<?php
/**
 * Module: Featured Products
 * Matches the original React design exactly
 */

$tag = get_sub_field('subheading') ?: "MOST POPULAR in 2026";

$heading = get_sub_field('title') ?: "Armodafinil Products";

// Featured product slugs (matching original JS: HOME_PRODUCT_SLUGS)
$featured_slugs = ['waklert-150mg', 'artvigil-50mg', 'armod-50mg-armodafinil'];

$products = get_sub_field('products');
if (!$products) {
    // Fallback: Get by the exact slugs from the original design
    $products = [];
    foreach ($featured_slugs as $slug) {
        $found = get_page_by_path($slug, OBJECT, 'product');
        if ($found) {
            $products[] = wc_get_product($found->ID);
        }
    }
    // If still empty, get latest 4
    if (empty($products)) {
        $products = wc_get_products(array(
            'limit' => 4,
            'status' => 'publish',
        ));
    }
}
?>
<section class="section-padding bg-white" data-testid="featured-products">
    <div class="container-custom">
        <div class="text-center mb-10">
            <span class="inline-block bg-primary-soft text-primary-dark text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4">
                <?= $tag ?>
            </span>
            <h2 class="font-heading text-2xl md:text-4xl font-black text-ink">
                <?= $heading ?>
            </h2>
        </div>

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

        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
            <a href="<?= wc_get_page_permalink('shop') ?>" class="inline-flex items-center gap-2 border-2 border-primary-light text-primary-dark font-bold px-7 py-3 rounded-full hover:bg-primary-light hover:text-white hover:border-primary-light transition-all uppercase tracking-widest text-sm">
                <?= "View All Products" ?>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </a>
        </div>
    </div>
</section>
