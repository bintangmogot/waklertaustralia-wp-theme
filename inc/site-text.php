<?php
/**
 * Site Text: small labels and messages that used to be hardcoded in templates.
 * Edit in WP Admin -> Theme Settings -> Site Text. The defaults below are used only if a field is empty.
 */

/** Default content lives in inc/data/default-content.json (no text hardcoded in PHP). */
function waklert_default_content($section) {
    static $data = null;
    if ($data === null) {
        $path = get_theme_file_path('/inc/data/default-content.json');
        $data = file_exists($path) ? (json_decode(file_get_contents($path), true) ?: []) : [];
    }
    return $data[$section] ?? [];
}

function waklert_text_defaults() {
    return waklert_default_content('site_text');
}

function waklert_text($name) {
    $defaults = waklert_text_defaults();
    $value = function_exists('get_field') ? get_field($name, 'option') : '';
    $value = is_string($value) ? trim($value) : '';
    return $value !== '' ? $value : ($defaults[$name] ?? '');
}

function waklert_text_url($name) {
    $value = waklert_text($name);
    return preg_match('#^https?://#i', $value) ? $value : home_url('/' . ltrim($value, '/'));
}

/** Copy the defaults into the saved options once, so every Site Text field is already filled in WP Admin. */
add_action('acf/init', function() {
    $target_ver = '20261102_site_text_v1';
    if (get_option('waklert_site_text_seed_ver') === $target_ver) {
        return;
    }
    foreach (waklert_text_defaults() as $name => $default) {
        if (get_option('options_' . $name, null) === null) {
            update_option('options_' . $name, $default);
            update_option('_options_' . $name, 'field_st_' . $name);
        }
    }
    update_option('waklert_site_text_seed_ver', $target_ver);
}, 35);
