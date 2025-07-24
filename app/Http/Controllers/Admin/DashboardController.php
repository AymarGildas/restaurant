<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\User;
use App\Models\Admin\Order;
use App\Models\Admin\Plat;
use App\Models\Admin\OrderItem; // Assuming you have this model

class DashboardController extends Controller
{
      public function __construct()
    {
        // examples:
        $this->middleware(['permission:access-dashboard'],["only" =>["index"]]);
    }
    public function index()
    {
        // Use the Customer role to count clients, not all users
        $totalClients = User::role('Customer')->count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalplats = Plat::count();

        // Calculate total revenue from completed orders
        $totalRevenue = Order::where('status', 'delivered')->sum('total_amount');

        // Calculate how many units of each plat need to be prepared from active orders
        // UPDATED: Changed ->get() to ->paginate()
        $platsToPrepare = OrderItem::select('plat_id')
            ->selectRaw('SUM(quantity) as total_quantity')
            ->whereHas('order', function ($query) {
                // Only count orders that are still active in the kitchen
                $query->whereIn('status', ['pending', 'accepted', 'preparing']);
            })
            ->groupBy('plat_id')
            ->with('plat') // Eager load plat info for efficiency
            ->orderBy('total_quantity', 'desc') // Show most needed items first
            ->paginate(5); // Paginate the results, showing 5 per page

        return view('admin.dashboard.index', compact(
            'totalClients',
            'totalOrders',
            'pendingOrders',
            'totalplats',
            'totalRevenue',
            'platsToPrepare'
        ));
    }
}
