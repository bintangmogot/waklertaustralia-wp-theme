<?php
/**
 * Module: Why Choose Us (Audiences / Key Benefits)
 */

$tag = get_sub_field('tag');
$heading = get_sub_field('heading') ?: "Why Buy Modafinil from Waklert Australia?";
$desc = get_sub_field('description') ?: "At Waklert Australia, we pride ourselves on providing a quick, reliable, and affordable service for all your Modafinil and Armodafinil needs. Here's why you should choose us:";

$is_about_page = is_page('about-us');

$section_classes = $is_about_page 
    ? 'relative isolate overflow-hidden section-padding bg-primary-dark text-white' 
    : 'section-padding bg-gradient-to-b from-[#f8fafc] via-[#eff6fb] to-[#f8fafc] bg-pattern-dots text-foreground border-y-2 border-dashed border-sky-200/80 relative isolate overflow-hidden';

$tag_classes = $is_about_page
    ? 'inline-flex items-center gap-2 bg-white/10 text-amber-300 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-3 backdrop-blur-sm border border-white/20'
    : 'inline-flex items-center gap-2 bg-sky-100 text-[#0c4161] border border-sky-300 text-xs font-black uppercase tracking-widest px-4 py-1.5 rounded-full mb-3 shadow-xs';

// 4 high-quality colorful vector icons tailored to the reference design
$colorful_icons = [
    // 0: Affordable Prices (Hand & Shiny Dollar Coin with Growth Sparkle)
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-16 h-16 shrink-0" fill="none" aria-hidden="true"><path d="M46 11L53 11L53 18" stroke="#10B981" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" /><path d="M53 11L43 21" stroke="#10B981" stroke-width="2.5" stroke-linecap="round" /><circle cx="50" cy="22" r="1.5" fill="#34D399" /><circle cx="32" cy="21" r="13" fill="#D97706" /><circle cx="32" cy="20" r="12" fill="#F59E0B" /><circle cx="32" cy="20" r="10" fill="#FBBF24" /><circle cx="32" cy="20" r="8.5" fill="#F59E0B" stroke="#D97706" stroke-width="0.8" /><text x="32" y="25" font-family="system-ui, -apple-system, sans-serif" font-size="14" font-weight="900" fill="#78350F" text-anchor="middle">$</text><path d="M13 54L23 46L26.5 50.5L16.5 58.5Z" fill="#DC2626" /><path d="M12 55L15.5 59" stroke="#991B1B" stroke-width="2" stroke-linecap="round" /><path d="M23 46L30 41C32.5 39.5 35.5 39.5 38 41L47 45C48.8 45.8 49.5 48 48.5 49.6C47.6 51 45.4 51.5 43.6 50.8L34 47.5L30.5 50.5L26.5 50.5L23 46Z" fill="#FDBA74" stroke="#EA580C" stroke-width="1.2" stroke-linejoin="round" /><path d="M36 41C38.5 38 41.5 37 44.5 38.5C46.5 39.5 47 41.5 46 43L40.5 48" stroke="#EA580C" stroke-width="1.2" stroke-linecap="round" /></svg>',

    // 1: Fast Domestic Shipping (Red Express Delivery Truck with FAST badge & Speed Streaks)
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-16 h-16 shrink-0" fill="none" aria-hidden="true"><path d="M5 29H13M3 35H10M6 41H12" stroke="#DC2626" stroke-width="2" stroke-linecap="round" /><rect x="18" y="13" width="22" height="9.5" rx="2" fill="#DC2626" /><path d="M14 18H17M12 15H15" stroke="#DC2626" stroke-width="1.5" stroke-linecap="round" /><text x="29" y="20.5" font-family="system-ui, -apple-system, sans-serif" font-size="7" font-weight="900" font-style="italic" fill="#FFFFFF" text-anchor="middle" letter-spacing="0.5">FAST</text><path d="M16 23.5H41V46H16V23.5Z" fill="#EF4444" /><path d="M16 23.5H41V26.5H16V23.5Z" fill="#DC2626" /><path d="M41 29.5H49.5L55.5 36V46H41V29.5Z" fill="#DC2626" /><path d="M43 31.5H49L53 36H43V31.5Z" fill="#93C5FD" /><rect x="53.5" y="41" width="2.5" height="3" rx="0.5" fill="#FBBF24" /><rect x="54" y="44" width="3" height="3" rx="1" fill="#475569" /><ellipse cx="36" cy="53" rx="22" ry="2" fill="#000000" fill-opacity="0.1" /><circle cx="25" cy="46" r="6.5" fill="#1E293B" /><circle cx="25" cy="46" r="2.8" fill="#E2E8F0" /><circle cx="47" cy="46" r="6.5" fill="#1E293B" /><circle cx="47" cy="46" r="2.8" fill="#E2E8F0" /></svg>',

    // 2: Delivery to PO Box or Home Address (Red Mailbox with Mail & Yellow Flag)
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-16 h-16 shrink-0" fill="none" aria-hidden="true"><ellipse cx="32" cy="57" rx="16" ry="2" fill="#000000" fill-opacity="0.1" /><rect x="29" y="37" width="6" height="19" rx="1" fill="#92400E" /><path d="M20 21C20 15 24.5 11 32 11C39.5 11 44 15 44 21V37H20V21Z" fill="#DC2626" /><path d="M20 21C20 15 24.5 11 32 11C36.5 11 39.5 13 41.5 17L20 34V21Z" fill="#EF4444" /><rect x="18" y="35" width="28" height="4" rx="2" fill="#991B1B" /><rect x="23" y="23" width="18" height="12" rx="1" fill="#FFFFFF" stroke="#CBD5E1" stroke-width="1" /><path d="M23 24L32 30L41 24" stroke="#EF4444" stroke-width="1.2" stroke-linecap="round" /><rect x="37" y="25" width="3" height="3" fill="#DC2626" /><rect x="44" y="23" width="2" height="10" fill="#B45309" /><path d="M44 23H52.5V17H44V23Z" fill="#FACC15" /></svg>',

    // 3: No Customs Issues (Australian Delivery Courier with Verified Parcel)
    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="w-16 h-16 shrink-0" fill="none" aria-hidden="true"><ellipse cx="32" cy="57" rx="16" ry="2" fill="#000000" fill-opacity="0.1" /><path d="M19 54C19 45.5 24.5 42 32 42C39.5 42 45 45.5 45 54V56H19V54Z" fill="#0C4161" /><path d="M29 42L32 47.5L35 42Z" fill="#FFFFFF" /><path d="M31.2 47.5L32 53.5L32.8 47.5Z" fill="#DC2626" /><rect x="29" y="37" width="6" height="6" fill="#FDBA74" /><circle cx="32" cy="28.5" r="8" fill="#FDBA74" /><path d="M24 27.5C24 22.5 27 20.5 32 20.5C37 20.5 40 22.5 40 27.5V29.5H24V27.5Z" fill="#334155" /><path d="M23 24.5C23 19.5 27 17.5 32 17.5C37 17.5 41 19.5 41 24.5H23Z" fill="#0C4161" /><path d="M21 24.5H43C44 24.5 45 25.5 44 26.5L42 27.5H22L20 26.5C19 25.5 20 24.5 21 24.5Z" fill="#082C42" /><circle cx="32" cy="21.5" r="1.5" fill="#FACC15" /><rect x="25" y="44" width="14" height="11.5" rx="1" fill="#D97706" stroke="#B45309" stroke-width="0.8" /><path d="M32 44V55.5M25 49.8H39" stroke="#B45309" stroke-width="0.8" /><circle cx="37" cy="45" r="5.2" fill="#10B981" stroke="#FFFFFF" stroke-width="1.2" /><path d="M35 45L36.5 46.5L39.5 43.5" stroke="#FFFFFF" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" /></svg>'
];

// Build items list
$items = [];
if (have_rows('audiences')) {
    $idx = 0;
    while (have_rows('audiences')) {
        the_row();
        $custom_icon = get_sub_field('icon_svg');
        // Use custom icon if provided and not the legacy wireframe, otherwise use colorful graphic
        $icon = (!empty($custom_icon) && strpos($custom_icon, 'stroke="currentColor"') === false) 
            ? $custom_icon 
            : ($colorful_icons[$idx % 4] ?? $colorful_icons[0]);
        
        $items[] = [
            'icon'  => $icon,
            'title' => get_sub_field('title'),
            'desc'  => get_sub_field('desc'),
        ];
        $idx++;
    }
}

// Fallback to the 4 cards matching the reference design
if (empty($items)) {
    $items = [
        [
            'icon'  => $colorful_icons[0],
            'title' => "Affordable Modafinil Prices Across Australia",
            'desc'  => "We offer competitive prices on Modafinil and Armodafinil in Australia, ensuring you get the best deal without compromising on quality. Save money while enjoying the benefits of enhanced focus and wakefulness."
        ],
        [
            'icon'  => $colorful_icons[1],
            'title' => "Fast, Local Domestic Shipping",
            'desc'  => "Forget long wait times and customs delays. With Waklert Australia, your Modafinil and Armodafinil will be shipped locally within Australia, so you get your order quickly and without hassle."
        ],
        [
            'icon'  => $colorful_icons[2],
            'title' => "Delivery to Your PO Box or Home Address",
            'desc'  => "We offer flexible delivery options. Whether you prefer delivery to your PO Box or a home address, we make it easy for you to receive your order discreetly and efficiently."
        ],
        [
            'icon'  => $colorful_icons[3],
            'title' => "No Customs Issues",
            'desc'  => "We ensure there are no customs problems with your Modafinil or Armodafinil order. Get your medication delivered safely within Australia without the complications that often come with international shipments."
        ],
    ];
}
?>

<section class="<?= esc_attr($section_classes) ?>" data-testid="<?= $is_about_page ? 'about-principles' : 'why-choose-us' ?>">
    <?php if ($is_about_page) waklert_output_pattern_rings(); ?>
    <div class="container-site relative z-10">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 md:mb-14">
            <?php if (!empty($tag)): ?>
                <span class="<?= esc_attr($tag_classes) ?>">
                    <?= esc_html($tag) ?>
                </span>
            <?php endif; ?>
            <h2 class="font-heading text-2xl sm:text-3xl md:text-4xl font-extrabold <?= $is_about_page ? 'text-white' : 'text-ink' ?> tracking-tight mb-3.5">
                <?= esc_html($heading) ?>
            </h2>
            <?php if (!empty($desc)): ?>
                <p class="<?= $is_about_page ? 'text-white/80' : 'text-muted-foreground' ?> text-sm md:text-base leading-relaxed max-w-2xl mx-auto">
                    <?= esc_html($desc) ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- 4-Card Grid matching reference design -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
            <?php foreach ($items as $card): ?>
                <div class="group flex flex-col h-full rounded-2xl bg-white border-2 border-dashed border-sky-300/80 hover:border-[#0c4161] overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 ease-out">
                    <!-- Top Half: Pure white surface with colorful illustration & bold title -->
                    <div class="bg-white p-6 pb-6 flex flex-col items-center text-center flex-1 justify-start">
                        <div class="w-16 h-16 mb-4 flex items-center justify-center shrink-0 transform transition-transform duration-300 group-hover:scale-110 group-hover:rotate-1">
                            <?= $card['icon'] ?>
                        </div>
                        <h3 class="font-heading font-extrabold text-[17px] md:text-lg text-ink text-center leading-snug tracking-tight">
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
