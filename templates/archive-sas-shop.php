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
		<?php do_action( 'sas_shop_wrapper_pre_loop_args' ); ?>

		<?php if ( have_posts() ) : ?>

			<header class="page-header">Sas Shop</header>

			<?php // while ( have_posts() ) : the_post(); ?>

				<?php
					/*
					 * @since 1.0.0
					 * Defined in public/class-sas-shop-public.php
				 	 */
				?>
				<?php do_action( 'sas_shop_wrapper_loop' ); ?>

			<?php // endwhile; ?>

			<?php	//wp_reset_postdata(); ?>
			<?php 	//wp_reset_query(); ?>

			<?php	//Pagination here ?>

		<?php else : ?>

			<?php
				/*
				 * @since 1.0.0
				 * Defined in public/class-sas-shop-public.php
			 	 */
			?>
			<?php do_action( 'sas_shop_wrapper_no_content' ); ?>

		<?php endif; ?>

	<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
	?>
	<?php do_action( 'sas_shop_wrapper_end' ); ?>


<?php get_sidebar('sas-shop-sidebar-1'); ?>
<?php get_sidebar(); ?>
<?php get_footer( 'Shop' ); ?>