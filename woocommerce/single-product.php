<?php
/**
 * The Template for displaying all single products
 * Uses the Waklert Australia theme's WooCommerce product layout.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop');

global $product;

// Ensure we have a proper WC_Product object
if (!is_a($product, 'WC_Product')) {
    $product = wc_get_product(get_the_ID());
}

if (!$product) {
    get_footer('shop');
    return;
}

$product_modules = get_field('modules', $product->get_id()) ?: [];
$product_summary_module = '';
$product_description_module = '';

foreach ($product_modules as $module) {
    $layout = $module['acf_fc_layout'] ?? '';

    if ($layout === 'product_summary' && $product_summary_module === '') {
        $product_summary_module = $module['content'] ?? '';
    } elseif ($layout === 'product_description' && $product_description_module === '') {
        $product_description_module = $module['content'] ?? '';
    }
}

// Retain the former ACF fields as a fallback for products that have not been migrated.
$acf_short = $product_summary_module ?: get_post_meta($product->get_id(), 'short_desc', true);

if ($acf_short) {
    $summary = $acf_short ?: '';
} else {
// Parse the product summary from legacy HTML comments when present.
    $summary_raw = $product->get_short_description();
    preg_match('/<!-- en -->(.+?)<!-- \/en -->/s', $summary_raw, $en_match);
    preg_match('/<!-- ms -->(.+?)<!-- \/ms -->/s', $summary_raw, $ms_match);
    $summary = !empty($en_match[1]) ? trim($en_match[1]) : strip_tags($summary_raw, '<p><a><strong><b><i><em><ul><ol><li><br>');
}

$image = wp_get_attachment_image_url($product->get_image_id(), 'large') ?: '';

// Fetch variations if it's a variable product
$variations = [];
if ($product->is_type('variable')) {
    $variations = $product->get_available_variations();
}
$default_variation_index = 0;
$lowest_variation_price = INF;
foreach ($variations as $variation_index => $variation_data) {
    if (!isset($variation_data['display_price']) || !is_numeric($variation_data['display_price'])) {
        continue;
    }
    if (isset($variation_data['is_in_stock']) && !$variation_data['is_in_stock']) {
        continue;
    }

    $variation_price = (float) $variation_data['display_price'];
    if ($variation_price < $lowest_variation_price) {
        $lowest_variation_price = $variation_price;
        $default_variation_index = $variation_index;
    }
}

$text_under_image = get_field('text_under_product_image', $product->get_id()); // ACF field
$product_id = $product->get_id();
$review_summary = waklert_get_product_review_summary($product_id);
$reviews = $review_summary['reviews'];
$unit_price = waklert_get_product_unit_price($product);
$display_unit_price = $unit_price;
$unit_price_lead = 'From ';
if ($product->is_type('variable') && isset($variations[$default_variation_index])) {
    $default_variation = $variations[$default_variation_index];
    $default_variation_product = wc_get_product($default_variation['variation_id'] ?? 0);
    $default_pack_count = $default_variation_product
        ? waklert_get_product_pack_count($product, $default_variation_product)
        : 0;
    if ($default_pack_count > 0) {
        $display_unit_price = (float) $default_variation['display_price'] / $default_pack_count;
        $unit_price_lead = '';
    }
}
$unit_currency = get_woocommerce_currency();
$unit_currency_symbol = $unit_currency === 'AUD' ? 'A$' : get_woocommerce_currency_symbol($unit_currency);
$unit_price_decimals = wc_get_price_decimals();
$unit_price_decimal_separator = wc_get_price_decimal_separator();
$unit_price_thousand_separator = wc_get_price_thousand_separator();
$product_badge = trim((string) get_field('product_badge', $product_id));
if ($product_badge === '' && $product->is_featured()) {
    $product_badge = waklert_get_product_presentation_option('best_seller_label', 'Best Seller');
}
$free_shipping_message = waklert_get_product_presentation_option('free_shipping_message', 'Free shipping on orders above');
$free_shipping_threshold = get_field('free_shipping_threshold', 'option');
$free_shipping_threshold = is_numeric($free_shipping_threshold) ? $free_shipping_threshold : 299;
$trust_items = array_values(array_filter([
    [
        'label' => waklert_get_product_presentation_option('product_trust_dispatch', 'AU-wide dispatch'),
        'icon' => 'fi-rr-truck-side',
    ],
    [
        'label' => waklert_get_product_presentation_option('product_trust_checkout', 'Encrypted checkout'),
        'icon' => 'fi-rr-lock',
    ],
    [
        'label' => waklert_get_product_presentation_option('product_trust_quality', 'Quality verified'),
        'icon' => 'fi-rr-shield-check',
    ],
], static function ($item) {
    return trim((string) $item['label']) !== '';
}));
$product_specs_heading = waklert_get_product_presentation_option('product_specs_heading', 'Product specs');
$no_reviews_text = waklert_get_product_presentation_option('product_no_reviews_text', 'No reviews yet');
$product_specs = [
    [
        'label' => waklert_get_product_presentation_option('product_specs_active_label', 'Active Ingredient'),
        'value' => get_field('product_active_ingredient', $product_id),
    ],
    [
        'label' => waklert_get_product_presentation_option('product_specs_indication_label', 'Indication'),
        'value' => get_field('product_indication', $product_id),
    ],
    [
        'label' => waklert_get_product_presentation_option('product_specs_manufacturer_label', 'Manufacturer'),
        'value' => get_field('product_manufacturer', $product_id) ?: (waklert_get_product_attribute_by_label($product, '/manufacturer|brand/i') ?: $product->get_meta('brand')),
    ],
    [
        'label' => waklert_get_product_presentation_option('product_specs_strength_label', 'Strength'),
        'value' => waklert_get_product_strength($product),
    ],
    [
        'label' => waklert_get_product_presentation_option('product_specs_packaging_label', 'Packaging'),
        'value' => get_field('product_packaging', $product_id) ?: waklert_get_product_attribute_by_label($product, '/packaging/i'),
    ],
    [
        'label' => waklert_get_product_presentation_option('product_specs_delivery_label', 'Delivery Time'),
        'value' => get_field('product_delivery_time', $product_id),
    ],
];
?>

<div class="container-site py-4">
    <nav class="flex items-center gap-2 text-sm text-slate-500" data-testid="breadcrumb">
        <a href="<?= home_url('/') ?>"
            class="hover:text-slate-900 transition-colors"><?= "Home" ?></a>
        <span>/</span>
        <a href="<?= wc_get_page_permalink('shop') ?>"
            class="hover:text-slate-900 transition-colors"><?= "Products" ?></a>
        <span>/</span>
        <span class="text-slate-900"><?= esc_html($product->get_name()) ?></span>
    </nav>
</div>

<section class="container-site pb-12">
    <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
        <!-- Left Column: Image Area -->
        <div class="md:sticky md:top-24 md:self-start">
            <div class="rounded-md overflow-hidden bg-white border border-slate-200 p-4 flex items-center justify-center"
                data-testid="product-image">
                <img src="<?= esc_url($image) ?>"
                    alt="<?= esc_attr($product->get_name()) ?>"
                    class="max-w-full max-h-[500px] object-contain">
            </div>

            <!-- ACF: Text under product image -->
            <?php if (!empty($text_under_image)): ?>
                <div class="mt-8 prose prose-slate prose-sm max-w-none rounded-xl border border-slate-200 bg-white p-6">
                    <?= $text_under_image ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Column: Info Area -->
        <div>
            <div class="mb-3 flex flex-wrap items-center gap-2">
                <?php if ($product_badge !== ''): ?>
                    <span class="inline-flex rounded-full bg-primary-softer px-3 py-1 text-xs font-bold text-primary-dark">
                        <?= esc_html($product_badge) ?>
                    </span>
                <?php endif; ?>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white px-3 py-1 text-xs font-semibold text-primary-dark ring-1 ring-border">
                    <span class="h-1.5 w-1.5 rounded-full <?= $product->is_in_stock() ? 'bg-primary' : 'bg-destructive' ?>" aria-hidden="true"></span>
                    <?= esc_html($product->is_in_stock() ? 'In stock' : 'Out of stock') ?>
                </span>
            </div>
            <h1 class="font-heading text-2xl md:text-3xl font-extrabold mb-3 text-slate-900"
                data-testid="text-product-title">
                <?= esc_html($product->get_name()) ?>
            </h1>

            <?php if ($review_summary['review_count'] > 0): ?>
                <a href="#product-reviews" class="mb-4 inline-flex items-center gap-1.5 text-sm text-muted-foreground transition-colors hover:text-primary-dark" aria-label="Read <?= esc_attr($review_summary['review_count']) ?> customer reviews">
                    <?php if ($review_summary['rating_count'] > 0): ?>
                        <span class="text-accent" aria-hidden="true">★★★★★</span>
                        <span class="font-semibold text-ink"><?= esc_html(number_format($review_summary['average_rating'], 1)) ?></span>
                        <span aria-hidden="true">·</span>
                    <?php endif; ?>
                    <span>(<?= esc_html($review_summary['review_count']) ?> <?= esc_html($review_summary['review_count'] === 1 ? 'review' : 'reviews') ?>)</span>
                </a>
            <?php else: ?>
                <a href="#product-reviews" class="mb-4 inline-flex text-sm text-muted-foreground transition-colors hover:text-primary-dark">
                    <?= esc_html($no_reviews_text) ?>
                </a>
            <?php endif; ?>

            <div class="mb-4">
                <span class="text-2xl font-extrabold text-primary" data-testid="text-product-price">
                    <?php
                    if ($product->is_type('variable')) {
                        echo "From " . wp_kses_post(wc_price($product->get_variation_price('min')));
                    } else {
                        echo $product->get_price_html();
                    }
                    ?>
                </span>
        <?php if ($display_unit_price !== null): ?>
            <p id="product-unit-price" class="mt-1 text-sm font-semibold text-primary-dark" aria-live="polite"
                data-currency-symbol="<?= esc_attr($unit_currency_symbol) ?>"
                data-decimals="<?= esc_attr($unit_price_decimals) ?>"
                data-decimal-separator="<?= esc_attr($unit_price_decimal_separator) ?>"
                data-thousand-separator="<?= esc_attr($unit_price_thousand_separator) ?>">
                <?= esc_html($unit_price_lead . waklert_format_product_unit_price($display_unit_price) . '/tablet') ?>
            </p>
        <?php endif; ?>
            </div>

            <div class="prose prose-sm text-slate-600 mb-6 max-w-none" data-testid="text-product-description">
                <?= wp_kses_post($summary) ?>
            </div>

            <?php if ($free_shipping_message !== '' && is_numeric($free_shipping_threshold) && (float) $free_shipping_threshold > 0): ?>
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-ink">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white text-accent" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 11v5" />
                            <path d="M12 8h.01" />
                        </svg>
                    </span>
                    <?php
                    $free_shipping_threshold = (float) $free_shipping_threshold;
                    $free_shipping_decimals = $free_shipping_threshold === floor($free_shipping_threshold)
                        ? 0
                        : wc_get_price_decimals();
                    ?>
                    <span><?= esc_html($free_shipping_message) ?> <strong class="font-extrabold"><?= wp_kses_post(wc_price($free_shipping_threshold, ['decimals' => $free_shipping_decimals])) ?></strong></span>
                </div>
            <?php endif; ?>

            <?php if ($product->is_in_stock() && !empty($variations)): ?>

                <form id="product-purchase-form" class="mb-6 cart custom-variations-form" action="" method="post" enctype='multipart/form-data'>

                    <div class="space-y-4" data-testid="variation-selector">
                        <div>
                            <label
                                class="text-sm font-medium text-foreground mb-2 block"><?= "Select Option" ?></label>

                            <div class="space-y-2" id="variation-rows">
                                <?php 
                                // Determine the correct attribute key dynamically (e.g., attribute_pa_pack-size)
                                $first_attr_key = 'attribute_pa_quantity';
                                if (!empty($variations) && !empty($variations[0]['attributes'])) {
                                    $keys = array_keys($variations[0]['attributes']);
                                    if (!empty($keys)) {
                                        $first_attr_key = $keys[0];
                                    }
                                }
                                
                                $sticky_default_pack_label = '';
                                foreach ($variations as $i => $variation):
                                    // Read pack quantity from the actual variation attribute.
                                    $qty_str = isset($variation['attributes'][$first_attr_key]) ? $variation['attributes'][$first_attr_key] : '';
                                    if (empty($qty_str) && !empty($variation['attributes'])) {
                                        $qty_str = reset($variation['attributes']); // Fallback
                                    }

                                    $variation_product = wc_get_product($variation['variation_id']);
                                    $first_attr_name = preg_replace('/^attribute_/', '', $first_attr_key);
                                    $display_qty_str = $variation_product ? $variation_product->get_attribute($first_attr_name) : '';
                                    $display_qty_str = $display_qty_str ?: str_replace(['-', '_'], ' ', (string) $qty_str);
                                    $display_qty_str = trim(preg_replace('/\s+/', ' ', wp_strip_all_tags($display_qty_str)));
                                    $display_qty_str = $display_qty_str !== '' ? ucwords($display_qty_str) : 'Pack size not listed';
                                    $qty_num = $variation_product ? waklert_get_product_pack_count($product, $variation_product) : 0;

                                    $price_num = (float) $variation['display_price'];
                                    $per_tab_price = $qty_num > 0 ? $price_num / $qty_num : null;
                                    $is_active = ($i === $default_variation_index);
                                    if ($is_active) {
                                        $sticky_default_pack_label = $display_qty_str;
                                    }
                                    $sticky_price_label = wp_strip_all_tags(wc_price($price_num));
                                    ?>
                                    <button type="button"
                                        class="variation-row-btn w-full flex items-center justify-between gap-4 px-4 py-3 rounded-md border text-left transition-colors <?php echo $is_active ? 'border-primary bg-primary-softer text-primary-dark active-row' : 'border-slate-200 bg-white text-slate-700 hover:border-primary/50'; ?>"
                                        data-id="<?= esc_attr($variation['variation_id']) ?>"
                                        data-qty="<?= esc_attr($qty_num) ?>" data-price="<?= esc_attr($price_num) ?>"
                                        data-pack-label="<?= esc_attr($display_qty_str) ?>" data-display-price="<?= esc_attr($sticky_price_label) ?>"
                                        data-per-tab="<?= esc_attr($per_tab_price ?? '') ?>" data-val="<?= esc_attr($qty_str) ?>">

                                        <span class="text-sm font-semibold"><?= esc_html($display_qty_str) ?></span>
                                        <span class="text-right shrink-0">
                                            <span
                                                class="text-sm font-extrabold text-primary block leading-snug"><?= wp_kses_post(wc_price($price_num)) ?></span>
                                            <?php if ($per_tab_price !== null): ?>
                                                <span class="text-[10px] text-emerald-600 block leading-none -mt-px">
                                                    <?= esc_html(waklert_format_product_unit_price($per_tab_price)) ?>/tablet
                                                </span>
                                            <?php endif; ?>
                                        </span>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Quantity Selector -->
                        <div class="flex items-center gap-3">
                            <label
                                class="text-sm font-medium text-foreground"><?= "Quantity" ?></label>
                            <div class="flex items-center border border-slate-200 rounded-md bg-white">
                                <button type="button" id="qty-dec"
                                    class="w-9 h-9 flex items-center justify-center text-muted-foreground hover:text-foreground transition-colors font-bold">-</button>
                                <span id="qty-val" class="w-10 text-center text-sm font-bold">1</span>
                                <button type="button" id="qty-inc"
                                    class="w-9 h-9 flex items-center justify-center text-muted-foreground hover:text-foreground transition-colors font-bold">+</button>
                            </div>
                        </div>

                        <!-- Hidden WooCommerce fields required for cart -->
                        <input type="hidden" name="add-to-cart" value="<?= absint($product->get_id()) ?>" />
                        <input type="hidden" name="product_id" value="<?= absint($product->get_id()) ?>" />
                        <input type="hidden" name="variation_id" class="variation_id"
                            value="<?= esc_attr($variations[$default_variation_index]['variation_id'] ?? '') ?>" />
                        <input type="hidden" name="<?= esc_attr($first_attr_key) ?>" class="variation_attribute_hidden"
                            value="<?= esc_attr($variations[$default_variation_index]['attributes'][$first_attr_key] ?? '') ?>" />
                        <input type="hidden" name="quantity" class="form-quantity" value="1" />

                        <!-- Checkout Button -->
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 rounded-md bg-primary px-4 py-3 text-xs font-bold uppercase tracking-normal text-primary-foreground shadow-sm transition-colors hover:bg-primary-dark disabled:opacity-50 sm:px-8 sm:py-3.5 sm:text-sm sm:tracking-wider">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span id="submit-btn-text">
                                <?= "Checkout & Pay" ?> -
                                <?= wp_kses_post(wc_price((float) $variations[$default_variation_index]['display_price'])) ?>
                            </span>
                        </button>
                    </div>
                </form>

                <!-- Script to handle variation row selection & quantity calculation -->
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const rows = document.querySelectorAll('.variation-row-btn');
                        const inputVarId = document.querySelector('input.variation_id');
                        const inputAttr = document.querySelector('input.variation_attribute_hidden');
                        const inputQty = document.querySelector('input.form-quantity');

                        const qtyVal = document.getElementById('qty-val');
                        const btnDec = document.getElementById('qty-dec');
                        const btnInc = document.getElementById('qty-inc');
                        const btnText = document.getElementById('submit-btn-text');
                        const unitPriceLabel = document.getElementById('product-unit-price');
                        const stickyBar = document.getElementById('sticky-product-bar');
                        const stickyPack = document.getElementById('sticky-product-pack');
                        const stickyPrice = document.getElementById('sticky-product-price');
                        const stickySubmit = document.getElementById('sticky-product-submit');
                        const purchaseForm = document.getElementById('product-purchase-form');

                        const selectedRow = document.querySelector('.variation-row-btn.active-row') || rows[0];
                        let selectedPrice = parseFloat(selectedRow.dataset.price);
                        let quantity = 1;

                        function updateUnitPrice(row) {
                            if (!unitPriceLabel) return;

                            const rawPerTab = row.dataset.perTab;
                            const perTab = Number(rawPerTab);
                            if (rawPerTab === '' || !Number.isFinite(perTab)) {
                                unitPriceLabel.hidden = true;
                                return;
                            }

                            const decimals = parseInt(unitPriceLabel.dataset.decimals, 10) || 0;
                            const decimalSeparator = unitPriceLabel.dataset.decimalSeparator || '.';
                            const thousandSeparator = unitPriceLabel.dataset.thousandSeparator || ',';
                            const fixedPrice = perTab.toFixed(decimals).split('.');
                            const whole = fixedPrice[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousandSeparator);
                            const fraction = fixedPrice[1] || '';
                            const formattedPrice = unitPriceLabel.dataset.currencySymbol + whole + (decimals > 0 ? decimalSeparator + fraction : '');

                            unitPriceLabel.textContent = formattedPrice + '/tablet';
                            unitPriceLabel.hidden = false;
                        }

                        if (selectedRow) {
                            updateUnitPrice(selectedRow);
                            if (stickyPack) stickyPack.textContent = selectedRow.dataset.packLabel || '';
                        }

                        function updateBtnText() {
                            const total = selectedPrice * quantity;
                            btnText.innerHTML = '<?= "Checkout & Pay" ?> - <?= esc_js(get_woocommerce_currency_symbol()) ?>' + total.toLocaleString('en-AU', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                            if (stickyPrice) {
                                const currencySymbol = stickyPrice.dataset.currencySymbol || '';
                                stickyPrice.textContent = currencySymbol + total.toLocaleString('en-AU', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                            }
                        }

                        if (selectedRow && stickyPrice) {
                            stickyPrice.textContent = selectedRow.dataset.displayPrice || '';
                        }

                        rows.forEach(row => {
                            row.addEventListener('click', function () {
                                // Update UI states
                                rows.forEach(r => {
                                    r.className = "variation-row-btn w-full flex items-center justify-between gap-4 px-4 py-3 rounded-md border text-left transition-colors border-slate-200 bg-white text-slate-700 hover:border-primary/50";
                                });
                                this.className = "variation-row-btn active-row w-full flex items-center justify-between gap-4 px-4 py-3 rounded-md border-2 border-primary bg-primary-softer text-primary-dark text-left transition-colors";

                                // Update Hidden inputs
                                inputVarId.value = this.dataset.id;
                                inputAttr.value = this.dataset.val;

                                // Update local variables
                                selectedPrice = parseFloat(this.dataset.price);
                                updateUnitPrice(this);
                                if (stickyPack) stickyPack.textContent = this.dataset.packLabel || '';
                                updateBtnText();
                            });
                        });

                        if (stickyBar && purchaseForm) {
                            const toggleStickyBar = () => {
                                const showStickyBar = purchaseForm.getBoundingClientRect().bottom <= 0;
                                stickyBar.classList.toggle('translate-y-full', !showStickyBar);
                                stickyBar.classList.toggle('opacity-0', !showStickyBar);
                                stickyBar.classList.toggle('pointer-events-none', !showStickyBar);
                                stickyBar.classList.toggle('translate-y-0', showStickyBar);
                                stickyBar.classList.toggle('opacity-100', showStickyBar);
                                stickyBar.setAttribute('aria-hidden', showStickyBar ? 'false' : 'true');
                                stickyBar.inert = !showStickyBar;
                                document.body.classList.toggle('has-sticky-product-bar', showStickyBar);
                            };
                            let scrollFrame = 0;
                            const queueStickyUpdate = () => {
                                if (scrollFrame) return;
                                scrollFrame = window.requestAnimationFrame(() => {
                                    toggleStickyBar();
                                    scrollFrame = 0;
                                });
                            };

                            window.addEventListener('scroll', queueStickyUpdate, { passive: true });
                            window.addEventListener('resize', queueStickyUpdate);
                            window.addEventListener('pageshow', queueStickyUpdate);
                            queueStickyUpdate();

                            if (stickySubmit) {
                                stickySubmit.addEventListener('click', () => {
                                    if (typeof purchaseForm.requestSubmit === 'function') {
                                        purchaseForm.requestSubmit();
                                    } else {
                                        purchaseForm.submit();
                                    }
                                });
                            }
                        }

                        // Quantity listeners
                        btnDec.addEventListener('click', function () {
                            if (quantity > 1) {
                                quantity--;
                                qtyVal.innerText = quantity;
                                inputQty.value = quantity;
                                updateBtnText();
                            }
                        });

                        btnInc.addEventListener('click', function () {
                            quantity++;
                            qtyVal.innerText = quantity;
                            inputQty.value = quantity;
                            updateBtnText();
                        });
                    });
                </script>

            <?php else: ?>
                <div class="mb-6">
                    <span
                        class="w-full flex items-center justify-center rounded-md bg-destructive-soft px-8 py-3.5 text-sm font-bold uppercase tracking-wider text-destructive">
                        <?= "Out of Stock" ?>
                    </span>
                </div>
            <?php endif; ?>

            <?php if ($trust_items): ?>
                <div class="grid grid-cols-1 gap-3 border-t border-slate-200 pt-6 sm:grid-cols-3">
                    <?php foreach ($trust_items as $trust_item): ?>
                        <div class="flex min-h-12 items-center gap-2 rounded-lg border border-border bg-white px-3 py-2 text-sm font-medium text-ink">
                            <span class="inline-flex h-5 w-5 shrink-0 items-center justify-center text-primary" aria-hidden="true"><i class="fi <?= esc_attr($trust_item['icon']) ?>"></i></span>
                            <span><?= esc_html($trust_item['label']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <details open class="mt-6 overflow-hidden rounded-xl border border-border bg-white">
                <summary class="group flex cursor-pointer list-none items-center justify-between gap-3 px-4 py-4 font-semibold text-ink marker:hidden [&::-webkit-details-marker]:hidden">
                    <span class="inline-flex items-center gap-2">
                        <i class="fi fi-rr-list-check text-primary" aria-hidden="true"></i>
                        <span><?= esc_html($product_specs_heading ?: 'Product specs') ?> (<?= count($product_specs) ?>)</span>
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-primary transition-transform duration-200 group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </summary>
                <dl class="divide-y divide-border border-t border-border px-4">
                    <?php foreach ($product_specs as $spec): ?>
                        <?php
                        $spec_label = trim((string) ($spec['label'] ?? ''));
                        $spec_value = trim(wp_strip_all_tags((string) ($spec['value'] ?? '')));
                        if ($spec_label === '') {
                            continue;
                        }
                        ?>
                        <div class="flex items-start justify-between gap-4 py-3 text-sm">
                            <dt class="text-muted-foreground"><?= esc_html($spec_label) ?></dt>
                            <dd class="text-right font-medium text-ink"><?= esc_html($spec_value !== '' ? $spec_value : 'Not listed') ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>
            </details>
        </div>
    </div>
    <!-- ACF: Extra Tabs (Removed as requested) -->
</section>

<?php if ($product->is_in_stock() && !empty($variations)): ?>
    <?php $sticky_default_variation = $variations[$default_variation_index] ?? null; ?>
    <div id="sticky-product-bar" class="fixed inset-x-0 bottom-0 z-40 translate-y-full border-t border-slate-200 bg-white/95 opacity-0 shadow-[0_-8px_24px_rgba(15,23,42,0.12)] backdrop-blur transition duration-300 pointer-events-none" aria-hidden="true" inert>
        <div class="container-site flex items-center gap-3 py-2 pr-16 sm:gap-4 sm:py-3 sm:pr-0">
            <?php if ($image !== ''): ?>
                <img src="<?= esc_url($image) ?>" alt="" class="h-12 w-12 shrink-0 rounded-md border border-slate-200 bg-white object-contain p-1 sm:h-16 sm:w-16">
            <?php endif; ?>
            <div class="min-w-0 flex-1">
                <p class="truncate text-xs font-bold text-slate-900 sm:text-sm"><?= esc_html($product->get_name()) ?></p>
                <p class="mt-0.5 truncate text-[11px] text-slate-600 sm:text-xs">
                    <span id="sticky-product-pack"><?= esc_html($sticky_default_pack_label ?? '') ?></span>
                    <span aria-hidden="true"> · </span>
                    <span id="sticky-product-price" data-currency-symbol="<?= esc_attr(get_woocommerce_currency_symbol()) ?>"><?= esc_html(wp_strip_all_tags(wc_price((float) ($sticky_default_variation['display_price'] ?? 0)))) ?></span>
                </p>
            </div>
            <button id="sticky-product-submit" type="button" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-md bg-primary px-3 py-3 text-xs font-bold text-primary-foreground shadow-sm transition-colors hover:bg-primary-dark sm:px-5 sm:text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <span>Add to Cart</span>
            </button>
        </div>
    </div>
<?php endif; ?>

<!-- Product Description Section -->
<?php
$acf_main = $product_description_module ?: get_post_meta($product->get_id(), 'main_desc', true);
$main_desc = '';

if ($acf_main) {
    $main_desc = $acf_main;
} else {
    $main_desc = get_the_content();
}

if (!empty(trim(strip_tags($main_desc)))): 
?>
<section class="section-padding bg-slate-50 border-t border-slate-200" data-testid="section-product-description">
    <div class="container-site">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 md:p-10 prose prose-slate max-w-none">
            <?= apply_filters('the_content', $main_desc); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php
get_template_part('template-parts/product-reviews', null, [
    'product_id' => $product->get_id(),
    'product_name' => $product->get_name(),
]);
?>

<!-- Dosage Guide Banner -->
<section class="py-8 bg-white border-t border-slate-200" data-testid="product-dosage-guide-banner">
    <div class="container-site max-w-4xl">
        <a href="<?= home_url('/armodafinil-guide/') ?>"
            class="group flex flex-col sm:flex-row items-center gap-4 bg-primary-softer border-2 border-primary-light/50 rounded-md p-5 hover:bg-primary-soft hover:border-primary-light transition-colors"
            data-testid="link-dosage-guide-banner">
            <div class="w-12 h-12 rounded-md bg-primary text-primary-foreground flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                    </path>
                </svg>
            </div>
            <div class="text-center sm:text-left flex-1">
                <h3 class="font-heading font-extrabold text-primary group-hover:text-primary-dark transition-colors">
                    <?= "Armodafinil Information Guide" ?>
                </h3>
                <p class="text-slate-600 text-sm mt-1">
                    <?= "Read general safety and Australian access information. Discuss treatment and directions with your doctor or pharmacist." ?>
                </p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 text-primary flex-shrink-0 hidden sm:block transition-transform group-hover:translate-x-1"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
    </div>
</section>



<!-- Dynamic ACF Modules (Replaces Hardcoded FAQs) -->
<?php
if (have_rows('modules', $product->get_id())) {
    while (have_rows('modules', $product->get_id())) {
        the_row();
        $layout = get_row_layout();
        if (in_array($layout, ['product_summary', 'product_description'], true)) {
            continue;
        }
        get_template_part('modules/content', $layout);
    }
}
?>

<!-- Related Products -->
<section class="section-padding bg-slate-50 border-t border-slate-200">
    <div class="container-site">
        <h2 class="font-heading text-2xl md:text-3xl font-extrabold text-slate-900 text-center mb-8">
            <?= "Related Products" ?>
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            <?php
            $related_products = wc_get_related_products($product->get_id(), 4);
            foreach ($related_products as $related_product_id) {
                $post_object = get_post($related_product_id);
                setup_postdata($GLOBALS['post'] =& $post_object);
                wc_get_template_part('content', 'product');
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</section>

<?php get_footer('shop'); ?>
