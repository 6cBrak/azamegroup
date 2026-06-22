<article class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-shadow duration-300 overflow-hidden group flex flex-col">

    {{-- Image --}}
    <a href="{{ route('shop.show', $product->slug) }}" class="block relative overflow-hidden flex-shrink-0">
        @if($product->getFirstImage())
            <img src="{{ $product->getFirstImage() }}" alt="{{ $product->getName() }}"
                 loading="lazy" width="400" height="280"
                 class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-52 bg-gray-100 flex flex-col items-center justify-center gap-2">
                <i class="fas fa-image text-5xl text-gray-300"></i>
                <span class="text-xs text-gray-400">Aucune photo</span>
            </div>
        @endif

        {{-- Badges --}}
        <div class="absolute top-2 left-2 flex flex-col gap-1">
            @if($product->featured)
                <span class="inline-flex items-center gap-1 bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded-full shadow">
                    <i class="fas fa-star text-yellow-700 text-[10px]"></i> Vedette
                </span>
            @endif
        </div>

        {{-- Rupture de stock --}}
        @if(!$product->isInStock())
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                <span class="bg-red-500 text-white font-bold text-sm px-4 py-2 rounded-lg shadow-lg">
                    {{ __('app.out_of_stock') }}
                </span>
            </div>
        @endif
    </a>

    {{-- Infos --}}
    <div class="p-4 flex flex-col flex-1">
        {{-- Catégorie --}}
        <p class="text-xs font-semibold text-amber-500 uppercase tracking-wide mb-1">
            {{ $product->category?->getName() }}
        </p>

        {{-- Nom --}}
        <h3 class="font-semibold text-gray-800 text-sm leading-snug mb-3 line-clamp-2 flex-1">
            <a href="{{ route('shop.show', $product->slug) }}" class="hover:text-amber-600 transition-colors">
                {{ $product->getName() }}
            </a>
        </h3>

        {{-- Prix + Bouton --}}
        <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-100">
            <span class="text-base font-extrabold text-amber-600">
                {{ number_format($product->price, 0, ',', ' ') }} <span class="text-xs font-semibold text-gray-500">F CFA</span>
            </span>

            @if($product->isInStock())
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit"
                            class="bg-amber-400 hover:bg-amber-500 text-gray-900 font-bold text-sm px-3 py-2 rounded-xl transition-colors duration-200 flex items-center gap-1.5 shadow-sm">
                        <i class="fas fa-cart-plus"></i>
                        <span class="hidden sm:inline text-xs">Ajouter</span>
                    </button>
                </form>
            @else
                <span class="text-xs text-red-400 font-medium">Épuisé</span>
            @endif
        </div>
    </div>

</article>
