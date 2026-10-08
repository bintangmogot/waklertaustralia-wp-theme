<?php
/**
 * Module: About Products
 */
$heading = get_sub_field('heading') ?: '';
$desc = get_sub_field('desc') ?: '';
$products = get_sub_field('products') ?: [];

if (!$heading && !$desc && !$products) {
    return;
}
?>
<section class="bg-white py-4 md:py-8">
    <div class="container-custom max-w-4xl">
        <?php if ($heading): ?><h2 class="font-heading font-black text-xl sm:text-2xl text-slate-900 mb-4"><?= esc_html($heading) ?></h2><?php endif; ?>
        <?php if ($desc): ?><p class="text-sm sm:text-base text-slate-600 mb-6 whitespace-pre-line"><?= esc_html($desc) ?></p><?php endif; ?>

        <?php if ($products): ?>
        <div class="grid md:grid-cols-2 gap-5">
            <?php foreach ($products as $product): ?>
            <div class="border border-stone-200 rounded-xl p-5">
                <?php if (!empty($product['title'])): ?><h3 class="font-heading font-bold text-slate-900 mb-2 mt-0"><?= esc_html($product['title']) ?></h3><?php endif; ?>
                <?php if (!empty($product['desc'])): ?><p class="text-sm text-slate-500 mb-0 whitespace-pre-line"><?= esc_html($product['desc']) ?></p><?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
