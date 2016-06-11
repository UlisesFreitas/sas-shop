<?php
/**
 * The template for displaying user account
 *
 * @package Sas_Shop
 * @subpackage Sas_Shop
 * @since 1.0.0
 */
?>

<?php get_header( 'Shop' ); ?>
	<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
	?>
	<?php  do_action('sas_shop_wrapper_start'); ?>
	<div class="row">
	<?php if( is_user_logged_in() ): ?>
		<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
		?>
		<?php do_action( 'sas_shop_wrapper_myaccount_form' )?>
	<?php else: ?>
	<div class="sas-shop-col-6">
		<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
		?>
		<?php  do_action( 'sas_shop_wrapper_login_form' ); ?>
	</div>
	<div class="sas-shop-col-6">

		<?php do_action( 'sas_shop_wrapper_mini_signup_form' ); ?>
	</div>
	<?php endif; ?>
	</div>
	<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
	?>
	<?php  do_action( 'sas_shop_wrapper_end' ); ?>
<?php   get_sidebar(); ?>
<?php  get_footer( 'Shop' ); ?>