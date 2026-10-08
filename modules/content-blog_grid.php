<?php
/**
 * Module: Blog Grid
 */
$heading = get_sub_field('heading') ?: "Latest Articles";
$desc = get_sub_field('description');

// Fetch standard posts
$args = array(
    'post_type' => 'post',
    'posts_per_page' => -1,
    'post_status' => 'publish'
);

$query = new WP_Query($args);
$all_articles = $query->posts;

// Sort by date (WP_Query handles this by default, but keeping it just in case)
usort($all_articles, function($a, $b) {
    return strtotime($b->post_date) - strtotime($a->post_date);
});
?>
<section class="section-padding bg-stone-50" data-testid="blog-grid">
    <div class="container-custom">
        <?php if ($heading): ?>
        <div class="mb-10 text-center">
            <h2 class="font-heading text-3xl font-black text-slate-900"><?= esc_html($heading) ?></h2>
            <?php if ($desc): ?>
                <p class="mt-3 text-slate-600"><?= esc_html($desc) ?></p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($all_articles)): ?>
                <?php foreach ($all_articles as $article): ?>
                    <a href="<?= get_permalink($article->ID) ?>" class="group flex flex-col bg-white border border-stone-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all">
                        <div class="p-6 flex-1 flex flex-col">
                            <span class="text-xs font-bold uppercase tracking-widest text-primary mb-3">
                                <?= get_the_date('M j, Y', $article->ID) ?>
                            </span>
                            <h3 class="font-heading font-black text-xl text-slate-900 mb-3 group-hover:text-primary transition-colors">
                                <?= esc_html($article->post_title) ?>
                            </h3>
                            <p class="text-sm text-slate-600 line-clamp-3 mb-4 flex-1">
                                <?php 
                                    // Try to get intro from ACF if available
                                    $modules = get_field('modules', $article->ID);
                                    $excerpt = '';
                                    if ($modules) {
                                        foreach ($modules as $mod) {
                                            if (isset($mod['intro']) && !empty($mod['intro'])) {
                                                $excerpt = $mod['intro'];
                                                break;
                                            }
                                        }
                                    }
                                    if (!$excerpt) {
                                        $excerpt = wp_trim_words($article->post_content, 20);
                                    }
                                    echo esc_html($excerpt);
                                ?>
                            </p>
                            <span class="inline-flex items-center gap-1 text-sm font-bold text-primary-dark">
                                Read article
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-slate-500">No articles found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
