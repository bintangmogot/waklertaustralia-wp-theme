<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="lg:grid lg:grid-cols-12 lg:gap-10 lg:items-start my-8 font-sans">
    <div class="lg:col-span-7">
        
        <div class="mb-6">
            <a href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>" class="inline-flex items-center text-slate-500 hover:text-primary transition-colors text-sm font-medium mb-3 group">
                <?= waklert_content_icon('cart_icon_90229b5868') ?>
                <?php esc_html_e( waklert_content('cart_text_7a161231ec'), 'woocommerce' ); ?>
            </a>
            <h1 class="text-2xl md:text-3xl font-black font-heading text-slate-900"><?php esc_html_e( waklert_content('cart_text_b836985683'), 'woocommerce' ); ?></h1>
        </div>
        
        <form class="woocommerce-cart-form bg-white rounded-xl border border-stone-200 overflow-hidden" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
            <?php do_action( 'woocommerce_before_cart_table' ); ?>

            <div class="overflow-x-auto">
                <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents w-full text-left" cellspacing="0">
                    <thead class="border-b border-stone-200 bg-white">
                        <tr>
                            <th colspan="2" class="product-name px-6 py-4 text-sm font-bold text-slate-700"><?php esc_html_e( waklert_content('cart_text_9c638e555c'), 'woocommerce' ); ?></th>
                            <th class="product-subtotal px-6 py-4 text-sm font-bold text-slate-700 text-right"><?php esc_html_e( waklert_content('cart_text_1cba2185b6'), 'woocommerce' ); ?></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        <?php do_action( 'woocommerce_before_cart_contents' ); ?>

                        <?php
                        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                            $visible = apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key );

                            if ( $_product instanceof WC_Product && $_product->exists() && $cart_item['quantity'] > 0 && $visible ) {
                                $product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
                                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                                ?>
                                <tr class="woocommerce-cart-form__cart-item hover:bg-stone-50/50 transition-colors <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                                    
                                    <!-- Thumbnail -->
                                    <td class="product-thumbnail px-6 py-6 w-24 sm:w-32 align-top hidden sm:table-cell">
                                        <?php
                                        $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(array(100, 100), array('class' => 'rounded-md object-cover border border-stone-100 bg-white')), $cart_item, $cart_item_key );

                                        if ( ! $product_permalink ) {
                                            echo $thumbnail; // PHPCS: XSS ok.
                                        } else {
                                            printf( '<a href="%s" class="block shrink-0">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                        }
                                        ?>
                                    </td>

                                    <!-- Product Info (Title, Price, Qty, Remove) -->
                                    <td class="product-name px-6 py-6 align-top" data-title="<?php esc_attr_e( waklert_content('cart_text_9c638e555c'), 'woocommerce' ); ?>">
                                        <!-- Mobile Thumbnail (visible only on small screens) -->
                                        <div class="sm:hidden mb-4 max-w-[80px]">
                                            <?php
                                            if ( ! $product_permalink ) {
                                                echo $thumbnail; // PHPCS: XSS ok.
                                            } else {
                                                printf( '<a href="%s" class="block shrink-0">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                                            }
                                            ?>
                                        </div>

                                        <!-- Title -->
                                        <div class="font-bold text-slate-900 text-base leading-tight mb-1">
                                            <?php
                                            if ( ! $product_permalink ) {
                                                echo wp_kses_post( $product_name . '&nbsp;' );
                                            } else {
                                                echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="hover:text-primary transition-colors">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                            }
                                            ?>
                                        </div>
                                        
                                        <?php
                                        do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                                        // Meta data.
                                        $meta = wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.
                                        if ($meta) {
                                            echo '<div class="text-xs text-stone-500 mt-1">' . $meta . '</div>';
                                        }

                                        // Backorder notification.
                                        if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification text-xs text-amber-600 mt-1">' . esc_html__( waklert_content('cart_text_f8376808d0'), 'woocommerce' ) . '</p>', $product_id ) );
                                        }
                                        ?>

                                        <!-- Price -->
                                        <div class="product-price text-sm text-slate-500 mt-1 font-medium">
                                            <?php
                                                echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                            ?>
                                        </div>

                                        <!-- Qty & Remove -->
                                        <div class="flex items-center gap-4 mt-4">
                                            <div class="flex items-center gap-2 text-sm font-medium text-slate-600">
                                                <span><?= esc_html(waklert_content('cart_text_349bec6b1e')) ?></span>
                                                <div class="product-quantity max-w-[80px]">
                                                <?php
                                                if ( $_product->is_sold_individually() ) {
                                                    $min_quantity = 1;
                                                    $max_quantity = 1;
                                                } else {
                                                    $min_quantity = 0;
                                                    $max_quantity = $_product->get_max_purchase_quantity();
                                                }

                                                $product_quantity = woocommerce_quantity_input(
                                                    array(
                                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                                        'input_value'  => $cart_item['quantity'],
                                                        'max_value'    => $max_quantity,
                                                        'min_value'    => $min_quantity,
                                                        'product_name' => $product_name,
                                                        'classes'      => array('w-full', 'rounded', 'border-stone-200', 'shadow-none', 'py-1', 'px-2', 'text-sm', 'focus:border-primary', 'focus:ring-primary', 'text-center'),
                                                    ),
                                                    $_product,
                                                    false
                                                );

                                                echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                                ?>
                                                </div>
                                            </div>

                                            <div class="product-remove">
                                                <?php
                                                    echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                        'woocommerce_cart_item_remove_link',
                                                        sprintf(
                                                            '<a role="button" href="%s" class="remove inline-flex items-center justify-center p-1.5 rounded text-red-400 hover:bg-red-50 hover:text-red-600 transition-colors" aria-label="%s" data-product_id="%s" data-product_sku="%s" title="%s">%s</a>',
                                                            esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                            esc_attr( sprintf( __( waklert_content('cart_text_dac3f55da0'), 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
                                                            esc_attr( $product_id ),
                                                            esc_attr( $_product->get_sku() ),
                                                            esc_attr(waklert_content('manual_cart_remove_title')),
                                                            waklert_content_icon('manual_cart_remove_icon')
                                                        ),
                                                        $cart_item_key
                                                    );
                                                ?>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Subtotal -->
                                    <td class="product-subtotal px-6 py-6 align-top text-right font-bold text-slate-900" data-title="<?php esc_attr_e( waklert_content('cart_text_04f0073062'), 'woocommerce' ); ?>">
                                        <?php
                                            echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>

                        <?php do_action( 'woocommerce_cart_contents' ); ?>

                        <!-- Update Cart Button Row -->
                        <tr>
                            <td colspan="3" class="actions px-6 py-4 bg-stone-50/50 border-t border-stone-200 text-right">
                                <?php do_action( 'woocommerce_cart_actions' ); ?>
                                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                                <button type="submit" class="button px-5 py-2 bg-white border border-stone-200 hover:bg-stone-100 text-slate-700 text-sm font-semibold rounded-lg shadow-sm transition-colors" name="update_cart" value="<?php esc_attr_e( waklert_content('cart_text_734498838e'), 'woocommerce' ); ?>"><?php esc_html_e( waklert_content('cart_text_734498838e'), 'woocommerce' ); ?></button>
                            </td>
                        </tr>

                        <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                    </tbody>
                </table>
            </div>
            <?php do_action( 'woocommerce_after_cart_table' ); ?>
        </form>
    </div>

    <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

    <div class="lg:col-span-5 mt-8 lg:mt-0">
        <div class="cart-collaterals">
            <?php
                /**
                 * Cart collaterals hook.
                 *
                 * @hooked woocommerce_cross_sell_display
                 * @hooked woocommerce_cart_totals - 10
                 */
                do_action( 'woocommerce_cart_collaterals' );
            ?>
        </div>
    </div>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
