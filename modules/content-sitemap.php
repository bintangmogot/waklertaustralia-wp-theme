<?php
/**
 * Sitemap Module
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

if (waklert_module_is_empty()) { return; }

$title = waklert_content('content_sitemap_text_5253e1e160');
$subtitle = waklert_module_text('subtitle');

// Main Pages
$main_links = [
    ['label' => waklert_content('content_sitemap_text_288f3b94ac'), 'url' => home_url('/')],
    ['label' => waklert_content('content_sitemap_text_f97d041ee5'), 'url' => home_url('/shop/')],
    ['label' => waklert_content('content_sitemap_text_e1d90a3b11'), 'url' => home_url('/about-us/')],
    ['label' => waklert_content('content_sitemap_text_eca0743e49'), 'url' => home_url('/reviews/')],
    ['label' => waklert_content('content_sitemap_text_a97165abfe'), 'url' => home_url('/faq/')],
    ['label' => waklert_content('content_sitemap_text_1c2787b6ff'), 'url' => home_url('/track-order/')],
    ['label' => waklert_content('content_sitemap_text_3575f31406'), 'url' => home_url('/buyers-guide/')],
    ['label' => waklert_content('content_sitemap_text_fa9716efa7'), 'url' => home_url('/armodafinil-guide/')],
    ['label' => waklert_content('content_sitemap_text_8d9b0d53fa'), 'url' => home_url('/contact/')]
];

// Policies & Legal
$legal_links = [
    ['label' => waklert_content('content_sitemap_text_c982a49fef'), 'url' => home_url('/terms-and-conditions/')],
    ['label' => waklert_content('content_sitemap_text_9addbcd051'), 'url' => home_url('/privacy/')],
    ['label' => waklert_content('content_sitemap_text_b50519c98e'), 'url' => home_url('/refund-policy/')],
    ['label' => waklert_content('content_sitemap_text_c85b372d96'), 'url' => home_url('/shipping-policy/')],
    ['label' => waklert_content('content_sitemap_text_09ce4a6e3f'), 'url' => home_url('/medical-disclaimer/')],
    ['label' => waklert_content('content_sitemap_text_5253e1e160'), 'url' => home_url('/sitemap/')]
];

// Query WooCommerce Products dynamically
$products = get_posts([
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
]);

// Australian Delivery Cities
$cities = get_posts([
    'post_type' => 'city',
    'post_status' => 'publish',
    'posts_per_page' => 20,
    'orderby' => 'menu_order title',
    'order' => 'ASC'
]);
?>

<!-- 2-Tone Patterned Header -->
<header class="relative overflow-hidden border-b-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-6 sm:py-7 md:py-9">
    <div class="container-site max-w-4xl mx-auto px-4 relative z-10">
        <!-- Breadcrumbs -->
        <div class="mb-3">
            <nav aria-label="<?= esc_attr(waklert_content('content_sitemap_text_72f641b507')) ?>" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-dashed border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                <?php if ((waklert_has_content(esc_html(waklert_option_text('breadcrumb_home_label')))) && waklert_has_content(esc_url(home_url('/')))): ?><a href="<?= esc_url(home_url('/')) ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]"><?= esc_html(waklert_option_text('breadcrumb_home_label')) ?></a><?php endif; ?>
                <span class="text-sky-300 font-normal">/</span>
                <?php if (waklert_has_content(esc_html(waklert_content('content_sitemap_text_5253e1e160')))): ?><span aria-current="page" class="font-extrabold text-[#0c4161]"><?= esc_html(waklert_content('content_sitemap_text_5253e1e160')) ?></span><?php endif; ?>
            </nav>
        </div>

        <!-- Eyebrow Badge -->
        <div class="mb-2.5">
            <?php if (waklert_has_content(esc_html(waklert_content('content_sitemap_text_5e3322a22b')))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                <?= esc_html(waklert_content('content_sitemap_text_5e3322a22b')) ?>
            </span><?php endif; ?>
        </div>

        <?php if (waklert_has_content(esc_html($title))): ?><h1 class="mx-auto max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-[#0c4161]">
            <?= esc_html($title) ?>
        </h1><?php endif; ?>

        <?php if (waklert_has_content(esc_html($subtitle))): ?><p class="mx-auto mt-4 max-w-2xl text-sm md:text-base leading-relaxed text-slate-600">
            <?= esc_html($subtitle) ?>
        </p><?php endif; ?>
    </div>
</header>

<section class="py-7 md:py-10 bg-gradient-to-b from-white via-slate-50/50 to-white">
    <div class="container-site max-w-6xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Column 1: Main Pages -->
            <div class="rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-6 shadow-xs">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-100 text-[#0c4161]">
                        <?= waklert_content_icon('content_sitemap_icon_e97086a627') ?>
                    </span>
                    <?php if (waklert_has_content(esc_html(waklert_content('content_sitemap_text_2531b1c5fd')))): ?><h2 class="font-heading text-base font-black text-[#0c4161] uppercase tracking-wider">
                        <?= esc_html(waklert_content('content_sitemap_text_2531b1c5fd')) ?>
                    </h2><?php endif; ?>
                </div>
                <ul class="space-y-2.5">
                    <?php foreach ($main_links as $link): ?>
                        <?php if (waklert_has_content(esc_url($link['url'])) || waklert_has_content(esc_html($link['label']))): ?><li>
                            <?php if ((waklert_has_content(esc_html($link['label']))) && waklert_has_content(esc_url($link['url']))): ?><a href="<?= esc_url($link['url']) ?>" class="group flex items-center gap-2 text-sm text-slate-600 hover:text-[#0c4161] font-medium transition-all">
                                <span class="h-1.5 w-1.5 rounded-full bg-sky-300 group-hover:bg-[#0c4161] transition-colors"></span>
                                <?php if (waklert_has_content(esc_html($link['label']))): ?><span class="group-hover:translate-x-0.5 transition-transform"><?= esc_html($link['label']) ?></span><?php endif; ?>
                            </a><?php endif; ?>
                        </li><?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Column 2: Products -->
            <div class="rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-6 shadow-xs">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-700">
                        <?= waklert_content_icon('content_sitemap_icon_f85561063f') ?>
                    </span>
                    <?php if (waklert_has_content(esc_html(waklert_content('content_sitemap_text_28b1ee1ab8')))): ?><h2 class="font-heading text-base font-black text-[#0c4161] uppercase tracking-wider">
                        <?= esc_html(waklert_content('content_sitemap_text_28b1ee1ab8')) ?>
                    </h2><?php endif; ?>
                </div>
                <ul class="space-y-2.5">
                    <?php if ($products): ?>
                        <?php foreach ($products as $prod): ?>
                            <?php if (waklert_has_content(esc_url(get_permalink($prod->ID))) || waklert_has_content(esc_html($prod->post_title))): ?><li>
                                <?php if ((waklert_has_content(esc_html($prod->post_title))) && waklert_has_content(esc_url(get_permalink($prod->ID)))): ?><a href="<?= esc_url(get_permalink($prod->ID)) ?>" class="group flex items-center gap-2 text-sm text-slate-600 hover:text-[#0c4161] font-medium transition-all">
                                    <span class="h-1.5 w-1.5 rounded-full bg-amber-400 group-hover:bg-[#0c4161] transition-colors"></span>
                                    <?php if (waklert_has_content(esc_html($prod->post_title))): ?><span class="group-hover:translate-x-0.5 transition-transform"><?= esc_html($prod->post_title) ?></span><?php endif; ?>
                                </a><?php endif; ?>
                            </li><?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php if (waklert_has_content(esc_url(home_url('/shop/'))) || waklert_has_content(esc_html(waklert_content('content_sitemap_text_38597a7f69')))): ?><li><?php if ((waklert_has_content(esc_html(waklert_content('content_sitemap_text_38597a7f69')))) && waklert_has_content(esc_url(home_url('/shop/')))): ?><a href="<?= esc_url(home_url('/shop/')) ?>" class="text-sm text-slate-600 hover:text-[#0c4161]"><?= esc_html(waklert_content('content_sitemap_text_38597a7f69')) ?></a><?php endif; ?></li><?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Column 3: Australia Delivery Hubs -->
            <div class="rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-6 shadow-xs">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">
                        <?= waklert_content_icon('content_sitemap_icon_052d9ae2b5') ?>
                    </span>
                    <?php if (waklert_has_content(esc_html(waklert_content('content_sitemap_text_c7173699c3')))): ?><h2 class="font-heading text-base font-black text-[#0c4161] uppercase tracking-wider">
                        <?= esc_html(waklert_content('content_sitemap_text_c7173699c3')) ?>
                    </h2><?php endif; ?>
                </div>
                <ul class="space-y-2.5">
                    <?php if ($cities): ?>
                        <?php foreach (array_slice($cities, 0, 10) as $c): ?>
                            <?php if (waklert_has_content(esc_url(get_permalink($c->ID))) || waklert_has_content(esc_html(get_field('city_name', $c->ID) ?: $c->post_title))): ?><li>
                                <?php if ((waklert_has_content(esc_html(get_field('city_name', $c->ID) ?: $c->post_title))) && waklert_has_content(esc_url(get_permalink($c->ID)))): ?><a href="<?= esc_url(get_permalink($c->ID)) ?>" class="group flex items-center gap-2 text-sm text-slate-600 hover:text-[#0c4161] font-medium transition-all">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 group-hover:bg-[#0c4161] transition-colors"></span>
                                    <?php if (waklert_has_content(esc_html(get_field('city_name', $c->ID) ?: $c->post_title))): ?><span class="group-hover:translate-x-0.5 transition-transform"><?= esc_html(get_field('city_name', $c->ID) ?: $c->post_title) ?></span><?php endif; ?>
                                </a><?php endif; ?>
                            </li><?php endif; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <?php if (waklert_has_content(esc_html(waklert_content('content_sitemap_text_4b1fc1dddd')))): ?><li><?php if (waklert_has_content(esc_html(waklert_content('content_sitemap_text_4b1fc1dddd')))): ?><span class="text-sm text-slate-500"><?= esc_html(waklert_content('content_sitemap_text_4b1fc1dddd')) ?></span><?php endif; ?></li><?php endif; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Column 4: Legal & Policies -->
            <div class="rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-6 shadow-xs">
                <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-700">
                        <?= waklert_content_icon('content_sitemap_icon_af1caec82c') ?>
                    </span>
                    <?php if (waklert_has_content(esc_html(waklert_content('content_sitemap_text_c749dd2e47')))): ?><h2 class="font-heading text-base font-black text-[#0c4161] uppercase tracking-wider">
                        <?= esc_html(waklert_content('content_sitemap_text_c749dd2e47')) ?>
                    </h2><?php endif; ?>
                </div>
                <ul class="space-y-2.5">
                    <?php foreach ($legal_links as $link): ?>
                        <?php if (waklert_has_content(esc_url($link['url'])) || waklert_has_content(esc_html($link['label']))): ?><li>
                            <?php if ((waklert_has_content(esc_html($link['label']))) && waklert_has_content(esc_url($link['url']))): ?><a href="<?= esc_url($link['url']) ?>" class="group flex items-center gap-2 text-sm text-slate-600 hover:text-[#0c4161] font-medium transition-all">
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-300 group-hover:bg-[#0c4161] transition-colors"></span>
                                <?php if (waklert_has_content(esc_html($link['label']))): ?><span class="group-hover:translate-x-0.5 transition-transform"><?= esc_html($link['label']) ?></span><?php endif; ?>
                            </a><?php endif; ?>
                        </li><?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    </div>
</section>
