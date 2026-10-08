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
        
        // Add missing prose table styles since Tailwind CLI stripped them
        $custom_css = "
            .prose table { width: 100%; table-layout: auto; text-align: left; margin-top: 2em; margin-bottom: 2em; border-collapse: collapse; }
            .prose thead { border-bottom: 2px solid var(--color-primary-light); background-color: var(--color-primary-softer); }
            .prose th { font-weight: 700; color: var(--color-foreground); padding: 0.75rem 1rem; vertical-align: bottom; }
            .prose td { padding: 0.75rem 1rem; border-bottom: 1px solid var(--color-border); vertical-align: top; color: var(--color-muted-foreground); }
            .prose tbody tr:last-child td { border-bottom: none; }
            .prose tbody tr:nth-child(even) { background-color: var(--color-surface); }
            .prose .table-wrapper, .prose figure.wp-block-table { overflow-x: auto; -webkit-overflow-scrolling: touch; border: 1px solid var(--color-border); border-radius: var(--radius-md); }
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
