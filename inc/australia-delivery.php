<?php
/**
 * Keep city fields available immediately and provide automated idempotent migration
 * for Australia Delivery cities across local, staging (InstaWP), and production environments.
 */
defined('ABSPATH') || exit;

add_action('acf/init', static function () {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }
    // Register the version-controlled definitions after ACF loads database groups.
    foreach (['group_city_fields', 'group_page_modules'] as $key) {
        $path = get_theme_file_path("/acf-json/{$key}.json");
        if (file_exists($path)) {
            $group = json_decode(file_get_contents($path), true);
            if (is_array($group) && !empty($group['key'])) {
                acf_add_local_field_group($group);
            }
        }
    }
});

/**
 * Automatically synchronize Australia Delivery cities on environments like InstaWP.
 * Replaces legacy Perth suburban posts with the 8 requested metropolitan delivery hubs.
 */
function waklert_auto_sync_delivery_cities() {
    $target_version = '20261019_v2';
    $current_version = get_option('waklert_delivery_cities_migration_ver');
    $force = isset($_GET['sync_cities_now']) && $_GET['sync_cities_now'] === '1';

    if ($current_version === $target_version && !$force) {
        return;
    }

    $seed_file = get_theme_file_path('/inc/data/delivery-cities-seed.json');
    if (!file_exists($seed_file)) {
        return;
    }

    $cities_data = json_decode(file_get_contents($seed_file), true);
    if (!is_array($cities_data) || empty($cities_data)) {
        return;
    }

    $target_slugs = [
        'sydney',
        'melbourne',
        'adelaide',
        'darwin',
        'brisbane',
        'gold-coast',
        'hobart',
        'canberra'
    ];

    // 1. Remove outdated / non-target city posts (e.g. legacy Perth suburbs)
    $existing_cities = get_posts([
        'post_type'   => 'city',
        'numberposts' => -1,
        'post_status' => 'any',
    ]);

    if (!empty($existing_cities)) {
        foreach ($existing_cities as $ec) {
            if (!in_array($ec->post_name, $target_slugs, true)) {
                wp_delete_post($ec->ID, true);
            }
        }
    }

    // 2. Discover available WooCommerce products dynamically
    $available_product_ids = [];
    $candidate_slugs = ['waklert-150mg', 'waklert-150mg-2', 'artvigil-150mg', 'armod-150mg', 'armodacharge-150mg', 'armod-50mg', 'waklert-50mg'];
    foreach ($candidate_slugs as $cslug) {
        $p = get_page_by_path($cslug, OBJECT, 'product');
        if ($p && $p->post_status === 'publish') {
            $available_product_ids[] = (int) $p->ID;
        }
    }
    if (empty($available_product_ids)) {
        $fallback_prods = get_posts([
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => 4,
            'fields'         => 'ids',
        ]);
        if (!empty($fallback_prods)) {
            $available_product_ids = array_map('intval', $fallback_prods);
        }
    }

    // 3. Upsert the 8 cities with full meta & ACF values
    $seeded_city_posts = [];
    foreach ($cities_data as $city) {
        $slug = $city['name'];
        if (!in_array($slug, $target_slugs, true)) {
            continue;
        }

        $existing = get_page_by_path($slug, OBJECT, 'city');
        $post_data = [
            'post_title'   => $city['title'],
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'city',
            'menu_order'   => (int) ($city['menu_order'] ?? 0),
        ];

        if ($existing) {
            $post_data['ID'] = $existing->ID;
            $post_id = wp_update_post($post_data);
        } else {
            $post_id = wp_insert_post($post_data);
        }

        if (is_wp_error($post_id) || !$post_id) {
            continue;
        }

        $seeded_city_posts[$slug] = $post_id;

        // Prepare ACF payload
        $acf_data = $city['acf'] ?? [];
        if (!empty($available_product_ids)) {
            $acf_data['selected_products'] = array_slice($available_product_ids, 0, 4);
        }

        if (function_exists('update_field')) {
            foreach ($acf_data as $key => $val) {
                update_field($key, $val, $post_id);
            }
        }

        // Store direct postmeta entries as backup
        if (!empty($city['meta']) && is_array($city['meta'])) {
            foreach ($city['meta'] as $meta_key => $meta_vals) {
                if (empty($meta_vals)) continue;
                $val = maybe_unserialize($meta_vals[0]);
                if ($meta_key === 'selected_products' && !empty($available_product_ids)) {
                    $val = array_slice($available_product_ids, 0, 4);
                }
                update_post_meta($post_id, $meta_key, $val);
            }
        }
    }

    // 4. Update Footer Delivery Cities Nav Menu
    $menu_obj = wp_get_nav_menu_object('footer-delivery-cities');
    if (!$menu_obj) {
        $menu_obj = wp_get_nav_menu_object('Footer Delivery Cities');
    }
    if (!$menu_obj) {
        $locations = get_nav_menu_locations();
        if (!empty($locations['footer_cities'])) {
            $menu_obj = wp_get_nav_menu_object($locations['footer_cities']);
        }
    }

    if ($menu_obj) {
        $menu_id = $menu_obj->term_id;
        $old_items = wp_get_nav_menu_items($menu_id);
        if ($old_items) {
            foreach ($old_items as $oi) {
                wp_delete_post($oi->ID, true);
            }
        }

        $menu_order = 1;
        foreach ($target_slugs as $tslug) {
            if (isset($seeded_city_posts[$tslug])) {
                $c_post_id = $seeded_city_posts[$tslug];
                $label = function_exists('get_field') ? get_field('city_name', $c_post_id) : '';
                if (empty($label)) {
                    $label = ucwords(str_replace('-', ' ', $tslug));
                }
                wp_update_nav_menu_item($menu_id, 0, [
                    'menu-item-title'     => $label,
                    'menu-item-object'    => 'city',
                    'menu-item-object-id' => $c_post_id,
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                    'menu-item-position'  => $menu_order++,
                ]);
            }
        }
    }

    // 5. Update front page city_section module if applicable
    $front_id = (int) get_option('page_on_front');
    if ($front_id && function_exists('get_field') && function_exists('update_field')) {
        foreach (['modules', 'page_modules'] as $module_field_key) {
            $modules = get_field($module_field_key, $front_id);
            if (is_array($modules)) {
                $updated = false;
                foreach ($modules as &$mod) {
                    if (($mod['acf_fc_layout'] ?? '') === 'city_section') {
                        $mod['cities_list'] = [
                            ['city_name' => 'Sydney', 'has_checkmark' => true],
                            ['city_name' => 'Melbourne', 'has_checkmark' => true],
                            ['city_name' => 'Adelaide', 'has_checkmark' => true],
                            ['city_name' => 'Darwin', 'has_checkmark' => true],
                            ['city_name' => 'Brisbane', 'has_checkmark' => true],
                            ['city_name' => 'Gold Coast', 'has_checkmark' => true],
                            ['city_name' => 'Hobart', 'has_checkmark' => true],
                            ['city_name' => 'Canberra', 'has_checkmark' => true],
                        ];
                        $mod['quick_cities'] = "Sydney ✓\nMelbourne ✓\nAdelaide ✓\nDarwin ✓\nBrisbane ✓\nGold Coast ✓\nHobart ✓\nCanberra ✓";
                        $updated = true;
                    }
                }
                unset($mod);
                if ($updated) {
                    update_field($module_field_key, $modules, $front_id);
                }
            }
        }
    }

    // 6. Flush rewrites & mark migration complete
    flush_rewrite_rules(false);
    update_option('waklert_delivery_cities_migration_ver', $target_version);
}
add_action('init', 'waklert_auto_sync_delivery_cities', 20);
