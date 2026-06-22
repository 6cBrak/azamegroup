@extends('layouts.app')

@section('title', __('app.site_name') . ' - ' . __('app.tagline'))
@section('meta_description', 'Découvrez ' . __('app.site_name') . ' — boutique en ligne multi-catégories avec livraison rapide partout en Algérie. Commandez facilement via WhatsApp.')

@section('content')

{{-- Hero Banner --}}
@php
use App\Models\Setting;
$heroSlogan = app()->getLocale() === 'en'
    ? Setting::get('company_slogan_en', Setting::get('company_slogan'))
    : Setting::get('company_slogan', 'Votre partenaire stratégique pour des opportunités sans frontières.');
$heroMotto  = app()->getLocale() === 'en'
    ? Setting::get('company_motto_en', Setting::get('company_motto'))
    : Setting::get('company_motto', 'CONNECTER • DÉVELOPPER • RÉUSSIR');
@endphp

<section class="relative overflow-hidden" style="background:#111111; min-height:320px;">

    {{-- Cercles décoratifs --}}
    <div class="absolute top-0 right-0 w-96 h-96 rounded-full opacity-10"
         style="background:radial-gradient(circle, #fbbf24, transparent); transform:translate(30%, -30%)"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 rounded-full opacity-10"
         style="background:radial-gradient(circle, #fbbf24, transparent); transform:translate(-30%, 30%)"></div>
    {{-- Ligne diagonale déco --}}
    <div class="absolute inset-0 opacity-5"
         style="background:repeating-linear-gradient(45deg, #fbbf24 0px, #fbbf24 1px, transparent 1px, transparent 60px)"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-4 py-10 text-center">

        {{-- Badge --}}
        <div class="inline-flex items-center gap-2 border border-yellow-500 text-yellow-400 text-xs font-bold px-4 py-1.5 rounded-full mb-8 tracking-widest uppercase">
            <span class="w-2 h-2 rounded-full bg-yellow-400 animate-pulse"></span>
            Sourcing International · Afrique · Asie · Europe
        </div>

        {{-- Titre --}}
        <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-4 leading-tight">
            {{ Setting::get('site_name', 'AZAM GROUP') }}
        </h1>

        {{-- Slogan --}}
        @if($heroSlogan)
        <p class="text-lg md:text-xl text-gray-400 max-w-2xl mx-auto mb-6">
            {{ $heroSlogan }}
        </p>
        @endif

        {{-- Motto --}}
        @if($heroMotto)
        <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
            @foreach(explode('•', $heroMotto) as $part)
                @if(trim($part))
                <span class="text-sm font-extrabold tracking-widest uppercase px-4 py-1.5 rounded-full"
                      style="background:rgba(251,191,36,0.12); color:#fbbf24; border:1px solid rgba(251,191,36,0.3)">
                    {{ trim($part) }}
                </span>
                @endif
            @endforeach
        </div>
        @endif

        {{-- CTA --}}
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('shop.index') }}"
               class="inline-flex items-center gap-2 font-extrabold px-8 py-3.5 rounded-xl text-gray-900 transition hover:brightness-110 shadow-lg"
               style="background:#fbbf24">
                <i class="fas fa-box-open"></i> Voir nos produits
            </a>
            <a href="{{ route('contact') }}"
               class="inline-flex items-center gap-2 font-bold px-8 py-3.5 rounded-xl text-white transition border border-gray-600 hover:border-yellow-500 hover:text-yellow-400">
                <i class="fas fa-envelope"></i> Nous contacter
            </a>
        </div>

        {{-- Stats --}}
        <div class="flex flex-wrap justify-center gap-8 mt-8 pt-6 border-t border-gray-800">
            @foreach([
                ['value'=>'3+',    'label'=> app()->getLocale()==='en' ? 'Continents' : 'Continents'],
                ['value'=>'100%',  'label'=> app()->getLocale()==='en' ? 'Commitment' : 'Engagement client'],
                ['value'=>'B2B',   'label'=> app()->getLocale()==='en' ? 'Custom solutions' : 'Solutions sur mesure'],
                ['value'=>'Pan-AF','label'=> app()->getLocale()==='en' ? 'Pan-African network' : 'Réseau pan-africain'],
            ] as $stat)
            <div class="text-center">
                <div class="text-2xl font-extrabold" style="color:#fbbf24">{{ $stat['value'] }}</div>
                <div class="text-xs text-gray-500 mt-1 uppercase tracking-wide">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Categories --}}
@if($categories->count())
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __('app.categories') }}</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($categories as $cat)
            <a href="{{ route('shop.index', ['category' => $cat->slug]) }}"
               class="bg-white rounded-xl shadow hover:shadow-md transition p-4 text-center hover:bg-indigo-50">
                @if($cat->image)
                    <img src="{{ $cat->image }}" alt="{{ $cat->getName() }}" class="w-12 h-12 object-cover rounded-full mx-auto mb-2">
                @else
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-2">
                        <i class="fas fa-tag text-indigo-600"></i>
                    </div>
                @endif
                <p class="text-sm font-medium text-gray-700">{{ $cat->getName() }}</p>
                <p class="text-xs text-gray-400">{{ $cat->products_count }} articles</p>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Featured Products --}}
@if($featuredProducts->count())
<section class="py-12 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">⭐ {{ __('app.featured') }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- New arrivals --}}
@if($newProducts->count())
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">🆕 {{ __('app.new_arrivals') }}</h2>
            <a href="{{ route('shop.index', ['sort' => 'newest']) }}" class="text-indigo-600 hover:underline text-sm">Voir tout →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($newProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
