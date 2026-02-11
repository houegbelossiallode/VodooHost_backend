<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Exception;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::where('actif','OUI')->orderBy('updated_at','desc')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        try{
           $request->validate([
            'libelle' => 'required',
        ],[
            'libelle.required' => 'Le champ libellé est requis.'
        ]);

        Categorie::create($request->all());
        return redirect()->route('hoost.categories.index')->with('success', 'Categorie créée avec succès.');
        }
        catch(Exception $e){
            return redirect()->route('hoost.categories.index')->with(['error' => 'Une erreur est survenue lors de la création de la catégorie.' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $categorie = Categorie::findOrFail($id);
        return view('categories.edit', compact('categorie'));
    }

    public function update(Request $request, $id)
    {
        try{
           $request->validate([
            'libelle' => 'required',
        ],[
            'libelle.required' => 'Le champ libellé est requis.'
        ]);
        $categorie = Categorie::findOrFail($id);
        $categorie->update($request->all());
        return redirect()->route('hoost.categories.index')->with('success', 'Categorie mise à jour avec succès.');
        }
        catch(Exception $e){
            return redirect()->route('hoost.categories.index')->with(['error' => 'Une erreur est survenue lors de la mise à jour de la catégorie.' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $categorie = Categorie::findOrFail($id);
        if($categorie->actif === 'OUI'){
            $categorie->actif = 'NON';
        } else {
            $categorie->actif = 'OUI';
        }
        $categorie->save();
        return redirect()->route('hoost.categories.index')->with('success', 'Categorie supprimée avec succès.');
    }

}
