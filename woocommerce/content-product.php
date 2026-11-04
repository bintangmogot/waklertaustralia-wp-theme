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
$no_reviews_text = waklert_get_product_presentation_option('product_no_reviews_text');
$in_stock_label = waklert_option_text('shop_card_in_stock_label');
$out_of_stock_label = waklert_option_text('shop_card_out_of_stock_label');
$best_seller_label = waklert_get_product_presentation_option('best_seller_label');
?>
<article class="group relative flex flex-col overflow-hidden rounded-3xl border-2 border-dashed border-sky-300/80 hover:border-[#0c4161] bg-white shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
    <!-- Badges -->
    <div class="absolute left-3 top-3 z-10 flex flex-col gap-1.5">
        <?php if ($in_stock): ?>
        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-white shadow-sm">
            <?= waklert_content_icon('content_product_icon_fe0715cd87') ?>
            <?= esc_html($in_stock_label) ?>
        </span>
        <?php else: ?>
        <span class="inline-flex items-center gap-1 rounded-full bg-rose-500 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-white shadow-sm">
            <?= esc_html($out_of_stock_label) ?>
        </span>
        <?php endif; ?>

        <?php if ($product->is_featured()): ?>
        <span class="inline-flex items-center gap-1 rounded-full bg-amber-500 px-3 py-1 text-[10px] font-extrabold uppercase tracking-wider text-white shadow-sm">
            <?= waklert_content_icon('content_product_icon_806f32cd78') ?>
            <?= esc_html($best_seller_label) ?>
        </span>
        <?php endif; ?>
    </div>

    <!-- Product Image with Radial Spotlight -->
    <a href="<?= esc_url($link) ?>" class="relative block aspect-square overflow-hidden bg-[radial-gradient(ellipse_at_center,rgba(186,230,253,0.35)_0%,rgba(255,255,255,0.95)_70%)] p-6">
        <img src="<?= esc_url($image) ?>" alt="<?= esc_attr(get_post_meta($product->get_image_id(), '_wp_attachment_image_alt', true) ?: $title) ?>" loading="lazy" class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-110">
    </a>

    <!-- Product Info -->
    <div class="flex flex-1 flex-col p-4 md:p-6 border-t border-dashed border-sky-100">
        <h3 class="font-heading text-sm sm:text-base md:text-lg font-extrabold text-slate-900 group-hover:text-[#0c4161] transition-colors leading-snug">
            <a href="<?= esc_url($link) ?>" class="line-clamp-2">
                <?= esc_html($title) ?>
            </a>
        </h3>

        <?php if ($excerpt !== ''): ?>
        <div class="product-desc-wrapper mt-2">
            <p id="<?= esc_attr($description_id) ?>" class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                <?= esc_html($excerpt) ?>
            </p>
            <?php if ($excerpt_length > 80): ?>
            <button type="button" aria-expanded="false" aria-controls="<?= esc_attr($description_id) ?>" data-product-description-toggle class="mt-1 text-xs font-bold text-[#0c4161] hover:text-amber-600 transition-colors">
                <?= esc_html(waklert_option_text('shop_card_read_more_label')) ?> <?= esc_html(waklert_content('content_product_text_9cd110735f')) ?>
            </button>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Pricing Block -->
        <div class="mt-4 pt-3 border-t border-dashed border-slate-200/80 flex flex-wrap items-baseline justify-between gap-2">
            <div>
                <p class="font-heading text-base md:text-xl font-extrabold text-[#0c4161] leading-tight">
                    <?= wp_kses_post(waklert_get_product_card_price_html($product)) ?>
                </p>
                <?php if ($unit_price !== null): ?>
                <span class="mt-1 inline-flex items-center rounded-full bg-emerald-50 border border-emerald-200 px-2 py-0.5 text-[11px] font-bold text-emerald-800">
                    <?= esc_html(waklert_option_text('shop_card_unit_prefix')) ?> <?= wp_kses_post(wc_price($unit_price, array('decimals' => 2))) ?><?= esc_html(waklert_option_text('shop_card_unit_suffix')) ?>
                </span>
                <?php endif; ?>
            </div>

            <!-- Mini AU Post Pill -->
            <span class="inline-flex items-center gap-1 text-[11px] font-bold text-slate-500">
                <?= waklert_content_icon('content_product_icon_de67906da9') ?>
                <?= esc_html(waklert_option_text('shop_card_delivery_label')) ?>
            </span>
        </div>

        <!-- Anchor action at the bottom of the card -->
        <div class="mt-auto pt-3 sm:pt-5">
            <?php if (apply_filters('waklert_show_product_card_reviews', false)): ?>
                <div class="mb-2 sm:mb-3">
                    <?php if ($review_summary['review_count'] > 0): ?>
                    <a href="<?= esc_url($link . '#product-reviews') ?>" class="inline-flex w-fit items-center gap-1.5 text-xs text-muted-foreground transition-colors hover:text-primary-dark" aria-label="Read <?= esc_attr($review_summary['review_count']) ?> product reviews">
                        <?php if ($review_summary['rating_count'] > 0): ?>
                            <span class="text-accent" aria-hidden="true"><?= waklert_content_icon('manual_star_marker') ?></span>
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
                </div>
            <?php endif; ?>

            <!-- CTA Button (Compact on Mobile) -->
            <div>
            <?php if ($in_stock): ?>
            <a href="<?= esc_url($link) ?>" class="flex w-full items-center justify-center gap-1.5 sm:gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 px-2.5 py-2 sm:px-4 sm:py-3 text-[11px] sm:text-xs md:text-sm font-black uppercase tracking-tight sm:tracking-wider text-white shadow-md hover:shadow-lg transition-all hover:-translate-y-0.5 leading-none text-center">
                <?= waklert_content_icon('content_product_icon_a4f9a0edd6') ?>
                <span><?= esc_html(waklert_option_text('shop_card_button_text')) ?></span>
            </a>
            <?php else: ?>
            <span class="flex w-full items-center justify-center rounded-xl bg-slate-100 px-2.5 py-2 sm:px-4 sm:py-3 text-[11px] sm:text-xs md:text-sm font-bold uppercase tracking-tight sm:tracking-wider text-slate-400">
                <?= esc_html($out_of_stock_label) ?>
            </span>
            <?php endif; ?>
            </div>
        </div>
    </div>
</article>
