<?php

namespace App\Http\Controllers;

use App\Models\Customer\CustomerPlat;
use App\Models\Admin\Type;
use App\Models\Admin\Menu;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // 1. Get all types for the navigation tabs
        $types = Type::all();

        // 2. Get all menus for the filter dropdown
        $menus = Menu::all();

        // 3. Start building the query for plats
        $platsQuery = CustomerPlat::with(['menu', 'type'])
                                  ->where('is_active', true);

        // 4. Filter by the selected Type (from the tabs)
        if ($request->has('type') && $request->type != '') {
            $platsQuery->where('type_id', $request->type);
        }

        // 5. Filter by the selected Menu (from the dropdown)
        if ($request->has('menu') && $request->menu != '') {
            $platsQuery->where('menu_id', $request->menu);
        }

        // 6. Paginate the results, showing 9 plats per page
        $plats = $platsQuery->latest()->paginate(9)->withQueryString();

        // 7. Pass all the data to the view
        return view('landing', compact('types', 'menus', 'plats'));
    }
}