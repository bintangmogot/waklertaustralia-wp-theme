<?php
/**
 * Module: Delivery Cities (Shipping Map)
 */

$cities = get_sub_field('cities');

// Do not fall back to the cloned Australia city catalogue. This section will
// appear after Australia delivery locations have been reviewed and selected.
if (empty($cities)) {
    return;
}

$tag = "Australia-wide Delivery";

$heading = get_sub_field('title') ?: "Delivery Across Australia";

$desc = get_sub_field('description') ?: "Delivery options and estimates vary by destination and carrier.";
?>
<section class="section-padding bg-stone-50" data-testid="city-spotlight">
    <div class="container-custom">
        <div class="text-center mb-10">
            <span class="inline-block bg-primary-soft text-primary-dark text-xs font-bold uppercase tracking-widest px-3 py-1.5 rounded-full mb-4">
                <?= $tag ?>
            </span>
            <h2 class="font-heading text-2xl md:text-4xl font-black text-ink mb-3">
                <?= $heading ?>
            </h2>
            <p class="text-muted-foreground max-w-xl mx-auto">
                <?= $desc ?>
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
            <?php 
            if(have_rows('featured_cities')): 
                while(have_rows('featured_cities')): the_row();
                    $name = get_sub_field('city_name');
                    $slug = sanitize_title($name);
            ?>
            <a href="<?= home_url('/buy-modafinil/' . $slug . '/') ?>" class="group flex items-center gap-4 bg-white border border-stone-200 rounded-xl p-5 hover:border-primary hover:shadow-md transition-all">
                <div class="w-12 h-12 rounded-xl bg-primary-dark text-white flex items-center justify-center flex-shrink-0 font-heading font-black text-sm group-hover:bg-primary transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-heading font-bold text-ink group-hover:text-primary-dark transition-colors">
                        <?= $name ?>
                    </h3>
                    <p class="text-xs text-muted-foreground">
                        <?= get_sub_field('region') ?> &middot; <?= get_sub_field('days') ?> <?= "working days" ?>
                    </p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-300 ml-auto group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </a>
            <?php 
                endwhile;
            else:
                // Fallback: Dynamically fetch from the 'city' post type
                $city_query = new WP_Query([
                    'post_type' => 'city',
                    'posts_per_page' => 6,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ]);
                
                if ($city_query->have_posts()):
                    while ($city_query->have_posts()): $city_query->the_post();
                        $days = get_post_meta(get_the_ID(), 'delivery_days', true) ?: '7-9';
                        $region = get_post_meta(get_the_ID(), 'region', true) ?: 'Australia';
                        $city_name = get_post_meta(get_the_ID(), 'city_name', true);
                        if (!$city_name) {
                            $city_name = str_replace(['Buy Modafinil in ', 'Buy Modafinil '], '', get_the_title());
                        }
                        
                        // We can assume standard translations or just use the region field for both if ms isn't provided
            ?>
            <a href="<?= get_permalink() ?>" class="group flex items-center gap-4 bg-white border border-stone-200 rounded-xl p-5 hover:border-primary hover:shadow-md transition-all">
                <div class="w-12 h-12 rounded-xl bg-primary-dark text-white flex items-center justify-center flex-shrink-0 font-heading font-black text-sm group-hover:bg-primary transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-heading font-bold text-ink group-hover:text-primary-dark transition-colors">
                        <?= esc_html($city_name) ?>
                    </h3>
                    <p class="text-xs text-muted-foreground">
                        <?= esc_html($region) ?> &middot; <?= esc_html($days) ?>
                    </p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-300 ml-auto group-hover:text-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            </a>
            <?php 
                    endwhile;
                    wp_reset_postdata();
                endif;
            endif; 
            ?>
        </div>

        <div class="flex flex-wrap justify-center gap-2">
            <?php 
            $more_cities = get_sub_field('more_cities_comma_separated');
            if($more_cities):
                $cities_arr = explode(',', $more_cities);
                foreach($cities_arr as $c):
                    $c = trim($c);
                    if(empty($c)) continue;
                    $slug = sanitize_title($c);
            ?>
            <a href="<?= home_url('/buy-modafinil/' . $slug . '/') ?>" class="text-xs border border-stone-200 text-muted-foreground px-3 py-1.5 rounded-full hover:border-primary hover:text-primary transition-colors">
                <?= esc_html($c) ?>
            </a>
            <?php 
                endforeach;
            else:
                // Dynamically fetch ALL other cities to list as pills
                $all_cities = get_posts([
                    'post_type' => 'city',
                    'posts_per_page' => -1,
                    'offset' => 6, // Skip the first 6 we just featured
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ]);
                foreach($all_cities as $c):
                    $city_name = get_post_meta($c->ID, 'city_name', true);
                    if (!$city_name) {
                        $city_name = str_replace(['Buy Modafinil in ', 'Buy Modafinil '], '', $c->post_title);
                    }
            ?>
            <a href="<?= get_permalink($c->ID) ?>" class="text-xs border border-stone-200 text-muted-foreground px-3 py-1.5 rounded-full hover:border-primary hover:text-primary transition-colors">
                <?= esc_html($city_name) ?>
            </a>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
