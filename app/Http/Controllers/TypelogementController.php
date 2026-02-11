<?php

namespace App\Http\Controllers;

use App\Models\TypeLogement;
use Illuminate\Http\Request;

class TypelogementController extends Controller
{
    public function index()
    {
        $typelogements = TypeLogement::latest()->get();
        return view('typelogements.index', compact('typelogements'));
    }

    public function create()
    {
        return view('typelogements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        TypeLogement::create([
            'libelle' => $request->input('libelle'),
        ]);
        return redirect()->route('hoost.typelogements.index')->with('success', 'Type de logement créé avec succès');
    }

    public function show($id)
    {
        return view('typelogement.show', compact('id'));
    }


    public function edit($id)
    {
        $typelogement = TypeLogement::findOrFail($id);
        return view('typelogements.edit', compact('typelogement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
        ]);

        $typelogement = TypeLogement::findOrFail($id);
        $typelogement->libelle = $request->input('libelle');
        $typelogement->save();
        return redirect()->route('hoost.typelogements.index')->with('success', 'Type de logement mis à jour avec succès');
    }

    public function destroy($id)
    {
        TypeLogement::find($id)->delete();
        return redirect()->route('hoost.typelogements.index')->with('success', 'Type de logement supprimé avec succès');
    }
}
