@extends('layouts.app')

@section('title', $product->getName() . ' - ' . __('app.site_name'))
@section('meta_description', Str::limit($product->getDescription() ?: $product->getName() . ' — disponible sur ' . config('app.name') . ', votre partenaire à Ouagadougou.', 160))
@section('og_type', 'product')
@section('og_image', $product->getFirstImage() ?? asset('images/og-default.jpg'))

@push('schema')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Product",
    "name": "{{ $product->getName() }}",
    "description": "{{ Str::limit($product->getDescription(), 200) }}",
    "image": "{{ $product->getFirstImage() ?? asset('images/og-default.jpg') }}",
    "sku": "PROD-{{ $product->id }}",
    "brand": { "@@type": "Brand", "name": "{{ config('app.name') }}" },
    "offers": {
        "@@type": "Offer",
        "price": "{{ $product->price }}",
        "priceCurrency": "XOF",
        "availability": "{{ $product->isInStock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "url": "{{ url('/produits/' . $product->slug) }}"
    }
    @if($reviewCount > 0)
    ,"aggregateRating": {
        "@@type": "AggregateRating",
        "ratingValue": "{{ number_format($avgRating, 1) }}",
        "reviewCount": "{{ $reviewCount }}"
    }
    @endif
}
</script>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    {{-- Breadcrumb --}}
    <nav class="text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-amber-600">{{ __('app.home') }}</a>
        <span class="mx-2">/</span>
        <a href="{{ route('shop.index') }}" class="hover:text-amber-600">{{ __('app.products') }}</a>
        @if($product->category)
            <span class="mx-2">/</span>
            <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-amber-600">
                {{ $product->category->getName() }}
            </a>
        @endif
        <span class="mx-2">/</span>
        <span class="text-gray-800">{{ $product->getName() }}</span>
    </nav>

    {{-- Product detail --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8 grid md:grid-cols-2 gap-10">

        {{-- Images --}}
        <div>
            @if($product->images && count($product->images) > 0)
                {{-- Main image with zoom icon --}}
                <div class="relative group cursor-zoom-in" onclick="openLightbox('{{ $product->images[0] }}')">
                    <img src="{{ $product->images[0] }}" alt="{{ $product->getName() }}"
                         id="mainImg"
                         class="w-full h-80 object-cover rounded-xl mb-4 transition-transform duration-300 group-hover:brightness-90">
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                        <span class="bg-black bg-opacity-50 text-white rounded-full w-12 h-12 flex items-center justify-center">
                            <i class="fas fa-search-plus text-lg"></i>
                        </span>
                    </div>
                </div>
                @if(count($product->images) > 1)
                    <div class="flex gap-2 overflow-x-auto pb-1 thumbnail-strip">
                        @foreach($product->images as $img)
                            <img src="{{ $img }}" data-src="{{ $img }}" alt=""
                                 onclick="switchMain('{{ $img }}')"
                                 class="w-20 h-20 flex-shrink-0 object-cover rounded-lg cursor-pointer border-2 border-transparent hover:border-amber-400 transition">
                        @endforeach
                    </div>
                @endif
            @else
                <div class="w-full h-80 bg-gray-100 rounded-xl flex flex-col items-center justify-center gap-3">
                    <i class="fas fa-image text-7xl text-gray-300"></i>
                    <span class="text-sm text-gray-400">Aucune photo disponible</span>
                </div>
            @endif
        </div>

        {{-- Lightbox overlay --}}
        <div id="lightbox" onclick="closeLightbox()"
             class="fixed inset-0 z-50 bg-black bg-opacity-90 hidden items-center justify-center p-4">
            <button onclick="closeLightbox()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300">
                <i class="fas fa-times"></i>
            </button>
            <img id="lightbox-img" src="" alt=""
                 class="max-w-full max-h-screen object-contain rounded-xl shadow-2xl"
                 onclick="event.stopPropagation()">
        </div>

        {{-- Info --}}
        <div>
            <p class="text-amber-500 text-sm font-semibold uppercase tracking-wide mb-2">{{ $product->category?->getName() }}</p>
            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->getName() }}</h1>

            <div class="text-4xl font-extrabold text-amber-600 mb-6">
                {{ number_format($product->price, 0, ',', ' ') }} <span class="text-xl font-semibold text-gray-500">F CFA</span>
            </div>

            @if($product->getDescription())
                <p class="text-gray-600 mb-6 leading-relaxed">{{ $product->getDescription() }}</p>
            @endif

            @if($product->isInStock())
                <p class="text-green-600 font-medium mb-4">
                    <i class="fas fa-check-circle"></i> {{ __('app.in_stock') }}
                    <span class="text-gray-400 text-sm ml-1">({{ $product->stock }} disponibles)</span>
                </p>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex items-center gap-3 mb-4">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}"
                           class="w-20 border border-gray-300 rounded-lg px-3 py-2 text-center focus:outline-none focus:ring-2 focus:ring-amber-400">
                    <button type="submit"
                            class="flex-1 bg-amber-400 hover:bg-amber-500 text-gray-900 font-bold py-3 rounded-xl transition-colors text-center shadow-sm">
                        <i class="fas fa-cart-plus mr-2"></i> {{ __('app.add_to_cart') }}
                    </button>
                </form>
            @else
                <p class="text-red-500 font-medium mb-4">
                    <i class="fas fa-times-circle"></i> {{ __('app.out_of_stock') }}
                </p>
            @endif
        </div>
    </div>

    {{-- Reviews section --}}
    <div class="mt-12 grid md:grid-cols-2 gap-8">

        {{-- Existing reviews --}}
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-star text-yellow-400"></i> Avis clients
                @if($reviewCount)
                    <span class="text-sm font-normal text-gray-500">({{ $reviewCount }} avis — {{ number_format($avgRating, 1) }}/5)</span>
                @endif
            </h2>

            @if($reviews->isEmpty())
                <p class="text-gray-400 text-sm py-4">Aucun avis pour l'instant. Soyez le premier !</p>
            @else
                <div class="space-y-4 max-h-[32rem] overflow-y-auto pr-2">
                    @foreach($reviews as $review)
                    <div class="bg-white rounded-xl shadow p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-semibold text-gray-800 text-sm">{{ $review->author_name }}</span>
                            <div class="flex text-yellow-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                        </div>
                        @if($review->comment)
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $review->comment }}</p>
                        @endif
                        <p class="text-xs text-gray-400 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Review form --}}
        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-4">Laisser un avis</h2>
            <form action="{{ route('reviews.store', $product->id) }}" method="POST"
                  class="bg-white rounded-xl shadow p-5 space-y-4">
                @csrf

                {{-- Star picker --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Note <span class="text-red-500">*</span></label>
                    <div class="flex gap-1 text-2xl" id="star-picker">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" data-val="{{ $i }}"
                                class="star-btn text-gray-300 hover:text-yellow-400 transition focus:outline-none">
                            <i class="fas fa-star"></i>
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                    @error('rating') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Votre nom <span class="text-red-500">*</span></label>
                    <input type="text" name="author_name" value="{{ old('author_name') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                    @error('author_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email (optionnel)</label>
                    <input type="email" name="author_email" value="{{ old('author_email') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Commentaire</label>
                    <textarea name="comment" rows="4"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-amber-400">{{ old('comment') }}</textarea>
                </div>

                <button type="submit"
                        class="w-full bg-amber-400 hover:bg-amber-500 text-gray-900 font-bold py-2.5 rounded-xl transition-colors shadow-sm">
                    <i class="fas fa-paper-plane mr-2"></i> Envoyer mon avis
                </button>
                <p class="text-xs text-gray-400 text-center">Votre avis sera publié après modération.</p>
            </form>
        </div>
    </div>

    {{-- Related products --}}
    @if($related->count())
    <div class="mt-12">
        <h2 class="text-xl font-bold text-gray-800 mb-6">Produits similaires</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($related as $relProd)
                @include('components.product-card', ['product' => $relProd])
            @endforeach
        </div>
    </div>
    @endif

    {{-- Recently viewed --}}
    @if($recentlyViewed->count())
    <div class="mt-12">
        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-history text-amber-400"></i> Récemment consultés
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($recentlyViewed as $viewedProd)
                @include('components.product-card', ['product' => $viewedProd])
            @endforeach
        </div>
    </div>
    @endif

</div>
@push('scripts')
<script>
function switchMain(src) {
    const mainImg = document.getElementById('mainImg');
    mainImg.src = src;
    mainImg.closest('.relative').onclick = function() { openLightbox(src); };
    document.querySelectorAll('.thumbnail-strip img').forEach(img => {
        img.classList.toggle('border-amber-400', img.getAttribute('data-src') === src);
        img.classList.toggle('border-transparent', img.getAttribute('data-src') !== src);
    });
}
function openLightbox(src) {
    document.getElementById('lightbox-img').src = src;
    const lb = document.getElementById('lightbox');
    lb.classList.remove('hidden');
    lb.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    const lb = document.getElementById('lightbox');
    lb.classList.add('hidden');
    lb.classList.remove('flex');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
});

// Star rating picker
(function() {
    const btns = document.querySelectorAll('.star-btn');
    const input = document.getElementById('rating-input');
    let current = parseInt(input.value) || 0;

    function paint(val) {
        btns.forEach((btn, i) => {
            btn.classList.toggle('text-yellow-400', i < val);
            btn.classList.toggle('text-gray-300', i >= val);
        });
    }

    paint(current);

    btns.forEach((btn, i) => {
        btn.addEventListener('mouseenter', () => paint(i + 1));
        btn.addEventListener('mouseleave', () => paint(current));
        btn.addEventListener('click', () => {
            current = i + 1;
            input.value = current;
            paint(current);
        });
    });
})();
</script>
@endpush
@endsection
