<?php
/**
 * Enqueue scripts and styles
 */

function modmy_enqueue_scripts() {
    // 1. Google Fonts (Manrope, Inter & Caveat for cursive Best Seller notes)
    wp_enqueue_style(
        'modmy-fonts',
        'https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&family=Caveat:wght@600;700&display=swap',
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
            .prose table { width: 100%; max-width: 100%; table-layout: auto; text-align: left; margin: 2rem 0; border-collapse: separate; border-spacing: 0; border: 1px solid var(--color-border); border-radius: var(--radius-xl, 1rem); overflow: hidden; background-color: var(--color-card, #fff); box-shadow: 0 4px 20px -4px oklch(0.208 0.042 265.755 / 0.08); font-size: 0.9375rem; line-height: 1.55; }
            .prose .table-wrapper, .prose figure.wp-block-table { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; margin: 2rem 0; border: 1px solid var(--color-border); border-radius: var(--radius-xl, 1rem); background-color: var(--color-card, #fff); box-shadow: 0 4px 20px -4px oklch(0.208 0.042 265.755 / 0.08); }
            .prose .table-wrapper table, .prose figure.wp-block-table table { margin: 0; border: none; border-radius: 0; box-shadow: none; min-width: 100%; }
            .prose thead { border-bottom: 2px solid #082c42; background-color: #0c4161; }
            .prose th, .prose thead th { font-family: var(--font-heading); font-weight: 800; font-size: 0.875rem; letter-spacing: 0.02em; color: #ffffff !important; padding: 1rem 1.25rem; vertical-align: middle; border-bottom: 2px solid #082c42; border-right: 1px solid rgba(255, 255, 255, 0.15); background-color: #0c4161; text-align: left; }
            .prose th:last-child, .prose thead th:last-child { border-right: none; }
            .prose table:not(:has(thead)) tbody tr:first-child td, .prose table:not(:has(thead)) tbody tr:first-child th { font-family: var(--font-heading); font-weight: 800; font-size: 0.875rem; letter-spacing: 0.02em; color: #ffffff !important; padding: 1rem 1.25rem; vertical-align: middle; border-bottom: 2px solid #082c42; border-right: 1px solid rgba(255, 255, 255, 0.15); background-color: #0c4161; }
            .prose table:not(:has(thead)) tbody tr:first-child td:last-child, .prose table:not(:has(thead)) tbody tr:first-child th:last-child { border-right: none; }
            .prose td { padding: 0.9375rem 1.25rem; border-bottom: 1px solid var(--color-border); border-right: 1px solid oklch(0.9 0.018 82 / 0.6); vertical-align: top; color: var(--color-foreground); font-size: 0.9375rem; line-height: 1.6; background-color: var(--color-card, #ffffff); }
            .prose td:last-child { border-right: none; }
            .prose tbody td:first-child, .prose tbody th:first-child { font-weight: 700; color: var(--color-foreground); background-color: oklch(0.982 0.01 84 / 0.7); }
            .prose tbody tr:nth-child(even) td { background-color: oklch(0.988 0.006 84 / 0.5); }
            .prose tbody tr:nth-child(even) td:first-child { background-color: oklch(0.972 0.014 84 / 0.8); }
            .prose tbody tr:hover td { background-color: oklch(0.965 0.016 84 / 0.6); transition: background-color 0.15s ease; }
            .prose tbody tr:hover td:first-child { background-color: oklch(0.955 0.02 84); }
            .prose th.waklert-highlight-header, .prose thead th.waklert-highlight-header { background: #082c42 !important; color: #ffffff !important; border-bottom: 2px solid #051b29 !important; }
            .prose td.waklert-highlight-cell { background-color: oklch(0.98 0.012 84 / 0.6); font-weight: 600; color: var(--color-foreground); }
            .prose tbody tr:nth-child(even) td.waklert-highlight-cell { background-color: oklch(0.97 0.016 84 / 0.7); }
            .prose tbody tr:hover td.waklert-highlight-cell { background-color: oklch(0.955 0.022 84); }
            .prose tbody tr:last-child td, .prose tbody tr:last-child th { border-bottom: none; }
            details .prose a, .faq-answer a, details summary + div a { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-underline-offset: 3px; text-decoration-thickness: 1.5px; }
            details .prose a:hover, .faq-answer a:hover, details summary + div a:hover { color: var(--color-primary-dark); text-decoration-thickness: 2px; }
            details .prose p { margin-top: 0.5rem; margin-bottom: 0.5rem; }
            details .prose > :first-child { margin-top: 0; }
            details .prose > :last-child { margin-bottom: 0; }
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
