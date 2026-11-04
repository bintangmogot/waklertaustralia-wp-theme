<?php
/**
 * Module: Call to Action (CTA)
 */

if (waklert_module_is_empty()) { return; }

$heading = waklert_module_text('heading');

$is_buyers_guide = is_page('buyers-guide');
$desc = waklert_module_text('description');

$btn = waklert_module_text('button_text');
$wa_url = function_exists('waklert_format_whatsapp_url') ? waklert_format_whatsapp_url(get_field('whatsapp_number', 'option')) : 'https://wa.me/61488841833';
$btn_url = waklert_module_text('button_url');
if (function_exists('waklert_format_whatsapp_url') && stripos($btn_url, 'wa.me') !== false) {
    $btn_url = waklert_format_whatsapp_url($btn_url);
}

$btn2 = waklert_module_text('secondary_button_text');
$default_cta_email = get_field('contact_email', 'option') ?: 'orders@waklertaustralia.com.au';
if (strpos($default_cta_email, 'example.com') !== false || strpos($default_cta_email, 'hoppingmad') !== false || strpos($default_cta_email, 'modaaust') !== false) {
    $default_cta_email = 'orders@waklertaustralia.com.au';
}
$btn2_url = waklert_resolve_link(waklert_module_text('secondary_button_url'));
?>
<section class="py-4 pb-10 bg-white" data-testid="cta-section">
    <div class="container-custom max-w-4xl">
        <div class="relative isolate overflow-hidden rounded-2xl bg-primary p-8 text-center text-white shadow-sm md:p-10 not-prose">
            <?php waklert_output_pattern_rings(); ?>
            <div class="relative z-10">
                <?php if (waklert_has_content($heading)): ?><h2 class="font-heading font-black text-2xl md:text-3xl mb-3 text-white">
                    <?= $heading ?>
                </h2><?php endif; ?>
                <?php if (waklert_has_content($desc)): ?><p class="text-white/85 mb-6 max-w-2xl mx-auto font-medium text-sm md:text-base leading-relaxed">
                    <?= $desc ?>
                </p><?php endif; ?>
                <div class="flex flex-row gap-3 sm:gap-4 justify-center items-center">
                    <?php if ((waklert_has_content($btn)) && waklert_has_content(esc_url($btn_url))): ?><a href="<?= esc_url($btn_url) ?>" class="inline-flex items-center justify-center gap-2 bg-white text-primary-dark font-bold px-4 py-2 sm:px-7 sm:py-3 rounded-full hover:bg-accent transition-colors shadow-sm text-xs sm:text-sm whitespace-nowrap">
                        <?= $btn ?>
                    </a><?php endif; ?>
                    <?php if ((waklert_has_content($btn2)) && waklert_has_content(esc_url($btn2_url))): ?><a href="<?= esc_url($btn2_url) ?>" class="inline-flex items-center justify-center gap-2 border-2 border-white/50 text-white font-bold px-4 py-2 sm:px-7 sm:py-3 rounded-full hover:border-accent hover:bg-accent hover:text-ink transition-colors text-xs sm:text-sm whitespace-nowrap">
                        <?= $btn2 ?>
                    </a><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
