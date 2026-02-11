<?php

namespace App\Http\Controllers;

use App\Models\Quartier;
use Exception;
use Illuminate\Http\Request;

class QuartierController extends Controller
{

    public function index(){
        $quartiers = Quartier::orderBy('updated_at','desc')->paginate(6)->withQueryString();
        return view('quartiers.index',compact('quartiers'));
    }

    public function create()
    {
        return view('quartiers.create');
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
            'libelle'   => 'required|unique:quartiers,libelle',
            'longitude' => 'required|numeric',
            'latitude'  => 'required|numeric',
           ]);

        Quartier::create([
            'libelle'=> $request->libelle,
            'longitude'=> $request->longitude,
            'latitude'=> $request->latitude
        ]);

        return redirect()->route('hoost.quartiers.index')->with('success', 'Le quartier a été enregistré avec succès.');
        }catch(Exception $e){
            return redirect()->route('hoost.quartiers.index')->with('error','Une erreur inattendue s\'est produite : ' . $e->getMessage());
        }
    }


    public function edit($id)
    {
        $quartier = Quartier::findOrFail($id);
        return view('quartiers.create', compact('quartier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
        ],[
            "libelle.required"=> "Le libelle est requis"
        ]);

        $quartier = Quartier::findOrFail($id);
        $quartier->libelle = $request->input('libelle');
        $quartier->save();
        return redirect()->route('hoost.quartiers.index')->with('success', 'Quartier mis à jour avec succès');
    }

    public function destroy($id)
    {
        Quartier::find($id)->delete();
        return redirect()->route('hoost.quartiers.index')->with('success', 'Quartier supprimé avec succès');
    }



    


}
