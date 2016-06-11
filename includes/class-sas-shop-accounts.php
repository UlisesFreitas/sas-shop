<?php
class Sas_Shop_Accounts {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct($version, $plugin_name) {


		$this->plugin_name = $plugin_name;
		$this->version = $version;




		// Redirects
		//add_action( 'login_form_login', array( $this, 'sas_shop_redirect_to_sas_login' ) );
		//add_filter( 'authenticate', array( $this, 'sas_shop_maybe_redirect_at_authenticate' ), 101, 3 );
		//add_filter( 'login_redirect', array( $this, 'sas_shop_redirect_after_login' ), 10, 3 );


		// User contact info
		//add_filter('user_contactmethods', array($this,'sas_shop_add_contact_methods'), 10, 2 );




	}

	//
	// REDIRECT FUNCTIONS
	//

	public function sas_shop_prevent_direct_access_to_login(){

		global $pagenow;
		if( $pagenow === 'wp-login.php' &&  $_SERVER['REQUEST_METHOD'] == 'GET' ){

			parse_str($_SERVER['QUERY_STRING'], $params);
			if(empty($params)){
				$login_url = get_option( 'sas_shop_sas-shop-login_page_id' );
				$login_url =  get_the_permalink( $login_url ) ;
				wp_redirect( $login_url );
				exit;
			}

		}
	}


	/**
	 * Redirect the user to the custom login page instead of wp-login.php.
	 */
	public function sas_shop_redirect_to_sas_login() {

		// The rest are redirected to the login page
		$login_url = get_option( 'sas_shop_sas-shop-login_page_id' );
		$login_url =  get_the_permalink( $login_url ) ;


		if ( $_SERVER['REQUEST_METHOD'] == 'GET' ) {
			if ( is_user_logged_in() ) {
				$this->sas_shop_redirect_logged_in_user();
				exit;
			}

			if ( ! empty( $_REQUEST['redirect_to'] ) ) {
				$login_url = add_query_arg( 'redirect_to', $_REQUEST['redirect_to'] , $login_url );
			}

			if ( ! empty( $_REQUEST['checkemail'] ) ) {
				$login_url = add_query_arg( 'checkemail', $_REQUEST['checkemail'], $login_url );
			}


			wp_redirect( $login_url );
			exit;
		}
	}

	/**
	 * Redirect the user after authentication if there were any errors.
	 *
	 * @param Wp_User|Wp_Error  $user       The signed in user, or the errors that have occurred during login.
	 * @param string            $username   The user name used to log in.
	 * @param string            $password   The password used to log in.
	 *
	 * @return Wp_User|Wp_Error The logged in user, or error information if there were errors.
	 */
	public function sas_shop_maybe_redirect_at_authenticate( $user, $username, $password ) {
		// Check if the earlier authenticate filter (most likely,
		// the default WordPress authentication) functions have found errors

		if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {


			if ( is_wp_error( $user ) ) {
				$error_codes = join( ',', $user->get_error_codes() );


				$login_url = get_the_permalink(get_option( 'sas_shop_sas-shop-login_page_id' ));
				$login_url = add_query_arg( 'login', $error_codes, $login_url );

				wp_redirect( $login_url );
				exit;
			}
		}

		return $user;

	}

	/**
	 * Returns the URL to which the user should be redirected after the (successful) login.
	 *
	 * @param string           $redirect_to           The redirect destination URL.
	 * @param string           $requested_redirect_to The requested redirect destination URL passed as a parameter.
	 * @param WP_User|WP_Error $user                  WP_User object if login was successful, WP_Error object otherwise.
	 *
	 * @return string Redirect URL
	 */
	public function sas_shop_redirect_after_login( $redirect_to, $requested_redirect_to, $user ) {

		$redirect_url = get_option( 'sas_shop_sas-shop-myaccount_page_id' );
		$redirect_url =  get_the_permalink( $redirect_url ) ;

		if ( ! isset( $user->ID ) ) {
			return $redirect_url;
		}

		if ( user_can( $user, 'manage_options' ) ) {
			// Use the redirect_to parameter if one is set, otherwise redirect to admin dashboard.
			if ( $requested_redirect_to == '' ) {
				$redirect_url = admin_url();
			} else {
				$redirect_url = $redirect_to;
			}
		}
		/*
			else {
			// Non-admin users always go to their account page after login
			$redirect_url = home_url( 'sas-account' );
		}
		*/

		return wp_validate_redirect( $redirect_url, home_url() );
	}

	/**
	 * Redirect to custom login page after the user has been logged out.
	 */

	public function sas_shop_redirect_after_logout() {
		$redirect_url = get_the_permalink(get_option( 'sas_shop_sas-shop-login_page_id' ));
		$redirect_url = $redirect_url . '?logged_out=true';
		wp_redirect( $redirect_url );

		exit;

	}

	/**
	 * Redirects the user to the correct page depending on whether he / she
	 * is an admin or not.
	 *
	 * @param string $redirect_to   An optional redirect_to URL for admin users
	 */
	public function sas_shop_redirect_logged_in_user( $redirect_to = null ) {

		$user = wp_get_current_user();

		if ( user_can( $user, 'manage_options' ) ) {
			if ( $redirect_to ) {
				wp_safe_redirect( $redirect_to );
			} else {
				wp_redirect( admin_url() );
			}
		} else {

			wp_redirect( get_the_permalink(get_option( 'sas_shop_sas-shop-myaccount_page_id' )) );
		}
	}


	/**
	 * Redirects the user to the custom registration page instead
	 * of wp-login.php?action=register.
	 */
	public function sas_shop_redirect_to_signup() {
		if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
			if ( is_user_logged_in() ) {
				$this->sas_shop_redirect_logged_in_user();
			} else {
				$signup = get_the_permalink( get_option( 'sas_shop_sas-shop-signup_page_id' ) );
				wp_redirect( $signup );
			}
			exit;
		}
	}


	/**
	 * Handles the user account updates.
	 *
	 * Used through the action hook "login_form_register" activated on wp-login.php
	 * when accessed through the registration action.
	 */
	public function sas_shop_do_sas_account_user() {


		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && is_page( get_option( 'sas_shop_sas-shop-myaccount_page_id' ) ) ) {


			$redirect_url = get_the_permalink( get_option( 'sas_shop_sas-shop-myaccount_page_id' ) );

			$email = sanitize_text_field( wp_unslash( $_POST['email'] ) );
			$first_name = sanitize_text_field( $_POST['first_name'] );
			$last_name = sanitize_text_field( $_POST['last_name'] );

			$phone = sanitize_text_field( $_POST['sas_shop_phone'] );
			$address = sanitize_text_field( $_POST['sas_shop_address'] );
			$country = sanitize_text_field( $_POST['sas_shop_country'] );
			$city = sanitize_text_field( $_POST['sas_shop_city'] );
			$zipcode = sanitize_text_field( $_POST['sas_shop_zipcode'] );

			$user = get_user_by( 'email', $email );
			if(!$user){
				$user = get_user_by('id', $_POST['checkuser_id']);
			}
			if(!$user){
				$redirect_url = get_the_permalink( get_option( 'sas_shop_sas-shop-myaccount_page_id' ) );
				wp_redirect( $redirect_url );
				return;
			}

			$result = $this->sas_shop_update_account_user( $user->ID, $email, $first_name, $last_name, $phone, $address, $country, $city, $zipcode );

			if ( is_wp_error( $result ) ) {
				$errors = join( ',', $result->get_error_codes() );
				$redirect_url = add_query_arg( 'register-errors', $errors, $redirect_url );
			} else {

				$redirect_url = get_the_permalink( get_option( 'sas_shop_sas-shop-myaccount_page_id' ) );
			}


			wp_safe_redirect( $redirect_url );
			exit;
		}
	}
	/**
	 * Validates and then completes the user account data
	 *
	 * @param string $email         The new user's email address
	 * @param string $first_name    The new user's first name
	 * @param string $last_name     The new user's last name
	 *
	 * @return int|WP_Error         The id of the user that was created, or error if failed.
	 */
	private function sas_shop_update_account_user( $user_ID, $email, $first_name, $last_name, $sas_shop_phone, $sas_shop_address, $sas_shop_country, $sas_shop_city, $sas_shop_zipcode ){

		$errors = new WP_Error();

		// Email address is used as both username and email. It is also the only
		// parameter we need to validate
		if ( ! is_email( $email ) ) {
			$errors->add( 'email', $this->sas_shop_get_error_message( 'email' ) );
			return $errors;
		}

		if ( username_exists( $email ) || email_exists( $email ) ) {

			$user_data = array(
			'ID'            => $user_ID,
			'user_login'    => $email,
			'user_email'    => $email,
			'first_name'    => $first_name,
			'last_name'     => $last_name,
			'nickname'      => $first_name,
			'sas_shop_phone'     => $sas_shop_phone,
			'sas_shop_address'   => $sas_shop_address,
			'sas_shop_country'   => $sas_shop_country,
			'sas_shop_city'      => $sas_shop_city,
			'sas_shop_zipcode'   => $sas_shop_zipcode,
		);

		$user_id = wp_update_user( $user_data );

		}
		return $user_id;
	}



	/**
	 * Validates and then completes the new user signup process if all went well.
	 *
	 * @param string $email         The new user's email address
	 * @param string $first_name    The new user's first name
	 * @param string $last_name     The new user's last name
	 *
	 * @return int|WP_Error         The id of the user that was created, or error if failed.
	 */
	public function sas_shop_register_user( $email, $password, $first_name, $last_name ) {


		$errors = new WP_Error();

		// Email address is used as both username and email. It is also the only
		// parameter we need to validate
		if ( ! is_email( $email ) ) {
			$errors->add( 'email', $this->sas_shop_get_error_message( 'email' ) );
			return $errors;
		}

		if ( username_exists( $email ) || email_exists( $email ) ) {
			$errors->add( 'email_exists', $this->sas_shop_get_error_message( 'email_exists') );
			return $errors;
		}

		// Generate the password so that the subscriber will have to check email...
		//$password = wp_generate_password( 12, false );

		$user_data = array(
			'user_login'    => $email,
			'user_email'    => $email,
			'user_pass'     => $password,
			'first_name'    => $first_name,
			'last_name'     => $last_name,
			'nickname'      => $first_name,
		);

		$user_id = wp_insert_user( $user_data );
		wp_new_user_notification( $user_id, null, $password );

		return $user_id;
	}
	/**
	 * Validates and then completes the new user signup process if all went well.
	 *
	 * @param string $email         The new user's email address
	 * @param string $first_name    The new user's password
	 *
	 * @return int|WP_Error         The id of the user that was created, or error if failed.
	 */
	public function sas_shop_register_user_mini( $email, $password ) {


		$errors = new WP_Error();

		// Email address is used as both username and email. It is also the only
		// parameter we need to validate
		if ( ! is_email( $email ) ) {
			$errors->add( 'email', $this->sas_shop_get_error_message( 'email' ) );
			return $errors;
		}

		if ( username_exists( $email ) || email_exists( $email ) ) {
			$errors->add( 'email_exists', $this->sas_shop_get_error_message( 'email_exists') );
			return $errors;
		}

		// Generate the password so that the subscriber will have to check email...
		//$password = wp_generate_password( 12, false );

		$user_data = array(
			'user_login'    => $email,
			'user_email'    => $email,
			'user_pass'     => $password,
			'first_name'    => '',
			'last_name'     => '',
			'nickname'      => '',
		);

		$user_id = wp_insert_user( $user_data );
		wp_new_user_notification( $user_id, null, $password );

		return $user_id;
	}
	/**
	 * auto_login_user function.
	 *
	 * @access public
	 * @param mixed $userID
	 * @param mixed $redirect_url
	 * @return void
	 */
	public function auto_login_user($userID, $redirect_url ){

		$user = get_user_by('id', $userID);
		clean_user_cache($user->ID);
		wp_clear_auth_cookie();
		wp_set_current_user($user->ID);
		wp_set_auth_cookie($user->ID, true, false);
		update_user_caches($user);

		$redirect_url = get_the_permalink( get_option( 'sas_shop_sas-shop-signup_page_id' ) );
		wp_safe_redirect( $redirect_url );
		exit;
	}
	/**
	 * Finds and returns a matching error message for the given error code.
	 *
	 * @param string $error_code    The error code to look up.
	 *
	 * @return string               An error message.
	 */
	public function sas_shop_get_error_message( $error_code ) {
		switch ( $error_code ) {
			// Login errors

			case 'empty_username':
				return __( 'You do have an email address, right?', 'sas-shop' );

			case 'empty_password':
				return __( 'You need to enter a password to login.', 'sas-shop' );

			case 'invalid_username':
				return __(
					"We don't have any users with that email address. Maybe you used a different one when signing up?",
					'sas-shop'
				);

			case 'incorrect_password':
				$err = __(
					"The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",
					'sas-shop'
				);
				return sprintf( $err, wp_lostpassword_url() );

			// Registration errors

			case 'email':
				return __( 'The email address you entered is not valid.', 'sas-shop' );

			case 'email_exists':
				return __( 'An account exists with this email address.', 'sas-shop' );

			case 'closed':
				return __( 'Registering new users is currently not allowed.', 'sas-shop' );

			case 'captcha':
				return __( 'The Google reCAPTCHA check failed. Are you a robot?', 'sas-shop' );

			// Lost password

			case 'empty_username':
				return __( 'You need to enter your email address to continue.', 'sas-shop' );

			case 'invalid_email':
			case 'invalidcombo':
				return __( 'There are no users registered with this email address.', 'sas-shop' );

			// Reset password

			case 'expiredkey':
			case 'invalidkey':
				return __( 'The password reset link you used is not valid anymore.', 'sas-shop' );

			case 'password_reset_mismatch':
				return __( "The two passwords you entered don't match.", 'sas-shop' );

			case 'password_reset_empty':
				return __( "Sorry, we don't accept empty passwords.", 'sas-shop' );

			case 'password_reset_empty':
				return __( "Sorry, we don't accept empty passwords.", 'sas-shop' );

			default:
				break;
		}

		return __( 'An unknown error occurred. Please try again later.', 'sas-shop' );
	}

	public function sas_shop_remove_admin_bar() {
		if (!current_user_can('administrator') && !is_admin()) {
			show_admin_bar(false);
		}
	}


	public function sas_shop_prevent_profile_access(){
   		if (current_user_can('manage_options')) return '';

   		if (strpos ($_SERVER ['REQUEST_URI'] , 'wp-admin/profile.php' )){
	   		$redirect_url = get_option( 'sas_shop_sas-shop-myaccount_page_id' );
      		wp_redirect ( get_the_permalink( $redirect_url ) );
 		 }

	}
	/**
	 * Add Profile Fields
	*/
	public function sas_shop_add_contact_methods($profile_fields) {

		// Add new fields
		$profile_fields['sas_shop_phone'] = __('Phone','sas-shop');
		$profile_fields['sas_shop_address'] = __('Address','sas-shop');
		$profile_fields['sas_shop_country'] = __( 'Country', 'sas-shop' );
		$profile_fields['sas_shop_city'] = __('City','sas-shop');
		$profile_fields['sas_shop_zipcode'] = __('Zip code','sas-shop');


		return $profile_fields;
	}

}