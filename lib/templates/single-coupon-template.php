<?php

function clipit_render_single_coupon($post, $display = 'single', $to_be_deprecated) {
    extract($to_be_deprecated);
    ob_start();?>
    <article class="lnbCoupon" style="--button-bg: <?php echo $button_bg; ?>; --button-accent: <?php echo $button_accent; ?>">
        <span class="lnbCoupon__icon"><i class="far fa-cut"></i></span>
        <div class="lnbCoupon__content">
            <h2 class="lnbCoupon__title"><?php the_title();?></h2>
            <span class="lnbCoupon__description"><?php the_content();?></span>
            <span class="lnbCoupon__expiration"><?php echo $coupon_expiration ? 'Expires: ' . $coupon_expiration : 'Limited time offer.'; ?></span>
            <?php if($display !== 'multi') { ?>
            <span class="lnbCoupon__finePrint"><?php echo $coupon_fineprint; ?></span>
            <?php } ?>
            <span class="lnbCoupon__image">
                <img src="<?php echo $logo_url; ?>" />
            </span>
        </div>
        <div class="lnbCoupon__actions">
        <?php if($display !== 'multi') { ?>
            <a href="javascript:window.print()" class="lnbCoupon__button">Print Coupon</a>
        <?php } else { ?>
            <a href="<?php echo get_post_permalink($post) ?>" class="lnbCoupon__button">More Details</a>
        <?php } ?>
    </article>
    <?php return ob_get_clean();
}