<?php
/**
 * Email Styles - Waklert Australia Bespoke Design
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 10.8.0
 */

defined( 'ABSPATH' ) || exit;

// Waklert Australia Brand Colors
$primary_navy   = '#0C4161';
$primary_dark   = '#082A3F';
$sky_blue       = '#0284C7';
$sky_light      = '#E0F2FE';
$sky_border     = '#BAE6FD';
$bg_canvas      = '#F1F5F9';
$card_bg        = '#FFFFFF';
$text_main      = '#0F172A';
$text_muted     = '#64748B';
$border_color   = '#E2E8F0';
$highlight_gold = '#EAB308';
$gold_bg        = '#FEFCE8';
$gold_border    = '#FEF08A';
$font_family    = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif';
?>

/* Global Styles */
body {
	background-color: <?php echo esc_attr( $bg_canvas ); ?>;
	padding: 24px 0 36px 0;
	margin: 0;
	font-family: <?php echo $font_family; ?>;
	-webkit-font-smoothing: antialiased;
	-moz-osx-font-smoothing: grayscale;
	color: <?php echo esc_attr( $text_main ); ?>;
}

#outer_wrapper {
	background-color: <?php echo esc_attr( $bg_canvas ); ?>;
}

#wrapper {
	background-color: transparent;
	margin: 0 auto;
	padding: 0;
	-webkit-text-size-adjust: none !important;
	width: 100%;
	max-width: 640px;
}

/* Template Container Card */
#template_container {
	background-color: <?php echo esc_attr( $card_bg ); ?>;
	border: 1px solid <?php echo esc_attr( $border_color ); ?>;
	border-radius: 20px;
	overflow: hidden;
	box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
}

/* Header Gradient */
#template_header {
	background: linear-gradient(135deg, <?php echo esc_attr( $primary_navy ); ?> 0%, <?php echo esc_attr( $primary_dark ); ?> 100%);
	background-color: <?php echo esc_attr( $primary_navy ); ?>;
	color: #FFFFFF;
	border-top-left-radius: 19px;
	border-top-right-radius: 19px;
	border-bottom: 3px solid <?php echo esc_attr( $sky_blue ); ?>;
}

#header_wrapper {
	padding: 36px 28px 32px 28px;
	text-align: center;
}

#header_wrapper h1 {
	color: #FFFFFF !important;
	font-family: <?php echo $font_family; ?> !important;
	font-size: 26px !important;
	font-weight: 800 !important;
	line-height: 1.25 !important;
	margin: 0 0 8px 0 !important;
	text-align: center !important;
	letter-spacing: -0.3px;
	text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.email-subheading {
	color: #BAE6FD !important;
	font-family: <?php echo $font_family; ?> !important;
	font-size: 14px !important;
	font-weight: 500 !important;
	margin: 0 !important;
	text-align: center !important;
}

/* Body Content Inner */
#body_content {
	background-color: <?php echo esc_attr( $card_bg ); ?>;
}

#body_content_inner_cell {
	padding: 32px 28px 24px 28px !important;
}

#body_content_inner {
	color: <?php echo esc_attr( $text_main ); ?>;
	font-family: <?php echo $font_family; ?>;
	font-size: 15px;
	line-height: 1.6;
	text-align: left;
}

/* Headings */
h1, h2, h3, h4 {
	color: <?php echo esc_attr( $primary_navy ); ?>;
	font-family: <?php echo $font_family; ?>;
	font-weight: 800;
	margin: 0 0 16px 0;
	line-height: 1.3;
}

h2 {
	font-size: 19px !important;
	border-bottom: 2px solid <?php echo esc_attr( $border_color ); ?>;
	padding-bottom: 10px;
	margin-top: 28px;
	margin-bottom: 16px;
}

h3 {
	font-size: 16px !important;
	margin-bottom: 12px;
}

/* Paragraphs & Text */
p {
	margin: 0 0 16px;
	color: <?php echo esc_attr( $text_main ); ?>;
	font-size: 15px;
	line-height: 1.6;
}

a {
	color: <?php echo esc_attr( $sky_blue ); ?>;
	font-weight: 600;
	text-decoration: underline;
}

a:hover {
	color: <?php echo esc_attr( $primary_navy ); ?>;
}

/* Order Table */
.td, table.td {
	border-color: <?php echo esc_attr( $border_color ); ?> !important;
}

table[border="1"] {
	border-collapse: separate !important;
	border-spacing: 0 !important;
	border: 1px solid <?php echo esc_attr( $border_color ); ?> !important;
	border-radius: 12px !important;
	overflow: hidden !important;
	margin-bottom: 24px !important;
	width: 100% !important;
}

table[border="1"] th {
	background-color: #F8FAFC !important;
	color: <?php echo esc_attr( $primary_navy ); ?> !important;
	font-size: 13px !important;
	font-weight: 700 !important;
	text-transform: uppercase !important;
	letter-spacing: 0.5px !important;
	padding: 12px 16px !important;
	border-top: none !important;
	border-left: none !important;
	border-right: none !important;
	border-bottom: 2px solid <?php echo esc_attr( $border_color ); ?> !important;
}

table[border="1"] td {
	padding: 14px 16px !important;
	border-top: none !important;
	border-left: none !important;
	border-right: none !important;
	border-bottom: 1px solid <?php echo esc_attr( $border_color ); ?> !important;
	color: <?php echo esc_attr( $text_main ); ?> !important;
	font-size: 14px !important;
}

table[border="1"] tr:last-child td,
table[border="1"] tr:last-child th {
	border-bottom: none !important;
}

/* Order Totals */
.order-totals th {
	background-color: #F8FAFC !important;
	color: <?php echo esc_attr( $text_muted ); ?> !important;
	font-weight: 600 !important;
	text-align: left !important;
}

.order-totals td {
	font-weight: 700 !important;
	color: <?php echo esc_attr( $text_main ); ?> !important;
	text-align: right !important;
}

.order-totals-total th {
	font-size: 15px !important;
	font-weight: 800 !important;
	color: <?php echo esc_attr( $primary_navy ); ?> !important;
	background-color: <?php echo esc_attr( $sky_light ); ?> !important;
	border-top: 2px solid <?php echo esc_attr( $sky_border ); ?> !important;
}

.order-totals-total td {
	font-size: 18px !important;
	font-weight: 800 !important;
	color: <?php echo esc_attr( $sky_blue ); ?> !important;
	background-color: <?php echo esc_attr( $sky_light ); ?> !important;
	border-top: 2px solid <?php echo esc_attr( $sky_border ); ?> !important;
}

/* Customer Addresses */
#addresses {
	margin-top: 24px;
	margin-bottom: 20px;
}

#addresses td {
	padding: 0 10px 0 0 !important;
}

#addresses td + td {
	padding: 0 0 0 10px !important;
}

#addresses h2 {
	margin-top: 0;
	border-bottom: none;
	padding-bottom: 6px;
	font-size: 16px !important;
}

address.address {
	background-color: #F8FAFC;
	border: 1px solid <?php echo esc_attr( $border_color ); ?>;
	border-radius: 12px;
	padding: 16px;
	font-style: normal;
	font-size: 14px;
	line-height: 1.6;
	color: <?php echo esc_attr( $text_main ); ?>;
}

/* Custom BACS / Bank Transfer Card in Email */
.email-bank-instructions-box {
	background-color: <?php echo esc_attr( $gold_bg ); ?>;
	border: 2px solid <?php echo esc_attr( $highlight_gold ); ?>;
	border-radius: 14px;
	padding: 20px;
	margin: 24px 0;
}

.email-bank-title {
	font-family: <?php echo $font_family; ?>;
	font-size: 16px;
	font-weight: 800;
	color: #854D0E;
	margin: 0 0 8px 0;
}

.email-bank-account-table {
	width: 100%;
	border-collapse: collapse;
	margin-top: 12px;
}

.email-bank-account-table td {
	padding: 8px 12px;
	font-size: 14px;
	border-bottom: 1px dashed #FDE047;
}

.email-bank-account-table tr:last-child td {
	border-bottom: none;
}

/* Responsive Rules */
@media screen and (max-width: 600px) {
	body {
		padding: 10px 0 !important;
	}
	#wrapper {
		width: 100% !important;
	}
	#template_container {
		border-radius: 14px !important;
	}
	#template_header {
		border-radius: 13px 13px 0 0 !important;
	}
	#header_wrapper {
		padding: 24px 16px 20px 16px !important;
	}
	#header_wrapper h1 {
		font-size: 22px !important;
	}
	#body_content_inner_cell {
		padding: 20px 16px !important;
	}
	#addresses td {
		display: block !important;
		width: 100% !important;
		padding: 0 0 16px 0 !important;
	}
	#addresses td + td {
		padding: 0 !important;
	}
}
