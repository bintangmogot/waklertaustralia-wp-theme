<?php
/**
 * ACF Theme Options Page
 */

if (function_exists('acf_add_options_page')) {
    add_action('acf/init', function() {
        acf_add_options_page(array(
            'page_title'    => 'Theme General Settings',
            'menu_title'    => 'Theme Settings',
            'menu_slug'     => 'theme-general-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false,
            'icon_url'      => 'dashicons-admin-generic',
            'position'      => 30
        ));
    });
}

/**
 * Format a phone number or URL into a clean WhatsApp direct chat URL.
 * Defaults to the Theme Settings WhatsApp number or +61 488 841 833.
 */
function waklert_format_whatsapp_url($phone_or_url = null) {
    $val = trim((string) $phone_or_url);
    if ($val === '') {
        $option_number = function_exists('get_field') ? get_field('whatsapp_number', 'option') : null;
        $val = !empty($option_number) ? trim((string) $option_number) : '+61 488 841 833';
    }

    // Direct URL provided
    if (preg_match('#^https?://#i', $val)) {
        // Replace legacy Malaysian number if present
        if (strpos($val, 'wa.me/60') !== false) {
            return 'https://wa.me/61488841833';
        }
        return $val;
    }

    // Strip all non-digits
    $clean = preg_replace('/\D+/', '', $val);

    // If starts with Australian local mobile 04..., convert leading 0 to 61
    if (str_starts_with($clean, '0')) {
        $clean = '61' . substr($clean, 1);
    }

    // If starts with Malaysian country code 60 or empty, use Australian fallback
    if ($clean === '' || str_starts_with($clean, '60')) {
        $clean = '61488841833';
    }

    return 'https://wa.me/' . $clean;
}

/**
 * Configure ACF JSON save and load paths for automatic sync
 */
add_filter('acf/settings/save_json', function($path) {
    return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function($paths) {
    $theme_json_dir = get_stylesheet_directory() . '/acf-json';
    if (!in_array($theme_json_dir, $paths)) {
        $paths[] = $theme_json_dir;
    }
    return $paths;
});


