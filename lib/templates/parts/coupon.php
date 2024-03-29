<?php 
wp_enqueue_style('arvo', 'https://fonts.googleapis.com/css?family=Arvo:700&display=swap');
$coupon_icon = get_post_meta(get_the_ID(), 'coupon_icon', true);
$coupon_pre_text = get_post_meta(get_the_ID(), 'coupon_pre_text', true);
$page_custom_select = get_post_meta(get_the_ID(), 'page_custom_select', true);
$coupon_featured = get_post_meta(get_the_ID(), 'coupon_featured', true);
$coupon_fineprint = get_post_meta(get_the_ID(), 'coupon_fineprint', true);
$raw_title = get_the_title();
$formatted_title = preg_replace('/\s+/', '+', $raw_title);
?>
<article class="clipit-coupon <?php if(($coupon_featured) == 'yes') { echo 'featured'; }?>">
    <div class="clipit-coupon__int">
        <?php if(($coupon_featured) == 'yes') { ?>
            <span class=clipit-coupon__save-wrapper>
                <span class="clipit-coupon__save">Featured</span>
            </span>
        <?php } ?>    
        <?php if(get_post_meta(get_the_ID(), 'coupon_pre_text', true)) { ?>
        <div class="clipit-coupon__pretitle-wrapper">
            <div class="clipit-coupon__title-pre">
                <?php echo $coupon_pre_text; ?>
            </div>
        </div>
        <?php } ?>
        <?php if(get_post_meta(get_the_ID(), 'coupon_icon', true)) { ?>
            <div class="clipit-coupon__asset-wrapper">
                <div class="clipit-coupon__img">
                    <img src="<?php echo plugin_dir_url(dirname(__DIR__)) .'inc/assets/'. $coupon_icon .'.jpg'; ?>" />
                </div>
            </div>
        
        <?php } else if(has_post_thumbnail()) { ?>
            <div class="clipit-coupon__asset-wrapper">
                <div class="clipit-coupon__img">    
                    <?php echo the_post_thumbnail( $post_id, 'thumbnail' ); ?>
                </div>
            </div>
        <?php } ?>

            <div class="clipit-coupon__content-wrapper <?php echo !empty($coupon_icon) || !empty(has_post_thumbnail()) ? 'with-img' : '';?>">

            <?php include 'coupon-title.php';?>
            <span class="clipit-coupon__subtitle"><?php esc_html(the_excerpt());?></span>
            <?php if(get_post_meta(get_the_ID(), 'coupon_fb_like', true) == 'yes') { ?>
            <span class="clipit-coupon__spacer"></span>
            <div class="clipit-coupon__fblike">
                <iframe src="https://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>%2F&width=219&layout=button_count&action=recommend&size=large&share=true&height=46&appId=221733661184896" width="219" height="46" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
            </div>
            <?php } ?>

        <div class="clipit-coupon__footer-wrapper">
            <?php if(get_post_meta(get_the_ID(), 'page_custom_select', true)) { ?>
                <a class="clipit-coupon__button coupon_btn_click" href="<?php the_permalink($page_custom_select);?>?coupon-name=<?php echo $formatted_title; ?>">Get Service</a>
            <?php } else { ?>
                <a class="clipit-coupon__button coupon_btn_click" href="<?php the_permalink();?>">View Details</a>
            <?php } ?>    
            <?php include 'coupon-expiration.php';?>
            <?php if(get_post_meta(get_the_ID(), 'coupon_fineprint_display', true) == 'yes') { ?>
            <div class="clipit-coupon__fine" style="font-size: 12px; margin-top: 10px;">
                <i><?php echo wp_strip_all_tags($coupon_fineprint); ?></1>
            </div>	
            <?php } ?>
        </div>

        </div>
        
    </div>
</article>