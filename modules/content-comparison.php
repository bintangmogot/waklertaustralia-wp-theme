<?php
/**
 * Module: Comparison Table
 * Follows the colorful card design rules:
 * - Multi-color vibrant vector icons for each compared feature
 * - 2-tone card structure (Waklert highlighted column in navy/amber + white rows)
 * - Dashed borders
 * - Patterned gradient background
 * - Lift & hover animations
 */

if (waklert_module_is_empty()) { return; }

$tag = waklert_module_text('tag');
$heading = waklert_module_text('heading');
$desc = waklert_module_text('description');
$attribute_label = waklert_module_text('attribute_label');
$badge_label = waklert_module_text('badge_label');
$product_label = waklert_module_text('product_label');
$coffee_label = waklert_module_text('coffee_label');
$energy_label = waklert_module_text('energy_label');
$footer_note = waklert_module_text('footer_note');
$footer_badge = waklert_module_text('footer_badge');

// Feature row colorful micro-icons
$feature_icons = [
    'duration' => waklert_content_icon('content_comparison_icon_4ac3d45a8c'),
    'crash'    => waklert_content_icon('content_comparison_icon_351e4cd565'),
    'focus'    => waklert_content_icon('content_comparison_icon_88e7a52994'),
    'safety'   => waklert_content_icon('content_comparison_icon_4d9d0a9b4b'),
    'sleep'    => waklert_content_icon('content_comparison_icon_93668b9915'),
    'cost'     => waklert_content_icon('content_comparison_icon_f3a25bb60f'),
];

$rows = [];
if (have_rows('rows')) {
    while (have_rows('rows')) {
        the_row();
        if (!waklert_module_row_has_content(get_row(true))) { continue; }
        $rows[] = [
            'feature'  => get_sub_field('feature'),
            'modafinil' => get_sub_field('modafinil'),
            'coffee'   => get_sub_field('coffee'),
            'energy'   => get_sub_field('energy'),
        ];
    }
}

if (empty($rows)) {
    $rows = [];
}
?>
<section class="section-padding bg-gradient-to-b from-[#f8fafc] via-[#eff6fb] to-[#f8fafc] bg-pattern-dots border-t-2 border-dashed border-sky-200/80 relative isolate overflow-hidden" data-testid="comparison-table">
    <div class="container-custom max-w-5xl relative z-10">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-12">
            <?php if (waklert_has_content(esc_html($tag))): ?><span class="inline-flex items-center bg-amber-100 text-amber-900 border border-amber-300 text-xs font-bold uppercase tracking-wider px-4 py-1.5 rounded-full mb-3 shadow-2xs">
                <?= esc_html($tag) ?>
            </span><?php endif; ?>
            <?php if (waklert_has_content(esc_html($heading))): ?><h2 class="font-heading text-2xl md:text-4xl font-black text-ink tracking-tight mb-3">
                <?= esc_html($heading) ?>
            </h2><?php endif; ?>
            <?php if (waklert_has_content(esc_html($desc))): ?><p class="text-sm md:text-base text-muted-foreground leading-relaxed max-w-xl mx-auto">
                <?= esc_html($desc) ?>
            </p><?php endif; ?>
        </div>

        <!-- Comparison Table Card with Dashed Border and Two-Tone Structure -->
        <div class="bg-white border-2 border-dashed border-sky-300/80 rounded-3xl overflow-hidden shadow-xl hover:border-[#0c4161] transition-all duration-300">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="py-5 px-5 md:px-6 bg-[#0c4161] text-white font-heading font-black text-sm uppercase tracking-wider w-[34%]">
                                <?= esc_html($attribute_label) ?>
                            </th>
                            <!-- Highlighted Waklert Column -->
                            <th class="py-5 px-5 md:px-6 bg-[#082c42] text-white font-heading font-black text-center text-sm md:text-base border-x-2 border-dashed border-amber-400/60 relative w-[26%]">
                                <?php if (waklert_has_content(esc_html($badge_label))): ?><div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-400 text-slate-950 text-[10px] font-black uppercase tracking-widest mb-1 shadow-xs">
                                    <?= esc_html($badge_label) ?>
                                </div><?php endif; ?>
                                <?php if (waklert_has_content(esc_html($product_label))): ?><span class="block text-white text-lg"><?= esc_html($product_label) ?></span><?php endif; ?>
                            </th>
                            <th class="py-5 px-4 md:px-6 bg-[#0c4161] text-white/90 font-heading font-bold text-center text-sm uppercase tracking-wider w-[20%]">
                                <?= esc_html($coffee_label) ?>
                            </th>
                            <th class="py-5 px-4 md:px-6 bg-[#0c4161] text-white/90 font-heading font-bold text-center text-sm uppercase tracking-wider w-[20%]">
                                <?= esc_html($energy_label) ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-sky-100">
                        <?php 
                        $icon_keys = ['duration', 'crash', 'focus', 'safety', 'sleep', 'cost'];
                        foreach ($rows as $index => $r): 
                            $icon_key = $r['key'] ?? ($icon_keys[$index % 6]);
                            $icon_svg = $feature_icons[$icon_key] ?? $feature_icons['duration'];
                        ?>
                        <tr class="group hover:bg-sky-50/50 transition-colors duration-200">
                            <!-- Feature Name with Colorful Icon -->
                            <td class="py-4 px-5 md:px-6 font-heading font-bold text-ink">
                                <div class="flex items-center gap-3">
                                    <?php if (waklert_has_content($icon_svg)): ?><div class="w-9 h-9 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                        <?= $icon_svg ?>
                                    </div><?php endif; ?>
                                    <?php if (waklert_has_content(esc_html($r['feature']))): ?><span class="text-sm md:text-[15px]"><?= esc_html($r['feature']) ?></span><?php endif; ?>
                                </div>
                            </td>

                            <!-- Waklert Value (Clean Pill without bullet dot) -->
                            <td class="py-4 px-5 md:px-6 text-center bg-sky-50/70 border-x-2 border-dashed border-sky-200/80 font-extrabold text-[#0c4161]">
                                <?php if (waklert_has_content(esc_html($r['modafinil']))): ?><span class="inline-flex items-center justify-center px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-300/80 text-xs font-bold shadow-2xs">
                                    <?= esc_html($r['modafinil']) ?>
                                </span><?php endif; ?>
                            </td>

                            <!-- Coffee Value -->
                            <td class="py-4 px-4 md:px-6 text-center text-slate-600 font-medium text-xs md:text-sm">
                                <?= esc_html($r['coffee']) ?>
                            </td>

                            <!-- Energy Drink Value -->
                            <td class="py-4 px-4 md:px-6 text-center text-slate-500 font-medium text-xs md:text-sm">
                                <?= esc_html($r['energy']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Bottom Table Footer with Australia Note -->
            <div class="p-4 px-6 bg-slate-50 border-t-2 border-dashed border-sky-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
                <?php if (waklert_has_content(esc_html($footer_note))): ?><span class="flex items-center gap-2">
                    <?= waklert_content_icon('content_comparison_icon_1b701caa03') ?>
                    <?php if (waklert_has_content(esc_html($footer_note))): ?><span><?= esc_html($footer_note) ?></span><?php endif; ?>
                </span><?php endif; ?>
                <?php if (waklert_has_content(esc_html($footer_badge))): ?><span class="font-bold text-[#0c4161]"><?= esc_html($footer_badge) ?></span><?php endif; ?>
            </div>
        </div>
    </div>
</section>
