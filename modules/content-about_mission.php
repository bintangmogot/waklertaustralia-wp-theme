<?php
/**
 * Module: About Mission & Vision
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

if (waklert_module_is_empty()) { return; }

$m_head   = waklert_module_text('mission_heading');
$m_label  = waklert_module_text('mission_label');
$m_desc   = waklert_module_text('mission_desc');
$m_preset = (string) (get_sub_field('mission_icon_preset') ?: 'browse_catalogue');
$m_image  = get_sub_field('mission_icon_image');

$v_head   = waklert_module_text('vision_heading');
$v_label  = waklert_module_text('vision_label');
$v_desc   = waklert_module_text('vision_desc');
$v_preset = (string) (get_sub_field('vision_icon_preset') ?: 'medical_rx_clarity');
$v_image  = get_sub_field('vision_icon_image');

if (!$m_head && !$m_desc && !$v_head && !$v_desc) {
    return;
}

$m_icon = waklert_render_card_icon([
    'icon_image'     => $m_image,
    'icon_preset'    => $m_preset,
    'title'          => $m_head,
    'desc'           => $m_desc,
    'default_preset' => 'browse_catalogue',
    'size_class'     => 'h-10 w-10 shrink-0',
]);

$v_icon = waklert_render_card_icon([
    'icon_image'     => $v_image,
    'icon_preset'    => $v_preset,
    'title'          => $v_head,
    'desc'           => $v_desc,
    'default_preset' => 'medical_rx_clarity',
    'size_class'     => 'h-10 w-10 shrink-0',
]);
?>

<section class="py-6 md:py-10 bg-white">
    <div class="container-site max-w-5xl">
        <div class="grid md:grid-cols-2 gap-6 lg:gap-8 items-stretch">
            
            <!-- Mission / Approach Card -->
            <div class="relative overflow-hidden rounded-2xl border-2 border-dashed border-sky-300/80 bg-gradient-to-br from-sky-50/50 via-white to-sky-50/20 p-6 sm:p-8 shadow-xs hover:border-sky-400 hover:shadow-md transition-all">
                <div class="flex items-center gap-3.5 mb-4">
                    <?php if (waklert_has_content($m_icon)): ?><span class="flex h-13 w-13 shrink-0 items-center justify-center rounded-xl bg-white border border-sky-100 shadow-xs">
                        <?= $m_icon ?>
                    </span><?php endif; ?>
                    <div>
                        <?php if (waklert_has_content(esc_html($m_label))): ?><span class="text-[11px] font-black uppercase tracking-widest text-[#0c4161]/70"><?= esc_html($m_label) ?></span><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($m_head))): ?><h2 class="font-heading font-black text-xl sm:text-2xl text-[#0c4161] m-0"><?= esc_html($m_head) ?></h2><?php endif; ?>
                    </div>
                </div>
                <?php if ($m_desc): ?>
                    <?php if (waklert_has_content(esc_html($m_desc))): ?><p class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line m-0">
                        <?= esc_html($m_desc) ?>
                    </p><?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Vision / Information First Card -->
            <div class="relative overflow-hidden rounded-2xl border-2 border-dashed border-amber-300/80 bg-gradient-to-br from-amber-50/50 via-white to-amber-50/20 p-6 sm:p-8 shadow-xs hover:border-amber-400 hover:shadow-md transition-all">
                <div class="flex items-center gap-3.5 mb-4">
                    <?php if (waklert_has_content($v_icon)): ?><span class="flex h-13 w-13 shrink-0 items-center justify-center rounded-xl bg-white border border-amber-100 shadow-xs">
                        <?= $v_icon ?>
                    </span><?php endif; ?>
                    <div>
                        <?php if (waklert_has_content(esc_html($v_label))): ?><span class="text-[11px] font-black uppercase tracking-widest text-amber-700"><?= esc_html($v_label) ?></span><?php endif; ?>
                        <?php if (waklert_has_content(esc_html($v_head))): ?><h2 class="font-heading font-black text-xl sm:text-2xl text-slate-900 m-0"><?= esc_html($v_head) ?></h2><?php endif; ?>
                    </div>
                </div>
                <?php if ($v_desc): ?>
                    <?php if (waklert_has_content(esc_html($v_desc))): ?><p class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line m-0">
                        <?= esc_html($v_desc) ?>
                    </p><?php endif; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
