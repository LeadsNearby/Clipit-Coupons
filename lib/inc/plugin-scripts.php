<?php
// ClipIt Scripts and Style
add_action('wp_enqueue_scripts', 'clipit_plugin_scripts', 99);
function clipit_plugin_scripts() {
    if (!is_admin()) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-tooltip');
        wp_enqueue_script('jquery-ui-dialog');
        wp_enqueue_script('jquery-ui-tabs');
        wp_register_script('coupon-commons', plugins_url('js/coupon-commons.js', __FILE__), array(), null, true);
        wp_enqueue_script('coupon-commons');
        wp_register_script('g-plusone', 'https://apis.google.com/js/platform.js', array(), null, true);
        wp_enqueue_script('g-plusone');
        // wp_register_script('countdown', plugins_url('js/countdown.js', __FILE__), array(), null, true);
        // wp_enqueue_script('countdown');
        //wp_register_script('jquery.print-preview', plugins_url('js/jquery.print-preview.js',__FILE__));
        //wp_enqueue_script('jquery.print-preview');
        wp_register_style('clipit-styles', plugins_url('css/clipit-styles.css', __FILE__));
        wp_enqueue_style('clipit-styles');
        wp_register_style('jquery-ui-styles', plugins_url('css/jquery-ui.css', __FILE__));
        wp_enqueue_style('jquery-ui-styles');
        wp_register_style('clipit-print-styles', plugins_url('css/clipit-print.css', __FILE__), array(), '', 'print');
        wp_enqueue_style('clipit-print-styles');
        //wp_register_style('clipit-print-preview', plugins_url('css/clipit-preview.css',__FILE__), array(), '', 'print');
        //wp_enqueue_style('clipit-print-preview');
    }
}
