<?php
/**
 * Customer on-hold order email
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 10.4.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email );

$customer_first_name = $order->get_billing_first_name() ?: 'there';

$intro_copy = function_exists( 'get_field' ) ? get_field( 'email_on_hold_intro', 'option' ) : '';
if ( empty( $intro_copy ) ) {
    $intro_copy = "We've received your order and it's currently on hold until we can confirm your payment has been processed.";
}

$instruction_copy = function_exists( 'get_field' ) ? get_field( 'email_on_hold_instruction', 'option' ) : '';
if ( empty( $instruction_copy ) ) {
    $instruction_copy = 'Please complete your payment using EFT or PayID below with your order number and we will send the product immediately and also send you an Australian Post tracking number.';
}

$warning_copy = function_exists( 'get_field' ) ? get_field( 'email_on_hold_warning', 'option' ) : '';
if ( empty( $warning_copy ) ) {
    $warning_copy = 'Please DO NOT mention WAKLERT or Armodafinil on your bank transfer description.';
}
?>

<p style="margin: 0 0 16px 0; font-size: 15px; line-height: 1.6; color: #0F172A; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $customer_first_name ) ); ?></p>

<p style="margin: 0 0 16px 0; font-size: 15px; line-height: 1.6; color: #0F172A; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><?php echo esc_html( $intro_copy ); ?></p>

<p style="margin: 0 0 16px 0; font-size: 15px; line-height: 1.6; color: #0F172A; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;"><?php echo esc_html( $instruction_copy ); ?></p>

<p style="margin: 0 0 24px 0; font-size: 15px; line-height: 1.6; color: #DC2626; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <?php
    $formatted_warning = esc_html( $warning_copy );
    $formatted_warning = str_ireplace( 'DO NOT', '<strong style="color: #DC2626; font-weight: 800;">DO NOT</strong>', $formatted_warning );
    $formatted_warning = str_ireplace( 'WAKLERT', '<strong style="color: #0C4161; font-weight: 800;">WAKLERT</strong>', $formatted_warning );
    $formatted_warning = str_ireplace( 'Armodafinil', '<strong style="color: #0C4161; font-weight: 800;">Armodafinil</strong>', $formatted_warning );
    echo $formatted_warning;
    ?>
</p>

<?php
/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
