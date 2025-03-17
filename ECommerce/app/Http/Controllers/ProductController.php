<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
    
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
    
        $products = $query->get();
    
        return view('products.index', compact('products'));
    }
    
    

    public function show($id)
    {
        $product = Product::with('reviews.user')->findOrFail($id);
        $reviews = $product->reviews; 
    
        $averageRating = $reviews->avg('rating') ?? 0; 
    
        return view('products.show', compact('product', 'reviews', 'averageRating'));
    }
    
    
}
