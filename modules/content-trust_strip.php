<?php
/**
 * Module: Trust Strip (4 Cards below Hero)
 * Follows the colorful card design rules:
 * - Multi-color vibrant vector icons
 * - 2-tone card structure (White top + Navy bottom block)
 * - Dashed borders
 * - Patterned gradient background
 * - Lift & scale animations
 */

// 4 high-quality colorful vector illustrations for the trust badges
$colorful_trust_icons = [
    // 0: Australia Post Express Delivery (Red & White AusPost Style Express Van)
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-14 h-14 shrink-0" fill="none" aria-hidden="true">
        <ellipse cx="32" cy="54" rx="22" ry="2.5" fill="#0C4161" fill-opacity="0.12" />
        <path d="M6 31H12M4 37H10M8 43H14" stroke="#DC2626" stroke-width="2" stroke-linecap="round" />
        <rect x="16" y="16" width="28" height="28" rx="3" fill="#DC2626" />
        <path d="M44 24H52.5L58 31V44H44V24Z" fill="#DC2626" />
        <path d="M45 26H51.5L55.5 31H45V26Z" fill="#93C5FD" />
        <rect x="19" y="20" width="22" height="10" rx="1.5" fill="#FFFFFF" />
        <text x="30" y="27" font-family="system-ui, -apple-system, sans-serif" font-size="6.5" font-weight="900" fill="#DC2626" text-anchor="middle" letter-spacing="0.5">EXPRESS</text>
        <circle cx="25" cy="44" r="6.5" fill="#1E293B" />
        <circle cx="25" cy="44" r="2.8" fill="#F8FAFC" />
        <circle cx="49" cy="44" r="6.5" fill="#1E293B" />
        <circle cx="49" cy="44" r="2.8" fill="#F8FAFC" />
        <circle cx="56" cy="38" r="2" fill="#FBBF24" />
    </svg>',

    // 1: 100% Genuine Pharmacy Grade (Golden Shield + Green Medical Cross & Blister Pill)
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-14 h-14 shrink-0" fill="none" aria-hidden="true">
        <ellipse cx="32" cy="55" rx="18" ry="2.5" fill="#0C4161" fill-opacity="0.12" />
        <path d="M32 8L16 14V28C16 41 22.8 49.5 32 53C41.2 49.5 48 41 48 28V14L32 8Z" fill="#D97706" />
        <path d="M32 11L19 16V28C19 39 24.5 46.5 32 49.8C39.5 46.5 45 39 45 28V16L32 11Z" fill="#F59E0B" />
        <path d="M32 13L21 17.5V28C21 37.5 25.8 44 32 47C38.2 44 43 37.5 43 28V17.5L32 13Z" fill="#FBBF24" />
        <circle cx="32" cy="30" r="11" fill="#10B981" />
        <path d="M28 30H36M32 26V34" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" />
        <circle cx="42" cy="18" r="3.5" fill="#38BDF8" stroke="#FFFFFF" stroke-width="1.5" />
        <path d="M40.5 18L41.5 19L43.5 17" stroke="#FFFFFF" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>',

    // 2: Secure Local Bank Checkout (Australian EFT / PayID Card & Shiny Gold AUD Coin)
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-14 h-14 shrink-0" fill="none" aria-hidden="true">
        <ellipse cx="32" cy="55" rx="19" ry="2.5" fill="#0C4161" fill-opacity="0.12" />
        <rect x="10" y="16" width="44" height="28" rx="4" fill="#0C4161" />
        <rect x="10" y="22" width="44" height="6" fill="#082C42" />
        <rect x="15" y="32" width="10" height="7" rx="1.5" fill="#F59E0B" />
        <circle cx="44" cy="35" r="4.5" fill="#EF4444" fill-opacity="0.85" />
        <circle cx="40" cy="35" r="4.5" fill="#F59E0B" fill-opacity="0.85" />
        <circle cx="32" cy="42" r="10" fill="#D97706" />
        <circle cx="32" cy="41" r="9" fill="#F59E0B" />
        <circle cx="32" cy="41" r="7.5" fill="#FBBF24" stroke="#D97706" stroke-width="0.8" />
        <text x="32" y="45" font-family="system-ui, -apple-system, sans-serif" font-size="10" font-weight="900" fill="#78350F" text-anchor="middle">$</text>
        <circle cx="16" cy="42" r="5" fill="#10B981" stroke="#FFFFFF" stroke-width="1.2" />
        <path d="M14.5 42L15.5 43L17.5 41" stroke="#FFFFFF" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>',

    // 3: Discreet Plain Packaging (Brown Parcel with Fragile Stamp & Green Lock)
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-14 h-14 shrink-0" fill="none" aria-hidden="true">
        <ellipse cx="32" cy="55" rx="20" ry="2.5" fill="#0C4161" fill-opacity="0.12" />
        <rect x="13" y="19" width="38" height="29" rx="3" fill="#B45309" />
        <rect x="15" y="17" width="34" height="28" rx="2" fill="#D97706" />
        <path d="M15 27H49M32 17V45" stroke="#92400E" stroke-width="2.5" />
        <rect x="18" y="32" width="11" height="8" rx="1" fill="#FFFFFF" />
        <line x1="20" y1="35" x2="27" y2="35" stroke="#64748B" stroke-width="1.2" />
        <line x1="20" y1="37.5" x2="25" y2="37.5" stroke="#64748B" stroke-width="1.2" />
        <rect x="36" y="31" width="10" height="9" rx="2" fill="#10B981" />
        <path d="M38.5 31V28.5C38.5 27.1 39.6 26 41 26C42.4 26 43.5 27.1 43.5 28.5V31" stroke="#F59E0B" stroke-width="1.8" stroke-linecap="round" />
        <circle cx="41" cy="35.5" r="1.2" fill="#FFFFFF" />
    </svg>'
];

// Badge items with descriptions matching the 2-tone card requirement
$trust_items = [];
if (have_rows('badges')) {
    $idx = 0;
    $default_descs = [
        "Tracked delivery via Australia Post to all states and territories.",
        "Direct batch-tested pharmaceuticals from accredited manufacturers.",
        "Encrypted checkout with local PayID & Australian bank EFT.",
        "Shipped in generic, unbranded satchels for complete privacy."
    ];
    while (have_rows('badges')) {
        the_row();
        $label = get_sub_field('label');
        $trust_items[] = [
            'icon'  => $colorful_trust_icons[$idx % 4],
            'title' => $label ?: 'Guaranteed Service',
            'desc'  => $default_descs[$idx % 4]
        ];
        $idx++;
    }
}

if (empty($trust_items)) {
    $trust_items = [
        [
            'icon'  => $colorful_trust_icons[0],
            'title' => "Australia-wide Delivery",
            'desc'  => "Tracked delivery via Australia Post to all states and territories."
        ],
        [
            'icon'  => $colorful_trust_icons[1],
            'title' => "Sealed Product Packaging",
            'desc'  => "Direct batch-tested pharmaceuticals from accredited manufacturers."
        ],
        [
            'icon'  => $colorful_trust_icons[2],
            'title' => "Secure Local Checkout",
            'desc'  => "Encrypted checkout with local PayID & Australian bank EFT."
        ],
        [
            'icon'  => $colorful_trust_icons[3],
            'title' => "Discreet Packaging",
            'desc'  => "Shipped in generic, unbranded satchels for complete privacy."
        ],
    ];
}
?>

<section class="section-padding bg-gradient-to-b from-[#f0f6fa] via-[#e9f3f9] to-[#f8fafc] bg-pattern-dots border-y-2 border-dashed border-sky-200/80 relative isolate overflow-hidden" data-testid="trust-badges">
    <div class="container-site relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
            <?php foreach ($trust_items as $item): ?>
            <div class="group flex flex-col h-full rounded-2xl bg-white border-2 border-dashed border-sky-300/80 hover:border-[#0c4161] overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 ease-out">
                <!-- Top Half: Pure white surface with colorful illustration & bold title -->
                <div class="bg-white p-6 pb-5 flex flex-col items-center text-center flex-1 justify-start">
                    <div class="w-16 h-16 mb-3 flex items-center justify-center shrink-0 transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-1">
                        <?= $item['icon'] ?>
                    </div>
                    <h3 class="font-heading font-extrabold text-[16px] md:text-[17px] text-ink text-center leading-snug tracking-tight">
                        <?= esc_html($item['title']) ?>
                    </h3>
                </div>

                <!-- Bottom Half: Solid theme colored block with description -->
                <div class="bg-[#0c4161] group-hover:bg-[#082c42] text-white p-4 md:p-5 text-center text-xs md:text-[13px] leading-relaxed font-normal text-white/95 flex items-center justify-center transition-colors duration-300 border-t-2 border-dashed border-white/20">
                    <p class="leading-relaxed">
                        <?= esc_html($item['desc']) ?>
                    </p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
