<?php
/**
 * Module: About Intro
 */
$tag = get_sub_field('tag') ?: '';
$heading = get_sub_field('heading') ?: '';
$desc = get_sub_field('desc') ?: '';

if (!$tag && !$heading && !$desc) {
    return;
}
?>
<section class="bg-white pt-6 pb-2 md:pt-12 md:pb-8">
    <div class="container-custom max-w-4xl">
        <div class="text-center">
            <?php if ($tag): ?><span class="inline-block bg-primary-softer text-primary-dark text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4"><?= esc_html($tag) ?></span><?php endif; ?>
            <?php if ($heading): ?><h1 class="font-heading text-2xl sm:text-3xl md:text-5xl font-black text-slate-900 mb-4 leading-tight"><?= esc_html($heading) ?></h1><?php endif; ?>
            <?php if ($desc): ?><p class="text-base sm:text-lg text-slate-500 max-w-2xl mx-auto whitespace-pre-line"><?= esc_html($desc) ?></p><?php endif; ?>
        </div>
    </div>
</section>
