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
 * Uses the saved Theme Settings WhatsApp number when no explicit value is supplied.
 */
function waklert_format_whatsapp_url($phone_or_url = null) {
    $val = trim((string) $phone_or_url);
    if ($val === '' || stripos($val, 'tel:') === 0) {
        $option_number = function_exists('get_field') ? get_field('whatsapp_number', 'option') : null;
        $val = trim((string) $option_number);
    }

    // Direct URL provided
    if (preg_match('#^https?://#i', $val)) {
        // A leading 0 does not work on WhatsApp, so use the country code 61 instead
        return preg_replace('#(wa\.me/)\+?0+#i', '${1}61', $val);
    }

    // Strip all non-digits
    $clean = preg_replace('/\D+/', '', $val);

    // If starts with Australian local mobile 04..., convert leading 0 to 61
    if (str_starts_with($clean, '0')) {
        $clean = '61' . substr($clean, 1);
    }

    // No saved contact means no link.
    if ($clean === '') { return ''; }

    return 'https://wa.me/' . $clean;
}

/**
 * Build a tel:/sms: link in international format (+61...) from a local Australian number.
 * A leading 0 is replaced by the country code 61 so the link works from anywhere.
 */
function waklert_format_tel_url($value, $scheme = 'tel') {
    $clean = preg_replace('/\D+/', '', (string) preg_replace('/^(tel|sms):/i', '', trim((string) $value)));
    if ($clean === '') {
        return '';
    }
    if (str_starts_with($clean, '0')) {
        $clean = '61' . substr($clean, 1);
    } elseif (strlen($clean) === 9 && str_starts_with($clean, '4')) {
        $clean = '61' . $clean;
    }
    return $scheme . ':+' . $clean;
}

/**
 * Configure ACF JSON save and load paths for automatic sync.
 * ACF only writes (or deletes) the acf-json files on the local site. On live they come from Git, so
 * "Update from Remote" in cPanel always finds a clean folder and can pull.
 */
function waklert_is_local_site() {
    $host = (string) wp_parse_url(home_url(), PHP_URL_HOST);
    return (bool) preg_match('/\.(test|local|localhost)$/i', $host);
}

add_filter('acf/settings/save_json', function($path) {
    return waklert_is_local_site() ? get_stylesheet_directory() . '/acf-json' : '';
});

add_filter('acf/settings/load_json', function($paths) {
    $theme_json_dir = get_stylesheet_directory() . '/acf-json';
    if (!in_array($theme_json_dir, $paths)) {
        $paths[] = $theme_json_dir;
    }
    return $paths;
});

/**
 * Clear the page cache (LiteSpeed) whenever Theme Settings or a menu is saved,
 * so footer/header edits show on the front end straight away.
 */
add_action('acf/save_post', function($post_id) {
    if ($post_id === 'options') {
        do_action('litespeed_purge_all');
    }
}, 20);
add_action('wp_update_nav_menu', function() {
    do_action('litespeed_purge_all');
});

/**
 * One-time import of the reorganised Theme Settings tabs (acf-json/group_theme_settings.json)
 * into the database field group. Field names are unchanged, so saved values are kept.
 */
add_action('acf/init', function() {
    $target_ver = '20261103_theme_settings_tabs_v13';
    if (get_option('waklert_theme_settings_tabs_ver') === $target_ver || !function_exists('acf_import_field_group')) {
        return;
    }

    $acf_posts = get_posts([
        'post_type'      => 'acf-field-group',
        'posts_per_page' => -1,
        'post_status'    => 'any',
    ]);

    foreach (['group_theme_settings', 'group_page_modules'] as $group_key) {
        $json_path = get_stylesheet_directory() . '/acf-json/' . $group_key . '.json';
        $json_data = file_exists($json_path) ? json_decode(file_get_contents($json_path), true) : null;
        if (!is_array($json_data) || empty($json_data['key'])) {
            continue;
        }
        $first_matched = false;
        foreach ($acf_posts as $p) {
            if ($p->post_name !== $group_key && $p->post_excerpt !== $group_key) {
                continue;
            }
            if (!$first_matched) {
                $first_matched = true;
                $json_data['ID'] = $p->ID;
                acf_import_field_group($json_data);
            } else {
                wp_delete_post($p->ID, true);
            }
        }
    }

    // Product Page Presentation now lives inside Theme Settings (Product Pages tab)
    foreach ($acf_posts as $p) {
        if ($p->post_name === 'group_waklert_product_presentation_settings' || $p->post_excerpt === 'group_waklert_product_presentation_settings') {
            wp_delete_post($p->ID, true);
        }
    }

    // Fields removed from the JSON are not removed from the database copy by the import above
    global $wpdb;
    foreach (['field_hero_stats'] as $removed_key) {
        $removed_ids = $wpdb->get_col($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'acf-field' AND post_name = %s", $removed_key));
        foreach ($removed_ids as $removed_id) {
            acf_delete_field((int) $removed_id);
        }
    }

    update_option('waklert_theme_settings_tabs_ver', $target_ver);
}, 21);

/**
 * Default FAQ questions, shown by the FAQs module when no items have been entered.
 */
function waklert_default_faq_items() {
    return waklert_seed_defaults()['faqs'] ?? [];
}

/* The one-time seed that copies these defaults into the admin FAQ lists lives in inc/content-seed.php. */

/**
 * Synchronize Header & Top Bar Theme Settings across local, staging (InstaWP), and live environments:
 * - Imports acf-json/group_theme_settings.json into any existing DB field group so WP Admin labels update immediately without deleting the JSON file
 * - Seeds live Header & Top Bar values once so WP Admin reflects the live configuration out of the box
 */


/**
 * Synchronize Page Modules ACF schema & seed semantically aligned icon presets + descriptions
 * across all pages (Homepage, About Us, Buyer's Guide, Track Order) so WP Admin shows the exact
 * matching colorful icon preset and description for every card out of the box.
 */


/** Page-specific editor visibility; these helpers do not alter saved values. */
function waklert_editing_shop_page() {
    $post_id = isset($_GET['post']) ? (int) $_GET['post'] : (int) get_the_ID();
    return $post_id > 0 && function_exists('wc_get_page_id') && $post_id === (int) wc_get_page_id('shop');
}
add_filter('acf/prepare_field/key=field_page_hero_trust_cards', function($field) {
    return is_admin() && !waklert_editing_shop_page() ? false : $field;
});
add_filter('acf/prepare_field/key=field_page_hero_bullets', function($field) {
    return is_admin() && waklert_editing_shop_page() ? false : $field;
});
