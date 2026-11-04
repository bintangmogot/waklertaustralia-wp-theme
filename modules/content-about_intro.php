<?php
/**
 * Module: About Intro / Hero
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

if (waklert_module_is_empty()) { return; }

$tag = waklert_module_text('tag');
$heading = waklert_module_text('heading');
$desc = waklert_module_text('desc');
?>

<!-- 2-Tone Patterned Header -->
<header class="relative overflow-hidden border-b-2 border-solid border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-6 sm:py-7 md:py-9">
    <div class="container-site max-w-4xl mx-auto px-4 relative z-10">
        <!-- Breadcrumb Pill -->
        <div class="mb-3">
            <nav aria-label="<?= esc_attr(waklert_content('content_about_intro_text_f36fc26e7a')) ?>" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-solid border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                <?php if ((waklert_has_content(esc_html(waklert_option_text('breadcrumb_home_label')))) && waklert_has_content(esc_url(home_url('/')))): ?><a href="<?= esc_url(home_url('/')) ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]"><?= esc_html(waklert_option_text('breadcrumb_home_label')) ?></a><?php endif; ?>
                <span class="text-sky-300 font-normal">/</span>
                <?php if (waklert_has_content(esc_html(get_the_title()))): ?><span aria-current="page" class="font-extrabold text-[#0c4161]"><?= esc_html(get_the_title()) ?></span><?php endif; ?>
            </nav>
        </div>

        <!-- Eyebrow Badge -->
        <?php if ($tag): ?>
        <?php if ((waklert_has_content(esc_html($tag)))): ?><div class="mb-2.5">
            <?php if (waklert_has_content(esc_html($tag))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                <?= esc_html($tag) ?>
            </span><?php endif; ?>
        </div><?php endif; ?>
        <?php endif; ?>

        <?php if (waklert_has_content(esc_html($heading))): ?><h1 class="mx-auto max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-[#0c4161]">
            <?= esc_html($heading) ?>
        </h1><?php endif; ?>

        <?php if ($desc): ?>
        <?php if (waklert_has_content(esc_html($desc))): ?><p class="mx-auto mt-4 max-w-4xl text-sm md:text-base leading-relaxed text-slate-600 whitespace-pre-line">
            <?= esc_html($desc) ?>
        </p><?php endif; ?>
        <?php endif; ?>
    </div>
</header>
