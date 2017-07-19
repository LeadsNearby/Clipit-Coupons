<?php
//Dashboard Widgets	
    //Coupons Expired
    function clipit_expired_db() {
    ?>
    <div id="expired-coupons" class="activity-block">
    <h4>Expired Coupons</h4> 
        <ol>
            <?php
			global $post;
            $args = array(
                'numberposts' => 10,
                'post_type' => 'coupon',
				'order' => 'DESC',
				'orderby' => 'meta_value',
				'meta_key' => 'coupon_expiration'
            );		
            $myposts = get_posts( $args );
            foreach( $myposts as $post ) : setup_postdata($post);
			$exp = get_post_meta($post->ID, 'coupon_expiration', true);
			$exp_date = strtotime($exp);
			if(time() > $exp_date) { ?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><span class="expired"><?php echo $exp ?></span></li>
			<?php } endforeach; ?>
        </ol>		
    </div>   
    <?php
    }
    function add_clipit_expired_db() {
        wp_add_dashboard_widget( 'clipit_expired_db', __( 'ClipIt Coupons Expired' ), 'clipit_expired_db' );
    }
    add_action('wp_dashboard_setup', 'add_clipit_expired_db' );
    //Recent ClipIt Conversions
    function clipit_conversion_db() {
    ?>
    <div id="conversions-coupons" class="activity-block">
    <h4>Conversions</h4>   
        <ol>
            <?php
			global $post;
            $args = array(
                'numberposts' => 10,
                'post_type' => 'coupon',
				'meta_key' => 'link_click_counter',
				'order' => 'DESC',
				'orderby' => 'meta_value_num'
            );		
            $myposts = get_posts( $args );
            foreach( $myposts as $post ) : setup_postdata($post);
            $count = get_post_meta( $post->ID, 'link_click_counter', true );
			$post_view_count = get_post_meta($post->ID, 'post_views_count', true );
			$conversions = $count / $post_view_count;
			$conversion_total = $conversions * 100;
            ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><span><?php echo round($conversion_total, 2); ?>% Conversion Rate </span></li>
            <?php endforeach; ?>
        </ol>
    </div>   
    <?php
    }
    function add_clipit_conversion_db() {
        wp_add_dashboard_widget( 'clipit_conversion_db', __( 'ClipIt Coupons Conversion Rate' ), 'clipit_conversion_db' );
    }
    add_action('wp_dashboard_setup', 'add_clipit_conversion_db' );
	//Recent ClipIt Clicks
	function clipit_recent_clicks_db() {
	?>
	<div id="clicked-coupons" class="activity-block">
	<h4>Top 10 Coupon Clicks</h4>	
		<ol>
			<?php
			global $post;
			$args = array( 
				'numberposts' => 10,
				'post_type' => 'coupon',
				'meta_key' => 'link_click_counter',
				'orderby' => 'meta_value_num'
			);
			$myposts = get_posts( $args );
			foreach( $myposts as $post ) : setup_postdata($post); 
			$count = get_post_meta( $post->ID, 'link_click_counter', true );
			?>
			<li><span><?php echo $count ?> Button Clicks</span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; ?>
		</ol>
	</div>	
	<?php
	}
	function add_clipit_recent_clicks_db() {
		wp_add_dashboard_widget( 'clipit_recent_clicks_db', __( 'Top 10 ClipIt Coupon Clicks' ),'clipit_recent_clicks_db' );
	}
	add_action('wp_dashboard_setup', 'add_clipit_recent_clicks_db' );
	//Recent ClipIt Coupons
	function clipit_recent_coupons_db() {
	?>
	<div id="published-posts" class="activity-block">
	<h4>Recently Published Coupons</h4>	
		<ul>
			<?php
			global $post;
			$args = array( 
				'numberposts' => 5,
				'post_type' => 'coupon'
			);
			$myposts = get_posts( $args );
			foreach( $myposts as $post ) : setup_postdata($post); ?>
			<li><span><?php the_time('M jS, g:i a') ?></span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php edit_post_link('EDIT', '<span class="coupon-edit">', '</span>'); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>	
	<?php
	}
	function add_clipit_recent_coupons_db() {
		wp_add_dashboard_widget( 'clipit_recent_coupons_db', __( 'Recent ClipIt Coupons' ), 'clipit_recent_coupons_db' );
	}
	add_action('wp_dashboard_setup', 'add_clipit_recent_coupons_db' );
	//ClipIt Coupon Views
	function clipit_views_db() {
	?>
	<div id="popular-coupons" class="activity-block">
	<h4>Top 10 Most Viewed Coupons</h4>		
		<ol>
			<?php
			global $post;
			$args = array( 
				'meta_key' => 'post_views_count',
				'numberposts' => 10,
				'orderby' => 'meta_value_num',
				'order' => 'DESC',
				'post_type' => 'coupon'
			);			
			$myposts = get_posts( $args );
			foreach( $myposts as $post ) : setup_postdata($post); ?>
			<li><span><?php echo getCoupontViews(get_the_ID()); ?></span><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endforeach; ?>
		</ol>
	</div>	
	<?php
	}
	function add_clipit_views_db() {
		wp_add_dashboard_widget( 'clipit_views_db', __( 'Top 10 Most Viewed Coupons' ), 'clipit_views_db' );
	}
	add_action('wp_dashboard_setup', 'add_clipit_views_db' );
?>