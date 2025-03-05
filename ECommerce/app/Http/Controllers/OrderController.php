<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
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

    // Mostra la pagina di conferma dell'ordine
    public function confirmOrder()
    {
        $cartItems = Auth::check()
            ? CartItem::with('product')->where('user_id', Auth::id())->get()
            : session()->get('cart', []);

        $cartTotal = collect($cartItems)->sum(fn($item) => isset($item['product']) ? $item['product']->price * $item['quantity'] : 0);

        return view('orders.confirm', compact('cartItems', 'cartTotal'));

    }

    // Finalizza l'ordine
    public function finalizeOrder(Request $request)
    {
        // Genera un codice ordine univoco
        $orderCode = strtoupper(uniqid('ORD-'));
        
        if (Auth::check()) {
            $orderData = [
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'address' => Auth::user()->address,
                'zip_code' => Auth::user()->zip_code,
                'city' => Auth::user()->city,
            ];
    
            $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        } else {
            // Validazione per guest
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'address' => 'required|string',
                'zip_code' => 'required|string',
                'city' => 'required|string',
            ]);
    
            $orderData = $request->only('name', 'email', 'address', 'zip_code', 'city');
            session(['guest_email' => $request->email]); // Salva l'email nella sessione
    
            $cartItems = collect(session()->get('cart', []));
        }
    
        // Calcola il totale dell'ordine
        $cartTotal = $cartItems->sum(fn($item) => isset($item['product']) ? $item['product']->price * $item['quantity'] : 0);
    
        // Aggiungi il codice ordine e il totale
        $orderData['total_price'] = $cartTotal;
        $orderData['order_code'] = $orderCode;
    
        // Crea l'ordine nel database
        $order = Order::create($orderData);
        
        // Salva gli articoli nell'ordine
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item['product']->id,
                'quantity' => $item['quantity'],
                'price' => $item['product']->price,
            ]);
        }
    
        // Svuota il carrello
        Auth::check() ? CartItem::where('user_id', Auth::id())->delete() : session()->forget('cart');
    
        // Reindirizza alla pagina di successo con i dettagli dell'ordine
        return redirect()->route('orders.success')->with([
            'order_code' => $orderCode,
        ]);
    }
    
}

