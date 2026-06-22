@extends('layouts.app')

@section('title', __('app.cart') . ' - ' . __('app.site_name'))

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">🛒 {{ __('app.cart') }}</h1>

    @if(empty($cart))
        <div class="bg-white rounded-2xl shadow p-16 text-center">
            <i class="fas fa-shopping-cart text-6xl text-gray-200 mb-4"></i>
            <p class="text-gray-400 text-xl mb-6">{{ __('app.empty_cart') }}</p>
            <a href="{{ route('shop.index') }}"
               class="inline-block bg-indigo-600 text-white font-bold px-8 py-3 rounded-xl hover:bg-indigo-700 transition">
                {{ __('app.continue_shopping') }}
            </a>
        </div>
    @else
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Items --}}
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $id => $item)
                <div class="bg-white rounded-xl shadow p-4 flex items-center gap-4">
                    {{-- Image --}}
                    @if($item['image'])
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                    @else
                        <div class="w-20 h-20 bg-indigo-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-image text-indigo-200 text-2xl"></i>
                        </div>
                    @endif

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('shop.show', $item['slug']) }}" class="font-semibold text-gray-800 hover:text-indigo-600 block truncate">
                            {{ $item['name'] }}
                        </a>
                        <p class="text-indigo-600 font-bold">{{ number_format($item['price'], 2) }} F CFA</p>
                    </div>

                    {{-- Quantity --}}
                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                        @csrf @method('PATCH')
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0"
                               class="w-16 border border-gray-300 rounded-lg px-2 py-1 text-center text-sm"
                               onchange="this.form.submit()">
                    </form>

                    {{-- Subtotal --}}
                    <div class="text-right flex-shrink-0">
                        <p class="font-bold text-gray-800">{{ number_format($item['price'] * $item['quantity'], 2) }} F CFA</p>
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600 text-sm mt-1">
                                <i class="fas fa-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach

                <form action="{{ route('cart.clear') }}" method="POST" class="text-right">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600 text-sm">
                        <i class="fas fa-trash-alt"></i> Vider le panier
                    </button>
                </form>
            </div>

            {{-- Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow p-6 sticky top-20">
                    <h2 class="font-bold text-lg text-gray-800 mb-4">Récapitulatif</h2>
                    <div class="border-t pt-4 mb-6">
                        <div class="flex justify-between text-xl font-bold text-indigo-700">
                            <span>{{ __('app.total') }}</span>
                            <span>{{ number_format($total, 2) }} F CFA</span>
                        </div>
                    </div>
                    <a href="{{ route('checkout.index') }}"
                       class="block w-full bg-indigo-600 text-white font-bold py-3 rounded-xl text-center hover:bg-indigo-700 transition">
                        {{ __('app.proceed_checkout') }} →
                    </a>
                    <a href="{{ route('shop.index') }}" class="block text-center text-indigo-600 hover:underline mt-3 text-sm">
                        ← {{ __('app.continue_shopping') }}
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
