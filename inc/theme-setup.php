<?php
/**
 * Theme Setup & Registration
 */

function modmy_theme_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // WooCommerce support
    add_theme_support('woocommerce');

    // Register Navigation Menus
    register_nav_menus(array(
        'primary'       => __('Primary Menu', 'waklert-australia'),
        'mobile_cities' => __('Mobile Cities Grid', 'waklert-australia'),
        'footer_quick'  => __('Footer Quick Links', 'waklert-australia'),
        'footer_info'   => __('Footer Information', 'waklert-australia'),
        'footer_trending' => __('Footer Trending Products', 'waklert-australia'),
        'footer_cities' => __('Footer Delivery Cities', 'waklert-australia'),
    ));

    // HTML5 markup support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
}
add_action('after_setup_theme', 'modmy_theme_setup');

/**
 * Register Custom Post Types
 */
function modmy_register_cpt() {
    // Reviews CPT
    register_post_type('review', array(
        'labels' => array(
            'name' => 'Reviews',
            'singular_name' => 'Review',
            'add_new_item' => 'Add New Review'
        ),
        'public' => true,
        'has_archive' => false,
        'supports' => array('title'), // ACF will handle the rest
    ));
}
add_action('init', 'modmy_register_cpt');

/**
 * Add Tailwind CSS classes to Navigation Menus
 */
add_filter('nav_menu_css_class', function($classes, $item, $args, $depth = 0) {
    if (isset($args->theme_location)) {
        if ($args->theme_location === 'primary') {
            $is_mobile = isset($args->menu_class) && strpos($args->menu_class, 'flex flex-col') !== false;
            $has_children = in_array('menu-item-has-children', $classes);

            if ($is_mobile) {
                $classes[] = 'w-full list-none';
                if ($has_children) {
                    $classes[] = 'has-submenu';
                }
            } else {
                $classes[] = 'list-none';
                if ($has_children && $depth === 0) {
                    $classes[] = 'relative group';
                }
            }
        } elseif ($args->theme_location === 'mobile_cities') {
            $classes[] = 'list-none';
        }
    }
    return $classes;
}, 10, 4);

add_filter('nav_menu_link_attributes', function($atts, $item, $args, $depth = 0) {
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        $is_mobile = isset($args->menu_class) && strpos($args->menu_class, 'flex flex-col') !== false;

        if ($is_mobile) {
            if ($depth === 0) {
                // Mobile Menu Root Link
                $atts['class'] = (isset($atts['class']) ? $atts['class'] . ' ' : '') . 'flex-1 block px-6 py-3 text-[20px] font-semibold text-slate-800 hover:bg-stone-50 hover:text-primary transition-colors';
            } else {
                // Mobile Menu Sub-item Link
                $atts['class'] = (isset($atts['class']) ? $atts['class'] . ' ' : '') . 'flex items-center justify-between w-full px-4 py-2.5 text-[15px] font-medium text-foreground/85 hover:text-primary hover:bg-white rounded-xl transition-colors';
            }
        } else {
            if ($depth === 0) {
                // Desktop Root Menu Link
                $classes = 'inline-flex items-center px-3.5 xl:px-4 py-2 text-[17.5px] font-semibold rounded-full transition-all duration-200';
                $item_classes = (array) $item->classes;
                $is_current = in_array('current-menu-item', $item_classes) || $item->current || in_array('current-page-ancestor', $item_classes);
                if ($is_current) {
                    $classes .= ' bg-primary-softer text-primary';
                } else {
                    $classes .= ' text-foreground/80 hover:bg-primary-softer hover:text-primary';
                }
                $atts['class'] = (isset($atts['class']) ? $atts['class'] . ' ' : '') . $classes;
            } else {
                // Desktop Submenu Dropdown Link
                $atts['class'] = (isset($atts['class']) ? $atts['class'] . ' ' : '') . 'flex items-center justify-between w-full px-3.5 py-2 text-[14.5px] font-semibold text-foreground/80 hover:text-primary hover:bg-primary-softer/70 rounded-xl transition-colors whitespace-nowrap';
            }
        }
    } elseif (isset($args->theme_location) && $args->theme_location === 'mobile_cities') {
        $atts['class'] = (isset($atts['class']) ? $atts['class'] . ' ' : '') . 'text-sm text-[#62847A] hover:text-primary transition-colors block py-1.5 font-medium';
    } elseif (isset($args->theme_location) && strpos($args->theme_location, 'footer_') !== false) {
        $atts['class'] = (isset($atts['class']) ? $atts['class'] . ' ' : '') . 'hover:text-primary transition-colors';
    }
    return $atts;
}, 10, 4);

add_filter('nav_menu_submenu_css_class', function($classes, $args, $depth = 0) {
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        if (!in_array('sub-menu', $classes)) {
            $classes[] = 'sub-menu';
        }
    }
    return $classes;
}, 10, 3);

add_filter('walker_nav_menu_start_el', function($item_output, $item, $depth, $args) {
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        $item_classes = (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $item_classes);
        $is_mobile = isset($args->menu_class) && strpos($args->menu_class, 'flex flex-col') !== false;

        if ($has_children && $depth === 0) {
            if ($is_mobile) {
                $chevron_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4.5 h-4.5 pointer-events-none transition-transform duration-200"><path d="m6 9 6 6 6-6"/></svg>';
                $toggle_button = sprintf(
                    '<button type="button" class="mobile-submenu-toggle flex items-center justify-center w-9 h-9 mr-6 rounded-xl bg-surface border border-border/70 text-foreground/70 hover:text-primary hover:bg-primary-softer hover:border-primary/40 transition-all focus:outline-none shrink-0" aria-expanded="false" aria-label="%s">%s</button>',
                    esc_attr(sprintf(__('Toggle %s submenu', 'waklert-australia'), $item->title)),
                    $chevron_svg
                );
                $item_output = '<div class="flex items-center justify-between w-full">' . $item_output . $toggle_button . '</div>';
            } else {
                $desktop_chevron = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="inline-block ml-1.5 w-3.5 h-3.5 opacity-60 group-hover:opacity-100 group-hover:rotate-180 transition-transform duration-200"><path d="m6 9 6 6 6-6"/></svg>';
                $item_output = str_replace('</a>', $desktop_chevron . '</a>', $item_output);
            }
        } elseif ($depth > 0 && $is_mobile) {
            $arrow_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 opacity-40 shrink-0"><path d="m9 18 6-6-6-6"/></svg>';
            $item_output = str_replace('</a>', $arrow_svg . '</a>', $item_output);
        }
    }
    return $item_output;
}, 10, 4);

