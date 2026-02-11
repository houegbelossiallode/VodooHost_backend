<?php

namespace App\Http\Controllers;

use App\Models\Dejeuner;
use Exception;
use Illuminate\Http\Request;

class DejeunerController extends Controller
{
    public function index()
    {
        $dejeuners = Dejeuner::where('actif','OUI')->orderBy('updated_at','desc')->get();
        return view('dejeuners.index', compact('dejeuners'));
    }

    public function create()
    {
        return view('dejeuners.create');
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
        Dejeuner::create([
            'libelle' => $request->input('libelle'),
        ]);
        return redirect()->route('hoost.dejeuners.index')->with('success', 'Déjeuner créé avec succès');
        }catch(Exception $e){
            return redirect()->back()->with('error','Une erreur est survenue' . $e->getMessage());
        }
        
    }

    public function edit($id)
    {
        $dejeuners = Dejeuner::findOrFail($id);
        return view('dejeuners.edit', compact('dejeuners'));
    }

    public function update(Request $request, $id)
    {
        try{
          $request->validate([
            'libelle' => 'required|string|max:255',
        ],[
            "libelle.required"=> "Le libelle est requis"
        ]);
        $dejeuner = Dejeuner::findOrFail($id);
        $dejeuner->libelle = $request->input('libelle');
        $dejeuner->save();
        return redirect()->route('hoost.dejeuners.index')->with('success', 'Déjeuner mis à jour avec succès');
        }catch(Exception $e){
          return redirect()->back()->with('error','Une erreur est survenue' . $e->getMessage());
        }
        
    }

    public function destroy($id)
    {
        $dejeuner = Dejeuner::findOrFail($id);
        if($dejeuner->actif === 'OUI'){
            $dejeuner->actif = 'NON';
        } else {
            $dejeuner->actif = 'OUI';
        }
        $dejeuner->save();
        return redirect()->route('hoost.dejeuners.index')->with('success', 'Déjeuner supprimé avec succès');
    }
}
