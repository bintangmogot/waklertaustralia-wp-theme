<?php
/**
 * The header for our theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="overflow-x-hidden">
<head>
    <?php $measurement_id = trim((string) waklert_content('pg_header_gtm_id')); if ($measurement_id !== '') : ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= esc_attr($measurement_id) ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){window.dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', <?= wp_json_encode($measurement_id, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>);
    </script>
    <?php endif; ?>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php if (is_single() || is_page()) : ?>
        <?php
        global $post;
        $og_url = get_permalink();
        $og_title = get_the_title();
        $og_description = get_the_excerpt();
        $og_image = get_the_post_thumbnail_url($post->ID, 'full');
        if (!$og_image) {
            $og_image = waklert_content_asset('header_image_9ed1f5bbdf');
        }
        ?>
        <meta property="og:title" content="<?php echo esc_attr($og_title); ?>" />
        <meta property="og:description" content="<?php echo esc_attr($og_description); ?>" />
        <meta property="og:url" content="<?php echo esc_url($og_url); ?>" />
        <meta property="og:image" content="<?php echo esc_url($og_image); ?>" />
        <meta property="og:type" content="article" />
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?php echo esc_attr($og_title); ?>">
        <meta name="twitter:description" content="<?php echo esc_attr($og_description); ?>">
        <meta name="twitter:image" content="<?php echo esc_url($og_image); ?>">
    <?php else : ?>
        <meta property="og:title" content="<?php echo esc_attr(get_bloginfo('name')); ?>" />
        <meta property="og:description" content="<?php echo esc_attr(get_bloginfo('description')); ?>" />
        <meta property="og:url" content="<?php echo esc_url(home_url('/')); ?>" />
        <meta property="og:type" content="website" />
    <?php endif; ?>
    <?php wp_head(); ?>
    <?php if (!has_site_icon()) : ?>
        <link rel="icon" href="<?= esc_url(waklert_content_asset('header_image_18dabadce0')) ?>" type="image/png">
        <link rel="apple-touch-icon" href="<?= esc_url(waklert_content_asset('header_image_18dabadce0')) ?>">
    <?php endif; ?>
</head>

<body <?php body_class('bg-background text-foreground antialiased selection:bg-primary-soft selection:text-primary-dark'); ?>>
<?php wp_body_open(); ?>

<!-- Trust Bar -->
<div class="relative overflow-hidden w-full bg-gradient-to-r from-[#082a3f] via-[#0c4161] to-[#0f4f75] bg-pattern-dots-dark border-b border-sky-400/20 text-white text-[13px]" data-testid="trust-bar">
    <div class="container-site relative z-10 flex h-9 items-center justify-between gap-2 px-4 font-medium tracking-wide sm:gap-4">
        <?php $topbar_left = get_field('topbar_left', 'option'); ?>
        <?php if (!empty($topbar_left)): ?>
        <p class="min-w-0 flex-1 truncate text-[10px] opacity-95 sm:flex-none sm:overflow-visible sm:text-[13px] sm:whitespace-nowrap flex items-center gap-1.5">
            <!-- Colorful Delivery Van SVG -->
            <?= waklert_content_icon('header_icon_211072ad49') ?>
            <span><?php echo esc_html($topbar_left); ?></span>
        </p>
        <?php endif; ?>

        <?php $topbar_center = get_field('topbar_center', 'option'); ?>
        <?php if (!empty($topbar_center)): ?>
        <p class="hidden md:flex items-center gap-1.5 opacity-95 text-amber-300 font-semibold">
            <!-- Colorful Star SVG -->
            <?= waklert_content_icon('header_icon_91ef0d23aa') ?>
            <span><?php echo esc_html($topbar_center); ?></span>
        </p>
        <?php endif; ?>

        <?php 
        $raw_phone = trim((string) (get_field('header_phone_number', 'option') ?: get_field('whatsapp_number', 'option')));
        $display_phone = '';
        $tel_phone = '';
        if ($raw_phone !== '') {
            $clean_digits = preg_replace('/\D+/', '', $raw_phone);
            if (str_starts_with($clean_digits, '61') && strlen($clean_digits) >= 10) {
                $clean_digits = '0' . substr($clean_digits, 2);
            }
            if (strlen($clean_digits) === 10 && str_starts_with($clean_digits, '0')) {
                $display_phone = substr($clean_digits, 0, 4) . ' ' . substr($clean_digits, 4, 3) . ' ' . substr($clean_digits, 7, 3);
            } elseif (strlen($clean_digits) === 9 && str_starts_with($clean_digits, '4')) {
                $clean_digits = '0' . $clean_digits;
                $display_phone = substr($clean_digits, 0, 4) . ' ' . substr($clean_digits, 4, 3) . ' ' . substr($clean_digits, 7, 3);
            } else {
                $display_phone = trim((string) preg_replace('/^\+?61\s*/', '0', $raw_phone));
            }
            $tel_phone = waklert_format_tel_url($display_phone ?: $raw_phone);
        }

        $header_btn_text = trim((string) get_field('whatsapp_button_text', 'option'));
        if ($header_btn_text === '' || stripos($header_btn_text, 'whatsapp') !== false) {
            $header_btn_text = $display_phone;
        }

        $header_btn_url_raw = trim((string) get_field('whatsapp_button_url', 'option'));
        if ($header_btn_url_raw !== '' && stripos($header_btn_url_raw, 'wa.me') === false) {
            if (preg_match('#^(tel:|sms:)#i', $header_btn_url_raw)) {
                $header_btn_href = waklert_format_tel_url($header_btn_url_raw, strtolower(substr($header_btn_url_raw, 0, 3)));
            } elseif (preg_match('#^(mailto:|https?://|/|\#)#i', $header_btn_url_raw)) {
                $header_btn_href = $header_btn_url_raw;
            } else {
                $header_btn_href = waklert_format_tel_url($header_btn_url_raw);
            }
        } else {
            $header_btn_href = $tel_phone;
        }
        ?>
        <?php if ($display_phone !== ''): ?>
        <div class="flex shrink-0 items-center md:hidden">
            <a href="<?php echo esc_attr($tel_phone); ?>" aria-label="Call <?php echo esc_attr($display_phone); ?>" class="inline-flex shrink-0 items-center gap-1.5 text-[10px] text-white/90 transition-colors hover:text-white sm:text-[13px] font-semibold bg-white/10 hover:bg-white/20 px-2.5 py-1 rounded-full border border-white/20">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <?= waklert_content_icon('header_icon_abf8657331') ?>
                <span class="whitespace-nowrap"><?php echo esc_html($display_phone); ?></span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Header -->
<header class="sticky top-0 z-50 w-full border-b-2 border-solid border-sky-200/80 bg-white/95 backdrop-blur-md shadow-sm transition-all">
    <div class="container-site relative flex h-[68px] sm:h-[72px] items-center justify-between gap-4">

        <!-- Mobile Menu Toggle -->
        <div class="flex items-center lg:hidden">
            <button type="button" aria-label="<?= esc_attr(waklert_content('header_text_0b7eb152ba')) ?>" id="mobile-menu-open" class="rounded-xl p-2.5 -ml-1 text-[#0c4161] bg-sky-50 border-2 border-solid border-sky-300/80 hover:bg-sky-100 hover:border-[#0c4161] transition-all">
                <?= waklert_content_icon('header_icon_a31a0c4c5a') ?>
            </button>
        </div>

        <!-- Logo -->
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 lg:static lg:translate-x-0 lg:translate-y-0 transition-transform duration-300 hover:scale-[1.02]">
            <?php waklert_the_logo('h-12 sm:h-[53px] w-auto max-w-[264px] sm:max-w-[312px] object-contain', 'header'); ?>
        </div>

        <!-- Desktop Nav -->
        <nav class="hidden items-center gap-1 lg:flex lg:flex-1 lg:justify-center desktop-nav">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'flex items-center gap-1.5 font-semibold text-slate-700',
                'fallback_cb'    => false,
                'walker'         => class_exists('Waklert_Desktop_Nav_Walker') ? new Waklert_Desktop_Nav_Walker() : false,
            ]);
            ?>
        </nav>

        <!-- Right Actions -->
        <div class="flex items-center gap-2 sm:gap-3 ml-auto lg:ml-0">
            <?php if ($header_btn_text !== '' && $header_btn_href !== ''): ?>
            <!-- Header Phone Number Button (Hidden on mobile; Solid Blue Background & White Icon on desktop) -->
            <a href="<?= esc_attr($header_btn_href) ?>" aria-label="Call <?= esc_attr($header_btn_text) ?>" class="hidden md:inline-flex items-center gap-2 sm:gap-2.5 px-3.5 sm:px-4 py-1.5 rounded-full bg-[#0c4161] hover:bg-[#082a3f] text-white transition-all group shadow-sm">
                <span class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-full bg-white/15 text-white transition-colors group-hover:bg-white/25">
                    <?= waklert_content_icon('header_icon_7ae7816964') ?>
                </span>
                <span class="text-base sm:text-lg lg:text-xl font-black font-heading tracking-tight text-white whitespace-nowrap"><?= esc_html($header_btn_text) ?></span>
            </a>
            <?php endif; ?>

            <?= do_shortcode('[xoo_wsc_cart]') ?>
        </div>
    </div>
</header>

<!-- Mobile Nav Overlay (Placed outside <header> to avoid backdrop-blur/sticky containing block clipping) -->
<div id="mobile-menu-overlay" class="fixed inset-0 z-[99998] hidden bg-slate-900/60 backdrop-blur-sm lg:hidden transition-opacity" aria-hidden="true"></div>

<!-- Mobile Nav Drawer -->
<div id="mobile-menu-drawer" class="fixed inset-y-0 left-0 z-[99999] w-[88%] max-w-sm h-screen h-[100dvh] transform overflow-y-auto bg-gradient-to-b from-[#f8fafc] via-[#f0f6fa] to-[#eef5fa] bg-pattern-dots transition-transform duration-300 ease-in-out lg:hidden -translate-x-full shadow-2xl flex flex-col justify-between">
    <div class="shrink-0">
        <div class="flex h-[68px] items-center justify-between border-b-2 border-solid border-sky-200/80 bg-white/90 px-6 backdrop-blur">
            <?php waklert_the_logo('h-11 w-auto max-w-[228px] object-contain', 'mobile'); ?>
            <button type="button" aria-label="<?= esc_attr(waklert_content('header_text_ba014a1153')) ?>" id="mobile-menu-close" class="rounded-xl p-2 text-[#0c4161] bg-sky-50 border border-solid border-sky-300 hover:bg-sky-100 transition-colors">
                <?= waklert_content_icon('header_icon_9ffbbe9b97') ?>
            </button>
        </div>

        <nav class="flex flex-col border-b-2 border-solid border-sky-200/80 py-3 px-4 mobile-nav">
            <?php
            wp_nav_menu([
                'theme_location' => 'mobile',
                'container'      => false,
                'menu_class'     => 'flex flex-col divide-y divide-solid divide-sky-200/80',
                'fallback_cb'    => function() {
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'flex flex-col divide-y divide-solid divide-sky-200/80',
                        'fallback_cb'    => false,
                        'walker'         => class_exists('Waklert_Mobile_Nav_Walker') ? new Waklert_Mobile_Nav_Walker() : false,
                    ]);
                },
                'walker'         => class_exists('Waklert_Mobile_Nav_Walker') ? new Waklert_Mobile_Nav_Walker() : false,
            ]);
            ?>
        </nav>

        <?php if ($header_btn_text !== '' && $header_btn_href !== ''): ?>
        <div class="px-6 pt-5 pb-2">
            <a href="<?= esc_attr($header_btn_href) ?>" class="flex w-full items-center justify-center gap-2.5 rounded-full bg-[#0c4161] px-4 py-2.5 sm:px-5 sm:py-3.5 text-sm sm:text-base font-black text-white shadow-md transition-all hover:shadow-lg hover:bg-[#082a3f]">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white/20 text-white">
                    <?= waklert_content_icon('header_icon_5f623be711') ?>
                </span>
                <span><?= esc_html($header_btn_text) ?></span>
            </a>
        </div>
        <?php endif; ?>
    </div>

    <?php
    $help_eyebrow = waklert_option_text('mobile_help_eyebrow');
    $help_title = waklert_option_text('mobile_help_title');
    $help_text = waklert_option_text('mobile_help_text');
    $help_button = waklert_option_text('mobile_help_button_text');
    $help_url = esc_url(waklert_resolve_link(waklert_option_text('mobile_help_button_url')));
    $show_help_heading = waklert_has_content($help_eyebrow) || waklert_has_content($help_title);
    $show_help_button = waklert_has_content($help_button) && waklert_has_content($help_url);
    ?>
    <?php if ($show_help_heading || waklert_has_content($help_text) || $show_help_button): ?>
    <!-- 2-Tone Dashed Help Card in Mobile Drawer -->
    <div data-testid="mobile-help-card" class="mx-6 mb-8 mt-4 shrink-0 rounded-3xl border-2 border-solid border-sky-300/80 bg-white overflow-hidden shadow-sm transition-all hover:shadow-md">
        <?php if ($show_help_heading || waklert_has_content($help_text)): ?>
        <div class="p-5">
            <?php if ($show_help_heading): ?>
            <div class="flex items-center gap-3 mb-2.5">
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-600 border border-amber-200">
                    <!-- Colorful Help Life Ring SVG -->
                    <?= waklert_content_icon('header_icon_76cdc1cd7a') ?>
                </div>
                <div>
                    <?php if (waklert_has_content($help_eyebrow)): ?><span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-600"><?= esc_html($help_eyebrow) ?></span><?php endif; ?>
                    <?php if (waklert_has_content($help_title)): ?><h3 class="text-sm font-extrabold text-[#0c4161]"><?= esc_html($help_title) ?></h3><?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
            <?php if (waklert_has_content($help_text)): ?><p class="text-xs leading-relaxed text-slate-600"><?= esc_html($help_text) ?></p><?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if ($show_help_button): ?>
        <a href="<?= $help_url ?>" class="flex items-center justify-between bg-gradient-to-r from-[#0c4161] to-[#125883] px-4 py-2.5 sm:px-5 sm:py-3 text-xs font-bold text-white transition-colors hover:from-[#09324c] hover:to-[#0c4161]">
            <span><?= esc_html($help_button) ?></span>
            <?= waklert_content_icon('header_icon_d49d6353f9') ?>
        </a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
