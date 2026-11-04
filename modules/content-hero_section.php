<?php
/**
 * Module: Hero Section
 * Waklert Australia editorial storefront introduction.
 * Features Australian tradie holding Waklert 150 product box.
 * Responsive right-anchor layout with seamless desktop blend.
 * 100% dynamic: admin can customize desktop & mobile images via ACF Pro module,
 * with ultra-optimized WebP fallbacks (35KB desktop, 56KB mobile) for instant loading.
 */

if (waklert_module_is_empty()) { return; }

$location      = waklert_module_text('location_text');
$heading       = waklert_module_text('heading');
$subtitle      = waklert_module_text('subtitle');
$description   = waklert_module_text('description');
$primary_btn   = waklert_module_text('primary_button_text');
$primary_link  = waklert_module_text('primary_button_link');
$secondary_btn = trim((string) get_sub_field('secondary_button_text'));
$secondary_link = trim((string) get_sub_field('secondary_button_link'));

// -----------------------------------------------------------------------------
// Desktop Hero Image Handling
// -----------------------------------------------------------------------------
$desktop_img           = get_sub_field('background_image');
$desktop_attachment_id = 0;
$desktop_img_url       = '';
$desktop_alt           = $heading;

if (is_array($desktop_img)) {
    $desktop_attachment_id = !empty($desktop_img['ID']) ? (int) $desktop_img['ID'] : 0;
    $desktop_img_url       = $desktop_img['url'] ?? '';
    if (!empty($desktop_img['alt'])) {
        $desktop_alt = $desktop_img['alt'];
    }
} elseif (is_numeric($desktop_img) && (int) $desktop_img > 0) {
    $desktop_attachment_id = (int) $desktop_img;
    $desktop_img_url       = wp_get_attachment_image_url($desktop_attachment_id, 'full') ?: '';
    $alt = get_post_meta($desktop_attachment_id, '_wp_attachment_image_alt', true);
    if (!empty($alt)) {
        $desktop_alt = $alt;
    }
} elseif (is_string($desktop_img) && $desktop_img !== '') {
    $desktop_img_url = $desktop_img;
}

$is_custom_desktop = !empty($desktop_img_url);
$desktop_webp_url = waklert_content_asset('content_hero_section_image_6583d08075');
$desktop_png_url = waklert_content_asset('content_hero_section_image_3add29e327');
// -----------------------------------------------------------------------------
// Mobile Hero Image Handling
// -----------------------------------------------------------------------------
$mobile_img           = get_sub_field('mobile_image');
$mobile_attachment_id = 0;
$mobile_img_url       = '';
$mobile_alt           = $heading;

if (is_array($mobile_img)) {
    $mobile_attachment_id = !empty($mobile_img['ID']) ? (int) $mobile_img['ID'] : 0;
    $mobile_img_url       = $mobile_img['url'] ?? '';
    if (!empty($mobile_img['alt'])) {
        $mobile_alt = $mobile_img['alt'];
    }
} elseif (is_numeric($mobile_img) && (int) $mobile_img > 0) {
    $mobile_attachment_id = (int) $mobile_img;
    $mobile_img_url       = wp_get_attachment_image_url($mobile_attachment_id, 'full') ?: '';
    $alt = get_post_meta($mobile_attachment_id, '_wp_attachment_image_alt', true);
    if (!empty($alt)) {
        $mobile_alt = $alt;
    }
} elseif (is_string($mobile_img) && $mobile_img !== '') {
    $mobile_img_url = $mobile_img;
}

$is_custom_mobile = !empty($mobile_img_url);
$mobile_webp_url = waklert_content_asset('content_hero_section_image_98dbfb49bd');
$mobile_png_url = waklert_content_asset('content_hero_section_image_fe12bd4316');
?>

<section data-testid="hero-section" class="relative isolate overflow-hidden bg-[#0C4161] text-primary-foreground">
    <!-- MOBILE ONLY: Top Image (< md) -->
<?php if ($is_custom_mobile || $mobile_webp_url || $mobile_png_url): ?>    <div class="relative block md:hidden w-full overflow-hidden bg-[#0C4161]">
        <?php if ($is_custom_mobile): ?>
            <?php if (waklert_has_content(esc_url($mobile_img_url))): ?><img
                src="<?= esc_url($mobile_img_url) ?>" 
                <?php if ($mobile_attachment_id && function_exists('wp_get_attachment_image_srcset')): 
                    $m_srcset = wp_get_attachment_image_srcset($mobile_attachment_id, 'full');
                    if ($m_srcset): ?>
                        srcset="<?= esc_attr($m_srcset) ?>"
                        sizes="(max-width: 768px) 100vw, 736px"
                    <?php endif; ?>
                <?php endif; ?>
                alt="<?= esc_attr($mobile_alt) ?>" 
                class="w-full h-auto object-cover max-h-[440px] object-top"
                loading="eager"
                fetchpriority="high"
                decoding="async"
            /><?php endif; ?>
        <?php else: ?>
            <picture>
                <source srcset="<?= esc_url($mobile_webp_url) ?>" type="image/webp">
                <?php if (waklert_has_content(esc_url($mobile_png_url))): ?><img
                    src="<?= esc_url($mobile_png_url) ?>" 
                    alt="<?= esc_attr($heading) ?>" 
                    class="w-full h-auto object-cover max-h-[440px] object-top"
                    loading="eager"
                    fetchpriority="high"
                    decoding="async"
                /><?php endif; ?>
            </picture>
        <?php endif; ?>
        <!-- Gradient transition between image and content (< md) -->
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-36 sm:h-44 bg-gradient-to-t from-[#0C4161] via-[#0C4161]/80 to-transparent z-10" aria-hidden="true"></div>
    </div>

<?php endif; ?>
    <!-- MAIN HERO CONTENT CONTAINER (with pattern rings, dots & text) -->
    <div class="relative md:min-h-[580px] lg:min-h-[640px] md:flex md:items-center -mt-12 sm:-mt-16 md:mt-0 z-20">
        <!-- Background dot pattern (hidden on mobile, visible on md+) -->
        <div class="pointer-events-none absolute inset-0 hidden md:block bg-pattern-dots-dark z-0" aria-hidden="true"></div>

        <?php waklert_output_pattern_rings('hidden md:block'); ?>

        <!-- TABLET & DESKTOP ONLY: Background Right-Anchored Image (>= md) -->
<?php if ($is_custom_desktop || $desktop_webp_url || $desktop_png_url): ?>        <div class="pointer-events-none absolute inset-0 z-0 overflow-hidden hidden md:block">
            <?php if ($is_custom_desktop): ?>
                <?php if (waklert_has_content(esc_url($desktop_img_url))): ?><img
                    src="<?= esc_url($desktop_img_url) ?>" 
                    <?php if ($desktop_attachment_id && function_exists('wp_get_attachment_image_srcset')): 
                        $d_srcset = wp_get_attachment_image_srcset($desktop_attachment_id, 'full');
                        if ($d_srcset): ?>
                            srcset="<?= esc_attr($d_srcset) ?>"
                            sizes="(max-width: 1024px) 100vw, 1024px"
                        <?php endif; ?>
                    <?php endif; ?>
                    alt="<?= esc_attr($desktop_alt) ?>" 
                    class="h-full w-full object-cover"
                    loading="eager"
                    fetchpriority="high"
                    decoding="async"
                /><?php endif; ?>
            <?php else: ?>
                <picture>
                    <source srcset="<?= esc_url($desktop_webp_url) ?>" type="image/webp">
                    <?php if (waklert_has_content(esc_url($desktop_png_url))): ?><img
                        src="<?= esc_url($desktop_png_url) ?>" 
                        alt="<?= esc_attr($heading) ?>" 
                        class="h-full w-full object-cover"
                        loading="eager"
                        fetchpriority="high"
                        decoding="async"
                    /><?php endif; ?>
                </picture>
            <?php endif; ?>
            <!-- Tablet backdrop overlay (md to lg) for text contrast, hidden on desktop lg+ -->
            <div class="absolute inset-0 bg-[#0C4161]/75 lg:hidden" aria-hidden="true"></div>
        </div>

<?php endif; ?>
        <!-- Left Column Content -->
        <div class="container-site relative z-10 w-full pt-2 pb-8 sm:pt-3 sm:pb-10 md:py-12 lg:py-14">
            <div class="max-w-lg lg:max-w-[460px] xl:max-w-[530px]">
                <?php if ($location): ?>
                <?php if (waklert_has_content(esc_html($location))): ?><span class="mb-5 md:mb-6 inline-flex items-center gap-2 md:gap-2.5 rounded-full border border-white/25 bg-white/10 px-4.5 py-2 md:px-5 md:py-2.5 text-xs sm:text-sm md:text-[0.9375rem] font-bold uppercase tracking-[0.16em] text-white backdrop-blur-md shadow-sm">
                    <?= waklert_content_icon('content_hero_section_icon_bda9a58a43') ?>
                    <?php if (waklert_has_content(esc_html($location))): ?><span><?= esc_html($location) ?></span><?php endif; ?>
                </span><?php endif; ?>
                <?php endif; ?>

                <?php if (waklert_has_content(esc_html($heading))): ?><h1 class="mb-4 md:mb-5 font-heading text-3xl sm:text-4xl md:text-[2.75rem] lg:text-[3.125rem] xl:text-[3.4375rem] font-extrabold leading-[1.1] md:leading-[1.08] tracking-tight text-white drop-shadow-sm">
                    <?= esc_html($heading) ?>
                </h1><?php endif; ?>

                <?php if ($subtitle): ?>
                <?php if (waklert_has_content(esc_html($subtitle))): ?><p class="mb-5 md:mb-6 font-heading text-xl sm:text-2xl md:text-[1.625rem] lg:text-[1.875rem] font-semibold leading-snug text-amber-300/95">
                    <?= esc_html($subtitle) ?>
                </p><?php endif; ?>
                <?php endif; ?>

                <?php if ($description): ?>
                <?php if (waklert_has_content(esc_html($description))): ?><p class="mb-7 md:mb-8 text-base sm:text-lg md:text-[1.25rem] lg:text-[1.35rem] leading-relaxed text-white/85">
                    <?= esc_html($description) ?>
                </p><?php endif; ?>
                <?php endif; ?>

                <?php if (($primary_btn !== '' && $primary_link !== '') || ($secondary_btn !== '' && $secondary_link !== '')): ?>
                <div class="flex flex-wrap gap-2.5 sm:gap-3 md:gap-3.5 mb-8">
                    <?php if ((waklert_has_content(esc_html($primary_btn))) && waklert_has_content(esc_url($primary_link))): ?><a href="<?= esc_url($primary_link) ?>" class="group inline-flex items-center gap-2 md:gap-2.5 rounded-full bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 px-5 py-2.5 sm:px-7 sm:py-3.5 md:px-8 md:py-4 text-xs sm:text-base md:text-[1.0625rem] font-extrabold uppercase tracking-wide text-slate-950 shadow-lg shadow-amber-500/20 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-500/30 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">
                        <?php if (waklert_has_content(esc_html($primary_btn))): ?><span><?= esc_html($primary_btn) ?></span><?php endif; ?>
                        <?= waklert_content_icon('content_hero_section_icon_609ee66802') ?>
                    </a><?php endif; ?>
                    <?php if ($secondary_btn !== '' && $secondary_link !== ''): ?>
                        <?php if ((waklert_has_content(esc_html($secondary_btn))) && waklert_has_content(esc_url($secondary_link))): ?><a href="<?= esc_url($secondary_link) ?>" class="inline-flex items-center rounded-full border border-white/30 bg-white/10 px-4 py-2.5 sm:px-6 sm:py-3.5 md:px-7 md:py-4 text-xs sm:text-base md:text-[1.0625rem] font-bold uppercase tracking-wide text-white transition hover:bg-white/20 hover:-translate-y-0.5">
                            <?= esc_html($secondary_btn) ?>
                        </a><?php endif; ?>
                    <?php endif; ?>
                </div>

                <?php endif; ?>

                <!-- Feature badges (editable in the module: Feature Badges) -->
                <?php
                $hero_badge_icons = [
                    'truck'  => waklert_content_icon('content_hero_section_icon_1aa793cd5a'),
                    'shield' => waklert_content_icon('content_hero_section_icon_4171b8782e'),
                    'lock'   => waklert_content_icon('content_hero_section_icon_e35e028e8f'),
                ];
                $hero_badges = [];
                if (have_rows('feature_badges')) {
                    while (have_rows('feature_badges')) {
                        the_row();
        if (!waklert_module_row_has_content(get_row(true))) { continue; }
                        if (!waklert_has_content(get_sub_field('title')) && !waklert_has_content(get_sub_field('subtitle'))) { continue; }
                        $hero_badges[] = [
                            'title'    => (string) get_sub_field('title'),
                            'subtitle' => (string) get_sub_field('subtitle'),
                            'icon'     => (string) get_sub_field('icon'),
                        ];
                    }
                } else {
                    $hero_badges = [];
                }
                ?>
                <?php if ($hero_badges): ?>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-2">
                    <?php foreach ($hero_badges as $badge): ?>
                    <div class="group flex items-center gap-2.5 rounded-xl border border-dashed border-white/30 bg-white/10 hover:bg-white/15 backdrop-blur-sm p-2.5 px-3 transition-all duration-300 hover:-translate-y-0.5 hover:border-amber-400/80">
                        <div class="w-8 h-8 rounded-lg bg-white/90 p-1 flex items-center justify-center shrink-0 shadow-xs transition-transform duration-300 group-hover:scale-110">
                            <?= $hero_badge_icons[$badge['icon']] ?? $hero_badge_icons['shield'] ?>
                        </div>
                        <div class="leading-tight">
                            <?php if (waklert_has_content(esc_html($badge['title']))): ?><span class="block text-[11px] font-extrabold text-white"><?= esc_html($badge['title']) ?></span><?php endif; ?>
                            <?php if (waklert_has_content(esc_html($badge['subtitle']))): ?><span class="block text-[10px] text-white/75 font-medium"><?= esc_html($badge['subtitle']) ?></span><?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
