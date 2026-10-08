<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 */

defined('ABSPATH') || exit;

get_header('shop');

$shop_page_id = wc_get_page_id('shop');

// Check if ACF modules exist on the Shop page
if (have_rows('modules', $shop_page_id)) {
    echo '<main>';
    while (have_rows('modules', $shop_page_id)) {
        the_row();
        $layout = get_row_layout();

        // Keep the Ordering SEO copy and FAQ content saved in ACF, but omit
        // these sections from the shop archive presentation.
        if (is_shop() && in_array($layout, ['seo_text', 'faqs'], true)) {
            continue;
        }

        get_template_part('modules/content', $layout);
    }
    echo '</main>';
} else {
    // Fallback if no ACF modules are configured for the Shop page
?>

<section class="bg-background pt-12 pb-6 text-center border-b border-border">
    <div class="container-site max-w-4xl">
        <h1 class="font-heading text-4xl font-extrabold tracking-tight md:text-5xl">
            <?= "Buy Modafinil Online in Malaysia" ?>
        </h1>
        <p class="mx-auto mt-3 max-w-2xl text-base leading-relaxed text-muted-foreground">
            <?= "Browse and buy genuine Modafinil tablets online from certified manufacturers. Fast Malaysia-wide delivery on all orders." ?>
        </p>
    </div>
</section>

<section class="py-10 md:py-16 bg-background">
    <div class="container-site">
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

<?php
// Guide Section from React
?>
<section class="py-12 md:py-16 bg-stone-50">
    <div class="container-site max-w-4xl">
        <div class="text-center mb-8">
            <h2 class="font-heading text-2xl md:text-4xl font-black text-ink"><?= "Choosing the Right Modafinil" ?></h2>
            <p class="mt-3 text-base leading-relaxed text-muted-foreground">
                <?= "With several brands and dosages available, the right product depends on your experience level, desired effects, and budget. Below is a comparison of our most popular options." ?>
            </p>
        </div>
        
        <div class="space-y-6">
            <div class="rounded-xl border border-border bg-card p-6 shadow-card">
                <h3 class="font-heading text-xl font-bold"><?= "Modalert 200mg — The Gold Standard" ?></h3>
                <p class="mt-2 text-sm leading-relaxed text-muted-foreground"><?= "Manufactured by Sun Pharma, Modalert is the most widely recognised modafinil brand worldwide. Each tablet contains the standard 200mg clinical dose and delivers a clean, sustained boost in focus lasting 10–12 hours." ?></p>
                <p class="mt-3 text-sm font-semibold text-primary-dark"><?= "Best for: First-time users who want a trusted, proven brand." ?></p>
            </div>
            
            <div class="rounded-xl border border-border bg-card p-6 shadow-card">
                <h3 class="font-heading text-xl font-bold"><?= "Modvigil 200mg — Affordable Alternative" ?></h3>
                <p class="mt-2 text-sm leading-relaxed text-muted-foreground"><?= "Produced by HAB Pharma with the same 200mg dose as Modalert. Many users report very similar effects at a lower price, with a slightly gentler onset that suits all-day productivity." ?></p>
                <p class="mt-3 text-sm font-semibold text-primary-dark"><?= "Best for: Budget-conscious buyers or those who want a smoother onset." ?></p>
            </div>

            <div class="rounded-xl border border-border bg-card p-6 shadow-card">
                <h3 class="font-heading text-xl font-bold"><?= "Modasmart 400mg — Extended Duration" ?></h3>
                <p class="mt-2 text-sm leading-relaxed text-muted-foreground"><?= "Double the standard dose in a single tablet, designed for experienced users who need longer-lasting cognitive enhancement for extended study sessions or overnight shifts." ?></p>
                <p class="mt-3 text-sm font-semibold text-primary-dark"><?= "Best for: Experienced users who need 14+ hours of sustained focus." ?></p>
            </div>
        </div>
    </div>
</section>

<?php 
} // End ACF check 
?>

<?php get_footer('shop'); ?>
