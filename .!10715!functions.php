<?php
/**
 * Modafinil Malaysia — Theme Functions
 */

// Define constants for easy reference
define('MODMY_THEME_VERSION', '1.0.0');
define('MODMY_THEME_DIR', get_stylesheet_directory());
define('MODMY_THEME_URI', get_stylesheet_directory_uri());

// 1. Language system
require_once MODMY_THEME_DIR . '/inc/i18n.php';

// 2. Theme setup (menus, supports, image sizes)
require_once MODMY_THEME_DIR . '/inc/theme-setup.php';

// 3. Asset enqueues (CSS, JS)
require_once MODMY_THEME_DIR . '/inc/enqueue.php';

// 4. ACF Theme Options (Global settings)
require_once MODMY_THEME_DIR . '/inc/theme-options.php';

// 5. Shortcodes
require_once MODMY_THEME_DIR . '/inc/shortcodes.php';

// 6. WooCommerce customizations
require_once MODMY_THEME_DIR . '/inc/woocommerce.php';

// Custom Dynamic QRIS Gateway
if ( class_exists( 'WooCommerce' ) ) {
    require_once MODMY_THEME_DIR . '/inc/class-wc-gateway-dynamic-qris.php';
}
add_filter( 'woocommerce_payment_gateways', function( $gateways ) {
    $gateways[] = 'WC_Gateway_Dynamic_QRIS';
    return $gateways;
});

// 7. Custom Post Types
require_once MODMY_THEME_DIR . '/inc/post-types.php';


// 7. ACF Fallbacks (prevents fatal errors if ACF is not active)
if (!function_exists('get_field')) {
    function get_field($selector, $post_id = false, $format_value = true) { return false; }
}
if (!function_exists('get_sub_field')) {
    function get_sub_field($selector, $format_value = true) { return false; }
}
if (!function_exists('have_rows')) {
    function have_rows($selector, $post_id = false) { return false; }
}
if (!function_exists('the_row')) {
    function the_row() { return false; }
}

// 9. Enable SVG Uploads in Media Library
add_filter('upload_mimes', function($mimes) {
    if (current_user_can('manage_options')) {
        $mimes['svg'] = 'image/svg+xml';
    }
    return $mimes;
});

// 10. Force precise Homepage Title
add_filter('document_title_parts', function($title) {
    if (is_front_page()) {
        $title['title'] = get_bloginfo('name');
        $title['tagline'] = get_bloginfo('description');
        unset($title['site']);
    }
    return $title;
});
add_filter('document_title_separator', function($sep) {
    if (is_front_page()) { return '|'; }
    return $sep;
});

// 11. Custom Gravity Forms submit button markup with envelope icon
add_filter('gform_submit_button', function($button, $form) {
    if ($form['id'] == 1) {
        $btn_text = function_exists('modmy_t') ? "Send Message" : "Send Message";
        return sprintf(
            '<button type="submit" id="gform_submit_button_%d" class="button gform_button flex items-center justify-center gap-2 w-full md:w-auto">
                <span>%s</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </button>',
            $form['id'],
            esc_html($btn_text)
        );
    }
    return $button;
}, 10, 2);
add_action( "woocommerce_thankyou", "modafinil_add_shipping_note_thankyou", 5 );
function modafinil_add_shipping_note_thankyou( $order_id ) {
    ?>
    <div class="shipping-notice-thankyou mt-8 mb-8 p-6 bg-blue-50 border-l-4 border-blue-500 rounded">
        <h3 class="text-blue-700 font-bold mb-2">Note</h3>
        <p class="text-blue-700">The average shipping time is 10 - 15 days. Please note that delivery may take up to 30 days from the date of dispatch due to potential disruptions in postal services caused by weather issues or natural disaster.</p>
    </div>
    <?php
}


add_action("wp_head", function() {
    if (function_exists("is_checkout") && is_checkout()) {
        echo "<style>
            .woocommerce-terms-and-conditions-checkbox-text a {
                color: #2563eb !important;
                text-decoration: underline !important;
                font-weight: 600;
            }
            .woocommerce-terms-and-conditions-checkbox-text a:hover {
                color: #1d4ed8 !important;
            }
            .woocommerce-privacy-policy-text a {
                color: #2563eb !important;
                text-decoration: underline !important;
                font-weight: 600;
            }
            .woocommerce-privacy-policy-text a:hover {
                color: #1d4ed8 !important;
            }
        </style>";
    }
});


if( function_exists("acf_add_local_field_group") ):
    acf_add_local_field_group(array(
        "key" => "group_review_linked_product",
        "title" => "Additional Review Settings",
        "fields" => array(
            array(
                "key" => "field_review_linked_product",
                "label" => "Linked Product",
                "name" => "linked_product",
                "type" => "post_object",
                "instructions" => "Select a product if this is a Product Review. Leave empty for General Reviews.",
                "required" => 0,
                "post_type" => array(
                    0 => "product",
                ),
                "taxonomy" => "",
                "allow_null" => 1,
                "multiple" => 0,
                "return_format" => "id",
                "ui" => 1,
            ),
            ),
        "location" => array(
            array(
                array(
                    "param" => "post_type",
                    "operator" => "==",
                    "value" => "review",
                ),
            ),
        ),
        "menu_order" => 0,
        "position" => "side",
        "style" => "default",
        "label_placement" => "top",
        "instruction_placement" => "label",
        "hide_on_screen" => "",
        "active" => true,
        "description" => "",
    ));
endif;


// Add Custom Columns to Review CPT
add_filter("manage_review_posts_columns", function($columns) {

    $columns["linked_product"] = "Linked Product";
    return $columns;
});

// Populate Custom Columns
add_action("manage_review_posts_custom_column", function($column, $post_id) {
    if ($column === "review_category") {
        $terms = get_the_terms($post_id, "review_category");
        if ($terms && !is_wp_error($terms)) {
            $term_names = array_map(function($term) { return $term->name; }, $terms);
            echo implode(", ", $term_names);
        } else {
