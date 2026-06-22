@extends('layouts.app')

@section('title', 'FAQ - ' . __('app.site_name'))
@section('meta_description', 'Questions fréquentes sur nos produits, livraisons et commandes.')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-12">

    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-3">Questions fréquentes</h1>
        <p class="text-gray-500">Trouvez rapidement les réponses à vos questions.</p>
    </div>

    @php
    $faqs = [
        [
            'q' => 'Comment passer une commande ?',
            'a' => 'Ajoutez les produits souhaités à votre panier, puis cliquez sur "Commander". Remplissez le formulaire avec vos coordonnées et cliquez sur "Commander via WhatsApp". Vous serez redirigé vers WhatsApp pour confirmer votre commande avec notre équipe.',
        ],
        [
            'q' => 'Quels modes de paiement acceptez-vous ?',
            'a' => 'Nous acceptons le paiement à la livraison (Cash on Delivery). Les détails sont discutés lors de la confirmation via WhatsApp.',
        ],
        [
            'q' => 'Quels sont les délais de livraison ?',
            'a' => 'La livraison est généralement effectuée sous 2 à 5 jours ouvrables selon votre wilaya. Alger et les grandes villes peuvent bénéficier d\'une livraison express.',
        ],
        [
            'q' => 'Comment suivre ma commande ?',
            'a' => 'Après confirmation de votre commande via WhatsApp, notre équipe vous tiendra informé par message de l\'avancement de votre livraison.',
        ],
        [
            'q' => 'Puis-je retourner un article ?',
            'a' => 'Oui, nous acceptons les retours dans les 7 jours suivant la réception, à condition que le produit soit dans son état d\'origine. Contactez-nous via WhatsApp pour initier un retour.',
        ],
        [
            'q' => 'Les produits sont-ils garantis ?',
            'a' => 'Tous nos produits sont vérifiés avant expédition. Si vous recevez un produit défectueux, contactez-nous immédiatement et nous trouverons une solution.',
        ],
        [
            'q' => 'Puis-je modifier ma commande après confirmation ?',
            'a' => 'Oui, tant que votre commande n\'a pas été expédiée. Contactez-nous rapidement via WhatsApp pour toute modification.',
        ],
        [
            'q' => 'Livrez-vous partout en Algérie ?',
            'a' => 'Oui, nous livrons dans toutes les wilayas d\'Algérie via nos partenaires de livraison.',
        ],
    ];
    @endphp

    <div class="space-y-3" x-data="{ open: null }">
        @foreach($faqs as $i => $faq)
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <button onclick="toggleFaq({{ $i }})"
                    class="w-full flex items-center justify-between px-6 py-4 text-left hover:bg-gray-50 transition">
                <span class="font-semibold text-gray-800">{{ $faq['q'] }}</span>
                <i id="icon-{{ $i }}" class="fas fa-chevron-down text-indigo-400 transition-transform duration-200"></i>
            </button>
            <div id="faq-{{ $i }}" class="hidden px-6 pb-5 text-gray-600 leading-relaxed text-sm border-t border-gray-100 pt-4">
                {{ $faq['a'] }}
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-10 bg-indigo-50 rounded-2xl p-6 text-center">
        <p class="text-gray-600 mb-3">Vous n'avez pas trouvé la réponse à votre question ?</p>
        <a href="{{ route('contact') }}" class="bg-indigo-600 text-white font-bold px-6 py-2.5 rounded-xl hover:bg-indigo-700 transition inline-block">
            <i class="fas fa-envelope mr-2"></i> Contactez-nous
        </a>
    </div>
</div>

@push('scripts')
<script>
function toggleFaq(i) {
    const content = document.getElementById('faq-' + i);
    const icon = document.getElementById('icon-' + i);
    const isOpen = !content.classList.contains('hidden');
    content.classList.toggle('hidden', isOpen);
    icon.style.transform = isOpen ? '' : 'rotate(180deg)';
}
</script>
@endpush
@endsection
