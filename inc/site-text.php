<?php
/**
 * Site Text: small labels and messages that used to be hardcoded in templates.
 * Edit in WP Admin -> Theme Settings -> Site Text. The defaults below are used only if a field is empty.
 */

function waklert_text_defaults() {
    return [
        "header_support_badge" => "Support Desk",
        "header_support_heading" => "Need a hand?",
        "header_support_text" => "Find clear information about products, ordering and express Australia delivery.",
        "header_support_link_text" => "Visit the FAQs",
        "header_support_link_url" => "/faq/",
        "footer_disclaimer_label" => "Medical Website Disclaimer:",
        "footer_whatsapp_label" => "WhatsApp",
        "footer_chat_label" => "Chat Live",
        "footer_working_days_label" => "Working Days:",
        "footer_office_hours_label" => "Office Hours:",
        "reviews_badge" => "Verified reviews",
        "reviews_title" => "What our customers say",
        "reviews_subtitle" => "Real experiences from verified buyers",
        "reviews_rating_label" => "Customer rating",
        "reviews_empty_text" => "No reviews yet. Be the first to review this product.",
        "reviews_form_heading" => "Write a Review",
        "reviews_required_note" => "All fields are required.",
        "reviews_submit_label" => "Submit Review",
        "reviews_moderation_note" => "Moderated before publishing",
        "comparison_badge" => "Product comparison",
        "comparison_title" => "Compare our products",
        "comparison_text" => "Compare listed product details, pack sizes and current prices. Prices and availability come from the product listings.",
        "comparison_view_packs" => "View pack sizes and prices",
        "comparison_view_options" => "View product options",
        "comparison_unavailable" => "Pack sizes and prices are currently unavailable.",
        "comparison_empty" => "No products are currently available to compare.",
        "comparison_disclaimer" => "Product information is for comparison only. Speak with a qualified health professional about medicine selection.",
        "thankyou_heading_named" => "Congratulations, {name}!",
        "thankyou_heading" => "Thank You for Your Order!",
        "thankyou_order_number_label" => "Order Number",
        "thankyou_payment_method_label" => "Payment Method",
        "thankyou_confirmation_label" => "Confirmation sent to:",
        "thankyou_invoice_label" => "Tax Invoice Generated",
        "thankyou_account_name_label" => "Account Name",
        "thankyou_account_number_label" => "Account Number",
        "thankyou_email_note" => "Your order confirmation & tax invoice have been dispatched to your email",
    ];
}

function waklert_text($name) {
    $defaults = waklert_text_defaults();
    $value = function_exists('get_field') ? get_field($name, 'option') : '';
    $value = is_string($value) ? trim($value) : '';
    return $value !== '' ? $value : ($defaults[$name] ?? '');
}

function waklert_text_url($name) {
    $value = waklert_text($name);
    return preg_match('#^https?://#i', $value) ? $value : home_url('/' . ltrim($value, '/'));
}

/** Copy the defaults into the saved options once, so every Site Text field is already filled in WP Admin. */
add_action('acf/init', function() {
    $target_ver = '20261102_site_text_v1';
    if (get_option('waklert_site_text_seed_ver') === $target_ver) {
        return;
    }
    foreach (waklert_text_defaults() as $name => $default) {
        if (get_option('options_' . $name, null) === null) {
            update_option('options_' . $name, $default);
            update_option('_options_' . $name, 'field_st_' . $name);
        }
    }
    update_option('waklert_site_text_seed_ver', $target_ver);
}, 35);
