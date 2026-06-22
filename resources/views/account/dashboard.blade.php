@extends('layouts.app')

@section('title', 'Mon compte - ' . __('app.site_name'))

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">

    {{-- En-tête --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-800">Bonjour, {{ $customer->name }}</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $customer->email }}</p>
        </div>
        <form action="{{ route('account.logout') }}" method="POST">
            @csrf
            <button type="submit" class="flex items-center gap-2 border border-gray-300 text-gray-600 px-4 py-2 rounded-xl hover:bg-gray-50 text-sm transition">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
        </form>
    </div>

    <div class="grid md:grid-cols-3 gap-6">

        {{-- Sidebar navigation --}}
        <div class="space-y-2">
            <a href="{{ route('account.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('account.dashboard') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-indigo-50' }} shadow text-sm font-medium transition">
                <i class="fas fa-tachometer-alt w-4"></i> Tableau de bord
            </a>
            <a href="{{ route('account.orders') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl {{ request()->routeIs('account.orders') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-indigo-50' }} shadow text-sm font-medium transition">
                <i class="fas fa-box w-4"></i> Mes commandes
            </a>
            <a href="{{ route('shop.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white text-gray-700 hover:bg-indigo-50 shadow text-sm font-medium transition">
                <i class="fas fa-shopping-bag w-4"></i> Continuer mes achats
            </a>
        </div>

        {{-- Main content --}}
        <div class="md:col-span-2 space-y-6">

            {{-- Commandes récentes --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-bold text-gray-800 text-lg">Commandes récentes</h2>
                    <a href="{{ route('account.orders') }}" class="text-sm text-indigo-600 hover:underline">Tout voir</a>
                </div>

                @if($recentOrders->isEmpty())
                    <div class="text-center py-8 text-gray-400">
                        <i class="fas fa-box-open text-4xl mb-3"></i>
                        <p>Aucune commande pour l'instant.</p>
                        <a href="{{ route('shop.index') }}" class="mt-3 inline-block bg-indigo-600 text-white px-4 py-2 rounded-xl text-sm hover:bg-indigo-700 transition">
                            Découvrir nos produits
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentOrders as $order)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl text-sm">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $order->reference }}</p>
                                <p class="text-gray-400 text-xs">{{ $order->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-block bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-700 text-xs px-2 py-0.5 rounded-full font-medium">
                                    {{ $order->status_label }}
                                </span>
                                <p class="font-bold text-indigo-700 mt-1">{{ number_format($order->total, 2) }} F CFA</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Informations du profil --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="font-bold text-gray-800 text-lg mb-4">Mes informations</h2>
                <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                            <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                            <input type="tel" name="phone" value="{{ old('phone', $customer->phone) }}"
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                            <input type="text" name="city" value="{{ old('city', $customer->city) }}"
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                            <input type="text" name="address" value="{{ old('address', $customer->address) }}"
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white font-bold px-5 py-2 rounded-xl hover:bg-indigo-700 transition text-sm">
                            <i class="fas fa-save mr-1"></i> Sauvegarder
                        </button>
                    </div>
                </form>
            </div>

            {{-- Changer mot de passe --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <h2 class="font-bold text-gray-800 text-lg mb-4">Changer le mot de passe</h2>
                <form action="{{ route('account.password.update') }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mot de passe actuel</label>
                        <input type="password" name="current_password" required
                               class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('current_password') border-red-400 @enderror">
                        @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nouveau mot de passe</label>
                            <input type="password" name="password" required minlength="8"
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirmer</label>
                            <input type="password" name="password_confirmation" required
                                   class="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-gray-700 text-white font-bold px-5 py-2 rounded-xl hover:bg-gray-800 transition text-sm">
                            <i class="fas fa-key mr-1"></i> Modifier le mot de passe
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
