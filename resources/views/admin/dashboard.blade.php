@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{-- Stats cards --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-3xl font-bold text-indigo-600">{{ $stats['products'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Produits</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-3xl font-bold text-purple-600">{{ $stats['categories'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Catégories</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-3xl font-bold text-blue-600">{{ $stats['orders'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Commandes</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-2xl font-bold text-green-600">{{ number_format($stats['revenue'], 0) }}</p>
        <p class="text-xs text-gray-500 mt-1">CA (F CFA)</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-3xl font-bold text-yellow-500">{{ $stats['pending'] }}</p>
        <p class="text-xs text-gray-500 mt-1">En attente</p>
    </div>
    <div class="bg-white rounded-xl shadow p-4 text-center">
        <p class="text-3xl font-bold text-red-500">{{ $stats['low_stock'] }}</p>
        <p class="text-xs text-gray-500 mt-1">Stock faible</p>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">

    {{-- Recent orders --}}
    <div class="bg-white rounded-xl shadow">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-gray-700">Dernières commandes</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 text-sm hover:underline">Voir tout</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-500 font-medium">Réf.</th>
                        <th class="px-4 py-2 text-left text-gray-500 font-medium">Client</th>
                        <th class="px-4 py-2 text-left text-gray-500 font-medium">Total</th>
                        <th class="px-4 py-2 text-left text-gray-500 font-medium">Statut</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-mono text-xs">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:underline">
                                {{ $order->reference }}
                            </a>
                        </td>
                        <td class="px-4 py-2">{{ $order->customer_name }}</td>
                        <td class="px-4 py-2 font-medium">{{ number_format($order->total, 2) }} F CFA</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $order->status_color === 'yellow' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status_color === 'blue'   ? 'bg-blue-100 text-blue-800'   : '' }}
                                {{ $order->status_color === 'green'  ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status_color === 'red'    ? 'bg-red-100 text-red-800'     : '' }}
                                {{ $order->status_color === 'purple' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400">Aucune commande</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Low stock --}}
    <div class="bg-white rounded-xl shadow">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="font-bold text-gray-700">⚠️ Stock faible</h3>
            <a href="{{ route('admin.products.index') }}" class="text-indigo-600 text-sm hover:underline">Gérer</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-500 font-medium">Produit</th>
                        <th class="px-4 py-2 text-left text-gray-500 font-medium">Stock</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($lowStockProducts as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:underline">
                                {{ $product->name_fr }}
                            </a>
                        </td>
                        <td class="px-4 py-2">
                            <span class="font-bold {{ $product->stock === 0 ? 'text-red-600' : 'text-yellow-600' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="2" class="px-4 py-8 text-center text-gray-400">✅ Tous les stocks sont OK</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
