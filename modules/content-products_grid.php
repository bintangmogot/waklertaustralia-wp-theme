<?php
/**
 * Module: Products Grid
 * Displays the WooCommerce products loop.
 */
?>
<section class="py-10 md:py-16 bg-background">
    <div class="container-site px-2 sm:px-4">
        <?php
        if (woocommerce_product_loop()) {
            woocommerce_product_loop_start();

            if (wc_get_loop_prop('total')) {
                while (have_posts()) {
                    the_post();
                    do_action('woocommerce_shop_loop');
                    wc_get_template_part('content', 'product');
                }
            }

            woocommerce_product_loop_end();
        } else {
            do_action('woocommerce_no_products_found');
        }
        ?>
    </div>
</section>
