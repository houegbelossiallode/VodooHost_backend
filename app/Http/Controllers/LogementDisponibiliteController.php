<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Logement;
use Illuminate\Http\Request;
use App\Models\LogementDisponibilite;

class LogementDisponibiliteController extends Controller
{
    // public function index(Logement $logement)
    // {
    //     $disponibilites = $logement->disponibilites()
    //         ->orderBy('date_debut')
    //         ->get()
    //         ->groupBy(function($item) {
    //             return Carbon::parse($item->date_debut)->format('Y-m');
    //         });

    //     return view('logements.disponibilites.index', compact('logement', 'disponibilites'));
    // }

    // public function store(Request $request, Logement $logement)
    // {
    //     $validated = $request->validate([
    //         'date_debut' => 'required|date',
    //         'date_fin' => 'required|date|after_or_equal:date_debut',
    //         'statut' => 'required|in:disponible,indisponible,reserve',
    //         'prix_nuit' => 'nullable|numeric|min:0',
    //         'min_nuits' => 'nullable|integer|min:1',
    //         'notes' => 'nullable|string|max:500'
    //     ]);

    //     // Vérifier les conflits
    //     $conflits = $logement->disponibilites()
    //         ->where(function($query) use ($validated) {
    //             $query->whereBetween('date_debut', [$validated['date_debut'], $validated['date_fin']])
    //                   ->orWhereBetween('date_fin', [$validated['date_debut'], $validated['date_fin']])
    //                   ->orWhere(function($q) use ($validated) {
    //                       $q->where('date_debut', '<=', $validated['date_debut'])
    //                         ->where('date_fin', '>=', $validated['date_fin']);
    //                   });
    //         })
    //         ->get();

    //     if ($conflits->isNotEmpty()) {
    //         return back()->with('error', 'Des périodes de disponibilité existent déjà pour ces dates.');
    //     }

    //     $logement->disponibilites()->create($validated);

    //     return redirect()
    //         ->route('hoost.logements.disponibilites.index', $logement)
    //         ->with('success', 'Période de disponibilité ajoutée avec succès.');
    // }

    // /**
    //  * Affiche le formulaire de modification d'une disponibilité
    //  */
    // public function edit(Logement $logement, LogementDisponibilite $disponibilite)
    // {
    //     $this->authorize('update', $disponibilite);

    //     return view('logements.disponibilites.edit', compact('logement', 'disponibilite'));
    // }

    // /**
    //  * Met à jour une disponibilité existante
    //  */
    // public function update(Request $request, Logement $logement, LogementDisponibilite $disponibilite)
    // {
    //     $this->authorize('update', $disponibilite);

    //     $validated = $request->validate([
    //         'date_debut' => 'required|date',
    //         'date_fin' => 'required|date|after_or_equal:date_debut',
    //         'statut' => 'required|in:disponible,indisponible,reserve',
    //         'prix_nuit' => 'nullable|numeric|min:0',
    //         'min_nuits' => 'nullable|integer|min:1',
    //         'notes' => 'nullable|string|max:500'
    //     ]);

    //     // Vérifier les conflits avec d'autres périodes (sauf la période actuelle)
    //     $conflits = $logement->disponibilites()
    //         ->where('id', '!=', $disponibilite->id)
    //         ->where(function($query) use ($validated) {
    //             $query->whereBetween('date_debut', [$validated['date_debut'], $validated['date_fin']])
    //                   ->orWhereBetween('date_fin', [$validated['date_debut'], $validated['date_fin']])
    //                   ->orWhere(function($q) use ($validated) {
    //                       $q->where('date_debut', '<=', $validated['date_debut'])
    //                         ->where('date_fin', '>=', $validated['date_fin']);
    //                   });
    //         })
    //         ->exists();

    //     if ($conflits) {
    //         return back()->with('error', 'Des périodes de disponibilité existent déjà pour ces dates.');
    //     }

    //     $disponibilite->update($validated);

    //     return redirect()
    //         ->route('hoost.logements.disponibilites.index', $logement)
    //         ->with('success', 'Période de disponibilité mise à jour avec succès.');
    // }

    // /**
    //  * Supprime une disponibilité
    //  */
    // public function destroy(Logement $logement, LogementDisponibilite $disponibilite)
    // {
    //     $this->authorize('delete', $disponibilite);

    //     $disponibilite->delete();

    //     return redirect()
    //         ->route('hoost.logements.disponibilites.index', $logement)
    //         ->with('success', 'Période de disponibilité supprimée avec succès.');
    // }


    // Liste des disponibilités pour un logement (vue calendrier hôte)
    public function index(Logement $logement)
    {
       // On ne prend que les disponibilités (y compris statut = reserver)
        $dispos = $logement->disponibilites;  // relation logement_disponibilites

        $events = [];

        foreach ($dispos as $d) {
            // couleur + libellé selon le statut
            switch ($d->statut) {
                case 'disponible':
                    $color = '#D1B11B';        // vert
                    $title = 'Disponible';
                    break;

                case 'indisponible':
                    $color = '#E892E0';        // rouge
                    $title = 'Indisponible';
                    break;

                case 'reserver':              // ce qu’on met dans le callback Fedapay
                    $color = '#F0BC75';        // bleu
                    $title = 'Réservé';
                    break;

                default:
                    $color = '#6c757d';
                    $title = ucfirst($d->statut);
                    break;
            }

            $events[] = [
                'id'     => 'dispo-'.$d->id,
                'title'  => $title,
                'start'  => $d->date_debut,
                // FullCalendar : end = EXCLUSIF => +1 jour
                'end'    => Carbon::parse($d->date_fin)->addDay()->toDateString(),
                'allDay' => true,
                'color'  => $color,
                'statut' => $d->statut,
            ];
        }
        return view('logements.disponibilites.index', compact('logement', 'events'));
    }

    // Affiche un formulaire avec un calendrier pour ajouter une plage de dispo
    public function create(Logement $logement)
    {
        return view('logements.disponibilites.create', compact('logement'));
    }

    public function store(Request $request, Logement $logement)
    {
        $request->validate([
            'date_debut' => ['required', 'date', 'after_or_equal:today'],
            'date_fin'   => ['required', 'date', 'after_or_equal:date_debut'],
            'statut'       => ['required', 'in:disponible,indisponible'],
        ], [
            // DATE DEBUT
            'date_debut.required'        => 'La date de début est obligatoire.',
            'date_debut.date'            => 'La date de début doit être une date valide.',
            'date_debut.after_or_equal'  => 'La date de début doit être aujourd\'hui ou une date ultérieure.',
            // DATE FIN
            'date_fin.required'          => 'La date de fin est obligatoire.',
            'date_fin.date'              => 'La date de fin doit être une date valide.',
            'date_fin.after_or_equal'    => 'La date de fin doit être postérieure ou égale à la date de début.',
            // STATUT
            'statut.in'                  => 'Le statut doit être "disponible" ou "indisponible".',
        ]);

        $statut = $request->statut;
        $dateDebut = $request->date_debut;
        $dateFin   = $request->date_fin;

        //1) Vérifier s'il existe déjà une dispo qui se chevauche
        $overlap = $logement->disponibilites()
            ->where(function ($q) use ($dateDebut, $dateFin) {
                $q->whereBetween('date_debut', [$dateDebut, $dateFin])
                    ->orWhereBetween('date_fin', [$dateDebut, $dateFin])
                    ->orWhere(function ($q2) use ($dateDebut, $dateFin) {
                        $q2->where('date_debut', '<=', $dateDebut)
                            ->where('date_fin', '>=', $dateFin);
                    });
            })
            ->exists();
        //2)Vérifier si une réservation chevauche ses dates 
        $reserve = $logement->reservations()
            ->where(function ($q) use ($dateDebut, $dateFin) {
                $q->whereBetween('date_debut', [$dateDebut, $dateFin])
                    ->orWhereBetween('date_fin', [$dateDebut, $dateFin])
                    ->orWhere(function ($q2) use ($dateDebut, $dateFin) {
                        $q2->where('date_debut', '<=', $dateDebut)
                            ->where('date_fin', '>=', $dateFin);
                    });
            })
            ->exists();
        if ($reserve) {
            // Si c'est un appel AJAX (FullCalendar)
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Il existe déjà une réservation qui chevauche ces dates.',
                ], 422);
            }
            // Sinon, flux classique avec message d'erreur
            return back()
                ->withErrors(['date_debut' => 'Une réservation existe déjà sur cette période.'])
                ->withInput();
        }

        if ($overlap) {
            // Si c'est un appel AJAX (FullCalendar)
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Il existe déjà une période de ' . $statut . ' qui chevauche ces dates.',
                ], 422);
            }
            // Sinon, flux classique avec message d'erreur
            return back()
                ->withErrors(['date_debut' => 'Une disponibilité existe déjà sur cette période.'])
                ->withInput();
        }

        $dispo = $logement->disponibilites()->create([
            'date_debut' => $request->date_debut,
            'date_fin'   => $request->date_fin,
            'statut'       => $statut,
        ]);

        // Si c'est un appel AJAX (FullCalendar)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'event'   => [
                    'id'    => 'dispo-' . $dispo->id,
                    'title' => $statut === 'disponible' ? 'Disponible' : 'Indisponible',
                    'start' => $dispo->date_debut,
                    'end'   => \Carbon\Carbon::parse($dispo->date_fin)->addDay()->toDateString(),
                    'allDay' => true,
                    'color' => $statut === 'disponible' ? '#D1B11B' : '#E892E0',
                ],
            ]);
        }

        // Fallback : comportement classique
        return redirect()
            ->route('hoost.logements.disponibilites.index', $logement)
            ->with('success', 'Période de disponibilité ajoutée.');
    }

    // Enregistre une plage de disponibilité
    // public function store(Request $request, Logement $logement)
    // {
    //     $request->validate([
    //         'date_debut' => ['required', 'date', 'after_or_equal:today'],
    //         'date_fin'   => ['required', 'date', 'after_or_equal:date_debut'],
    //     ]);

    //     LogementDisponibilite::create([
    //         'logement_id' => $logement->id,
    //         'date_debut'  => $request->date_debut,
    //         'date_fin'    => $request->date_fin,
    //         'statut'        => 'disponible',
    //     ]);

    //     return redirect()
    //         ->route('hoost.logements.disponibilites.index', $logement)
    //         ->with('success', 'Période de disponibilité ajoutée avec succès.');
    // }

    // Supprimer une plage de dispo
    public function destroy(Request $request, Logement $logement, LogementDisponibilite $disponibilite)
    {
        // Sécurité : on vérifie que la dispo appartient bien à ce logement
        if ($disponibilite->logement_id !== $logement->id) {
            abort(404);
        }

        $disponibilite->delete();

        // Si c'est un appel AJAX (FullCalendar)
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Période supprimée avec succès.',
            ]);
        }

        // Fallback : navigation classique
        return back()->with('success', 'Période supprimée avec succès.');
    }
}
