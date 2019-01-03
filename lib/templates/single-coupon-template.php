<?php

function clipit_render_single_coupon($post, $display = 'single', $to_be_deprecated) {
    extract($to_be_deprecated);
    ob_start();?>
    <article class="lnbCoupon" data-coupon-id="<?php echo $post->ID; ?>" style="--button-bg: <?php echo $button_bg; ?>; --button-accent: <?php echo $button_accent; ?>">
        <span class="lnbCoupon__icon"><i class="far fa-cut"></i></span>
        <div class="lnbCoupon__content">
            <span class="lnbCoupon__title"><?php the_title();?></span>
            <span class="lnbCoupon__description"><?php the_content();?></span>
            <span class="lnbCoupon__expiration"><?php echo $coupon_expiration ? 'Expires: ' . $coupon_expiration : 'Limited time offer.'; ?></span>
            <?php if($display !== 'multi') { ?>
            <span class="lnbCoupon__finePrint"><?php echo $coupon_fineprint; ?></span>
            <span class="lnbCoupon__image">
                <img src="<?php echo $logo_url; ?>" />
            </span>
            <?php } else { ?>
            <div class="lnbCoupon__actions lnbCoupon__actions--multi">
                <a href="<?php echo get_post_permalink($post) ?>" class="lnbCoupon__button lnbCoupon__button--smaller lnbCoupon__button--fullwidth">More Details</a>
            </div>
            <?php } ?>
        </div>
        <?php if($display !== 'multi') { ?>
        <div class="lnbCoupon__actions">
            <a href="javascript:window.print()" class="lnbCoupon__button">Print Coupon</a>
        </div>
        <?php } ?>
    </article>
    <?php return ob_get_clean();
}