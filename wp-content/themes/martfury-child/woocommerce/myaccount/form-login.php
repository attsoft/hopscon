<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$login_actived = true;
if ( ! empty( $_POST ) && isset( $_POST['woocommerce-register-nonce'] ) && ! empty( $_POST['woocommerce-register-nonce'] ) ) {
	$login_actived = false;
}

$login_form_layout = martfury_get_option( 'login_register_layout' );
$login_layout      = 'martfury-login-' . $login_form_layout;
if ( $login_form_layout == 'promotion' ) {
	$login_layout .= ' martfury-login-tabs';
}

?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php

if (isset($_GET['popup']) && $_GET['popup'] == 'register') {
  # code...
  $login_actived = false;
  $class = 'active';
}
$login_class     = $login_actived ? 'active' : '';
$register_class  = ! $login_actived ? 'active' : '';
$col_login_class = 'col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3';
if ( $login_form_layout == 'promotion' ) {
	$col_login_class = 'col-md-5 col-sm-12';
}
?>

<div class="customer-login">

    <div class="row">

        <div class="<?php echo esc_attr( $col_login_class ); ?> col-login">
            <div class="<?php echo esc_attr( $login_layout ); ?>">
                <ul class="tabs-nav">
                    <li class="<?php echo esc_attr( $login_class ); ?>"><a href="#"
                                          class="<?php echo esc_attr( $login_class ); ?>"><?php esc_html_e( 'Log in', 'martfury' ); ?></a>
                    </li>
					<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>
                        <li class="<?php echo esc_attr( $register_class ); ?>"><a class="<?php echo esc_attr( $register_class ); ?>"
                               href="#"><?php esc_html_e( 'Register', 'martfury' ); ?></a></li>
					<?php endif; ?>
                </ul>
                <div class="tabs-content">

                    <div class="tabs-panel <?php echo esc_attr( $login_class ); ?>">

                        <h2><?php esc_html_e( 'Log In Your Account', 'martfury' ); ?></h2>

                        <form id="woo_login_form" class="woocommerce-form woocommerce-form-login login" method="post">

							<?php do_action( 'woocommerce_login_form_start' ); ?>

                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" required
                                       placeholder="<?php esc_attr_e( 'Username or email address', 'martfury' ); ?>"
                                       name="username" id="username" autocomplete="username"
                                       value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>"/>
                            </p>

                            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide form-row-password">
                                <input class="woocommerce-Input woocommerce-Input--text input-text" required
                                       placeholder="<?php esc_attr_e( 'Password', 'martfury' ); ?>" type="password"
                                       autocomplete="current-password"
                                       name="password" id="password"/>
                            </p>

							<?php do_action( 'woocommerce_login_form' ); ?>

                            <p class="form-row">
                                <span class="woocommerce-form-row__remember">
                                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                                        <input class="woocommerce-form__input woocommerce-form__input-checkbox"
                                               name="rememberme" type="checkbox" id="rememberme" value="forever"/>
                                        <span><?php esc_html_e( 'Remember me', 'martfury' ); ?></span>
                                     </label>
                                   <a class="lost-password"
                                      href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot your password?', 'martfury' ); ?></a>
                                </span>

								<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                                <button type="submit" class="woocommerce-Button button" name="login"
                                        value="<?php esc_attr_e( 'Log in', 'martfury' ); ?>"><?php esc_html_e( 'Log in', 'martfury' ); ?></button>
                            </p>

							<?php do_action( 'woocommerce_login_form_end' ); ?>

                        </form>
                    </div>

					<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

                        <div class="tabs-panel <?php echo esc_attr( $register_class ); ?>">

                            <center>                            

                            <h2><?php esc_html_e( 'Register An Account For Free', 'martfury' ); ?></h2>
                            <h2><?php esc_html_e( 'Already have an account? ', 'martfury' ); ?>
                              <u> 
                                <a class="" href="<?php echo site_url('/my-account'); ?>"> Login</a>
                              </u>
                            </h2>

                            </center>

                            <form method="post" class="register woocommerce-form woocommerce-form-register">
								
                                <ul class="donate-now">
                                  
                                  <li>
                                    <input type="radio" id="vendor" name="user_chose" value="vendor" />
                                    <label for="vendor">Business Owner</label>
                                  </li>
                                  <li>
                                    <input type="radio" id="driver" name="user_chose" value="driver" />
                                    <label for="driver">Driver</label>
                                  </li>
                                  <li>
                                    <input type="radio" id="customer" name="user_chose" checked="checked" value="customer"/>
                                    <label for="customer">Customer</label>
                                  </li>
                                </ul>
                                <div style="clear:both; padding-top: 10px;"></div>

                                
								<?php do_action( 'woocommerce_register_form_start' ); ?>

                <input type="hidden" id="selected_role" name="selected_role" value="customer" />

								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                        <input type="text" required 
                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                               placeholder="<?php esc_attr_e( 'Username', 'martfury' ); ?>"
                                               name="username" id="reg_username" autocomplete="username"
                                               value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( $_POST['username'] ) : ''; ?>"/>
                                    </p>

								<?php endif; ?>

                                <!-- <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                    <input type="email" required
                                           class="woocommerce-Input woocommerce-Input--text input-text"
                                           placeholder="<?php esc_attr_e( 'Email address', 'martfury' ); ?>"
                                           name="email" id="reg_email" autocomplete="email"
                                           value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( $_POST['email'] ) : ''; ?>"/>
                                </p> -->

                                <p class="form-row form-group">
                                  <label for="reg_email"><?php esc_html_e( 'Email address', 'martfury' ); ?>
                                    <span class="required">*</span>
                                  </label>
                                  <input type="email" required class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Email address', 'martfury' ); ?>" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( $_POST['email'] ) : ''; ?>"/>
                                </p>

                                <p class="form-row form-group confirm_email_address_user">
                                  <label for="confirm_email"><?php esc_html_e( 'Confirm Email address', 'martfury' ); ?>
                                    <span class="required">*</span>
                                  </label>
                                  <input type="email" required class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Confirm Email address', 'martfury' ); ?>" name="confirm_email" id="confirm_email" autocomplete="confirm_email" value="<?php echo ( ! empty( $_POST['confirm_email'] ) ) ? esc_attr( $_POST['confirm_email'] ) : ''; ?>"/>
                                </p>

								<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                                    <!-- <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                                        <input type="password" required
                                               placeholder="<?php esc_attr_e( 'Password', 'martfury' ); ?>"
                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                               autocomplete="new-password"
                                               name="password" id="reg_password"/>
                                    </p> -->

                                <p class="form-row form-group">
                                  <label for="password"><?php esc_html_e( 'Password', 'martfury' ); ?>
                                    <span class="required">*</span>
                                  </label>
                                  <input type="password" required
                                               placeholder="<?php esc_attr_e( 'Password', 'martfury' ); ?>"
                                               class="woocommerce-Input woocommerce-Input--text input-text"
                                               autocomplete="new-password"
                                               name="password" id="reg_password"/>
                                </p>

								<?php else : ?>

                                    <p><?php esc_html_e( 'A password will be sent to your email address.', 'martfury' ); ?></p>

								<?php endif; ?>

                

                

								<?php do_action( 'woocommerce_register_form' ); ?>
                  


                 <?php /*?> <p class="form-row form-group form-row-wide send_otp_msg_row">

                    <label for="customer-phone"><?php esc_html_e( 'Phone Number', 'martfury' ); ?>

                      <span class="required">*</span></label>

                      <input type="text" class="input-text form-control customer_phone" name="phone" id="customer-phone" value="<?php if ( ! empty( $_POST['phone'] ) ) { echo esc_attr( $_POST['phone'] ); } ?>" required="required" />
                      <input type="hidden" name="sendedotp" id="sendedotp" value="">
                      <span class="send_otp_msg" onclick="get_otp(this);">Get OTP</span>
                       <span class="loading_icn" style="display:none;"><img src="<?php echo get_stylesheet_directory_uri().'/image/preloader.gif'; ?>" width="30px"></span>
                       <span class="otp_msg"></span>

                  </p>            
                  <p class="form-row form-group vefify_otp_row">
                      <label for="vefify_otp"><?php esc_html_e( 'Vefify OTP', 'martfury' ); ?>
                        <span class="required">*</span>
                      </label>
                      <input type="text" required class="woocommerce-Input woocommerce-Input--text input-text"
                                 autocomplete="vefify_otp"
                                 name="vefify_otp" id="vefify_otp"/>
                     <span class="send_otp_verify" onclick="verify_otp(this);">Verify</span>
                     <span class="loading_icn_vr" style="display:none;"><img src="<?php echo get_stylesheet_directory_uri().'/image/preloader.gif'; ?>" width="30px"></span>
                     <span class="very_msg"></span>
                  </p>


                  <p class="form-row form-group">
                      <label for="dob"><?php esc_html_e( 'DOB', 'martfury' ); ?>
                        <span class="required">*</span>
                      </label>
                      <input type="date" required class="woocommerce-Input woocommerce-Input--text input-text"
                                 autocomplete="dob"
                                 name="dob" id="dob"/>
                  </p><?php */?>
                  
                   <!-- <p class="form-row form-group email_ques">
                      <label for="dob"><?php //esc_html_e( 'Opt-in for Email Marketing', 'martfury' ); ?><span class="required">*</span>
                      </label>
                      <label for="question1" class="inner_em"><input type="checkbox" id="question1" name="question1" value="question1"> 
                     Recive all Notification Email.</label><br>
  					<label for="question2" class="inner_em"><input type="checkbox" id="question2" name="question2" value="question2">
  					 Recive only Event Email.</label><br>
  					<label for="question3" class="inner_em"><input type="checkbox" id="question3" name="question3" value="question3">
  					 Don't want to recive any Email.</label><br><br>
                     <div class="wpuf-fields" data-required="yes" data-type="radio">
					<label class="wpuf-radio-inline">
                            <input name="email_marketing_question" class="wpuf_email_marketing_question_3788" type="radio" value="yes" required>
                            Yes </label>
                        
                        <label class="wpuf-radio-inline">
                            <input name="email_marketing_question" class="wpuf_email_marketing_question_3788" type="radio" value="no">
                            No                        </label>
                        
                
            </div>
                  </p> -->
                  
                   <p class="form-row form-group term_cond">
                     
                      <label for="question1"><!--<input type="checkbox" id="cus_termcon" name="cus_termcon" value="cus_termcon" required>--> 
                      By registering you accept HoPscan's <a href="<?php echo home_url(); ?>/term-conditions/" target="_blank"> Terms and Conditions</a> and <a href="<?php echo home_url(); ?>/policy/" target="_blank">Privacy Policy</a> and allow HoPscan to contact you and send you marketing communications using the contact details you have provided to us.</label>
                  </p>
					


                                <p class="woocommerce-form-row form-row register_sub">
									<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                                    <button type="submit" class="woocommerce-Button button cus_wc_regiester" name="register"
                                            value="<?php esc_attr_e( 'Register', 'martfury' ); ?>"><?php esc_html_e( 'Register', 'martfury' ); ?></button>
                                       
                                </p>
<p style="clear:both;"></p>
								<?php do_action( 'woocommerce_register_form_end' ); ?>

                            </form>

                        </div>

					<?php endif; ?>

                </div>
            </div>
        </div>

		<?php do_action( 'martfury_after_login_form' ); ?>

    </div>
</div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
