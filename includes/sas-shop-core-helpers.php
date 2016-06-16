<?php
/**
 * Sas Shop Core Helpers
 *
 * General core functions available on both the front-end and admin.
 *
 * @author 		UlisesFreitas
 * @category 	Core
 * @package 	Sas Shop/Functions
 * @version 	1.0.0
 */

//if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Include core functions
//include( 'sas-shop-conditional-functions.php' );
//include( 'sas-shop-formatting-functions.php' );

class Sas_Shop_Core_Helpers {


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

	public function __construct($version, $plugin_name){

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}


	/**
	 * Retrieve page ids. returns -1 if no page is found
	 *
	 * @access public
	 * @param string $page
	 * @return int
	 */
	public function sas_shop_get_page_id( $page ) {

		$page = apply_filters( 'sas_shop_get_' . $page . '_page_id', get_option('sas_shop_' . $page . '_page_id' ) );

		return $page ? $page : -1;
	}

	/**
	 * Get template part.
	 *
	 * @access public
	 * @param mixed $slug
	 * @param string $name (default: '')
	 * @return void
	 */
	public function sas_shop_get_template_part( $slug, $name = '' ) {

		$template = '';

		// Look in yourtheme/slug-name.php and yourtheme/sas-shop/slug-name.php
		if ( $name ) {
			$template = locate_template( array ( "{$slug}-{$name}.php", Sas_Shop::template_path() . "{$slug}-{$name}.php" ) );
		}

		// Get default slug-name.php
		if ( !$template && $name && file_exists( Sas_Shop::plugin_path() . "/templates/{$slug}-{$name}.php" ) )
			$template = Sas_Shop::plugin_path() . "/templates/{$slug}-{$name}.php";

		// If template file doesn't exist, look in yourtheme/slug.php and yourtheme/sas-shop/slug.php
		if ( !$template )
			$template = locate_template( array ( "{$slug}.php", Sas_Shop::template_path() . "{$slug}.php" ) );

		if ( $template )
			load_template( $template, false );
	}

	/**
	 * Get other templates, passing attributes and including the file.
	 *
	 * @access public
	 * @param mixed $template_name
	 * @param array $args (default: array())
	 * @param string $template_path (default: '')
	 * @param string $default_path (default: '')
	 * @return void
	 */
	public function sas_shop_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {

		if ( $args && is_array($args) )
			extract( $args );

		$located = self::sas_shop_locate_template( $template_name, $template_path, $default_path );

		if(!$located){
			print('NO');
			exit;
		}

		do_action( 'sas_shop_before_template_part', $template_name, $template_path, $located, $args );

		include( $located );

		do_action( 'sas_shop_after_template_part', $template_name, $template_path, $located, $args );
	}

	/**
	 * Locate a template and return the path for inclusion.
	 *
	 * This is the load order:
	 *
	 *		yourtheme		/	$template_path	/	$template_name
	 *		yourtheme		/	$template_name
	 *		$default_path	/	$template_name
	 *
	 * @access public
	 * @param mixed $template_name
	 * @param string $template_path (default: '')
	 * @param string $default_path (default: '')
	 * @return string
	 */
	public function sas_shop_locate_template( $template_name, $template_path = '', $default_path = '' ) {
		if ( ! $template_path ) $template_path = Sas_Shop::template_path();
		if ( ! $default_path ) $default_path = Sas_Shop::plugin_path() . '/templates/';

		// Look within passed path within the theme - this is priority
		$template = locate_template(
			array(
				trailingslashit( $template_path ) . $template_name,
				$template_name
			)
		);

		// Get default template
		if ( ! $template )
			$template = $default_path . $template_name;

		// Return what we found
		return apply_filters('sas_shop_locate_template', $template, $template_name, $template_path);
	}


	/**
	 * Trim trailing zeros off prices.
	 *
	 * @access public
	 * @param mixed $price
	 * @return string
	 */
	public function sas_shop_trim_zeros( $price ) {
		return preg_replace( '/' . preg_quote( get_option( 'sas_shop_price_decimal_sep' ), '/' ) . '0++$/', '', $price );
	}

	/**
	 * Format decimal numbers ready for DB storage
	 *
	 * Sanitize, remove locale formatting, and optionally round + trim off zeros
	 *
	 * @param  float|string $number Expects either a float or a string with a decimal separator only (no thousands)
	 * @param  mixed $dp number of decimal points to use, blank to use sas_shop_price_num_decimals, or false to avoid all rounding.
	 * @param  boolean $trim_zeros from end of string
	 * @return string
	 */
	public function sas_shop_format_decimal( $number, $dp = false, $trim_zeros = false ) {
		// Remove locale from string
		if ( ! is_float( $number ) ) {
			$locale   = localeconv();
			$decimals = array( get_option( 'sas_shop_price_decimal_sep' ), $locale['decimal_point'], $locale['mon_decimal_point'] );
			$number   = self::sas_shop_clean( str_replace( $decimals, '.', $number ) );
		}

		// DP is false - don't use number format, just return a string in our format
		if ( $dp !== false ) {
			$dp     = intval( $dp == "" ? get_option( 'sas_shop_price_num_decimals' ) : $dp );
			$number = number_format( floatval( $number ), $dp, '.', '' );
		}

		if ( $trim_zeros && strstr( $number, '.' ) ) {
			$number = rtrim( rtrim( $number, '0' ), '.' );
		}

		return $number;
	}

	/**
	 * Clean variables
	 *
	 * @access public
	 * @param string $var
	 * @return string
	 */
	public function sas_shop_clean( $var ) {
		return sanitize_text_field( $var );
	}

	/**
	 * Convert a float to a string without locale formatting which PHP adds when changing floats to strings
	 * @param  float $float
	 * @return string
	 */
	public function sas_shop_float_to_string( $float ) {
		if ( ! is_float( $float ) ) {
			return $float;
		}

		$locale = localeconv();
		$string = strval( $float );
		$string = str_replace( $locale['decimal_point'], '.', $string );

		return $string;
	}

	public function sas_shop_shipping_names( $shipping_method ){

		if( $shipping_method == 'free_shipping' ){
			$name = 'shipping_free_name';
		}
		if( $shipping_method == 'flat_shipping' ){
			$name = 'shipping_flat_name';
		}

		$shipping_name = Sas_Shop_Option::get_option($name);

		return $shipping_name;


	}

	public function sas_shop_order_status_names( $order_status ){

		/*
			'options' => array( 'cancelled' => 'Cancelled', 'completed' => 'Completed', 'failed' => 'Failed', 'pending_payment' => 'Pending Payment', 'processing' => 'Processing', 'refunded' => 'Refunded'
		*/
		switch( $order_status ){
			case 'cancelled':
				$name = __('Cancelled', SAS_SHOP_NAME);
			break;
			case 'completed':
				$name = __('Completed', SAS_SHOP_NAME);
			break;
			case 'failed':
				$name = __('Failed', SAS_SHOP_NAME);
			break;
			case 'pending_payment':
				$name = __('Pending Payment', SAS_SHOP_NAME);
			break;
			case 'processing':
				$name = __('Processing', SAS_SHOP_NAME);
			break;
			case 'refunded':
				$name = __('Refunded', SAS_SHOP_NAME);
			break;

		}

		return $name;


	}


}
?>