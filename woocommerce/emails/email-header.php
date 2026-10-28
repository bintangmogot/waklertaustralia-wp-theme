<?php
/**
 * Email Header - Waklert Australia Exact Match
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

$logo_url = function_exists( 'waklert_get_logo_url' ) ? waklert_get_logo_url( 'header' ) : '';
if ( empty( $logo_url ) ) {
    $theme_logo = get_template_directory() . '/assets/images/waklert-australia-logo.png';
    if ( file_exists( $theme_logo ) ) {
        $logo_url = get_template_directory_uri() . '/assets/images/waklert-australia-logo.png';
    }
}
$header_image_url = home_url( '/' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<title><?php echo esc_html( $store_name ); ?></title>
	</head>
	<body <?php echo is_rtl() ? 'rightmargin' : 'leftmargin'; ?>="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
		<table width="100%" id="outer_wrapper" role="presentation" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td><!-- Deliberately empty for responsive centering --></td>
				<td width="640" style="max-width: 640px; margin: 0 auto;">
					<div id="wrapper" dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
						<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="inner_wrapper" role="presentation">
							<tr>
								<td align="center" valign="top">
									
									<!-- Preheader Preview Text for Email Clients -->
									<div style="display: none; font-size: 1px; color: #ffffff; line-height: 1px; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all;">
										<?php echo esc_html( $store_name ); ?> &bull; Order Confirmation
									</div>

									<!-- Main Container Card -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_container" role="presentation">
										<tr>
											<td align="left" valign="top" style="padding: 32px 32px 0 32px;">
												<!-- Brand Logo Header (Left-aligned as in target screenshot) -->
												<?php if ( $logo_url ) : ?>
													<a href="<?php echo esc_url( $header_image_url ); ?>" target="_blank" style="text-decoration: none; display: inline-block;">
														<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $store_name ); ?>" width="180" style="max-width: 180px; height: auto; display: block; border: 0; outline: none; margin: 0 0 24px 0;" />
													</a>
												<?php else : ?>
													<a href="<?php echo esc_url( $header_image_url ); ?>" target="_blank" style="text-decoration: none; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 24px; font-weight: 800; color: #0C4161; display: inline-block; margin-bottom: 24px;">
														<?php echo esc_html( $store_name ); ?>
													</a>
												<?php endif; ?>

												<!-- Heading: Thank you for your order (Left-aligned, clean dark typography) -->
												<h1 style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; font-size: 28px; font-weight: 800; color: #0F172A; margin: 0 0 20px 0; line-height: 1.25; text-align: left; letter-spacing: -0.3px;">
													<?php echo esc_html( $email_heading ); ?>
												</h1>
											</td>
										</tr>
										<tr>
											<td align="left" valign="top">
												<!-- Body Content -->
												<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_body" role="presentation">
													<tr>
														<td valign="top" id="body_content" style="padding: 0 32px 32px 32px;">
															<table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
																<tr>
																	<td valign="top" id="body_content_inner_cell" style="padding: 0 !important;">
																		<div id="body_content_inner">
