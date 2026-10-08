<?php
/**
 * Module: About Mission & Vision
 */
$m_head = get_sub_field('mission_heading') ?: '';
$m_desc = get_sub_field('mission_desc') ?: '';

$v_head = get_sub_field('vision_heading') ?: '';
$v_desc = get_sub_field('vision_desc') ?: '';

if (!$m_head && !$m_desc && !$v_head && !$v_desc) {
    return;
}
?>
<section class="bg-white py-2 md:py-4">
    <div class="container-custom max-w-4xl">
        <div class="grid md:grid-cols-2 gap-6 items-start">
            <div class="bg-primary-softer border border-primary/20 rounded-xl p-5 md:p-6">
                <?php if ($m_head): ?><h2 class="font-heading font-black text-xl text-slate-900 mb-2 mt-0"><?= esc_html($m_head) ?></h2><?php endif; ?>
                <?php if ($m_desc): ?><p class="text-slate-600 text-sm leading-relaxed mb-0 whitespace-pre-line"><?= esc_html($m_desc) ?></p><?php endif; ?>
            </div>
            <div class="bg-stone-50 border border-stone-200 rounded-xl p-6">
                <?php if ($v_head): ?><h2 class="font-heading font-black text-xl text-slate-900 mb-2 mt-0"><?= esc_html($v_head) ?></h2><?php endif; ?>
                <?php if ($v_desc): ?><p class="text-slate-600 text-sm leading-relaxed mb-0 whitespace-pre-line"><?= esc_html($v_desc) ?></p><?php endif; ?>
            </div>
        </div>
    </div>
</section>
