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
            $cartItems = CartItem::with('product')->where('user_id', Auth::id())->get()
                ->filter(fn($item) => $item->product !== null);
        } else {
            $sessionCart = session()->get('cart', []);
    
            $cartItems = collect($sessionCart)->map(function ($item) {
                $productId = $item['product']['id'] ?? null;
                $quantity = $item['quantity'] ?? 1; 
    
                if (!$productId) {
                    return null;
                }
    
                $product = Product::find($productId);
                if (!$product) {
                    return null; 
                }
    
                return (object) [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            })->filter();
        }
    
        $cartTotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
    
        return view('orders.confirm', compact('cartItems', 'cartTotal'));
    }
    
    
    
    
    
    public function finalizeOrder(Request $request)
    {
        $orderCode = strtoupper(uniqid('ORD-'));
    
        if (Auth::check()) {
            $cartItems = CartItem::with('product')
                ->where('user_id', Auth::id())
                ->get()
                ->filter(fn($item) => $item->product !== null);
    
            $orderData = [
                'user_id' => Auth::id(),
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'address' => Auth::user()->address,
                'zip_code' => Auth::user()->zip_code,
                'city' => Auth::user()->city,
            ];
        } else {
            $sessionCart = session()->get('cart', []);
    
            $cartItems = collect($sessionCart)->map(function ($item) {
                $product = Product::find($item['product']['id'] ?? null);
                if ($product) {
                    return (object) [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                    ];
                }
                return null;
            })->filter();
    
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'address' => 'required|string',
                'zip_code' => 'required|string',
                'city' => 'required|string',
            ]);
    
            $orderData = $request->only('name', 'email', 'address', 'zip_code', 'city');
            session(['guest_email' => $request->email]);
        }
    
        $cartTotal = $cartItems->sum(fn($item) => $item->product ? $item->product->price * $item->quantity : 0);
    
        $orderData['total_price'] = $cartTotal;
        $orderData['order_code'] = $orderCode;
    
        $order = Order::create($orderData);
    
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product->id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
            $item->product->decrement('stock', $item->quantity);
        }
    
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }
        
        return redirect()->route('orders.success')->with([
            'order_code' => $orderCode,
        ]);
    }
    
    
}

