<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Projet;
use Exception;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    public function index()
    {
        $projets = Projet::where('actif','OUI')->orderBy('updated_at','desc')->paginate(6)->withQueryString();
        return view('projets.index', compact('projets'));
    }

    public function create()
    {
        $categories = Categorie::where('actif','OUI')->orderBy('updated_at','desc')->get();
        return view('projets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try{
          $request->validate([
            'titre' => 'required',
            'description' => 'required',
            'date_debut' => 'required|date|after_or_equal:today',
            'pourcentage_contribution' => 'required|numeric',
            'categorie_id' => 'required|exists:categories,id',
            'objectif'=> 'required'
        ]);
        //dd($request->all());
        Projet::create($request->all());
        return redirect()->route('hoost.projets.index')->with('success', 'Projet créé avec succès.');
        }catch(Exception $e){
          return redirect()->route('hoost.projets.index')->with('error', 'Une erreur est survenue' . $e->getMessage());
        }
        
    }

    public function edit(Projet $projet)
    {
        $categories = Categorie::where('actif','OUI')->orderBy('updated_at','desc')->get();
        return view('projets.edit', compact('projet', 'categories'));
    }

    public function update(Request $request, Projet $projet)
    {
        try{
          $request->validate([
            'titre' => 'required',
            'description' => 'required',
            'date_debut' => 'required|date|after_or_equal:today',
            'pourcentage_contribution' => 'required|numeric',
            'categorie_id' => 'required|exists:categories,id',
            'objectif'=> 'required'
           ]);
        $projet->update($request->all());
        return redirect()->route('hoost.projets.index')->with('success', 'Projet modifié avec succès.');
        }catch(Exception $e){
          return redirect()->route('hoost.projets.index')->with('error', 'Une erreur est survenue' . $e->getMessage());
        }
        
    }   

    public function destroy(Projet $projet)
    {
        if($projet->actif === 'OUI'){
            $projet->actif = 'NON';
            $projet->save();
        } else {
            $projet->actif = 'OUI';
            $projet->save();
        }
        return redirect()->route('hoost.projets.index')->with('success', 'Projet supprimé avec succès.');
    }


}
