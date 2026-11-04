<?php
/**
 * Module: Delivery Cities (Shipping Across Australia)
 * Follows the colorful card design rules:
 * - Multi-color vibrant vector icons
 * - 2-tone card structure (White card with navy/sky accents & green ETA tags)
 * - Dashed borders
 * - Patterned gradient background
 * - Lift & arrow animations
 */

if (waklert_module_is_empty()) { return; }

$tag = waklert_content('content_delivery_cities_text_3305a71b68');
$heading = waklert_content('content_delivery_cities_text_325dceca94');
$desc = waklert_content('content_delivery_cities_text_8466514c20');

$cities_field = get_sub_field('cities');
?>
<section class="section-padding bg-gradient-to-b from-[#f0f6fa] via-[#e9f2f8] to-[#f8fafc] bg-pattern-dots border-t-2 border-dashed border-sky-200/80 relative isolate overflow-hidden" data-testid="city-spotlight">
    <div class="container-custom relative z-10">
        <!-- Section Header -->
        <div class="text-center max-w-3xl mx-auto mb-10 md:mb-12">
            <?php if (waklert_has_content(esc_html($tag))): ?><span class="inline-flex items-center gap-2 bg-sky-100 text-[#0c4161] border border-sky-300 text-xs font-black uppercase tracking-widest px-4 py-1.5 rounded-full mb-3 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-[#0c4161] animate-pulse-subtle"></span>
                <?= esc_html($tag) ?>
            </span><?php endif; ?>
            <?php if (waklert_has_content(esc_html($heading))): ?><h2 class="font-heading text-2xl md:text-4xl font-black text-ink tracking-tight mb-3">
                <?= esc_html($heading) ?>
            </h2><?php endif; ?>
            <?php if (waklert_has_content(esc_html($desc))): ?><p class="text-sm md:text-base text-muted-foreground max-w-xl mx-auto leading-relaxed">
                <?= esc_html($desc) ?>
            </p><?php endif; ?>
        </div>

        <!-- Featured Cities Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
            <?php 
            $featured_list = [];
            if (!empty($cities_field) && is_array($cities_field)) {
                foreach ($cities_field as $c) {
                    $pid = is_object($c) ? $c->ID : $c;
                    $featured_list[] = $pid;
                }
            }

            // If less than 6 featured, fetch more cities to make a complete vibrant grid
            if (count($featured_list) < 6) {
                $additional = get_posts([
                    'post_type'      => 'city',
                    'posts_per_page' => 6 - count($featured_list),
                    'post__not_in'   => $featured_list,
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC'
                ]);
                foreach ($additional as $add_p) {
                    $featured_list[] = $add_p->ID;
                }
            }

            if (!empty($featured_list)):
                foreach ($featured_list as $city_id):
                    $city_post = get_post($city_id);
                    if (!$city_post) continue;

                    $days = get_post_meta($city_id, 'delivery_days', true) ?: '2-4';
                    $region = get_post_meta($city_id, 'region', true) ?: waklert_content('content_delivery_cities_text_cd860d6d29');
                    $city_name = get_post_meta($city_id, 'city_name', true);
                    if (!$city_name) {
                        $city_name = str_replace(['Armodafinil Delivery to ', 'Buy Modafinil in ', 'Buy Modafinil '], '', $city_post->post_title);
                    }
                    $permalink = get_permalink($city_id);
            ?>
            <a href="<?= esc_url($permalink) ?>" class="group flex items-center justify-between gap-4 bg-white border-2 border-dashed border-sky-300/80 hover:border-[#0c4161] rounded-2xl p-5 hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 ease-out shadow-xs">
                <div class="flex items-center gap-3.5 min-w-0">
                    <!-- Colorful Location Pin Icon -->
                    <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-100 flex items-center justify-center shrink-0 shadow-inner transform transition-transform duration-300 group-hover:scale-110">
                        <?= waklert_content_icon('content_delivery_cities_icon_f127e0cdd4') ?>
                    </div>
                    <div class="truncate">
                        <?php if (waklert_has_content(esc_html($city_name))): ?><h3 class="font-heading font-black text-ink text-base md:text-[17px] group-hover:text-[#0c4161] transition-colors truncate">
                            <?= esc_html($city_name) ?>
                        </h3><?php endif; ?>
                        <p class="text-xs text-muted-foreground flex items-center gap-1.5 mt-0.5">
                            <?php if (waklert_has_content(esc_html($region))): ?><span class="font-semibold text-slate-700"><?= esc_html($region) ?></span><?php endif; ?>
                            <?php if (waklert_has_content(esc_html(waklert_content('content_delivery_cities_text_7149dbb192')))): ?><span class="text-slate-300"><?= esc_html(waklert_content('content_delivery_cities_text_7149dbb192')) ?></span><?php endif; ?>
                            <?php if (waklert_has_content(esc_html($days)) || waklert_has_content(esc_html(waklert_content('content_delivery_cities_text_e351a5e638')))): ?><span class="inline-flex items-center gap-1 font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full text-[10px]">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <?= esc_html($days) ?> <?= esc_html(waklert_content('content_delivery_cities_text_e351a5e638')) ?>
                            </span><?php endif; ?>
                        </p>
                    </div>
                </div>
                <!-- Animated Chevron -->
                <div class="w-8 h-8 rounded-full bg-slate-50 group-hover:bg-[#0c4161] group-hover:text-white flex items-center justify-center shrink-0 text-slate-400 transition-colors duration-300">
                    <?= waklert_content_icon('content_delivery_cities_icon_d7fd697c4d') ?>
                </div>
            </a>
            <?php 
                endforeach;
            endif; 
            ?>
        </div>

        <!-- Regional & Remote Towns Pill Grid -->
        <div class="text-center pt-2">
            <?php if (waklert_has_content(esc_html(waklert_content('content_delivery_cities_text_f4b39cf6ee')))): ?><span class="inline-block text-xs font-black uppercase tracking-wider text-slate-500 mb-3"><?= esc_html(waklert_content('content_delivery_cities_text_f4b39cf6ee')) ?></span><?php endif; ?>
            <div class="flex flex-wrap justify-center gap-2 max-w-4xl mx-auto">
                <?php 
                $all_cities = get_posts([
                    'post_type'      => 'city',
                    'posts_per_page' => 18,
                    'post__not_in'   => $featured_list,
                    'orderby'        => 'menu_order',
                    'order'          => 'ASC'
                ]);
                foreach($all_cities as $c):
                    $city_name = get_post_meta($c->ID, 'city_name', true);
                    if (!$city_name) {
                        $city_name = str_replace(['Armodafinil Delivery to ', 'Buy Modafinil in ', 'Buy Modafinil '], '', $c->post_title);
                    }
                ?>
                <?php if ((waklert_has_content(esc_html($city_name))) && waklert_has_content(get_permalink($c->ID))): ?><a href="<?= get_permalink($c->ID) ?>" class="text-xs border border-dashed border-sky-300/80 bg-white text-slate-700 font-bold px-3.5 py-1.5 rounded-full hover:bg-[#0c4161] hover:text-white hover:border-[#0c4161] transition-all duration-200 shadow-2xs hover:-translate-y-0.5">
                    <?= esc_html($city_name) ?> <?= waklert_content_icon('manual_check_marker') ?>
                </a><?php endif; ?>
                <?php endforeach; ?>
                <?php if (waklert_has_content(esc_html(waklert_content('content_delivery_cities_text_19bfbe3620')))): ?><span class="text-xs border border-dashed border-amber-300 bg-amber-50 text-amber-900 font-bold px-3.5 py-1.5 rounded-full shadow-2xs">
                    <?= esc_html(waklert_content('content_delivery_cities_text_19bfbe3620')) ?>
                </span><?php endif; ?>
            </div>
        </div>
    </div>
</section>
