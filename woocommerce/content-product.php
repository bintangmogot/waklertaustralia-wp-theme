<?php
/**
 * The template for displaying product content within loops
 * Matches the original React ProductCard.tsx design exactly
 */

defined('ABSPATH') || exit;

global $product;

// Ensure we have a proper WC_Product object
if (!is_a($product, 'WC_Product')) {
    $product = wc_get_product(get_the_ID());
}

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}

$title = $product->get_title();
$link = $product->get_permalink();
$image = wp_get_attachment_image_url($product->get_image_id(), 'medium') ?: '';
$shop_page_text = get_field('shop_page_text', $product->get_id()); // From ACF
$shop_page_excerpt = trim(wp_strip_all_tags((string) $shop_page_text));
$is_placeholder_excerpt = preg_match('/^(?:armodafinil|modafinil)\s+product$/i', $shop_page_excerpt);
$excerpt_source = $shop_page_text && !$is_placeholder_excerpt
    ? $shop_page_text
    : $product->get_short_description();
$excerpt = trim(preg_replace('/\\s+/', ' ', wp_strip_all_tags($excerpt_source)));
$excerpt_length = function_exists('mb_strlen') ? mb_strlen($excerpt) : strlen($excerpt);
$description_id = 'product-description-' . absint($product->get_id());
$in_stock = $product->is_in_stock();
$unit_price = waklert_get_product_unit_price($product);
$review_summary = waklert_get_product_review_summary($product->get_id());
$no_reviews_text = waklert_get_product_presentation_option('product_no_reviews_text', 'No reviews yet');
?>
<article class="group relative flex flex-col overflow-hidden rounded-xl border border-border hover:border-primary bg-card shadow-card transition-shadow hover:shadow-card-hover">
    <!-- Stock Badge -->
    <?php if ($in_stock): ?>
    <span class="absolute left-4 top-4 z-10 rounded-md bg-primary px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-primary-foreground">
        <?= "In Stock" ?>
    </span>
    <?php else: ?>
    <span class="absolute left-4 top-4 z-10 rounded-md bg-destructive px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-destructive-foreground">
        <?= "Out of Stock" ?>
    </span>
    <?php endif; ?>

    <!-- Product Image -->
    <a href="<?= esc_url($link) ?>" class="relative block aspect-square overflow-hidden bg-white">
        <img src="<?= esc_url($image) ?>" alt="<?= esc_attr($title) ?> product image" loading="lazy" class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-110">
    </a>

    <!-- Product Info -->
    <div class="flex flex-1 flex-col p-3 md:p-5">
        <h3 class="font-heading text-sm md:text-base font-bold text-card-foreground leading-tight">
            <a href="<?= esc_url($link) ?>" class="line-clamp-2">
                <?= esc_html($title) ?>
            </a>
        </h3>

        <?php if ($excerpt !== ''): ?>
        <div class="product-desc-wrapper mt-1.5">
            <p id="<?= esc_attr($description_id) ?>" class="text-xs md:text-sm text-muted-foreground leading-relaxed">
                <?= esc_html($excerpt) ?>
            </p>
            <?php if ($excerpt_length > 80): ?>
            <button type="button" aria-expanded="false" aria-controls="<?= esc_attr($description_id) ?>" data-product-description-toggle class="mt-1.5 text-xs font-medium text-primary-dark transition-colors hover:text-primary">
                Read more
            </button>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Price Range -->
        <p class="mt-2 md:mt-4 font-heading text-[15px] md:text-lg font-bold text-price leading-tight">
            <?= wp_kses_post(waklert_get_product_card_price_html($product)) ?>
        </p>

        <?php if ($unit_price !== null): ?>
        <p class="mt-1 text-xs md:text-sm font-medium text-primary-dark line-clamp-1">
            From <?= wp_kses_post(wc_price($unit_price)) ?>/tab
        </p>
        <?php endif; ?>

        <!-- Anchor the review and action together at the bottom of the card. -->
        <div class="mt-auto pt-4">
            <?php if ($review_summary['review_count'] > 0): ?>
            <a href="<?= esc_url($link . '#product-reviews') ?>" class="inline-flex w-fit items-center gap-1.5 text-xs text-muted-foreground transition-colors hover:text-primary-dark" aria-label="Read <?= esc_attr($review_summary['review_count']) ?> product reviews">
                <?php if ($review_summary['rating_count'] > 0): ?>
                    <span class="text-accent" aria-hidden="true">★</span>
                    <span class="font-semibold text-ink"><?= esc_html(number_format($review_summary['average_rating'], 1)) ?></span>
                    <span aria-hidden="true">·</span>
                <?php endif; ?>
                <span>(<?= esc_html($review_summary['review_count']) ?> <?= esc_html($review_summary['review_count'] === 1 ? 'review' : 'reviews') ?>)</span>
            </a>
            <?php else: ?>
            <a href="<?= esc_url($link . '#product-reviews') ?>" class="inline-flex w-fit text-xs text-muted-foreground transition-colors hover:text-primary-dark">
                <?= esc_html($no_reviews_text) ?>
            </a>
            <?php endif; ?>

            <!-- CTA Button -->
            <div class="mt-3">
            <?php if ($in_stock): ?>
            <a href="<?= esc_url($link) ?>" class="flex w-full items-center justify-center text-center rounded-md bg-primary px-1 py-2 sm:px-2 md:px-3 lg:px-5 sm:py-2 md:py-3 text-[10px] sm:text-xs lg:text-sm font-bold uppercase leading-tight lg:tracking-wider text-primary-foreground shadow-pill transition-colors hover:bg-primary-dark">
                <?= "Buy Now" ?>
            </a>
            <?php else: ?>
            <span class="flex w-full items-center justify-center text-center rounded-md bg-destructive-soft px-1 py-2 sm:px-2 md:px-3 lg:px-5 sm:py-2 md:py-3 text-[10px] sm:text-xs lg:text-sm font-semibold leading-tight text-destructive">
                <?= "Out of Stock" ?>
            </span>
            <?php endif; ?>
            </div>
        </div>
    </div>
</article>
