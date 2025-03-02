<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;


class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(env('VITE_STRIPE_SECRET'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($request->amount*100), // Amount in centimes
                'currency' => 'eur',
                'payment_method' => $request->payment_method_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => \route('cart'),
            ]);

            if ($paymentIntent->status === 'succeeded') {
              
                // Create Order
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'numero_commande' => 'CMD-' . Str::upper(Str::random(10)),
                    'total' => $request->amount,
                    'statut' => 'en attente',
                    'methode_paiement' => 'CB',
                    'adresse_livraison' => $request->address,
                ]);    
                $order->save();
                
                $cart = Basket::where('user_id', Auth::id())->get();
                
                Log::debug('Products in cart');
                Log::debug($cart);
                // Create OrderDetails
                foreach ($cart as $product) {
                    $order_detail = OrderDetails::create([
                        'order_id' => $order->id,
                        'product_id' => $product['product_id'],
                        'quantity' => $product['qty'],
                        'price' => $product['price'],
                    ]);

                    $order_detail->save();
                }

                // Delete Basket
                Basket::where('user_id', Auth::id())->delete();
                
                // Send mail to confirm order
                $site_name = Config::get('app.name');
                Mail::to(Auth::user()->email)->send(new OrderConfirmationMail($order, $site_name));

                return response()->json([
                    'success' => true, 
                    'client_secret' => $paymentIntent->client_secret,
                ]);
            } else {   
                return response()->json(['success' => false, 'error' => 'Paiement non confirmé.']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 200);
        }
    }
}
