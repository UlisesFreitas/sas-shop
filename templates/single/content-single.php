<?php
/*The template for displaying content
 *
 * @package Sas Shop
 * @author Ulises Freitas
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
while ( have_posts() ) : the_post();
?>
<div class="row">
	<div class="sas-shop-col-6 sas-shop-col-m-6">
		<?php the_post_thumbnail( 'sas-shop-product-thumbnail' ); ?>
	</div>
	<div class="sas-shop-col-6 sas-shop-col-m-6">

		<?php if(get_the_title() != ''): ?>
		<h1><?php echo get_the_title(); ?></h1>
		<?php endif; ?>
		<?php

		$price = Sas_Shop_Core_Helpers::sas_shop_format_decimal(
																get_post_meta(get_the_ID(), 'field-product-price', true),
																Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' )
																);
		$currencySymbol = Sas_Shop_Settings_Definition::get_sas_shop_currency_symbol( Sas_Shop_Option::get_option( 'sas_shop_currency' ) );
		$taxesIncluded = Sas_Shop_Option::get_option( 'sas_shop_prices_with_tax' );

		if($taxesIncluded == 'sas-shop-prices-with-tax'){

			$taxIncludedSufix =  Sas_Shop_Option::get_option( 'sas_shop_tax_sufix_included' );

			$productTax = get_post_meta( get_the_ID(), 'field-sas-product-taxes', true );

			$tax_amount     = round( ( $price * ( $productTax / 100 ) ) , 2 );

			// @TODO: TAX DECIMALS
			$price = $price + $tax_amount;
			$price = Sas_Shop_Core_Helpers::sas_shop_format_decimal($price, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) ) . ' ' . $currencySymbol . ' <small>' . $taxIncludedSufix . '</small>';

		}else{

			$taxExcludedSufix =  Sas_Shop_Option::get_option( 'sas_shop_tax_sufix_excluded' );
			$price = $price . ' ' . $currencySymbol . ' <small>' . $taxExcludedSufix . '</small>';
		}
		?>
		<span><?php echo $price; ?></span>
		<div class="clear"></div>

		<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
		?>
		<?php do_action( 'sas_shop_add_to_cart_single_btn_display' ); ?>
		<div class="clear"></div>
		<hr>
		<?php if( get_post_meta( get_the_ID(), 'field-product-display-sku', true ) == 1 ): ?>
			<span><?php echo 'Product SKU: ' . get_post_meta(get_the_ID(), 'field-product-sku', true); ?></span>
			<br />
		<?php endif; ?>
		<?php if( get_post_meta(get_the_ID(), 'field-product-display-current-stock', true ) == 1 ):?>
			<span><?php echo 'Current Stock: ' . get_post_meta(get_the_ID(), 'field-product-current-stock', true); ?></span>
		<?php endif; ?>
	</div>
	<div class="sas-shop-col-12 sas-shop-col-m-12">

		<div class="sas-product-tabs">

		  <input class="sas-shop-product-tabs" id="tab1" type="radio" name="sas-product-tab" checked>
		  <label for="tab1" class="sas-label-product-tab"><?php _e('Product Description', 'sas-shop' ); ?></label>

		  <input class="sas-shop-product-tabs" id="tab2" type="radio" name="sas-product-tab">
		  <label for="tab2" class="sas-label-product-tab"><?php _e('Product Comments', 'sas-shop' ); ?></label>

		  <!--input class="sas-shop-product-tabs" id="tab3" type="radio" name="sas-product-tab">
		  <label for="tab3" class="sas-label-product-tab">Mumbai</label>

		  <input class="sas-shop-product-tabs" id="tab4" type="radio" name="sas-product-tab">
		  <label for="tab4" class="sas-label-product-tab">Tokyo</label-->

		  <div class="sas-product-tab-content">
			  <div id="content1">

				<?php if(get_the_content() != ''){ ?>
					<p><?php echo get_the_content(); ?></p>
				<?php } ?>
			  </div>

			  <div id="content2">
				<p><?php comments_template( '', true ); ?></p>
			  </div>

			  <!--div id="content3">
				<p></p>
			  </div>

			  <div id="content4">
				<p></p>
			  </div-->
		  </div>

		</div>
	</div>
</div>
<?php endwhile; ?>