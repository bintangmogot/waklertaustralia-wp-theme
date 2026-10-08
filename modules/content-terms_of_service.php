<?php
/**
 * Terms of Service Module
 */

$title = get_sub_field('title') ?: "Terms & Conditions";

$subtitle = get_sub_field('subtitle') ?: "By accessing this website and placing an order, you agree to the terms below.";

$default_badges = [
    ['Age 18+ Verification', 'Kelayakan 18+ Tahun'],
    ['Therapeutic Goods Act 1989 Compliance', 'Pematuhan Akta Racun 1952'],
    ['Personal Use Only', 'Kegunaan Peribadi Sahaja']
];

$default_sections = [
    [
        'title' => '1. Eligibility & Age Restriction / Kelayakan',
        'content' => 'You must be at least 18 years of age to access this site and place an order. By completing an order, you confirm that products ordered are strictly for your personal use and not for unauthorized commercial resale.',
    ],
    [
        'title' => '2. Medical Disclaimer / Penafian Perubatan',
        'content' => 'All content on this site is provided for educational purposes only. Modafinil is a prescription medication in Australia regulated under the Therapeutic Goods Act 1989. We are not licensed medical providers. Always consult a licensed medical practitioner before use.',
    ],
    [
        'title' => '3. Orders & Pricing / Pesanan & Harga',
        'content' => 'All prices are displayed in Australian Dollars (AUD) and are subject to change without prior notice. We reserve the right to decline or cancel any order suspected of fraud, abuse, or violation of these terms. Orders are dispatched only after payment is confirmed.',
    ],
    [
        'title' => '4. Shipping & Delivery / Penghantaran',
        'content' => 'Deliveries are fulfilled via Australia Post — taking 7-12 working days for the East Coast and 10-16 working days for Sabah & Sarawak. Timeframes are estimated. Free shipping applies to orders A$399 and above.',
    ],
    [
        'title' => '5. Customer Responsibility / Tanggungjawab Pelanggan',
        'content' => 'You are responsible for providing an accurate and complete delivery address upon checkout. Orders that fail to deliver due to incorrect address information provided by the customer are not eligible for automatic refunds.',
    ],
    [
        'title' => '6. Limitation of Liability / Had Liabiliti',
        'content' => 'Waklert Australia accepts no liability for personal side effects, damages, or losses resulting from product use. Our maximum financial liability is strictly limited to the purchase amount paid for the specific order.',
    ],
    [
        'title' => '7. Terms Modifications / Perubahan Terma',
        'content' => 'We reserve the right to revise or update these terms at any time. Continued use of the website following changes constitutes acceptance of the modified terms.',
    ]
];
?>
<section class="bg-slate-900 text-white py-16 text-center relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-primary/20 to-slate-900 pointer-events-none"></div>
    <div class="container-custom max-w-3xl relative z-10">
        <span class="inline-block bg-accent/15 text-accent text-xs font-bold uppercase tracking-widest px-3.5 py-1.5 rounded-full mb-4 border border-accent/30">
            <?= "User Agreement & Terms" ?>
        </span>
        <h1 class="font-heading text-4xl md:text-5xl font-black mb-4 tracking-tight">
            <?= $title ?>
        </h1>
        <p class="text-slate-300 max-w-2xl mx-auto leading-relaxed text-base md:text-lg mb-8">
            <?= $subtitle ?>
        </p>

        <!-- Badge Pills -->
        <div class="flex flex-wrap justify-center gap-3">
            <?php if (have_rows('badges')): ?>
                <?php while (have_rows('badges')): the_row(); ?>
                <span class="inline-flex items-center gap-1.5 bg-accent/10 border border-accent/30 text-accent text-xs font-bold px-4 py-2 rounded-full shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-accent" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <?= get_sub_field('badge') ?>
                </span>
                <?php endwhile; ?>
            <?php else: ?>
                <?php foreach ($default_badges as $b): ?>
                <span class="inline-flex items-center gap-1.5 bg-accent/10 border border-accent/30 text-accent text-xs font-bold px-4 py-2 rounded-full shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-accent" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    <?= $b[0] ?>
                </span>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section-padding bg-white">
    <div class="container-custom max-w-3xl space-y-8">
        <?php if (have_rows('sections')): ?>
            <?php while (have_rows('sections')): the_row();
                $s_title = get_sub_field('title');
                $s_content = get_sub_field('content');
                $content = $s_content;
            ?>
            <div class="bg-stone-50/70 border border-stone-200 rounded-2xl p-6 md:p-8 hover:border-emerald-200 transition-all">
                <h2 class="font-heading font-black text-xl text-slate-900 mb-4 pb-2 border-b border-stone-200 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                    <?= $s_title ?>
                </h2>
                <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line space-y-3">
                    <?= esc_html($content) ?>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <?php foreach ($default_sections as $sec):
                $content = $sec['content'];
            ?>
            <div class="bg-stone-50/70 border border-stone-200 rounded-2xl p-6 md:p-8 hover:border-emerald-200 transition-all">
                <h2 class="font-heading font-black text-xl text-slate-900 mb-4 pb-2 border-b border-stone-200 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                    <?= $sec['title'] ?>
                </h2>
                <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                    <?= esc_html($content) ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Contact Callout -->
        <div class="mt-12 bg-slate-900 text-white rounded-2xl p-8 text-center shadow-lg">
            <h2 class="font-heading font-extrabold text-2xl mb-3">
                <?= "Have questions about our terms?" ?>
            </h2>
            <p class="text-slate-300 text-sm mb-6 max-w-lg mx-auto leading-relaxed">
                <?= "Contact our legal support team via WhatsApp for any clarifications before placing your order." ?>
            </p>
            <a href="https://wa.me/60185754182" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-accent text-accent-foreground font-bold px-7 py-3.5 rounded-full hover:brightness-105 transition-colors shadow-md text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"></path>
                </svg>
                <?= "Support WhatsApp" ?>
            </a>
        </div>
    </div>
</section>
