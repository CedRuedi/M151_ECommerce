@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Benvenuto, {{ $user->name }}!</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-xl font-semibold">Ordini Effettuati</h2>
            <p class="text-4xl text-blue-500 mt-4">{{ $ordersCount }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-xl font-semibold">Prodotti nel Carrello</h2>
            <p class="text-4xl text-green-500 mt-4">{{ $cartItemsCount }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h2 class="text-xl font-semibold">Totale Speso</h2>
            <p class="text-4xl text-red-500 mt-4">€ {{ number_format($totalSpent, 2) }}</p>
        </div>
    </div>

    <div class="mt-8 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold mb-4">Attività Recenti</h2>
        @if($recentActivities->isEmpty())
            <p class="text-gray-500">Nessuna attività recente.</p>
        @else
            <ul class="list-disc pl-5 space-y-2 text-gray-700">
                @foreach ($recentActivities as $order)
                    <li>
                        Ordine #{{ $order->id }} completato il {{ $order->created_at->format('d/m/Y') }} - Totale: € {{ number_format($order->total_price, 2) }}
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
