<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerOrder;
use App\Models\Customer\CustomerOrderItem;
use App\Models\Admin\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerOrderController extends Controller
{
         public function __construct()
    {
        // examples:
        $this->middleware(['permission:customer-order-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:customer-order-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:customer-order-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:customer-order-delete'],["only" =>["destroy"]]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = auth()->user()->id;

        $orders = CustomerOrder::with('orderItems.plat')
            ->where('user_id', $userId)
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $plats = Plat::where('is_active', true)->get();

        return view('customer.orders.create', compact('plats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userId = auth()->user()->id;

        $validated = $request->validate([
            'delivery_type'      => 'required|in:pickup,delivery',
            'delivery_address'   => 'nullable|string|max:255|required_if:delivery_type,delivery',
            'notes'              => 'nullable|string',
            'items'              => 'required|array|min:1',
            'items.*.plat_id' => 'required|exists:plats,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;

            foreach ($validated['items'] as $item) {
                $plat = Plat::findOrFail($item['plat_id']);
                $totalAmount += $plat->price * $item['quantity'];
            }

            $order = CustomerOrder::create([
                'user_id'          => $userId,
                'total_amount'     => $totalAmount,
                'status'           => 'pending',
                'delivery_type'    => $validated['delivery_type'],
                'delivery_address' => $validated['delivery_address'] ?? null,
                'payment_status'   => 'pending',
                'notes'            => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                $plat = Plat::findOrFail($item['plat_id']);
                $order->orderItems()->create([
                    'plat_id' => $plat->id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $plat->price,
                ]);
            }

            DB::commit();

            return redirect()->route('customer.orders.index')->with('success', 'Order placed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Failed to place order: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = auth()->user()->id;

        $order = CustomerOrder::with('orderItems.plat')
            ->where('user_id', $userId)
            ->findOrFail($id);

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userId = auth()->user()->id;

        $order = CustomerOrder::with('orderItems')->where('user_id', $userId)->findOrFail($id);
        $plats = Plat::where('is_active', true)->get();

        return view('customer.orders.edit', compact('order', 'plats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $userId = auth()->user()->id;

        $order = CustomerOrder::where('user_id', $userId)->findOrFail($id);

        $validated = $request->validate([
            'delivery_type'      => 'required|in:pickup,delivery',
            'delivery_address'   => 'nullable|string|max:255|required_if:delivery_type,delivery',
            'notes'              => 'nullable|string',
            'items'              => 'required|array|min:1',
            'items.*.plat_id' => 'required|exists:plats,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            foreach ($validated['items'] as $item) {
                $plat = Plat::findOrFail($item['plat_id']);
                $totalAmount += $plat->price * $item['quantity'];
            }

            $order->update([
                'total_amount'     => $totalAmount,
                'delivery_type'    => $validated['delivery_type'],
                'delivery_address' => $validated['delivery_address'] ?? null,
                'notes'            => $validated['notes'] ?? null,
            ]);

            // Remove old items
            $order->orderItems()->delete();

            // Add new items
            foreach ($validated['items'] as $item) {
                $plat = Plat::findOrFail($item['plat_id']);
                $order->orderItems()->create([
                    'plat_id' => $plat->id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $plat->price,
                ]);
            }

            DB::commit();

            return redirect()->route('customer.orders.show', $order->id)->with('success', 'Order updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Failed to update order: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userId = auth()->user()->id;

        $order = CustomerOrder::where('user_id', $userId)->findOrFail($id);
        $order->delete();

        return redirect()->route('customer.orders.index')->with('success', 'Order deleted successfully.');
    }
}
