<?php
/**
 * Module: Hero Section
 * Waklert Australia editorial storefront introduction.
 */

$location      = get_sub_field('location_text') ?: 'Australia-wide delivery options';
$heading       = get_sub_field('heading') ?: 'Waklert Australia';
$subtitle      = get_sub_field('subtitle') ?: 'A focused range of armodafinil products';
$description   = get_sub_field('description') ?: 'Explore product information, ordering details and delivery options in one place. Armodafinil is prescription-only in Australia; speak with a qualified healthcare professional before use.';
$primary_btn   = get_sub_field('primary_button_text') ?: 'View products';
$primary_link  = get_sub_field('primary_button_link') ?: wc_get_page_permalink('shop');
$secondary_btn = trim((string) get_sub_field('secondary_button_text'));
$secondary_link = trim((string) get_sub_field('secondary_button_link'));

$hero_products = function_exists('wc_get_products')
    ? wc_get_products([
        'status'  => 'publish',
        'limit'   => 3,
        'orderby' => 'menu_order',
        'order'   => 'ASC',
        'return'  => 'objects',
    ])
    : [];
$product_count = function_exists('wp_count_posts') ? (int) wp_count_posts('product')->publish : count($hero_products);
?>

<section data-testid="hero-section" class="relative isolate overflow-hidden bg-primary-dark text-primary-foreground">
    <?php waklert_output_pattern_rings(); ?>

    <div class="container-site relative grid min-h-[600px] items-center gap-14 py-16 md:py-20 lg:grid-cols-[1.05fr_.95fr] lg:gap-16 lg:py-24">
        <div class="max-w-2xl">
            <span class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-white backdrop-blur-sm">
                <span aria-hidden="true" class="h-2 w-2 rounded-full bg-accent"></span>
                <?= esc_html($location) ?>
            </span>

            <h1 class="mb-4 max-w-xl font-heading text-4xl font-extrabold leading-[1.05] tracking-tight text-white md:text-5xl lg:text-6xl">
                <?= esc_html($heading) ?>
            </h1>
            <p class="mb-5 max-w-xl font-heading text-xl font-semibold leading-snug text-white/85 md:text-2xl">
                <?= esc_html($subtitle) ?>
            </p>
            <p class="mb-8 max-w-xl text-base leading-relaxed text-white/75 md:text-lg">
                <?= esc_html($description) ?>
            </p>

            <div class="mb-10 flex flex-wrap gap-3">
                <a href="<?= esc_url($primary_link) ?>" class="inline-flex items-center gap-2 rounded-full bg-accent px-6 py-3.5 text-sm font-extrabold uppercase tracking-wide text-accent-foreground shadow-pill transition hover:-translate-y-0.5 hover:brightness-105 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">
                    <?= esc_html($primary_btn) ?>
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </a>
                <?php if ($secondary_btn !== '' && $secondary_link !== ''): ?>
                    <a href="<?= esc_url($secondary_link) ?>" class="inline-flex items-center rounded-full border border-accent/70 px-6 py-3.5 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-accent hover:text-accent-foreground focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">
                        <?= esc_html($secondary_btn) ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="flex flex-wrap gap-x-8 gap-y-4 border-t border-white/15 pt-6">
                <div>
                    <p class="font-heading text-2xl font-extrabold text-accent">01</p>
                    <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.15em] text-white/65">Focused category</p>
                </div>
                <div>
                    <p class="font-heading text-2xl font-extrabold text-accent"><?= esc_html((string) $product_count) ?></p>
                    <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.15em] text-white/65">Products listed</p>
                </div>
                <div>
                    <p class="font-heading text-2xl font-extrabold text-accent">AU</p>
                    <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.15em] text-white/65">Australian storefront</p>
                </div>
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-lg lg:ml-auto">
            <div aria-hidden="true" class="absolute -inset-5 -rotate-3 rounded-[2rem] border border-white/15"></div>
            <div class="relative overflow-hidden rounded-3xl border border-white/70 bg-background p-6 text-foreground shadow-2xl md:p-8">
                <div class="mb-7 flex items-start justify-between gap-4">
                    <div>
                        <p class="mb-2 text-[10px] font-extrabold uppercase tracking-[0.2em] text-primary">The collection</p>
                        <h2 class="font-heading text-2xl font-extrabold tracking-tight text-foreground md:text-3xl">Armodafinil, clearly presented.</h2>
                    </div>
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-primary-soft text-primary-dark" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7 4h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Zm3 4h4m-4 4h4m-4 4h2"/></svg>
                    </span>
                </div>

                <?php if (!empty($hero_products)) : ?>
                    <div class="divide-y divide-border">
                        <?php foreach ($hero_products as $index => $product) : ?>
                            <a href="<?= esc_url(get_permalink($product->get_id())) ?>" class="group flex items-center gap-4 py-4 first:pt-0 last:pb-0">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-surface font-heading text-xs font-extrabold tracking-wide text-primary-dark transition group-hover:bg-primary-soft">
                                    <?= esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)) ?>
                                </span>
                                <span class="min-w-0 flex-1">
                                    <span class="block truncate font-bold text-foreground transition group-hover:text-primary-dark"><?= esc_html($product->get_name()) ?></span>
                                    <span class="mt-1 block text-xs text-muted-foreground">Armodafinil product</span>
                                </span>
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-muted-foreground transition group-hover:translate-x-1 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <p class="rounded-2xl bg-surface p-5 text-sm leading-relaxed text-muted-foreground">Browse the focused armodafinil range and review the product information before ordering.</p>
                <?php endif; ?>

                <div class="mt-7 flex items-center justify-between gap-4 border-t border-border pt-5">
                    <span class="text-xs font-semibold text-muted-foreground">One focused category</span>
                    <a href="<?= esc_url($primary_link) ?>" class="inline-flex items-center gap-1.5 text-xs font-extrabold uppercase tracking-wide text-primary-dark hover:text-primary">
                        Explore the range
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </a>
                </div>
            </div>
            <p class="mt-5 text-center text-xs font-medium tracking-wide text-white/60">Product information is not a substitute for advice from a healthcare professional.</p>
        </div>
    </div>
</section>
