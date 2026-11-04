<?php
/**
 * Module: Blog Section
 * Fully editable via ACF Pro flexible content module.
 */

if (waklert_module_is_empty()) { return; }

$row = function_exists('get_row') ? get_row() : [];
if (!is_array($row)) {
    $row = [];
}

$eyebrow = waklert_module_text('eyebrow');
$title = waklert_module_text('title');
$subtitle = waklert_module_text('subtitle');

$posts_count = get_sub_field('posts_count');
if (empty($posts_count) && isset($row['posts_count'])) {
    $posts_count = $row['posts_count'];
}
if (!$posts_count) {
    $posts_count = is_front_page() ? 3 : 9;
}
$posts_count = (int) $posts_count;

$show_view_all = true;
if (isset($row['show_view_all'])) {
    $show_view_all = !empty($row['show_view_all']);
} elseif (get_sub_field('show_view_all') !== null && get_sub_field('show_view_all') !== false) {
    $show_view_all = !empty(get_sub_field('show_view_all'));
}

// If we are already on the blog page or archive, hide "view all" button to prevent self-linking
if (is_home() || is_archive() || (is_page() && get_the_ID() === (int) get_option('page_for_posts')) || (is_page() && basename(get_permalink()) === 'blog')) {
    $show_view_all = false;
}

$button_text = waklert_module_text('button_text');

$read_more_label   = waklert_module_text('read_more_label');
$read_time_label   = waklert_module_text('read_time_label');
$default_category  = waklert_module_text('default_category');
$placeholder_label = waklert_module_text('placeholder_label');
$empty_text        = waklert_module_text('empty_text');

$button_url = !empty(get_sub_field('button_url')) 
    ? get_sub_field('button_url') 
    : (!empty($row['button_url']) ? $row['button_url'] : '');

if (empty($button_url)) {
    $blog_page_id = get_option('page_for_posts');
    $button_url = $blog_page_id ? get_permalink($blog_page_id) : home_url('/blog');
}

// Check for admin-chosen posts (via ACF relationship field)
$selected_posts = get_sub_field('selected_posts');
if (empty($selected_posts) && isset($row['selected_posts'])) {
    $selected_posts = $row['selected_posts'];
}
if (empty($selected_posts)) {
    $selected_posts = get_sub_field('posts') ?: ($row['posts'] ?? null);
}

$articles = [];
if (!empty($selected_posts) && is_array($selected_posts)) {
    foreach ($selected_posts as $item) {
        $p = is_numeric($item) ? get_post($item) : $item;
        if ($p && is_object($p) && isset($p->ID) && $p->post_status === 'publish') {
            $articles[] = $p;
        }
    }
}

// Fallback: If no posts selected manually, query latest posts based on posts_count
if (empty($articles)) {
    $args = [
        'post_type'      => 'post',
        'posts_per_page' => $posts_count,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];

    $blog_query = new WP_Query($args);
    $articles = $blog_query->posts;
}
?>
<section class="section-padding bg-gradient-to-b from-[#f0f6fa] via-[#e9f2f8] to-[#f8fafc] bg-pattern-dots border-t-2 border-solid border-sky-200/80 relative isolate overflow-hidden" data-testid="blog-section">
    <div class="container-custom relative z-10">
        <!-- Section Header -->
        <?php if (!empty($title) || !empty($eyebrow)): ?>
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-12">
            <?php if (!empty($eyebrow)): ?>
            <?php if (waklert_has_content(esc_html($eyebrow))): ?><span class="inline-flex items-center gap-2 bg-amber-100 text-amber-900 border border-amber-300 text-xs font-black uppercase tracking-widest px-4 py-1.5 rounded-full mb-3 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse-subtle"></span>
                <?= esc_html($eyebrow) ?>
            </span><?php endif; ?>
            <?php endif; ?>

            <?php if (!empty($title)): ?>
            <?php if (waklert_has_content(esc_html($title))): ?><h2 class="font-heading text-2xl sm:text-3xl md:text-4xl font-black text-ink tracking-tight mb-3">
                <?= esc_html($title) ?>
            </h2><?php endif; ?>
            <?php endif; ?>

            <?php if (!empty($subtitle)): ?>
            <?php if (waklert_has_content(esc_html($subtitle))): ?><p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl mx-auto">
                <?= esc_html($subtitle) ?>
            </p><?php endif; ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Cards Grid -->
        <?php if (!empty($articles)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            <?php foreach ($articles as $article): 
                $post_id = $article->ID;
                $permalink = get_permalink($post_id);
                $categories = get_the_category($post_id);
                $cat_label = (!empty($categories) && $categories[0]->name !== 'Uncategorized') 
                    ? $categories[0]->name 
                    : $default_category;

                // Reading time calculation (~200 wpm)
                $plain_text = strip_tags($article->post_content);
                $word_count = str_word_count($plain_text);
                $read_time = max(1, (int) ceil($word_count / 200));

                // Intro / Excerpt calculation
                $intro_val = '';
                if (function_exists('get_field')) {
                    $modules_data = get_field('modules', $post_id);
                    if (is_array($modules_data)) {
                        foreach ($modules_data as $mod) {
                            if (!empty($mod['intro'])) {
                                $intro_val = $mod['intro'];
                                break;
                            }
                        }
                    }
                    if (empty($intro_val)) {
                        $intro_val = get_field('intro', $post_id);
                    }
                }

                $excerpt = !empty(trim($article->post_excerpt)) 
                    ? $article->post_excerpt 
                    : (!empty($intro_val) ? $intro_val : wp_trim_words($plain_text, 22, '...'));
            ?>
            <article class="group flex flex-col h-full bg-white border-2 border-solid border-sky-300/80 hover:border-[#0c4161] rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-out">
                <!-- Card Thumbnail / Visual Area -->
                <a href="<?= esc_url($permalink) ?>" class="block relative aspect-[16/10] overflow-hidden bg-slate-900 focus:outline-hidden" tabindex="-1" aria-hidden="true">
                    <?php if (has_post_thumbnail($post_id)): ?>
                        <?= get_the_post_thumbnail($post_id, 'large', [
                            'class' => 'w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-105',
                            'loading' => 'lazy',
                            'alt' => esc_attr($article->post_title)
                        ]); ?>
                    <?php else: ?>
                        <!-- Branded Fallback Visual -->
                        <?php if ((waklert_has_content(esc_html($placeholder_label)))): ?><div class="w-full h-full bg-gradient-to-br from-[#081729] via-[#0d2a4a] to-[#1a4066] flex flex-col items-center justify-center p-6 text-white text-center relative overflow-hidden transition-transform duration-500 ease-out group-hover:scale-105">
                            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/5 pointer-events-none"></div>
                            <div class="absolute -left-6 -bottom-6 w-24 h-24 rounded-full bg-white/5 pointer-events-none"></div>
                            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center mb-3 backdrop-blur-xs border border-white/15 text-white/90 shadow-inner">
                                <?= waklert_content_icon('content_blog_section_icon_14530a2b38') ?>
                            </div>
                            <?php if (waklert_has_content(esc_html($placeholder_label))): ?><span class="text-xs font-bold tracking-widest uppercase text-white/80"><?= esc_html($placeholder_label) ?></span><?php endif; ?>
                        </div><?php endif; ?>
                    <?php endif; ?>

                    <!-- Floating Category Badge -->
                    <?php if ((waklert_has_content(esc_html($cat_label)))): ?><div class="absolute top-3.5 left-3.5 z-10">
                        <?php if (waklert_has_content(esc_html($cat_label))): ?><span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-black tracking-wider uppercase bg-amber-400 text-slate-950 shadow-md border border-amber-500/30">
                            <?= waklert_content_icon('manual_star_marker') ?> <?= esc_html($cat_label) ?>
                        </span><?php endif; ?>
                    </div><?php endif; ?>
                </a>

                <!-- Card Body -->
                <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between bg-white">
                    <div>
                        <!-- Meta: Date & Read Time with Colorful SVG Icons -->
                        <div class="flex items-center gap-3 text-xs text-slate-500 mb-3 font-semibold">
                            <time datetime="<?= get_the_date('c', $post_id) ?>" class="inline-flex items-center gap-1.5">
                                <?= waklert_content_icon('content_blog_section_icon_a25b78e8b2') ?>
                                <?= get_the_date('M j, Y', $post_id) ?>
                            </time>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <?php if (waklert_has_content(esc_html($read_time)) || waklert_has_content(esc_html($read_time_label))): ?><span class="inline-flex items-center gap-1">
                                <?= waklert_content_icon('content_blog_section_icon_a252063e0e') ?>
                                <?= esc_html($read_time) ?> <?= esc_html($read_time_label) ?>
                            </span><?php endif; ?>
                        </div>

                        <!-- Title -->
                        <?php if (waklert_has_content(esc_url($permalink)) || waklert_has_content(esc_html($article->post_title))): ?><h3 class="font-heading font-black text-xl sm:text-2xl text-ink group-hover:text-[#0c4161] transition-colors line-clamp-2 mb-3 leading-snug">
                            <?php if ((waklert_has_content(esc_html($article->post_title))) && waklert_has_content(esc_url($permalink))): ?><a href="<?= esc_url($permalink) ?>">
                                <?= esc_html($article->post_title) ?>
                            </a><?php endif; ?>
                        </h3><?php endif; ?>

                        <!-- Excerpt -->
                        <?php if (waklert_has_content(esc_html($excerpt))): ?><p class="text-sm text-slate-600 line-clamp-3 mb-4 leading-relaxed">
                            <?= esc_html($excerpt) ?>
                        </p><?php endif; ?>
                    </div>
                </div>

                <!-- Two-Tone Footer Block -->
                <?php if ((waklert_has_content(esc_html($read_more_label))) && waklert_has_content(esc_url($permalink))): ?><a href="<?= esc_url($permalink) ?>" class="bg-[#f0f6fa] group-hover:bg-[#0c4161] p-3 px-4 sm:p-4 sm:px-6 border-t-2 border-solid border-sky-200/80 flex items-center justify-between transition-colors duration-300 text-xs sm:text-sm font-black text-[#0c4161] group-hover:text-white mt-auto">
                    <?php if (waklert_has_content(esc_html($read_more_label))): ?><span><?= esc_html($read_more_label) ?></span><?php endif; ?>
                    <?= waklert_content_icon('content_blog_section_icon_605c0cb448') ?>
                </a><?php endif; ?>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <?php if ((waklert_has_content(esc_html($empty_text)))): ?><div class="text-center py-12 bg-white rounded-2xl border-2 border-solid border-sky-300/80 p-8">
            <?php if (waklert_has_content(esc_html($empty_text))): ?><p class="text-slate-500 font-medium"><?= esc_html($empty_text) ?></p><?php endif; ?>
        </div><?php endif; ?>
        <?php endif; ?>

        <!-- View All Button -->
        <?php if ($show_view_all && !empty($button_text) && !empty($button_url)): ?>
        <div class="mt-10 md:mt-12 text-center">
            <?php if ((waklert_has_content(esc_html($button_text))) && waklert_has_content(esc_url($button_url))): ?><a href="<?= esc_url($button_url) ?>" class="inline-flex items-center gap-2 border-2 border-solid border-sky-300/90 bg-white hover:bg-[#0c4161] text-[#0c4161] hover:text-white font-extrabold px-5 py-2.5 sm:px-8 sm:py-3.5 rounded-full transition-all duration-300 uppercase tracking-wider sm:tracking-widest text-xs shadow-sm hover:shadow-md hover:-translate-y-0.5">
                <?php if (waklert_has_content(esc_html($button_text))): ?><span><?= esc_html($button_text) ?></span><?php endif; ?>
                <?= waklert_content_icon('content_blog_section_icon_30f6347ddc') ?>
            </a><?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
