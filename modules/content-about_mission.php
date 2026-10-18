<?php
/**
 * Module: About Mission & Vision
 * Waklert Australia 2-tone Dashed & Patterned Theme
 */

$m_head = get_sub_field('mission_heading') ?: 'Our Approach';
$m_desc = get_sub_field('mission_desc') ?: 'We organise armodafinil product information so customers can compare brands, strengths and batch details with clarity.';

$v_head = get_sub_field('vision_heading') ?: 'Information First';
$v_desc = get_sub_field('vision_desc') ?: 'We use plain English, state clearly that armodafinil is prescription-only in Australia, and encourage customers to speak to a doctor before ordering.';

if (!$m_head && !$m_desc && !$v_head && !$v_desc) {
    return;
}
?>

<section class="py-6 md:py-10 bg-white">
    <div class="container-site max-w-5xl">
        <div class="grid md:grid-cols-2 gap-6 lg:gap-8 items-stretch">
            
            <!-- Mission / Approach Card -->
            <div class="relative overflow-hidden rounded-2xl border-2 border-dashed border-sky-300/80 bg-gradient-to-br from-sky-50/50 via-white to-sky-50/20 p-6 sm:p-8 shadow-xs hover:border-sky-400 hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-4">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#0c4161] text-white shadow-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
                        </svg>
                    </span>
                    <div>
                        <span class="text-[11px] font-black uppercase tracking-widest text-[#0c4161]/70">Core Purpose</span>
                        <h2 class="font-heading font-black text-xl sm:text-2xl text-[#0c4161] m-0"><?= esc_html($m_head) ?></h2>
                    </div>
                </div>
                <?php if ($m_desc): ?>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line m-0">
                        <?= esc_html($m_desc) ?>
                    </p>
                <?php endif; ?>
            </div>

            <!-- Vision / Information First Card -->
            <div class="relative overflow-hidden rounded-2xl border-2 border-dashed border-amber-300/80 bg-gradient-to-br from-amber-50/50 via-white to-amber-50/20 p-6 sm:p-8 shadow-xs hover:border-amber-400 hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-4">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white shadow-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </span>
                    <div>
                        <span class="text-[11px] font-black uppercase tracking-widest text-amber-700">Medical Clarity</span>
                        <h2 class="font-heading font-black text-xl sm:text-2xl text-slate-900 m-0"><?= esc_html($v_head) ?></h2>
                    </div>
                </div>
                <?php if ($v_desc): ?>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line m-0">
                        <?= esc_html($v_desc) ?>
                    </p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
