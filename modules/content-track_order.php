<?php
/**
 * Module: Track Order
 * Displays the complete Australia Post Order Tracking section.
 * All content, headlines, pills, banners, steps, and cards are 100% editable from WP Admin.
 */

// Optional prefilled tracking number from query string
$tracking_param = isset($_GET['tracking']) ? sanitize_text_field(wp_unslash($_GET['tracking'])) : '';
if (!$tracking_param && isset($_GET['order_id'])) {
    $tracking_param = sanitize_text_field(wp_unslash($_GET['order_id']));
}

// 1. Hero & Intro Fields
$badge_text = get_sub_field('badge_text') ?: 'Live Australia Post Tracking';
$page_title = get_sub_field('heading') ?: get_the_title() ?: 'Track Your Parcel';
$page_desc  = get_sub_field('description') ?: 'Follow your Waklert Australia delivery from our warehouse to your doorstep with real-time Australia Post tracking.';
$intro_p1   = get_sub_field('intro_callout_p1') ?: 'Welcome to the Waklert Australia order tracking page. Every parcel we dispatch is shipped with Australia Post and comes with a unique tracking number, so you can follow your delivery from our warehouse to your door.';
$intro_p2   = get_sub_field('intro_callout_p2') ?: "Your tracking number was emailed to you when your order was dispatched. Enter it below and we'll take you straight to the live Australia Post tracking results for your parcel.";

// 2. Tracking Form Fields
$form_heading      = get_sub_field('form_heading') ?: 'Enter Your Tracking Number';
$form_instructions = get_sub_field('form_instructions') ?: 'Tracking numbers are usually 10–23 characters long, e.g. 33ABC1234567. You can find yours in your dispatch confirmation email.';
$input_placeholder = get_sub_field('input_placeholder') ?: 'e.g. 33ABC1234567';
$button_text       = get_sub_field('track_btn_text') ?: 'Track My Order';
$redirect_notice   = get_sub_field('redirect_notice') ?: "You'll be redirected to the official Australia Post tracking page (auspost.com.au), where your parcel's latest scan events are shown automatically.";

// Keyword Pills Repeater
$quick_links = get_sub_field('keyword_pills');
if (empty($quick_links) || !is_array($quick_links)) {
    $quick_links = [
        ['label' => 'Order Tracking', 'url' => '#auspost-tracking-form', 'is_external' => false],
        ['label' => 'Australia Post', 'url' => 'https://auspost.com.au/', 'is_external' => true],
        ['label' => 'Buy Modafinil Australia', 'url' => home_url('/shop/'), 'is_external' => false],
        ['label' => 'Shipping Australia', 'url' => home_url('/shipping-policy/'), 'is_external' => false],
        ['label' => 'Buy Modvigil Online', 'url' => home_url('/product/waklert-150mg-2/'), 'is_external' => false],
        ['label' => 'Buy Artvigil', 'url' => home_url('/product/artvigil-150mg/'), 'is_external' => false],
        ['label' => 'Waklert Australia', 'url' => home_url('/'), 'is_external' => false],
        ['label' => 'Modafinil Buy Australia', 'url' => home_url('/armodafinil-guide/'), 'is_external' => false],
    ];
}

// 3. Companion Delivery Banner Fields
$banner_partner_label = get_sub_field('banner_partner_label') ?: 'Official Partner';
$banner_partner_logo  = get_sub_field('banner_partner_logo');
if (is_array($banner_partner_logo) && !empty($banner_partner_logo['url'])) {
    $partner_logo_url = $banner_partner_logo['url'];
} elseif (is_string($banner_partner_logo) && !empty(trim($banner_partner_logo))) {
    $partner_logo_url = $banner_partner_logo;
} else {
    $partner_logo_url = get_theme_file_uri('/assets/images/australia-post.png');
}
$banner_brand_badge = get_sub_field('banner_brand_badge') ?: 'Waklert Australia';
$banner_kicker      = get_sub_field('banner_kicker') ?: 'Direct Express Delivery';
$banner_title_1     = get_sub_field('banner_title_1') ?: 'JUST STAY AT HOME';
$banner_title_2     = get_sub_field('banner_title_2') ?: 'WE DELIVER!';
$banner_safe_stamp  = get_sub_field('banner_safe_stamp') ?: '100% SAFE';
$banner_btn_text    = get_sub_field('banner_button_text') ?: 'ORDER NOW';
$banner_btn_link    = get_sub_field('banner_button_link') ?: home_url('/shop/');
$banner_domain      = get_sub_field('banner_domain') ?: 'waklertaustralia.com';

// 4. How Order Tracking Works Steps Repeater
$how_heading = get_sub_field('how_works_heading') ?: 'How Order Tracking Works';
$how_steps   = get_sub_field('how_works_steps');
if (empty($how_steps) || !is_array($how_steps)) {
    $how_steps = [
        [
            'title' => '1. Order Dispatched',
            'description' => 'Once your order leaves our facility, we email you a dispatch confirmation containing your Australia Post tracking number.'
        ],
        [
            'title' => '2. Enter Your Number',
            'description' => 'Paste the tracking number into the field above and select "Track My Order". We\'ll open your parcel\'s results on the Australia Post website.'
        ],
        [
            'title' => '3. Follow Your Parcel',
            'description' => 'Australia Post updates scan events at each stage — accepted, in transit, onboard for delivery, and delivered.'
        ]
    ];
}

// 5. Need Help & Support Fields
$help_title    = get_sub_field('help_heading') ?: 'Need Help?';
$help_desc     = get_sub_field('help_description') ?: "Can't find your tracking number or no scans after 3 business days? Contact our support team and we'll look into it.";
$help_btn_text = get_sub_field('help_btn_text') ?: 'Contact Support';
$help_btn_url  = get_sub_field('help_btn_url') ?: home_url('/contact/');

// 6. Trust Cards Repeater
$trust_cards = get_sub_field('trust_cards');
if (empty($trust_cards) || !is_array($trust_cards)) {
    $trust_cards = [
        [
            'card_type'   => 'shipping',
            'title'       => 'Free Shipping',
            'description' => 'On orders over $200 AUD — enjoy fast, secure, and discreet delivery right to your doorstep.'
        ],
        [
            'card_type'   => 'support',
            'title'       => '24/7 Support',
            'description' => 'We’re here to help anytime — day or night, our team is ready to assist you with your orders and inquiries.'
        ],
        [
            'card_type'   => 'payment',
            'title'       => 'Secure Payment',
            'description' => 'Shop with confidence — all transactions are 100% safe, encrypted, and protected for your peace of mind.'
        ]
    ];
}
?>

<!-- 2-Tone Patterned Header -->
<header class="relative overflow-hidden border-b-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-6 sm:py-7 md:py-9" data-testid="track-order-hero">
    <div class="container-site max-w-5xl mx-auto px-4 relative z-10">
        <!-- Breadcrumbs -->
        <div class="mb-3">
            <nav aria-label="Breadcrumb" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-dashed border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                <a href="<?= esc_url(home_url('/')) ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]">Home</a>
                <span class="text-sky-300 font-normal">/</span>
                <span aria-current="page" class="font-extrabold text-[#0c4161]"><?= esc_html($page_title) ?></span>
            </nav>
        </div>

        <!-- Eyebrow Badge -->
        <div class="mb-2.5">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                <?= esc_html($badge_text) ?>
            </span>
        </div>

        <h1 class="mx-auto max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-[#0c4161]">
            <?= esc_html($page_title) ?>
        </h1>
        <p class="mx-auto mt-3 max-w-2xl text-sm md:text-base leading-relaxed text-slate-600">
            <?= esc_html($page_desc) ?>
        </p>
    </div>
</header>

<!-- Main Content Area -->
<div class="container-site max-w-5xl mx-auto px-4 py-6 sm:py-8 space-y-7 sm:space-y-9">

    <!-- Intro Callout Box (Yellow/Amber Accent Line) -->
    <div class="rounded-2xl border border-slate-200/90 border-l-[6px] border-l-amber-500 bg-gradient-to-r from-amber-50/40 via-white to-white p-5 sm:p-7 shadow-xs">
        <div class="text-sm sm:text-base leading-relaxed text-slate-700 m-0 space-y-3 prose-a:text-[#0c4161] prose-a:font-bold prose-a:underline hover:prose-a:text-amber-600">
            <p class="m-0"><?= wp_kses_post(wpautop($intro_p1)) ?></p>
            <?php if ($intro_p2): ?>
                <p class="mt-3 m-0"><?= wp_kses_post(wpautop($intro_p2)) ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- 2-Column Main Tracker & Companion Banner Section -->
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-stretch" aria-label="Tracking Tool and Information">
        
        <!-- Left Column: Tracking Form & Keywords -->
        <div class="lg:col-span-7 xl:col-span-7 flex flex-col justify-between space-y-6">
            <div>
                <h2 class="font-heading text-2xl sm:text-3xl font-black text-[#0c4161] tracking-tight">
                    <?= esc_html($form_heading) ?>
                </h2>
                <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    <?= wp_kses_post($form_instructions) ?>
                </p>

                <!-- Interactive Tracking Form -->
                <form id="auspost-tracking-form" action="https://auspost.com.au/mypost/track/search" method="GET" target="_blank" rel="noopener noreferrer" class="mt-5 space-y-3">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <label for="auspost-tracking-input" class="sr-only"><?= esc_html($form_heading) ?></label>
                            <input 
                                type="text" 
                                id="auspost-tracking-input" 
                                name="id" 
                                value="<?= esc_attr($tracking_param) ?>" 
                                placeholder="<?= esc_attr($input_placeholder) ?>" 
                                autocomplete="off"
                                spellcheck="false"
                                required
                                class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 sm:py-3.5 text-base sm:text-lg font-mono tracking-wider text-slate-900 placeholder:text-slate-400 focus:border-[#0c4161] focus:bg-white focus:outline-none focus:ring-4 focus:ring-sky-100 transition-all shadow-inner"
                            >
                        </div>
                        <button 
                            type="submit" 
                            id="auspost-tracking-btn"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 active:scale-[0.98] text-white px-6 sm:px-7 py-3 sm:py-3.5 text-sm sm:text-base font-black uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-amber-500/20 transition-all shrink-0 cursor-pointer"
                        >
                            <span><?= esc_html($button_text) ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                    <div id="tracking-error-msg" class="hidden text-xs font-semibold text-rose-600 pl-1" role="alert"></div>
                </form>

                <!-- Info Alert Box (Soft Yellow/Amber) -->
                <div class="mt-4 rounded-xl border border-amber-200/90 bg-amber-50/70 p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed m-0">
                        <?= wp_kses_post($redirect_notice) ?>
                    </p>
                </div>
            </div>

            <!-- Keyword / Quick Navigation Pills -->
            <?php if (!empty($quick_links)): ?>
            <div class="pt-2">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-2.5">Popular Searches & Quick Links</p>
                <div class="flex flex-wrap gap-2 sm:gap-2.5">
                    <?php foreach ($quick_links as $pill): 
                        $plabel = $pill['label'] ?? '';
                        $purl   = $pill['url'] ?? '#';
                        $pext   = !empty($pill['is_external']);
                        if (!$plabel) continue;
                    ?>
                        <a 
                            href="<?= esc_url($purl) ?>" 
                            <?= $pext ? 'target="_blank" rel="noopener noreferrer"' : '' ?>
                            class="inline-flex items-center gap-1 rounded-full border border-amber-200/90 bg-amber-50/70 hover:bg-amber-100/90 text-slate-700 hover:text-slate-900 px-3.5 py-1.5 text-xs font-bold transition-all shadow-2xs"
                        >
                            <span><?= esc_html($plabel) ?></span>
                            <?php if ($pext): ?>
                                <svg class="w-3 h-3 opacity-60" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right Column: Visual Companion Banner -->
        <div class="lg:col-span-5 xl:col-span-5 flex">
            <div class="w-full rounded-3xl border-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#eef7fd] via-[#f7fbfe] to-white p-6 sm:p-7 shadow-sm flex flex-col justify-between items-center text-center relative overflow-hidden group hover:shadow-md transition-all">
                
                <!-- Background Map Watermark SVG -->
                <div class="absolute -right-6 -bottom-6 w-56 h-56 opacity-10 pointer-events-none text-sky-700" aria-hidden="true">
                    <svg viewBox="0 0 200 160" fill="currentColor">
                        <path d="M165,115 C155,120 145,135 130,135 C115,135 110,145 95,140 C80,135 70,120 60,110 C50,100 35,90 30,75 C25,60 30,45 45,35 C60,25 80,30 95,20 C110,10 135,15 150,30 C165,45 175,70 175,85 C175,100 175,110 165,115 Z"/>
                    </svg>
                </div>

                <!-- Top Australia Post & Brand Header -->
                <div class="w-full flex items-center justify-between gap-3 pb-3 border-b border-sky-200/60 relative z-10">
                    <div class="flex items-center gap-2">
                        <img src="<?= esc_url($partner_logo_url) ?>" alt="<?= esc_attr($banner_partner_label) ?>" class="h-6 sm:h-7 w-auto object-contain">
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-rose-700"><?= esc_html($banner_partner_label) ?></span>
                    </div>
                    <span class="inline-flex items-center gap-1 rounded-full bg-sky-100 border border-sky-300/80 px-2.5 py-0.5 text-[10px] font-black uppercase tracking-wider text-[#0c4161]">
                        <?= esc_html($banner_brand_badge) ?>
                    </span>
                </div>

                <!-- Hero Callout Heading -->
                <div class="my-4 relative z-10">
                    <p class="font-heading text-xs font-black uppercase tracking-[0.2em] text-slate-500 mb-1"><?= esc_html($banner_kicker) ?></p>
                    <h3 class="font-heading text-2xl sm:text-3xl font-black text-slate-900 leading-tight">
                        <?= esc_html($banner_title_1) ?>
                    </h3>
                    <p class="font-heading text-2xl sm:text-3xl font-black text-sky-600 tracking-tight leading-tight">
                        <?= esc_html($banner_title_2) ?>
                    </p>
                </div>

                <!-- Visual Illustration (Courier & Scooter with Safe Badge) -->
                <div class="relative my-3 w-full max-w-[240px] flex items-center justify-center">
                    <svg viewBox="0 0 200 150" class="w-full h-auto drop-shadow-md" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 135H190" stroke="#CBD5E1" stroke-width="3" stroke-linecap="round" stroke-dasharray="6 6"/>
                        <circle cx="50" cy="115" r="18" fill="#1E293B" stroke="#64748B" stroke-width="4"/>
                        <circle cx="50" cy="115" r="8" fill="#94A3B8"/>
                        <circle cx="50" cy="115" r="3" fill="#FFFFFF"/>
                        <circle cx="150" cy="115" r="18" fill="#1E293B" stroke="#64748B" stroke-width="4"/>
                        <circle cx="150" cy="115" r="8" fill="#94A3B8"/>
                        <circle cx="150" cy="115" r="3" fill="#FFFFFF"/>
                        <path d="M50 115L75 110L90 115L120 115L135 90L150 115" stroke="#0284C7" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M75 110L85 85L125 85L135 90" fill="#0284C7"/>
                        <path d="M125 85L140 60L130 55" stroke="#0369A1" stroke-width="5" stroke-linecap="round"/>
                        <rect x="70" y="80" width="35" height="8" rx="4" fill="#0F172A"/>
                        <rect x="42" y="60" width="32" height="26" rx="4" fill="#E11D48"/>
                        <rect x="44" y="62" width="28" height="22" rx="2" fill="#BE123C"/>
                        <path d="M58 60V86M42 73H74" stroke="#FFE4E6" stroke-width="1.8"/>
                        <circle cx="58" cy="73" r="5" fill="#FFFFFF"/>
                        <path d="M56 71C58 69.5 60 71 60 73C60 75 58 76 56 74" stroke="#BE123C" stroke-width="1.2" stroke-linecap="round"/>
                        <path d="M92 85L105 105L120 105" stroke="#0369A1" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M95 85L110 65" stroke="#0284C7" stroke-width="10" stroke-linecap="round"/>
                        <path d="M108 67L128 62" stroke="#0284C7" stroke-width="4" stroke-linecap="round"/>
                        <circle cx="118" cy="48" r="12" fill="#0284C7"/>
                        <path d="M118 42C124 42 129 46 129 52H118V42Z" fill="#38BDF8"/>
                        <path d="M124 50H132" stroke="#0F172A" stroke-width="2.5" stroke-linecap="round"/>
                    </svg>

                    <!-- Safe Stamp Badge -->
                    <?php if ($banner_safe_stamp): ?>
                    <div class="absolute -top-2 -right-2 bg-gradient-to-br from-rose-500 to-rose-600 text-white rounded-full p-2.5 shadow-lg border-2 border-white flex flex-col items-center justify-center w-14 h-14 rotate-12">
                        <span class="text-[10px] font-black leading-tight text-center uppercase"><?= esc_html($banner_safe_stamp) ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- CTA Button -->
                <div class="w-full relative z-10 mt-3">
                    <a href="<?= esc_url($banner_btn_link) ?>" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#0284c7] to-[#0c4161] hover:from-[#0369a1] hover:to-[#082a40] text-white font-extrabold uppercase tracking-wider text-xs sm:text-sm py-3 px-5 shadow-md hover:shadow-lg transition-all active:scale-[0.98]">
                        <span><?= esc_html($banner_btn_text) ?></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>

                <!-- Website Domain Stamp -->
                <div class="mt-3 pt-3 border-t border-sky-200/60 w-full flex items-center justify-center gap-1.5 text-xs font-bold text-slate-600 relative z-10">
                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                    <span><?= esc_html($banner_domain) ?></span>
                </div>
            </div>
        </div>
    </section>

    <!-- "How Order Tracking Works" Section -->
    <?php if (!empty($how_steps)): ?>
    <section class="space-y-6 pt-2" aria-labelledby="how-tracking-works-heading">
        <div class="border-b border-slate-200 pb-3">
            <h2 id="how-tracking-works-heading" class="font-heading text-2xl sm:text-3xl font-black text-[#0c4161] tracking-tight">
                <?= esc_html($how_heading) ?>
            </h2>
        </div>

        <div class="space-y-4">
            <?php foreach ($how_steps as $step): 
                $stitle = $step['title'] ?? '';
                $sdesc  = $step['description'] ?? '';
                if (!$stitle) continue;
            ?>
            <div class="rounded-2xl border border-slate-200 bg-white border-t-[4px] border-t-amber-500 p-5 sm:p-6 shadow-xs hover:border-slate-300 transition-all">
                <h3 class="font-heading text-base sm:text-lg font-black text-slate-900 mb-2">
                    <?= esc_html($stitle) ?>
                </h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                    <?= esc_html($sdesc) ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- "Need Help?" Card -->
    <section class="rounded-2xl border-2 border-dashed border-sky-300/80 bg-gradient-to-r from-sky-50/60 via-white to-sky-50/40 p-6 sm:p-7 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5" aria-labelledby="need-help-heading">
        <div class="space-y-1.5 max-w-xl">
            <h3 id="need-help-heading" class="font-heading text-lg sm:text-xl font-extrabold text-[#0c4161]">
                <?= esc_html($help_title) ?>
            </h3>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                <?= wp_kses_post($help_desc) ?>
            </p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="<?= esc_url($help_btn_url) ?>" class="inline-flex items-center gap-2 rounded-xl bg-[#0c4161] hover:bg-[#082a40] text-white px-5 py-2.5 text-xs sm:text-sm font-extrabold uppercase tracking-wider shadow-sm transition-all">
                <span><?= esc_html($help_btn_text) ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </a>
        </div>
    </section>

    <!-- 3-Column Value Proposition / Trust Features -->
    <?php if (!empty($trust_cards)): ?>
    <section class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-6 pt-2 pb-6" aria-label="Key Benefits">
        <?php foreach ($trust_cards as $card): 
            $ctype = $card['card_type'] ?? 'shipping';
            $ctitle = $card['title'] ?? '';
            $cdesc = $card['description'] ?? '';
            if (!$ctitle) continue;
        ?>
        <div class="rounded-2xl border-2 border-dashed border-sky-200/90 bg-white p-6 shadow-xs hover:border-sky-400 hover:shadow-md transition-all flex flex-col items-center text-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white p-2 shadow-lg shadow-black/10 border-2 border-sky-100 mb-4 shrink-0">
                <?php if ($ctype === 'support'): ?>
                    <!-- 24/7 Support Shield SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-10 h-10 shrink-0" fill="none" aria-hidden="true">
                        <ellipse cx="32" cy="55" rx="18" ry="2.5" fill="#0C4161" fill-opacity="0.15" />
                        <path d="M32 7L16 13.5V27C16 40.5 23 48.5 32 52.5C41 48.5 48 40.5 48 27V13.5L32 7Z" fill="#0284C7" />
                        <path d="M32 10L18.5 15.5V27C18.5 38.5 24.5 45.8 32 49.2C39.5 45.8 45.5 38.5 45.5 27V15.5L32 10Z" fill="#38BDF8" />
                        <circle cx="32" cy="29" r="10" fill="#0C4161" />
                        <path d="M26 29H38M32 23V35" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" />
                    </svg>
                <?php elseif ($ctype === 'payment'): ?>
                    <!-- Secure Lock Shield SVG (Amber/Gold tones) -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-10 h-10 shrink-0" fill="none" aria-hidden="true">
                        <ellipse cx="32" cy="55" rx="18" ry="2.5" fill="#0C4161" fill-opacity="0.15" />
                        <path d="M32 7L16 13.5V27C16 40.5 23 48.5 32 52.5C41 48.5 48 40.5 48 27V13.5L32 7Z" fill="#D97706" />
                        <path d="M32 10L18.5 15.5V27C18.5 38.5 24.5 45.8 32 49.2C39.5 45.8 45.5 38.5 45.5 27V15.5L32 10Z" fill="#F59E0B" />
                        <rect x="25" y="27" width="14" height="12" rx="2.5" fill="#FFFFFF" />
                        <path d="M28 27V23C28 20.8 29.8 19 32 19C34.2 19 36 20.8 36 23V27" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" />
                        <circle cx="32" cy="33" r="1.5" fill="#B45309" />
                    </svg>
                <?php else: ?>
                    <!-- AusPost Delivery Van SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-10 h-10 shrink-0" fill="none" aria-hidden="true">
                        <ellipse cx="32" cy="55" rx="20" ry="2.5" fill="#0C4161" fill-opacity="0.15" />
                        <rect x="6" y="20" width="34" height="24" rx="3" fill="#DC2626" />
                        <path d="M40 25H49.5C51.5 25 53.2 26.2 54 28L57.5 35.5C57.8 36.2 58 37 58 37.8V44H40V25Z" fill="#B91C1C" />
                        <path d="M42 27H49L53.5 35H42V27Z" fill="#FEE2E2" />
                        <rect x="10" y="27" width="26" height="5" rx="1.5" fill="#FFFFFF" fill-opacity="0.9" />
                        <circle cx="18" cy="46" r="6.5" fill="#1E293B" stroke="#F1F5F9" stroke-width="2" />
                        <circle cx="18" cy="46" r="2.5" fill="#FFFFFF" />
                        <circle cx="48" cy="46" r="6.5" fill="#1E293B" stroke="#F1F5F9" stroke-width="2" />
                        <circle cx="48" cy="46" r="2.5" fill="#FFFFFF" />
                        <circle cx="56" cy="40" r="1.5" fill="#FBBF24" />
                    </svg>
                <?php endif; ?>
            </div>
            <h3 class="font-heading font-extrabold text-slate-900 text-base mb-2"><?= esc_html($ctitle) ?></h3>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                <?= esc_html($cdesc) ?>
            </p>
        </div>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

</div>

<!-- Client-side Tracker Redirection Script -->
<script>
(function() {
    const form = document.getElementById('auspost-tracking-form');
    const input = document.getElementById('auspost-tracking-input');
    const errorMsg = document.getElementById('tracking-error-msg');

    if (!form || !input) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const rawVal = input.value || '';
        const cleanVal = rawVal.replace(/[\s\-]/g, '');

        if (!cleanVal) {
            if (errorMsg) {
                errorMsg.textContent = 'Please enter your Australia Post tracking number.';
                errorMsg.classList.remove('hidden');
            }
            input.focus();
            return;
        }

        if (errorMsg) {
            errorMsg.classList.add('hidden');
        }

        const targetUrl = 'https://auspost.com.au/mypost/track/#/details/' + encodeURIComponent(cleanVal);
        window.open(targetUrl, '_blank', 'noopener,noreferrer');
    });

    input.addEventListener('input', function() {
        if (errorMsg && !errorMsg.classList.contains('hidden')) {
            errorMsg.classList.add('hidden');
        }
    });
})();
</script>
