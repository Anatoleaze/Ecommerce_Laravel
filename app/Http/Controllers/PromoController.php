<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use Carbon\Carbon;

class PromoController extends Controller
{
    
    /**
     * @Route /check-promo
     * Check Code Promo
     */
    public function checkPromo(Request $request)
{
    $request->validate([
        'code' => 'required|string',
        'total' => 'required|numeric',
    ]);

    $promo = Promo::where('code', $request->code)->first();

    if (!$promo) {
        return response()->json(['error' => 'Ce Code n\'existe pas'], 400);
    }

    // Check active code
    $today = Carbon::now()->toDateString();
    if ($promo->started_at > $today || $promo->expired_at < $today) {
        return response()->json(['error' => 'Ce code promo n’est plus valable'], 400);
    }

    if ($promo->started_at > $today) {
        return response()->json(['error' => 'Ce code promo n’existe pas 2'], 400);
    }

    // Check if cart > min cart 
    if ($request->total < $promo->min_achat) {
        return response()->json(['error' => 'Montant minimum requis: ' . $promo->min_achat . '€'], 400);
    }

    // Reduction Apply
    $discount = ($request->total * $promo->remise) / 100;
    $newTotal = $request->total - $discount;

    return response()->json([
        'success' => 'Réduction appliquée avec succès !',
        'discount' => $discount,
        'newTotal' => $newTotal
    ]);
}


}
