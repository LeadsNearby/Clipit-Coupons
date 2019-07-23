<article class="clipit-coupon">
    <?php include 'coupon-title.php';?>
    <span class="clipit-coupon__subtitle"><?php esc_html(the_excerpt());?></span>
    <span class="clipit-coupon__spacer"></span>
    <span class="clipit-coupon__expiration"></span>
    <span class="clipit-coupon__act"></span>
    <a class="clipit-coupon__button" href="<?php the_permalink();?>">View Details</a>
</article>
