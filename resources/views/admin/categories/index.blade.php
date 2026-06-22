@extends('layouts.admin')

@section('title', 'Catégories')

@section('header-actions')
    <a href="{{ route('admin.categories.create') }}"
       class="bg-indigo-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
        + Nouvelle catégorie
    </a>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Image</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Nom FR</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Nom EN</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Parent</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Produits</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Statut</th>
                <th class="px-4 py-3 text-right text-gray-500 font-medium">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($categories as $cat)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    @if($cat->image)
                        <img src="{{ $cat->image }}" class="w-10 h-10 object-cover rounded-full">
                    @else
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-tag text-indigo-400 text-xs"></i>
                        </div>
                    @endif
                </td>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $cat->name_fr }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $cat->name_en }}</td>
                <td class="px-4 py-3 text-gray-400 text-xs">{{ $cat->parent?->name_fr ?? '-' }}</td>
                <td class="px-4 py-3 text-center">
                    <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-1 rounded-full">{{ $cat->products_count }}</span>
                </td>
                <td class="px-4 py-3">
                    @if($cat->active)
                        <span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-1 rounded-full">Actif</span>
                    @else
                        <span class="bg-gray-100 text-gray-500 text-xs font-medium px-2 py-1 rounded-full">Inactif</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin.categories.edit', $cat) }}" class="text-indigo-600 hover:text-indigo-800 mr-3"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="inline"
                          onsubmit="return confirm('Supprimer cette catégorie ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-12 text-center text-gray-400">
                    Aucune catégorie.
                    <a href="{{ route('admin.categories.create') }}" class="text-indigo-600 hover:underline ml-1">Créer la première</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
