<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Paramètres AZAM GROUP ───────────────────────────────────────
        $settings = [
            // Identité
            'site_name'            => 'AZAM GROUP',
            // Présentation FR
            'company_slogan'          => "Votre partenaire stratégique pour des opportunités sans frontières.",
            'company_motto'           => "CONNECTER • DÉVELOPPER • RÉUSSIR",
            'company_manager'         => "Abubakar BOLY",
            'company_manager_title'   => "Gérant",
            'company_website'         => "www.azamgroupe.com",
            'company_intro'           => "AZAM GROUP accompagne les entreprises et entrepreneurs dans leur développement commercial sur les marchés africains. Grâce à notre réseau international et notre expertise locale, nous ouvrons des portes là où d'autres voient des obstacles.\n\nDe l'étude de marché à l'implantation sur le terrain, en passant par le sourcing qualifié auprès des meilleurs fournisseurs d'Asie, d'Amérique et d'Europe — nous sommes à vos côtés à chaque étape de votre réussite.",
            // Présentation EN
            'company_slogan_en'       => "Your strategic partner for boundless opportunities.",
            'company_motto_en'        => "CONNECT • DEVELOP • SUCCEED",
            'company_intro_en'        => "AZAM GROUP supports businesses and entrepreneurs in their commercial development across African markets. Thanks to our international network and local expertise, we open doors where others see obstacles.\n\nFrom market research to on-the-ground implementation, through qualified sourcing from the best suppliers in Asia, America and Europe — we are by your side at every step of your success.",
            // Service 1 FR
            'service1_title'          => "Conseils & Développement Commercial",
            'service1_subtitle'       => "Pénétration des marchés africains avec une stratégie sur mesure.",
            'service1_items'          => "Stratégie commerciale & accès aux marchés\nDéveloppement des partenariats & réseaux locaux\nÉtudes de marché & veille stratégique\nImplantation & accompagnement sur le continent africain",
            // Service 1 EN
            'service1_title_en'       => "Consulting & Business Development",
            'service1_subtitle_en'    => "Penetrating African markets with a tailor-made strategy.",
            'service1_items_en'       => "Commercial strategy & market access\nPartnership development & local networks\nMarket research & strategic intelligence\nImplementation & support across the African continent",
            // Service 2 FR
            'service2_title'          => "Sourcing & Achat Groupé",
            'service2_subtitle'       => "Accès direct aux meilleurs fournisseurs d'Asie, d'Amérique et d'Europe.",
            'service2_zones'          => "Asie,Amérique,Europe",
            'service2_items'          => "Sourcing qualifié & fournisseurs fiables\nAchat groupé pour des conditions optimisées\nContrôle qualité & conformité\nLogistique & suivi de bout en bout",
            // Service 2 EN
            'service2_title_en'       => "Sourcing & Group Purchasing",
            'service2_subtitle_en'    => "Direct access to the best suppliers from Asia, America and Europe.",
            'service2_items_en'       => "Qualified sourcing & reliable suppliers\nGroup purchasing for optimized conditions\nQuality control & compliance\nEnd-to-end logistics & tracking",
            // Valeurs FR
            'value1_title'            => "Vision",
            'value1_text'             => "Créer de la valeur et ouvrir de nouvelles opportunités.",
            'value2_title'            => "Engagement",
            'value2_text'             => "Votre réussite, notre priorité.",
            'value3_title'            => "Expertise",
            'value3_text'             => "Une approche professionnelle et des solutions sur mesure.",
            'value4_title'            => "Réseau",
            'value4_text'             => "Un maillage international au service de vos ambitions.",
            // Valeurs EN
            'value1_title_en'         => "Vision",
            'value1_text_en'          => "Creating value and opening new opportunities.",
            'value2_title_en'         => "Commitment",
            'value2_text_en'          => "Your success, our absolute priority.",
            'value3_title_en'         => "Expertise",
            'value3_text_en'          => "A professional approach and tailored solutions.",
            'value4_title_en'         => "Network",
            'value4_text_en'          => "An international network at the service of your ambitions.",
            // Contact
            'contact_email'        => 'abubakarboly@gmail.com',
            'contact_phone'        => '+226 666 000 00',
            'contact_phone2'       => '+226 76614950',
            'contact_address'      => 'Cité an 2, rue 6.40',
            'contact_city'         => 'Ouagadougou',
            'contact_hours'        => 'Lun - Ven : 8h00 - 18h00',
            'contact_map'          => '',
            'whatsapp_number'      => '+22676614950',
            'social_facebook'      => '',
            'social_instagram'     => '',
            // Texte SEO long
            'about_fr'             => "AZAM GROUP est votre partenaire stratégique pour des opportunités sans frontières.\n\nNous accompagnons les entreprises et entrepreneurs dans leur développement commercial sur les marchés africains, et facilitons l'accès aux meilleurs fournisseurs d'Asie, d'Amérique et d'Europe.\n\nGérant : Abubakar BOLY — www.azamgroupe.com",
            'about_en'             => "AZAM GROUP is your strategic partner for boundless opportunities.\n\nWe support businesses and entrepreneurs in their commercial development across African markets, and facilitate access to the best suppliers from Asia, America and Europe.\n\nCEO: Abubakar BOLY — www.azamgroupe.com",
        ];

        Setting::setMany($settings);

        // ─── Admin ───────────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@azamgroupe.com'],
            [
                'name'     => 'Abubakar BOLY',
                'email'    => 'admin@azamgroupe.com',
                'password' => Hash::make('Admin@2024'),
            ]
        );

        // ─── Désactiver les anciennes catégories démo ────────────────────
        Category::whereIn('slug', ['electronique','vetements','maison','sports','beaute','alimentation','maison-lifestyle'])
                 ->update(['active' => false]);

        // ─── 2 catégories AZAM GROUP ──────────────────────────────────────
        $cats = [
            [
                'name_fr'    => 'Matériaux de Construction',
                'name_en'    => 'Construction Materials',
                'slug'       => 'materiaux-construction',
                'sort_order' => 1,
                'active'     => true,
            ],
            [
                'name_fr'    => 'Énergie',
                'name_en'    => 'Energy',
                'slug'       => 'energie',
                'sort_order' => 2,
                'active'     => true,
            ],
        ];

        foreach ($cats as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $catMateriaux = Category::where('slug', 'materiaux-construction')->first();
        $catEnergie   = Category::where('slug', 'energie')->first();

        // ─── Produits : Matériaux de Construction ─────────────────────────
        $productsMateriaux = [
            [
                'name_fr'        => 'Ciment Portland CEM II – Sac 50kg',
                'name_en'        => 'Portland Cement CEM II – 50kg Bag',
                'slug'           => 'ciment-portland-cem2-50kg',
                'description_fr' => "Ciment Portland CEM II de haute qualité, importé et distribué par AZAM GROUP.\n\n• Résistance 32,5 MPa\n• Sac de 50 kg\n• Prise rapide, idéal maçonnerie & dallage\n• Certifié normes ISO\n\nDisponible à la palette (35 sacs). Prix dégressif sur commande groupée.",
                'description_en' => "High quality Portland CEM II cement imported by AZAM GROUP.\n\n• 32.5 MPa strength\n• 50 kg bag\n• Fast setting, ideal for masonry & flooring\n• ISO certified\n\nAvailable per pallet (35 bags). Volume discounts available.",
                'price'          => 7500,
                'stock'          => 500,
                'featured'       => true,
            ],
            [
                'name_fr'        => 'Fer à Béton – Barre ∅12mm × 12m',
                'name_en'        => 'Steel Rebar – ∅12mm × 12m Bar',
                'slug'           => 'fer-a-beton-12mm-12m',
                'description_fr' => "Fer à béton haute adhérence, sourcé et importé par AZAM GROUP.\n\n• Diamètre : 12 mm\n• Longueur : 12 mètres\n• Acier HA500 haute résistance\n• Nervures hélicoïdales pour meilleure adhérence\n• Certifié normes construction\n\nVente à la barre ou en lot (12 barres / lot).",
                'description_en' => "High-adherence steel rebar sourced and imported by AZAM GROUP.\n\n• Diameter: 12 mm\n• Length: 12 meters\n• HA500 high-strength steel\n• Helical ribs for better grip\n• Construction standard certified\n\nSold per bar or bundle (12 bars).",
                'price'          => 15000,
                'stock'          => 300,
                'featured'       => true,
            ],
            [
                'name_fr'        => 'Tôle Galvanisée Ondulée – Feuille 2,5m',
                'name_en'        => 'Corrugated Galvanized Sheet – 2.5m',
                'slug'           => 'tole-galvanisee-ondulee-2m5',
                'description_fr' => "Tôle galvanisée ondulée pour toiture et bardage, importée via AZAM GROUP.\n\n• Longueur : 2,5 m — Largeur utile : 0,83 m\n• Épaisseur : 0,5 mm (galva 275 g/m²)\n• Résistance aux intempéries et à la corrosion\n• Teinte naturelle zinc ou prélaquée (sur commande)\n\nVente à la feuille ou au pack de 10 feuilles.",
                'description_en' => "Corrugated galvanized roofing sheet imported via AZAM GROUP.\n\n• Length: 2.5 m — Useful width: 0.83 m\n• Thickness: 0.5 mm (galva 275 g/m²)\n• Weather & corrosion resistant\n• Natural zinc or pre-painted finish (on order)\n\nSold per sheet or pack of 10.",
                'price'          => 12000,
                'stock'          => 400,
                'featured'       => true,
            ],
            [
                'name_fr'        => 'Carreaux Sol & Mur – 60×60 cm (boîte de 4)',
                'name_en'        => 'Floor & Wall Tiles – 60×60 cm (box of 4)',
                'slug'           => 'carreaux-sol-mur-60x60',
                'description_fr' => "Carreaux en grès cérame poli, importés d'Asie par AZAM GROUP.\n\n• Format : 60 × 60 cm\n• Épaisseur : 10 mm\n• Grès cérame haute dureté (PEI 4)\n• Résistant à l'abrasion et aux taches\n• Finition brillante ou mat (au choix)\n\nBoîte de 4 carreaux = 1,44 m². Disponible en plusieurs coloris.",
                'description_en' => "Polished porcelain tiles imported from Asia by AZAM GROUP.\n\n• Size: 60 × 60 cm\n• Thickness: 10 mm\n• High-hardness porcelain (PEI 4)\n• Abrasion & stain resistant\n• Glossy or matte finish\n\nBox of 4 tiles = 1.44 m². Available in several colors.",
                'price'          => 8500,
                'stock'          => 200,
                'featured'       => false,
            ],
            [
                'name_fr'        => 'Sanitaires – WC Suspendu + Lavabo (Set complet)',
                'name_en'        => 'Bathroom Set – Wall-hung Toilet + Basin',
                'slug'           => 'sanitaires-wc-suspendu-lavabo-set',
                'description_fr' => "Set sanitaire complet importé via AZAM GROUP — qualité européenne.\n\n• WC suspendu céramique blanc (cuvette + abattant soft-close)\n• Lavabo vasque 60 cm + robinet mitigeur\n• Bâti-support pour WC suspendu inclus\n• Chasse d'eau économique double débit (3 / 6 L)\n• Garantie 2 ans\n\nInstallation possible sur demande (Ouagadougou).",
                'description_en' => "Complete bathroom set imported via AZAM GROUP — European quality.\n\n• White ceramic wall-hung toilet (bowl + soft-close seat)\n• 60 cm washbasin + mixer tap\n• Wall-hung WC frame included\n• Dual-flush (3 / 6 L)\n• 2-year warranty\n\nInstallation available on request (Ouagadougou).",
                'price'          => 185000,
                'stock'          => 30,
                'featured'       => false,
            ],
        ];

        foreach ($productsMateriaux as $p) {
            Product::updateOrCreate(
                ['slug' => $p['slug']],
                array_merge($p, ['category_id' => $catMateriaux->id, 'active' => true])
            );
        }

        // ─── Produits : Énergie ───────────────────────────────────────────
        $productsEnergie = [
            [
                'name_fr'        => 'Groupe Électrogène 5 KVA – Diesel',
                'name_en'        => '5 KVA Diesel Generator',
                'slug'           => 'groupe-electrogene-5kva-diesel',
                'description_fr' => "Groupe électrogène diesel importé et certifié par AZAM GROUP — fiable et économique.\n\n• Puissance : 5 KVA / 4 KW\n• Moteur diesel 4 temps refroidi à air\n• Réservoir 15L — autonomie 8 à 10h\n• Démarrage électrique + kick de secours\n• Voltmètre et indicateur carburant intégrés\n• Silencieux basse vibration\n\nIdéal bureaux, ateliers, commerces, chantiers.",
                'description_en' => "Diesel generator imported and certified by AZAM GROUP.\n\n• Power: 5 KVA / 4 KW\n• 4-stroke air-cooled diesel engine\n• 15L tank — 8 to 10h autonomy\n• Electric + kick starter\n• Built-in voltmeter & fuel gauge\n• Low-vibration silencer\n\nIdeal for offices, workshops, shops, construction sites.",
                'price'          => 850000,
                'stock'          => 15,
                'featured'       => true,
            ],
            [
                'name_fr'        => 'Batterie Rechargeable AGM 200 Ah – 12V',
                'name_en'        => 'AGM Rechargeable Battery 200 Ah – 12V',
                'slug'           => 'batterie-agm-200ah-12v',
                'description_fr' => "Batterie solaire AGM sans entretien, importée via AZAM GROUP.\n\n• Capacité : 200 Ah — Tension : 12 V\n• Technologie AGM (sans entretien, étanche)\n• Décharge profonde supportée jusqu'à 80%\n• Durée de vie : 800 cycles minimum\n• Compatible systèmes solaires, UPS, onduleurs\n• Bornes M8 — poids : 55 kg\n\nLivraison possible à domicile (Ouagadougou).",
                'description_en' => "Maintenance-free AGM solar battery imported via AZAM GROUP.\n\n• Capacity: 200 Ah — Voltage: 12 V\n• AGM technology (sealed, maintenance-free)\n• Deep discharge up to 80%\n• Lifespan: 800+ cycles\n• Compatible with solar, UPS, inverter systems\n• M8 terminals — weight: 55 kg\n\nHome delivery available (Ouagadougou).",
                'price'          => 180000,
                'stock'          => 40,
                'featured'       => true,
            ],
            [
                'name_fr'        => 'Panneau Solaire Monocristallin 300W',
                'name_en'        => 'Monocrystalline Solar Panel 300W',
                'slug'           => 'panneau-solaire-monocristallin-300w',
                'description_fr' => "Panneau solaire haute performance importé et distribué par AZAM GROUP.\n\n• Puissance crête : 300 Wc\n• Type : monocristallin haute efficacité (20,5%)\n• Dimensions : 1640 × 992 × 35 mm\n• Tension max : 32,5 V — Courant max : 9,2 A\n• Certification : IEC 61215, IEC 61730\n• Cadre aluminium anodisé — verre trempé anti-reflets\n• Garantie 25 ans sur rendement\n\nVente à l'unité ou en kit complet (panneaux + batterie + régulateur).",
                'description_en' => "High-performance solar panel imported by AZAM GROUP.\n\n• Peak power: 300 Wp\n• Type: high-efficiency monocrystalline (20.5%)\n• Dimensions: 1640 × 992 × 35 mm\n• Max voltage: 32.5 V — Max current: 9.2 A\n• Certified: IEC 61215, IEC 61730\n• Anodized aluminium frame — anti-reflective tempered glass\n• 25-year performance warranty\n\nSold individually or as complete kit (panels + battery + controller).",
                'price'          => 95000,
                'stock'          => 60,
                'featured'       => true,
            ],
        ];

        foreach ($productsEnergie as $p) {
            Product::updateOrCreate(
                ['slug' => $p['slug']],
                array_merge($p, ['category_id' => $catEnergie->id, 'active' => true])
            );
        }
    }
}
