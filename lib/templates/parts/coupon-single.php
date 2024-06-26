<?php
wp_enqueue_script('print');
wp_enqueue_style('print');
$classes = array(
    'clipit-coupon',
    'clipit-coupon--single',
);
?>
<?php the_content();?>
<?php $accent_color = get_option('clipit_accent_color');?>
<article class="<?php echo implode($classes, ' '); ?>" <?php if (!empty($accent_color)) {echo 'style="--color-accent:', $accent_color, '"';}?>>
    <span class="clipit-coupon__icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path d="M263.39 256L445.66 73.37c3.12-3.12 3.12-8.19 0-11.31-18.74-18.74-49.14-18.74-67.88 0L223.82 216.35l-43.1-43.18C187.92 159.71 192 144.33 192 128c0-53.02-42.98-96-96-96S0 74.98 0 128s42.98 96 96 96c16.31 0 31.66-4.07 45.11-11.24L184.26 256l-43.15 43.24C127.66 292.07 112.31 288 96 288c-53.02 0-96 42.98-96 96s42.98 96 96 96 96-42.98 96-96c0-16.33-4.08-31.71-11.28-45.17l43.1-43.18 153.95 154.29c18.74 18.74 49.14 18.74 67.88 0 3.12-3.12 3.12-8.19 0-11.31L263.39 256zM96 176c-26.47 0-48-21.53-48-48s21.53-48 48-48 48 21.53 48 48-21.53 48-48 48zm0 256c-26.47 0-48-21.53-48-48s21.53-48 48-48 48 21.53 48 48-21.53 48-48 48z"/>
        </svg>
    </span>
    <?php include 'coupon-title.php';?>
    <span class="clipit-coupon__subtitle"><?php esc_html(the_excerpt());?></span>
    <?php if(get_post_meta(get_the_ID(), 'coupon_fb_like', true) == 'yes') { ?>
    <div class="clipit-coupon__fblike">
        <iframe src="https://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>%2F&width=219&layout=button_count&action=recommend&size=large&share=true&height=46&appId=221733661184896" width="219" height="46" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
    </div>
    <?php } ?>
    <?php include 'coupon-expiration.php';?>
    <span class="clipit-coupon__fine">
        <span>
			<?php 
			if (!empty($coupon_fineprint)) {
				echo wp_strip_all_tags($coupon_fineprint);
			} else {
				echo 'To redeem, call, or request an appointment on our website and mention this coupon. The offer is valid for one-time use only. It is not redeemable for cash, not valid toward previous purchases, and must be requested while making the appointment. The offer may not be combined with other coupons, discounts, offers, or promotions. This offer is not valid on customer-supplied items';
			}
			?>
		</span>
        <?php include 'coupon-logo.php';?>
    </span>
</article>
<?php if (empty($print)): ?>
<a class="clipit-coupon__button clipit-coupon__button--print clipit-coupon__button--single" href="javascript:window.print()">
    Print Coupon
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M400 264c-13.25 0-24 10.74-24 24 0 13.25 10.75 24 24 24s24-10.75 24-24c0-13.26-10.75-24-24-24zm32-88V99.88c0-12.73-5.06-24.94-14.06-33.94l-51.88-51.88c-9-9-21.21-14.06-33.94-14.06H110.48C93.64 0 80 14.33 80 32v144c-44.18 0-80 35.82-80 80v128c0 8.84 7.16 16 16 16h64v96c0 8.84 7.16 16 16 16h320c8.84 0 16-7.16 16-16v-96h64c8.84 0 16-7.16 16-16V256c0-44.18-35.82-80-80-80zM128 48h192v48c0 8.84 7.16 16 16 16h48v64H128V48zm256 416H128v-64h256v64zm80-112H48v-96c0-17.64 14.36-32 32-32h352c17.64 0 32 14.36 32 32v96z"/></svg>
</a>
<?php endif;?>
<?php
if ($coupon_shorts):
    echo '<h3 class="clipit-schedule-title">Schedule Service</h3>';
    echo stripslashes(do_shortcode($coupon_shorts));
endif;