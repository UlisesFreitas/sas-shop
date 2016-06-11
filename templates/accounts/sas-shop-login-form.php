<?php
/**
 * The template for displaying user account
 *
 * @package Sas_Shop
 * @subpackage Sas_Shop
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php global $attributes; ?>
<?php

	if( is_user_logged_in() ){
		echo __('You already logged.','sas-shop');
		return;
	}
?>
<h3><?php echo __( 'Login to your Account', 'sas-shop'); ?></h3>
<?php if (  true ) : ?>

<div class="login">

	<!-- Show errors if there are any -->
	<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
		<?php foreach ( $attributes['errors'] as $error ) : ?>
			<p>
				<?php echo $error; ?>
			</p>
		<?php endforeach; ?>
	<?php endif; ?>

	<!-- Show logged out message if user just logged out -->
	<?php if ( !empty( $attributes['logged_out'] ) ) : ?>
		<p>
			<?php echo __( 'You have signed out. Would you like to sign in again?', 'sas-shop' ); ?>
		</p>
	<?php endif; ?>

	<?php if ( !empty( $attributes['registered'] ) ): ?>
		<p>
			<?php
				printf(
					__( 'You have successfully registered to <strong>%s</strong>. We have emailed your password to the email address you entered.', 'sas-shop' ),
					get_bloginfo( 'name' )
				);
			?>
		</p>
	<?php endif; ?>

	<?php if ( !empty( $attributes['lost_password_sent'] ) ): ?>
		<p>
			<?php echo __( 'Check your email for a link to reset your password.', 'sas-shop' ); ?>
		</p>
	<?php endif; ?>

	<?php if ( !empty( $attributes['password_updated'] ) ) : ?>
		<p>
			<?php echo __( 'Your password has been changed. You can sign in now.', 'sas-shop' ); ?>
		</p>
	<?php endif; ?>

	<?php wp_login_form($attributes); ?>
	<?php if(!empty($attributes['forgot_password_link'])): ?>
	<a class="forgot-password" href="<?php echo wp_lostpassword_url(); ?>">
		<?php echo __( 'Forgot your password?', 'sas-shop' ); ?>
	</a>
	<?php endif; ?>
</div>
<?php else : ?>
	<div class="login-form-container">
		<form id="sas-shop-login-form" method="post" action="<?php echo wp_login_url(); ?>">
			<p>
				<label for="user_login"><?php _e( 'Email', 'sas-shop' ); ?></label>
				<input type="text" name="user_login" id="user_login" value="<?php echo isset($_REQUEST['user_login']) ? $_REQUEST['user_login'] : ''; ?>">
			</p>
			<p>
				<label for="user_pass"><?php _e( 'Password', 'sas-shop' ); ?></label>
				<input type="password" name="user_pass" id="user_pass">
			</p>
			<p>
				<input id="wp-submit" type="submit" value="<?php _e( 'Sign In', 'sas-shop' ); ?>">
			</p>
		</form>

	</div>
<?php endif; ?>