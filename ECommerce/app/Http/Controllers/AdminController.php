<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function assignRole(Request $request, User $user) {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->roles()->sync([$request->role_id]); // Rimuove i ruoli precedenti e assegna il nuovo

        return redirect()->back()->with('success', 'Ruolo aggiornato con successo!');
    }
    public function create()
    {
        $categories = Category::all();
        return view('admin.create_product', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category_id' => 'required|exists:categories,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
    
            // Controlla se l'immagine è stata caricata
            if (!$request->hasFile('image')) {
                return back()->with('error', 'Errore: Nessuna immagine caricata.');
            }
    
            $imagePath = $request->file('image')->store('prod_img', 'public');
    
            Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'stock' => $request->stock,
                'category_id' => $request->category_id,
                'image' => $imagePath,
            ]);
    
            return redirect()->route('dashboard')->with('success', 'Prodotto aggiunto con successo!');
        } catch (\Exception $e) {
            return back()->with('error', 'Errore: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit_product', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('prod_img', 'public');
            $product->image = $imagePath;
        }
    
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
        ]);
    
        return redirect()->route('dashboard')->with('success', 'Prodotto aggiornato con successo!');
    }
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard')->with('success', 'Prodotto eliminato con successo!');
    }
    
    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->back()->with('success', 'Utente eliminato con successo!');
    }

    
}
