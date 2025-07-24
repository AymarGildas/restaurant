<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
      public function __construct()
    {
        // examples:
        $this->middleware(['permission:order-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:order-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:order-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:order-delete'],["only" =>["destroy"]]);
    }
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'orderItems.plat'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order with its items.
     */
    public function show($id)
    {
        $order = Order::with(['customer', 'orderItems.plat'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit($id)
    {
        $order = Order::with(['orderItems.plat'])->findOrFail($id);

        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified order in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status'           => 'required|in:pending,accepted,preparing,on_the_way,delivered,cancelled',
            'delivery_address' => 'nullable|string|max:255',
            'payment_status'   => 'required|in:pending,paid',
            'notes'            => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.index')->with('success', 'Order updated successfully.');
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted successfully.');
    }
}
