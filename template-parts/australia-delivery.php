<?php
/** Shared, field-driven Australia Delivery page. */
defined('ABSPATH') || exit;
$read = static function ($name) use ($args) {
    return isset($args['fields']) ? ($args['fields'][$name] ?? '') : get_field($name);
};
$city = trim((string) $read('city_name')) ?: get_the_title();
$region = $read('region') ?: 'Australia';
$days = $read('delivery_days');
$demographic = $read('demographic');
$industry = $read('industry');
$facts_date = $read('facts_date');
$facts_source = $read('facts_source');
$shop = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop/');
$contact = home_url('/contact/');
$product_anchor = wp_unique_id('delivery-products-');
$summary = [
    "Delivery to {$city}" => $days ?: ($read('delivery_note') ?: 'Confirm your postcode'),
    'Shipping' => $read('shipping_note') ?: 'Options at checkout',
    'Packaging' => $read('packaging_note') ?: 'Plain outer packaging',
    'Tracking' => $read('tracking_note') ?: 'Provided after dispatch',
];
$features = $read('features') ?: [['feat' => 'Compare available strengths and pack sizes'], ['feat' => 'Check delivery details for your postcode'], ['feat' => 'Review shipping and payment options at checkout'], ['feat' => 'Contact the team for order support']];
$reasons = $read('reasons') ?: [
    ['title' => 'A focused product range', 'text' => 'Compare armodafinil brands, strengths and pack sizes with clear product information.'],
    ['title' => "Delivery information for {$city}", 'text' => 'Check your postcode, shipping options and estimated timing before placing an order.'],
    ['title' => 'Help with your order', 'text' => 'Find answers in our FAQ or contact the team for help with ordering and delivery.'],
];
$faqs = $read('faqs') ?: [
    ['question' => "How long does delivery to {$city} take?", 'answer' => $days ? "{$days}. Contact our team to confirm the current estimate for your address." : 'Contact our team with your postcode to confirm the current delivery estimate before ordering.'],
    ['question' => 'Is the packaging discreet?', 'answer' => 'Orders are prepared in plain outer packaging. Product and regulatory information remains on the medicine packaging where required.'],
    ['question' => 'Where can I check shipping and payment options?', 'answer' => 'Available options are displayed at checkout. Check the details for your delivery address before confirming your order.'],
    ['question' => 'Who can help with a delayed order?', 'answer' => 'Check your tracking details, then contact our team with your order number for help. See the refund policy for the applicable terms.'],
];
?>
<section class="relative isolate overflow-hidden bg-primary-dark text-primary-foreground">
    <?php waklert_output_pattern_rings(); ?>
    <div class="container-site relative z-10 grid items-center gap-10 py-14 md:py-20 lg:grid-cols-[1.2fr_.8fr] lg:gap-16">
        <div>
            <nav aria-label="Breadcrumb" class="mb-8 flex flex-wrap gap-2 text-xs text-white/70"><a class="hover:text-white" href="<?= esc_url(home_url('/')) ?>">Home</a><span aria-hidden="true">/</span><a class="hover:text-white" href="<?= esc_url(home_url('/sitemap/')) ?>">Australia Delivery</a><span aria-hidden="true">/</span><span aria-current="page" class="text-white"><?= esc_html($city) ?></span></nav>
            <p class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-widest"><span aria-hidden="true" class="h-2 w-2 rounded-full bg-accent"></span><?= esc_html($region) ?></p>
            <h1 class="max-w-2xl font-heading text-4xl font-extrabold leading-tight tracking-tight md:text-5xl lg:text-6xl"><?= esc_html($read('hero_heading') ?: "Armodafinil Delivery to {$city}") ?></h1>
            <p class="mt-6 max-w-xl text-base leading-relaxed text-white/80 md:text-lg"><?= esc_html($read('hero_desc') ?: "Explore the Waklert Australia range and check ordering and delivery information for {$city}.") ?></p>
            <div class="mt-8 flex flex-wrap gap-3"><a class="inline-flex items-center justify-center rounded-full bg-accent px-7 py-3.5 text-sm font-extrabold uppercase tracking-wide text-accent-foreground transition hover:brightness-105 focus-visible:outline-2 focus-visible:outline-offset-4" href="<?= esc_url($shop) ?>"><?= esc_html($read('shop_button_label') ?: 'Shop now') ?> <span aria-hidden="true" class="ml-3">→</span></a><a class="inline-flex items-center justify-center rounded-full border border-white/40 px-7 py-3.5 text-sm font-bold uppercase tracking-wide transition hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-4" href="#<?= esc_attr($product_anchor) ?>"><?= esc_html($read('products_button_label') ?: 'View products') ?></a></div>
        </div>
        <aside aria-label="Delivery summary" class="rounded-2xl border border-border bg-card p-6 text-card-foreground shadow-card md:p-8">
            <div class="mb-6 flex items-center gap-4 border-b border-border pb-6"><span aria-hidden="true" class="flex h-12 w-12 items-center justify-center rounded-xl bg-primary-soft text-primary-dark"><svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h11v10H3V7Zm11 4h4l3 4v2h-7M7 7V4h7M8 17a2 2 0 1 1-4 0m15 0a2 2 0 1 1-4 0"/></svg></span><div><p class="text-xs font-bold uppercase tracking-widest text-primary"><?= esc_html($read('carrier') ?: 'Australia Delivery') ?></p><p class="mt-1 font-heading text-xl font-extrabold"><?= esc_html($read('summary_heading') ?: 'Delivery at a glance') ?></p></div></div>
            <dl class="space-y-5 text-sm"><?php foreach ($summary as $label => $value): ?><div class="flex items-start justify-between gap-6"><dt class="text-muted-foreground"><?= esc_html($label) ?></dt><dd class="max-w-[55%] text-right font-semibold"><?= esc_html($value) ?></dd></div><?php endforeach; ?></dl>
            <a class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-primary hover:text-primary-dark" href="<?= esc_url($contact) ?>"><?= esc_html($read('delivery_link_label') ?: 'Check delivery for your postcode') ?> <span aria-hidden="true">→</span></a>
        </aside>
    </div>
</section>
<section class="section-padding bg-background">
    <div class="container-site grid gap-10 lg:grid-cols-[1.2fr_.8fr] lg:gap-16">
        <div><p class="mb-3 text-xs font-bold uppercase tracking-widest text-primary"><?= esc_html($read('about_label') ?: "About {$city}") ?></p><h2 class="font-heading text-3xl font-extrabold tracking-tight md:text-4xl"><?= esc_html($read('about_heading') ?: "Delivery to {$city}" . ($region !== 'Australia' ? ", {$region}" : '')) ?></h2>
            <div class="mt-6 space-y-4 leading-relaxed text-muted-foreground [&_a]:text-primary"><?= wp_kses_post(wpautop($read('desc') ?: "Planning an order to {$city}? Browse the current range, compare pack options and confirm delivery details for your address with our team.")) ?></div>
            <?php if ($read('population')): ?><p class="mt-6 text-sm text-muted-foreground">Population of <?= esc_html($city) ?> <strong class="ml-2 text-foreground"><?= esc_html($read('population')) ?></strong></p><?php endif; ?>
            <?php if ($demographic || $industry): ?><div class="mt-5 space-y-3 text-sm leading-relaxed text-muted-foreground"><?php if ($demographic): ?><p><?= esc_html($demographic) ?></p><?php endif; ?><?php if ($industry): ?><p><?= esc_html($industry) ?></p><?php endif; ?><?php if ($facts_source): ?><p class="text-xs"><?= esc_html($facts_date ?: 'Source') ?>: <a href="<?= esc_url($facts_source) ?>" target="_blank" rel="noopener noreferrer">Australian Bureau of Statistics, 2021 Census QuickStats</a></p><?php endif; ?></div><?php endif; ?>
        </div>
        <aside class="rounded-2xl border border-border bg-primary-softer p-6 md:p-8"><h3 class="font-heading text-xl font-extrabold text-primary-dark"><?= esc_html($read('features_heading') ?: "Ordering in {$city}") ?></h3><ul class="mt-5 space-y-4 text-sm leading-relaxed"><?php foreach ($features as $feature): if (empty($feature['feat'])) continue; ?><li class="flex gap-3"><span aria-hidden="true" class="font-bold text-primary">✓</span><span><?= esc_html($feature['feat']) ?></span></li><?php endforeach; ?></ul></aside>
    </div>
</section>
<section class="section-padding border-t border-border bg-surface"><div class="container-site"><h2 class="mb-10 text-center font-heading text-3xl font-extrabold tracking-tight"><?= esc_html($read('reasons_heading') ?: count($reasons) . ' Reasons to Choose Waklert Australia') ?></h2><div class="grid gap-5 md:grid-cols-3"><?php foreach ($reasons as $index => $reason): ?><article class="rounded-2xl border border-border bg-card p-7 shadow-card"><span aria-hidden="true" class="mb-6 inline-flex h-11 w-11 items-center justify-center rounded-xl bg-primary-soft font-heading font-extrabold text-primary-dark"><?= esc_html(sprintf('%02d', $index + 1)) ?></span><h3 class="font-heading text-xl font-extrabold"><?= esc_html($reason['title'] ?? '') ?></h3><p class="mt-3 text-sm leading-relaxed text-muted-foreground"><?= esc_html($reason['text'] ?? '') ?></p></article><?php endforeach; ?></div></div></section>
<div class="border-y border-border bg-background"><ul class="container-site grid grid-cols-2 gap-6 py-7 text-center text-xs font-bold uppercase tracking-wider text-primary-dark md:grid-cols-4"><?php foreach (($read('trust_badges') ?: [['label' => 'Australia-wide delivery options'], ['label' => 'Sealed product packaging'], ['label' => 'Secure checkout'], ['label' => 'Discreet packaging']]) as $badge): ?><li class="flex items-center justify-center gap-2"><span aria-hidden="true" class="text-accent">✓</span><?= esc_html($badge['label'] ?? '') ?></li><?php endforeach; ?></ul></div>
<section id="<?= esc_attr($product_anchor) ?>" class="section-padding scroll-mt-24 bg-background"><div class="container-site">
    <div class="mb-10 text-center"><p class="mb-3 text-xs font-bold uppercase tracking-widest text-primary"><?= esc_html($read('products_label') ?: 'The collection') ?></p><h2 class="font-heading text-3xl font-extrabold tracking-tight md:text-4xl"><?= esc_html($read('products_heading') ?: "Armodafinil for {$city} Customers") ?></h2><p class="mt-4 text-muted-foreground"><?= esc_html($read('products_desc') ?: 'Explore current products, prices and pack sizes.') ?></p></div>
    <?php
    $ids = array_filter(array_map('absint', (array) $read('selected_products')));
    $query_args = ['post_type' => 'product', 'post_status' => 'publish', 'posts_per_page' => 4, 'orderby' => 'menu_order', 'order' => 'ASC'];
    if ($ids) { $query_args['post__in'] = $ids; $query_args['orderby'] = 'post__in'; }
    if (function_exists('wc_get_product_visibility_term_ids')) {
        $visibility = wc_get_product_visibility_term_ids();
        $query_args['tax_query'] = [['taxonomy' => 'product_visibility', 'field' => 'term_taxonomy_id', 'terms' => [$visibility['exclude-from-catalog']], 'operator' => 'NOT IN']];
    }
    $products = new WP_Query($query_args);
    if (function_exists('wc_get_product') && $products->have_posts()): ?>
    <div class="grid grid-cols-2 gap-4 md:gap-6 lg:grid-cols-4"><?php $previous_product = $GLOBALS['product'] ?? null; while ($products->have_posts()): $products->the_post(); $GLOBALS['product'] = wc_get_product(get_the_ID()); wc_get_template_part('content', 'product'); endwhile; wp_reset_postdata(); $GLOBALS['product'] = $previous_product; ?></div>
    <?php else: ?><p class="text-center text-muted-foreground">Check the shop for the latest product availability.</p><?php endif; ?>
    <div class="mt-9 text-center"><a class="inline-flex rounded-full border-2 border-primary px-7 py-3 text-sm font-bold uppercase tracking-wide text-primary transition hover:bg-primary hover:text-primary-foreground" href="<?= esc_url($shop) ?>"><?= esc_html($read('all_products_label') ?: 'View all products') ?></a></div>
</div></section>
<?php $reviews = $read('reviews') ?: []; if ($reviews): ?>
<section class="section-padding border-t border-border bg-surface"><div class="container-site"><h2 class="mb-8 font-heading text-3xl font-extrabold">Customer Reviews from <?= esc_html($city) ?></h2><div class="grid gap-5 md:grid-cols-2"><?php foreach ($reviews as $review): $rating = max(0, min(5, (int) ($review['rating'] ?? 0))); ?><figure class="rounded-2xl border border-border bg-card p-6"><?php if ($rating): ?><p aria-label="<?= esc_attr("{$rating} out of 5 stars") ?>" class="mb-4 text-accent"><?= esc_html(str_repeat('★', $rating)) ?></p><?php endif; ?><blockquote class="text-sm leading-relaxed text-muted-foreground"><?= esc_html($review['text'] ?? '') ?></blockquote><figcaption class="mt-5 text-sm font-bold"><?= esc_html($review['author'] ?? '') ?> <span class="font-normal text-muted-foreground"><?= esc_html($review['date'] ?? '') ?></span></figcaption></figure><?php endforeach; ?></div></div></section>
<?php endif; ?>
<section class="section-padding border-t border-border bg-surface"><div class="container-site max-w-4xl">
    <div class="mb-9 text-center"><p class="mb-3 text-xs font-bold uppercase tracking-widest text-primary"><?= esc_html($read('faq_label') ?: 'FAQ') ?></p><h2 class="font-heading text-3xl font-extrabold tracking-tight md:text-4xl"><?= esc_html($read('faq_heading') ?: "{$city} Delivery FAQ") ?></h2></div><div class="space-y-3">
    <?php foreach ($faqs as $index => $faq): if (empty($faq['question']) || empty($faq['answer'])) continue; ?><details open class="group rounded-xl border border-border bg-card transition open:border-primary-light open:bg-primary-softer"><summary class="flex cursor-pointer list-none items-start gap-4 rounded-xl p-5 font-semibold text-foreground hover:text-primary focus-visible:outline-2 focus-visible:outline-primary [&::-webkit-details-marker]:hidden"><span class="shrink-0 text-primary">Q<?= esc_html((string) ($index + 1)) ?>.</span><span class="flex-1"><?= esc_html($faq['question']) ?></span><span aria-hidden="true" class="text-primary transition-transform group-open:rotate-45">+</span></summary><div class="px-5 pb-6 text-sm leading-relaxed text-muted-foreground [&_a]:text-primary"><?= wp_kses_post(wpautop($faq['answer'])) ?></div></details><?php endforeach; ?>
    </div><p class="mt-6 text-center"><a class="text-sm font-bold text-primary hover:text-primary-dark" href="<?= esc_url(home_url('/faq/')) ?>"><?= esc_html($read('faq_link_label') ?: 'Read the full FAQ →') ?></a></p>
</div></section>
<section class="relative isolate overflow-hidden bg-primary-dark py-14 text-center text-primary-foreground md:py-16">
    <?php waklert_output_pattern_rings(); ?>
    <div class="container-site relative z-10 max-w-3xl"><h2 class="font-heading text-3xl font-extrabold tracking-tight md:text-4xl"><?= esc_html($read('cta_heading') ?: "Ready to Order in {$city}?") ?></h2><p class="mt-5 leading-relaxed text-white/80"><?= esc_html($read('cta_desc') ?: "Browse the range and confirm delivery options for your {$city} address before ordering.") ?></p><a class="mt-7 inline-flex rounded-full bg-accent px-8 py-3.5 text-sm font-extrabold uppercase tracking-wide text-accent-foreground transition hover:brightness-105" href="<?= esc_url($shop) ?>"><?= esc_html($read('cta_button_label') ?: 'Explore products') ?> <span aria-hidden="true" class="ml-3">→</span></a></div>
</section>

