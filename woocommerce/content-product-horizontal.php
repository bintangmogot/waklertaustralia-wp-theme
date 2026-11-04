<?php
/**
 * The template for displaying product content in a horizontal layout
 * Inspired by kamagraaus.com
 */

defined('ABSPATH') || exit;

global $product;

if (!is_a($product, 'WC_Product')) {
    $product = wc_get_product(get_the_ID());
}

if (empty($product) || !$product->is_visible()) {
    return;
}

$title = $product->get_title();
$link = $product->get_permalink();
$image = wp_get_attachment_image_url($product->get_image_id(), 'medium_large') ?: wc_placeholder_img_src();

// Use shop_page_text ACF field for excerpt, fallback to standard post excerpt
$excerpt = get_field('shop_page_text', $product->get_id());
if (!metadata_exists('post', $product->get_id(), 'shop_page_text')) {
    $excerpt = $product->get_short_description();
}
// Don't overly trim it in PHP so the JS toggle can reveal the rest
$excerpt = wp_trim_words(strip_shortcodes(wp_strip_all_tags($excerpt)), 60, '...');

// Custom price logic: change range to "From" for variable products
if ( $product->is_type('variable') ) {
    $min_price = $product->get_variation_price('min', true);
    $price_html = waklert_content('content_product_horizont_text_73956e4af7') . wc_price($min_price);
} else {
    $price_html = $product->get_price_html();
}
?>
<div class="group relative flex flex-col sm:flex-row bg-white border-2 border-dashed border-sky-300/80 hover:border-[#0c4161] rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-out">
    
    <!-- Image full width, no padding, object-contain so it never cuts -->
    <a href="<?= esc_url($link) ?>" class="sm:w-2/5 md:w-[42%] relative block bg-radial-[at_center] from-sky-50 to-white shrink-0 overflow-hidden min-h-[220px] sm:min-h-[auto] border-b sm:border-b-0 sm:border-r-2 sm:border-solid sm:border-sky-200/80 p-4 flex items-center justify-center">
        <img src="<?= esc_url($image) ?>" alt="<?= esc_attr($title) ?>" class="w-full h-full max-h-[240px] object-contain transition-transform duration-500 group-hover:scale-105 group-hover:rotate-1" loading="lazy" />
        <div class="absolute top-3 left-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-amber-400 text-slate-950 border border-amber-500/30 shadow-xs">
                <?= esc_html(waklert_content('content_product_horizont_text_71e9e38f61')) ?>
            </span>
        </div>
    </a>
    
    <div class="p-6 sm:p-7 flex flex-col justify-between flex-1 bg-white">
        <div>
            <!-- Title -->
            <a href="<?= esc_url($link) ?>" class="block font-heading text-xl md:text-2xl font-black text-slate-900 leading-tight hover:text-[#0c4161] transition-colors mb-2.5">
                <?= esc_html($title) ?>
            </a>

            <!-- Excerpt with Read More Toggle -->
            <?php if (waklert_has_content($excerpt)): ?>
            <div class="mb-4">
                <p class="text-sm text-slate-600 leading-relaxed line-clamp-2 transition-all duration-300">
                    <?= esc_html($excerpt) ?>
                </p>
                <?php if (str_word_count($excerpt) > 15): ?>
                <button type="button" data-read-more="<?= esc_attr(waklert_option_text('shop_card_read_more_label')) ?>" data-read-less="<?= esc_attr(waklert_content('manual_card_show_less')) ?>" onclick="let p = this.previousElementSibling; p.classList.toggle('line-clamp-2'); this.innerText = p.classList.contains('line-clamp-2') ? this.dataset.readMore : this.dataset.readLess;" class="text-xs font-bold text-[#0c4161] hover:underline mt-1"><?= esc_html(waklert_content('content_product_horizont_text_fc2c441ed2')) ?></button>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="pt-4 border-t-2 border-solid border-sky-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 mt-auto">
            <!-- Price -->
            <div class="text-sm text-slate-600 font-medium">
                <span class="block text-[11px] uppercase tracking-wider text-slate-400 font-bold"><?= esc_html(waklert_content('content_product_horizont_text_02e33cd22a')) ?></span>
                <span class="font-black text-slate-950 text-lg md:text-xl [&>span.amount]:!font-black [&>del]:opacity-50 [&>del]:font-normal [&>del]:text-sm [&>ins]:no-underline"><?= wp_kses_post($price_html) ?></span>
            </div>
            
            <!-- Shop Now Link (Compact on Mobile) -->
            <a href="<?= esc_url($link) ?>" class="inline-flex items-center justify-center gap-2 bg-[#0c4161] hover:bg-[#082c42] text-white font-extrabold text-xs sm:text-sm py-2 px-4 sm:py-2.5 sm:px-6 rounded-lg sm:rounded-xl group/btn shadow-md hover:shadow-lg transition-all duration-300 hover:scale-[1.02]">
                <span><?= esc_html(waklert_content('content_product_horizont_text_c25bac5760')) ?></span>
                <?= waklert_content_icon('content_product_horizont_icon_3bf6858433') ?>
            </a>
        </div>
    </div>
</div>
