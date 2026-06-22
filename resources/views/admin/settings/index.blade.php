@extends('layouts.admin')

@section('title', 'Paramètres du site')

@section('content')
<div class="max-w-3xl">
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2">
            <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        {{-- ══════════════════════════════════════════ --}}
        {{-- 1. IDENTITÉ DU SITE                       --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-bold text-gray-700 text-lg mb-5 flex items-center gap-2">
                <i class="fas fa-image text-indigo-500"></i> Identité du site
            </h2>
            <div class="flex flex-col sm:flex-row gap-6 items-start">
                {{-- Logo --}}
                <div class="flex-shrink-0">
                    @php $logo = $settings['site_logo'] ?? ''; @endphp
                    <div class="w-36 h-24 border-2 border-dashed border-gray-200 rounded-xl flex items-center justify-center bg-gray-50 overflow-hidden">
                        @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo" id="logo-preview"
                                 class="max-w-full max-h-full object-contain p-2">
                        @else
                            <div id="logo-placeholder" class="text-center text-gray-400">
                                <i class="fas fa-image text-3xl mb-1"></i>
                                <p class="text-xs">Aucun logo</p>
                            </div>
                            <img id="logo-preview" class="hidden max-w-full max-h-full object-contain p-2" alt="Aperçu">
                        @endif
                    </div>
                    <p class="text-xs text-gray-400 mt-1 text-center">PNG, JPG, SVG — max 2 Mo</p>
                </div>
                <div class="flex-1 space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Logo du site</label>
                        <input type="file" name="site_logo" accept="image/*" id="logo-input" onchange="previewLogo(this)"
                               class="block w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                        @if($logo)
                        <div class="mt-2 flex items-center gap-2">
                            <span class="text-xs text-green-600"><i class="fas fa-check-circle mr-1"></i>{{ basename($logo) }}</span>
                            <label class="flex items-center gap-1 text-xs text-red-500 cursor-pointer">
                                <input type="checkbox" name="remove_logo" value="1"> Supprimer
                            </label>
                        </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom du site</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? config('app.name') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- 2. PRÉSENTATION DE L'ENTREPRISE           --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-bold text-gray-700 text-lg mb-5 flex items-center gap-2">
                <i class="fas fa-building text-indigo-500"></i> Présentation de l'entreprise
            </h2>
            <div class="space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom du gérant</label>
                        <input type="text" name="company_manager" value="{{ $settings['company_manager'] ?? '' }}"
                               placeholder="Abubakar BOLY"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Titre / Fonction</label>
                        <input type="text" name="company_manager_title" value="{{ $settings['company_manager_title'] ?? '' }}"
                               placeholder="Gérant"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Site web</label>
                    <input type="text" name="company_website" value="{{ $settings['company_website'] ?? '' }}"
                           placeholder="www.azamgroupe.com"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                {{-- Slogan FR / EN --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Slogan <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded ml-1">FR</span>
                        </label>
                        <input type="text" name="company_slogan" value="{{ $settings['company_slogan'] ?? '' }}"
                               placeholder="Votre partenaire stratégique..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Slogan <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded ml-1">EN</span>
                        </label>
                        <input type="text" name="company_slogan_en" value="{{ $settings['company_slogan_en'] ?? '' }}"
                               placeholder="Your strategic partner for boundless opportunities."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                {{-- Motto FR / EN --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Motto <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded ml-1">FR</span>
                            <span class="text-xs text-gray-400 font-normal">séparés par •</span>
                        </label>
                        <input type="text" name="company_motto" value="{{ $settings['company_motto'] ?? '' }}"
                               placeholder="CONNECTER • DÉVELOPPER • RÉUSSIR"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Motto <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded ml-1">EN</span>
                        </label>
                        <input type="text" name="company_motto_en" value="{{ $settings['company_motto_en'] ?? '' }}"
                               placeholder="CONNECT • DEVELOP • SUCCEED"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                {{-- Intro FR / EN --}}
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Texte d'introduction <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded ml-1">FR</span>
                        </label>
                        <textarea name="company_intro" rows="5"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm resize-y"
                                  placeholder="AZAM GROUP accompagne les entreprises...">{{ $settings['company_intro'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Introduction text <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded ml-1">EN</span>
                        </label>
                        <textarea name="company_intro_en" rows="5"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm resize-y"
                                  placeholder="AZAM GROUP supports businesses...">{{ $settings['company_intro_en'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- 3. SERVICE 1                               --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-bold text-gray-700 text-lg mb-5 flex items-center gap-2">
                <i class="fas fa-chart-line text-indigo-500"></i> Service 1 — Conseils & Développement
            </h2>
            <div class="space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Titre <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded ml-1">FR</span>
                        </label>
                        <input type="text" name="service1_title" value="{{ $settings['service1_title'] ?? '' }}"
                               placeholder="Conseils & Développement Commercial"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Title <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded ml-1">EN</span>
                        </label>
                        <input type="text" name="service1_title_en" value="{{ $settings['service1_title_en'] ?? '' }}"
                               placeholder="Consulting & Business Development"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Sous-titre <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded ml-1">FR</span>
                        </label>
                        <input type="text" name="service1_subtitle" value="{{ $settings['service1_subtitle'] ?? '' }}"
                               placeholder="Pénétration des marchés africains..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Subtitle <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded ml-1">EN</span>
                        </label>
                        <input type="text" name="service1_subtitle_en" value="{{ $settings['service1_subtitle_en'] ?? '' }}"
                               placeholder="Penetrating African markets with a tailor-made strategy."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Prestations <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded ml-1">FR</span>
                            <span class="text-xs text-gray-400 font-normal">— une par ligne</span>
                        </label>
                        <textarea name="service1_items" rows="5"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm resize-y"
                                  placeholder="Stratégie commerciale & accès aux marchés&#10;Développement des partenariats...">{{ $settings['service1_items'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Services <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded ml-1">EN</span>
                            <span class="text-xs text-gray-400 font-normal">— one per line</span>
                        </label>
                        <textarea name="service1_items_en" rows="5"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm resize-y"
                                  placeholder="Commercial strategy & market access&#10;Partnership development & local networks...">{{ $settings['service1_items_en'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- 4. SERVICE 2                               --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-bold text-gray-700 text-lg mb-5 flex items-center gap-2">
                <i class="fas fa-globe text-indigo-500"></i> Service 2 — Sourcing & Achat Groupé
            </h2>
            <div class="space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Titre <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded ml-1">FR</span>
                        </label>
                        <input type="text" name="service2_title" value="{{ $settings['service2_title'] ?? '' }}"
                               placeholder="Sourcing & Achat Groupé"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Title <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded ml-1">EN</span>
                        </label>
                        <input type="text" name="service2_title_en" value="{{ $settings['service2_title_en'] ?? '' }}"
                               placeholder="Sourcing & Group Purchasing"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Sous-titre <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded ml-1">FR</span>
                        </label>
                        <input type="text" name="service2_subtitle" value="{{ $settings['service2_subtitle'] ?? '' }}"
                               placeholder="Accès direct aux meilleurs fournisseurs..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Subtitle <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded ml-1">EN</span>
                        </label>
                        <input type="text" name="service2_subtitle_en" value="{{ $settings['service2_subtitle_en'] ?? '' }}"
                               placeholder="Direct access to the best suppliers from Asia, America and Europe."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Zones couvertes
                        <span class="text-xs text-gray-400 font-normal ml-1">— séparées par des virgules (même valeur pour FR & EN)</span>
                    </label>
                    <input type="text" name="service2_zones" value="{{ $settings['service2_zones'] ?? '' }}"
                           placeholder="Asie,Amérique,Europe"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Prestations <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded ml-1">FR</span>
                            <span class="text-xs text-gray-400 font-normal">— une par ligne</span>
                        </label>
                        <textarea name="service2_items" rows="5"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm resize-y"
                                  placeholder="Sourcing qualifié & fournisseurs fiables&#10;Achat groupé...">{{ $settings['service2_items'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Services <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded ml-1">EN</span>
                            <span class="text-xs text-gray-400 font-normal">— one per line</span>
                        </label>
                        <textarea name="service2_items_en" rows="5"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm resize-y"
                                  placeholder="Qualified sourcing & reliable suppliers&#10;Group purchasing for optimized conditions...">{{ $settings['service2_items_en'] ?? '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- 5. NOS VALEURS (4)                         --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-bold text-gray-700 text-lg mb-5 flex items-center gap-2">
                <i class="fas fa-star text-indigo-500"></i> Nos valeurs (4)
            </h2>
            <div class="space-y-5">
                @foreach([
                    ['num'=>1, 'fr_title'=>'Vision',     'en_title'=>'Vision',      'fr_text'=>'Créer de la valeur et ouvrir de nouvelles opportunités.',   'en_text'=>'Creating value and opening new opportunities.'],
                    ['num'=>2, 'fr_title'=>'Engagement', 'en_title'=>'Commitment',  'fr_text'=>'Votre réussite, notre priorité absolue.',                    'en_text'=>'Your success, our absolute priority.'],
                    ['num'=>3, 'fr_title'=>'Expertise',  'en_title'=>'Expertise',   'fr_text'=>'Une approche professionnelle et des solutions sur mesure.',  'en_text'=>'A professional approach and tailored solutions.'],
                    ['num'=>4, 'fr_title'=>'Réseau',     'en_title'=>'Network',     'fr_text'=>'Un maillage international au service de vos ambitions.',     'en_text'=>'An international network at the service of your ambitions.'],
                ] as $v)
                <div class="border border-gray-100 rounded-xl p-4 space-y-3">
                    <p class="text-xs font-bold text-indigo-600 uppercase tracking-wide">Valeur {{ $v['num'] }}</p>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Titre <span class="bg-blue-100 text-blue-700 text-xs px-1.5 py-0.5 rounded ml-1">FR</span>
                            </label>
                            <input type="text" name="value{{ $v['num'] }}_title"
                                   value="{{ $settings['value'.$v['num'].'_title'] ?? '' }}"
                                   placeholder="{{ $v['fr_title'] }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Title <span class="bg-green-100 text-green-700 text-xs px-1.5 py-0.5 rounded ml-1">EN</span>
                            </label>
                            <input type="text" name="value{{ $v['num'] }}_title_en"
                                   value="{{ $settings['value'.$v['num'].'_title_en'] ?? '' }}"
                                   placeholder="{{ $v['en_title'] }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Description <span class="bg-blue-100 text-blue-700 text-xs px-1.5 py-0.5 rounded ml-1">FR</span>
                            </label>
                            <textarea name="value{{ $v['num'] }}_text" rows="2"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-y"
                                      placeholder="{{ $v['fr_text'] }}">{{ $settings['value'.$v['num'].'_text'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Description <span class="bg-green-100 text-green-700 text-xs px-1.5 py-0.5 rounded ml-1">EN</span>
                            </label>
                            <textarea name="value{{ $v['num'] }}_text_en" rows="2"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-y"
                                      placeholder="{{ $v['en_text'] }}">{{ $settings['value'.$v['num'].'_text_en'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- 6. CONTACT                                 --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-bold text-gray-700 text-lg mb-5 flex items-center gap-2">
                <i class="fas fa-address-book text-indigo-500"></i> Informations de contact
            </h2>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email de contact</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp (numéro complet avec indicatif)</label>
                    <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '' }}"
                           placeholder="+22676614950"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone principal</label>
                    <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone secondaire</label>
                    <input type="text" name="contact_phone2" value="{{ $settings['contact_phone2'] ?? '' }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                    <input type="text" name="contact_city" value="{{ $settings['contact_city'] ?? '' }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Horaires d'ouverture</label>
                    <input type="text" name="contact_hours" value="{{ $settings['contact_hours'] ?? '' }}"
                           placeholder="Lun-Ven 8h-18h"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Adresse complète</label>
                    <input type="text" name="contact_address" value="{{ $settings['contact_address'] ?? '' }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Google Maps (lien iframe src)
                        <span class="text-xs text-gray-400 font-normal ml-1">Google Maps → Partager → Intégrer une carte → copier le src</span>
                    </label>
                    <input type="text" name="contact_map" value="{{ $settings['contact_map'] ?? '' }}"
                           placeholder="https://www.google.com/maps/embed?pb=..."
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-xs">
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- 7. RÉSEAUX SOCIAUX                         --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-bold text-gray-700 text-lg mb-5 flex items-center gap-2">
                <i class="fas fa-share-alt text-indigo-500"></i> Réseaux sociaux
            </h2>
            <div class="grid sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fab fa-facebook text-blue-600 mr-1"></i> Facebook (URL)
                    </label>
                    <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}"
                           placeholder="https://facebook.com/azamgroup"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fab fa-instagram text-pink-500 mr-1"></i> Instagram (URL)
                    </label>
                    <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}"
                           placeholder="https://instagram.com/azamgroup"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- 8. TEXTE LONG À PROPOS (SEO)               --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-bold text-gray-700 text-lg mb-5 flex items-center gap-2">
                <i class="fas fa-file-alt text-indigo-500"></i> Texte long "À propos" (SEO)
            </h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Français <span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded ml-1">FR</span>
                    </label>
                    <textarea name="about_fr" rows="6"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm resize-y">{{ $settings['about_fr'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        English <span class="bg-green-100 text-green-700 text-xs px-2 py-0.5 rounded ml-1">EN</span>
                    </label>
                    <textarea name="about_en" rows="6"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm resize-y">{{ $settings['about_en'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════ --}}
        {{-- 9. VÉRIFICATION MOTEURS DE RECHERCHE      --}}
        {{-- ══════════════════════════════════════════ --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="font-bold text-gray-700 text-lg mb-5 flex items-center gap-2">
                <i class="fas fa-search text-indigo-500"></i> Vérification moteurs de recherche
            </h2>
            <p class="text-sm text-gray-500 mb-4">Colle ici les codes fournis par Google Search Console et Bing Webmaster Tools.</p>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fab fa-google mr-1 text-red-500"></i> Google Search Console — code de vérification
                    </label>
                    <input type="text" name="google_verification" value="{{ $settings['google_verification'] ?? '' }}"
                           placeholder="Ex: abc123xyz..."
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <p class="text-xs text-gray-400 mt-1">Depuis Search Console → Ajouter une propriété → Balise HTML → copie uniquement le contenu de content="..."</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fab fa-microsoft mr-1 text-blue-500"></i> Bing Webmaster Tools — code de vérification
                    </label>
                    <input type="text" name="bing_verification" value="{{ $settings['bing_verification'] ?? '' }}"
                           placeholder="Ex: XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <div class="flex justify-end pb-8">
            <button type="submit"
                    class="bg-indigo-600 text-white font-bold px-10 py-3 rounded-xl hover:bg-indigo-700 transition flex items-center gap-2 text-base">
                <i class="fas fa-save"></i> Enregistrer tous les paramètres
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewLogo(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('logo-preview');
        const placeholder = document.getElementById('logo-placeholder');
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        if (placeholder) placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
}
</script>
@endpush
@endsection
