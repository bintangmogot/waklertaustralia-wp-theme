<?php
/**
 * Registry-backed content for text, icons, and bundled image defaults.
 *
 * Content registries live in inc/data/template-content*.json. Their ACF field
 * groups are generated from the same registries and stored in acf-json.
 */

defined('ABSPATH') || exit;

function waklert_template_content_registry(): array {
    static $registry = null;
    if ($registry !== null) {
        return $registry;
    }

    $registry = [];
    $files = glob(MODMY_THEME_DIR . '/inc/data/template-content*.json') ?: [];
    sort($files, SORT_STRING);
    foreach ($files as $file) {
        $decoded = json_decode((string) file_get_contents($file), true);
        if (!is_array($decoded)) {
            continue;
        }
        foreach ($decoded as $key => $entry) {
            if (is_string($key) && preg_match('/^[a-z0-9_]+$/', $key) && is_array($entry)) {
                $registry[$key] = $entry;
            }
        }
    }

    return $registry;
}

/** Resolve the owning module even while its nested repeaters are active. */
function waklert_template_module_value(string $module, string $name, &$found = null) {
    $found = false;
    if (function_exists('acf_get_loop')) {
        for ($index = -1; $index >= -50; $index--) {
            $loop = acf_get_loop($index);
            if (!$loop) { break; }
            $row_index = (int) ($loop['i'] ?? -1);
            $row = $loop['value'][$row_index] ?? [];
            if (($row['acf_fc_layout'] ?? '') !== $module) { continue; }
            foreach ([$name, 'field_' . $name] as $row_key) {
                if (array_key_exists($row_key, $row)) { $found = true; return $row[$row_key]; }
            }
            $post_id = $loop['post_id'] ?? 0;
            $meta_key = ($loop['name'] ?? 'modules') . '_' . $row_index . '_' . $name;
            if (is_numeric($post_id) && metadata_exists('post', (int) $post_id, $meta_key)) {
                $found = true;
                return get_post_meta((int) $post_id, $meta_key, true);
            }
            return null;
        }
    }
    if (function_exists('get_row_layout') && get_row_layout() === $module && function_exists('get_sub_field')) {
        $value = get_sub_field($name, false);
        $found = $value !== false && $value !== null;
        return $value;
    }
    return null;
}

/** Punctuation is presentation, not a separate editorial setting. */
function waklert_content_is_punctuation(array $entry): bool {
    if (($entry['type'] ?? '') !== 'text') { return false; }
    $text = trim(html_entity_decode(strip_tags((string) ($entry['default'] ?? '')), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    return $text !== '' && !preg_match('/[\p{L}\p{N}]/u', $text);
}

/** Keep generated artwork and punctuation controls out of the content editor. */
function waklert_prepare_content_editor_field($field) {
    if (!is_array($field)) { return $field; }
    static $artwork_keys = null;
    static $text_tabs = null;
    static $editor_text_keys = null;
    if ($artwork_keys === null) {
        $artwork_keys = [];
        $text_tabs = [];
        $editor_text_keys = [];
        foreach (waklert_template_content_registry() as $key => $entry) {
            // Existing content/media controls keep their original editor location.
            if (!empty($entry['field_name'])) { continue; }
            $type = $entry['type'] ?? '';
            if (in_array($type, ['icon', 'image'], true)) {
                $artwork_keys['field_wc_' . $key] = true;
                if ($type === 'icon') { $artwork_keys['field_wc_' . $key . '_image'] = true; }
            } elseif (waklert_content_is_punctuation($entry)) {
                $artwork_keys['field_wc_' . $key] = true;
            } elseif ($type === 'text') {
                $editor_text_keys['field_wc_' . $key] = true;
                if (!empty($entry['module'])) { $text_tabs['field_wc_tab_' . $entry['module']] = true; }
            }
        }
    }
    $key = $field['key'] ?? '';
    if (isset($artwork_keys[$key])) { return false; }
    if (($field['type'] ?? '') === 'tab' && str_starts_with($key, 'field_wc_tab_')) {
        if (!isset($text_tabs[$key])) { return false; }
        $field['label'] = 'Additional text';
    }
    if (isset($editor_text_keys[$key]) && str_starts_with($field['instructions'] ?? '', 'Default is installed once')) {
        $field['instructions'] = '';
    }
    return $field;
}
add_filter('acf/prepare_field', 'waklert_prepare_content_editor_field', 20);

/** Return a text/icon field while preserving a saved empty value. */
function waklert_content(string $key): string {
    $entry = waklert_template_content_registry()[$key] ?? null;
    if (!is_array($entry)) {
        return '';
    }

    $field_name = (string) ($entry['field_name'] ?? ('wc_' . $key));
    $module     = (string) ($entry['module'] ?? '');
    if ($module !== '') {
        $value = waklert_template_module_value($module, $field_name, $found);
        if ($found) {
            return is_scalar($value) ? (string) $value : '';
        }
        return is_scalar($entry['default'] ?? null) ? (string) $entry['default'] : '';
    }

    if (function_exists('get_field')) {
        $value = get_field($field_name, 'option', false);
        if ($value !== false && $value !== null) {
            return is_scalar($value) ? (string) $value : '';
        }
    }

    $option = get_option('options_' . $field_name, null);
    if ($option !== null) {
        return is_scalar($option) ? (string) $option : '';
    }

    return is_scalar($entry['default'] ?? null) ? (string) $entry['default'] : '';
}

/** Saved artwork wins; blank icon/image controls use the bundled SVG. */
function waklert_content_icon(string $key): string {
    $entry = waklert_template_content_registry()[$key] ?? null;
    if (!is_array($entry) || ($entry['type'] ?? '') !== 'icon') {
        return '';
    }

    $image_name = 'wc_' . $key . '_image';
    $image      = false;
    $module     = (string) ($entry['module'] ?? '');
    if ($module !== '') {
        $image = waklert_template_module_value($module, $image_name, $found);
    }
    if ($module === '' && !$image && function_exists('get_field')) {
        $image = get_field($image_name, 'option');
    }

    $image_url = waklert_content_image_url($image);
    if ($image_url !== '') {
        $svg = waklert_content($key) ?: (string) ($entry['default'] ?? '');
        $attributes = [];
        if (preg_match('/<svg\b([^>]*)>/i', $svg, $match)) {
            foreach (['class', 'width', 'height'] as $name) {
                if (preg_match('/\b' . $name . '\s*=\s*(["\'])(.*?)\1/i', $match[1], $attribute)) {
                    $attributes[$name] = $attribute[2];
                }
            }
        }
        $class = isset($attributes['class']) ? ' class="' . esc_attr($attributes['class']) . '"' : '';
        $size  = '';
        foreach (['width', 'height'] as $name) {
            if (isset($attributes[$name]) && preg_match('/^[0-9.]+(?:px|em|rem|%)?$/', $attributes[$name])) {
                $size .= ' ' . $name . '="' . esc_attr($attributes[$name]) . '"';
            }
        }
        return '<img src="' . esc_url($image_url) . '" alt="" aria-hidden="true"' . $class . $size . '>';
    }

    $svg = trim(waklert_content($key));
    return waklert_sanitize_content_svg($svg !== '' ? $svg : (string) ($entry['default'] ?? ''));
}

/** Keep computed states (for example rating colours) separate from the editable artwork. */
function waklert_content_icon_class(string $key, string $class): string {
    $html = trim(waklert_content_icon($key));
    if ($class === '' || $html === '') { return $html; }
    if (preg_match('/^(<[^>]+\bclass=")([^"]*)"/', $html)) {
        return preg_replace_callback('/^(<[^>]+\bclass=")([^"]*)"/', function($match) use ($class) {
            return $match[1] . esc_attr(trim(html_entity_decode($match[2], ENT_QUOTES) . ' ' . $class)) . '"';
        }, $html, 1);
    }
    return preg_replace('/^<(svg|img|i|span)\b/', '<$1 class="' . esc_attr($class) . '"', $html, 1);
}

/** Resolve a saved image, falling back to the bundled asset when blank. */
function waklert_content_asset(string $key): string {
    $entry = waklert_template_content_registry()[$key] ?? null;
    if (!is_array($entry) || ($entry['type'] ?? '') !== 'image') {
        return '';
    }

    $field_name = (string) ($entry['field_name'] ?? ('wc_' . $key));
    $value      = false;
    $module     = (string) ($entry['module'] ?? '');
    if ($module !== '') {
        $value = waklert_template_module_value($module, $field_name, $found);
    }
    if ($module === '' && !$value && function_exists('get_field')) {
        $value = get_field($field_name, 'option');
    }

    $url = waklert_content_image_url($value);
    if ($url !== '') {
        return $url;
    }

    $default = (string) ($entry['default'] ?? '');
    if (preg_match('#^https?://#i', $default)) {
        return esc_url_raw($default);
    }
    $relative = ltrim(str_replace('\\', '/', $default), '/');
    if ($relative === '' || str_contains('/' . $relative, '/../')) {
        return '';
    }
    return get_theme_file_uri($relative);
}

function waklert_content_image_url($value): string {
    if (is_array($value)) {
        if (!empty($value['ID'])) {
            $value = $value['ID'];
        } elseif (!empty($value['url'])) {
            $value = $value['url'];
        } else {
            return '';
        }
    }
    if (is_numeric($value) && (int) $value > 0) {
        return (string) (wp_get_attachment_image_url((int) $value, 'full') ?: '');
    }
    return is_string($value) && preg_match('#^https?://#i', $value) ? esc_url_raw($value) : '';
}

function waklert_template_option_has_value(string $name): bool {
    return get_option('_' . $name, null) !== null || get_option($name, null) !== null;
}

function waklert_template_module_has_value(string $name): bool {
    global $post;
    if (!isset($post->ID) || !function_exists('get_row_index')) {
        return false;
    }
    $index = max(0, (int) get_row_index() - 1);
    return metadata_exists('post', (int) $post->ID, 'modules_' . $index . '_' . $name);
}

/** Restrict editable SVG to inert shapes, paths, and presentation attributes. */
function waklert_sanitize_content_svg(string $svg): string {
    if (!function_exists('wp_kses')) {
        return '';
    }
    $tags = ['svg', 'g', 'path', 'rect', 'circle', 'ellipse', 'line', 'polyline', 'polygon', 'title', 'desc', 'defs', 'clippath', 'mask', 'lineargradient', 'radialgradient', 'stop', 'i', 'span', 'text'];
    $attributes = [
        'class' => true, 'id' => true, 'viewbox' => true, 'xmlns' => true,
        'width' => true, 'height' => true, 'x' => true, 'y' => true,
        'x1' => true, 'x2' => true, 'y1' => true, 'y2' => true,
        'cx' => true, 'cy' => true, 'r' => true, 'rx' => true, 'ry' => true,
        'd' => true, 'points' => true, 'fill' => true, 'fill-rule' => true,
        'clip-rule' => true, 'stroke' => true, 'stroke-width' => true,
        'stroke-linecap' => true, 'stroke-linejoin' => true, 'stroke-dasharray' => true,
        'stroke-dashoffset' => true, 'opacity' => true, 'fill-opacity' => true,
        'stroke-opacity' => true, 'transform' => true, 'offset' => true,
        'stop-color' => true, 'stop-opacity' => true, 'clippathunits' => true,
        'maskunits' => true, 'aria-hidden' => true, 'role' => true, 'clip-path' => true,
        'font-family' => true, 'font-size' => true, 'font-weight' => true,
        'letter-spacing' => true, 'text-anchor' => true,
    ];
    $allowed = [];
    foreach ($tags as $tag) {
        $allowed[$tag] = $attributes;
    }
    $clean = wp_kses($svg, $allowed);
    // KSES lowercases attribute names; retain SVG's XML spelling as well as HTML compatibility.
    foreach (['viewbox' => 'viewBox', 'clippathunits' => 'clipPathUnits', 'maskunits' => 'maskUnits'] as $lower => $canonical) {
        $clean = preg_replace('/\b' . $lower . '(?=\s*=)/i', $canonical, $clean);
    }
    return $clean;
}

add_action('acf/init', function() {
    if (!function_exists('acf_add_options_sub_page')) {
        return;
    }
    $pages = [
        'shared'    => 'Header & Footer',
        'pages'     => 'Pages',
        'storefront'=> 'Storefront',
        'checkout'  => 'Checkout',
        'emails'    => 'Emails',
        'system'    => 'System Messages',
    ];
    foreach ($pages as $section => $label) {
        acf_add_options_sub_page([
            'page_title'  => 'Content: ' . $label,
            'menu_title'  => 'Content: ' . $label,
            'menu_slug'   => 'waklert-content-' . $section,
            'parent_slug' => 'theme-general-settings',
            'capability'  => 'manage_options',
        ]);
    }
});

/** Import a registry image only from this theme, once per local asset. */
function waklert_import_template_asset(string $relative): int {
    $relative = ltrim(str_replace('\\', '/', $relative), '/');
    if ($relative === '' || str_contains('/' . $relative, '/../')) {
        return 0;
    }
    $source = realpath(MODMY_THEME_DIR . '/' . $relative);
    $root   = realpath(MODMY_THEME_DIR);
    if (!$source || !$root || !str_starts_with(strtolower($source), strtolower($root . DIRECTORY_SEPARATOR)) || !is_readable($source)) {
        return 0;
    }

    $imports = (array) get_option('waklert_template_content_imports', []);
    if (!empty($imports[$relative]) && get_post((int) $imports[$relative])) {
        return (int) $imports[$relative];
    }

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $temp = wp_tempnam(basename($source));
    if (!$temp || !copy($source, $temp)) {
        return 0;
    }
    $attachment_id = media_handle_sideload(['name' => basename($source), 'tmp_name' => $temp], 0);
    if (is_wp_error($attachment_id)) {
        @unlink($temp);
        return 0;
    }
    $imports[$relative] = (int) $attachment_id;
    update_option('waklert_template_content_imports', $imports, false);
    return (int) $attachment_id;
}

/** Seed each new setting once. A later blank saved by an editor stays blank. */
function waklert_seed_template_content(): void {
    $lock = (int) get_option('waklert_template_content_seed_lock', 0);
    if ($lock && time() - $lock < 300) { return; }
    if ($lock) { delete_option('waklert_template_content_seed_lock'); }
    if (!add_option('waklert_template_content_seed_lock', time(), '', false)) { return; }
    try {
        waklert_seed_template_content_values();
    } finally {
        delete_option('waklert_template_content_seed_lock');
    }
}

function waklert_seed_template_content_values(): void {
    if (!function_exists('get_field') || !function_exists('acf_get_field')) {
        return;
    }
    $registry = waklert_template_content_registry();
    if (!$registry) {
        return;
    }

    $markers = (array) get_option('waklert_template_content_seeded', []);
    foreach ($registry as $key => $entry) {
        $module = (string) ($entry['module'] ?? '');
        if ($module !== '') {
            continue;
        }
        $marker = 'option:' . $key . (isset($entry['field_name']) ? ':' . $entry['field_name'] : '');
        if (!empty($markers[$marker])) {
            continue;
        }
        $name = (string) ($entry['field_name'] ?? ('wc_' . $key));
        $option_name = 'options_' . $name;
        if (!waklert_template_option_has_value($option_name) || get_option($option_name, null) === '') {
            $default = $entry['default'] ?? '';
            if (($entry['type'] ?? '') === 'image' && is_string($default) && $default !== '') {
                $default = waklert_import_template_asset($default) ?: '';
            }
            if (($entry['type'] ?? '') === 'image' && $default === '') { continue; }
            update_option('options_' . $name, $default);
            update_option('_options_' . $name, $entry['field_key'] ?? ('field_' . $name));
        }
        $markers[$marker] = true;
    }

    $post_ids = get_posts([
        'post_type' => 'any', 'post_status' => 'any', 'posts_per_page' => -1,
        'fields' => 'ids', 'meta_key' => 'modules',
    ]);
    foreach ($post_ids as $post_id) {
        $layouts = get_post_meta($post_id, 'modules', true);
        if (!is_array($layouts)) {
            continue;
        }
        foreach ($layouts as $index => $layout) {
            if ($layout === 'product_faqs' && empty($markers['original_product_faq_defaults'])) {
                waklert_seed_module($post_id, $index, $layout);
            }
            foreach ($registry as $key => $entry) {
                if (($entry['module'] ?? '') !== $layout) {
                    continue;
                }
                $identity = $key . (isset($entry['field_name']) ? ':' . $entry['field_name'] : '');
                $marker = 'module:' . (int) $post_id . ':' . (int) $index . ':' . $identity;
                if (!empty($markers[$marker])) {
                    continue;
                }
                $name = 'modules_' . (int) $index . '_' . ($entry['field_name'] ?? ('wc_' . $key));
                $exists = metadata_exists('post', (int) $post_id, $name);
                if (!$exists) {
                    $default = $entry['default'] ?? '';
                    if (($entry['type'] ?? '') === 'image' && is_string($default) && $default !== '') {
                        $default = waklert_import_template_asset($default) ?: '';
                    }
                    if (($entry['type'] ?? '') === 'image' && $default === '') { continue; }
                    update_post_meta($post_id, $name, $default);
                    update_post_meta($post_id, '_' . $name, $entry['field_key'] ?? ('field_wc_' . $key));
                }
                $markers[$marker] = true;
            }
        }
    }

    foreach ($registry as $key => $entry) {
        $identity = $key . (isset($entry['field_name']) ? ':' . $entry['field_name'] : '');
        $markers['introduced:' . $identity] = true;
    }
    $markers['original_product_faq_defaults'] = true;
    update_option('waklert_template_content_seeded', $markers, false);
    update_option('waklert_template_content_seed_version', hash('sha256', wp_json_encode($registry)), false);
}
function waklert_maybe_seed_template_content(): void {
    if (defined('WAKLERT_SKIP_CONTENT_SEED') && WAKLERT_SKIP_CONTENT_SEED) { return; }
    if (!current_user_can('manage_options')) { return; }
    $version = hash('sha256', wp_json_encode(waklert_template_content_registry()));
    if (get_option('waklert_template_content_seed_version') !== $version) {
        waklert_seed_template_content();
    }
}
add_action('admin_init', 'waklert_maybe_seed_template_content', 100);
add_action('acf/save_post', function($post_id) {
    if (current_user_can('manage_options')
        && !(defined('WAKLERT_SKIP_CONTENT_SEED') && WAKLERT_SKIP_CONTENT_SEED)) {
        waklert_seed_template_content();
    }
}, 30);

add_filter('acf/validate_value', function($valid, $value, $field) {
    if ($valid !== true || !is_string($value)) { return $valid; }
    foreach (waklert_template_content_registry() as $key => $entry) {
        if (($entry['field_key'] ?? ('field_wc_' . $key)) !== ($field['key'] ?? '')) { continue; }
        $default = (string) ($entry['default'] ?? '');
        preg_match_all('/%(?:[0-9]+\$)?[bcdeEfFgGosuxX]/', $default, $placeholders);
        if (!$placeholders[0]) { return $valid; }
        try {
            sprintf($value, ...array_fill(0, count($placeholders[0]), ''));
        } catch (Throwable $error) {
            return 'Keep the original formatting placeholders, such as %s, in this message.';
        }
        return $valid;
    }
    return $valid;
}, 10, 3);

add_action('acf/render_field/type=textarea', function($field) {
    $key = preg_replace('/^wc_/', '', $field['name'] ?? '');
    $entry = waklert_template_content_registry()[$key] ?? [];
    if (($entry['type'] ?? '') !== 'icon') { return; }
    $icon = waklert_sanitize_content_svg((string) ($field['value'] ?? $entry['default'] ?? ''));
    $icon = preg_replace_callback('/^\s*<svg\b([^>]*)>/', function($match) {
        $attrs = preg_replace('/\s+(width|height)="[^"]*"/', '', $match[1]);
        return '<svg' . $attrs . ' width="48" height="48">';
    }, $icon, 1);
    echo '<div aria-label="Icon preview" style="margin-top:8px;width:48px;height:48px;overflow:hidden">' . $icon . '</div>';
});

add_action('wp_head', function() {
    $icon = waklert_content_icon('manual_footer_brand_mark');
    $url = '';
    if (preg_match('/^\s*<svg\b/i', $icon)) {
        $url = 'data:image/svg+xml,' . rawurlencode($icon);
    } elseif (preg_match('/<img\b[^>]*\bsrc="([^"]+)"/', $icon, $match)) {
        $url = esc_url_raw(html_entity_decode($match[1], ENT_QUOTES));
    }
    echo '<style>:root{--waklert-brand-mark:' . ($url !== '' ? 'url("' . esc_attr($url) . '")' : 'none') . ';}</style>';
}, 30);
