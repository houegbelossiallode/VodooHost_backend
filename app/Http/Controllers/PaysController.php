<?php

namespace App\Http\Controllers;

use App\Models\Pays;
use Illuminate\Http\Request;

class PaysController extends Controller
{
    public function index()
    {
        $pays = Pays::where('actif','OUI')->latest()->get();
        return view('pays.index', compact('pays'));
    }

    public function create()
    {
        return view('pays.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required',
        ],[
            'libelle.required' => 'Le champ libellé est requis.'
        ]);

        Pays::create($request->all());
        return redirect()->route('hoost.pays.index')->with('success', 'Pays created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $pays = Pays::findOrFail($id);
        return view('pays.edit', compact('pays'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'libelle' => 'required',
        ],[
            'libelle.required' => 'Le champ libellé est requis.'
        ]);

        $pays = Pays::findOrFail($id);
        $pays->update($request->all());

        return redirect()->route('hoost.pays.index')->with('success', 'Pays updated successfully.');
    }
    public function destroy($id)
    {
        $pays = Pays::findOrFail($id);
        if($pays->actif === 'OUI'){
            $pays->actif = 'NON';
            $pays->save();
        } else {
            $pays->actif = 'OUI';
            $pays->save();
        }
        return redirect()->route('hoost.pays.index')->with('success', 'Pays deleted successfully.');
    }

}
