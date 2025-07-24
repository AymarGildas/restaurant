<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:role-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:role-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:role-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:role-delete'],["only" =>["destroy"]]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view("admin.roles.index", compact("roles"));

      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view("admin.roles.create", compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:250"
        ]);

        $role = Role::create(["name" => $request->name]);
        $role->syncPermissions($request->permissions);
        return redirect()->route('admin.roles.index')
                         ->with('success', 'Rôle créé avec succès.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $role = Role::with('permissions')->findOrFail($id);
    return view("admin.roles.show", compact("role"));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::find($id);
        $permissions = Permission::all();
        return view("admin.roles.edit", compact("role", "permissions"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required|string|max:250"
        ]);

        $role = Role::find($id);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);
        return redirect()->route('admin.roles.index')
                         ->with('success', 'Rôle mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
    
        if ($role->name === 'Admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Vous ne pouvez pas supprimer le rôle administrateur.');
        }
    
        // Détache d’abord toutes les permissions
        $role->permissions()->detach();
    
        // Optionnel : détache tous les utilisateurs associés
        $role->users()->detach(); // uniquement si tu relies des utilisateurs au rôle via Spatie
    
        $role->delete();
    
        return redirect()->route('admin.roles.index')
            ->with('success', 'Rôle supprimé avec succès.');
    }
    
    
    

}
