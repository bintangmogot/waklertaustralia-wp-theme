<?php
/**
 * Module: Blog Section
 * Fully editable via ACF Pro flexible content module.
 */

$row = function_exists('get_row') ? get_row() : [];
if (!is_array($row)) {
    $row = [];
}

// Field values with robust fallback to $row array and default content
$eyebrow = get_sub_field('eyebrow');
if (empty($eyebrow) && isset($row['eyebrow'])) {
    $eyebrow = $row['eyebrow'];
}
if ($eyebrow === null || $eyebrow === '') {
    $eyebrow = 'Knowledge & Resources';
}

$title = get_sub_field('title');
if (empty($title) && isset($row['title'])) {
    $title = $row['title'];
}
if (empty($title)) {
    $title = get_sub_field('heading') ?: ($row['heading'] ?? 'Latest Articles & Guides');
}

$subtitle = get_sub_field('subtitle');
if (empty($subtitle) && isset($row['subtitle'])) {
    $subtitle = $row['subtitle'];
}
if (empty($subtitle)) {
    $subtitle = get_sub_field('description') ?: ($row['description'] ?? 'Helpful insights, dosage guides, and research on Armodafinil and cognitive performance.');
}

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

$button_text = !empty(get_sub_field('button_text')) 
    ? get_sub_field('button_text') 
    : (!empty($row['button_text']) ? $row['button_text'] : 'View All Articles');

$button_url = !empty(get_sub_field('button_url')) 
    ? get_sub_field('button_url') 
    : (!empty($row['button_url']) ? $row['button_url'] : '');

if (empty($button_url)) {
    $blog_page_id = get_option('page_for_posts');
    $button_url = $blog_page_id ? get_permalink($blog_page_id) : home_url('/blog');
}

// Fetch published articles
$args = [
    'post_type'      => 'post',
    'posts_per_page' => $posts_count,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC',
];

$blog_query = new WP_Query($args);
$articles = $blog_query->posts;
?>
<section class="section-padding bg-slate-50/70 border-t border-slate-100" data-testid="blog-section">
    <div class="container-custom">
        <!-- Section Header -->
        <?php if (!empty($title) || !empty($eyebrow)): ?>
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-12">
            <?php if (!empty($eyebrow)): ?>
            <span class="inline-block bg-primary-soft text-primary-dark text-xs font-bold uppercase tracking-widest px-3.5 py-1.5 rounded-full mb-3 shadow-xs">
                <?= esc_html($eyebrow) ?>
            </span>
            <?php endif; ?>

            <?php if (!empty($title)): ?>
            <h2 class="font-heading text-2xl sm:text-3xl md:text-4xl font-black text-ink tracking-tight mb-3">
                <?= esc_html($title) ?>
            </h2>
            <?php endif; ?>

            <?php if (!empty($subtitle)): ?>
            <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl mx-auto">
                <?= esc_html($subtitle) ?>
            </p>
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
                    : 'Armodafinil Guide';

                // Reading time calculation (~200 wpm)
                $plain_text = strip_tags($article->post_content);
                $word_count = str_word_count($plain_text);
                $read_time = max(1, (int) ceil($word_count / 200));

                // Excerpt calculation
                $excerpt = !empty(trim($article->post_excerpt)) 
                    ? $article->post_excerpt 
                    : wp_trim_words($plain_text, 22, '...');
            ?>
            <article class="group flex flex-col bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-xs hover:shadow-xl hover:border-primary/40 transition-all duration-300">
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
                        <div class="w-full h-full bg-gradient-to-br from-[#081729] via-[#0d2a4a] to-[#1a4066] flex flex-col items-center justify-center p-6 text-white text-center relative overflow-hidden transition-transform duration-500 ease-out group-hover:scale-105">
                            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/5 pointer-events-none"></div>
                            <div class="absolute -left-6 -bottom-6 w-24 h-24 rounded-full bg-white/5 pointer-events-none"></div>
                            <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center mb-3 backdrop-blur-xs border border-white/15 text-white/90 shadow-inner">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <span class="text-xs font-bold tracking-widest uppercase text-white/80">Waklert Knowledge</span>
                        </div>
                    <?php endif; ?>

                    <!-- Floating Category Badge -->
                    <div class="absolute top-3.5 left-3.5 z-10">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold tracking-wider uppercase bg-white/95 text-slate-800 shadow-sm backdrop-blur-xs border border-slate-200/80">
                            <?= esc_html($cat_label) ?>
                        </span>
                    </div>
                </a>

                <!-- Card Body -->
                <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between">
                    <div>
                        <!-- Meta: Date & Read Time -->
                        <div class="flex items-center gap-3 text-xs text-slate-500 mb-3 font-semibold">
                            <time datetime="<?= get_the_date('c', $post_id) ?>" class="inline-flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <?= get_the_date('M j, Y', $post_id) ?>
                            </time>
                            <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                            <span class="inline-flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <?= esc_html($read_time) ?> min read
                            </span>
                        </div>

                        <!-- Title -->
                        <h3 class="font-heading font-black text-lg sm:text-xl text-ink group-hover:text-primary transition-colors line-clamp-2 mb-3 leading-snug">
                            <a href="<?= esc_url($permalink) ?>">
                                <?= esc_html($article->post_title) ?>
                            </a>
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-sm text-slate-600 line-clamp-3 mb-5 leading-relaxed">
                            <?= esc_html($excerpt) ?>
                        </p>
                    </div>

                    <!-- Footer Link -->
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                        <a href="<?= esc_url($permalink) ?>" class="inline-flex items-center gap-1.5 text-sm font-bold text-primary-dark group-hover:text-primary transition-colors">
                            <span>Read Article</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-12 bg-white rounded-2xl border border-slate-200 p-8">
            <p class="text-slate-500 font-medium">No articles published yet.</p>
        </div>
        <?php endif; ?>

        <!-- View All Button -->
        <?php if ($show_view_all && !empty($button_text) && !empty($button_url)): ?>
        <div class="mt-10 md:mt-12 text-center">
            <a href="<?= esc_url($button_url) ?>" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-full font-bold text-sm bg-primary text-primary-foreground hover:bg-primary-dark transition-all shadow-sm hover:shadow-md hover:scale-[1.02] active:scale-[0.98]">
                <span><?= esc_html($button_text) ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>
