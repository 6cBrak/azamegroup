@extends('layouts.app')

@section('title', __('app.products') . ' - ' . __('app.site_name'))
@section('meta_description', 'Explorez notre catalogue de produits — ' . __('app.site_name') . '. Matériaux de construction et énergie, prix en F CFA.')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- Sidebar filtres --}}
        <aside class="lg:w-64 flex-shrink-0">
            <form method="GET" action="{{ route('shop.index') }}" id="filter-form">
            <div class="bg-white rounded-2xl shadow-sm p-5 lg:sticky lg:top-20 space-y-6">

                {{-- Catégories --}}
                <div>
                    <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider mb-3">{{ __('app.categories') }}</h3>
                    <ul class="space-y-0.5">
                        <li>
                            <label class="flex items-center gap-2 px-3 py-2 rounded-xl cursor-pointer transition-colors text-sm
                                {{ !request('category') ? 'bg-amber-50 text-amber-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                                <input type="radio" name="category" value="" onchange="this.form.submit()"
                                       {{ !request('category') ? 'checked' : '' }} class="accent-amber-500">
                                {{ __('app.all_categories') }}
                            </label>
                        </li>
                        @foreach($categories as $cat)
                        <li>
                            <label class="flex items-center gap-2 px-3 py-2 rounded-xl cursor-pointer transition-colors text-sm
                                {{ request('category') === $cat->slug ? 'bg-amber-50 text-amber-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                                <input type="radio" name="category" value="{{ $cat->slug }}" onchange="this.form.submit()"
                                       {{ request('category') === $cat->slug ? 'checked' : '' }} class="accent-amber-500">
                                {{ $cat->getName() }}
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Prix --}}
                <div class="border-t border-gray-100 pt-5">
                    <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider mb-3">Prix (F CFA)</h3>
                    <div class="flex gap-2 items-center">
                        <input type="number" name="price_min" value="{{ request('price_min') }}"
                               placeholder="Min" min="0"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        <span class="text-gray-300 font-bold">–</span>
                        <input type="number" name="price_max" value="{{ request('price_max') }}"
                               placeholder="Max" min="0"
                               class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                    </div>
                    <button type="submit"
                            class="mt-3 w-full bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold py-2 rounded-xl transition-colors">
                        Appliquer
                    </button>
                </div>

                {{-- Disponibilité --}}
                <div class="border-t border-gray-100 pt-5">
                    <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider mb-3">Disponibilité</h3>
                    <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-600">
                        <input type="checkbox" name="in_stock" value="1" onchange="this.form.submit()"
                               {{ request('in_stock') ? 'checked' : '' }}
                               class="rounded accent-amber-500 w-4 h-4">
                        En stock uniquement
                    </label>
                </div>

                {{-- Réinitialiser --}}
                @if(request()->hasAny(['category','price_min','price_max','in_stock','search']))
                <div class="border-t border-gray-100 pt-3">
                    <a href="{{ route('shop.index') }}"
                       class="text-xs text-amber-600 hover:text-amber-700 font-medium flex items-center gap-1 transition-colors">
                        <i class="fas fa-times-circle"></i> Réinitialiser les filtres
                    </a>
                </div>
                @endif

                {{-- Champs cachés --}}
                @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
            </div>
            </form>
        </aside>

        {{-- Produits --}}
        <div class="flex-1 min-w-0">

            {{-- Toolbar --}}
            <div class="flex flex-wrap items-center justify-between mb-6 gap-3">
                <p class="text-gray-500 text-sm">
                    <span class="font-semibold text-gray-800">{{ $products->total() }}</span> produit(s) trouvé(s)
                </p>
                <form method="GET" action="{{ route('shop.index') }}" class="flex items-center gap-2">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('search'))   <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    <select name="sort" onchange="this.form.submit()"
                            class="border border-gray-200 rounded-xl px-4 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent cursor-pointer">
                        <option value="">Trier par défaut</option>
                        <option value="price_asc"  {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>Prix croissant</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                        <option value="newest"     {{ request('sort') === 'newest'     ? 'selected' : '' }}>Nouveautés</option>
                    </select>
                </form>
            </div>

            @if($products->isEmpty())
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-3xl text-gray-300"></i>
                    </div>
                    <p class="text-gray-400 text-lg font-medium">Aucun produit trouvé.</p>
                    <a href="{{ route('shop.index') }}"
                       class="mt-4 inline-block bg-amber-400 hover:bg-amber-500 text-gray-900 font-bold px-5 py-2 rounded-xl transition-colors text-sm">
                        Voir tous les produits
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-5">
                    @foreach($products as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
