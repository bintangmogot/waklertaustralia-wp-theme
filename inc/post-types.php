<?php
/**
 * Custom Post Types
 */

function modmy_register_post_types() {
    // 1. Reviews CPT
    $review_labels = array(
        'name'                  => 'Reviews',
        'singular_name'         => 'Review',
        'menu_name'             => 'Reviews',
        'name_admin_bar'        => 'Review',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Review',
        'new_item'              => 'New Review',
        'edit_item'             => 'Edit Review',
        'view_item'             => 'View Review',
        'all_items'             => 'All Reviews',
        'search_items'          => 'Search Reviews',
        'not_found'             => 'No reviews found.',
    );

    $review_args = array(
        'labels'             => $review_labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'review' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-star-filled',
        'supports'           => array( 'title', 'editor' ),
    );

    register_post_type( 'review', $review_args );

    // 2. Cities CPT
    $city_labels = array(
        'name'                  => 'Australia Delivery',
        'singular_name'         => 'City',
        'menu_name'             => 'Australia Delivery',
        'name_admin_bar'        => 'City',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New City',
        'new_item'              => 'New City',
        'edit_item'             => 'Edit City',
        'view_item'             => 'View City',
        'all_items'             => 'All Cities',
        'search_items'          => 'Search Cities',
        'not_found'             => 'No cities found.',
    );

    $city_args = array(
        'labels'             => $city_labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => false, // city URLs sit at the site root (/sydney/); see routing below
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-location',
        'supports'           => array( 'title', 'thumbnail' ),
    );

    register_post_type( 'city', $city_args );
}
add_action( 'init', 'modmy_register_post_types' );

/**
 * City landing pages live at the site root: /sydney/ (was /buy-modafinil/sydney/).
 * The post type has no rewrite rules of its own, so the root URL is resolved here.
 * A normal page with the same slug always wins over a city.
 */
add_filter( 'post_type_link', function ( $link, $post ) {
    if ( $post->post_type === 'city' && $post->post_name !== '' && $post->post_status === 'publish' ) {
        return home_url( user_trailingslashit( $post->post_name ) );
    }
    return $link;
}, 10, 2 );

add_filter( 'request', function ( $query_vars ) {
    // A root URL arrives as pagename (pages) or name (posts), depending on the matched rule.
    $slug = $query_vars['pagename'] ?? ( empty( $query_vars['post_type'] ) ? ( $query_vars['name'] ?? '' ) : '' );
    if ( $slug === '' || strpos( $slug, '/' ) !== false || get_page_by_path( $slug, OBJECT, array( 'page', 'post', 'product' ) ) ) {
        return $query_vars;
    }

    $city = get_page_by_path( $slug, OBJECT, 'city' );
    if ( ! $city || $city->post_status !== 'publish' ) {
        return $query_vars;
    }

    unset( $query_vars['pagename'] );
    $query_vars['post_type'] = 'city';
    $query_vars['city']      = $city->post_name;
    $query_vars['name']      = $city->post_name;
    return $query_vars;
} );

// 301: old /buy-modafinil/{city}/ -> /{city}/ ; cities that are not published (Draft) -> shop page
add_action( 'template_redirect', function () {
    global $wp;
    $path = (string) $wp->request;
    $slug = '';
    if ( preg_match( '#^buy-modafinil/([^/]+)/?$#', $path, $m ) ) {
        $slug = sanitize_title( $m[1] );
    } elseif ( is_404() && preg_match( '#^([^/]+)/?$#', $path, $m ) ) {
        $slug = sanitize_title( $m[1] );
    }
    if ( $slug === '' ) {
        return;
    }

    $city = get_page_by_path( $slug, OBJECT, 'city' );
    if ( $city && $city->post_status === 'publish' ) {
        if ( strpos( $path, 'buy-modafinil/' ) === 0 ) {
            wp_safe_redirect( get_permalink( $city ), 301 );
            exit;
        }
        return;
    }

    // Draft / private city: send visitors and search engines to the shop page.
    $drafted = get_posts( array(
        'post_type'      => 'city',
        'name'           => $slug,
        'post_status'    => array( 'draft', 'pending', 'private', 'future' ),
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ) );
    if ( $drafted ) {
        wp_safe_redirect( function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' ), 301 );
        exit;
    }
}, 1 );
