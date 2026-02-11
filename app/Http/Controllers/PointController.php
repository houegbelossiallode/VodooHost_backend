<?php

namespace App\Http\Controllers;

use App\Models\Pointfort;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index()
    {
        $points = Pointfort::where('actif','OUI')->orderBy('updated_at','desc')->get();
        return view('points.index', compact('points'));
    }

    public function create()
    {
        return view('points.create');
    }

    public function store(Request $request)
    {
        // Validation et stockage de l'équipement
        $request->validate([
            'libelle' => 'required|string|max:255',
        ],[
            "libelle.required"=> "Le libelle est requis"
        ]);
        // Logique de création de l'équipement
        Pointfort::create([
            'titre' => $request->input('libelle'),
            'description'=> 'ok'
        ]);
        return redirect()->route('hoost.points.index')->with('success', 'Point fort  créé avec succès');
    }

    public function edit($id)
    {
        $point = Pointfort::findOrFail($id);
        return view('points.edit', compact('point'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
        ],[
            "libelle.required"=> "Le libelle est requis"
        ]);

        $point = Pointfort::findOrFail($id);
        $point->titre = $request->input('libelle');
        $point->description = 'ok';
        $point->save();
        return redirect()->route('hoost.points.index')->with('success', 'Point fort mis à jour avec succès');
    }

    public function destroy($id)
    {
        $point = Pointfort::find($id);
        if($point->actif === 'OUI'){
            $point->actif = 'NON';
            $point->save();
        } else {
            $point->actif = 'OUI';
            $point->save();
        }
        return redirect()->route('hoost.points.index')->with('success', 'Point fort supprimé avec succès');
    }
}
