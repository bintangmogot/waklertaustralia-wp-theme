<?php
/**
 * The template for displaying the footer
 */
$footer_desc = get_field('footer_description', 'option') ?: "Waklert Australia provides clear information about a focused range of armodafinil products, ordering and delivery options.";
$footer_address = get_field('location_text', 'option') ?: get_field('footer_address', 'option') ?: "Australia-wide online service";
$footer_email = get_field('support_email', 'option') ?: get_field('footer_email', 'option') ?: "support@waklertaustralia.com";
$copyright_text = get_field('copyright_text', 'option') ?: sprintf('© %s Waklert Australia. All rights reserved.', date('Y'));
$footer_menu_locations = get_nav_menu_locations();
$footer_menus = [];

foreach (['footer_trending', 'footer_quick', 'footer_cities', 'footer_info'] as $location) {
    $menu_id = absint($footer_menu_locations[$location] ?? 0);
    if (!$menu_id) {
        continue;
    }

    $menu = wp_get_nav_menu_object($menu_id);
    $items = wp_get_nav_menu_items($menu_id);
    if (!$menu || empty($items)) {
        continue;
    }

    $heading = preg_replace('/^Footer\s+/i', '', $menu->name);
    $footer_menus[$location] = [
        'id' => $menu_id,
        'heading' => $heading ?: $menu->name,
    ];
}

$render_footer_menu = static function ($location, $wrapper_class = '') use ($footer_menus) {
    if (empty($footer_menus[$location])) {
        return;
    }

    $menu = $footer_menus[$location];
    ?>
    <section class="<?= esc_attr($wrapper_class) ?>">
        <h3 class="mb-5 text-[15px] font-bold text-white" style="color: #fff !important">
            <?= esc_html($menu['heading']) ?>
        </h3>
        <nav aria-label="<?= esc_attr($menu['heading']) ?>">
            <?php wp_nav_menu([
                'menu' => $menu['id'],
                'container' => false,
                'menu_class' => 'space-y-4 text-[13px] font-medium text-white/70 [&_a:hover]:text-accent [&_a]:transition-colors',
                'fallback_cb' => false,
            ]); ?>
        </nav>
    </section>
    <?php
};
?>
<footer class="relative isolate overflow-hidden bg-ink text-ink-foreground">
    <?php waklert_output_pattern_rings(); ?>
    <!-- Badge strip -->
    <div class="relative isolate overflow-hidden bg-primary py-8 text-primary-foreground [&_svg]:text-accent">
        <?php waklert_output_pattern_rings(); ?>
        <div class="container-site relative z-10 grid grid-cols-2 gap-6 text-center md:grid-cols-4">

            <div class="flex flex-col items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-7 w-7"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                <span class="text-[11px] font-bold tracking-widest uppercase"><?= "Australia-wide delivery options" ?></span>
            </div>

            <div class="flex flex-col items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-7 w-7"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                <span class="text-[11px] font-bold tracking-widest uppercase"><?= "100% Genuine Products" ?></span>
            </div>

            <div class="flex flex-col items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-7 w-7"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span class="text-[11px] font-bold tracking-widest uppercase"><?= "Shipping Insurance" ?></span>
            </div>

            <div class="flex flex-col items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-7 w-7"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                <span class="text-[11px] font-bold tracking-widest uppercase"><?= "Discreet Delivery" ?></span>
            </div>

        </div>
    </div>

    <div class="container-site relative z-10 grid gap-10 py-16 md:grid-cols-2 lg:grid-cols-5">
        <!-- Column 1 -->
        <div class="lg:col-span-2 pr-0 lg:pr-8">
            <a href="<?= home_url('/') ?>" class="flex shrink-0 items-center gap-2.5" aria-label="Waklert Australia">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary text-primary-foreground shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3.5 6.5 7.5 18 12 10 16.5 18 20.5 6.5" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="3.5" cy="6.5" r="1.6" fill="#fff" />
                        <circle cx="7.5" cy="18" r="1.6" fill="#fff" />
                        <circle cx="12" cy="10" r="2.4" fill="#f49a5b" />
                        <circle cx="16.5" cy="18" r="1.6" fill="#fff" />
                        <circle cx="20.5" cy="6.5" r="1.6" fill="#fff" />
                    </svg>
                </span>
                <span class="font-heading text-xl font-extrabold tracking-tight text-white">
                    Waklert <span class="text-accent">Australia</span>
                </span>
            </a>
            <p class="mt-5 text-[13px] leading-relaxed text-ink-foreground/80">
                <?= $footer_desc ?>
            </p>
            <?php $disclaimer = get_field('disclaimer_en', 'option') ?: "This website provides general information only and is not a substitute for advice from a qualified health professional."; ?>
            <p class="mt-2 text-[13px] leading-relaxed text-ink-foreground/80">
                <strong class="text-white"><?= "Medical Website Disclaimer:" ?></strong>
                <?= esc_html($disclaimer) ?>
            </p>

            <h3 class="text-[15px] font-bold text-white mb-4 mt-8" style="color: #fff !important">
                <?= "Get in Touch with Us" ?>
            </h3>

            <div class="mt-4 space-y-3.5">
                <div class="flex items-start gap-3 text-[13px] text-ink-foreground/80">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mt-0.5 text-[#FFD700] shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                    <span><?= $footer_address ?></span>
                </div>
                <div class="flex items-center gap-3 text-[13px] text-ink-foreground/80">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#FFD700] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>WhatsApp &rarr;</span>
                    <?php $whatsapp = get_field('whatsapp_number', 'option') ?: home_url('/contact/'); ?>
                    <a href="<?= esc_url($whatsapp) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex hover:opacity-80 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#25D366]" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.67-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    </a>
                </div>
                <div class="flex items-center gap-3 text-[13px] text-ink-foreground/80">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#FFD700] shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    <a href="mailto:<?= esc_attr($footer_email) ?>" class="hover:text-white transition-colors"><?= esc_html($footer_email) ?></a>
                </div>
            </div>

        </div>

        <!-- Column 2 -->
        <?php $render_footer_menu('footer_trending'); ?>

        <!-- Column 3 -->
        <div>
            <?php $render_footer_menu('footer_quick'); ?>
            <?php $render_footer_menu('footer_cities', 'mt-10'); ?>
        </div>

        <!-- Column 4 -->
        <?php $render_footer_menu('footer_info'); ?>
    </div>

    <div class="relative z-10 border-t border-white/10">
        <div class="container-site flex flex-col items-center justify-between gap-3 py-5 text-xs text-ink-foreground/60 sm:flex-row">
            <p><?= wp_kses_post($copyright_text) ?></p>
            <?php if (function_exists('is_product') && is_product()): ?>
                <a href="https://www.flaticon.com/uicons" class="transition-colors hover:text-white" target="_blank" rel="noopener noreferrer">UIcons by Flaticon</a>
            <?php endif; ?>
        </div>
    </div>
</footer>

<script>console.log("🚀 InstaWP Auto-Deploy is fully operational!");</script>
<?php wp_footer(); ?>
</body>
</html>
