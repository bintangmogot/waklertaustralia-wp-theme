<?php
/**
 * The template for displaying the footer
 */
$footer_desc = get_field('footer_description', 'option');
$footer_address = get_field('location_text', 'option') ?: get_field('footer_address', 'option');
$footer_email = get_field('support_email', 'option') ?: get_field('footer_email', 'option') ?: waklert_content('pg_footer_email');
$footer_contact_heading = get_field('footer_contact_heading', 'option');
$working_days = get_field('working_days', 'option');
$office_hours = get_field('office_hours', 'option');
$payments_heading = get_field('footer_payments_heading', 'option');
$shipping_heading = get_field('footer_shipping_heading', 'option');
$payment_images = get_field('footer_payment_images', 'option');
$shipping_images = get_field('footer_shipping_images', 'option');
$copyright_text = get_field('copyright_text', 'option');
$disclaimer = get_field('disclaimer_en', 'option');
$ssl_text = get_field('ssl_text', 'option');
$dispatch_text = get_field('dispatch_text', 'option');
$checkout_text = get_field('checkout_text', 'option');

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

// On homepage, render the Support CTA banner before footer if not already rendered as a page module
if (is_front_page() && empty($GLOBALS['waklert_support_cta_rendered'])) {
    get_template_part('modules/content', 'support_cta');
}
?>
<footer class="relative isolate overflow-hidden bg-ink text-ink-foreground">
    <?php waklert_output_pattern_rings(); ?>

    <?php
    $pre_footer_enabled = get_field('pre_footer_badges_enabled', 'option');
    $pre_footer_badges = get_field('pre_footer_badges', 'option');
    $color_classes = [
        'sky'     => 'text-sky-200',
        'amber'   => 'text-amber-200',
        'emerald' => 'text-emerald-200',
    ];
    ?>
    <?php if (!is_front_page() && !empty($pre_footer_enabled) && !empty($pre_footer_badges) && is_array($pre_footer_badges)): ?>
    <!-- 2-Tone Dashed Inner Page Badge Strip (Editable in WP Admin -> Theme Settings -> Footer) -->
    <div class="relative isolate overflow-hidden bg-gradient-to-r from-[#082a3f] via-[#0c4161] to-[#125883] bg-pattern-dots-dark py-10 text-white border-b-2 border-dashed border-sky-400/30">
        <?php waklert_output_pattern_rings(); ?>
        <div class="container-site relative z-10 grid grid-cols-2 gap-4 md:grid-cols-4 sm:gap-6">
            <?php foreach ($pre_footer_badges as $idx => $badge):
                $badge_title = $badge['title'] ?? '';
                if (trim((string) $badge_title) === '') continue;
                $badge_sub = $badge['subtitle'] ?? '';
                $badge_color_key = $badge['subtitle_color'] ?? 'sky';
                $badge_color_cls = $color_classes[$badge_color_key] ?? 'text-sky-200';
                $badge_icon_type = $badge['icon'] ?? 'truck';
                $badge_custom_icon = $badge['custom_icon'] ?? null;
            ?>
            <div class="group rounded-2xl border-2 border-dashed border-sky-300/40 bg-white/10 p-4 sm:p-5 backdrop-blur-sm flex flex-col items-center text-center gap-3 hover:bg-white/15 hover:-translate-y-1 transition-all">
                <div class="flex h-14 w-14 sm:h-16 sm:w-16 items-center justify-center rounded-2xl bg-white p-2 sm:p-2.5 shadow-lg shadow-black/25 border-2 border-white/90 group-hover:scale-105 transition-transform duration-300 shrink-0">
                    <?php if ($badge_icon_type === 'custom' && !empty($badge_custom_icon)): 
                        $c_url = is_array($badge_custom_icon) ? ($badge_custom_icon['url'] ?? '') : (is_numeric($badge_custom_icon) ? wp_get_attachment_image_url($badge_custom_icon, 'full') : $badge_custom_icon);
                    ?>
                        <img src="<?= esc_url($c_url) ?>" alt="<?= esc_attr($badge_title) ?>" class="w-10 h-10 sm:w-11 sm:h-11 object-contain shrink-0">
                    <?php elseif ($badge_icon_type === 'shield_pharma'): ?>
                        <?= waklert_content_icon('footer_icon_fc80858035') ?>
                    <?php elseif ($badge_icon_type === 'shield_insurance'): ?>
                        <?= waklert_content_icon('footer_icon_161fa942fa') ?>
                    <?php elseif ($badge_icon_type === 'parcel'): ?>
                        <?= waklert_content_icon('footer_icon_506df1a599') ?>
                    <?php else: // 'truck' or default ?>
                        <?= waklert_content_icon('footer_icon_49a47a3c44') ?>
                    <?php endif; ?>
                </div>
                <span class="text-xs font-extrabold tracking-wider uppercase text-white leading-tight"><?= esc_html($badge_title) ?></span>
                <?php if (!empty($badge_sub)): ?>
                    <span class="text-[11px] <?= esc_attr($badge_color_cls) ?> -mt-1.5"><?= esc_html($badge_sub) ?></span>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="container-site relative z-10 grid gap-10 py-16 md:grid-cols-2 lg:grid-cols-5">
        <!-- Column 1 -->
        <div class="lg:col-span-2 pr-0 lg:pr-8">
            <?php waklert_the_logo('h-12 sm:h-[53px] w-auto max-w-[264px] sm:max-w-[312px] object-contain', 'footer'); ?>

            <?php if (!empty($footer_desc)): ?>
            <p class="mt-5 text-[13px] leading-relaxed text-ink-foreground/80">
                <?= esc_html($footer_desc) ?>
            </p>
            <?php endif; ?>

            <?php if (!empty($disclaimer)): ?>
            <p class="mt-2 text-[13px] leading-relaxed text-ink-foreground/80">
                <strong class="text-white"><?= esc_html(waklert_option_text('disclaimer_label')) ?></strong>
                <?= esc_html($disclaimer) ?>
            </p>
            <?php endif; ?>

            <?php if (!empty($ssl_text) || !empty($dispatch_text) || !empty($checkout_text)): ?>
            <div class="mt-5 flex flex-wrap items-center gap-2 pt-1 text-xs">
                <?php if (!empty($ssl_text)): ?>
                <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/5 border border-sky-400/30 px-2.5 py-1 text-sky-200">
                    <?= waklert_content_icon('footer_icon_c00e1f65a5') ?>
                    <span><?= esc_html($ssl_text) ?></span>
                </span>
                <?php endif; ?>
                <?php if (!empty($dispatch_text)): ?>
                <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/5 border border-amber-400/30 px-2.5 py-1 text-amber-200">
                    <?= waklert_content_icon('footer_icon_be48130d38') ?>
                    <span><?= esc_html($dispatch_text) ?></span>
                </span>
                <?php endif; ?>
                <?php if (!empty($checkout_text)): ?>
                <span class="inline-flex items-center gap-1.5 rounded-lg bg-white/5 border border-emerald-400/30 px-2.5 py-1 text-emerald-200">
                    <?= waklert_content_icon('footer_icon_ffc0ddb7d2') ?>
                    <span><?= esc_html($checkout_text) ?></span>
                </span>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($footer_contact_heading)): ?>
            <h3 class="text-[15px] font-bold text-white mb-4 mt-8" style="color: #fff !important">
                <?= esc_html($footer_contact_heading) ?>
            </h3>
            <?php endif; ?>

            <?php
            $whatsapp_raw = get_field('whatsapp_button_url', 'option') ?: get_field('whatsapp_number', 'option');
            $whatsapp     = function_exists('waklert_format_whatsapp_url') ? waklert_format_whatsapp_url($whatsapp_raw) : esc_url($whatsapp_raw ?: home_url('/contact/'));
            $has_contact_details = !empty($footer_address) || !empty($whatsapp_raw) || !empty($footer_email) || !empty($working_days) || !empty($office_hours);
            ?>

            <?php if ($has_contact_details): ?>
            <div class="mt-4 space-y-3.5">
                <?php if (!empty($footer_address)): ?>
                <div class="flex items-start gap-3 text-[13px] text-ink-foreground/80">
                    <?= waklert_content_icon('footer_icon_71853b0e8d') ?>
                    <span><?= esc_html($footer_address) ?></span>
                </div>
                <?php endif; ?>

                <?php if (!empty($whatsapp_raw)): ?>
                <div class="flex items-center gap-3 text-[13px] text-ink-foreground/80">
                    <?= waklert_content_icon('footer_icon_d2539dece7') ?>
                    <span><?= esc_html(waklert_option_text('footer_whatsapp_label')) ?> <?= esc_html(waklert_content('footer_text_5a971de8a2')) ?></span>
                    <a href="<?= esc_url($whatsapp) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/40 px-2.5 py-0.5 text-xs font-bold text-emerald-300 hover:bg-emerald-500/30 transition-colors">
                        <?= waklert_content_icon('footer_icon_8f34b67158') ?>
                        <span><?= esc_html(waklert_option_text('footer_chat_button_text')) ?></span>
                    </a>
                </div>
                <?php endif; ?>

                <?php if (!empty($footer_email)): ?>
                <div class="flex items-center gap-3 text-[13px] text-ink-foreground/80">
                    <?= waklert_content_icon('footer_icon_94ee377a9c') ?>
                    <a href="mailto:<?= esc_attr($footer_email) ?>" class="hover:text-white transition-colors"><?= esc_html($footer_email) ?></a>
                </div>
                <?php endif; ?>

                <?php if (!empty($working_days)): ?>
                <div class="flex items-center gap-3 text-[13px] text-ink-foreground/80">
                    <?= waklert_content_icon('footer_icon_9f7ddb75ab') ?>
                    <span><strong class="text-white font-medium"><?= esc_html(waklert_option_text('working_days_label')) ?></strong> <?= esc_html($working_days) ?></span>
                </div>
                <?php endif; ?>

                <?php if (!empty($office_hours)): ?>
                <div class="flex items-center gap-3 text-[13px] text-ink-foreground/80">
                    <?= waklert_content_icon('footer_icon_fd4c2a4372') ?>
                    <span><strong class="text-white font-medium"><?= esc_html(waklert_option_text('office_hours_label')) ?></strong> <?= esc_html($office_hours) ?></span>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($payment_images) && is_array($payment_images)) : ?>
                <?php if (!empty($payments_heading)): ?>
                <h3 class="text-[15px] font-bold text-white mb-3 mt-8" style="color: #fff !important">
                    <?= esc_html($payments_heading) ?>
                </h3>
                <?php endif; ?>
                <div class="w-fit max-w-full rounded-2xl border-2 border-dashed border-white/15 bg-white/5 p-4 flex items-center gap-5 flex-wrap">
                    <?php foreach ($payment_images as $pay) : 
                        $img_src = '';
                        if (!empty($pay['image'])) {
                            if (is_array($pay['image'])) {
                                $img_src = $pay['image']['url'] ?? '';
                            } elseif (is_numeric($pay['image'])) {
                                $img_src = wp_get_attachment_image_url($pay['image'], 'full');
                            } elseif (is_string($pay['image'])) {
                                $img_src = $pay['image'];
                            }
                        }
                        if (!$img_src) continue;
                        $alt_val = !empty($pay['alt_text']) ? $pay['alt_text'] : (is_array($pay['image']) ? ($pay['image']['alt'] ?? $pay['image']['title'] ?? waklert_content('footer_text_808c622899')) : waklert_content('footer_text_808c622899'));
                    ?>
                        <img src="<?= esc_url($img_src) ?>" alt="<?= esc_attr($alt_val) ?>" class="footer-payment-logo object-contain h-8 sm:h-9 w-auto hover:scale-105 transition-transform" style="height: 34px; max-height: 36px; width: auto; max-width: 160px; object-fit: contain;">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($shipping_images) && is_array($shipping_images)) : ?>
                <?php if (!empty($shipping_heading)): ?>
                <h3 class="text-[15px] font-bold text-white mb-3 mt-8" style="color: #fff !important">
                    <?= esc_html($shipping_heading) ?>
                </h3>
                <?php endif; ?>
                <div class="w-fit max-w-full rounded-2xl border-2 border-dashed border-white/15 bg-white/5 p-4 flex items-center gap-5 flex-wrap">
                    <?php foreach ($shipping_images as $ship) : 
                        $img_src = '';
                        if (!empty($ship['image'])) {
                            if (is_array($ship['image'])) {
                                $img_src = $ship['image']['url'] ?? '';
                            } elseif (is_numeric($ship['image'])) {
                                $img_src = wp_get_attachment_image_url($ship['image'], 'full');
                            } elseif (is_string($ship['image'])) {
                                $img_src = $ship['image'];
                            }
                        }
                        if (!$img_src) continue;
                        $alt_val = !empty($ship['alt_text']) ? $ship['alt_text'] : (is_array($ship['image']) ? ($ship['image']['alt'] ?? $ship['image']['title'] ?? waklert_content('footer_text_e735f72b09')) : waklert_content('footer_text_e735f72b09'));
                    ?>
                        <img src="<?= esc_url($img_src) ?>" alt="<?= esc_attr($alt_val) ?>" class="footer-shipping-logo object-contain h-10 sm:h-11 w-auto hover:scale-105 transition-transform" style="height: 40px; max-height: 44px; width: auto; max-width: 150px; object-fit: contain;">
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
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
            <?php if (!empty($copyright_text)): ?>
                <p><?= wp_kses_post($copyright_text) ?></p>
            <?php else: ?>
                <p><?= esc_html(waklert_content('footer_text_c68dc600b1')) ?> <?= esc_html(date('Y')) ?> <?= esc_html(get_bloginfo('name') ?: waklert_content('footer_text_580af76bd8')) ?><?= esc_html(waklert_content('footer_text_8431a25d58')) ?></p>
            <?php endif; ?>
            <?php if (function_exists('is_product') && is_product()): ?>
                <a href="https://www.flaticon.com/uicons" class="transition-colors hover:text-white" target="_blank" rel="noopener noreferrer"><?= esc_html(waklert_option_text('icon_credit_text')) ?></a>
            <?php endif; ?>
        </div>
    </div>
</footer>

<script>console.log("🚀 InstaWP Auto-Deploy is fully operational!");</script>
<?php wp_footer(); ?>
</body>
</html>
