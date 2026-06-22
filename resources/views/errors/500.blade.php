@extends('layouts.app')

@section('title', 'Erreur serveur - ' . __('app.site_name'))

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-16">
    <div class="text-center max-w-lg">
        <div class="text-9xl font-extrabold text-red-100 select-none leading-none">500</div>
        <div class="-mt-8 relative z-10">
            <div class="text-6xl mb-4">⚙️</div>
            <h1 class="text-3xl font-bold text-gray-800 mb-3">Erreur serveur</h1>
            <p class="text-gray-500 mb-8">Une erreur inattendue s'est produite. Réessayez dans quelques instants.</p>
            <a href="{{ route('home') }}"
               class="bg-indigo-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-indigo-700 transition">
                <i class="fas fa-home mr-2"></i> Retour à l'accueil
            </a>
        </div>
    </div>
</div>
@endsection
