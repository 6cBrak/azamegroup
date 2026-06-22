@extends('layouts.app')

@section('title', 'Page introuvable - ' . __('app.site_name'))

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-16">
    <div class="text-center max-w-lg">
        <div class="text-9xl font-extrabold text-indigo-100 select-none leading-none">404</div>
        <div class="-mt-8 relative z-10">
            <div class="text-6xl mb-4">🔍</div>
            <h1 class="text-3xl font-bold text-gray-800 mb-3">Page introuvable</h1>
            <p class="text-gray-500 mb-8 text-lg">
                La page que vous cherchez n'existe pas ou a été déplacée.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('home') }}"
                   class="bg-indigo-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-indigo-700 transition">
                    <i class="fas fa-home mr-2"></i> Retour à l'accueil
                </a>
                <a href="{{ route('shop.index') }}"
                   class="border-2 border-indigo-600 text-indigo-600 font-bold px-6 py-3 rounded-xl hover:bg-indigo-50 transition">
                    <i class="fas fa-box mr-2"></i> Voir les produits
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
