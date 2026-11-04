<?php
/** Installer checks against an in-memory metadata store; no WordPress/database boot. */
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
define('MODMY_THEME_DIR', dirname(__DIR__));
function add_action(...$args) {}
function waklert_default_faq_items() { return waklert_seed_defaults()['faqs'] ?? []; }
$GLOBALS['seed_meta'] = [];
$GLOBALS['seed_writes'] = [];
function metadata_exists($type, $id, $name) { return array_key_exists($name, $GLOBALS['seed_meta'][$id] ?? []); }
function get_post_meta($id, $name = '', $single = true) {
    if ($name === '') { return array_map(static fn($value) => [$value], $GLOBALS['seed_meta'][$id] ?? []); }
    return $GLOBALS['seed_meta'][$id][$name] ?? '';
}
function update_post_meta($id, $name, $value) { $GLOBALS['seed_writes'][] = $name; $GLOBALS['seed_meta'][$id][$name] = $value; }
require MODMY_THEME_DIR . '/inc/content-seed.php';
function seed_assert($ok, $message) { if (!$ok) { throw new RuntimeException($message); } }
$defaults = waklert_module_defaults()['hero_section'];
foreach ([0, 7] as $index) {
    foreach ($defaults['fields'] as $name => $definition) { $GLOBALS['seed_meta'][1]["modules_{$index}_{$name}"] = ''; }
    foreach ($defaults['repeaters'] as $name => $definition) { $GLOBALS['seed_meta'][1]["modules_{$index}_{$name}"] = 0; }
    waklert_seed_module(1, $index, 'hero_section');
}
seed_assert($GLOBALS['seed_writes'] === [], 'Installer overwrote cleared or reordered fields.');
$GLOBALS['seed_meta'][1]['modules_2_badges'] = 1;
$GLOBALS['seed_meta'][1]['modules_2_badges_0_label'] = 'Delivery';
$GLOBALS['seed_meta'][1]['modules_2_badges_0_desc'] = '';
waklert_seed_trust_badge_descriptions(1, 2);
seed_assert($GLOBALS['seed_writes'] === [], 'Installer refilled a cleared badge description.');
unset($GLOBALS['seed_meta'][1]['modules_0_heading']);
waklert_seed_module(1, 0, 'hero_section');
seed_assert(get_post_meta(1, 'modules_0_heading', true) === $defaults['fields']['heading'][1], 'Missing field was not initialized.');
seed_assert(count($GLOBALS['seed_writes']) === 2, 'Installer altered unrelated content.');
// Existing FAQs must remain byte-for-byte intact, including partially populated lists.
foreach ([1, 0, null] as $count) {
    $GLOBALS['seed_meta'][2] = [
        'modules_0_faq_items_0_question' => 'KEEP LIVE QUESTION',
        'modules_0_faq_items_0_answer' => '<p>KEEP LIVE ANSWER</p>',
        '_modules_0_faq_items_0_answer' => 'field_faq_a_en',
    ];
    if ($count !== null) { $GLOBALS['seed_meta'][2]['modules_0_faq_items'] = $count; }
    $before = $GLOBALS['seed_meta'][2];
    $GLOBALS['seed_writes'] = [];
    waklert_seed_faq_module(2, 0);
    seed_assert($GLOBALS['seed_meta'][2] === $before && $GLOBALS['seed_writes'] === [], 'Existing live FAQ was altered.');
}
// An existing answer without a question must not be replaced either.
$GLOBALS['seed_meta'][3] = ['modules_0_faq_items_0_answer' => '<p>KEEP ANSWER ONLY</p>'];
$before = $GLOBALS['seed_meta'][3];
waklert_seed_faq_module(3, 0);
seed_assert($GLOBALS['seed_meta'][3] === $before, 'Partial FAQ answer was replaced.');
// Genuinely absent FAQs may receive the default list.
$GLOBALS['seed_meta'][4] = [];
waklert_seed_faq_module(4, 0);
seed_assert((int) get_post_meta(4, 'modules_0_faq_items') > 0, 'Missing FAQ did not initialize.');
$GLOBALS['seed_meta'][5] = ['modules_0_feature_badges_0_title' => 'KEEP LIVE BADGE'];
$before = $GLOBALS['seed_meta'][5];
waklert_seed_repeater(5, 0, 'feature_badges', $defaults['repeaters']['feature_badges']);
seed_assert($GLOBALS['seed_meta'][5] === $before, 'Existing repeater without a count was replaced.');
echo "Existing full/partial FAQs and repeater rows preserved; missing FAQs initialized.\n";
echo "Saved scalar/repeater clears, reordered modules, cleared badge descriptions and missing-field initialization passed.\n";
