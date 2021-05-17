<?php
/**
 *  Dokan Dashboard Template
 *
 *  Dokan Main Dahsboard template for Fron-end
 *
 *  @since 2.4
 *
 *  @package dokan
 */
?>
<div class="dokan-dashboard-wrap">
    <?php
        /**
         *  dokan_dashboard_content_before hook
         *
         *  @hooked get_dashboard_side_navigation
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_before' );
    ?>

    <div class="dokan-dashboard-content">

        <?php
            /**
             *  dokan_dashboard_content_before hook
             *
             *  @hooked show_seller_dashboard_notice
             *
             *  @since 2.4
             */
            do_action( 'dokan_help_content_inside_before' );
            
            
        ?>

        <article class="help-content-area">
        <div class="dokan-ajax-response"></div>
        <button class="tablink dokan-btn dokan-btn-theme" onclick="openPage('Home', this, 'green')" id="defaultOpen"><i class="fa fa-user">&nbsp;</i> Add New Driver</button>
        <!-- <button class="tablink dokan-btn dokan-btn-theme" onclick="openPage('reg_dr', this, 'green')" >Add Registerd Driver</button> -->
        <button class="tablink dokan-btn dokan-btn-theme" onclick="add_driver_popup(<?php echo get_current_user_id();?>);" >Add Registerd Driver</button>
        <button class="tablink dokan-btn dokan-btn-theme" onclick="openPage('News', this, 'green')" >Delivery Drivers</button>
<!--<button class="tablink" onclick="openPage('Contact', this, 'blue')">Contact</button>
<button class="tablink" onclick="openPage('About', this, 'orange')">About</button>-->
        
        <div id="Home" class="tabcontent">
            <div class="add_driverblock" style="position:relative;">
                
               
           <h4 class="entry-title">Register your driver.</h4>
           <div style="clear:both;"></div>
            
            <form method="post" id="settings-form"  action="" class="dokan-form-horizontal" autocomplete="off" enctype="multipart/form-data"> 
                <?php wp_nonce_field( 'dokan_about_settings_nonce' ); ?>
              
                 <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ddwc_driver_picture">
                        <?php esc_html_e( 'Driver Photo' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                    <a style="float:left;cursor:pointer;color:#fff;" id="image_url_driver_picture_btn" class="dokan-btn">Select Image</a>
                    <img style="width:50%;float:left;margin-left:5px;" width="640" height="400" src="" id="driver_picture">                    
                    <input type="hidden" name="ddwc_driver_picture" id="driver_picture_attach_id" placeholder="Item Image">
                  
                    </div>
                </div><?php ?>

                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="dr_fname">
                        <?php esc_html_e( 'First Name' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                        <input type="text" class="dokan-form-control" name="dr_fname" id="dr_fname" placeholder="<?php esc_attr_e( 'Driver First Name' ); ?>" value="">
                    </div>
                </div>

                
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="dr_lname">
                        <?php esc_html_e( 'Last Name' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                        <input type="text" class="dokan-form-control" name="dr_lname" id="dr_lname" placeholder="<?php esc_attr_e( 'Driver Last Name' ); ?>" value="">
                    </div>
                </div>

                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ddwc_driver_id_type">
                        <?php esc_html_e( 'Driver Id Type' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                        <select class="dokan-w12 dokan-form-control" name="ddwc_driver_id_type" id="ddwc_driver_id_type">
                            <option value="">Select ID Type</option>
                            <option value="Passport">Passport</option>
                            <option value="National ID">National ID</option>
                            <option value="Health Card">Health Card</option>
                            <option value="RAMQ">RAMQ</option>
                        </select>
                    </div>
                </div>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ddwc_driver_id_picture">
                        <?php esc_html_e( 'Driver Id Photo' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                    <a style="float:left;cursor:pointer;color:#fff;" id="image_url_driver_id_picture_btn" class="dokan-btn">Select Image</a>
                    <img style="width:50%;float:left;margin-left:5px;" width="640" height="400" src="" id="driver_id_picture">                    
                    <input type="hidden" name="ddwc_driver_id_picture" id="driver_id_picture_attach_id" placeholder="Item Image">
                  
                    </div>
                </div><?php ?>

                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ddwc_driver_id_number">
                        <?php esc_html_e( 'Driver Id Number' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control" type="text" name="ddwc_driver_id_number" placeholder="<?php esc_attr_e( 'Driver Id Number' ); ?>" id="ddwc_driver_id_number" value="">
                    </div>
                </div>

                  <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ddwc_driver_license_number">
                        <?php esc_html_e( 'Driver license number' ); ?>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control" type="text" name="ddwc_driver_license_number" placeholder="<?php esc_attr_e( 'Driver license number' ); ?>" id="ddwc_driver_license_number" value="">
                    </div>
                </div>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ddwc_driver_licence_picture">
                        <?php esc_html_e( 'Driver License Photo' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                    <a style="float:left;cursor:pointer;color:#fff;" id="image_url_driver_license_picture_btn" class="dokan-btn">Select Image</a>
                    <img style="width:50%;float:left;margin-left:5px;" width="640" height="400" src="" id="driver_license_picture">                    
                    <input type="hidden" name="ddwc_driver_licence_picture" id="driver_license_picture_attach_id" placeholder="Item Image">
                  
                    </div>
                </div>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="dr_email">
                        <?php esc_html_e( 'Email' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control" type="email" name="dr_email" placeholder="<?php esc_attr_e( 'Driver Email' ); ?>" id="dr_email" value="">
                    </div>
                </div>
                
                <?php
                
                $countries_obj   = new WC_Countries();
                $countries   = $countries_obj->__get('countries');
                 ?>
                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="drvr_country">
                        <?php esc_html_e( 'Country' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                        <select class="dokan-form-control" name="drvr_country" id="drvr_country">
                            <option value="">Select Country</option>
                            <?php foreach($countries as $key => $val) {?>
                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                            <?php } ?>
                        
                        </select>
                    </div>
                </div>
                 
                 <div class="dokan-form-group" id="drr_street_1">
                    <label class="dokan-w3 dokan-control-label" for="dr_street">
                        <?php esc_html_e( 'Street address' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control lft_bl" type="text" name="dr_street" id="dr_street" placeholder="<?php esc_attr_e( 'Street address' ); ?>" value="">
                    </div> 
                </div>
                 
                  <div class="dokan-form-group" id="drr_street_2">
                    <label class="dokan-w3 dokan-control-label" for="dr_street2">
                        <?php esc_html_e( 'Street address 2' ); ?>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control lft_bl" type="text" name="dr_street2" id="dr_street2" placeholder="<?php esc_attr_e( 'Apartment, suite, unit, etc. (optional)' ); ?>" value="">
                    </div>
                </div>
                 
                 <div class="dokan-form-group" id="drr_city">
                    <label class="dokan-w3 dokan-control-label" for="dr_city">
                        <?php esc_html_e( 'Town / City' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control right_bl" type="text" name="dr_city" placeholder="<?php esc_attr_e( 'Town / City' ); ?>" id="dr_city" value="">
                    </div>
                </div>
                 <div class="dokan-form-group" id="drr_state">
                    <label class="dokan-w3 dokan-control-label" for="dr_state">
                        <?php esc_html_e( 'State' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control right_bl" type="text" name="dr_state" placeholder="<?php esc_attr_e( 'State' ); ?>" id="dr_state" value="">
                    </div>
                </div>
                 <div class="dokan-form-group" id="drr_postcode">
                    <label class="dokan-w3 dokan-control-label" for="dr_zips">
                        <?php esc_html_e( 'Postcode / ZIP' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control right_bl" type="text" name="dr_zips" placeholder="<?php esc_attr_e( 'Postcode / ZIP' ); ?>" id="dr_zips" value="">
                    </div>
                </div>
                

                <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="dr_phone">
                        <?php esc_html_e( 'Phone Number' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control lft_bl" type="text" name="dr_phone_cd" id="dr_phone_cd" value="" autocomplete="false" readonly>
                        <input class="dokan-form-control right_bl" type="number" name="dr_phone" placeholder="<?php esc_attr_e( 'Driver Phone' ); ?>" id="dr_phone" value="" autocomplete="false" >
                    </div>
                </div>
                
                 <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ddwc_driver_license_plate">
                        <?php esc_html_e( 'License Plate Number' ); ?>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control" type="text" name="ddwc_driver_license_plate" placeholder="<?php esc_attr_e( 'Plate Number' ); ?>" id="ddwc_driver_license_plate" value="">
                    </div>
                </div>
                
                 <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ddwc_driver_transportation_type">
                        <?php esc_html_e( 'Transportation Type' ); ?>
                    </label>
                    <div class="dokan-w5">
                        <select class="dokan-form-control" name="ddwc_driver_transportation_type" id="ddwc_driver_transportation_type">
                            <option value="">--</option>
                            <option value="Bicycle">Bicycle</option>
                            <option value="Motorcycle">Motorcycle</option>
                            <option value="Car">Car</option>
                            <option value="SUV">SUV</option>
                            <option value="Truck">Truck</option>
                        </select>
                    </div>
                </div>
                
                
                 <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ddwc_driver_vehicle_model">
                        <?php esc_html_e( 'Vehicle Model' ); ?>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control" type="text" name="ddwc_driver_vehicle_model" placeholder="<?php esc_attr_e( 'Model Number' ); ?>" id="ddwc_driver_vehicle_model" value="">
                    </div>
                </div>
                
                 <div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="ddwc_driver_vehicle_color">
                        <?php esc_html_e( 'Vehicle Color' ); ?>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control" type="text" name="ddwc_driver_vehicle_color" placeholder="<?php esc_attr_e( 'Vehicle Color' ); ?>" id="ddwc_driver_vehicle_color" value="">
                    </div>
                </div>
                <!-- 
                
                
                <?php ?><div class="dokan-form-group">
                    <label class="dokan-w3 dokan-control-label" for="dr_pass">
                        <?php //esc_html_e( 'Password' ); ?><span class="required"> *</span>
                    </label>
                    <div class="dokan-w5">
                        <input class="dokan-form-control" type="password" name="dr_pass" id="dr_pass" value="">
                    </div>
                </div><?php ?> -->

                <div class="dokan-form-group">
                    <div class="dokan-w4 ajax_prev dokan-text-left" style="margin-left: 25%">
                        <input type="submit" name="dokan_update_about_settings2" class="dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Register' ); ?>">
                        
                         <input type="button" id="clear_form" name="clear_form" class="dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Clear' ); ?>">
                    </div>
                </div>
            </form>

            <style>
                #settings-form p.help-block {
                    margin-bottom: 0;
                }
                .ddwc-driver-details th {
                    padding: 6px;
                }
                table.ddwc-driver-details.driver-list tr td {
                    padding: 5px;
                }
                .driver-list tr.odd {
                    background: #e3f5ee;
                }
                
                .driver-list tr.even {
                    background: #f5dedc;
                }
            </style>            
            </div>
            </div>
            
            
             <div id="reg_dr" class="tabcontent">
            <div style="clear:both;"></div>
                <h4 class="entry-title">Select driver from existing drivers.</h4>
               <div class="dokan-form-group">
               
                <a href="javascript:void(0);" class="btn-adddr" onclick="add_driver_popup(<?php echo get_current_user_id();?>);">Add Driver</a>
                </div>
                <div class="dokan-form-group drad_success_msg">
                 <?php // if($_GET['drstatus'] == 'success'){ ?>
                       
                    <?php//  } ?>
                    
                 </div>
            <div style="clear:both;"></div>
             </div>
            
 <div id="News" class="tabcontent">    
 
 <?php 
    $vendor_id   = dokan_get_current_user_id();
    $args = array(
                    'role'    => 'driver',
                    'orderby' => 'user_nicename',
                    'order'   => 'ASC',
                    'meta_key' => 'driver_vendor', 
                    'meta_value' => $vendor_id,
                    'meta_compare' => "LIKE",
                );
    $drivers = get_users( $args );
    if ( $drivers ) {
 
 ?>
 
        
<div class="internal_drouter">
  <div class="dokan-form-group" style="position: relative;">
    <h4 class="dokan-w9" style="margin-top: 20px;">Delivery Drivers</h4>
    <br>
   <table class="ddwc-dashboard delivery-drivers">
  <thead>
    <tr>
      <td>Name</td>
      <td>Status</td>
      <td>Rating</td>
      <td style="min-width: 105px;">Contact</td>
      <td>Address</td>
      <td>Activate/Deactivate</td>
      <td style="min-width: 100px;">Actions</td>
    </tr>
  </thead>
  <tbody>
  
  <?php 
  foreach ( $drivers as $driver ) {
      
      $availability = '<span class="driver-status unavailable">' . esc_attr__( 'Unavailable', 'ddwc' ) . '</span>';

    // Driver available.
    if ( get_user_meta( $driver->ID, 'ddwc_driver_availability', true ) ) {
        $availability = '<span class="driver-status available">' . esc_attr__( 'Available', 'ddwc' ) . '</span>';
    }
      $driver_rating_final = ddwc_driver_rating( $driver->ID );
      
      // Driver phone number.
    $driver_number = get_user_meta( $driver->ID, 'billing_phone', true );
    if(empty($driver_number)){
        $driver_number = get_user_meta( $driver->ID, 'phone', true );
        }
    // Empty var.
    $phone_number = '';
    // Driver phone number button.
    if ( $driver_number ) {
        $phone_number = '<a href="tel:' . esc_html( $driver_number ) . '" class="button ddwc-button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M20 22.621l-3.521-6.795c-.008.004-1.974.97-2.064 1.011-2.24 1.086-6.799-7.82-4.609-8.994l2.083-1.026-3.493-6.817-2.106 1.039c-7.202 3.755 4.233 25.982 11.6 22.615.121-.055 2.102-1.029 2.11-1.033z"/></svg></a>';
    }
    
    // Get driver userdata.
    $user_info = get_userdata( $driver->ID );

    // Driver email address.
    $driver_email = $user_info->user_email;
    global $woocommerce;
    // Empty var.
    $email_address = '';
    
    $address = get_user_meta($driver->ID);
    $full_add = '';
    $street_1 = $address['rs_billing_address_1'][0];
    if(empty($address['rs_billing_address_1'][0])){
        $street_1 = $address['billing_address_1'][0];
        }
    if(isset($street_1)){
        $full_add .= $street_1.', ';
    }
    
    $street_2 = $address['rs_billing_address_2'][0];
    if(empty($address['rs_billing_address_2'][0])){
        $street_2 = $address['billing_address_2'][0];
        }
    if(isset($street_2)){
        $full_add .= $street_2.' ';
    }
    
    $billing_city = $address['rs_billing_city'][0];
    if(empty($address['rs_billing_city'][0])){
        $billing_city = $address['billing_city'][0];
        }
    if(isset($billing_city)){
        $full_add .= $billing_city.', ';
    }
    
    $billing_state = $address['rs_billing_state'][0];
    if(empty($address['rs_billing_state'][0])){
        $billing_state = $address['billing_state'][0];
        }
    if(isset($billing_state)){
        $full_add .= $billing_state.', ';
    }
    
    $billing_country = $address['country'][0];
    if(empty($address['country'][0])){
        $billing_country = $address['billing_country'][0];
        }
    if(isset($billing_country)){
        $full_add .= $billing_country;
    }

    // Driver email address button.
    if ( $driver_email ) {
        $email_address = '<a href="mailto:' . esc_html( $driver_email ) . '" class="button ddwc-button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"><path d="M0 3v18h24v-18h-24zm6.623 7.929l-4.623 5.712v-9.458l4.623 3.746zm-4.141-5.929h19.035l-9.517 7.713-9.518-7.713zm5.694 7.188l3.824 3.099 3.83-3.104 5.612 6.817h-18.779l5.513-6.812zm9.208-1.264l4.616-3.741v9.348l-4.616-5.607z"/></svg></a>';
    }
    if(get_user_meta($driver->ID, 'vendor_needs', true) == 'active'){
    $active_dactive = '<div class="ddwc-availability forspacificvd"><label class="switch"><input data-id="'.$driver->ID.'" type="checkbox" value="yes" checked><span class="slider round"></span></label></div>';
    }else{
        $active_dactive = '<div class="ddwc-availability forspacificvd"><label class="switch"><input data-id="'.$driver->ID.'" type="checkbox" value="yes"><span class="slider round"></span></label></div>';
        }
    $actions = '<a class="dokan-btn dokan-btn-default dokan-btn-sm tips" href="javascript:void(0);" onclick="showDriverDetails('.$driver->ID.')" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Driver"><i class="fa fa-eye">&nbsp;</i></a>

<a class="dokan-btn dokan-btn-default dokan-btn-sm tips" href="javascript:void(0);" onclick="removeDriverFromList('.$driver->ID.')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove Driver"><i class="fa fa-times">&nbsp;</i></a>'; 
   ?>
  
    <tr>
      <td><?php echo esc_html( $driver->display_name );?></td>
      <td><span class="driver-status unavailable"><?php echo $availability;?></span></td>
      <td><?php echo $driver_rating_final;?></td>
      <td><?php echo $phone_number;?><?php echo $email_address;?></td>
      <td><?php echo $full_add;?></td>
      <td><?php echo $active_dactive; ?></td>
      <td class="dr_actn" ><?php echo $actions; ?></td>
    </tr>
   <?php } ?>
  </tbody>
</table>
  </div>
  <div style="clear:both;"></div>
</div>
<?php } else{ 
    
    echo '<p style="margin: 20px 0;font-size: 16px;color: #000;"> Opps! No driver registerd yet.</p>';

}?>
</div>      
      

        </article><!-- .dashboard-content-area -->

         <?php
            /**
             *  dokan_dashboard_content_inside_after hook
             *
             *  @since 2.4
             */
            do_action( 'dokan_dashboard_content_inside_after' );
        ?>


    </div><!-- .dokan-dashboard-content -->

    <?php
        /**
         *  dokan_dashboard_content_after hook
         *
         *  @since 2.4
         */
        do_action( 'dokan_dashboard_content_after' );
    ?>
   <div class="driver-popup" style="display:none;"> 
            <form method="post" id="search-driverfm"  action="<?php echo dokan_get_navigation_url( 'vendor-driver' ); ?>" class="dokan-form-horizontal"> 
            <span class="close_icn">+</span>
                <?php wp_nonce_field( 'dokan_about_settings_nonce' ); ?>
                <label class="dokan-control-label" for="existing_dr">
                <?php esc_html_e( 'Search Driver (by registerd email)' ); ?>
                 </label>
                    <div style="clear:both;"></div>
                    <div class="dokan-w12 dr_src">
                        <input type="hidden" name="currentvendor_id" id="currentvendor_id" value="<?php echo get_current_user_id();?>">
                        <input type="text" name="searc_drvr" value="" id="searc_drvr">
                        <span class="search_btn" onclick="search_drivr(this);">Search</span>
                        <span class="dokan-loading" style="display:none;"> </span>
                     <div class="searched_data">
                     
                     </div>
                     <div class="searched_type">
                     
                     </div>
                    </div>
               
                 <div class="dokan-form-group">
                    <div class="dokan-w4 ajax_prev dokan-text-left">
                        <input type="submit" name="dokan_add_driver" id="dokan_add_driver" class="dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Add Driver' ); ?>">
                    </div>
                   
                </div>
                 <?php /*?><div class="dokan-form-group">
                 <?php if($_GET['drstatus'] == 'success'){?>
                        <p class="dr-success">Driver Assigned Successfully..</p>
                    <?php  } ?>
                    
                 </div><?php */?>   
                
             </form>
             </div> 
             
 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" onclick="close_popup();"><i class="fa fa-times">&nbsp;</i></button>
        <h4 class="modal-title" id="myModalLabel">More About Joe</h4>
      </div> 
      <div class="modal-body">
        <center>
          <img src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcRbezqZpEuwGSvitKy3wrwnth5kysKdRqBW54cAszm_wiutku3R" name="aboutme" width="140" height="140" border="0" class="img-circle">
          <h3 class="media-heading">Joe Sixpack <small>USA</small></h3>
          <span><strong>Skills: </strong></span> <span class="label label-warning">HTML5/CSS</span> <span class="label label-info">Adobe CS 5.5</span> <span class="label label-info">Microsoft Office</span> <span class="label label-success">Windows XP, Vista, 7</span>
        </center>
        <hr>
        <center>
          <p class="text-left"><strong>Bio: </strong><br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut sem dui, tempor sit amet commodo a, vulputate vel tellus.</p>
          <br>
        </center>
      </div>
      <div class="modal-footer">
        <center>
          <button type="button" class="btn btn-default" data-dismiss="modal">I've heard enough about Joe</button>
        </center>
      </div>
    </div>
  </div>
</div>            
    
<style>
.modal {
    display: none;
   overflow: auto;
    overflow-y: hidden;
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 9999;
    -webkit-overflow-scrolling: touch;
    outline: 0;
    margin: 0 auto;
    text-align: center;
    background: #000000c9;
}
.fade {
    opacity: 0;
    -webkit-transition: opacity .15s linear;
    transition: opacity .15s linear;
}
.fade.in {
    opacity: 1;
}

.modal.fade .modal-dialog {
    -webkit-transform: translate(0,-25%);
    -ms-transform: translate(0,-25%);
    transform: translate(0,-25%);
    -webkit-transition: -webkit-transform .3s ease-out;
    -moz-transition: -moz-transform .3s ease-out;
    -o-transition: -o-transform .3s ease-out;
    transition: transform .3s ease-out;
}
.modal.in .modal-dialog {
    -webkit-transform: translate(0,5%);
    -ms-transform: translate(0,5%);
    transform: translate(0,5%);
}
.modal-dialog {
    max-width: 600px;
    margin: 30px auto;
    position: relative;
    width: 100%;
}

.modal-content {
    position: relative;
    background-color: #fff;
    border: 1px solid #999;
    border: 1px solid rgba(0,0,0,.2);
    border-radius: 6px;
    -webkit-box-shadow: 0 5px 15px rgba(0,0,0,.5);
    box-shadow: 0 5px 15px rgba(0,0,0,.5);
    background-clip: padding-box;
    outline: 0;
}
.modal-header {
    padding: 15px;
    border-bottom: 1px solid #e5e5e5;
    min-height: 16.428571429px;
}
.modal-body {
    position: relative;
    padding: 20px;
}
.modal-footer {
    margin-top: 15px;
    padding: 19px 20px 20px;
    text-align: right;
    border-top: 1px solid #e5e5e5;
}

</style>    
    
<script>
function openPage(pageName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

//jQuery( document ).ready(function() {
    
function add_driver_popup(vendor_id){
    jQuery(".driver-popup").css('display', 'block');  
};
function showDriverDetails(driver_id){
    
    var data={
            "action": "show_driver_details",
            "driver_id" : driver_id
                    
        };
        jQuery.ajax({
          type: "POST",
          url: dokan.ajaxurl, 
          data: data,
          success: function(data) {
              
            jQuery('.modal-dialog').html(data);
              
            jQuery(".modal").css('display', 'block');  
            jQuery(".modal").addClass('in');
            
          }
        });
        
    
};

function removeDriverFromList(driver_id){
    
    if(confirm("Are you sure you want to remove this driver?")){
       var data={
            "action": "removeDriverFromList",
            "driver_id" : driver_id
                    
        };
        jQuery.ajax({
          type: "POST",
          url: dokan.ajaxurl, 
          data: data,
          success: function(data) {
			  
			  if(data == 'Driver removed'){
					// location.reload();
                    jQuery("#News").load(document.URL +  ' #News');	  
                    alert("Driver removed: To see the updated result please click ok");
			  }
			  else
			  {
                    jQuery("#News").load(document.URL +  ' #News');
			  		alert(data);
					// location.reload();	
			  }
	        
          }
        });
    }
    else{
        return false;
    }

};




function close_popup() {
    jQuery(".modal").css('display', 'none'); 
    jQuery(".modal").removeClass('in'); 
};
 
 function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}

function search_drivr(){
  var search_txt = jQuery("#searc_drvr").val();
  var vendor_id = jQuery("#currentvendor_id").val();
        if(validateEmail(search_txt) && search_txt != ''){
            
            var data={
                    "action": "sraech_drivers",
                    "drtext": search_txt,
                    "vendor_id" : vendor_id
                    
                };
                jQuery('.dr_src .dokan-loading').css('display', 'block');
                //jQuery(".update_order").attr('disabled','disabled');
                jQuery.ajax({
                  type: "POST",
                  url: dokan.ajaxurl, 
                  data: data,
                  success: function(data) {
                    jQuery('.dr_src .dokan-loading').css('display', 'none');
                    if(data == '<span>No Driver Found! </span>'){
                        jQuery("#dokan_add_driver").prop('disabled', true);
                        jQuery("#dokan_add_driver").hide(); 
                    }else{
                        jQuery("#dokan_add_driver").prop('disabled', false);
                        jQuery("#dokan_add_driver").show();
                        }
                    if (data == '<span>Driver already added.</span>') {
                        jQuery("#dokan_add_driver").prop('disabled', true);
                        jQuery("#dokan_add_driver").hide(); 
                        }
                    jQuery('.searched_data').html(data);
                    //$("#PersonName").text('');
                  // if(data == 'No Drivers Found!'){
                    //window.location.assign("<?php //echo home_url(); ?>/dashboard/orders/?order_id=<?php //echo $order_id; ?>&_wpnonce=<?php //echo $_GET['_wpnonce'] ?>");
                //   }
                  }
                });
            
            
        }else{
            alert('Please enter a valid email address.');
            }
};
 jQuery(".close_icn").click(function(){
        jQuery(".driver-popup").css('display', 'none');  
         
    });
//});



 jQuery("#clear_form").click(function(){
  jQuery('#settings-form input[type=text], #settings-form input[type=email], #settings-form input[type=number]').val('');
  jQuery('#settings-form select').val('').change();
 });


</script>
</div><!-- .dokan-dashboard-wrap -->