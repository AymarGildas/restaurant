<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerOrder;
use App\Models\Customer\CustomerOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
         public function __construct()
    {
        // examples:
        $this->middleware(['permission:checkout-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:checkout-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:checkout-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:checkout-delete'],["only" =>["destroy"]]);
    }
    /**
     * Display the checkout page.
     */
    public function create()
    {
        $cart = session()->get('cart', []);

        // Don't allow access to checkout if the cart is empty
        if (empty($cart)) {
            return redirect()->route('landing')->with('info', 'Your cart is empty. Please add items before proceeding to checkout.');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        return view('customer.checkout.create', compact('cart', 'total'));
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'delivery_type' => 'required|in:pickup,delivery',
            'delivery_address' => 'required_if:delivery_type,delivery|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('landing');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        try {
            // Get the current user's ID
            $user_id = auth()->user()->id; 

            // 1. Create the main Order using the CustomerOrder model
            $order = CustomerOrder::create([
                'user_id' => $user_id,
                'total_amount' => $total,
                'status' => 'pending',
                'delivery_type' => $request->delivery_type,
                // Only save the address if the delivery type is 'delivery'
                'delivery_address' => $request->delivery_type === 'delivery' ? $request->delivery_address : null,
                'payment_status' => 'pending',
                'notes' => $request->notes,
            ]);

            // 2. Loop through the cart and create Order Items for the new order
            foreach ($cart as $id => $item) {
                CustomerOrderItem::create([
                    'order_id' => $order->id,
                    'plat_id' => $id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);
            }

            // 3. Clear the cart from the session
            session()->forget('cart');

            // 4. Redirect to a success page with a confirmation message
            return redirect()->route('landing')->with('success', 'Your order has been placed successfully!');

        } catch (\Exception $e) {
            // If anything goes wrong, log the full error details and redirect back.
            logger()->error('Checkout Error: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all(),
                'cart' => $cart
            ]);
            return redirect()->back()->with('error', 'Something went wrong while placing your order. Please try again.');
        }
    }
}