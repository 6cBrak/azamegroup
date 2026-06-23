@extends('layouts.admin')

@section('title', 'Commandes')

@section('content')

{{-- Filters --}}
<form method="GET" class="bg-white rounded-xl shadow p-4 mb-5 flex flex-wrap gap-3 items-center">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Réf, nom, téléphone..."
           class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 flex-1 min-w-48">
    <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="">Tous les statuts</option>
        <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>En attente</option>
        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmée</option>
        <option value="shipped"   {{ request('status') === 'shipped'   ? 'selected' : '' }}>Expédiée</option>
        <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Livrée</option>
        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Annulée</option>
    </select>
    <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800">Filtrer</button>
    <a href="{{ route('admin.orders.index') }}" class="border border-gray-300 px-4 py-2 rounded-lg text-sm hover:bg-gray-50">Réinitialiser</a>

    {{-- Export CSV (reprend les filtres actifs) --}}
    <a href="{{ route('admin.orders.export', request()->only('search', 'status')) }}"
       class="ml-auto flex items-center gap-1.5 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        <i class="fas fa-file-csv"></i> Exporter CSV
    </a>
</form>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Référence</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Client</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Téléphone</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Ville</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Total</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Articles</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Statut</th>
                <th class="px-4 py-3 text-left text-gray-500 font-medium">Date</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs text-indigo-700 font-bold">{{ $order->reference }}</td>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $order->customer_name }}</td>
                <td class="px-4 py-3 text-gray-600">{{ $order->customer_phone }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $order->customer_city }}</td>
                <td class="px-4 py-3 font-bold text-indigo-700">{{ number_format($order->total, 2) }} F CFA</td>
                <td class="px-4 py-3 text-center">
                    <span class="bg-gray-100 text-gray-600 text-xs font-medium px-2 py-1 rounded-full">{{ $order->items->count() }}</span>
                </td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs font-medium
                        {{ $order->status === 'pending'   ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $order->status === 'confirmed' ? 'bg-blue-100 text-blue-800'     : '' }}
                        {{ $order->status === 'shipped'   ? 'bg-purple-100 text-purple-800' : '' }}
                        {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800'   : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800'       : '' }}">
                        {{ $order->status_label }}
                    </span>
                </td>
                <td class="px-4 py-3 text-gray-400 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td class="px-4 py-3">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-4 py-12 text-center text-gray-400">Aucune commande</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">
        {{ $orders->withQueryString()->links() }}
    </div>
</div>
@endsection
