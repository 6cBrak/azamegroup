@extends('layouts.admin')

@section('title', 'Modifier : ' . $category->name_fr)

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom (Français) *</label>
                    <input type="text" name="name_fr" value="{{ old('name_fr', $category->name_fr) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom (Anglais) *</label>
                    <input type="text" name="name_en" value="{{ old('name_en', $category->name_en) }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie parente</label>
                    <select name="parent_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Aucune --</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name_fr }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ordre d'affichage</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            @if($category->image)
                <div>
                    <p class="text-sm text-gray-500 mb-1">Image actuelle :</p>
                    <img src="{{ $category->image }}" class="w-20 h-20 object-cover rounded-lg border">
                </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nouvelle image</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="active" value="1" {{ old('active', $category->active) ? 'checked' : '' }} class="rounded">
                <span class="text-sm font-medium text-gray-700">Catégorie active</span>
            </label>
            <div class="flex gap-3">
                <button type="submit" class="bg-indigo-600 text-white font-bold px-6 py-2 rounded-xl hover:bg-indigo-700 transition">
                    Enregistrer
                </button>
                <a href="{{ route('admin.categories.index') }}" class="border border-gray-300 px-6 py-2 rounded-xl hover:bg-gray-50 text-gray-700">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
