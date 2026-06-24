<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO --}}
    <title>@yield('title', __('app.site_name') . ' - ' . __('app.tagline'))</title>
    <meta name="description" content="@yield('meta_description', __('app.tagline'))">
    <meta name="keywords"    content="@yield('meta_keywords', 'matériaux construction Ouagadougou, énergie solaire Burkina Faso, sourcing import Afrique, AZAM GROUP')">
    <meta name="robots"      content="index, follow">
    <meta name="author"      content="AZAM GROUP">
    <link rel="canonical"    href="{{ url()->current() }}">

    {{-- Hreflang bilingue FR/EN --}}
    <link rel="alternate" hreflang="fr"      href="{{ url()->current() }}">
    <link rel="alternate" hreflang="en"      href="{{ url()->current() }}">
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}">

    {{-- Open Graph --}}
    <meta property="og:type"        content="@yield('og_type', 'website')">
    <meta property="og:title"       content="@yield('title', __('app.site_name'))">
    <meta property="og:description" content="@yield('meta_description', __('app.tagline'))">
    <meta property="og:url"         content="{{ url()->current() }}">
    <meta property="og:image"       content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:site_name"   content="{{ __('app.site_name') }}">
    <meta property="og:locale"      content="{{ app()->getLocale() === 'fr' ? 'fr_BF' : 'en_US' }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="@yield('title', __('app.site_name'))">
    <meta name="twitter:description" content="@yield('meta_description', __('app.tagline'))">
    <meta name="twitter:image"       content="@yield('og_image', asset('images/og-default.jpg'))">

    {{-- Vérification Google / Bing (configurable depuis /admin/parametres) --}}
    @php use App\Models\Setting; @endphp
    @if(Setting::get('google_verification'))
    <meta name="google-site-verification" content="{{ Setting::get('google_verification') }}">
    @endif
    @if(Setting::get('bing_verification'))
    <meta name="msvalidate.01" content="{{ Setting::get('bing_verification') }}">
    @endif

    {{-- Schema.org LocalBusiness --}}
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "LocalBusiness",
        "name": "{{ Setting::get('site_name', 'AZAM GROUP') }}",
        "description": "{{ Str::limit(Setting::get('company_intro', ''), 160) }}",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/logo.png') }}",
        "image": "{{ asset('images/og-default.jpg') }}",
        "telephone": "{{ Setting::get('contact_phone') }}",
        "email": "{{ Setting::get('contact_email') }}",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "{{ Setting::get('contact_address', 'Cité an 2, rue 6.40') }}",
            "addressLocality": "{{ Setting::get('contact_city', 'Ouagadougou') }}",
            "addressCountry": "BF"
        },
        "openingHoursSpecification": {
            "@@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
            "opens": "08:00",
            "closes": "18:00"
        },
        "contactPoint": {
            "@@type": "ContactPoint",
            "telephone": "{{ Setting::get('whatsapp_number') }}",
            "contactType": "customer service",
            "availableLanguage": ["French", "English"]
        },
        "sameAs": [
            @if(Setting::get('social_facebook'))"{{ Setting::get('social_facebook') }}"@endif
            @if(Setting::get('social_facebook') && Setting::get('social_instagram')),@endif
            @if(Setting::get('social_instagram'))"{{ Setting::get('social_instagram') }}"@endif
        ]
    }
    </script>

    @stack('schema')

    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Palette orange #F57C00 --}}
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: {
                        50:  '#fff3e0',
                        100: '#ffe0b2',
                        200: '#ffcc80',
                        300: '#ffb74d',
                        400: '#ffa726',
                        500: '#ff9800',
                        600: '#fb8c00',
                        700: '#f57c00',
                        800: '#ef6c00',
                        900: '#e65100',
                    }
                }
            }
        }
    }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --gold:      #F57C00;
            --gold-dark: #E65100;
            --black:     #111111;
        }
        /* Remplacement global indigo → orange */
        .bg-indigo-600, .bg-indigo-500  { background-color: var(--gold-dark) !important; }
        .bg-indigo-700  { background-color: #BF360C !important; }
        .bg-indigo-50   { background-color: #fff3e0 !important; }
        .bg-indigo-100  { background-color: #ffe0b2 !important; }
        .text-indigo-600, .text-indigo-500 { color: var(--gold-dark) !important; }
        .text-indigo-700 { color: #BF360C !important; }
        .text-indigo-400 { color: var(--gold) !important; }
        .text-indigo-200 { color: #ffcc80 !important; }
        .hover\:bg-indigo-700:hover { background-color: #BF360C !important; }
        .hover\:bg-indigo-600:hover { background-color: var(--gold-dark) !important; }
        .hover\:bg-indigo-50:hover  { background-color: #fff3e0 !important; }
        .hover\:text-indigo-600:hover { color: var(--gold-dark) !important; }
        .hover\:text-indigo-700:hover { color: #BF360C !important; }
        .focus\:ring-indigo-500:focus { --tw-ring-color: var(--gold) !important; }
        .border-indigo-500, .border-indigo-600 { border-color: var(--gold) !important; }
        .hover\:border-indigo-500:hover { border-color: var(--gold) !important; }
        .ring-indigo-500 { --tw-ring-color: var(--gold) !important; }
        .hover\:text-indigo-800:hover { color: #BF360C !important; }
        /* Remplacement global yellow → orange (navbar, boutons) */
        .text-yellow-400, .text-yellow-500 { color: var(--gold) !important; }
        .hover\:text-yellow-400:hover { color: var(--gold) !important; }
        .bg-yellow-400, .bg-yellow-500  { background-color: var(--gold) !important; }
        .hover\:bg-yellow-400:hover { background-color: var(--gold-dark) !important; }
        .border-yellow-400 { border-color: var(--gold) !important; }
        .hover\:border-yellow-400:hover { border-color: var(--gold) !important; }
        .ring-yellow-400, .focus\:ring-yellow-400:focus { --tw-ring-color: var(--gold) !important; }
        /* Remplacement global amber → orange (product cards) */
        .text-amber-400, .text-amber-500, .text-amber-600 { color: var(--gold) !important; }
        .hover\:text-amber-600:hover { color: var(--gold-dark) !important; }
        .bg-amber-400, .bg-amber-500 { background-color: var(--gold) !important; }
        .hover\:bg-amber-500:hover { background-color: var(--gold-dark) !important; }
        /* Boutons orange */
        .btn-gold {
            background-color: var(--gold);
            color: #ffffff;
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

@stack('scripts')

{{-- Tawk.to chat widget (activable depuis Admin > Paramètres) --}}
@php
    $tawkRaw = \App\Models\Setting::get('tawk_property_id');
    // Accepte l'URL complète ou juste l'identifiant
    $tawkId = $tawkRaw ? preg_replace('#^https?://embed\.tawk\.to/#', '', trim($tawkRaw)) : null;
@endphp
@if($tawkId)
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadTime=new Date();
(function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/{{ $tawkId }}';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
})();
</script>
@endif

</body>
</html>
