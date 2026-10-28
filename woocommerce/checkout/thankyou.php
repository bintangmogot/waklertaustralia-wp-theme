<?php
/**
 * Thankyou page - Waklert Australia Exact Redesign
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;

// Dynamic options with rock-solid Australian defaults (ACF Theme Settings editable)
$contact_email = function_exists( 'get_field' ) ? get_field( 'contact_email', 'option' ) : '';
if ( empty( $contact_email ) || strpos( $contact_email, 'modafinil' ) !== false || strpos( $contact_email, 'example.com' ) !== false || strpos( $contact_email, '@waklertaustralia' ) !== false ) {
    $contact_email = 'orders@waklertaustralia.com.au';
} else {
    $contact_email = sanitize_email( $contact_email );
}

// Bank account details
$bacs_bank = 'Commonwealth Bank';
$bacs_name = 'Steven Waldberg';
$bacs_bsb  = '062 948';
$bacs_acc  = '48880531';

// PayID details (ACF editable with fallback)
$payid_number = function_exists( 'get_field' ) ? ( get_field( 'payid_number', 'option' ) ?: '0402 222 605' ) : '0402 222 605';

// Warning callout message (ACF editable with fallback)
$checkout_bacs_warning = function_exists( 'get_field' ) ? get_field( 'checkout_bacs_warning', 'option' ) : '';
if ( empty( $checkout_bacs_warning ) ) {
    $checkout_bacs_warning = '* Use the below BSB & account details to make the transfer. Simply mention your order number in the comment section. DO NOT reference anything related to medicine or website name. Just mention your order number.';
}

// Receipt dispatch notice (ACF editable with fallback)
$checkout_receipt_notice = function_exists( 'get_field' ) ? get_field( 'checkout_receipt_notice', 'option' ) : '';
if ( empty( $checkout_receipt_notice ) ) {
    $checkout_receipt_notice = "* Once your payment is done, just send the transaction copy to {email} and we'll ship your order immediately.";
}

// Shipping Note (ACF editable with fallback)
$shipping_note = function_exists( 'get_field' ) ? get_field( 'checkout_shipping_note', 'option' ) : '';
if ( empty( $shipping_note ) ) {
    $shipping_note = 'The average shipping time is 10 - 15 days. Please note that delivery may take up to 30 days from the date of dispatch due to potential disruptions in postal services caused by weather issues or natural disaster.';
}
?>

<div class="woocommerce-order max-w-5xl mx-auto py-6 sm:py-10 px-4 sm:px-6">

	<?php if ( $order ) : ?>

		<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

            <!-- Order Failed State -->
            <div class="text-center bg-card border border-destructive/20 rounded-3xl p-8 sm:p-12 shadow-sm mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-destructive/10 text-destructive mb-6 ring-8 ring-destructive/5">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <h1 class="font-heading text-3xl sm:text-4xl font-extrabold text-foreground mb-3"><?php esc_html_e( 'Order Payment Failed', 'woocommerce' ); ?></h1>
                <p class="text-muted-foreground text-base sm:text-lg max-w-xl mx-auto mb-8"><?php esc_html_e( 'Unfortunately your order payment could not be completed. Please re-attempt your payment or select direct bank transfer.', 'woocommerce' ); ?></p>
                
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-primary text-white font-bold hover:bg-primary-dark transition-all shadow-md hover:shadow-lg"><?php esc_html_e( 'Retry Payment', 'woocommerce' ); ?></a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="inline-flex items-center justify-center px-8 py-3.5 rounded-full border-2 border-border text-foreground font-bold hover:bg-muted transition-all"><?php esc_html_e( 'My Account', 'woocommerce' ); ?></a>
                    <?php endif; ?>
                </div>
            </div>

		<?php else : ?>

            <?php
            $is_bacs = ( $order->get_payment_method() === 'bacs' );
            $order_num = $order->get_order_number();
            $order_total = $order->get_formatted_order_total();
            $customer_name = $order->get_billing_first_name() ? $order->get_billing_first_name() : 'Customer';
            $order_date_formatted = wc_format_datetime( $order->get_date_created(), 'j F Y' );
            $payment_method_title = $is_bacs ? 'Pay via Direct Bank Transfer' : wp_strip_all_tags( $order->get_payment_method_title() );
            ?>

            <!-- Top Header: Congratulations, [Customer First Name] -->
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-[#0C4161] tracking-tight mb-6 sm:mb-8 font-heading">
                Congratulations, <?php echo esc_html( $customer_name ); ?>
            </h1>

            <!-- Two-Column Responsive Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-8">
                
                <!-- Left Column: Order Summary Card -->
                <div class="lg:col-span-5 bg-white border border-slate-200 rounded-2xl p-6 sm:p-7 shadow-xs">
                    <!-- Site Logo -->
                    <div class="flex items-center justify-center mb-5">
                        <?php
                        $logo_url = function_exists( 'waklert_get_logo_url' ) ? waklert_get_logo_url( 'header' ) : '';
                        if ( ! $logo_url ) {
                            $theme_logo = get_template_directory() . '/assets/images/waklert-australia-logo.png';
                            if ( file_exists( $theme_logo ) ) {
                                $logo_url = get_template_directory_uri() . '/assets/images/waklert-australia-logo.png';
                            }
                        }
                        if ( $logo_url ) : ?>
                            <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ?: 'Waklert Australia' ); ?>" class="h-10 sm:h-12 w-auto max-w-[240px] object-contain" />
                        <?php else : ?>
                            <span class="font-heading text-xl font-extrabold text-[#0C4161]">WAKLERT AUSTRALIA</span>
                        <?php endif; ?>
                    </div>

                    <!-- Order Total Amount -->
                    <div class="text-center font-extrabold text-3xl sm:text-4xl text-[#0C4161] mb-5 tracking-tight font-heading">
                        <?php echo wp_kses_post( $order_total ); ?>
                    </div>

                    <!-- Divider -->
                    <hr class="border-slate-200 mb-5">

                    <!-- Order Info Metadata List -->
                    <div class="bg-slate-50/70 border border-slate-100 rounded-xl p-4 divide-y divide-slate-200/80">
                        <div class="flex items-center justify-between py-2.5 first:pt-1">
                            <span class="text-xs sm:text-sm text-slate-600 font-medium">Order Number:</span>
                            <strong class="text-xs sm:text-sm text-slate-900 font-bold font-mono">#<?php echo esc_html( $order_num ); ?></strong>
                        </div>
                        <div class="flex items-center justify-between py-2.5">
                            <span class="text-xs sm:text-sm text-slate-600 font-medium">Date:</span>
                            <strong class="text-xs sm:text-sm text-slate-900 font-bold"><?php echo esc_html( $order_date_formatted ); ?></strong>
                        </div>
                        <div class="flex items-center justify-between py-2.5 last:pb-1">
                            <span class="text-xs sm:text-sm text-slate-600 font-medium">Payment Method:</span>
                            <strong class="text-xs sm:text-sm text-slate-900 font-bold text-right"><?php echo esc_html( $payment_method_title ); ?></strong>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Payment Instructions & Bank Details -->
                <div class="lg:col-span-7 flex flex-col">
                    
                    <!-- Intro Text with bold red EFT and PayID -->
                    <p class="text-sm sm:text-base font-semibold text-slate-900 mb-4 leading-relaxed">
                        Thank you for your order. Please complete your payment using <strong class="font-extrabold text-[#DC2626]" style="color: #dc2626;">EFT</strong> or <strong class="font-extrabold text-[#DC2626]" style="color: #dc2626;">PayID</strong> below.
                    </p>

                    <!-- Dark Navy Callout Box with bold red DO NOT and highlighted keywords -->
                    <div class="bg-[#0C4161] text-white rounded-xl p-4 sm:p-5 shadow-sm mb-6">
                        <p class="text-xs sm:text-sm leading-relaxed mb-0 font-normal">
                            <?php
                            $warning_html = esc_html( $checkout_bacs_warning );
                            $warning_html = str_ireplace( 'DO NOT', '<strong class="font-black text-[#FF4D4F]" style="color: #ff4d4f; font-weight: 800;">DO NOT</strong>', $warning_html );
                            $warning_html = str_ireplace( 'medicine', '<strong class="font-bold text-[#FFB703]" style="color: #ffb703; font-weight: 700;">medicine</strong>', $warning_html );
                            $warning_html = str_ireplace( 'website', '<strong class="font-bold text-[#FFB703]" style="color: #ffb703; font-weight: 700;">website</strong>', $warning_html );
                            echo $warning_html;
                            ?>
                        </p>
                    </div>

                    <!-- PayID Row with Copy Button -->
                    <div class="flex items-center justify-between py-2.5 border-b border-slate-200/80 mb-5">
                        <div class="flex items-baseline gap-2">
                            <span class="text-[#D97706] font-extrabold text-base sm:text-lg" style="color: #d97706;">PayID:</span>
                            <span class="text-[#0C4161] font-black text-base sm:text-lg tracking-wide select-all font-mono"><?php echo esc_html( $payid_number ); ?></span>
                        </div>
                        <button type="button" onclick="copyValue('<?php echo esc_js( preg_replace('/\s+/', '', $payid_number) ); ?>', this)" class="copy-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-bold text-[#0C4161] bg-white hover:bg-slate-50 transition-all active:scale-95 cursor-pointer shadow-2xs">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <span>Copy</span>
                        </button>
                    </div>

                    <!-- Or use bank transfer -->
                    <div class="text-slate-700 font-semibold text-xs sm:text-sm mb-3">
                        Or use bank transfer:
                    </div>

                    <!-- Bank Details List -->
                    <div class="space-y-1.5 text-slate-800 text-sm sm:text-base mb-6">
                        <div class="font-bold text-slate-900"><?php echo esc_html( $bacs_name ); ?>:</div>
                        <div><span class="font-bold">Bank:</span> <?php echo esc_html( $bacs_bank ); ?></div>
                        <div><span class="font-bold">BSB:</span> <?php echo esc_html( $bacs_bsb ); ?></div>
                        <div><span class="font-bold">Account number:</span> <?php echo esc_html( $bacs_acc ); ?></div>
                    </div>

                    <!-- Badges Row -->
                    <div class="flex flex-wrap items-center gap-3">
                        <!-- Commonwealth Bank Badge -->
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl border border-slate-200 bg-white shadow-2xs h-11">
                            <div class="w-6 h-6 rounded bg-[#FFCC00] flex items-center justify-center shrink-0 shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-[#1A1A1A]" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2L2 12l10 10 10-10L12 2zm0 4.2L17.8 12 12 17.8 6.2 12 12 6.2z"/>
                                </svg>
                            </div>
                            <div class="text-[11px] leading-tight font-bold text-slate-800">
                                <span>Commonwealth</span><br><span>Bank</span>
                            </div>
                        </div>

                        <!-- PayID Badge -->
                        <div class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-xl border border-slate-200 bg-white shadow-2xs h-11">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/payid.png' ); ?>" alt="PayID" class="h-6 w-auto object-contain" />
                        </div>

                        <!-- Osko Badge -->
                        <div class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-xl border border-slate-200 bg-white shadow-2xs h-11">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/osko.jpg' ); ?>" alt="Osko" class="h-6 w-auto object-contain" />
                        </div>
                    </div>

                </div>

            </div>

            <!-- Receipt Dispatch Notice (Green Circle 1 in Image 4) -->
            <?php
            $receipt_notice_text = str_replace(
                '{email}',
                '<a href="mailto:' . esc_attr( $contact_email ) . '" class="font-bold text-slate-900 underline">' . esc_html( $contact_email ) . '</a>',
                esc_html( $checkout_receipt_notice )
            );
            ?>
            <p class="text-xs sm:text-sm text-slate-600 italic mb-6">
                <?php echo $receipt_notice_text; ?>
            </p>

            <!-- Divider -->
            <hr class="border-slate-200 my-6">

            <!-- Shipping Note (Green Circle 2 in Image 4) -->
            <div class="mb-8">
                <h3 class="font-bold text-slate-900 text-sm sm:text-base mb-2">Note</h3>
                <p class="text-slate-600 text-xs sm:text-sm leading-relaxed max-w-4xl">
                    <?php echo esc_html( $shipping_note ); ?>
                </p>
            </div>

            <!-- WooCommerce Hook Outputs (Styled cleanly) -->
            <div class="thank-you-hooks-wrapper">
                <style>
                    /* Hide redundant duplicate plain BACS and old note */
                    .custom-bacs-details,
                    .woocommerce-bacs-bank-details,
                    .shipping-notice-thankyou { 
                        display: none !important; 
                    }
                    /* Modern order items table styling matching Image 3 */
                    .woocommerce-order-details {
                        background: transparent !important;
                        border: none !important;
                        padding: 0 !important;
                        margin-bottom: 2rem !important;
                        box-shadow: none !important;
                    }
                    .woocommerce-order-details h2.woocommerce-order-details__title {
                        font-family: var(--font-heading, inherit);
                        font-size: 1.5rem !important;
                        font-weight: 800 !important;
                        color: #0C4161 !important;
                        margin-top: 0 !important;
                        margin-bottom: 1.25rem !important;
                        padding-bottom: 0 !important;
                        border-bottom: none !important;
                    }
                    .woocommerce-table--order-details thead tr {
                        background-color: #0C4161 !important;
                        color: #FFFFFF !important;
                    }
                    .woocommerce-table--order-details thead th {
                        color: #FFFFFF !important;
                        font-weight: 700 !important;
                        font-size: 0.9375rem !important;
                        padding: 0.875rem 1rem !important;
                        border: none !important;
                    }
                    .woocommerce-table--order-details tbody td {
                        padding: 1rem 1rem !important;
                        border-bottom: 1px solid #E2E8F0 !important;
                    }
                    .woocommerce-table--order-details tfoot th {
                        padding: 0.875rem 1rem !important;
                        font-weight: 600 !important;
                        color: #64748B !important;
                        text-align: left !important;
                        border-bottom: 1px solid #E2E8F0 !important;
                    }
                    .woocommerce-table--order-details tfoot td {
                        padding: 0.875rem 1rem !important;
                        text-align: right !important;
                        font-weight: 700 !important;
                        color: #0F172A !important;
                        border-bottom: 1px solid #E2E8F0 !important;
                    }
                    /* Mobile Order Details adjustments */
                    @media (max-width: 767px) {
                        .woocommerce-order-details table.shop_table,
                        .woocommerce-order-details table.woocommerce-table--order-details,
                        table.woocommerce-table--order-details {
                            display: none !important;
                        }
                        .order-details-mobile-stack {
                            display: block !important;
                        }
                    }
                    @media (min-width: 768px) {
                        .order-details-mobile-stack {
                            display: none !important;
                        }
                    }
                </style>
                <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
            </div>

            <?php
            $shop_page_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : '';
            if ( empty( $shop_page_url ) ) {
                $shop_page_url = home_url( '/shop/' );
            }
            $shop_page_url = apply_filters( 'woocommerce_return_to_shop_redirect', $shop_page_url );
            ?>
            <!-- Return to Shop CTA -->
            <div class="mt-10 pt-8 border-t border-slate-200 flex flex-col items-center text-center">
                <a href="<?php echo esc_url( $shop_page_url ); ?>" class="inline-flex items-center justify-center gap-2.5 px-8 py-3.5 rounded-full bg-primary hover:bg-primary-dark text-white font-extrabold text-sm sm:text-base tracking-wide transition-all shadow-md hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 ring-4 ring-primary/10 w-full sm:w-auto">
                    <svg class="w-5 h-5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span>Return to Shop</span>
                </a>
                <p class="text-xs text-muted-foreground mt-3 flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-emerald-600 inline shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span>Your order confirmation &amp; tax invoice have been dispatched to your email</span>
                </p>
            </div>

		<?php endif; ?>

	<?php else : ?>

		<?php wc_get_template( 'checkout/order-received.php', array( 'order' => false ) ); ?>

	<?php endif; ?>

</div>

<!-- Copy to Clipboard Interactive Script -->
<script>
function copyValue(text, btn) {
    if (!navigator.clipboard) {
        var textarea = document.createElement("textarea");
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand("copy");
            showCopied(btn);
        } catch (err) {}
        document.body.removeChild(textarea);
        return;
    }
    navigator.clipboard.writeText(text).then(function() {
        showCopied(btn);
    });
}

function showCopied(btn) {
    var originalHTML = btn.innerHTML;
    btn.innerHTML = '<svg class="w-3.5 h-3.5 text-emerald-600 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span class="text-emerald-700 font-bold">Copied!</span>';
    btn.classList.add('border-emerald-300', 'bg-emerald-50');
    setTimeout(function() {
        btn.innerHTML = originalHTML;
        btn.classList.remove('border-emerald-300', 'bg-emerald-50');
    }, 2000);
}
</script>
