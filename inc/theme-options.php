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
    if ($val === '' || stripos($val, 'tel:') === 0) {
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

/**
 * Synchronize Header & Top Bar Theme Settings across local, staging (InstaWP), and live environments:
 * - Removes duplicate/stale DB field group overrides for group_theme_settings so ACF JSON is authoritative
 * - Seeds live Header & Top Bar values once so WP Admin reflects the live configuration out of the box
 */
add_action('init', function() {
    $target_ver = '20261021_header_settings_v1';
    if (get_option('waklert_header_settings_sync_ver') === $target_ver) {
        return;
    }

    // 1. Remove any stale DB field group posts for group_theme_settings so acf-json/group_theme_settings.json takes effect immediately
    $acf_posts = get_posts([
        'post_type'      => 'acf-field-group',
        'posts_per_page' => -1,
        'post_status'    => 'any',
    ]);
    if (!empty($acf_posts)) {
        foreach ($acf_posts as $p) {
            if ($p->post_name === 'group_theme_settings' || $p->post_excerpt === 'group_theme_settings' || $p->post_excerpt === 'theme-settings') {
                if (function_exists('acf_delete_field_group')) {
                    acf_delete_field_group($p->ID);
                } else {
                    wp_delete_post($p->ID, true);
                }
            }
        }
    }

    // 2. Sync Header & Top Bar options to match live data if still on legacy defaults
    $topbar_left = get_option('options_topbar_left');
    if ($topbar_left === false || $topbar_left === '' || strpos((string) $topbar_left, '7-10 Day Delivery') !== false) {
        update_option('options_topbar_left', 'Express Domestic Shipping');
        update_option('_options_topbar_left', 'field_topbar_left');
    }

    $topbar_center = get_option('options_topbar_center');
    if ($topbar_center === false || $topbar_center === '' || strpos((string) $topbar_center, 'Free Shipping on Orders') !== false) {
        update_option('options_topbar_center', 'Local Support 24/7');
        update_option('_options_topbar_center', 'field_topbar_center');
    }

    $phone_num = get_option('options_whatsapp_number');
    if ($phone_num === false || $phone_num === '' || strpos((string) $phone_num, '+61') !== false) {
        update_option('options_whatsapp_number', '0488 841 833');
        update_option('_options_whatsapp_number', 'field_whatsapp_number');
    }

    $btn_text = get_option('options_whatsapp_button_text');
    if ($btn_text === false || $btn_text === '' || stripos((string) $btn_text, 'whatsapp') !== false) {
        update_option('options_whatsapp_button_text', '0488 841 833');
        update_option('_options_whatsapp_button_text', 'field_whatsapp_button_text');
    }

    $btn_url = get_option('options_whatsapp_button_url');
    if ($btn_url === false || $btn_url === '' || stripos((string) $btn_url, 'wa.me') !== false) {
        update_option('options_whatsapp_button_url', 'tel:0488841833');
        update_option('_options_whatsapp_button_url', 'field_whatsapp_button_url');
    }

    // Clean up any accidental options_field_* entries
    delete_option('options_field_topbar_left');
    delete_option('_options_field_topbar_left');
    delete_option('options_field_topbar_center');
    delete_option('_options_field_topbar_center');
    delete_option('options_field_whatsapp_button_text');
    delete_option('_options_field_whatsapp_button_text');
    delete_option('options_field_whatsapp_button_url');
    delete_option('_options_field_whatsapp_button_url');

    update_option('waklert_header_settings_sync_ver', $target_ver);
}, 20);
