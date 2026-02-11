<?php

namespace App\Http\Controllers;

use App\Models\Logement;
use App\Models\ReglementLogement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reglement;

class LogementReglementController extends Controller
{
    public function index(Logement $logement)
    {
        $reglements = $logement->reglements;
        return view('logements.reglements.index', compact('logement', 'reglements'));
    }

    public function create(Logement $logement)
    {
        return view('logements.reglements.create', compact('logement'));
    }

    public function store(Request $request, Logement $logement)
    {
        $validated = $request->validate([
            'reglements'   => ['required', 'array', 'min:1'],
            'reglements.*' => ['required'],
        ]);
        foreach ($validated['reglements'] as $libelle) {
            $logement->reglements()->create([
                'libelle' => $libelle,
            ]);
        }
        return redirect()->route('hoost.logements.reglements.index',$logement->id)->with('success', 'Les règlements ont été enregistrés avec succès.');
    }

    public function edit(Logement $logement, Reglement $reglement)
    {
        // On vérifie que le règlement appartient bien au logement
        // if ($reglement->logement_id !== $logement->id) {
        //     abort(404);
        // }

        return view('logements.reglements.edit', compact('logement', 'reglement'));
    }

    public function update(Request $request, Logement $logement, Reglement $reglement)
    {
        // On vérifie que le règlement appartient bien au logement
        // if ($reglement->logement_id !== $logement->id) {
        //     abort(404);
        // }

        $validated = $request->validate([
            'libelle' => 'required',
        ]);

        $reglement->update($validated);

        return redirect()
            ->route('hoost.logements.reglements.index', $logement)
            ->with('success', 'Règlement mis à jour avec succès.');
    }


    public function destroy(Logement $logement, Reglement $reglement)
    {
        if($reglement->actif === 'OUI'){
            $reglement->actif = 'NON';
            $reglement->save();
        } else {
            $reglement->actif = 'OUI';
            $reglement->save();
        }
        return redirect()->back()->with('success', 'Règle supprimé avec succès');
    }
}
