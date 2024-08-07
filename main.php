<?php
/*
Plugin Name: ClipIt Coupons
Plugin URI: https://leadsnearby.com
Description: ClipIt Coupons is a basic but powerful plugin that uses to create, upload and preview coupons for your visitors to print, view or use directly on your website or blog. With a few words and and even fewer clicks you will be on your way to displaying awesome coupons on your website or blog.
Version: 3.0
Author: LeadsNearby
Author URI: https://leadsnearby.com
License: GPLv2
 */

// Define Directory Constants
define('ClipIt_MAIN', plugin_dir_path(__FILE__));
define('ClipIt_LIB', ClipIt_MAIN . '/lib');
define('ClipIt_ADMIN', ClipIt_LIB . '/admin');
define('ClipIt_INCLUDES', ClipIt_LIB . '/inc');
define('ClipIt_SHORTCODES', ClipIt_LIB . '/shortcodes');
define('ClipIt_FUNCTIONS', ClipIt_LIB . '/functions');
define('ClipIt_TEMPLATES', ClipIt_LIB . '/templates');
define('ClipIt_INSTALLER', ClipIt_LIB . '/installer');
define('ClipIt_EMAIL', ClipIt_LIB . '/email');

// Load Admin Scripts and Css
require_once ClipIt_ADMIN . '/admin-scripts.php';

// Load Plugin Scripts and Css
require_once ClipIt_INCLUDES . '/plugin-scripts.php';

// Load Custom Post Type Functions
require_once ClipIt_FUNCTIONS . '/post-types.php';

// Load Custom META Box Functions
require_once ClipIt_FUNCTIONS . '/meta-box.php';

add_filter('template_include', 'coupon_template_function', 1);
function coupon_template_function($template_path) {
    if (get_post_type() == 'coupon') {
        if (is_single()) {
            $template_path = plugin_dir_path(__FILE__) . 'lib/templates/single-coupon.php';
        }
        if (is_archive()) {
            $template_path = plugin_dir_path(__FILE__) . 'lib/templates/archive-coupon.php';
        }
    }
    return $template_path;
}

// Load Theme Functions
require_once ClipIt_FUNCTIONS . '/clipit-functions.php';

// Load Custom Shortcodes
require_once ClipIt_SHORTCODES . '/clipit-shortcode.php';
require_once ClipIt_SHORTCODES . '/clipit-rotator-shortcode.php';

add_action('wp_enqueue_scripts', function () {
    wp_register_style('clipit-rotator', plugin_dir_url(__FILE__) . '/lib/inc/css/clipit-rotator.css', array(), null);
    wp_register_script('clipit-rotator-js', plugin_dir_url(__FILE__) . '/lib/inc/js/coupon-rotator.js', array(), null, true);
});

// Load Admin Settings
require_once ClipIt_ADMIN . '/admin-settings.php';

// Load Admin Functions
require_once ClipIt_ADMIN . '/admin-functions.php';
