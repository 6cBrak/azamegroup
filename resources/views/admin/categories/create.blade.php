@extends('layouts.admin')

@section('title', 'Nouvelle catégorie')

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom (Français) *</label>
                    <input type="text" name="name_fr" value="{{ old('name_fr') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom (Anglais) *</label>
                    <input type="text" name="name_en" value="{{ old('name_en') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie parente</label>
                    <select name="parent_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Aucune (catégorie racine) --</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name_fr }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ordre d'affichage</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                <input type="file" name="image" accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="active" value="1" {{ old('active', '1') ? 'checked' : '' }} class="rounded">
                <span class="text-sm font-medium text-gray-700">Catégorie active</span>
            </label>
            <div class="flex gap-3">
                <button type="submit" class="bg-indigo-600 text-white font-bold px-6 py-2 rounded-xl hover:bg-indigo-700 transition">
                    Créer
                </button>
                <a href="{{ route('admin.categories.index') }}" class="border border-gray-300 px-6 py-2 rounded-xl hover:bg-gray-50 text-gray-700">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
