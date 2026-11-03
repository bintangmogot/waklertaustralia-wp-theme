<?php
/**
 * Thankyou page - Waklert Australia Reverted Layout with Exact Content & Formatting
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;

// Dynamic options with rock-solid Australian defaults
// Every text on this page is edited in WP Admin -> Theme Settings -> Checkout & Emails
$contact_email = sanitize_email( (string) get_field( 'support_email', 'option' ) );

$phone_raw    = preg_replace( '/[^0-9]/', '', (string) get_field( 'whatsapp_number', 'option' ) );
$whatsapp_url = 'https://wa.me/61' . ltrim( $phone_raw, '0' );

// Bank account details
$bank      = waklert_bank_details();
$bacs_bank = $bank['bank'];
$bacs_name = $bank['name'];
$bacs_bsb  = $bank['bsb'];
$bacs_acc  = $bank['number'];

$payid_number            = waklert_option_text( 'payid_number' );
$checkout_bacs_warning   = waklert_option_text( 'checkout_bacs_warning' );
$checkout_receipt_notice = waklert_option_text( 'checkout_receipt_notice' );
$shipping_note           = waklert_option_text( 'checkout_shipping_note' );

// Optional logo overrides (Theme Settings); the bundled logos are the safety net
$logo_src = static function ( $field, $fallback ) {
    $img = get_field( $field, 'option' );
    $url = is_array( $img ) ? ( $img['url'] ?? '' ) : ( is_numeric( $img ) ? wp_get_attachment_image_url( (int) $img, 'full' ) : (string) $img );
    return $url ?: get_template_directory_uri() . $fallback;
};
// **word** in a text becomes bold red
$bold_red = static function ( $text ) {
    return preg_replace( '/\*\*(.+?)\*\*/', '<strong class="text-[#DC2626] font-bold" style="color: #dc2626;">$1</strong>', esc_html( $text ) );
};
?>

<div class="woocommerce-order max-w-3xl mx-auto py-4 sm:py-8 px-2.5 sm:px-6">

	<?php if ( $order ) : ?>

		<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

            <!-- Order Failed State -->
            <div class="text-center bg-card border border-destructive/20 rounded-3xl p-8 sm:p-12 shadow-sm mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-destructive/10 text-destructive mb-6 ring-8 ring-destructive/5">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <h1 class="font-heading text-3xl sm:text-4xl font-extrabold text-foreground mb-3"><?php echo esc_html( waklert_option_text( 'thankyou_failed_title' ) ); ?></h1>
                <p class="text-muted-foreground text-base sm:text-lg max-w-xl mx-auto mb-8"><?php echo esc_html( waklert_option_text( 'thankyou_failed_text' ) ); ?></p>
                
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="inline-flex items-center justify-center px-8 py-3.5 rounded-full bg-primary text-white font-bold hover:bg-primary-dark transition-all shadow-md hover:shadow-lg"><?php echo esc_html( waklert_option_text( 'thankyou_failed_retry' ) ); ?></a>
                    <?php if ( is_user_logged_in() ) : ?>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="inline-flex items-center justify-center px-8 py-3.5 rounded-full border-2 border-border text-foreground font-bold hover:bg-muted transition-all"><?php echo esc_html( waklert_option_text( 'thankyou_failed_account' ) ); ?></a>
                    <?php endif; ?>
                </div>
            </div>

		<?php else : ?>

            <?php
            $is_bacs = ( $order->get_payment_method() === 'bacs' );
            $order_num = $order->get_order_number();
            $order_total = $order->get_formatted_order_total();
            $customer_first_name = $order->get_billing_first_name();
            $email_subject = rawurlencode( 'Payment Receipt - Order #' . $order_num );
            $email_body    = rawurlencode( "Hi,\n\nI have completed the bank transfer for Order #" . $order_num . " (" . wp_strip_all_tags( $order_total ) . ").\n\nPlease find my transaction receipt attached.\n\nThank you,\n" . $customer_first_name );
            $mailto_url    = 'mailto:' . esc_attr( $contact_email ) . '?subject=' . $email_subject . '&body=' . $email_body;
            $wa_text       = rawurlencode( 'Hi, here is my payment receipt for Order #' . $order_num . ' (' . wp_strip_all_tags( $order_total ) . ').' );
            $wa_full_url   = $whatsapp_url . '?text=' . $wa_text;
            ?>

            <!-- Hero Header Card -->
            <div class="flex flex-col items-center text-center mb-4 sm:mb-5">
                <!-- Status Check Circle: Blue Circle (#0284C7) with White Checkmark Icon -->
                <div class="flex items-center justify-center w-20 h-20 rounded-full bg-[#0284C7] text-white shadow-lg ring-8 ring-sky-100 mb-5">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="mb-4">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-semibold shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <?php echo esc_html( waklert_option_text( $is_bacs ? 'thankyou_status_bacs' : 'thankyou_status_paid' ) ); ?>
                    </div>
                </div>
                
                <h1 class="font-heading text-2xl sm:text-3xl font-extrabold text-foreground tracking-tight mb-1.5">
                    <?php if ( $customer_first_name ) : ?>
                        <?php echo esc_html( str_replace( '{name}', $customer_first_name, waklert_option_text( 'thankyou_title_named' ) ) ); ?>
                    <?php else : ?>
                        <?php echo esc_html( waklert_option_text( 'thankyou_title' ) ); ?>
                    <?php endif; ?>
                </h1>
                
                <p class="text-muted-foreground text-xs sm:text-sm max-w-xl mx-auto leading-relaxed mb-0">
                    <?php if ( $is_bacs ) : ?>
                        <?php echo wp_kses_post( $bold_red( waklert_option_text( 'thankyou_intro_bacs' ) ) ); ?>
                    <?php else : ?>
                        <?php echo esc_html( waklert_option_text( 'thankyou_intro_default' ) ); ?>
                    <?php endif; ?>
                </p>
            </div>

            <!-- Order Key Summary Grid -->
            <div class="bg-card border border-border/80 rounded-2xl p-3 sm:px-5 sm:py-3.5 shadow-xs mb-3.5 sm:mb-4">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 divide-y md:divide-y-0 md:divide-x divide-border/60">
                    <div class="flex flex-col pt-2 md:pt-0">
                        <span class="text-xs uppercase tracking-wider font-semibold text-muted-foreground mb-1"><?php echo esc_html( waklert_option_text( 'thankyou_label_order' ) ); ?></span>
                        <strong class="text-foreground text-lg sm:text-xl font-bold font-mono">#<?php echo esc_html( $order_num ); ?></strong>
                    </div>

                    <div class="flex flex-col pt-3 md:pt-0 md:pl-6">
                        <span class="text-xs uppercase tracking-wider font-semibold text-muted-foreground mb-1"><?php echo esc_html( waklert_option_text( 'thankyou_label_date' ) ); ?></span>
                        <strong class="text-foreground text-base sm:text-lg font-bold"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></strong>
                    </div>

                    <div class="flex flex-col pt-3 md:pt-0 md:pl-6">
                        <span class="text-xs uppercase tracking-wider font-semibold text-muted-foreground mb-1"><?php echo esc_html( waklert_option_text( 'thankyou_label_total' ) ); ?></span>
                        <strong class="text-primary text-xl sm:text-2xl font-extrabold"><?php echo wp_kses_post( $order_total ); ?></strong>
                    </div>

                    <div class="flex flex-col pt-3 md:pt-0 md:pl-6">
                        <span class="text-xs uppercase tracking-wider font-semibold text-muted-foreground mb-1"><?php echo esc_html( waklert_option_text( 'thankyou_label_payment' ) ); ?></span>
                        <strong class="text-foreground text-sm sm:text-base font-bold leading-tight"><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
                    </div>
                </div>

                <?php if ( $order->get_billing_email() ) : ?>
                    <div class="mt-5 pt-4 border-t border-border/60 flex flex-wrap items-center justify-between text-xs sm:text-sm text-muted-foreground gap-2">
                        <div>
                            <span><?php echo esc_html( waklert_option_text( 'thankyou_label_sent_to' ) ); ?> </span>
                            <strong class="text-foreground"><?php echo esc_html( $order->get_billing_email() ); ?></strong>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-emerald-700 font-medium">
                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <?php echo esc_html( waklert_option_text( 'thankyou_label_invoice' ) ); ?>
                        </span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ( $is_bacs ) : ?>
                <!-- Commonwealth Bank Transfer Card -->
                <div class="bg-gradient-to-b from-[#FAF5E8]/60 to-[#FFFDF9] border-2 border-[#EAB308]/40 rounded-2xl p-3.5 sm:p-5 shadow-xs mb-3.5 sm:mb-4 relative overflow-hidden">
                    <!-- Brand Top Bar -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pb-3 mb-3.5 border-b border-[#EAB308]/30">
                        <div class="flex items-center gap-3 min-w-0 shrink">
                            <!-- Commonwealth Bank Yellow Diamond Badge -->
                            <div class="w-9 h-9 shrink-0 rounded-lg bg-[#FFCC00] flex items-center justify-center shadow-xs border border-amber-300">
                                <svg class="w-6 h-6 text-[#1A1A1A]" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2L2 12l10 10 10-10L12 2zm0 4.2L17.8 12 12 17.8 6.2 12 12 6.2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="font-heading text-sm sm:text-lg font-extrabold text-[#1A1A1A] leading-tight"><?php echo esc_html( $bacs_bank ); ?></h2>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-[#FFCC00]/40 text-[#854D0E] border border-[#EAB308]/40"><?php echo esc_html( waklert_option_text( 'bank_card_badge' ) ); ?></span>
                                </div>
                                <p class="text-xs text-muted-foreground"><?php echo esc_html( waklert_option_text( 'bank_card_subtitle' ) ); ?></p>
                            </div>
                        </div>
                        <div class="text-center sm:text-right w-full sm:w-auto shrink-0 pt-1 sm:pt-0">
                            <span class="text-xs sm:text-xs font-semibold text-muted-foreground uppercase tracking-wider block mb-0.5"><?php echo esc_html( waklert_option_text( 'bank_card_amount_label' ) ); ?></span>
                            <span class="text-3xl sm:text-2xl font-black sm:font-extrabold text-foreground font-heading"><?php echo wp_kses_post( $order_total ); ?></span>
                        </div>
                    </div>

                    <!-- Callout Warning Box with bold red DO NOT and highlighted keywords -->
                    <div class="bg-[#0C4161] text-white rounded-xl py-2.5 px-3.5 sm:py-3 sm:px-4 shadow-xs mb-3.5 sm:mb-4">
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
                    <!-- Interactive Banking Fields Grid (mt-3 gap from warning above) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 mb-3 mt-3.5 sm:mt-4">
                        
                        <!-- Account Name -->
                        <div class="bg-white/95 border border-border/80 rounded-xl py-2 px-3 sm:py-2.5 sm:px-3.5 flex items-center justify-between gap-2 shadow-xs hover:border-primary/50 transition-colors">
                            <div>
                                <span class="text-[11px] uppercase tracking-wider font-bold text-muted-foreground block mb-0.5"><?php echo esc_html( waklert_option_text( 'bank_label_account_name' ) ); ?></span>
                                <span class="text-base sm:text-lg font-bold text-foreground select-all"><?php echo esc_html( $bacs_name ); ?></span>
                            </div>
                            <button type="button" onclick="copyValue('<?php echo esc_js( $bacs_name ); ?>', this)" class="copy-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-border text-xs font-bold text-foreground bg-muted/40 hover:bg-muted transition-all active:scale-95 cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span><?php echo esc_html( waklert_option_text( 'bank_copy_label' ) ); ?></span>
                            </button>
                        </div>

                        <!-- Bank Name -->
                        <div class="bg-white/95 border border-border/80 rounded-xl py-2 px-3 sm:py-2.5 sm:px-3.5 flex items-center justify-between gap-2 shadow-xs">
                            <div>
                                <span class="text-[11px] uppercase tracking-wider font-bold text-muted-foreground block mb-0.5"><?php echo esc_html( waklert_option_text( 'bank_label_bank' ) ); ?></span>
                                <span class="text-base sm:text-lg font-bold text-foreground"><?php echo esc_html( $bacs_bank ); ?></span>
                            </div>
                            <span class="text-xs font-semibold text-muted-foreground px-2.5 py-1 bg-muted/40 rounded-lg"><?php echo esc_html( $bank['country'] ); ?></span>
                        </div>

                        <!-- BSB -->
                        <div class="bg-white/95 border border-border/80 rounded-xl py-2 px-3 sm:py-2.5 sm:px-3.5 flex items-center justify-between gap-2 shadow-xs hover:border-primary/50 transition-colors">
                            <div>
                                <span class="text-[11px] uppercase tracking-wider font-bold text-muted-foreground block mb-0.5"><?php echo esc_html( waklert_option_text( 'bank_label_bsb' ) ); ?></span>
                                <span class="text-xl sm:text-2xl font-mono font-extrabold text-foreground tracking-wider select-all"><?php echo esc_html( $bacs_bsb ); ?></span>
                            </div>
                            <button type="button" onclick="copyValue('<?php echo esc_js( str_replace(' ', '', $bacs_bsb) ); ?>', this)" class="copy-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-border text-xs font-bold text-foreground bg-muted/40 hover:bg-muted transition-all active:scale-95 cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span><?php echo esc_html( waklert_option_text( 'bank_copy_label' ) ); ?></span>
                            </button>
                        </div>

                        <!-- Account Number -->
                        <div class="bg-white/95 border border-border/80 rounded-xl py-2 px-3 sm:py-2.5 sm:px-3.5 flex items-center justify-between gap-2 shadow-xs hover:border-primary/50 transition-colors">
                            <div>
                                <span class="text-[11px] uppercase tracking-wider font-bold text-muted-foreground block mb-0.5"><?php echo esc_html( waklert_option_text( 'bank_label_account_number' ) ); ?></span>
                                <span class="text-xl sm:text-2xl font-mono font-extrabold text-foreground tracking-wider select-all"><?php echo esc_html( $bacs_acc ); ?></span>
                            </div>
                            <button type="button" onclick="copyValue('<?php echo esc_js( $bacs_acc ); ?>', this)" class="copy-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-border text-xs font-bold text-foreground bg-muted/40 hover:bg-muted transition-all active:scale-95 cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span><?php echo esc_html( waklert_option_text( 'bank_copy_label' ) ); ?></span>
                            </button>
                        </div>

                        <!-- PayID Card (Prominent display with Copy) -->
                        <div class="bg-white/95 border border-border/80 rounded-xl py-2 px-3 sm:py-2.5 sm:px-3.5 flex items-center justify-between gap-2 shadow-xs hover:border-primary/50 transition-colors sm:col-span-2">
                            <div>
                                <span class="text-[11px] uppercase tracking-wider font-bold block mb-0.5 text-[#D97706]" style="color: #d97706;"><?php echo esc_html( waklert_option_text( 'bank_label_payid' ) ); ?></span>
                                <span class="text-xl sm:text-2xl font-mono font-extrabold text-[#0C4161] tracking-wider select-all"><?php echo esc_html( $payid_number ); ?></span>
                            </div>
                            <button type="button" onclick="copyValue('<?php echo esc_js( preg_replace('/\s+/', '', $payid_number) ); ?>', this)" class="copy-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-border text-xs font-bold text-foreground bg-muted/40 hover:bg-muted transition-all active:scale-95 cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span><?php echo esc_html( waklert_option_text( 'bank_copy_label' ) ); ?></span>
                            </button>
                        </div>

                    </div>


                    <!-- Payment Badges Row (Exact Logo Height Matching Reference Image) -->
                    <div class="mt-3.5 pt-3 border-t border-[#EAB308]/30 flex flex-wrap items-center justify-center gap-3">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl border border-slate-200/90 bg-white shadow-2xs h-10">
                            <div class="w-4.5 h-4.5 rounded bg-[#FFCC00] flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-[#1A1A1A]" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 12l10 10 10-10L12 2zm0 4.2L17.8 12 12 17.8 6.2 12 12 6.2z"/></svg>
                            </div>
                            <span class="text-xs font-bold text-slate-800"><?php echo esc_html( $bacs_bank ); ?></span>
                        </div>
                        <div class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-xl border border-slate-200/90 bg-white shadow-2xs h-10">
                            <img src="<?php echo esc_url( $logo_src( 'thankyou_payid_logo', '/assets/images/payid.png' ) ); ?>" alt="<?php echo esc_attr( waklert_option_text( 'bank_label_payid' ) ); ?>" style="height: 18px; max-height: 18px; width: auto; object-fit: contain; display: block;" />
                        </div>
                        <div class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-xl border border-slate-200/90 bg-white shadow-2xs h-10">
                            <img src="<?php echo esc_url( $logo_src( 'thankyou_osko_logo', '/assets/images/osko.jpg' ) ); ?>" alt="Osko" style="height: 18px; max-height: 18px; width: auto; object-fit: contain; display: block;" />
                        </div>
                    </div>
                </div>

                <!-- Receipt Email Dispatch Notice -->
                <p class="text-xs text-muted-foreground italic text-center mb-3">
                    <?php
                    $receipt_notice_text = str_replace(
                        '{email}',
                        '<a href="mailto:' . esc_attr( $contact_email ) . '" class="font-bold text-foreground underline">' . esc_html( $contact_email ) . '</a>',
                        esc_html( $checkout_receipt_notice )
                    );
                    echo $receipt_notice_text;
                    ?>
                </p>

                <!-- Shipping Timeline Note -->
                <div class="bg-card border border-border/80 rounded-xl py-2.5 px-3.5 sm:py-3 sm:px-4 mb-3.5 sm:mb-4 shadow-xs" style="max-width: 48rem; margin-left: auto; margin-right: auto;">
                    <h4 class="font-bold text-foreground text-sm sm:text-base mb-1.5"><?php echo esc_html( waklert_option_text( 'thankyou_note_heading' ) ); ?></h4>
                    <p class="text-xs sm:text-sm text-muted-foreground leading-relaxed mb-0">
                        <?php echo esc_html( $shipping_note ); ?>
                    </p>
                </div>

            <?php endif; ?>

            <!-- WooCommerce Hook Outputs (Styled cleanly) -->
            <div class="thank-you-hooks-wrapper" style="max-width: 48rem; margin-left: auto; margin-right: auto;">
                <style>
                    /* Hide redundant duplicate plain BACS and old note */
                    .custom-bacs-details,
                    .woocommerce-bacs-bank-details,
                    .shipping-notice-thankyou { 
                        display: none !important; 
                    }
                    /* Modern order items table styling */
                    .woocommerce-order-details {
                        background: #FFFFFF;
                        border: 1px solid #E2E8F0;
                        border-radius: 1.5rem;
                        padding: 1.5rem;
                        margin-bottom: 2rem;
                        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
                        max-width: 48rem;
                        margin-left: auto;
                        margin-right: auto;
                    }
                    @media (min-width: 640px) {
                        .woocommerce-order-details { padding: 2rem; }
                    }
                    .woocommerce-order-details h2.woocommerce-order-details__title {
                        font-family: var(--font-heading, inherit);
                        font-size: 1.25rem !important;
                        font-weight: 800 !important;
                        color: #0F172A !important;
                        margin-top: 0 !important;
                        margin-bottom: 1.25rem !important;
                        padding-bottom: 1rem !important;
                        border-bottom: 1px solid #E2E8F0 !important;
                    }
                    /* Full-width responsive mobile enhancements */
                    @media (max-width: 640px) {
                        .container-custom {
                            padding-inline: 0.5rem !important;
                        }
                        .section-padding {
                            padding-block: 1rem !important;
                        }
                        .woocommerce-order {
                            padding-left: 0.25rem !important;
                            padding-right: 0.25rem !important;
                        }
                        .thank-you-hooks-wrapper {
                            background: transparent !important;
                            border: none !important;
                            border-radius: 0 !important;
                            box-shadow: none !important;
                            padding: 0 !important;
                            margin-top: 1rem !important;
                        }
                        .thank-you-hooks-wrapper > p {
                            display: none !important;
                        }
                        .woocommerce-order-details {
                            padding: 1rem !important;
                            border-radius: 1.25rem !important;
                        }
                        .woocommerce-customer-details address {
                            padding: 1rem !important;
                            border-radius: 1.25rem !important;
                        }
                    }
                    .thank-you-hooks-wrapper {
                        background: transparent !important;
                        border: none !important;
                        border-radius: 0 !important;
                        box-shadow: none !important;
                        padding: 0 !important;
                    }
                    .thank-you-hooks-wrapper > p {
                        display: none !important;
                    }
                    /* Ensure no table layout on mobile order details */
                    @media (max-width: 767px) {
                        .woocommerce-order-details table.shop_table,
                        .woocommerce-order-details table.woocommerce-table--order-details,
                        table.woocommerce-table--order-details {
                        width: 100% !important;
                        border-collapse: separate !important;
                        border-spacing: 0 !important;
                        border: 1px solid #E2E8F0 !important;
                        border-radius: 0.75rem !important;
                        overflow: hidden !important;
                    }
                    .woocommerce-table--order-details thead tr,
                    .woocommerce-order .woocommerce-table--order-details thead tr,
                    table.woocommerce-table--order-details thead tr {
                        background-color: #0C4161 !important;
                    }
                    .woocommerce-table--order-details thead th,
                    .woocommerce-order .woocommerce-table--order-details thead th,
                    table.woocommerce-table--order-details thead th,
                    th.woocommerce-table__product-name,
                    th.woocommerce-table__product-table {
                        color: #FFFFFF !important;
                        -webkit-text-fill-color: #FFFFFF !important;
                        font-weight: 800 !important;
                        font-size: 0.75rem !important;
                        text-transform: uppercase !important;
                        letter-spacing: 0.05em !important;
                        padding: 0.625rem 0.875rem !important;
                        border: none !important;
                    }
                    .woocommerce-table--order-details tbody td {
                        padding: 0.75rem 0.875rem !important;
                        border-bottom: 1px solid #F1F5F9 !important;
                        font-size: 0.875rem !important;
                        color: #1E293B !important;
                    }
                    .woocommerce-table--order-details tbody td a {
                        color: #0C4161 !important;
                        font-weight: 700 !important;
                        text-decoration: underline !important;
                    }
                    .woocommerce-table--order-details tbody td a:hover {
                        color: #0284C7 !important;
                    }
                    .woocommerce-table--order-details tfoot th {
                        font-weight: 600 !important;
                        color: #475569 !important;
                        text-align: left !important;
                        padding: 0.625rem 0.875rem !important;
                        border-top: 1px solid #F1F5F9 !important;
                        font-size: 0.875rem !important;
                    }
                    .woocommerce-table--order-details tfoot td {
                        text-align: right !important;
                        font-weight: 700 !important;
                        color: #0F172A !important;
                        padding: 0.625rem 0.875rem !important;
                        border-top: 1px solid #F1F5F9 !important;
                        font-size: 0.875rem !important;
                    }
                    .woocommerce-table--order-details tfoot tr.order-total,
                    .woocommerce-order .woocommerce-table--order-details tfoot tr.order-total {
                        background-color: #F0F7FC !important;
                        border-top: 2px solid #BAE6FD !important;
                        border-bottom: 2px solid #BAE6FD !important;
                    }
                    .woocommerce-table--order-details tfoot tr.order-total th,
                    .woocommerce-order .woocommerce-table--order-details tfoot tr.order-total th {
                        color: #0C4161 !important;
                        font-weight: 900 !important;
                        font-size: 1.25rem !important;
                    }
                    .woocommerce-table--order-details tfoot tr.order-total td,
                    .woocommerce-table--order-details tfoot tr.order-total td bdi,
                    .woocommerce-table--order-details tfoot tr.order-total td span,
                    .woocommerce-order .woocommerce-table--order-details tfoot tr.order-total td {
                        color: #0284C7 !important;
                        font-weight: 900 !important;
                        font-size: 1.625rem !important;
                    }
                    .woocommerce-customer-details {
                        width: 100% !important;
                        max-width: 48rem !important;
                        margin-top: 2rem !important;
                        margin-bottom: 2rem !important;
                        margin-left: auto !important;
                        margin-right: auto !important;
                    }
                    /* Customer addresses layout: Force 1 column on mobile, 2 columns on desktop */
                    .woocommerce .woocommerce-customer-details .col2-set,
                    .woocommerce-page .woocommerce-customer-details .col2-set,
                    .woocommerce-customer-details .col2-set,
                    .woocommerce-customer-details .woocommerce-columns--addresses,
                    section.woocommerce-columns--addresses {
                        display: flex !important;
                        flex-direction: column !important;
                        gap: 1.5rem !important;
                        width: 100% !important;
                    }
                    .woocommerce .woocommerce-customer-details .col-1,
                    .woocommerce .woocommerce-customer-details .col-2,
                    .woocommerce-page .woocommerce-customer-details .col-1,
                    .woocommerce-page .woocommerce-customer-details .col-2,
                    .woocommerce .col2-set .col-1,
                    .woocommerce .col2-set .col-2,
                    .woocommerce-page .col2-set .col-1,
                    .woocommerce-page .col2-set .col-2,
                    .woocommerce-customer-details .col-1,
                    .woocommerce-customer-details .col-2,
                    .woocommerce-customer-details .woocommerce-column,
                    div.woocommerce-column--billing-address,
                    div.woocommerce-column--shipping-address {
                        float: none !important;
                        width: 100% !important;
                        max-width: 100% !important;
                        flex: 1 1 100% !important;
                        box-sizing: border-box !important;
                        clear: both !important;
                    }
                    @media (max-width: 767px) {
                        .woocommerce-customer-details .col2-set,
                        .woocommerce-customer-details .woocommerce-columns--addresses,
                        section.woocommerce-columns--addresses {
                            display: flex !important;
                            flex-direction: column !important;
                            gap: 1.5rem !important;
                        }
                        .woocommerce-customer-details .col-1,
                        .woocommerce-customer-details .col-2,
                        div.woocommerce-column--billing-address,
                        div.woocommerce-column--shipping-address {
                            float: none !important;
                            width: 100% !important;
                            clear: both !important;
                            display: block !important;
                            margin-bottom: 1.5rem !important;
                        }
                    }
                    @media (min-width: 768px) {
                        .woocommerce .woocommerce-customer-details .col2-set,
                        .woocommerce-page .woocommerce-customer-details .col2-set,
                        .woocommerce-customer-details .col2-set,
                        .woocommerce-customer-details .woocommerce-columns--addresses,
                        section.woocommerce-columns--addresses {
                            display: grid !important;
                            grid-template-columns: 1fr 1fr !important;
                            gap: 1.5rem !important;
                        }
                        .woocommerce-customer-details .col-1,
                        .woocommerce-customer-details .col-2,
                        div.woocommerce-column--billing-address,
                        div.woocommerce-column--shipping-address {
                            margin-bottom: 0 !important;
                        }
                    }
                    .woocommerce-customer-details address {
                        display: block !important;
                        background: #FFFFFF !important;
                        border: 1px solid #E2E8F0 !important;
                        border-radius: 1.25rem !important;
                        padding: 1.5rem !important;
                        font-style: normal !important;
                        font-size: 0.9375rem !important;
                        line-height: 1.65 !important;
                        color: #334155 !important;
                        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04) !important;
                        width: 100% !important;
                        box-sizing: border-box !important;
                    }
                    .woocommerce-customer-details address p {
                        display: flex !important;
                        align-items: center !important;
                        gap: 0.5rem !important;
                        margin-top: 0.75rem !important;
                        margin-bottom: 0 !important;
                        color: #475569 !important;
                        font-size: 0.875rem !important;
                        word-break: break-all !important;
                    }
                    .woocommerce-customer-details h2.woocommerce-column__title {
                        font-family: var(--font-heading, inherit);
                        font-size: 1.125rem !important;
                        font-weight: 800 !important;
                        color: #0F172A !important;
                        margin-top: 0 !important;
                        margin-bottom: 0.75rem !important;
                        padding-bottom: 0.5rem !important;
                        border-bottom: 2px solid #E2E8F0 !important;
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
            <div class="mt-10 pt-8 border-t border-border/60 flex flex-col items-center text-center">
                <a href="<?php echo esc_url( $shop_page_url ); ?>" class="inline-flex items-center justify-center gap-2.5 px-8 py-4 rounded-full bg-primary hover:bg-primary-dark text-white font-extrabold text-base tracking-wide transition-all shadow-md hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 ring-4 ring-primary/10 w-full sm:w-auto">
                    <svg class="w-5 h-5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span><?php echo esc_html( waklert_option_text( 'thankyou_shop_button' ) ); ?></span>
                </a>
                <p class="text-xs text-muted-foreground mt-3 flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-emerald-600 inline shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span><?php echo esc_html( waklert_option_text( 'thankyou_footer_note' ) ); ?></span>
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
    btn.innerHTML = '<svg class="w-3.5 h-3.5 text-emerald-600 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg><span class="text-emerald-700 font-bold">' + <?php echo wp_json_encode( waklert_option_text( 'bank_copied_label' ) ); ?> + '</span>';
    btn.classList.add('border-emerald-300', 'bg-emerald-50');
    setTimeout(function() {
        btn.innerHTML = originalHTML;
        btn.classList.remove('border-emerald-300', 'bg-emerald-50');
    }, 2000);
}
</script>
