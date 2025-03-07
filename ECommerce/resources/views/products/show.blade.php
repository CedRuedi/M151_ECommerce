@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="min-h-screen flex  justify-center" style="margin-top: 50px">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-12 w-full max-w-6xl px-4">
            <!-- Immagine del prodotto -->
            <div class="flex justify-center md:justify-end w-full md:w-1/2">
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-96 h-auto rounded-lg shadow-lg">
            </div>

            <!-- Dettagli del prodotto -->
            <div class="w-full md:w-1/2">
                <!-- Titolo -->
                <h1 class="text-4xl font-bold text-gray-800">{{ $product->name }}</h1>

                <!-- Descrizione -->
                <p class="text-lg text-gray-500 mt-2">{{ $product->description }}</p>

                <!-- Prezzo -->
                <p class="text-4xl font-bold text-red-500 mt-4">{{ $product->price }} €</p>

                <!-- Specifiche -->
                <ul class="mt-4 text-gray-600 space-y-2">
                    {{-- <li>Capacità: {{ $product->capacity ?? 'Non specificato' }}</li>
                    <li>Colore: {{ $product->color ?? 'Non specificato' }}</li> --}}
                    <li>Disponibilità: <span class="text-green-600 font-semibold">{{$product->stock}}</span></li>
                </ul>

                <!-- Valutazioni -->
                <div class="flex items-center mt-4">
                    <div class="flex items-center text-yellow-400">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $product->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049.641c.3-.921 1.603-.921 1.902 0l1.871 5.717h6.014c.969 0 1.372 1.24.588 1.81l-4.864 3.53 1.872 5.717c.299.922-.755 1.688-1.54 1.19L10 14.276l-4.865 3.53c-.784.498-1.838-.268-1.539-1.19l1.871-5.717-4.864-3.53c-.784-.57-.38-1.81.588-1.81h6.013l1.871-5.717z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600 ml-2">({{ $product->reviews_count }} recensioni)</span>
                </div>

                <!-- Pulsante aggiungi al carrello -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-6">
                    @csrf
                    <button class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 focus:outline-none">
                        Aggiungi al carrello
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
