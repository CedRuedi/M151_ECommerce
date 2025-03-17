@extends('layouts.app')

@section('title', 'Ordine Confermato')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-6 shadow-md rounded-lg mt-10 text-center" style="margin-top: 30px">
        <h2 class="text-2xl font-bold text-green-600 mb-4">Ordine Confermato!</h2>
        <p class="text-lg text-gray-700 mb-6">Il tuo ordine è stato completato con successo.</p>

        @if(session('order_code'))
            <p class="text-lg font-bold text-gray-800 mb-4">Codice Ordine: <span class="text-blue-600">{{ session('order_code') }}</span></p>
        @endif

        @if(Auth::check())
            <p class="text-gray-700 mb-4">Puoi visualizzare i dettagli del tuo ordine accedendo alla tua pagina ordini.</p>
            <a href="{{ route('orders.index') }}" class="bg-blue-500 text-white px-6 py-2 rounded-lg font-semibold">
                Vai ai miei ordini
            </a>
        @else
            <p class="text-gray-700 mb-4">Una email con i dettagli del tuo ordine è stata inviata a <strong>{{ session('guest_email') }}</strong>.</p>
            <p class="text-gray-500">Se non la vedi, controlla la cartella spam.</p>
            <a href="{{ route('products.index') }}" class="mt-4 inline-block text-blue-500 underline">Torna ai prodotti</a>
        @endif
    </div>
@endsection
