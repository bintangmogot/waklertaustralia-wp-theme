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
add_filter('nav_menu_css_class', function($classes, $item, $args) {
    if (isset($args->theme_location)) {
        if ($args->theme_location === 'primary' && isset($args->menu_class) && strpos($args->menu_class, 'flex flex-col') !== false) {
            // Mobile Menu LI
            $classes[] = 'w-full list-none';
        } elseif ($args->theme_location === 'mobile_cities') {
            $classes[] = 'list-none';
        }
    }
    return $classes;
}, 10, 3);

add_filter('nav_menu_link_attributes', function($atts, $item, $args) {
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        if (isset($args->menu_class) && strpos($args->menu_class, 'flex flex-col') !== false) {
            // Mobile Menu Link
            $atts['class'] = (isset($atts['class']) ? $atts['class'] . ' ' : '') . 'block px-6 py-3 text-base font-semibold text-slate-800 hover:bg-stone-50 hover:text-primary transition-colors';
        } else {
            // Desktop Menu Link
            $classes = 'px-4 py-2 text-sm font-semibold rounded-full transition-all duration-200';
            $is_current = in_array('current-menu-item', $item->classes) || $item->current || in_array('current-page-ancestor', $item->classes);
            if ($is_current) {
                $classes .= ' bg-primary-softer text-primary';
            } else {
                $classes .= ' text-foreground/80 hover:bg-primary-softer hover:text-primary';
            }
            $atts['class'] = (isset($atts['class']) ? $atts['class'] . ' ' : '') . $classes;
        }
    } elseif (isset($args->theme_location) && $args->theme_location === 'mobile_cities') {
        $atts['class'] = (isset($atts['class']) ? $atts['class'] . ' ' : '') . 'text-sm text-[#62847A] hover:text-primary transition-colors block py-1.5 font-medium';
    } elseif (isset($args->theme_location) && strpos($args->theme_location, 'footer_') !== false) {
        $atts['class'] = (isset($atts['class']) ? $atts['class'] . ' ' : '') . 'hover:text-primary transition-colors';
    }
    return $atts;
}, 10, 3);
