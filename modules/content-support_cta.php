<?php
/**
 * Module: Support CTA Banner
 * Matches the Kamagra-style rounded gradient card in Waklert brand colours
 * Features editable customer support representative image (guy with phone)
 */

if (waklert_module_is_empty()) { return; }

$GLOBALS['waklert_support_cta_rendered'] = true;

$eyebrow = waklert_module_text('eyebrow');
$title = waklert_module_text('title');
$description = waklert_module_text('desc');

$chat_label = waklert_module_text('chat_btn_text');
$chat_url = trim((string) get_sub_field('chat_btn_url'));
if ($chat_url !== '' && !preg_match('#^https?://#i', $chat_url)) {
    $chat_url = function_exists('waklert_format_whatsapp_url') ? waklert_format_whatsapp_url($chat_url) : $chat_url;
}

$sms_label = waklert_module_text('sms_btn_text');
$sms_url = trim((string) get_sub_field('sms_btn_url'));
if ($sms_url !== '') {
    $sms_scheme = preg_match('#^tel:#i', $sms_url) ? 'tel' : 'sms';
    $sms_url = function_exists('waklert_format_tel_url') ? waklert_format_tel_url($sms_url, $sms_scheme) : 'sms:+61488841833';
}

$contact_label = waklert_module_text('email_btn_text');
$contact_url = trim((string) get_sub_field('email_btn_url'));
$default_email = function_exists('get_field') ? (get_field('support_email', 'option') ?: get_field('contact_email', 'option') ?: 'orders@waklertaustralia.com.au') : 'orders@waklertaustralia.com.au';
if (strpos($default_email, 'example.com') !== false || strpos($default_email, 'hoppingmad') !== false || strpos($default_email, 'modaaust') !== false) {
    $default_email = 'orders@waklertaustralia.com.au';
}

if (filter_var($contact_url, FILTER_VALIDATE_EMAIL)) {
    $contact_url = 'mailto:' . $contact_url;
} elseif (str_starts_with($contact_url, 'mailto:')) {
    // already mailto
} elseif (str_starts_with($contact_url, '/') || str_starts_with($contact_url, '#') || preg_match('#^https?://#i', $contact_url)) {
    // Valid page link, anchor, or external link
} elseif (strpos($contact_url, '@') !== false) {
    $contact_url = 'mailto:' . $contact_url;
}

// Uploaded module image takes priority over the bundled support artwork.
$image_field = get_sub_field('image');
$image_url = '';
$image_alt = waklert_content('content_support_cta_text_c3a0c478fe');

if (is_array($image_field)) {
    $image_url = $image_field['url'] ?? '';
    $image_alt = !empty($image_field['alt']) ? $image_field['alt'] : (!empty($image_field['title']) ? $image_field['title'] : $image_alt);
} elseif (is_numeric($image_field)) {
    $image_url = wp_get_attachment_image_url($image_field, 'full');
    $alt = get_post_meta($image_field, '_wp_attachment_image_alt', true);
    if ($alt) $image_alt = $alt;
} elseif (is_string($image_field) && $image_field !== '') {
    $image_url = $image_field;
}


if (trim((string) $image_url) === '') {
    $image_url = waklert_content_asset('content_support_cta_image_714a9d77b7');
}
?>
<section class="relative overflow-hidden bg-gradient-to-b from-[#f0f6fa] via-[#e9f2f8] to-[#f8fafc] bg-pattern-dots py-8 md:py-12" data-testid="support-cta">
    <div class="container-site max-w-7xl relative z-10">
        <div class="relative isolate overflow-hidden rounded-[2.5rem] bg-gradient-to-r from-[#0c4160] via-[#165174] to-[#1f5f7f] bg-pattern-dots-dark text-white shadow-2xl border-2 border-dashed border-sky-400/40">
            <?php waklert_output_pattern_rings(); ?>
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-end">
                
                <!-- Left Column: Copy & Actions -->
                <div class="lg:col-span-7 xl:col-span-7 p-6 sm:p-10 md:p-12 lg:py-14 lg:pl-14 lg:pr-4">
                    <?php if ($eyebrow): ?>
                    <?php if (waklert_has_content(esc_html($eyebrow))): ?><span class="inline-flex items-center gap-2 rounded-full bg-amber-400/20 border border-amber-300/40 px-3.5 py-1 text-xs font-extrabold uppercase tracking-[0.2em] text-amber-300 mb-4 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                        <?= esc_html($eyebrow) ?>
                    </span><?php endif; ?>
                    <?php endif; ?>

                    <?php if (waklert_has_content(esc_html($title))): ?><h2 class="font-heading text-2xl sm:text-3xl md:text-4xl lg:text-[40px] xl:text-[42px] font-extrabold text-white leading-tight tracking-tight mb-4">
                        <?= esc_html($title) ?>
                    </h2><?php endif; ?>

                    <?php if (waklert_has_content(esc_html($description))): ?><p class="text-sky-100/90 text-sm sm:text-base md:text-lg leading-relaxed mb-8 max-w-xl font-medium">
                        <?= esc_html($description) ?>
                    </p><?php endif; ?>

                    <div class="flex flex-wrap items-center gap-3 sm:gap-4 pt-1">
                        <?php if ($chat_label !== ''): ?>
                        <?php $chat_target = (str_starts_with($chat_url, '/') || str_starts_with($chat_url, '#')) ? '_self' : '_blank'; ?>
                        <?php if ((waklert_has_content(esc_html($chat_label))) && waklert_has_content(esc_url($chat_url))): ?><a href="<?= esc_url($chat_url) ?>" target="<?= esc_attr($chat_target) ?>" rel="noopener noreferrer" class="inline-flex items-center gap-2 sm:gap-2.5 rounded-full bg-white px-4 py-2.5 sm:px-6 sm:py-3.5 text-xs sm:text-sm font-extrabold text-[#0c4161] shadow-lg transition-all hover:bg-slate-100 hover:scale-[1.03] active:scale-[0.98]">
                            <?= waklert_content_icon('content_support_cta_icon_67aaa3bb75') ?>
                            <?php if (waklert_has_content(esc_html($chat_label))): ?><span><?= esc_html($chat_label) ?></span><?php endif; ?>
                        </a><?php endif; ?>
                        <?php endif; ?>

                        <?php if ($sms_url !== ''): ?>
                        <?php if ((waklert_has_content(esc_html($sms_label))) && waklert_has_content(esc_url($sms_url))): ?><a href="<?= esc_url($sms_url) ?>" class="inline-flex items-center gap-2 rounded-full border border-dashed border-white/40 bg-white/10 px-4 py-2.5 sm:px-5 sm:py-3.5 text-xs sm:text-sm font-bold text-white backdrop-blur-sm transition-all hover:bg-white/20 hover:scale-[1.02] active:scale-[0.98]">
                            <?= waklert_content_icon('content_support_cta_icon_fb578bb7a9') ?>
                            <?php if (waklert_has_content(esc_html($sms_label))): ?><span><?= esc_html($sms_label) ?></span><?php endif; ?>
                        </a><?php endif; ?>
                        <?php endif; ?>

                        <?php if ($contact_label !== ''): ?>
                        <?php
                        $is_mailto = str_starts_with($contact_url, 'mailto:');
                        $plain_email = $is_mailto ? preg_replace('/^mailto:|\?.*$/i', '', $contact_url) : '';
                        ?>
                        <?php if ((waklert_has_content(esc_html($contact_label))) && waklert_has_content(esc_url($contact_url))): ?><a href="<?= esc_url($contact_url) ?>" <?= $is_mailto ? 'data-support-email="' . esc_attr($plain_email) . '"' : '' ?> class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-bold text-sky-200 underline underline-offset-4 decoration-sky-300/40 transition-colors hover:text-white hover:decoration-white ml-2">
                            <?php if (waklert_has_content(esc_html($contact_label))): ?><span><?= esc_html($contact_label) ?></span><?php endif; ?>
                        </a><?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column: Guy with Phone Media Image -->
                <?php if (!empty($image_url)): ?>
                <div class="lg:col-span-5 xl:col-span-5 flex justify-center lg:justify-end items-end self-end px-4 sm:px-6 lg:px-0 lg:pr-6 xl:pr-8 relative z-10 mt-2 lg:mt-0">
                    <?php if (waklert_has_content(esc_url($image_url))): ?><img
                        src="<?= esc_url($image_url) ?>" 
                        alt="<?= esc_attr($image_alt) ?>" 
                        class="w-auto h-auto max-h-[300px] sm:max-h-[350px] md:max-h-[390px] lg:max-h-[420px] xl:max-h-[450px] max-w-full object-contain object-bottom drop-shadow-[0_20px_35px_rgba(0,0,0,0.6)] transition-transform duration-300 hover:scale-[1.02]"
                        loading="lazy"
                        decoding="async"
                    /><?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
