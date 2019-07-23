<?php
// Template Functions
// Adds Template files when plugin is activated.
add_filter('template_include', 'coupon_template_function', 1);
function coupon_template_function($template_path) {
    if (get_post_type() == 'coupon') {
        if (is_single()) {
            $template_path = plugin_dir_path(__FILE__) . 'single-coupon.php';
        }
        if (is_archive()) {
            $template_path = plugin_dir_path(__FILE__) . 'coupon-archive.php';
        }
    }
    return $template_path;
}
