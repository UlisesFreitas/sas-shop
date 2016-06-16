<?php

/**
 *
 *
 * @link       https://disenialia.com
 * @since      1.0.0
 *
 * @package    Sas_Shop
 * @subpackage Sas_Shop/includes
 */

/**
 *
 * This class creates Orders
 *
 * @since      1.0.0
 * @package    Sas_Shop
 * @subpackage Sas_Shop/includes
 * @author     UlisesFreitas <ulises.freitas@gmail.com>
 */


class Sas_Shop_Order {


	private $order_id = null;

	private $order_user = 0;

	private $order_products = array();


	public function __construct(){}


	/**
	 * create_order function.
	 *
	 * @access public
	 * @return $order_id the order created with assigned title like "Order #88"
	 */
	public function create_order(){


				$order = array(
					'post_title'   => 'Order',
					'post_content' => 'New order',
					'post_status'  => 'publish',
					'post_author'  => 1,
					'post_type'    => 'sas_shop_orders'
				);

				$order_id = wp_insert_post($order);

				if (is_wp_error($order_id)) {
					$errors = $order_id->get_error_messages();
					foreach ($errors as $error) {
						echo $error;
					}
				}else{
					$order = array(
						'ID'           => $order_id,
						'post_title'   => 'Order #'.$order_id,
						//'post_content' => '',
					);
					$order_id = wp_update_post( $order );
					if (is_wp_error($order_id)) {
						$errors = $order_id->get_error_messages();
						foreach ($errors as $error) {
							echo $error;
						}
					}
				}


			return $order_id;

	}


	public function get_order_id( $order_id ){
	    return $order_id;
	}
	public function get_order_user(){
	    return $order_user;
	}
	public function get_order_products(){
	    return $order_products;
	}






}

 ?>