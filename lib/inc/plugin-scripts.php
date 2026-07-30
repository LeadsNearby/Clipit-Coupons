<?php
// ClipIt Scripts and Style
add_action('wp_enqueue_scripts', 'clipit_plugin_scripts');
function clipit_plugin_scripts()
{
    // List of templates
    $templates = array('archive-coupon.php', 'single-coupon.php', 'taxonomy-locations.php');

    wp_register_script('coupon-commons', plugins_url('js/coupon-commons.js', __FILE__), array(), null, true);
    wp_register_style('clipit-styles', plugins_url('css/clipit-styles.css', __FILE__));
    wp_register_style('print', plugins_url('print/print.min.css', __FILE__));
    wp_register_script('print', plugins_url('print/print.min.js', __FILE__), array(), null, true);

    $post = get_post();
    $has_coupon_shortcode = (
        is_singular()
        && $post instanceof WP_Post
        && has_shortcode((string) $post->post_content, 'clipit_coupons')
    );
    $is_coupon_view = (
        is_singular('coupon')
        || is_post_type_archive('coupon')
        || is_page_template($templates)
    );

    if ($has_coupon_shortcode || $is_coupon_view) {
        clipit_enqueue_frontend_styles();
    }
}

function clipit_enqueue_frontend_styles()
{
    wp_enqueue_style('clipit-styles');

    if (did_action('wp_head') && !wp_style_is('clipit-styles', 'done')) {
        wp_print_styles('clipit-styles');
    }
}

function enqueuing_admin_scripts()
{
    wp_enqueue_style('clipit-gbp-styles', plugins_url('css/clipit-gbp-styles.css', __FILE__));
}

add_action('admin_enqueue_scripts', 'enqueuing_admin_scripts');

