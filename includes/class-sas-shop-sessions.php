<?php

 /** Session functionality of the plugin.
 *
 * Defines the plugin name, version
 * @since      1.0.0
 * @package    Sas_Shop
 * @subpackage Sas_Shop/public
 * @author     UlisesFreitas <ulises.freitas@gmail.com>
 */

 /**
		 *
		 * Sample saving session


		$array = array('cart' => array(
										'cart_products' => array(
																 'product_id' => '1')
									    )
					   );
		$sessionHandler = Sas_Shop_Session_Handler::getInstance();
		$sessionHandler->saveData(json_encode( $array) );

		 */
		 /*
		  * Sample getting session

		  print_r( $sessionHandler->getData() );

		*/

class Sas_Shop_Session_Handler {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $session_id     The session Id
	 */
	 private $session_id;

	 /**
	 * Internal data collection.
	 *
	 * @var array
	 */

	 private $stored_data;

	 /**
	 * Singleton instance.
	 *
	 * @var bool|WP_Session
	 */
	private static $instance = false;

	/**
	 * Retrieve the current session instance.
	 *
	 * @param bool $session_id Session ID from which to populate data.
	 *
	 * @return bool|WP_Session
	 */
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	public function __construct( ){

		$this->stored_data = array();
		$this->session_id = self::sas_shop_session_start();

	}

	/**
	 * get_session_id function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_session_id(){
		return $this->session_id;
	}

	/**
	 * get_session_id function.
	 *
	 * @access public
	 * @return void
	 */
	public function get_cart_id(){
		return 'cart_' . $this->session_id;
	}

    /**
	 * Start new or resume existing session.
	 *
	 * Resumes an existing session based on a value sent by the _wp_session cookie.
	 *
	 */
	public function sas_shop_session_start() {


		if(! session_id() ){
			//session_start();
		}

		if( $this->session_id < 32 ){
			$this->session_id = $this->generate_id();
		}
		return $this->session_id;


	}
	public function get_ip_address() {
    if ( isset( $_SERVER['X-Real-IP'] ) ) {

      	return $_SERVER['X-Real-IP'];

    	} elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

      	// Proxy servers can send through this header like this: X-Forwarded-For: client1, proxy1, proxy2
      	// Make sure we always only send through the first IP in the list which should always be the client IP.

      	return trim( current( explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) );

    	} elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {

      		return $_SERVER['REMOTE_ADDR'];
    	}
    		return '';
	}

	public function sas_shop_get_data(){

		$data = json_decode( self::sas_shop_read_data() );
		$this->stored_data = json_decode(json_encode($data), True);
		return $this->stored_data;
	}

	/**
	 * Read data from a transient for the current session.
	 *
	 * Automatically resets the expiration time for the session transient to some time in the future.
	 *
	 * @return array
	 */
	protected function sas_shop_read_data() {


		$this->stored_data = get_option( "sas_session_{$this->session_id}" );

		return $this->stored_data;
	}

	/**
	 * Generate a cryptographically strong unique ID for the session token.
	 *
	 * @return string
	 */
	protected function generate_id() {

		$data = '';
		$rand = rand();
		$getIP = self::get_ip_address();
		if(! empty( $getIP ) ){

			$data = $data.$getIP;
			$generatedID = md5($data);

			$this->session_id = $generatedID;
			//add_option( 'sas_session_'. $generatedID , $generatedID );
			set_transient('sas_session_' . $generatedID , $generatedID, 12 * HOUR_IN_SECONDS );
			return $this->session_id;
		}else{
			return false;
		}

	}

    /**
	 * Write the data from the current session to the data storage system.
	 */
	public function sas_shop_save_data($data) {

		$this->stored_data = $data;
		//delete_option( 'sas_session_' . $this->session_id );
		if( get_option( "sas_session_{$this->session_id}" ) ){
			 update_option( "sas_session_{$this->session_id}", $this->stored_data, '', 'no'  );
		}else{
			add_option( "sas_session_{$this->session_id}", $this->stored_data, '', 'no' );
		}

	}

	/**
	 * Unset all session variables.
	 */
	public function sas_shop_session_unset() {

		$sas_shop_session = self::getInstance();

		$sas_shop_session->reset();
	}

	/**
	 * Flushes all session variables.
	 */
	protected function reset() {
		delete_option( "sas_session_{$this->session_id}" );
		$this->stored_data = array();

	}
}
?>