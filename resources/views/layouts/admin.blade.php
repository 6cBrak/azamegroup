<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Azam Groupe')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-800">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-900 text-white flex flex-col flex-shrink-0">
        <div class="p-5 border-b border-gray-700">
            @php $siteLogo = \App\Models\Setting::get('site_logo'); $siteName = \App\Models\Setting::get('site_name', config('app.name')); @endphp
            @if($siteLogo)
                <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}"
                     class="h-12 w-auto object-contain mb-2 rounded">
            @else
                <h1 class="text-xl font-bold text-white">⚙️ {{ $siteName }}</h1>
            @endif
            <p class="text-xs text-gray-400 mt-1">Panneau d'administration</p>
        </div>
        <nav class="flex-1 p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-tachometer-alt w-4"></i> Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.products.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-box w-4"></i> Produits
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-tags w-4"></i> Catégories
            </a>
            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-shopping-bag w-4"></i> Commandes
            </a>
            <a href="{{ route('admin.contact-messages.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.contact-messages.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-envelope w-4"></i> Messages
                @php $unread = \App\Models\ContactMessage::where('read', false)->count(); @endphp
                @if($unread > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5 font-bold">{{ $unread }}</span>
                @endif
            </a>
            <a href="{{ route('admin.reviews.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.reviews.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-star w-4"></i> Avis clients
                @php $pendingReviews = \App\Models\Review::where('approved', false)->count(); @endphp
                @if($pendingReviews > 0)
                    <span class="ml-auto bg-yellow-500 text-white text-xs rounded-full px-1.5 py-0.5 font-bold">{{ $pendingReviews }}</span>
                @endif
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.settings.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-cog w-4"></i> Paramètres
            </a>
            @endif
            <a href="{{ route('admin.profile.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.profile.*') ? 'bg-indigo-600 text-white' : 'text-gray-300 hover:bg-gray-800' }}">
                <i class="fas fa-user-cog w-4"></i> Mon profil
            </a>
            <hr class="border-gray-700 my-3">
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:bg-gray-800">
                <i class="fas fa-external-link-alt w-4"></i> Voir le site
            </a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-300 hover:bg-gray-800 w-full text-left">
                    <i class="fas fa-sign-out-alt w-4"></i> Déconnexion
                </button>
            </form>
        </nav>
        <div class="p-4 border-t border-gray-700 text-xs text-gray-500">
            {{ auth()->user()->name ?? 'Admin' }}
        </div>
    </aside>

    {{-- Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm px-6 py-4 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-700">@yield('title')</h2>
            @yield('header-actions')
        </header>

        <main class="flex-1 overflow-y-auto p-6">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded flex justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="font-bold">×</button>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded flex justify-between">
                    <span>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="font-bold">×</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
