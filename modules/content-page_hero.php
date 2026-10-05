<?php
/**
 * Module: Page Hero
 *
 * The posts index uses a centered editorial hero. Other page_hero placements
 * retain the standard theme hero and their optional backend bullet list.
 */
$title = get_sub_field('title') ?: get_the_title();
$subtitle = get_sub_field('subtitle');
$eyebrow = get_sub_field('eyebrow') ?: 'Waklert Australia Insights';
$bullets = get_sub_field('bullets');

if (is_home()) {
    // The posts index can inherit the first article as the global post title.
    // Use a clear archive heading whenever the editor has not supplied one.
    $title = get_sub_field('title') ?: 'Clear guides to armodafinil in Australia';
    $subtitle = get_sub_field('subtitle') ?: 'Browse straightforward articles about product information, ordering and delivery. For advice about your health or medicines, speak with an Australian-registered health professional.';
    $eyebrow = get_sub_field('eyebrow') ?: 'Waklert Australia Insights';
}

if (is_shop()) {
    // Match the Direct shop header presentation without changing saved ACF values.
    $title = 'Armodafinil Products';
    $subtitle = 'Browse our current range and compare listed product details, pack sizes and prices.';
    $eyebrow = 'Full catalogue';
}

if (is_home()) :
?>
<section class="relative isolate overflow-hidden bg-primary-dark text-primary-foreground" data-testid="blog-hero">
    <div aria-hidden="true" class="pointer-events-none absolute -right-40 -top-48 z-0 h-[34rem] w-[34rem] rounded-full border border-white/10"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -right-20 -top-28 z-0 h-[26rem] w-[26rem] rounded-full border border-white/10"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -bottom-64 left-[34%] z-0 h-[32rem] w-[32rem] rounded-full border border-white/5"></div>
    <div class="container-site relative z-10 grid items-center gap-12 py-14 md:py-20 lg:grid-cols-[1.05fr_.95fr] lg:gap-16 lg:py-24">
        <div class="max-w-2xl">
            <span class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.16em] text-white backdrop-blur-sm">
                <span aria-hidden="true" class="h-2 w-2 rounded-full bg-accent"></span>
                <?php echo esc_html($eyebrow); ?>
            </span>
            <h1 class="mb-5 max-w-2xl font-heading text-4xl font-extrabold leading-[1.05] tracking-tight text-white md:text-5xl lg:text-6xl">
                <?php echo esc_html($title); ?>
            </h1>
            <?php if ($subtitle) : ?>
                <p class="mb-8 max-w-2xl text-base leading-relaxed text-white/75 md:text-lg">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>
            <div class="flex flex-wrap gap-3">
                <a href="#blog-articles" class="inline-flex items-center gap-2 rounded-full bg-accent px-6 py-3.5 text-sm font-extrabold uppercase tracking-wide text-accent-foreground shadow-pill transition hover:-translate-y-0.5 hover:brightness-105 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">
                    Browse articles
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </a>
                <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="inline-flex items-center rounded-full border border-white/40 px-6 py-3.5 text-sm font-bold uppercase tracking-wide text-white transition hover:border-accent hover:bg-accent hover:text-accent-foreground focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-white">
                    Read the FAQ
                </a>
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-lg lg:ml-auto">
            <div aria-hidden="true" class="absolute -inset-5 -rotate-3 rounded-[2rem] border border-white/15"></div>
            <div class="relative rounded-3xl border border-white/70 bg-background p-6 text-foreground shadow-2xl md:p-8">
                <p class="mb-2 text-[10px] font-extrabold uppercase tracking-[0.2em] text-primary">Explore the articles</p>
                <h2 class="mb-5 font-heading text-2xl font-extrabold tracking-tight text-foreground md:text-3xl">Information, clearly organized.</h2>
                <div class="divide-y divide-border">
                    <?php
                    $blog_topics = [
                        ['Product information', 'General product guides'],
                        ['Ordering and delivery', 'Practical site information'],
                        ['Australian context', 'Local information and resources'],
                    ];
                    foreach ($blog_topics as $index => $topic) :
                    ?>
                        <a href="#blog-articles" class="group flex items-center gap-4 py-4 first:pt-0 last:pb-0">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-surface font-heading text-xs font-extrabold tracking-wide text-primary-dark transition group-hover:bg-primary-soft">
                                <?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?>
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block font-bold text-foreground transition group-hover:text-primary-dark"><?php echo esc_html($topic[0]); ?></span>
                                <span class="mt-1 block text-xs text-muted-foreground"><?php echo esc_html($topic[1]); ?></span>
                            </span>
                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0 text-muted-foreground transition group-hover:translate-x-1 group-hover:text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="mt-6 flex items-center justify-between gap-4 border-t border-border pt-5">
                    <span class="text-xs font-semibold text-muted-foreground">General information only</span>
                    <a href="#blog-articles" class="text-xs font-extrabold uppercase tracking-wide text-primary-dark hover:text-primary">View all articles</a>
                </div>
            </div>
            <p class="mt-5 text-center text-xs font-medium tracking-wide text-white/60">Articles do not replace advice from a qualified health professional.</p>
        </div>
    </div>
</section>
<?php elseif (is_shop()) : ?>
<section class="border-b border-border bg-primary-softer text-center" data-testid="shop-hero">
    <div class="container-site mx-auto max-w-4xl py-12 md:py-16">
        <span class="inline-flex rounded-full border border-primary/15 bg-primary-soft px-3 py-1.5 text-xs font-semibold uppercase tracking-widest text-primary-dark">
            <?php echo esc_html($eyebrow); ?>
        </span>
        <h1 class="mx-auto mt-4 font-heading text-3xl font-extrabold tracking-tight text-foreground md:text-5xl">
            <?php echo esc_html($title); ?>
        </h1>
        <?php if ($subtitle) : ?>
            <p class="mx-auto mt-3 max-w-2xl text-base leading-relaxed text-muted-foreground md:text-lg">
                <?php echo esc_html($subtitle); ?>
            </p>
        <?php endif; ?>
    </div>
</section>
<?php else : ?>
<section class="relative isolate overflow-hidden bg-ink text-ink-foreground" data-testid="page-hero">
    <div aria-hidden="true" class="pointer-events-none absolute -right-40 -top-48 z-0 h-[34rem] w-[34rem] rounded-full border border-white/10"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -right-20 -top-28 z-0 h-[26rem] w-[26rem] rounded-full border border-white/10"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -bottom-64 left-[34%] z-0 h-[32rem] w-[32rem] rounded-full border border-white/5"></div>
    <div class="container-site relative z-10 py-12 md:py-20">
        <h1 class="font-heading text-3xl font-extrabold tracking-tight md:text-[2.75rem] md:leading-[1.1]">
            <?php echo esc_html($title); ?>
        </h1>

        <?php if ($subtitle) : ?>
            <p class="mt-4 max-w-2xl text-base leading-relaxed text-ink-foreground/75">
                <?php echo esc_html($subtitle); ?>
            </p>
        <?php endif; ?>

        <?php if ($bullets) : ?>
            <ul class="mt-6 flex flex-wrap gap-x-8 gap-y-2">
                <?php foreach ($bullets as $bullet) :
                    if (empty($bullet['bullet'])) continue;
                ?>
                    <li class="flex items-center gap-2 text-sm text-ink-foreground/85">
                        <svg aria-hidden="true" class="h-4 w-4 text-accent" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <?php echo esc_html($bullet['bullet']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
