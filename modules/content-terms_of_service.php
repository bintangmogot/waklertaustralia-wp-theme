<?php
/**
 * Terms of Service Module
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

if (waklert_module_is_empty()) { return; }

$title = waklert_content('content_terms_of_service_text_9649fabe68');
$subtitle = waklert_content('content_terms_of_service_text_00cbed0d6c');

$default_badges = [
    waklert_content('content_terms_of_service_text_d1c249daaf'),
    waklert_content('content_terms_of_service_text_7646432b9d'),
    waklert_content('content_terms_of_service_text_9a5f4446b7')
];

$default_sections = [
    [
        'title' => waklert_content('content_terms_of_service_text_0b69c2a40d'),
        'content' => waklert_content('content_terms_of_service_text_04ac30076e'),
    ],
    [
        'title' => waklert_content('content_terms_of_service_text_d94df73574'),
        'content' => waklert_content('content_terms_of_service_text_838fde2629'),
    ],
    [
        'title' => waklert_content('content_terms_of_service_text_21ec327956'),
        'content' => waklert_content('content_terms_of_service_text_7260aeb958'),
    ],
    [
        'title' => waklert_content('content_terms_of_service_text_39f100d519'),
        'content' => waklert_content('content_terms_of_service_text_41f18a17f1'),
    ],
    [
        'title' => waklert_content('content_terms_of_service_text_1aa9ee8931'),
        'content' => waklert_content('content_terms_of_service_text_fd747e2009'),
    ],
    [
        'title' => waklert_content('content_terms_of_service_text_fff2a85f48'),
        'content' => waklert_content('content_terms_of_service_text_2d28c27c9d'),
    ],
    [
        'title' => waklert_content('content_terms_of_service_text_87abd202f8'),
        'content' => waklert_content('content_terms_of_service_text_2f967edbc0'),
    ]
];
// Empty repeater lists stay empty on the frontend.
$default_badges = [];
$default_sections = [];
?>

<!-- 2-Tone Patterned Header -->
<header class="relative overflow-hidden border-b-2 border-solid border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-6 sm:py-7 md:py-9">
    <div class="container-site max-w-4xl mx-auto px-4 relative z-10">
        <!-- Breadcrumbs -->
        <div class="mb-3">
            <nav aria-label="<?= esc_attr(waklert_content('content_terms_of_service_text_5c89622103')) ?>" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-solid border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                <?php if ((waklert_has_content(esc_html(waklert_option_text('breadcrumb_home_label')))) && waklert_has_content(esc_url(home_url('/')))): ?><a href="<?= esc_url(home_url('/')) ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]"><?= esc_html(waklert_option_text('breadcrumb_home_label')) ?></a><?php endif; ?>
                <span class="text-sky-300 font-normal">/</span>
                <?php if (waklert_has_content(esc_html(waklert_content('content_terms_of_service_text_9649fabe68')))): ?><span aria-current="page" class="font-extrabold text-[#0c4161]"><?= esc_html(waklert_content('content_terms_of_service_text_9649fabe68')) ?></span><?php endif; ?>
            </nav>
        </div>

        <!-- Eyebrow Badge -->
        <?php if ((waklert_has_content(esc_html(waklert_content('content_terms_of_service_text_22de085e47'))))): ?><div class="mb-2.5">
            <?php if (waklert_has_content(esc_html(waklert_content('content_terms_of_service_text_22de085e47')))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                <?= esc_html(waklert_content('content_terms_of_service_text_22de085e47')) ?>
            </span><?php endif; ?>
        </div><?php endif; ?>

        <?php if (waklert_has_content(esc_html($title))): ?><h1 class="mx-auto max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black leading-tight tracking-tight text-[#0c4161]">
            <?= esc_html($title) ?>
        </h1><?php endif; ?>

        <?php if (waklert_has_content(esc_html($subtitle))): ?><p class="mx-auto mt-4 max-w-2xl text-sm md:text-base leading-relaxed text-slate-600">
            <?= esc_html($subtitle) ?>
        </p><?php endif; ?>

        <!-- Compliance Badges -->
        <div class="mt-6 flex flex-wrap justify-center gap-2.5">
            <?php if (have_rows('badges')): ?>
                <?php while (have_rows('badges')): the_row();
        if (!waklert_module_row_has_content(get_row(true))) { continue; }
                    $badge_label = get_sub_field('badge');
                ?>
                <?php if (waklert_has_content(esc_html($badge_label))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-white/90 border border-solid border-sky-300 px-3.5 py-1.5 text-xs font-bold text-[#0c4161] shadow-2xs">
                    <?= waklert_content_icon('content_terms_of_service_icon_2b73520344') ?>
                    <?= esc_html($badge_label) ?>
                </span><?php endif; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <?php foreach ($default_badges as $b): ?>
                <?php if (waklert_has_content(esc_html($b))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-white/90 border border-solid border-sky-300 px-3.5 py-1.5 text-xs font-bold text-[#0c4161] shadow-2xs">
                    <?= waklert_content_icon('content_terms_of_service_icon_2b73520344') ?>
                    <?= esc_html($b) ?>
                </span><?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</header>

<section class="py-7 md:py-10 bg-gradient-to-b from-white via-slate-50/50 to-white">
    <div class="container-site max-w-4xl space-y-6">
        <?php if (have_rows('sections')): ?>
            <?php $s_idx = 0; while (have_rows('sections')): the_row();
        if (!waklert_module_row_has_content(get_row(true))) { continue; } $s_idx++;
                $s_title = get_sub_field('title');
                $s_content = get_sub_field('content');
            ?>
            <article class="rounded-2xl border-2 border-solid border-sky-200/80 bg-white p-6 sm:p-8 shadow-xs transition-all hover:border-sky-300">
                <?php if ((waklert_has_content(sprintf('%02d', $s_idx))) || (waklert_has_content(esc_html($s_title)))): ?><div class="flex items-center gap-2 mb-2">
                    <?php if (waklert_has_content(sprintf('%02d', $s_idx))): ?><span class="flex h-6 w-6 items-center justify-center rounded-md bg-sky-100 font-mono text-xs font-bold text-[#0c4161]">
                        <?= sprintf('%02d', $s_idx) ?>
                    </span><?php endif; ?>
                    <?php if (waklert_has_content(esc_html($s_title))): ?><h2 class="font-heading font-black text-lg sm:text-xl text-[#0c4161] m-0">
                        <?= esc_html($s_title) ?>
                    </h2><?php endif; ?>
                </div><?php endif; ?>
                <?php if (waklert_has_content(wp_kses_post(wpautop($s_content)))): ?><div class="prose max-w-none text-slate-600 text-sm sm:text-base leading-relaxed mt-3">
                    <?= wp_kses_post(wpautop($s_content)) ?>
                </div><?php endif; ?>
            </article>
            <?php endwhile; ?>
        <?php else: ?>
            <?php foreach ($default_sections as $s_idx => $sec): ?>
            <article class="rounded-2xl border-2 border-solid border-sky-200/80 bg-white p-6 sm:p-8 shadow-xs transition-all hover:border-sky-300">
                <?php if ((waklert_has_content(sprintf('%02d', $s_idx + 1))) || (waklert_has_content(esc_html($sec['title'])))): ?><div class="flex items-center gap-2 mb-2">
                    <?php if (waklert_has_content(sprintf('%02d', $s_idx + 1))): ?><span class="flex h-6 w-6 items-center justify-center rounded-md bg-sky-100 font-mono text-xs font-bold text-[#0c4161]">
                        <?= sprintf('%02d', $s_idx + 1) ?>
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

        <!-- Contact Callout -->
        <?php
        $hide_contact = get_sub_field('hide_contact_callout');
        if (!$hide_contact):
            $contact_heading = waklert_content('content_terms_of_service_text_431f7fcc83');
            $contact_desc = waklert_content('content_terms_of_service_text_38a023187c');
            $contact_btn = waklert_content('content_terms_of_service_text_482c9eda23');
            $contact_wa = waklert_module_text('whatsapp_number');
            $wa_url = function_exists('waklert_format_whatsapp_url') ? waklert_format_whatsapp_url($contact_wa) : 'https://wa.me/61488841833';
        ?>
        <div class="mt-10 rounded-3xl border-2 border-solid border-sky-300/80 bg-gradient-to-br from-[#f0f6fa] via-white to-sky-50/40 p-8 sm:p-10 shadow-xs text-center" data-testid="terms-contact-callout">
            <?php if (waklert_has_content(esc_html(waklert_content('content_terms_of_service_text_0582d770b2')))): ?><span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161]">
                <?= esc_html(waklert_content('content_terms_of_service_text_0582d770b2')) ?>
            </span><?php endif; ?>
            <?php if (waklert_has_content(esc_html($contact_heading))): ?><h2 class="mt-2.5 font-heading font-black text-xl sm:text-2xl text-[#0c4161]">
                <?= esc_html($contact_heading) ?>
            </h2><?php endif; ?>
            <?php if (waklert_has_content(esc_html($contact_desc))): ?><p class="text-slate-600 text-sm sm:text-base mt-2 mb-6 max-w-lg mx-auto leading-relaxed">
                <?= esc_html($contact_desc) ?>
            </p><?php endif; ?>
            <div class="flex flex-wrap items-center justify-center gap-3">
                <?php if ((waklert_has_content(esc_html($contact_btn))) && waklert_has_content(esc_url($wa_url))): ?><a href="<?= esc_url($wa_url) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 text-sm shadow-sm transition-colors">
                    <?= waklert_content_icon('content_terms_of_service_icon_052eab3f09') ?>
                    <?= esc_html($contact_btn) ?>
                </a><?php endif; ?>
                <?php if ((waklert_has_content(esc_html(waklert_content('content_terms_of_service_text_c8516f5bc8')))) && waklert_has_content(esc_url(home_url('/contact/')))): ?><a href="<?= esc_url(home_url('/contact/')) ?>" class="inline-flex items-center gap-1.5 rounded-full bg-white hover:bg-slate-50 text-[#0c4161] border border-sky-300 font-bold px-6 py-3 text-sm shadow-xs transition-colors">
                    <?= esc_html(waklert_content('content_terms_of_service_text_c8516f5bc8')) ?>
                </a><?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
