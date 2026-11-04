<?php
/**
 * Module: FAQs
 * Follows the colorful card design rules:
 * - Multi-color vibrant question icons
 * - 2-tone card structure (White header + Soft tinted answer block with dashed divider)
 * - Dashed borders
 * - Patterned gradient background
 * - Smooth hover and expansion animations
 */

if (waklert_module_is_empty()) { return; }

$badge = waklert_module_text('eyebrow');
$show_badge = get_sub_field('show_eyebrow') !== false;
$heading = waklert_module_text('heading');
$show_link = get_sub_field('show_full_faq_link') !== false;
$link = waklert_module_text('link_text');
$link_url = waklert_resolve_link(waklert_module_text('link_url'));
?>
<section class="section-padding bg-gradient-to-b from-[#f8fafc] via-[#eff6fb] to-[#f8fafc] bg-pattern-dots border-t-2 border-dashed border-sky-200/80 relative isolate overflow-hidden" data-testid="faq-strip">
    <div class="container-custom max-w-4xl relative z-10">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-12">
            <?php if($show_badge): ?>
            <?php if (waklert_has_content(esc_html($badge))): ?><span class="inline-flex items-center gap-2 bg-sky-100 text-[#0c4161] border border-sky-300 text-xs font-black uppercase tracking-widest px-4 py-1.5 rounded-full mb-3 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-[#0c4161] animate-pulse-subtle"></span>
                <?= esc_html($badge) ?>
            </span><?php endif; ?>
            <?php endif; ?>
            <?php if (waklert_has_content(esc_html($heading))): ?><h2 class="font-heading text-2xl md:text-4xl font-black text-ink tracking-tight mb-3">
                <?= esc_html($heading) ?>
            </h2><?php endif; ?>
        </div>

        <div class="space-y-4">
            <?php 
            if(have_rows('faq_items')): 
                while(have_rows('faq_items')): the_row();
        if (!waklert_has_content(get_sub_field('question'))) { continue; }
            ?>
            <details class="group bg-white border-2 border-dashed border-sky-300/80 open:border-[#0c4161] hover:border-[#0c4161] rounded-2xl overflow-hidden shadow-xs hover:shadow-lg transition-all duration-300">
                <summary class="flex items-center justify-between gap-4 p-5 md:p-6 cursor-pointer list-none select-text bg-white transition-colors duration-200 group-open:bg-sky-50/60">
                    <?php if ((waklert_has_content(esc_html(get_sub_field('question'))))): ?><div class="flex items-center gap-3.5 text-left">
                        <!-- Colorful Question Icon SVG -->
                        <div class="w-10 h-10 rounded-xl bg-sky-100 border border-sky-200/80 flex items-center justify-center shrink-0 shadow-2xs group-hover:scale-105 transition-transform">
                            <?= waklert_content_icon('content_faqs_icon_49f1c3f04c') ?>
                        </div>
                        <?php if (waklert_has_content(esc_html(get_sub_field('question')))): ?><h3 class="font-heading font-black text-ink text-base md:text-[17px] group-hover:text-[#0c4161] transition-colors leading-snug">
                            <?= esc_html(get_sub_field('question')) ?>
                        </h3><?php endif; ?>
                    </div><?php endif; ?>
                    <!-- Animated Rotating Arrow Button -->
                    <div class="w-9 h-9 rounded-full bg-slate-100 group-open:bg-[#0c4161] group-open:text-white flex items-center justify-center shrink-0 text-slate-500 transition-all duration-300 group-hover:bg-[#0c4161] group-hover:text-white">
                        <?= waklert_content_icon('content_faqs_icon_1a7175e14b') ?>
                    </div>
                </summary>
                <!-- Answer block with dashed divider -->
                <?php if (waklert_has_content(wp_kses_post(wpautop(get_sub_field('answer'))))): ?><div class="px-6 pb-6 pt-4 text-sm md:text-[15px] text-slate-600 leading-relaxed border-t-2 border-dashed border-sky-200/70 bg-sky-50/30 prose prose-sm max-w-none [&_a]:text-[#0c4161] [&_a]:font-bold hover:[&_a]:underline">
                    <?= wp_kses_post(wpautop(get_sub_field('answer'))) ?>
                </div><?php endif; ?>
            </details>
            <?php 
                endwhile;
            else:
                // Default FAQs
                $defaults = array_map(static fn($d) => ['q' => $d['question'], 'a' => $d['answer']], []);
                foreach ($defaults as $f):
            ?>
            <details class="group bg-white border-2 border-dashed border-sky-300/80 open:border-[#0c4161] hover:border-[#0c4161] rounded-2xl overflow-hidden shadow-xs hover:shadow-lg transition-all duration-300">
                <summary class="flex items-center justify-between gap-4 p-5 md:p-6 cursor-pointer list-none select-text bg-white transition-colors duration-200 group-open:bg-sky-50/60">
                    <?php if ((waklert_has_content(esc_html($f['q'])))): ?><div class="flex items-center gap-3.5 text-left">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 border border-sky-200/80 flex items-center justify-center shrink-0 shadow-2xs group-hover:scale-105 transition-transform">
                            <?= waklert_content_icon('content_faqs_icon_49f1c3f04c') ?>
                        </div>
                        <?php if (waklert_has_content(esc_html($f['q']))): ?><h3 class="font-heading font-black text-ink text-base md:text-[17px] group-hover:text-[#0c4161] transition-colors leading-snug">
                            <?= esc_html($f['q']) ?>
                        </h3><?php endif; ?>
                    </div><?php endif; ?>
                    <div class="w-9 h-9 rounded-full bg-slate-100 group-open:bg-[#0c4161] group-open:text-white flex items-center justify-center shrink-0 text-slate-500 transition-all duration-300 group-hover:bg-[#0c4161] group-hover:text-white">
                        <?= waklert_content_icon('content_faqs_icon_1a7175e14b') ?>
                    </div>
                </summary>
                <?php if (waklert_has_content(wp_kses_post(wpautop($f['a'])))): ?><div class="px-6 pb-6 pt-4 text-sm md:text-[15px] text-slate-600 leading-relaxed border-t-2 border-dashed border-sky-200/70 bg-sky-50/30 prose prose-sm max-w-none [&_a]:text-[#0c4161] [&_a]:font-bold hover:[&_a]:underline">
                    <?= wp_kses_post(wpautop($f['a'])) ?>
                </div><?php endif; ?>
            </details>
            <?php endforeach; endif; ?>
        </div>

        <?php if($show_link): ?>
        <div class="text-center mt-10">
            <?php if ((waklert_has_content(esc_html($link))) && waklert_has_content(esc_url($link_url))): ?><a href="<?= esc_url($link_url) ?>" class="inline-flex items-center gap-2 border-2 border-dashed border-sky-300/90 bg-white hover:bg-[#0c4161] text-[#0c4161] hover:text-white font-extrabold px-5 py-2.5 sm:px-8 sm:py-3.5 rounded-full transition-all duration-300 uppercase tracking-wider sm:tracking-widest text-xs shadow-sm hover:shadow-md hover:-translate-y-0.5">
                <?php if (waklert_has_content(esc_html($link))): ?><span><?= esc_html($link) ?></span><?php endif; ?>
                <?= waklert_content_icon('content_faqs_icon_dbdf5a612f') ?>
            </a><?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
