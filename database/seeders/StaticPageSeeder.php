<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
    {
        // ── ABOUT US ─────────────────────────────────────
        StaticPage::updateOrCreate(['slug' => 'about-us'], [
            'hero_title'    => 'Our Story',
            'hero_subtitle' => 'Rooted in craft. Worn with intention.',
            'hero_tag'      => null,
            'sections'      => [
                [
                    'type'     => 'intro',
                    'eyebrow'  => 'Who we are',
                    'heading'  => 'Jewellery that carries a culture forward',
                    'body'     => "Ethnicoast was born from a simple belief — that heritage jewellery shouldn't live only in glass cases.\n\nEvery piece we create draws from centuries-old craft traditions, reimagined for the modern wardrobe.\n\nFrom the hands that shape the metal to the moment it reaches you, care is the thread that runs through everything we do.",
                    'image'    => null,
                ],
                [
                    'type'    => 'timeline',
                    'heading' => 'How We Grew',
                    'eyebrow' => 'Our journey',
                    'items'   => [
                        ['year' => '2018', 'title' => 'The Beginning',    'body' => 'Started as a small passion project in a living room, sourcing directly from artisans in Rajasthan.'],
                        ['year' => '2020', 'title' => 'Going Online',     'body' => 'Launched our digital storefront and shipped our first 500 orders across India.'],
                        ['year' => '2022', 'title' => 'Community First',  'body' => 'Partnered with 30+ artisan families, introduced the lifetime plating guarantee.'],
                        ['year' => '2024', 'title' => '10,000 Smiles',   'body' => 'Crossed 10,000 customers and expanded to 500+ unique designs.'],
                    ],
                ],
                [
                    'type'    => 'team',
                    'heading' => 'Meet the Team',
                    'eyebrow' => 'The people',
                    'items'   => [
                        ['name' => 'Priya Sharma',  'role' => 'Founder & Creative Director',  'image' => null],
                        ['name' => 'Ravi Menon',    'role' => 'Head of Artisan Relations',    'image' => null],
                        ['name' => 'Anjali Bose',   'role' => 'Customer Experience Lead',     'image' => null],
                    ],
                ],
                [
                    'type'    => 'values',
                    'heading' => 'Our Values',
                    'eyebrow' => 'What we stand for',
                    'items'   => [
                        ['icon' => 'fa-solid fa-hands',       'title' => 'Handcrafted Always',    'body' => 'Every piece is made by skilled artisan hands — never mass-produced.'],
                        ['icon' => 'fa-solid fa-leaf',        'title' => 'Responsible Sourcing',  'body' => 'We choose materials and partners who share our commitment to people and the planet.'],
                        ['icon' => 'fa-solid fa-heart',       'title' => 'Community First',       'body' => 'Fair wages, long-term partnerships, and real stories behind every piece we sell.'],
                    ],
                ],
            ],
            'stats' => [
                ['num' => '10K+', 'label' => 'Happy Customers'],
                ['num' => '500+', 'label' => 'Unique Designs'],
                ['num' => '50+',  'label' => 'Artisan Families'],
                ['num' => '6+',   'label' => 'Years of Craft'],
            ],
            'cta_title'       => 'Find your piece of the story',
            'cta_subtitle'    => 'Explore our latest collections, each one rooted in craft.',
            'cta_button_text' => 'Shop Now',
            'cta_button_url'  => '/collection',
        ]);

        // ── WHY US ───────────────────────────────────────
        StaticPage::updateOrCreate(['slug' => 'why-us'], [
            'hero_title'    => 'Why Choose Us',
            'hero_subtitle' => 'Not all jewellery is made equal. Here\'s what sets us apart.',
            'hero_tag'      => 'The Ethnicoast difference',
            'sections'      => [
                [
                    'type'    => 'pillars',
                    'heading' => 'Built on Three Things',
                    'eyebrow' => 'Our pillars',
                    'items'   => [
                        ['num' => '01', 'icon' => 'fa-solid fa-gem',               'title' => 'Quality Without Compromise', 'body' => 'We use only high-grade base metals with thick plating. Every piece passes a 7-point quality check.'],
                        ['num' => '02', 'icon' => 'fa-solid fa-hands-holding-heart','title' => 'Artisan-Made, Always',       'body' => 'We partner directly with skilled artisan families. No middlemen, no factories.'],
                        ['num' => '03', 'icon' => 'fa-solid fa-shield-halved',     'title' => 'Unmatched After-Care',       'body' => 'Free lifetime plating. 30-day easy exchanges. 9-to-5 customer support.'],
                    ],
                ],
                [
                    'type'    => 'compare',
                    'heading' => 'Ethnicoast vs The Rest',
                    'eyebrow' => 'See the difference',
                    'items'   => [
                        ['feature' => 'Free Lifetime Plating',  'us' => true,  'them' => false],
                        ['feature' => 'Direct Artisan Sourcing','us' => true,  'them' => false],
                        ['feature' => '7-Point Quality Check',  'us' => true,  'them' => false],
                        ['feature' => '30-Day Easy Exchange',   'us' => true,  'them' => false],
                        ['feature' => 'Real Customer Support',  'us' => true,  'them' => 'Sometimes'],
                        ['feature' => 'Transparent Pricing',    'us' => true,  'them' => 'Varies'],
                    ],
                ],
                [
                    'type'    => 'promises',
                    'heading' => 'What We Promise You',
                    'eyebrow' => 'Our commitments',
                    'items'   => [
                        ['icon' => 'fa-solid fa-spray-can-sparkles', 'title' => 'Free Lifetime Plating',  'body' => 'We re-plate it free of charge, for life. No fine print.'],
                        ['icon' => 'fa-solid fa-rotate-left',        'title' => '30-Day Easy Exchange',   'body' => 'Exchange within 30 days, no questions asked.'],
                        ['icon' => 'fa-solid fa-truck-fast',         'title' => 'Free Shipping, Always',  'body' => 'Every order ships free across India.'],
                        ['icon' => 'fa-solid fa-headset',            'title' => 'Real Human Support',     'body' => 'Our team is reachable 9am–5pm, 7 days a week.'],
                    ],
                ],
                [
                    'type'    => 'testimonials',
                    'heading' => 'Don\'t Take Our Word for It',
                    'eyebrow' => 'What customers say',
                    'items'   => [
                        ['stars' => 5, 'quote' => 'The quality is unlike anything I\'ve found at this price point.', 'author' => 'Meera R., Bangalore'],
                        ['stars' => 5, 'quote' => 'Their exchange process was so smooth. Rare to find this kind of service.', 'author' => 'Sunita K., Delhi'],
                        ['stars' => 5, 'quote' => 'Knowing my purchase supports artisan families makes wearing it feel even better.', 'author' => 'Aisha P., Mumbai'],
                    ],
                ],
            ],
            'cta_title'       => 'Ready to experience the difference?',
            'cta_subtitle'    => 'Shop our full collection and find something made just for you.',
            'cta_button_text' => 'Explore Collection',
            'cta_button_url'  => '/collection',
        ]);

        // ── CHAT WITH US ─────────────────────────────────
        StaticPage::updateOrCreate(['slug' => 'chat-with-us'], [
            'hero_title'    => 'Chat With Us',
            'hero_subtitle' => 'Whether it\'s a question, a custom request, or just a hello — we\'d love to hear from you.',
            'hero_tag'      => 'We\'re here for you',
            'sections'      => [
                [
                    'type'    => 'channels',
                    'heading' => 'Choose How to Reach Us',
                    'eyebrow' => 'Get in touch',
                    'items'   => [
                        ['icon' => 'fa-brands fa-whatsapp',  'title' => 'WhatsApp',     'hours' => 'Mon–Sun, 9am–6pm',  'body' => 'The fastest way to reach us. Reply within minutes during business hours.', 'btn_text' => 'Chat on WhatsApp',  'btn_url' => 'https://wa.me/919XXXXXXXXX'],
                        ['icon' => 'fa-solid fa-envelope',   'title' => 'Email Us',     'hours' => 'Response within 24 hrs', 'body' => 'For detailed queries, orders, or feedback. We read every email personally.', 'btn_text' => 'Send an Email',    'btn_url' => 'mailto:hello@ethnicoast.com'],
                        ['icon' => 'fa-brands fa-instagram', 'title' => 'Instagram DM', 'hours' => 'Mon–Sat, 10am–5pm', 'body' => 'Drop us a DM. We\'re happy to share styling tips and upcoming launches.', 'btn_text' => 'Message on Instagram', 'btn_url' => 'https://instagram.com/ethnicoast'],
                    ],
                ],
                [
                    'type'    => 'faq',
                    'heading' => 'Frequently Asked',
                    'eyebrow' => 'Common questions',
                    'items'   => [
                        ['q' => 'How long does delivery take?',               'a' => 'Most orders are dispatched within 1–2 business days and delivered within 3–5 business days.'],
                        ['q' => 'What is the free lifetime plating promise?', 'a' => 'If your jewellery loses its shine, send it back and we\'ll re-plate it free — for life.'],
                        ['q' => 'How do I initiate an exchange?',             'a' => 'WhatsApp or email us within 30 days with your order number. We\'ll arrange a pickup.'],
                        ['q' => 'Do you accept custom orders?',               'a' => 'Yes! Share your reference over WhatsApp or email and we\'ll revert with a quote in 48 hours.'],
                        ['q' => 'Is COD available?',                          'a' => 'COD is available for orders up to ₹2,000 in select pincodes.'],
                    ],
                ],
                [
                    'type'       => 'contact_info',
                    'heading'    => 'Send a Message',
                    'eyebrow'    => 'Write to us',
                    'body'       => 'Fill in the form and the right person on our team will get back to you within 24 hours.',
                    'email'      => 'hello@ethnicoast.com',
                    'whatsapp'   => '+91 9XXXXXXXXX',
                    'hours'      => 'Mon–Sun, 9am–6pm',
                    'form_route' => 'frontend.contact.store',
                ],
            ],
            'cta_title'       => null,
            'cta_button_text' => null,
        ]);

        // ── ANIMAL WELFARE ────────────────────────────────
        StaticPage::updateOrCreate(['slug' => 'animal-welfare'], [
            'hero_title'    => 'Animal Welfare',
            'hero_subtitle' => 'We believe beautiful jewellery should never come at an animal\'s expense. Ever.',
            'hero_tag'      => 'Our Commitment',
            'sections'      => [
                [
                    'type'      => 'statement',
                    'heading'   => '100% Cruelty Free',
                    'eyebrow'   => 'Where we stand',
                    'body'      => "Every material we use, every supplier we work with, and every design we create follows one rule: no animal is harmed.\n\nThis isn't a trend for us — it's been a founding principle since day one.",
                    'big_quote' => '"Style should never ask anything of the natural world that it cannot willingly give."',
                    'body2'     => 'From the stones we source to the packaging we ship in, every decision is made with animals, artisans, and the earth in mind.',
                ],
                [
                    'type'    => 'commitments',
                    'heading' => 'Our Commitments',
                    'eyebrow' => 'What this means in practice',
                    'items'   => [
                        ['num' => '01', 'title' => 'No Animal-Derived Materials', 'body' => 'We use zero ivory, bone, horn, shell, fur, leather, or any other material sourced from animals.'],
                        ['num' => '02', 'title' => 'Lab-Created Stones Only',     'body' => 'Where gemstones are used, we source lab-grown or ethically mined mineral alternatives.'],
                        ['num' => '03', 'title' => 'Supply Chain Audits',         'body' => 'We visit and audit our artisan partners at least once a year. No audit, no partnership.'],
                        ['num' => '04', 'title' => 'Cruelty-Free Packaging',      'body' => 'Our boxes and pouches are made from recycled, plant-based, or sustainably harvested materials.'],
                    ],
                ],
                [
                    'type'    => 'feature_split',
                    'eyebrow' => 'Beyond materials',
                    'heading' => 'Giving Back to the Wild',
                    'body'    => "For every 100 orders placed, we donate to wildlife conservation efforts in India.\n\nWe also choose shipping partners who have committed to carbon-neutral last-mile delivery routes.\n\nThis is not charity. It is accountability.",
                    'image'   => null,
                ],
                [
                    'type'    => 'certifications',
                    'heading' => 'Verified & Committed',
                    'eyebrow' => 'Our standards',
                    'items'   => [
                        ['icon' => 'fa-solid fa-certificate',    'title' => 'PETA Approved',    'body' => 'Recognized by PETA as free from animal testing and animal-derived ingredients.'],
                        ['icon' => 'fa-solid fa-leaf',           'title' => 'Vegan Verified',   'body' => 'All materials used are certified vegan — no silk, lac, beeswax, or shell.'],
                        ['icon' => 'fa-solid fa-shield-halved',  'title' => 'Ethical Sourcing', 'body' => 'Supplier code of conduct includes animal welfare clauses backed by annual review.'],
                    ],
                ],
            ],
            'stats' => [
                ['icon' => 'fa-solid fa-paw',        'label' => 'Status',     'value' => '100% Cruelty Free'],
                ['icon' => 'fa-solid fa-seedling',   'label' => 'Materials',  'value' => 'Zero Animal-Derived'],
                ['icon' => 'fa-solid fa-recycle',    'label' => 'Packaging',  'value' => 'Eco-Conscious'],
                ['icon' => 'fa-solid fa-earth-asia', 'label' => 'Giving Back','value' => 'Wildlife Donations'],
            ],
            'cta_title'       => 'Wear your values',
            'cta_subtitle'    => 'Every piece you buy is a choice that doesn\'t cost the earth — or the creatures on it.',
            'cta_button_text' => 'Shop Cruelty-Free',
            'cta_button_url'  => '/collection',
        ]);
    }
}
