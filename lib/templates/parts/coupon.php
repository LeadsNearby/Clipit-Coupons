<?php wp_enqueue_style('arvo', 'https://fonts.googleapis.com/css?family=Arvo:700&display=swap');?>
<article class="clipit-coupon">
    <span class=clipit-coupon__save-wrapper>
        <span class="clipit-coupon__save">Save</span>
    </span>
    <?php include 'coupon-title.php';?>
    <span class="clipit-coupon__subtitle"><?php esc_html(the_excerpt());?></span>
    <span class="clipit-coupon__spacer"></span>
    <?php include 'coupon-expiration.php';?>
    <a class="clipit-coupon__button" href="<?php the_permalink();?>">View Details</a>
</article>
