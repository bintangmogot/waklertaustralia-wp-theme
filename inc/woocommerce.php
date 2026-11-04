<?php
/**
 * WooCommerce Customizations (WhatsApp Checkout)
 */

if (!class_exists('WooCommerce')) {
    return;
}

// Force Classic Checkout & Cart (WooCommerce 10.x defaults to Block-based, which breaks our custom templates)
add_filter( 'woocommerce_should_load_cart_checkout_blocks_frontend', '__return_false' );
add_filter( 'wc_use_checkout_block', '__return_false' );
add_filter( 'wc_use_cart_block', '__return_false' );

// 1. Remove standard Add to Cart buttons & single product metadata (categories, tags)
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

// Disable product category lists display across product templates
add_filter('wc_get_product_category_list', '__return_empty_string');

// Set maximum products per page to 16
add_filter('loop_shop_per_page', function($cols) {
    return 16;
}, 20);

// 2. Add Custom "Buy via WhatsApp" button on Single Product
add_action('woocommerce_single_product_summary', 'modmy_whatsapp_buy_button', 30);
function modmy_whatsapp_buy_button() {
    global $product;
    if (!$product) return;
    
    $whatsapp_number = function_exists('get_field') ? get_field('whatsapp_number', 'option') : '';
    if (!$whatsapp_number) {
        return;
    }
    $whatsapp_base = function_exists('waklert_format_whatsapp_url') ? waklert_format_whatsapp_url($whatsapp_number) : '';
    if (!$whatsapp_base) {
        return;
    }

    $message = strtr(waklert_content('com_product_whatsapp_message'), [
        '{site}'    => get_bloginfo('name'),
        '{product}' => $product->get_name(),
    ]);
    $url = $whatsapp_base . "?text=" . urlencode($message);

    $btn_text = waklert_content('com_product_whatsapp_button');

    echo '<div class="mt-8">';
    echo '<a href="' . esc_url($url) . '" target="_blank" rel="noopener noreferrer" class="flex w-full items-center justify-center gap-2 rounded-full bg-primary px-8 py-4 text-base font-bold text-primary-foreground shadow-pill transition-colors hover:bg-primary-dark sm:w-auto">';
    echo waklert_content_icon('com_whatsapp_icon');
    echo esc_html($btn_text);
    echo '</a>';
    echo '<p class="mt-3 text-center text-xs text-muted-foreground">' . esc_html(waklert_content('com_product_whatsapp_note')) . '</p>';
    echo '</div>';
}

// 3. Remove unnecessary WooCommerce Elements
add_action('wp', 'modmy_remove_wc_elements');
function modmy_remove_wc_elements() {
    // Remove breadcrumbs
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    // Remove sidebar
    remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
    // Remove sorting and result count
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    // Remove related products (we'll add our own if needed)
    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
}

// 4. Disable Cart & Checkout pages redirect (Commented out to allow side cart checkout)
// add_action('template_redirect', 'modmy_redirect_cart_checkout');
// function modmy_redirect_cart_checkout() {
//     }
// }

/**
 * Force hide the WooCommerce coupon section on the checkout page & side cart using CSS
 */
add_action('wp_head', 'modmy_hide_checkout_coupon_css_override', 999);
function modmy_hide_checkout_coupon_css_override() {
    echo '<style>
        .woocommerce-form-coupon-toggle,
        form.checkout_coupon,
        .woocommerce-form-coupon,
        .xoo-wsc-coupon,
        .xoo-wsc-sm-coupon { display: none !important; }
    </style>';
}

/**
 * Remove 'QRIS' text from Add to Cart / Checkout buttons dynamically
 */
add_action('wp_footer', 'modmy_remove_qris_text_js', 9999);
function modmy_remove_qris_text_js() {
?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Bulletproof text replacer (preserves events and HTML)
        var removeQris = function(node) {
            if (node.nodeType === 3) { // Text node
                if (node.nodeValue && node.nodeValue.includes('QRIS')) {
                    node.nodeValue = node.nodeValue.replace(/\s*\(QRIS\)/g, '').replace(/\s*QRIS/g, '');
                }
            } else if (node.nodeType === 1 && node.nodeName !== 'SCRIPT' && node.nodeName !== 'STYLE') {
                node.childNodes.forEach(removeQris);
            }
        };
        
        // 2. Hide side cart coupon via JS as fallback
        var hideCoupons = function() {
            var coupons = document.querySelectorAll('.xoo-wsc-coupon, .woocommerce-form-coupon, form.checkout_coupon, .woocommerce-form-coupon-toggle, .xoo-wsc-sm-coupon, [data-id="coupon"]');
            coupons.forEach(function(el) {
                el.style.setProperty('display', 'none', 'important');
            });
        };
        
        var runAllFixes = function() {
            removeQris(document.body);
            hideCoupons();
        };
        
        runAllFixes();
        
        // Aggressively check for 3 seconds to catch delayed plugin injections
        var interval = setInterval(runAllFixes, 500);
        setTimeout(function() { clearInterval(interval); }, 3000);
        
        if (typeof jQuery !== 'undefined') {
            jQuery(document).on('found_variation updated_wc_div wc_fragments_refreshed wc_fragments_loaded', runAllFixes);
        }
    });
    </script>
<?php
}

/**
 * Make Phone Number Mandatory on Checkout
 */
add_filter('woocommerce_billing_fields', 'modmy_make_phone_mandatory', 9999);
function modmy_make_phone_mandatory($fields) {
    if (isset($fields['billing_phone'])) {
        $fields['billing_phone']['required'] = true;
    }
    return $fields;
}

add_filter('woocommerce_checkout_fields', 'modmy_make_phone_mandatory_checkout', 9999);
function modmy_make_phone_mandatory_checkout($fields) {
    if (isset($fields['billing']['billing_phone'])) {
        $fields['billing']['billing_phone']['required'] = true;
    }
    return $fields;
}

add_filter('woocommerce_form_field_args', 'waklert_require_billing_phone_field_args', PHP_INT_MAX, 3);
function waklert_require_billing_phone_field_args($args, $key, $value) {
    if ('billing_phone' === $key) {
        $args['required'] = true;
        $args['label'] = waklert_content('com_checkout_phone_label');
        $args['class'] = array_values(array_unique(array_merge((array) ($args['class'] ?? array()), array('validate-required'))));
    }

    return $args;
}

/** Keep the phone field visibly required when the field-editor plugin renders its markup. */
function waklert_require_billing_phone_markup($field, $key, $args, $value) {
    if ('billing_phone' !== $key) {
        return $field;
    }

    $required_marker = '&nbsp;<abbr class="required" title="' . esc_attr__('required', 'woocommerce') . '">*</abbr>';
    $field = preg_replace('/(?:&nbsp;|\s)*<span class="optional">\s*\([^<]*\)\s*<\/span>/i', $required_marker, $field);

    return preg_replace_callback('/<input\b[^>]*>/i', static function ($matches) {
        $input = $matches[0];
        if (!preg_match('/\srequired(?:\s|=|>)/i', $input)) {
            $input = preg_replace('/\s*\/?>(?=\s*$)/', ' required="required" aria-required="true"$0', $input, 1);
        }
        return $input;
    }, $field, 1);
}
foreach (array('tel', 'text') as $phone_field_type) {
    add_filter('woocommerce_form_field_' . $phone_field_type, 'waklert_require_billing_phone_markup', PHP_INT_MAX, 4);
}

/** Keep the required indicator and native validation after checkout fragments refresh. */
function waklert_require_billing_phone_ui() {
    if (!is_checkout() || is_order_received_page()) {
        return;
    }
    ?>
    <script>
    (() => {
        const enforceRequiredPhone = () => {
            const field = document.querySelector('#billing_phone_field');
            const input = field?.querySelector('#billing_phone');
            const label = field?.querySelector('label');
            if (!field || !input || !label) return;

            input.required = true;
            input.setAttribute('aria-required', 'true');
            field.classList.add('validate-required');
            label.querySelector('.optional')?.remove();
            if (!label.querySelector('.required')) {
                const marker = document.createElement('abbr');
                marker.className = 'required';
                marker.title = <?php echo wp_json_encode(waklert_content('com_checkout_required_label')); ?>;
                marker.textContent = '*';
                label.append(document.createTextNode(' '), marker);
            }
        };

        enforceRequiredPhone();
        if (window.jQuery) {
            jQuery(document.body).on('updated_checkout', enforceRequiredPhone);
        }
        new MutationObserver(enforceRequiredPhone).observe(document.body, { childList: true, subtree: true });
    })();
    </script>
    <?php
}
add_action('wp_footer', 'waklert_require_billing_phone_ui', 99);

/** Reject a missing phone number even when a checkout field extension skips core validation. */
function waklert_validate_billing_phone_required($data, $errors) {
    if (empty($data['billing_phone']) && $errors instanceof WP_Error) {
        $errors->add('billing_phone_required', waklert_content('com_checkout_phone_required_error'));
    }
}
add_action('woocommerce_after_checkout_validation', 'waklert_validate_billing_phone_required', PHP_INT_MAX, 2);

add_filter('woocommerce_product_single_add_to_cart_text', 'modmy_remove_qris_from_button', 9999);
add_filter('woocommerce_product_add_to_cart_text', 'modmy_remove_qris_from_button', 9999);
add_filter('woocommerce_order_button_text', 'modmy_remove_qris_from_button', 9999);
function modmy_remove_qris_from_button($label) {
    // Remove any occurrence of "QRIS" (with optional surrounding spaces and parentheses)
    return preg_replace('/\s*\(?\s*QRIS\s*\)?/i', '', $label);
}

/**
 * Ensure BACS payment description and instructions always use Australian Post
 * and match Armodafinil Direct format.
 */
add_filter('woocommerce_gateway_description', function($description, $gateway_id) {
    if ($gateway_id === 'bacs') {
        return '<p>' . esc_html(waklert_content('com_bacs_gateway_description')) . '</p>';
    }
    return $description;
}, 99, 2);

/**
 * Completely suppress redundant core BACS instructions in emails & thank-you pages
 * so that only the modern custom on-hold email copy and custom BACS card are used.
 */
add_filter('option_woocommerce_bacs_settings', function($value) {
    if (is_array($value)) {
        $value['instructions'] = '';
    }
    return $value;
}, 9999);

add_filter('woocommerce_bacs_instructions', '__return_empty_string', 9999, 2);

add_action('woocommerce_init', function() {
    if (function_exists('WC') && WC()->payment_gateways()) {
        $gateways = WC()->payment_gateways()->payment_gateways();
        if (isset($gateways['bacs'])) {
            $gateways['bacs']->instructions = '';
        }
    }
}, 999);

add_action('woocommerce_email_before_order_table', function($order, $sent_to_admin, $plain_text = false) {
    if (function_exists('WC') && WC()->payment_gateways()) {
        $gateways = WC()->payment_gateways()->payment_gateways();
        if (isset($gateways['bacs'])) {
            $gateways['bacs']->instructions = '';
        }
    }
}, 1, 3);

/**
 * Global mail filter: Ensure Modafinil and "one step closer" rogue BACS text
 * never reaches any sent customer email.
 */
add_filter('wp_mail', function($args) {
    if (isset($args['message'])) {
        $args['message'] = preg_replace('/<p[^>]*>[^<]*one step closer[^<]*<\/p>\s*/is', '', $args['message']);
        $args['message'] = preg_replace('/<p[^>]*>[^<]*nearly complete.*?Modafinil[^<]*<\/p>\s*/is', '', $args['message']);
        $args['message'] = preg_replace('/Your order is nearly complete and your one step closer[^\r\n]*/i', '', $args['message']);
    }
    return $args;
}, 9999);

/**
 * Output PayID details directly under BACS bank details in customer order emails
 */
add_action('woocommerce_email_before_order_table', function($order, $sent_to_admin, $plain_text = false) {
    if (!$order || $sent_to_admin) {
        return;
    }
    if ($order->get_payment_method() !== 'bacs') {
        return;
    }
    $payid_number = function_exists('waklert_option_text') ? waklert_option_text('payid_number') : '';
    if ($payid_number === '') {
        return;
    }
    $payid_label = waklert_content('com_payid_label');
    if ($plain_text) {
        echo "\n" . wp_strip_all_tags($payid_label) . ': ' . $payid_number . "\n\n";
    } else {
        echo '<p class="bacs-payid-email" style="color: #dc2626 !important; font-weight: 700 !important; font-size: 16px !important; margin: 16px 0 24px 0 !important; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif;">' . esc_html($payid_label) . ': ' . esc_html($payid_number) . '</p>';
    }
}, 11, 3);

require_once __DIR__ . '/cart-shipping-insurance.php';
