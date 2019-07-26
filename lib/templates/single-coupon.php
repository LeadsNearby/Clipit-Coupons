<?php
/*
Template Name: Coupons Single
 */
get_header();
wp_enqueue_script('coupon-commons');
wp_enqueue_style('clipit-styles');
wp_enqueue_style('clipit-print-styles');

echo '<div id="clipit" class="clipit-coupons clipit-coupons--single">';

$coupons_fineprint_general = get_option('clipit_fineprint_default', '');

if (have_posts()):
    while (have_posts()): the_post();
        $post_id = get_the_ID();
        $coupon_expiration = get_post_meta($post_id, 'coupon_expiration', true);
        $coupons_fineprint_meta = get_post_meta($post_id, 'coupon_fineprint', true);
        $coupon_fineprint = $coupons_fineprint_meta ? $coupons_fineprint_meta : $coupons_fineprint_general;
        $coupon_shorts = get_post_meta($post_id, 'coupon_shorts', true);
        $coupon_css_class = get_post_meta($post_id, 'coupon_css_class', true);
        $unix_coupon_expiration = strtotime($coupon_expiration . ' 11:59 pm');
        if (empty($coupon_expiration) || $unix_coupon_expiration > current_time('timestamp')) {
            include 'parts/coupon-single.php';
            $print = true;
            echo '<div class="clipit-print-modal" hidden>';
            include 'parts/coupon-single.php';
            echo '</div>';
            unset($print);
        } else {
            echo "<h3>Sorry, this coupon expired on {$coupon_expiration}</h3>";
        }
    endwhile;
endif;

echo '</div>';
get_footer();
