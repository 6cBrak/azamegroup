@extends('layouts.app')

@section('title', __('app.checkout') . ' - ' . __('app.site_name'))

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">📦 {{ __('orders.your_order') }}</h1>

    <div class="grid lg:grid-cols-3 gap-8">

        {{-- Form --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="font-bold text-lg text-gray-700 mb-5">Vos informations</h2>
                @if(auth('customer')->check())
                <div class="mb-4 flex items-center gap-2 bg-indigo-50 border border-indigo-200 rounded-xl px-4 py-3 text-sm text-indigo-800">
                    <i class="fas fa-user-circle text-indigo-500"></i>
                    Connecté en tant que <strong>{{ auth('customer')->user()->name }}</strong> —
                    <a href="{{ route('account.dashboard') }}" class="underline hover:text-indigo-600">Mon compte</a>
                </div>
                @endif
                <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('orders.name') }} *</label>
                            <input type="text" name="name" value="{{ old('name', $customer?->name) }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-400 @enderror">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('orders.phone') }} *</label>
                            <input type="tel" name="phone" value="{{ old('phone', $customer?->phone) }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('phone') border-red-400 @enderror">
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('orders.email') }}</label>
                        <input type="email" name="email" value="{{ old('email', $customer?->email) }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('orders.city') }} *</label>
                            <input type="text" name="city" value="{{ old('city', $customer?->city) }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('city') border-red-400 @enderror">
                            @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('orders.address') }} *</label>
                            <input type="text" name="address" value="{{ old('address', $customer?->address) }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('address') border-red-400 @enderror">
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('orders.notes') }}</label>
                        <textarea name="notes" rows="3"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-800">
                        <i class="fab fa-whatsapp text-green-600 text-lg mr-2"></i>
                        Après confirmation, vous serez redirigé vers <strong>WhatsApp</strong> pour finaliser votre commande.
                    </div>

                    <button type="submit"
                            class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl hover:bg-indigo-700 transition text-lg">
                        <i class="fab fa-whatsapp mr-2"></i> {{ __('orders.place_order') }}
                    </button>
                </form>
            </div>

            {{-- Trust badges --}}
            <div class="mt-5 grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
                <div class="bg-white rounded-xl shadow p-3">
                    <i class="fas fa-shield-alt text-2xl text-green-500 mb-1"></i>
                    <p class="text-xs text-gray-600 font-medium">Paiement sécurisé</p>
                </div>
                <div class="bg-white rounded-xl shadow p-3">
                    <i class="fas fa-truck text-2xl text-blue-500 mb-1"></i>
                    <p class="text-xs text-gray-600 font-medium">Livraison rapide</p>
                </div>
                <div class="bg-white rounded-xl shadow p-3">
                    <i class="fas fa-undo-alt text-2xl text-orange-500 mb-1"></i>
                    <p class="text-xs text-gray-600 font-medium">Retour 7 jours</p>
                </div>
                <div class="bg-white rounded-xl shadow p-3">
                    <i class="fab fa-whatsapp text-2xl text-green-600 mb-1"></i>
                    <p class="text-xs text-gray-600 font-medium">Support WhatsApp</p>
                </div>
            </div>
        </div>

        {{-- Order summary --}}
        <div>
            <div class="bg-white rounded-2xl shadow p-5 sticky top-20">
                <h2 class="font-bold text-lg text-gray-700 mb-4">{{ __('orders.your_order') }}</h2>
                <div class="space-y-3 max-h-64 overflow-y-auto pr-1">
                    @foreach($cart as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-700">{{ $item['name'] }} <span class="text-gray-400">×{{ $item['quantity'] }}</span></span>
                        <span class="font-medium">{{ number_format($item['price'] * $item['quantity'], 2) }} F CFA</span>
                    </div>
                    @endforeach
                </div>
                <div class="border-t mt-4 pt-4 flex justify-between font-bold text-indigo-700 text-lg">
                    <span>{{ __('app.total') }}</span>
                    <span>{{ number_format($total, 2) }} F CFA</span>
                </div>

                {{-- Safety note --}}
                <div class="mt-4 text-xs text-gray-400 space-y-1">
                    <p><i class="fas fa-lock text-green-400 mr-1"></i> Vos données sont protégées</p>
                    <p><i class="fas fa-check-circle text-green-400 mr-1"></i> Paiement à la livraison disponible</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
