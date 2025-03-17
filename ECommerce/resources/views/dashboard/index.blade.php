@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@if(auth()->check() && auth()->user()->roles->contains('name', 'Admin'))
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Pannello di Amministrazione</h1>
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Gestione Utenti</h1>
    
    
        <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-200 text-gray-700">
                    <th class="p-4 text-center">Nome</th>
                    <th class="p-4 text-center">Email</th>
                    <th class="p-4 text-center">Ruolo</th>
                    <th class="p-4 text-center">Azione</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-t text-center">
                        <td class="p-4">{{ $user->name }}</td>
                        <td class="p-4">{{ $user->email }}</td>
                        <td class="p-4">
                            <form action="{{ route('admin.assignRole', $user->id) }}" method="POST">
                                @csrf
                                <select name="role_id" class="border rounded px-3 py-1 w-32 text-center" style="width: 30%">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->roles->contains($role) ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Aggiorna</button>
                            </form>
                        </td>
                        <td class="p-4">
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questo utente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-red-500 px-3 py-1 rounded">Elimina</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Bottone per Aprire la Modale -->
    <button onclick="openModal('add')" class="bg-green-500 text-white px-4 py-2 rounded" style="width: 100%">Aggiungi Prodotto</button>

    <!-- Modale -->
    <!-- Modale Aggiunta -->
    <div id="productModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
            <h2 class="text-xl font-bold mb-4" id="modalTitle">Aggiungi un nuovo prodotto</h2>
            <form id="productForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
            
                <label class="block mb-2">Nome</label>
                <input type="text" name="name" id="productName" class="border p-2 w-full rounded" required>
            
                <label class="block mt-4 mb-2">Descrizione</label>
                <textarea name="description" id="productDescription" class="border p-2 w-full rounded" required></textarea>
            
                <label class="block mt-4 mb-2">Prezzo (€)</label>
                <input type="number" name="price" id="productPrice" step="0.01" class="border p-2 w-full rounded" required>
            
                <label class="block mt-4 mb-2">Stock</label>
                <input type="number" name="stock" id="productStock" class="border p-2 w-full rounded" required>
            
                <label class="block mt-4 mb-2">Categoria</label>
                <select name="category_id" id="productCategory" class="border p-2 w-full rounded" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            
                <label class="block mt-4 mb-2">Immagine</label>
                <input type="file" name="image" id="productImage" class="border p-2 w-full rounded">
            
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Annulla</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salva</button>
                </div>
            </form>
            
        </div>
    </div>

    <!-- Tabella dei prodotti -->
    <table class="w-full bg-white shadow-md rounded-lg mt-4">
        <thead>
            <tr class="bg-gray-200 text-gray-700">
                <th class="p-4">Nome</th>
                <th class="p-4">Categoria</th>
                <th class="p-4">Prezzo</th>
                <th class="p-4">Stock</th>
                <th class="p-4">Immagine</th>
                <th class="p-4">Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr class="border-t text-center">
                    <td class="p-4">{{ $product->name }}</td>
                    <td class="p-4">{{ $product->category->name }}</td>
                    <td class="p-4">€ {{ number_format($product->price, 2) }}</td>
                    <td class="p-4">{{ $product->stock }}</td>
                    <td class="p-4"><img src="{{ asset('storage/' . $product->image) }}" class="rounded" style="width: 100px;height: 80px;margin-left: 35%"></td>
                    <td class="p-4">
                        <button onclick="openModal('edit', {{ $product }})" class="bg-yellow-500 text-blue-500 px-3 py-1 rounded">Modifica</button>
                        <form action="{{ route('admin.products.delete', $product->id) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler eliminare questo prodotto?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-red-500 px-3 py-1 rounded">Elimina</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- JavaScript per la gestione della modale -->
<script>

    function openModal(mode, product = null) {
        const modal = document.getElementById('productModal');
        const form = document.getElementById('productForm');
        const title = document.getElementById('modalTitle');

        if (mode === 'add') {
            title.innerText = "Aggiungi un nuovo prodotto";
            form.action = "{{ route('admin.products.store') }}";
            form.reset();
            document.getElementById('methodField').value = "POST";
            document.getElementById('productImage').required = true;
        } else if (mode === 'edit' && product) {
            title.innerText = "Modifica Prodotto";
            form.action = `/admin/products/${product.id}`;
            document.getElementById('methodField').value = "PUT"; // Cambia il metodo in PUT

            // Assicura che i campi vengano riempiti
            document.getElementById('productName').value = product.name;
            document.getElementById('productDescription').value = product.description;
            document.getElementById('productPrice').value = product.price;
            document.getElementById('productStock').value = product.stock;
            document.getElementById('productCategory').value = product.category_id;
            document.getElementById('productImage').required = false;
        }

        modal.classList.remove('hidden');
    }



    function closeModal() {
        document.getElementById('productModal').classList.add('hidden');
    }
</script>


@else
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
@endif
@endsection
