<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Basket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get Czrt of user
     */
    public function index()
    {
        $cart = Basket::where('user_id', Auth::id())->with('product')->get();
        return response()->json($cart);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $status = 200;

        try {
            // Check of product exist in cart
            $cartItem = Basket::where('user_id', Auth::id())
                                ->where('product_id', $request->product_id)
                                ->first();

            if ($cartItem) {
                // Update quantity and price
                $cartItem->increment('qty', $request->quantity);
                $cartItem->increment('price', $request->price * $request->quantity);

            } else {
                // Create product in cart
                $cartItem = Basket::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'qty' => $request->quantity,
                'price' => $request->price * $request->quantity,
                ]); 
            }
        } catch (\Exception $e) {
            $status = 500; // Erreur serveur
            return response()->json([
                'message' => 'Une erreur est survenue',
                'error' => $e->getMessage()
            ], $status);
        }

        return response()->json(['message' => 'Produit ajouté au panier', 'cartItem' => $cartItem, 'status' => $status]);

    }

    /**
     * Show cart of user
     */
    public function show(Basket $cartModel)
    {
        $data = array();
        $cart = Basket::where('user_id', Auth::id())->get();

        foreach($cart as $cart_row) {
            $product = Product::where('id', $cart_row->product_id)->first();
            $data[]= [
                'product_id' => $cart_row->product_id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $cart_row->qty,
                'img' => '/'.$product->image_name
            ];
            
        }

        return view('cart', compact('data'));
        
    }

    

    // A voir
    public function remove($id)
    {
        Basket::where('product_id', $id)->where('user_id', Auth::id())->delete();
        return response()->json(['message' => 'Produit retiré du panier']);
    }

    /**
     * Get Number of product in cart
     */
    public function getCartCount()
    {
        $count = Basket::where('user_id', Auth::id())->sum('qty'); 
        return response()->json(['count' => $count]);
    }

    
    public function update(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|integer',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
    ]);

    $cartItem = Basket::where('product_id', $validated['product_id'])
                    ->where('user_id', Auth::id()) 
                    ->first();

    if (!$cartItem) {
        return response()->json(['message' => 'Item not found'], 404);
    }

    if ($validated['quantity'] == 0) {
        $cartItem->delete();
        return response()->json(['message' => 'Item removed']);
    } else {
        $cartItem->qty = $validated['quantity'];
        $cartItem->price =  $validated['price'];
        $cartItem->save();
        return response()->json(['message' => 'Cart updated', 'cartItem' => $cartItem]);
    }
}
}
