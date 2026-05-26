<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Illuminate\Http\Request;
use App\Models\Product;

use Illuminate\Support\Facades\Log;
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
        $types = ['hommes', 'femmes', 'chaussures', 'sacs', 'montres'];
        $limitPerType = 8; // max par tag
        $products = collect();

        foreach ($types as $type) {
            $products = $products->merge(
                Product::where('type', $type)->latest()->limit($limitPerType)->get()
            );
        }
        
        $link = config('app.url');
        
        return view('home', compact('products','link'));
    }

   
    
}


