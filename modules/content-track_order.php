<?php
/**
 * Module: Track Order
 * Displays the complete Australia Post Order Tracking section.
 * All content, headlines, steps, and cards are 100% editable from WP Admin.
 */

if (waklert_module_is_empty()) { return; }

// Optional prefilled tracking number from query string
$tracking_param = isset($_GET['tracking']) ? sanitize_text_field(wp_unslash($_GET['tracking'])) : '';
if (!$tracking_param && isset($_GET['order_id'])) {
    $tracking_param = sanitize_text_field(wp_unslash($_GET['order_id']));
}

// 1. Hero & Intro Fields
$badge_text = waklert_content('content_track_order_text_d91016a918');
$page_title = waklert_module_text('heading');
$page_desc  = waklert_content('content_track_order_text_c01564410e');
$intro_p1   = waklert_content('content_track_order_text_7eda1bb78a');
$intro_p2   = waklert_content('content_track_order_text_3ff4e38cc4');

// 2. Tracking Form Fields
$form_heading        = waklert_content('content_track_order_text_a01640ffce');
$form_instructions   = waklert_content('content_track_order_text_1ca723893f');
$input_placeholder   = waklert_module_text('input_placeholder');
$button_text         = waklert_content('content_track_order_text_e9f3de5bf3');
$redirect_notice     = waklert_content('content_track_order_text_e5b9133f02');

// 3. How Order Tracking Works Steps Repeater
$how_heading = waklert_content('content_track_order_text_132953f951');
$how_steps = waklert_module_rows('how_works_steps');

// 4. Need Help & Support Fields
$help_title    = waklert_content('content_track_order_text_20caef60bb');
$help_desc     = waklert_content('content_track_order_text_033dd6ffc9');
$help_btn_text = waklert_content('content_track_order_text_07a6e2adc6');
$help_btn_url  = waklert_module_text('help_btn_url');

// 5. Trust Cards Repeater
$trust_cards = waklert_module_rows('trust_cards');
?>

<!-- 2-Tone Patterned Header -->
<header class="relative overflow-hidden border-b-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-6 sm:py-7 md:py-9" data-testid="track-order-hero">
    <div class="container-site max-w-5xl mx-auto px-4 relative z-10">
        <!-- Breadcrumbs -->
        <div class="mb-3">
            <nav aria-label="<?= esc_attr(waklert_content('content_track_order_text_a020ba8c6a')) ?>" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-dashed border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                <?php if ((waklert_has_content(esc_html(waklert_option_text('breadcrumb_home_label')))) && waklert_has_content(esc_url(home_url('/')))): ?><a href="<?= esc_url(home_url('/')) ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]"><?= esc_html(waklert_option_text('breadcrumb_home_label')) ?></a><?php endif; ?>
                <span class="text-sky-300 font-normal">/</span>
                <?php if (waklert_has_content(esc_html($page_title))): ?><span aria-current="page" class="font-extrabold text-[#0c4161]"><?= esc_html($page_title) ?></span><?php endif; ?>
            </nav>
        </div>

        <!-- Eyebrow Badge -->
        <div class="mb-2.5">
            <?php if (waklert_has_content(esc_html($badge_text))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                <?= esc_html($badge_text) ?>
            </span><?php endif; ?>
        </div>

        <?php if (waklert_has_content(esc_html($page_title))): ?><h1 class="mx-auto max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-[#0c4161]">
            <?= esc_html($page_title) ?>
        </h1><?php endif; ?>
        <?php if (waklert_has_content(esc_html($page_desc))): ?><p class="mx-auto mt-3 max-w-2xl text-sm md:text-base leading-relaxed text-slate-600">
            <?= esc_html($page_desc) ?>
        </p><?php endif; ?>
    </div>
</header>

<!-- Main Content Area -->
<div class="container-site max-w-5xl mx-auto px-4 py-6 sm:py-8 space-y-7 sm:space-y-9">

    <!-- Intro Callout Box (Yellow/Amber Accent Line) -->
    <div class="rounded-2xl border border-slate-200/90 border-l-[6px] border-l-amber-500 bg-gradient-to-r from-amber-50/40 via-white to-white p-5 sm:p-7 shadow-xs">
        <div class="text-sm sm:text-base leading-relaxed text-slate-700 m-0 space-y-3 prose-a:text-[#0c4161] prose-a:font-bold prose-a:underline hover:prose-a:text-amber-600">
            <?php if (waklert_has_content(wp_kses_post(wpautop($intro_p1)))): ?><p class="m-0"><?= wp_kses_post(wpautop($intro_p1)) ?></p><?php endif; ?>
            <?php if ($intro_p2): ?>
                <?php if (waklert_has_content(wp_kses_post(wpautop($intro_p2)))): ?><p class="mt-3 m-0"><?= wp_kses_post(wpautop($intro_p2)) ?></p><?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Main Australia Post Tracking Tool Card (Clean, Focused Single Card) -->
    <section class="rounded-3xl border-2 border-dashed border-sky-300/80 bg-white p-6 sm:p-8 md:p-10 shadow-sm relative overflow-hidden" aria-label="<?= esc_attr(waklert_content('content_track_order_text_ed94aa8399')) ?>">
        <div class="max-w-3xl mx-auto space-y-6">
            <div class="text-center sm:text-left">
                <div class="inline-flex items-center gap-2 rounded-full bg-sky-100 border border-sky-300/80 px-3 py-1 text-xs font-black uppercase tracking-wider text-[#0c4161] mb-2.5">
                    <?= waklert_content_icon('content_track_order_icon_08a7994f1b') ?>
                    <?php if (waklert_has_content(esc_html($form_heading))): ?><span><?= esc_html($form_heading) ?></span><?php endif; ?>
                </div>
                <?php if (waklert_has_content(esc_html($form_heading))): ?><h2 class="font-heading text-2xl sm:text-3xl font-black text-[#0c4161] tracking-tight">
                    <?= esc_html($form_heading) ?>
                </h2><?php endif; ?>
                <?php if (waklert_has_content(wp_kses_post($form_instructions))): ?><p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                    <?= wp_kses_post($form_instructions) ?>
                </p><?php endif; ?>
            </div>

            <!-- Interactive Tracking Form with Pill / Capsule Styling -->
            <form id="auspost-tracking-form" action="https://auspost.com.au/mypost/track/search" method="GET" target="_blank" rel="noopener noreferrer" class="space-y-3">
                <div class="flex flex-col sm:flex-row gap-3 items-stretch">
                    <div class="relative flex-1">
                        <label for="auspost-tracking-input" class="sr-only"><?= esc_html($form_heading) ?></label>
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 sm:pl-5 text-sky-600">
                            <?= waklert_content_icon('content_track_order_icon_79ef7d2a67') ?>
                        </div>
                        <input 
                            type="text" 
                            id="auspost-tracking-input" 
                            name="id" 
                            value="<?= esc_attr($tracking_param) ?>" 
                            placeholder="<?= esc_attr($input_placeholder) ?>" 
                            autocomplete="off"
                            spellcheck="false"
                            class="w-full rounded-full border-2 border-sky-300/80 bg-slate-50/50 pl-12 pr-5 py-3.5 sm:py-4 text-base sm:text-lg font-mono tracking-wider text-slate-900 placeholder:text-slate-400 focus:border-[#0c4161] focus:bg-white focus:outline-none focus:ring-4 focus:ring-sky-100 transition-all shadow-inner"
                        >
                    </div>
                    <?php if (waklert_has_content(esc_html($button_text))): ?><button
                        type="submit" 
                        id="auspost-tracking-btn"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-gradient-to-r from-amber-500 via-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 active:scale-[0.98] text-white px-7 sm:px-9 py-3.5 sm:py-4 text-sm sm:text-base font-black uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-amber-500/25 transition-all shrink-0 cursor-pointer"
                    >
                        <?php if (waklert_has_content(esc_html($button_text))): ?><span><?= esc_html($button_text) ?></span><?php endif; ?>
                        <?= waklert_content_icon('content_track_order_icon_2589fe33dc') ?>
                    </button><?php endif; ?>
                </div>
                <div id="tracking-error-msg" class="hidden text-xs font-semibold text-rose-600 pl-4" role="alert"></div>
            </form>

            <!-- Info Alert Box (Soft Yellow/Amber) -->
            <div class="rounded-2xl border border-amber-200/90 bg-amber-50/70 p-4 flex items-start gap-3">
                <?= waklert_content_icon('content_track_order_icon_4a1ad4e839') ?>
                <?php if (waklert_has_content(wp_kses_post($redirect_notice))): ?><p class="text-xs sm:text-sm text-slate-700 leading-relaxed m-0">
                    <?= wp_kses_post($redirect_notice) ?>
                </p><?php endif; ?>
            </div>
        </div>
    </section>

    <!-- "How Order Tracking Works" Section -->
    <?php if (!empty($how_steps)): ?>
    <section class="space-y-6 pt-2" aria-labelledby="how-tracking-works-heading">
        <div class="border-b border-slate-200 pb-3">
            <?php if (waklert_has_content(esc_html($how_heading))): ?><h2 id="how-tracking-works-heading" class="font-heading text-2xl sm:text-3xl font-black text-[#0c4161] tracking-tight">
                <?= esc_html($how_heading) ?>
            </h2><?php endif; ?>
        </div>

        <div class="space-y-4">
            <?php foreach ($how_steps as $step): 
                $stitle = $step['title'] ?? '';
                $sdesc  = $step['description'] ?? '';
                if (!$stitle) continue;
            ?>
            <div class="rounded-2xl border border-slate-200 bg-white border-t-[4px] border-t-amber-500 p-5 sm:p-6 shadow-xs hover:border-slate-300 transition-all">
                <?php if (waklert_has_content(esc_html($stitle))): ?><h3 class="font-heading text-base sm:text-lg font-black text-slate-900 mb-2">
                    <?= esc_html($stitle) ?>
                </h3><?php endif; ?>
                <?php if (waklert_has_content(esc_html($sdesc))): ?><p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                    <?= esc_html($sdesc) ?>
                </p><?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- "Need Help?" Card -->
    <section class="rounded-2xl border-2 border-dashed border-sky-300/80 bg-gradient-to-r from-sky-50/60 via-white to-sky-50/40 p-6 sm:p-7 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-5" aria-labelledby="need-help-heading">
        <div class="space-y-1.5 max-w-xl">
            <?php if (waklert_has_content(esc_html($help_title))): ?><h3 id="need-help-heading" class="font-heading text-lg sm:text-xl font-extrabold text-[#0c4161]">
                <?= esc_html($help_title) ?>
            </h3><?php endif; ?>
            <?php if (waklert_has_content(wp_kses_post($help_desc))): ?><p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                <?= wp_kses_post($help_desc) ?>
            </p><?php endif; ?>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <?php if ((waklert_has_content(esc_html($help_btn_text))) && waklert_has_content(esc_url($help_btn_url))): ?><a href="<?= esc_url($help_btn_url) ?>" class="inline-flex items-center gap-2 rounded-xl bg-[#0c4161] hover:bg-[#082a40] text-white px-5 py-2.5 text-xs sm:text-sm font-extrabold uppercase tracking-wider shadow-sm transition-all">
                <?php if (waklert_has_content(esc_html($help_btn_text))): ?><span><?= esc_html($help_btn_text) ?></span><?php endif; ?>
                <?= waklert_content_icon('content_track_order_icon_407028e28c') ?>
            </a><?php endif; ?>
        </div>
    </section>

    <!-- 3-Column Value Proposition / Trust Features -->
    <?php if (!empty($trust_cards)): ?>
    <section class="grid grid-cols-1 md:grid-cols-3 gap-5 lg:gap-6 pt-2 pb-6" aria-label="<?= esc_attr(waklert_content('content_track_order_text_09abb1d9d7')) ?>">
        <?php foreach ($trust_cards as $card): 
            $ctype = $card['card_type'] ?? 'shipping';
            $ctitle = $card['title'] ?? '';
            $cdesc = $card['description'] ?? '';
            $cimage = $card['icon_image'] ?? null;
            if (!$ctitle) continue;

            $legacy_map = [
                'shipping' => 'express_shipping',
                'support'  => 'live_chat_support',
                'payment'  => 'aud_checkout',
            ];
            $resolved_preset = $legacy_map[$ctype] ?? $ctype;
            $card_icon_html = waklert_render_card_icon([
                'icon_image'     => $cimage,
                'icon_preset'    => $resolved_preset,
                'title'          => $ctitle,
                'desc'           => $cdesc,
                'default_preset' => 'express_shipping',
                'size_class'     => 'w-10 h-10 shrink-0',
            ]);
        ?>
        <div class="rounded-2xl border-2 border-dashed border-sky-200/90 bg-white p-6 shadow-xs hover:border-sky-400 hover:shadow-md transition-all flex flex-col items-center text-center">
            <?php if (waklert_has_content($card_icon_html)): ?><div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white p-2 shadow-lg shadow-black/10 border-2 border-sky-100 mb-4 shrink-0">
                <?= $card_icon_html ?>
            </div><?php endif; ?>
            <?php if (waklert_has_content(esc_html($ctitle))): ?><h3 class="font-heading font-extrabold text-slate-900 text-base mb-2"><?= esc_html($ctitle) ?></h3><?php endif; ?>
            <?php if (waklert_has_content(esc_html($cdesc))): ?><p class="text-xs sm:text-sm text-slate-600 leading-relaxed m-0">
                <?= esc_html($cdesc) ?>
            </p><?php endif; ?>
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

        if (cleanVal) {
            // When user enters a tracking number, open Australia Post details page which automatically fetches and displays the scan results
            const targetUrl = 'https://auspost.com.au/mypost/track/details/' + encodeURIComponent(cleanVal);
            window.open(targetUrl, '_blank', 'noopener,noreferrer');
        } else {
            // If input is empty, direct link to Australia Post tracking portal
            const portalUrl = 'https://auspost.com.au/mypost/track/';
            window.open(portalUrl, '_blank', 'noopener,noreferrer');
        }
    });

    input.addEventListener('input', function() {
        if (errorMsg && !errorMsg.classList.contains('hidden')) {
            errorMsg.classList.add('hidden');
        }
    });
})();
</script>
