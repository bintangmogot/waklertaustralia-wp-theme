<?php
/**
 * Module: City Page (embed a full city page inside another page, e.g. the homepage)
 * Pulls every section from the chosen City entry (Australia Delivery), so the content
 * is still edited in one place: WP Admin -> Australia Delivery -> the city.
 */

if (waklert_module_is_empty()) { return; }
$city_id = (int) get_sub_field('city');
if (!$city_id) {
    return;
}

$delivery_fields = [];
foreach (['city_name', 'region', 'population', 'delivery_days', 'hero_desc', 'desc', 'features', 'reviews', 'carrier', 'shipping_note', 'packaging_note', 'tracking_note', 'hero_heading', 'reasons', 'faqs', 'selected_products', 'cta_heading', 'cta_desc', 'delivery_note', 'summary_heading', 'delivery_link_label', 'about_label', 'about_heading', 'features_heading', 'reasons_heading', 'products_label', 'products_heading', 'products_desc', 'faq_label', 'faq_heading', 'faq_link_label', 'shop_button_label', 'products_button_label', 'all_products_label', 'cta_button_label', 'trust_badges', 'facts_source', 'facts_date'] as $field) {
    $delivery_fields[$field] = get_field($field, $city_id);
}
if (trim((string) $delivery_fields['city_name']) === '') {
    $delivery_fields['city_name'] = get_the_title($city_id);
}

get_template_part('template-parts/australia-delivery', null, ['fields' => $delivery_fields, 'heading_tag' => 'h2']);
