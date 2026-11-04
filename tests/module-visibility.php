<?php
/** CLI-only render checks using unsaved ACF rows. No content/database writes. */
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('WAKLERT_SKIP_CONTENT_SEED', true);
$_SERVER['HTTP_HOST'] = 'waklertaustralia.com.test';
require dirname(__DIR__, 4) . '/wp-load.php';
if (!waklert_is_local_site()) { throw new RuntimeException('Local checks only.'); }
set_exception_handler(function(Throwable $error) { fwrite(STDERR, $error->getMessage() . PHP_EOL); exit(1); });
function visibility_assert($ok, $message) { if (!$ok) { throw new RuntimeException($message); } }
foreach (['', '  ', '<p><br></p>', '&nbsp;', "\xc2\xa0"] as $blank) {
    visibility_assert(!waklert_has_content($blank), 'Blank content detected as visible.');
}
visibility_assert(waklert_has_content('<img src="/media.jpg" alt="">'), 'Image-only rich text hidden.');
visibility_assert(waklert_has_content('0'), 'Zero should remain visible.');
visibility_assert(waklert_has_content('Visible'), 'Text hidden.');
visibility_assert(!waklert_module_row_has_content(['title' => '', 'icon' => 'truck']), 'Empty icon-only card visible.');
visibility_assert(waklert_module_row_has_content(['title' => 'Restored', 'icon' => 'truck']), 'Restored card hidden.');
$group = json_decode(file_get_contents(MODMY_THEME_DIR . '/acf-json/group_page_modules.json'), true);
$layouts = $group['fields'][0]['layouts'] ?? [];
if (!$layouts) {
    foreach ($group['fields'] as $field) { if ($field['name'] === 'modules') { $layouts = $field['layouts']; } }
}
function render_visibility_module($layout, $fields, $overrides = []) {
    $row = ['acf_fc_layout' => $layout];
    foreach ($fields as $field) {
        $row[$field['key']] = in_array($field['type'], ['repeater','relationship'], true) ? [] : '';
        if (array_key_exists($field['name'], $overrides)) { $row[$field['key']] = $overrides[$field['name']]; }
    }
    acf_get_store('values')->reset();
    acf_add_loop(['name' => 'modules', 'field' => acf_get_field('field_modules'), 'i' => 0, 'post_id' => 0, 'value' => [$row]]);
    ob_start();
    try { include MODMY_THEME_DIR . '/modules/content-' . $layout . '.php'; return ob_get_contents(); }
    finally { ob_end_clean(); while (acf_get_loop()) { acf_remove_loop('active'); } }
}
$by_name = [];
foreach ($layouts as $layout) { $by_name[$layout['name']] = $layout['sub_fields']; }
foreach (['hero_section', 'featured_products'] as $name) {
    $fields = $by_name[$name];
    $html = render_visibility_module($name, $fields);
    visibility_assert(!preg_match('/<h[12]\b/', $html), "$name has an empty heading");
    visibility_assert(!preg_match('/<p\b/', $html), "$name has an empty description");
    visibility_assert(!preg_match('/<a\b/', $html), "$name has a blank/default button");
    visibility_assert(!str_contains($html, 'Express Delivery'), "$name resurrected default badges");
    $html = render_visibility_module($name, $fields, ['heading' => 'VISIBLE HEADING', 'title' => 'VISIBLE HEADING', 'description' => 'VISIBLE DESCRIPTION', 'primary_button_text' => 'VISIBLE BUTTON', 'primary_button_link' => '/shop/', 'button_text' => 'VISIBLE BUTTON', 'button_url' => '/shop/']);
    foreach (['VISIBLE HEADING','VISIBLE DESCRIPTION','VISIBLE BUTTON'] as $text) { visibility_assert(str_contains($html, $text), "$name failed to restore $text"); }
    $html = render_visibility_module($name, $fields, ['heading' => 'VISIBLE HEADING', 'title' => 'VISIBLE HEADING', 'description' => '   ']);
    visibility_assert(str_contains($html, 'VISIBLE HEADING') && !preg_match('/<p\b/', $html), "$name blank description left output");
    echo "$name empty, whitespace and restored states passed.\n";
}
$badge_fields = [];
foreach ($by_name['hero_section'] as $field) { if ($field['name'] === 'feature_badges') { $badge_fields = $field['sub_fields']; } }
$badge = [];
foreach ($badge_fields as $field) { $badge[$field['key']] = ['title'=>'RESTORED BADGE','subtitle'=>'RESTORED BADGE DETAIL','icon'=>'truck'][$field['name']] ?? ''; }
$html = render_visibility_module('hero_section', $by_name['hero_section'], ['heading'=>'Hero', 'feature_badges'=>[$badge]]);
visibility_assert(str_contains($html, 'RESTORED BADGE'), 'Badge could not be restored.');
foreach ($badge_fields as $field) { if ($field['name'] !== 'icon') { $badge[$field['key']] = ''; } }
$html = render_visibility_module('hero_section', $by_name['hero_section'], ['heading'=>'Hero', 'feature_badges'=>[$badge]]);
visibility_assert(!str_contains($html, 'grid-cols-1 sm:grid-cols-3'), 'Icon-only empty badge still has a card.');
foreach (['hero_section','featured_products'] as $name) {
    $html = render_visibility_module($name, $by_name[$name], ['heading'=>'Heading','title'=>'Heading','primary_button_text'=>'BUTTON LABEL','button_text'=>'BUTTON LABEL']);
    visibility_assert(!str_contains($html, 'BUTTON LABEL'), "$name shows a button without its link.");
}
echo "Repeater badge restoration and incomplete button checks passed.\n";
foreach ($by_name as $name => $fields) {
    if (!is_file(MODMY_THEME_DIR . '/modules/content-' . $name . '.php')) { continue; }
    $html = render_visibility_module($name, $fields);
    if ($name !== 'products_grid') { visibility_assert(trim($html) === '', "$name left an empty section shell"); }
    echo "$name rendered with empty fields.\n";
}
// Artwork falls back independently from text; custom uploads retain priority.
$html = render_visibility_module('hero_section', $by_name['hero_section'], ['heading'=>'Hero with fallback artwork']);
visibility_assert(str_contains($html, 'assets/images/hero-tradie-v2.webp'), 'Empty desktop image lost bundled fallback.');
visibility_assert(str_contains($html, 'assets/images/hero-mobile-tradie.webp'), 'Empty mobile image lost bundled fallback.');
visibility_assert(!preg_match('/<p\b/', $html), 'Artwork fallback restored empty description text.');
$uploads = get_posts(['post_type'=>'attachment', 'post_mime_type'=>'image', 'posts_per_page'=>2, 'fields'=>'ids']);
visibility_assert(count($uploads) === 2, 'Two existing image attachments are required for upload-priority checks.');
$desktop_upload = wp_get_attachment_image_url($uploads[0], 'full');
$mobile_upload = wp_get_attachment_image_url($uploads[1], 'full');
$html = render_visibility_module('hero_section', $by_name['hero_section'], ['heading'=>'Custom hero', 'background_image'=>$uploads[0], 'mobile_image'=>$uploads[1]]);
visibility_assert(str_contains($html, esc_url($desktop_upload)) && str_contains($html, esc_url($mobile_upload)), 'Uploaded hero image did not take priority.');
visibility_assert(!str_contains($html, 'hero-tradie-v2.webp') && !str_contains($html, 'hero-mobile-tradie.webp'), 'Fallback replaced an uploaded image.');
$html = render_visibility_module('support_cta', $by_name['support_cta'], ['title'=>'Support']);
visibility_assert(str_contains($html, 'assets/images/guy-with-phone.png'), 'Empty support image lost bundled fallback.');
$blank_artwork = static function($value, $post_id, $field) {
    return str_starts_with($field['key'] ?? '', 'field_wc_') ? '' : $value;
};
add_filter('acf/load_value', $blank_artwork, 100, 3);
try {
    acf_get_store('values')->reset();
    $icon = waklert_content_icon('theme_setup_icon_8cbaa9f5f7');
    visibility_assert(str_contains($icon, '<svg'), 'Blank icon lost its bundled fallback.');
    $image = waklert_content_asset('header_image_18dabadce0');
    visibility_assert(str_contains($image, 'assets/images/waklert-site-icon.png'), 'Blank global image lost its bundled fallback.');
} finally { remove_filter('acf/load_value', $blank_artwork, 100); acf_get_store('values')->reset(); }
echo "Image/icon fallback, uploaded image priority and empty-text checks passed.\n";
function visibility_repeater_row($fields, $name, $values) {
    foreach ($fields as $field) {
        if ($field['name'] !== $name) { continue; }
        $row = [];
        foreach ($field['sub_fields'] as $sub) { $row[$sub['key']] = $values[$sub['name']] ?? ''; }
        return $row;
    }
    throw new RuntimeException('Unknown fixture repeater: ' . $name);
}
foreach ([['trust_strip','badges','label'],['why_choose_us','audiences','title'],['how_to_order','steps','title']] as [$layout,$repeater,$title_field]) {
    $row = visibility_repeater_row($by_name[$layout], $repeater, [$title_field=>'KEPT CARD TITLE']);
    $html = render_visibility_module($layout, $by_name[$layout], [$repeater=>[$row]]);
    visibility_assert(str_contains($html, 'KEPT CARD TITLE'), 'Populated card disappeared: ' . $layout);
    visibility_assert(!str_contains($html, 'bg-[#0c4161] group-hover:bg-[#082c42] text-white'), 'Empty description left a coloured panel: ' . $layout);
}
$html = render_visibility_module('about_mission', $by_name['about_mission'], ['mission_heading'=>'KEPT MISSION']);
visibility_assert(str_contains($html, 'KEPT MISSION') && !str_contains($html, 'border-amber-300/80'), 'Cleared vision left its card or icon.');
foreach (['faqs','product_faqs'] as $layout) {
    $row = visibility_repeater_row($by_name[$layout], 'faq_items', ['answer'=>'Answer without a question']);
    $html = render_visibility_module($layout, $by_name[$layout], ['faq_items'=>[$row]]);
    visibility_assert(!str_contains($html, '<details'), 'Blank question left an icon-only FAQ: ' . $layout);
}
echo "Companion card panels, mission/vision and FAQ question visibility passed.\n";
echo "All module visibility checks passed.\n";
