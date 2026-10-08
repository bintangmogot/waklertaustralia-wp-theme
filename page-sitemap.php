<?php
/**
 * Template Name: HTML Sitemap
 * Description: A responsive, editable sitemap for Waklert Australia.
 */

get_header();

$sitemap_title = get_field('sitemap_title') ?: get_the_title();
$sitemap_intro = get_field('sitemap_intro') ?: 'Browse the main pages, armodafinil products and support information on this site.';
$custom_columns = get_field('sitemap_columns');

$columns = [];
if (is_array($custom_columns) && $custom_columns) {
    foreach ($custom_columns as $column) {
        $links = [];
        foreach (($column['links'] ?? []) as $row) {
            $link = $row['link'] ?? null;
            if (is_array($link) && !empty($link['url']) && !empty($link['title'])) {
                $links[] = [
                    'title' => $link['title'],
                    'url' => $link['url'],
                    'target' => $link['target'] ?? '',
                ];
            }
        }
        if (!empty($column['column_title']) && $links) {
            $columns[] = ['title' => $column['column_title'], 'links' => $links];
        }
    }
}

if (!$columns) {
    $main_pages = [];
    $support_pages = [];
    $policy_pages = [];
    $support_terms = ['about', 'contact', 'faq', 'support', 'track'];
    $policy_terms = ['privacy', 'terms', 'refund', 'policy'];

    foreach (get_pages(['sort_column' => 'menu_order,post_title']) as $page) {
        if ((int) $page->ID === (int) get_option('page_on_front') || $page->post_name === 'sitemap') {
            continue;
        }

        $haystack = strtolower($page->post_title . ' ' . $page->post_name);
        if (array_filter($support_terms, static fn($term) => str_contains($haystack, $term))) {
            $support_pages[] = $page;
        } elseif (array_filter($policy_terms, static fn($term) => str_contains($haystack, $term))) {
            $policy_pages[] = $page;
        } else {
            $main_pages[] = $page;
        }
    }

    $columns[] = ['title' => 'Main Pages', 'links' => array_map(static fn($page) => [
        'title' => $page->post_title,
        'url' => get_permalink($page),
    ], $main_pages)];

    $product_links = [];
    if (function_exists('wc_get_products')) {
        foreach (wc_get_products(['status' => 'publish', 'limit' => 100, 'orderby' => 'menu_order title', 'order' => 'ASC']) as $product) {
            $product_links[] = ['title' => $product->get_name(), 'url' => $product->get_permalink()];
        }
    }
    if (!$product_links) {
        $product_links[] = ['title' => 'Shop All Products', 'url' => home_url('/shop/')];
    }
    $columns[] = ['title' => 'Armodafinil Products', 'links' => $product_links];

    $columns[] = ['title' => 'Help & Support', 'links' => array_map(static fn($page) => [
        'title' => $page->post_title,
        'url' => get_permalink($page),
    ], $support_pages)];

    $columns[] = ['title' => 'Policies', 'links' => array_map(static fn($page) => [
        'title' => $page->post_title,
        'url' => get_permalink($page),
    ], $policy_pages)];
}
$delivery_links = [];
foreach (get_posts(['post_type' => 'city', 'post_status' => 'publish', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC']) as $city_page) {
    $delivery_links[] = ['title' => get_field('city_name', $city_page->ID) ?: $city_page->post_title, 'url' => get_permalink($city_page)];
}
if ($delivery_links) {
    $columns[] = ['title' => 'Australia Delivery', 'links' => $delivery_links];
}
?>

<main>
    <section class="relative isolate overflow-hidden border-b-4 border-accent bg-ink py-14 text-white md:py-20">
        <?php waklert_output_pattern_rings(); ?>
        <div class="container-site relative z-10 mx-auto max-w-4xl text-center">
            <p class="mb-3 text-xs font-bold uppercase tracking-[0.18em] text-accent">Waklert Australia</p>
            <h1 class="font-heading text-3xl font-extrabold tracking-tight md:text-5xl"><?= esc_html($sitemap_title) ?></h1>
            <p class="mx-auto mt-4 max-w-2xl text-sm leading-relaxed text-ink-foreground/80 md:text-base"><?= esc_html($sitemap_intro) ?></p>
        </div>
    </section>

    <section class="section-padding bg-background">
        <div class="container-site grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-4">
            <?php foreach ($columns as $column): ?>
            <section class="rounded-xl border border-border bg-card p-6 shadow-sm transition-all hover:-translate-y-0.5 hover:border-primary/30 hover:shadow-md">
                <h2 class="mb-4 border-b border-border pb-3 font-heading text-lg font-bold text-ink"><?= esc_html($column['title']) ?></h2>
                <?php if (!empty($column['links'])): ?>
                <ul class="space-y-3">
                    <?php foreach ($column['links'] as $link): ?>
                    <li>
                        <a href="<?= esc_url($link['url']) ?>" <?= !empty($link['target']) ? 'target="' . esc_attr($link['target']) . '" rel="noopener noreferrer"' : '' ?> class="text-sm font-medium text-muted-foreground transition-colors hover:text-primary-dark focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                            <?= esc_html($link['title']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <p class="text-sm text-muted-foreground">No links in this section yet.</p>
                <?php endif; ?>
            </section>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>
