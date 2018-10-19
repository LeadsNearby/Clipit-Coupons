<?php
/*
Plugin Name: ClipIt Coupons
Plugin URI: http://leadsnearby.com
Description: ClipIt Coupons is a basic but powerful plugin that uses to create, upload and preview coupons for your visitors to print, view or use directly on your website or blog. With a few words and and even fewer clicks you will be on your way to displaying awesome coupons on your website or blog.
Version: 2.0.0
Author: LeadsNearby
Author URI: http://leadsnearby.com
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

// Include the TGM_Plugin_Activation class.
require_once ClipIt_INSTALLER . '/class-tgm-plugin-activation.php';

// Load Admin Scripts and Css
require_once ClipIt_ADMIN . '/admin-scripts.php';

// Load Plugin Scripts and Css
require_once ClipIt_INCLUDES . '/plugin-scripts.php';

// Load Plugin Widgets
require_once ClipIt_INCLUDES . '/widgets.php';

// Load Custom Post Type Functions
require_once ClipIt_FUNCTIONS . '/post-types.php';

// Load Custom META Box Functions
require_once ClipIt_FUNCTIONS . '/meta-box.php';

// Load Template Functions
require_once ClipIt_TEMPLATES . '/template-functions.php';

// Load Theme Functions
require_once ClipIt_FUNCTIONS . '/clipit-functions.php';

// Load Custom Shortcodes
require_once ClipIt_SHORTCODES . '/clipit-shortcode.php';

// Load Email Functions
//require_once(ClipIt_EMAIL . '/client/client_email.php');

// Load Admin Interface
require_once ClipIt_ADMIN . '/admin-docs.php';

// Load Admin Settings
require_once ClipIt_ADMIN . '/admin-settings.php';

// Load Activate Settings
require_once ClipIt_ADMIN . '/admin-activate.php';

// Load Admin Functions
require_once ClipIt_ADMIN . '/admin-functions.php';

// Load Admin Emails
require_once ClipIt_ADMIN . '/admin-emails.php';

require_once ClipIt_MAIN . 'lib/updater/github-updater.php';
new GitHubPluginUpdater(__FILE__, 'LeadsNearby', 'Clipit-Coupons');
