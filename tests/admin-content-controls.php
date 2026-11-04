<?php
/** CLI-only checks of the real ACF admin preparation/rendering pipeline. */
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('WAKLERT_SKIP_CONTENT_SEED', true);
$_SERVER['HTTP_HOST'] = 'waklertaustralia.com.test';
require dirname(__DIR__, 4) . '/wp-load.php';
set_exception_handler(function(Throwable $error) { fwrite(STDERR, $error->getMessage() . PHP_EOL); exit(1); });
if (!waklert_is_local_site()) { throw new RuntimeException('Local checks only.'); }
function admin_control_assert($ok, $message) { if (!$ok) { throw new RuntimeException($message); } }
$hidden = [];
$punctuation = 0;
foreach (waklert_template_content_registry() as $key => $entry) {
    if (!empty($entry['field_name'])) { continue; }
    if (in_array($entry['type'], ['icon','image'], true) || waklert_content_is_punctuation($entry)) {
        $hidden[] = 'field_wc_' . $key;
        if ($entry['type'] === 'icon') { $hidden[] = 'field_wc_' . $key . '_image'; }
        if (waklert_content_is_punctuation($entry)) { $punctuation++; }
    } else {
        $field = acf_get_field('field_wc_' . $key);
        admin_control_assert(is_array(acf_prepare_field($field)), 'Editorial text hidden: ' . $key);
    }
}
foreach ($hidden as $key) {
    $field = acf_get_field($key);
    admin_control_assert(is_array($field), 'Missing field definition: ' . $key);
    admin_control_assert(acf_prepare_field($field) === false, 'Technical field visible: ' . $key);
    ob_start();
    acf_render_field_wrap($field);
    $html = ob_get_clean();
    admin_control_assert(trim($html) === '', 'Technical control emitted admin markup: ' . $key);
}
foreach (['field_hero_bg','field_hero_mobile_image','field_hero_desc_en','field_fp_desc'] as $key) {
    admin_control_assert(is_array(acf_prepare_field(acf_get_field($key))), 'Normal content control hidden: ' . $key);
}
admin_control_assert(acf_prepare_field(['key'=>'field_wc_tab_hero_section','type'=>'tab']) === false, 'Empty hero artwork tab remains visible.');
$tab = acf_prepare_field(['key'=>'field_wc_tab_track_order','type'=>'tab']);
admin_control_assert(is_array($tab) && $tab['label'] === 'Additional text', 'Useful text tab missing/incorrectly labelled.');
$icon = waklert_content_icon('content_hero_section_icon_bda9a58a43');
admin_control_assert(str_contains($icon, '<svg') || str_contains($icon, '<img'), 'Frontend artwork was lost.');
echo count($hidden) . " technical controls hidden, including $punctuation punctuation controls.\n";
echo "Editorial text, normal media fields, tab visibility and frontend artwork preserved.\n";
