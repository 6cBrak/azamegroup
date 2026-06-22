@extends('layouts.app')

@php
use App\Models\Setting;
$en = app()->getLocale() === 'en';

function settingLang(string $key, string $default = ''): string {
    $en  = app()->getLocale() === 'en';
    $val = $en ? \App\Models\Setting::get($key . '_en') : '';
    return $val ?: \App\Models\Setting::get($key, $default);
}
function itemsLang(string $key, string $defaultFr): array {
    $en  = app()->getLocale() === 'en';
    $raw = $en ? \App\Models\Setting::get($key . '_en') : '';
    if (!$raw) $raw = \App\Models\Setting::get($key, $defaultFr);
    return array_filter(array_map('trim', explode("\n", $raw)));
}

$slogan       = settingLang('company_slogan', 'Votre partenaire stratégique pour des opportunités sans frontières.');
$motto        = settingLang('company_motto',  'CONNECTER • DÉVELOPPER • RÉUSSIR');
$manager      = Setting::get('company_manager', 'Abubakar BOLY');
$managerTitle = Setting::get('company_manager_title', 'Gérant');
$website      = Setting::get('company_website', 'www.azamgroupe.com');
$intro        = settingLang('company_intro', '');

$s1Title    = settingLang('service1_title',    'Conseils & Développement Commercial');
$s1Subtitle = settingLang('service1_subtitle', 'Pénétration des marchés africains avec une stratégie sur mesure.');
$s1Items    = itemsLang('service1_items', "Stratégie commerciale & accès aux marchés\nDéveloppement des partenariats & réseaux locaux\nÉtudes de marché & veille stratégique\nImplantation & accompagnement en Afrique");

$s2Title    = settingLang('service2_title',    'Sourcing & Achat Groupé');
$s2Subtitle = settingLang('service2_subtitle', "Accès direct aux meilleurs fournisseurs d'Asie, d'Amérique et d'Europe.");
$s2Zones    = array_filter(array_map('trim', explode(',', Setting::get('service2_zones', 'Asie,Amérique,Europe'))));
$s2Items    = itemsLang('service2_items', "Sourcing qualifié & fournisseurs fiables\nAchat groupé pour conditions optimisées\nContrôle qualité & conformité\nLogistique & suivi de bout en bout");

$values = [
    ['title' => settingLang('value1_title', 'Vision'),     'text' => settingLang('value1_text', "Créer de la valeur et ouvrir de nouvelles opportunités."),  'icon' => 'fa-eye'],
    ['title' => settingLang('value2_title', 'Engagement'), 'text' => settingLang('value2_text', 'Votre réussite, notre priorité absolue.'),                   'icon' => 'fa-handshake'],
    ['title' => settingLang('value3_title', 'Expertise'),  'text' => settingLang('value3_text', 'Une approche professionnelle et des solutions sur mesure.'), 'icon' => 'fa-lightbulb'],
    ['title' => settingLang('value4_title', 'Réseau'),     'text' => settingLang('value4_text', 'Un maillage international au service de vos ambitions.'),    'icon' => 'fa-network-wired'],
];
@endphp

@section('title', 'À propos – ' . Setting::get('site_name', 'AZAM GROUP'))
@section('meta_description', $slogan)

@section('content')

{{-- ═══ HERO ══════════════════════════════════════════════════════════════ --}}
<section class="relative bg-gray-900 text-white py-20 px-4 overflow-hidden">
    <div class="absolute inset-0 opacity-5" style="background-image:radial-gradient(circle at 20% 50%, #fbbf24 0%, transparent 60%), radial-gradient(circle at 80% 20%, #fbbf24 0%, transparent 40%)"></div>
    <div class="max-w-4xl mx-auto text-center relative z-10">
        <p class="text-yellow-400 text-sm font-bold tracking-widest uppercase mb-3">Qui sommes-nous ?</p>
        <h1 class="text-5xl font-extrabold mb-4" style="color:#fbbf24">{{ Setting::get('site_name', 'AZAM GROUP') }}</h1>
        @if($slogan)
        <p class="text-xl text-gray-300 max-w-2xl mx-auto mb-6">{{ $slogan }}</p>
        @endif
        @if($motto)
        <div class="flex flex-wrap items-center justify-center gap-2 text-yellow-400 font-bold text-lg tracking-widest">
            @foreach(explode('•', $motto) as $part)
                @if(!empty(trim($part)))
                    <span>{{ trim($part) }}</span>
                    @if(!$loop->last)<span class="text-gray-600">•</span>@endif
                @endif
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- ═══ INTRO ══════════════════════════════════════════════════════════════ --}}
<section class="max-w-5xl mx-auto px-4 py-14">
    <div class="grid md:grid-cols-2 gap-10 items-center">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-800 mb-4">
                Partenaire de votre <span style="color:#d97706">croissance</span>
            </h2>
            @if($intro)
            <div class="text-gray-600 leading-relaxed whitespace-pre-line mb-4">{{ $intro }}</div>
            @else
            <p class="text-gray-600 leading-relaxed mb-4">
                AZAM GROUP accompagne les entreprises et entrepreneurs dans leur développement commercial
                sur les marchés africains. Grâce à notre réseau international et notre expertise locale,
                nous ouvrons des portes là où d'autres voient des obstacles.
            </p>
            @endif
            @if($manager)
            <div class="mt-6 flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-yellow-400 flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-tie text-gray-900 text-lg"></i>
                </div>
                <div>
                    <p class="font-bold text-gray-800">{{ $manager }}</p>
                    <p class="text-sm text-gray-500">{{ $managerTitle }}@if($website) — <a href="http://{{ $website }}" target="_blank" class="text-yellow-600 hover:underline">{{ $website }}</a>@endif</p>
                </div>
            </div>
            @endif
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-gray-900 text-white rounded-2xl p-5 text-center">
                <div class="text-yellow-400 text-3xl font-extrabold mb-1">3+</div>
                <p class="text-gray-300 text-sm">Continents couverts</p>
            </div>
            <div class="bg-yellow-400 text-gray-900 rounded-2xl p-5 text-center">
                <div class="text-3xl font-extrabold mb-1">100%</div>
                <p class="text-sm font-semibold">Engagement client</p>
            </div>
            <div class="bg-yellow-400 text-gray-900 rounded-2xl p-5 text-center">
                <div class="text-3xl font-extrabold mb-1">Pan-</div>
                <p class="text-sm font-semibold">Africain</p>
            </div>
            <div class="bg-gray-900 text-white rounded-2xl p-5 text-center">
                <div class="text-yellow-400 text-3xl font-extrabold mb-1">B2B</div>
                <p class="text-gray-300 text-sm">Solutions sur mesure</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SERVICES ═══════════════════════════════════════════════════════════ --}}
<section class="bg-gray-50 py-14 px-4">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-10">
            <p class="text-yellow-600 text-sm font-bold tracking-widest uppercase mb-2">Ce que nous faisons</p>
            <h2 class="text-3xl font-extrabold text-gray-800">Nos services</h2>
        </div>
        <div class="grid md:grid-cols-2 gap-8">

            {{-- Service 1 --}}
            <div class="bg-white rounded-2xl shadow-md p-7 border-t-4" style="border-color:#fbbf24">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-gray-900 text-xl"
                         style="background:#fbbf24">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="font-extrabold text-gray-800 text-lg leading-tight">{{ $s1Title }}</h3>
                </div>
                @if($s1Subtitle)
                <p class="text-gray-500 text-sm mb-4">{{ $s1Subtitle }}</p>
                @endif
                @if($s1Items)
                <ul class="space-y-2">
                    @foreach($s1Items as $item)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <i class="fas fa-check-circle text-yellow-500 mt-0.5 flex-shrink-0"></i>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>

            {{-- Service 2 --}}
            <div class="bg-white rounded-2xl shadow-md p-7 border-t-4 border-gray-900">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 rounded-xl bg-gray-900 flex items-center justify-center text-yellow-400 text-xl">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3 class="font-extrabold text-gray-800 text-lg leading-tight">{{ $s2Title }}</h3>
                </div>
                @if($s2Subtitle)
                <p class="text-gray-500 text-sm mb-4">{{ $s2Subtitle }}</p>
                @endif
                @if($s2Zones)
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($s2Zones as $zone)
                    <span class="bg-yellow-50 border border-yellow-200 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full">
                        {{ $zone }}
                    </span>
                    @endforeach
                </div>
                @endif
                @if($s2Items)
                <ul class="space-y-2">
                    @foreach($s2Items as $item)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <i class="fas fa-check-circle text-gray-700 mt-0.5 flex-shrink-0"></i>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ═══ VALEURS ═════════════════════════════════════════════════════════════ --}}
@if(collect($values)->filter(fn($v) => $v['title'])->isNotEmpty())
<section class="max-w-5xl mx-auto px-4 py-14">
    <div class="text-center mb-10">
        <p class="text-yellow-600 text-sm font-bold tracking-widest uppercase mb-2">Ce qui nous guide</p>
        <h2 class="text-3xl font-extrabold text-gray-800">Nos valeurs</h2>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @php
        $colors = [
            ['color'=>'#fbbf24','bg'=>'#fffbeb'],
            ['color'=>'#d97706','bg'=>'#fef3c7'],
            ['color'=>'#b45309','bg'=>'#fde68a'],
            ['color'=>'#92400e','bg'=>'#fcd34d'],
        ];
        @endphp
        @foreach($values as $i => $v)
        @if($v['title'])
        <div class="bg-white rounded-2xl shadow p-6 text-center hover:shadow-lg transition">
            <div class="w-14 h-14 rounded-full mx-auto mb-4 flex items-center justify-center"
                 style="background:{{ $colors[$i]['bg'] }}">
                <i class="fas {{ $v['icon'] }} text-2xl" style="color:{{ $colors[$i]['color'] }}"></i>
            </div>
            <h3 class="font-extrabold text-gray-800 mb-2">{{ $v['title'] }}</h3>
            @if($v['text'])
            <p class="text-gray-500 text-sm">{{ $v['text'] }}</p>
            @endif
        </div>
        @endif
        @endforeach
    </div>
</section>
@endif

{{-- ═══ CONTACT ═════════════════════════════════════════════════════════════ --}}
<section class="bg-gray-900 text-white py-14 px-4">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <p class="text-yellow-400 text-sm font-bold tracking-widest uppercase mb-2">Nous contacter</p>
            <h2 class="text-3xl font-extrabold">Coordonnées</h2>
        </div>
        @php
        $wp          = Setting::get('whatsapp_number');
        $city        = Setting::get('contact_city');
        $addr        = Setting::get('contact_address');
        $addrFull    = $addr . ($city ? ' – ' . $city : '');
        $contactItems = array_filter([
            $manager ? ['icon'=>'fa-user-tie',      'label'=>$managerTitle ?: 'Gérant', 'value'=>$manager,   'href'=>null] : null,
            $addr    ? ['icon'=>'fa-map-marker-alt', 'label'=>'Adresse',                'value'=>$addrFull,  'href'=>null] : null,
            $website       ? ['icon'=>'fa-globe',         'label'=>'Site web',   'value'=>$website, 'href'=>'http://'.$website]                            : null,
            Setting::get('contact_email')  ? ['icon'=>'fa-envelope',    'label'=>'Email',    'value'=>Setting::get('contact_email'),  'href'=>'mailto:'.Setting::get('contact_email')]  : null,
            Setting::get('contact_phone')  ? ['icon'=>'fa-phone',       'label'=>'Téléphone','value'=>Setting::get('contact_phone'),  'href'=>'tel:'.Setting::get('contact_phone')]     : null,
            $wp            ? ['icon'=>'fab fa-whatsapp', 'label'=>'WhatsApp',  'value'=>$wp,                                          'href'=>'https://wa.me/'.preg_replace('/[^0-9]/','',$wp)] : null,
        ]);
        @endphp
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($contactItems as $c)
            <div class="flex items-start gap-4 bg-gray-800 rounded-xl p-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#fbbf24">
                    <i class="{{ $c['icon'] }} text-gray-900"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-gray-400 text-xs mb-0.5">{{ $c['label'] }}</p>
                    @if($c['href'])
                        <a href="{{ $c['href'] }}" target="_blank"
                           class="text-sm font-semibold text-yellow-400 hover:text-yellow-300 transition break-all">{{ $c['value'] }}</a>
                    @else
                        <p class="text-sm font-semibold text-gray-200 break-words">{{ $c['value'] }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('contact') }}"
               class="inline-block font-extrabold px-8 py-3 rounded-xl transition text-gray-900"
               style="background:#fbbf24">
                <i class="fas fa-paper-plane mr-2"></i> Envoyer un message
            </a>
        </div>
    </div>
</section>

@endsection
