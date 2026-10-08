<?php
/**
 * The template for displaying individual blog posts.
 */

get_header();
?>

<main>
    <?php
    // Check if the post uses ACF Flexible Content Modules (like the policy layout)
    if (have_rows('modules')) {
        while (have_rows('modules')) {
            the_row();
            $layout = get_row_layout();
            get_template_part('modules/content', $layout);
        }
    } else {
        // Fallback to standard post layout
        while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="border-b border-border bg-gradient-to-b from-primary-softer via-primary-softer/70 to-background text-center" data-testid="single-post-hero">
                <div class="container-site mx-auto max-w-4xl py-12 md:py-16">
                    <nav aria-label="Breadcrumb" class="mb-7 flex flex-wrap items-center justify-center gap-2 text-xs text-muted-foreground">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="transition-colors hover:text-primary">Home</a>
                        <span aria-hidden="true">/</span>
                        <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="transition-colors hover:text-primary">Insights</a>
                        <span aria-hidden="true">/</span>
                        <span class="max-w-[14rem] truncate text-foreground"><?php the_title(); ?></span>
                    </nav>

                    <?php $category = modmy_get_post_category(get_the_ID()); ?>
                    <?php if ($category) : ?>
                        <span class="eyebrow"><?php echo esc_html($category); ?></span>
                    <?php else : ?>
                        <span class="eyebrow">Waklert Australia Insights</span>
                    <?php endif; ?>

                    <h1 class="mx-auto mt-5 max-w-4xl font-heading text-4xl font-extrabold leading-tight tracking-tight text-foreground sm:text-5xl md:text-6xl">
                        <?php the_title(); ?>
                    </h1>

                    <?php $excerpt = get_the_excerpt(); ?>
                    <?php if ($excerpt) : ?>
                        <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-muted-foreground md:text-lg">
                            <?php echo esc_html($excerpt); ?>
                        </p>
                    <?php endif; ?>

                    <div class="mt-6 flex flex-wrap items-center justify-center gap-2 text-xs text-muted-foreground">
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j F Y')); ?></time>
                        <span aria-hidden="true">&middot;</span>
                        <span><?php echo esc_html(get_the_author()); ?></span>
                    </div>
                </div>
            </header>

            <div class="section-padding min-h-[50vh] bg-background">
                <div class="container-site max-w-3xl">
                    <?php if (has_post_thumbnail()) : ?>
                        <figure class="mb-8 overflow-hidden rounded-2xl border border-border shadow-card">
                            <?php the_post_thumbnail('large', ['class' => 'h-auto w-full object-cover', 'loading' => 'eager']); ?>
                        </figure>
                    <?php endif; ?>

                    <div class="prose prose-slate max-w-none prose-a:text-primary hover:prose-a:text-primary-dark prose-headings:font-heading prose-headings:font-bold">
                        <?php the_content(); ?>
                    </div>

                    <?php if (comments_open() || get_comments_number()) : ?>
                        <div class="mt-12 border-t border-border pt-8">
                            <?php comments_template(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    <?php endwhile; 
    } // End else
    ?>
</main>

<?php get_footer(); ?>