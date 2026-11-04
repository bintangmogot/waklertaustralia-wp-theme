<?php
/**
 * FAQ Full Page Module
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

if (waklert_module_is_empty()) { return; }

$eyebrow = waklert_module_text('eyebrow');
$heading = waklert_module_text('heading');
$desc = waklert_module_text('description');
$breadcrumb_label = waklert_module_text('breadcrumb_label');
$questions_label = waklert_module_text('questions_label');
$question_label = waklert_module_text('question_label');
$cta_eyebrow = waklert_module_text('cta_eyebrow');
$cta_whatsapp = waklert_module_text('cta_whatsapp_text');
$categories = waklert_module_rows('faq_categories');
$cta_heading = waklert_module_text('cta_heading');
$cta_desc = waklert_module_text('cta_desc');
$cta_btn = waklert_module_text('cta_btn_text');
$cta_link = waklert_resolve_link(waklert_module_text('cta_btn_link'));

$whatsapp_number = function_exists('get_field') ? get_field('whatsapp_number', 'option') : '';
if (!$whatsapp_number && function_exists('waklert_get_whatsapp_number')) {
    $whatsapp_number = waklert_get_whatsapp_number();
}
$whatsapp_url = function_exists('waklert_format_whatsapp_url') ? waklert_format_whatsapp_url($whatsapp_number) : 'https://wa.me/61488841833';
?>

<!-- 2-Tone Patterned Header -->
<header class="relative overflow-hidden border-b-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-6 sm:py-7 md:py-9" data-testid="faq-page-hero">
    <div class="container-site max-w-4xl mx-auto px-4 relative z-10">
        <!-- Breadcrumbs -->
        <div class="mb-3">
            <nav aria-label="<?= esc_attr(waklert_content('content_faq_page_text_cfdeea7b5d')) ?>" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-dashed border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                <?php if ((waklert_has_content(esc_html(waklert_option_text('breadcrumb_home_label')))) && waklert_has_content(esc_url(home_url('/')))): ?><a href="<?= esc_url(home_url('/')) ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]"><?= esc_html(waklert_option_text('breadcrumb_home_label')) ?></a><?php endif; ?>
                <span class="text-sky-300 font-normal">/</span>
                <?php if (waklert_has_content(esc_html($breadcrumb_label))): ?><span aria-current="page" class="font-extrabold text-[#0c4161]"><?= esc_html($breadcrumb_label) ?></span><?php endif; ?>
            </nav>
        </div>

        <!-- Eyebrow Badge -->
        <?php if ((waklert_has_content(esc_html($eyebrow)))): ?><div class="mb-2.5">
            <?php if (waklert_has_content(esc_html($eyebrow))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                <?= esc_html($eyebrow) ?>
            </span><?php endif; ?>
        </div><?php endif; ?>

        <?php if (waklert_has_content(esc_html($heading))): ?><h1 class="mx-auto max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-[#0c4161]">
            <?= esc_html($heading) ?>
        </h1><?php endif; ?>

        <?php if ($desc): ?>
        <?php if (waklert_has_content(esc_html($desc))): ?><p class="mx-auto mt-4 max-w-2xl text-sm md:text-base leading-relaxed text-slate-600">
            <?= esc_html($desc) ?>
        </p><?php endif; ?>
        <?php endif; ?>

        <!-- Quick Jump Category Navigation Pills -->
        <?php if (!empty($categories)): ?>
        <div class="mt-7 flex flex-wrap items-center justify-center gap-2">
            <?php foreach ($categories as $c_idx => $cat): 
                $cat_title = $cat['title'] ?? (waklert_content('content_faq_page_text_f955ddff0d') . ($c_idx + 1));
                $cat_slug = sanitize_title($cat_title);
            ?>
            <?php if (waklert_has_content(esc_html($cat_title)) || waklert_has_content(count($cat['items'] ?? []))): ?><a href="#cat-<?= esc_attr($cat_slug) ?>"
               class="inline-flex items-center gap-1.5 rounded-full bg-white/95 border border-dashed border-sky-300 px-3.5 py-1.5 text-xs font-bold text-[#0c4161] hover:bg-[#0c4161] hover:text-white hover:border-[#0c4161] transition-all shadow-2xs">
                <?php if (waklert_has_content(esc_html($cat_title))): ?><span><?= esc_html($cat_title) ?></span><?php endif; ?>
                <?php if (waklert_has_content(count($cat['items'] ?? []))): ?><span class="flex h-4 w-4 items-center justify-center rounded-full bg-sky-100 group-hover:bg-white/20 text-[10px] font-mono text-[#0c4161] font-bold">
                    <?= count($cat['items'] ?? []) ?>
                </span><?php endif; ?>
            </a><?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</header>

<!-- Main FAQ Content Section -->
<section class="py-7 md:py-10 bg-gradient-to-b from-white via-slate-50/40 to-white">
    <div class="container-site max-w-4xl space-y-12">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $c_idx => $category): 
                $cat_title = $category['title'] ?? '';
                $cat_slug = sanitize_title($cat_title);
                $items = $category['items'] ?? [];
            ?>
            <div id="cat-<?= esc_attr($cat_slug) ?>" class="scroll-mt-28">
                <!-- Category Section Header -->
                <?php if ($cat_title): ?>
                <?php if ((waklert_has_content(sprintf('%02d', $c_idx + 1))) || (waklert_has_content(esc_html($cat_title))) || (waklert_has_content(count($items)) || waklert_has_content(esc_html(count($items) === 1 ? $question_label : $questions_label)))): ?><div class="flex items-center justify-between gap-3 mb-5 pb-3 border-b-2 border-dashed border-sky-200/80">
                    <?php if ((waklert_has_content(sprintf('%02d', $c_idx + 1))) || (waklert_has_content(esc_html($cat_title)))): ?><div class="flex items-center gap-2.5">
                        <?php if (waklert_has_content(sprintf('%02d', $c_idx + 1))): ?><span class="flex h-7 w-7 items-center justify-center rounded-lg bg-sky-100 font-mono text-xs font-black text-[#0c4161]">
                            <?= sprintf('%02d', $c_idx + 1) ?>
                        </span><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($cat_title))): ?><h2 class="font-heading text-lg sm:text-xl md:text-2xl font-black text-[#0c4161] m-0">
                            <?= esc_html($cat_title) ?>
                        </h2><?php endif; ?>
                    </div><?php endif; ?>
                    <?php if (waklert_has_content(count($items)) || waklert_has_content(esc_html(count($items) === 1 ? $question_label : $questions_label))): ?><span class="inline-flex items-center rounded-full bg-slate-100 border border-slate-200/60 px-2.5 py-0.5 text-xs font-bold text-slate-500">
                        <?= count($items) ?> <?= esc_html(count($items) === 1 ? $question_label : $questions_label) ?>
                    </span><?php endif; ?>
                </div><?php endif; ?>
                <?php endif; ?>

                <!-- Accordion Stack -->
                <?php if (!empty($items)): ?>
                <div class="space-y-3.5">
                    <?php foreach ($items as $i_idx => $item): 
                        $q = $item['question'] ?? '';
                        if (!waklert_has_content($q)) { continue; }
                        $a = $item['answer'] ?? '';
                        // First item in first category starts open for quick preview
                        $is_open = ($c_idx === 0 && $i_idx === 0) ? 'open' : '';
                    ?>
                    <details <?= $is_open ?> class="group rounded-2xl border-2 border-dashed border-sky-200/80 bg-white overflow-hidden shadow-xs hover:border-sky-300 transition-all duration-200 open:border-sky-300 open:shadow-sm">
                        <summary class="flex items-center justify-between gap-4 p-5 cursor-pointer list-none select-text bg-white transition-colors hover:bg-sky-50/40 group-open:bg-sky-50/50">
                            <?php if ((waklert_has_content(esc_html($q)))): ?><div class="flex items-center gap-3.5 text-left">
                                <!-- Distinct Question Icon -->
                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-sky-100 border border-sky-200/80 shadow-2xs group-hover:scale-105 transition-transform" aria-hidden="true">
                                    <?= waklert_content_icon('content_faq_page_icon_4b70de5689') ?>
                                </div>
                                <?php if (waklert_has_content(esc_html($q))): ?><h3 class="font-heading text-sm sm:text-base font-extrabold text-[#0c4161] group-hover:text-sky-950 transition-colors leading-snug">
                                    <?= esc_html($q) ?>
                                </h3><?php endif; ?>
                            </div><?php endif; ?>
                            <!-- Rotating Arrow Chevron Button -->
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-500 transition-all duration-200 group-hover:bg-[#0c4161] group-hover:text-white group-open:bg-[#0c4161] group-open:text-white" aria-hidden="true">
                                <?= waklert_content_icon('content_faq_page_icon_e3f7bc9bf2') ?>
                            </div>
                        </summary>
                        <!-- Answer Block with Dashed Divider -->
                        <?php if (waklert_has_content(wp_kses_post(wpautop($a)))): ?><div class="border-t-2 border-dashed border-sky-200/70 bg-gradient-to-b from-sky-50/30 via-white to-white px-6 pb-6 pt-4 text-sm sm:text-[15px] leading-relaxed text-slate-600 prose max-w-none [&_a]:text-[#0c4161] [&_a]:font-bold hover:[&_a]:underline">
                            <?= wp_kses_post(wpautop($a)) ?>
                        </div><?php endif; ?>
                    </details>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- 2-Tone Support CTA Card -->
        <div class="rounded-3xl border-2 border-dashed border-sky-300/80 bg-gradient-to-br from-[#f0f6fa] via-white to-sky-50/50 p-8 sm:p-10 md:p-12 shadow-xs text-center">
            <?php if (waklert_has_content(esc_html($cta_eyebrow))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-2xs">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                <?= esc_html($cta_eyebrow) ?>
            </span><?php endif; ?>
            <?php if (waklert_has_content(esc_html($cta_heading))): ?><h2 class="mt-3 font-heading text-xl sm:text-2xl md:text-3xl font-black text-[#0c4161]">
                <?= esc_html($cta_heading) ?>
            </h2><?php endif; ?>
            <?php if (waklert_has_content(esc_html($cta_desc))): ?><p class="mx-auto mt-2 mb-6 max-w-lg text-sm sm:text-base leading-relaxed text-slate-600">
                <?= esc_html($cta_desc) ?>
            </p><?php endif; ?>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <?php if ((waklert_has_content(esc_html($cta_whatsapp)) || waklert_has_content(esc_html(waklert_content('content_faq_page_text_5ccbf58a1e')))) && waklert_has_content(esc_url($whatsapp_url))): ?><a href="<?= esc_url($whatsapp_url) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 text-xs sm:text-sm shadow-sm transition-colors">
                    <?= waklert_content_icon('content_faq_page_icon_d78f8e4baa') ?>
                    <?= esc_html($cta_whatsapp) ?> <?= esc_html(waklert_content('content_faq_page_text_5ccbf58a1e')) ?>
                </a><?php endif; ?>
                <?php if ((waklert_has_content(esc_html($cta_btn)) || waklert_has_content(esc_html(waklert_content('content_faq_page_text_5ccbf58a1e')))) && waklert_has_content(esc_url($cta_link))): ?><a href="<?= esc_url($cta_link) ?>" class="inline-flex items-center gap-2 rounded-full bg-[#0c4161] hover:bg-[#082c42] text-white font-bold px-6 py-3 text-xs sm:text-sm shadow-sm transition-colors">
                    <?= esc_html($cta_btn) ?> <?= esc_html(waklert_content('content_faq_page_text_5ccbf58a1e')) ?>
                </a><?php endif; ?>
            </div>
        </div>
    </div>
</section>
