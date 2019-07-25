<?php
/*
Template Name: Coupons Single
 */
get_header();
wp_enqueue_style('clipit-styles');
wp_enqueue_style('clipit-print-styles');

echo '<div id="clipit" class="clipit-coupons clipit-coupons--single">';

if (have_posts()):
    while (have_posts()): the_post();
        $post_id = get_the_ID();
        $coupon_expiration = get_post_meta($post_id, 'coupon_expiration', true);
        $coupon_fineprint = get_post_meta($post_id, 'coupon_fineprint', true) ? get_post_meta($post_id, 'coupon_fineprint', true) : get_option('clipit_fineprint_default', '');
        $coupon_shorts = get_post_meta($post_id, 'coupon_shorts', true);
        $coupon_css_class = get_post_meta($post_id, 'coupon_css_class', true);
        $unix_coupon_expiration = strtotime($coupon_expiration . ' 11:59 pm');
        include 'parts/coupon-single.php';
    endwhile;
endif;

echo '</div>';
get_footer();
