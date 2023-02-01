<?php
// Register Coupon Post Type
add_action('init', 'clipit_coupon');
function clipit_coupon() {
    $labels = array(
        'name' => _x('ClipIt Coupons', 'post type general name'),
        'singular_name' => _x('ClipIt Coupon', 'post type singular name'),
        'add_new' => _x('Add New Coupon', 'Coupon'),
        'add_new_item' => __('Add New Coupon'),
        'edit_item' => __('Edit Coupon'),
        'new_item' => __('New Coupon'),
        'all_items' => __('Manage Coupons'),
        'view_item' => __('View Coupon'),
        'search_items' => __('Search Coupons'),
        'not_found' => __('No Coupons found'),
        'not_found_in_trash' => __('No Coupons found in the Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'ClipIt Coupons',
    );

    register_post_type(
        'coupon',
        array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => false,
            'menu_position' => 15,
            'menu_icon' => 'dashicons-tickets',
            'supports' => array(
                'title',
                'editor',
                'revisions',
                'excerpt',
                'custom-fields',
                'thumbnail',
            ),
            'taxonomies' => array(
                'post_tag',
                'display-category',
            ),
            'show_ui' => true,
            'show_in_menu' => true,
            'publicly_queryable' => true,
            'has_archive' => true,
            'query_var' => true,
            'can_export' => true,
            'rewrite' => array(
                'slug' => 'coupon',
                'with_front' => false,
            ),
            'capability_type' => 'post',
            'show_in_rest' => true,
            'rest_base' => 'coupons',
            'rest_controller_class' => 'WP_REST_Posts_Controller',
        )
    );
}

// Build taxonomies for each post type
add_action('init', 'coupon_display_category');
function coupon_display_category() {
    $labels = array(
        'add_new_item' => __('Add Display Category'),
        'new_item_name' => __('New Display Category'),
        'edit_item' => __('Edit Display Category'),
        'view_item' => __('View Display Category'),
    );
    register_taxonomy(
        'display-category',
        'coupon',
        array(
            'labels' => $labels,
            'public' => true,
            'show_in_nav_menus' => true,
            'hierarchical' => true,
            'label' => 'Display Category',
            'query_var' => true,
            'rewrite' => true,
            'show_in_rest' => true,
            'rest_base' => 'display-category',
        )
    );
}
