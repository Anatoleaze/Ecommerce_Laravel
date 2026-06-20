<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\OrderDetails;
use App\Models\Product;
use Carbon\Carbon;
use App\Mail\OrderStatusUpdated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Store a newly created order (Après succès Stripe)
     */
    public function store(Request $request)
    {
        // 1. Validation stricte des données entrantes
        $request->validate([
            'total' => 'required|numeric|min:0',
            'methode_paiement' => 'required|string',
            'adresse_livraison' => 'required|string',
            'payment_intent_id' => 'required|string|unique:orders,payment_intent_id', // Évite les doublons de commande
        ]);

        // 2. Génération du numéro de commande unique
        $numeroCommande = 'CMD-' . strtoupper(Str::random(8));

        // 3. Insertion propre en BDD (Ici, on utilise bien $request-> et JAMAIS $POST)
        $commande = Order::create([
            'user_id' => Auth::id(),
            'numero_commande' => $numeroCommande,
            'total' => $request->total,
            'methode_paiement' => $request->methode_paiement,
            'payment_intent_id' => $request->payment_intent_id,
            'adresse_livraison' => $request->adresse_livraison,
            'statut' => 'payé',
        ]);

        // 4. Réponse structurée attendue par ton composant Vue3
        return response()->json([
            'success' => true,
            'message' => 'Commande créée avec succès !',
            'commande' => $commande
        ], 201);
    }

    /**
     * Display a listing of the resource for the client
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
            'title' => 'Mes Commandes',
            'data' => $orders
        ]);
    }

    /**
     * Show details of an order
     */
    public function details($order_id)
    {
        $order = Order::findOrFail($order_id);
        $order_details = OrderDetails::where('order_id', $order_id)->get();
        $data = [];

        foreach ($order_details as $value) {
            $product = Product::find($value->product_id);

            // Sécurité si un produit a été supprimé de la BDD entre temps
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

        // Plus sécurisé : on prend la date de la commande directement
        $date = Carbon::parse($order->created_at)->format('d/m/Y');

        return view('order_details', ['date' => $date, 'order' => $data]);
    }

    /**
     * Show orders in admin panel
     */
    public function adminShow(Request $request)
    {
        // On affiche les commandes payées en priorité (les nouvelles reçues)
        // Tu pourras enlever le ->where() si tu veux que l'admin voie TOUTES les commandes
        $orders = Order::with('user')->where('statut', 'payé')->latest()->get();

        return view('order', ['title' => 'Les Commandes reçues', 'data' => $orders]);
    }


    /**
     * Change Order Status (Côté Admin)
     */
    public function updateOrderStatus(Request $request, $orderId)
    {
        // Récupère le statut envoyé depuis le body JSON du fetch ({ status: nextStatus })
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
}
