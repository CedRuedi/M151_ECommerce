@extends('layouts.app')

@section('title', 'I tuoi Ordini')

@section('content')
    <div class="max-w-5xl mx-auto bg-white p-6 shadow-md rounded-lg" style="margin-top: 30px; margin-left: 20%;margin-right: 20%">
        <h1 class="text-3xl font-bold text-center mb-6">I tuoi Ordini</h1>

        @if($orders->isEmpty())
            <p class="text-center text-gray-500">Non hai ancora effettuato ordini.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse rounded-lg shadow-lg">
                    <thead>
                        <tr class="bg-gray-200 text-gray-700">
                            <th class="px-4 py-3 text-left">ID ORDINE</th>
                            <th class="px-4 py-3 text-left">CODICE ORDINE</th>
                            <th class="px-4 py-3 text-left">TOTALE</th>
                            <th class="px-4 py-3 text-left">STATO</th>
                            <th class="px-4 py-3 text-left">DATA</th>
                            <th class="px-4 py-3 text-center">AZIONI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="border-b">
                                <td class="px-4 py-4 text-gray-800">{{ $order->id }}</td>
                                <td class="px-4 py-4 text-blue-500 font-semibold">
                                    <a href="{{ route('orders.show', $order->id) }}">{{ $order->order_code }}</a>
                                </td>
                                <td class="px-4 py-4 text-gray-800 font-bold">{{ number_format($order->total_price, 2) }} €</td>
                                <td class="px-4 py-4 text-gray-600">{{ $order->status }}</td>
                                <td class="px-4 py-4 text-gray-600">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-4 text-center">
                                    <a href="{{ route('orders.show', $order->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                                        Dettagli
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
