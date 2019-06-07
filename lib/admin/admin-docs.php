<?php
add_action("admin_menu", "coupon_admin_settings");
function coupon_admin_settings() {
    add_submenu_page("edit.php?post_type=coupon", "ClipIt Coupons Documentation", "Documentation", "edit_posts", basename(__FILE__), "coupons_doc");
}
function coupons_doc() {global $title;?>
	<h2><?php echo $title; ?></h2>
	<p>ClipIt Coupons is a powerful plugin that uses wordpress custom post types to create coupons for your visitors to view, print or use directly on your website. With a few words and and even fewer clicks you will be on your way to displaying awesome coupons on your website or blog.</p>
	<h3>Getting Started</h3>
	<p>If you are reading this then you successfully added the plugin to your WordPress theme or blog so there is no need to go over that. Let jump straight to the fun stuff.</p>
	<div id="accordion" class="clipit-docs">
		<h3>Getting Started</h3>
		<div>
			<div class="alignleft"><strong>Flush your Permalinks</strong> - Because Clipit uses custom post types to generate the coupons it may be necessary to flush your permalinks in order to get them to appear on the site. Flushing your permalinks is easy, simply go to Settings > Permalinks and you are done. You dont have to make any changes, just visting the Permalinks page will flush the permalinks.</div>
			<div class="alignright example refresh-permalinks"></div>
			<div class="clear"></div>
			<div><strong>Clip it Admin Settings</strong> - ClipIt Coupons comes with a built in admin settings area where you can modify the color, style, and typography of your coupons. You can also apply default Rules, and Fine Print for your coupons.</div>
			<hr />
			<div class="clear"></div>
			<div class="alignleft"><strong>General Settings</strong> - In the General Settings tab you can create predefined Rules and Fine Print for all of your coupons.
				<ul class="bullets">
					<li><strong>Expired Coupon Text</strong> - You can set default text for any coupon that has expired. If a visitor bookmarks a coupon from your site and it has expired the customer can see the message that you post here. If no message a posted here a default message of "Sorry, the (Coupon Title) coupon expired on (Expiration Date)"</li>
					<li><strong>The Rules Default Content</strong> - You can enter any default rules you have. These rules will be displayed on every coupon created. Note: These settings will be overridden if you place any content in the Rules fields in the individual coupons.</li>
					<li><strong>The Fine Print Default Content</strong> - You can enter any default fine print you have. The fine print will be displayed on every coupon created. Note: These settings will be overridden if you place any content in the FIne Print fields in the individual coupons.</li>
					<li><strong>Print Logo</strong> - Add your logo here to include it in the printable coupon.</li>
					<li><strong>Email to Claim Coupon</strong> - Enter the contact email address to receive notifications of when someone enters their contact information to claim a coupon.<br /> Got multiple email addresses? Separate each with a comma and space i.e., test@test.com, test@test.com</li>
				</ul>
			</div>
			<div class="alignright example settings-general"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Styling Options</strong> - You can select the colors you would like to have on your coupons here. You can set background colors, and text colors.<br />
			<strong>Coupon Banner Options</strong> - You can now select to have a coupon banner appear on every page of your wordpress website. You can also upload a coupon image and assign a height, width and position.
			</div>
			<div class="alignright example settings-styles"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Typography Options</strong> - You can close to 40 different fonts you can choose for your coupons. You can also set what size your fonts can be here.</div>
			<div class="alignright example settings-typography"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Custom CSS Options</strong> - Want more control over your coupons. You can now use CSS to style them however you like.</div>
			<div class="alignright example settings-css"></div>
			<div class="clear"></div>
			<div><strong>Locations</strong> - If you have multiple locations. Then using the locations feature is a great way to let your potential customers know where they can use your awesome coupons. Once locations are entered a map for each location will appear on the single coupon page </div>
			<hr />
			<div class="alignleft"><strong>Adding Locations</strong> - Adding locations to your coupons is easy, just follow the instructions below.
				<ol>
					<li>Enter the name of the city</li>
					<li>Enter the slug of city. Don't know what this is. Don't worry it isnt required and WordPress will take care of it for you.</li>
					<li>Enter the Phone number to the location</li>
					<li>Enter the Street Address to the location</li>
					<li>Enter the City to the location</li>
					<li>Enter the State number to the location</li>
					<li>Enter the Zip Code number to the location</li>
					<li>You can add any additional information in the description box.</li>
				</ol>
			</div>
			<div class="alignright example locations"></div>
			<div class="clear"></div>
		</div>
		<h3>Coupon Configuration</h3>
		<div>
			<div class="alignleft"><strong>Step 1</strong> - Start by going to the Clipit Coupons Tab and selecting Add New Coupon</div>
			<div class="alignright example step-one"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Step 2</strong> - Start by entering the title for your coupon then move to the Coupon Theme section.
				<ul>
					<li><strong>Coupon Type</strong> - Select whether you want to upload a coupon or build one.</li>
					<li><strong>Coupon Style</strong> - If you chose to build your coupon then you can select one of two coupon styles.</li>
					<li><strong>Coupon Action</strong> - Select what action you would like your coupon to take when a user clicks on it.</li>
					<li><strong>Coupon Expiration</strong> - Choose a date (a calendar will appear when you click in the field) you would like your coupon will expire.</li>
					<li><strong>Display Expiration Date</strong> - By default the expiration date will not appear. Selecting this option will display the expiration date on the coupon.</li>
					<li><strong>Main Coupon Image</strong> - Upload the main coupon image you would like to use.</li>
					<li><strong>Sidebar Coupon Image</strong> - Upload the coupon image you would like to use on sidebar widgets.</li>
					<li><strong>Destination URL</strong> - Enter the URL you want your coupon to redirect to once it is clicked on.</li>
					<li><strong>Social Sharing</strong> - Check to enable social sharing on your coupon.</li>
					<li><strong>Email to Claim Coupon</strong> - Check to enable the quick email to claim form on your coupon.</li>
					<li><strong>Featured Coupon</strong> - Check to enable the Featured Coupon Banner</li>
					<li><strong>Display Coupon Views</strong> - Check to see how many people have viewed the coupon</li>
					<li><strong>Display Coupon Comments</strong> - Check to see how many comments have posted for this coupon</li>
				</ul>
				<p><strong>If Upload is selected only the following fields will be available to you:</strong></p>
				<ul>
					<li>Coupon Action</li>
					<li>Destination URL</li>
					<li>Display Expiration Date</li>
					<li>Coupon Expiration</li>
					<li>Replace coupon image with QRCode during printing</li>
					<li>Social Sharing</li>
					<li>Email to Claim Coupon</li>
				</ul>
			</div>
			<div class="alignright example step-two"></div>
			<div class="clear"></div>
			<div class="alignleft">
				<p><strong>If Build is selected only the follow fields will be available to you:</strong></p>
				<ul>
					<li>Coupon Style</li>
					<li>Coupon Action</li>
					<li>Destination URL</li>
					<li>Display Expiration Date</li>
					<li>Coupon Expiration</li>
					<li>Dynamic Expiration</li>
					<li>Replace coupon image with QRCode during printing</li>
					<li>Featured Coupon</li>
					<li>Display Coupon Views</li>
					<li>Display Coupon Comments</li>
				</ul>
			</div>
			<div class="alignright example step-two-a"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Step 3</strong> - Coupon Information
				<ul>
					<li><strong>Coupon Code / Promo Code</strong> - Enter your Coupon or Promo Code here. This will appear if you select "Promo Code Display" or partially appear if you select "Promo Code Peel" from the Coupon Actions drop down</li>
					<li><strong>Coupon Name</strong> - Enter the name of your coupon - for internal use only.</li>
					<li><strong>Title</strong> - Enter the title of the coupon.</li>
					<li><strong>Description</strong> - Enter a short description of the coupon</li>
					<li><strong>The Fine Print</strong> - Enter your fine print here.</li>
					<li><strong>Promo Text</strong> - If you selected "Promo Code Peel" from the Coupon Actions dropdown this text will appear in the modal that opens up to display the promo code.</li>
					<li><strong>Custom Button Text</strong> - Enter in the custom text for your coupon button.</li>
				</ul>
			</div>
			<div class="alignright example step-three"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Step 4</strong> - Adding Tags
				<p>In order to group coupons for use in the shortcode you will need to assign your coupon tags. You can assign multiple tags if you like. When used with the shortcode tags allow you to group any coupon you like as long as they share the same tag. Please use the tag slug when applying to your shortcode.</p>
			</div>
			<div class="alignright example step-five"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Step 5</strong> - Locations.
				<p>Select what locations a person can redeem your coupon at.</p>
			</div>
			<div class="alignright example step-six"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Step 6</strong> - Discounts.
				<p><strong>Actual Value</strong> - Enter the actual dollar value of the service or item (no symbols). Ex: 25</p>
				<p><strong>Savings</strong> - Enter the dollar amount someone would be saving (no symbols). Ex: 50</p>
			</div>
			<div class="alignright example discount-step"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Step 7</strong> - How To Use.
				<p>Insert one instruction per line for how to use. It will appear as a numbered list online. HTML can be used in this step.</p>
			</div>
			<div class="alignright example step-seven"></div>
			<div class="clear"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Step 8</strong> - The Rules.
				<p>Enter any restrictions not specified in the Fine Print. HTML can be used in this step.</p>
			</div>
			<div class="alignright example step-eight"></div>
			<div class="clear"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Step 9</strong> - Featured Image.
				<p>Insert an image to be used with your coupon. The image should be 225px x 250px</p>
			</div>
			<div class="alignright example step-nine"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Step 10</strong> - Contact Form Shorcode.
				<p>Insert the shortcode from your favorite contact form to have it appear on the single-coupon.php page.</p>
			</div>
			<div class="alignright example step-ten"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Step 11</strong> - Coupon QR Code.
				<p>Once you save your newly created coupon a QR will be created and stored in this area. It will also appear on the single-coupon page.</p>
			</div>
			<div class="alignright example step-eleven"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Step 12</strong> - Scheduling Your Coupons.
				<p>Your coupons by default are set to published once you create them. However if you would like to schedule your coupons to start at a later date, you can now do that by changing the publish date in the Publish area (located on the top right side) during coupon creation.</p>
				<p>Changing the date on your coupon is easy, simply click on the edit button next to the Current Publish date and select the Month, Day, and Year that you would like your coupon to start. You can even enter in a time (24hr) that you would like the coupon to appear.</p>
			</div>
			<div class="alignright example step-tweleve"></div>
			<div class="clear"></div>
		</div>
		<h3>Importing Coupons</h3>
		<div>
			<p>ClipIt now allows you to import your coupons in a .csv file. After you install ClipIt you will have the option to install the Really Simple CSV Importer. Please activate this if you would like to import your coupons using our pre-filled .csv file.</p>
			<p><strong>Instructions</strong> - Once ClipIt has been downloaded, extract the zip file and you will see a file called csv-importer. This file contains our pre-defined / pre-filled .csv file. You can use this as your guide to building your coupons. Note: DO NOT DELETE THE HEADERS! The CSV importer depends on these headers to place your information in the correct place</p>
			<strong>Available Column Name and Values</strong>
			<ul>
				<li><strong>post_author</strong>: (login or ID) The user name or user ID number of the author.</li>
				<li><strong>post_date</strong>: (string) The time of publish date.</li>
				<li><strong>post_title</strong>: (string) The title of the post.</li>
				<li><strong>post_status</strong>: ('draft' or 'publish' or 'pending') The status of the post. 'draft' is default.</li>
				<li><strong>post_name</strong>: (string) The slug of the post.</li>
				<li><strong>post_type</strong>: For the purpose of ClipIt Coupons the default is 'coupon'.</li>
				<li><strong>post_thumbnail</strong>: (string) The uri or path of the Featured Image. E.g. <a target="_blank" href="http://example.com/example.jpg">http://example.com/example.jpg</a> or /path/to/example.jpg</li>
				<li><strong>post_tags</strong>: (string, comma separated) name of tags</li>
				<li><strong>tax_locations</strong>: (string, comma separated) Locations must already exist. Entries are names or slugs of locations.</li>
				<li><strong>coupon_type</strong>: (string) ('build' or 'upload')</li>
				<li><strong>coupon_main_upload</strong>: (string) The uri or path of the Main Couponn Upload. E.g. <a target="_blank" href="http://example.com/main-coupon-upload.jpg">http://example.com/main-coupon-upload.jpg</a> or /path/to/main-coupon-upload.jpg</li>
				<li><strong>coupon_sidebar_upload</strong>: (string) The uri or path of the Sidebar Couponn Upload. E.g. <a target="_blank" href="http://example.com/main-coupon-upload.jpg">http://example.com/main-coupon-upload.jpg</a> or /path/to/main-coupon-upload.jpg</li>
				<li><strong>coupon_action</strong>: (string) ('destination url' or 'print page' or 'promo code display' or 'promo code peel')</li>
				<li><strong>coupon_expiration</strong>: (string) Enter the date the coupon expires.</li>
				<li><strong>coupon_destination_url</strong>: (string) If the coupon_action is 'destination url' then you need to place a URL here (http://example.com).</li>
				<li><strong>coupon_social</strong>: (boolean) Choose to activate the social icons on the coupon page. ('yes' or 'no')</li>
				<li><strong>coupon_email</strong>: (boolean) Choose to activate Email to Claim Coupon on the coupon page. ('yes' or 'no')</li>
				<li><strong>coupon_feature</strong>: (boolean) Choose to activate the Feature Image Banner on the coupon page. ('yes' or 'no')</li>
				<li><strong>coupon_views</strong>: (boolean) Choose to activate Coupon Views on the coupon page. ('yes' or 'no')</li>
				<li><strong>coupon_comments</strong>: (boolean) Choose to activate Comments on the coupon page. ('yes' or 'no')</li>
				<li><strong>coupon_promo_code</strong>: (string) Enter the Promo Code you would like to use.</li>
				<li><strong>coupon_name</strong>: (string) Enter the Coupon Name (for internal purposes only).</li>
				<li><strong>coupon_savings</strong>: (string) Enter the saving amount</li>
				<li><strong>coupon_title</strong>: (string) Enter the Title of the Coupon (This will appear as the title of the coupon)</li>
				<li><strong>coupon_description</strong>: (string) Enter the description for the coupon</li>
				<li><strong>coupon_fineprint</strong>: (string) Enter the fine print for the coupon</li>
				<li><strong>coupon_promo_text</strong>: (string) Enter any additional promotional text</li>
				<li><strong>coupon_how_to</strong>: (string) Enter any how to information</li>
				<li><strong>coupon_rules</strong>: (string) Enter the coupon rules</li>
				<li><strong>coupon_shorts</strong>: (string) Insert any form shortcode here.</li>
			</ul>
			<p>Once you have filled in the csv file with your coupons. You will need to import the file. Below are a few instructions on how to do that.</p>
			<ol>
				<li>Log into your site's WordPress Admin panel, and go to the Tools tab</li>
				<li>Click Import</li>
				<li>Click on CSV</li>
				<li>Make sure your .csv file meets the requirements. If you just changed the values then you should be fine.</li>
				<li>Choose the .csv file from your computer and upload it.</li>
				<li>Once this is successful, you can now see your coupons in the ClipIt Coupons Tab.</li>
			</ol>
		</div>
		<h3>Shortcode Configuration</h3>
		<div>
			<p>ClipIt Coupons allows you to place coupons anywhere you like on your site by using the WordPress shortcode feature. Below we will go over what the shortcode can do.</p>
			<p><strong>How to include ClipIt Coupons on your site</strong></p>
			<p>Simply paste the shortcode below on the page or widget you want to display the coupon(s)</p>
			<p class="clipit-docs-code">[clipit_coupons columns="3" number_posts="9" post_id="" sidebar="" show_title="" show_desc="" show_featured="" show_exp="" show_fine="yes" show_img="" show_views="" tag="projects" trim_desc="" show_discount="" show_comments="" show_countdown=""]</p>
			<p>You can also include the shortcode into your PHP by pasting the code below:</p>
			<p class="clipit-docs-code">&lt;?php echo do_shortcode('[clipit_coupons columns="3" number_posts="9" post_id="" sidebar="" show_title="" show_desc="" show_featured="" show_exp="" show_fine="yes" show_img="" show_views="" tag="projects" trim_desc="" show_discount="" show_comments="" show_countdown=""]') ?&gt;</p>
			<p><strong>Definitions</strong></p>
			<ul>
				<li><strong>columns</strong> - How many columns do you want to display coupons in. Values: 1-4 (Default Value: 1)</li>
				<li><strong>number_posts</strong> - How many coupons you want to appear. If trying to display only one coupon this should be set to 1.  (Default Value: 1)</li>
				<li><strong>post_id</strong> - Show a specific coupon based on Post ID</li>
				<li><strong>sidebar</strong> - Specify whether or not the shortcode will appear in a widget. Values: Yes/No</li>
				<li><strong>show_desc</strong> - Display Description on Coupon. Values: Yes/No (Default Value: Yes)</li>
				<li><strong>show_featured</strong> - Display Featured Banner on Coupon. Values: Yes/No</li>
				<li><strong>show_fine</strong> - Display Fine Print on Coupon. Values: Yes/No (Default Value: Yes)</li>
				<li><strong>show_img</strong> - Display the Featured Image on the Coupon. Values: Yes/No (Default Value: Yes)</li>
				<li><strong>show_title</strong> - Display the Coupon Title. Values: Yes/No (Default Value: Yes)</li>
				<li><strong>show_exp</strong> - Display the Coupon Expiration. Values: Yes/No (Default Value: Yes)</li>
				<li><strong>show_views</strong> - Display the Coupon Views. Values: Yes/No (Default Value: Yes)</li>
				<li><strong>show_comments</strong> - Display the Coupon Comments. Values: Yes/No (Default Value: Yes)</li>
				<li><strong>show_discount</strong> - Display the Cost Savings. Values: Yes/No (Default Value: Yes)</li>
				<li><strong>show_countdown</strong> - Display the Expiration Countdown. Values: Yes/No (Default Value: Yes)</li>
				<li><strong>tag</strong> - Display coupons using a specific tag: (tag="cooking"). Display coupons that have "either" of these tags: (tag="bread, baking"). Display coupons that have "all" of these tags: (tag="bread, baking, recipe")</li>
				<li><strong>trim_desc</strong> - If the value for show_desc is yes then you can select to truncate the description by selecting yes here. . Values: Yes/No</li>
			</ul>
		</div>
		<h3>Reporting</h3>
		<div>
		<?php echo '<img src="' . plugins_url('images/doc/reporting.png', __FILE__) . '" >' ?>
		<p>ClipIt Reports allow you can see which coupons are your most popular and then focus on providing more of the same coupons for your users. The feedback function allows you to see which coupons are working and which ones are not, helping you to keep your site clean as users will quickly leave if the coupons they try do not work.</p>
		<p>ClipIt features 4 different reports that will give you all the information you'll need to put the best coupons out for your customers.</p>
			<ul class="bullets">
				<li><strong>Most Recent Coupons Created</strong> - This will display what coupons were recently created.</li>
				<li><strong>Top 10 Most Viewed Coupons</strong> - This report will show you the 10 most viewed coupons on your site.</li>
				<li><strong>Top 10 Clicked Coupons</strong> - This report will show you the 10 most clicked coupons on your site</li>
				<li><strong>Coupon Conversion Rate</strong> - This report takes the total clicks of a coupon and divides them by the total views to give you the conversion rate of your coupons.</li>
				<li><strong>Expiring Coupons</strong> - This report will show which coupons have now expired.</li>
				</ul>
		</div>
		<h3>Email Submissions</h3>
		<div>
		<p>ClipIt now will store all emails collected from coupons using the email to print function. You can also download the email submissions in .CSV format.</p>
		</div>
	</div>
<?php }?>