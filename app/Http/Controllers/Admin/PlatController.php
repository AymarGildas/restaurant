<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Plat;
use App\Models\Admin\Menu;
use App\Models\Admin\Type; // 1. Import the Type model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlatController extends Controller
{
        public function __construct()
    {
        // examples:
        $this->middleware(['permission:plat-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:plat-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:plat-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:plat-delete'],["only" =>["destroy"]]);
    }
    public function index()
    {
        // 2. Eager load both menu and type relationships
        $plats = Plat::with(['menu', 'type'])->latest()->paginate(10);
        return view('admin.plats.index', compact('plats'));
    }

    public function create()
    {
        $menus = Menu::all();
        $types = Type::all(); // 3. Get all types for the dropdown
        return view('admin.plats.create', compact('menus', 'types')); // 4. Pass types to the view
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
            'menu_id'     => 'required|exists:menus,id',
            'type_id'     => 'required|exists:types,id', // 5. Add validation for type_id
            'is_active'   => 'sometimes|boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('plats', 'public');
            $validated['image'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        Plat::create($validated);

        return redirect()->route('admin.plats.index')->with('success', 'Plat created successfully.');
    }

    public function edit($id)
    {
        $plat = Plat::findOrFail($id);
        $menus = Menu::all();
        $types = Type::all(); // 6. Get all types for the dropdown
        return view('admin.plats.edit', compact('plat', 'menus', 'types')); // 7. Pass types to the view
    }

    public function update(Request $request, $id)
    {
        $plat = Plat::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
            'menu_id'     => 'required|exists:menus,id',
            'type_id'     => 'required|exists:types,id', // 8. Add validation for type_id
            'is_active'   => 'sometimes|boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($plat->image && Storage::disk('public')->exists($plat->image)) {
                Storage::disk('public')->delete($plat->image);
            }
            $path = $request->file('image')->store('plats', 'public');
            $validated['image'] = $path;
        }

        $validated['is_active'] = $request->has('is_active');

        $plat->update($validated);

        return redirect()->route('admin.plats.index')->with('success', 'Plat updated successfully.');
    }

    public function destroy($id)
    {
        $plat = Plat::findOrFail($id);

        if ($plat->image && Storage::disk('public')->exists($plat->image)) {
            Storage::disk('public')->delete($plat->image);
        }

        $plat->delete();

        return redirect()->route('admin.plats.index')->with('success', 'Plat deleted successfully.');
    }
}