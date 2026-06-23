@extends('layouts.admin')
@section('title', 'Client : ' . $customer->name)

@section('content')
<div class="max-w-3xl">

    {{-- Info client --}}
    <div class="bg-white rounded-xl shadow p-5 mb-6">
        <div class="flex justify-between items-start">
            <h2 class="font-bold text-gray-700 text-lg mb-4 border-b pb-2 flex-1">
                <i class="fas fa-user-circle mr-2 text-indigo-500"></i>{{ $customer->name }}
            </h2>
            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST"
                  onsubmit="return confirm('Supprimer ce client et toutes ses données ?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-600 text-sm ml-4">
                    <i class="fas fa-trash mr-1"></i> Supprimer
                </button>
            </form>
        </div>
        <dl class="grid grid-cols-2 gap-3 text-sm">
            <div><dt class="text-gray-400">Email</dt><dd class="font-medium">{{ $customer->email }}</dd></div>
            <div><dt class="text-gray-400">Téléphone</dt><dd class="font-medium">{{ $customer->phone ?? '—' }}</dd></div>
            <div><dt class="text-gray-400">Ville</dt><dd class="font-medium">{{ $customer->city ?? '—' }}</dd></div>
            <div><dt class="text-gray-400">Adresse</dt><dd class="font-medium">{{ $customer->address ?? '—' }}</dd></div>
            <div><dt class="text-gray-400">Inscrit le</dt><dd class="font-medium">{{ $customer->created_at->format('d/m/Y H:i') }}</dd></div>
            <div><dt class="text-gray-400">Total commandes</dt><dd class="font-bold text-indigo-700">{{ $orders->count() }}</dd></div>
        </dl>
    </div>

    {{-- Commandes --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="p-4 border-b">
            <h3 class="font-bold text-gray-700">Historique des commandes</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-gray-500 font-medium">Référence</th>
                    <th class="px-4 py-2 text-left text-gray-500 font-medium">Date</th>
                    <th class="px-4 py-2 text-left text-gray-500 font-medium">Articles</th>
                    <th class="px-4 py-2 text-right text-gray-500 font-medium">Total</th>
                    <th class="px-4 py-2 text-left text-gray-500 font-medium">Statut</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr>
                    <td class="px-4 py-3 font-mono text-xs text-indigo-700 font-bold">{{ $order->reference }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">{{ $order->items->count() }}</span>
                    </td>
                    <td class="px-4 py-3 text-right font-bold text-indigo-700">{{ number_format($order->total, 2) }} F CFA</td>
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
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-800">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">Aucune commande</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.customers.index') }}" class="border border-gray-300 px-5 py-2 rounded-lg hover:bg-gray-50 text-gray-700 text-sm">
            ← Retour aux clients
        </a>
    </div>
</div>
@endsection