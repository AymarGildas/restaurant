<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Admin\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:user-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:user-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:user-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:user-delete'],["only" =>["destroy"]]);

    }
    /**
     * Display a listing of the resource.
     */
public function index()
{
    if (!auth()->user()->hasRole('Super Admin')) {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Super Admin');
        })->get();
    } else {
        $users = User::all();
    }

    return view('admin.users.index', compact('users'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view("admin.users.create", compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'roles' => 'required|array',
        'roles.*' => 'string|exists:roles,name'
    ]);

    if ($validated->fails()) {
        return response()->json(['errors' => $validated->errors()], 403);
    }

    try {
        // Créer l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 🛡 Attribuer les rôles via le guard sanctum
        $roles = Role::whereIn('name', $request->roles)
                     ->where('guard_name', 'sanctum')
                     ->pluck('name')
                     ->toArray();

        $user->syncRoles($roles);

        // Créer un token
        $user->createToken('auth_token')->plainTextToken;

        return redirect()->route("admin.users.index")->with("success", "Utilisateur créé avec succès.");
        
    } catch (\Exception $exception) {
        return response()->json(['error' => $exception->getMessage()], 403);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);
        return view("admin.users.show", compact('user'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = User::find($id);
        $roles= Role::all();
        return view("admin.users.edit", compact("user", "roles"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Validate input
        $validated = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:6|confirmed', 
            'roles' => 'required|array',
            'roles.*' => 'string|exists:roles,name'       
        ]);

        if ($validated->fails()) {
            return response()->json(data: $validated->errors(),status:403);
        }

        
       try {
        $user = User::find($id);
         // 🛡 Attribuer les rôles via le guard sanctum
         $roles = Role::whereIn('name', $request->roles)
         ->where('guard_name', 'sanctum')
         ->pluck('name') 
         ->toArray();

        $user->syncRoles($roles);

        $user->name = $request->name;
        $user-> email = $request->email;
        $user->password = Hash::make(value: $request->password);
        $user->save();

        return redirect()->route("admin.users.index")->with("success","User updated.");

 
        } catch (\Exception $exception) {
         return response()->json(data:['error' => $exception->getMessage()],status:403);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);
        $user->delete();
        return redirect()->route("admin.users.index")->with("success","User deleted.");

    }
}
