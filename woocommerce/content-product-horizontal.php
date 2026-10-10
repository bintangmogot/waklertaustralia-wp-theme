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

// Use short description for excerpt, fallback to standard post excerpt
$excerpt = $product->get_short_description();
if (empty($excerpt)) {
    $excerpt = get_the_excerpt();
}
$excerpt = wp_trim_words(strip_shortcodes(wp_strip_all_tags($excerpt)), 20, '...');

// If price has range, WooCommerce usually adds "From". Let's just output WooCommerce price html
$price_html = $product->get_price_html();
?>
<div class="group relative flex flex-col sm:flex-row bg-white border border-stone-200 rounded-2xl overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <a href="<?= esc_url($link) ?>" class="sm:w-2/5 md:w-[35%] relative flex items-center justify-center p-4 bg-white border-b sm:border-b-0 sm:border-r border-stone-100 shrink-0 min-h-[200px]">
        <img src="<?= esc_url($image) ?>" alt="<?= esc_attr($title) ?>" class="max-w-[80%] max-h-[160px] object-contain transition-transform duration-500 group-hover:scale-105" loading="lazy" />
    </a>
    
    <div class="p-5 sm:p-6 flex flex-col justify-center flex-1">
        
        <!-- Bestseller Tag -->
        <div class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest text-purple-600 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg> 
            BESTSELLER
        </div>

        <!-- Title -->
        <a href="<?= esc_url($link) ?>" class="font-heading text-xl md:text-2xl font-black text-slate-900 leading-tight hover:text-primary transition-colors mb-2">
            <?= esc_html($title) ?>
        </a>

        <!-- Excerpt -->
        <p class="text-sm text-slate-500 leading-relaxed line-clamp-3 mb-4">
            <?= esc_html($excerpt) ?>
        </p>

        <!-- Price -->
        <div class="text-sm text-slate-600 mb-2 font-medium flex items-center gap-1.5 [&>span.price]:flex [&>span.price]:items-center [&>span.price]:gap-1">
            <span class="font-bold text-slate-900 text-base [&>span.amount]:!font-bold [&>del]:opacity-50 [&>del]:font-normal [&>del]:text-sm [&>ins]:no-underline"><?= wp_kses_post($price_html) ?></span>
        </div>
        
        <!-- Shop Now Link -->
        <a href="<?= esc_url($link) ?>" class="inline-flex items-center gap-1 text-primary hover:text-primary-dark font-bold text-sm transition-colors mt-auto group/btn">
            Shop now 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 transition-transform group-hover/btn:translate-x-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
    </div>
</div>
