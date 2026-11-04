<?php
/**
 * Customer Reviews Module
 */

if (waklert_module_is_empty()) { return; }

$heading = waklert_module_text('heading');
$desc = waklert_module_text('description');
$eyebrow = waklert_module_text('eyebrow');
$summary_text = waklert_module_text('summary_text');
$score_suffix = waklert_module_text('score_suffix');
$badge_1 = waklert_module_text('badge_1');
$badge_2 = waklert_module_text('badge_2');
$default_meta = waklert_module_text('default_meta');
$verified_label = waklert_module_text('verified_label');
$empty_text = waklert_module_text('empty_text');

// Run query first to calculate dynamic stats
$reviews_query = new WP_Query([
    'post_type' => 'review',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'meta_query' => array(
        'relation' => 'OR',
        array(
            'key'     => 'linked_product',
            'compare' => 'NOT EXISTS'
        ),
        array(
            'key'     => 'linked_product',
            'value'   => '',
            'compare' => '='
        )
    )
]);

$total_reviews = $reviews_query->found_posts;
$total_stars = 0;

if ($reviews_query->have_posts()) {
    while ($reviews_query->have_posts()) {
        $reviews_query->the_post();
        $r = (int) get_post_meta(get_the_ID(), 'rating', true);
        if (!$r) $r = 5;
        $total_stars += $r;
    }
    $reviews_query->rewind_posts();
}

$average_rating = $total_reviews > 0 ? round($total_stars / $total_reviews, 1) : 5.0;
$average_stars = round($average_rating);
?>
<section class="relative overflow-hidden bg-gradient-to-b from-[#f0f6fa] via-[#e9f2f8] to-[#f8fafc] bg-pattern-dots py-8 md:py-12" data-testid="section-general-reviews">
    <div class="container-site max-w-6xl mx-auto px-4 relative z-10">
        <!-- Header & Aggregate Summary Card -->
        <div class="mb-12">
            <div class="text-center max-w-2xl mx-auto mb-8">
                <?php if (waklert_has_content(esc_html($eyebrow))): ?><span class="inline-flex items-center gap-2 rounded-full bg-sky-100 border border-sky-300/80 px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-[#0c4161] shadow-sm mb-4">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <?= esc_html($eyebrow) ?>
                </span><?php endif; ?>
                <?php if (waklert_has_content(esc_html($heading))): ?><h1 class="font-heading text-3xl md:text-5xl font-extrabold text-[#0c4161] tracking-tight mb-4">
                    <?= esc_html($heading) ?>
                </h1><?php endif; ?>
                <?php if (waklert_has_content(esc_html($desc))): ?><p class="text-slate-600 text-base md:text-lg leading-relaxed">
                    <?= esc_html($desc) ?>
                </p><?php endif; ?>
            </div>

            <!-- 2-Tone Dashed Rating Summary Card -->
            <div class="rounded-3xl border-2 border-dashed border-sky-300/80 bg-white p-6 md:p-8 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-6 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-400 to-amber-500 text-white shadow-md">
                        <!-- Multi-color Shield SVG -->
                        <?= waklert_content_icon('content_reviews_icon_b88d9a8db7') ?>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 text-amber-400 mb-1">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <?= waklert_content_icon_class('manual_review_module_star_1', ($i < $average_stars) ? 'text-amber-400 fill-current' : 'text-slate-200 fill-current') ?>
                            <?php endfor; ?>
                            <?php if (waklert_has_content(number_format($average_rating, 1)) || waklert_has_content(esc_html($score_suffix))): ?><span class="ml-1 text-lg font-black text-slate-900"><?= number_format($average_rating, 1) ?> <?= esc_html($score_suffix) ?></span><?php endif; ?>
                        </div>
                        <?php if (waklert_has_content(esc_html(str_replace('{count}', (string) $total_reviews, $summary_text)))): ?><p class="text-xs sm:text-sm font-semibold text-slate-500">
                            <?= esc_html(str_replace('{count}', (string) $total_reviews, $summary_text)) ?>
                        </p><?php endif; ?>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <?php if (waklert_has_content(esc_html($badge_1))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 border border-emerald-300 px-3.5 py-1.5 text-xs font-bold text-emerald-800">
                        <?= waklert_content_icon('content_reviews_icon_c064a6e8b9') ?>
                        <?= esc_html($badge_1) ?>
                    </span><?php endif; ?>
                    <?php if (waklert_has_content(esc_html($badge_2))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-50 border border-sky-300 px-3.5 py-1.5 text-xs font-bold text-[#0c4161]">
                        <?= waklert_content_icon('content_reviews_icon_c4604a30e0') ?>
                        <?= esc_html($badge_2) ?>
                    </span><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Reviews Grid: 2-Tone Dashed Cards -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <?php
            if ($reviews_query->have_posts()):
                while ($reviews_query->have_posts()): $reviews_query->the_post();
                    $post_id = get_the_ID();
                    $name = get_field('name', $post_id) ?: get_the_title();
                    $meta = get_field('reviewer_meta', $post_id) ?: $default_meta;
                    
                    $title = get_the_title();
                    $body = get_the_content();
                    
                    $rating = (int) get_field('rating', $post_id);
                    if (!$rating) $rating = 5;
                    
                    $initial = !empty($name) ? mb_substr($name, 0, 1) : 'M';
                ?>
                <div class="group flex flex-col rounded-3xl border-2 border-dashed border-sky-300/80 hover:border-[#0c4161] bg-white shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 overflow-hidden">
                    <!-- Top Card Body (Pure White) -->
                    <div class="p-6 md:p-7 flex-1 flex flex-col">
                        <div class="flex items-center justify-between gap-3 mb-4">
                            <!-- Colorful Quote Mark SVG -->
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-sky-50 border border-sky-200 text-[#0c4161] group-hover:scale-110 transition-transform">
                                <?= waklert_content_icon('content_reviews_icon_3b705a7473') ?>
                            </div>

                            <!-- Golden Stars -->
                            <div class="flex items-center gap-1 text-amber-400">
                                <?php for ($stars = 0; $stars < 5; $stars++): ?>
                                    <?= waklert_content_icon_class('manual_review_module_star_2', ($stars < $rating) ? "text-amber-400 fill-current" : "text-slate-200 fill-current") ?>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <?php if (waklert_has_content(esc_html($title))): ?><h3 class="font-heading text-base font-bold text-slate-900 mb-2 leading-snug group-hover:text-[#0c4161] transition-colors">
                            <?= esc_html($title) ?>
                        </h3><?php endif; ?>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">
                            <?= esc_html(waklert_content('content_reviews_text_a018beff4e')) ?><?= esc_html(trim(wp_strip_all_tags($body))) ?><?= esc_html(waklert_content('content_reviews_text_7d2f94618b')) ?>
                        </p>
                    </div>

                    <!-- Bottom 2-Tone Solid Navy Strip -->
                    <div class="bg-gradient-to-r from-[#0c4161] to-[#125883] p-4 sm:p-5 flex items-center justify-between gap-3 text-white">
                        <div class="flex min-w-0 items-center gap-3">
                            <!-- Vibrant Amber Reviewer Avatar -->
                            <?php if (waklert_has_content(esc_html($initial))): ?><div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-amber-500 text-[#0c4161] flex items-center justify-center font-extrabold text-sm uppercase shadow-sm shrink-0">
                                <?= esc_html($initial) ?>
                            </div><?php endif; ?>
                            <div class="min-w-0">
                                <?php if (waklert_has_content(esc_html($name))): ?><p class="font-bold text-xs sm:text-sm text-white leading-snug">
                                    <?= esc_html($name) ?>
                                </p><?php endif; ?>
                                <p class="text-[11px] text-sky-200 font-medium"><?= esc_html($meta) ?> <?= esc_html(waklert_content('content_reviews_text_d4f2412b9d')) ?> <?= get_the_date('M Y') ?></p>
                            </div>
                        </div>

                        <?php if (waklert_has_content(esc_html($verified_label))): ?><span class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-300 bg-emerald-500/20 border border-emerald-400/40 px-2.5 py-1 rounded-full shrink-0" data-testid="badge-verified-buyer">
                            <?= waklert_content_icon('content_reviews_icon_c42edf2d00') ?>
                            <?= esc_html($verified_label) ?>
                        </span><?php endif; ?>
                    </div>
                </div>
                <?php endwhile;
                wp_reset_postdata();
            else: ?>
                <div class="col-span-full py-16 text-center text-slate-500 bg-white rounded-3xl border-2 border-dashed border-sky-200 p-8">
                    <?php if (waklert_has_content(esc_html($empty_text))): ?><p class="text-lg font-bold text-[#0c4161]"><?= esc_html($empty_text) ?></p><?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
