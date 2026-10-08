<?php
/**
 * Track Order Module
 */

$badge = get_sub_field('badge_text') ?: "Track Order";

$heading = get_sub_field('heading') ?: "Track Your Order";

$desc = get_sub_field('description') ?: "Use the tracking link supplied after dispatch to follow your order.";

$box_heading = get_sub_field('track_box_heading') ?: "Need help tracking your order?";

$box_desc = get_sub_field('track_box_desc') ?: "Use the carrier link and tracking reference in your dispatch email. Contact our order support team if you need help.";

$btn_text = get_sub_field('track_btn_text') ?: "Contact Order Support";
$btn_link = get_sub_field('track_btn_link') ?: home_url('/contact/');

$metro_estimate = trim((string) (get_sub_field('est_peninsular_days') ?: ''));
$remote_estimate = trim((string) (get_sub_field('est_sabah_sarawak_days') ?: ''));
$metro_has_day_range = (bool) preg_match('/^\d+\s*[-–]\s*\d+$/', $metro_estimate);
$remote_has_day_range = (bool) preg_match('/^\d+\s*[-–]\s*\d+$/', $remote_estimate);
?>
<section class="section-padding bg-white text-center">
    <div class="container-custom max-w-3xl">
        <span class="inline-block bg-primary-softer text-primary-dark text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4">
            <?= $badge ?>
        </span>
        <h1 class="font-heading text-4xl md:text-5xl font-black text-slate-900 mb-4">
            <?= $heading ?>
        </h1>
        <p class="text-slate-500 max-w-2xl mx-auto leading-relaxed">
            <?= $desc ?>
        </p>
    </div>
</section>

<section class="pb-16 bg-white">
    <div class="container-custom max-w-3xl">
        <!-- Tracking Box -->
        <div class="flex flex-col items-center rounded-2xl border border-primary/20 bg-primary-softer/50 px-6 py-10 text-center shadow-sm sm:px-12">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-primary">
                <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/>
                <path d="M15 18H9"/>
                <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/>
                <circle cx="17" cy="18" r="2"/>
                <circle cx="7" cy="18" r="2"/>
            </svg>
            
            <h2 class="mt-5 font-heading text-xl font-bold text-slate-900">
                <?= $box_heading ?>
            </h2>
            <p class="mt-3 text-sm leading-relaxed text-slate-500 sm:text-base">
                <?= $box_desc ?>
            </p>
            <a href="<?= esc_url($btn_link) ?>" class="mt-6 inline-flex items-center gap-2 rounded-full bg-primary hover:bg-primary-dark px-6 py-3 text-sm font-bold text-primary-foreground shadow-md transition-colors">
                <?= $btn_text ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
                </svg>
            </a>
        </div>

        <!-- Estimates -->
        <div class="mt-12">
            <h2 class="font-heading text-xl font-bold text-slate-900 text-center sm:text-left">
                <?= "Estimated Delivery Time" ?>
            </h2>
            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm text-center sm:text-left">
                    <h3 class="font-semibold text-slate-900"><?= "Metro & regional destinations" ?></h3>
                    <div class="mt-2 <?= $metro_has_day_range ? 'text-4xl' : 'text-lg' ?> font-extrabold text-primary">
                        <?= $metro_has_day_range ? esc_html($metro_estimate) : 'Check carrier estimate' ?>
                    </div>
                    <p class="mt-1 text-sm text-slate-500">
                        <?= $metro_has_day_range ? 'business days from dispatch' : 'Timing depends on the carrier and destination.' ?>
                    </p>
                </div>
                <div class="rounded-xl border border-stone-200 bg-white p-6 shadow-sm text-center sm:text-left">
                    <h3 class="font-semibold text-slate-900"><?= "Remote destinations" ?></h3>
                    <div class="mt-2 <?= $remote_has_day_range ? 'text-4xl' : 'text-lg' ?> font-extrabold text-primary">
                        <?= $remote_has_day_range ? esc_html($remote_estimate) : 'Check carrier estimate' ?>
                    </div>
                    <p class="mt-1 text-sm text-slate-500">
                        <?= $remote_has_day_range ? 'business days from dispatch' : 'Timing depends on the carrier and destination.' ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Text -->
        <div class="mt-12 text-center">
            <p class="text-sm leading-relaxed text-slate-500">
                <?= "Contact order support if tracking has not updated within the carrier's estimated timeframe." ?>
                <a href="/refund-policy" class="font-medium text-primary hover:text-primary-dark hover:underline">
                    <?= "Read our policy." ?>
                </a>
            </p>
            <p class="mt-8 text-sm text-slate-500">
                <?= "Still have questions about your order?" ?>
            </p>
            <a href="<?= esc_url(home_url('/contact/')) ?>" class="mt-4 inline-flex items-center rounded-full bg-slate-900 px-6 py-3 text-sm font-bold text-white shadow-md transition-colors hover:bg-slate-800">
                <?= "Contact Support" ?>
            </a>
        </div>
    </div>
</section>
