@extends('layouts.admin')

@section('title', 'Produits')

@section('header-actions')
    <a href="{{ route('admin.products.create') }}"
       class="bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
        + Nouveau produit
    </a>
@endsection

@section('content')

{{-- Filters --}}
<form method="GET" class="bg-white rounded-xl shadow p-4 mb-5 flex flex-wrap gap-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..."
           class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 flex-1 min-w-48">
    <select name="category" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="">Toutes les catégories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name_fr }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800">Filtrer</button>
    <a href="{{ route('admin.products.index') }}" class="border border-gray-300 px-4 py-2 rounded-lg text-sm hover:bg-gray-50">Réinitialiser</a>
</form>

{{-- Table --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Image</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Nom</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Catégorie</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Prix</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Stock</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Statut</th>
                <th class="px-4 py-3 text-right text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($products as $product)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    @if($product->getFirstImage())
                        <img src="{{ $product->getFirstImage() }}" class="w-12 h-12 object-cover rounded-lg">
                    @else
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-image text-gray-300"></i>
                        </div>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <p class="font-medium text-gray-800">{{ $product->name_fr }}</p>
                    <p class="text-xs text-gray-400">{{ $product->name_en }}</p>
                </td>
                <td class="px-4 py-3 text-gray-600">{{ $product->category?->name_fr ?? '-' }}</td>
                <td class="px-4 py-3 font-bold text-indigo-700">{{ number_format($product->price, 2) }} F CFA</td>
                <td class="px-4 py-3">
                    <span class="font-medium {{ $product->stock === 0 ? 'text-red-600' : ($product->stock <= 5 ? 'text-yellow-600' : 'text-green-600') }}">
                        {{ $product->stock }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    @if($product->active)
                        <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded-full">Actif</span>
                    @else
                        <span class="bg-gray-100 text-gray-500 text-xs font-medium px-2 py-1 rounded-full">Inactif</span>
                    @endif
                    @if($product->featured)
                        <span class="bg-yellow-100 text-yellow-700 text-xs font-medium px-2 py-1 rounded-full ml-1">⭐</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin.products.edit', $product) }}"
                       class="text-indigo-600 hover:text-indigo-800 mr-3"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline"
                          onsubmit="return confirm('Supprimer ce produit ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-12 text-center text-gray-400">
                    Aucun produit trouvé.
                    <a href="{{ route('admin.products.create') }}" class="text-indigo-600 hover:underline ml-1">Créer le premier</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
