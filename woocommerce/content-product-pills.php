<?php
/**
 * The template for displaying product content within loops
 * Adapted to match the Armodafinil Direct design with variation pills
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
$image = wp_get_attachment_image_url($product->get_image_id(), 'medium_large') ?: '';
if (!$image) {
    $image = wc_placeholder_img_src();
}

$review_summary = waklert_get_product_review_summary($product->get_id());
$rating = (float) $review_summary['average_rating'];
$review_count = (int) $review_summary['review_count'];

$in_stock = $product->is_in_stock();
?>
<div class="group relative flex flex-col bg-white border border-border rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:border-primary/50 transition-all duration-300 h-full">
    <a href="<?= esc_url($link) ?>" class="block relative aspect-[4/3] bg-white border-b border-border p-4">
        <img src="<?= esc_url($image) ?>" alt="<?= esc_attr($title) ?>" class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105" loading="lazy" />
    </a>
    
    <div class="p-4 sm:p-5 flex flex-col flex-1">
        <?php if (apply_filters('waklert_show_product_card_reviews', false)): ?>
        <div class="flex items-center gap-2 mb-2">
            <div class="flex items-center text-amber-400">
                <?php for($i=1; $i<=5; $i++): 
                    if ( $rating >= $i ) {
                        echo waklert_content_icon('content_product_pills_icon_c46f69f405');
                    } elseif ( $rating >= ( $i - 0.5 ) ) {
                        echo waklert_content_icon('content_product_pills_icon_5d2cfb7425');
                    } else {
                        echo waklert_content_icon('content_product_pills_icon_1084e90cf2');
                    }
                endfor; ?>
            </div>
            <span class="text-[11px] sm:text-xs text-muted-foreground font-medium">
                <?php if ($review_count > 0): ?>
                    <?= esc_html(number_format($rating, 1)) ?> <span class="opacity-70">(<?= esc_html($review_count) ?>)</span>
                <?php else: ?>
                    <?= esc_html(waklert_get_product_presentation_option('product_no_reviews_text')) ?>
                <?php endif; ?>
            </span>
        </div>
        <?php endif; ?>

        <a href="<?= esc_url($link) ?>" class="font-heading text-[15px] sm:text-lg font-bold text-card-foreground leading-snug hover:text-primary transition-colors line-clamp-2 mb-4">
            <?= esc_html($title) ?>
        </a>

        <div class="grid grid-cols-2 gap-1.5 mt-auto mb-4">
            <?php 
            $first_price = "";
            if ( $product->is_type('variable') ) {
                $variations = $product->get_available_variations();
                if (function_exists('waklert_sort_product_variations')) {
                    waklert_sort_product_variations($variations, $product);
                }
                $count = 0;
                foreach ($variations as $var) {
                    $label = "";
                    foreach ($var['attributes'] as $key => $val) {
                        if ($val) { $label = $val; break; }
                    }
                    if (empty($label)) {
                        $parts = explode('-', get_the_title($var['variation_id']));
                        $label = trim(end($parts));
                    }
                    
                    // Clean up hyphens and lowercase
                    $label = str_ireplace('-tabs', ' Tabs', $label);
                    $label = str_ireplace('-', ' ', $label);

                    $price_html = wc_price($var['display_price']);
                    if ($count === 0) {
                        $first_price = $price_html;
                    }

                    $is_first = ($count === 0);
                    $base_classes = "text-center py-1.5 px-1 border rounded-md transition-colors text-[11px] font-bold truncate cursor-pointer";
                    $active_classes = "bg-primary text-primary-foreground border-primary";
                    $inactive_classes = "text-primary bg-primary/5 border-primary/20 hover:bg-primary/10";
                    
                    $current_classes = $base_classes . " " . ($is_first ? $active_classes : $inactive_classes);
                    
                    $js_price = addslashes($price_html);
                    $onclick = "let card = this.closest('.group'); card.querySelector('.dynamic-price').innerHTML = '{$js_price}'; Array.from(this.parentElement.children).forEach(el => { el.className = '{$base_classes} {$inactive_classes}'; }); this.className = '{$base_classes} {$active_classes}';";

                    echo '<button type="button" onclick="' . esc_attr($onclick) . '" class="' . esc_attr($current_classes) . '">';
                    
                    $display_label = trim($label);
                    if (is_numeric($display_label)) {
                        $display_label .= " Tabs";
                    } elseif (stripos($display_label, "tab") === false && stripos($display_label, "pill") === false) {
                        $display_label .= " Tabs";
                    }
                    $display_label = str_ireplace("tablets", waklert_content('content_product_pills_text_70bda98608'), $display_label);
                    echo esc_html($display_label);

                    echo '</button>';
                    
                    $count++;
                }
            } else {
                $first_price = $product->get_price_html();
            }
            ?>
        </div>

        <div class="flex items-baseline gap-2 mb-3">
            <span class="dynamic-price text-xl font-bold text-price tracking-tight [&>span.amount]:!font-bold [&>del]:opacity-50 [&>del]:font-normal [&>del]:text-sm [&>ins]:no-underline"><?= wp_kses_post($first_price) ?></span>
        </div>
        
        <div class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-widest <?= $in_stock ? 'text-emerald-600' : 'text-destructive' ?> mb-1">
            <?= waklert_content_icon('content_product_pills_icon_b3bb384166') ?>
            <?= $in_stock ? waklert_content('content_product_pills_text_ae6028163a') : waklert_content('content_product_pills_text_f9ef78d605') ?>
        </div>
        
        <a href="<?= esc_url($link) ?>" class="mt-2 w-full inline-flex justify-center items-center gap-1.5 sm:gap-2 h-9 sm:h-11 rounded-lg sm:rounded-xl bg-primary hover:bg-primary-dark text-primary-foreground text-xs sm:text-sm font-bold transition-all shadow-sm hover:shadow">
            <?= waklert_content_icon('content_product_pills_icon_c9b8adaee3') ?>
            <?= esc_html(waklert_content('content_product_pills_text_cef5775e80')) ?>
        </a>
    </div>
</div>
