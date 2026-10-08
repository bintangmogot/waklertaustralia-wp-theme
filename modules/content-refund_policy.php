<?php
/**
 * Refund Policy Module
 */
$title = get_sub_field('title') ?: '';
$subtitle = get_sub_field('subtitle') ?: '';
$badges = get_sub_field('badges') ?: [];
$sections = get_sub_field('sections') ?: [];

if (!$title && !$subtitle && !$badges && !$sections) {
    return;
}
?>
<section class="bg-slate-900 py-16 text-center text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-primary/20 to-slate-900 pointer-events-none"></div>
    <div class="container-custom max-w-3xl relative z-10">
        <?php if ($title): ?><h1 class="font-heading text-4xl md:text-5xl font-black mb-4 tracking-tight"><?= esc_html($title) ?></h1><?php endif; ?>
        <?php if ($subtitle): ?><p class="text-slate-300 max-w-2xl mx-auto leading-relaxed text-base md:text-lg mb-8"><?= esc_html($subtitle) ?></p><?php endif; ?>

        <?php if ($badges): ?>
        <div class="flex flex-wrap justify-center gap-3">
            <?php foreach ($badges as $item): if (empty($item['badge'])) continue; ?>
            <span class="inline-flex items-center gap-1.5 bg-accent/10 border border-accent/30 text-accent text-xs font-bold px-4 py-2 rounded-full shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-accent" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
                <?= esc_html($item['badge']) ?>
            </span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php if ($sections): ?>
<section class="section-padding bg-white">
    <div class="container-custom max-w-3xl space-y-8">
        <?php foreach ($sections as $section): ?>
        <article class="bg-stone-50/70 border border-stone-200 rounded-2xl p-6 md:p-8 hover:border-primary-light transition-colors">
            <?php if (!empty($section['title'])): ?>
            <h2 class="font-heading font-black text-xl text-slate-900 mb-4 pb-2 border-b border-stone-200 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-primary inline-block" aria-hidden="true"></span>
                <?= esc_html($section['title']) ?>
            </h2>
            <?php endif; ?>
            <?php if (!empty($section['content'])): ?><div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line"><?= esc_html($section['content']) ?></div><?php endif; ?>
        </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>
