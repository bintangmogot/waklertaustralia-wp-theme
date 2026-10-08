<?php
/**
 * Privacy policy module.
 *
 * Policy copy and contact details are maintained in the WordPress page editor.
 */
$title = get_sub_field('title') ?: get_the_title();
$intro = get_sub_field('subtitle');
$eyebrow = get_sub_field('eyebrow') ?: 'Privacy & data protection';
$updated = get_sub_field('updated');
$sections = get_sub_field('sections') ?: [];
$contact_email = sanitize_email(get_sub_field('contact_email'));
$contact_heading = get_sub_field('contact_heading') ?: 'Questions about your privacy?';
$contact_description = get_sub_field('contact_description');
$section_ids = [];

foreach ($sections as $index => $section) {
    $section_ids[] = 'policy-section-' . ($index + 1) . '-' . sanitize_title($section['title'] ?? '');
}
?>
<article class="policy-page-module">
    <nav aria-label="Breadcrumb" class="border-b border-border bg-background">
        <div class="container-site flex h-12 items-center gap-2 text-xs text-muted-foreground">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="transition-colors hover:text-primary">Home</a>
            <span aria-hidden="true">/</span>
            <span class="truncate text-foreground"><?php echo esc_html($title); ?></span>
        </div>
    </nav>

    <header class="border-b border-border bg-primary-softer">
        <div class="container-site max-w-4xl py-14 md:py-20">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="mb-6 inline-flex items-center gap-2 text-sm font-semibold text-primary-dark transition-colors hover:text-primary">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>
                </svg>
                Back to home
            </a>
            <div class="mb-4">
                <span class="inline-flex rounded-full border border-primary/15 bg-primary-soft px-3 py-1.5 text-[11px] font-bold uppercase tracking-widest text-primary-dark">
                    <?php echo esc_html($eyebrow); ?>
                </span>
            </div>
            <h1 class="font-heading text-4xl font-extrabold leading-tight tracking-tight text-foreground md:text-5xl">
                <?php echo esc_html($title); ?>
            </h1>
            <?php if ($intro) : ?>
                <p class="mt-4 max-w-3xl text-base leading-relaxed text-muted-foreground md:text-lg">
                    <?php echo esc_html($intro); ?>
                </p>
            <?php endif; ?>
            <?php if ($updated) : ?>
                <p class="mt-5 text-xs text-muted-foreground">Last updated <?php echo esc_html($updated); ?></p>
            <?php endif; ?>
        </div>
    </header>

    <?php if ($sections) : ?>
        <div class="container-site grid max-w-6xl gap-10 py-12 lg:grid-cols-[15rem_minmax(0,1fr)] lg:gap-12">
            <aside class="hidden lg:block">
                <div class="sticky top-24">
                    <p class="mb-3 px-2 text-xs font-bold uppercase tracking-widest text-primary-dark">On this page</p>
                    <nav aria-label="Privacy policy sections">
                        <ol class="space-y-1">
                            <?php foreach ($sections as $index => $section) :
                                $section_id = $section_ids[$index];
                            ?>
                                <li>
                                    <a href="#<?php echo esc_attr($section_id); ?>"
                                       data-policy-target="<?php echo esc_attr($section_id); ?>"
                                       class="flex gap-2 rounded-r-lg border-l-2 border-transparent px-2 py-2 text-sm leading-snug text-muted-foreground transition-colors hover:text-primary">
                                        <span class="w-6 shrink-0 font-mono text-xs tabular-nums text-muted-foreground/70"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                                        <span><?php echo esc_html($section['title'] ?? ''); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    </nav>

                    <?php if ($contact_email) : ?>
                        <div class="mt-8 rounded-2xl border border-border bg-card p-5 shadow-sm">
                            <p class="mb-2 text-xs font-bold uppercase tracking-widest text-muted-foreground">Need help?</p>
                            <p class="text-sm leading-relaxed text-foreground/75">Contact us about this policy or a privacy request.</p>
                            <a href="mailto:<?php echo esc_attr($contact_email); ?>" class="mt-4 inline-flex min-h-10 items-center gap-2 rounded-full bg-primary px-4 py-2 text-xs font-bold text-primary-foreground transition-colors hover:bg-primary-dark">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                </svg>
                                Email privacy contact
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>

            <div class="min-w-0 space-y-10">
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
                        <div class="mt-4 text-sm leading-7 text-muted-foreground md:text-base [&_a]:font-semibold [&_a]:text-primary [&_a]:underline [&_li]:pl-1 [&_ol]:list-decimal [&_ol]:space-y-2 [&_ol]:pl-5 [&_p+p]:mt-4 [&_strong]:font-bold [&_strong]:text-foreground [&_ul]:list-disc [&_ul]:space-y-2 [&_ul]:pl-5">
                            <?php echo wp_kses_post(wpautop($section_content)); ?>
                        </div>
                    </section>
                <?php endforeach; ?>

                <?php if ($contact_email) : ?>
                    <section aria-labelledby="privacy-contact-title" class="rounded-3xl border border-border bg-surface p-6 md:p-8">
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
                            <div class="max-w-2xl">
                                <h2 id="privacy-contact-title" class="font-heading text-xl font-bold text-foreground md:text-2xl">
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
