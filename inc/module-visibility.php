<?php
/** Empty CMS fields have no frontend output; their controls stay in ACF. */
defined('ABSPATH') || exit;

function waklert_has_content($value): bool {
    if (!is_scalar($value)) { return false; }
    if (preg_match('/<(?:img|video|audio|iframe)\b[^>]*\bsrc=[\"\']([^\"\']+)[\"\']/i', (string) $value, $media) && trim($media[1]) !== '') { return true; }
    $text = html_entity_decode(strip_tags((string) $value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = preg_replace('/[\s\x{00a0}\x{200b}\x{feff}]+/u', '', $text);
    return $text !== null && $text !== '';
}

function waklert_module_text(string $name): string {
    $value = get_sub_field($name);
    return waklert_has_content($value) ? trim((string) $value) : '';
}

/** Ignore empty repeater cards, including cards containing only a decorative icon. */
function waklert_module_row_has_content($row): bool {
    if (!is_array($row)) { return waklert_has_content($row); }
    foreach ($row as $name => $value) {
        if (is_bool($value)) { continue; }
        $field = function_exists('acf_get_field') ? acf_get_field($name) : false;
        $name = $field['name'] ?? $name;
        $type = $field['type'] ?? '';
        if (in_array($type, ['select', 'true_false', 'number', 'tab'], true)
            || preg_match('/(^_|icon|preset|style|theme|class|checkmark|acf_fc_layout)/i', (string) $name)) { continue; }
        if (is_array($value) ? waklert_module_row_has_content($value) : waklert_has_content($value)) { return true; }
    }
    return false;
}

function waklert_module_rows(string $name): array {
    $rows = get_sub_field($name);
    return is_array($rows) ? array_values(array_filter($rows, 'waklert_module_row_has_content')) : [];
}

/** Suppress the section shell when all its saved content has been cleared. */
function waklert_module_is_empty(): bool {
    if (!function_exists('get_row') || !function_exists('acf_get_loop') || !acf_get_loop()) { return false; }
    $row = get_row();
    if (!is_array($row)) { return false; }
    $content = $row;
    unset($content['acf_fc_layout']);
    // A module with no configuration fields may intentionally render native data.
    return $content !== [] && !waklert_module_row_has_content($content);
}
