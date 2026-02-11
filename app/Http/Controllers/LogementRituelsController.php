<?php

namespace App\Http\Controllers;

use App\Models\Logement;
use App\Models\Rituel;
use Illuminate\Http\Request;

class LogementRituelsController extends Controller
{
    public function edit(Logement $logement)
    {
        $rituels = Rituel::where('actif','OUI')->orderBy('titre')->get(['id','titre','symbole','description']);
        $selected  = $logement->rituels()->pluck('rituels.id')->toArray();

        return view('logements.rituels_edit', compact('logement','rituels','selected'));
    }

    public function update(Request $request, Logement $logement)
    {
        $data = $request->validate([
            'rituels'   => ['nullable','array'],
            'rituels.*' => ['integer','exists:rituels,id'],
        ]);

        $logement->rituels()->sync($data['rituels'] ?? []); // remplace l’ensemble
        return redirect()->route('hoost.logements.index')->with('success', 'Rituels affectés avec succès.');
    }
}
