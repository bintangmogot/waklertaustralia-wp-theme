<?php
/**
 * Module: How to Order (Steps)
 * Follows the colorful card design rules:
 * - Multi-color vibrant vector icons
 * - 2-tone card structure (White top with colorful icon + Navy bottom block)
 * - Dashed borders
 * - Patterned gradient background
 * - Lift & scale animations
 */

$tag = get_sub_field('tag') ?: "Simple Process";
$heading = get_sub_field('heading') ?: "Three Steps from Product Information to Delivery";

$is_about_page = is_page('about-us');
$section_classes = $is_about_page 
    ? 'relative isolate overflow-hidden section-padding bg-primary-dark text-white' 
    : 'section-padding bg-gradient-to-b from-[#f0f6fa] via-[#e9f3f9] to-[#f8fafc] bg-pattern-dots border-y-2 border-dashed border-sky-200/80 relative isolate overflow-hidden';

$tag_classes = $is_about_page
    ? 'inline-flex items-center gap-2 bg-white/10 text-amber-300 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-3 backdrop-blur-sm border border-white/20'
    : 'inline-flex items-center gap-2 bg-amber-100/90 text-amber-900 border border-amber-300/80 text-xs font-black uppercase tracking-widest px-4 py-1.5 rounded-full mb-3 shadow-xs';

// 3 high-craft colorful vector illustrations tailored to ordering Armodafinil in Australia
$step_illustrations = [
    // Step 1: Review Range (Blister pack, pill tablets, magnifying glass with blue lens & gold frame)
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-16 h-16 shrink-0" fill="none" aria-hidden="true">
        <ellipse cx="32" cy="56" rx="20" ry="2.5" fill="#0C4161" fill-opacity="0.12" />
        <!-- Blister strip background -->
        <rect x="14" y="14" width="36" height="30" rx="4" fill="#E2E8F0" stroke="#94A3B8" stroke-width="1.5" />
        <rect x="16" y="16" width="14" height="11" rx="2.5" fill="#38BDF8" fill-opacity="0.25" stroke="#0284C7" stroke-width="1" />
        <circle cx="23" cy="21.5" r="3.5" fill="#FFFFFF" />
        <rect x="34" y="16" width="14" height="11" rx="2.5" fill="#F59E0B" fill-opacity="0.25" stroke="#D97706" stroke-width="1" />
        <circle cx="41" cy="21.5" r="3.5" fill="#FBBF24" />
        <rect x="16" y="30" width="14" height="11" rx="2.5" fill="#10B981" fill-opacity="0.25" stroke="#059669" stroke-width="1" />
        <circle cx="23" cy="35.5" r="3.5" fill="#34D399" />
        <rect x="34" y="30" width="14" height="11" rx="2.5" fill="#38BDF8" fill-opacity="0.25" stroke="#0284C7" stroke-width="1" />
        <circle cx="41" cy="35.5" r="3.5" fill="#FFFFFF" />
        <!-- Magnifying Glass with sparkling reflections -->
        <circle cx="40" cy="28" r="11" fill="#93C5FD" fill-opacity="0.4" stroke="#0C4161" stroke-width="2.5" />
        <circle cx="40" cy="28" r="9.5" stroke="#F59E0B" stroke-width="1.2" />
        <path d="M48 36L56 44" stroke="#0C4161" stroke-width="3.5" stroke-linecap="round" />
        <path d="M48 36L56 44" stroke="#F59E0B" stroke-width="1.8" stroke-linecap="round" />
        <path d="M35 24L38 27" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" />
    </svg>',

    // Step 2: Confirm Order (PayID / Local EFT Card, Gold AUD coin & Green Padlock)
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-16 h-16 shrink-0" fill="none" aria-hidden="true">
        <ellipse cx="32" cy="56" rx="20" ry="2.5" fill="#0C4161" fill-opacity="0.12" />
        <!-- Credit / Bank Card -->
        <rect x="10" y="16" width="44" height="28" rx="4" fill="#0C4161" stroke="#082C42" stroke-width="1.5" />
        <rect x="10" y="22" width="44" height="6" fill="#082C42" />
        <rect x="15" y="32" width="9" height="7" rx="1.5" fill="#F59E0B" />
        <circle cx="42" cy="34" r="5" fill="#EF4444" fill-opacity="0.8" />
        <circle cx="47" cy="34" r="5" fill="#F59E0B" fill-opacity="0.8" />
        <!-- Shiny AUD Gold Coin -->
        <circle cx="32" cy="42" r="11" fill="#D97706" />
        <circle cx="32" cy="41" r="10" fill="#F59E0B" />
        <circle cx="32" cy="41" r="8.5" fill="#FBBF24" stroke="#D97706" stroke-width="0.8" />
        <text x="32" y="45.5" font-family="system-ui, -apple-system, sans-serif" font-size="11" font-weight="900" fill="#78350F" text-anchor="middle">$</text>
        <!-- Green Security Padlock -->
        <rect x="17" y="39" width="10" height="9" rx="2" fill="#10B981" />
        <path d="M19.5 39V36.5C19.5 35.1 20.6 34 22 34C23.4 34 24.5 35.1 24.5 36.5V39" stroke="#FBBF24" stroke-width="1.8" stroke-linecap="round" />
        <circle cx="22" cy="43.5" r="1.2" fill="#FFFFFF" />
    </svg>',

    // Step 3: Track Delivery (Australia Post Express Delivery Van with Live Tracking Pin)
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-16 h-16 shrink-0" fill="none" aria-hidden="true">
        <ellipse cx="32" cy="56" rx="22" ry="2.5" fill="#0C4161" fill-opacity="0.12" />
        <!-- Speed Streaks -->
        <path d="M5 32H11M3 38H9M7 44H13" stroke="#DC2626" stroke-width="2" stroke-linecap="round" />
        <!-- Express Van -->
        <rect x="15" y="19" width="27" height="25" rx="3" fill="#DC2626" />
        <path d="M42 26H50.5L56 33V44H42V26Z" fill="#DC2626" />
        <path d="M43 28H49.5L53.5 33H43V28Z" fill="#93C5FD" />
        <rect x="19" y="23" width="19" height="9" rx="1.5" fill="#FFFFFF" />
        <text x="28.5" y="29.5" font-family="system-ui, -apple-system, sans-serif" font-size="6" font-weight="900" fill="#DC2626" text-anchor="middle" letter-spacing="0.5">TRACK</text>
        <circle cx="24" cy="44" r="6.5" fill="#1E293B" />
        <circle cx="24" cy="44" r="2.8" fill="#F8FAFC" />
        <circle cx="48" cy="44" r="6.5" fill="#1E293B" />
        <circle cx="48" cy="44" r="2.8" fill="#F8FAFC" />
        <!-- Location GPS Pin with Pulse Dot -->
        <path d="M48 6C44.7 6 42 8.7 42 12C42 16.5 48 23 48 23C48 23 54 16.5 54 12C54 8.7 51.3 6 48 6Z" fill="#10B981" />
        <circle cx="48" cy="11.5" r="2.5" fill="#FFFFFF" />
    </svg>'
];

// Step items
$step_items = [];
if (have_rows('steps')) {
    $idx = 0;
    while (have_rows('steps')) {
        the_row();
        $step_items[] = [
            'icon'  => $step_illustrations[$idx % 3],
            'title' => get_sub_field('title'),
            'desc'  => get_sub_field('desc'),
            'step'  => sprintf('%02d', $idx + 1)
        ];
        $idx++;
    }
}

if (empty($step_items)) {
    $step_items = [
        [
            'icon'  => $step_illustrations[0],
            'title' => "Review the Range",
            'desc'  => "Compare available armodafinil brands, strengths and pack sizes. Read the product information before making a selection.",
            'step'  => "01"
        ],
        [
            'icon'  => $step_illustrations[1],
            'title' => "Confirm Your Order",
            'desc'  => "Choose an available payment method at checkout. Order details are handled through the secure checkout process.",
            'step'  => "02"
        ],
        [
            'icon'  => $step_illustrations[2],
            'title' => "Track Delivery",
            'desc'  => "When an order is dispatched, Australia Post tracking details are provided so you can follow its progress.",
            'step'  => "03"
        ],
    ];
}
?>

<section class="<?= esc_attr($section_classes) ?>" data-testid="<?= $is_about_page ? 'about-site-guide' : 'how-it-works' ?>">
    <?php if ($is_about_page) waklert_output_pattern_rings(); ?>
    <div class="container-site relative z-10">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 md:mb-14">
            <?php if (!empty($tag)): ?>
                <span class="<?= esc_attr($tag_classes) ?>">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse-subtle"></span>
                    <?= esc_html($tag) ?>
                </span>
            <?php endif; ?>
            <h2 class="font-heading text-2xl sm:text-3xl md:text-4xl font-extrabold <?= $is_about_page ? 'text-white' : 'text-ink' ?> tracking-tight mb-3.5">
                <?= esc_html($heading) ?>
            </h2>
            <p class="<?= $is_about_page ? 'text-white/80' : 'text-muted-foreground' ?> text-sm md:text-base leading-relaxed max-w-2xl mx-auto">
                Simple, transparent, and private. Ordering Armodafinil across Australia takes just 3 straightforward steps.
            </p>
        </div>

        <!-- 3-Card Grid matching the 2-Tone Dashed Card Rule -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8 items-stretch max-w-5xl mx-auto">
            <?php foreach ($step_items as $card): ?>
                <div class="group flex flex-col h-full rounded-2xl bg-white border-2 border-dashed border-sky-300/80 hover:border-[#0c4161] overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-out">
                    <!-- Top Half: Pure white surface with colorful illustration, step pill & bold title -->
                    <div class="bg-white p-6 pb-6 flex flex-col items-center text-center flex-1 justify-start relative">
                        <!-- Step Badge -->
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-900 border border-amber-300 text-[11px] font-black tracking-widest uppercase mb-4 shadow-xs">
                            <span>STEP <?= esc_html($card['step']) ?></span>
                        </div>

                        <!-- Colorful Vector Illustration -->
                        <div class="w-16 h-16 mb-4 flex items-center justify-center shrink-0 transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-1">
                            <?= $card['icon'] ?>
                        </div>

                        <!-- Card Title -->
                        <h3 class="font-heading font-extrabold text-[18px] md:text-xl text-ink text-center leading-snug tracking-tight">
                            <?= esc_html($card['title']) ?>
                        </h3>
                    </div>

                    <!-- Bottom Half: Solid theme colored block with description -->
                    <div class="bg-[#0c4161] group-hover:bg-[#082c42] text-white p-5 md:p-6 text-center text-xs md:text-[13px] leading-relaxed font-normal text-white/95 flex items-center justify-center transition-colors duration-300 border-t-2 border-dashed border-white/20">
                        <p class="leading-relaxed">
                            <?= esc_html($card['desc']) ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
