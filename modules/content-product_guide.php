<?php
/**
 * Module: Product Guide
 * "Choosing the Right Modafinil"
 */

// The shop archive gets a catalog-driven comparison. The existing ACF guide
// remains stored and continues to render unchanged on every other page.
if (function_exists('is_shop') && is_shop()) {
    get_template_part('modules/content', 'catalog_comparison');
    return;
}

$heading = get_sub_field('heading') ?: '';

$desc    = get_sub_field('description') ?: '';
$guide_items = get_sub_field('guide_items') ?: [];
$is_buyers_guide = is_page('buyers-guide');

if (!$heading && !$desc && !$guide_items) {
    return;
}
?>
<section class="py-12 md:py-16 bg-stone-50" data-testid="product-guide">
    <div class="container-site <?= $is_buyers_guide ? 'max-w-6xl' : 'max-w-4xl' ?>">
        <div class="text-center mb-8">
            <?php if ($heading): ?><h2 class="font-heading text-2xl md:text-4xl font-black text-ink"><?= esc_html($heading) ?></h2><?php endif; ?>
            <?php if ($desc): ?><p class="mx-auto mt-3 max-w-2xl text-base leading-relaxed text-muted-foreground"><?= esc_html($desc) ?></p><?php endif; ?>
        </div>
        
        <div class="<?= $is_buyers_guide ? 'grid gap-4 sm:grid-cols-2 lg:grid-cols-3' : 'space-y-6' ?>">
            <?php if (have_rows('guide_items')): ?>
                <?php while (have_rows('guide_items')): the_row(); ?>
                <?php
                    $item_title = get_sub_field('title');
                    $item_description = get_sub_field('description');
                    $item_note = get_sub_field('best_for');
                    $item_initial = $item_title ? mb_substr(wp_strip_all_tags($item_title), 0, 1) : '';
                ?>
                <article class="<?= $is_buyers_guide ? 'group flex h-full flex-col rounded-2xl border border-border bg-white p-6 shadow-card transition-colors hover:border-primary/40 hover:shadow-md' : 'rounded-xl border border-border bg-card p-6 shadow-card' ?>">
                    <?php if ($is_buyers_guide): ?>
                    <div class="flex items-start gap-4">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-primary-softer font-heading text-lg font-black text-primary" aria-hidden="true">
                            <?= esc_html($item_initial) ?>
                        </span>
                        <div class="min-w-0 flex-1">
                    <?php endif; ?>
                    <h3 class="font-heading text-xl font-bold text-ink"><?= esc_html($item_title) ?></h3>
                    <p class="mt-2 text-sm leading-relaxed text-muted-foreground"><?= esc_html($item_description) ?></p>
                    <?php if ($item_note): ?>
                    <p class="mt-3 text-sm font-semibold text-primary-dark"><?= esc_html($item_note) ?></p>
                    <?php endif; ?>
                    <?php 
                    $product_link = get_sub_field('product_link');
                    if ($product_link): ?>
                    <a href="<?= esc_url($product_link) ?>" class="mt-4 inline-flex items-center gap-1 text-sm font-bold text-price hover:underline">
                        <?= $is_buyers_guide ? 'View listing' : 'View product &rarr;' ?>
                        <?php if ($is_buyers_guide): ?><span aria-hidden="true">&rarr;</span><?php endif; ?>
                    </a>
                    <?php endif; ?>
                    <?php if ($is_buyers_guide): ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </article>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
