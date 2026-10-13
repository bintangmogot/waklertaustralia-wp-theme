<?php
/**
 * Australian dollar currency symbol.
 * Display currency as $ without the "A" prefix across the site (e.g. $150.00).
 */
add_filter('woocommerce_currency_symbol', function ($currency_symbol, $currency) {
    return '$';
}, 999, 2);

