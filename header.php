<?php
/**
 * The header for our theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="overflow-x-hidden">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-D0FP1NRE56"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-D0FP1NRE56');
    </script>
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
            $og_image = get_template_directory_uri() . '/screenshot.jpg';
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
</head>

<body <?php body_class('bg-background text-foreground antialiased selection:bg-primary-soft selection:text-primary-dark'); ?>>
<?php wp_body_open(); ?>

<!-- Trust Bar -->
<div class="w-full bg-primary text-primary-foreground text-[13px]" data-testid="trust-bar">
    <div class="container-site flex h-9 items-center justify-between gap-2 px-4 font-medium tracking-wide sm:gap-4">
        <?php $topbar_left = get_field('topbar_left', 'option') ?: '7-10 Day Delivery | Australia-wide dispatch'; ?>
        <p class="min-w-0 flex-1 truncate text-[10px] opacity-90 sm:flex-none sm:overflow-visible sm:text-[13px] sm:whitespace-nowrap"><?php echo esc_html($topbar_left); ?></p>

        <?php $topbar_center = get_field('topbar_center', 'option') ?: 'Free Shipping on Orders Over $299'; ?>
        <p class="hidden md:block opacity-90"><?php echo esc_html($topbar_center); ?></p>

        <div class="flex shrink-0 items-center">
            <?php
            $support_phone = get_field('whatsapp_number', 'option') ?: '+61 488 841 833';
            $clean_phone = preg_replace('/[^0-9]/', '', $support_phone);
            if (strpos($clean_phone, '0') === 0) {
                $clean_phone = '61' . substr($clean_phone, 1);
            }
            $tel_phone = '+' . $clean_phone;
            ?>
            <a href="tel:<?php echo esc_attr($tel_phone); ?>" aria-label="Call <?php echo esc_attr($support_phone); ?>" class="inline-flex shrink-0 items-center gap-1 text-[10px] text-primary-soft transition-colors hover:text-white sm:gap-1.5 sm:text-[13px]">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/><path d="M14.05 2a9 9 0 0 1 8 7.94"/><path d="M14.05 6A5 5 0 0 1 18 10"/></svg>
                <span class="whitespace-nowrap"><?php echo esc_html($support_phone); ?></span>
            </a>
        </div>
    </div>
</div>

<!-- Header -->
<header class="sticky top-0 z-50 w-full border-b border-border bg-background shadow-sm">
    <div class="container-site relative flex h-[68px] items-center justify-between gap-4">

        <!-- Mobile Menu Toggle -->
        <div class="flex items-center lg:hidden">
            <button type="button" aria-label="Menu" id="mobile-menu-open" class="rounded-md p-2 -ml-2 text-foreground/70 transition-colors hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
            </button>
        </div>

        <!-- Logo -->
        <div class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 lg:static lg:translate-x-0 lg:translate-y-0">
            <a href="<?= home_url('/') ?>" class="flex shrink-0 items-center gap-2.5" aria-label="Waklert Australia">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary text-primary-foreground shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3.5 6.5 7.5 18 12 10 16.5 18 20.5 6.5" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="3.5" cy="6.5" r="1.6" fill="#fff" />
                        <circle cx="7.5" cy="18" r="1.6" fill="#fff" />
                        <circle cx="12" cy="10" r="2.4" fill="#f49a5b" />
                        <circle cx="16.5" cy="18" r="1.6" fill="#fff" />
                        <circle cx="20.5" cy="6.5" r="1.6" fill="#fff" />
                    </svg>
                </span>
                <span class="flex flex-col leading-none">
                    <span class="font-heading text-[15px] font-extrabold tracking-[0.12em] text-foreground">WAKLERT</span>
                    <span class="mt-1 text-[9px] font-bold uppercase tracking-[0.24em] text-muted-foreground">Australia</span>
                </span>
            </a>
        </div>

        <!-- Desktop Nav -->
        <nav class="hidden items-center gap-1 lg:flex lg:flex-1 lg:justify-center desktop-nav">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'flex items-center gap-1',
                'fallback_cb'    => false,
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            ]);
            ?>
        </nav>

        <!-- Right Actions -->
        <div class="flex items-center gap-3 ml-auto lg:ml-0">
            <?php
            $whatsapp = get_field('whatsapp_number', 'option') ?: home_url('/contact/');
            ?>
            <a href="<?= esc_url($whatsapp) ?>" target="_blank" rel="noopener noreferrer" class="hidden items-center gap-2 rounded-full bg-primary px-4 py-2 text-sm font-semibold text-primary-foreground shadow-pill transition-colors hover:bg-primary-dark sm:inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 shrink-0"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.67-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                WhatsApp
            </a>
            <?= do_shortcode('[xoo_wsc_cart]') ?>
        </div>
    </div>

    <!-- Mobile Nav Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm lg:hidden" aria-hidden="true"></div>

    <!-- Mobile Nav Drawer -->
    <div id="mobile-menu-drawer" class="fixed inset-y-0 left-0 z-50 w-[85%] max-w-sm transform overflow-y-auto bg-background transition-transform duration-300 ease-in-out lg:hidden -translate-x-full">
        <div class="flex h-[68px] items-center justify-between border-b border-border px-6">
            <span class="font-heading text-lg font-bold text-foreground">
                Waklert Australia
            </span>
            <button type="button" aria-label="Close menu" id="mobile-menu-close" class="rounded-md p-2 text-foreground/70 transition-colors hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>

        <nav class="flex flex-col border-b border-border py-4 mobile-nav">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'flex flex-col',
                'fallback_cb'    => false,
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            ]);
            ?>
        </nav>

        <div class="mx-6 mb-8 mt-6 rounded-2xl border border-border bg-surface p-5">
            <h3 class="mb-2 text-xs font-extrabold uppercase tracking-[0.16em] text-primary-dark">Need a hand?</h3>
            <p class="mb-3 text-sm leading-relaxed text-muted-foreground">Find clear information about products, ordering and delivery.</p>
            <a href="<?= esc_url(home_url('/faq/')) ?>" class="inline-flex items-center gap-2 text-sm font-bold text-primary-dark hover:text-primary">
                Visit the FAQ
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </div>
    </div>
</header>
