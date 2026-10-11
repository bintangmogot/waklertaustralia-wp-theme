<?php
/**
 * Module: Support CTA Banner
 * Matches the Kamagra-style rounded gradient card in Waklert brand colours
 */

$GLOBALS['waklert_support_cta_rendered'] = true;

$eyebrow = get_sub_field('eyebrow') ?: get_sub_field('tag') ?: 'Need Help?';
$title = get_sub_field('title') ?: 'Talk to us via SMS or WhatsApp - 24/7.';
$description = get_sub_field('desc') ?: get_sub_field('description') ?: 'We are available all the time to handle any questions, offer advice or reassure you about your purchase.';

$chat_label = get_sub_field('chat_btn_text') ?: 'WhatsApp';
$chat_url = trim((string) get_sub_field('chat_btn_url'));
if ($chat_url === '') {
    $chat_url = 'https://wa.me/61488841833';
} elseif (!preg_match('#^https?://#i', $chat_url)) {
    $clean_phone = preg_replace('/\D+/', '', $chat_url);
    if (str_starts_with($clean_phone, '0')) {
        $clean_phone = '61' . substr($clean_phone, 1);
    }
    $chat_url = 'https://wa.me/' . $clean_phone;
}

$sms_label = get_sub_field('sms_btn_text') ?: 'SMS';
$sms_url = trim((string) get_sub_field('sms_btn_url'));
if ($sms_url === '') {
    $sms_url = 'sms:0488841833';
} elseif (!preg_match('#^(sms:|tel:)#i', $sms_url)) {
    $sms_url = 'sms:' . preg_replace('/\s+/', '', $sms_url);
}

$contact_label = get_sub_field('email_btn_text') ?: 'Send an email';
$contact_url = trim((string) get_sub_field('email_btn_url'));
if ($contact_url === '') {
    $contact_url = 'mailto:orders@waklertaustralia.com.au';
} elseif (!str_starts_with($contact_url, 'mailto:') && filter_var($contact_url, FILTER_VALIDATE_EMAIL)) {
    $contact_url = 'mailto:' . $contact_url;
}
?>
<section class="section-padding bg-background" data-testid="support-cta">
    <div class="container-site max-w-7xl">
        <div class="relative isolate overflow-hidden rounded-[2rem] bg-gradient-to-r from-[#0c4160] via-[#165174] to-[#1f5f7f] p-8 sm:p-12 md:p-14 text-white shadow-xl border border-white/10">
            <?php waklert_output_pattern_rings(); ?>
            <div class="relative z-10 max-w-3xl">
                <?php if ($eyebrow): ?>
                <span class="inline-block text-xs font-extrabold uppercase tracking-[0.2em] text-[#f49a5b] mb-3">
                    <?= esc_html($eyebrow) ?>
                </span>
                <?php endif; ?>

                <h2 class="font-heading text-2xl sm:text-3xl md:text-4xl lg:text-[40px] font-extrabold text-white leading-tight tracking-tight mb-4">
                    <?= esc_html($title) ?>
                </h2>

                <p class="text-white/85 text-sm sm:text-base md:text-lg leading-relaxed mb-8 max-w-2xl">
                    <?= esc_html($description) ?>
                </p>

                <div class="flex flex-wrap items-center gap-3 sm:gap-4 pt-1">
                    <?php if ($chat_label !== ''): ?>
                    <a href="<?= esc_url($chat_url) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2.5 rounded-full bg-white px-6 py-3.5 text-sm font-extrabold text-slate-900 shadow-md transition-all hover:bg-slate-100 hover:scale-[1.02] active:scale-[0.98]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#25D366" class="w-5 h-5 shrink-0"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.67-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span><?= esc_html($chat_label) ?></span>
                    </a>
                    <?php endif; ?>

                    <?php if ($sms_url !== ''): ?>
                    <a href="<?= esc_url($sms_url) ?>" class="inline-flex items-center gap-2 rounded-full border border-white/30 bg-white/10 px-5 py-3.5 text-sm font-bold text-white backdrop-blur-sm transition-all hover:bg-white/20 hover:scale-[1.02] active:scale-[0.98]">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4.5 h-4.5 shrink-0"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <span><?= esc_html($sms_label) ?></span>
                    </a>
                    <?php endif; ?>

                    <?php if ($contact_label !== ''): ?>
                    <a href="<?= esc_url($contact_url) ?>" class="inline-flex items-center gap-1.5 text-sm font-bold text-white/90 underline underline-offset-4 decoration-white/40 transition-colors hover:text-white hover:decoration-white ml-2">
                        <span><?= esc_html($contact_label) ?></span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
