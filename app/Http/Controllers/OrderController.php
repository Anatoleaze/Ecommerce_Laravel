<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /*

        $query = Product::query();

        if ($search) {
            $query->where('user_id', 'like', '');
        }

        // Utiliser paginate() pour la pagination
        $products = $query->paginate(4); // 12 produits par page
        */
        $link = config('app.url');

        return view('order', [ 'link' => $link]);
    }
}
