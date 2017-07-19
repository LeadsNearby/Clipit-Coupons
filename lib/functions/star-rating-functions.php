<?php
if ( ! defined('ABSPATH')) exit; // if direct access 
function star_rating_record()
	{	
		$starvalue = (int)$_POST['starvalue'];
		$data_id = (int)$_POST['data_id'];		
		$totalstarvalue = get_post_meta( $data_id, 'totalstarvalue', true );
		if(empty($totalstarvalue)) $totalstarvalue = 0;
		$starvalue = $starvalue + $totalstarvalue;
		update_post_meta( $data_id, 'totalstarvalue', $starvalue );
		$totalstarcount = get_post_meta( $data_id, 'totalstarcount', true );
		if(empty($totalstarcount)) $totalstarcount = 0;
		$totalstarcount += 1;
		update_post_meta( $data_id, 'totalstarcount', $totalstarcount );	
		$rate =$starvalue/$totalstarcount;
		if($rate>5)
			{
				$rate = 5;
			}
		echo number_format($rate, 2);
		die();
	}
add_action('wp_ajax_star_rating_record', 'star_rating_record');
add_action('wp_ajax_nopriv_star_rating_record', 'star_rating_record');
function star_rating_dark_color($input_color)
	{
		if(empty($input_color))
			{
				return "";
			}
		else
			{
				$input = $input_color;
				$col = Array(
					hexdec(substr($input,1,2)),
					hexdec(substr($input,3,2)),
					hexdec(substr($input,5,2))
				);
				$darker = Array(
					$col[0]/2,
					$col[1]/2,
					$col[2]/2
				);
				return "#".sprintf("%02X%02X%02X", $darker[0], $darker[1], $darker[2]);
			}
	}