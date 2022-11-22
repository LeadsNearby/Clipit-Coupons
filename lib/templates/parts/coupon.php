<?php wp_enqueue_style('arvo', 'https://fonts.googleapis.com/css?family=Arvo:700&display=swap');?>
<article class="clipit-coupon">
    <span class=clipit-coupon__save-wrapper>
        <span class="clipit-coupon__save">Save</span>
    </span>
    <?php include 'coupon-title.php';?>
    <span class="clipit-coupon__subtitle"><?php esc_html(the_excerpt());?></span>
    <?php if(get_post_meta(get_the_ID(), 'coupon_fb_like', true) == 'yes') { ?>
    <div class="clipit-coupon__fblike">
        <iframe src="https://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>%2F&width=219&layout=button_count&action=recommend&size=large&share=true&height=46&appId=221733661184896" width="219" height="46" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
    </div>
    <?php } ?>
    <span class="clipit-coupon__spacer"></span>
    <?php include 'coupon-expiration.php';?>
    <a class="clipit-coupon__button coupon_btn_click" href="<?php the_permalink();?>">View Details</a>
</article>