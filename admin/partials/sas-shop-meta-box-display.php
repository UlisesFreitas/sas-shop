<?php
/**
 * Provide a meta box view for the settings page
 *
 * @link       https://disenialia.com
 * @since      1.0.0
 *
 * @package    SAS_Shop
 * @subpackage SAS_Shop/admin/partials
 */

/**
 * Meta Box
 *
 * Renders a single meta box.
 *
 * @since       1.0.0
*/
?>

<form action="options.php" method="POST">
	<?php settings_fields( 'sas_shop_settings' ); ?>
	<?php do_settings_sections( 'sas_shop_settings_' . $active_tab ); ?>
	<?php submit_button(); ?>
</form>
<br class="clear" />
