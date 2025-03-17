@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="min-h-screen flex justify-center" style="margin-top: 50px">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-12 w-full max-w-6xl px-4">
            <div class="flex justify-center md:justify-end w-full md:w-1/2">
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-96 h-auto rounded-lg shadow-lg">
            </div>

            <div class="w-full md:w-1/2">
                <h1 class="text-4xl font-bold text-gray-800">{{ $product->name }}</h1>
                <p class="text-lg text-gray-500 mt-2">{{ $product->description }}</p>
                <p class="text-4xl font-bold text-red-500 mt-4">{{ $product->price }} €</p>
                <ul class="mt-4 text-gray-600 space-y-2">
                    <li>Disponibilità: <span class="text-green-600 font-semibold">{{ $product->stock }}</span></li>
                </ul>
                <div class="flex items-center mt-4">
                    <span class="text-xl font-semibold">Valutazione Media:</span>
                    <div class="flex items-center text-yellow-400 ml-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049.641c.3-.921 1.603-.921 1.902 0l1.871 5.717h6.014c.969 0 1.372 1.24.588 1.81l-4.864 3.53 1.872 5.717c.299.922-.755 1.688-1.54 1.19L10 14.276l-4.865 3.53c-.784.498-1.838-.268-1.539-1.19l1.871-5.717-4.864-3.53c-.784-.57-.38-1.81.588-1.81h6.013l1.871-5.717z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600 ml-2">({{ number_format($averageRating, 1) }} su 5)</span>
                </div>
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-6">
                    @csrf
                    <button class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 focus:outline-none">
                        Aggiungi al carrello
                    </button>
                </form><br><br>
                
                <div class="max-w-6xl mx-auto mt-12 px-4">
            
                    @if($reviews->isEmpty())
                        <p class="text-gray-500">Nessuna recensione disponibile.</p>
                    @else
                        @foreach($reviews as $review)
                            <div class="bg-white p-4 shadow-md rounded-lg mb-4">
                                <div class="flex items-center">
                                    <div class="font-bold text-lg">{{ $review->user->name }}</div>
                                    <div class="flex ml-4 text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049.641c.3-.921 1.603-.921 1.902 0l1.871 5.717h6.014c.969 0 1.372 1.24.588 1.81l-4.864 3.53 1.872 5.717c.299.922-.755 1.688-1.54 1.19L10 14.276l-4.865 3.53c-.784.498-1.838-.268-1.539-1.19l1.871-5.717-4.864-3.53c-.784-.57-.38-1.81.588-1.81h6.013l1.871-5.717z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-600 mt-2">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>
                
                @auth
                <button onclick="openReviewModal()" class="bg-green-500 text-white px-6 py-3 mt-4 rounded-lg">
                    Aggiungi una Recensione
                </button>
                @endauth
            </div>
        </div>
    </div>

    

    <div id="reviewModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
            <h2 class="text-xl font-bold mb-4">Lascia una Recensione</h2>
            <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                @csrf
                <label class="block mb-2">Valutazione</label>
                <select name="rating" class="border p-2 w-full rounded" required>
                    <option value="5">5 - Eccellente</option>
                    <option value="4">4 - Buono</option>
                    <option value="3">3 - Normale</option>
                    <option value="2">2 - Scarso</option>
                    <option value="1">1 - Pessimo</option>
                </select>

                <label class="block mt-4 mb-2">Commento</label>
                <textarea name="comment" class="border p-2 w-full rounded" required></textarea>

                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" onclick="closeReviewModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Annulla</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Invia Recensione</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openReviewModal() {
            document.getElementById('reviewModal').classList.remove('hidden');
        }
        function closeReviewModal() {
            document.getElementById('reviewModal').classList.add('hidden');
        }
    </script>
@endsection
