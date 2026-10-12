<?php
/**
 * Australian dollar currency symbol.
 * On product pages, prices show without the "A" prefix (e.g. $150.00).
 */
add_filter('woocommerce_currency_symbol', function ($currency_symbol, $currency) {
    if (is_product() || is_singular('product')) {
        return '$';
    }
    return $currency === 'AUD' ? 'A$' : $currency_symbol;
}, 99, 2);

