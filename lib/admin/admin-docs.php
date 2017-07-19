<?php
add_action("admin_menu" , "coupon_admin_settings");
function coupon_admin_settings() {
	add_submenu_page("edit.php?post_type=coupon", "ClipIt Coupons Documentation", "Documentation", "edit_posts", basename(__FILE__), "coupons_doc");
}
function coupons_doc() { global $title; ?>
	<h2><?php echo $title;?></h2>
	<p>ClipIt Coupons is a powerful plugin that uses wordpress custom post types to create coupons for your visitors to view, print or use directly on your website. With a few words and and even fewer clicks you will be on your way to displaying awesome coupons on your website or blog.</p>
	<h3>Getting Started</h3>
	<p>If you are reading this then you successfully added the plugin to your WordPress theme or blog so there is no need to go over that. Let jump straight to the fun stuff.</p>
	<div id="accordion" class="clipit-docs">
		<h3>Getting Started</h3>
		<div>
			<div class="alignleft"><strong>Activating Your License Key</strong> - If you purchased the premium version of ClipIt Coupons then you would have also received an activation key right after checkout and via email. Please enter and activate the key here.</div>		
			<div class="alignright example activate"></div>
			<div class="clear"></div>
			<div class="alignleft"><strong>Installing/Activating Additional Plugins</strong> - When you install ClipIt Coupons you will see a prompt that lets you know there a two other plugins that are recommended: Thumbs Rating and Post Types Order. These plugins will further enhance the user experiance when installed.</div>
			<div class="alignright example plugins"></div>
			<div class="clear"></div>
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
					<li><strong>Enable Dynamic Expiration</strong> - This Dynamic Date feature updates everyday so if you choose the “today” option, the expiration will always show that day’s date. This is used in conjunction with the normal Coupon Expiration field.</li>
					<li><strong>Dynamic Expiration + Days:</strong> - If Dynamic Expiration is chosen you can select a number of days the expiration will countdown for after today. Example. Dynamic Expiration + 2 day will result in a -72 hour countdown. If +0 day is selected, the phrase "Expiring Today" will appear.</li>
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
					<li>Dynamic Expiration</li>
					<li>Replace coupon image with QRCode during printing</li>
					<li>Main Coupon Image</li>
					<li>Social Sharing</li>
					<li>Email to Claim Coupon</li>
					<li>Sidebar Coupon Image</li>
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
		<?php echo '<img src="' . plugins_url( 'images/doc/reporting.png', __FILE__ ) . '" >' ?>			
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
		<h3>Change log</h3> 
		<div>
			<strong>Version 1.2.3</strong>				
				<ul class="bullets">	
				        <li>Updated Offer schema has been added to the shortcode and single-coupon template. Users can now insert a custom class to the shortcode. Functions.php has been reduced.</li>				
			                <li><strong>Updated Documentation</strong> - Documentation has been updated</li>
				</ul>
			<strong>Version 1.2.2</strong>				
				<ul class="bullets">	
				        <li><strong>Coupon Banner Added</strong> - Allows for a banner to appear throughout the wordpress site</li>
				        <li><strong>Email Submission Download</strong> - You can now download your email submissions as a CSV file.</li>
				        <li><strong>Related Coupons</strong> - All coupons will now show up to 4 additional coupons as related coupons.</li>				
						<li><strong>Updated Documentation</strong> - Documentation has been updated</li>
				</ul>
		        <strong>Version 1.2.1</strong>				
				<ul class="bullets">	
				        <li><strong>Review Stars Fix</strong></li>
	                        </ul>
		        <strong>Version 1.2.0</strong>				
				<ul class="bullets">	
				        <li><strong>Strip HTML added</strong> - to social sharing description attributes. Commenting has been removed. Custom Font-Size option updated. Shortcode updated to include "show_title" as an option.</li>
                    	        </ul>
			<strong>Version 1.1.4</strong>				
				<ul class="bullets">	
				        <li><strong>Print Coupon Updates</strong> - Updates to the printed coupon appearance</li>
				        <li><strong>Logo field added to General options</strong> - Uploaded logo will appear at the top of the printed coupon.</li>				
					<li><strong>Updated Documentation</strong> - Documentation has been updated</li>
				</ul>			
			<strong>Version 1.1.3</strong>				
				<ul class="bullets">					
					<li><strong>Updated Documentation</strong> - Documentation has been updated</li>
				</ul>
			<strong>Version 1.1.2</strong>				
				<ul class="bullets">					
					<li><strong>Updates to CSS and Widget Area</strong> - The single-coupon.php was updated to remove the sidebar.</li>
				</ul>
			<strong>Version 1.1.1</strong>				
				<ul class="bullets">					
					<li><strong>CSS Updates</strong></li>
				</ul>				
			<strong>Version 1.0.2</strong>				
				<ul class="bullets">					
					<li><strong>Removal of coupon styles</strong> - The ability to choose from multiple coupon appearances has been removed.</li>
					<li><strong>Layout change for single-coupon.php</strong> - The layout for the single-coupon.php has been updated to match standards used by standard group buying sites.</li>
					<li><strong>Dynamic Expiration Countdown</strong> - We are now able to display an actual countdown to the expiration date when standard expirations are used.</li>
					<li><strong>Schema Rich Coupon Aggregate Star Rating</strong> - Clipit now includes Schema Rich Aggregate Star Rating. Users will now be able to rate coupons. These ratings will be picked up by Google because of the structured data that is being used.</li>
					<li><strong>Updated Section Icons</strong> - We have updated to icons in each in each section to provide better definition between sections.</li>
					<li><strong>Directions Link</strong> - Clipit now includes a "Get Directions" link, when clicked it will open a new window allowing viewers to get direction to the location(s) in the coupon.</li>
					<li><strong>Updated Description / Fine Print textareas in Admin</strong> - The Coupon Description and Fine Print areas now include default WordPress WYSIWYG options. Users can format text how they like and have it appear correctly on the coupons.</li>
				</ul>
			<strong>Version 1.0.1</strong>				
				<ul class="bullets">					
					<li><strong>Shortcode button added to Pages and Posts</strong> - A quick add button has been added next to the media button to allow for quick and easy coupon insertion into any page or post.</li>										
				</ul>	     		
			<strong>Version 1.0</strong>				
				<ul class="bullets">					
					<li><strong>ClipIt Coupons sent into the wild</strong> - Initial debut 2/18/2015</li>										
				</ul>		
			<strong>Pre-Release Version 8.5.2</strong>				
			<ul class="bullets">					
				<li><strong>Coupon Styles</strong> - You can now select from 2 different coupon styles.</li>					
				<li><strong>Changes to column lists</strong> - Manage Coupon Column lists have been adjusted to display relevant information more clearly.</li>					
				<li><strong>Updates to Promo Peel popup</strong> - The Promo Peel Popup has been updated to display more information to the customer.</li>					
				<li><strong>Countdown in style #2</strong> - Countdown to the minute is included in the 2nd coupon style.</li>					
				<li><strong>Changes to Email Claim Form</strong> - Typos and errors have been corrected on the Email to Claim Coupon Form.</li>					
				<li><strong>Scheduler Updated</strong> - Coupon scheduler has been updated.</li>					
				<li><strong></strong> - Changes to CSS</li>				
			</ul>			
			<strong>Pre-Release Version 8.5.1</strong>				
				<ul class="bullets">					
					<li><strong>Reporting Updated</strong> - Expired Coupons Report has been added. Now you can see which coupons have expired.</li>					
					<li><strong>Default Coupon Image Added</strong> - A default image has been added in the event that a user does not add a featured image to the coupon in build mode.</li>					
					<li>Small CSS changes</li>				
				</ul>			
			<strong>Pre-Release Version 8.5</strong>				
				<ul class="bullets">					
					<li><strong>JSPDF Updated</strong> - JSPDF function updated.</li>					
					<li><strong>jQuery Update</strong> - Coupon Commons jQuery has been updated to fix a bug with the plugin upload button.</li>				
				</ul>			
			<strong>Pre-Release Version 8.4.2</strong>				
				<ul class="bullets">					
					<li><strong>Email a friend button added to social icon set</strong> - Viewers can now click on the Email a Friend icon to send their friends an email with a link to the coupon.</li>					
					<li><strong>Update to Social Like Buttons</strong> - This version corrects a bug in the Google Plus button when multiple coupons appear on the same page or post.</li>				
				</ul>			
			<strong>Pre-Release Version 8.4.1</strong>				
				<ul class="bullets">					
					<li><strong>Shortcodes Updates</strong> - Four new shortcode attributes added. Now you can show/hide title, expiration, views, and comments.</li>					
					<li><strong>Updates to Google Maps Embed API</strong> - Updates have made to the Google Maps API to include responsive capabilities.</li>					
					<li><strong>CSS Changes</strong> - Changes have been made to the CSS to accomodate for the changes to the Google Maps API</li>					
					<li><strong>Sidebars are now included</strong> - ClipIt now comes with dynamic sidebars. By default ClipIt will be 100% wide, but when you add a widget to one of the predifined sidebars the layout will change to 70/30 and you will have a sidebar.</li>
				</ul>			
			<strong>Pre-Release Version 8.4</strong>				
				<ul class="bullets">					
					<li><strong>Locations Taxonomy Updated</strong> - The Locations Taxonomy now includes fields for Street Address, City, State, Zip Code, Phone Number and Additional Information.</li>					
					<li><strong>Google Maps Integrated into Locations</strong> - Now that we are able to extract location details, we can now generate a google map on the single-coupon.php page.</li>					
					<li><strong>Location selection updated</strong> - This update corrects the issue that had all locations appearing on each single-coupon.php page regardless of what Locations were actually selected.</li>					
					<li>Small CSS changes</li>				
				</ul>			
			<strong>Pre-Release Version 8.3</strong>				
				<ul class="bullets">					
					<li><strong>Social Like Buttons</strong> - Social Like buttons have been added as an alternative to the standard Like/Dislike buttons that ClipIt includes.</li>					
					<li><strong>Show Like added to shortcode</strong> - You can now choose to show or hide the like function in the shortcode.</li>					
					<li><strong>Locations Taxonomy</strong> - ClipIt now includes a taxonomy-locations.php file. This will allow your location pages to render the coupons properly.</li>				
				</ul>			
			<strong>Pre-Release Version 8.2</strong>				
				<ul class="bullets">					
					<li><strong>Conversion Rate Dashboard Widget</strong> - You can now view the conversion rates for your coupons on the WordPress Dashboard.</li>				
				</ul>			
			<strong>Pre-Release Version 8.1</strong>				
				<ul class="bullets">					
					<li><strong>Dynamic Expiration</strong> - The most effective method, this option creates a sense of urgency in your buyers by displaying the expiration as the current date. This Dynamic Date feature updates everyday so if you choose the “today” option, the expiration will always show that day’s date. </li>					
					<li><strong>HTML Formatted Emails</strong> - Now notifications sent to you will be properly formatted HTML.</li>					
					<li><strong>Additional Social Icons</strong> - New social icons for Reddit, Stumbleupon, and Digg have been added.</li>				
				</ul>
			<strong>Pre-Release Pre-Release Version 8.0</strong>
				<ul class="bullets">
					<li><strong>CSV Coupon Upload</strong> - You can now upload your coupons using a .csv file. We have provided a pre-defined and pre-filled .csv file that you can use to build your coupons.</li>
					<li><strong>QR Code Generator</strong> - Once you have created your coupon and published it, you will now also get a auto generated QR Code that points directly to the coupon. This QR Code will appear below the fine print in the single coupon page. This QR Code will also appear on the sidebar below the Contact Form Shortcode box in the Coupon Creation panel.</li>
					<li><strong>Stats Widget Dashboard</strong> - Now user can go to the WordPress Dashboard and enable two dashboard widgets for ClipIt Coupons.</li>
						<ul class="sub">
							<li><strong>Recent ClipIt Coupons</strong> - This lets you know the last 5 Coupons that have been created.</li>
							<li><strong>Recent ClipIt View</strong> - This will tell you which coupons have been viewed the most.</li>
						</ul>
					<li><strong>Schema.org Added</strong> - Schema markup has been added to the single-coupon page. While on-page markup varies based on the search engine. Google uses it to create rich snippets in search results.</li>
					<li><strong>Default Expired Coupon Text</strong> - You can set text to be displayed when a coupon expires. This can only be done in the Clip Settings page under General.</li>
					<li><strong>Target Blank pages when using Destination URL Coupon Action</strong> - Now when you use the Destination URL Coupon Action and a site visitor clicks on the "View Coupon" button, a new tab will be opened to that URL.</li>
					<li><strong>Responsive JS is added</strong> - Email to Claim functionality will no work when a site visitor is viewing your coupons on their mobile cellular devices.</li>
					<li><strong>Fixes</strong></li>
						<ul class="sub">
							<li>Applied Fix for Coupon Type to show/hide available options Coupon Actions.</li>
							<li>Updated ClipIt CPT Messages.</li>
							<li>Coupon Image in the Manage Coupons screen now correctly displays the default build coupon image when Coupon Type 'Build' is selected. If Coupon Type 'Upload' is selected then the Main Coupon Upload image will appear.</li>
							<li>Corrected the duplication of thumbs rating on the Manage Coupons Screen.</li>
							<li>Additional Coupon Columns added to Manage Coupons Screen.</li>
						</ul>
					<li>Updates to documentation</li>
					<li>Small CSS changes</li>
				</ul>
			<strong>Pre-Release Version 7.0</strong>
				<ul class="bullets">
					<li><strong>Clip It Admin Settings</strong> - You can now have control over the look of your built coupons. You can change colors, fonts, and even have access to override the CSS of the coupons.</li>
					<li>Updates to documentation</li>
					<li>Small CSS changes</li>
				</ul>
			<strong>Pre-Release Version 6.0</strong>
				<ul class="bullets">
					<li><strong>Social Sharing</strong> - Your customers can now share your coupons on their favorite social media network. Facebook, Twitter, Google+, LinkedIn, and Pinterest are available.</li>
					<li>Updates to documentation</li>
					<li>Small CSS changes</li>
				</ul>
			<strong>Pre-Release Version 5.0</strong>
				<ul class="bullets">
					<li><strong>Print Coupons to PDF</strong> - You can now print coupons directly to a PDF. Once the PDF is generated you can print your coupons.</li>
					<li><strong>Email to Claim Function</strong> - This feature will automatically generate a modal window that will request a users Name and Email address, before they can print a coupon. This works on both uploaded and built coupons.</li>
					<li><strong>Contact Form Shortcode Area</strong> - A new area was created that now will allow you to use the shortcode from your favorite contact form to be viewed on the single-coupon.php page.</li>
					<li><strong>Updated WP_Query Function fixes Tag filtering issue.</strong> - This corrects an issue with tag filtering when using the ClipIt shortcode.</li>
					<li><strong>Toggle Comments on single-coupon.php template</strong> - Comments by default are hidden but if the "Comments" text is clicked the comments will appear at the bottom.</li>
					<li><strong>jQuery Tooltip added to Promo Code Display Action.</strong> - Now when users hover over the Promo Code text they will see a ToolTip that gives them additional information about the coupon. Note: The "Promo Text" field must have text in it for this to work correctly.</li>
					<li>Updates to documentation</li>
					<li>Small CSS changes</li>
				</ul>
			<strong>Pre-Release Version 4.1</strong>
				<ul class="bullets">
					<li>Updates to documentation</li>
					<li>Small CSS change</li>
				</ul>
			<strong>Pre-Release Version 4</strong>
				<ul class="bullets">
					<li><strong>Cloning a Coupon</strong> - The ability to clone a coupon is now available on the manage coupons page. If you hover over an already created coupon in the Manage Coupons page, you will see an option to "Clone" the coupon. Once clicked on, you will be redirected to the cloned coupon edit page</li>
					<li><strong>Additional Plugin Prompt</strong> - ClipIt works better when used in conjunction with other plugins. Specifically the Thumbs Rating and Post Types Order plugins. So when a user installs and activates ClipIt they will see a prompt that recommends they install those two plugins.</li>
					<li><strong>Change Coupon Order</strong> - In previous version you would need to change the Post Date in order to change the order the coupons list. Now when you install the Post Types Order Plugin you will have the ability to change these using an easy to use interface.</li>
					<li><strong>Locations Taxonomy</strong> - If a user has different locations, they can now enter those locations using the Locations Page. These locations will be used later during coupon creation.</li>
					<li><strong>New Fields</strong> - In order to enhance the user experience, additional fields needed to be added. They are outlined below:</li>
						<ul class="sub">
							<li><strong>Locations</strong> - If users have multiple locations and want to offer coupons specific to one location they have the ability to specify what locations their coupons are good at.
							<li><strong>How To Use</strong> - This field allows users to give their customers detailed instructions on how to use the coupon. The user has to place one instruction per line followed by a hard return. When done correctly, the instructions will appear as an ordered list on the website. This field allows for HTML to be used. In the event that no information is entered in this field, default text (Please call your service provider for more details) will be applied.</li>
							<li><strong>The Rules</strong> - This field allows users to specify any rules they may have with a coupon, i.e., Does not cover tax. This field allows for HTML to be used. In the event that no information is entered in this field, default text (Please call your service provider for more details) will be applied.</li>
						</ul>
					<li><strong>Shortcode updates</strong>. There have been quite a few updates to the shortcode. Below are the changes:</li>
						<ul class="sub">
							<li><strong>Addition of Vote Buttons</strong> - If you have enabled Enable Like/Dislike Buttons on your coupons they will appear when you use the clipit shortcode.</li>
							<li><strong>Times Used</strong> - If you have enabled Coupon Views on your coupon they will appear when you use the clipit shortcode.</li>
							<li><strong>Comments</strong> - If you have enabled Coupon Comments on your coupon they will appear when you use the clipit shortcode. If you have active comments for your coupon the View Comments link will be an active link that toggles the 3 most recent comments for that coupon. If no active comments are available then "No Comment" will appear and it will not be an active link.</li>
							<li><strong>Scheduling</strong> - In previous versions a user was able to schedule a coupon to expire on a certain date. This worked fine except it would not remove coupon if it was applied using a shortcode. Now all coupons will honor the expiration date applied during coupon creation.</li>
						</ul>
					<li><strong>Updates to CSS.</strong> There were a few changes to the CSS. Some corrected calculation issues when resizing coupons to fit in narrower columns. Other changes were made to accommodate the shortcode changes that were mentioned above.</li>
					<li><strong>Updates to Documentation.</strong> The documentation has been updated to reflect all the changes specified above.</li>
				</ul>
			<strong>Pre-Release Version 3</strong>
				<ul class="bullets">
					<li>If enabled, users can now leave comments about a specific coupon.</li>
					<li>The Description text area now allows HTML to be used.</li>
					<li>The Fine Print text area now allows HTML to be used.</li>
					<li>Coupon Preview is now available.</li>
				</ul>
			<strong>Pre-Release Version 2</strong>
				<ul class="bullets">
					<li>The ability to upload a pre-existing coupon is now availble. Now users can chose to build or upload their coupons.</li>
					<li>If enabled, You can now see how many times your coupon has been viewed.</li>
				</ul>
			<strong>Pre-Release Version 1</strong>
				<ul class="bullets">
					<li>ClipIt Coupons Pre-Release 1 available for testing</li>
				</ul>
		</div>
	</div>
<?php } ?>