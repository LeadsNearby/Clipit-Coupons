<?php
// ClipIt Scripts and Style
add_action('wp_enqueue_scripts', 'clipit_plugin_scripts');
function clipit_plugin_scripts()
{
    // List of templates
    $templates = array('archive-coupon.php', 'single-coupon.php', 'taxonomy-locations.php');

    // Check if the current post has the shortcode and is using any of the specified templates
    if (is_singular() && has_shortcode(get_post()->post_content, 'clipit_coupons') || is_page_template($templates)) {
        wp_register_script('coupon-commons', plugins_url('js/coupon-commons.js', __FILE__), array(), null, true);
        wp_register_style('clipit-styles', plugins_url('css/clipit-styles.css', __FILE__));
        wp_enqueue_style('clipit-styles');

        wp_enqueue_style('clipit-gbp-styles', plugins_url('css/clipit-gbp-styles.css', __FILE__));

        wp_register_style('print', plugins_url('print/print.min.css', __FILE__));
        wp_register_script('print', plugins_url('print/print.min.js', __FILE__), array(), null, true);
    }
}

function enqueuing_admin_scripts()
{
    wp_enqueue_style('clipit-gbp-styles', plugins_url('css/clipit-gbp-styles.css', __FILE__));
}

add_action('admin_enqueue_scripts', 'enqueuing_admin_scripts');

