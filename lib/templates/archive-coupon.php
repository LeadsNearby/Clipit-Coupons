<?php

get_header();

echo '<div id="clipit" class="clipit-coupons">';

if (have_posts()): while (have_posts()): the_post();
        include 'parts/coupon.php';
    endwhile;
endif;

echo '</div>';

get_footer();
