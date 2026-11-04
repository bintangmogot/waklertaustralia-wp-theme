<?php
/**
 * Module: Featured Products
 * Matches the original React design exactly
 */

if (waklert_module_is_empty()) { return; }

$tag = waklert_module_text('subheading');

$heading = waklert_module_text('title');
$description = waklert_module_text('description');
$button_text = waklert_module_text('button_text');
$button_href = waklert_resolve_link(waklert_module_text('button_url'));

$products = get_sub_field('products') ?: [];
?>
<section class="section-padding bg-gradient-to-b from-[#f8fafc] via-[#eff6fb] to-[#f8fafc] bg-pattern-dots border-t-2 border-dashed border-sky-200/80 relative isolate overflow-hidden" data-testid="featured-products">
    <div class="container-custom relative z-10">
        <?php if ($tag !== '' || $heading !== '' || $description !== ''): ?>
        <div class="text-center mb-10 md:mb-12">
            <?php if (waklert_has_content(esc_html($tag))): ?><span class="inline-flex items-center gap-2 bg-amber-100/90 text-amber-900 border border-amber-300 text-xs font-black uppercase tracking-widest px-4 py-1.5 rounded-full mb-3 shadow-xs">
                <?= waklert_content_icon('content_featured_product_icon_83d2048db9') ?>
                <?= esc_html($tag) ?>
            </span><?php endif; ?>
            <?php if (waklert_has_content(esc_html($heading))): ?><h2 class="font-heading text-2xl md:text-4xl font-black text-ink tracking-tight mb-3">
                <?= esc_html($heading) ?>
            </h2><?php endif; ?>
            <?php if (waklert_has_content(esc_html($description))): ?><p class="text-sm md:text-base text-muted-foreground max-w-xl mx-auto leading-relaxed">
                <?= esc_html($description) ?>
            </p><?php endif; ?>
        </div>

        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <?php 
            if($products):
                foreach($products as $p):
                    // Handle both ACF post objects and wc_get_products instances
                    $product_id = is_numeric($p) ? $p : (is_a($p, 'WC_Product') ? $p->get_id() : $p->ID);
                    if(!$product_id) continue;
                    
                    $post_object = get_post($product_id);
                    setup_postdata($GLOBALS['post'] =& $post_object);
                    wc_get_template_part('content', 'product-horizontal');
                endforeach;
                wp_reset_postdata();
            endif;
            ?>
        </div>

        <?php if ($button_text !== '' && $button_href !== ''): ?>
        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <?php if ((waklert_has_content(esc_html($button_text))) && waklert_has_content(esc_url($button_href))): ?><a href="<?= esc_url($button_href) ?>" class="inline-flex items-center gap-2 border-2 border-primary-light text-primary-dark font-bold px-5 py-2.5 sm:px-7 sm:py-3 rounded-full hover:bg-primary-light hover:text-white hover:border-primary-light transition-all uppercase tracking-wider sm:tracking-widest text-xs sm:text-sm">
                <?= esc_html($button_text) ?>
                <?= waklert_content_icon('content_featured_product_icon_e302efd623') ?>
            </a><?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
