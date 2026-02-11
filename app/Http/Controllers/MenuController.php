<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Module;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::where('actif','OUI')->orderBy('updated_at','desc')->get();
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        //return view('menus.create');
        $modules = Module::where('actif','OUI')->latest()->get();
        return view('menus.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'module_id' => 'nullable|exists:modules,id',
            'icon' => 'nullable|string|max:255',
        ],[
            'name.required' => 'Le nom est obligatoire.',
            'module_id.required' => 'Le module est obligatoire.',
            'module_id.exists' => 'Le module sélectionné est invalide.',
            'icon.max' => 'L\'icône ne peut pas dépasser 255 caractères.',
            'icon.required' => 'L\'icône est obligatoire.',
        ]);

        Menu::create([
            'name' => $request->name,
            'module_id' => $request->module_id,
            'icon' => $request->icon,
        ]);
        return redirect()->route('hoost.menus.index')->with('success', 'Menu créé avec succès.');
    }

    public function show(Menu $menu)
    {
        $modules = Module::where('actif','OUI')->latest()->get();
        return view('menus.edit', compact('menu', 'modules'));
    }

    public function edit(Menu $menu)
    {
        $modules = Module::where('actif','OUI')->latest()->get();
        return view('menus.edit', compact('menu', 'modules'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'module_id' => 'nullable|exists:modules,id',
            'icon' => 'nullable|string|max:255',
        ],[
            'name.required' => 'Le nom est obligatoire.',
            'module_id.exists' => 'Le module sélectionné est invalide.',
            'icon.max' => 'L\'icône ne peut pas dépasser 255 caractères.',
            'icon.required' => 'L\'icône est obligatoire.',
        ]);

        $menu->update([
            'name' => $request->name,
            'module_id' => $request->module_id,
            'icon' => $request->icon,
        ]);
        return redirect()->route('hoost.menus.index')->with('success', 'Menu mis à jour avec succès.');
    }

    public function destroy(Menu $menu)
    {
        if($menu->actif === 'OUI'){
            $menu->actif = 'NON';
            $menu->save();
        } else {
            $menu->actif = 'OUI';
            $menu->save();
        }
        return redirect()->route('hoost.menus.index')->with('success', 'Menu supprimé avec succès.');
    }
}
