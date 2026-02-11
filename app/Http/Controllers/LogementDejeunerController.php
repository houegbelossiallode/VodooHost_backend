<?php

namespace App\Http\Controllers;

use App\Models\Dejeuner;
use App\Models\Logement;
use Exception;
use Illuminate\Http\Request;

class LogementDejeunerController extends Controller
{
    public function edit(Logement $logement)
    {
        // Liste des équipements (adapte le champ d’affichage si besoin: libelle, nom…)
        $dejeuners = Dejeuner::where('actif','OUI')->orderBy('libelle')->get(['id','libelle']);
        // Équipements déjà affectés pour pré-cocher
        $selected = $logement->dejeuners()->pluck('dejeuners.id')->toArray();

        return view('logements.dejeuners_edit', compact('logement', 'dejeuners', 'selected'));
    }

    public function update(Request $request, Logement $logement)
    {

        //Je veux recupérer la route qui est appelé

        try{
          $data = $request->validate([
            'dejeuners'   => ['nullable','array'],
            'dejeuners.*' => ['integer','exists:dejeuners,id'],
        ]);

        //dd($request);

        // Remplace l’ensemble des liens par la sélection actuelle
        $logement->dejeuners()->sync($data['dejeuners'] ?? []);

        return redirect()->route('hoost.logements.index')->with('success', 'Petits déjeuners affectés avec succès.');
        }catch(Exception $e){
            return redirect()->route('hoost.logements.index')->with('error', 'Une erreur est survenue' .$e);
        }
        
    }
}
