<?php global $attributes; ?>
<div id="register-form" class="widecolumn">
<h3><?php echo __( 'Create an Account', 'sas-shop'); ?></h3>
	<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
		<?php foreach ( $attributes['errors'] as $error ) : ?>
			<p>
				<?php echo $error; ?>
			</p>
		<?php endforeach; ?>
	<?php endif; ?>

	<!--form id="signupform" action="<?php echo wp_registration_url(); ?>" method="post"-->
	<form id="signupform" action="<?php echo get_the_permalink( get_option( 'sas_shop_sas-shop-signup_page_id' ) ); ?>" method="post">
		<p class="form-row">

			<input type="text" name="email" id="email" placeholder="<?php echo __( '* Email', 'sas-shop'); ?>">
		</p>

		<p class="form-row">

			<input type="text" name="first_name" id="first-name" placeholder="<?php echo __( 'First name', 'sas-shop'); ?>">
		</p>

		<p class="form-row">

			<input type="text" name="last_name" id="last-name" placeholder="<?php echo __( 'Last name', 'sas-shop'); ?>">
		</p>

		<p class="form-row">

			<input type="text" name="sas_shop_phone" id="sas_shop_phone" placeholder="<?php echo __( 'Phone', 'sas-shop'); ?>">
		</p>

		<p class="form-row">

			<input type="text" name="sas_shop_address" id="sas_shop_address" placeholder="<?php echo __( 'Address', 'sas-shop'); ?>">
		</p>

		<p class="form-row">

			<input type="text" name="sas_shop_country" id="sas_shop_country" placeholder="<?php echo __( 'Country', 'sas-shop'); ?>">
		</p>

		<p class="form-row">

			<input type="text" name="sas_shop_city" id="sas_shop_city" placeholder="<?php echo __( 'City', 'sas-shop'); ?>">
		</p>

		<p class="form-row">

			<input type="text" name="sas_shop_zipcode" id="sas_shop_zipcode" placeholder="<?php echo __( 'Zip code', 'sas-shop'); ?>">
		</p>

		<p class="form-row">

			<input type="password" name="user_password" id="user_password" placeholder="<?php echo __( '* Password', 'sas-shop'); ?>">
		</p>

		<p class="signup-submit">
			<input type="submit" name="submit" class="sas-shop-btn"
			       value="<?php echo __( 'Sign Up', 'sas-shop'); ?>"/>
		</p>
	</form>
</div>