<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class TypeController extends Controller
{
        public function __construct()
    {
        // examples:
        $this->middleware(['permission:type-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:type-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:type-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:type-delete'],["only" =>["destroy"]]);
    }
    public function index()
    {
        $types = Type::latest()->paginate(10);
        return view('admin.types.index', compact('types'));
    }

    public function create()
    {
        return view('admin.types.create');
    }

    public function store(Request $request)
    {
        // Add 'description' to validation
        $request->validate([
            'name' => 'required|string|max:255|unique:types,name',
            'description' => 'nullable|string',
        ]);

        // Get the current user's ID using the auth() helper
        $user_id = auth()->user()->id; 

        // Add 'description' and 'user_id' to the create call
        Type::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $user_id,
        ]);

        return redirect()->route('admin.types.index')->with('success', 'Type created successfully.');
    }

    public function edit($id)
    {
        $type = Type::findOrFail($id);
        // Corrected variable from 'types' to 'type'
        return view('admin.types.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        // Add 'description' to validation
        $request->validate([
            'name' => 'required|string|max:255|unique:types,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $type = Type::findOrFail($id);
        
        // Add 'description' to the update call
        $type->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.types.index')->with('success', 'Type updated successfully.');
    }

    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();

        return redirect()->route('admin.types.index')->with('success', 'Type deleted successfully.');
    }
}