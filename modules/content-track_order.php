<?php
/**
 * Module: Track Order
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

$badge = get_sub_field('badge_text') ?: "Live Parcel Tracking";
$heading = get_sub_field('heading') ?: "Track Your Order";
$desc = get_sub_field('description') ?: "Use the carrier tracking reference supplied in your dispatch email to follow your package directly with Australia Post.";

$box_heading = get_sub_field('track_box_heading') ?: "Ready to track your parcel?";
$box_desc = get_sub_field('track_box_desc') ?: "All parcels are dispatched in discreet, unbranded packaging via tracked postal services. Enter your reference directly on the carrier portal or contact our Australian support team.";

$btn_text = get_sub_field('track_btn_text') ?: "Contact Order Support";
$btn_link = get_sub_field('track_btn_link') ?: home_url('/contact/');

$metro_estimate = trim((string) (get_sub_field('est_peninsular_days') ?: ''));
$remote_estimate = trim((string) (get_sub_field('est_sabah_sarawak_days') ?: ''));

if (empty($metro_estimate) || $metro_estimate === 'Varies') {
    $metro_estimate = "5–10";
}
if (empty($remote_estimate) || $remote_estimate === 'Varies') {
    $remote_estimate = "7–14";
}
?>

<!-- 2-Tone Patterned Header -->
<header class="relative overflow-hidden border-b-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-8 md:py-14">
    <div class="container-site max-w-4xl mx-auto px-4 relative z-10">
        <!-- Breadcrumb Pill -->
        <div class="mb-3">
            <nav aria-label="Breadcrumb" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-dashed border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                <a href="<?= esc_url(home_url('/')) ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]">Home</a>
                <span class="text-sky-300 font-normal">/</span>
                <span aria-current="page" class="font-extrabold text-[#0c4161]">Track Your Order</span>
            </nav>
        </div>

        <!-- Eyebrow Badge -->
        <div class="mb-2.5">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse" aria-hidden="true"></span>
                <?= esc_html($badge) ?>
            </span>
        </div>

        <h1 class="mx-auto max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-[#0c4161]">
            <?= esc_html($heading) ?>
        </h1>

        <p class="mx-auto mt-4 max-w-2xl text-sm md:text-base leading-relaxed text-slate-600">
            <?= esc_html($desc) ?>
        </p>
    </div>
</header>

<section class="py-10 md:py-16 bg-gradient-to-b from-white via-slate-50/40 to-white">
    <div class="container-site max-w-4xl space-y-10">
        
        <!-- Main Tracking Action Box -->
        <div class="relative overflow-hidden rounded-3xl border-2 border-dashed border-sky-300/80 bg-gradient-to-br from-[#f0f6fa] via-white to-sky-50/30 p-8 sm:p-12 text-center shadow-xs">
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#0c4161] text-amber-400 shadow-sm mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/>
                    <path d="M15 18H9"/>
                    <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/>
                    <circle cx="17" cy="18" r="2"/>
                    <circle cx="7" cy="18" r="2"/>
                </svg>
            </div>

            <h2 class="font-heading text-2xl sm:text-3xl font-black text-[#0c4161]">
                <?= esc_html($box_heading) ?>
            </h2>

            <p class="mx-auto mt-3 max-w-xl text-sm sm:text-base leading-relaxed text-slate-600">
                <?= esc_html($box_desc) ?>
            </p>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-wrap items-center justify-center gap-3.5">
                <a href="https://auspost.com.au/mypost/track/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-[#0c4161] hover:bg-[#082c42] text-white px-6 py-3 text-sm font-bold shadow-sm transition-colors">
                    <span>Australia Post Portal</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
                
                <a href="<?= esc_url($btn_link) ?>" class="inline-flex items-center gap-2 rounded-full bg-white hover:bg-slate-50 text-[#0c4161] border border-sky-300 px-6 py-3 text-sm font-bold shadow-xs transition-colors">
                    <?= esc_html($btn_text) ?>
                </a>
            </div>
        </div>

        <!-- Estimated Delivery Timeframes -->
        <div>
            <div class="text-center mb-6">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161]">
                    Logistics Schedule
                </span>
                <h3 class="mt-2 font-heading text-xl sm:text-2xl font-black text-[#0c4161]">
                    Estimated Delivery Timeframes
                </h3>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="rounded-2xl border-2 border-dashed border-sky-200/90 bg-white p-6 shadow-xs text-center sm:text-left transition-all hover:border-sky-400">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        <h4 class="font-heading font-bold text-slate-900 text-base">Metro &amp; Regional Hubs</h4>
                    </div>
                    <div class="mt-2 text-3xl sm:text-4xl font-black text-[#0c4161]">
                        <?= esc_html($metro_estimate) ?> <span class="text-sm font-semibold text-slate-500">business days</span>
                    </div>
                    <p class="mt-2 text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Sydney, Melbourne, Brisbane, Perth, Adelaide, Canberra, Hobart, and major surrounding regional postal zones.
                    </p>
                </div>

                <div class="rounded-2xl border-2 border-dashed border-amber-200/90 bg-white p-6 shadow-xs text-center sm:text-left transition-all hover:border-amber-400">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                        <h4 class="font-heading font-bold text-slate-900 text-base">Remote &amp; FIFO Locations</h4>
                    </div>
                    <div class="mt-2 text-3xl sm:text-4xl font-black text-amber-600">
                        <?= esc_html($remote_estimate) ?> <span class="text-sm font-semibold text-slate-500">business days</span>
                    </div>
                    <p class="mt-2 text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Regional WA, Far North Queensland, Northern Territory, and remote mining sites serviced by Australia Post.
                    </p>
                </div>
            </div>
        </div>

        <!-- Help / Reship Guarantee Strip -->
        <div class="rounded-2xl border-2 border-dashed border-slate-200/90 bg-white p-6 sm:p-8 text-center shadow-xs">
            <h4 class="font-heading font-bold text-base text-slate-900 mb-2">Tracking Not Updating Yet?</h4>
            <p class="text-xs sm:text-sm text-slate-600 max-w-xl mx-auto leading-relaxed">
                Carrier systems typically take 24–48 hours after parcel lodgement to reflect initial tracking scans. If your parcel is delayed beyond normal transit windows, our <a href="<?= esc_url(home_url('/refund-policy/')) ?>" class="font-bold text-[#0c4161] hover:underline">100% Free Reshipment Guarantee</a> covers you completely.
            </p>
            <div class="mt-4">
                <a href="<?= esc_url(home_url('/contact/')) ?>" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0c4161] hover:text-amber-600 transition-colors">
                    <span>Contact Order Support Team</span>
                    <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>

    </div>
</section>
