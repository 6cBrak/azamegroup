@extends('layouts.admin')

@section('title', 'Nouveau produit')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom (Français) *</label>
                    <input type="text" name="name_fr" value="{{ old('name_fr') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name_fr') border-red-400 @enderror">
                    @error('name_fr') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom (Anglais) *</label>
                    <input type="text" name="name_en" value="{{ old('name_en') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie *</label>
                <select name="category_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Choisir --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name_fr }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prix (DA) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0" step="0.01"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description (Français)</label>
                <textarea name="description_fr" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description_fr') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description (Anglais)</label>
                <textarea name="description_en" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description_en') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Images</label>
                <input type="file" name="images[]" multiple accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <p class="text-xs text-gray-400 mt-1">Plusieurs images acceptées (max 2Mo chacune)</p>
            </div>

            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="active" value="1" {{ old('active', '1') ? 'checked' : '' }} class="rounded">
                    <span class="text-sm font-medium text-gray-700">Actif</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }} class="rounded">
                    <span class="text-sm font-medium text-gray-700">⭐ Produit vedette</span>
                </label>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-indigo-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-indigo-700 transition">
                    Créer le produit
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
