<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package Sas_Shop
 * @subpackage Sas_Shop
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php get_header(); ?>

<?php do_action( 'sas_shop_add_to_cart_single_product' ); ?>

<?php do_action( 'sas_shop_wrapper_start' ); ?>

<?php do_action( 'sas_shop_wrapper_single_content' ); ?>

<?php

//	while ( have_posts() ) : the_post();
//       Sas_Shop_Core_Helpers::sas_shop_get_template( 'single/content-single.php' );
//	endwhile;
?>
<?php do_action( 'sas_shop_wrapper_end' ); ?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>