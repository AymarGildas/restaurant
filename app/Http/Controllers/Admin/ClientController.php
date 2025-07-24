<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\User; // Make sure this points to your User model, e.g., App\Models\User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
      public function __construct()
    {
        // examples:
        $this->middleware(['permission:client-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:client-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:client-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:client-delete'],["only" =>["destroy"]]);

    }
    /**
     * Display a listing of the clients (users with 'Customer' role).
     */
    public function index(Request $request)
    {
        // 1. Get all unique 'secteur' values for the tabs
        $secteurs = User::role('Customer')->pluck('secteur')->unique()->filter();

        // 2. Start building the query for clients
        $clientsQuery = User::role('Customer');

        // 3. Filter by the selected secteur if one is present in the request
        if ($request->has('secteur') && $request->secteur != '') {
            $clientsQuery->where('secteur', $request->secteur);
        }

        // 4. Paginate the results
        $clients = $clientsQuery->latest()->paginate(10)->withQueryString();
        
        return view('admin.clients.index', compact('clients', 'secteurs'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'adresse' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'secteur' => 'required|string|max:100',
        ]);

        $client = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'adresse' => $request->adresse,
            'contact' => $request->contact,
            'secteur' => $request->secteur,
        ]);

        // Automatically assign the 'Customer' role to the new user
        $client->assignRole('Customer');

        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
    }

    /**
     * Display the specified client.
     */
    public function show($id)
    {
        // Find the client with the 'Customer' role
        $client = User::role('Customer')->findOrFail($id);
        
        // Fetch all orders belonging to this client, ordered by the newest first
        // You can paginate this later if needed, e.g., ->paginate(5)
        $orders = $client->orders()->latest()->get();

        // Pass both the client and their orders to the view
        return view('admin.clients.show', compact('client', 'orders'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit($id)
    {
        $client = User::role('Customer')->findOrFail($id);
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Request $request, $id)
    {
        $client = User::role('Customer')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $client->id,
            'password' => 'nullable|string|min:6|confirmed',
            'adresse' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'secteur' => 'required|string|max:100',
        ]);

        $data = $request->only(['name', 'email', 'adresse', 'contact', 'secteur']);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $client->update($data);

        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy($id)
    {
        $client = User::role('Customer')->findOrFail($id);
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully.');
    }
}
