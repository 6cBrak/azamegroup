<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO --}}
    <title>@yield('title', __('app.site_name') . ' - ' . __('app.tagline'))</title>
    <meta name="description" content="@yield('meta_description', __('app.tagline'))">
    <meta name="keywords"    content="@yield('meta_keywords', 'boutique en ligne, acheter en ligne, Algérie, livraison')">
    <link rel="canonical"   href="{{ url()->current() }}">

    {{-- Open Graph --}}
    <meta property="og:type"        content="@yield('og_type', 'website')">
    <meta property="og:title"       content="@yield('title', __('app.site_name'))">
    <meta property="og:description" content="@yield('meta_description', __('app.tagline'))">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:image"       content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:site_name"   content="{{ __('app.site_name') }}">
    <meta property="og:locale"      content="{{ app()->getLocale() === 'fr' ? 'fr_FR' : 'en_US' }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('title', __('app.site_name'))">
    <meta name="twitter:description" content="@yield('meta_description', __('app.tagline'))">
    <meta name="twitter:image"       content="@yield('og_image', asset('images/og-default.jpg'))">

    {{-- Schema.org --}}
    @php use App\Models\Setting; @endphp
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "{{ __('app.site_name') }}",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "contactPoint": {
            "@@type": "ContactPoint",
            "telephone": "{{ Setting::get('contact_phone') }}",
            "contactType": "customer service",
            "availableLanguage": ["French", "Arabic"]
        },
        "address": {
            "@@type": "PostalAddress",
            "addressLocality": "{{ Setting::get('contact_city', 'Alger') }}",
            "addressCountry": "DZ"
        },
        "sameAs": [
            "{{ Setting::get('social_facebook') }}",
            "{{ Setting::get('social_instagram') }}"
        ]
    }
    </script>

    @stack('schema')

    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Palette jaune or + noir --}}
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: {
                        50:  '#fffbeb',
                        100: '#fef3c7',
                        200: '#fde68a',
                        300: '#fcd34d',
                        400: '#fbbf24',
                        500: '#f59e0b',
                        600: '#d97706',
                        700: '#b45309',
                        800: '#92400e',
                        900: '#78350f',
                    }
                }
            }
        }
    }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --gold:      #fbbf24;
            --gold-dark: #d97706;
            --black:     #111111;
        }
        /* Remplacement global indigo → or */
        .bg-indigo-600, .bg-indigo-500  { background-color: var(--gold-dark) !important; }
        .bg-indigo-700  { background-color: #b45309 !important; }
        .bg-indigo-50   { background-color: #fffbeb !important; }
        .bg-indigo-100  { background-color: #fef3c7 !important; }
        .text-indigo-600, .text-indigo-500 { color: var(--gold-dark) !important; }
        .text-indigo-700 { color: #b45309 !important; }
        .text-indigo-400 { color: var(--gold) !important; }
        .text-indigo-200 { color: #fde68a !important; }
        .hover\:bg-indigo-700:hover { background-color: #b45309 !important; }
        .hover\:bg-indigo-600:hover { background-color: var(--gold-dark) !important; }
        .hover\:bg-indigo-50:hover  { background-color: #fffbeb !important; }
        .hover\:text-indigo-600:hover { color: var(--gold-dark) !important; }
        .hover\:text-indigo-700:hover { color: #b45309 !important; }
        .focus\:ring-indigo-500:focus { --tw-ring-color: var(--gold) !important; }
        .border-indigo-500, .border-indigo-600 { border-color: var(--gold) !important; }
        .hover\:border-indigo-500:hover { border-color: var(--gold) !important; }
        .ring-indigo-500 { --tw-ring-color: var(--gold) !important; }
        .hover\:text-indigo-800:hover { color: #92400e !important; }
        /* Boutons or (texte noir pour le contraste) */
        .btn-gold {
            background-color: var(--gold);
            color: #111111;
            font-weight: 700;
            transition: background-color .2s;
        }
        .btn-gold:hover { background-color: var(--gold-dark); }
        /* Mobile menu */
        #mobile-menu { display: none; }
        #mobile-menu.open { display: block; }
        /* Surbrillance nav active */
        nav a.active { color: var(--gold) !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

{{-- NAVBAR --}}
<nav class="bg-gray-900 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                @php
                    $siteLogo = Setting::get('site_logo');
                    $hasDefaultLogo = file_exists(public_path('images/logo.png'));
                @endphp
                @if($siteLogo)
                    <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ __('app.site_name') }}"
                         class="h-11 w-auto object-contain">
                @elseif($hasDefaultLogo)
                    <img src="{{ asset('images/logo.png') }}" alt="{{ __('app.site_name') }}"
                         class="h-11 w-auto object-contain">
                @else
                    <span class="text-2xl font-extrabold" style="color:var(--gold)">{{ __('app.site_name') }}</span>
                @endif
            </a>

            {{-- Search (desktop) --}}
            <form action="{{ route('shop.index') }}" method="GET" class="hidden md:flex flex-1 max-w-md mx-6">
                <div class="flex w-full">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="{{ __('app.search') }}"
                           class="flex-1 border border-gray-600 bg-gray-800 text-gray-100 placeholder-gray-400 rounded-l-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    <button type="submit" class="btn-gold px-4 rounded-r-lg">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            {{-- Nav links desktop --}}
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}"     class="hidden md:block text-gray-300 hover:text-yellow-400 font-medium text-sm transition">{{ __('app.home') }}</a>
                <a href="{{ route('shop.index') }}" class="hidden md:block text-gray-300 hover:text-yellow-400 font-medium text-sm transition">{{ __('app.products') }}</a>
                <a href="{{ route('about') }}"    class="hidden md:block text-gray-300 hover:text-yellow-400 font-medium text-sm transition">À propos</a>
                <a href="{{ route('contact') }}"  class="hidden md:block text-gray-300 hover:text-yellow-400 font-medium text-sm transition">Contact</a>

                {{-- Mon compte --}}
                @if(auth('customer')->check())
                <a href="{{ route('account.dashboard') }}"
                   class="hidden md:flex items-center gap-1.5 text-sm text-gray-300 hover:text-yellow-400 font-medium transition">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ auth('customer')->user()->name }}</span>
                </a>
                @else
                <a href="{{ route('account.login') }}"
                   class="hidden md:flex items-center gap-1.5 text-sm text-gray-300 hover:text-yellow-400 font-medium transition">
                    <i class="fas fa-user"></i> Connexion
                </a>
                @endif

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="relative flex items-center gap-1 text-gray-300 hover:text-yellow-400 transition">
                    <i class="fas fa-shopping-cart text-xl"></i>
                    @if(count(session('cart', [])) > 0)
                        <span class="absolute -top-2 -right-2 text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold text-gray-900" style="background:var(--gold)">
                            {{ count(session('cart', [])) }}
                        </span>
                    @endif
                </a>

                {{-- Language switch --}}
                <a href="{{ route('lang.switch', app()->getLocale() === 'fr' ? 'en' : 'fr') }}"
                   class="hidden md:inline-block text-xs border border-gray-600 rounded px-2 py-1 hover:border-yellow-400 hover:text-yellow-400 text-gray-400 transition">
                    {{ __('app.lang_switch') }}
                </a>

                {{-- Hamburger mobile --}}
                <button id="hamburger" onclick="toggleMenu()"
                        class="md:hidden flex flex-col justify-center items-center w-8 h-8 gap-1.5 focus:outline-none">
                    <span class="block w-6 h-0.5 bg-gray-300 transition-all duration-300"></span>
                    <span class="block w-6 h-0.5 bg-gray-300 transition-all duration-300"></span>
                    <span class="block w-6 h-0.5 bg-gray-300 transition-all duration-300"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="md:hidden bg-gray-800 border-t border-gray-700">
        <div class="px-4 pt-3 pb-2">
            <form action="{{ route('shop.index') }}" method="GET" class="flex">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="{{ __('app.search') }}"
                       class="flex-1 bg-gray-700 border border-gray-600 text-gray-100 placeholder-gray-400 rounded-l-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">
                <button type="submit" class="btn-gold px-4 rounded-r-lg">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <nav class="px-4 pb-4 space-y-1">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-yellow-400 font-medium transition">
                <i class="fas fa-home w-4 text-yellow-500"></i> {{ __('app.home') }}
            </a>
            <a href="{{ route('shop.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-yellow-400 font-medium transition">
                <i class="fas fa-box w-4 text-yellow-500"></i> {{ __('app.products') }}
            </a>
            <a href="{{ route('about') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-yellow-400 font-medium transition">
                <i class="fas fa-info-circle w-4 text-yellow-500"></i> À propos
            </a>
            <a href="{{ route('contact') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-yellow-400 font-medium transition">
                <i class="fas fa-envelope w-4 text-yellow-500"></i> Contact
            </a>
            @if(auth('customer')->check())
            <a href="{{ route('account.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-yellow-400 font-medium transition">
                <i class="fas fa-user-circle w-4 text-yellow-500"></i> Mon compte
            </a>
            @else
            <a href="{{ route('account.login') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-yellow-400 font-medium transition">
                <i class="fas fa-user w-4 text-yellow-500"></i> Connexion
            </a>
            @endif
            <div class="border-t border-gray-700 pt-2 mt-2">
                <a href="{{ route('lang.switch', app()->getLocale() === 'fr' ? 'en' : 'fr') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-gray-400 hover:bg-gray-700 text-sm transition">
                    <i class="fas fa-globe w-4"></i> {{ __('app.lang_switch') }}
                </a>
            </div>
        </nav>
    </div>
</nav>

{{-- Flash messages --}}
@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 font-bold ml-4">×</button>
        </div>
    </div>
@endif
@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 mt-4">
        <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded flex justify-between items-center">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 font-bold ml-4">×</button>
        </div>
    </div>
@endif

{{-- Main content --}}
<main class="min-h-screen">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="bg-gray-900 text-gray-400 mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            @if($hasDefaultLogo ?? false)
                <img src="{{ asset('images/logo.png') }}" alt="{{ __('app.site_name') }}" class="h-14 w-auto object-contain mb-3 brightness-100">
            @else
                <h3 class="font-extrabold text-xl mb-3" style="color:var(--gold)">{{ __('app.site_name') }}</h3>
            @endif
            <p class="text-sm text-gray-500">{{ __('app.tagline') }}</p>
        </div>
        <div>
            <h3 class="font-bold text-lg mb-4" style="color:var(--gold)">Navigation</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('home') }}"      class="hover:text-yellow-400 transition">{{ __('app.home') }}</a></li>
                <li><a href="{{ route('shop.index') }}" class="hover:text-yellow-400 transition">{{ __('app.products') }}</a></li>
                <li><a href="{{ route('about') }}"     class="hover:text-yellow-400 transition">À propos</a></li>
                <li><a href="{{ route('contact') }}"   class="hover:text-yellow-400 transition">Contact</a></li>
                <li><a href="{{ route('faq') }}"       class="hover:text-yellow-400 transition">FAQ</a></li>
                <li><a href="{{ route('cart.index') }}" class="hover:text-yellow-400 transition">{{ __('app.cart') }}</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-bold text-lg mb-4" style="color:var(--gold)">Contact</h3>
            <p class="text-sm mb-1"><i class="fas fa-phone mr-2 text-yellow-500"></i> {{ Setting::get('contact_phone') }}</p>
            <p class="text-sm mb-3"><i class="fas fa-map-marker-alt mr-2 text-yellow-500"></i> {{ Setting::get('contact_city', 'Algérie') }}</p>
            <div class="flex gap-4 mt-3">
                @if(Setting::get('social_facebook'))
                <a href="{{ Setting::get('social_facebook') }}" target="_blank" class="text-gray-500 hover:text-yellow-400 text-xl transition"><i class="fab fa-facebook"></i></a>
                @endif
                @if(Setting::get('social_instagram'))
                <a href="{{ Setting::get('social_instagram') }}" target="_blank" class="text-gray-500 hover:text-yellow-400 text-xl transition"><i class="fab fa-instagram"></i></a>
                @endif
                @if(Setting::get('whatsapp_number'))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', Setting::get('whatsapp_number')) }}" target="_blank" class="text-gray-500 hover:text-yellow-400 text-xl transition"><i class="fab fa-whatsapp"></i></a>
                @endif
            </div>
        </div>
    </div>
    <div class="border-t border-gray-800 py-4 px-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-600">
        <span>&copy; {{ date('Y') }} {{ __('app.site_name') }}. Tous droits réservés.</span>
        <div class="flex gap-4">
            <a href="{{ route('faq') }}"     class="hover:text-yellow-400 transition">FAQ</a>
            <a href="{{ route('cgu') }}"     class="hover:text-yellow-400 transition">CGU</a>
            <a href="{{ route('privacy') }}" class="hover:text-yellow-400 transition">Confidentialité</a>
        </div>
    </div>
</footer>

@stack('scripts')
<script>
function toggleMenu() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('open');
}
document.addEventListener('click', function(e) {
    const menu = document.getElementById('mobile-menu');
    const btn  = document.getElementById('hamburger');
    if (menu && btn && !menu.contains(e.target) && !btn.contains(e.target)) {
        menu.classList.remove('open');
    }
});
</script>
</body>
</html>
