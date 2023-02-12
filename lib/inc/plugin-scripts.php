<?php
// ClipIt Scripts and Style
add_action('wp_enqueue_scripts', 'clipit_plugin_scripts');
function clipit_plugin_scripts()
{
    wp_register_script('coupon-commons', plugins_url('js/coupon-commons.js', __FILE__), array(), null, true);
    wp_register_style('clipit-styles', plugins_url('css/clipit-styles.css', __FILE__));
    wp_enqueue_style('clipit-styles');

    wp_enqueue_style('clipit-gbp-styles', plugins_url('css/clipit-gbp-styles.css', __FILE__));

    wp_register_style('print', plugins_url('print/print.min.css', __FILE__));
    wp_register_script('print', plugins_url('print/print.min.js', __FILE__), array(), null, true);
}

function enqueuing_admin_scripts()
{
    wp_enqueue_style('clipit-gbp-styles', plugins_url('css/clipit-gbp-styles.css', __FILE__));
}

add_action('admin_enqueue_scripts', 'enqueuing_admin_scripts');
