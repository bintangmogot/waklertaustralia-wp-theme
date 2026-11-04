<?php
/**
 * Module: SEO Text with CTA
 */

if (waklert_module_is_empty()) { return; }

$content = get_sub_field('content');

$show_cta = get_sub_field('show_cta') !== false; // Default true
$cta_title = waklert_content('pg_seo_cta_title');
$cta_desc = waklert_content('pg_seo_cta_desc');

$raw_cta_link = get_sub_field('cta_link');
if (is_array($raw_cta_link) && !empty($raw_cta_link['url'])) {
    $cta_link = $raw_cta_link['url'];
} elseif (is_string($raw_cta_link) && !empty(trim($raw_cta_link))) {
    $cta_link = trim($raw_cta_link);
} else {
    $cta_link = '';
}

// Keep legacy dosage-guide module links pointed at the site's Armodafinil guide.
if (strpos($cta_link, '/dosage-guide') !== false) {
    $cta_link = str_replace('/dosage-guide', '/armodafinil-guide', $cta_link);
}
?>
<section class="py-8 md:py-12 bg-background">
    <div class="container-site max-w-4xl">
        <?php if (waklert_has_content(wp_kses_post($content))): ?><div class="prose prose-slate max-w-none prose-a:text-primary hover:prose-a:text-primary-dark prose-headings:font-heading prose-headings:font-bold">
            <?php 
            echo wp_kses_post($content);
            ?>
        </div><?php endif; ?>

        <?php if ($show_cta): ?>
        <?php if ((waklert_has_content(esc_html($cta_title)) || waklert_has_content(esc_html($cta_desc))) && waklert_has_content(esc_url($cta_link))): ?><a href="<?= esc_url($cta_link) ?>" class="mt-12 group flex flex-col md:flex-row items-start md:items-center gap-5 p-6 rounded-xl border border-primary-light/50 bg-primary-softer hover:bg-primary-soft hover:border-primary-light transition-colors">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-primary text-primary-foreground shadow-sm group-hover:scale-105 transition-transform">
                <?= waklert_content_icon('content_seo_text_icon_1cd5e03fa4') ?>
            </div>
            <div class="flex-1">
                <?php if (waklert_has_content(esc_html($cta_title))): ?><h3 class="font-heading font-bold text-slate-900 text-lg"><?= esc_html($cta_title) ?></h3><?php endif; ?>
                <?php if (waklert_has_content(esc_html($cta_desc))): ?><p class="text-slate-600 text-sm mt-1 leading-relaxed">
                    <?= esc_html($cta_desc) ?>
                </p><?php endif; ?>
            </div>
            <div class="hidden md:flex flex-shrink-0 text-primary group-hover:translate-x-1 transition-transform">
                <?= waklert_content_icon('content_seo_text_icon_098a3174ce') ?>
            </div>
        </a><?php endif; ?>
        <?php endif; ?>
    </div>
</section>
