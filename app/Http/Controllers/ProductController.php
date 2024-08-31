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

        $query = Product::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('type', 'like', '%' . $search . '%');
        }

        // Utiliser paginate() pour la pagination
        $products = $query->paginate(4); // 12 produits par page
 
        $link = config('app.url');

        return view('products_list', ['products' => $products, 'search' => $search, 'link' => $link]);
    }

    /**
     * List all products
     */
    public function list(){
      
        // Use Pagination 
        $products = Product::paginate(50); // 50 pproduct by page

        $link = config('app.url');

        return view('products_list_admin', ['products' => $products, 'link'=> $link]);
    
    }

        
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $link = config('app.url');
        return view('create_product',['link' => $link]);
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

        // Image Upload
        $path="";

        if ($request->hasFile('image_name')) {
            try {
                
                $request->file('image_name')->move(public_path('images'), $request->file('image_name')->getClientOriginalName());
                $path .= 'images/' . $request->file('image_name')->getClientOriginalName();

            } catch (\Exception $e) {
                return redirect()->route('create_product')->with('error', $e);
            }
        }

        $product = new Product();
        $product->name = $request->name;
        $product->slug = str_replace('-','_',str_replace(' ','_', strtolower($request->name)));
        $product->description = $request->description;
        $product->type = $request->type;
        $product->price = strval(str_replace(' ','',str_replace('€','',str_replace(',','.',$request->price))));
        $product->sale_price = strval(str_replace(' ','',str_replace('€','',str_replace(',','.',$request->sale_price))));
        $product->image_name = $path; 
        
        $product->save();

        $users = User::all();

        foreach($users as $user){
            $contactData = [
                'nom' => $user->name,
                'prenom' => $user->first_name,
                'mail' => $user->email,
                'site' => config('app.name'),
                'link' => config('app.url'),
            ];

            Mail::to($user->email)->send(new CreateProductMail($contactData));
               
        }

        $link = config('app.url');

        return redirect()->route('create_product', ['link' => $link])->with('success', 'Produit créé avec succès.');
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Data Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'type' => 'required|string',
            'image_name' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Update product
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->sale_price = $request->input('sale_price');
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

        return redirect()->route('products_list_admin',['link'=>$link])->with('success', 'Produit supprimé avec succès.');
    
    }
}
