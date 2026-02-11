<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Sousmenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolePermissionController extends Controller
{
    public function index()
    {
        $roleid = request('roleid');
        if(empty($roleid)){
            return redirect()->route('hoost.roles.index')->with('error', 'Veuillez selectionner un profil.');
        }
        $role = Role::where('id',$roleid)->firstOrFail();
        if(!$role){
            return redirect()->route('hoost.roles.index')->with('error', 'Ce profil n\'existe pas');
        }
        $permissions = RolePermission::where('role_id',$roleid)->get();
        //dd($permissions);
        return view('roles.permissions.index', compact('permissions','role'));
    }

    public function create()
    {
        $roles = Role::latest()->get();
        $sousmenus = Sousmenu::latest()->get();
        return view('roles.permissions.create', compact('roles', 'sousmenus'));
    }

    public function store(Request $request)
    {
        try{
        $request->validate([
            'sousmenu_id' => 'required',
            'role_id' => 'required',
        ], [
            'sousmenu_id.required' => "Le champs est requis",
            'role_id.required' => "Le champs est requis",
        ]);

        RolePermission::create([
            'sousmenu_id' => $request->sousmenu_id,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('hoost.permissions.index')->with('success', 'Permission creée avec succès.');

    } catch (\Exception $e) {
        // Gestion des erreurs : redirection avec un message d'erreur
        return redirect()->route('hoost.permissions.index')->with(['error' => 'Une erreur inattendue s\'est produite : ' . $e->getMessage()]);
    }
    
    }


    public function edit(RolePermission $permission)
    {
        $roles = Role::latest()->get();
        $sousmenus = Sousmenu::latest()->get();
        return view('roles.permissions.edit', compact('permission', 'roles', 'sousmenus'));
    }

  
    // public function update(Request $request, $roleId)
    // {
    //     $role = Role::findOrFail($roleId);
    //     $permissions = $request->input('permissions', []);
    //     //return dd(request('permissions'));
    //     // Mettre à jour chaque permission en fonction des checkboxes
    //     foreach ($permissions as $permissionId => $isGranted) {
    //         RolePermission::where('role_id', $roleId)
    //                       ->where('sousmenu_id', $permissionId)
    //                       ->update(['is_granted' => $isGranted]);
    //     }
    //     return redirect()->route('hoost.roles.index')->with('success', 'Droits accordé.');
    // }


    public function update(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);

        // Permissions cochées (ex : [3 => "1", 5 => "1"])
        $permissions = $request->input('permissions', []);
        // 1) Tout passer à false → cast obligatoire
        DB::table('role_permissions')
            ->where('role_id', $roleId)
            ->update(['is_granted' => DB::raw('false')]); // ou '0::boolean'

        // 2) Activer ceux cochés
        foreach ($permissions as $permissionId => $value) {
            DB::table('role_permissions')
                ->where('role_id', $roleId)
                ->where('sousmenu_id', $permissionId)
                ->update(['is_granted' => DB::raw('true')]); // ou '1::boolean'
        }
    return redirect()->route('hoost.roles.index')->with('success', 'Permissions mises à jour avec succès ✔');
    }



}
