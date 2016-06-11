<?php
/*
 *
 * 	@package Sas Shop
 *  @since 1.0.0
 *
 */

?>

<!--div class="row"-->
	<div class="sas-shop-col-3 sas-shop-col-m-12">
		<a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>">
			<?php the_post_thumbnail( 'sas-shop-product-thumbnail' ); ?>
		</a>
		<h3><?php echo get_the_title(); ?></h3>
		<?php
		$price = Sas_Shop_Core_Helpers::sas_shop_format_decimal(get_post_meta(get_the_ID(), 'field-product-price', true), 2);
		$currencySymbol = Sas_Shop_Settings_Definition::get_sas_shop_currency_symbol( Sas_Shop_Option::get_option( 'sas_shop_currency' ) );
		?>
		<span><?php echo $price . ' ' . $currencySymbol; ?></span>

		<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
		 */
		?>
		<?php do_action( 'sas_shop_add_to_cart_front_btn_display' ); ?>
	</div>
<!--/div-->