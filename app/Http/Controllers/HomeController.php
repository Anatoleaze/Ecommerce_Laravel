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
        $query = Product::query();

        // Use Pagination 
        $products = $query->paginate(8); // 8 pproduct by page
        
        $link = config('app.url');
        
        return view('home', compact('products','link'));
    }

   
    
}


