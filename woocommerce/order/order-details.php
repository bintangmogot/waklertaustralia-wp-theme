<?php
/**
 * Order details - Waklert Australia Clean Modern Layout
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.9.0
 *
 * @var bool $show_downloads Controls whether the downloads table should be rendered.
 */

defined( 'ABSPATH' ) || exit;

$order = wc_get_order( $order_id );

if ( ! $order ) {
	return;
}

$order_items        = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );
$show_purchase_note = $order->has_status( apply_filters( 'woocommerce_purchase_note_order_statuses', array( 'completed', 'processing' ) ) );
$downloads          = $order->get_downloadable_items();
$actions            = array_filter(
	wc_get_account_orders_actions( $order ),
	function ( $key ) {
		return 'view' !== $key;
	},
	ARRAY_FILTER_USE_KEY
);

$show_customer_details = $order->get_user_id() === get_current_user_id();

if ( $show_downloads ) {
	wc_get_template(
		'order/order-downloads.php',
		array(
			'downloads'  => $downloads,
			'show_title' => true,
		)
	);
}
?>
<section class="woocommerce-order-details bg-card border border-border/80 rounded-2xl sm:rounded-3xl p-3.5 sm:p-7 shadow-xs mb-6 sm:mb-8">
	<?php do_action( 'woocommerce_order_details_before_order_table', $order ); ?>

	<h2 class="woocommerce-order-details__title font-heading text-xl sm:text-2xl font-extrabold text-foreground mb-4 pb-3 border-b border-border/80 flex items-center justify-between">
		<span><?php esc_html_e( 'Order details', 'woocommerce' ); ?></span>
		<span class="text-xs font-semibold uppercase tracking-wider text-muted-foreground px-2.5 py-1 rounded-full bg-muted">
			Order #<?php echo esc_html( $order->get_order_number() ); ?>
		</span>
	</h2>

	<!-- Mobile Flat Clean List (NO nested tables, NO nested boxes) -->
	<div class="order-details-mobile-stack md:hidden mb-2">
		<!-- Ordered Items -->
		<div class="divide-y divide-border/60 mb-4">
			<?php
			foreach ( $order_items as $item_id => $item ) :
				$product = $item->get_product();
				$qty     = $item->get_quantity();
				$subtotal = $order->get_formatted_line_subtotal( $item );
				?>
				<div class="py-3 first:pt-0 last:pb-3 flex items-start justify-between gap-3">
					<div class="flex-1 pr-2">
						<div class="font-bold text-sm text-foreground leading-snug">
							<?php echo wp_kses_post( $item->get_name() ); ?>
						</div>
						<div class="text-xs text-muted-foreground mt-1 flex items-center gap-2">
							<span>Qty: <strong class="text-foreground font-semibold"><?php echo esc_html( $qty ); ?></strong></span>
						</div>
						<?php wc_display_item_meta( $item ); ?>
						<?php if ( $show_purchase_note && $product && $product->get_purchase_note() ) : ?>
							<div class="mt-2 text-xs text-amber-800 bg-amber-50/80 p-2.5 rounded-lg border border-amber-200">
								<?php echo wp_kses_post( wpautop( do_shortcode( $product->get_purchase_note() ) ) ); ?>
							</div>
						<?php endif; ?>
					</div>
					<div class="text-right shrink-0">
						<span class="font-extrabold text-sm text-foreground font-mono"><?php echo wp_kses_post( $subtotal ); ?></span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Summary Breakdown (clean flat rows) -->
		<div class="border-t-2 border-border/70 pt-3 space-y-2.5">
			<?php
			foreach ( $order->get_order_item_totals() as $key => $total ) :
				$is_grand_total = ( $key === 'order_total' );
				?>
				<div class="flex items-center justify-between text-sm <?php echo $is_grand_total ? 'pt-2.5 border-t border-border/80 font-black text-base' : 'text-muted-foreground'; ?>">
					<span class="<?php echo $is_grand_total ? 'text-foreground font-extrabold' : 'text-muted-foreground text-xs font-semibold'; ?>"><?php echo esc_html( $total['label'] ); ?></span>
					<span class="<?php echo $is_grand_total ? 'text-primary font-mono text-xl font-black' : 'text-foreground font-medium text-xs sm:text-sm'; ?>">
						<?php echo wp_kses_post( $total['value'] ); ?>
					</span>
				</div>
			<?php endforeach; ?>
		</div>

		<?php if ( $order->get_customer_note() ) : ?>
			<div class="mt-4 pt-3 border-t border-border/60 text-xs text-muted-foreground">
				<span class="font-bold text-foreground block mb-1"><?php esc_html_e( 'Note:', 'woocommerce' ); ?></span>
				<?php echo wp_kses( nl2br( wc_wptexturize_order_note( $order->get_customer_note() ) ), array( 'br' => array() ) ); ?>
			</div>
		<?php endif; ?>
	</div>

	<!-- Desktop / Tablet Table (visible on >= md screen) -->
	<div class="hidden md:block overflow-x-auto">
		<table class="woocommerce-table woocommerce-table--order-details shop_table order_details w-full text-left border-collapse">
			<thead>
				<tr class="border-b border-border/80">
					<th class="woocommerce-table__product-name product-name py-3 px-4 text-xs font-bold uppercase tracking-wider text-muted-foreground"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
					<th class="woocommerce-table__product-table product-total py-3 px-4 text-xs font-bold uppercase tracking-wider text-muted-foreground text-right"><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
				</tr>
			</thead>

			<tbody class="divide-y divide-border/50">
				<?php
				do_action( 'woocommerce_order_details_before_order_table_items', $order );

				foreach ( $order_items as $item_id => $item ) {
					$product = $item->get_product();

					wc_get_template(
						'order/order-details-item.php',
						array(
							'order'              => $order,
							'item_id'            => $item_id,
							'item'               => $item,
							'show_purchase_note' => $show_purchase_note,
							'purchase_note'      => $product ? $product->get_purchase_note() : '',
							'product'            => $product,
						)
					);
				}

				do_action( 'woocommerce_order_details_after_order_table_items', $order );
				?>
			</tbody>

			<tfoot class="border-t-2 border-border/80 divide-y divide-border/40">
				<?php
				foreach ( $order->get_order_item_totals() as $key => $total ) {
					$is_grand_total = ( $key === 'order_total' );
					?>
					<tr class="<?php echo $is_grand_total ? 'bg-primary/5 font-bold' : ''; ?>">
						<th scope="row" class="py-3 px-4 text-sm font-semibold text-muted-foreground"><?php echo esc_html( $total['label'] ); ?></th>
						<td class="py-3 px-4 text-right text-sm font-bold <?php echo $is_grand_total ? 'text-primary font-mono text-xl' : 'text-foreground'; ?>">
							<?php echo wp_kses_post( $total['value'] ); ?>
						</td>
					</tr>
					<?php
				}
				?>
				<?php if ( $order->get_customer_note() ) : ?>
					<tr>
						<th class="py-3 px-4 text-sm font-semibold text-muted-foreground"><?php esc_html_e( 'Note:', 'woocommerce' ); ?></th>
						<td class="py-3 px-4 text-sm text-foreground">
						<?php
						$customer_note = wc_wptexturize_order_note( $order->get_customer_note() );
						echo wp_kses( nl2br( $customer_note ), array( 'br' => array() ) );
						?>
						</td>
					</tr>
				<?php endif; ?>
			</tfoot>
		</table>
	</div>

	<?php do_action( 'woocommerce_order_details_after_order_table', $order ); ?>
</section>

<?php
do_action( 'woocommerce_after_order_details', $order );

if ( $show_customer_details ) {
	wc_get_template( 'order/order-details-customer.php', array( 'order' => $order ) );
}
