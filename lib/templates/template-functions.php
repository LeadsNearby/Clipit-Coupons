<?php
// Template Functions
	// Adds Template files when plugin is activated.
	add_filter( 'template_include', 'coupon_template_function', 1 );
	function coupon_template_function( $template_path ) {
		if ( get_post_type() == 'coupon' ) {			
			if ( is_single() ) {
				// checks if the file exists in the theme first,
				// otherwise serve the file from the plugin
				if ( $theme_file = locate_template( array ( 'single-coupon.php' ) ) ) {
					$template_path = $theme_file;
				} else {
					$template_path = plugin_dir_path( __FILE__ ) . 'single-coupon.php';
				}
			}
			// Will be used in later versions!
			//if ( is_single() ) {
				// checks if the file exists in the theme first,
				// otherwise serve the file from the plugin
				//if ( $theme_comments_file = locate_template( array ( 'clipit-comments.php' ) ) ) {
					//$comments_path = $theme_comments_file;
				//} else {
					//$comments_path = plugin_dir_path( __FILE__ ) . 'clipit-comments.php';
				//}
			//}
			if ( is_archive() ) {
				// checks if the file exists in the theme first,
				// otherwise serve the file from the plugin
				if ( $theme_file = locate_template( array ( 'taxonomy-locations.php' ) ) ) {
					$template_path = $theme_file;
				} else {
					$template_path = plugin_dir_path( __FILE__ ) . 'taxonomy-locations.php';
				}
			}
		}
		return $template_path;
	}
?>