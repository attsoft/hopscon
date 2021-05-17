<?php



/**

 * Provide a public-facing view

 *

 * This file is used to markup the public-facing aspects for filter form.

 *

* @link       http://ideas.echopointer.com

 * @since      1.2.3

 *

 * @package    Kas_Dokan_Vendor_Filter

 * @subpackage Kas_Dokan_Vendor_Filter/public/partials

 */

?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php

if ( $args['id'] ) {

			$kas_map_info = '';

			

			// Generate json for map markers....

	        foreach ( $args['id'] as $seller ) {

	   

	            $store_info = dokan_get_store_info( $seller['id'] );

	            $banner_id  = isset( $store_info['banner'] ) ? $store_info['banner'] : 0;

	            if (!empty($store_info['location'])) {

	            	$locations = explode( ',', $store_info['location'] );

		        	$def_lat = $locations[0];

            		$def_long = $locations[1];

	            }

		        $store_name = isset( $store_info['store_name'] ) ? esc_html( $store_info['store_name'] ) : __( 'N/A', $this->kas_filter );

		        $store_url  = dokan_get_store_url( $seller['id'] );

		        

            		            

	            

            	if (!empty($def_lat) && !empty($def_long) && isset($def_lat) && isset($def_long)) {

	            

		            $kas_map_info .= "['<div class=\"kas_map_info\">";

                    if ( $banner_id ) {

                      	$image_size = 'kas_vendor_image';

	                    if (isset($image_size)) {

	                      $banner_url = wp_get_attachment_image_src( $banner_id, $image_size );

	                    }else{

	                      $banner_url = wp_get_attachment_image_src( $banner_id);

	                    }

	                    $kas_map_info .= "<a href=\"".$store_url."\"><img class=\"kas_map_imp\" src=\"".esc_url( $banner_url[0] )."\" alt=\"".esc_attr( $store_name )."\"></a><br>";

                    }else{

                    	$kas_map_info .= "<a href=\"".$store_url."\"><img class=\"kas_map_imp\" src=\"".dokan_get_no_seller_image()."\" alt=\"No Image\"></a><br>";

                    }	

		            $kas_map_info .= "<p><a href=\"".$store_url."\">".$store_name."</a></p><br><div class=\"kas_map_left\">".dokan_get_seller_address( $seller['id'] );

		            $kas_map_info .= "</div><div class=\"kas_map_right\"><abbr title=\"Phone Number\">P:</abbr>".esc_html( $store_info['phone'] )."<br><a  target=\"_blank\" href=\"http://maps.google.com/maps?saddr=KAS_USER_POSITION&daddr=".$def_lat.",".$def_long."\">Get Direction</a><br><br><a class=\"dokan-btn dokan-btn-theme\" href=\"".$store_url."\">Visit Store</a></div></div>','";

		            $kas_map_info .= $def_lat."','";

		            $kas_map_info .= $def_long."'],";

	            }

  

	        }

	        

	        

	        $kas_map_info = substr ( $kas_map_info, 0, - 1 );

			$kas_map_info = '<script type="text/javascript"> var locations = [' . $kas_map_info . '];</script>';

			

			// json for map markers

			echo $kas_map_info;

	

?>			

	<div id="map" style="width: 100%; height:<?php echo esc_attr( get_option('kas-map-height') );?>px;"></div>

    <script type="text/javascript">



        window.map = new google.maps.Map(document.getElementById('map'), {

            mapTypeId: google.maps.MapTypeId.ROADMAP

        });



        var infowindow = new google.maps.InfoWindow();



        var bounds = new google.maps.LatLngBounds();



        for (i = 0; i < locations.length; i++) {

            marker = new google.maps.Marker({

                position: new google.maps.LatLng(locations[i][1], locations[i][2]),

                map: map

            });



            bounds.extend(marker.position);



            google.maps.event.addListener(marker, 'click', (function (marker, i) {

                return function () {

                	var res = locations[i][0].replace("KAS_USER_POSITION", ''); 

                    infowindow.setContent(res);

                    infowindow.open(map, marker);

                }

            })(marker, i));

        }



        map.fitBounds(bounds);



        var listener = google.maps.event.addListener(map, "idle", function () {

            map.setZoom(<?php echo get_option('kas-map-zoom');?>);

            google.maps.event.removeListener(listener);

        });



  </script> 			

	<br>	

<?php }else {?>

    <p class="dokan-error"><?php _e( 'No seller found for map!',$this->kas_filter); ?></p>

<?php } ?>	