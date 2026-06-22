<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Refund;

class OrderController extends Controller
{
    /**
     * Enregistre une nouvelle commande après le succès Stripe
     */
    public function store(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric|min:0',
            'methode_paiement' => 'required|string',
            'adresse_livraison' => 'required|string',
            'payment_intent_id' => 'nullable|string|unique:orders,payment_intent_id',
        ]);

        $commande = Order::create([
            'user_id' => Auth::id(),
            'numero_commande' => 'CMD-' . strtoupper(Str::random(8)),
            'total' => $request->total,
            'statut' => 'En attente',
            'methode_paiement' => $request->methode_paiement,
            'payment_intent_id' => $request->payment_intent_id ?? null,
            'adresse_livraison' => $request->adresse_livraison,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Commande créée avec succès !',
            'commande' => $commande
        ], 201);
    }

    /**
     * Liste des commandes pour le client (et fallback admin global)
     */
    public function index(Request $request)
    {
        if (Auth::user()->isAdmin()) {
            $orders = Order::with('user')->latest()->get();
        } else {
            $orders = Order::with('user')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('order', [
            'title' => Auth::user()->isAdmin() ? 'Gestion de toutes les commandes' : 'Mes Commandes',
            'data' => $orders
        ]);
    }

    /**
     * Vue Admin globale : Envoie TOUTES les commandes à Vue
     */
    public function adminShow(Request $request)
    {
        // CORRIGÉ : Plus de ->where() restrictif pour que Vue reçoive tous les statuts
        $orders = Order::with('user')->latest()->get();

        return view('order', ['title' => 'Gestion globale des commandes', 'data' => $orders]);
    }

    /**
     * Détails d'une commande (Produits inclus)
     */
    public function details($order_id)
    {
        $order = Order::findOrFail($order_id);
        $order_details = OrderDetails::where('order_id', $order_id)->get();
        $data = [];

        foreach ($order_details as $value) {
            $product = Product::find($value->product_id);

            $productPrice = $product ? $product->price : $value->price;
            $productName = $product ? $product->name : 'Produit inconnu';
            $productImage = $product ? $product->image_name : 'default.png';

            $data[] = [
                'order_id' => $order->id,
                'quantity' => $value->quantity,
                'product_price' => $productPrice,
                'product_name' => $productName,
                'product_image' => $productImage,
                'statut' => $order->statut,
                'num' => $order->numero_commande,
                'livraison' => $order->adresse_livraison,
                'total' => $order->total
            ];
        }

        $date = Carbon::parse($order->created_at)->format('d/m/Y');

        return view('order_details', ['date' => $date, 'order' => $data]);
    }

    /**
     * Changement de statut logistique (Boutons du tableau Vue)
     */
    public function updateOrderStatus(Request $request, $orderId)
    {
        $newStatus = $request->input('status');

        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Commande introuvable'], 404);
        }

        $order->statut = $newStatus;
        $order->save();

        return response()->json([
            'success' => true,
            'status' => $order->statut
        ]);
    }

    /**
     * Remboursement Stripe avec double sécurité (statut 'livre' + Mock Seeder)
     */
    public function refundOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->statut !== 'livre') {
            return response()->json([
                'success' => false,
                'error' => 'Erreur : Seules les commandes livrées peuvent être remboursées.'
            ], 422);
        }

        if (empty($order->payment_intent_id)) {
            return response()->json([
                'success' => false,
                'error' => 'Erreur : Aucun identifiant de paiement trouvé.'
            ], 422);
        }

        // Bypasser Stripe si c'est une fausse commande du Seeder (commence par demo_)
        if (str_starts_with($order->payment_intent_id, 'demo_')) {
            $order->update(['statut' => 'rembourse']);
            return response()->json([
                'success' => true,
                'message' => '[MODE SIMULATION] La fausse commande a été remboursée localement !'
            ]);
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Utilisation du bon paramètre 'payment_intent' avec ta colonne 'payment_intent_id'
            Refund::create([
                'payment_intent' => $order->payment_intent_id,
            ]);

            $order->update(['statut' => 'rembourse']);

            return response()->json([
                'success' => true,
                'message' => 'La commande a été remboursée avec succès sur Stripe !'
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            return response()->json(['error' => 'Erreur Stripe : ' . $e->getMessage()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur serveur : ' . $e->getMessage()], 500);
        }
    }
}
