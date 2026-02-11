<?php

namespace App\Http\Controllers;

use App\Models\Logement;
use App\Models\Pays;
use App\Models\Photo;
use App\Models\Projet;
use App\Models\Quartier;
use App\Models\TypeLogement;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LogementController extends Controller
{

    private function supabaseBase(): string
    {
        return rtrim(env('SUPABASE_URL'), '/') . '/storage/v1';
    }

    private function supaHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . env('SUPABASE_SERVICE_ROLE_KEY'),
            'apikey'        => env('SUPABASE_SERVICE_ROLE_KEY'),
        ];
    }

    private function uploadPhotoToSupabase(\Illuminate\Http\UploadedFile $file, int $logementId): string
    {
        $bucket = env('SUPABASE_BUCKET_LOGEMENTS', 'logements');
        $ext    = strtolower($file->getClientOriginalExtension() ?: 'jpg');
        $name   = Str::uuid() . '.' . $ext;
        $path   = "logements/{$logementId}/" . date('Y/m/') . $name;

        $resp = Http::withHeaders($this->supaHeaders())
            ->attach('file', file_get_contents($file->getRealPath()), $name)
            ->post($this->supabaseBase() . "/object/$bucket/$path");

        if (!$resp->successful()) {
            throw new \RuntimeException('Upload Supabase échoué: ' . $resp->body());
        }

        // Bucket public
        return rtrim(env('SUPABASE_URL'), '/') . "/storage/v1/object/public/$bucket/$path";
    }

    public function index()
    {
        $user = Auth::user();
        //dd($user->id);
        $logements = Logement::where('actif','OUI')->where('user_id',$user->id)->orderBy('updated_at', 'desc')->get();
        //dd($logements);
        $quartiers = Quartier::where('actif','OUI')->latest()->get();
        $typelogements = TypeLogement::where('actif','OUI')->latest()->get();

        return view('logements.index', compact('logements', 'quartiers', 'typelogements'));
    }

    public function liste(Request $request)
    {
        $query = Logement::where('actif','OUI')->with(['photos'])
            ->withAvg('avis as note_moyenne', 'notes')  // moyenne des notes
            ->withCount('avis');  // ajoute la moyenne des notes
        //Recherche plein texte sur titre / description / adresse
        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($qbuilder) use ($q) {
                $like = '%' . $q . '%';
                // Si tu es sur PostgreSQL
                $qbuilder->where('titre', 'ILIKE', $like)
                    ->orWhere('description', 'ILIKE', $like)
                    ->orWhere('adresse', 'ILIKE', $like);
                // Si jamais tu passes sur MySQL un jour, remplace ILIKE par LIKE
            });
        }
        // Gestion du tri
        switch ($request->get('sort')) {
            case 'oldest':
                $query->orderBy('updated_at', 'asc');
                break;

            case 'rating':
                // Uniquement les logements qui ont au moins 1 avis
                $query->whereHas('avis')
                    ->orderByDesc('note_moyenne');
                break;

            case 'name_asc':
                $query->orderBy('titre', 'asc');
                break;

            case 'name_desc':
                $query->orderBy('titre', 'desc');
                break;

            case 'price_asc':
                $query->orderBy('prix_par_nuit', 'asc');
                break;

            case 'price_desc':
                $query->orderBy('prix_par_nuit', 'desc');
                break;

            case 'latest':
            default:
                $query->orderBy('updated_at', 'desc');
                break;
        }

        $logements = $query->paginate(6)->withQueryString();
        $typelogements = TypeLogement::where('actif','OUI')->latest()->get();
        $projets = Projet::where('actif','OUI')->latest()->get();
        return view('logements.visiteurs.index', compact('logements', 'typelogements', 'projets'));
    }

    public function create()
    {
        $quartiers = Quartier::where('actif','OUI')->latest()->get();
        $typelogements = TypeLogement::where('actif','OUI')->latest()->get();
        return view('logements.create', compact('quartiers', 'typelogements'));
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'titre' => 'required|string|max:255',
                'description' => 'required|string',
                'adresse' => 'required|string|max:255',
                'quartier_id' => 'required|exists:quartiers,id',
                'prix_par_nuit' => 'required|numeric',
                'nb_chambre' => 'required|numeric',
                'nb_voyageur_max' => 'required|numeric',
                'type_logement_id' => 'required|exists:type_logements,id',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'photos'   => ['required', 'array', 'max:20'],
                'photos.*' => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'], // 5 Mo
            ], [
                'titre.required' => 'Le titre est obligatoire.',
                'description.required' => 'La description est obligatoire.',
                'adresse.required' => 'L\'adresse est obligatoire.',
                'quartier_id.required' => 'Le quartier est obligatoire.',
                'quartier_id.exists' => 'Le quartier sélectionné est invalide.',
                'prix_par_nuit.required' => 'Le prix par nuit est obligatoire.',
                'prix_par_nuit.numeric' => 'Le prix par nuit doit être un nombre valide.',
                'nb_chambre.required' => 'Le nombre de chambres est obligatoire.',
                'nb_chambre.numeric' => 'Le nombre de chambres doit être un entier.',
                'nb_voyageur_max.required' => 'Le nombre maximum de voyageurs est obligatoire.',
                'nb_voyageur_max.numeric' => 'Le nombre maximum de voyageurs doit être un entier.',
                'type_logement_id.required' => 'Le type de logement est obligatoire.',
                'type_logement_id.exists' => 'Le type de logement sélectionné est invalide.',
                'photos.required' => 'Veuillez télécharger au moins une photo du logement.',
                'photos.array'    => 'Le format des photos est invalide.',
                'latitude.required' => 'La latitude est obligatoire.',
                'latitude.numeric' => 'La latitude doit être un nombre valide.',
                'longitude.required' => 'La longitude est obligatoire.',
                'longitude.numeric' => 'La longitude doit être un nombre valide.',
                'photos.max'      => 'Vous ne pouvez pas télécharger plus de 20 photos.',
                'photos.*.image'  => 'Chaque fichier doit être une image valide.',
                'photos.*.mimes'  => 'Les formats d\'image autorisés sont jpg, jpeg et png.',
                'photos.*.max'    => 'Chaque photo ne doit pas dépasser 5 Mo.',

            ]);
            $user = Auth::user();
            $logement = Logement::create([
                'titre' => $request->input('titre'),
                'description' => $request->input('description'),
                'adresse' => $request->input('adresse'),
                'quartier_id' => $request->input('quartier_id'),
                'prix_par_nuit' => $request->input('prix_par_nuit'),
                'nb_chambre' => $request->input('nb_chambre'),
                'nb_voyageur_max' => $request->input('nb_voyageur_max'),
                'type_logement_id' => $request->input('type_logement_id'),
                'user_id' => $user->id,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
            ]);

            // 2) Enregistrer les photos (si présentes)
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $url = $this->uploadPhotoToSupabase($file, $logement->id);
                    Photo::create([
                        'logement_id' => $logement->id,
                        'url'         => $url,
                    ]);
                }
            }

            return redirect()->route('hoost.logements.index')->with('success', 'Logement créé avec succès');
        } catch (Exception $e) {
            return redirect()->route('hoost.logements.index')->with('error', 'Une erreur inattendue s\'est produite : ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $logement = Logement::findOrFail($id);
        $quartiers = Quartier::where('actif','OUI')->latest()->get();
        $typelogements = TypeLogement::where('actif','OUI')->latest()->get();
        return view('logements.edit', compact('logement', 'quartiers', 'typelogements'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'titre' => 'required|string|max:255',
                'description' => 'required|string',
                'adresse' => 'required|string|max:255',
                'quartier_id' => 'required|exists:quartiers,id',
                'prix_par_nuit' => 'required|numeric',
                'nb_chambre' => 'required|integer',
                'nb_voyageur_max' => 'required|integer',
                'type_logement_id' => 'required|exists:type_logements,id',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
            ]);

            $logement = Logement::findOrFail($id);
            $logement->titre = $request->input('titre');
            $logement->description = $request->input('description');
            $logement->adresse = $request->input('adresse');
            $logement->quartier_id = $request->input('quartier_id');
            $logement->prix_par_nuit = $request->input('prix_par_nuit');
            $logement->nb_chambre = $request->input('nb_chambre');
            $logement->nb_voyageur_max = $request->input('nb_voyageur_max');
            $logement->type_logement_id = $request->input('type_logement_id');
            $logement->latitude = $request->input('latitude');
            $logement->longitude = $request->input('longitude');
            $logement->save();

            // Ajout de nouvelles photos déposées pendant l’édition
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    $url = $this->uploadPhotoToSupabase($file, $logement->id); // même helper que pour store()
                    \App\Models\Photo::create([
                        'logement_id' => $logement->id,
                        'url'         => $url,
                    ]);
                }
            }
            return redirect()->route('hoost.logements.index')->with('success', 'Logement mis à jour avec succès');
        } catch (Exception $e) {
            return redirect()->route('hoost.logements.index')->with('error', 'Une erreur inattendue s\'est produite : ' . $e->getMessage());
        }
    }

    public function show(Logement $logement)
    {
        $logement->load([
            'photos:id,logement_id,url',
            'rituels:id,titre,description,symbole,duree,precautions',
            'pays:id,libelle',
            'typelogement:id,libelle',
            'equipements:id,libelle',
            'divinites:id,nom',
        ]);
        // Périodes "indisponible" ou "réserver" pour ce logement
        // $dispos = $logement->disponibilites()
        //     ->whereIn('statut', ['indisponible', 'reserver'])
        //     ->get(['date_debut', 'date_fin']);

        // // On les transforme pour Flatpickr : [{from: 'YYYY-MM-DD', to: 'YYYY-MM-DD'}, ...]
        // $blockedRanges = $dispos->map(function ($d) {
        //     return [
        //         'from' => Carbon::parse($d->date_debut)->format('Y-m-d'),
        //         'to'   => Carbon::parse($d->date_fin)->format('Y-m-d'),
        //     ];
        // })->values()->toArray();

        // On récupère TOUTES les lignes de disponibilités pour ce logement
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
        $projets = Projet::latest()->get();
        return view('logements.show', compact('logement', 'projets', 'blockedRanges', 'availableRanges'));
    }

    public function destroy($id)
    {
        $logement = Logement::find($id);
        if($logement->actif === 'OUI'){
            $logement->actif = 'NON';
            $logement->save();
        } else {
            $logement->actif = 'OUI';
            $logement->save();
        }

        return redirect()->route('hoost.logements.index')->with('success', 'Logement supprimé avec succès');
    }
}
