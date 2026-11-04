<?php
/**
 * Module: City Header (SEO Pages)
 */

if (waklert_module_is_empty()) { return; }

$city_name = waklert_module_text('city_name');
$state_name = trim((string) get_sub_field('state_name'));
$heading = waklert_module_text('heading');
$desc = waklert_module_text('description');
?>
<section class="bg-background py-8 md:py-10 text-center border-b border-border">
    <div class="container-site max-w-4xl">
        <?php if (waklert_has_content(esc_html(waklert_content('content_city_header_text_bcb5303d58')))): ?><span class="inline-block rounded-full bg-primary-softer px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-primary">
            <?= esc_html(waklert_content('content_city_header_text_bcb5303d58')) ?>
        </span><?php endif; ?>
        <?php if (waklert_has_content($heading)): ?><h1 class="mt-4 font-heading text-4xl font-extrabold tracking-tight md:text-5xl">
            <?= $heading ?>
        </h1><?php endif; ?>
        <?php if (waklert_has_content($desc)): ?><p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-muted-foreground">
            <?= $desc ?>
        </p><?php endif; ?>
    </div>
</section>
