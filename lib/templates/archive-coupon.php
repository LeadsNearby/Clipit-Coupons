<?php

get_header();

echo '<div id="clipit" class="clipit-coupons">';

if (have_posts()): while (have_posts()): the_post();
        $coupon_expiration = get_post_meta(get_the_ID(), 'coupon_expiration', true);
        $unix_coupon_expiration = strtotime($coupon_expiration . ' 11:59 pm');
        if (empty($coupon_expiration) || $unix_coupon_expiration > current_time('timestamp')) {
            include 'parts/coupon.php';
        }
    endwhile;
endif;

echo '</div>';

get_footer();
