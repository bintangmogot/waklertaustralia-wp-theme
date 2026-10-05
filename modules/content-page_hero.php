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
<section class="border-b border-border bg-background text-foreground" data-testid="blog-hero">
    <div class="container-site relative z-10 py-12 md:py-16 lg:py-20">
        <div class="grid gap-7 border-b border-border pb-8 md:grid-cols-[1.1fr_.9fr] md:items-end md:gap-12 md:pb-10">
            <div>
                <span class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-[0.18em] text-primary-dark">
                    <span aria-hidden="true" class="h-2 w-2 rounded-full bg-accent"></span>
                    <?php echo esc_html($eyebrow); ?>
                </span>
                <h1 class="mt-4 max-w-3xl font-heading text-4xl font-extrabold leading-[1.05] tracking-tight text-foreground md:text-5xl lg:text-6xl">
                    <?php echo esc_html($title); ?>
                </h1>
            </div>
            <div class="max-w-2xl md:justify-self-end">
                <?php if ($subtitle) : ?>
                    <p class="text-base leading-relaxed text-muted-foreground md:text-lg">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>
                <div class="mt-5 flex flex-wrap items-center gap-x-6 gap-y-3">
                    <a href="#blog-articles" class="inline-flex items-center gap-2 text-sm font-extrabold uppercase tracking-wide text-primary-dark transition hover:text-primary focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary">
                        Browse articles
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </a>
                    <a href="<?php echo esc_url(home_url('/faq/')); ?>" class="text-sm font-bold text-muted-foreground transition hover:text-primary-dark focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-primary">
                        Read the FAQ
                    </a>
                </div>
            </div>
        </div>

        <?php
        $blog_topics = [
            ['Product information', 'General product guides'],
            ['Ordering and delivery', 'Practical site information'],
            ['Australian context', 'Local information and resources'],
        ];
        ?>
        <div class="grid gap-6 border-b border-border py-7 sm:grid-cols-3 sm:gap-8 md:py-8">
            <?php foreach ($blog_topics as $index => $topic) : ?>
                <div class="flex items-start gap-3">
                    <span class="pt-0.5 font-heading text-xs font-extrabold tracking-wide text-primary"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                    <div>
                        <h2 class="font-bold text-foreground"><?php echo esc_html($topic[0]); ?></h2>
                        <p class="mt-1 text-sm text-muted-foreground"><?php echo esc_html($topic[1]); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="pt-4 text-xs leading-relaxed text-muted-foreground">Articles do not replace advice from a qualified health professional.</p>
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
