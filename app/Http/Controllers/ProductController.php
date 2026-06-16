<?php

namespace App\Http\Controllers;

use App\Mail\CreateProductMail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $price = $request->input('price');

        $query = Product::query();

        // Filtre par type ou recherche par nom
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('type', $search)
                    ->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        // Filtre par prix
        if ($price) {
            switch ($price) {
                case 'price-0-50':
                    $query->where('price', '<', 50);
                    break;
                case 'price-50-100':
                    $query->whereBetween('price', [50, 100]);
                    break;
                case 'price-100-200':
                    $query->whereBetween('price', [100, 200]);
                    break;
                case 'price-200-500':
                    $query->whereBetween('price', [200, 500]);
                    break;
                case 'price-500-plus':
                    $query->where('price', '>=', 500);
                    break;
            }
        }

        $products = $query->paginate(20)->withQueryString();
        $link = config('app.url');

        return view('products_list', [
            'products' => $products,
            'search' => $search,
            'link' => $link
        ]);
    }

    /**
     * List all products
     */
    /**
     * List all products (Admin)
     */
    /**
     * List all products (Admin)
     */
    public function list(Request $request)
    {
        $query = Product::query();

        // Si le champ de recherche contient un mot
        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        // Dans ton ProductController.php, modifie la méthode list :
        $products = $query->orderBy('created_at', 'desc')->paginate(10);

        $link = config('app.url');

        return view('products_list_admin', [
            'products' => $products, 
            'link' => $link
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $link = config('app.url');
        return view('create_product', ['link' => $link]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'type' => 'required|string|max:255',
            'image_name' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // =========================
        // IMAGE UPLOAD SAFE
        // =========================
        $path = null;

        if ($request->hasFile('image_name')) {

            $file = $request->file('image_name');

            // nom unique pour éviter écrasement
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $destination = public_path('images');

            // sécurité : créer le dossier si besoin
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move($destination, $filename);

            $path = 'images/' . $filename;
        }

        // =========================
        // CREATE PRODUCT
        // =========================
        $product = new Product();
        $product->name = $validated['name'];
        $product->slug = str_replace(' ', '_', strtolower($validated['name']));
        $product->description = $validated['description'];
        $product->type = $validated['type'];

        $product->price = str_replace([' ', '€'], '', $validated['price']);
        $product->sale_price = !empty($validated['sale_price'])
            ? str_replace([' ', '€'], '', $validated['sale_price'])
            : null;
        $product->image_name = $path;
        $product->save();

        // =========================
        // EMAIL (SAFE VERSION)
        // =========================
        try {
            $users = User::all();

            foreach ($users as $user) {
                $contactData = [
                    'nom' => $user->name,
                    'prenom' => $user->first_name,
                    'mail' => $user->email,
                    'site' => config('app.name'),
                    'link' => config('app.url'),
                ];

                Mail::to($user->email)->send(new CreateProductMail($contactData));
            }
        } catch (\Exception $e) {
            // on évite le 500 si email crash
            Log::error('Mail error: ' . $e->getMessage());
        }

        // =========================
        // RESPONSE
        // =========================
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Produit créé avec succès.',
                'product' => $product
            ]);
        }

        return redirect()
            ->route('create_product')
            ->with('success', 'Produit créé avec succès.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $link = config('app.url');

        return view('editProduct', compact('product', 'link'));
    }

    /**
     * Public product detail page used for sharing redirects
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $link = config('app.url');

        return view('product_show', compact('product', 'link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Data Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'type' => 'required|string|max:255',
            'image_name' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Update product
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->sale_price  = $request->filled('sale_price')
            ? $request->sale_price
            : null;
        $product->type = $request->input('type');

        // Image
        if ($request->hasFile('image_name')) {

            // Old image
            $oldImagePath = public_path($product->image_name);

            // Remove if old image exist
            if (file_exists($oldImagePath)) {

                unlink($oldImagePath);
            }

            // Download New image
            $request->file('image_name')->move(public_path('images'), $request->file('image_name')->getClientOriginalName());
            $path = 'images/' . $request->file('image_name')->getClientOriginalName();

            $product->image_name = $path;
        }

        // Save Modification
        $product->save();

        // Return JSON response for AJAX requests
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Produit mis à jour avec succès.',
                'product' => $product
            ]);
        }

        // Regular redirect for form submissions
        $link = config('app.url');
        return redirect()->route('edit', ['id' => $product->id, 'link' => $link])->with('success', 'Produit mis à jour avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Get image
        $imagePath = public_path($product->image_name);

        // Remove image if exist
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $product->delete();

        $link = config('app.url');

        return redirect()->route('products_list_admin', ['link' => $link])->with('success', 'Produit supprimé avec succès.');
    }
}
