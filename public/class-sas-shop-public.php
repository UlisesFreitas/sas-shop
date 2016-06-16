<?php

 /** The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 * @since      1.0.0
 * @package    Sas_Shop
 * @subpackage Sas_Shop/public
 * @author     UlisesFreitas <ulises.freitas@gmail.com>
 */
class Sas_Shop_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$sessionHandler = Sas_Shop_Session_Handler::getInstance();
		$cart_id = $sessionHandler->get_cart_id();

		if( ! $cart_id ){
			self::start_cart_session();
		}

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sas_Shop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sas_Shop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sas-shop-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sas_Shop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sas_Shop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_register_script( $this->plugin_name . '-public', plugin_dir_url( __FILE__ ) . 'js/sas-shop-public.js' , array('jquery'), $this->version, false );
		wp_localize_script( $this->plugin_name . '-public', 'sas_shop_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( $this->plugin_name . '-public', plugin_dir_url( __FILE__ ) . 'js/sas-shop-public.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script($this->plugin_name . '-validation', plugin_dir_url(__FILE__) . 'validation/jquery.validate.min.js', array('jquery',$this->plugin_name . '-public'), $this->version, false );
		wp_enqueue_script($this->plugin_name . '-additional-methods', plugin_dir_url(__FILE__) . 'validation/additional-methods.min.js', array('jquery'), $this->version, true );


		if(is_page(get_option( 'sas_shop_sas-shop-checkout_page_id' ))){
			wp_enqueue_script($this->plugin_name . '-validation', plugin_dir_url(__FILE__) . 'js/sas-shop-public-validate-checkout.js', array('jquery',$this->plugin_name . '-validation'), $this->version, false );
		}
	}

	/**
	 * start_cart_session function.
	 *
	 * @access public
	 * @return void
	 */
	public function start_cart_session(){

		$sessionHandler = Sas_Shop_Session_Handler::getInstance();
		$cart_data = array( 'cart_'. $sessionHandler->get_session_id() => array( 'cart_products' => array() ) );
		$sessionHandler->sas_shop_save_data(json_encode( $cart_data ) );

	}

	/**
	 * get_single_template function.
	 *
	 * @access public
	 * @static
	 * @param mixed $single_template
	 * @return void
	 */
	public static function get_single_template($single_template) {
		global $post;
		if($post->post_type == 'sas_product') {
          $single_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/single.php';
        }

     return $single_template;
	}

	/**
	 * sas_shop_wrapper_single_content_display function.
	 *
	 * @access public
	 * @return void
	 */
	public function sas_shop_wrapper_single_content_display(){
		global $post;
		if($post->post_type == 'sas_product') {
		 	Sas_Shop_Core_Helpers::sas_shop_get_template( 'single/content-single.php' );
		}
	}
	/**
	 * get_shop_template function.
	 *
	 * @access public
	 * @static
	 * @param mixed $page_template
	 * @return void
	 */
	public static function get_shop_template( $page_template ){
	    if ( is_page( get_option( 'sas_shop_sas-shop-front_page_id' ) ) || is_page( 'sas-shop-front' ) ) {
	        $page_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/archive-sas-shop.php';
	    }
	    return $page_template;
	}



	/**
	 * get_cart_template function.
	 *
	 * @access public
	 * @static
	 * @param mixed $page_template
	 * @return void
	 */
	public static function get_cart_template( $page_template ){
	    if ( is_page( get_option( 'sas_shop_sas-shop-cart_page_id' ) ) || is_page( 'sas-shop-cart' ) ) {
	        $page_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/cart.php';
	    }
	    return $page_template;
	}

	/**
	 * get_checkout_template function.
	 *
	 * @access public
	 * @static
	 * @param mixed $page_template
	 * @return void
	 */
	public static function get_checkout_template( $page_template, $attributes = array() ){

		global $attributes;
		$attributes['errors'] = array();

	    if ( is_page( get_option( 'sas_shop_sas-shop-checkout_page_id' ) ) || is_page( 'sas-shop-checkout' ) ) {

			$url_args = wp_parse_args( $_SERVER['REQUEST_URI'] );
			$order_status = isset($url_args['order_status']) ? $url_args['order_status'] : NULL;
			$confirmation = isset($url_args['sas_shop_confirmation']) ? $url_args['sas_shop_confirmation'] : NULL;
			$order_id = isset($url_args['order']) ? $url_args['order'] : NULL;

			if( 'GET' == $_SERVER['REQUEST_METHOD'] && $order_status != NULL && $order_id != NULL && $confirmation != NULL ){


				$order = get_post( $order_id );
				$order_meta = get_post_meta( $order->ID );

				$confirmation_meta = get_post_meta($order_id, 'field-order-confirmation', true );
				if( $confirmation != $confirmation_meta && !current_user_can( 'sas_shop_manager' ) ){
					$attributes['sas_shop_this_is_not_your_order'] = '<h2>You are not allowed to see this content.</h2>';

					$page_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/order.php';
					return $page_template;
					exit;
				}

				$attributes['sas_shop_order_id'] = $order_id;
				$attributes['sas_shop_order_title'] = $order->post_title;
				$attributes['sas_shop_order_meta'] = $order_meta;

				$email_notification_order = get_post_meta( $order_id, 'field-email-customer-new-order' );

				if($email_notification_order == 0 || empty($email_notification_order)){


					$emailHandler = new Sas_Shop_Email_Handler();
					$emailHandler->sendEmail($order->ID, __('New Order #' . $order->ID  , SAS_SHOP_NAME ), 'email-customer-new-order');

				}



				$page_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/order.php';
				return $page_template;
				exit;

			}

			if( 'POST' == $_SERVER['REQUEST_METHOD'] ){

				$sessionHandler = Sas_Shop_Session_Handler::getInstance();
				$cart_data = $sessionHandler->sas_shop_get_data();
				$cart_id = $sessionHandler->get_cart_id();

				$cart_id_post = isset($_POST['cart_id']) ? $_POST['cart_id'] : '';
				$create_account_check = isset($_POST['create_account_check']) ? $_POST['create_account_check']: '';

				if( $cart_id === $cart_id_post ){


					if( isset($create_account_check) && $create_account_check == 'on' ){

						//Guest User

						$pluginAccounts = new Sas_Shop_Accounts(SAS_SHOP_VERSION, SAS_SHOP_NAME);

						$email      	= isset($_POST['email']) ? $_POST['email'] :'';
						if(empty($email)){
							$attributes['errors'] = __('Email is empty' , 'sas-shop' );
						}
						if( ! is_email( $email ) ){
							$attributes['errors'] = __('That is not a valid email' , 'sas-shop' );
						}

						$first_name 	= isset($_POST['first_name']) ? $_POST['first_name'] : '' ;
						if(empty($first_name)){
							$attributes['errors'] = __('Please fill your name' , 'sas-shop' );
						}
						$last_name   	= isset($_POST['last_name']) ? $_POST['last_name'] : '';
						if(empty($last_name)){
							$attributes['errors'] = __('Please fill your surname' , 'sas-shop' );
						}
						$user_password 	= isset($_POST['user_password']) ? $_POST['user_password'] : '';
						if(empty($user_password)){
							$attributes['errors'] = __('Please enter a password' , 'sas-shop' );
						}
						$phone 			= isset($_POST['sas_shop_phone']) ? $_POST['sas_shop_phone'] : '';
						if(empty($phone)){
							$attributes['errors'] = __('Please fill your phone' , 'sas-shop' );
						}
						$address 		= isset($_POST['sas_shop_address']) ? $_POST['sas_shop_address'] : '';
						if(empty($address)){
							$attributes['errors'] = __('Please fill your address' , 'sas-shop' );
						}
						$country 		= isset($_POST['sas_shop_country']) ? $_POST['sas_shop_country'] : '';
						if(empty($country)){
							$attributes['errors'] = __('Please fill your country' , 'sas-shop' );
						}
						$city 			= isset($_POST['sas_shop_city']) ? $_POST['sas_shop_city'] : '';
						if(empty($city)){
							$attributes['errors'] = __('Please fill your city' , 'sas-shop' );
						}
						$zipcode 		= isset($_POST['sas_shop_zipcode']) ?  $_POST['sas_shop_zipcode']  : '';
						if(empty($zipcode)){
							$attributes['errors'] = __('Please fill your zip code' , 'sas-shop' );
						}


						if( count($attributes['errors']) > 0){

							$return_url = get_the_permalink( get_option( 'sas_shop_sas-shop-checkout_page_id' ) );
							wp_redirect( $return_url );
							exit;
						}
						$first_name = sanitize_text_field( $first_name );
						$last_name = sanitize_text_field( $last_name );
						$user_password = sanitize_text_field( $user_password );

						$phone = sanitize_text_field( $phone );
						$address = sanitize_text_field( $address );
						$country = sanitize_text_field($country );
						$city = sanitize_text_field( $city );
						$zipcode = sanitize_text_field( $zipcode );

						$additional_info = sanitize_text_field($_POST['sas_shop_additional_info']);


						$result = $pluginAccounts->sas_shop_register_user( $email, $user_password ,$first_name, $last_name );


						if ( is_wp_error( $result ) ) {

							foreach( $result->get_error_codes() as $code){
								$attributes['errors'] = $pluginAccounts->sas_shop_get_error_message( $code );
							}
						} else {

							$user = get_user_by('id', $result);

							update_user_meta( $user->ID, 'first_name', $first_name );
							update_user_meta( $user->ID, 'last_name', $last_name );

							update_user_meta( $user->ID, 'sas_shop_phone', $phone );
							update_user_meta( $user->ID, 'sas_shop_address', $address );
							update_user_meta( $user->ID, 'sas_shop_country', $country );
							update_user_meta( $user->ID, 'sas_shop_city', $city );
							update_user_meta( $user->ID, 'sas_shop_zipcode', $zipcode );

							$order_id = Sas_Shop_Order::create_order();

							if( is_numeric( $order_id ) ){

								$order = get_post($order_id );

								update_post_meta($order_id, 'field-order-customer-id', $user->ID );
								update_post_meta($order_id, 'field-order-customer-name', $first_name );
								update_post_meta($order_id, 'field-order-customer-lastname', $last_name );
								update_post_meta($order_id, 'field-order-customer-email', $email );
								update_post_meta($order_id, 'field-order-customer-country', $country );
								update_post_meta($order_id, 'field-order-customer-address', $address );
								update_post_meta($order_id, 'field-order-customer-city', $city );
								update_post_meta($order_id, 'field-order-customer-zip-code', $zipcode );
								update_post_meta($order_id, 'field-order-customer-phone', $phone );
								update_post_meta($order_id, 'field-order-customer-info', $additional_info );
								update_post_meta($order_id, 'field-order-date-creation', get_the_date( 'd-m-Y' , $order_id) );
								update_post_meta($order_id, 'field-order-time-creation', get_the_date( 'H:i:s' , $order_id) );
								update_post_meta($order_id, 'field-order-cart-products', json_encode($cart_data[$cart_id]['cart_products']) );
								update_post_meta($order_id, 'field-order-cart-subtotal', json_encode($cart_data[$cart_id]['cart_subtotal']) );
								update_post_meta($order_id, 'field-order-cart-taxes', json_encode($cart_data[$cart_id]['cart_taxes']) );
								update_post_meta($order_id, 'field-order-cart-total', json_encode($cart_data[$cart_id]['cart_total']) );
								update_post_meta($order_id, 'field-order-shipping', $cart_data[$cart_id]['shipping_checked'] );
								update_post_meta($order_id, 'field-order-payment-method', $_POST['sas_shop_payment_method'][0] );

								update_post_meta($order_id, 'field-order-shipping-unit-price', $cart_data[$cart_id]['cart_shipping_unit_price'] );
								update_post_meta($order_id, 'field-order-shipping-unit-tax', $cart_data[$cart_id]['cart_shipping_unit_tax'] );
								update_post_meta($order_id, 'field-order-shipping-total-price', $cart_data[$cart_id]['cart_shipping_total_price'] );
								update_post_meta($order_id, 'field-order-shipping-total-tax', $cart_data[$cart_id]['cart_shipping_total_tax'] );


								//update_post_meta($order_id, 'field-order-status', 'pending_payment' );


								if( $_POST['sas_shop_payment_method'][0] == 'bank_transfer' || $_POST['sas_shop_payment_method'][0] == 'cash_on_delivery' ){
									update_post_meta($order_id, 'field-order-status', 'pending_payment' );
								}


								update_post_meta($order_id, 'field-order-confirmation', $sessionHandler->get_session_id() );


								clean_user_cache($user->ID);
								wp_clear_auth_cookie();
								wp_set_current_user($user->ID);
								wp_set_auth_cookie($user->ID, true, false);
								update_user_caches($user);


								$return_args = array('order' => $order_id , 'order_status' => 'order_completed', 'sas_shop_confirmation' => $sessionHandler->get_session_id() );
								$url = get_the_permalink( get_option( 'sas_shop_sas-shop-checkout_page_id' ) );

								$return_url = add_query_arg( $return_args , $url );
								wp_redirect( $return_url );
								exit;
							}

						}



					}else{


							$email      	= isset($_POST['email']) ? $_POST['email'] :'';
							if(empty($email)){
								$attributes['errors'] = __('Email is empty' , 'sas-shop' );
							}
							if( ! is_email( $email ) ){
								$attributes['errors'] = __('That is not a valid email' , 'sas-shop' );
							}

							$first_name 	= isset($_POST['first_name']) ? $_POST['first_name'] : '' ;
							if(empty($first_name)){
								$attributes['errors'] = __('Please fill your name' , 'sas-shop' );
							}
							$last_name   	= isset($_POST['last_name']) ? $_POST['last_name'] : '';
							if(empty($last_name)){
								$attributes['errors'] = __('Please fill your surname' , 'sas-shop' );
							}
							$phone 			= isset($_POST['sas_shop_phone']) ? $_POST['sas_shop_phone'] : '';
							if(empty($phone)){
								$attributes['errors'] = __('Please fill your phone' , 'sas-shop' );
							}
							$address 		= isset($_POST['sas_shop_address']) ? $_POST['sas_shop_address'] : '';
							if(empty($address)){
								$attributes['errors'] = __('Please fill your address' , 'sas-shop' );
							}
							$country 		= isset($_POST['sas_shop_country']) ? $_POST['sas_shop_country'] : '';
							if(empty($country)){
								$attributes['errors'] = __('Please fill your country' , 'sas-shop' );
							}
							$city 			= isset($_POST['sas_shop_city']) ? $_POST['sas_shop_city'] : '';
							if(empty($city)){
								$attributes['errors'] = __('Please fill your city' , 'sas-shop' );
							}
							$zipcode 		= isset($_POST['sas_shop_zipcode']) ?  $_POST['sas_shop_zipcode']  : '';
							if(empty($zipcode)){
								$attributes['errors'] = __('Please fill your zip code' , 'sas-shop' );
							}


							if( count($attributes['errors']) > 0){

								$return_url = get_the_permalink( get_option( 'sas_shop_sas-shop-checkout_page_id' ) );
								wp_redirect( $return_url );
								exit;
							}


							$email = sanitize_email( $email );
							$first_name = sanitize_text_field( $first_name );
							$last_name = sanitize_text_field( $last_name );
							$phone = sanitize_text_field( $phone );
							$address = sanitize_text_field( $address );
							$country = sanitize_text_field( $country );
							$city = sanitize_text_field( $city );
							$zipcode = sanitize_text_field( $zipcode );
							$additional_info = sanitize_text_field($_POST['sas_shop_additional_info']);


							$user = get_user_by( 'email', $email );

							update_user_meta( $user->ID, 'first_name', $first_name );
							update_user_meta( $user->ID, 'last_name', $last_name );

							update_user_meta( $user->ID, 'sas_shop_phone', $phone );
							update_user_meta( $user->ID, 'sas_shop_address', $address );
							update_user_meta( $user->ID, 'sas_shop_country', $country );
							update_user_meta( $user->ID, 'sas_shop_city', $city );
							update_user_meta( $user->ID, 'sas_shop_zipcode', $zipcode );



							$order_id = Sas_Shop_Order::create_order();

							if( is_numeric( $order_id ) ){

								$order = get_post($order_id );

								update_post_meta($order_id, 'field-order-customer-id', $user->ID );
								update_post_meta($order_id, 'field-order-customer-name', $first_name );
								update_post_meta($order_id, 'field-order-customer-lastname', $last_name );
								update_post_meta($order_id, 'field-order-customer-email', $email );
								update_post_meta($order_id, 'field-order-customer-country', $country );
								update_post_meta($order_id, 'field-order-customer-address', $address );
								update_post_meta($order_id, 'field-order-customer-city', $city );
								update_post_meta($order_id, 'field-order-customer-zip-code', $zipcode );
								update_post_meta($order_id, 'field-order-customer-phone', $phone );
								update_post_meta($order_id, 'field-order-customer-info', $additional_info );
								update_post_meta($order_id, 'field-order-date-creation', get_the_date( 'd-m-Y' , $order_id) );
								update_post_meta($order_id, 'field-order-time-creation', get_the_date( 'H:i:s' , $order_id) );
								update_post_meta($order_id, 'field-order-cart-products', json_encode($cart_data[$cart_id]['cart_products']) );
								update_post_meta($order_id, 'field-order-cart-subtotal', json_encode($cart_data[$cart_id]['cart_subtotal']) );
								update_post_meta($order_id, 'field-order-cart-taxes', json_encode($cart_data[$cart_id]['cart_taxes']) );
								update_post_meta($order_id, 'field-order-cart-total', json_encode($cart_data[$cart_id]['cart_total']) );
								update_post_meta($order_id, 'field-order-shipping', $cart_data[$cart_id]['shipping_checked'] );

								update_post_meta($order_id, 'field-order-payment-method', $_POST['sas_shop_payment_method'][0] );

								update_post_meta($order_id, 'field-order-shipping-unit-price', $cart_data[$cart_id]['cart_shipping_unit_price'] );
								update_post_meta($order_id, 'field-order-shipping-unit-tax', $cart_data[$cart_id]['cart_shipping_unit_tax'] );
								update_post_meta($order_id, 'field-order-shipping-total-price', $cart_data[$cart_id]['cart_shipping_total_price'] );
								update_post_meta($order_id, 'field-order-shipping-total-tax', $cart_data[$cart_id]['cart_shipping_total_tax'] );

								if( $_POST['sas_shop_payment_method'][0] == 'bank_transfer' || $_POST['sas_shop_payment_method'][0] == 'cash_on_delivery' ){
									update_post_meta($order_id, 'field-order-status', 'pending_payment' );
								}

								update_post_meta($order_id, 'field-order-confirmation', $sessionHandler->get_session_id() );

								$return_args = array('order' => $order_id , 'order_status' => 'order_completed', 'sas_shop_confirmation' => $sessionHandler->get_session_id() );
								$url = get_the_permalink( get_option( 'sas_shop_sas-shop-checkout_page_id' ) );

								$return_url = add_query_arg( $return_args , $url );
								wp_redirect( $return_url );
								exit;

							}

					}

				}



			}

	        $page_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/checkout.php';

	    }
	    return $page_template;
	}

	/**
	 * sas_shop_wrapper_order_completed_display function.
	 *
	 * @access public
	 * @param array $attributes (default: array( ))
	 * @return void
	 */
	public function sas_shop_wrapper_order_completed_display( $attributes = array( ) ){

		global $attributes;

		Sas_Shop_Core_Helpers::sas_shop_get_template( 'order/order-completed.php', $attributes );
	}

	/**
	 * sas_shop_wrapper_checkout_form_display function.
	 *
	 * @access public
	 * @param mixed $page_template
	 * @param array $attributes (default: array())
	 * @return void
	 */
	public function sas_shop_wrapper_checkout_form_display( $page_template, $attributes = array() ){

		global $attributes;
		$pluginAccounts = new Sas_Shop_Accounts(SAS_SHOP_VERSION, 'sas-shop');

		if ( is_user_logged_in() ) {

			$user_ID = get_current_user_id();
			$user_data = get_userdata($user_ID);

			$all_meta_for_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_ID ) );
			$attributes['usermeta'] = $all_meta_for_user;
			$attributes['userdata'] = $user_data;

			// Retrieve possible errors from request parameters
			$attributes['errors'] = array();
			if ( isset( $_REQUEST['register-errors'] ) ) {
				$error_codes = explode( ',', $_REQUEST['register-errors'] );

				foreach ( $error_codes as $error_code ) {
					$attributes['errors'] []= $pluginAccounts->sas_shop_get_error_message( $error_code );
				}
			}
		}
		Sas_Shop_Core_Helpers::sas_shop_get_template( 'checkout/checkout-form.php', $attributes );
	}

	/**
	 * get_myaccount_template function.
	 *
	 * @access public
	 * @static
	 * @param mixed $page_template
	 * @return void
	 */
	public static function get_myaccount_template( $page_template ){

	    if ( is_page( get_option( 'sas_shop_sas-shop-myaccount_page_id' ) ) || is_page( 'sas-shop-myaccount' ) ) {

			if(isset($_POST['action']) && $_POST['action'] == 'sas_shop_update_account'){

				do_action( 'sas_shop_update_account_user');
				exit;
			}

		    $page_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/accounts/sas-shop-myaccount.php';

	    }
	    return $page_template;
	}

	/**
	 * get_signup_template function.
	 *
	 * @access public
	 * @static
	 * @param mixed $page_template
	 * @return void
	 */
	public function get_signup_template( $page_template, $attributes = array() ){

		global $attributes;

	    if( is_page( get_option( 'sas_shop_sas-shop-signup_page_id' ) ) || is_page( 'sas-shop-signup' ) ) {

			if(is_user_logged_in()){
				$my_account = get_the_permalink( get_option( 'sas_shop_sas-shop-myaccount_page_id' ) );
				wp_redirect( $my_account );
				exit;
			}

			$pluginAccounts = new Sas_Shop_Accounts($this->version, $this->plugin_name);

			if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST) ) {

				$redirect_url = get_the_permalink( get_option( 'sas_shop_sas-shop-signup_page_id' ) );

				if ( ! get_option( 'users_can_register' ) ) {
					// Registration closed, display error
					$redirect_url = add_query_arg( 'register-errors', 'closed', $redirect_url );
				}

				if( $_POST['action'] == 'signup_mini_form' ){



					$email = $_POST['email'];
					$user_password = sanitize_text_field( $_POST['user_password'] );

					$result = $pluginAccounts->sas_shop_register_user_mini( $email, $user_password );

					if ( is_wp_error( $result ) ) {

						foreach( $result->get_error_codes() as $code){
							$errors []= $pluginAccounts->sas_shop_get_error_message( $code );
						}

						$redirect_url = get_the_permalink( get_option( 'sas_shop_sas-shop-myaccount_page_id' ) );
						wp_redirect( $redirect_url );
						exit;

					}else{

						$redirect_url = get_the_permalink( get_option( 'sas_shop_sas-shop-signup_page_id' ) );

						$pluginAccounts->auto_login_user($result, $redirect_url );
						/*
						$user = get_user_by('id', $result);
						clean_user_cache($user->ID);
						wp_clear_auth_cookie();
						wp_set_current_user($user->ID);
						wp_set_auth_cookie($user->ID, true, false);
						update_user_caches($user);

						$redirect_url = get_the_permalink( get_option( 'sas_shop_sas-shop-signup_page_id' ) );
						wp_safe_redirect( $redirect_url );
						exit;
						*/

					}

				}
				if( $_POST['action'] == 'signup_regular_form' ){

					$email = $_POST['email'];
					$first_name = sanitize_text_field( $_POST['first_name'] );
					$last_name = sanitize_text_field( $_POST['last_name'] );
					$user_password = sanitize_text_field( $_POST['user_password'] );

					$phone = sanitize_text_field( $_POST['sas_shop_phone'] );
					$address = sanitize_text_field( $_POST['sas_shop_address'] );
					$country = sanitize_text_field( $_POST['sas_shop_country'] );
					$city = sanitize_text_field( $_POST['sas_shop_city'] );
					$zipcode = sanitize_text_field( $_POST['sas_shop_zipcode'] );

					$result = $pluginAccounts->sas_shop_register_user( $email, $user_password ,$first_name, $last_name );

					if ( is_wp_error( $result ) ) {

						foreach( $result->get_error_codes() as $code){
							$errors []= $pluginAccounts->sas_shop_get_error_message( $code );
						}
					} else {
					// Success, redirect to login page.

					update_user_meta( $result, 'sas_shop_phone', $phone );
					update_user_meta( $result, 'sas_shop_address', $address );
					update_user_meta( $result, 'sas_shop_country', $city );
					update_user_meta( $result, 'sas_shop_city', $city );
					update_user_meta( $result, 'sas_shop_zipcode', $zipcode );


					$redirect_url = get_the_permalink( get_option( 'sas_shop_sas-shop-signup_page_id' ) );

					$pluginAccounts->auto_login_user($result, $redirect_url );

					}
				}
		}

			if(isset($errors)){
			$attributes['errors'] = $errors; //

		}

			$page_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/accounts/sas-shop-sign-up.php';

	    }
	    return $page_template;
	}

	/**
	 * sas_shop_wrapper_signup_form_display function.
	 *
	 * @access public
	 * @param mixed $page_template
	 * @param array $attributes (default: array())
	 * @return void
	 */
	public function sas_shop_wrapper_signup_form_display( $page_template, $attributes = array() ){

		global $attributes;
		$pluginAccounts = new Sas_Shop_Accounts($this->version, $this->plugin_name);

		Sas_Shop_Core_Helpers::sas_shop_get_template( 'accounts/sas-shop-sign-up-form.php', $attributes );

	}

	/**
	 * sas_shop_wrapper_mini_signup_form function.
	 *
	 * @access public
	 * @param mixed $page_template
	 * @param array $attributes (default: array())
	 * @return void
	 */
	public function sas_shop_wrapper_mini_signup_form_display( $page_template, $attributes = array() ){

		global $attributes;
		$pluginAccounts = new Sas_Shop_Accounts($this->version, $this->plugin_name);

		Sas_Shop_Core_Helpers::sas_shop_get_template( 'accounts/sas-shop-sign-up-mini-form.php', $attributes );
	}

	/**
	 * get_login_template function.
	 *
	 * @access public
	 * @static
	 * @param mixed $page_template
	 * @return void
	 */
	public static function get_login_template( $page_template ){


		if(is_page(get_option( 'sas_shop_sas-shop-login_page_id' ) ) ){

			$page_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/accounts/sas-shop-login.php';

	    }
	    return $page_template;
	}

	/**
	 * sas_shop_wrapper_login_form_template function.
	 *
	 * @access public
	 * @param mixed $page_template
	 * @param array $attributes (default: array())
	 * @return void
	 */
	public function sas_shop_wrapper_login_form_template( $page_template, $attributes = array() ){


		if ( is_page( get_option( 'sas_shop_sas-shop-login_page_id' ) ) || is_page( 'sas-shop-login' ) || is_page( get_option( 'sas_shop_sas-shop-myaccount_page_id' ) ) || is_page( 'sas-shop-myaccount' ) ) {

		global $attributes;

		$pluginAccounts = new Sas_Shop_Accounts($this->version, $this->plugin_name);

		$permalink = get_permalink(get_option( 'sas_shop_sas-shop-login_page_id' ));
		$find_h = '#^http(s)?://#';
		$find_w = '/^www\./';
		$replace = '';
		$link = preg_replace( $find_h, $replace, $permalink );
		$link = preg_replace( $find_w, $replace, $link );



		$defaults = array(
			'echo'           		=> true,
			'remember'       		=> true,
			'redirect'       		=> ( is_ssl() ? 'https://' : 'http://' ) .  $link,
			'form_id'        		=> 'sas-shop-login-form',
			'id_username'    		=> 'user_login',
			'id_password'   	 	=> 'user_pass',
			'id_remember'    		=> 'rememberme',
			'id_submit'      		=> 'wp-submit',
			'label_username' 		=> __( 'Email', $this->plugin_name ),
			'label_password' 		=> __( 'Password', $this->plugin_name ),
			'label_remember' 		=> __( 'Remember Me', $this->plugin_name ),
			'label_log_in'   		=> __( 'Log In', $this->plugin_name ),
			'value_username' 		=> '',
			'logged_out'     		=> '',
			'errors'         		=> array(),
			'registered'     		=> '',
			'lost_password_sent' 	=> '',
			'password_updated'      => '',
			'forgot_password_link'  => ''


		);

		$attributes['redirect'] = ( is_ssl() ? 'https://' : 'http://' ) .  $link;
		if ( isset( $_REQUEST['redirect_to'] ) ) {
			$attributes['redirect'] = wp_validate_redirect( $_REQUEST['redirect_to'], $attributes['redirect'] );
		}

		// Error messages
		$errors = array();
		if ( isset( $_REQUEST['login'] ) ) {
			$error_codes = explode( ',', $_REQUEST['login'] );

			foreach ( $error_codes as $code ) {



				$errors []= $pluginAccounts->sas_shop_get_error_message( $code );
			}
		}

		$attributes['errors'] = $errors;

		// Check if user just logged out
		$attributes['logged_out'] = isset( $_REQUEST['logged_out'] ) && $_REQUEST['logged_out'] == true;

		// Check if the user just registered
		$attributes['registered'] = isset( $_REQUEST['registered'] );

		// Check if the user just requested a new password
		$attributes['lost_password_sent'] = isset( $_REQUEST['checkemail'] ) && $_REQUEST['checkemail'] == 'confirm';

		// Check if user just updated password
		$attributes['password_updated'] = isset( $_REQUEST['password'] ) && $_REQUEST['password'] == 'changed';



		$attributes = wp_parse_args( $attributes, $defaults  );

		Sas_Shop_Core_Helpers::sas_shop_get_template( 'accounts/sas-shop-login-form.php', $attributes );

		}
	}

	/**
	 * get_password_lost_template function.
	 *
	 * @access public
	 * @static
	 * @param mixed $page_template
	 * @param array $attributes (default: array())
	 * @return void
	 */
	public static function get_password_lost_template( $page_template , $attributes = array() ){

		if( is_page( get_option( 'sas_shop_sas-shop-password-lost_page_id') ) ){

			if(is_user_logged_in()){
				$my_account = get_the_permalink( get_option( 'sas_shop_sas-shop-myaccount_page_id' ) );
				wp_redirect( $my_account );
				exit;
			}

			$page_template = plugin_dir_path( dirname( __FILE__ ) ) . 'templates/accounts/sas-shop-password-lost.php';


	    }
	    return $page_template;
	}

	/**
	 * sas_shop_wrapper_password_lost_form_display function.
	 *
	 * @access public
	 * @param mixed $page_template
	 * @param array $attributes (default: array())
	 * @return void
	 */
	public function sas_shop_wrapper_password_lost_form_display( $page_template, $attributes = array() ){

		if( is_page( get_option( 'sas_shop_sas-shop-password-lost_page_id') ) ){

			global $attributes;
			$pluginAccounts = new Sas_Shop_Accounts($this->version, $this->plugin_name);

			Sas_Shop_Core_Helpers::sas_shop_get_template( 'accounts/sas-shop-password-lost-form.php', $attributes );
		}
	}

	/**
	 * sas_shop_wrapper_myaccount_form_template function.
	 *
	 * @access public
	 * @param mixed $page_template
	 * @param array $attributes (default: array())
	 * @return void
	 */
	public function sas_shop_wrapper_myaccount_form_template( $page_template, $attributes = array() ){

		global $attributes;
		$pluginAccounts = new Sas_Shop_Accounts($this->version, $this->plugin_name);

		if ( is_user_logged_in() ) {

			$user_ID = get_current_user_id();
			$user_data = get_userdata($user_ID);

			$all_meta_for_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $user_ID ) );
			$attributes['usermeta'] =  $all_meta_for_user;
			$attributes['userdata'] = $user_data;

			// Retrieve possible errors from request parameters
			$attributes['errors'] = array();
			if ( isset( $_REQUEST['register-errors'] ) ) {
				$error_codes = explode( ',', $_REQUEST['register-errors'] );

				foreach ( $error_codes as $error_code ) {
					$attributes['errors'] []= $pluginAccounts->sas_shop_get_error_message( $error_code );
				}
			}
		}
		Sas_Shop_Core_Helpers::sas_shop_get_template( 'accounts/sas-shop-myaccount-form.php', $attributes );

	}


	public function sas_shop_wrapper_myaccount_orders_template( $page_template, $orders = array() ){

		global $orders;

		Sas_Shop_Core_Helpers::sas_shop_get_template( 'accounts/sas-shop-myaccount-orders.php', $orders );

	}


	/**
	 * sas_shop_include_wrapper_start function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function sas_shop_include_wrapper_start(){

		Sas_Shop_Core_Helpers::sas_shop_get_template( 'shop/sas-shop-wrapper-start.php' );
	}

	/**
	 * sas_shop_custom_args_shop_front_page function.
	 *
	 * @access public
	 * @static
	 * @param array $args (default: array())
	 * @return void
	 */
	public static function sas_shop_custom_args_shop_front_page( $args = array() ){

		if ( $args && is_array($args) ){

			extract( $args );
		}else{

			$args=array(
					'post_type' => 'sas_product',
					'posts_per_page' => -1,
					'order' => 'ASC',
					'orderby' => 'date',
					'post_status'=> 'publish',
			);
		}

		query_posts($args);

	}


	/**
	 * sas_shop_include_wrapper_end function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function sas_shop_include_wrapper_loop(){

		Sas_Shop_Core_Helpers::sas_shop_get_template( 'shop/sas-shop-wrapper-loop.php' );
	}

	/**
	 * sas_shop_include_wrapper_no_content function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function sas_shop_include_wrapper_no_content(){

		Sas_Shop_Core_Helpers::sas_shop_get_template( 'shop/sas-shop-wrapper-no-content.php' );
	}

	/**
	 * sas_shop_include_wrapper_end function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function sas_shop_include_wrapper_end(){

		Sas_Shop_Core_Helpers::sas_shop_get_template( 'shop/sas-shop-wrapper-end.php' );
	}

	/**
	 * sas_shop_wrapper_cart_form_display function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function sas_shop_wrapper_cart_form_display(){

		Sas_Shop_Core_Helpers::sas_shop_get_template( 'cart/cart-form.php' );
	}

	/**
	 * add_to_cart function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public function sas_shop_add_to_cart_single(){

		$sessionHandler = Sas_Shop_Session_Handler::getInstance();
		$cart_data = $sessionHandler->sas_shop_get_data();
		$cart_id = $sessionHandler->get_cart_id();

		$new_product = array();
		if( isset($_POST["type"]) && $_POST["type"] == 'add' && isset($_POST["product_qty"]) && $_POST["product_qty"] > 0){

			foreach($_POST as $key => $value){

				unset($new_product['type']);
				unset($new_product['return_url']);
				unset($new_product['action']);

				$new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING);

				$product_id = isset($new_product['product_id']) ? $new_product['product_id'] : NULL;
				if($product_id != NULL){
					$post = get_post( $new_product['product_id'] );
				}

				if( isset( $post->ID ) ){

		        $new_product["product_name"] = $post->post_title;
		        $new_product["product_price"] = get_post_meta($post->ID, 'field-product-price', true);

					if(isset($cart_data[$cart_id]["cart_products"])){  //if session var already exist
						if(isset($cart_data[$cart_id]["cart_products"][$new_product['product_id']])){
							unset($cart_data[$cart_id]["cart_products"][$new_product['product_id']]); //unset old array item
							$sessionHandler->sas_shop_save_data(json_encode( $cart_data ) );
						}
					}
					$cart_data[$cart_id]["cart_products"][$new_product['product_id']] = $new_product; //update or create product session with new item
					$sessionHandler->sas_shop_save_data( json_encode( $cart_data ) );
				}
			}

		}
		//update or remove items
		if(isset($_POST["product_qty"]) || isset($_POST["remove_code"]) ){

			//update item quantity in product session
			if(isset($_POST["product_qty"]) && is_array($_POST["product_qty"])){
				foreach($_POST["product_qty"] as $key => $value){
					if(is_numeric($value) && $value > 0 ){

						$cart_data[$cart_id]["cart_products"][$key]["product_qty"] = $value;
						$sessionHandler->sas_shop_save_data(json_encode( $cart_data ) );

					}
				}
			}
			//remove an item from product session
			if(isset($_POST["remove_code"]) && is_array($_POST["remove_code"])){
				foreach($_POST["remove_code"] as $key){

					unset($cart_data[$cart_id]["cart_products"][$key]);
					$sessionHandler->sas_shop_save_data(json_encode( $cart_data ) );
				}
			}


		}
		//back to return url
		$return_url = (isset($_POST["return_url"]))?urldecode($_POST["return_url"]):''; //return url
		wp_redirect( $return_url ); exit;

	}

	/**
	 * sas_shop_add_to_cart_single_product_process function.
	 *
	 * @access public
	 * @return void
	 */
	public function sas_shop_add_to_cart_single_product_process(){

		$cart_page = get_option( 'sas_shop_sas-shop-cart_page_id' );
		$checkout_page = get_option( 'sas_shop_sas-shop-checkout_page_id' );
		//$hide_mini_cart = get_option( 'widget_sas-shop-cart_hide_mini_cart' , true);


		if(! is_page($cart_page) && ! is_page($checkout_page) ):


		$sessionHandler = Sas_Shop_Session_Handler::getInstance();
		$cart_data = $sessionHandler->sas_shop_get_data();
		$cart_id = $sessionHandler->get_cart_id();

		$cart_url = get_permalink( get_option( 'sas_shop_sas-shop-cart_page_id' ) );

		if(isset($cart_data[$cart_id]["cart_products"]) && count($cart_data[$cart_id]["cart_products"]) > 0) {

			$currencySymbol = Sas_Shop_Settings_Definition::get_sas_shop_currency_symbol( Sas_Shop_Option::get_option( 'sas_shop_currency' ) );

			$html = '';
			$html .= '<div class="cart-view-table-front" id="view-cart">';
			//$html .= '<h3>' . __( 'Shopping Cart', $this->plugin_name ) . '</h3>';
			//$html .= '<form method="post" action="' . esc_url( admin_url('admin-post.php') ) . '">';
			//$html .= '<input type="hidden" name="action" value="add_to_cart" />';
			$html .= '<table width="100%" cellpadding="2" cellspacing="0">';
			$html .= '<tbody>';

			$total = 0;
			$b = 0;
			foreach ($cart_data[$cart_id]["cart_products"] as $cart_itm){

				$product_name = $cart_itm["product_name"];
				$product_qty = $cart_itm["product_qty"];
				$product_price = $cart_itm["product_price"];
				$product_id = $cart_itm["product_id"];
				$bg_color = ($b++%2==1) ? 'odd' : 'even';

				$html .= '<tr class="'.$bg_color.'">';
				//$html .= '<td>' . __('Qty', $this->plugin_name ) . '</td><td><input type="number" size="2" min="1" name="product_qty['.$product_id.']" value="'.$product_qty.'" /></td>';
				//$html .= '<td>' . __('Qty', $this->plugin_name ) . '</td>';
				$html .= '<td>'.$product_qty.' x </td>';
				$html .= '<td colspan="3">'.$product_name.'</td>';
				//$html .= '<td><input type="checkbox" name="remove_code[]" value="'.$product_id.'" /> Remove</td>';
				$html .= '</tr>';
				$subtotal = ($product_price * $product_qty);
				$total = ($total + $subtotal);



				$cart_data[$cart_id]['cart_subtotal'] = $subtotal;
				$cart_data[$cart_id]['cart_total'] = $total;
				$sessionHandler->sas_shop_save_data(json_encode( $cart_data ) );
			}
			$html .= '<tr>';
			$html .= '<td colspan="2">';
			//$html .= '<button type="submit">' . __( 'Update', $this->plugin_name ) . '</button>';
			$html .= '<a href="' . $cart_url . '" style="font-size:12px !important;">Checkout</a>';
			$html .= '</td>';
			//$html .= '<td>';
			//$html .= __('Subtotal: ', $this->plugin_name ) . $subtotal;
			//$html .= '</td>';
			$html .= '<td colspan="2">';
			$html .= __('Total: ', $this->plugin_name ) . $total . ' ' . $currencySymbol;
			$html .= '</td>';
			$html .= '</tr>';
			$html .= '</tbody>';
			$html .= '</table>';

			$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			//$html .= '<input type="hidden" name="return_url" value="' . $current_url . '" />';
			//$html .= '</form>';
			$html .= '</div>';

			return $html;



		}else{

			$html = '';
			$html .= '<div class="cart-view-table-front" id="view-cart">';
			//$html .= '<h3>' . __( 'Shopping Cart', $this->plugin_name ) . '</h3>';
			$html .= '<p>' . __( 'Your cart is empty', $this->plugin_name ) . '</p>';
			$html .= '</div>';

			return $html;

		}
		endif;
	}

	/**
	 * sas_shop_add_to_cart_btn function.
	 *
	 * @access public
	 * @return void
	 */
	public function sas_shop_add_to_cart_front_btn(){

		Sas_Shop_Core_Helpers::sas_shop_get_template( 'cart/add-to-cart-front.php' );
	}

	/**
	 * sas_shop_add_to_cart_single_btn function.
	 *
	 * @access public
	 * @return void
	 */
	public function sas_shop_add_to_cart_single_btn(){

		Sas_Shop_Core_Helpers::sas_shop_get_template( 'cart/add-to-cart-single.php' );
	}

	/**
	 * sas_shop_update_cart_data function.
	 *
	 * @access public
	 * @return void
	 */
	public function sas_shop_update_cart_data(){

		if( isset($_POST['data']) ){

			$sessionHandler = Sas_Shop_Session_Handler::getInstance();
			$cart_data = $sessionHandler->sas_shop_get_data();
			$cart_id = $sessionHandler->get_cart_id();

			parse_str($_POST['data'], $data);

			if(isset($data['sas_shop_shipping_method']) ){
				$shipping = isset($data['sas_shop_shipping_method'][0]) ? $data['sas_shop_shipping_method'][0] : null;
				$shipping_price = '';
				if($shipping == 'shipping_free_name'){
					$shipping_price = Sas_Shop_Option::get_option( 'shipping_free_name' );
					$shipping_tax   = floatval('0.00');

					$cart_data[$cart_id]['shipping_checked'] = 'free_shipping';
					$sessionHandler->sas_shop_save_data(json_encode( $cart_data ) );
				}
				if($shipping == 'shipping_flat_name'){
					$shipping_price = Sas_Shop_Option::get_option( 'shipping_flat_price' );
					$shipping_tax   = Sas_Shop_Option::get_option( 'shipping_flat_tax' );

					$cart_data[$cart_id]['shipping_checked'] = 'flat_shipping';
					$sessionHandler->sas_shop_save_data(json_encode( $cart_data ) );
				}
				$grand_total = $data['grand_total'];
				$taxes_total = $data['taxes_total'];
				$shipping_price_per_qty = 0;
				$shipping_taxes = 0;
				$calculated_tax = round( ( $shipping_price * ( floatval($shipping_tax) / 100 ) ) , 2 );

				$total_cart_qty = $cart_data[$cart_id]['total_cart_qty'];
				$shipping_taxes =   $calculated_tax * $total_cart_qty;
				$shipping_price_per_qty = $shipping_price  * $total_cart_qty;


				$total_shipping_with_tax = $shipping_taxes + $shipping_price_per_qty;
				$taxes_total = floatval( $taxes_total ) + floatval( $shipping_taxes );
				$grand_total = $grand_total + $total_shipping_with_tax;
				$dataResult = array( 'taxes_total' => $taxes_total, 'grand_total' => $grand_total );


				$cart_data[$cart_id]['cart_shipping_unit_price'] = $shipping_price;
				$cart_data[$cart_id]['cart_shipping_unit_tax'] = $shipping_tax;

				$cart_data[$cart_id]['cart_shipping_total_price'] = $shipping_price_per_qty;
				$cart_data[$cart_id]['cart_shipping_total_tax'] = $shipping_taxes;

				$cart_data[$cart_id]['cart_taxes'] = $taxes_total;
				$cart_data[$cart_id]['cart_total'] = $grand_total;
				$sessionHandler->sas_shop_save_data(json_encode( $cart_data ) );

				echo wp_send_json($dataResult);
			}else{
				echo wp_send_json(false);
			}

		}
	}

	/**
	 * sas_shop_register_sidebar function.
	 *
	 * @access public
	 * @return void
	 */
	public function sas_shop_register_sidebar() {
	    register_sidebar( array(
	        'name' => __( 'Sas Shop Sidebar', $this->plugin_name),
	        'id' => 'sas-shop-sidebar',
	        'description' => __( 'Widgets in this area will be shown on product single page.', $this->plugin_name ),
	        'before_widget' => '<li id="%1$s" class="widget %2$s">',
			'after_widget'  => '</li>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>',
	    ) );
	}


}
