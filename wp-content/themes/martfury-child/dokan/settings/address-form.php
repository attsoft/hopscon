<?php
/**
 * Dokan Settings Address form Template
 *
 * @since 2.4
 *
 * @package dokan
 */

$address         = isset( $profile_info['address'] ) ? $profile_info['address'] : '';
$address_street1 = isset( $profile_info['address']['street_1'] ) ? $profile_info['address']['street_1'] : '';
$address_street2 = isset( $profile_info['address']['street_2'] ) ? $profile_info['address']['street_2'] : '';
$address_city    = isset( $profile_info['address']['city'] ) ? $profile_info['address']['city'] : '';
$address_zip     = isset( $profile_info['address']['zip'] ) ? $profile_info['address']['zip'] : '';
$address_country = isset( $profile_info['address']['country'] ) ? $profile_info['address']['country'] : '';
$address_state   = isset( $profile_info['address']['state'] ) ? $profile_info['address']['state'] : '';

?>

<input type="hidden" id="dokan_selected_country" value="<?php echo esc_attr( $address_country )?>" />
<input type="hidden" id="dokan_selected_state" value="<?php echo esc_attr( $address_state ); ?>" />
<div class="dokan-form-group">
     
    <div class="one">
    <label class="dokan-w3 dokan-control-label" for="setting_address"><?php esc_html_e( 'Address', 'dokan-lite' ); ?></label>
    
    <div class="dokan-w5 dokan-text-left dokan-address-fields">
      <fieldset>
      <legend>
          <b>Flat Rate Delivery Fee Settings</b>
      </legend>           
      <?php if ( $seller_address_fields['street_1'] ) { ?>
            
                <div class="dokan-form-group">
                <label style="width:57%;" class="dokan-w3 control-label" for="dokan_address[street_1]"><?php esc_html_e( 'Street', 'dokan-lite' ); ?>
                    <?php
                    $required_attr = '';
                    if ( $seller_address_fields['street_1']['required'] ) {
                        $required_attr = 'required'; ?>
                        <span class="required"> *</span>
                    <?php } ?>
                </label>
                <input <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> id="dokan_address[street_1]" value="<?php echo esc_attr( $address_street1 ); ?>" name="dokan_address[street_1]" placeholder="<?php esc_attr_e( 'Street address' , 'dokan-lite' ) ?>" class="ghghgh dokan-form-control input-md" type="text">
			<div class="rwanda_address_notice dokan-w12">
				<b>Special Address Instructions For Rwanda</b><br>
				If Available, type the Street address.If NOT, type the Sector name (Umurenge) followed by the District name, to select your address. 
				<br>
			</div>
            </div>
            
        <?php }
        if ( $seller_address_fields['street_2'] ) { ?>
            <div class="dokan-form-group">
                <label class="dokan-w3 control-label" for="dokan_address[street_2]"><?php esc_html_e( 'Street 2', 'dokan-lite' ); ?>
                    <?php
                    $required_attr = '';
                    if ( $seller_address_fields['street_2']['required'] ) {
                        $required_attr = 'required'; ?>
                        <span class="required"> *</span>
                    <?php } ?>
                </label>
                <input <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> id="dokan_address[street_2]" value="<?php echo esc_attr( $address_street2 ); ?>" name="dokan_address[street_2]" placeholder="<?php esc_attr_e( 'Apartment, suite, unit etc. (optional)' , 'dokan-lite' ) ?>" class="dokan-form-control input-md" type="text">
            </div>
        <?php } ?>
        </fieldset>
        <fieldset>
      <legend>
          <b>Delivery Distance Calculation Settings</b>
      </legend>
        <?php if ( $seller_address_fields['city'] || $seller_address_fields['zip'] ) {
        ?>
            <div class="dokan-from-group">
                <?php if ( $seller_address_fields['city'] ) { ?>
                    <div class="dokan-form-group dokan-w6 dokan-left dokan-right-margin-30">
                        <label class="control-label" for="dokan_address[city]"><?php esc_html_e( 'City', 'dokan-lite' ); ?>
                            <?php
                            $required_attr = '';
                            if ( $seller_address_fields['city']['required'] ) {
                                $required_attr = 'required'; ?>
                                <span class="required"> *</span>
                            <?php } ?>
                        </label>
                        <div class="cityyhide <?php echo $address_city; ?>">
                            
                        <input <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> id="dokan_address[city]" value="<?php echo esc_attr( $address_city ); ?>" name="dokan_address[city]" placeholder="<?php esc_attr_e( 'Town / City' , 'dokan-lite' ) ?>" class="dokan-form-control input-md" type="text">
                        </div>
                        
                        <div class="cityshow">
                        <select id="dokan_address[city]"  name="dokan_address[city]" class="dokan-form-control input-md">
                        <option value="">Select City / District</option>
                        <option value="Kicukiro" <?php if(esc_attr( $address_city ) == 'Kicukiro'){ echo "Selected"; }else{} ?>>Kicukiro </option>
                        <option value="Gasabo" <?php if(esc_attr( $address_city ) == 'Gasabo'){ echo "Selected"; }else{} ?>>Gasabo </option>
                        <option value="Nyarugenge" <?php if(esc_attr( $address_city ) == 'Nyarugenge'){ echo "Selected"; }else{} ?>>Nyarugenge</option>
                        <option value="Burera" <?php if(esc_attr( $address_city ) == 'Burera'){ echo "Selected"; }else{} ?>>Burera</option>
                        <option value="Gakenke" <?php if(esc_attr( $address_city ) == 'Gakenke'){ echo "Selected"; }else{} ?>>Gakenke </option>
                        <option value="Gicumbi" <?php if(esc_attr( $address_city ) == 'Gicumbi'){ echo "Selected"; }else{} ?>>Gicumbi</option>
                        <option value="Musanze" <?php if(esc_attr( $address_city ) == 'Musanze'){ echo "Selected"; }else{} ?>>Musanze</option>
                        <option value="Rulindo" <?php if(esc_attr( $address_city ) == 'Rulindo'){ echo "Selected"; }else{} ?>>Rulindo </option>
                        <option value="Gisagara" <?php if(esc_attr( $address_city ) == 'Gisagara'){ echo "Selected"; }else{} ?>>Gisagara</option>
                        <option value="Huye" <?php if(esc_attr( $address_city ) == 'Huye'){ echo "Selected"; }else{} ?>>Huye</option>
                        <option value="Kamonyi" <?php if(esc_attr( $address_city ) == 'Kamonyi'){ echo "Selected"; }else{} ?>>Kamonyi </option>
                        <option value="Muhanga" <?php if(esc_attr( $address_city ) == 'Muhanga'){ echo "Selected"; }else{} ?>>Muhanga</option>
                        <option value="Nyamagabe" <?php if(esc_attr( $address_city ) == 'Nyamagabe'){ echo "Selected"; }else{} ?>>Nyamagabe</option>
                        <option value="Nyanza" <?php if(esc_attr( $address_city ) == 'Nyanza'){ echo "Selected"; }else{} ?>>Nyanza</option>
                        <option value="Nyaruguru" <?php if(esc_attr( $address_city ) == 'Nyaruguru'){ echo "Selected"; }else{} ?>>Nyaruguru</option>
                        <option value="Ruhango" <?php if(esc_attr( $address_city ) == 'Ruhango'){ echo "Selected"; }else{} ?>>Ruhango</option>
                        <option value="Bugesera" <?php if(esc_attr( $address_city ) == 'Bugesera'){ echo "Selected"; }else{} ?>>Bugesera</option>
                        <option value="Gatsibo" <?php if(esc_attr( $address_city ) == 'Gatsibo'){ echo "Selected"; }else{} ?>>Gatsibo</option>
                        <option value="Kayonza" <?php if(esc_attr( $address_city ) == 'Kayonza'){ echo "Selected"; }else{} ?>>Kayonza</option>
                        <option value="Kirehe" <?php if(esc_attr( $address_city ) == 'Kirehe'){ echo "Selected"; }else{} ?>>Kirehe</option>
                        <option value="Ngoma" <?php if(esc_attr( $address_city ) == 'Ngoma'){ echo "Selected"; }else{} ?>>Ngoma</option>
                        <option value="Nyagatare" <?php if(esc_attr( $address_city ) == 'Nyagatare'){ echo "Selected"; }else{} ?>>Nyagatare</option>
                        <option value="Rwamagana" <?php if(esc_attr( $address_city ) == 'Rwamagana'){ echo "Selected"; }else{} ?>>Rwamagana</option>
                        <option value="Karongi" <?php if(esc_attr( $address_city ) == 'Karongi'){ echo "Selected"; }else{} ?>>Karongi</option>
                        <option value="Nyabihu" <?php if(esc_attr( $address_city ) == 'Nyabihu'){ echo "Selected"; }else{} ?>>Nyabihu</option>
                        <option value="Nyamasheke" <?php if(esc_attr( $address_city ) == 'Nyamasheke'){ echo "Selected"; }else{} ?>>Nyamasheke</option>
                        <option value="Rubavu" <?php if(esc_attr( $address_city ) == 'Rubavu'){ echo "Selected"; }else{} ?>>Rubavu</option>
                        <option value="Rusizi" <?php if(esc_attr( $address_city ) == 'Rusizi'){ echo "Selected"; }else{} ?>>Rusizi</option>
                        <option value="Rutsiro" <?php if(esc_attr( $address_city ) == 'Rutsiro'){ echo "Selected"; }else{} ?>>Rutsiro</option>
                    </select>
                </div>
                        
                    </div>
                <?php }
                if ( $seller_address_fields['zip'] ) { ?>
                    <div class="dokan-form-group dokan-w5 dokan-left">
                        <label class="control-label" for="dokan_address[zip]"><?php esc_html_e( 'Post/ZIP Code', 'dokan-lite' ); ?>
                            <?php
                            $required_attr = '';
                            if ( $seller_address_fields['zip']['required'] ) {
                                $required_attr = 'required'; ?>
                                <span class="required"> *</span>
                            <?php } ?>
                        </label>
                        <input <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> id="dokan_address[zip]" value="<?php echo esc_attr( $address_zip ); ?>" name="dokan_address[zip]" placeholder="<?php esc_attr_e( 'Postcode / Zip' , 'dokan-lite' ) ?>" class="dokan-form-control dokan-address-zip input-md" type="text">
                    </div>
                <?php } ?>
                <div class="dokan-clearfix"></div>
            </div>
        <?php }

        if ( $seller_address_fields['country'] ) {
            $country_obj   = new WC_Countries();
            $countries     = $country_obj->countries;
            $states        = $country_obj->states;
        ?>
            <div class="dokan-form-group">
                <label class="control-label" for="dokan_address[country]"><?php esc_html_e( 'Country ', 'dokan-lite' ); ?>
                    <?php
                    $required_attr = '';
                    if ( $seller_address_fields['country']['required'] ) {
                        $required_attr = 'required'; ?>
                        <span class="required"> *</span>
                    <?php } ?>
                </label>
                <select <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> name="dokan_address[country]" onchange="test(this)" class="country_to_state dokan-form-control" id="dokan_address_country">
                    <?php dokan_country_dropdown( $countries, $address_country, false ); ?>
                </select>
            </div>
        <?php }
       /* if ( $seller_address_fields['state'] ) {
            $address_state_class = '';
            $is_input            = false;
            $no_states           = false;
            if ( isset( $states[$address_country] ) ) {
                if ( empty( $states[$address_country] ) ) {
                    $address_state_class = 'dokan-hide';
                    $no_states           = true;
                }
            } else {
                $is_input = true;
            }
        ?>
            <div  id="dokan-states-box" class="dokan-form-group">
                <label class="dokan-w3 control-label" for="dokan_address[state]"><?php esc_html_e( 'State ', 'dokan-lite' ); ?>
                    <?php
                    $required_attr = '';
                    if ( $seller_address_fields['state']['required'] ) {
                        $required_attr = 'required'; ?>
                        <span class="required"> *</span>
                    <?php } ?>
                </label>
            <?php if ( $is_input ) {
                    $required_attr = '';
                    if ( $seller_address_fields['state']['required'] ) {
                        $required_attr = 'required';
                    } 
                    ?>
                     
                <input <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> name="dokan_address[state]" Placeholder="State" class="statefield_clean dokan-form-control <?php echo esc_attr( $address_state_class ) ?>" id="dokan_address_state" value="<?php echo esc_attr( $address_state ) ?>"/>

                  <?php /*  
                 <div class="hideshow">
                <input <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> name="dokan_address[state]" class="dsdsd dokan-form-control <?php echo esc_attr( $address_state_class ) ?>" id="dokan_address_state" value="<?php echo esc_attr( $address_state ) ?>"/>
                </div>
                
                <div class="printselect">
                    <select name="dokan_address[state]" class="dsdsd dokan-form-control <?php echo esc_attr( $address_state_class ) ?>" id="dokan_address_state">
                        <option>Select Province</option>
                        <option value="Kigali" <?php if(esc_attr( $address_state ) == 'Kigali'){ echo "Selected"; }else{} ?>>Kigali </option>
                        <option value="Northern Province" <?php if(esc_attr( $address_state ) == 'Northern Province'){ echo "Selected"; }else{} ?>>Northern Province </option>
                        <option value="Southern Province" <?php if(esc_attr( $address_state ) == 'Southern Province'){ echo "Selected"; }else{} ?>>Southern Province</option>
                        <option value="Eastern Province" <?php if(esc_attr( $address_state ) == 'Eastern Province'){ echo "Selected"; }else{} ?>>Eastern Province</option>
                    </select>
                </div>
                */ ?>
                
            <?php/* } else {
                    $required_attr = '';
                    if ( $seller_address_fields['state']['required'] ) {
                        $required_attr = 'required';
                    }
                ?>
                <select <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> name="dokan_address[state]" class="rrrrttt dokan-form-control" id="dokan_address_state">
                    <?php dokan_state_dropdown( $states[$address_country], $address_state ) ?>
                </select>
            <?php } ?>
            </div>
        <?php } */?>
        <div  id="dokan-states-box" class="dokan-form-group hidestateinput">
        <label class="dokan-w3 control-label" for="dokan_address[state]"><?php esc_html_e( 'State ', 'dokan-lite' ); ?></label>
        <input <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> name="dokan_address[state]" Placeholder="State" class="statefield_clean dokan-form-control <?php echo esc_attr( $address_state_class ) ?>" id="dokan_address_state" value="<?php echo esc_attr( $address_state ) ?>"/>
        </div>
        <div  id="dokan-states-box" class="dokan-form-group showstateinput">
            <label class="dokan-w3 control-label" for="dokan_address[state]"><?php esc_html_e( 'State ', 'dokan-lite' ); ?></label>
            <select name="dokan_address[state]" class="removename dokan-form-control <?php echo esc_attr( $address_state_class ) ?>" id="dokan_address_state">
                <option value="">Select State/Province</option>
                <option value="Kigali" <?php if(esc_attr( $address_state ) == 'Kigali'){ echo "Selected"; }else{  } ?>>Kigali </option>
                <option value="Northern Province" <?php if(esc_attr( $address_state ) == 'Northern Province'){ echo "Selected"; }else{  } ?>>Northern Province </option>
                <option value="Southern Province" <?php if(esc_attr( $address_state ) == 'Southern Province'){ echo "Selected"; }else{  } ?>>Southern Province</option>
                <option value="Eastern Province" <?php if(esc_attr( $address_state ) == 'Eastern Province'){ echo "Selected"; }else{  } ?>>Eastern Province</option>
            </select>
        </div>
        </fieldset>
         
    </div>
    
    </div>
    <?php /*
    <div class="two">
        <label class="dokan-w3 dokan-control-label" for="setting_address"><?php esc_html_e( 'Address', 'dokan-lite' ); ?></label>
    
    <div class="dokan-w5 dokan-text-left dokan-address-fields">
      <?php if ( $seller_address_fields['street_1'] ) { ?>
            
                <div class="dokan-form-group">
                <label class="dokan-w3 control-label" for="dokan_address[street_1]"><?php esc_html_e( 'Street ', 'dokan-lite' ); ?>
                    <?php
                    $required_attr = '';
                    if ( $seller_address_fields['street_1']['required'] ) {
                        $required_attr = 'required'; ?>
                        <span class="required"> *</span>
                    <?php } ?>
                </label>
                <input <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> id="dokan_address[street_1]" value="<?php echo esc_attr( $address_street1 ); ?>" name="dokan_address[street_1]" placeholder="<?php esc_attr_e( 'Street address' , 'dokan-lite' ) ?>" class="ghghgh dokan-form-control input-md" type="text">
			<div class="rwanda_address_notice dokan-w12">
				If not street address available you must have to put city/state in street address field for rwanda country*
				<br>
			</div>
            </div>
            
        <?php }
        if ( $seller_address_fields['street_2'] ) { ?>
            <div class="dokan-form-group">
                <label class="dokan-w3 control-label" for="dokan_address[street_2]"><?php esc_html_e( 'Street 2', 'dokan-lite' ); ?>
                    <?php
                    $required_attr = '';
                    if ( $seller_address_fields['street_2']['required'] ) {
                        $required_attr = 'required'; ?>
                        <span class="required"> *</span>
                    <?php } ?>
                </label>
                <input <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> id="dokan_address[street_2]" value="<?php echo esc_attr( $address_street2 ); ?>" name="dokan_address[street_2]" placeholder="<?php esc_attr_e( 'Apartment, suite, unit etc. (optional)' , 'dokan-lite' ) ?>" class="dokan-form-control input-md" type="text">
            </div>
        <?php }
        if ( $seller_address_fields['city'] || $seller_address_fields['zip'] ) {
        ?>
            <div class="dokan-from-group">
                <?php if ( $seller_address_fields['city'] ) { ?>
                    <div class="dokan-form-group dokan-w6 dokan-left dokan-right-margin-30">
                        <label class="control-label" for="dokan_address[city]"><?php esc_html_e( 'City', 'dokan-lite' ); ?>
                            <?php
                            $required_attr = '';
                            if ( $seller_address_fields['city']['required'] ) {
                                $required_attr = 'required'; ?>
                                <span class="required"> *</span>
                            <?php } ?>
                        </label>
                        <div class="cityyhide <?php echo $address_city; ?>">
                            
                        <input <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> id="dokan_address[city]" value="<?php echo esc_attr( $address_city ); ?>" name="dokan_address[city]" placeholder="<?php esc_attr_e( 'Town / City' , 'dokan-lite' ) ?>" class="dokan-form-control input-md" type="text">
                        </div>
                        
                        <div class="cityshow">
                        <select id="dokan_address[city]"  name="dokan_address[city]" class="dokan-form-control input-md">
                        <option value="Kicukiro" <?php if(esc_attr( $address_city ) == 'Kicukiro'){ echo "Selected"; }else{} ?>>Kicukiro </option>
                        <option value="Gasabo" <?php if(esc_attr( $address_city ) == 'Gasabo'){ echo "Selected"; }else{} ?>>Gasabo </option>
                        <option value="Nyarugenge" <?php if(esc_attr( $address_city ) == 'Nyarugenge'){ echo "Selected"; }else{} ?>>Nyarugenge</option>
                        <option value="Burera" <?php if(esc_attr( $address_city ) == 'Burera'){ echo "Selected"; }else{} ?>>Burera</option>
                        <option value="Gakenke" <?php if(esc_attr( $address_city ) == 'Gakenke'){ echo "Selected"; }else{} ?>>Gakenke </option>
                        <option value="Gicumbi" <?php if(esc_attr( $address_city ) == 'Gicumbi'){ echo "Selected"; }else{} ?>>Gicumbi</option>
                        <option value="Musanze" <?php if(esc_attr( $address_city ) == 'Musanze'){ echo "Selected"; }else{} ?>>Musanze</option>
                        <option value="Rulindo" <?php if(esc_attr( $address_city ) == 'Rulindo'){ echo "Selected"; }else{} ?>>Rulindo </option>
                        <option value="Gisagara" <?php if(esc_attr( $address_city ) == 'Gisagara'){ echo "Selected"; }else{} ?>>Gisagara</option>
                        <option value="Huye" <?php if(esc_attr( $address_city ) == 'Huye'){ echo "Selected"; }else{} ?>>Huye</option>
                        <option value="Kamonyi" <?php if(esc_attr( $address_city ) == 'Kamonyi'){ echo "Selected"; }else{} ?>>Kamonyi </option>
                        <option value="Muhanga" <?php if(esc_attr( $address_city ) == 'Muhanga'){ echo "Selected"; }else{} ?>>Muhanga</option>
                        <option value="Nyamagabe" <?php if(esc_attr( $address_city ) == 'Nyamagabe'){ echo "Selected"; }else{} ?>>Nyamagabe</option>
                        <option value="Nyanza" <?php if(esc_attr( $address_city ) == 'Nyanza'){ echo "Selected"; }else{} ?>>Nyanza</option>
                        <option value="Nyaruguru" <?php if(esc_attr( $address_city ) == 'Nyaruguru'){ echo "Selected"; }else{} ?>>Nyaruguru</option>
                        <option value="Ruhango" <?php if(esc_attr( $address_city ) == 'Ruhango'){ echo "Selected"; }else{} ?>>Ruhango</option>
                        <option value="Bugesera" <?php if(esc_attr( $address_city ) == 'Bugesera'){ echo "Selected"; }else{} ?>>Bugesera</option>
                        <option value="Gatsibo" <?php if(esc_attr( $address_city ) == 'Gatsibo'){ echo "Selected"; }else{} ?>>Gatsibo</option>
                        <option value="Kayonza" <?php if(esc_attr( $address_city ) == 'Kayonza'){ echo "Selected"; }else{} ?>>Kayonza</option>
                        <option value="Kirehe" <?php if(esc_attr( $address_city ) == 'Kirehe'){ echo "Selected"; }else{} ?>>Kirehe</option>
                        <option value="Ngoma" <?php if(esc_attr( $address_city ) == 'Ngoma'){ echo "Selected"; }else{} ?>>Ngoma</option>
                        <option value="Nyagatare" <?php if(esc_attr( $address_city ) == 'Nyagatare'){ echo "Selected"; }else{} ?>>Nyagatare</option>
                        <option value="Rwamagana" <?php if(esc_attr( $address_city ) == 'Rwamagana'){ echo "Selected"; }else{} ?>>Rwamagana</option>
                        <option value="Karongi" <?php if(esc_attr( $address_city ) == 'Karongi'){ echo "Selected"; }else{} ?>>Karongi</option>
                        <option value="Nyabihu" <?php if(esc_attr( $address_city ) == 'Nyabihu'){ echo "Selected"; }else{} ?>>Nyabihu</option>
                        <option value="Nyamasheke" <?php if(esc_attr( $address_city ) == 'Nyamasheke'){ echo "Selected"; }else{} ?>>Nyamasheke</option>
                        <option value="Rubavu" <?php if(esc_attr( $address_city ) == 'Rubavu'){ echo "Selected"; }else{} ?>>Rubavu</option>
                        <option value="Rusizi" <?php if(esc_attr( $address_city ) == 'Rusizi'){ echo "Selected"; }else{} ?>>Rusizi</option>
                        <option value="Rutsiro" <?php if(esc_attr( $address_city ) == 'Rutsiro'){ echo "Selected"; }else{} ?>>Rutsiro</option>
                    </select>
                </div>
                        
                    </div>
                <?php }
                if ( $seller_address_fields['zip'] ) { ?>
                    <div class="dokan-form-group dokan-w5 dokan-left">
                        <label class="control-label" for="dokan_address[zip]"><?php esc_html_e( 'Post/ZIP Code', 'dokan-lite' ); ?>
                            <?php
                            $required_attr = '';
                            if ( $seller_address_fields['zip']['required'] ) {
                                $required_attr = 'required'; ?>
                                <span class="required"> *</span>
                            <?php } ?>
                        </label>
                        <input <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> id="dokan_address[zip]" value="<?php echo esc_attr( $address_zip ); ?>" name="dokan_address[zip]" placeholder="<?php esc_attr_e( 'Postcode / Zip' , 'dokan-lite' ) ?>" class="dokan-form-control dokan-address-zip input-md" type="text">
                    </div>
                <?php } ?>
                <div class="dokan-clearfix"></div>
            </div>
        <?php }

        if ( $seller_address_fields['country'] ) {
            $country_obj   = new WC_Countries();
            $countries     = $country_obj->countries;
            $states        = $country_obj->states;
        ?>
            <div class="dokan-form-group">
                <label class="control-label" for="dokan_address[country]"><?php esc_html_e( 'Country ', 'dokan-lite' ); ?>
                    <?php
                    $required_attr = '';
                    if ( $seller_address_fields['country']['required'] ) {
                        $required_attr = 'required'; ?>
                        <span class="required"> *</span>
                    <?php } ?>
                </label>
                <select <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> name="dokan_address[country]" class="country_to_state dokan-form-control" id="dokan_address_country">
                    <?php dokan_country_dropdown( $countries, $address_country, false ); ?>
                </select>
            </div>
        <?php }
        if ( $seller_address_fields['state'] ) {
            $address_state_class = '';
            $is_input            = false;
            $no_states           = false;
            if ( isset( $states[$address_country] ) ) {
                if ( empty( $states[$address_country] ) ) {
                    $address_state_class = 'dokan-hide';
                    $no_states           = true;
                }
            } else {
                $is_input = true;
            }
        ?>
            <div  id="dokan-states-box" class="dokan-form-group">
                <label class="dokan-w3 control-label" for="dokan_address[state]"><?php esc_html_e( 'State ', 'dokan-lite' ); ?>
                    <?php
                    $required_attr = '';
                    if ( $seller_address_fields['state']['required'] ) {
                        $required_attr = 'required'; ?>
                        <span class="required"> *</span>
                    <?php } ?>
                </label>
            <?php if ( $is_input ) {
                    $required_attr = '';
                    if ( $seller_address_fields['state']['required'] ) {
                        $required_attr = 'required';
                    }
                    ?>
                    
                 <div class="hideshow">
                <input <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> name="dokan_address[state]" class="dsdsd dokan-form-control <?php echo esc_attr( $address_state_class ) ?>" id="dokan_address_state" value="<?php echo esc_attr( $address_state ) ?>"/>
                </div>
                
                <div class="printselect">
                    <select name="dokan_address[state]" class="dsdsd dokan-form-control <?php echo esc_attr( $address_state_class ) ?>" id="dokan_address_state">
                        <option>Select Province</option>
                        <option value="Kigali" <?php if(esc_attr( $address_state ) == 'Kigali'){ echo "Selected"; }else{} ?>>Kigali </option>
                        <option value="Northern Province" <?php if(esc_attr( $address_state ) == 'Northern Province'){ echo "Selected"; }else{} ?>>Northern Province </option>
                        <option value="Southern Province" <?php if(esc_attr( $address_state ) == 'Southern Province'){ echo "Selected"; }else{} ?>>Southern Province</option>
                        <option value="Eastern Province" <?php if(esc_attr( $address_state ) == 'Eastern Province'){ echo "Selected"; }else{} ?>>Eastern Province</option>
                    </select>
                </div>
                
            <?php } else {
                    $required_attr = '';
                    if ( $seller_address_fields['state']['required'] ) {
                        $required_attr = 'required';
                    }
                ?>
                <select <?php echo esc_attr( $required_attr ); ?> <?php echo esc_attr( $disabled ) ?> name="dokan_address[state]" class="rrrrttt dokan-form-control" id="dokan_address_state">
                    <?php dokan_state_dropdown( $states[$address_country], $address_state ) ?>
                </select>
            <?php } ?>
            </div>
        <?php } ?>
    </div>
    </div>
    */ ?>
</div>
