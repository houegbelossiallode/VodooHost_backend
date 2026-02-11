<?php

namespace App\Http\Controllers;

use App\Models\Pointfort;
use App\Models\Quartier;
use Illuminate\Http\Request;

class QuartierPointsController extends Controller
{
    public function edit(Quartier $quartier)
    {
        // Liste des équipements (adapte le champ d’affichage si besoin: libelle, nom…)
        $points = Pointfort::orderBy('titre')->get(['id','titre']);
        // Équipements déjà affectés pour pré-cocher
        $selected = $quartier->pointforts()->pluck('pointforts.id')->toArray();

        return view('quartiers.pointforts_edit', compact('quartier', 'points', 'selected'));
    }

    public function update(Request $request, Quartier $quartier)
    {
        $data = $request->validate([
            'points'   => ['nullable','array'],
            'points.*' => ['integer','exists:pointforts,id'],
        ]);

        // Remplace l’ensemble des liens par la sélection actuelle
        $quartier->pointforts()->sync($data['points'] ?? []);

        return redirect()->route('hoost.quartiers.index')->with('success', 'Points forts affectés avec succès.');
    }
}
