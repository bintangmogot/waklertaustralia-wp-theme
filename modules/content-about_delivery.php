<?php
/**
 * Module: About Delivery
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

$heading = get_sub_field('heading') ?: 'Delivery Across Australia';
$desc = get_sub_field('desc') ?: 'Current delivery options, transit times, and parcel tracking are confirmed during ordering and dispatch.';
$items = get_sub_field('list_items') ?: [];

if (!$heading && !$desc && !$items) {
    return;
}
?>

<section class="py-6 md:py-10 bg-white">
    <div class="container-site max-w-5xl">
        <div class="text-center max-w-3xl mx-auto mb-8">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161]">
                Logistics & Logistics
            </span>
            <h2 class="mt-2 font-heading font-black text-2xl sm:text-3xl md:text-4xl text-[#0c4161]"><?= esc_html($heading) ?></h2>
            <?php if ($desc): ?>
                <p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed whitespace-pre-line"><?= esc_html($desc) ?></p>
            <?php endif; ?>
        </div>

        <?php if ($items): ?>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ($items as $item): ?>
            <div class="relative flex flex-col rounded-2xl border-2 border-dashed border-sky-200/80 bg-gradient-to-br from-sky-50/40 via-white to-transparent p-6 shadow-xs transition-all hover:border-sky-400 hover:shadow-md">
                <div class="flex items-center gap-3 mb-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-xs">
                        <?php if (!empty($item['icon_svg'])): ?>
                            <?= wp_kses($item['icon_svg'], ['svg' => ['class' => true, 'xmlns' => true, 'viewBox' => true, 'fill' => true, 'stroke' => true], 'path' => ['d' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'fill-rule' => true, 'clip-rule' => true]]) ?>
                        <?php else: ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        <?php endif; ?>
                    </span>
                    <?php if (!empty($item['title'])): ?>
                        <h3 class="font-heading font-bold text-base text-slate-900 m-0"><?= esc_html($item['title']) ?></h3>
                    <?php endif; ?>
                </div>
                <?php if (!empty($item['desc'])): ?>
                    <p class="text-sm text-slate-600 leading-relaxed m-0"><?= esc_html($item['desc']) ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
