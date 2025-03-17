@extends('layouts.app')

@section('title', 'Conferma Ordine')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-lg" style="margin-top: 30px">
        <h2 class="text-2xl font-bold mb-6">Conferma il tuo Ordine</h2>

        <div class="mb-6">
            @foreach ($cartItems as $item)
                @if(isset($item->product) && $item->product)
                    <div class="flex items-center justify-between border-b border-gray-300 py-4">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/'.$item->product->image) }}" 
                                alt="{{ $item->product->name }}" 
                                class="w-20 h-20 rounded-lg shadow-sm">
                            <div class="ml-4">
                                <h2 class="text-lg font-bold text-gray-800">{{ $item->product->name }}</h2>
                                <p class="text-sm text-gray-500">Quantità: {{ $item->quantity }}</p>
                                <p class="text-lg font-bold text-gray-700">
                                    {{ number_format($item->product->price * $item->quantity, 2) }} €
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-red-500">Prodotto non disponibile.</p>
                @endif
            @endforeach
        </div>

        <div class="mb-6 p-4 bg-gray-100 rounded-lg">
            <h3 class="text-xl font-semibold mb-2">Indirizzo di Spedizione</h3>

            @if(Auth::user())
                <p><strong>Nome:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p><strong>Indirizzo:</strong> {{ Auth::user()->address }}</p>
                <p><strong>CAP:</strong> {{ Auth::user()->zip_code }}</p>
                <p><strong>Città:</strong> {{ Auth::user()->city }}</p>
            @else
                <form action="{{ route('orders.finalize') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" name="name" required class="w-full border rounded p-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" required class="w-full border rounded p-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Indirizzo</label>
                            <input type="text" name="address" required class="w-full border rounded p-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">CAP</label>
                            <input type="text" name="zip_code" required class="w-full border rounded p-2">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Città</label>
                            <input type="text" name="city" required class="w-full border rounded p-2">
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <a href="{{ route('register') }}" class="text-blue-500 underline">Registrati</a>
                        <button class="bg-green-500 text-white px-6 py-2 rounded">
                            Conferma Ordine come Guest
                        </button>
                    </div>
                </form>
            @endif
        </div>

        @if(Auth::user())
            <form action="{{ route('orders.finalize') }}" method="POST">
                @csrf
                <button class="bg-green-600 text-white px-6 py-3 rounded w-full text-lg font-semibold">
                    Conferma Ordine
                </button>
            </form>
        @endif
    </div>
@endsection
