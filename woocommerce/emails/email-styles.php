<?php
/**
 * Email Styles - Waklert Australia Design (matching Armodafinil Direct)
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 10.8.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
body {
    padding: 0;
    margin: 0;
    -webkit-text-size-adjust: none !important;
    width: 100%;
    background-color: #f0f6fa;
}
#outer_wrapper {
    background-color: #f0f6fa;
}
#wrapper {
    margin: 0 auto;
    padding: 20px 0 40px;
    max-width: 600px;
}
#template_container {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 4px 16px -4px rgba(15,23,42,0.05);
    overflow: hidden;
}
#template_header {
    background-color: #0c4161;
    color: #ffffff;
    border-bottom: 0;
    border-radius: 12px 12px 0 0;
}
#header_wrapper {
    padding: 30px 40px;
    display: block;
    text-align: center;
}
#header_wrapper h1 {
    color: #ffffff;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    font-size: 26px;
    font-weight: 700;
    line-height: 1.3;
    margin: 0;
    text-shadow: none;
}
.email-logo-text {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    font-size: 20px;
    font-weight: 700;
    color: #09152b;
    text-align: center;
    margin-bottom: 20px;
}
#template_header_image {
    text-align: center;
    padding-bottom: 20px;
}
#template_header_image img {
    border: none;
    display: inline-block;
    font-size: 14px;
    font-weight: bold;
    height: auto;
    outline: none;
    text-decoration: none;
    text-transform: capitalize;
    vertical-align: middle;
    margin: 0 auto;
    max-width: 100%;
}
#body_content_inner {
    color: #334155;
    font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    font-size: 15px;
    line-height: 1.6;
    text-align: left;
}
#body_content_inner_cell {
    padding: 30px 40px;
}
h1, h2, h3, h4, h5, h6 {
    color: #09152b;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}
h2 {
    font-size: 20px;
    font-weight: 700;
    line-height: 1.3;
    margin: 0 0 16px;
}
h3 {
    font-size: 16px;
    font-weight: 700;
    line-height: 1.3;
    margin: 16px 0 8px;
}
a {
    color: #0284c7;
    font-weight: normal;
    text-decoration: underline;
}
p {
    margin: 0 0 16px;
}

/* Order Details Table matching Armodafinil Direct */
#body_content table.td {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    overflow: hidden;
}
#body_content table .email-order-details td,
#body_content table .email-order-details th {
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
}
#body_content table .email-order-details th {
    background-color: #f0f6fa;
    color: #09152b;
    font-weight: 600;
}
#body_content .email-order-details tbody tr:last-child td {
    border-bottom: 2px solid #e2e8f0;
}
#body_content .email-order-details .order-totals td,
#body_content .email-order-details .order-totals th {
    padding: 10px 16px;
    border-bottom: 1px solid #e2e8f0;
}
#body_content .email-order-details .order-totals th {
    background-color: #f0f6fa;
    color: #09152b;
    font-weight: 600;
}
#body_content .email-order-details .order-totals-total th {
    font-weight: 700;
    color: #09152b;
    background-color: #f0f6fa;
}
#body_content .email-order-details .order-totals-total td {
    font-weight: 700;
    color: #09152b;
    font-size: 18px;
}
#body_content .email-order-details .order-totals-last td,
#body_content .email-order-details .order-totals-last th {
    border-bottom: none;
}

.td {
    color: #334155;
    border: 1px solid #e2e8f0;
    vertical-align: middle;
}
.address {
    padding: 16px;
    color: #334155;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background-color: #f0f6fa;
    word-break: break-word;
    font-style: normal;
    line-height: 1.5;
}
.text,
.address-title,
.order-item-data {
    color: #09152b;
    font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}
.link {
    color: #0284c7;
}

#template_footer {
    padding: 0;
}
#template_footer_inner {
    padding: 24px 0 0;
}
#template_footer #credit {
    border: 0;
    color: #64748b;
    font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    font-size: 13px;
    line-height: 1.5;
    text-align: center;
    padding: 0 20px;
}
#template_footer #credit a {
    color: #0c4161;
    text-decoration: none;
    font-weight: 600;
}

@media screen and (max-width: 600px) {
    #header_wrapper {
        padding: 20px !important;
    }
    #header_wrapper h1 {
        font-size: 22px !important;
    }
    #body_content_inner_cell {
        padding: 20px !important;
    }
    #body_content_inner {
        font-size: 14px !important;
    }
}
