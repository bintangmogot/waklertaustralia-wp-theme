<?php
/**
 * Module: Trust Strip (4 Cards below Hero)
 * Follows the colorful card design rules:
 * - Multi-color vibrant vector icons (editable via Icon Preset, Custom Image, or SVG in ACF)
 * - 2-tone card structure (White top + Navy bottom block)
 * - Dashed borders & Lift/scale animations
 */

if (waklert_module_is_empty()) { return; }

$fallback_presets = ['australia_delivery', 'discreet_sealed', 'aud_checkout', 'live_chat_support'];

$trust_items = [];
if (have_rows('badges')) {
    $idx = 0;
    while (have_rows('badges')) {
        the_row();
        if (!waklert_module_row_has_content(get_row(true))) { continue; }
        $label       = (string) get_sub_field('label');
        $custom_desc = trim((string) get_sub_field('desc'));
        $desc        = $custom_desc;
        $icon_preset = (string) (get_sub_field('icon_preset') ?: 'auto');
        $icon_image  = get_sub_field('icon_image');
        $icon_svg    = (string) get_sub_field('icon_svg');

        $icon_html = waklert_render_card_icon([
            'icon_image'     => $icon_image,
            'icon_preset'    => $icon_preset,
            'icon_svg'       => $icon_svg,
            'title'          => $label,
            'desc'           => $desc,
            'default_preset' => $fallback_presets[$idx % 4] ?? 'australia_delivery',
            'size_class'     => 'w-14 h-14 shrink-0',
        ]);

        $trust_items[] = [
            'icon'  => $icon_html,
            'title' => $label,
            'desc'  => $desc,
        ];
        $idx++;
    }
}

if (empty($trust_items)) {
    $defaults = [];
    foreach ($defaults as $card) {
        $trust_items[] = [
            'icon'  => waklert_render_card_icon([
                'icon_preset' => $card['icon_preset'],
                'title'       => $card['label'],
                'desc'        => $card['desc'],
                'size_class'  => 'w-14 h-14 shrink-0',
            ]),
            'title' => $card['label'],
            'desc'  => $card['desc'],
        ];
    }
}
?>

<section class="section-padding bg-gradient-to-b from-[#f0f6fa] via-[#e9f3f9] to-[#f8fafc] bg-pattern-dots border-y-2 border-solid border-sky-200/80 relative isolate overflow-hidden" data-testid="trust-badges">
    <div class="container-site relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
            <?php foreach ($trust_items as $item): ?>
            <?php if ((waklert_has_content(esc_html($item['title']))) || (waklert_has_content($item['desc'])) || (waklert_has_content(esc_html($item['desc'])))): ?><div class="group flex flex-col h-full rounded-2xl bg-white border-2 border-dashed border-sky-300/80 hover:border-[#0c4161] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 ease-out">
                <!-- Top Half: Pure white surface with colorful illustration & bold title -->
                <?php if ((waklert_has_content(esc_html($item['title'])))): ?><div class="bg-white p-6 pb-5 flex flex-col items-center text-center justify-start min-h-[176px]">
                    <div class="w-16 h-16 mb-3 flex items-center justify-center shrink-0 transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-1">
                        <?= $item['icon'] ?>
                    </div>
                    <?php if (waklert_has_content(esc_html($item['title']))): ?><h3 class="font-heading font-extrabold text-[16px] md:text-[17px] text-ink text-center leading-snug tracking-tight">
                        <?= esc_html($item['title']) ?>
                    </h3><?php endif; ?>
                </div><?php endif; ?>

                <!-- Bottom Half: Solid theme colored block with description -->
                <?php if (waklert_has_content($item['desc'])): ?><?php if ((waklert_has_content(esc_html($item['desc'])))): ?><div class="bg-[#0c4161] group-hover:bg-[#082c42] text-white p-4 md:p-5 text-center text-xs md:text-[13px] leading-relaxed font-normal text-white/95 flex-1 flex items-center justify-center transition-colors duration-300 border-t-2 border-solid border-white/20">
                    <?php if (waklert_has_content(esc_html($item['desc']))): ?><p class="leading-relaxed">
                        <?= esc_html($item['desc']) ?>
                    </p><?php endif; ?>
                </div><?php endif; ?><?php endif; ?>
            </div><?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
