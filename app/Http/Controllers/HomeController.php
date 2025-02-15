<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Illuminate\Http\Request;
use App\Models\Product;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $query = Product::query();

        // Use Pagination 
        $products = $query->paginate(8); // 8 pproduct by page
        
        $link = config('app.url');

        // Get User 
        /*$current_user = auth()->user();
        
        $quantity = 0;
        
        if ($current_user){
            $user_id = $current_user->id;
            
            // Get product in cart
            $cart = Basket::find(['user_id' => $user_id]);
            
            foreach ($cart as $product){
                $quantity += $product->qty;
            }
        }*/

        return view('home', compact('products','link'));
    }

   
    
}


