<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('orders.show', compact('order'));
    }

    public function confirmOrder()
    {
        if (Auth::check()) {
            // Se l'utente è autenticato, recupera i prodotti dal database
            $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get()
                ->filter(fn($item) => $item->product !== null); // Rimuove eventuali prodotti eliminati
        } else {
            // Se l'utente è guest, recupera i prodotti salvati in sessione
            $sessionCart = session()->get('cart', []);
    
            // Recupera i dettagli dei prodotti dal database e rimuove quelli non esistenti
            $cartItems = collect($sessionCart)->map(function ($item) {
                $productId = $item['product']['id'] ?? null; // Corregge il recupero dell'ID
                $quantity = $item['quantity'] ?? 1; // Quantità predefinita se non presente
    
                if (!$productId) {
                    return null; // Se manca l'ID, ignora l'elemento
                }
    
                $product = Product::find($productId);
                if (!$product) {
                    return null; // Se il prodotto non esiste più, ignoralo
                }
    
                return (object) [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            })->filter(); // Rimuove gli elementi nulli
        }
    
        // Calcola il totale
        $cartTotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
    
        return view('orders.confirm', compact('cartItems', 'cartTotal'));
    }
    
    
    
    
    

    // Finalizza l'ordine
    public function finalizeOrder(Request $request)
    {
        // Genera un codice ordine univoco
        $orderCode = strtoupper(uniqid('ORD-'));
    
        if (Auth::check()) {
            // Se l'utente è autenticato, prendi i dati direttamente dal DB
            $cartItems = CartItem::with('product')
                ->where('user_id', Auth::id())
                ->get()
                ->filter(fn($item) => $item->product !== null); // Filtra prodotti non validi
    
            $orderData = [
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'address' => Auth::user()->address,
                'zip_code' => Auth::user()->zip_code,
                'city' => Auth::user()->city,
            ];
        } else {
            // Se è un guest, ottieni i prodotti dalla sessione
            $sessionCart = session()->get('cart', []);
    
            // Recupera i dettagli dei prodotti dal database e rimuove quelli inesistenti
            $cartItems = collect($sessionCart)->map(function ($item) {
                $product = Product::find($item['product']['id'] ?? null);
                if ($product) {
                    return (object) [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                    ];
                }
                return null;
            })->filter(); // Rimuove gli elementi nulli
    
            // Validazione dati guest
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'address' => 'required|string',
                'zip_code' => 'required|string',
                'city' => 'required|string',
            ]);
    
            // Salva i dettagli guest
            $orderData = $request->only('name', 'email', 'address', 'zip_code', 'city');
            session(['guest_email' => $request->email]); // Memorizza l'email nella sessione
        }
    
        // Calcola il totale dell'ordine
        $cartTotal = $cartItems->sum(fn($item) => $item->product ? $item->product->price * $item->quantity : 0);
    
        // Aggiungi il codice ordine e il totale
        $orderData['total_price'] = $cartTotal;
        $orderData['order_code'] = $orderCode;
    
        // Crea l'ordine nel database
        $order = Order::create($orderData);
    
        // Salva gli articoli dell'ordine
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
            $item->product->decrement('stock', $item->quantity);
        }
    
        // Svuota il carrello
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }
        
        // Reindirizza alla pagina di successo con i dettagli dell'ordine
        return redirect()->route('orders.success')->with([
            'order_code' => $orderCode,
        ]);
    }
    
    
}

