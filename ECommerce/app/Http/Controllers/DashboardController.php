<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\CartItem;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Numero totale di ordini effettuati dall'utente
        $ordersCount = Order::where('user_id', $user->id)->count();

        // Numero totale di prodotti attualmente nel carrello dell'utente
        $cartItemsCount = CartItem::where('user_id', $user->id)->sum('quantity');

        // Somma totale di quanto ha speso l'utente (somma di tutti gli ordini)
        $totalSpent = Order::where('user_id', $user->id)->sum('total_price');

        // Ordini recenti (ultimi 5)
        $recentActivities = Order::where('user_id', $user->id)
                                 ->orderBy('created_at', 'desc')
                                 ->take(5)
                                 ->get();

        return view('dashboard.index', compact('user', 'ordersCount', 'cartItemsCount', 'totalSpent', 'recentActivities'));
    }
}
