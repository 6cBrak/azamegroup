@extends('layouts.admin')
@section('title', 'Clients')

@section('content')

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-800 rounded-lg px-4 py-3 mb-5">
    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
</div>
@endif

{{-- Filtres --}}
<form method="GET" class="bg-white rounded-xl shadow p-4 mb-5 flex flex-wrap gap-3 items-center">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, email, téléphone..."
           class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 flex-1 min-w-48">
    <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800">Filtrer</button>
    <a href="{{ route('admin.customers.index') }}" class="border border-gray-300 px-4 py-2 rounded-lg text-sm hover:bg-gray-50">Réinitialiser</a>
    <span class="ml-auto text-sm text-gray-500">{{ $customers->total() }} client(s)</span>
</form>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Nom</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Email</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Téléphone</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Ville</th>
                <th class="px-4 py-3 text-center text-gray-500 font-medium">Commandes</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Inscrit le</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($customers as $customer)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium text-gray-800">{{ $customer->name }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $customer->email }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $customer->phone ?? '—' }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $customer->city ?? '—' }}</td>
                <td class="px-4 py-3 text-center">
                    <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2 py-1 rounded-full">
                        {{ $customer->orders_count }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-400 text-xs">{{ $customer->created_at->format('d/m/Y') }}</td>
                <td class="px-4 py-3 flex items-center gap-3">
                    <a href="{{ route('admin.customers.show', $customer) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                    <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST"
                          onsubmit="return confirm('Supprimer ce client et ses données ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 text-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-12 text-center text-gray-400">Aucun client inscrit</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">
        {{ $customers->withQueryString()->links() }}
    </div>
</div>
@endsection