<?php global $attributes; ?>
<div id="password-lost-form" class="widecolumn">
<h3><?php _e( 'Forgot Your Password?', 'sas-shop' ); ?></h3>

	<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
		<?php foreach ( $attributes['errors'] as $error ) : ?>
			<p>
				<?php echo $error; ?>
			</p>
		<?php endforeach; ?>
	<?php endif; ?>

	<p>
		<?php
			echo __(
				"Enter your email address and we'll send you a link you can use to pick a new password.",
				'sas-shop'
			);
		?>
	</p>

	<form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
		<p class="form-row">
			<label for="user_login"><?php echo __( 'Email', 'sas-shop' ); ?>
			<input type="text" name="user_login" id="user_login">
		</p>

		<p class="lostpassword-submit">
			<input type="submit" name="submit" class="sas-shop-btn"
			       value="<?php echo __( 'Reset Password', 'sas-shop' ); ?>"/>
		</p>
	</form>
</div>