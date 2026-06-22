@extends('layouts.app')

@section('title', __('orders.success_title') . ' - ' . __('app.site_name'))

@section('content')
<div class="max-w-2xl mx-auto px-4 py-16 text-center">
    <div class="bg-white rounded-3xl shadow-lg p-10">
        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-check text-green-600 text-4xl"></i>
        </div>
        <h1 class="text-3xl font-extrabold text-gray-800 mb-3">{{ __('orders.success_title') }}</h1>
        <p class="text-gray-500 mb-2">{{ __('orders.success_msg') }}</p>
        <p class="text-indigo-600 font-mono font-bold text-lg mb-8">{{ $order->reference }}</p>

        <a href="{{ $whatsappUrl }}" target="_blank"
           class="inline-flex items-center gap-3 bg-green-500 hover:bg-green-600 text-white font-bold px-8 py-4 rounded-2xl text-lg transition shadow-lg">
            <i class="fab fa-whatsapp text-2xl"></i>
            {{ __('orders.whatsapp_btn') }}
        </a>

        <div class="mt-8 text-sm text-gray-400">
            <p>Référence: <strong>{{ $order->reference }}</strong></p>
            <p>Total: <strong>{{ number_format($order->total, 2) }} F CFA</strong></p>
        </div>

        <a href="{{ route('home') }}" class="block mt-6 text-indigo-600 hover:underline">
            ← Retour à l'accueil
        </a>
    </div>
</div>
@endsection
