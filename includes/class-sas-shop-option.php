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
 * The get_option functionality of the plugin.
 *
 *
 * @package    Sas_Shop
 * @subpackage Sas_Shop/includes
 * @author     UlisesFreitas <ulises.freitas@gmail.com>
 */


class Sas_Shop_Option {

	/**
	 * Get all options
	 *
	 * Looks to see if the specified setting exists, returns default if not.
	 *
	 * @since 	1.0.0
	 * @return 	mixed 	$value 	Value saved / $default if key if not exist
	 */
	static public function get_options() {



		$plugin_options = get_option( 'sas_shop_settings' );

		//$value = isset( $plugin_options ) ? $plugin_options : false;
		//return $value;
		return $plugin_options;
	}
	/**
	 * Get an option
	 *
	 * Looks to see if the specified setting exists, returns default if not.
	 *
	 * @since 	1.0.0
	 * @return 	mixed 	$value 	Value saved / $default if key if not exist
	 */
	static public function get_option( $key, $default = false ) {

		if ( empty( $key ) ) {
			return $default;
		}

		$plugin_options = get_option( 'sas_shop_settings', array() );

		$value = isset( $plugin_options[ $key ] ) ? $plugin_options[ $key ] : $default;

		return $value;
	}

	/**
	 * Update an option
	 *
	 * Updates the specified option.
	 * This is for developers to update options outside the settings page.
	 *
	 * WARNING: Hooks and filters will be triggered!!
	 * @TODO: Trigger hooks & filters, pull requests welcomed
	 *
	 * @since 1.0.0
	 * @return true if the option was saved or false if not
	 */
	static public function update_option( $key, $value ) {

		if ( empty( $key ) ) {
			return false;
		}

		// Load the options
		$plugin_options = get_option( 'sas_shop_settings', array() );

		// Update the specified value in the array
		$plugin_options[ $key ] = $value;

		// Save the options back to the DB
		return update_option( 'sas_shop_settings', $plugin_options );
	}

	/**
	 * Delete an option
	 *
	 * Deletes the specified option.
	 * This is for developers to delete options outside the settings page.
	 *
	 * WARNING: Hooks and filters will be triggered!!
	 * @TODO: Trigger hooks & filters, pull requests welcomed
	 *
	 * @since 1.0.0
	 * @return true if the option was deleted or false if not
	 */
	static public function delete_option( $key ) {

		if ( empty( $key ) ) {
			return false;
		}

		// Load the options
		$plugin_options = get_option( 'sas_shop_settings', array() );

		// Delete the specified key
		unset($plugin_options[ $key ]);

		// Save the options back to the DB
		return update_option( 'sas_shop_settings', $plugin_options );
	}
}
