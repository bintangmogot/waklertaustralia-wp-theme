<?php
/** Keep city fields available immediately, including on the named page template. */
defined('ABSPATH') || exit;
add_action('acf/init', static function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }
    // Register the version-controlled definitions after ACF loads database groups.
    foreach (['group_city_fields', 'group_page_modules'] as $key) {
        $path = get_theme_file_path("/acf-json/{$key}.json");
        $group = json_decode(file_get_contents($path), true);
        if (is_array($group) && !empty($group['key'])) {
            acf_add_local_field_group($group);
        }
    }
});
