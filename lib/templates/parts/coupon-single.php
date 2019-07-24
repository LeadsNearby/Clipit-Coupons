<article class="clipit-coupon clipit-coupon--single">
    <?php include 'coupon-title.php';?>
    <span class="clipit-coupon__subtitle"><?php esc_html(the_excerpt());?></span>
    <?php include 'coupon-expiration.php';?>
    <span class="clipit-coupon__fine">
        <?php echo $coupon_fineprint; ?>
    </span>
</article>
<a class="clipit-coupon__button clipit-coupon__button--single" href="<?php the_permalink();?>">View Details</a>
