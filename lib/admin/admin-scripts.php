<?php
// ClipIt Admin Scripts
add_action('admin_enqueue_scripts', 'clipit_admin_scripts');
function clipit_admin_scripts() {
    /* Register our script. */
    if (is_admin()) {
        wp_enqueue_media();
        wp_enqueue_script('jquery');
        wp_register_script('coupon-admin-commons', plugins_url('js/coupon-admin-commons.js', __FILE__));
        wp_enqueue_script('coupon-admin-commons');
        wp_enqueue_script('jquery-cookie', plugins_url('js/jquery.cookie.js', __FILE__));
        wp_enqueue_script('jquery-cookie');
        wp_enqueue_script('jquery-ui-accordion');
        wp_enqueue_script('jquery-ui-tabs');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('farbtastic');
        /* Register Admin Styles */
        wp_register_style('jquery-ui-style', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css');
        wp_enqueue_style('jquery-ui-style');
        wp_register_style('coupon-admin-styles', plugins_url('css/coupon-admin-styles.css', __FILE__));
        wp_enqueue_style('coupon-admin-styles');
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('farbtastic');
        wp_enqueue_style('thickbox');
    }
}
