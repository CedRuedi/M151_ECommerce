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
                    return $item->product !== null;  // Filtra gli articoli senza prodotto associato
                });
        } else {
            $sessionCart = session()->get('cart', []);
        
            // Recupera i dettagli dei prodotti dal database e rimuove quelli inesistenti
            $cartItems = collect($sessionCart)->map(function ($item) {
                $product = Product::find($item['product']['id']);
                if ($product) {  // Verifica se il prodotto esiste
                    return (object) [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                    ];
                }
                return null; // Ignora i prodotti non validi
            })->filter(); // Rimuove gli elementi null
        }
    
        // Calcolo del totale
        $cartTotal = $cartItems->sum(fn($item) => $item->product ? $item->product->price * $item->quantity : 0);
    
        return view('cart.index', compact('cartItems', 'cartTotal'));
    }
    
    

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
    
        if (Auth::user()) {
            // Se l'utente è autenticato, aggiungiamo al DB
            $cartItem = CartItem::where('user_id', Auth::id())
                                ->where('product_id', $productId)
                                ->first();
    
            if ($cartItem) {
                // Se esiste già, aggiorna solo la quantità di +1
                $cartItem->increment('quantity');
            } else {
                // Se non esiste, creiamo un nuovo elemento con quantità 1
                CartItem::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => 1,
                ]);
            }
        } else {
            // Se è un guest, salviamo il carrello nella sessione
            $cart = session()->get('cart', []);
    
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += 1;
            } else {
                $cart[$productId] = [
                    'product' => ['id' => $productId], // Salva solo l'ID
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
            // Aggiorna nel database
            CartItem::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->update(['quantity' => $request->quantity]);
        } else {
            // Aggiorna nella sessione
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
            // Rimuove dal database
            CartItem::where('user_id', Auth::id())->where('product_id', $productId)->delete();
        } else {
            // Rimuove dalla sessione
            $cart = session()->get('cart', []);
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
    
        return redirect()->route('cart.index')->with('success', 'Prodotto rimosso.');
    }
    

}
