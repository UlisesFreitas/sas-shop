<?php

	global $attributes;

	$id               = $attributes['userdata']->ID;
	$email            = $attributes['userdata']->user_email;
	$first_name       = isset($attributes['usermeta']['first_name']) ? $attributes['usermeta']['first_name'] : '';
	$last_name        = isset($attributes['usermeta']['last_name']) ? $attributes['usermeta']['last_name'] : '';
	$sas_shop_phone   =	isset($attributes['usermeta']['sas_shop_phone'] ) ? $attributes['usermeta']['sas_shop_phone'] : '';
	$sas_shop_address = isset($attributes['usermeta']['sas_shop_address']) ? $attributes['usermeta']['sas_shop_address'] : '';
	$sas_shop_country = isset($attributes['usermeta']['sas_shop_country']) ? $attributes['usermeta']['sas_shop_country'] : '';
	$sas_shop_city    = isset($attributes['usermeta']['sas_shop_city']) ? $attributes['usermeta']['sas_shop_city'] : '';
	$sas_shop_zipcode = isset($attributes['usermeta']['sas_shop_zipcode']) ? $attributes['usermeta']['sas_shop_zipcode'] : '';
	$errors           = isset($attributes['errors']) ? $attributes['errors'] : array();
?>
<div id="register-form" class="widecolumn">
	<?php

		//if(isset($_POST['action']) && $_POST['action'] == 'sas_shop_update_account'){

			//do_action( 'sas_shop_update_account_user');
			//exit;
		//}
	?>
	<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
		<?php foreach ( $attributes['errors'] as $error ) : ?>
			<p>
				<?php echo $error; ?>
			</p>
		<?php endforeach; ?>
	<?php endif; ?>

	<form id="your-profile" action="<?php echo the_permalink(); ?>" method="post">



		<?php wp_nonce_field('update-profile_' . $attributes['userdata']->ID) ?>
		<input type="hidden" name="from" value="profile">
		<input type="hidden" name="checkuser_id" value="<?php echo $attributes['userdata']->ID; ?>" />

		<p class="form-row">

			<input type="text" name="email" readonly="readonly" id="email" placeholder="<?php _e( '* Email', 'sas-shop' ); ?>" value="<?php echo $attributes['userdata']->user_email; ?>">
		</p>

		<p class="form-row">

			<input type="text" name="first_name" id="first-name" placeholder="<?php _e( 'First name', 'sas-shop' ); ?>" value="<?php echo $first_name;  ?>">
		</p>

		<p class="form-row">

			<input type="text" name="last_name" id="last-name" placeholder="<?php _e( 'Last name', 'sas-shop' ); ?>" value="<?php echo $last_name; ?>">
		</p>

		<p class="form-row">

			<input type="text" name="sas_shop_phone" id="sas_shop_phone" placeholder="<?php _e( 'Phone', 'sas-shop' ); ?>"  value="<?php echo $sas_shop_phone; ?>">
		</p>

		<p class="form-row">

			<input type="text" name="sas_shop_address" id="sas_shop_address" placeholder="<?php _e( 'Address', 'sas-shop' ); ?>" value="<?php echo $sas_shop_address; ?>">
		</p>
		<p class="form-row">

			<input type="text" name="sas_shop_country" id="sas_shop_country" placeholder="<?php _e( 'Country', 'sas-shop' ); ?>" value="<?php echo $sas_shop_country; ?>">
		</p>
		<p class="form-row">

			<input type="text" name="sas_shop_city" id="sas_shop_city" placeholder="<?php _e( 'City', 'sas-shop' ); ?>" value="<?php echo $sas_shop_city; ?>">
		</p>

		<p class="form-row">

			<input type="text" name="sas_shop_zipcode" id="sas_shop_zipcode" placeholder="<?php _e( 'Zip code', 'sas-shop' ); ?>" value="<?php echo $sas_shop_zipcode; ?>">
		</p>


		<p class="submit">
			<input type="hidden" name="action" value="sas_shop_update_account" />
			<input type="hidden" name="user_id" id="user_id" value="<?php echo $attributes['userdata']->ID;?>">
			<input type="submit" name="submit" class="button" value="<?php _e( 'Update', 'sas-shop' ); ?>"/>
		</p>
	</form>
</div>