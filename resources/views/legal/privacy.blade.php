@extends('layouts.app')

@section('title', 'Politique de Confidentialité - ' . __('app.site_name'))
@section('meta_description', 'Politique de confidentialité et protection des données personnelles de notre boutique.')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">

    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-3">Politique de Confidentialité</h1>
        <p class="text-gray-400 text-sm">Dernière mise à jour : {{ date('d/m/Y') }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-8 space-y-8 text-gray-700 text-sm leading-relaxed">

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">1. Données collectées</h2>
            <p>Lors de votre utilisation de notre site, nous collectons les informations suivantes :</p>
            <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                <li>Nom et prénom</li>
                <li>Numéro de téléphone</li>
                <li>Adresse email (optionnelle)</li>
                <li>Adresse de livraison</li>
                <li>Données de navigation (cookies de session)</li>
            </ul>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">2. Utilisation des données</h2>
            <p>Vos données personnelles sont utilisées exclusivement pour :</p>
            <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                <li>Traiter et livrer vos commandes</li>
                <li>Vous contacter concernant votre commande</li>
                <li>Répondre à vos demandes de contact</li>
                <li>Améliorer nos services</li>
            </ul>
            <p class="mt-3">Nous ne vendons ni ne louons vos données personnelles à des tiers.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">3. Cookies</h2>
            <p>Ce site utilise des cookies de session pour maintenir votre panier d'achats actif pendant votre navigation. Ces cookies ne stockent aucune information personnelle et sont supprimés à la fermeture de votre navigateur.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">4. Sécurité des données</h2>
            <p>Nous mettons en œuvre des mesures de sécurité appropriées pour protéger vos données contre tout accès non autorisé, altération ou divulgation. Vos données sont stockées sur des serveurs sécurisés.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">5. Conservation des données</h2>
            <p>Vos données de commande sont conservées pendant une durée de 3 ans conformément aux obligations légales algériennes. Les messages de contact sont conservés pendant 1 an.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">6. Vos droits</h2>
            <p>Conformément à la loi algérienne sur la protection des données personnelles, vous disposez des droits suivants :</p>
            <ul class="list-disc list-inside mt-2 space-y-1 text-gray-600">
                <li>Droit d'accès à vos données</li>
                <li>Droit de rectification</li>
                <li>Droit à l'effacement</li>
                <li>Droit d'opposition</li>
            </ul>
            <p class="mt-3">Pour exercer ces droits, contactez-nous via la <a href="{{ route('contact') }}" class="text-indigo-600 hover:underline">page contact</a>.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">7. Partage des données</h2>
            <p>Vos données peuvent être partagées avec nos partenaires de livraison uniquement dans le but d'assurer la livraison de vos commandes (nom, adresse, téléphone). Ces partenaires sont soumis à des obligations de confidentialité.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">8. Contact</h2>
            <p>Pour toute question relative à la protection de vos données personnelles, contactez-nous via notre <a href="{{ route('contact') }}" class="text-indigo-600 hover:underline">formulaire de contact</a>.</p>
        </section>

    </div>
</div>
@endsection
