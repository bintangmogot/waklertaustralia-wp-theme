<?php
/**
 * Module: Reviews Carousel
 */

$tag = "Reviews";

$heading = get_sub_field('title') ?: "Customer Reviews";

$reviews = get_sub_field('reviews');

// Reviews must be selected explicitly. Never display cloned testimonials as
// if they were reviews of Waklert Australia.
if (empty($reviews)) {
    return;
}
?>
<section class="section-padding bg-stone-50" data-testid="testimonials">
    <div class="container-custom">
        <div class="text-center mb-10">
            <span class="inline-block bg-primary-soft text-primary-dark text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4">
                <?= $tag ?>
            </span>
            <h2 class="font-heading text-2xl md:text-4xl font-black text-ink mb-3">
                <?= $heading ?>
            </h2>
        </div>

        <div class="flex gap-5 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-hide">
            <?php 
            if($reviews):
                foreach($reviews as $r):
                    $post_id = is_object($r) ? $r->ID : $r;
                    
                    $title = get_the_title($post_id);
                    
                    $body = get_post_field('post_content', $post_id);
                    
                    $reviewer = get_field('name', $post_id) ?: (is_object($r) ? $r->post_title : get_the_title($post_id));
                    $meta = get_field('reviewer_meta', $post_id) ?: "Verified Buyer";
                    $rating_val = get_field('rating', $post_id) ?: 5;
                    $review_date = get_field('review_date', $post_id) ?: get_the_date(get_option('date_format'), $post_id);
            ?>
            <div class="bg-white border border-stone-200 rounded-xl p-6 flex-shrink-0 w-[320px] snap-start transition-all hover:-translate-y-1 hover:border-primary/30 hover:shadow-md">
                <div class="flex gap-0.5 mb-3 text-accent">
                    <?php for($i=0; $i < $rating_val; $i++): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                    <?php endfor; ?>
                </div>
                <h4 class="font-heading font-bold text-ink text-sm mb-2"><?= $title ?></h4>
                <p class="text-sm text-muted-foreground leading-relaxed mb-4">
                    &ldquo;<?= $body ?>&rdquo;
                </p>
                <div class="flex items-center gap-3 pt-3 border-t border-stone-100">
                    <div class="w-8 h-8 rounded-full bg-primary-softer flex items-center justify-center text-primary-dark font-bold text-xs flex-shrink-0">
                        <?= substr($reviewer, 0, 1) ?>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-ink"><?= $reviewer ?></p>
                        <p class="text-[11px] text-muted-foreground"><?= esc_html($meta) ?><?php if ($review_date): ?> · <?= esc_html($review_date) ?><?php endif; ?></p>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            else:
            ?>
            <!-- Placeholder if no reviews exist yet -->
            <div class="bg-white border border-stone-200 rounded-xl p-6 flex-shrink-0 w-[320px] snap-start">
                <div class="flex gap-0.5 mb-3 text-accent">
                    <?php for($i=0; $i<5; $i++): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                    <?php endfor; ?>
                </div>
                <h4 class="font-heading font-bold text-ink text-sm mb-2">Life-changing focus</h4>
                <p class="text-sm text-muted-foreground leading-relaxed mb-4">
                    &ldquo;Helped me get through my finals. Delivery was surprisingly fast!&rdquo;
                </p>
                <div class="flex items-center gap-3 pt-3 border-t border-stone-100">
                    <div class="w-8 h-8 rounded-full bg-primary-softer flex items-center justify-center text-primary-dark font-bold text-xs flex-shrink-0">A</div>
                    <div>
                        <p class="text-xs font-bold text-ink">Ahmad F.</p>
                        <p class="text-[11px] text-muted-foreground">Kuala Lumpur</p>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-8">
            <a href="<?= home_url('/reviews') ?>" class="inline-flex items-center gap-2 border-2 border-primary-light text-primary-dark font-bold px-7 py-3 rounded-full hover:bg-primary-light hover:text-white hover:border-primary-light transition-all uppercase tracking-widest text-sm">
                <?= "Read All Reviews" ?>
            </a>
        </div>
    </div>
</section>
