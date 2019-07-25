<?php the_content();?>
<article class="clipit-coupon clipit-coupon--single">
    <?php include 'coupon-title.php';?>
    <span class="clipit-coupon__subtitle"><?php esc_html(the_excerpt());?></span>
    <?php include 'coupon-expiration.php';?>
    <span class="clipit-coupon__fine">
        <?php echo $coupon_fineprint; ?>
    </span>
</article>
<a class="clipit-coupon__button clipit-coupon__button--single" href="javascript:window.print()">
    Print Coupon
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400 264c-13.25 0-24 10.74-24 24 0 13.25 10.75 24 24 24s24-10.75 24-24c0-13.26-10.75-24-24-24zm32-88V99.88c0-12.73-5.06-24.94-14.06-33.94l-51.88-51.88c-9-9-21.21-14.06-33.94-14.06H110.48C93.64 0 80 14.33 80 32v144c-44.18 0-80 35.82-80 80v128c0 8.84 7.16 16 16 16h64v96c0 8.84 7.16 16 16 16h320c8.84 0 16-7.16 16-16v-96h64c8.84 0 16-7.16 16-16V256c0-44.18-35.82-80-80-80zM128 48h192v48c0 8.84 7.16 16 16 16h48v64H128V48zm256 416H128v-64h256v64zm80-112H48v-96c0-17.64 14.36-32 32-32h352c17.64 0 32 14.36 32 32v96z"/></svg>
</a>
<?php
if ($coupon_shorts):
    echo '<h3 class="clipit-schedule-title">Schedule Service</h3>';
    echo do_shortcode($coupon_shorts);
endif;