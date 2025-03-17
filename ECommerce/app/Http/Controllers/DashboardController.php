<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $ordersCount = Order::where('user_id', $user->id)->count();

        $cartItemsCount = CartItem::where('user_id', $user->id)->sum('quantity');

        $totalSpent = Order::where('user_id', $user->id)->sum('total_price');

        $recentActivities = Order::where('user_id', $user->id)
                                 ->orderBy('created_at', 'desc')
                                 ->take(5)
                                 ->get();

                                 
        $products = Product::with('category')->get();
        $categories = Category::all();
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('dashboard.index', compact('user', 'ordersCount', 'cartItemsCount', 'totalSpent', 'recentActivities','products','categories','users','roles'));
    }
}
