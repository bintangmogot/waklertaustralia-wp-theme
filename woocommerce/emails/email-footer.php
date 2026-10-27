<?php
/**
 * Email Footer - Waklert Australia Bespoke Design
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 10.4.0
 */

defined( 'ABSPATH' ) || exit;

$support_email = 'steven@hoppingmad.com.au';
$phone_display = function_exists( 'get_field' ) ? ( get_field( 'whatsapp_button_text', 'option' ) ?: '0488 841 833' ) : '0488 841 833';
$site_url      = home_url( '/' );
?>
																		</div>
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
												<!-- End Body -->
											</td>
										</tr>
									</table>
									<!-- End Main Container Card -->

								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Footer Card -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_footer" role="presentation">
										<tr>
											<td valign="top" style="padding: 28px 24px 36px 24px; text-align: center;">
												
												<!-- Trust & Support Badge Box -->
												<table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation" style="margin-bottom: 24px; background-color: #F8FAFC; border: 1px dashed #CBD5E1; border-radius: 14px;">
													<tr>
														<td style="padding: 16px 20px; text-align: center;">
															<p style="margin: 0 0 6px 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 700; color: #0C4161;">
																Need Help or Have Any Questions?
															</p>
															<p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 13px; color: #475569; line-height: 1.5;">
																Direct Australian customer support: <a href="mailto:<?php echo esc_attr( $support_email ); ?>" style="color: #0284C7; font-weight: 700; text-decoration: none;"><?php echo esc_html( $support_email ); ?></a>
																&bull; Phone / SMS: <strong style="color: #0F172A;"><?php echo esc_html( $phone_display ); ?></strong>
															</p>
														</td>
													</tr>
												</table>

												<!-- Australia Post Express Guarantee -->
												<p style="margin: 0 0 12px 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 12px; color: #64748B; line-height: 1.5;">
													All orders are dispatched discreetly in plain packaging via Australia Post Express with unique tracking.
												</p>

												<!-- Copyright -->
												<p style="margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 12px; color: #94A3B8;">
													&copy; <?php echo esc_html( date( 'Y' ) ); ?> <a href="<?php echo esc_url( $site_url ); ?>" style="color: #64748B; text-decoration: underline; font-weight: 600;">Waklert Australia</a>. All rights reserved.
												</p>

											</td>
										</tr>
									</table>
									<!-- End Footer -->
								</td>
							</tr>
						</table>
					</div>
				</td>
				<td><!-- Deliberately empty for responsive centering --></td>
			</tr>
		</table>
	</body>
</html>
