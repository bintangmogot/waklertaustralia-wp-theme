<?php
/**
 * Keep Australian dollar prices explicit, matching the Direct storefront.
 */
add_filter('woocommerce_currency_symbol', function ($currency_symbol, $currency) {
    return $currency === 'AUD' ? 'A$' : $currency_symbol;
}, 10, 2);
