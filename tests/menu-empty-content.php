<?php
/** CLI-only rendering checks. Option filters simulate edits without database writes. */
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('WAKLERT_SKIP_CONTENT_SEED', true);
$_SERVER['HTTP_HOST'] = 'waklertaustralia.com.test';
require dirname(__DIR__, 4) . '/wp-load.php';
set_exception_handler(function(Throwable $e) { fwrite(STDERR, $e->getMessage() . PHP_EOL); exit(1); });
if (!waklert_is_local_site()) { throw new RuntimeException('Local checks only.'); }
function menu_assert($ok, $message) { if (!$ok) { throw new RuntimeException($message); } }
function with_menu_options(array $values, callable $render) {
    $filters = [];
    foreach ($values as $name => $value) {
        $filters[$name] = static fn() => $value;
        add_filter('pre_option_options_' . $name, $filters[$name]);
    }
    try { return $render(); }
    finally { foreach ($filters as $name => $callback) { remove_filter('pre_option_options_' . $name, $callback); } }
}
function menu_fragment() {
    $walker = new Waklert_Desktop_Nav_Walker();
    $html = '';
    $walker->start_lvl($html);
    $html .= '<li>PRODUCT_SENTINEL</li>';
    $walker->end_lvl($html);
    return $html;
}
$names = ['menu_dropdown_heading','menu_dropdown_badge','menu_dropdown_note','menu_dropdown_button_text','menu_dropdown_button_url'];
for ($mask = 0; $mask < 32; $mask++) {
    $values = [];
    foreach ($names as $index => $name) { $values[$name] = ($mask & (1 << $index)) ? ($index === 4 ? '/shop/' : 'VALUE_' . $index) : ''; }
    $html = with_menu_options($values, 'menu_fragment');
    $heading = (bool) ($mask & 1); $badge = (bool) ($mask & 2); $note = (bool) ($mask & 4);
    $button = (bool) ($mask & 8) && (bool) ($mask & 16);
    menu_assert(str_contains($html, 'menu-dropdown-header') === ($heading || $badge), 'Incorrect heading strip for ' . $mask);
    menu_assert(str_contains($html, '★') === $heading, 'Orphan heading star for ' . $mask);
    menu_assert(str_contains($html, 'menu-dropdown-footer') === ($note || $button), 'Incorrect footer strip for ' . $mask);
    menu_assert(str_contains($html, '<a ') === $button, 'Orphan button/arrow for ' . $mask);
    menu_assert(str_contains($html, 'PRODUCT_SENTINEL'), 'Product list disappeared for ' . $mask);
}
$empty = array_fill_keys($names, '  &nbsp;  '); $empty['menu_dropdown_button_url'] = '/shop/';
$html = with_menu_options($empty, 'menu_fragment');
menu_assert(!str_contains($html, 'menu-dropdown-header') && !str_contains($html, 'menu-dropdown-footer'), 'Whitespace left an empty strip.');
file_put_contents(sys_get_temp_dir() . '/waklert-empty-menu.html', $html);
$mobile_fields = ['mobile_help_eyebrow','mobile_help_title','mobile_help_text','mobile_help_button_text'];
foreach (['empty','text','button_without_link','button'] as $case) {
    $values = array_fill_keys($mobile_fields, ''); $values['mobile_help_button_url'] = '/contact/';
    if ($case === 'text') { $values['mobile_help_text'] = 'HELP DESCRIPTION'; }
    if ($case === 'button' || $case === 'button_without_link') { $values['mobile_help_button_text'] = 'CONTACT BUTTON'; }
    if ($case === 'button_without_link') { $values['mobile_help_button_url'] = ''; }
    $html = with_menu_options($values, static function() { ob_start(); include MODMY_THEME_DIR . '/header.php'; return ob_get_clean(); });
    menu_assert(str_contains($html, 'data-testid="mobile-help-card"') === in_array($case, ['text','button'], true), 'Incorrect mobile help card for ' . $case);
    menu_assert(!str_contains($html, 'Colorful Help Life Ring'), 'Orphan help icon for ' . $case);
}
echo "32 mega-menu combinations, whitespace, product list preservation and mobile help visibility passed.\n";
