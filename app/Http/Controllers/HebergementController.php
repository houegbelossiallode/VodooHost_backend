<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Equipement;
use App\Models\Logement;
use App\Models\LogementDisponibilite;
use App\Models\Projet;
use App\Models\TypeLogement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HebergementController extends Controller
{
    public function index(Request $request)
    {
        $equipements = Equipement::where('actif','OUI')->latest()->get();
        $typelogements = TypeLogement::where('actif','OUI')->latest()->get();
        // Base de la requête
        $query = Logement::where('actif','OUI')->with(['user','photos','equipements','typelogement'])->select('*');
        switch (request('sort')) {
            case 'price_asc':
                $query->orderBy('prix_par_nuit', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('prix_par_nuit', 'desc');
                break;
            default:
                $query->latest();
        }
        // 1) Mots-clés : titre / description / adresse / ville
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($qbuilder) use ($q) {
                $like = "%{$q}%";
                $qbuilder->where('titre', 'ILIKE', $like)
                    ->orWhere('description', 'ILIKE', $like)
                    ->orWhere('adresse', 'ILIKE', $like)
                    // Recherche dans le quartier
                    ->orWhereHas('quartier', function ($qb) use ($like) {
                        $qb->where('libelle', 'ILIKE', $like);
                    });
            });
        }
        // 3) Catégorie (BDD)
        if ($request->filled('type_logement_id')) {
            $query->where('type_logement_id', $request->type_logement_id);
        }
        // 4) Prix (slider) : "min;max"
        if ($request->filled('price')) {
            $raw = $request->price;

            if (str_contains($raw, ';')) {
                [$min, $max] = explode(';', $raw);

                $min = (int) $min;
                $max = (int) $max;

                if ($min > 0) {
                    $query->where('prix_par_nuit', '>=', $min);
                }
                if ($max > 0) {
                    $query->where('prix_par_nuit', '<=', $max);
                }
            }
        }

        // 5) Nombre de chambres minimum
        if ($request->filled('nb_chambre')) {
            $query->where('nb_chambre', '=', (int) $request->nb_chambre);
        }

        // 6) Nombre de voyageurs minimum
        if ($request->filled('nb_voyageurs')) {
            $query->where('nb_voyageur_max', '=', (int) $request->nb_voyageurs);
        }

        // 7) Filtre par plage de dates : disponibilités + réservations
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $dateDebut = Carbon::parse($request->date_debut)->startOfDay();
            $dateFin   = Carbon::parse($request->date_fin)->endOfDay();

            $query
                // a) Le logement doit être déclaré DISPONIBLE sur toute la plage
                ->whereHas('disponibilites', function ($q) use ($dateDebut, $dateFin) {
                    $q->where('statut', 'disponible')
                        ->whereDate('date_debut', '<=', $dateDebut)
                        ->whereDate('date_fin', '>=', $dateFin);
                })

                // b) Et il ne doit PAS avoir de réservation qui chevauche la plage
                ->whereDoesntHave('reservations', function ($q) use ($dateDebut, $dateFin) {
                    // Si tu as un champ statut sur les réservations, filtre ici :
                    // $q->whereIn('statut', ['confirmee', 'payee']);

                    $q->where(function ($qq) use ($dateDebut, $dateFin) {
                        // condition de chevauchement
                        $qq->where('date_debut', '<', $dateFin)
                            ->where('date_fin',   '>', $dateDebut);
                    });
                });
        }

        // 8) Langues parlées par l’hôte
        if ($request->filled('langues')) {
            $langues = array_filter((array) $request->langues);

            $query->whereHas('user', function ($q) use ($langues) {
                $q->where(function ($qq) use ($langues) {
                    foreach ($langues as $lang) {
                        $qq->orWhereJsonContains('langue', $lang); // colonne JSON dans users
                    }
                });
            });
        }
        // 9) Équipements (au moins un équipement choisi)
        if ($request->filled('equipements')) {
            $equipIds = (array) $request->equipements;
            //dd($equipIds);
            $query->whereHas('equipements', function ($q) use ($equipIds) {
                $q->whereIn('equipements.id', $equipIds);
            });
        }
        // Exécution + pagination
        $logements = $query->paginate(6)->withQueryString();
        $hotes = User::where('actif','OUI')->whereHas('logements')
            ->withCount('logements')
            ->get();
        $typelogements = TypeLogement::where('actif','OUI')->orderBy('libelle')->get();
        $equipements = Equipement::where('actif','OUI')->orderBy('libelle')->get();
        $logementsMapData = $logements->map(function ($l) {
            return [
                'id'      => $l->id,
                'titre'   => $l->titre,
                'adresse' => $l->adresse,
                'lat'     => $l->latitude,
                'lng'     => $l->longitude,
                'prix'    => $l->prix_par_nuit,
                'photo'   => optional($l->photos->first())->url,
                'url'     => route('hoost.hebergements.show', $l->id),
            ];
        })->values()->toArray();
        return view('pages.logements', compact('typelogements', 'logements', 'equipements', 'logementsMapData'));
    }

    public function show(Request $request, $id)
    {
        $logement = Logement::where('actif','OUI')->with('user', 'equipements', 'reglements', 'divinites', 'rituels', 'avis','typelogement')->find($id);


        $totalAvis = $logement->avis()->count();
        $avgNoteGlobal = $logement->avis()->avg('notes');

        // Recherche et tri
        $search = $request->query('q');
        $sort   = $request->query('sort', 'relevance'); // 'relevance', 'recent', 'best', 'worst'
        $showAll = $request->boolean('all');            // ?all=1 pour "Afficher tous les commentaires"

        // Base de la requête sur les avis de CE logement
        $avisQuery = $logement->avis()->with('user');

        // Recherche par mots-clés dans le commentaire
        if ($search) {
            $avisQuery->where('commentaire', 'LIKE', '%' . $search . '%');
        }

        // Tri
        switch ($sort) {
            case 'recent':
                $avisQuery->orderByDesc('created_at');
                break;
            case 'best':
                $avisQuery->orderByDesc('notes');
                break;
            case 'worst':
                $avisQuery->orderBy('notes');
                break;
            case 'relevance':
            default:
                // Pour l’instant, on considère pertinence = "meilleurs + récents"
                $avisQuery->orderByDesc('notes')->orderByDesc('created_at');
                break;
        }

        // Limite par défaut : 3 commentaires + bouton "Afficher tous les commentaires"
        if ($showAll) {
            $avis = $avisQuery->paginate(10)->withQueryString();
        } else {
            $avis = $avisQuery->take(3)->get();
        }

        // Logements similaires
        $similaires = Logement::where('actif','OUI')->with(['photos', 'typelogement'])
            ->where('type_logement_id', $logement->type_logement_id)
            ->where('nb_chambre', $logement->nb_chambre)
            ->where('nb_voyageur_max', $logement->nb_voyageur_max)
            ->where('id', '!=', $logement->id)
            ->get();
        $projets = Projet::where('actif','OUI')->latest()->get();

        $dispos = $logement->disponibilites()
            ->get(['date_debut', 'date_fin', 'statut']);

        //Plages DISPONIBLES
        $availableRanges = $dispos
            ->where('statut', 'disponible')
            ->map(function ($d) {
                return [
                    'from' => Carbon::parse($d->date_debut)->format('Y-m-d'),
                    'to'   => Carbon::parse($d->date_fin)->format('Y-m-d'),
                ];
            })
            ->values()
            ->toArray();

        //Plages BLOQUÉES (indisponible + reserver)
        $blockedRanges = $dispos
            ->whereIn('statut', ['indisponible', 'reserver'])
            ->map(function ($d) {
                return [
                    'from' => Carbon::parse($d->date_debut)->format('Y-m-d'),
                    'to'   => Carbon::parse($d->date_fin)->format('Y-m-d'),
                ];
            })
            ->values()
            ->toArray();


        return view('pages.detail-logement', compact(
            'logement',
            'similaires',
            'projets',
            'blockedRanges',
            'availableRanges',
            'avis',
            'totalAvis',
            'avgNoteGlobal',
            'search',
            'sort',
            'showAll',
        ));
    }


    public function detailHote($id)
    {
        $hote = User::with(['logements', 'logements.rituels'])->findOrFail($id);
        $logements = $hote->logements()
            ->with('photos')
            ->paginate(6)->withQueryString(); // 6 logements par page (tu peux changer)
        return view('pages.detail-hote', compact('hote','logements'));
    }
}
