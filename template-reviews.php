<?php
/**
 * Template Name: Reviews Page
 */

get_header();
?>

<main class="site-main mt-8 mb-16">
    <section class="section-padding bg-white" data-testid="section-general-reviews">
        <?php
        $reviews = get_posts([
            "post_type" => "review",
            "posts_per_page" => -1,
            "orderby" => "date",
            "order" => "DESC",
            "meta_query" => array(
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
        $review_count = count($reviews);
        ?>
        <div class="container-site max-w-4xl mx-auto px-4">
            <div class="text-center mb-10">
                <h1 class="font-heading text-3xl md:text-5xl font-extrabold text-slate-900 mb-4">
                    <?= "Customer Reviews" ?>
                </h1>
                <p class="text-slate-600 mb-4 text-lg">
                    <?= "See what our customers have to say about their experience." ?>
                </p>
                <?php if ($review_count > 0): ?>
                <div class="flex items-center justify-center gap-2">
                    <div class="flex items-center gap-0.5 text-accent">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                            </svg>
                        <?php endfor; ?>
                    </div>
                    <span class="text-base font-semibold text-slate-600">
                        <?= sprintf("4.8 out of 5 (%d reviews)", $review_count) ?>
                    </span>
                </div>
                <?php endif; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php
                if ($reviews):
                    foreach ($reviews as $i => $r):
                        $post_id = $r->ID;
                        $title = get_the_title($post_id);
                        $body = get_post_field('post_content', $post_id);
                        $reviewer = get_field("name", $post_id) ?: $r->post_title;
                        $meta = get_field('reviewer_meta', $post_id) ?: "Verified Buyer";
                        $rating_val = get_field("rating", $post_id) ?: 5;
                        ?>
                        <div class="bg-white border-2 border-slate-200 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow" data-testid="review-<?= $i ?>">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-base uppercase">
                                        <?= substr($reviewer, 0, 1) ?>
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-slate-900 flex items-center gap-1.5 whitespace-nowrap">
                                            <?= esc_html($reviewer) ?>
                                            <span class="inline-flex items-center gap-0.5 text-[10px] font-bold text-green-600 leading-none" data-testid="badge-verified-buyer">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <?= "Verified Buyer" ?>
                                            </span>
                                        </p>
                                        <p class="text-[11px] text-slate-500 font-medium mt-0.5"><?= esc_html($meta) ?></p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-0.5 text-accent">
                                    <?php for ($stars = 0; $stars < 5; $stars++): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 <?= ($stars < $rating_val) ? "text-accent" : "text-slate-200" ?>" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                        </svg>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <p class="font-bold text-base text-slate-900 mb-2 leading-snug">
                                <?= $title ?>
                            </p>
                            <p class="text-sm text-slate-600 leading-relaxed">
                                &ldquo;<?= $body ?>&rdquo;
                            </p>
                        </div>
                    <?php
                    endforeach;
                else:
                    echo "<div class=\"col-span-full py-12 text-center text-slate-500 bg-slate-50 rounded-xl border border-slate-200\">";
                    echo "<p class=\"text-lg font-medium\">" . "No reviews found." . "</p>";
                    echo "</div>";
                endif;
                ?>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
