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
if (empty($excerpt)) {
    $excerpt = $product->get_short_description() ?: get_the_excerpt();
}
// Don't overly trim it in PHP so the JS toggle can reveal the rest
$excerpt = wp_trim_words(strip_shortcodes(wp_strip_all_tags($excerpt)), 60, '...');

// Custom price logic: change range to "From" for variable products
if ( $product->is_type('variable') ) {
    $min_price = $product->get_variation_price('min', true);
    $price_html = 'From ' . wc_price($min_price);
} else {
    $price_html = $product->get_price_html();
}
?>
<div class="group relative flex flex-col sm:flex-row bg-gradient-to-br from-white to-blue-50/70 border border-slate-200/70 rounded-[1.5rem] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-500">
    
    <!-- Image full width, no padding, object-contain so it never cuts -->
    <a href="<?= esc_url($link) ?>" class="sm:w-2/5 md:w-[40%] relative block bg-white shrink-0 overflow-hidden min-h-[220px] sm:min-h-[auto] border-b sm:border-b-0 sm:border-r border-slate-100 p-0">
        <img src="<?= esc_url($image) ?>" alt="<?= esc_attr($title) ?>" class="absolute inset-0 w-full h-full object-contain transition-transform duration-700 group-hover:scale-105" loading="lazy" />
    </a>
    
    <div class="p-6 sm:p-7 flex flex-col justify-center flex-1">
        
        <!-- Bestseller Tag -->
        <div class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-widest text-orange-500 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg> 
            BESTSELLER
        </div>

        <!-- Title -->
        <a href="<?= esc_url($link) ?>" class="font-heading text-xl md:text-2xl font-black text-slate-900 leading-tight hover:text-primary transition-colors mb-2">
            <?= esc_html($title) ?>
        </a>

        <!-- Excerpt with Read More Toggle -->
        <div class="mb-4">
            <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 transition-all duration-300">
                <?= esc_html($excerpt) ?>
            </p>
            <?php if (str_word_count($excerpt) > 15): ?>
            <button type="button" onclick="let p = this.previousElementSibling; p.classList.toggle('line-clamp-2'); this.innerText = p.classList.contains('line-clamp-2') ? 'Read more' : 'Show less';" class="text-xs font-bold text-primary hover:text-primary-dark mt-1">Read more</button>
            <?php endif; ?>
        </div>

        <!-- Price -->
        <div class="text-sm text-slate-600 mb-3 font-medium flex items-center gap-1.5 [&>span.price]:flex [&>span.price]:items-center [&>span.price]:gap-1">
            <span class="font-bold text-slate-900 text-base [&>span.amount]:!font-bold [&>del]:opacity-50 [&>del]:font-normal [&>del]:text-sm [&>ins]:no-underline"><?= wp_kses_post($price_html) ?></span>
        </div>
        
        <!-- Shop Now Link -->
        <a href="<?= esc_url($link) ?>" class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white font-bold text-sm transition-colors mt-auto py-3 px-5 rounded-xl group/btn shadow-md">
            Shop now 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 transition-transform group-hover/btn:translate-x-1"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
    </div>
</div>
