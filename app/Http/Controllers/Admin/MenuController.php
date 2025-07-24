<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class MenuController extends Controller
{
      public function __construct()
    {
        // examples:
        $this->middleware(['permission:menu-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:menu-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:menu-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:menu-delete'],["only" =>["destroy"]]);

    }
    public function index()
    {
        $menus = Menu::latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        // 1. Add 'description' to validation
        $request->validate([
            'name' => 'required|string|max:255|unique:menus,name',
            'description' => 'nullable|string', // Description can be optional
        ]);

        // 2. Add 'description' and the logged-in user's ID to the create method
        $user_id = auth()->user()->id; // Get the current user's ID
        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $user_id, 
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        // 1. Add 'description' to validation for the update
        $request->validate([
            'name' => 'required|string|max:255|unique:menus,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $menu = Menu::findOrFail($id);
        
        // 2. Add 'description' to the update method
        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
    }
}