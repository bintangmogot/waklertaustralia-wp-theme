<?php
/**
 * Enqueue scripts and styles
 */

function modmy_enqueue_scripts() {
    // 1. Google Fonts
    wp_enqueue_style(
        'modmy-fonts',
        'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap',
        array(),
        null
    );

    if (function_exists('is_product') && is_product()) {
        wp_enqueue_style(
            'waklert-flaticon-uicons',
            'https://cdn-uicons.flaticon.com/4.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css',
            array(),
            '4.0.0'
        );
    }

    // 2. Main Tailwind CSS
    // Check if main.css exists in assets/css
    $css_path = MODMY_THEME_DIR . '/assets/css/main.css';
    $css_url  = MODMY_THEME_URI . '/assets/css/main.css';
    
    if (file_exists($css_path)) {
        wp_enqueue_style('modmy-style', $css_url, array(), filemtime($css_path));
        
        // Add robust prose table and typography styles as inline safeguard
        $custom_css = "
            .prose table { width: 100%; max-width: 100%; table-layout: auto; text-align: left; margin: 2rem 0; border-collapse: separate; border-spacing: 0; border: 1px solid var(--color-border); border-radius: var(--radius-xl, 1rem); overflow: hidden; background-color: #fff; box-shadow: 0 4px 20px -4px oklch(0.208 0.042 265.755 / 0.08); font-size: 0.9375rem; line-height: 1.55; }
            .prose .table-wrapper, .prose figure.wp-block-table { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; margin: 2rem 0; border: 1px solid var(--color-border); border-radius: var(--radius-xl, 1rem); background-color: #fff; box-shadow: 0 4px 20px -4px oklch(0.208 0.042 265.755 / 0.08); }
            .prose .table-wrapper table, .prose figure.wp-block-table table { margin: 0; border: none; border-radius: 0; box-shadow: none; min-width: 100%; }
            .prose thead { border-bottom: 2px solid var(--color-primary); background-color: var(--color-primary-softer); }
            .prose th, .prose thead th { font-family: var(--font-heading); font-weight: 800; font-size: 0.875rem; letter-spacing: 0.02em; color: var(--color-foreground); padding: 1rem 1.25rem; vertical-align: middle; border-bottom: 2px solid var(--color-primary); border-right: 1px solid oklch(0.9 0.018 82 / 0.6); background-color: var(--color-primary-softer); text-align: left; }
            .prose th:last-child, .prose thead th:last-child { border-right: none; }
            .prose table:not(:has(thead)) tbody tr:first-child td, .prose table:not(:has(thead)) tbody tr:first-child th { font-family: var(--font-heading); font-weight: 800; font-size: 0.875rem; letter-spacing: 0.02em; color: var(--color-foreground); padding: 1rem 1.25rem; vertical-align: middle; border-bottom: 2px solid var(--color-primary); border-right: 1px solid oklch(0.9 0.018 82 / 0.6); background-color: var(--color-primary-softer); }
            .prose table:not(:has(thead)) tbody tr:first-child td:last-child, .prose table:not(:has(thead)) tbody tr:first-child th:last-child { border-right: none; }
            .prose td { padding: 0.9375rem 1.25rem; border-bottom: 1px solid var(--color-border); border-right: 1px solid oklch(0.9 0.018 82 / 0.6); vertical-align: top; color: var(--color-muted-foreground); font-size: 0.9375rem; line-height: 1.6; }
            .prose td:last-child { border-right: none; }
            .prose tbody td:first-child, .prose tbody th:first-child { font-weight: 700; color: var(--color-foreground); background-color: oklch(0.988 0.006 220 / 0.5); }
            .prose tbody tr:nth-child(even) td { background-color: var(--color-surface); }
            .prose tbody tr:nth-child(even) td:first-child { background-color: oklch(0.975 0.012 220 / 0.7); }
            .prose tbody tr:hover td { background-color: var(--color-primary-softer); transition: background-color 0.15s ease; }
            .prose tbody tr:hover td:first-child { background-color: oklch(0.95 0.022 220); }
            .prose tbody tr:last-child td, .prose tbody tr:last-child th { border-bottom: none; }
        ";
        wp_add_inline_style('modmy-style', $custom_css);
    } else {
        // Fallback to style.css if Tailwind hasn't run yet
        wp_enqueue_style('modmy-style-fallback', get_stylesheet_uri(), array(), MODMY_THEME_VERSION);
    }

    // 3. Main JavaScript
    wp_enqueue_script(
        'modmy-main-js',
        MODMY_THEME_URI . '/assets/js/main.js',
        array('jquery'),
        file_exists(MODMY_THEME_DIR . '/assets/js/main.js') ? filemtime(MODMY_THEME_DIR . '/assets/js/main.js') : MODMY_THEME_VERSION,
        true
    );
}
add_action('wp_enqueue_scripts', 'modmy_enqueue_scripts');
