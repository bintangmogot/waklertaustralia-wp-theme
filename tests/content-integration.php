<?php
/** Local WordPress integration check. Temporary edits are restored in finally. */
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
$_SERVER['HTTP_HOST'] = 'waklertaustralia.com.test';
define('WAKLERT_SKIP_CONTENT_SEED', true);
define('WP_USE_THEMES', false);
require dirname(__DIR__, 4) . '/wp-load.php';
set_exception_handler(function(Throwable $error) { fwrite(STDERR, $error->getMessage() . "\n"); exit(1); });
if (!waklert_is_local_site()) { throw new RuntimeException('Run this check only on the local site.'); }
function content_assert($condition, $message) {
    if (!$condition) { throw new RuntimeException($message); }
}
$registry = waklert_template_content_registry();
$missing = [];
foreach ($registry as $key => $entry) {
    if (!acf_get_field($entry['field_key'] ?? ('field_wc_' . $key))) { $missing[] = $key; }
}
content_assert(!$missing, 'Missing ACF definitions: ' . implode(', ', $missing));
content_assert(function_exists('waklert_editing_shop_page'), 'The Shop-specific editor visibility helper is missing.');
echo 'ACF field definitions verified: ' . count($registry) . "\n";

$svg = waklert_sanitize_content_svg('<svg viewBox="0 0 64 64" onload="alert(1)"><defs><linearGradient id="a"><stop offset="0" stop-color="#fff"/></linearGradient></defs><path fill="url(#a)" d="M0 0"/></svg><script>alert(1)</script>');
content_assert(str_contains($svg, 'viewBox="0 0 64 64"'), 'SVG viewBox stripped.');
content_assert(str_contains($svg, '<linearGradient'), 'SVG gradient stripped.');
content_assert(!str_contains($svg, '<script') && !str_contains($svg, 'onload='), 'SVG execution survived sanitization.');
echo "Real WordPress SVG sanitization verified.\n";
$custom_icon = waklert_render_card_icon(['icon_preset' => 'auto', 'icon_svg' => '<svg viewBox="0 0 24 24" stroke="currentColor"><path d="M1 2L3 4"/></svg>']);
content_assert(str_contains($custom_icon, 'M1 2L3 4'), 'Custom monochrome SVG was ignored.');

$module_key = null;
$option_key = null;
foreach ($registry as $key => $entry) {
    if ($entry['type'] !== 'text') { continue; }
    if (!empty($entry['module']) && !$module_key) { $module_key = $key; }
    if (empty($entry['module']) && empty($entry['field_name']) && !$option_key) { $option_key = $key; }
}
$entry = $registry[$module_key];
$name = $entry['field_name'] ?? ('wc_' . $module_key);
$row_key = $entry['field_key'] ?? ('field_' . $name);
acf_add_loop(['name' => 'modules', 'i' => 0, 'post_id' => 0, 'value' => [['acf_fc_layout' => $entry['module'], $row_key => 'Nested module override']]]);
acf_add_loop(['name' => 'modules_0_items', 'i' => 0, 'post_id' => 0, 'value' => [['title' => 'Nested item']]]);
try {
    content_assert(waklert_content($module_key) === 'Nested module override', 'Nested repeater lost parent module values.');
    acf_update_loop('previous', 'value', [['acf_fc_layout' => $entry['module'], $row_key => '']]);
    content_assert(waklert_content($module_key) === '', 'Nested repeater lost a cleared parent value.');
} finally {
    acf_remove_loop('active');
    acf_remove_loop('active');
}
echo "Nested module overrides and cleared values verified.\n";

$field_key = 'field_wc_' . $option_key;
$name = 'wc_' . $option_key;
$saved = get_option('options_' . $name, null);
try {
    update_field($field_key, 'Editor override check', 'option');
    waklert_seed_template_content();
    content_assert(waklert_content($option_key) === 'Editor override check', 'Seeder overwrote an editor value.');
    update_field($field_key, '', 'option');
    waklert_seed_template_content();
    content_assert(waklert_content($option_key) === '', 'Seeder overwrote an intentional clear.');
} finally {
    if ($saved === null) {
        delete_field($field_key, 'option');
    } else {
        update_field($field_key, $saved, 'option');
    }
}
echo "Repeated seeding preserves edits and clears. All temporary edits restored.\n";

// An existing cleared value must stay cleared after the module moves to another row.
$markers = get_option('waklert_template_content_seeded', []);
$fixture = wp_insert_post(['post_type' => 'page', 'post_status' => 'draft', 'post_title' => 'Temporary content integration fixture'], true);
content_assert(!is_wp_error($fixture), 'Could not create a local test fixture.');
try {
    $module_field_name = $entry['field_name'] ?? ('wc_' . $module_key);
    $module_field_key = $entry['field_key'] ?? ('field_wc_' . $module_key);
    $fixture_rows = [['acf_fc_layout' => 'rich_text'], ['acf_fc_layout' => $entry['module'], $module_field_key => 'Saved through ACF']];
    update_field('field_modules', $fixture_rows, $fixture);
    $saved_rows = get_field('modules', $fixture);
    content_assert(trim(wp_strip_all_tags((string) ($saved_rows[1][$module_field_name] ?? ''))) === 'Saved through ACF', 'ACF flexible-content save lost the content field.');
    content_assert(get_post_meta($fixture, 'modules_1_' . $module_field_name, true) === 'Saved through ACF', 'ACF flexible-content storage changed the raw editor value.');
    $fixture_rows[1][$module_field_key] = '';
    $fixture_rows = array_reverse($fixture_rows);
    update_field('field_modules', $fixture_rows, $fixture);
    $meta_name = 'modules_0_' . $module_field_name;
    waklert_seed_template_content();
    content_assert(get_post_meta($fixture, $meta_name, true) === '', 'Moving a cleared module refilled its field.');
} finally {
    wp_delete_post($fixture, true);
    update_option('waklert_template_content_seeded', $markers, false);
}
echo "ACF flexible-content saves and module reordering preserve values; local fixture removed.\n";

// Render customer templates using an unsaved order; fail before any mail could be sent.
$block_mail = function() { throw new RuntimeException('A rendering check attempted to send mail.'); };
add_filter('pre_wp_mail', $block_mail, PHP_INT_MAX);
$order = new WC_Order();
$order->set_payment_method('bacs');
$order->set_date_created(time());
$order->set_total('123.00');
$copy_name = 'bank_copy_label';
$copy_saved = get_option('options_' . $copy_name);
$receipt_saved = get_option('options_wc_manual_receipt_subject');
$notice_saved = get_option('options_checkout_receipt_notice');
$saved_hooks = [];
foreach (['woocommerce_before_thankyou', 'woocommerce_thankyou_bacs', 'woocommerce_thankyou'] as $hook_name) {
    $saved_hooks[$hook_name] = isset($GLOBALS['wp_filter'][$hook_name]) ? clone $GLOBALS['wp_filter'][$hook_name] : null;
    remove_all_actions($hook_name);
}
function render_content_template($template, $arguments): string {
    $level = ob_get_level();
    ob_start();
    try {
        wc_get_template($template, $arguments);
        return (string) ob_get_contents();
    } finally {
        while (ob_get_level() > $level) { ob_end_clean(); }
    }
}
try {
    update_field('field_ty_bank_copy_label', 'Copy integration check', 'option');
    update_field('field_wc_manual_receipt_subject', 'Receipt integration check {order}', 'option');
    update_field('field_checkout_receipt_notice', '{email}', 'option');
    $html = render_content_template('checkout/thankyou.php', ['order' => $order]);
    content_assert(str_contains($html, 'Copy integration check'), 'Thank-you copy did not use the saved ACF value.');
    content_assert(str_contains($html, 'Receipt%20integration%20check'), 'Receipt subject did not use its saved ACF value.');
    $emails = WC()->mailer()->get_emails();
    $email_html = render_content_template('emails/customer-processing-order.php', ['order' => $order, 'sent_to_admin' => false, 'plain_text' => false, 'email_heading' => 'Rendering check', 'additional_content' => '', 'email' => $emails['WC_Email_Customer_Processing_Order']]);
    content_assert(str_contains($email_html, '<html'), 'Customer email did not render.');
} finally {
    update_field('field_ty_bank_copy_label', $copy_saved, 'option');
    update_field('field_wc_manual_receipt_subject', $receipt_saved, 'option');
    update_field('field_checkout_receipt_notice', $notice_saved, 'option');
    remove_filter('pre_wp_mail', $block_mail, PHP_INT_MAX);
    foreach ($saved_hooks as $hook_name => $hook) {
        if ($hook === null) { unset($GLOBALS['wp_filter'][$hook_name]); }
        else { $GLOBALS['wp_filter'][$hook_name] = $hook; }
    }
}
echo "Thank-you, receipt-message and customer email rendering verified without saving an order or sending mail.\n";
