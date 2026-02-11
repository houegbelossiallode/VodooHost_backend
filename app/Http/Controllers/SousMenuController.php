<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Sousmenu;
use Illuminate\Http\Request;

class SousMenuController extends Controller
{
    public function index()
     {
         $sousmenus = Sousmenu::with('menu')->orderBy('updated_at','desc')->get();
         return view('sousmenus.index', compact('sousmenus'));
     }
 
     // Afficher le formulaire de création
     public function create()
     {
        $menus = Menu::latest()->get();
        return view('sousmenus.create',compact('menus'));
     }
 
     // Enregistrer un nouveau sousmenu
     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required',
             'menu_id' => 'required|exists:menus,id',
             'url' => 'required',
         ],[
            'name.required' => "Le name est requis",
            'menu_id.required' => "Le menu est requis",
            'url.required' => "L'URL est requise",
        ]);
 
         Sousmenu::create([
             'name' => $request->name,
             'menu_id' => $request->menu_id,
             'url' => $request->url,
         ]);
 
         return redirect()->route('hoost.sousmenus.index')->with('success', 'sousmenu créé avec succès.');
     }
 
     // Afficher le formulaire d'édition
     public function edit($id)
     {
         $sousmenu = Sousmenu::findOrFail($id);
         $menus = Menu::latest()->get(); 
         return view('sousmenus.edit', compact('sousmenu','menus'));
     }
 
     // Mettre à jour un sousmenu
     public function update(Request $request, $id)
     {
         $request->validate([
             'name' => 'required|max:255',
             'menu_id' => 'required|exists:menus,id', 
             'url' => 'required',
         ],[
            'name.required' => "Le name est requis",
            'menu_id.required' => "Le menu est requis",
            'url.required' => "L'URL est requise",
        ]);
 
         $sousmenu = Sousmenu::findOrFail($id);
         $sousmenu->forceFill([
             'name' => $request->name,
             'menu_id' => $request->menu_id,
             'url' => $request->url,
         ])->save();
 
         return redirect()->route('hoost.sousmenus.index')->with('success', 'sousmenu mis à jour avec succès.');
     }
 
     // Supprimer un sousmenu (en le marquant comme supprimé)
     public function destroy($id)
     {
         $sousmenu = Sousmenu::findOrFail($id);
         if(!$sousmenu){
             return back()->with('error', 'Sousmenu introuvable.');
         }
         $sousmenu->delete();

         return redirect()->route('hoost.sousmenus.index')->with('success', 'Module supprimé avec succès.');
     }
}
