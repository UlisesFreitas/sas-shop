<?php

/**
 * Fired during plugin activation
 *
 * @link       https://disenialia.com
 * @since      1.0.0
 *
 * @package    Sas_Shop
 * @subpackage Sas_Shop/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Sas_Shop
 * @subpackage Sas_Shop/includes
 * @author     UlisesFreitas <ulises.freitas@gmail.com>
 */
class Sas_Shop_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		new Sas_Shop_Install();

		Sas_Shop_Admin::SasRoles();

		Sas_Shop_Admin::SASProduct();
		Sas_Shop_Admin::SASOrders();


		Sas_Shop_Admin::sas_product_taxonomy_type();


	}

}
