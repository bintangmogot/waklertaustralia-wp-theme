<?php
/**
 * Email Header - Waklert Australia Design (matching Armodafinil Direct)
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 10.7.0
 */

defined( 'ABSPATH' ) || exit;

$store_name = $store_name ?? get_bloginfo( 'name', 'display' );
if ( empty( $store_name ) ) {
    $store_name = 'Waklert Australia';
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<title><?php echo esc_html( $store_name ); ?></title>
	</head>
	<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<table width="100%" id="outer_wrapper" role="presentation">
			<tr>
				<td></td>
				<td width="600">
					<div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
						<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="inner_wrapper" role="presentation">
							<tr>
								<td align="center" valign="top">
                                    
                                    <!-- Preheader Preview Text for Email Clients -->
                                    <div style="display: none; font-size: 1px; color: #ffffff; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all;">
                                        Waklert Australia - Thank you for your order.
                                    </div>

                                    <!-- HTML Logo matching Armodafinil Direct format -->
                                    <div id="template_header_image" style="margin-bottom: 24px; text-align: center;">
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: #0c4161; font-weight: normal; text-decoration: none; display: inline-block;">
                                            <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin: 0 auto;">
                                                <tr>
                                                    <!-- Icon box -->
                                                    <td valign="middle" style="padding-right: 12px;">
                                                        <div style="width: 40px; height: 40px; border-radius: 12px; background-color: #0c4161; text-align: center; line-height: 40px;">
                                                            <span style="color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 19px; font-weight: bold; letter-spacing: -0.5px;">W</span>
                                                        </div>
                                                    </td>
                                                    <!-- Text -->
                                                    <td valign="middle" style="text-align: left;">
                                                        <div style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 22px; font-weight: 800; color: #09152b; line-height: 1.1; mso-line-height-rule: exactly;">Waklert</div>
                                                        <div style="font-family: Inter, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; font-size: 10px; text-transform: uppercase; letter-spacing: 2px; color: #0284c7; margin-top: 4px; line-height: 1; font-weight: 700;">Australia</div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </a>
                                    </div>

									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_container" role="presentation">
										<tr>
											<td align="center" valign="top">
												<!-- Header -->
												<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header" role="presentation">
													<tr>
														<td id="header_wrapper">
															<h1><?php echo esc_html( $email_heading ); ?></h1>
														</td>
													</tr>
												</table>
												<!-- End Header -->
											</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<!-- Body -->
												<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_body" role="presentation">
													<tr>
														<td valign="top" id="body_content">
															<!-- Content -->
															<table border="0" cellpadding="20" cellspacing="0" width="100%" role="presentation">
																<tr>
																	<td valign="top" id="body_content_inner_cell">
																		<div id="body_content_inner">
