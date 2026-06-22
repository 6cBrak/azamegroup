@extends('layouts.admin')

@section('title', 'Commande ' . $order->reference)

@section('content')
<div class="max-w-3xl">
    <div class="grid sm:grid-cols-2 gap-6 mb-6">

        {{-- Order info --}}
        <div class="bg-white rounded-xl shadow p-5">
            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Informations client</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500">Nom</dt><dd class="font-medium">{{ $order->customer_name }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Téléphone</dt><dd class="font-medium">{{ $order->customer_phone }}</dd></div>
                @if($order->customer_email)
                <div class="flex justify-between"><dt class="text-gray-500">Email</dt><dd>{{ $order->customer_email }}</dd></div>
                @endif
                <div class="flex justify-between"><dt class="text-gray-500">Ville</dt><dd>{{ $order->customer_city }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Adresse</dt><dd class="text-right max-w-48">{{ $order->customer_address }}</dd></div>
                @if($order->notes)
                <div class="flex justify-between"><dt class="text-gray-500">Notes</dt><dd class="text-right max-w-48 text-gray-600 italic">{{ $order->notes }}</dd></div>
                @endif
            </dl>
        </div>

        {{-- Status --}}
        <div class="bg-white rounded-xl shadow p-5">
            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Statut de la commande</h3>
            <p class="text-sm text-gray-500 mb-1">Référence : <span class="font-mono font-bold text-gray-800">{{ $order->reference }}</span></p>
            <p class="text-sm text-gray-500 mb-4">Date : {{ $order->created_at->format('d/m/Y H:i') }}</p>

            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-3">
                @csrf @method('PUT')
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="pending"   {{ $order->status === 'pending'   ? 'selected' : '' }}>En attente</option>
                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                    <option value="shipped"   {{ $order->status === 'shipped'   ? 'selected' : '' }}>Expédiée</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Livrée</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                </select>
                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                    Mettre à jour
                </button>
            </form>

            <div class="mt-4 pt-4 border-t">
                <p class="text-lg font-bold text-indigo-700">Total : {{ number_format($order->total, 2) }} F CFA</p>
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="p-4 border-b">
            <h3 class="font-bold text-gray-700">Articles commandés</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-gray-500 font-medium">Produit</th>
                    <th class="px-4 py-2 text-center text-gray-500 font-medium">Qté</th>
                    <th class="px-4 py-2 text-right text-gray-500 font-medium">Prix unit.</th>
                    <th class="px-4 py-2 text-right text-gray-500 font-medium">Sous-total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($order->items as $item)
                <tr>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $item->product_name }}</td>
                    <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                    <td class="px-4 py-3 text-right text-gray-600">{{ number_format($item->unit_price, 2) }} F CFA</td>
                    <td class="px-4 py-3 text-right font-bold text-indigo-700">{{ number_format($item->subtotal, 2) }} F CFA</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 border-t">
                <tr>
                    <td colspan="3" class="px-4 py-3 text-right font-bold text-gray-700">TOTAL</td>
                    <td class="px-4 py-3 text-right font-extrabold text-indigo-700 text-lg">{{ number_format($order->total, 2) }} F CFA</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="mt-4 flex gap-3">
        <a href="{{ route('admin.orders.index') }}" class="border border-gray-300 px-5 py-2 rounded-lg hover:bg-gray-50 text-gray-700 text-sm">
            ← Retour aux commandes
        </a>
        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST"
              onsubmit="return confirm('Supprimer définitivement cette commande ?')">
            @csrf @method('DELETE')
            <button type="submit" class="bg-red-50 text-red-600 border border-red-200 px-5 py-2 rounded-lg hover:bg-red-100 text-sm">
                <i class="fas fa-trash mr-1"></i> Supprimer
            </button>
        </form>
    </div>
</div>
@endsection
