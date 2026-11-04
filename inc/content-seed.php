<?php
/**
 * Content seed: puts the default text of the page modules into WP Admin as real field values
 * (Pages -> Modules -> ...), so what visitors read is what the client can edit.
 *
 * Runs once per environment. Bump WAKLERT_CONTENT_SEED_VERSION whenever the defaults change.
 * Only empty fields are filled; anything already written in the admin is never touched.
 * Frontend modules respect saved empty values instead of substituting defaults.
 */

const WAKLERT_CONTENT_SEED_VERSION = '20261103_content_seed_v11';

/**
 * Default text per module layout.
 * 'fields'    => field name => [ACF field key, value]
 * 'repeaters' => repeater name => key, 'check' (sub field that must be filled for the repeater to count as written),
 *                'subs' (sub field name => key), 'rows', optional 'unless' (other fields that already cover the content)
 */
function waklert_seed_defaults(): array {
    static $data = null;
    if ($data === null) {
        $data = json_decode((string) file_get_contents(MODMY_THEME_DIR . '/inc/data/content-defaults.json'), true) ?: [];
    }
    return $data;
}

function waklert_module_defaults() {
    return waklert_seed_defaults()['modules'] ?? [];
}

/** Default text of the Theme Settings fields: option name => [ACF field key, value]. */
function waklert_option_defaults() {
    return waklert_seed_defaults()['options'] ?? [];
}

/** Bank transfer details (Theme Settings -> Checkout & Emails) used by the thank-you page, the BACS block and WooCommerce. */
function waklert_bank_details() {
    return [
        'bank'    => waklert_option_text('bank_transfer_bank_name'),
        'name'    => waklert_option_text('bank_transfer_account_name'),
        'bsb'     => waklert_option_text('bank_transfer_bsb'),
        'number'  => waklert_option_text('bank_transfer_account_number'),
        'country' => waklert_option_text('bank_transfer_country'),
    ];
}

/** Theme Settings text, with the default as a safety net when the admin left it empty. */
function waklert_option_text($name) {
    $saved = get_option('options_' . $name, null);
    if ($saved !== null) { return is_scalar($saved) ? (string) $saved : ''; }
    $value = function_exists('get_field') ? trim((string) get_field($name, 'option')) : '';
    return $value !== '' ? $value : (waklert_option_defaults()[$name][1] ?? waklert_acf_option_default($name));
}

/** Read the canonical field default from the existing Theme Settings JSON. */
function waklert_acf_option_default($name) {
    static $defaults = null;
    if ($defaults === null) {
        $defaults = [];
        $group = json_decode((string) file_get_contents(MODMY_THEME_DIR . '/acf-json/group_theme_settings.json'), true);
        foreach ($group['fields'] ?? [] as $field) {
            if (!empty($field['name']) && array_key_exists('default_value', $field)) {
                $defaults[$field['name']] = $field['default_value'];
            }
        }
    }
    return $defaults[$name] ?? '';
}

/** Install existing scalar ACF defaults once, without resetting later edits or clears. */
add_action('admin_init', function() {
    if (!current_user_can('manage_options')
        || (defined('WAKLERT_SKIP_CONTENT_SEED') && WAKLERT_SKIP_CONTENT_SEED)) { return; }
    $path = MODMY_THEME_DIR . '/acf-json/group_theme_settings.json';
    $version = hash_file('sha256', $path);
    if (get_option('waklert_acf_defaults_version') === $version) { return; }
    $markers = (array) get_option('waklert_acf_defaults_seeded', []);
    $group = json_decode((string) file_get_contents($path), true);
    foreach ($group['fields'] ?? [] as $field) {
        $name = $field['name'] ?? '';
        $default = $field['default_value'] ?? null;
        if (!$name || isset($markers[$name]) || !is_scalar($default) || $default === '') { continue; }
        $current = get_option('options_' . $name, null);
        if ($current === null || $current === '') {
            update_option('options_' . $name, $default);
            update_option('_options_' . $name, $field['key']);
        }
        $markers[$name] = true;
    }
    update_option('waklert_acf_defaults_seeded', $markers, false);
    update_option('waklert_acf_defaults_version', $version, false);
}, 98);

/** Default value of one field, used by the templates as a safety net. */
function waklert_module_default($layout, $name) {
    return waklert_module_defaults()[$layout]['fields'][$name][1] ?? '';
}

/** Default rows of one repeater, as sub field name => value. */
function waklert_module_default_rows($layout, $name) {
    return waklert_module_defaults()[$layout]['repeaters'][$name]['rows'] ?? [];
}

/** Relative links typed in the admin (/shop/) become full links on this site. */
function waklert_resolve_link($url) {
    $url = trim((string) $url);
    if ($url === '' || preg_match('#^(https?:|mailto:|tel:|sms:|\#)#i', $url)) {
        return $url;
    }
    return home_url('/' . ltrim($url, '/'));
}

/** Description under a trust badge when the admin left it empty. */
function waklert_default_trust_badge_desc($label, $idx = 0) {
    $lower = strtolower(trim((string) $label));
    $rows  = waklert_module_default_rows('trust_strip', 'badges');

    if (str_contains($lower, 'focused') || str_contains($lower, 'category') || str_contains($lower, 'range')) {
        return waklert_seed_defaults()['trust_descriptions']['036c5026f5'];
    }
    if (str_contains($lower, 'checkout') && str_contains($lower, 'delivery')) {
        return waklert_seed_defaults()['trust_descriptions']['d3e5857ced'];
    }
    if (str_contains($lower, 'listing') || str_contains($lower, 'detail')) {
        return waklert_seed_defaults()['trust_descriptions']['3aa6f3112c'];
    }
    if (str_contains($lower, 'support') || str_contains($lower, 'question') || str_contains($lower, 'chat')) {
        return waklert_seed_defaults()['trust_descriptions']['dd46c3441b'];
    }
    if (str_contains($lower, 'sealed')) {
        return waklert_seed_defaults()['trust_descriptions']['f00d47a832'];
    }
    if (str_contains($lower, 'discreet')) {
        return waklert_seed_defaults()['trust_descriptions']['e4abdc33bf'];
    }
    if (str_contains($lower, 'checkout') || str_contains($lower, 'payid') || str_contains($lower, 'secure')) {
        return waklert_seed_defaults()['trust_descriptions']['b619872424'];
    }
    if (str_contains($lower, 'australia') || str_contains($lower, 'delivery') || str_contains($lower, 'shipping')) {
        return waklert_seed_defaults()['trust_descriptions']['9352490d6d'];
    }
    return $rows[$idx % max(1, count($rows))]['desc'] ?? '';
}

/** True when any row of this FAQs module already has a question typed in. */
function waklert_faq_module_has_content($post_id, $idx) {
    $count = (int) get_post_meta($post_id, "modules_{$idx}_faq_items", true);
    for ($r = 0; $r < $count; $r++) {
        if (trim((string) get_post_meta($post_id, "modules_{$idx}_faq_items_{$r}_question", true)) !== '') {
            return true;
        }
    }
    return false;
}

/** Removes every saved row (and its field references) of one repeater inside a module. */
function waklert_clear_repeater_rows($post_id, $idx, $name) {
    global $wpdb;

    $like = $wpdb->esc_like("modules_{$idx}_{$name}_") . '%';
    $wpdb->query($wpdb->prepare(
        "DELETE FROM {$wpdb->postmeta} WHERE post_id = %d AND (meta_key LIKE %s OR meta_key LIKE %s)",
        $post_id,
        $like,
        '\_' . $like
    ));
}

/** Protect existing repeater children even if their parent count is missing. */
function waklert_repeater_has_saved_rows($post_id, $idx, $name): bool {
    $prefix = "modules_{$idx}_{$name}_";
    foreach (array_keys(get_post_meta($post_id)) as $key) {
        if (str_starts_with($key, $prefix) || str_starts_with($key, '_' . $prefix)) { return true; }
    }
    return false;
}

/** Initialize FAQs only when no saved list or child fields exist. */
function waklert_seed_faq_module($post_id, $idx) {
    if (metadata_exists('post', $post_id, "modules_{$idx}_faq_items")
        || waklert_repeater_has_saved_rows($post_id, $idx, 'faq_items')) { return; }

    $items = waklert_default_faq_items();
    foreach ($items as $r => $row) {
        update_post_meta($post_id, "modules_{$idx}_faq_items_{$r}_question", $row['question']);
        update_post_meta($post_id, "_modules_{$idx}_faq_items_{$r}_question", 'field_faq_q_en');
        update_post_meta($post_id, "modules_{$idx}_faq_items_{$r}_answer", '<p>' . $row['answer'] . '</p>');
        update_post_meta($post_id, "_modules_{$idx}_faq_items_{$r}_answer", 'field_faq_a_en');
    }
    update_post_meta($post_id, "modules_{$idx}_faq_items", count($items));
    update_post_meta($post_id, "_modules_{$idx}_faq_items", 'field_faq_items');
}

function waklert_module_meta_filled($post_id, $meta_key) {
    return trim((string) get_post_meta($post_id, $meta_key, true)) !== '';
}

function waklert_repeater_has_content($post_id, $idx, $name, $check) {
    $count = (int) get_post_meta($post_id, "modules_{$idx}_{$name}", true);
    for ($r = 0; $r < $count; $r++) {
        if (waklert_module_meta_filled($post_id, "modules_{$idx}_{$name}_{$r}_{$check}")) {
            return true;
        }
    }
    return false;
}

function waklert_seed_repeater($post_id, $idx, $name, $repeater) {
    if (metadata_exists('post', $post_id, "modules_{$idx}_{$name}")
        || waklert_repeater_has_saved_rows($post_id, $idx, $name)) { return; }
    foreach ($repeater['unless'] ?? [] as $other) {
        if (waklert_module_meta_filled($post_id, "modules_{$idx}_{$other}")) {
            return;
        }
    }
    if (waklert_repeater_has_content($post_id, $idx, $name, $repeater['check'])) {
        return;
    }

    foreach ($repeater['rows'] as $r => $row) {
        foreach ($repeater['subs'] as $sub => $sub_key) {
            update_post_meta($post_id, "modules_{$idx}_{$name}_{$r}_{$sub}", $row[$sub] ?? '');
            update_post_meta($post_id, "_modules_{$idx}_{$name}_{$r}_{$sub}", $sub_key);
        }
    }
    update_post_meta($post_id, "modules_{$idx}_{$name}", count($repeater['rows']));
    update_post_meta($post_id, "_modules_{$idx}_{$name}", $repeater['key']);
}

/** Trust badges written without a description show a generated one on the site; make that visible in the admin. */
function waklert_seed_trust_badge_descriptions($post_id, $idx) {
    $count = (int) get_post_meta($post_id, "modules_{$idx}_badges", true);
    for ($r = 0; $r < $count; $r++) {
        $label = (string) get_post_meta($post_id, "modules_{$idx}_badges_{$r}_label", true);
        if ($label === '' || metadata_exists('post', $post_id, "modules_{$idx}_badges_{$r}_desc")) {
            continue;
        }
        update_post_meta($post_id, "modules_{$idx}_badges_{$r}_desc", waklert_default_trust_badge_desc($label, $r));
        update_post_meta($post_id, "_modules_{$idx}_badges_{$r}_desc", 'field_ts_desc_en');
    }
}

/** Fills the empty fields and repeaters of one module with its defaults. */
function waklert_seed_module($post_id, $idx, $layout) {
    $defaults = waklert_module_defaults()[$layout] ?? null;
    if (!$defaults) {
        return;
    }
    // The trust cards only exist on the Shop page hero
    if ($layout === 'page_hero' && (!function_exists('wc_get_page_id') || (int) $post_id !== (int) wc_get_page_id('shop'))) {
        return;
    }

    foreach ($defaults['fields'] ?? [] as $name => [$field_key, $value]) {
        if (metadata_exists('post', $post_id, "modules_{$idx}_{$name}")) {
            continue;
        }
        update_post_meta($post_id, "modules_{$idx}_{$name}", $value);
        update_post_meta($post_id, "_modules_{$idx}_{$name}", $field_key);
    }
    foreach ($defaults['repeaters'] ?? [] as $name => $repeater) {
        waklert_seed_repeater($post_id, $idx, $name, $repeater);
    }
    if ($layout === 'trust_strip') {
        waklert_seed_trust_badge_descriptions($post_id, $idx);
    }
}

add_action('init', function() {
    if (defined('WAKLERT_SKIP_CONTENT_SEED') && WAKLERT_SKIP_CONTENT_SEED) { return; }
    if (get_option('waklert_content_seed_version') === WAKLERT_CONTENT_SEED_VERSION) {
        return;
    }

    $post_ids = get_posts([
        'post_type'      => 'any',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_key'       => 'modules',
    ]);
    foreach ($post_ids as $post_id) {
        $layouts = get_post_meta($post_id, 'modules', true);
        if (!is_array($layouts)) {
            continue;
        }
        foreach ($layouts as $idx => $layout_name) {
            if ($layout_name === 'faqs' && !metadata_exists('post', $post_id, "modules_{$idx}_faq_items")) {
                waklert_seed_faq_module($post_id, $idx);
            }
            waklert_seed_module($post_id, $idx, $layout_name);
        }
    }

    foreach (waklert_option_defaults() as $name => [$field_key, $value]) {
        if (trim((string) get_option('options_' . $name, '')) === '') {
            update_option('options_' . $name, $value);
            update_option('_options_' . $name, $field_key);
        }
    }

    update_option('waklert_content_seed_version', WAKLERT_CONTENT_SEED_VERSION);
    do_action('litespeed_purge_all');
}, 99);
