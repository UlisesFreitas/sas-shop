<?php

 /** Session functionality of the plugin.
 *
 * Defines the plugin name, version
 * @since      1.0.0
 * @package    Sas_Shop
 * @subpackage Sas_Shop/public
 * @author     UlisesFreitas <ulises.freitas@gmail.com>
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
	 private $container;

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



		//add_action( 'plugins_loaded', array( &$this, 'sas_shop_session_start' ) );

		//print_r($this->stored_data);
		//$this->write_data($array);
		//$this->readData();

	}

    /**
	 * Start new or resume existing session.
	 *
	 * Resumes an existing session based on a value sent by the _wp_session cookie.
	 *
	 */
	public function sas_shop_session_start() {


		if(! session_id() ){
			session_start();
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

	/**
	 * GetIP function.
	 *
	 * @access public
	 * @return void
	 */
	public function getIP(){

    	foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        	if (array_key_exists($key, $_SERVER) === true){
            	foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip){
                	if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    	return $ip;
                	}else{
	                	return false;
                	}
            	}
        	}
    	}
	}



	public function getData(){

		$data = json_decode( self::readData() );
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
	protected function readData() {


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
	public function saveData($data) {

		$this->container = $data;
		delete_option( 'sas_session_' . $this->session_id );
		add_option( 'sas_session_' . $this->session_id, $this->container, '', 'no' );

	}
	public static function SetSessionVar($name, $value){

		if(!$name || !$value){
			return false;
		}else{
			$_SESSION[$name] = $value;
		}

	}

	public static function GetSessionVar($name){

			if (isset($_SESSION[$name])) {
				 return $_SESSION[$name];
			} else {
				return false;
			}

	}

	public static function DeleteSessionVar($name){

		unset($_SESSION[$name]);

	}

	/**
	 * Unset all session variables.
	 */
	public function wp_session_unset() {
		$wp_session = self::getInstance();

		$wp_session->reset();
	}

}
?>