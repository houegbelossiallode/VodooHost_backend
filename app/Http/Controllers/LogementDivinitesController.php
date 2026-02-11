<?php

namespace App\Http\Controllers;

use App\Models\Divinite;
use App\Models\Logement;
use Illuminate\Http\Request;

class LogementDivinitesController extends Controller
{
    public function edit(Logement $logement)
    {
        $divinites = Divinite::where('actif','OUI')->orderBy('nom')->get(['id','nom','description','image']);
        $selected  = $logement->divinites()->pluck('divinites.id')->toArray();

        return view('logements.divinites_edit', compact('logement','divinites','selected'));
    }

    public function update(Request $request, Logement $logement)
    {
        $data = $request->validate([
            'divinites'   => ['nullable','array'],
            'divinites.*' => ['integer','exists:divinites,id'],
        ]);

        $logement->divinites()->sync($data['divinites'] ?? []); // remplace l’ensemble
        return redirect()->route('hoost.logements.index')->with('success', 'Divinités affectées avec succès.');
    }
}
