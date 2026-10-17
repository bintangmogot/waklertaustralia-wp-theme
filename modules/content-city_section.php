<?php
/**
 * Module: City Section (Delivered Everywhere in Australia)
 * Standalone text-based cities showcase with dark forest-green pill design.
 * Distinct from delivery_cities: displays stylish text badges without hyperlinks.
 */

$tag = get_sub_field('tag');
if ($tag === null || $tag === '') {
    $tag = 'SHIPPING NATIONWIDE';
}

$heading = get_sub_field('title');
if ($heading === null || $heading === '') {
    $heading = 'Delivered Everywhere in Australia';
}

$desc = get_sub_field('description');
if ($desc === null || $desc === '') {
    $desc = 'Metro cities, regional towns, or remote FIFO camps — we ship to your address.';
}

// 1. Check quick_cities textarea
$quick_cities = trim((string) get_sub_field('quick_cities'));
$cities_list = [];

if (!empty($quick_cities)) {
    $lines = preg_split('/\r\n|\r|\n/', $quick_cities);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '') continue;
        $has_check = false;
        if (str_contains($line, '✓')) {
            $has_check = true;
            $line = trim(str_replace('✓', '', $line));
        }
        $cities_list[] = [
            'name' => $line,
            'checkmark' => $has_check,
        ];
    }
}

// 2. Check repeater field
if (empty($cities_list) && have_rows('cities_list')) {
    while (have_rows('cities_list')) {
        the_row();
        $name = trim((string) get_sub_field('city_name'));
        if ($name === '') continue;
        $has_check = (bool) get_sub_field('has_checkmark');
        if (str_contains($name, '✓')) {
            $has_check = true;
            $name = trim(str_replace('✓', '', $name));
        }
        $cities_list[] = [
            'name' => $name,
            'checkmark' => $has_check,
        ];
    }
}

// 3. Fallback to default 15 Australian cities from reference design
if (empty($cities_list)) {
    $cities_list = [
        ['name' => 'Sydney NSW', 'checkmark' => false],
        ['name' => 'Melbourne VIC', 'checkmark' => false],
        ['name' => 'Brisbane QLD', 'checkmark' => false],
        ['name' => 'Perth WA', 'checkmark' => false],
        ['name' => 'Adelaide SA', 'checkmark' => false],
        ['name' => 'Darwin NT', 'checkmark' => false],
        ['name' => 'Hobart TAS', 'checkmark' => false],
        ['name' => 'Canberra ACT', 'checkmark' => false],
        ['name' => 'Gold Coast QLD', 'checkmark' => false],
        ['name' => 'Newcastle NSW', 'checkmark' => false],
        ['name' => 'Cairns QLD', 'checkmark' => false],
        ['name' => 'Wollongong NSW', 'checkmark' => false],
        ['name' => 'Geelong VIC', 'checkmark' => false],
        ['name' => 'Townsville QLD', 'checkmark' => false],
        ['name' => 'Regional & Remote', 'checkmark' => true],
    ];
}
?>

<section class="section-padding bg-[#0d2b1a] relative isolate overflow-hidden border-y-2 border-dashed border-[#205234]/70" data-testid="city-section">
    <!-- Subtle Ambient Glow Effects -->
    <div class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(ellipse_75%_55%_at_50%_0%,rgba(245,158,11,0.08),transparent_70%)]" aria-hidden="true"></div>
    <div class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(circle_at_50%_100%,rgba(16,185,129,0.07),transparent_65%)]" aria-hidden="true"></div>

    <?php if (function_exists('waklert_output_pattern_rings')) { waklert_output_pattern_rings(); } ?>

    <div class="container-custom relative z-10 max-w-5xl mx-auto px-4 sm:px-6">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-10 md:mb-12">
            <?php if (!empty($tag)): ?>
            <div class="inline-flex items-center gap-2 bg-[#213a26]/90 border border-[#ec951a]/35 text-[#ec951a] text-[11px] sm:text-xs font-black uppercase tracking-[0.2em] px-4 py-1.5 rounded-full mb-4 sm:mb-5 shadow-xs">
                <?= esc_html($tag) ?>
            </div>
            <?php endif; ?>

            <h2 class="font-heading text-2xl sm:text-3xl md:text-4xl lg:text-[42px] font-black text-[#fff1ca] tracking-tight leading-tight mb-3 sm:mb-4">
                <?= esc_html($heading) ?>
            </h2>

            <?php if (!empty($desc)): ?>
            <p class="text-sm sm:text-base text-[#c2d6c9] max-w-xl mx-auto leading-relaxed">
                <?= esc_html($desc) ?>
            </p>
            <?php endif; ?>
        </div>

        <!-- City Pills Container -->
        <div class="max-w-4xl mx-auto flex flex-wrap justify-center items-center gap-2.5 sm:gap-3 md:gap-3.5">
            <?php foreach ($cities_list as $city): ?>
            <div class="group inline-flex items-center gap-2.5 bg-[#173a27]/90 hover:bg-[#1f4c34] border border-[#2f5c40]/80 hover:border-[#ec951a]/45 text-[#fff1ca] rounded-full px-4 sm:px-5 py-2 sm:py-2.5 text-xs sm:text-sm md:text-[15px] font-semibold tracking-wide shadow-xs transition-all duration-300 hover:-translate-y-0.5 cursor-default select-none">
                <!-- Amber / Gold Location Indicator Dot -->
                <span class="w-2 h-2 rounded-full bg-[#f59e0b] shadow-[0_0_8px_rgba(245,158,11,0.7)] shrink-0" aria-hidden="true"></span>
                <span><?= esc_html($city['name']) ?></span>
                <?php if (!empty($city['checkmark'])): ?>
                <span class="text-[#fff1ca] font-bold ml-0.5" aria-hidden="true">✓</span>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
