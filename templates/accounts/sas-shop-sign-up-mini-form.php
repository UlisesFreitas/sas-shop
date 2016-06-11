<?php global $attributes; ?>
<div id="register-form">
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
		<input type="hidden" name="action" value="signup_mini_form" />
		<p>
			<label for="user_login"><?php _e( 'Email', 'sas-shop' ); ?></label>
			<input type="text" name="email" id="email" placeholder="<?php echo __( '* Email', 'sas-shop'); ?>">
		</p>
		<p>
			<label for="user_password"><?php _e( 'Password', 'sas-shop' ); ?></label>
			<input type="password" name="user_password" id="user_password" placeholder="<?php echo __( '* Password', 'sas-shop'); ?>">
		</p>

		<!--small>
			<?php _e( 'Note: Your password will be generated automatically and emailed to the address you specify above.', 'sas-shop'); ?>
		</small-->

		<p class="signup-submit">
			<input type="submit" name="submit" class="sas-shop-btn"
			       value="<?php echo __( 'Register', 'sas-shop'); ?>"/>
		</p>
	</form>
</div>