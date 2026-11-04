<?php
/**
 * Module: Terms Contact Callout / Support Callout
 * Dedicated card matching the Terms & Conditions WhatsApp callout
 */

if (waklert_module_is_empty()) { return; }

$heading = waklert_module_text('heading');
$description = waklert_module_text('description');
$btn_label = waklert_module_text('btn_label');
$raw_number = waklert_module_text('whatsapp_number');
$wa_url = $raw_number !== '' && function_exists('waklert_format_whatsapp_url') ? waklert_format_whatsapp_url($raw_number) : '';
?>
<section class="section-padding bg-white" data-testid="terms-contact-callout">
    <div class="container-custom max-w-3xl">
        <div class="bg-slate-900 text-white rounded-2xl p-8 text-center shadow-lg">
            <?php if (waklert_has_content(esc_html($heading))): ?><h2 class="font-heading font-extrabold text-2xl mb-3">
                <?= esc_html($heading) ?>
            </h2><?php endif; ?>
            <?php if (waklert_has_content(esc_html($description))): ?><p class="text-slate-300 text-sm mb-6 max-w-lg mx-auto leading-relaxed">
                <?= esc_html($description) ?>
            </p><?php endif; ?>
            <?php if ((waklert_has_content(esc_html($btn_label))) && waklert_has_content(esc_url($wa_url))): ?><a href="<?= esc_url($wa_url) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-accent text-accent-foreground font-bold px-7 py-3.5 rounded-full hover:brightness-105 transition-colors shadow-md text-sm">
                <?= waklert_content_icon('content_terms_contact_icon_50700b7917') ?>
                <?= esc_html($btn_label) ?>
            </a><?php endif; ?>
        </div>
    </div>
</section>
