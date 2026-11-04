<?php
/**
 * Module: Product Guide
 * "Choosing the Right Armodafinil"
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

if (waklert_module_is_empty()) { return; }

// The shop page omits the product comparison section per user request.
if (function_exists('is_shop') && is_shop()) {
    return;
}

$heading = waklert_content('content_product_guide_text_646cb601b9');
$desc    = waklert_content('content_product_guide_text_198c0aab04');
$guide_items = waklert_module_rows('guide_items');
$is_buyers_guide = is_page('buyers-guide');

if (!$heading && !$desc && !$guide_items) {
    return;
}
?>

<section class="py-8 md:py-12 bg-gradient-to-b from-white via-slate-50/50 to-white" data-testid="product-guide">
    <div class="container-site <?= $is_buyers_guide ? 'max-w-6xl' : 'max-w-4xl' ?>">
        
        <div class="text-center mb-10 max-w-3xl mx-auto">
            <?php if (waklert_has_content(esc_html(waklert_content('content_product_guide_text_0e4b8798f5')))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161]">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                <?= esc_html(waklert_content('content_product_guide_text_0e4b8798f5')) ?>
            </span><?php endif; ?>
            <?php if (waklert_has_content(esc_html($heading))): ?><h2 class="mt-2.5 font-heading text-2xl sm:text-3xl md:text-4xl font-black text-[#0c4161]"><?= esc_html($heading) ?></h2><?php endif; ?>
            <?php if ($desc): ?>
                <?php if (waklert_has_content(esc_html($desc))): ?><p class="mx-auto mt-3 max-w-2xl text-sm sm:text-base leading-relaxed text-slate-600"><?= esc_html($desc) ?></p><?php endif; ?>
            <?php endif; ?>
        </div>
        
        <div class="<?= $is_buyers_guide ? 'grid gap-6 sm:grid-cols-2 lg:grid-cols-3' : 'space-y-6' ?>">
            <?php if (have_rows('guide_items')): ?>
                <?php $guide_idx = 0; while (have_rows('guide_items')): the_row();
        if (!waklert_module_row_has_content(get_row(true))) { continue; } $guide_idx++; ?>
                <?php
                    $item_title = get_sub_field('title');
                    $item_description = get_sub_field('description');
                    $item_note = get_sub_field('best_for');
                    $item_initial = $item_title ? mb_substr(wp_strip_all_tags($item_title), 0, 1) : '';
                    $product_link = get_sub_field('product_link');
                ?>
                <article class="group flex h-full flex-col justify-between rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-6 sm:p-7 shadow-xs transition-all duration-200 hover:border-sky-400 hover:shadow-md">
                    <div>
                        <!-- Header with Avatar & Badge -->
                        <?php if ((waklert_has_content(esc_html($item_initial ?: sprintf('%02d', $guide_idx)))) || (waklert_has_content(esc_html(waklert_content('content_product_guide_text_1458f29e94'))))): ?><div class="flex items-center justify-between gap-3 mb-4">
                            <?php if (waklert_has_content(esc_html($item_initial ?: sprintf('%02d', $guide_idx)))): ?><span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-100 font-heading text-base font-black text-[#0c4161] shadow-2xs group-hover:scale-105 transition-transform" aria-hidden="true">
                                <?= esc_html($item_initial ?: sprintf('%02d', $guide_idx)) ?>
                            </span><?php endif; ?>
                            <?php if (waklert_has_content(esc_html(waklert_content('content_product_guide_text_1458f29e94')))): ?><span class="inline-flex items-center gap-1 rounded-full bg-sky-50 border border-sky-200 px-2.5 py-0.5 text-[11px] font-bold text-[#0c4161]">
                                <?= esc_html(waklert_content('content_product_guide_text_1458f29e94')) ?>
                            </span><?php endif; ?>
                        </div><?php endif; ?>

                        <?php if (waklert_has_content(esc_html($item_title))): ?><h3 class="font-heading text-lg sm:text-xl font-black text-slate-900 mb-2"><?= esc_html($item_title) ?></h3><?php endif; ?>
                        
                        <?php if (waklert_has_content(esc_html($item_description))): ?><p class="text-sm leading-relaxed text-slate-600 mb-4"><?= esc_html($item_description) ?></p><?php endif; ?>

                        <?php if ($item_note): ?>
                        <?php if ((waklert_has_content(esc_html(waklert_content('content_product_guide_text_745ac9e31e'))) || waklert_has_content(esc_html($item_note))) || (waklert_has_content(esc_html(waklert_content('content_product_guide_text_745ac9e31e'))))): ?><div class="mb-4">
                            <?php if (waklert_has_content(esc_html(waklert_content('content_product_guide_text_745ac9e31e'))) || waklert_has_content(esc_html($item_note))): ?><span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-50 border border-amber-200/80 px-2.5 py-1 text-xs font-semibold text-amber-900">
                                <?php if (waklert_has_content(esc_html(waklert_content('content_product_guide_text_745ac9e31e')))): ?><span class="font-bold text-amber-700"><?= esc_html(waklert_content('content_product_guide_text_745ac9e31e')) ?></span><?php endif; ?> <?= esc_html($item_note) ?>
                            </span><?php endif; ?>
                        </div><?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <?php if ($product_link): ?>
                    <div class="pt-4 border-t border-slate-100 mt-2">
                        <?php if ((waklert_has_content(esc_html(waklert_content('content_product_guide_text_0bfe18e97a'))) || waklert_has_content(esc_html(waklert_content('content_product_guide_text_4271f06eec')))) && waklert_has_content(esc_url($product_link))): ?><a href="<?= esc_url($product_link) ?>" class="inline-flex items-center justify-between w-full rounded-xl bg-slate-50 hover:bg-[#0c4161] hover:text-white px-4 py-2.5 text-xs font-bold text-[#0c4161] transition-all">
                            <?php if (waklert_has_content(esc_html(waklert_content('content_product_guide_text_0bfe18e97a')))): ?><span><?= esc_html(waklert_content('content_product_guide_text_0bfe18e97a')) ?></span><?php endif; ?>
                            <?php if (waklert_has_content(esc_html(waklert_content('content_product_guide_text_4271f06eec')))): ?><span aria-hidden="true"><?= esc_html(waklert_content('content_product_guide_text_4271f06eec')) ?></span><?php endif; ?>
                        </a><?php endif; ?>
                    </div>
                    <?php endif; ?>
                </article>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

    </div>
</section>
