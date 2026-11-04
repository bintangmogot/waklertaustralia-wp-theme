<?php
/**
 * The main template file
 * Handles the Blog index, archives, and search results.
 */

get_header();

$blog_page_id = is_home() ? (int) get_option('page_for_posts') : 0;
$has_modules  = $blog_page_id && have_rows('modules', $blog_page_id);

function modmy_render_blog_loop() {
    $has_posts = have_posts();
    ?>
    <section id="blog-articles" class="py-8 md:py-12 bg-gradient-to-b from-white via-slate-50/40 to-white min-h-[50vh]" aria-label="<?= esc_attr(waklert_content('index_text_fa6c48d810')) ?>">
        <div class="container-site max-w-7xl">
            <?php if ($has_posts) : ?>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php while (have_posts()) : the_post(); 
                        $post_id = get_the_ID();
                        $permalink = get_permalink();
                        $categories = get_the_category($post_id);
                        $cat_label = (!empty($categories) && $categories[0]->name !== 'Uncategorized') 
                            ? $categories[0]->name 
                            : waklert_content('pg_index_category_fallback');

                        // Reading time calculation (~200 wpm)
                        $plain_text = strip_tags(get_the_content());
                        $word_count = str_word_count($plain_text);
                        $read_time = max(1, (int) ceil($word_count / 200));

                        // Excerpt calculation
                        $excerpt = '';
                        $modules = get_field('modules', $post_id);
                        if ($modules) {
                            foreach ($modules as $mod) {
                                if (!empty($mod['intro'])) {
                                    $excerpt = $mod['intro'];
                                    break;
                                }
                            }
                        }
                        if (empty(trim($excerpt))) {
                            $raw_post_excerpt = get_post_field('post_excerpt', $post_id);
                            if (!empty(trim($raw_post_excerpt))) {
                                $excerpt = $raw_post_excerpt;
                            }
                        }
                        if (empty(trim($excerpt))) {
                            $excerpt = get_the_excerpt();
                        }
                        if (empty(trim($excerpt))) {
                            $excerpt = wp_trim_words($plain_text, 22, '...');
                        }
                    ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('group flex flex-col h-full bg-white border-2 border-dashed border-sky-300/80 hover:border-[#0c4161] rounded-2xl overflow-hidden shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 ease-out'); ?>>
                            <!-- Thumbnail / Visual Media Area -->
                            <a href="<?php echo esc_url($permalink); ?>" class="block relative aspect-[16/10] overflow-hidden bg-slate-900 focus:outline-hidden" tabindex="-1" aria-hidden="true">
                                <?php if (has_post_thumbnail($post_id)) : ?>
                                    <?php echo get_the_post_thumbnail($post_id, 'large', [
                                        'class' => 'w-full h-full object-cover transition-transform duration-500 ease-out group-hover:scale-105',
                                        'loading' => 'lazy',
                                        'alt' => esc_attr(get_the_title($post_id))
                                    ]); ?>
                                <?php else : ?>
                                    <!-- Branded Fallback Visual -->
                                    <div class="w-full h-full bg-gradient-to-br from-[#081729] via-[#0d2a4a] to-[#1a4066] flex flex-col items-center justify-center p-6 text-white text-center relative overflow-hidden transition-transform duration-500 ease-out group-hover:scale-105">
                                        <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/5 pointer-events-none"></div>
                                        <div class="absolute -left-6 -bottom-6 w-24 h-24 rounded-full bg-white/5 pointer-events-none"></div>
                                        <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center mb-3 backdrop-blur-xs border border-white/15 text-white/90 shadow-inner">
                                            <?= waklert_content_icon('index_icon_673ed92658') ?>
                                        </div>
                                        <span class="text-xs font-bold tracking-widest uppercase text-white/80"><?= esc_html(waklert_content('index_text_8f30e26088')) ?></span>
                                    </div>
                                <?php endif; ?>

                                <!-- Floating Category Badge -->
                                <div class="absolute top-3.5 left-3.5 z-10">
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-[10px] font-black tracking-wider uppercase bg-amber-400 text-slate-950 shadow-md border border-amber-500/30">
                                        ★ <?php echo esc_html($cat_label); ?>
                                    </span>
                                </div>
                            </a>

                            <!-- Card Body -->
                            <div class="p-6 sm:p-7 flex-1 flex flex-col justify-between bg-white">
                                <div>
                                    <!-- Meta: Date & Read Time -->
                                    <div class="flex items-center gap-3 text-xs text-slate-500 mb-3 font-semibold">
                                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" class="inline-flex items-center gap-1.5">
                                            <?= waklert_content_icon('index_icon_946d59acce') ?>
                                            <?php echo esc_html(get_the_date('j M Y')); ?>
                                        </time>
                                        <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                        <span class="inline-flex items-center gap-1">
                                            <?= waklert_content_icon('index_icon_087a81bc80') ?>
                                            <?php echo esc_html($read_time); ?> <?= esc_html(waklert_content('index_text_20439f05f2')) ?>
                                        </span>
                                    </div>

                                    <!-- Title -->
                                    <h2 class="font-heading font-black text-xl sm:text-2xl text-[#0c4161] group-hover:text-sky-900 transition-colors line-clamp-2 mb-3 leading-snug">
                                        <a href="<?php echo esc_url($permalink); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>

                                    <!-- Excerpt -->
                                    <p class="text-sm text-slate-600 line-clamp-3 mb-4 leading-relaxed flex-1">
                                        <?php echo esc_html(wp_trim_words($excerpt, 22, '...')); ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Two-Tone Footer Block -->
                            <a href="<?php echo esc_url($permalink); ?>" class="bg-[#f0f6fa] group-hover:bg-[#0c4161] p-3 px-4 sm:p-4 sm:px-6 border-t-2 border-dashed border-sky-200/80 flex items-center justify-between transition-colors duration-300 text-xs sm:text-sm font-black text-[#0c4161] group-hover:text-white mt-auto">
                                <span><?= esc_html(waklert_content('index_text_83cfdb2776')) ?></span>
                                <?= waklert_content_icon('index_icon_76f8373bb5') ?>
                            </a>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="mt-12 flex justify-center">
                    <?php
                    $pages = paginate_links([
                        'mid_size'  => 2,
                        'prev_text' => '&larr;',
                        'next_text' => '&rarr;',
                        'type'      => 'array',
                    ]);

                    if (!empty($pages)) {
                        echo '<ul class="flex flex-wrap items-center justify-center gap-2">';
                        foreach ($pages as $page) {
                            if (strpos($page, 'current') !== false) {
                                $num = strip_tags($page);
                                echo '<li><span class="flex h-10 w-10 pointer-events-none items-center justify-center rounded-xl bg-[#0c4161] text-sm font-black text-white shadow-sm">' . esc_html($num) . '</span></li>';
                            } elseif (strpos($page, 'dots') !== false) {
                                echo '<li><span class="flex h-10 w-10 items-center justify-center font-bold text-slate-400">&hellip;</span></li>';
                            } else {
                                $styled_link = preg_replace(
                                    '/class="([^"]*)"/',
                                    'class="$1 flex h-10 w-10 items-center justify-center rounded-xl border-2 border-dashed border-sky-200/80 bg-white text-sm font-bold text-[#0c4161] transition-all hover:bg-sky-50 hover:border-sky-300 hover:shadow-xs"',
                                    $page
                                );
                                if (strpos($styled_link, 'class=') === false) {
                                    $styled_link = str_replace('<a ', '<a class="flex h-10 w-10 items-center justify-center rounded-xl border-2 border-dashed border-sky-200/80 bg-white text-sm font-bold text-[#0c4161] transition-all hover:bg-sky-50 hover:border-sky-300 hover:shadow-xs" ', $styled_link);
                                }
                                echo '<li>' . $styled_link . '</li>';
                            }
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>
            <?php else : ?>
                <div class="col-span-full py-12 text-center">
                    <div class="mx-auto max-w-xl rounded-3xl border-2 border-dashed border-sky-200/80 bg-white px-6 py-12 shadow-xs md:px-10">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161]">
                            <?php echo esc_html(is_search() ? waklert_content('pg_index_search') : waklert_content('pg_archive_blog_label')); ?>
                        </span>
                        <h2 class="mt-4 font-heading text-2xl font-black text-[#0c4161] md:text-3xl">
                            <?php echo esc_html(is_search() ? waklert_content('pg_archive_empty_search') : waklert_content('pg_archive_empty_blog')); ?>
                        </h2>
                        <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-slate-600">
                            <?php echo esc_html(is_search() ? waklert_content('pg_archive_empty_search_hint') : waklert_content('pg_archive_empty_blog_hint')); ?>
                        </p>
                        <?php if (is_search()) : ?>
                            <div class="mx-auto mt-6 max-w-md">
                                <?php get_search_form(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
}

if (is_home() && $has_modules) {
    $rendered_loop = false;
    while (have_rows('modules', $blog_page_id)) {
        the_row();
        $layout = get_row_layout();

        if ($layout === 'posts_grid' || $layout === 'blog_grid') {
            modmy_render_blog_loop();
            $rendered_loop = true;
        } else {
            get_template_part('modules/content', $layout);
            if ($layout === 'page_hero' && !$rendered_loop) {
                $raw_modules = get_field('modules', $blog_page_id) ?: [];
                $remaining_layouts = array_column($raw_modules, 'acf_fc_layout');
                if (!in_array('posts_grid', $remaining_layouts, true) && !in_array('blog_grid', $remaining_layouts, true)) {
                    modmy_render_blog_loop();
                    $rendered_loop = true;
                }
            }
        }
    }

    if (!$rendered_loop) {
        modmy_render_blog_loop();
    }
} else {
    $title = waklert_content('pg_archive_title');
    $subtitle = waklert_content('pg_archive_subtitle');

    if (is_archive()) {
        $archive_title = get_the_archive_title();
        $title = $archive_title ? wp_strip_all_tags($archive_title) : $title;
        $subtitle = get_the_archive_description();
    } elseif (is_search()) {
        $title = waklert_content('pg_index_search_heading') . ' ' . get_search_query();
        $subtitle = '';
    }
    ?>
    <section class="relative overflow-hidden border-b-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-10 md:py-14" data-testid="blog-archive-hero">
        <div class="container-site mx-auto max-w-4xl px-4 relative z-10">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs mb-3">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                <?php echo esc_html(is_search() ? waklert_content('pg_archive_search_label') : waklert_content('pg_archive_blog_label')); ?>
            </span>
            <h1 class="mx-auto mt-2 max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl font-black leading-tight tracking-tight text-[#0c4161]">
                <?php echo esc_html($title); ?>
            </h1>
            <?php if ($subtitle) : ?>
                <div class="mx-auto mt-4 max-w-2xl text-sm md:text-base leading-relaxed text-slate-600">
                    <?php echo is_archive() ? wp_kses_post($subtitle) : esc_html($subtitle); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
    modmy_render_blog_loop();
}

get_footer();
