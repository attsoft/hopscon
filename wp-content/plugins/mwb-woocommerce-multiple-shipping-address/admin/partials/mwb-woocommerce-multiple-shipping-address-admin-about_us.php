<?php
$mwb_about_us_data = wp_remote_get('https://demo.makewebbetter.com/api/about_us.json');

$mwb_description = $mwb_detailed_description = $mwb_our_plans = $mwb_our_plans_url = $mwb_our_microservices = $mwb_our_microservices_url = '';
if(array_key_exists('body', $mwb_about_us_data) && !empty($mwb_about_us_data['body']))
{
	$mwb_about_us_data = json_decode($mwb_about_us_data['body']);
	$mwb_description = $mwb_about_us_data->description;
	$mwb_detailed_description = $mwb_about_us_data->detailed_description;
	$mwb_our_plans = $mwb_about_us_data->our_plans;
	$mwb_our_plans_url = $mwb_about_us_data->our_plans_url;
	$mwb_our_microservices = $mwb_about_us_data->our_microservices;
	$mwb_our_microservices_url = $mwb_about_us_data->our_microservices_url;
}
?>
<div class="mwb_woocommerce_multiple_shipping_address_about_wrap">
	<div class="mwb_woocommerce_multiple_shipping_address_about_logo_desc">
		<div class="mwb_woocommerce_multiple_shipping_address_about_logo">
			<img class="mwb_woocommerce_multiple_shipping_address_logo" src="<?php echo MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_URL.'admin/images/logo.png' ?>" alt="">
		</div>
		<div class="mwb_woocommerce_multiple_shipping_address_about_full_desc">
			<p><?php
				if($mwb_description != '')
				{
					_e($mwb_description,'mwb-woocommerce-multiple-shipping-address');
				}
				else
				{
					?>
					<?php _e('Our professional team deals with throughout analysis of the inquiry published, support team maintains a detailed report on the inquiry extended by the customer. Then a meeting gets scheduled with our project manager with who guidance a roadmap gets managed and according to it, work starts off! Apart from this, you will get 24x7 support service and quick response','mwb-woocommerce-multiple-shipping-address'); ?>.
					
					<?php
				}
			?></p>
		</div>
	</div>
	<div class="mwb_woocommerce_multiple_shipping_address_about_more_desc">
	<?php
		if($mwb_detailed_description != '')
		{
			_e($mwb_detailed_description,'mwb-woocommerce-multiple-shipping-address');
		}
		else
		{
			?>
			<p><?php _e("Our team of trendsetters largely comprise of 5+ years of experience holder professionals from the industry who well know the Knitty-gritty of the industry, designers, content visualizers, developers and other creative professionals at large. We have surely spent much time designing great solutions for your web's smooth functioning all from scratch and thus we came out as great creators","mwb-woocommerce-multiple-shipping-address"); ?>.</p>
			<p><?php _e('In next 20 years, we will try to come out with something more valuable yet outstanding digital result for the new world which is ready to knock our doors!','mwb-woocommerce-multiple-shipping-address'); ?></p>
			<?php
		} ?>
	</div>
	<div class="mwb_woocommerce_multiple_shipping_address_subscription_wrap">
		<h3><?php _e('our plans','mwb-woocommerce-multiple-shipping-address'); ?></h3>
		<p><?php
			if($mwb_our_plans != '')
			{
				_e($mwb_our_plans,'mwb-woocommerce-multiple-shipping-address');
			}
			else
			{ ?>
				<?php _e('We are always trying to help our clients with all possible manners thats why we are came with monthly/yearly basis plan so purchase a plan now and we will take care of all things','mwb-woocommerce-multiple-shipping-address'); ?>.

			<?php } ?>
		</p>
		<a href="<?php echo $mwb_our_plans_url; ?>" target="_blank">
			<div class="mwb_woocommerce_multiple_shipping_address_subscription">
				<span><?php _e('Monthly/Yearly Plan','mwb-woocommerce-multiple-shipping-address'); ?></span>
			</div>
		</a>

	</div>
	<div class="mwb_woocommerce_multiple_shipping_address_subscription_wrap">
		<h3><?php _e('our microservices','mwb-woocommerce-multiple-shipping-address'); ?></h3>
		<p><?php
			if($mwb_our_microservices != '')
			{
				_e($mwb_our_microservices,'mwb-woocommerce-multiple-shipping-address');;
			}
			else
			{ ?>
				<?php _e('We are also provide micro services for taking sort term of services and our experts will boost your site so please take a look of our micro-services','mwb-woocommerce-multiple-shipping-address'); ?>.
			<?php } ?>
		</p>
		<a href="<?php echo $mwb_our_microservices_url; ?>" target="_blank">
			<div class="mwb_woocommerce_multiple_shipping_address_subscription">
				<span><?php _e('Check Our Microservices','mwb-woocommerce-multiple-shipping-address'); ?></span>
			</div>
		</a>
	</div>
	<?php

	$mwb_woocommerce_multiple_shipping_address_plugins_data = wp_remote_get('https://demo.makewebbetter.com/api/feed.json',array('plugin_id'=>'mwb_rnx'));
	if(is_array($mwb_woocommerce_multiple_shipping_address_plugins_data) && !empty($mwb_woocommerce_multiple_shipping_address_plugins_data))
	{
		if(array_key_exists('body', $mwb_woocommerce_multiple_shipping_address_plugins_data))
		{
			if($mwb_woocommerce_multiple_shipping_address_plugins_data['body'] != '')
			{
				$mwb_woocommerce_multiple_shipping_address_plugins_data = json_decode($mwb_woocommerce_multiple_shipping_address_plugins_data['body']); ?>
				<div class="mwb_woocommerce_multiple_shipping_address_featured_wrap">
					<h3><?php _e('our featured plugins','mwb-woocommerce-multiple-shipping-address'); ?></h3><?php
					foreach ($mwb_woocommerce_multiple_shipping_address_plugins_data as $mwb_woocommerce_multiple_shipping_address_data) 
					{ 
						if($mwb_woocommerce_multiple_shipping_address_data->image_link == '')
						{
							$mwb_standard_image_link = MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_URL.'admin/images/placeholder.png';
						}
						else
						{
							$mwb_standard_image_link = $mwb_woocommerce_multiple_shipping_address_data->image_link;
						}
					?>
					<div class="mwb_woocommerce_multiple_shipping_address_featured_plugin">
						<img class="mwb_woocommerce_multiple_shipping_address_image" src="<?php echo $mwb_standard_image_link ?>" alt="">
						<div class="mwb_woocommerce_multiple_shipping_address_desc">
							<p class="mwb_woocommerce_multiple_shipping_address_title"><?php echo $mwb_woocommerce_multiple_shipping_address_data->plugin_name ?></p>
							<?php if(round($mwb_woocommerce_multiple_shipping_address_data->ratting) > 0) : 
							$mwb_woocommerce_multiple_shipping_address_counter = 0; ?>
							<div class="mwb_woocommerce_multiple_shipping_address_rating">
								<?php while ( $mwb_woocommerce_multiple_shipping_address_counter < round($mwb_woocommerce_multiple_shipping_address_data->ratting)) : ?>
									<img class="mwb_woocommerce_multiple_shipping_address_star" src="<?php echo MWB_WOOCOMMERCE_MULTIPLE_SHIPPING_ADDRESS_DIR_URL.'admin/images/star.png' ?>" alt="">
								<?php $mwb_woocommerce_multiple_shipping_address_counter++;
								 endwhile; ?>
							</div>
							<?php endif; ?>
							<span class="mwb_woocommerce_multiple_shipping_address_price"><?php echo $mwb_woocommerce_multiple_shipping_address_data->price ?></span>

							<span class="mwb_woocommerce_multiple_shipping_address_buy_now"><a href="<?php echo $mwb_woocommerce_multiple_shipping_address_data->landing_page ?>" target="_blank"><?php _e('Buy Now','mwb-woocommerce-multiple-shipping-address'); ?></a></span>
						</div>
					</div><?php
				}
				?></div><?php		
			}
		}
	}
	?>
</div>