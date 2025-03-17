@extends('layouts.app')

@section('title', 'Carrello')

@section('content')
    <style>
        select {
            padding: 5px 20px;
            min-width: 60px;
        }
    </style>

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Il tuo carrello</h1>

        @if($cartItems->isEmpty())
            <p class="text-gray-500">Il carrello è vuoto.</p>
        @else
        @foreach ($cartItems as $item)
            @if ($item->product)
                <div class="bg-white shadow-md rounded-lg p-6 mb-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="w-24 h-24 rounded-lg shadow-sm">
                            <div class="ml-6">
                                <h2 class="text-lg font-bold text-gray-800">{{ $item->product->name }}</h2>
                                <p class="text-sm text-gray-500">{{ $item->product->description }}</p>
                                <p class="text-green-600 text-sm mt-1">✔ Consegnato dopodomani</p>
                                <p class="text-sm text-gray-500">Più di {{ $item->product->stock }} pezzi in stock</p>
                            </div>
                        </div>
        
                        <div class="flex items-center space-x-4">
                            <form action="{{ route('cart.update', $item->product->id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PUT')
        
                                <select name="quantity" class="border border-gray-300 rounded-md px-2 py-1 text-gray-700">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
        
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Aggiorna</button>
                            </form>
        
                            <p class="text-lg font-bold text-gray-700">{{ number_format($item->product->price * $item->quantity, 2) }} €</p>
        
                            <form action="{{ route('cart.remove', $item->product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700">Rimuovi</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-red-500">Prodotto non disponibile.</p>
            @endif
        @endforeach
        

        <div class="mt-6 p-4 bg-white shadow-md rounded-lg">
            <h2 class="text-xl font-bold mb-4">Totale Ordine: {{ number_format($cartTotal, 2) }} €</h2>
        
            <a href="{{ route('orders.confirm') }}" class="bg-green-500 text-white px-6 py-2 rounded w-full text-center block text-lg font-semibold">
                Procedi all'ordine
            </a>
        </div>
            
        @endif
    </div>
@endsection
