@extends('layouts.app')

@section('title', 'Conditions Générales d\'Utilisation - ' . __('app.site_name'))
@section('meta_description', 'Consultez les conditions générales d\'utilisation de notre boutique en ligne.')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">

    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-3">Conditions Générales d'Utilisation</h1>
        <p class="text-gray-400 text-sm">Dernière mise à jour : {{ date('d/m/Y') }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-8 space-y-8 text-gray-700 text-sm leading-relaxed">

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">1. Présentation</h2>
            <p>Le site <strong>{{ __('app.site_name') }}</strong> est une boutique en ligne proposant des produits à la vente avec livraison en Algérie. En accédant à ce site, vous acceptez les présentes conditions générales d'utilisation.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">2. Accès au site</h2>
            <p>Le site est accessible 24h/24 et 7j/7, sous réserve des opérations de maintenance. Nous nous réservons le droit de suspendre, restreindre ou modifier l'accès au site sans préavis.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">3. Commandes</h2>
            <p>Les commandes sont passées via WhatsApp. Une commande est confirmée uniquement après validation par notre équipe. Nous nous réservons le droit d'annuler toute commande en cas de rupture de stock, d'erreur de prix ou de suspicion de fraude.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">4. Prix</h2>
            <p>Les prix sont affichés en Dinars Algériens (DA) et sont susceptibles d'être modifiés sans préavis. Le prix applicable est celui en vigueur au moment de la confirmation de la commande.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">5. Livraison</h2>
            <p>La livraison est assurée partout en Algérie. Les délais et frais de livraison sont communiqués lors de la confirmation de commande. Nous déclinons toute responsabilité en cas de retard dû à des facteurs externes (grèves, conditions météo, etc.).</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">6. Retours et remboursements</h2>
            <p>Les retours sont acceptés dans un délai de 7 jours suivant la réception, sous réserve que le produit soit intact, dans son emballage d'origine et accompagné du bon de commande. Contactez-nous via WhatsApp pour initier un retour.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">7. Propriété intellectuelle</h2>
            <p>Tous les contenus présents sur ce site (textes, images, logos, etc.) sont la propriété de {{ __('app.site_name') }} et sont protégés par les lois relatives à la propriété intellectuelle. Toute reproduction sans autorisation est interdite.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">8. Responsabilité</h2>
            <p>{{ __('app.site_name') }} ne saurait être tenu responsable des dommages directs ou indirects résultant de l'utilisation du site ou des produits achetés, au-delà du montant de la commande concernée.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">9. Droit applicable</h2>
            <p>Les présentes conditions sont régies par le droit algérien. Tout litige sera soumis aux tribunaux compétents d'Algérie.</p>
        </section>

        <section>
            <h2 class="text-lg font-bold text-gray-800 mb-3">10. Contact</h2>
            <p>Pour toute question concernant ces conditions, contactez-nous via la <a href="{{ route('contact') }}" class="text-indigo-600 hover:underline">page contact</a> ou par WhatsApp.</p>
        </section>

    </div>
</div>
@endsection
