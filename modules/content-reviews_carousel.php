<?php
/**
 * Module: Reviews Carousel
 * Follows the colorful card design rules:
 * - Multi-color vibrant vector icons & 5-star ratings
 * - 2-tone card structure (White quote top + Navy reviewer footer block)
 * - Dashed borders
 * - Patterned gradient background
 * - Lift & hover animations
 */

if (waklert_module_is_empty()) { return; }

$tag = waklert_module_text('badge');
$heading = waklert_module_text('title');
$description = waklert_module_text('description');
$button_text = waklert_module_text('button_text');
$button_href = waklert_resolve_link(waklert_module_text('button_url'));
$verified_label = waklert_module_text('verified_label');

$reviews = get_sub_field('reviews');
?>
<section class="section-padding bg-gradient-to-b from-[#f0f6fa] via-[#e9f2f8] to-[#f8fafc] bg-pattern-dots border-t-2 border-solid border-sky-200/80 relative isolate overflow-hidden" data-testid="testimonials">
    <div class="container-custom relative z-10">
        <!-- Section Header -->
        <?php if ((waklert_has_content(esc_html($tag))) || (waklert_has_content(esc_html($heading))) || (waklert_has_content(esc_html($description)))): ?><div class="text-center max-w-3xl mx-auto mb-10 md:mb-12">
            <?php if (waklert_has_content(esc_html($tag))): ?><span class="inline-flex items-center gap-2 bg-amber-100 text-amber-900 border border-amber-300 text-xs font-black uppercase tracking-widest px-4 py-1.5 rounded-full mb-3 shadow-xs">
                <span class="text-amber-500"><?= str_repeat(waklert_content_icon('manual_star_marker'), 5) ?></span>
                <?= esc_html($tag) ?>
            </span><?php endif; ?>
            <?php if (waklert_has_content(esc_html($heading))): ?><h2 class="font-heading text-2xl md:text-4xl font-black text-ink tracking-tight mb-3">
                <?= esc_html($heading) ?>
            </h2><?php endif; ?>
            <?php if (waklert_has_content(esc_html($description))): ?><p class="text-sm md:text-base text-muted-foreground leading-relaxed max-w-xl mx-auto">
                <?= esc_html($description) ?>
            </p><?php endif; ?>
        </div><?php endif; ?>

        <!-- Horizontal Scrollable Review Cards -->
        <div class="flex gap-6 overflow-x-auto pb-6 pt-2 snap-x snap-mandatory scrollbar-hide -mx-4 px-4 sm:mx-0 sm:px-0">
            <?php 
            if(!empty($reviews)):
                foreach($reviews as $r):
                    $post_id = is_object($r) ? $r->ID : $r;
                    $title = get_the_title($post_id);
                    $body = get_post_field('post_content', $post_id);
                    $reviewer = get_field('name', $post_id) ?: (is_object($r) ? $r->post_title : get_the_title($post_id));
                    $meta = get_field('reviewer_meta', $post_id) ?: waklert_content('content_reviews_carousel_text_0defd22ae1');
                    $rating_val = get_field('rating', $post_id) ?: 5;
                    $review_date = get_field('review_date', $post_id) ?: get_the_date('M j, Y', $post_id);
            ?>
            <div class="group flex flex-col justify-between bg-white border-2 border-solid border-sky-300/80 hover:border-amber-400 rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex-shrink-0 w-[310px] sm:w-[340px] snap-start">
                <!-- Top Half: Crisp White Surface with Golden Stars & Quote -->
                <div class="p-6 flex-1 flex flex-col justify-start bg-white relative">
                    <!-- Colorful Quote Mark & 5-Star Row -->
                    <div class="flex items-center justify-between mb-3.5">
                        <div class="flex items-center gap-1 text-amber-400">
                            <?php for($i=0; $i < $rating_val; $i++): ?>
                            <?= waklert_content_icon('content_reviews_carousel_icon_f715c1c786') ?>
                            <?php endfor; ?>
                        </div>
                        <!-- Colorful Quote SVG -->
                        <div class="w-7 h-7 rounded-lg bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-600">
                            <?= waklert_content_icon('content_reviews_carousel_icon_9c5d17a257') ?>
                        </div>
                    </div>

                    <?php if (waklert_has_content(esc_html($title))): ?><h4 class="font-heading font-black text-ink text-base md:text-lg mb-2.5 leading-snug group-hover:text-[#0c4161] transition-colors">
                        <?= esc_html($title) ?>
                    </h4><?php endif; ?>
                    <?php if (waklert_has_content($body)): ?><p class="text-xs md:text-sm text-slate-600 leading-relaxed italic">
                        <?= esc_html(waklert_content('content_reviews_carousel_text_6fbc934d31')) ?><?= esc_html(trim(wp_strip_all_tags($body))) ?><?= esc_html(waklert_content('content_reviews_carousel_text_24575dc320')) ?>
                    </p><?php endif; ?>
                </div>

                <!-- Bottom Half: Solid Navy Footer with Reviewer Info -->
                <div class="bg-[#0c4161] group-hover:bg-[#082c42] text-white p-4 px-5 flex items-center justify-between transition-colors duration-300 border-t-2 border-solid border-white/20">
                    <?php if ((waklert_has_content(esc_html(strtoupper(substr($reviewer, 0, 1))))) || (waklert_has_content(esc_html($reviewer))) || (waklert_has_content(esc_html($verified_label)))): ?><div class="flex items-center gap-3">
                        <?php if (waklert_has_content(esc_html(strtoupper(substr($reviewer, 0, 1))))): ?><div class="w-9 h-9 rounded-full bg-gradient-to-br from-amber-400 to-amber-500 text-slate-950 font-black text-sm flex items-center justify-center shadow-xs shrink-0">
                            <?= esc_html(strtoupper(substr($reviewer, 0, 1))) ?>
                        </div><?php endif; ?>
                        <?php if ((waklert_has_content(esc_html($reviewer))) || (waklert_has_content(esc_html($verified_label)))): ?><div>
                            <?php if (waklert_has_content(esc_html($reviewer))): ?><p class="text-xs font-bold text-white leading-tight"><?= esc_html($reviewer) ?></p><?php endif; ?>
                            <?php if (waklert_has_content(esc_html($verified_label))): ?><p class="text-[11px] text-emerald-300 font-semibold leading-tight mt-0.5">
                                <?= esc_html($verified_label) ?>
                            </p><?php endif; ?>
                        </div><?php endif; ?>
                    </div><?php endif; ?>
                    <?php if ($review_date): ?>
                    <?php if (waklert_has_content(esc_html($review_date))): ?><span class="text-[10px] text-white/70 font-medium"><?= esc_html($review_date) ?></span><?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php 
                endforeach;
            endif;
            ?>
        </div>

        <div class="text-center mt-8">
            <?php if ((waklert_has_content(esc_html($button_text))) && waklert_has_content(esc_url($button_href))): ?><a href="<?= esc_url($button_href) ?>" class="inline-flex items-center gap-2 border-2 border-solid border-sky-300/90 bg-white hover:bg-[#0c4161] text-[#0c4161] hover:text-white font-extrabold px-5 py-2.5 sm:px-8 sm:py-3.5 rounded-full transition-all duration-300 uppercase tracking-wider sm:tracking-widest text-xs shadow-sm hover:shadow-md hover:-translate-y-0.5">
                <?php if (waklert_has_content(esc_html($button_text))): ?><span><?= esc_html($button_text) ?></span><?php endif; ?>
                <?= waklert_content_icon('content_reviews_carousel_icon_41430d82e3') ?>
            </a><?php endif; ?>
        </div>
    </div>
</section>
