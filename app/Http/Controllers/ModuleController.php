<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    // Afficher tous les modules
     public function index()
     {
       $modules = Module::where('actif','OUI')->orderBy('updated_at','desc')->get();
        // $search = request('search');
        // if(!empty($search)){
        // $modules = Module::where('actif','OUI')
        //                 ->where(function($query) use ($search) {
        //                     $query->where('name', 'LIKE', "%$search%");
        //                     })
        //                 ->get();      
                      
        // }
        
         return view('modules.index', compact('modules'));
     }
 
     // Afficher le formulaire de création
     public function create()
     {
         return view('modules.create');
     }
 
     // Enregistrer un nouveau module
     public function store(Request $request)
     {
        $request->validate([
          'name' => 'required|max:255',
        ],
        [
            'name.required' => "Le champs est requis",
        ]);
 
         Module::create([
            'name' => $request->name,
         ]);
 
         return redirect()->route('hoost.modules.index')->with('success', 'Module créé avec succès.');
     }
 
     // Afficher le formulaire d'édition
     public function edit($id)
     {
         $module = Module::findOrFail($id);
         return view('modules.edit', compact('module'));
     }
 
     // Mettre à jour un module
     public function update(Request $request, $id)
     {
         $request->validate([
            'name' => 'required|max:255',
         ],
         [
            'name.required' => "Le champs est requis",
        ]);
 
         $module = Module::findOrFail($id);
         $module->forceFill([
             'name' => $request->name,
         ])->save();
 
         return redirect()->route('hoost.modules.index')->with('success', 'Module mis à jour avec succès.');
     }
 
     // Supprimer un module (en le marquant comme supprimé)
     public function destroy($id)
     {
         $module = Module::findOrFail($id);
         $module->delete();
         return redirect()->route('hoost.modules.index')->with('success', 'Module supprimé avec succès.');
     }
}
