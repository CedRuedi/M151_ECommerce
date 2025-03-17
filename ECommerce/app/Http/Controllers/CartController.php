<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (Auth::user()) {
            $cartItems = CartItem::with('product')
                ->where('user_id', Auth::id())
                ->get()
                ->filter(function ($item) {
                    return $item->product !== null;  
                });
        } else {
            $sessionCart = session()->get('cart', []);
        
            $cartItems = collect($sessionCart)->map(function ($item) {
                $product = Product::find($item['product']['id']);
                if ($product) {  
                    return (object) [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                    ];
                }
                return null; 
            })->filter(); 
        }
    
        $cartTotal = $cartItems->sum(fn($item) => $item->product ? $item->product->price * $item->quantity : 0);
    
        return view('cart.index', compact('cartItems', 'cartTotal'));
    }
    
    

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
    
        if (Auth::user()) {
            
            $cartItem = CartItem::where('user_id', Auth::id())
                                ->where('product_id', $productId)
                                ->first();
    
            if ($cartItem) {
                
                $cartItem->increment('quantity');
            } else {
                
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => 1,
                ]);
            }
        } else {
            
            $cart = session()->get('cart', []);
    
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += 1;
            } else {
                $cart[$productId] = [
                    'product' => ['id' => $productId], 
                    'quantity' => 1,
                ];
            }
            
    
            session()->put('cart', $cart);
        }
    
        return redirect()->route('cart.index')->with('success', 'Prodotto aggiunto al carrello!');
    }

    public function update(Request $request, $productId)
    {
        if (Auth::user()) {
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->update(['quantity' => $request->quantity]);
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $request->quantity;
            }
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Quantità aggiornata.');
    }

    

    public function remove($productId)
    {
        if (Auth::user()) {
            CartItem::where('user_id', Auth::id())->where('product_id', $productId)->delete();
        } else {
            $cart = session()->get('cart', []);
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
    
        return redirect()->route('cart.index')->with('success', 'Prodotto rimosso.');
    }
    

}
