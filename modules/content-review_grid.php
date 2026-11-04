<?php
/**
 * Module: Review Grid
 */

if (waklert_module_is_empty()) { return; }

$tag = waklert_module_text('tag');

$heading = waklert_module_text('heading');

$desc = waklert_module_text('description');

// Fetch reviews from CPT
$reviews = get_posts([
    'post_type' => 'review',
    'posts_per_page' => -1,
    'orderby' => 'date',
    'order' => 'DESC',
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
?>
<section class="section-padding bg-white">
    <div class="container-custom max-w-5xl">
        <div class="text-center mb-12">
            <?php if (waklert_has_content($tag)): ?><span class="inline-block bg-primary-soft text-primary-dark text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4">
                <?= $tag ?>
            </span><?php endif; ?>
            <?php if (waklert_has_content($heading)): ?><h1 class="font-heading text-4xl md:text-5xl font-black text-ink mb-4">
                <?= $heading ?>
            </h1><?php endif; ?>
            <?php if (waklert_has_content($desc)): ?><p class="text-muted-foreground max-w-xl mx-auto">
                <?= $desc ?>
            </p><?php endif; ?>

            <div class="flex items-center justify-center gap-3 mt-5">
                <div class="flex gap-0.5 text-accent">
                    <?php for($i=0; $i<5; $i++): ?>
                    <?= waklert_content_icon('content_review_grid_icon_7577c020ff') ?>
                    <?php endfor; ?>
                </div>
                <span class="font-heading font-black text-2xl text-ink">4.9</span>
                <?php if (waklert_has_content(esc_html(waklert_content('content_review_grid_text_0511a9d4b2')))): ?><span class="text-muted-foreground text-sm">
                    <?= esc_html(waklert_content('content_review_grid_text_0511a9d4b2')) ?>
                </span><?php endif; ?>
            </div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php 
            if($reviews):
                foreach($reviews as $r):
                    $post_id = is_object($r) ? $r->ID : $r;
                    $title = get_the_title($post_id);
                    $body = get_post_field('post_content', $post_id);
                    $reviewer = get_field('name', $post_id) ?: (is_object($r) ? $r->post_title : get_the_title($post_id));
                    $meta = get_field('reviewer_meta', $post_id) ?: waklert_content('content_review_grid_text_2d2f65336a');
                    $rating_val = get_field('rating', $post_id) ?: 5;
            ?>
            <div class="bg-white border border-stone-200 rounded-xl p-6 hover:border-primary-soft hover:shadow-sm transition-all">
                <div class="flex gap-0.5 mb-3 text-accent">
                    <?php for($i=0; $i < $rating_val; $i++): ?>
                    <?= waklert_content_icon('content_review_grid_icon_6d5e051030') ?>
                    <?php endfor; ?>
                </div>
                <?php if (waklert_has_content($title)): ?><h4 class="font-heading font-bold text-ink text-sm mb-2"><?= $title ?></h4><?php endif; ?>
                <?php if (waklert_has_content($body)): ?><p class="text-sm text-muted-foreground leading-relaxed mb-4">
                    <?= esc_html(waklert_content('content_review_grid_text_8009b97b02')) ?><?= $body ?><?= esc_html(waklert_content('content_review_grid_text_276073cb09')) ?>
                </p><?php endif; ?>
                <div class="flex items-center gap-3 pt-3 border-t border-stone-100">
                    <?php if (waklert_has_content(substr($reviewer, 0, 1))): ?><div class="w-8 h-8 rounded-full bg-primary-softer flex items-center justify-center text-primary-dark font-bold text-xs flex-shrink-0">
                        <?= substr($reviewer, 0, 1) ?>
                    </div><?php endif; ?>
                    <div>
                        <?php if (waklert_has_content(esc_html($reviewer))): ?><p class="text-xs font-bold text-ink"><?= esc_html($reviewer) ?></p><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($meta)) || waklert_has_content(get_the_date('M j, Y', $post_id))): ?><p class="text-[11px] text-muted-foreground">
                            <?= esc_html($meta) ?>
                            &bull; <?php if (waklert_has_content(get_the_date('M j, Y', $post_id))): ?><span><?= get_the_date('M j, Y', $post_id) ?></span><?php endif; ?>
                        </p><?php endif; ?>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            else:
                echo "<p class='col-span-full text-center text-muted-foreground'>" . waklert_content('content_review_grid_text_6291960655') . "</p>";
            endif; 
            ?>
        </div>
    </div>
</section>
