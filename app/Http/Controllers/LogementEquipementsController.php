<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use App\Models\Logement;
use Illuminate\Http\Request;

class LogementEquipementsController extends Controller
{
    public function edit(Logement $logement)
    {
        // Liste des équipements (adapte le champ d’affichage si besoin: libelle, nom…)
        $equipements = Equipement::where('actif','OUI')->orderBy('libelle')->get(['id','libelle']);
        // Équipements déjà affectés pour pré-cocher
        $selected = $logement->equipements()->pluck('equipements.id')->toArray();

        return view('logements.equipements_edit', compact('logement', 'equipements', 'selected'));
    }

    public function update(Request $request, Logement $logement)
    {
        $data = $request->validate([
            'equipements'   => ['nullable','array'],
            'equipements.*' => ['integer','exists:equipements,id'],
        ]);

        // Remplace l’ensemble des liens par la sélection actuelle
        $logement->equipements()->sync($data['equipements'] ?? []);

        return redirect()->route('hoost.logements.index')->with('success', 'Équipements affectés avec succès.');
    }
}
