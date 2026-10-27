<?php
/**
 * Customer on-hold order email - Waklert Australia Design
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 10.4.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<p style="font-size: 16px; font-weight: 700; color: #0C4161; margin-bottom: 12px;">
<?php
if ( ! empty( $order->get_billing_first_name() ) ) {
	printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) );
} else {
	printf( esc_html__( 'Hi there,', 'woocommerce' ) );
}
?>
</p>

<p style="margin-bottom: 16px; color: #334155;">
	Thank you for your order! We have received your order <strong style="color: #0C4161;">#<?php echo esc_html( $order->get_order_number() ); ?></strong> and reserved your items. 
	<?php if ( $order->get_payment_method() === 'bacs' ) : ?>
		Please find our official bank transfer details below to complete your payment for <strong>same-day Australia Post Express dispatch</strong>.
	<?php else : ?>
		Your order is currently awaiting payment confirmation.
	<?php endif; ?>
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
	echo '<div style="margin-top: 24px; padding: 16px; background-color: #F8FAFC; border-radius: 12px; border: 1px solid #E2E8F0;">';
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
	echo '</div>';
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
