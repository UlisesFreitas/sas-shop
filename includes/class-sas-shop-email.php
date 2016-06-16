<?php

 /** Session functionality of the plugin.
 *
 * Defines the plugin name, version
 * @since      1.0.0
 * @package    Sas_Shop
 * @subpackage Sas_Shop/public
 * @author     UlisesFreitas <ulises.freitas@gmail.com>
 */


class Sas_Shop_Email_Handler {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $session_id     The session Id
	 */
	 private $email_manager;
	 private $sas_shop_email_manager_name;

	 /**
	 * Internal data collection.
	 *
	 * @var array
	 */

	 private $message_template;

	 private $message;

	 private $headers;

	 private $subject;

	 private $user_email;

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


	public function __construct(){

		$this->message = '';
		$this->subject = '';
		$this->user_email = '';

		$this->email_manager = Sas_Shop_Option::get_option( 'sas_shop_email_manager' );
		$this->sas_shop_email_manager_name = Sas_Shop_Option::get_option( 'sas_shop_email_manager_name' );

		add_filter ('wp_mail_from', array( $this, 'sas_shop_mail_from' ) );
		add_filter ('wp_mail_from_name', array( $this, 'sas_shop_mail_from_name' ) );
	}


	public function sas_shop_mail_content_type() {
		return "text/html";
	}

	public function sas_shop_mail_from() {
		return $this->email_manager;
	}


	public function sas_shop_mail_from_name() {
		return $this->sas_shop_email_manager_name;
	}

	public function sendEmail( $orderID, $subject, $emailTemplate = 'email-customer-new-order' ){

		$currencySymbol = Sas_Shop_Settings_Definition::get_sas_shop_currency_symbol( Sas_Shop_Option::get_option( 'sas_shop_currency' ) );

		add_filter ('wp_mail_content_type', array( $this , 'sas_shop_mail_content_type') );


		switch($emailTemplate){

			case 'email-customer-new-order':
				ob_start();

			include(plugin_dir_path( dirname(__FILE__) ) .'templates/email/email-header.php');
			include(plugin_dir_path( dirname(__FILE__) ) .'templates/email/email-customer-new-order.php');
			include(plugin_dir_path( dirname(__FILE__) ) .'templates/email/email-footer.php');

			$this->message_template = ob_get_contents();

			ob_clean();

			$this->subject = $subject;
			//replace placeholders with user-specific content
			//$sw_year = date('Y');
			$this->message = str_ireplace('[name]', get_post_meta( $orderID, 'field-order-customer-name', true), $this->message_template);
			$this->message = str_ireplace('[lastname]', get_post_meta( $orderID, 'field-order-customer-lastname', true), $this->message);

			$productlist = get_post_meta($orderID, 'field-order-cart-products' , false );
			$productlist = json_decode( $productlist[0]  );
			$productlist = json_decode(json_encode($productlist), true );

			$newProductList = '<div class="sas-shop-tab-wrap"><table class="sas-shop-tab">
	  <tr>
	    <th class="sas-shop-t">Product</th>
	    <th class="sas-shop-t">qty</th>
	    <th class="sas-shop-t">price</th>
	    <th class="sas-shop-t">Subtotal</th>
	  </tr>';
			foreach($productlist as $product){
				$newProductList .= '<tr><td class="sas-shop-t">'.$product['product_name'] . '</td><td class="sas-shop-t">' . $product['product_qty'] . '</td><td class="sas-shop-t">' . $product['product_price'] . ' [currency]</td><td class="sas-shop-t">' . round( $product['product_price'] *  $product['product_qty'], 2) . ' [currency]</td></tr>';
			}
			$newProductList .= '</table></div><br />';


			$this->message = str_ireplace('[productslist]', $newProductList , $this->message);


			$this->message = str_ireplace('[currency]', $currencySymbol, $this->message);
			$this->message = str_ireplace('[orderid]', $orderID, $this->message);
			$this->message = str_ireplace('[taxes]', get_post_meta($orderID, 'field-order-cart-taxes', true), $this->message);
			$this->message = str_ireplace('[subtotal]', get_post_meta($orderID, 'field-order-cart-subtotal', true), $this->message);
			$this->message = str_ireplace('[total]', get_post_meta($orderID, 'field-order-cart-total', true), $this->message);


			break;
		}

		//Prepare headers for HTML
		$this->headers  = 'MIME-Version: 1.0' . "\r\n";
		$this->headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


		$this->user_email = get_post_meta($orderID, 'field-order-customer-email', true);
		//Send user notification email
		$sended = wp_mail($this->user_email, $this->subject , $this->message, $this->headers);

		if($sended == 1){
			update_post_meta($orderID, 'field-email-customer-new-order', 1);
		}else{
			update_post_meta($orderID, 'field-email-customer-new-order', 0);
		}

		remove_filter ('wp_mail_content_type', array( $this, 'sas_shop_mail_content_type' ) );



	}


}
?>