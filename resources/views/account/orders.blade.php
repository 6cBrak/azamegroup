@extends('layouts.app')

@section('title', 'Mes commandes - ' . __('app.site_name'))

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-extrabold text-gray-800">Mes commandes</h1>
        <a href="{{ route('account.dashboard') }}" class="text-sm text-indigo-600 hover:underline">
            <i class="fas fa-arrow-left mr-1"></i> Tableau de bord
        </a>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-2xl shadow p-16 text-center text-gray-400">
            <i class="fas fa-box-open text-5xl mb-4 text-gray-200"></i>
            <p class="text-lg">Vous n'avez pas encore de commandes.</p>
            <a href="{{ route('shop.index') }}" class="mt-4 inline-block bg-indigo-600 text-white font-bold px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition">
                Découvrir nos produits
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($orders as $order)
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between px-6 py-4 gap-3 border-b border-gray-100">
                    <div class="flex items-center gap-4">
                        <div>
                            <p class="font-bold text-gray-800">{{ $order->reference }}</p>
                            <p class="text-xs text-gray-400">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-700 text-xs font-semibold px-3 py-1.5 rounded-full">
                            {{ $order->status_label }}
                        </span>
                        <span class="font-extrabold text-indigo-700 text-lg">{{ number_format($order->total, 2) }} F CFA</span>
                    </div>
                </div>

                <div class="px-6 py-4">
                    <p class="text-xs text-gray-500 font-medium mb-3 uppercase tracking-wide">Articles</p>
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                        <div class="flex justify-between text-sm text-gray-700">
                            <span>{{ $item->product_name }} <span class="text-gray-400">×{{ $item->quantity }}</span></span>
                            <span class="font-medium">{{ number_format($item->subtotal, 2) }} F CFA</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-100 text-xs text-gray-400 flex flex-wrap gap-x-4">
                        <span><i class="fas fa-map-marker-alt mr-1"></i> {{ $order->customer_city }}, {{ $order->customer_address }}</span>
                        @if($order->notes)
                            <span><i class="fas fa-comment mr-1"></i> {{ $order->notes }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
