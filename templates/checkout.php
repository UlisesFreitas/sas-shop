<?php
/**
 * The template for displaying archive and shop posts
 *
 * @package Sas_Shop
 * @subpackage Sas_Shop
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php get_header( 'Shop' ); ?>

	<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
	?>
	<?php do_action('sas_shop_wrapper_start'); ?>

	<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
	?>
	<?php do_action('sas_shop_wrapper_checkout_form' ); ?>
	<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
	?>
	<?php do_action( 'sas_shop_wrapper_end' ); ?>


<?php get_sidebar(); ?>
<?php get_footer( 'Shop' ); ?>