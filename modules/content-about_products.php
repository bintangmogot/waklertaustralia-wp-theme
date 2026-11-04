<?php
/**
 * Module: About Products
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

if (waklert_module_is_empty()) { return; }

$heading = waklert_module_text('heading');
$eyebrow = waklert_module_text('eyebrow');
$badge_text = waklert_module_text('badge_text');
$link_text = waklert_module_text('link_text');
$link_href = waklert_resolve_link(waklert_module_text('link_url'));
$desc = waklert_module_text('desc');
$products = get_sub_field('products') ?: [];

if (!$heading && !$desc && !$products) {
    return;
}
?>

<section class="py-6 md:py-10 bg-gradient-to-b from-white via-slate-50/50 to-white">
    <div class="container-site max-w-5xl">
        <div class="text-center max-w-3xl mx-auto mb-8">
            <?php if (waklert_has_content(esc_html($eyebrow))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161]">
                <?= esc_html($eyebrow) ?>
            </span><?php endif; ?>
            <?php if (waklert_has_content(esc_html($heading))): ?><h2 class="mt-2 font-heading font-black text-2xl sm:text-3xl md:text-4xl text-[#0c4161]"><?= esc_html($heading) ?></h2><?php endif; ?>
            <?php if ($desc): ?>
                <?php if (waklert_has_content(esc_html($desc))): ?><p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed whitespace-pre-line"><?= esc_html($desc) ?></p><?php endif; ?>
            <?php endif; ?>
        </div>

        <?php if ($products): ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ($products as $idx => $product): ?>
            <div class="group relative flex flex-col justify-between overflow-hidden rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-6 shadow-xs transition-all duration-200 hover:border-sky-400 hover:shadow-md">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <?php if (waklert_has_content(sprintf('%02d', $idx + 1))): ?><span class="flex h-9 w-9 items-center justify-center rounded-xl bg-sky-100 text-[#0c4161] font-heading font-black text-xs">
                            <?= sprintf('%02d', $idx + 1) ?>
                        </span><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($badge_text))): ?><span class="inline-flex items-center gap-1 rounded-full bg-amber-50 border border-amber-200 px-2.5 py-0.5 text-[10px] font-bold text-amber-700">
                            <?= esc_html($badge_text) ?>
                        </span><?php endif; ?>
                    </div>
                    <?php if (!empty($product['title'])): ?>
                        <?php if (waklert_has_content(esc_html($product['title']))): ?><h3 class="font-heading font-bold text-lg text-slate-900 mb-2"><?= esc_html($product['title']) ?></h3><?php endif; ?>
                    <?php endif; ?>
                    <?php if (!empty($product['desc'])): ?>
                        <?php if (waklert_has_content(esc_html($product['desc']))): ?><p class="text-sm text-slate-600 leading-relaxed mb-4 whitespace-pre-line"><?= esc_html($product['desc']) ?></p><?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="pt-2 border-t border-slate-100 mt-auto">
                    <?php if ((waklert_has_content(esc_html($link_text)) || waklert_has_content(esc_html(waklert_content('content_about_products_text_bdd5a71338')))) && waklert_has_content(esc_url($link_href))): ?><a href="<?= esc_url($link_href) ?>" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0c4161] group-hover:text-amber-600 transition-colors">
                        <?php if (waklert_has_content(esc_html($link_text))): ?><span><?= esc_html($link_text) ?></span><?php endif; ?>
                        <?php if (waklert_has_content(esc_html(waklert_content('content_about_products_text_bdd5a71338')))): ?><span aria-hidden="true"><?= esc_html(waklert_content('content_about_products_text_bdd5a71338')) ?></span><?php endif; ?>
                    </a><?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
