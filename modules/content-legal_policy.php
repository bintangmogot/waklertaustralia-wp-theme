<?php
/**
 * Shared, editable policy and disclosure page.
 *
 * Page copy, update date, contact details, and section rows are stored in ACF.
 */
$title = get_sub_field('title') ?: get_the_title();
$eyebrow = get_sub_field('eyebrow') ?: 'Policy & information';
$intro = get_sub_field('intro');
$updated = get_sub_field('updated');
$sections = get_sub_field('sections') ?: [];
$contact_email = sanitize_email(get_sub_field('contact_email'));
$contact_heading = get_sub_field('contact_heading') ?: 'Questions about this page?';
$contact_description = get_sub_field('contact_description');
$section_ids = [];

foreach ($sections as $index => $section) {
    $section_ids[] = 'legal-section-' . ($index + 1) . '-' . sanitize_title($section['title'] ?? '');
}
?>
<?php if (is_singular('post')) : ?>
    <!-- Detailed Blog Page Header (1/3 Viewport, Centered, Compact, Waklert Australia Theme) -->
    <header class="relative overflow-hidden border-b-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-5 sm:py-6 md:py-7" data-testid="single-post-hero">
        <div class="container-site max-w-4xl mx-auto px-4 relative z-10">
            <!-- Centered Breadcrumb Pill -->
            <div class="mb-2.5">
                <nav aria-label="Breadcrumb" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-dashed border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]">Home</a>
                    <span class="text-sky-300 font-normal">/</span>
                    <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]">Blog</a>
                    <span class="text-sky-300 font-normal">/</span>
                    <span aria-current="page" class="max-w-[12rem] sm:max-w-xs md:max-w-md truncate font-extrabold text-[#0c4161]"><?php echo esc_html($title); ?></span>
                </nav>
            </div>

            <!-- Eyebrow Badge -->
            <?php if (!empty($eyebrow)) : ?>
                <div class="mb-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3 py-0.5 text-[11px] font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                        <?php echo esc_html($eyebrow); ?>
                    </span>
                </div>
            <?php endif; ?>

            <!-- Compact Centered Title -->
            <h1 class="mx-auto max-w-2xl md:max-w-3xl font-heading text-xl sm:text-2xl md:text-3xl lg:text-[2rem] font-black leading-tight tracking-tight text-[#0c4161]">
                <?php echo esc_html($title); ?>
            </h1>

            <!-- Meta info: Date & Author -->
            <?php
            $post_author_id = get_post_field('post_author', get_the_ID());
            $author_name = get_the_author_meta('display_name', $post_author_id);
            if (empty($author_name) || strtolower($author_name) === 'admin') {
                $author_name = 'Waklert Australia Team';
            }
            ?>
            <div class="mt-2.5 flex flex-wrap items-center justify-center gap-2 sm:gap-3 text-xs text-slate-500">
                <span class="inline-flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('j F Y')); ?></time>
                </span>
                <span class="text-sky-300" aria-hidden="true">&middot;</span>
                <span class="inline-flex items-center gap-1.5">
                    <svg class="h-3.5 w-3.5 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span><?php echo esc_html($author_name); ?></span>
                </span>
                <?php if ($updated && $updated !== get_the_date('j F Y')) : ?>
                    <span class="text-sky-300" aria-hidden="true">&middot;</span>
                    <span class="text-slate-400">Updated <?php echo esc_html($updated); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </header>
<?php else : ?>
    <!-- Policy Page Header (Waklert Australia Theme) -->
    <header class="relative overflow-hidden border-b-2 border-dashed border-sky-300/80 bg-gradient-to-b from-[#f0f6fa] via-[#eef5fa] to-white bg-pattern-dots text-center py-8 md:py-12">
        <div class="container-site max-w-4xl mx-auto px-4 relative z-10">
            <div class="mb-3">
                <nav aria-label="Breadcrumb" class="inline-flex max-w-full flex-wrap items-center justify-center gap-1.5 rounded-full border border-dashed border-sky-300/80 bg-white/90 px-3.5 py-1 text-xs font-medium text-slate-500 shadow-xs backdrop-blur">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="font-bold text-slate-600 transition-colors hover:text-[#0c4161]">Home</a>
                    <span class="text-sky-300 font-normal">/</span>
                    <span aria-current="page" class="max-w-[12rem] sm:max-w-xs md:max-w-md truncate font-extrabold text-[#0c4161]"><?php echo esc_html($title); ?></span>
                </nav>
            </div>
            <div class="mb-2.5">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-sky-100/90 border border-sky-300/80 px-3.5 py-1 text-xs font-black uppercase tracking-[0.16em] text-[#0c4161] shadow-xs">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse" aria-hidden="true"></span>
                    <?php echo esc_html($eyebrow); ?>
                </span>
            </div>
            <h1 class="mx-auto max-w-3xl font-heading text-2xl sm:text-3xl md:text-4xl font-black leading-tight tracking-tight text-[#0c4161]">
                <?php echo esc_html($title); ?>
            </h1>
            <?php if ($intro) : ?>
                <p class="mx-auto mt-4 max-w-2xl text-sm md:text-base leading-relaxed text-slate-600">
                    <?php echo esc_html($intro); ?>
                </p>
            <?php endif; ?>
            <?php if ($updated) : ?>
                <p class="mt-4 text-xs font-medium text-slate-400">Last updated <?php echo esc_html($updated); ?></p>
            <?php endif; ?>
        </div>
    </header>
<?php endif; ?>

    <?php if ($sections) : ?>
        <div class="container-site grid max-w-6xl gap-8 lg:gap-10 pt-6 pb-12 md:pt-8 md:pb-16 lg:grid-cols-[15rem_minmax(0,1fr)]">
            <aside class="hidden lg:block">
                <div class="sticky top-24">
                    <p class="mb-3 px-2 text-xs font-bold uppercase tracking-widest text-[#0c4161]">On this page</p>
                    <nav aria-label="<?php echo esc_attr($title); ?> sections">
                        <ol class="space-y-1">
                            <?php foreach ($sections as $index => $section) :
                                $section_id = $section_ids[$index];
                            ?>
                                <li>
                                    <a href="#<?php echo esc_attr($section_id); ?>"
                                       data-policy-target="<?php echo esc_attr($section_id); ?>"
                                       class="flex gap-2 rounded-xl border border-transparent px-3 py-2 text-sm leading-snug text-slate-600 transition-all hover:bg-sky-50 hover:text-[#0c4161] hover:border-sky-200">
                                        <span class="w-6 shrink-0 font-mono text-xs tabular-nums text-slate-400"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                                        <span class="font-medium"><?php echo esc_html($section['title'] ?? ''); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </nav>
                </div>
            </aside>

            <div class="min-w-0 space-y-10">
                <?php if (has_post_thumbnail()) : ?>
                    <figure class="mb-8 overflow-hidden rounded-2xl border-2 border-dashed border-sky-200/80 bg-white p-1.5 shadow-sm">
                        <?php the_post_thumbnail('large', ['class' => 'h-auto w-full object-cover rounded-xl shadow-xs', 'loading' => 'eager']); ?>
                    </figure>
                <?php endif; ?>

                <?php foreach ($sections as $index => $section) :
                    $section_title = $section['title'] ?? '';
                    $section_content = $section['content'] ?? '';
                    $section_id = $section_ids[$index];
                ?>
                    <section id="<?php echo esc_attr($section_id); ?>" aria-labelledby="<?php echo esc_attr($section_id); ?>-title" class="scroll-mt-24">
                        <p class="font-mono text-[11px] font-semibold tabular-nums tracking-widest text-muted-foreground">
                            <?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?>
                        </p>
                        <h2 id="<?php echo esc_attr($section_id); ?>-title" class="mt-1 font-heading text-2xl font-bold leading-tight text-foreground md:text-3xl">
                            <?php echo esc_html($section_title); ?>
                        </h2>
                        <div class="prose max-w-none text-muted-foreground mt-4 text-sm md:text-base leading-7">
                            <?php echo wp_kses_post(wpautop($section_content)); ?>
                        </div>
                    </section>
                <?php endforeach; ?>

                <?php if ($contact_email) : ?>
                    <section aria-labelledby="legal-policy-contact-title" class="rounded-3xl border border-border bg-surface p-6 md:p-8">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                            <div class="max-w-2xl">
                                <h2 id="legal-policy-contact-title" class="font-heading text-xl font-bold text-foreground md:text-2xl">
                                    <?php echo esc_html($contact_heading); ?>
                                </h2>
                                <?php if ($contact_description) : ?>
                                    <p class="mt-2 text-sm leading-relaxed text-muted-foreground">
                                        <?php echo esc_html($contact_description); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                            <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="inline-flex min-h-11 shrink-0 items-center justify-center gap-2 rounded-full bg-primary px-5 py-3 text-sm font-bold text-primary-foreground transition-colors hover:bg-primary-dark">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                </svg>
                                Email us
                            </a>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</article>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const links = Array.from(document.querySelectorAll('[data-policy-target]'));
    if (!links.length) return;

    const sections = links
        .map(function (link) { return document.getElementById(link.dataset.policyTarget); })
        .filter(Boolean);

    function updateActiveSection() {
        let activeId = sections[0] ? sections[0].id : '';
        const threshold = window.scrollY + 150;

        sections.forEach(function (section) {
            if (section.getBoundingClientRect().top + window.scrollY <= threshold) {
                activeId = section.id;
            }
        });

        links.forEach(function (link) {
            const active = link.dataset.policyTarget === activeId;
            link.classList.toggle('border-primary', active);
            link.classList.toggle('bg-primary-soft', active);
            link.classList.toggle('font-semibold', active);
            link.classList.toggle('text-primary-dark', active);
            link.classList.toggle('border-transparent', !active);
        });
    }

    window.addEventListener('scroll', updateActiveSection, { passive: true });
    updateActiveSection();
});
</script>
