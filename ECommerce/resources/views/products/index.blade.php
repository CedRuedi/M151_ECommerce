@extends('layouts.app')

@section('title', 'Prodotti')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-6">
    <div class="flex flex-col md:flex-row items-center justify-between mb-8 bg-white shadow-md rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 md:mb-0">
            Lista Prodotti
        </h1>
        <form method="GET" action="{{ route('products.index') }}" class="flex items-center w-full md:w-auto">
            <input 
                type="text" 
                name="search" 
                placeholder="Cerca prodotti..." 
                class="border border-gray-300 rounded-lg px-4 py-2 w-full md:w-80 focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="{{ request('search') }}"
            >
            <button 
                type="submit" 
                class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none">
                Cerca
            </button>
        </form>
    </div>
</div>

    <div class="flex justify-center px-6" style="margin-bottom: 40px">
        <div class="grid gap-6 px-6" style="grid-template-columns: repeat(3, minmax(300px, 460px));">
            @foreach ($products as $product)
                <div class="bg-white border border-gray-200 rounded-lg shadow-md overflow-hidden">
                    <img class="w-full h-48 object-cover" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                    <div class="p-4">
                        <h5 class="text-lg font-bold text-gray-800">{{ $product->name }}</h5>
                        <p class="text-sm text-gray-600 mt-2">{{ $product->description }}</p>
                        <p class="text-lg font-semibold text-green-600 mt-2">{{ $product->price }} €</p>
                        <a href="{{ route('products.show', $product->id) }}" class="block mt-4 text-center bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Visualizza Dettagli
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
