<?php
/**
 * Module: About Delivery
 */
$heading = get_sub_field('heading') ?: '';
$desc = get_sub_field('desc') ?: '';
$items = get_sub_field('list_items') ?: [];

if (!$heading && !$desc && !$items) {
    return;
}
?>
<section class="bg-white py-4 pb-6 md:py-8 md:pb-12">
    <div class="container-custom max-w-4xl">
        <?php if ($heading): ?><h2 class="font-heading font-black text-xl sm:text-2xl text-slate-900 mb-4"><?= esc_html($heading) ?></h2><?php endif; ?>
        <?php if ($desc): ?><p class="text-sm sm:text-base text-slate-600 mb-6 whitespace-pre-line"><?= esc_html($desc) ?></p><?php endif; ?>

        <?php if ($items): ?>
        <ul class="space-y-4 mb-8 text-slate-600 text-sm list-none pl-0">
            <?php foreach ($items as $item): ?>
            <li class="flex items-start gap-3">
                <div class="text-primary flex-shrink-0 mt-0.5 w-5 h-5">
                    <?php if (!empty($item['icon_svg'])): ?>
                        <?= wp_kses($item['icon_svg'], ['svg' => ['class' => true, 'xmlns' => true, 'viewBox' => true, 'fill' => true, 'stroke' => true], 'path' => ['d' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'fill-rule' => true, 'clip-rule' => true]]) ?>
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" /></svg>
                    <?php endif; ?>
                </div>
                <span>
                    <?php if (!empty($item['title'])): ?><strong><?= esc_html($item['title']) ?>:</strong><?php endif; ?>
                    <?= esc_html($item['desc'] ?? '') ?>
                </span>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</section>
