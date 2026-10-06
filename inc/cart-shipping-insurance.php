<?php
/**
 * Show the WooCommerce Shipping Insurance Manager controls in the cart and
 * apply its configured default package before cart fees are calculated.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

/**
 * Select the configured insurance default on first cart calculation.
 * The sentinel preserves a customer's explicit choice to decline insurance.
 *
 * @param WC_Cart $cart WooCommerce cart.
 */
function waklert_cart_insurance_select_default( $cart ) {
	if ( ! WC()->session || ! $cart || $cart->is_empty() ) {
		return;
	}

	$selected = WC()->session->get( 'shipping_insurance_package', null );
	if ( 'NO_INSURANCE' === $selected || ( null !== $selected && '' !== $selected ) ) {
		return;
	}

	$default_option = get_option( 'shipping_insurance_default_option', '' );
	if ( ! in_array( $default_option, array( 'most_expensive', 'least_expensive' ), true ) ) {
		return;
	}

	$excluded_methods = (array) get_option( 'shipping_insurance_exclude_shipping_methods', array() );
	$chosen_methods   = (array) WC()->session->get( 'chosen_shipping_methods', array() );
	$eligible_method  = false;
	foreach ( $chosen_methods as $chosen_method ) {
		$method_id = explode( ':', (string) $chosen_method, 2 )[0];
		if ( ! in_array( $method_id, $excluded_methods, true ) ) {
			$eligible_method = true;
			break;
		}
	}
	if ( ! $eligible_method ) {
		return;
	}

	$cart_value = (float) $cart->get_cart_contents_total();
	if ( 'cart_total' === get_option( 'shipping_insurance_percentage_base', 'items_subtotal' ) ) {
		$cart_value += (float) $cart->get_shipping_total();
	}

	$packages     = (array) get_option( 'shipping_insurance_packages', array() );
	$default_id   = '';
	$default_cost = null;
	foreach ( $packages as $package_id => $package ) {
		if ( ! isset( $package['enabled'], $package['type'], $package['amount'] ) || 'yes' !== $package['enabled'] ) {
			continue;
		}

		$minimum = isset( $package['min_cart_value'] ) ? (float) $package['min_cart_value'] : 0;
		$maximum = isset( $package['max_cart_value'] ) ? (float) $package['max_cart_value'] : 0;
		if ( ( $minimum > 0 && $cart_value < $minimum ) || ( $maximum > 0 && $cart_value > $maximum ) ) {
			continue;
		}

		if ( 'fixed' === $package['type'] ) {
			$cost = (float) $package['amount'];
		} elseif ( 'percentage' === $package['type'] ) {
			$cost = ( (float) $package['amount'] / 100 ) * $cart_value;
		} else {
			continue;
		}

		if ( null === $default_cost || ( 'most_expensive' === $default_option && $cost > $default_cost ) || ( 'least_expensive' === $default_option && $cost < $default_cost ) ) {
			$default_id   = (string) $package_id;
			$default_cost = $cost;
		}
	}

	if ( '' !== $default_id ) {
		WC()->session->set( 'shipping_insurance_package', $default_id );
	}
}
add_action( 'woocommerce_cart_calculate_fees', 'waklert_cart_insurance_select_default', 1 );

/**
 * Preserve the explicit no-insurance choice through checkout refreshes.
 *
 * @param string $markup Insurance Manager radio markup.
 * @return string
 */
function waklert_cart_insurance_preserve_decline_choice( $markup ) {
	if ( WC()->session && 'NO_INSURANCE' === WC()->session->get( 'shipping_insurance_package', '' ) ) {
		$markup = str_replace(
			'name="shipping_insurance_package" value="" ',
			'name="shipping_insurance_package" value="NO_INSURANCE" checked="checked" ',
			$markup
		);
	}

	return $markup;
}

/** Render the plugin's insurance choices in the existing cart totals layout. */
function waklert_cart_insurance_render_cart_choices() {
	if ( ! class_exists( 'Shipping_Insurance_Manager_Public' ) || ! WC()->cart || ! WC()->session ) {
		return;
	}

	ob_start();
	$insurance = new Shipping_Insurance_Manager_Public( 'shipping-insurance-manager', '1.0.0' );
	$insurance->add_shipping_insurance_checkbox();
	$markup = waklert_cart_insurance_preserve_decline_choice( ob_get_clean() );

	if ( ! preg_match( '/<td[^>]*>(.*?)<\/td>/is', $markup, $matches ) ) {
		return;
	}

	$options = preg_replace( '/<br\s*\/?\s*>/i', '', $matches[1] );
	$options = str_replace(
		'class="shipping-insurance-option"',
		'class="shipping-insurance-option" style="display:flex;align-items:center;gap:.5rem;font-size:.875rem;line-height:1.25rem;color:#475569"',
		$options
	);
	$options = str_replace(
		'class="shipping-insurance-radio"',
		'class="shipping-insurance-radio" style="width:1rem;height:1rem;flex-shrink:0;accent-color:#1e6280"',
		$options
	);

	echo '<div class="shipping-insurance" style="padding:1rem 0;border-bottom:1px solid #f5f5f4">';
	echo '<div style="font-weight:700;color:#0f172a;font-size:1rem;line-height:1.5rem;margin-bottom:.75rem">' . esc_html__( 'Shipping Insurance', 'woocommerce' ) . '</div>';
	echo '<div style="display:flex;flex-direction:column;gap:.5rem">' . $options . '</div>';
	echo '</div>';
}
add_action( 'woocommerce_cart_totals_before_order_total', 'waklert_cart_insurance_render_cart_choices', 10 );

/** Capture the checkout plugin output so an explicit opt-out survives AJAX. */
function waklert_cart_insurance_start_checkout_buffer() {
	ob_start();
}
add_action( 'woocommerce_review_order_before_order_total', 'waklert_cart_insurance_start_checkout_buffer', -9999 );

function waklert_cart_insurance_finish_checkout_buffer() {
	$markup = ob_get_clean();
	echo waklert_cart_insurance_preserve_decline_choice( $markup );
}
add_action( 'woocommerce_review_order_before_order_total', 'waklert_cart_insurance_finish_checkout_buffer', 9999 );

/** Save cart-page insurance choices, recalculate the fee and refresh the cart. */
function waklert_cart_insurance_save_choice() {
	check_ajax_referer( 'waklert_cart_insurance', 'nonce' );

	if ( ! WC()->session || ! WC()->cart || ! isset( $_POST['package'] ) ) {
		wp_send_json_error( array( 'message' => 'Cart is unavailable.' ), 400 );
	}

	$package_id = sanitize_text_field( wp_unslash( $_POST['package'] ) );
	if ( 'NO_INSURANCE' !== $package_id ) {
		$packages = (array) get_option( 'shipping_insurance_packages', array() );
		if ( ! isset( $packages[ $package_id ]['enabled'] ) || 'yes' !== $packages[ $package_id ]['enabled'] ) {
			wp_send_json_error( array( 'message' => 'Insurance option is unavailable.' ), 400 );
		}
	}

	WC()->session->set( 'shipping_insurance_package', $package_id );
	WC()->cart->calculate_totals();
	wp_send_json_success();
}
add_action( 'wp_ajax_waklert_cart_insurance', 'waklert_cart_insurance_save_choice' );
add_action( 'wp_ajax_nopriv_waklert_cart_insurance', 'waklert_cart_insurance_save_choice' );

/** Post radio changes from the cart, then reload WooCommerce's rendered totals. */
function waklert_cart_insurance_cart_script() {
	if ( ! is_cart() || is_checkout() ) {
		return;
	}

	$config = array(
		'url'   => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'waklert_cart_insurance' ),
	);
	?>
	<script>
	(() => {
		const config = <?php echo wp_json_encode( $config ); ?>;
		document.addEventListener('change', async (event) => {
			const input = event.target.closest('input.shipping-insurance-radio');
			if (!input) return;

			const body = new URLSearchParams({
				action: 'waklert_cart_insurance',
				nonce: config.nonce,
				package: input.value || 'NO_INSURANCE'
			});

			input.disabled = true;
			try {
				const response = await fetch(config.url, {
					method: 'POST',
					credentials: 'same-origin',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
					body
				});
				const result = await response.json();
				if (!response.ok || !result.success) throw new Error('Could not update insurance.');
				window.location.reload();
			} catch (error) {
				input.disabled = false;
				window.alert(error.message);
			}
		});
	})();
	</script>
	<?php
}
add_action( 'wp_footer', 'waklert_cart_insurance_cart_script', 40 );
