<?php
/**
 * Module: Contact Form & Info
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

if (waklert_module_is_empty()) { return; }

$heading = waklert_module_text('heading');
$desc    = get_sub_field('description');
if (empty($desc)) {
    $desc = '';
}
$breadcrumb_label = waklert_module_text('breadcrumb_label');
$eyebrow = waklert_module_text('eyebrow');

// WhatsApp (number and link fall back to Theme Settings)
$wa_title   = waklert_module_text('whatsapp_title');
$wa_badge   = waklert_module_text('wa_badge');
$wa_link    = waklert_module_text('wa_link_text');
$wa_subtext = waklert_module_text('wa_subtext');
$wa_number  = waklert_module_text('whatsapp_number');
$wa_url     = waklert_module_text('whatsapp_url');
if ($wa_url !== '' && function_exists('waklert_format_whatsapp_url')) {
    $wa_url = waklert_format_whatsapp_url($wa_url);
}

// Email (address falls back to Theme Settings)
$email_title    = waklert_module_text('email_title');
$email_address  = waklert_module_text('contact_email');
$email_timeframe_label = waklert_module_text('email_timeframe_label');
$email_subtext  = waklert_module_text('email_subtext');
$email_link     = waklert_module_text('email_link_text');

// Operating Hours
$hours_title         = waklert_module_text('hours_title');
$hours_mon_fri_label = waklert_module_text('hours_mon_fri_label');
$hours_mon_fri       = waklert_module_text('hours_mon_fri');
$hours_sat_label     = waklert_module_text('hours_sat_label');
$hours_sat           = waklert_module_text('hours_sat');
$hours_sun_label     = waklert_module_text('hours_sun_label');
$hours_sun           = waklert_module_text('hours_sun');

// Map & Address
$address_title   = waklert_module_text('address_title');
$address_line_1  = waklert_module_text('address_line_1');
$address_line_2  = waklert_module_text('address_city_state_zip');
$address_country = waklert_module_text('address_country');
$directions_text = waklert_module_text('directions_text');
$form_eyebrow    = waklert_module_text('form_eyebrow');
$form_title      = waklert_module_text('form_title');
$form_text       = waklert_module_text('form_text');
$form_id         = (int) (get_sub_field('form_id') ?: '');

// Directions URL (link to open in Google Maps)
$entered_directions = waklert_module_text('directions_url');
$default_directions = "https://maps.google.com/?q=" . urlencode($address_line_1 . ', ' . $address_line_2 . ', ' . $address_country);
$directions_url     = $entered_directions ?: $default_directions;

$default_map_embed = '';

$entered_embed = waklert_module_text('google_maps_url');

if (preg_match('/src=["\']([^"\']+)["\']/', $entered_embed, $iframe_match)) {
    $entered_embed = $iframe_match[1];
}

if (strpos($entered_embed, 'maps.app.goo.gl') !== false || strpos($entered_embed, 'goo.gl/maps') !== false || strpos($entered_embed, '/place/') !== false) {
    if (empty($entered_directions)) {
        $directions_url = $entered_embed;
    }
    $google_maps_url = $default_map_embed;
} elseif (!empty($entered_embed) && strpos($entered_embed, '/maps/embed') !== false) {
    $google_maps_url = $entered_embed;
} else {
    $google_maps_url = $default_map_embed;
}
?>

<!-- 2-Tone Patterned Header -->
<header class="relative overflow-hidden border-b-2 border-solid border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-6 sm:py-7 md:py-9">
    <div class="container-site max-w-4xl mx-auto px-4 relative z-10">
        <!-- Breadcrumbs -->
        <div class="mb-3">
            <nav aria-label="<?= esc_attr(waklert_content('content_contact_text_ec89f409f4')) ?>" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-solid border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                <?php if ((waklert_has_content(esc_html(waklert_option_text('breadcrumb_home_label')))) && waklert_has_content(esc_url(home_url('/')))): ?><a href="<?= esc_url(home_url('/')) ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]"><?= esc_html(waklert_option_text('breadcrumb_home_label')) ?></a><?php endif; ?>
                <span class="text-sky-300 font-normal">/</span>
                <?php if (waklert_has_content(esc_html($breadcrumb_label))): ?><span aria-current="page" class="font-extrabold text-[#0c4161]"><?= esc_html($breadcrumb_label) ?></span><?php endif; ?>
            </nav>
        </div>

        <!-- Eyebrow Badge -->
        <?php if ((waklert_has_content(esc_html($eyebrow)))): ?><div class="mb-2.5">
            <?php if (waklert_has_content(esc_html($eyebrow))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse" aria-hidden="true"></span>
                <?= esc_html($eyebrow) ?>
            </span><?php endif; ?>
        </div><?php endif; ?>

        <?php if (waklert_has_content(esc_html($heading))): ?><h1 class="mx-auto max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-[#0c4161]">
            <?= esc_html($heading) ?>
        </h1><?php endif; ?>

        <?php if (waklert_has_content(esc_html($desc))): ?><p class="mx-auto mt-4 max-w-2xl text-sm md:text-base leading-relaxed text-slate-600">
            <?= esc_html($desc) ?>
        </p><?php endif; ?>
    </div>
</header>

<section class="py-7 md:py-10 bg-gradient-to-b from-white via-slate-50/50 to-white">
    <div class="container-site grid gap-8 lg:gap-10 lg:grid-cols-[1fr_1.2fr]">
        
        <!-- Left: Contact Details & Info Cards -->
        <div class="space-y-5">
            
            <!-- WhatsApp Card (Fastest Option) -->
            <a href="<?= esc_url($wa_url) ?>" target="_blank" rel="noopener noreferrer" class="group relative block overflow-hidden rounded-2xl border-2 border-solid border-emerald-300/80 bg-gradient-to-br from-emerald-50/60 via-white to-emerald-50/30 p-6 shadow-xs transition-all duration-200 hover:border-emerald-400 hover:shadow-md">
                <?php if ((waklert_has_content(esc_html($wa_title))) || (waklert_has_content(esc_html($wa_badge))) || (waklert_has_content(esc_html($wa_number))) || (waklert_has_content(esc_html($wa_subtext))) || (waklert_has_content(esc_html($wa_link)) || waklert_has_content(esc_html(waklert_content('content_contact_text_98dd745a32'))))): ?><div class="flex items-start gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-xs group-hover:scale-105 transition-transform">
                        <?= waklert_content_icon('content_contact_icon_45d7697278') ?>
                    </span>
                    <?php if ((waklert_has_content(esc_html($wa_title))) || (waklert_has_content(esc_html($wa_badge))) || (waklert_has_content(esc_html($wa_number))) || (waklert_has_content(esc_html($wa_subtext)))): ?><div class="min-w-0 flex-1">
                        <?php if ((waklert_has_content(esc_html($wa_title))) || (waklert_has_content(esc_html($wa_badge)))): ?><div class="flex items-center gap-2">
                            <?php if (waklert_has_content(esc_html($wa_title))): ?><h2 class="font-heading text-base font-bold text-slate-900"><?= esc_html($wa_title) ?></h2><?php endif; ?>
                            <?php if (waklert_has_content(esc_html($wa_badge))): ?><span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-800">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <?= esc_html($wa_badge) ?>
                            </span><?php endif; ?>
                        </div><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($wa_number))): ?><p class="mt-1 font-mono text-base font-bold text-emerald-700"><?= esc_html($wa_number) ?></p><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($wa_subtext))): ?><p class="mt-1 text-xs text-slate-500"><?= esc_html($wa_subtext) ?></p><?php endif; ?>
                    </div><?php endif; ?>
                    <?php if (waklert_has_content(esc_html($wa_link)) || waklert_has_content(esc_html(waklert_content('content_contact_text_98dd745a32')))): ?><span class="hidden sm:inline-flex items-center text-xs font-bold text-emerald-600 group-hover:translate-x-1 transition-transform">
                        <?= esc_html($wa_link) ?> <?= esc_html(waklert_content('content_contact_text_98dd745a32')) ?>
                    </span><?php endif; ?>
                </div><?php endif; ?>
            </a>

            <!-- Email Card -->
            <a href="<?= esc_url('mailto:' . $email_address) ?>" class="group relative block overflow-hidden rounded-2xl border-2 border-solid border-sky-300/80 bg-gradient-to-br from-sky-50/60 via-white to-sky-50/30 p-6 shadow-xs transition-all duration-200 hover:border-sky-400 hover:shadow-md">
                <?php if ((waklert_has_content(esc_html($email_title))) || (waklert_has_content(esc_html($email_address))) || (waklert_has_content(esc_html($email_timeframe_label)) || waklert_has_content(esc_html($email_subtext))) || (waklert_has_content(esc_html($email_link)) || waklert_has_content(esc_html(waklert_content('content_contact_text_98dd745a32'))))): ?><div class="flex items-start gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#0c4161] text-white shadow-xs group-hover:scale-105 transition-transform">
                        <?= waklert_content_icon('content_contact_icon_ce3ac4136a') ?>
                    </span>
                    <?php if ((waklert_has_content(esc_html($email_title))) || (waklert_has_content(esc_html($email_address))) || (waklert_has_content(esc_html($email_timeframe_label)) || waklert_has_content(esc_html($email_subtext)))): ?><div class="min-w-0 flex-1">
                        <?php if (waklert_has_content(esc_html($email_title))): ?><h2 class="font-heading text-base font-bold text-slate-900"><?= esc_html($email_title) ?></h2><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($email_address))): ?><p class="mt-1 font-mono text-sm font-semibold text-[#0c4161] break-all"><?= esc_html($email_address) ?></p><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($email_timeframe_label)) || waklert_has_content(esc_html($email_subtext))): ?><p class="mt-1 text-xs text-slate-500"><?= esc_html($email_timeframe_label) ?> <?= esc_html($email_subtext) ?></p><?php endif; ?>
                    </div><?php endif; ?>
                    <?php if (waklert_has_content(esc_html($email_link)) || waklert_has_content(esc_html(waklert_content('content_contact_text_98dd745a32')))): ?><span class="hidden sm:inline-flex items-center text-xs font-bold text-sky-700 group-hover:translate-x-1 transition-transform">
                        <?= esc_html($email_link) ?> <?= esc_html(waklert_content('content_contact_text_98dd745a32')) ?>
                    </span><?php endif; ?>
                </div><?php endif; ?>
            </a>

            <!-- Operating Hours Card -->
            <?php if ((waklert_has_content(esc_html($hours_title))) || (waklert_has_content(esc_html($hours_mon_fri_label))) || (waklert_has_content(esc_html($hours_mon_fri))) || (waklert_has_content(esc_html($hours_sat_label))) || (waklert_has_content(esc_html($hours_sat))) || (waklert_has_content(esc_html($hours_sun_label))) || (waklert_has_content(esc_html($hours_sun)))): ?><div class="rounded-2xl border-2 border-solid border-slate-200/90 bg-white p-6 shadow-xs">
                <?php if ((waklert_has_content(esc_html($hours_title)))): ?><div class="flex items-center gap-2 mb-4">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-100 text-[#0c4161]">
                        <?= waklert_content_icon('content_contact_icon_3a9844c53a') ?>
                    </div>
                    <?php if (waklert_has_content(esc_html($hours_title))): ?><h2 class="font-heading text-sm font-black uppercase tracking-wider text-slate-900"><?= esc_html($hours_title) ?></h2><?php endif; ?>
                </div><?php endif; ?>
                <?php if ((waklert_has_content(esc_html($hours_mon_fri_label))) || (waklert_has_content(esc_html($hours_mon_fri))) || (waklert_has_content(esc_html($hours_sat_label))) || (waklert_has_content(esc_html($hours_sat))) || (waklert_has_content(esc_html($hours_sun_label))) || (waklert_has_content(esc_html($hours_sun)))): ?><div class="space-y-3 text-sm">
                    <?php if ((waklert_has_content(esc_html($hours_mon_fri_label))) || (waklert_has_content(esc_html($hours_mon_fri)))): ?><div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <?php if (waklert_has_content(esc_html($hours_mon_fri_label))): ?><span class="text-slate-600 font-medium"><?= esc_html($hours_mon_fri_label) ?></span><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($hours_mon_fri))): ?><span class="font-bold text-slate-900"><?= esc_html($hours_mon_fri) ?></span><?php endif; ?>
                    </div><?php endif; ?>
                    <?php if ((waklert_has_content(esc_html($hours_sat_label))) || (waklert_has_content(esc_html($hours_sat)))): ?><div class="flex items-center justify-between border-b border-slate-100 pb-2">
                        <?php if (waklert_has_content(esc_html($hours_sat_label))): ?><span class="text-slate-600 font-medium"><?= esc_html($hours_sat_label) ?></span><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($hours_sat))): ?><span class="font-bold text-slate-900"><?= esc_html($hours_sat) ?></span><?php endif; ?>
                    </div><?php endif; ?>
                    <?php if ((waklert_has_content(esc_html($hours_sun_label))) || (waklert_has_content(esc_html($hours_sun)))): ?><div class="flex items-center justify-between">
                        <?php if (waklert_has_content(esc_html($hours_sun_label))): ?><span class="text-slate-600 font-medium"><?= esc_html($hours_sun_label) ?></span><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($hours_sun))): ?><span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-bold text-amber-800"><?= esc_html($hours_sun) ?></span><?php endif; ?>
                    </div><?php endif; ?>
                </div><?php endif; ?>
            </div><?php endif; ?>

            <!-- Visit Us / Google Maps Card -->
            <div class="rounded-2xl border-2 border-solid border-slate-200/90 bg-white overflow-hidden shadow-xs">
                <div class="p-6 space-y-3">
                    <?php if ((waklert_has_content(esc_html($address_title)))): ?><div class="flex items-center gap-2 font-heading font-bold text-base text-[#0c4161]">
                        <?= waklert_content_icon('content_contact_icon_ed47200777') ?>
                        <?php if (waklert_has_content(esc_html($address_title))): ?><span><?= esc_html($address_title) ?></span><?php endif; ?>
                    </div><?php endif; ?>
                    <?php
                    $address_parts = array_filter(array_map(function($p) {
                        return rtrim(trim((string) $p), ',');
                    }, [$address_line_1, $address_line_2, $address_country]));
                    $one_line_address = implode(', ', $address_parts);
                    ?>
                    <?php if (waklert_has_content(esc_html($one_line_address))): ?><p class="text-sm leading-relaxed text-slate-600"><?= esc_html($one_line_address) ?></p><?php endif; ?>
                    <div class="pt-1">
                        <?php if ((waklert_has_content(esc_html($directions_text))) && waklert_has_content(esc_url($directions_url))): ?><a href="<?= esc_url($directions_url) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-full bg-sky-50 border border-sky-200/80 px-3.5 py-1.5 text-xs font-bold text-[#0c4161] hover:bg-sky-100 transition-colors">
                            <?php if (waklert_has_content(esc_html($directions_text))): ?><span><?= esc_html($directions_text) ?></span><?php endif; ?>
                            <?= waklert_content_icon('content_contact_icon_4db4001099') ?>
                        </a><?php endif; ?>
                    </div>
                </div>
                <?php if ($google_maps_url): ?>
                <div class="relative w-full h-56 border-t border-slate-200 bg-slate-50">
                    <iframe
                        src="<?= esc_url($google_maps_url) ?>"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="<?= esc_attr($address_title . ' - ' . $one_line_address) ?>"
                        class="w-full h-full">
                    </iframe>
                </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- Right: Message Form Card -->
        <?php if ((waklert_has_content(esc_html($form_eyebrow))) || (waklert_has_content(esc_html($form_title))) || (waklert_has_content(esc_html($form_text))) || (waklert_has_content(do_shortcode('[gravityform id="' . $form_id . '" title="false" description="false" ajax="true"]')))): ?><div class="rounded-3xl border-2 border-solid border-sky-300/80 bg-white p-6 sm:p-8 md:p-10 shadow-xs relative">
            <?php if ((waklert_has_content(esc_html($form_eyebrow))) || (waklert_has_content(esc_html($form_title))) || (waklert_has_content(esc_html($form_text)))): ?><div class="mb-6">
                <?php if (waklert_has_content(esc_html($form_eyebrow))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161]">
                    <?= esc_html($form_eyebrow) ?>
                </span><?php endif; ?>
                <?php if (waklert_has_content(esc_html($form_title))): ?><h2 class="mt-2 font-heading text-2xl font-black text-[#0c4161]"><?= esc_html($form_title) ?></h2><?php endif; ?>
                <?php if (waklert_has_content(esc_html($form_text))): ?><p class="mt-1 text-sm text-slate-500"><?= esc_html($form_text) ?></p><?php endif; ?>
            </div><?php endif; ?>

            <?php if (waklert_has_content(do_shortcode('[gravityform id="' . $form_id . '" title="false" description="false" ajax="true"]'))): ?><div class="contact-form-wrapper">
                <?= do_shortcode('[gravityform id="' . $form_id . '" title="false" description="false" ajax="true"]') ?>
            </div><?php endif; ?>
        </div><?php endif; ?>

    </div>
</section>
