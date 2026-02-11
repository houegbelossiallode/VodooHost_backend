<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use Exception;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    public function index()
    {
        $equipements = Equipement::where('actif','OUI')->latest()->get();
        return view('equipements.index', compact('equipements'));
    }

    public function create()
    {
        return view('equipements.create');
    }

    public function store(Request $request)
    {
        try{
        // Validation et stockage de l'équipement
        $request->validate([
            'libelle' => 'required|string|max:255',
        ],[
            "libelle.required"=> "Le libelle est requis"
        ]);
        // Logique de création de l'équipement
        Equipement::create([
            'libelle' => $request->input('libelle'),
        ]);
        return redirect()->route('hoost.equipements.index')->with('success', 'Équipement créé avec succès');
        }catch(Exception $e){
          return redirect()->back()->with('error','Une erreur est survenue' . $e->getMessage());
        }
        
    }

    public function edit($id)
    {
        $equipement = Equipement::findOrFail($id);
        return view('equipements.edit', compact('equipement'));
    }

    public function update(Request $request, $id)
    {
        try{
          $request->validate([
            'libelle' => 'required|string|max:255',
        ],[
            "libelle.required"=> "Le libelle est requis"
        ]);
        $equipement = Equipement::findOrFail($id);
        $equipement->libelle = $request->input('libelle');
        $equipement->save();
        return redirect()->route('hoost.equipements.index')->with('success', 'Équipement mis à jour avec succès');
        }catch(Exception $e){
          return redirect()->back()->with('error','Une erreur est survenue' . $e->getMessage());
        }
        
    }

    public function destroy($id)
    {
        $equipement = Equipement::findOrFail($id);
        if($equipement->actif === 'OUI'){
            $equipement->actif = 'NON';
        } else {
            $equipement->actif = 'OUI';
        }
        $equipement->save();
        return redirect()->route('hoost.equipements.index')->with('success', 'Équipement supprimé avec succès');
    }
}
