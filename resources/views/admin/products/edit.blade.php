@extends('layouts.admin')

@section('title', 'Modifier : ' . $product->name_fr)

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom (Français) *</label>
                    <input type="text" name="name_fr" value="{{ old('name_fr', $product->name_fr) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom (Anglais) *</label>
                    <input type="text" name="name_en" value="{{ old('name_en', $product->name_en) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie *</label>
                <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name_fr }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prix (DA) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" step="0.01"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description (Français)</label>
                <textarea name="description_fr" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description_fr', $product->description_fr) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description (Anglais)</label>
                <textarea name="description_en" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description_en', $product->description_en) }}</textarea>
            </div>

            {{-- Current images --}}
            @if($product->images && count($product->images) > 0)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Images actuelles</label>
                <div class="flex gap-2 flex-wrap">
                    @foreach($product->images as $img)
                        <img src="{{ $img }}" class="w-20 h-20 object-cover rounded-lg border">
                    @endforeach
                </div>
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ajouter des images</label>
                <input type="file" name="images[]" multiple accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="active" value="1" {{ old('active', $product->active) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm font-medium text-gray-700">Actif</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm font-medium text-gray-700">⭐ Produit vedette</span>
                </label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-indigo-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-indigo-700 transition">
                    Enregistrer les modifications
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="border border-gray-300 px-6 py-3 rounded-xl hover:bg-gray-50 transition text-gray-700">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
