<?php

namespace App\Http\Controllers;

use App\Models\Constance;
use Exception;
use Illuminate\Http\Request;

class ConstanceController extends Controller
{
    public function index()
    {
        $constances = Constance::where('actif','OUI')->orderBy('updated_at','desc')->get();
        return view('constances.index', compact('constances'));
    }

    public function create()
    {
        return view('constances.create');
    }

    public function store(Request $request)
    {
        try{
          $request->validate([
            'param' => 'required',
            'val' => 'required',
        ], [
            'param.required' => "Le champs est requis",
            'val.required' => "Le champs est requis",
        ]);
        Constance::create([
            'param' => $request->param,
            'val' => $request->val,
        ]);
        return redirect()->route('hoost.constances.index')->with('success', 'Constante créée avec succès.');
        }
        catch(Exception $e){
            return redirect()->route('hoost.constances.index')->with(['error' => 'Une erreur est survenue lors de la création de la constante.' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $constance = Constance::findOrFail($id);
        return view('constances.edit', compact('constance'));
    }


    public function update(Request $request, $id)
    {
        try{
        $constance = Constance::findOrFail($id);
        $request->validate([
            'param' => 'required',
            'val' => 'required',
        ], [
            'param.required' => "Le champs est requis",
            'val.required' => "Le champs est requis",
        ]);
        $constance->update([
            'param' => $request->param,
            'val' => $request->val,
        ]);
        return redirect()->route('hoost.constances.index')->with('success', 'Constante mise à jour avec succès.');
        }
        catch(Exception $e){
            return redirect()->route('hoost.constances.index')->with(['error' => 'Une erreur est survenue lors de la mise à jour de la constante.' . $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        $constance = Constance::findOrFail($id);
        if($constance->actif === 'OUI'){
            $constance->actif = 'NON';
        } else {
            $constance->actif = 'OUI';
        }
        $constance->save();
        return redirect()->route('hoost.constances.index')->with('success', 'Constante supprimée avec succès.');
    }
}
