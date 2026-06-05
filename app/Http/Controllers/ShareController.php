<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShareController extends Controller
{
    public function productShare($id)
    {
        $product = Product::findOrFail($id);

        // Strip HTML and get first sentence of description
        $description = strip_tags($product->description ?? '');
        $firstSentence = '';
        if (!empty($description)) {
            $parts = preg_split('/(?<=[.?!])\s+/', trim($description));
            $firstSentence = $parts[0] ?? $description;
        }

        $image = $product->image_name ? url($product->image_name) : url('/images/default.png');

        return view('share_product', [
            'product' => $product,
            'firstSentence' => $firstSentence,
            'image' => $image,
        ]);
    }
}
