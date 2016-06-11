<?php
/**
 * Installation related functions and actions.
 *
 * @author 		UlisesFreitas
 * @category 	Admin
 * @package 	Sas Shop/Classes
 * @version 	1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'Sas_Shop_Install' ) ) {

/**
 * Sas_Shop_Install Class
 */
class Sas_Shop_Install {

	/**
	 * Hook in tabs.
	 */
	public function __construct() {

		$this->create_pages();

	}

	/**
	 * List the pages that the plugin relies on,
	 * fetching the page id's in variables.
	 *
	 * @access public
	 * @return void
	 */
	public function sas_shop_pages() {

		return apply_filters(
							'sas_shop_pages', array(

										'sas-shop-front' => array(
											'name' 		=> _x( 'Sas Shop', 'sas-shop', 'sas-shop' ),
											'title' 	=> __( 'Shop', 'sas-shop' ),
											'content' 	=> __( '', 'sas-shop' )
										),
										'sas-shop-myaccount' => array(
											'name' 		=> _x( 'My Account', 'sas-shop-my-account', 'sas-shop' ),
											'title' 	=> __( 'My Account', 'sas-shop' ),
											'content' 	=> __( '', 'sas-shop' )
										),
										'sas-shop-login' => array(
											'name' 		=> _x( 'Sas Shop Login', 'sas-shop-login', 'sas-shop' ),
											'title' 	=> __( 'Login', 'sas-shop' ),
											'content' 	=> __( '', 'sas-shop' )
										),
										'sas-shop-cart' => array(
											'name' 		=> _x( 'Cart', 'sas-shop-cart', 'sas-shop' ),
											'title' 	=> __( 'Cart', 'sas-shop' ),
											'content' 	=> __( '', 'sas-shop' )
										),
										'sas-shop-checkout' => array(
											'name' 		=> _x( 'Sas Shop Checkout', 'sas-shop-checkout', 'sas-shop' ),
											'title' 	=> __( 'Checkout', 'sas-shop' ),
											'content' 	=> __( '', 'sas-shop' )
										),
										'sas-shop-password-lost' => array(
											'name' 		=> _x( 'Sas Shop Password Lost', 'sas-shop-password-lost', 'sas-shop' ),
											'title' => __( 'Forgot Your Password?', 'sas-shop' ),
											'content' 	=> __( '', 'sas-shop' )
										),
										'sas-shop-signup' => array(
											'name' 		=> _x( 'Sas Shop signup', 'sas-shop-signup', 'sas-shop' ),
											'title' => __( 'Sign Up', 'sas-shop' ),
											'content' 	=> __( '', 'sas-shop' )
										),
								    )
							);
	}

	/**
	 * Create the pages the plugin relies on,
	 * storing page id's in variables.
	 *
	 * @access public
	 * @return void
	 */
	public static function create_pages() {
		$pages = self::sas_shop_pages(); // Get the pages.

		foreach ( $pages as $key => $page ) {
			Sas_Shop_Admin::sas_shop_create_page( esc_sql( $page['name'] ), 'sas_shop_' . $key . '_page_id', $page['title'], $page['content'], ! empty( $page['parent'] ) ? self::sas_shop_get_page_id( $page['parent'] ) : '' );


		}
	}



} // end if class.

} // end if class exists.

//return new Sas_Shop_Install();

?>