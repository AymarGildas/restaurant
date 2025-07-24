<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerPlat;
use Illuminate\Http\Request;

class CartController extends Controller
{
        public function __construct()
    {
        // examples:
        $this->middleware(['permission:cart-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:cart-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:cart-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:cart-delete'],["only" =>["destroy"]]);
    }
    /**
     * Display a listing of the resource (show the cart page).
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        // Calculate the total price of the items in the cart
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        return view('customer.cart.index', compact('cart', 'total'));
    }

    /**
     * Store a newly created resource in storage (add a plat to the cart).
     */
    public function store(Request $request)
    {
        $request->validate([
            'plat_id' => 'required|exists:plats,id',
        ]);

        $platId = $request->input('plat_id');
        $plat = CustomerPlat::findOrFail($platId);

        $cart = session()->get('cart', []);

        // Check if the item is already in the cart
        if (isset($cart[$platId])) {
            // If yes, increment the quantity
            $cart[$platId]['quantity']++;
        } else {
            // If no, add the new item with quantity 1
            $cart[$platId] = [
                "name"     => $plat->name,
                "quantity" => 1,
                "price"    => $plat->price,
                "image"    => $plat->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Plat added to cart successfully!');
    }

    /**
     * Update the specified resource in storage (update an item's quantity).
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = (int) $request->input('quantity');
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove the specified resource from storage (remove an item from the cart).
     */
    public function destroy(string $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Plat removed from cart successfully!');
    }
}