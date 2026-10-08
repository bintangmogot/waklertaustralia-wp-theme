<?php
/**
 * Armodafinil Information Guide Module.
 * All page copy and destinations are managed through the ACF Page Modules form.
 */

$page_badge       = (string) get_sub_field('page_badge');
$page_title       = (string) get_sub_field('page_title');
$page_subtitle    = (string) get_sub_field('page_subtitle');
$disclaimer_label = (string) get_sub_field('disclaimer_label');
$disclaimer       = (string) get_sub_field('disclaimer');
$guide_heading    = (string) get_sub_field('guide_heading');
$guide_intro      = (string) get_sub_field('guide_intro');
$products_heading = (string) get_sub_field('products_heading');
$products_button_text = (string) get_sub_field('products_button_text');
$products_button_link = (string) get_sub_field('products_button_link');
$timing_heading   = (string) get_sub_field('timing_heading');
$timing_intro     = (string) get_sub_field('timing_intro');
$import_heading   = (string) get_sub_field('import_heading');
$import_intro     = (string) get_sub_field('import_intro');
$faq_heading      = (string) get_sub_field('faq_heading');
$cta_heading      = (string) get_sub_field('cta_heading');
$cta_description  = (string) get_sub_field('cta_description');
$shop_button_text = (string) get_sub_field('shop_button_text');
$shop_button_link = (string) get_sub_field('shop_button_link');
$contact_button_text = (string) get_sub_field('contact_button_text');
$contact_button_link = (string) get_sub_field('contact_button_link');

$dosage_cards  = get_sub_field('dosage_cards');
$product_cards = get_sub_field('product_cards');
$timing_items  = get_sub_field('timing_items');
$import_checks = get_sub_field('malaysia_tips');
$faq_items     = get_sub_field('faq_items');

$dosage_cards  = is_array($dosage_cards) ? $dosage_cards : [];
$product_cards = is_array($product_cards) ? $product_cards : [];
$timing_items  = is_array($timing_items) ? $timing_items : [];
$import_checks = is_array($import_checks) ? $import_checks : [];
$faq_items     = is_array($faq_items) ? $faq_items : [];
?>

<!-- Hero / Intro -->
<section class="bg-gradient-to-br from-primary-dark via-ink to-primary py-16 text-white md:py-24 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 30% 50%, #f4a261 0%, transparent 50%), radial-gradient(circle at 80% 20%, #3b82f6 0%, transparent 40%);"></div>
    <div class="container-custom max-w-6xl relative z-10">
        <?php if ($page_badge !== ''): ?>
            <span class="mb-5 inline-block rounded-full bg-accent/15 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-accent border border-accent/30">
                <?= esc_html($page_badge) ?>
            </span>
        <?php endif; ?>
        <?php if ($page_title !== ''): ?>
            <h1 class="mb-5 font-heading text-3xl font-black leading-tight md:text-5xl drop-shadow">
                <?= esc_html($page_title) ?>
            </h1>
        <?php endif; ?>
        <?php if ($page_subtitle !== ''): ?>
            <p class="max-w-3xl text-lg leading-relaxed text-slate-300">
                <?= nl2br(esc_html($page_subtitle)) ?>
            </p>
        <?php endif; ?>
        <?php if ($disclaimer_label !== '' || $disclaimer !== ''): ?>
            <div class="mt-8 flex items-start gap-3 rounded-xl border border-amber-400/30 bg-amber-400/10 px-5 py-4 text-sm text-amber-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="mt-0.5 h-5 w-5 shrink-0 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                <span><?php if ($disclaimer_label !== ''): ?><strong class="text-amber-300"><?= esc_html($disclaimer_label) ?></strong><?php endif; ?> <?= nl2br(esc_html($disclaimer)) ?></span>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Guidance Cards -->
<section class="border-y border-border bg-surface py-12 md:py-16">
    <div class="container-custom max-w-6xl">
        <?php if ($guide_heading !== '' || $guide_intro !== ''): ?>
            <div class="mb-8 max-w-2xl">
                <?php if ($guide_heading !== ''): ?>
                    <h2 class="font-heading text-2xl font-bold tracking-tight text-ink md:text-3xl">
                        <?= esc_html($guide_heading) ?>
                    </h2>
                <?php endif; ?>
                <?php if ($guide_intro !== ''): ?>
                    <p class="mt-3 text-sm leading-relaxed text-muted-foreground">
                        <?= nl2br(esc_html($guide_intro)) ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($dosage_cards): ?>
            <div class="grid gap-4 md:grid-cols-3">
                <?php foreach ($dosage_cards as $i => $card): ?>
                    <article class="flex h-full flex-col rounded-2xl border border-border bg-background p-5 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/30 hover:shadow-md md:p-6">
                        <div class="flex items-center justify-between gap-3">
                            <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-softer font-heading text-sm font-bold text-primary-dark">
                                <?= esc_html(sprintf('%02d', $i + 1)) ?>
                            </span>
                            <?php if (!empty($card['label'])): ?>
                                <span class="rounded-full bg-primary-softer px-3 py-1 text-xs font-bold uppercase tracking-wide text-primary-dark">
                                    <?= esc_html($card['label']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($card['dose'])): ?>
                            <h3 class="mt-5 font-heading text-lg font-bold leading-snug tracking-tight text-ink md:text-xl">
                                <?= esc_html($card['dose']) ?>
                            </h3>
                        <?php endif; ?>
                        <?php if (!empty($card['desc'])): ?>
                            <p class="mt-3 text-sm leading-6 text-muted-foreground">
                                <?= nl2br(esc_html($card['desc'])) ?>
                            </p>
                        <?php endif; ?>
                        <span aria-hidden="true" class="mt-auto block w-10 rounded-full border-t-2 border-accent pt-5"></span>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Products listed on this site -->
<section class="section-padding bg-stone-50 border-t border-stone-200">
    <div class="container-custom max-w-6xl">
        <?php if ($products_heading !== ''): ?>
            <div class="mb-10 text-center">
                <h2 class="font-heading text-2xl md:text-3xl font-black text-slate-900 tracking-tight">
                    <?= esc_html($products_heading) ?>
                </h2>
            </div>
        <?php endif; ?>
        <?php if ($product_cards): ?>
            <div class="grid gap-4 md:grid-cols-2">
                <?php foreach ($product_cards as $prod): ?>
                    <?php if (empty($prod['link'])) { continue; } ?>
                    <a href="<?= esc_url($prod['link']) ?>" class="group flex items-center gap-5 rounded-2xl border border-stone-200 bg-white p-5 shadow-sm transition-all hover:border-primary hover:shadow-md hover:-translate-y-0.5">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-primary-softer font-heading text-xl font-black text-primary-dark group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                            <?= esc_html(strtoupper(substr((string) ($prod['name'] ?? ''), 0, 1))) ?>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between">
                                <p class="font-heading font-black text-slate-900"><?= esc_html($prod['name'] ?? '') ?></p>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                            </div>
                            <?php if (!empty($prod['use'])): ?>
                                <p class="text-sm text-slate-500"><?= esc_html($prod['use']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($prod['dose']) || !empty($prod['duration'])): ?>
                                <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-2 text-xs">
                                    <?php if (!empty($prod['dose'])): ?>
                                        <span class="shrink-0 whitespace-nowrap rounded-full bg-slate-100 px-2.5 py-1 font-bold text-slate-600"><?= esc_html($prod['dose']) ?></span>
                                    <?php endif; ?>
                                    <?php if (!empty($prod['duration'])): ?>
                                        <span class="text-slate-400"><?= esc_html($prod['duration']) ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($products_button_text !== '' && $products_button_link !== ''): ?>
            <div class="mt-8 text-center">
                <a href="<?= esc_url($products_button_link) ?>" class="inline-flex rounded-full border-2 border-primary px-8 py-3 text-sm font-bold uppercase tracking-wider text-primary-dark transition-all hover:bg-primary hover:text-primary-foreground">
                    <?= esc_html($products_button_text) ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Responsible use checklist -->
<section class="section-padding bg-white border-t border-stone-200">
    <div class="container-custom max-w-5xl">
        <?php if ($timing_heading !== '' || $timing_intro !== ''): ?>
            <div class="mb-10 text-center">
                <?php if ($timing_heading !== ''): ?>
                    <h2 class="font-heading text-2xl md:text-3xl font-black text-slate-900 tracking-tight">
                        <?= esc_html($timing_heading) ?>
                    </h2>
                <?php endif; ?>
                <?php if ($timing_intro !== ''): ?>
                    <p class="mt-3 text-sm text-slate-500 max-w-2xl mx-auto">
                        <?= nl2br(esc_html($timing_intro)) ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($timing_items): ?>
            <div class="grid gap-4 md:grid-cols-3">
                <?php foreach ($timing_items as $item): ?>
                    <div class="flex flex-col gap-3 rounded-xl border border-stone-200 bg-stone-50 p-6 shadow-sm">
                        <?php if (!empty($item['time'])): ?>
                            <div class="inline-flex w-fit rounded-lg bg-primary px-4 py-2">
                                <p class="text-sm font-black text-white"><?= esc_html($item['time']) ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($item['desc'])): ?>
                            <p class="text-sm leading-relaxed text-slate-600">
                                <?= nl2br(esc_html($item['desc'])) ?>
                            </p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Australian prescription and import information -->
<section class="section-padding bg-gradient-to-br from-primary-softer to-stone-50 border-t border-stone-200">
    <div class="container-custom max-w-6xl">
        <?php if ($import_heading !== '' || $import_intro !== ''): ?>
            <div class="mb-10 text-center">
                <?php if ($import_heading !== ''): ?>
                    <h2 class="font-heading text-2xl md:text-3xl font-black text-slate-900 tracking-tight">
                        <?= esc_html($import_heading) ?>
                    </h2>
                <?php endif; ?>
                <?php if ($import_intro !== ''): ?>
                    <p class="mt-3 text-sm text-slate-500 max-w-xl mx-auto">
                        <?= nl2br(esc_html($import_intro)) ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($import_checks): ?>
            <div class="grid gap-5 md:grid-cols-2">
                <?php foreach ($import_checks as $tip): ?>
                    <div class="flex gap-4 rounded-2xl border border-white bg-white p-6 shadow-sm">
                        <?php if (!empty($tip['emoji'])): ?>
                            <span class="text-3xl shrink-0 mt-1"><?= esc_html($tip['emoji']) ?></span>
                        <?php endif; ?>
                        <div>
                            <?php if (!empty($tip['title'])): ?>
                                <h3 class="mb-1 font-heading font-black text-slate-900 text-base">
                                    <?= esc_html($tip['title']) ?>
                                </h3>
                            <?php endif; ?>
                            <?php if (!empty($tip['desc'])): ?>
                                <p class="text-sm leading-relaxed text-slate-500">
                                    <?= nl2br(esc_html($tip['desc'])) ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- FAQs -->
<section class="section-padding bg-white border-t border-stone-200">
    <div class="container-custom max-w-6xl">
        <?php if ($faq_heading !== ''): ?>
            <div class="mb-12 text-center">
                <h2 class="font-heading text-2xl md:text-3xl font-black text-slate-900 tracking-tight">
                    <?= esc_html($faq_heading) ?>
                </h2>
            </div>
        <?php endif; ?>
        <?php if ($faq_items): ?>
            <div class="grid gap-4 md:grid-cols-2">
                <?php foreach ($faq_items as $faq): ?>
                    <details open class="group cursor-pointer rounded-2xl border border-stone-200 bg-white p-6 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-primary/40 hover:shadow-md open:bg-primary-softer/60 open:border-primary/40">
                        <summary class="flex items-center justify-between gap-4 font-heading text-base md:text-lg font-bold text-slate-900 marker:content-none rounded-xl transition-colors hover:text-primary-dark active:bg-primary-softer/60">
                            <?= esc_html($faq['q'] ?? '') ?>
                            <span class="ml-4 shrink-0 rounded-full bg-stone-100 p-1.5 text-stone-500 group-open:bg-primary-softer group-open:text-primary-dark transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300 group-open:-rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                            </span>
                        </summary>
                        <?php if (!empty($faq['a'])): ?>
                            <p class="mt-4 pr-8 text-sm leading-relaxed text-slate-600">
                                <?= nl2br(esc_html($faq['a'])) ?>
                            </p>
                        <?php endif; ?>
                    </details>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Calls to action -->
<section class="bg-gradient-to-r from-primary-dark to-primary py-16">
    <div class="container-custom max-w-5xl text-center text-white">
        <?php if ($cta_heading !== ''): ?>
            <h2 class="mb-4 font-heading text-3xl font-black drop-shadow">
                <?= esc_html($cta_heading) ?>
            </h2>
        <?php endif; ?>
        <?php if ($cta_description !== ''): ?>
            <p class="mb-8 text-lg text-primary-foreground/85">
                <?= nl2br(esc_html($cta_description)) ?>
            </p>
        <?php endif; ?>
        <?php if (($shop_button_text !== '' && $shop_button_link !== '') || ($contact_button_text !== '' && $contact_button_link !== '')): ?>
            <div class="flex flex-col gap-3 sm:flex-row sm:justify-center">
                <?php if ($shop_button_text !== '' && $shop_button_link !== ''): ?>
                    <a href="<?= esc_url($shop_button_link) ?>" class="inline-flex justify-center rounded-full bg-white px-8 py-3.5 text-sm font-bold uppercase tracking-wider text-primary-dark transition-all hover:bg-primary-softer hover:scale-105 shadow-lg">
                        <?= esc_html($shop_button_text) ?>
                    </a>
                <?php endif; ?>
                <?php if ($contact_button_text !== '' && $contact_button_link !== ''): ?>
                    <a href="<?= esc_url($contact_button_link) ?>" class="inline-flex items-center justify-center gap-2 rounded-full border-2 border-white/60 px-8 py-3.5 text-sm font-bold uppercase tracking-wider text-white transition-all hover:bg-white/10">
                        <?= esc_html($contact_button_text) ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
