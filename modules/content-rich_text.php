<?php
/**
 * Module: Rich Text
 */

$content = get_sub_field('content');
if (!$content) {
    return;
}

$width = get_sub_field('width') ?: 'default';
$max_width_class = match ($width) {
    'narrow' => 'max-w-3xl',
    'full' => 'max-w-none',
    default => 'max-w-6xl',
};

$is_about_page = is_page('about-us');
$section_classes = $is_about_page ? 'section-padding bg-white' : 'section-padding bg-background';
$container_width_class = $is_about_page ? 'max-w-4xl' : $max_width_class;
$panel_classes = $is_about_page ? 'relative isolate overflow-hidden rounded-3xl bg-primary-dark p-6 text-white shadow-sm sm:p-8 md:p-12' : '';
$prose_classes = $is_about_page
    ? 'relative z-10 prose max-w-none prose-headings:font-heading prose-headings:font-bold [&>h1]:!text-white [&>h2]:!text-white [&>h3]:!text-white [&>h4]:!text-white [&>h5]:!text-white [&>h6]:!text-white [&>p]:!text-white/85 [&_li]:!text-white/85 [&_strong]:!text-white [&_a]:!text-accent [&_a:hover]:!text-white'
    : 'prose prose-slate max-w-none prose-a:text-primary hover:prose-a:text-primary-dark prose-headings:font-heading prose-headings:font-bold';
?>
<section class="<?= esc_attr($section_classes) ?>">
    <div class="container-site <?= esc_attr($container_width_class) ?>">
        <div class="<?= esc_attr($panel_classes) ?>">
            <?php if ($is_about_page) waklert_output_pattern_rings(); ?>
            <div class="<?= esc_attr($prose_classes) ?>">
                <?= wp_kses_post($content) ?>
            </div>
        </div>
    </div>
</section>
