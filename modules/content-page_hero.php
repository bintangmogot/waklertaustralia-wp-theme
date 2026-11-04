<?php
/**
 * Module: Page Hero
 *
 * The posts index uses a centered editorial hero. Other page_hero placements
 * retain the standard theme hero and their optional backend bullet list.
 */

if (waklert_module_is_empty()) { return; }
$title = waklert_module_text('title');
$subtitle = get_sub_field('subtitle');
$eyebrow = waklert_content('pg_hero_blog_eyebrow');
$bullets = get_sub_field('bullets');

if (is_home()) {
    // The posts index can inherit the first article as the global post title.
    // Use a clear archive heading whenever the editor has not supplied one.
    $title = waklert_content('pg_hero_blog_title');
    $subtitle = waklert_content('pg_hero_blog_subtitle');
    $eyebrow = waklert_content('pg_hero_blog_eyebrow');
}

if (is_shop()) {
    $shop_page_id = function_exists('wc_get_page_id') ? wc_get_page_id('shop') : 0;
    // Allow custom title/subtitle/eyebrow from ACF or fallback to shop page title
            $title = waklert_module_text('title');
    $subtitle = waklert_content('pg_hero_shop_subtitle');
    $eyebrow = waklert_content('pg_hero_shop_eyebrow');
}

if (is_home()) :
?>
<section class="relative overflow-hidden border-b-2 border-solid border-sky-200/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-foreground" data-testid="blog-hero">
    <div class="container-site relative z-10 py-7 md:py-10 lg:py-12">
        <div class="grid gap-7 border-b-2 border-solid border-sky-200/80 pb-8 md:grid-cols-[1.1fr_.9fr] md:items-end md:gap-12 md:pb-10">
            <div>
                <?php if (waklert_has_content(esc_html($eyebrow))): ?><span class="inline-flex items-center gap-2 rounded-full bg-sky-100 border border-sky-300/80 px-3.5 py-1 text-xs font-extrabold uppercase tracking-[0.18em] text-[#0c4161] shadow-sm">
                    <span aria-hidden="true" class="h-2 w-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <?php echo esc_html($eyebrow); ?>
                </span><?php endif; ?>
                <?php if (waklert_has_content(esc_html($title))): ?><h1 class="mt-4 max-w-3xl font-heading text-4xl font-extrabold leading-[1.05] tracking-tight text-[#0c4161] md:text-5xl lg:text-6xl">
                    <?php echo esc_html($title); ?>
                </h1><?php endif; ?>
            </div>
            <div class="max-w-2xl md:justify-self-end">
                <?php if ($subtitle) : ?>
                    <?php if (waklert_has_content(esc_html($subtitle))): ?><p class="text-base leading-relaxed text-slate-600 md:text-lg">
                        <?php echo esc_html($subtitle); ?>
                    </p><?php endif; ?>
                <?php endif; ?>
                <div class="mt-5 flex flex-wrap items-center gap-x-6 gap-y-3">
                    <?php if (waklert_has_content(esc_html(waklert_content('content_page_hero_text_6e85e64107')))): ?><a href="#blog-articles" class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-5 py-2.5 text-sm font-extrabold uppercase tracking-wide text-white shadow-md transition-all hover:from-amber-600 hover:to-amber-700 hover:shadow-lg hover:-translate-y-0.5">
                        <?= esc_html(waklert_content('content_page_hero_text_6e85e64107')) ?>
                        <?= waklert_content_icon('content_page_hero_icon_eb009e29ba') ?>
                    </a><?php endif; ?>
                    <?php if ((waklert_has_content(esc_html(waklert_content('content_page_hero_text_a29f85c94a')))) && waklert_has_content(esc_url(home_url('/faq/')))): ?><a href="<?php echo esc_url(home_url('/faq/')); ?>" class="text-sm font-bold text-[#0c4161] transition hover:text-amber-600">
                        <?= esc_html(waklert_content('content_page_hero_text_a29f85c94a')) ?>
                    </a><?php endif; ?>
                </div>
            </div>
        </div>

        <?php
        $blog_topics = [
            [waklert_content('pg_hero_blog_topic_1_title'), waklert_content('pg_hero_blog_topic_1_desc'), 'text-sky-600'],
            [waklert_content('pg_hero_blog_topic_2_title'), waklert_content('pg_hero_blog_topic_2_desc'), 'text-amber-600'],
            [waklert_content('pg_hero_blog_topic_3_title'), waklert_content('pg_hero_blog_topic_3_desc'), 'text-emerald-600'],
        ];
        ?>
        <div class="grid gap-4 py-8 sm:grid-cols-3 sm:gap-6">
            <?php foreach ($blog_topics as $index => $topic) : ?>
                <div class="group rounded-2xl border-2 border-solid border-sky-300/80 bg-white p-5 shadow-sm hover:border-[#0c4161] hover:shadow-md hover:-translate-y-1 transition-all">
                    <div class="flex items-center gap-3 mb-2">
                        <?php if (waklert_has_content(esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)))): ?><span class="flex h-7 w-7 items-center justify-center rounded-lg bg-sky-50 text-xs font-black text-[#0c4161] border border-sky-200">
                            <?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?>
                        </span><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($topic[0]))): ?><h2 class="font-heading font-bold text-slate-900 group-hover:text-[#0c4161] transition-colors"><?php echo esc_html($topic[0]); ?></h2><?php endif; ?>
                    </div>
                    <?php if (waklert_has_content(esc_html($topic[1]))): ?><p class="text-xs text-slate-600 leading-relaxed"><?php echo esc_html($topic[1]); ?></p><?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (waklert_has_content(esc_html(waklert_content('content_page_hero_text_59ee23eb94')))): ?><p class="pt-2 text-xs leading-relaxed text-slate-500"><?= esc_html(waklert_content('content_page_hero_text_59ee23eb94')) ?></p><?php endif; ?>
    </div>
</section>
<?php elseif (is_shop()) : ?>
<section class="relative isolate overflow-hidden bg-gradient-to-br from-[#082a3f] via-[#0c4161] to-[#125883] bg-pattern-dots-dark text-white text-center border-b-2 border-solid border-sky-400/30" data-testid="shop-hero">
    <?php waklert_output_pattern_rings(); ?>
    <div class="container-site relative z-10 mx-auto max-w-4xl py-8 md:py-12 px-4">
        <!-- Eyebrow Badge -->
        <?php if (waklert_has_content(esc_html($eyebrow))): ?><span class="inline-flex items-center gap-2 rounded-full border border-amber-400/40 bg-amber-400/15 px-4 py-1.5 text-xs font-extrabold uppercase tracking-widest text-amber-300 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
            <?php echo esc_html($eyebrow); ?>
        </span><?php endif; ?>

        <!-- Main Title -->
        <?php if (waklert_has_content(esc_html($title))): ?><h1 class="mx-auto mt-4 font-heading text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
            <?php echo esc_html($title); ?>
        </h1><?php endif; ?>

        <!-- Subtitle -->
        <?php if ($subtitle) : ?>
            <?php if (waklert_has_content(esc_html($subtitle))): ?><p class="mx-auto mt-4 max-w-2xl text-base sm:text-lg leading-relaxed text-sky-100/90 font-medium">
                <?php echo esc_html($subtitle); ?>
            </p><?php endif; ?>
        <?php endif; ?>

        <!-- Trust cards (editable in the module: Trust Cards) -->
        <?php
        $trust_icons = [
            'shield' => ['bg-amber-400/20 text-amber-300 border-amber-300/40', waklert_content_icon('content_page_hero_icon_99b2eb354a')],
            'truck'  => ['bg-sky-400/20 text-sky-300 border-sky-300/40', waklert_content_icon('content_page_hero_icon_dbf9e11b34')],
            'lock'   => ['bg-emerald-400/20 text-emerald-300 border-emerald-300/40', waklert_content_icon('content_page_hero_icon_0a8b129dd2')],
        ];
        $trust_cards = [];
        if (have_rows('trust_cards')) {
            while (have_rows('trust_cards')) {
                the_row();
        if (!waklert_module_row_has_content(get_row(true))) { continue; }
                $trust_cards[] = ['title' => (string) get_sub_field('title'), 'subtitle' => (string) get_sub_field('subtitle'), 'icon' => (string) get_sub_field('icon')];
            }
        } else {
            $trust_cards = [];
        }
        ?>
        <?php if ($trust_cards) : ?>
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-3.5 max-w-3xl mx-auto text-left">
            <?php foreach ($trust_cards as $card) :
                $icon = $trust_icons[$card['icon']] ?? $trust_icons['shield'];
            ?>
            <div class="rounded-2xl border-2 border-solid border-sky-300/40 bg-white/10 p-3.5 backdrop-blur-sm flex items-center gap-3 hover:bg-white/15 transition-all">
                <?php if (waklert_has_content($icon[1])): ?><div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border <?php echo esc_attr($icon[0]); ?>">
                    <?php echo $icon[1]; ?>
                </div><?php endif; ?>
                <div>
                    <?php if (waklert_has_content(esc_html($card['title']))): ?><h4 class="text-xs font-bold text-white leading-snug"><?php echo esc_html($card['title']); ?></h4><?php endif; ?>
                    <?php if (waklert_has_content(esc_html($card['subtitle']))): ?><p class="text-[11px] text-sky-200"><?php echo esc_html($card['subtitle']); ?></p><?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php else : ?>
<section class="relative isolate overflow-hidden bg-gradient-to-br from-[#082a3f] via-[#0c4161] to-[#125883] bg-pattern-dots-dark text-white border-b-2 border-solid border-sky-400/30" data-testid="page-hero">
    <?php waklert_output_pattern_rings(); ?>
    <div class="container-site relative z-10 py-8 md:py-12">
        <?php if (waklert_has_content(esc_html($title))): ?><h1 class="font-heading text-3xl font-extrabold tracking-tight md:text-[2.75rem] md:leading-[1.1] text-white">
            <?php echo esc_html($title); ?>
        </h1><?php endif; ?>

        <?php if ($subtitle) : ?>
            <?php if (waklert_has_content(esc_html($subtitle))): ?><p class="mt-4 max-w-2xl text-base leading-relaxed text-sky-100/90 font-medium">
                <?php echo esc_html($subtitle); ?>
            </p><?php endif; ?>
        <?php endif; ?>

        <?php if ($bullets) : ?>
            <ul class="mt-6 flex flex-wrap gap-3">
                <?php foreach ($bullets as $bullet) :
                    if (empty($bullet['bullet'])) continue;
                ?>
                    <?php if (waklert_has_content(esc_html($bullet['bullet']))): ?><li class="inline-flex items-center gap-2 rounded-full border border-solid border-sky-300/40 bg-white/10 px-4 py-1.5 text-xs sm:text-sm font-semibold text-white backdrop-blur-sm hover:bg-white/20 transition-all">
                        <?= waklert_content_icon('content_page_hero_icon_7408110dcc') ?>
                        <?php if (waklert_has_content(esc_html($bullet['bullet']))): ?><span><?php echo esc_html($bullet['bullet']); ?></span><?php endif; ?>
                    </li><?php endif; ?>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
