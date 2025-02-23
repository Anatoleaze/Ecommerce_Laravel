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

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric|min:0',
            'methode_paiement' => 'required|string',
            'adresse_livraison' => 'required|string',
        ]);

        $commande = Order::create([
            'user_id' => Auth::id(),
            'total' => $request->total,
            'methode_paiement' => $request->methode_paiement,
            'adresse_livraison' => $request->adresse_livraison,
        ]);

        return response()->json([
            'message' => 'Commande créée avec succès !',
            'commande' => $commande
        ]);
    }

    /*public function index()
    {
        return response()->json(Order::with('user')->latest()->get());
    }*/


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $orders = Order::with('user')->get();
        
        return view('order', [ 'title' => 'Mes Commandes', 'data' => $orders]);
    }

    /**
     * Show details of a order
     */
    public function details($order_id){

        $order_details = OrderDetails::where('order_id', $order_id)->get();
        $data = [];

        $order = Order::where(['id' => $order_id])->first();

        foreach ($order_details as $key => $value) {
            
            $product = Product::where('id', $value->product_id)->first();

            $data[]=array(
                'order_id' => $order->id,
                'quantity' => $value->quantity,
                'product_price' => $product->price,
                'product_name' => $product->name,
                'product_image' => $product->image_name,
                'statut' => $order->statut,
                'num' => $order->numero_commande,
                'livraison' => $order->adresse_livraison,
                'total' => $order->total

            );
        }
       
        $date = Carbon::parse($order_details[0]['created_at'])->format('d/m/Y');
        
        return view('order_details', ['date'=> $date, 'order' => $data]);

    }

    /**
     * Show order in admin
     */
    public function adminShow(Request $request)
    {
        $orders = Order::where('statut', 'en attente')->get();

        return view('order', [ 'title' => 'Les Commandes reçuent', 'data' => $orders]);
    }


    // Change Order Status
    public function updateOrderStatus(Request $request, $orderId)
    {

        $order = Order::findOrFail($orderId);

        if ($order->statut === 'en attente') {
            $order->statut = 'en cours de livraison';
            $order->save();
            
            $user = auth()->user();
            
            Mail::to($user->email)->send(new OrderStatusUpdated($order));

            return response()->json([
                'success' => true,
                'message' => 'Le statut de la commande a été mis à jour.',
                'status' => $order->statut
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Le statut de la commande ne peut pas être mis à jour.'
        ]);
    }

}
