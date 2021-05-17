<?php 

if ( ! function_exists( 'cus_martfury_extra_account' ) ) :

	function cus_martfury_extra_account() {
		$extras = martfury_menu_extras();
		if ( empty( $extras ) || ! in_array( 'account', $extras ) ) {
			return;
		}

		if ( is_user_logged_in() ) {
			$user_menu = martfury_nav_vendor_menu();
			$user_id   = get_current_user_id();
			if ( empty( $user_menu ) ) {
				$user_menu = martfury_nav_user_menu();
			}
			$logout_witoutnonce = home_url().'/wp-login.php?action=logout&redirect_to='.home_url().'/my-account';
			$account      = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			$account_link = $account;
			$author       = get_user_by( 'id', $user_id );
			//$author_name  = $author->display_name;
			$author_name  = $author->user_firstname. " " .$author->user_lastname;
			if(empty($author->user_firstname)){
				$author_name  = $author->display_name;
				}

			$logged_type = '<i class="extra-icon icon-user"></i>';
			$user_type   = 'icon';

			if ( martfury_get_option( 'user_logged_type' ) == 'avatar' ) {
				$logged_type = get_avatar( $user_id, 32 );
				$user_type   = 'avatar';
			}

			if ( class_exists( 'WeDevs_Dokan' ) && in_array( 'seller', $author->roles ) ) {

				$account_link = function_exists( 'dokan_get_navigation_url' ) ? dokan_get_navigation_url() : $account_link;
				$shop_info    = get_user_meta( $user_id, 'dokan_profile_settings', true );
				if ( $shop_info && isset( $shop_info['store_name'] ) && $shop_info['store_name'] ) {
					$author_name = $shop_info['store_name'];
				}

			} elseif ( class_exists( 'WCVendors_Pro' ) && in_array( 'vendor', $author->roles ) ) {

				$dashboard_page_id = get_option( 'wcvendors_dashboard_page_id' );
				$dashboard_page_id = is_array( $dashboard_page_id ) ? $dashboard_page_id[0] : $dashboard_page_id;
				if ( $dashboard_page_id ) {
					$account_link = get_permalink( $dashboard_page_id );
				}

			} elseif ( class_exists( 'WC_Vendors' ) && in_array( 'vendor', $author->roles ) ) {
				$vendor_dashboard_page = get_option( 'wcvendors_vendor_dashboard_page_id' );
				$account_link          = get_permalink( $vendor_dashboard_page );

			} elseif ( class_exists( 'WCMp' ) && in_array( 'dc_vendor', $author->roles ) ) {
				if ( function_exists( 'wcmp_vendor_dashboard_page_id' ) && wcmp_vendor_dashboard_page_id() ) {
					$account_link = get_permalink( wcmp_vendor_dashboard_page_id() );
				}

				if ( function_exists( 'get_wcmp_vendor' ) ) {

					$store_user  = get_wcmp_vendor( $user_id );
					$author_name = $store_user->page_title;
				}

			} elseif ( function_exists( 'wcfm_is_vendor' ) && wcfm_is_vendor() ) {

				$pages = get_option( "wcfm_page_options" );

				if ( isset( $pages['wc_frontend_manager_page_id'] ) && $pages['wc_frontend_manager_page_id'] ) {
					$account_link = get_permalink( $pages['wc_frontend_manager_page_id'] );
				}
				global $WCFM;
				$author_name = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_name_by_vendor( absint( $user_id ) );

				if ( function_exists( 'wcfmmp_get_store' ) && martfury_get_option( 'user_logged_type' ) == 'avatar' ) {

					$store_user  = wcfmmp_get_store( $user_id );
					$logged_type = sprintf( '<img src="%s" alt="%s">', esc_url( $store_user->get_avatar() ), esc_html__( 'Logo', 'martfury' ) );
				}

			}

			echo sprintf(

				'<li class="extra-menu-item menu-item-account logined %s">
				<a href="%s">%s</a>
				<ul>
					<li>
						<h3>%s</h3>
					</li>
					<li>
						%s
					</li>
					<li class="line-space 11"></li>
					<li class="logout">
						<a href="%s">%s</a>
					</li>
				</ul>
			</li>',
				esc_attr( $user_type ),
				esc_url( $account_link ),
				$logged_type,
				esc_html__( 'Hello,', 'martfury' ) . ' ' . $author_name . '!',
				implode( ' ', $user_menu ),
				esc_url( $logout_witoutnonce ),
				esc_html__( 'Logout', 'martfury' )
			);

		} else {

			
			$register      = '';
			$register_text = esc_html__( 'Register', 'martfury' );

			if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
				$register = sprintf(
					'<li class="extra-menu-item menu-item-account" ><a href="%s?popup=register" class="item-register cus-item-register" id="menu-extra-register"><img src="'.get_stylesheet_directory_uri().'/image/sign-up-icon.png" class="sign-up-icon">%s</a></li>',
					esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
					$register_text
				);
			}


			echo sprintf(
				'<li class="extra-menu-item menu-item-account" style="padding-right: 15px !important;">
					<a href="%s" id="menu-extra-login" class="cus-menu-extra-login"><i class="extra-icon icon-user"></i>%s</a>
					
				</li>%s',
				esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
				esc_html__( 'Log in', 'martfury' ),
				$register
			);
		}
	}
endif;

if ( ! function_exists( 'martfury_extra_account' ) ) :
	function martfury_extra_account() {
		$extras = martfury_menu_extras();

		if ( empty( $extras ) || ! in_array( 'account', $extras ) ) {
			return;
		}

		if ( is_user_logged_in() ) {
			$user_menu = martfury_nav_vendor_menu();
			$user_id   = get_current_user_id();
			if ( empty( $user_menu ) ) {
				$user_menu = martfury_nav_user_menu();
			}
			$account      = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			$account_link = $account;
			$author       = get_user_by( 'id', $user_id );
			//$author_name  = $author->display_name;
			$author_name  = $author->user_firstname. " " .$author->user_lastname;
			if(empty($author->user_firstname)){
				$author_name  = $author->display_name;
				}
			$logged_type = '<i class="extra-icon icon-user"></i>';
			$user_type   = 'icon';
			if ( martfury_get_option( 'user_logged_type' ) == 'avatar' ) {
				$logged_type = get_avatar( $user_id, 32 );
				$user_type   = 'avatar';
			}


			if ( class_exists( 'WeDevs_Dokan' ) && in_array( 'seller', $author->roles ) ) {
				$account_link = function_exists( 'dokan_get_navigation_url' ) ? dokan_get_navigation_url() : $account_link;
				$shop_info    = get_user_meta( $user_id, 'dokan_profile_settings', true );
				if ( $shop_info && isset( $shop_info['store_name'] ) && $shop_info['store_name'] ) {
					$author_name = $shop_info['store_name'];
				}
			} elseif ( class_exists( 'WCVendors_Pro' ) && in_array( 'vendor', $author->roles ) ) {
				$dashboard_page_id = get_option( 'wcvendors_dashboard_page_id' );
				$dashboard_page_id = is_array( $dashboard_page_id ) ? $dashboard_page_id[0] : $dashboard_page_id;
				if ( $dashboard_page_id ) {
					$account_link = get_permalink( $dashboard_page_id );
				}

			} elseif ( class_exists( 'WC_Vendors' ) && in_array( 'vendor', $author->roles ) ) {
				$vendor_dashboard_page = get_option( 'wcvendors_vendor_dashboard_page_id' );
				$account_link          = get_permalink( $vendor_dashboard_page );

			} elseif ( class_exists( 'WCMp' ) && in_array( 'dc_vendor', $author->roles ) ) {
				if ( function_exists( 'wcmp_vendor_dashboard_page_id' ) && wcmp_vendor_dashboard_page_id() ) {
					$account_link = get_permalink( wcmp_vendor_dashboard_page_id() );
				}
				if ( function_exists( 'get_wcmp_vendor' ) ) {
					$store_user  = get_wcmp_vendor( $user_id );
					$author_name = $store_user->page_title;
				}
			} elseif ( function_exists( 'wcfm_is_vendor' ) && wcfm_is_vendor() ) {
				$pages = get_option( "wcfm_page_options" );
				if ( isset( $pages['wc_frontend_manager_page_id'] ) && $pages['wc_frontend_manager_page_id'] ) {
					$account_link = get_permalink( $pages['wc_frontend_manager_page_id'] );
				}
				global $WCFM;
				$author_name = $WCFM->wcfm_vendor_support->wcfm_get_vendor_store_name_by_vendor( absint( $user_id ) );

				if ( function_exists( 'wcfmmp_get_store' ) && martfury_get_option( 'user_logged_type' ) == 'avatar' ) {
					$store_user  = wcfmmp_get_store( $user_id );
					$logged_type = sprintf( '<img src="%s" alt="%s">', esc_url( $store_user->get_avatar() ), esc_html__( 'Logo', 'martfury' ) );
				}

			}

			echo sprintf(
				'<li class="extra-menu-item menu-item-account logined %s">
				<a href="%s">%s</a>
				<ul>
					<li>
						<h3>%s</h3>
					</li>
					<li>
						%s
					</li>
					<li class="line-space 12"></li>
					<li class="logout">
						<a href="%s">%s</a>
					</li>
				</ul>
			</li>',
				esc_attr( $user_type ),
				esc_url( $account_link ),
				$logged_type,
				esc_html__( 'Hello,', 'martfury' ) . ' ' . $author_name . '!',
				implode( ' ', $user_menu ),
				esc_url( wp_logout_url( $account ) ),
				esc_html__( 'Logout', 'martfury' )
			);
		} else {

			$register      = '';
			$register_text = esc_html__( 'Register', 'martfury' );

			if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
				$register = sprintf(
					'<a href="%s" class="item-register" id="menu-extra-register">%s</a>',
					esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
					$register_text
				);
			}

			echo sprintf(
				'<li class="extra-menu-item menu-item-account">
					<a href="%s" id="menu-extra-login"><i class="extra-icon icon-user"></i>%s</a>
					%s
				</li>',
				esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
				esc_html__( 'Log in', 'martfury' ),
				$register
			);
		}


	}
endif;



if ( ! function_exists( 'martfury_vendor_navigation_url' ) ) :
	function martfury_vendor_navigation_url() {
		$author   = get_user_by( 'id', get_current_user_id() );
		$vendor   = array();
		$vendor[] = '<ul>';
		if ( function_exists( 'dokan_get_navigation_url' ) && in_array( 'seller', $author->roles ) ) {
			$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( dokan_get_navigation_url() ), esc_html__( 'Dashboard', 'martfury' ) );
			$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ), esc_html__( 'Dashboard (Customer)', 'martfury' ) );
			$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( dokan_get_navigation_url( 'products' ) ), esc_html__( 'Products', 'martfury' ) );
			$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( dokan_get_navigation_url( 'orders' ) ), esc_html__( 'Orders', 'martfury' ) );
			$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( dokan_get_navigation_url( 'edit-account' ) ), esc_html__( 'Settings', 'martfury' ) );
			if ( function_exists( 'dokan_get_store_url' ) ) {
				$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( dokan_get_store_url( get_current_user_id() ) ), esc_html__( 'Visit Store', 'martfury' ) );
			}
			$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( dokan_get_navigation_url( 'withdraw' ) ), esc_html__( 'Withdraw', 'martfury' ) );
		} elseif ( class_exists( 'WCVendors_Pro' ) && in_array( 'vendor', $author->roles ) ) {
			$dashboard_page_id = get_option( 'wcvendors_dashboard_page_id' );
			$dashboard_page_id = is_array( $dashboard_page_id ) ? $dashboard_page_id[0] : $dashboard_page_id;
			if ( $dashboard_page_id ) {
				$dashboard_page_url = get_permalink( $dashboard_page_id );
				$vendor[]           = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $dashboard_page_url ), esc_html__( 'Dashboard', 'martfury' ) );
				$vendor[]           = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $dashboard_page_url . 'product' ), esc_html__( 'Products', 'martfury' ) );
				$vendor[]           = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $dashboard_page_url . 'order' ), esc_html__( 'Orders', 'martfury' ) );
				$vendor[]           = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $dashboard_page_url . 'settings' ), esc_html__( 'Settings', 'martfury' ) );
			}
		} elseif ( class_exists( 'WC_Vendors' ) && in_array( 'vendor', $author->roles ) ) {
			$vendor_dashboard_page = get_option( 'wcvendors_vendor_dashboard_page_id' );
			$shop_settings_page    = get_option( 'wcvendors_shop_settings_page_id' );

			if ( ! empty( $vendor_dashboard_page ) && ! empty( $shop_settings_page ) ) {
				if ( ! empty( $vendor_dashboard_page ) ) {
					$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( $vendor_dashboard_page ) ), esc_html__( 'Dashboard', 'martfury' ) );
				}
				if ( ! empty( $shop_settings_page ) ) {
					$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( $shop_settings_page ) ), esc_html__( 'Shop Settings', 'martfury' ) );
				}
				if ( class_exists( 'WCV_Vendors' ) ) {
					$shop_page = WCV_Vendors::get_vendor_shop_page( get_current_user_id() );
					$vendor[]  = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $shop_page ), esc_html__( 'Visit Store', 'martfury' ) );
				}
			}

		}

		$vendor[] = '</ul>';

		return $vendor;
	}
endif;