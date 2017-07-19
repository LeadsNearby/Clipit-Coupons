<?php
add_action("admin_menu" , "coupon_email_settings");
function coupon_email_settings() {
	add_submenu_page("edit.php?post_type=coupon", "ClipIt Email Submissions", "Email Submissions", "edit_posts", basename(__FILE__), "clipit_email_results");
}
function clipit_email_results() { global $title;
	
	if (current_user_can( update_plugins )):
	
	global $wpdb;
	$customers = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}clipit_email_table ORDER BY time DESC LIMIT 0 , 30 ");
	//print_r($customers);
	
        echo "<div id='ClipitEmailData'>";
	echo "<table id='clipit-email-list'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>DATE / TIME SUBMITTED</th>";
    echo "<th>CUSTOMER NAME</th>";
    echo "<th>EMAIL ADDRESS<br></th>";
	echo "<th>PHONE NUMBER</th>";
    echo "</tr>";	
    echo "</thead>";	
    echo "</tbody>";	
	foreach($customers as $customer){
	echo "<tr>";
	echo "<td>".$customer->time."</td>";	
	echo "<td>".$customer->name."</td>";
	echo "<td>".$customer->email."</td>";
	echo "<td>".$customer->phone."</td>";
	echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
        echo "</div>";
        echo "<a href='#' style='margin-top:15px' class='export button-primary'>Export Table data into Excel</a>";
	else:
	echo "Sorry, only admin users can view this information";
	endif;
	
} ?>