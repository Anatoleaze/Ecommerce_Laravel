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

    if ($promo->started_at > $today) {
        return response()->json(['error' => 'Ce code promo n\'est pas encore valable'], 400);
    }

    // Vérifie si le code est expiré
    if ($promo->expired_at < $today) {
        return response()->json(['error' => 'Ce code promo est expiré'], 400);
    }

    // Check if cart > min cart 
    if ($request->total < $promo->min_achat) {
        return response()->json(['error' => 'Montant minimum requis: ' . $promo->min_achat . '€'], 400);
    }

    // Reduction Apply
    $discount = round($request->total * ($promo->remise / 100), 2);
    $newTotal = round($request->total - $discount, 2);

    return response()->json([
        'success' => 'Réduction appliquée avec succès !',
        'discount' => $discount,
        'newTotal' => $newTotal,
        'pourcentage' => $promo->remise,
    ]);
}


}
