<?php

namespace App\Http\Controllers;
use App\Models\Customer\CustomerOrder;
use App\Models\Customer\CustomerOrderItem;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        // examples:
        $this->middleware(['permission:access-dashboard'],["only" =>["index","show"]]);

    }

    /**
     * Show the application dashboard.
     */
     public function index()
    {
        // 1. Get the currently logged-in user's ID
        $userId =  auth()->user()->id; 


        // 2. Fetch all orders for that user, including the items and their associated plats
        // We order by the newest first and paginate the results.
        $orders = CustomerOrder::where('user_id', $userId)
                                ->with('orderItems.plat') // Eager load nested relationships
                                ->latest()
                                ->paginate(10); // Show 10 orders per page

        // 3. Pass the orders to the view
        return view('home', compact('orders')); 
    }
}
