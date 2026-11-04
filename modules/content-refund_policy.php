<?php
/**
 * Refund Policy Module
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

if (waklert_module_is_empty()) { return; }

$title = waklert_content('content_refund_policy_text_cc59bfbf70');
$subtitle = waklert_content('content_refund_policy_text_1e8f098e0a');
$badges = waklert_module_rows('badges');
$sections = waklert_module_rows('sections');

$default_badges = [
    '100% Free Reshipment',
    waklert_content('content_refund_policy_text_428b9dd79a'),
    waklert_content('content_refund_policy_text_92b8355308')
];

$default_sections = [
    [
        'title' => waklert_content('content_refund_policy_text_2a0860f014'),
        'content' => waklert_content('content_refund_policy_text_a772869bea')
    ],
    [
        'title' => waklert_content('content_refund_policy_text_bea82b8b1f'),
        'content' => waklert_content('content_refund_policy_text_45110d7987')
    ],
    [
        'title' => waklert_content('content_refund_policy_text_b58e66070e'),
        'content' => waklert_content('content_refund_policy_text_4898a3fe4f')
    ]
];
// Empty repeater lists stay empty on the frontend.
$default_badges = [];
$default_sections = [];
?>

<!-- 2-Tone Patterned Header -->
<header class="relative overflow-hidden border-b-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-6 sm:py-7 md:py-9">
    <div class="container-site max-w-4xl mx-auto px-4 relative z-10">
        <!-- Breadcrumbs -->
        <div class="mb-3">
            <nav aria-label="<?= esc_attr(waklert_content('content_refund_policy_text_0940110068')) ?>" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-dashed border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                <?php if ((waklert_has_content(esc_html(waklert_option_text('breadcrumb_home_label')))) && waklert_has_content(esc_url(home_url('/')))): ?><a href="<?= esc_url(home_url('/')) ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]"><?= esc_html(waklert_option_text('breadcrumb_home_label')) ?></a><?php endif; ?>
                <span class="text-sky-300 font-normal">/</span>
                <?php if (waklert_has_content(esc_html(waklert_content('content_refund_policy_text_92449f9fdf')))): ?><span aria-current="page" class="font-extrabold text-[#0c4161]"><?= esc_html(waklert_content('content_refund_policy_text_92449f9fdf')) ?></span><?php endif; ?>
            </nav>
        </div>

        <!-- Eyebrow Badge -->
        <?php if ((waklert_has_content(esc_html(waklert_content('content_refund_policy_text_1399e146b4'))))): ?><div class="mb-2.5">
            <?php if (waklert_has_content(esc_html(waklert_content('content_refund_policy_text_1399e146b4')))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse" aria-hidden="true"></span>
                <?= esc_html(waklert_content('content_refund_policy_text_1399e146b4')) ?>
            </span><?php endif; ?>
        </div><?php endif; ?>

        <?php if (waklert_has_content(esc_html($title))): ?><h1 class="mx-auto max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-[#0c4161]">
            <?= esc_html($title) ?>
        </h1><?php endif; ?>

        <?php if (waklert_has_content(esc_html($subtitle))): ?><p class="mx-auto mt-4 max-w-2xl text-sm md:text-base leading-relaxed text-slate-600">
            <?= esc_html($subtitle) ?>
        </p><?php endif; ?>

        <!-- Guarantee Badges -->
        <div class="mt-6 flex flex-wrap justify-center gap-2.5">
            <?php if (!empty($badges)): ?>
                <?php foreach ($badges as $item): if (empty($item['badge'])) continue; ?>
                <?php if (waklert_has_content(esc_html($item['badge']))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-white/90 border border-dashed border-sky-300 px-3.5 py-1.5 text-xs font-bold text-[#0c4161] shadow-2xs">
                    <?= waklert_content_icon('content_refund_policy_icon_032782fb42') ?>
                    <?= esc_html($item['badge']) ?>
                </span><?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <?php foreach ($default_badges as $b): ?>
                <?php if (waklert_has_content(esc_html($b))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-white/90 border border-dashed border-sky-300 px-3.5 py-1.5 text-xs font-bold text-[#0c4161] shadow-2xs">
                    <?= waklert_content_icon('content_refund_policy_icon_032782fb42') ?>
                    <?= esc_html($b) ?>
                </span><?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</header>

<section class="py-7 md:py-10 bg-gradient-to-b from-white via-slate-50/50 to-white">
    <div class="container-site max-w-4xl space-y-6">
        <?php if (!empty($sections)): ?>
            <?php foreach ($sections as $idx => $section): ?>
            <article class="rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-6 sm:p-8 shadow-xs transition-all hover:border-sky-300">
                <?php if (!empty($section['title'])): ?>
                <?php if ((waklert_has_content(sprintf('%02d', $idx + 1))) || (waklert_has_content(esc_html($section['title'])))): ?><div class="flex items-center gap-2 mb-2">
                    <?php if (waklert_has_content(sprintf('%02d', $idx + 1))): ?><span class="flex h-6 w-6 items-center justify-center rounded-md bg-sky-100 font-mono text-xs font-bold text-[#0c4161]">
                        <?= sprintf('%02d', $idx + 1) ?>
                    </span><?php endif; ?>
                    <?php if (waklert_has_content(esc_html($section['title']))): ?><h2 class="font-heading font-black text-lg sm:text-xl text-[#0c4161] m-0">
                        <?= esc_html($section['title']) ?>
                    </h2><?php endif; ?>
                </div><?php endif; ?>
                <?php endif; ?>
                <?php if (!empty($section['content'])): ?>
                    <?php if (waklert_has_content(wp_kses_post(wpautop($section['content'])))): ?><div class="prose max-w-none text-slate-600 text-sm sm:text-base leading-relaxed mt-3">
                        <?= wp_kses_post(wpautop($section['content'])) ?>
                    </div><?php endif; ?>
                <?php endif; ?>
            </article>
            <?php endforeach; ?>
        <?php else: ?>
            <?php foreach ($default_sections as $idx => $sec): ?>
            <article class="rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-6 sm:p-8 shadow-xs transition-all hover:border-sky-300">
                <?php if ((waklert_has_content(sprintf('%02d', $idx + 1))) || (waklert_has_content(esc_html($sec['title'])))): ?><div class="flex items-center gap-2 mb-2">
                    <?php if (waklert_has_content(sprintf('%02d', $idx + 1))): ?><span class="flex h-6 w-6 items-center justify-center rounded-md bg-sky-100 font-mono text-xs font-bold text-[#0c4161]">
                        <?= sprintf('%02d', $idx + 1) ?>
                    </span><?php endif; ?>
                    <?php if (waklert_has_content(esc_html($sec['title']))): ?><h2 class="font-heading font-black text-lg sm:text-xl text-[#0c4161] m-0">
                        <?= esc_html($sec['title']) ?>
                    </h2><?php endif; ?>
                </div><?php endif; ?>
                <?php if (waklert_has_content(wp_kses_post(wpautop($sec['content'])))): ?><div class="prose max-w-none text-slate-600 text-sm sm:text-base leading-relaxed mt-3">
                    <?= wp_kses_post(wpautop($sec['content'])) ?>
                </div><?php endif; ?>
            </article>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Support Callout Box -->
        <div class="mt-10 rounded-3xl border-2 border-dashed border-sky-300/80 bg-gradient-to-br from-[#f0f6fa] via-white to-sky-50/40 p-8 sm:p-10 shadow-xs text-center">
            <?php if (waklert_has_content(esc_html(waklert_content('content_refund_policy_text_498ec4e2de')))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161]">
                <?= esc_html(waklert_content('content_refund_policy_text_498ec4e2de')) ?>
            </span><?php endif; ?>
            <?php if (waklert_has_content(esc_html(waklert_content('content_refund_policy_text_1d47517b67')))): ?><h2 class="mt-2.5 font-heading font-black text-xl sm:text-2xl text-[#0c4161]">
                <?= esc_html(waklert_content('content_refund_policy_text_1d47517b67')) ?>
            </h2><?php endif; ?>
            <?php if (waklert_has_content(esc_html(waklert_content('content_refund_policy_text_656e439279')))): ?><p class="text-slate-600 text-sm sm:text-base mt-2 mb-6 max-w-lg mx-auto leading-relaxed">
                <?= esc_html(waklert_content('content_refund_policy_text_656e439279')) ?>
            </p><?php endif; ?>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <?php if ((waklert_has_content(esc_html(waklert_content('content_refund_policy_text_bd33063e6e')))) && waklert_has_content(esc_url(home_url('/contact/')))): ?><a href="<?= esc_url(home_url('/contact/')) ?>" class="inline-flex items-center gap-2 rounded-full bg-[#0c4161] hover:bg-[#082c42] text-white font-bold px-7 py-3 text-sm shadow-sm transition-colors">
                    <?= esc_html(waklert_content('content_refund_policy_text_bd33063e6e')) ?>
                </a><?php endif; ?>
            </div>
        </div>
    </div>
</section>
