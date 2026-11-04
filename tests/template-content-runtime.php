<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }

define('ABSPATH', __DIR__ . '/');
$test_root = sys_get_temp_dir() . '/waklert-content-' . bin2hex(random_bytes(6));
mkdir($test_root . '/inc/data', 0777, true);
define('MODMY_THEME_DIR', $test_root);

$GLOBALS['test_options'] = [];
$GLOBALS['test_fields'] = [];
$GLOBALS['test_sub_fields'] = [];
$GLOBALS['test_row_layout'] = '';
$GLOBALS['test_allowed_svg'] = [];

function add_action(...$args): void {}
function add_filter(...$args): void {}
function get_option($name, $default = false) { return $GLOBALS['test_options'][$name] ?? $default; }
function get_field($name, $post_id = false, $format_value = true) { return $GLOBALS['test_fields'][$name] ?? false; }
function get_sub_field($name, $format_value = true) { return $GLOBALS['test_sub_fields'][$name] ?? false; }
function get_row_layout() { return $GLOBALS['test_row_layout']; }
function wp_kses($html, $allowed) {
    $GLOBALS['test_allowed_svg'] = $allowed;
    $tags = '<' . implode('><', array_keys($allowed)) . '>';
    $html = strip_tags($html, $tags);
    return preg_replace_callback('/<([a-zA-Z][\w:-]*)([^>]*)>/', function($match) use ($allowed) {
        $tag = strtolower($match[1]);
        if (!isset($allowed[$tag])) { return ''; }
        $attrs = '';
        preg_match_all('/([a-zA-Z][\w:-]*)\s*=\s*(["\'])(.*?)\2/', $match[2], $found, PREG_SET_ORDER);
        foreach ($found as $attribute) {
            if (isset($allowed[$tag][strtolower($attribute[1])])) {
                $attrs .= ' ' . strtolower($attribute[1]) . '="' . htmlspecialchars($attribute[3], ENT_QUOTES) . '"';
            }
        }
        return '<' . $tag . $attrs . (str_ends_with(trim($match[0]), '/>') ? '/>' : '>');
    }, $html);
}

$fixture = MODMY_THEME_DIR . '/inc/data/template-content-runtime-test.json';
if (!is_dir(dirname($fixture))) { mkdir(dirname($fixture), 0777, true); }
file_put_contents($fixture, json_encode([
    'runtime_test_text' => ['type' => 'text', 'default' => 'seed value', 'source' => 'tests/template-content-runtime.php', 'label' => 'Test'],
    'runtime_test_module' => ['type' => 'text', 'default' => 'module default', 'source' => 'tests/template-content-runtime.php', 'label' => 'Test module', 'module' => 'hero'],
    'runtime_test_icon' => ['type' => 'icon', 'default' => '<svg class="w-4 h-4" viewBox="0 0 24 24"><path d="M0 0"/></svg><script>alert(1)</script>', 'source' => 'tests/template-content-runtime.php', 'label' => 'Test icon'],
], JSON_THROW_ON_ERROR));
register_shutdown_function(static function() use ($fixture, $test_root) {
    if (is_file($fixture)) { unlink($fixture); }
    rmdir($test_root . '/inc/data'); rmdir($test_root . '/inc'); rmdir($test_root);
});

require dirname(__DIR__) . '/inc/template-content.php';

function expect_same($expected, $actual, string $message): void {
    if ($expected !== $actual) {
        throw new RuntimeException($message . ': expected ' . var_export($expected, true) . ', got ' . var_export($actual, true));
    }
}

expect_same('seed value', waklert_content('runtime_test_text'), 'Missing option uses registry default');
$GLOBALS['test_fields']['wc_runtime_test_text'] = '';
expect_same('', waklert_content('runtime_test_text'), 'Saved empty option remains empty');
$GLOBALS['test_fields']['wc_runtime_test_text'] = '0';
expect_same('0', waklert_content('runtime_test_text'), 'Zero-like text remains intact');
$GLOBALS['test_row_layout'] = 'hero';
$GLOBALS['test_sub_fields']['wc_runtime_test_module'] = '';
expect_same('', waklert_content('runtime_test_module'), 'Saved empty module field remains empty');
$GLOBALS['test_sub_fields']['wc_runtime_test_module'] = 'Editable';
expect_same('Editable', waklert_content('runtime_test_module'), 'Active module field takes precedence');

$icon = waklert_content_icon('runtime_test_icon');
expect_same(true, str_contains($icon, 'class="w-4 h-4"'), 'SVG classes are retained');
expect_same(true, str_contains($icon, 'viewBox="0 0 24 24"'), 'SVG viewBox is retained with real KSES casing behavior');
expect_same(false, str_contains($icon, '<script'), 'Script elements are removed from editable SVG');
expect_same(false, isset($GLOBALS['test_allowed_svg']['svg']['onload']), 'Event handlers are excluded from SVG allowlist');

$GLOBALS['test_fields']['wc_runtime_test_icon'] = '';
expect_same(true, str_contains(waklert_content_icon('runtime_test_icon'), '<svg'), 'Saved blank icon uses bundled SVG');
$GLOBALS['test_fields']['wc_runtime_test_icon'] = '<svg viewBox="0 0 12 12"><path d="M2 2"/></svg>';
expect_same(true, str_contains(waklert_content_icon('runtime_test_icon'), 'M2 2'), 'Saved custom SVG takes priority');
echo "Template content runtime checks passed.\n";
