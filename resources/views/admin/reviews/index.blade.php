@extends('layouts.admin')

@section('title', 'Avis clients')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Avis clients</h1>
    <span class="text-sm text-gray-500">{{ $reviews->total() }} avis au total</span>
</div>

@if($reviews->isEmpty())
    <div class="bg-white rounded-xl shadow p-12 text-center text-gray-400">
        <i class="fas fa-star text-5xl mb-3 text-gray-200"></i>
        <p>Aucun avis pour l'instant.</p>
    </div>
@else
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-4 py-3 text-gray-600 font-semibold">Auteur</th>
                <th class="text-left px-4 py-3 text-gray-600 font-semibold">Produit</th>
                <th class="text-left px-4 py-3 text-gray-600 font-semibold">Note</th>
                <th class="text-left px-4 py-3 text-gray-600 font-semibold">Commentaire</th>
                <th class="text-left px-4 py-3 text-gray-600 font-semibold">Statut</th>
                <th class="text-left px-4 py-3 text-gray-600 font-semibold">Date</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @foreach($reviews as $review)
            <tr class="hover:bg-gray-50 {{ !$review->approved ? 'bg-yellow-50' : '' }}">
                <td class="px-4 py-3">
                    <p class="font-medium text-gray-800">{{ $review->author_name }}</p>
                    @if($review->author_email)
                        <p class="text-xs text-gray-400">{{ $review->author_email }}</p>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-700">
                    <a href="{{ route('shop.show', $review->product->slug) }}" target="_blank"
                       class="hover:text-indigo-600">
                        {{ $review->product->getName() }}
                    </a>
                </td>
                <td class="px-4 py-3">
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-xs"></i>
                        @endfor
                    </div>
                    <span class="text-xs text-gray-500">{{ $review->rating }}/5</span>
                </td>
                <td class="px-4 py-3 text-gray-600 max-w-xs">
                    <p class="line-clamp-2 text-sm">{{ $review->comment ?: '—' }}</p>
                </td>
                <td class="px-4 py-3">
                    @if($review->approved)
                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">
                            <i class="fas fa-check"></i> Approuvé
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full font-medium">
                            <i class="fas fa-clock"></i> En attente
                        </span>
                    @endif
                </td>
                <td class="px-4 py-3 text-xs text-gray-400">{{ $review->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-4 py-3">
                    <div class="flex gap-2 justify-end">
                        @if(!$review->approved)
                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" title="Approuver"
                                    class="text-green-600 hover:text-green-800 text-sm px-2 py-1 border border-green-300 rounded hover:bg-green-50">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST"
                              onsubmit="return confirm('Supprimer cet avis ?')">
                            @csrf @method('DELETE')
                            <button type="submit" title="Supprimer"
                                    class="text-red-500 hover:text-red-700 text-sm px-2 py-1 border border-red-200 rounded hover:bg-red-50">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $reviews->links() }}</div>
@endif
@endsection
