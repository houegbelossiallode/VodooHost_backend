<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('updated_at', 'desc')->paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|unique:roles,libelle',
        ], [
            'libelle.required' => "Le champs est requis",
            'libelle.unique' => "Ce rôle existe déjà",
        ]);

        Role::create([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('hoost.roles.index')->with('success', 'Rôle créé avec succès.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.edit', compact('role'));
    }

    

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'libelle' => 'required|unique:roles,libelle,' . $role->id,
        ], [
            'libelle.required' => "Le champs est requis",
            'libelle.unique' => "Ce rôle existe déjà",
        ]);

        $role->update([
            'libelle' => $request->libelle,
        ]);

        return redirect()->route('hoost.roles.index')->with('success', 'Rôle mis à jour avec succès.');
    }
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('hoost.roles.index')->with('success', 'Rôle supprimé avec succès.');
    }
}
