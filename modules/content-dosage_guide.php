<?php
/**
 * Armodafinil Information Guide Module.
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

if (waklert_module_is_empty()) { return; }

$page_badge       = (string) waklert_content('content_dosage_guide_text_5d1b441c1e');
$page_title       = (string) waklert_content('content_dosage_guide_text_ee92ef75c9');
$page_subtitle    = (string) waklert_content('content_dosage_guide_text_4fb0a6108f');
$disclaimer_label = (string) waklert_content('content_dosage_guide_text_95261103c6');
$disclaimer       = (string) waklert_content('content_dosage_guide_text_277a072c20');

$guide_heading    = (string) waklert_content('content_dosage_guide_text_1f6eb03ec8');
$guide_intro      = (string) waklert_content('content_dosage_guide_text_1a8ad04e13');
$products_heading = (string) waklert_content('content_dosage_guide_text_98bf9d1cdb');
$products_button_text = (string) waklert_content('content_dosage_guide_text_331988aa98');
$products_button_link = waklert_module_text('products_button_link');
$timing_heading   = (string) waklert_content('content_dosage_guide_text_89a9768b65');
$timing_intro     = (string) waklert_content('content_dosage_guide_text_c8b9c8cd5e');
$import_heading   = (string) waklert_content('content_dosage_guide_text_12ef0fef45');
$import_intro     = (string) waklert_content('content_dosage_guide_text_4c8b628255');
$faq_heading      = (string) waklert_content('content_dosage_guide_text_e50bb01bae');
$cta_heading      = (string) waklert_content('content_dosage_guide_text_aa0566eb15');
$cta_description  = (string) waklert_content('content_dosage_guide_text_ee0def65b7');
$shop_button_text = (string) waklert_content('content_dosage_guide_text_0b2f6f8f76');
$shop_button_link = waklert_module_text('shop_button_link');
$contact_button_text = (string) waklert_content('content_dosage_guide_text_4f4e4699c1');
$contact_button_link = waklert_module_text('contact_button_link');

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

<!-- 2-Tone Patterned Header -->
<header class="relative overflow-hidden border-b-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-6 sm:py-7 md:py-9">
    <div class="container-site max-w-4xl mx-auto px-4 relative z-10">
        <!-- Breadcrumbs -->
        <div class="mb-3">
            <nav aria-label="<?= esc_attr(waklert_content('content_dosage_guide_text_07e96eed46')) ?>" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-dashed border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                <?php if ((waklert_has_content(esc_html(waklert_option_text('breadcrumb_home_label')))) && waklert_has_content(esc_url(home_url('/')))): ?><a href="<?= esc_url(home_url('/')) ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]"><?= esc_html(waklert_option_text('breadcrumb_home_label')) ?></a><?php endif; ?>
                <span class="text-sky-300 font-normal">/</span>
                <?php if (waklert_has_content(esc_html(waklert_content('content_dosage_guide_text_3870f2a549')))): ?><span aria-current="page" class="font-extrabold text-[#0c4161]"><?= esc_html(waklert_content('content_dosage_guide_text_3870f2a549')) ?></span><?php endif; ?>
            </nav>
        </div>

        <!-- Eyebrow Badge -->
        <?php if ($page_badge !== ''): ?>
        <?php if ((waklert_has_content(esc_html($page_badge)))): ?><div class="mb-2.5">
            <?php if (waklert_has_content(esc_html($page_badge))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                <?= esc_html($page_badge) ?>
            </span><?php endif; ?>
        </div><?php endif; ?>
        <?php endif; ?>

        <?php if (waklert_has_content(esc_html($page_title))): ?><h1 class="mx-auto max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-[#0c4161]">
            <?= esc_html($page_title) ?>
        </h1><?php endif; ?>

        <?php if ($page_subtitle !== ''): ?>
        <?php if (waklert_has_content(nl2br(esc_html($page_subtitle)))): ?><p class="mx-auto mt-4 max-w-2xl text-sm md:text-base leading-relaxed text-slate-600">
            <?= nl2br(esc_html($page_subtitle)) ?>
        </p><?php endif; ?>
        <?php endif; ?>

        <!-- Medical Disclaimer Banner -->
        <?php if ($disclaimer_label !== '' || $disclaimer !== ''): ?>
        <div class="mt-6 mx-auto max-w-3xl flex items-start gap-3 rounded-2xl border-2 border-dashed border-amber-300 bg-amber-50/90 p-4 text-left text-xs sm:text-sm text-amber-950 shadow-xs">
            <?= waklert_content_icon('content_dosage_guide_icon_924893f4a8') ?>
            <div>
                <?php if ($disclaimer_label !== ''): ?><strong class="font-bold text-amber-900"><?= esc_html($disclaimer_label) ?>:</strong> <?php endif; ?>
                <?= nl2br(esc_html($disclaimer)) ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</header>

<!-- Dosage Cards Section -->
<section class="py-7 md:py-10 bg-white">
    <div class="container-site max-w-6xl">
        <?php if ($guide_heading !== '' || $guide_intro !== ''): ?>
            <div class="mb-10 text-center max-w-3xl mx-auto">
                <?php if (waklert_has_content(esc_html(waklert_content('content_dosage_guide_text_54c59ec536')))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161]">
                    <?= esc_html(waklert_content('content_dosage_guide_text_54c59ec536')) ?>
                </span><?php endif; ?>
                <?php if ($guide_heading !== ''): ?>
                    <?php if (waklert_has_content(esc_html($guide_heading))): ?><h2 class="mt-2 font-heading text-2xl sm:text-3xl md:text-4xl font-black text-[#0c4161]">
                        <?= esc_html($guide_heading) ?>
                    </h2><?php endif; ?>
                <?php endif; ?>
                <?php if ($guide_intro !== ''): ?>
                    <?php if (waklert_has_content(nl2br(esc_html($guide_intro)))): ?><p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed">
                        <?= nl2br(esc_html($guide_intro)) ?>
                    </p><?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($dosage_cards): ?>
            <div class="grid gap-6 md:grid-cols-3">
                <?php foreach ($dosage_cards as $i => $card): ?>
                    <article class="flex h-full flex-col justify-between rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-6 sm:p-7 shadow-xs transition-all duration-200 hover:border-sky-400 hover:shadow-md">
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <?php if (waklert_has_content(esc_html(sprintf('%02d', $i + 1)))): ?><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-sky-100 font-heading text-sm font-black text-[#0c4161]">
                                    <?= esc_html(sprintf('%02d', $i + 1)) ?>
                                </span><?php endif; ?>
                                <?php if (!empty($card['label'])): ?>
                                    <?php if (waklert_has_content(esc_html($card['label']))): ?><span class="rounded-full bg-amber-50 border border-amber-200 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-amber-800">
                                        <?= esc_html($card['label']) ?>
                                    </span><?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($card['dose'])): ?>
                                <?php if (waklert_has_content(esc_html($card['dose']))): ?><h3 class="font-heading text-xl font-black text-slate-900 mb-2">
                                    <?= esc_html($card['dose']) ?>
                                </h3><?php endif; ?>
                            <?php endif; ?>
                            <?php if (!empty($card['desc'])): ?>
                                <?php if (waklert_has_content(nl2br(esc_html($card['desc'])))): ?><p class="text-sm leading-relaxed text-slate-600">
                                    <?= nl2br(esc_html($card['desc'])) ?>
                                </p><?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Products Available in Australia -->
<section class="py-7 md:py-10 bg-gradient-to-b from-slate-50/60 via-white to-slate-50/40">
    <div class="container-site max-w-6xl">
        <?php if ($products_heading !== ''): ?>
            <?php if ((waklert_has_content(esc_html(waklert_content('content_dosage_guide_text_841ea3acd6')))) || (waklert_has_content(esc_html($products_heading)))): ?><div class="mb-10 text-center max-w-3xl mx-auto">
                <?php if (waklert_has_content(esc_html(waklert_content('content_dosage_guide_text_841ea3acd6')))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161]">
                    <?= esc_html(waklert_content('content_dosage_guide_text_841ea3acd6')) ?>
                </span><?php endif; ?>
                <?php if (waklert_has_content(esc_html($products_heading))): ?><h2 class="mt-2 font-heading text-2xl sm:text-3xl md:text-4xl font-black text-[#0c4161]">
                    <?= esc_html($products_heading) ?>
                </h2><?php endif; ?>
            </div><?php endif; ?>
        <?php endif; ?>

        <?php if ($product_cards): ?>
            <div class="grid gap-5 md:grid-cols-2">
                <?php foreach ($product_cards as $prod): ?>
                    <?php if (empty($prod['link'])) { continue; } ?>
                    <a href="<?= esc_url($prod['link']) ?>" class="group flex items-center gap-5 rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-6 shadow-xs transition-all hover:border-sky-400 hover:shadow-md">
                        <?php if (waklert_has_content(esc_html(strtoupper(substr((string) ($prod['name'] ?? ''), 0, 1))))): ?><div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-sky-100 font-heading text-xl font-black text-[#0c4161] group-hover:bg-[#0c4161] group-hover:text-white transition-colors">
                            <?= esc_html(strtoupper(substr((string) ($prod['name'] ?? ''), 0, 1))) ?>
                        </div><?php endif; ?>
                        <div class="min-w-0 flex-1">
                            <?php if ((waklert_has_content(esc_html($prod['name'] ?? '')))): ?><div class="flex items-center justify-between">
                                <?php if (waklert_has_content(esc_html($prod['name'] ?? ''))): ?><p class="font-heading font-black text-slate-900 text-lg group-hover:text-[#0c4161] transition-colors"><?= esc_html($prod['name'] ?? '') ?></p><?php endif; ?>
                                <?= waklert_content_icon('content_dosage_guide_icon_8d72795ee3') ?>
                            </div><?php endif; ?>
                            <?php if (!empty($prod['use'])): ?>
                                <?php if (waklert_has_content(esc_html($prod['use']))): ?><p class="text-sm text-slate-600 mt-1"><?= esc_html($prod['use']) ?></p><?php endif; ?>
                            <?php endif; ?>
                            <?php if (!empty($prod['dose']) || !empty($prod['duration'])): ?>
                                <div class="mt-2.5 flex flex-wrap items-center gap-x-3 gap-y-2 text-xs">
                                    <?php if (!empty($prod['dose'])): ?>
                                        <?php if (waklert_has_content(esc_html($prod['dose']))): ?><span class="rounded-full bg-sky-50 border border-sky-200 px-2.5 py-0.5 font-bold text-[#0c4161]"><?= esc_html($prod['dose']) ?></span><?php endif; ?>
                                    <?php endif; ?>
                                    <?php if (!empty($prod['duration'])): ?>
                                        <?php if (waklert_has_content(esc_html($prod['duration']))): ?><span class="text-slate-500 font-medium"><?= esc_html($prod['duration']) ?></span><?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($products_button_text !== '' && $products_button_link !== ''): ?>
            <div class="mt-10 text-center">
                <?php if ((waklert_has_content(esc_html($products_button_text)) || waklert_has_content(esc_html(waklert_content('content_dosage_guide_text_a1f51eea2c')))) && waklert_has_content(esc_url($products_button_link))): ?><a href="<?= esc_url($products_button_link) ?>" class="inline-flex rounded-full bg-[#0c4161] hover:bg-[#082c42] px-7 py-3 text-sm font-bold text-white shadow-xs transition-colors">
                    <?= esc_html($products_button_text) ?> <?= esc_html(waklert_content('content_dosage_guide_text_a1f51eea2c')) ?>
                </a><?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Administration Schedule & Timing -->
<section class="py-7 md:py-10 bg-white">
    <div class="container-site max-w-5xl">
        <?php if ($timing_heading !== '' || $timing_intro !== ''): ?>
            <div class="mb-10 text-center max-w-3xl mx-auto">
                <?php if (waklert_has_content(esc_html(waklert_content('content_dosage_guide_text_d7b745af29')))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161]">
                    <?= esc_html(waklert_content('content_dosage_guide_text_d7b745af29')) ?>
                </span><?php endif; ?>
                <?php if ($timing_heading !== ''): ?>
                    <?php if (waklert_has_content(esc_html($timing_heading))): ?><h2 class="mt-2 font-heading text-2xl sm:text-3xl md:text-4xl font-black text-[#0c4161]">
                        <?= esc_html($timing_heading) ?>
                    </h2><?php endif; ?>
                <?php endif; ?>
                <?php if ($timing_intro !== ''): ?>
                    <?php if (waklert_has_content(nl2br(esc_html($timing_intro)))): ?><p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed">
                        <?= nl2br(esc_html($timing_intro)) ?>
                    </p><?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($timing_items): ?>
            <div class="grid gap-6 md:grid-cols-3">
                <?php foreach ($timing_items as $item): ?>
                    <div class="rounded-2xl border-2 border-dashed border-sky-200/80 bg-gradient-to-br from-sky-50/40 via-white to-transparent p-6 shadow-xs">
                        <?php if (!empty($item['time'])): ?>
                            <?php if (waklert_has_content(esc_html($item['time']))): ?><div class="inline-flex rounded-full bg-[#0c4161] px-3.5 py-1 text-xs font-black text-white mb-3">
                                <?= esc_html($item['time']) ?>
                            </div><?php endif; ?>
                        <?php endif; ?>
                        <?php if (!empty($item['desc'])): ?>
                            <?php if (waklert_has_content(nl2br(esc_html($item['desc'])))): ?><p class="text-sm leading-relaxed text-slate-600 m-0">
                                <?= nl2br(esc_html($item['desc'])) ?>
                            </p><?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Australian Prescription & Import Information -->
<section class="py-7 md:py-10 bg-gradient-to-b from-slate-50/60 via-white to-slate-50/40">
    <div class="container-site max-w-5xl">
        <?php if ($import_heading !== '' || $import_intro !== ''): ?>
            <div class="mb-10 text-center max-w-3xl mx-auto">
                <?php if (waklert_has_content(esc_html(waklert_content('content_dosage_guide_text_7d779c8c8b')))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161]">
                    <?= esc_html(waklert_content('content_dosage_guide_text_7d779c8c8b')) ?>
                </span><?php endif; ?>
                <?php if ($import_heading !== ''): ?>
                    <?php if (waklert_has_content(esc_html($import_heading))): ?><h2 class="mt-2 font-heading text-2xl sm:text-3xl md:text-4xl font-black text-[#0c4161]">
                        <?= esc_html($import_heading) ?>
                    </h2><?php endif; ?>
                <?php endif; ?>
                <?php if ($import_intro !== ''): ?>
                    <?php if (waklert_has_content(nl2br(esc_html($import_intro)))): ?><p class="mt-3 text-sm sm:text-base text-slate-600 leading-relaxed">
                        <?= nl2br(esc_html($import_intro)) ?>
                    </p><?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($import_checks): ?>
            <div class="grid gap-5 md:grid-cols-2">
                <?php foreach ($import_checks as $tip): ?>
                    <div class="flex gap-4 rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-6 shadow-xs">
                        <?php if (!empty($tip['emoji'])): ?>
                            <?php if (waklert_has_content(esc_html($tip['emoji']))): ?><span class="text-3xl shrink-0 mt-0.5"><?= esc_html($tip['emoji']) ?></span><?php endif; ?>
                        <?php endif; ?>
                        <div>
                            <?php if (!empty($tip['title'])): ?>
                                <?php if (waklert_has_content(esc_html($tip['title']))): ?><h3 class="font-heading font-black text-slate-900 text-base mb-1">
                                    <?= esc_html($tip['title']) ?>
                                </h3><?php endif; ?>
                            <?php endif; ?>
                            <?php if (!empty($tip['desc'])): ?>
                                <?php if (waklert_has_content(nl2br(esc_html($tip['desc'])))): ?><p class="text-sm leading-relaxed text-slate-600 m-0">
                                    <?= nl2br(esc_html($tip['desc'])) ?>
                                </p><?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- FAQs Section -->
<?php if ($faq_items): ?>
<section class="py-7 md:py-10 bg-white">
    <div class="container-site max-w-5xl">
        <?php if ((waklert_has_content(esc_html(waklert_content('content_dosage_guide_text_68471f55b4')))) || (waklert_has_content(esc_html($faq_heading)))): ?><div class="mb-10 text-center max-w-3xl mx-auto">
            <?php if (waklert_has_content(esc_html(waklert_content('content_dosage_guide_text_68471f55b4')))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161]">
                <?= esc_html(waklert_content('content_dosage_guide_text_68471f55b4')) ?>
            </span><?php endif; ?>
            <?php if (waklert_has_content(esc_html($faq_heading))): ?><h2 class="mt-2 font-heading text-2xl sm:text-3xl md:text-4xl font-black text-[#0c4161]">
                <?= esc_html($faq_heading) ?>
            </h2><?php endif; ?>
        </div><?php endif; ?>

        <div class="grid gap-4 md:grid-cols-2">
            <?php foreach ($faq_items as $faq): ?>
                <details class="group rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-6 shadow-xs transition-all hover:border-sky-400 open:border-sky-400 open:bg-sky-50/20">
                    <summary class="flex items-center justify-between gap-4 font-heading text-base font-bold text-slate-900 cursor-pointer list-none">
                        <?= esc_html($faq['q'] ?? '') ?>
                        <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-sky-100 text-[#0c4161] group-open:-rotate-180 transition-transform">
                            <?= waklert_content_icon('content_dosage_guide_icon_9b28dab586') ?>
                        </span>
                    </summary>
                    <?php if (!empty($faq['a'])): ?>
                        <?php if (waklert_has_content(wp_kses_post(wpautop($faq['a'])))): ?><div class="mt-4 pt-3 border-t border-slate-100 text-sm leading-relaxed text-slate-600 prose prose-sm max-w-none">
                            <?= wp_kses_post(wpautop($faq['a'])) ?>
                        </div><?php endif; ?>
                    <?php endif; ?>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Bottom Support CTA -->
<section class="py-8 md:py-10 bg-white">
    <div class="container-site max-w-4xl text-center">
        <div class="rounded-3xl border-2 border-dashed border-sky-300/80 bg-gradient-to-br from-[#f0f6fa] via-white to-sky-50/30 p-8 sm:p-12 shadow-xs">
            <?php if ($cta_heading !== ''): ?>
                <?php if (waklert_has_content(esc_html($cta_heading))): ?><h2 class="font-heading text-2xl sm:text-3xl md:text-4xl font-black text-[#0c4161] mb-3">
                    <?= esc_html($cta_heading) ?>
                </h2><?php endif; ?>
            <?php endif; ?>
            <?php if ($cta_description !== ''): ?>
                <?php if (waklert_has_content(nl2br(esc_html($cta_description)))): ?><p class="text-sm sm:text-base text-slate-600 max-w-xl mx-auto leading-relaxed mb-8">
                    <?= nl2br(esc_html($cta_description)) ?>
                </p><?php endif; ?>
            <?php endif; ?>
            <div class="flex flex-wrap items-center justify-center gap-3.5">
                <?php if ((waklert_has_content(esc_html($shop_button_text))) && waklert_has_content(esc_url($shop_button_link))): ?><a href="<?= esc_url($shop_button_link) ?>" class="inline-flex rounded-full bg-[#0c4161] hover:bg-[#082c42] px-7 py-3 text-sm font-bold text-white shadow-sm transition-colors">
                    <?= esc_html($shop_button_text) ?>
                </a><?php endif; ?>
                <?php if ((waklert_has_content(esc_html($contact_button_text)) || waklert_has_content(esc_html(waklert_content('content_dosage_guide_text_a1f51eea2c')))) && waklert_has_content(esc_url($contact_button_link))): ?><a href="<?= esc_url($contact_button_link) ?>" class="inline-flex items-center gap-1.5 rounded-full bg-white hover:bg-slate-50 text-[#0c4161] border border-sky-300 px-6 py-3 text-sm font-bold shadow-xs transition-colors">
                    <?= esc_html($contact_button_text) ?> <?= esc_html(waklert_content('content_dosage_guide_text_a1f51eea2c')) ?>
                </a><?php endif; ?>
            </div>
        </div>
    </div>
</section>
