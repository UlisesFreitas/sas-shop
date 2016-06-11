<?php
/**
 * The template for displaying user password lost
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

	<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
	?>
	<?php do_action( 'sas_shop_wrapper_password_lost_form' )?>

	<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
	?>
	<?php  do_action( 'sas_shop_wrapper_end' ); ?>
<?php   get_sidebar(); ?>
<?php  get_footer( 'Shop' ); ?>