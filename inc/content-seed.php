<?php
/**
 * Content seed: puts the default text of the page modules into WP Admin as real field values
 * (Pages -> Modules -> ...), so what visitors read is what the client can edit.
 *
 * Runs once per environment. Bump WAKLERT_CONTENT_SEED_VERSION whenever the defaults change.
 * Only empty fields are filled; anything already written in the admin is never touched.
 * The same defaults are the safety net the module templates fall back to.
 */

const WAKLERT_CONTENT_SEED_VERSION = '20261103_content_seed_v4';

/**
 * Default text per module layout.
 * 'fields'    => field name => [ACF field key, value]
 * 'repeaters' => repeater name => key, 'check' (sub field that must be filled for the repeater to count as written),
 *                'subs' (sub field name => key), 'rows', optional 'unless' (other fields that already cover the content)
 */
function waklert_module_defaults() {
    static $defaults = null;
    if ($defaults !== null) {
        return $defaults;
    }

    $defaults = [
        'hero_section' => [
            'fields' => [
                'location_text'       => ['field_hero_loc_en', 'Australia-wide delivery'],
                'heading'             => ['field_hero_heading_en', 'Waklert in Australia, delivered on-time & hassle-free.'],
                'subtitle'            => ['field_hero_sub_en', 'Waklert Australia — Generic Armodafinil'],
                'description'         => ['field_hero_desc_en', 'Waklert Australia supplies genuine, high-grade Armodafinil, including Sun Pharma’s Waklert 150mg and 50mg, without the standard pharmacy markups. Every order is packed discreetly and shipped with full Australia Post tracking to Sydney, Melbourne, Brisbane, Perth, Adelaide, and regional towns nationwide, with quick AUD checkout via PayID and direct EFT.'],
                'primary_button_text' => ['field_hero_btn1_en', 'View Products'],
            ],
            'repeaters' => [
                'feature_badges' => [
                    'key'   => 'field_hero_badges',
                    'check' => 'title',
                    'subs'  => ['title' => 'field_hero_badge_title', 'subtitle' => 'field_hero_badge_sub', 'icon' => 'field_hero_badge_icon'],
                    'rows'  => [
                        ['title' => 'Express Delivery', 'subtitle' => 'Domestic AU Post', 'icon' => 'truck'],
                        ['title' => 'Genuine Quality', 'subtitle' => 'Sun Pharma Grade', 'icon' => 'shield'],
                        ['title' => 'Discreet Packaging', 'subtitle' => '100% Privacy', 'icon' => 'lock'],
                    ],
                ],
            ],
        ],
        'featured_products' => [
            'fields' => [
                'subheading'  => ['field_fp_tag_en', 'MOST POPULAR in 2026'],
                'title'       => ['field_fp_title_en', 'Armodafinil Products'],
                'description' => ['field_fp_desc', 'Genuine Sun Pharma and HAB Pharma Armodafinil tablets shipped domestically across Australia.'],
                'button_text' => ['field_fp_button_text', 'View All Products'],
                'button_url'  => ['field_fp_button_url', '/shop/'],
            ],
        ],
        'how_to_order' => [
            'fields' => [
                'tag'         => ['field_hto_tag_en', 'Simple Process'],
                'heading'     => ['field_hto_heading_en', 'Three Steps from Product Information to Delivery'],
                'description' => ['field_hto_desc_en', 'Simple, transparent, and private. Ordering Armodafinil across Australia takes just 3 straightforward steps.'],
                'step_label'  => ['field_hto_step_label', 'STEP'],
            ],
            'repeaters' => [
                'steps' => [
                    'key'   => 'field_hto_steps',
                    'check' => 'title',
                    'subs'  => ['title' => 'field_hto_s_t_en', 'desc' => 'field_hto_s_d_en', 'icon_preset' => 'field_hto_s_icon_preset'],
                    'rows'  => [
                        ['title' => 'Review the Range', 'desc' => 'Compare available armodafinil brands, strengths and pack sizes. Read the product information before making a selection.', 'icon_preset' => 'browse_catalogue'],
                        ['title' => 'Confirm Your Order', 'desc' => 'Choose an available payment method at checkout. Order details are handled through the secure checkout process.', 'icon_preset' => 'aud_checkout'],
                        ['title' => 'Track Delivery', 'desc' => 'When an order is dispatched, Australia Post tracking details are provided so you can follow its progress.', 'icon_preset' => 'express_shipping'],
                    ],
                ],
            ],
        ],
        'why_choose_us' => [
            'fields' => [
                'heading'     => ['field_wcu_heading_en', 'Why Buy Armodafinil from Waklert Australia?'],
                'description' => ['field_wcu_desc_en', 'At Waklert Australia, we pride ourselves on providing a quick, reliable, and affordable service for all your Armodafinil needs. Here’s why you should choose us:'],
            ],
            'repeaters' => [
                'audiences' => [
                    'key'   => 'field_wcu_audiences',
                    'check' => 'title',
                    'subs'  => ['title' => 'field_wcu_a_title_en', 'desc' => 'field_wcu_a_desc_en', 'icon_preset' => 'field_wcu_a_icon_preset'],
                    'rows'  => [
                        ['title' => 'If it doesn’t land, we fix it', 'desc' => 'Every order ships with Australia Post tracking. If a parcel stalls or goes missing in transit, we reship it free of charge or issue a full refund.', 'icon_preset' => 'parcel_guarantee'],
                        ['title' => 'Real people on chat', 'desc' => 'Have a question before or after ordering? Reach our local support team via SMS, WhatsApp, or email 7 days a week for fast, practical answers.', 'icon_preset' => 'live_chat_support'],
                        ['title' => 'Straight up about what we sell - no candy coating', 'desc' => 'Armodafinil is a Schedule 4 prescription medicine in Australia. We provide clear batch details, strength guides, and transparent ordering information.', 'icon_preset' => 'medical_rx_clarity'],
                        ['title' => 'Simple AUD checkout', 'desc' => 'Pay securely in Australian Dollars (AUD) using local PayID or direct bank transfer — no hidden international conversion fees or complicated steps.', 'icon_preset' => 'aud_checkout'],
                    ],
                ],
            ],
        ],
        'city_section' => [
            'fields' => [
                'tag'         => ['field_cs_tag', 'SHIPPING NATIONWIDE'],
                'title'       => ['field_cs_title', 'Delivered Everywhere in Australia'],
                'description' => ['field_cs_desc', 'Metro cities, regional towns, or remote FIFO camps — we ship to your address.'],
            ],
            'repeaters' => [
                'cities_list' => [
                    'key'    => 'field_cs_cities_list',
                    'check'  => 'city_name',
                    'unless' => ['quick_cities'],
                    'subs'   => ['city_name' => 'field_cs_city_name', 'has_checkmark' => 'field_cs_has_checkmark'],
                    'rows'   => [
                        ['city_name' => 'Sydney', 'has_checkmark' => 1],
                        ['city_name' => 'Melbourne', 'has_checkmark' => 1],
                        ['city_name' => 'Adelaide', 'has_checkmark' => 1],
                        ['city_name' => 'Darwin', 'has_checkmark' => 1],
                        ['city_name' => 'Brisbane', 'has_checkmark' => 1],
                        ['city_name' => 'Gold Coast', 'has_checkmark' => 1],
                        ['city_name' => 'Hobart', 'has_checkmark' => 1],
                        ['city_name' => 'Canberra', 'has_checkmark' => 1],
                    ],
                ],
            ],
        ],
        'comparison' => [
            'fields' => [
                'tag'             => ['field_comp_tag_en', 'Know Before You Order'],
                'heading'         => ['field_comp_heading_en', 'Waklert vs Coffee vs Energy Drinks'],
                'description'     => ['field_comp_desc_en', 'See why thousands of Australian shift workers and professionals choose Waklert over high-sugar stimulants.'],
                'attribute_label' => ['field_comp_attr_label', 'Key Attribute'],
                'badge_label'     => ['field_comp_badge_label', '★ RECOMMENDED'],
                'product_label'   => ['field_comp_product_label', 'Waklert 150'],
                'coffee_label'    => ['field_comp_coffee_label', 'Coffee'],
                'energy_label'    => ['field_comp_energy_label', 'Energy Drinks'],
                'footer_note'     => ['field_comp_footer_note', 'Armodafinil offers sustained wakefulness without sugar crashes or high liquid intake.'],
                'footer_badge'    => ['field_comp_footer_badge', '100% Genuine Sun Pharma Batch Tested'],
            ],
            'repeaters' => [
                'rows' => [
                    'key'   => 'field_comp_rows',
                    'check' => 'feature',
                    'subs'  => ['feature' => 'field_comp_f_en', 'modafinil' => 'field_comp_m_en', 'coffee' => 'field_comp_c_en', 'energy' => 'field_comp_e_en'],
                    'rows'  => [
                        ['feature' => 'Effect Duration', 'modafinil' => '10-15 hours', 'coffee' => '2-4 hours', 'energy' => '1-3 hours'],
                        ['feature' => 'Crash Effect', 'modafinil' => 'Smooth / None', 'coffee' => 'Moderate dip', 'energy' => 'Severe crash'],
                        ['feature' => 'Focus Quality', 'modafinil' => 'Deep, calm focus', 'coffee' => 'Mild alertness', 'energy' => 'Jittery spikes'],
                        ['feature' => 'Habit Risk', 'modafinil' => 'Very low', 'coffee' => 'Moderate caffeine cycle', 'energy' => 'High sugar / caffeine'],
                        ['feature' => 'Sleep Disruption', 'modafinil' => 'Low (morning dose)', 'coffee' => 'Moderate', 'energy' => 'High'],
                        ['feature' => 'Cost per Day', 'modafinil' => '~AUD $3 - $5', 'coffee' => '~AUD $5 - $9', 'energy' => '~AUD $4 - $7'],
                    ],
                ],
            ],
        ],
        'trust_strip' => [
            'repeaters' => [
                'badges' => [
                    'key'   => 'field_ts_badges',
                    'check' => 'label',
                    'subs'  => ['label' => 'field_ts_label_en', 'desc' => 'field_ts_desc_en', 'icon_preset' => 'field_ts_icon_preset'],
                    'rows'  => [
                        ['label' => 'Australia-wide Delivery', 'desc' => 'Tracked delivery via Australia Post to all states and territories.', 'icon_preset' => 'australia_delivery'],
                        ['label' => 'Sealed Product Packaging', 'desc' => 'Direct batch-tested pharmaceuticals from accredited manufacturers.', 'icon_preset' => 'discreet_sealed'],
                        ['label' => 'Secure Local Checkout', 'desc' => 'Encrypted checkout with local PayID & Australian bank EFT.', 'icon_preset' => 'aud_checkout'],
                        ['label' => 'Discreet Packaging', 'desc' => 'Shipped in generic, unbranded satchels for complete privacy.', 'icon_preset' => 'po_box_delivery'],
                    ],
                ],
            ],
        ],
        'reviews_carousel' => [
            'fields' => [
                'badge'          => ['field_rc_badge', 'Customer Reviews'],
                'title'          => ['field_rc_title_en', 'What Australian Customers Say'],
                'description'    => ['field_rc_description', 'Real feedback from verified Australian buyers — shift workers, students, and professionals across the country.'],
                'button_text'    => ['field_rc_button_text', 'Read All Reviews'],
                'button_url'     => ['field_rc_button_url', '/reviews'],
                'verified_label' => ['field_rc_verified_label', '✓ Verified Buyer'],
            ],
        ],
        'faqs' => [
            'fields' => [
                'heading'   => ['field_faq_heading_en', 'Frequently Asked Questions'],
                'link_text' => ['field_faq_link_en', 'Full FAQ'],
                'link_url'  => ['field_faq_link_url', '/faq'],
            ],
        ],
        'blog_section' => [
            'fields' => [
                'eyebrow'           => ['field_blog_sec_eyebrow', 'Knowledge & Resources'],
                'title'             => ['field_blog_sec_title', 'Latest Articles & Guides'],
                'subtitle'          => ['field_blog_sec_subtitle', 'Helpful insights, dosage guides, and research on Armodafinil and cognitive performance.'],
                'button_text'       => ['field_blog_sec_button_text', 'View All Articles'],
                'read_more_label'   => ['field_blog_sec_read_more', 'Read Full Guide'],
                'read_time_label'   => ['field_blog_sec_read_time', 'min read'],
                'default_category'  => ['field_blog_sec_default_cat', 'Armodafinil Guide'],
                'placeholder_label' => ['field_blog_sec_placeholder', 'Waklert Knowledge'],
                'empty_text'        => ['field_blog_sec_empty', 'No articles published yet.'],
            ],
        ],
        'support_cta' => [
            'fields' => [
                'eyebrow'        => ['field_scta_eyebrow', 'Need Help?'],
                'title'          => ['field_scta_title', 'Talk to us via SMS or WhatsApp - 24/7.'],
                'desc'           => ['field_scta_desc', 'We are available all the time to handle any questions, offer advice or reassure you about your purchase.'],
                'chat_btn_text'  => ['field_scta_chat_text', 'Contact Support'],
                'sms_btn_text'   => ['field_scta_sms_text', 'SMS'],
                'email_btn_text' => ['field_scta_email_text', 'Email Support'],
            ],
        ],
    ];

    return $defaults;
}

/** Default text of the Theme Settings -> Shop Page tab: option name => [ACF field key, value]. */
function waklert_option_defaults() {
    return [
        'shop_card_button_text'        => ['field_shop_card_button_text', 'BUY NOW'],
        'shop_card_out_of_stock_label' => ['field_shop_card_out_of_stock', 'Out of Stock'],
        'shop_card_in_stock_label'     => ['field_shop_card_in_stock', 'In Stock'],
        'shop_card_read_more_label'    => ['field_shop_card_read_more', 'Read more'],
        'shop_card_unit_prefix'        => ['field_shop_card_unit_prefix', 'From'],
        'shop_card_unit_suffix'        => ['field_shop_card_unit_suffix', '/tab'],
        'shop_card_delivery_label'     => ['field_shop_card_delivery', 'AU Express'],
    ];
}

/** Theme Settings text, with the default as a safety net when the admin left it empty. */
function waklert_option_text($name) {
    $value = function_exists('get_field') ? trim((string) get_field($name, 'option')) : '';
    return $value !== '' ? $value : (waklert_option_defaults()[$name][1] ?? '');
}

/** Default value of one field, used by the templates as a safety net. */
function waklert_module_default($layout, $name) {
    return waklert_module_defaults()[$layout]['fields'][$name][1] ?? '';
}

/** Default rows of one repeater, as sub field name => value. */
function waklert_module_default_rows($layout, $name) {
    return waklert_module_defaults()[$layout]['repeaters'][$name]['rows'] ?? [];
}

/** Relative links typed in the admin (/shop/) become full links on this site. */
function waklert_resolve_link($url) {
    $url = trim((string) $url);
    if ($url === '' || preg_match('#^(https?:|mailto:|tel:|sms:|\#)#i', $url)) {
        return $url;
    }
    return home_url('/' . ltrim($url, '/'));
}

/** Description under a trust badge when the admin left it empty. */
function waklert_default_trust_badge_desc($label, $idx = 0) {
    $lower = strtolower(trim((string) $label));
    $rows  = waklert_module_default_rows('trust_strip', 'badges');

    if (str_contains($lower, 'focused') || str_contains($lower, 'category') || str_contains($lower, 'range')) {
        return 'Dedicated exclusively to genuine armodafinil tablets and verified pack sizes.';
    }
    if (str_contains($lower, 'checkout') && str_contains($lower, 'delivery')) {
        return 'Transparent shipping options, transit estimates, and Australia Post tracking at checkout.';
    }
    if (str_contains($lower, 'listing') || str_contains($lower, 'detail')) {
        return 'Clear active ingredient, strength, manufacturer, and pack options on every page.';
    }
    if (str_contains($lower, 'support') || str_contains($lower, 'question') || str_contains($lower, 'chat')) {
        return 'Direct Australian customer care via SMS, WhatsApp, and email 7 days a week.';
    }
    if (str_contains($lower, 'sealed')) {
        return 'Original factory-sealed blister packs from licensed pharmaceutical manufacturers.';
    }
    if (str_contains($lower, 'discreet')) {
        return 'Plain, unmarked satchels with no external branding for complete privacy.';
    }
    if (str_contains($lower, 'checkout') || str_contains($lower, 'payid') || str_contains($lower, 'secure')) {
        return 'Encrypted AUD checkout supporting local PayID and Australian bank transfer.';
    }
    if (str_contains($lower, 'australia') || str_contains($lower, 'delivery') || str_contains($lower, 'shipping')) {
        return 'Tracked delivery via Australia Post to metro, regional, and PO Box addresses.';
    }
    return $rows[$idx % max(1, count($rows))]['desc'] ?? '';
}

/** True when any row of this FAQs module already has a question typed in. */
function waklert_faq_module_has_content($post_id, $idx) {
    $count = (int) get_post_meta($post_id, "modules_{$idx}_faq_items", true);
    for ($r = 0; $r < $count; $r++) {
        if (trim((string) get_post_meta($post_id, "modules_{$idx}_faq_items_{$r}_question", true)) !== '') {
            return true;
        }
    }
    return false;
}

/** Removes every saved row (and its field references) of one repeater inside a module. */
function waklert_clear_repeater_rows($post_id, $idx, $name) {
    global $wpdb;

    $like = $wpdb->esc_like("modules_{$idx}_{$name}_") . '%';
    $wpdb->query($wpdb->prepare(
        "DELETE FROM {$wpdb->postmeta} WHERE post_id = %d AND (meta_key LIKE %s OR meta_key LIKE %s)",
        $post_id,
        $like,
        '\_' . $like
    ));
}

/** Writes the default FAQs into one FAQs module, replacing any empty rows left behind. */
function waklert_seed_faq_module($post_id, $idx) {
    waklert_clear_repeater_rows($post_id, $idx, 'faq_items');

    $items = waklert_default_faq_items();
    foreach ($items as $r => $row) {
        update_post_meta($post_id, "modules_{$idx}_faq_items_{$r}_question", $row['question']);
        update_post_meta($post_id, "_modules_{$idx}_faq_items_{$r}_question", 'field_faq_q_en');
        update_post_meta($post_id, "modules_{$idx}_faq_items_{$r}_answer", '<p>' . $row['answer'] . '</p>');
        update_post_meta($post_id, "_modules_{$idx}_faq_items_{$r}_answer", 'field_faq_a_en');
    }
    update_post_meta($post_id, "modules_{$idx}_faq_items", count($items));
    update_post_meta($post_id, "_modules_{$idx}_faq_items", 'field_faq_items');
}

function waklert_module_meta_filled($post_id, $meta_key) {
    return trim((string) get_post_meta($post_id, $meta_key, true)) !== '';
}

function waklert_repeater_has_content($post_id, $idx, $name, $check) {
    $count = (int) get_post_meta($post_id, "modules_{$idx}_{$name}", true);
    for ($r = 0; $r < $count; $r++) {
        if (waklert_module_meta_filled($post_id, "modules_{$idx}_{$name}_{$r}_{$check}")) {
            return true;
        }
    }
    return false;
}

function waklert_seed_repeater($post_id, $idx, $name, $repeater) {
    foreach ($repeater['unless'] ?? [] as $other) {
        if (waklert_module_meta_filled($post_id, "modules_{$idx}_{$other}")) {
            return;
        }
    }
    if (waklert_repeater_has_content($post_id, $idx, $name, $repeater['check'])) {
        return;
    }

    waklert_clear_repeater_rows($post_id, $idx, $name);
    foreach ($repeater['rows'] as $r => $row) {
        foreach ($repeater['subs'] as $sub => $sub_key) {
            update_post_meta($post_id, "modules_{$idx}_{$name}_{$r}_{$sub}", $row[$sub] ?? '');
            update_post_meta($post_id, "_modules_{$idx}_{$name}_{$r}_{$sub}", $sub_key);
        }
    }
    update_post_meta($post_id, "modules_{$idx}_{$name}", count($repeater['rows']));
    update_post_meta($post_id, "_modules_{$idx}_{$name}", $repeater['key']);
}

/** Trust badges written without a description show a generated one on the site; make that visible in the admin. */
function waklert_seed_trust_badge_descriptions($post_id, $idx) {
    $count = (int) get_post_meta($post_id, "modules_{$idx}_badges", true);
    for ($r = 0; $r < $count; $r++) {
        $label = (string) get_post_meta($post_id, "modules_{$idx}_badges_{$r}_label", true);
        if ($label === '' || waklert_module_meta_filled($post_id, "modules_{$idx}_badges_{$r}_desc")) {
            continue;
        }
        update_post_meta($post_id, "modules_{$idx}_badges_{$r}_desc", waklert_default_trust_badge_desc($label, $r));
        update_post_meta($post_id, "_modules_{$idx}_badges_{$r}_desc", 'field_ts_desc_en');
    }
}

/** Fills the empty fields and repeaters of one module with its defaults. */
function waklert_seed_module($post_id, $idx, $layout) {
    $defaults = waklert_module_defaults()[$layout] ?? null;
    if (!$defaults) {
        return;
    }

    foreach ($defaults['fields'] ?? [] as $name => [$field_key, $value]) {
        if (waklert_module_meta_filled($post_id, "modules_{$idx}_{$name}")) {
            continue;
        }
        update_post_meta($post_id, "modules_{$idx}_{$name}", $value);
        update_post_meta($post_id, "_modules_{$idx}_{$name}", $field_key);
    }
    foreach ($defaults['repeaters'] ?? [] as $name => $repeater) {
        waklert_seed_repeater($post_id, $idx, $name, $repeater);
    }
    if ($layout === 'trust_strip') {
        waklert_seed_trust_badge_descriptions($post_id, $idx);
    }
}

add_action('init', function() {
    if (get_option('waklert_content_seed_version') === WAKLERT_CONTENT_SEED_VERSION) {
        return;
    }

    $post_ids = get_posts([
        'post_type'      => 'any',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_key'       => 'modules',
    ]);
    foreach ($post_ids as $post_id) {
        $layouts = get_post_meta($post_id, 'modules', true);
        if (!is_array($layouts)) {
            continue;
        }
        foreach ($layouts as $idx => $layout_name) {
            if ($layout_name === 'faqs' && !waklert_faq_module_has_content($post_id, $idx)) {
                waklert_seed_faq_module($post_id, $idx);
            }
            waklert_seed_module($post_id, $idx, $layout_name);
        }
    }

    foreach (waklert_option_defaults() as $name => [$field_key, $value]) {
        if (trim((string) get_option('options_' . $name, '')) === '') {
            update_option('options_' . $name, $value);
            update_option('_options_' . $name, $field_key);
        }
    }

    update_option('waklert_content_seed_version', WAKLERT_CONTENT_SEED_VERSION);
    do_action('litespeed_purge_all');
}, 99);
