@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Aggiungi un nuovo prodotto</h1>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <label class="block mb-2">Nome</label>
        <input type="text" name="name" class="border p-2 w-full" required>

        <label class="block mt-4 mb-2">Descrizione</label>
        <textarea name="description" class="border p-2 w-full" required></textarea>

        <label class="block mt-4 mb-2">Prezzo (€)</label>
        <input type="number" name="price" step="0.01" class="border p-2 w-full" required>

        <label class="block mt-4 mb-2">Stock</label>
        <input type="number" name="stock" class="border p-2 w-full" required>

        <label class="block mt-4 mb-2">Categoria</label>
        <select name="category_id" class="border p-2 w-full" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label class="block mt-4 mb-2">Immagine</label>
        <input type="file" name="image" class="border p-2 w-full" required>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-4 rounded">Aggiungi</button>
    </form>
</div>
@endsection
