<?php
/**
 * Customer Reviews Module
 */

$heading = get_sub_field('heading') ?: "What Australian Customers Say";
$desc = get_sub_field('description') ?: "Real testimonials from Waklert Australia users across Australia.";

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
<section class="section-padding bg-white">
    <div class="container-custom">
        <div class="text-center mb-12">
            <span class="inline-block bg-primary-soft text-primary-dark text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4">
                <?= "Customer Reviews" ?>
            </span>
            <h1 class="font-heading text-4xl md:text-5xl font-black text-slate-900 mb-4">
                <?= $heading ?>
            </h1>
            <p class="text-slate-500 max-w-xl mx-auto">
                <?= $desc ?>
            </p>

            <div class="flex items-center justify-center gap-3 mt-5">
                <div class="flex gap-0.5 text-accent">
                    <?php for($i = 0; $i < $average_stars; $i++): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                    </svg>
                    <?php endfor; ?>
                </div>
                <span class="font-heading font-black text-2xl text-slate-900"><?= number_format($average_rating, 1) ?></span>
                <span class="text-slate-500 text-sm">
                    <?= "({$total_reviews} verified reviews)" ?>
                </span>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php
            if ($reviews_query->have_posts()):
                while ($reviews_query->have_posts()): $reviews_query->the_post();
                    $post_id = get_the_ID();
                    $name = get_field('name', $post_id) ?: get_the_title();
                    $meta = get_field('reviewer_meta', $post_id) ?: "Verified Buyer";
                    
                    $title = get_the_title();
                    $body = get_the_content();
                    
                    $rating = (int) get_field('rating', $post_id);
                    if (!$rating) $rating = 5;
                    
                    $initial = !empty($name) ? mb_substr($name, 0, 1) : 'M';
                ?>
                <div class="bg-white border border-stone-200 rounded-xl p-6 hover:border-primary-light hover:shadow-sm transition-all">
                    <div class="flex gap-0.5 mb-3 text-accent">
                        <?php for($i = 0; $i < $rating; $i++): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                        <?php endfor; ?>
                    </div>
                    <h4 class="font-heading font-bold text-slate-900 text-sm mb-2">
                        <?= $title ?>
                    </h4>
                    <p class="text-sm text-slate-500 leading-relaxed mb-4">
                        &ldquo;<?= $body ?>&rdquo;
                    </p>
                    <div class="flex items-center gap-3 pt-3 border-t border-stone-100">
                        <div class="w-8 h-8 rounded-full bg-primary-softer flex items-center justify-center text-primary-dark font-bold text-xs flex-shrink-0">
                            <?= esc_html($initial) ?>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900"><?= esc_html($name) ?></p>
                            <p class="text-[11px] text-slate-400">
                                <?= esc_html($meta) ?> 
                                &bull; <span><?= get_the_date('M j, Y') ?></span>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endwhile;
                wp_reset_postdata();
            else: ?>
                <p class="text-center col-span-full text-slate-500">No reviews found yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
