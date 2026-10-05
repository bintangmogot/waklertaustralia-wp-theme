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
    <section id="blog-articles" class="section-y min-h-[50vh] bg-background" aria-label="Articles">
        <div class="container-site grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php if ($has_posts) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('group flex flex-col overflow-hidden rounded-2xl border border-border bg-card shadow-card transition-all hover:-translate-y-1 hover:border-primary hover:shadow-card-hover'); ?>>
                        <a href="<?php the_permalink(); ?>" class="flex h-full flex-col focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="aspect-video overflow-hidden">
                                    <?php the_post_thumbnail('medium_large', ['class' => 'h-full w-full object-cover transition-transform duration-500 group-hover:scale-105', 'loading' => 'lazy']); ?>
                                </div>
                            <?php else : ?>
                                <div class="relative isolate flex aspect-video items-end overflow-hidden bg-primary-dark p-6 text-white sm:p-7">
                                    <div aria-hidden="true" class="pointer-events-none absolute -right-40 -top-48 z-0 h-[34rem] w-[34rem] rounded-full border border-white/10"></div>
                                    <div aria-hidden="true" class="pointer-events-none absolute -right-20 -top-28 z-0 h-[26rem] w-[26rem] rounded-full border border-white/10"></div>
                                    <div aria-hidden="true" class="pointer-events-none absolute -bottom-64 left-[34%] z-0 h-[32rem] w-[32rem] rounded-full border border-white/5"></div>
                                    <div class="relative z-10">
                                        <span class="mb-3 inline-flex rounded-full border border-white/20 bg-white/10 px-3 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-white/85">Waklert Australia Insights</span>
                                        <p class="font-heading text-xl font-extrabold leading-tight tracking-tight sm:text-2xl"><?php the_title(); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="flex flex-1 flex-col p-6">
                                <div class="flex flex-wrap items-center gap-3">
                                    <?php
                                    $cat_name = modmy_get_post_category(get_the_ID());
                                    if ($cat_name) :
                                    ?>
                                        <span class="eyebrow"><?php echo esc_html($cat_name); ?></span>
                                    <?php endif; ?>
                                    <time class="text-xs text-muted-foreground" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo esc_html(get_the_date('j M Y')); ?>
                                    </time>
                                </div>

                                <h2 class="mt-4 font-heading text-lg font-bold leading-snug text-foreground transition-colors group-hover:text-primary">
                                    <?php the_title(); ?>
                                </h2>

                                <p class="mt-3 flex-1 text-sm leading-relaxed text-muted-foreground">
                                    <?php
                                    $excerpt = get_the_excerpt();
                                    if (empty(trim($excerpt))) {
                                        $modules = get_field('modules', get_the_ID());
                                        if ($modules) {
                                            foreach ($modules as $mod) {
                                                if (!empty($mod['intro'])) {
                                                    $excerpt = $mod['intro'];
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    if (empty(trim($excerpt))) {
                                        $excerpt = wp_trim_words(get_the_content(), 24);
                                    }
                                    echo esc_html(wp_trim_words($excerpt, 24));
                                    ?>
                                </p>

                                <span class="mt-5 text-sm font-bold text-primary transition-colors group-hover:text-primary-dark">
                                    Read article <span aria-hidden="true">&rarr;</span>
                                </span>
                            </div>
                        </a>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-span-full py-12 text-center">
                    <div class="mx-auto max-w-xl rounded-3xl border border-border bg-card px-6 py-12 shadow-card md:px-10">
                        <span class="eyebrow"><?php echo is_search() ? 'Search' : 'Waklert Australia Insights'; ?></span>
                        <h2 class="mt-4 font-heading text-2xl font-bold text-foreground md:text-3xl">
                            <?php echo is_search() ? 'No results found' : 'No articles are published yet'; ?>
                        </h2>
                        <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-muted-foreground">
                            <?php echo is_search() ? 'Try a different search term.' : 'Please check back for new articles and general information.'; ?>
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

        <?php if ($has_posts) : ?>
            <div class="container-site mt-12 flex justify-center">
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
                            echo '<li><span class="flex h-10 w-10 pointer-events-none items-center justify-center rounded-md bg-primary text-sm font-bold text-primary-foreground shadow-sm">' . esc_html($num) . '</span></li>';
                        } elseif (strpos($page, 'dots') !== false) {
                            echo '<li><span class="flex h-10 w-10 items-center justify-center font-normal text-muted-foreground">&hellip;</span></li>';
                        } else {
                            $styled_link = preg_replace(
                                '/class="([^"]*)"/',
                                'class="$1 flex h-10 w-10 items-center justify-center rounded-md border border-border bg-card text-sm font-bold text-foreground transition-all hover:border-primary hover:text-primary hover:shadow-sm"',
                                $page
                            );
                            if (strpos($styled_link, 'class=') === false) {
                                $styled_link = str_replace('<a ', '<a class="flex h-10 w-10 items-center justify-center rounded-md border border-border bg-card text-sm font-bold text-foreground transition-all hover:border-primary hover:text-primary hover:shadow-sm" ', $styled_link);
                            }
                            echo '<li>' . $styled_link . '</li>';
                        }
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        <?php endif; ?>
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
    $title = 'Articles & Guides';
    $subtitle = 'General information, site updates and resources. Website content is not individual medical advice.';

    if (is_archive()) {
        $archive_title = get_the_archive_title();
        $title = $archive_title ? wp_strip_all_tags($archive_title) : $title;
        $subtitle = get_the_archive_description();
    } elseif (is_search()) {
        $title = 'Search results for: ' . get_search_query();
        $subtitle = '';
    }
    ?>
    <section class="border-b border-border bg-gradient-to-b from-primary-softer via-primary-softer/70 to-background text-center" data-testid="blog-archive-hero">
        <div class="container-site mx-auto max-w-4xl py-16 md:py-20">
            <span class="eyebrow">Waklert Australia Insights</span>
            <h1 class="mx-auto mt-5 max-w-4xl font-heading text-4xl font-extrabold leading-tight tracking-tight text-foreground sm:text-5xl md:text-6xl">
                <?php echo esc_html($title); ?>
            </h1>
            <?php if ($subtitle) : ?>
                <div class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-muted-foreground md:text-lg">
                    <?php echo is_archive() ? wp_kses_post($subtitle) : esc_html($subtitle); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
    modmy_render_blog_loop();
}

get_footer();
