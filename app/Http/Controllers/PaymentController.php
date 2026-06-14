<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\CardException;
use Stripe\Exception\ApiErrorException;
use Illuminate\Http\Request;
use App\Models\Basket;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;


class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {

            $paymentIntent = PaymentIntent::create([
                'amount' => (int) ($request->amount * 100),
                'currency' => 'eur',
                'payment_method' => $request->payment_method_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('cart'),
            ]);

            // Paiement nécessitant une authentification (3D Secure)
            if (
                $paymentIntent->status === 'requires_action'
                && $paymentIntent->next_action->type === 'use_stripe_sdk'
            ) {

                return response()->json([
                    'requires_action' => true,
                    'payment_intent_client_secret' => $paymentIntent->client_secret,
                ]);
            }

            // Paiement réussi
            if ($paymentIntent->status === 'succeeded') {

                // Création de la commande
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'numero_commande' => 'CMD-' . Str::upper(Str::random(10)),
                    'total' => $request->amount,
                    'statut' => 'en attente',
                    'methode_paiement' => 'CB',
                    'adresse_livraison' => $request->address,
                ]);

                // Récupération du panier
                $cart = Basket::where('user_id', Auth::id())->get();

                // Création des lignes de commande
                foreach ($cart as $product) {

                    OrderDetails::create([
                        'order_id' => $order->id,
                        'product_id' => $product->product_id,
                        'quantity' => $product->qty,
                        'price' => $product->price,
                    ]);
                }

                // Suppression du panier
                Basket::where('user_id', Auth::id())->delete();

                // Envoi du mail de confirmation
                $site_name = Config::get('app.name');

                Mail::to(Auth::user()->email)
                    ->send(new OrderConfirmationMail($order, $site_name));

                return response()->json([
                    'success' => true,
                    'client_secret' => $paymentIntent->client_secret,
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Le paiement n\'a pas été confirmé.',
                'status' => $paymentIntent->status,
            ], 400);

        } catch (CardException $e) {

            $error = $e->getError();

            $messages = [
                'expired_card' => 'Votre carte bancaire a expiré.',
                'card_declined' => 'Votre carte a été refusée.',
                'incorrect_cvc' => 'Le code de sécurité (CVC) est incorrect.',
                'processing_error' => 'Une erreur est survenue lors du traitement du paiement.',
                'incorrect_number' => 'Le numéro de carte est invalide.',
                'insufficient_funds' => 'Fonds insuffisants.',
                'authentication_required' => 'Une authentification supplémentaire est requise.',
            ];

            return response()->json([
                'success' => false,
                'error_code' => $error->code,
                'decline_code' => $error->decline_code,
                'error' => $messages[$error->code] ?? $error->message,
            ], 400);

        } catch (ApiErrorException $e) {

            return response()->json([
                'success' => false,
                'error_code' => 'stripe_api_error',
                'error' => 'Une erreur est survenue lors de la communication avec Stripe.',
            ], 500);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error_code' => 'server_error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
