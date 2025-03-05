@extends('layouts.app')

@section('title', 'Dettaglio Ordine')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-lg" style="margin-top: 30px">
        <h1 class="text-3xl font-bold text-center mb-6">Dettaglio Ordine</h1>

        <!-- Informazioni generali sull'ordine -->
        <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-6">
            <p class="text-lg"><strong>ID Ordine:</strong> {{ $order->id }}</p>
            <p class="text-lg"><strong>Codice Ordine:</strong> <span class="text-blue-500 font-semibold">{{ $order->order_code }}</span></p>
            <p class="text-lg"><strong>Totale:</strong> <span class="font-bold">{{ number_format($order->total_price, 2) }} €</span></p>
            <p class="text-lg"><strong>Stato:</strong> <span class="text-gray-700">{{ $order->status }}</span></p>
            <p class="text-lg"><strong>Data:</strong> {{ $order->created_at->format('d/m/Y') }}</p>
        </div>

        <!-- Tabella dei prodotti nell'ordine -->
        <h2 class="text-2xl font-bold mb-4">Prodotti Ordinati</h2>
        <div class="overflow-x-auto">
            <table class="w-full border-collapse rounded-lg shadow-lg">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="px-4 py-3 text-left">PRODOTTO</th>
                        <th class="px-4 py-3 text-left">QUANTITÀ</th>
                        <th class="px-4 py-3 text-left">PREZZO UNITARIO</th>
                        <th class="px-4 py-3 text-left">TOTALE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr class="border-b">
                            <td class="px-4 py-4 text-gray-800">{{ $item->product->name }}</td>
                            <td class="px-4 py-4 text-gray-800">{{ $item->quantity }}</td>
                            <td class="px-4 py-4 text-gray-800">{{ number_format($item->price, 2) }} €</td>
                            <td class="px-4 py-4 font-bold text-gray-900">{{ number_format($item->quantity * $item->price, 2) }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pulsante per tornare agli ordini -->
        <div class="mt-6 text-center">
            <a href="{{ route('orders.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-200">
                Torna ai tuoi ordini
            </a>
        </div>
    </div>
@endsection
