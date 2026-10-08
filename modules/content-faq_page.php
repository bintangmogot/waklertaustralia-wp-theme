<?php
/**
 * FAQ Full Page Module
 */
$eyebrow = get_sub_field('eyebrow') ?: '';
$heading = get_sub_field('heading') ?: '';
$desc = get_sub_field('description') ?: '';
$categories = get_sub_field('faq_categories') ?: [];
$cta_heading = get_sub_field('cta_heading') ?: '';
$cta_desc = get_sub_field('cta_desc') ?: '';
$cta_btn = get_sub_field('cta_btn_text') ?: '';
$cta_link = get_sub_field('cta_btn_link') ?: '';

if (!$eyebrow && !$heading && !$desc && !$categories && !$cta_heading && !$cta_desc && !$cta_btn) {
    return;
}
?>
<section class="section-padding bg-background">
    <div class="container-custom max-w-3xl">
        <?php if ($eyebrow || $heading || $desc): ?>
        <div class="text-center mb-12">
            <?php if ($eyebrow): ?><span class="mb-4 inline-block rounded-full bg-primary-soft px-3 py-1.5 text-xs font-bold uppercase tracking-widest text-primary-dark"><?= esc_html($eyebrow) ?></span><?php endif; ?>
            <?php if ($heading): ?><h1 class="mb-4 font-heading text-4xl font-black text-foreground md:text-5xl"><?= esc_html($heading) ?></h1><?php endif; ?>
            <?php if ($desc): ?><p class="mx-auto max-w-xl text-muted-foreground"><?= esc_html($desc) ?></p><?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($categories): ?>
        <div class="space-y-10">
            <?php foreach ($categories as $category): ?>
            <div>
                <?php if (!empty($category['title'])): ?><h2 class="mb-5 border-b-2 border-primary-light/50 pb-3 font-heading text-xl font-black text-foreground"><?= esc_html($category['title']) ?></h2><?php endif; ?>
                <?php if (!empty($category['items'])): ?>
                <div class="space-y-3">
                    <?php foreach ($category['items'] as $item): ?>
                    <details class="group rounded-xl border border-border transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/40 hover:shadow-md open:bg-primary-softer/50 open:border-primary/40">
                        <summary class="flex items-center justify-between gap-4 p-5 cursor-pointer list-none rounded-xl transition-colors hover:text-primary-dark active:bg-primary-softer/60">
                            <h3 class="font-heading text-sm font-bold text-foreground"><?= esc_html($item['question'] ?? '') ?></h3>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-primary-dark transition-transform group-open:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </summary>
                        <div class="border-t border-border px-5 pb-5 pt-4 text-sm leading-relaxed text-muted-foreground">
                            <?= wp_kses_post($item['answer'] ?? '') ?>
                        </div>
                    </details>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if ($cta_heading || $cta_desc || ($cta_btn && $cta_link)): ?>
        <div class="mt-12 rounded-2xl border border-primary-light/50 bg-primary-softer p-8 text-center">
            <?php if ($cta_heading): ?><h2 class="mb-3 font-heading text-xl font-bold text-foreground"><?= esc_html($cta_heading) ?></h2><?php endif; ?>
            <?php if ($cta_desc): ?><p class="mb-5 text-sm text-muted-foreground"><?= esc_html($cta_desc) ?></p><?php endif; ?>
            <?php if ($cta_btn && $cta_link): ?><a href="<?= esc_url($cta_link) ?>" class="inline-flex items-center gap-2 rounded-full bg-primary px-6 py-3 font-bold text-primary-foreground transition-colors hover:bg-primary-dark"><?= esc_html($cta_btn) ?></a><?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
