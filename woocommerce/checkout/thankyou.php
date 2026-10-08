<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;

$contact_email = function_exists( 'get_field' ) ? get_field( 'contact_email', 'option' ) : '';
$contact_email = sanitize_email( $contact_email ?: 'orders@modafinil-australia.com' );
?>

<div class="woocommerce-order max-w-3xl mx-auto py-8 lg:py-12">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-destructive-soft text-destructive mb-6">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <h1 class="font-heading text-3xl font-extrabold text-foreground mb-4"><?php esc_html_e( 'Order Failed', 'woocommerce' ); ?></h1>
                <p class="text-muted-foreground mb-8"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>
                
                <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions flex justify-center gap-4">
                    <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay px-8 py-3 rounded-full bg-primary text-white font-bold hover:bg-primary-dark transition-colors"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay px-8 py-3 rounded-full border-2 border-primary text-primary font-bold hover:bg-primary-softer transition-colors"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
                    <?php endif; ?>
                </p>
            </div>

		<?php else : ?>

            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary-softer text-primary mb-6">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h1 class="font-heading text-4xl font-extrabold text-foreground mb-3"><?php esc_html_e( 'Thank You!', 'woocommerce' ); ?></h1>
                <p class="text-muted-foreground text-lg"><?php esc_html_e( 'Your order has been received and is now being processed.', 'woocommerce' ); ?></p>
            </div>

            <div class="bg-card border border-border rounded-2xl shadow-sm p-6 md:p-8 mb-10">
                <h2 class="font-heading text-xl font-bold text-foreground mb-6 pb-4 border-b border-border"><?php esc_html_e( 'Order Summary', 'woocommerce' ); ?></h2>
                
                <ul class="woocommerce-order-overview grid grid-cols-2 md:grid-cols-4 gap-6 mb-0 list-none p-0">

                    <li class="woocommerce-order-overview__order order flex flex-col gap-1">
                        <span class="text-sm text-muted-foreground"><?php esc_html_e( 'Order number', 'woocommerce' ); ?></span>
                        <strong class="text-foreground text-lg"><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                    </li>

                    <li class="woocommerce-order-overview__date date flex flex-col gap-1">
                        <span class="text-sm text-muted-foreground"><?php esc_html_e( 'Date', 'woocommerce' ); ?></span>
                        <strong class="text-foreground text-lg"><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                    </li>

                    <li class="woocommerce-order-overview__total total flex flex-col gap-1">
                        <span class="text-sm text-muted-foreground"><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
                        <strong class="text-primary text-lg"><?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                    </li>

                    <?php if ( $order->get_payment_method_title() ) : ?>
                        <li class="woocommerce-order-overview__payment-method method flex flex-col gap-1">
                            <span class="text-sm text-muted-foreground"><?php esc_html_e( 'Payment method', 'woocommerce' ); ?></span>
                            <strong class="text-foreground text-lg"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
                        </li>
                    <?php endif; ?>

                </ul>
                
                <?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) : ?>
                    <div class="mt-6 pt-4 border-t border-border flex flex-col gap-1">
                        <span class="text-sm text-muted-foreground"><?php esc_html_e( 'Email', 'woocommerce' ); ?></span>
                        <strong class="text-foreground"><?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
                    </div>
                <?php endif; ?>
            </div>

        <div class="bg-[#F0F7FF] border border-[#BDE0FF] rounded-2xl p-6 md:p-8 mb-10 text-center">
            <h3 class="font-heading text-xl font-bold text-foreground mb-4">Payment Instructions</h3>
            <p class="mb-0 text-foreground text-lg leading-relaxed">
                * Once your payment is done, just send the transaction copy to <a href="mailto:<?php echo esc_attr( $contact_email ); ?>" class="text-primary hover:underline font-bold"><?php echo esc_html( $contact_email ); ?></a> and we’ll ship your order immediately.
            </p>
        </div>

		<?php endif; ?>

        <div class="thank-you-hooks-wrapper">
		    <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		    <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
        </div>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>
