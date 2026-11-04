<?php
/**
 * Shared, field-driven Australia Delivery page template.
 * Redesigned with creative 2-tone dashed brand theme, colorful vector icons, and smooth micro-interactions.
 */
defined('ABSPATH') || exit;

$read = static function ($name) use ($args) {
    return isset($args['fields']) ? ($args['fields'][$name] ?? '') : get_field($name);
};

// h2 when this layout is embedded inside another page (e.g. the homepage already has an h1)
$hero_tag     = (($args['heading_tag'] ?? 'h1') === 'h2') ? 'h2' : 'h1';
$city         = trim((string) $read('city_name')) ?: get_the_title();
$region       = $read('region') ?: waklert_content('australia_delivery_text_93e4bd7b01');
$days         = $read('delivery_days');
$demographic  = $read('demographic');
$industry     = $read('industry');
$facts_date   = $read('facts_date');
$facts_source = $read('facts_source');
$shop         = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
$contact      = home_url('/contact/');
$product_anchor = wp_unique_id('delivery-products-');

$summary = [
    strtr(waklert_content('manual_delivery_12ee315960'), ['{city}' => $city]) => [
        'val'  => $days ?: ($read('delivery_note') ?: waklert_content('australia_delivery_text_410c957697')),
        'sub'  => waklert_content('australia_delivery_text_86fb0ca089'),
        'badge'=> 'bg-emerald-100 text-emerald-800 border-emerald-200',
    ],
    waklert_content('australia_delivery_text_835a694988') => [
        'val'  => $read('shipping_note') ?: waklert_content('australia_delivery_text_77dd221d1e'),
        'sub'  => waklert_content('australia_delivery_text_178fddb27a'),
        'badge'=> 'bg-amber-100 text-amber-800 border-amber-200',
    ],
    waklert_content('australia_delivery_text_643d864756') => [
        'val'  => $read('packaging_note') ?: waklert_content('australia_delivery_text_7bf0d46cd4'),
        'sub'  => waklert_content('manual_delivery_discreet_badge'),
        'badge'=> 'bg-sky-100 text-[#0c4161] border-sky-200',
    ],
    waklert_content('australia_delivery_text_a775b9d01e') => [
        'val'  => $read('tracking_note') ?: waklert_content('australia_delivery_text_d3d1c37a9c'),
        'sub'  => waklert_content('australia_delivery_text_9601945fbc'),
        'badge'=> 'bg-indigo-100 text-indigo-800 border-indigo-200',
    ],
];

$features = $read('features') ?: [
    ['feat' => waklert_content('australia_delivery_text_beb88ccc4e')],
    ['feat' => waklert_content('australia_delivery_text_d52d781a3e')],
    ['feat' => waklert_content('australia_delivery_text_77c8b11ec8')],
    ['feat' => waklert_content('australia_delivery_text_92b6050259')],
];

$reasons = $read('reasons') ?: [
    [
        'title' => waklert_content('manual_delivery_reason_title'),
        'text'  => waklert_content('australia_delivery_text_64db834f9b'),
    ],
    [
        'title' => strtr(waklert_content('manual_delivery_2ad783c17f'), ['{city}' => $city]),
        'text'  => waklert_content('australia_delivery_text_47696ea2b2'),
    ],
    [
        'title' => waklert_content('australia_delivery_text_9f945d3dd2'),
        'text'  => waklert_content('australia_delivery_text_ac0c8d642d'),
    ],
];

$faqs = $read('faqs') ?: [
    [
        'question' => strtr(waklert_content('manual_delivery_0cb40d265e'), ['{city}' => $city]),
        'answer'   => $days ? strtr(waklert_content('manual_delivery_88d5e53136'), ['{days}' => $days]) : waklert_content('australia_delivery_text_6b5171f90e'),
    ],
    [
        'question' => waklert_content('australia_delivery_text_cd4371d3a7'),
        'answer'   => waklert_content('australia_delivery_text_7680afc36f'),
    ],
    [
        'question' => waklert_content('australia_delivery_text_1ba43ab6e0'),
        'answer'   => waklert_content('australia_delivery_text_5d80ca95d7'),
    ],
    [
        'question' => waklert_content('australia_delivery_text_681983d65d'),
        'answer'   => waklert_content('australia_delivery_text_7987326a88'),
    ],
];

$whatsapp_raw = get_field('whatsapp_button_url', 'option') ?: get_field('whatsapp_number', 'option');
$whatsapp     = function_exists('waklert_format_whatsapp_url') ? waklert_format_whatsapp_url($whatsapp_raw) : esc_url($whatsapp_raw ?: home_url('/contact/'));
?>

<!-- ============================================================
     1. HERO SECTION: 2-Tone Gradient + Ambient Rings + Dashed Delivery Glance Card
     ============================================================ -->
<section class="relative isolate overflow-hidden bg-gradient-to-r from-[#082a3f] via-[#0c4161] to-[#125883] bg-pattern-dots-dark text-white border-b-2 border-dashed border-sky-400/30">
    <?php waklert_output_pattern_rings(); ?>

    <div class="container-site relative z-10 grid items-center gap-10 py-8 sm:py-10 md:py-12 lg:py-14 lg:grid-cols-[1.15fr_.85fr] lg:gap-14">
        <!-- Left: City Pitch & Actions -->
        <div>
            <!-- Breadcrumbs Pill -->
            <div class="mb-5 sm:mb-6">
                <nav aria-label="<?= esc_attr(waklert_content('australia_delivery_text_3b345600ae')) ?>" class="inline-flex max-w-full flex-wrap items-center gap-1.5 rounded-full border border-dashed border-sky-300/50 bg-white/10 px-3.5 py-1 text-xs font-medium text-sky-200 backdrop-blur-sm">
                    <a class="font-bold text-white transition-colors hover:text-amber-300" href="<?= esc_url(home_url('/')) ?>"><?= esc_html(waklert_option_text('breadcrumb_home_label')) ?></a>
                    <span aria-hidden="true" class="text-sky-300/60">/</span>
                    <a class="text-sky-200 transition-colors hover:text-white" href="<?= esc_url(home_url('/sitemap/')) ?>"><?= esc_html(waklert_content('australia_delivery_text_935daa936f')) ?></a>
                    <span aria-hidden="true" class="text-sky-300/60">/</span>
                    <span aria-current="page" class="font-extrabold text-amber-300"><?= esc_html($city) ?></span>
                </nav>
            </div>

            <!-- Region Eyebrow -->
            <div class="mb-4">
                <span class="inline-flex items-center gap-2 rounded-full border border-dashed border-amber-400/60 bg-amber-400/15 px-3.5 py-1 text-xs font-black uppercase tracking-widest text-amber-300 shadow-xs">
                    <span class="h-2 w-2 rounded-full bg-amber-400 animate-pulse" aria-hidden="true"></span>
                    <?= esc_html($region) ?>
                </span>
            </div>

            <!-- Main Heading -->
            <<?= $hero_tag ?> class="max-w-2xl font-heading text-3xl sm:text-4xl md:text-5xl lg:text-[3.25rem] font-black leading-[1.12] tracking-tight text-white drop-shadow-sm">
                <?= esc_html($read('hero_heading') ?: strtr(waklert_content('manual_delivery_ba68a4ba18'), ['{city}' => $city])) ?>
            </<?= $hero_tag ?>>

            <!-- Subtitle -->
            <p class="mt-4 sm:mt-5 max-w-xl text-sm sm:text-base leading-relaxed text-sky-100/90 font-medium">
                <?= esc_html($read('hero_desc') ?: strtr(waklert_content('manual_delivery_3f9eb2ca28'), ['{city}' => $city])) ?>
            </p>

            <!-- Compact Action Buttons -->
            <div class="mt-7 sm:mt-8 flex flex-wrap items-center gap-3">
                <a class="group inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 px-5 py-2.5 sm:px-7 sm:py-3.5 text-xs sm:text-sm font-black uppercase tracking-wide text-slate-950 shadow-lg shadow-amber-500/25 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-amber-400" href="<?= esc_url($shop) ?>">
                    <span><?= esc_html($read('shop_button_label') ?: waklert_content('australia_delivery_text_3caf4641a5')) ?></span>
                    <?= waklert_content_icon('australia_delivery_icon_56b959e1ca') ?>
                </a>
                <a class="inline-flex items-center justify-center rounded-full border-2 border-dashed border-sky-300/60 bg-white/10 hover:bg-white/20 px-4 py-2.5 sm:px-6 sm:py-3.5 text-xs sm:text-sm font-extrabold uppercase tracking-wide text-white backdrop-blur-sm transition-all duration-300 hover:-translate-y-0.5 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white" href="#<?= esc_attr($product_anchor) ?>">
                    <?= esc_html($read('products_button_label') ?: waklert_content('australia_delivery_text_3b2f8b9b3a')) ?>
                </a>
            </div>

            <!-- Mini Trust Badges -->
            <div class="mt-6 pt-5 border-t border-dashed border-white/15 flex flex-wrap items-center gap-4 sm:gap-6 text-xs text-sky-200/90 font-medium">
                <span class="inline-flex items-center gap-1.5"><span class="text-amber-400 font-bold"><?= waklert_content_icon('manual_check_marker') ?></span> <?= esc_html(waklert_content('australia_delivery_text_4f3b211dff')) ?></span>
                <span class="inline-flex items-center gap-1.5"><span class="text-emerald-400 font-bold"><?= waklert_content_icon('manual_check_marker') ?></span> <?= esc_html(waklert_content('australia_delivery_text_77a7a42b17')) ?></span>
                <span class="inline-flex items-center gap-1.5"><span class="text-sky-300 font-bold"><?= waklert_content_icon('manual_check_marker') ?></span> <?= esc_html(waklert_content('australia_delivery_text_d9271e0fe5')) ?></span>
            </div>
        </div>

        <!-- Right: 2-Tone Dashed "Delivery at a Glance" Card -->
        <aside aria-label="<?= esc_attr(waklert_content('australia_delivery_text_f097ef76c4')) ?>" class="rounded-3xl border-2 border-dashed border-sky-300/80 bg-white text-slate-800 shadow-2xl p-6 sm:p-7 md:p-8 relative">
            <!-- Accent Top Stripe / Corner Badge -->
            <div class="flex items-center gap-3.5 pb-5 border-b-2 border-dashed border-sky-100">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-sky-50 border border-dashed border-sky-200 shadow-xs">
                    <!-- Colorful Delivery Truck SVG -->
                    <?= waklert_content_icon('australia_delivery_icon_908e379675') ?>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1 text-[11px] font-black uppercase tracking-widest text-[#0c4161]">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        <?= esc_html($read('carrier') ?: waklert_content('australia_delivery_text_935daa936f')) ?>
                    </span>
                    <h2 class="font-heading text-lg sm:text-xl font-black text-[#0c4161] leading-tight">
                        <?= esc_html($read('summary_heading') ?: waklert_content('australia_delivery_text_31226e6dbc')) ?>
                    </h2>
                </div>
            </div>

            <!-- List of Delivery Specs -->
            <div class="divide-y divide-dashed divide-sky-100/90 py-1">
                <?php foreach ($summary as $label => $item): ?>
                <div class="py-3.5 flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold text-[#0c4161]"><?= esc_html($label) ?></p>
                        <p class="text-[11px] text-slate-500 font-medium"><?= esc_html($item['sub']) ?></p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block rounded-lg px-2.5 py-1 text-xs font-extrabold border border-dashed <?= esc_attr($item['badge']) ?>">
                            <?= esc_html($item['val']) ?>
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Card Action Footer -->
            <div class="mt-4 pt-4 border-t-2 border-dashed border-sky-100">
                <a class="group flex items-center justify-between w-full rounded-xl bg-gradient-to-r from-[#0c4161] to-[#082a3f] hover:from-[#082a3f] hover:to-[#0c4161] text-white px-4 py-3 text-xs sm:text-sm font-extrabold tracking-wide shadow-md transition-all duration-300" href="<?= esc_url($contact) ?>">
                    <span><?= esc_html($read('delivery_link_label') ?: waklert_content('australia_delivery_text_30eea535ec')) ?></span>
                    <span class="transition-transform duration-300 group-hover:translate-x-1 font-bold"><?= esc_html(waklert_content('australia_delivery_text_67e45e5a08')) ?></span>
                </a>
            </div>
        </aside>
    </div>
</section>

<!-- ============================================================
     2. TRUST BADGES STRIP (4-Col Vibrant 2-Tone Dashed Cards)
     ============================================================ -->
<div class="bg-gradient-to-b from-[#f0f6fa] to-[#f8fafc] border-b-2 border-dashed border-sky-200/80 py-5 sm:py-6">
    <div class="container-site grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">
        <!-- Badge 1: AusPost -->
        <div class="group flex items-center gap-3 rounded-2xl border-2 border-dashed border-sky-200/80 bg-gradient-to-br from-sky-50/40 to-white p-3 sm:p-3.5 hover:border-sky-400 hover:shadow-sm transition-all">
            <div class="flex h-10 w-10 sm:h-11 sm:w-11 shrink-0 items-center justify-center rounded-xl bg-white border border-sky-200 shadow-xs transition-transform group-hover:scale-105">
                <?= waklert_content_icon('australia_delivery_icon_773654b0e5') ?>
            </div>
            <div>
                <p class="text-[11px] sm:text-xs font-black uppercase tracking-wider text-[#0c4161] leading-tight"><?= esc_html(waklert_content('australia_delivery_text_4d5101250e')) ?></p>
                <p class="text-[10px] text-slate-500 mt-0.5"><?= esc_html(waklert_content('australia_delivery_text_fce9969a88')) ?></p>
            </div>
        </div>

        <!-- Badge 2: 100% Genuine Sun Pharma -->
        <div class="group flex items-center gap-3 rounded-2xl border-2 border-dashed border-amber-200/80 bg-gradient-to-br from-amber-50/40 to-white p-3 sm:p-3.5 hover:border-amber-400 hover:shadow-sm transition-all">
            <div class="flex h-10 w-10 sm:h-11 sm:w-11 shrink-0 items-center justify-center rounded-xl bg-white border border-amber-200 shadow-xs transition-transform group-hover:scale-105">
                <?= waklert_content_icon('australia_delivery_icon_9f169e10b0') ?>
            </div>
            <div>
                <p class="text-[11px] sm:text-xs font-black uppercase tracking-wider text-[#0c4161] leading-tight"><?= esc_html(waklert_content('australia_delivery_text_38a368de2a')) ?></p>
                <p class="text-[10px] text-slate-500 mt-0.5"><?= esc_html(waklert_content('australia_delivery_text_8fe758d33d')) ?></p>
            </div>
        </div>

        <!-- Badge 3: Secure Checkout -->
        <div class="group flex items-center gap-3 rounded-2xl border-2 border-dashed border-emerald-200/80 bg-gradient-to-br from-emerald-50/40 to-white p-3 sm:p-3.5 hover:border-emerald-400 hover:shadow-sm transition-all">
            <div class="flex h-10 w-10 sm:h-11 sm:w-11 shrink-0 items-center justify-center rounded-xl bg-white border border-emerald-200 shadow-xs transition-transform group-hover:scale-105">
                <?= waklert_content_icon('australia_delivery_icon_2d62f7ac47') ?>
            </div>
            <div>
                <p class="text-[11px] sm:text-xs font-black uppercase tracking-wider text-[#0c4161] leading-tight"><?= esc_html(waklert_content('australia_delivery_text_b82a3387f8')) ?></p>
                <p class="text-[10px] text-slate-500 mt-0.5"><?= esc_html(waklert_content('australia_delivery_text_f2e45848d0')) ?></p>
            </div>
        </div>

        <!-- Badge 4: Discreet -->
        <div class="group flex items-center gap-3 rounded-2xl border-2 border-dashed border-sky-200/80 bg-gradient-to-br from-sky-50/40 to-white p-3 sm:p-3.5 hover:border-sky-400 hover:shadow-sm transition-all">
            <div class="flex h-10 w-10 sm:h-11 sm:w-11 shrink-0 items-center justify-center rounded-xl bg-white border border-sky-200 shadow-xs transition-transform group-hover:scale-105">
                <?= waklert_content_icon('australia_delivery_icon_8b097b85f0') ?>
            </div>
            <div>
                <p class="text-[11px] sm:text-xs font-black uppercase tracking-wider text-[#0c4161] leading-tight"><?= esc_html(waklert_content('australia_delivery_text_6aa39e4595')) ?></p>
                <p class="text-[10px] text-slate-500 mt-0.5"><?= esc_html(waklert_content('australia_delivery_text_46537ab9b2')) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     3. ABOUT CITY & ORDERING GUIDANCE (2-Tone Creative Grid)
     ============================================================ -->
<section class="section-padding bg-[#f8fafc] bg-pattern-dots border-b-2 border-dashed border-sky-200/80">
    <div class="container-site grid gap-10 lg:grid-cols-[1.15fr_.85fr] lg:gap-14 items-start">
        <!-- Left: City Narrative -->
        <div>
            <div class="mb-3">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100 border border-dashed border-sky-300 px-3 py-0.5 text-xs font-extrabold uppercase tracking-widest text-[#0c4161]">
                    <?= waklert_content_icon('australia_delivery_icon_c0b9827435') ?>
                    <?= esc_html($read('about_label') ?: strtr(waklert_content('manual_delivery_90d17920a2'), ['{city}' => $city])) ?>
                </span>
            </div>

            <h2 class="font-heading text-2xl sm:text-3xl md:text-4xl font-black tracking-tight text-[#0c4161] leading-tight">
                <?= esc_html($read('about_heading') ?: strtr(waklert_content('manual_delivery_12ee315960'), ['{city}' => $city]) . ($region !== 'Australia' ? ", {$region}" : '')) ?>
            </h2>

            <div class="mt-5 space-y-4 text-sm sm:text-base leading-relaxed text-slate-600 [&_a]:text-[#0c4161] [&_a]:font-bold hover:[&_a]:underline">
                <?= wp_kses_post(wpautop($read('desc') ?: strtr(waklert_content('manual_delivery_0fe57946e1'), ['{city}' => $city]))) ?>
            </div>

            <!-- City Statistics / QuickStats 2-Tone Card -->
            <?php if ($read('population') || $demographic || $industry): ?>
            <div class="mt-6 rounded-2xl border-2 border-dashed border-sky-200/90 bg-white p-5 shadow-xs">
                <div class="flex items-center gap-2 mb-3">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-100 text-amber-600 font-bold text-xs">ℹ</span>
                    <h3 class="text-xs font-black uppercase tracking-wider text-[#0c4161]"><?= esc_html($city) ?> <?= esc_html(waklert_content('australia_delivery_text_d46ac35013')) ?></h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-600">
                    <?php if ($read('population')): ?>
                    <div class="rounded-xl bg-sky-50/50 border border-dashed border-sky-100 p-3">
                        <span class="text-slate-400 block text-[11px]"><?= esc_html(waklert_content('australia_delivery_text_51c6c6823e')) ?></span>
                        <strong class="text-sm font-extrabold text-[#0c4161]"><?= esc_html($read('population')) ?></strong>
                    </div>
                    <?php endif; ?>

                    <?php if ($industry): ?>
                    <div class="rounded-xl bg-sky-50/50 border border-dashed border-sky-100 p-3">
                        <span class="text-slate-400 block text-[11px]"><?= esc_html(waklert_content('australia_delivery_text_951c02290a')) ?></span>
                        <strong class="text-xs font-bold text-slate-800"><?= esc_html($industry) ?></strong>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if ($demographic): ?>
                <p class="mt-3 text-xs text-slate-500 leading-relaxed"><?= esc_html($demographic) ?></p>
                <?php endif; ?>

                <?php if ($facts_source): ?>
                <p class="mt-2 text-[10px] text-slate-400 border-t border-dashed border-slate-100 pt-2">
                    <?= esc_html($facts_date ?: waklert_content('australia_delivery_text_fc28ffc655')) ?>: <a href="<?= esc_url($facts_source) ?>" target="_blank" rel="noopener noreferrer" class="text-[#0c4161] underline hover:text-amber-600"><?= esc_html(waklert_content('australia_delivery_text_a1b5cff01c')) ?></a>
                </p>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Right: 2-Tone "Ordering in {City}" Feature Checklist -->
        <aside class="rounded-3xl border-2 border-dashed border-sky-300 bg-white p-6 sm:p-8 shadow-md">
            <div class="flex items-center gap-3 pb-5 border-b-2 border-dashed border-sky-200/80 mb-5">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 border border-amber-200 text-amber-600">
                    <?= waklert_content_icon('australia_delivery_icon_0b9090adda') ?>
                </div>
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-600"><?= esc_html(waklert_content('australia_delivery_text_a0ad13996e')) ?></span>
                    <h3 class="font-heading text-lg sm:text-xl font-extrabold text-[#0c4161]">
                        <?= esc_html($read('features_heading') ?: strtr(waklert_content('manual_delivery_14a6198e5f'), ['{city}' => $city])) ?>
                    </h3>
                </div>
            </div>

            <ul class="space-y-3.5">
                <?php foreach ($features as $feature): if (empty($feature['feat'])) continue; ?>
                <li class="flex items-start gap-3 rounded-xl border border-dashed border-sky-100 bg-sky-50/40 p-3 transition-colors hover:bg-sky-50/80">
                    <span aria-hidden="true" class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-white font-black text-xs shadow-xs mt-0.5"><?= waklert_content_icon('manual_check_marker') ?></span>
                    <span class="text-xs sm:text-sm font-semibold text-slate-700 leading-snug"><?= esc_html($feature['feat']) ?></span>
                </li>
                <?php endforeach; ?>
            </ul>

            <!-- Quick WhatsApp Assistance in Sidebar -->
            <div class="mt-6 pt-5 border-t-2 border-dashed border-sky-200/80">
                <a href="<?= esc_url($whatsapp) ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between rounded-xl bg-emerald-50 hover:bg-emerald-100/80 border border-dashed border-emerald-300 p-3.5 text-xs font-bold text-emerald-800 transition-colors">
                    <span class="flex items-center gap-2">
                        <?= waklert_content_icon('australia_delivery_icon_07d7c96a3d') ?>
                        <?= esc_html(waklert_content('australia_delivery_text_439ebab824')) ?> <?= esc_html($city) ?>?
                    </span>
                    <span class="underline"><?= esc_html(waklert_content('australia_delivery_text_bfb2de8cc1')) ?></span>
                </a>
            </div>
        </aside>
    </div>
</section>

<!-- ============================================================
     4. "3 REASONS" - AUDIENCE-STYLE 2-TONE DASHED CARDS WITH COLORFUL ICONS
     ============================================================ -->
<section class="section-padding bg-white border-b-2 border-dashed border-sky-200/80">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-12">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 border border-dashed border-amber-300 px-3.5 py-1 text-xs font-black uppercase tracking-widest text-amber-800 mb-3 shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                <?= esc_html(waklert_content('australia_delivery_text_05a193aa61')) ?>
            </span>
            <h2 class="font-heading text-2xl sm:text-3xl md:text-4xl font-black text-[#0c4161] tracking-tight">
                <?= esc_html($read('reasons_heading') ?: strtr(waklert_content('manual_delivery_reasons_heading'), ['{count}' => count($reasons)])) ?>
            </h2>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <?php
            // 3-Tone Palette matching Audience cards
            $card_styles = [
                0 => [
                    'border'   => 'border-sky-300 hover:border-[#0c4161]',
                    'bg_top'   => 'bg-gradient-to-br from-sky-50 via-white to-sky-50/50',
                    'num_bg'   => 'bg-[#0c4161] text-white',
                    'icon_bg'  => 'bg-sky-100/80 border-sky-200',
                    'icon_svg' => waklert_content_icon('australia_delivery_icon_21fb91d91b'),
                ],
                1 => [
                    'border'   => 'border-amber-300 hover:border-amber-500',
                    'bg_top'   => 'bg-gradient-to-br from-amber-50/60 via-white to-amber-50/30',
                    'num_bg'   => 'bg-amber-500 text-white',
                    'icon_bg'  => 'bg-amber-100/80 border-amber-200',
                    'icon_svg' => waklert_content_icon('australia_delivery_icon_7249a4b8ae'),
                ],
                2 => [
                    'border'   => 'border-emerald-300 hover:border-emerald-600',
                    'bg_top'   => 'bg-gradient-to-br from-emerald-50/60 via-white to-emerald-50/30',
                    'num_bg'   => 'bg-emerald-600 text-white',
                    'icon_bg'  => 'bg-emerald-100/80 border-emerald-200',
                    'icon_svg' => waklert_content_icon('australia_delivery_icon_9f6162a225'),
                ],
            ];

            foreach ($reasons as $index => $reason):
                $cfg = $card_styles[$index % 3];
            ?>
            <article class="group relative flex flex-col rounded-3xl border-2 border-dashed <?= esc_attr($cfg['border']) ?> bg-white overflow-hidden shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300">
                <!-- Top 2-Tone Banner Block -->
                <div class="<?= esc_attr($cfg['bg_top']) ?> p-6 pb-4 border-b-2 border-dashed border-sky-100/80 flex items-center justify-between">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white border border-dashed <?= esc_attr($cfg['icon_bg']) ?> shadow-xs transition-transform duration-300 group-hover:scale-110">
                        <?= $cfg['icon_svg'] ?>
                    </div>
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full <?= esc_attr($cfg['num_bg']) ?> font-heading font-black text-xs shadow-xs">
                        <?= esc_html(sprintf('%02d', $index + 1)) ?>
                    </span>
                </div>

                <!-- Content Area -->
                <div class="p-6 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-heading text-lg font-black text-[#0c4161] leading-snug mb-2">
                            <?= esc_html($reason['title'] ?? '') ?>
                        </h3>
                        <p class="text-xs sm:text-sm leading-relaxed text-slate-600">
                            <?= esc_html($reason['text'] ?? '') ?>
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-dashed border-slate-100 flex items-center gap-1.5 text-xs font-bold text-[#0c4161] group-hover:text-amber-600 transition-colors">
                        <span><?= esc_html(waklert_content('australia_delivery_text_3e366ccc6d')) ?></span>
                        <span><?= esc_html(waklert_content('australia_delivery_text_67e45e5a08')) ?></span>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     5. PRODUCTS COLLECTION GRID (Dashed Cards + Compact Sizing)
     ============================================================ -->
<section id="<?= esc_attr($product_anchor) ?>" class="section-padding scroll-mt-24 bg-[#f8fafc] bg-pattern-dots border-b-2 border-dashed border-sky-200/80">
    <div class="container-site">
        <div class="mb-10 text-center max-w-2xl mx-auto">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100 border border-dashed border-sky-300 px-3.5 py-1 text-xs font-extrabold uppercase tracking-widest text-[#0c4161] mb-3 shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <?= esc_html($read('products_label') ?: waklert_content('australia_delivery_text_e09f2ae718')) ?>
            </span>
            <h2 class="font-heading text-2xl sm:text-3xl md:text-4xl font-black text-[#0c4161] tracking-tight">
                <?= esc_html($read('products_heading') ?: strtr(waklert_content('manual_delivery_785b84ea0d'), ['{city}' => $city])) ?>
            </h2>
            <p class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed">
                <?= esc_html($read('products_desc') ?: waklert_content('australia_delivery_text_6eacd4aac0')) ?>
            </p>
        </div>

        <?php
        $ids = array_filter(array_map('absint', (array) $read('selected_products')));
        $query_args = ['post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 4, 'orderby' => 'menu_order', 'order' => 'ASC'];
        if ($ids) { $query_args['post__in'] = $ids; $query_args['orderby'] = 'post__in'; }
        if (function_exists('wc_get_product_visibility_term_ids')) {
            $visibility = wc_get_product_visibility_term_ids();
            $query_args['tax_query'] = [['taxonomy' => 'product_visibility', 'field' => 'term_taxonomy_id', 'terms' => [$visibility['exclude-from-catalog']], 'operator' => 'NOT IN']];
        }
        $products = new WP_Query($query_args);
        if (function_exists('wc_get_product') && $products->have_posts()): ?>
            <div class="grid grid-cols-2 gap-3.5 sm:gap-5 lg:grid-cols-4">
                <?php $previous_product = $GLOBALS['product'] ?? null;
                while ($products->have_posts()): $products->the_post();
                    $GLOBALS['product'] = wc_get_product(get_the_ID());
                    wc_get_template_part('content', 'product');
                endwhile;
                wp_reset_postdata();
                $GLOBALS['product'] = $previous_product;
                ?>
            </div>
        <?php else: ?>
            <p class="text-center text-slate-500 py-8 bg-white rounded-2xl border-2 border-dashed border-sky-200">
                <?= esc_html(waklert_content('australia_delivery_text_5ccf2d5a68')) ?>
            </p>
        <?php endif; ?>

        <div class="mt-9 text-center">
            <a class="inline-flex items-center gap-2 rounded-full border-2 border-dashed border-sky-300 bg-white hover:bg-[#0c4161] text-[#0c4161] hover:text-white px-5 py-2.5 sm:px-7 sm:py-3 text-xs sm:text-sm font-extrabold uppercase tracking-wider text-primary transition-all shadow-xs hover:shadow-md hover:-translate-y-0.5" href="<?= esc_url($shop) ?>">
                <span><?= esc_html($read('all_products_label') ?: waklert_content('australia_delivery_text_6455d2c1df')) ?></span>
                <?= waklert_content_icon('australia_delivery_icon_76d2e7c21a') ?>
            </a>
        </div>
    </div>
</section>

<!-- ============================================================
     6. CUSTOMER REVIEWS (2-Tone Cards with Star Glow)
     ============================================================ -->
<?php $reviews = $read('reviews') ?: []; if ($reviews): ?>
<section class="section-padding bg-white border-b-2 border-dashed border-sky-200/80">
    <div class="container-site">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 border border-dashed border-emerald-300 px-3.5 py-1 text-xs font-black uppercase tracking-widest text-emerald-800 mb-3 shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <?= esc_html(waklert_content('australia_delivery_text_7506e3cf6a')) ?>
            </span>
            <h2 class="font-heading text-2xl sm:text-3xl md:text-4xl font-black text-[#0c4161] tracking-tight">
                <?= esc_html(waklert_content('australia_delivery_text_2bd3c45e60')) ?> <?= esc_html($city) ?>
            </h2>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <?php foreach ($reviews as $review): $rating = max(0, min(5, (int) ($review['rating'] ?? 0))); ?>
            <figure class="rounded-3xl border-2 border-dashed border-sky-200/90 bg-gradient-to-br from-sky-50/40 via-white to-white p-6 sm:p-7 shadow-xs hover:shadow-md hover:border-sky-400 hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-3">
                    <?php if ($rating): ?>
                    <p aria-label="<?= esc_attr(strtr(waklert_content('manual_delivery_25b96f7534'), ['{rating}' => $rating])) ?>" class="text-amber-400 tracking-wider text-sm">
                        <?= str_repeat(waklert_content_icon('manual_star_marker'), $rating) ?>
                    </p>
                    <?php endif; ?>
                    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                        <span class="text-emerald-500 font-bold"><?= waklert_content_icon('manual_check_marker') ?></span> <?= esc_html(waklert_content('australia_delivery_text_be90fd1d75')) ?>
                    </span>
                </div>
                <blockquote class="text-xs sm:text-sm leading-relaxed text-slate-600 mb-4">
                    “<?= esc_html($review['text'] ?? '') ?>”
                </blockquote>
                <figcaption class="flex items-center gap-3 pt-3 border-t border-dashed border-sky-100 text-xs font-bold text-[#0c4161]">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-sky-100 text-[#0c4161] font-black text-xs border border-sky-300">
                        <?= esc_html(strtoupper(substr($review['author'] ?? 'C', 0, 1))) ?>
                    </span>
                    <span><?= esc_html($review['author'] ?? '') ?></span>
                    <span class="font-normal text-slate-400"><?= esc_html(waklert_content('australia_delivery_text_b02299444b')) ?> <?= esc_html($review['date'] ?? '') ?></span>
                </figcaption>
            </figure>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================================================
     7. DELIVERY FAQS (Interactive 2-Tone Dashed Accordions)
     ============================================================ -->
<section class="section-padding bg-[#f8fafc] bg-pattern-dots border-b-2 border-dashed border-sky-200/80">
    <div class="container-site max-w-4xl">
        <div class="mb-10 text-center">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100 border border-dashed border-sky-300 px-3.5 py-1 text-xs font-extrabold uppercase tracking-widest text-[#0c4161] mb-3 shadow-xs">
                <?= esc_html($read('faq_label') ?: waklert_content('australia_delivery_text_5ded0e1472')) ?>
            </span>
            <h2 class="font-heading text-2xl sm:text-3xl md:text-4xl font-black text-[#0c4161] tracking-tight">
                <?= esc_html($read('faq_heading') ?: strtr(waklert_content('manual_delivery_16ace2911a'), ['{city}' => $city])) ?>
            </h2>
        </div>

        <div class="space-y-3.5">
            <?php foreach ($faqs as $index => $faq): if (empty($faq['question']) || empty($faq['answer'])) continue; ?>
            <details class="group rounded-2xl border-2 border-dashed border-sky-200/90 bg-white overflow-hidden transition-all duration-200 open:border-[#0c4161] open:shadow-md">
                <summary class="flex cursor-pointer list-none items-center justify-between p-4 sm:p-5 font-extrabold text-[#0c4161] text-xs sm:text-sm hover:bg-sky-50/50 [&::-webkit-details-marker]:hidden">
                    <span class="flex items-center gap-3 pr-4">
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-sky-100 text-[#0c4161] font-black text-xs border border-sky-300">
                            <?= esc_html((string) ($index + 1)) ?>
                        </span>
                        <span><?= esc_html($faq['question']) ?></span>
                    </span>
                    <span aria-hidden="true" class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-sky-50 text-[#0c4161] text-base font-bold transition-transform duration-200 group-open:rotate-45">
                        +
                    </span>
                </summary>
                <div class="px-5 pb-5 pt-2 text-xs sm:text-sm leading-relaxed text-slate-600 border-t-2 border-dashed border-sky-100 bg-sky-50/30 prose prose-sm max-w-none [&_a]:text-[#0c4161] [&_a]:underline [&_a]:font-bold">
                    <?= wp_kses_post(wpautop($faq['answer'])) ?>
                </div>
            </details>
            <?php endforeach; ?>
        </div>

        <p class="mt-8 text-center">
            <?php $faq_link_text = trim(str_replace(['→', '->', '&rarr;'], '', (string) ($read('faq_link_label') ?: waklert_content('australia_delivery_text_40b632b193')))); ?>
            <a class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-extrabold text-[#0c4161] hover:text-amber-600 transition-colors underline underline-offset-4 decoration-sky-300 hover:decoration-amber-500" href="<?= esc_url(home_url('/faq/')) ?>">
                <span><?= esc_html($faq_link_text) ?></span>
                <span aria-hidden="true"><?= esc_html(waklert_content('australia_delivery_text_67e45e5a08')) ?></span>
            </a>
        </p>
    </div>
</section>

<!-- ============================================================
     8. CREATIVE 2-TONE SUPPORT & CTA BANNER (Dashed + Pattern Rings)
     ============================================================ -->
<section class="section-padding bg-white">
    <div class="container-site max-w-4xl">
        <div class="relative isolate overflow-hidden rounded-[2.5rem] bg-gradient-to-r from-[#082a3f] via-[#0c4161] to-[#125883] bg-pattern-dots-dark p-8 sm:p-12 md:p-14 text-white shadow-2xl border-2 border-dashed border-sky-400/40 text-center">
            <?php waklert_output_pattern_rings(); ?>

            <div class="relative z-10 max-w-2xl mx-auto">
                <span class="inline-flex items-center gap-2 rounded-full bg-amber-400/20 border border-amber-300/40 px-3.5 py-1 text-xs font-black uppercase tracking-[0.2em] text-amber-300 mb-4 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <?= esc_html(waklert_content('australia_delivery_text_007552f10a')) ?>
                </span>

                <h2 class="font-heading text-2xl sm:text-3xl md:text-4xl font-black text-white leading-tight tracking-tight mb-4">
                    <?= esc_html($read('cta_heading') ?: strtr(waklert_content('manual_delivery_e88b1426ff'), ['{city}' => $city])) ?>
                </h2>

                <p class="text-sky-100/90 text-xs sm:text-sm md:text-base leading-relaxed mb-8 max-w-xl mx-auto font-medium">
                    <?= esc_html($read('cta_desc') ?: strtr(waklert_content('manual_delivery_dceb64d7b1'), ['{city}' => $city])) ?>
                </p>

                <div class="flex flex-wrap items-center justify-center gap-3">
                    <a class="group inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 px-5 py-2.5 sm:px-8 sm:py-3.5 text-xs sm:text-sm font-black uppercase tracking-wide text-slate-950 shadow-lg shadow-amber-500/25 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-xl" href="<?= esc_url($shop) ?>">
                        <span><?= esc_html($read('cta_button_label') ?: waklert_content('australia_delivery_text_4012c41c69')) ?></span>
                        <?= waklert_content_icon('australia_delivery_icon_fdbd3685a5') ?>
                    </a>
                    <a href="<?= esc_url($whatsapp) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border-2 border-dashed border-white/40 bg-white/10 hover:bg-white/20 px-4 py-2.5 sm:px-6 sm:py-3.5 text-xs sm:text-sm font-bold text-white backdrop-blur-sm transition hover:-translate-y-0.5">
                        <?= waklert_content_icon('australia_delivery_icon_6ef2d1394a') ?>
                        <span><?= esc_html(waklert_content('australia_delivery_text_ece128500a')) ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
