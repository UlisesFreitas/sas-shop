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

	<?php if( is_user_logged_in() ): ?>

<?php
		$url_args = wp_parse_args( $_SERVER['REQUEST_URI'] );
		$order_id = isset($url_args['order']) ? $url_args['order'] : NULL;

		if( 'GET' == $_SERVER['REQUEST_METHOD'] && $order_id != NULL ){

			$order_meta = get_post_meta($order_id);
			$currencySymbol = Sas_Shop_Settings_Definition::get_sas_shop_currency_symbol( Sas_Shop_Option::get_option( 'sas_shop_currency' ) );

			$subtotal 	= Sas_Shop_Core_Helpers::sas_shop_format_decimal($order_meta['field-order-cart-subtotal'][0], Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) );
			$shipping   = Sas_Shop_Core_Helpers::sas_shop_format_decimal($order_meta['field-order-shipping-total-price'][0], Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) );
			$vat		= Sas_Shop_Core_Helpers::sas_shop_format_decimal($order_meta['field-order-cart-taxes'][0], Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) );
			$total		= Sas_Shop_Core_Helpers::sas_shop_format_decimal($order_meta['field-order-cart-total'][0], Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) );

			$post = get_post( $order_id );

			echo '<h1>' . $post->post_title . '</h1>';

			echo '<p class="sas-shop-col-4">Created: <br /><strong>' .$order_meta['field-order-date-creation'][0] . '</strong> ' .  __('at','sas-shop') . ' <strong>' . $order_meta['field-order-time-creation'][0] . '</strong></p>';
			echo '<p class="sas-shop-col-4">Order status: <br /><strong>' . Sas_Shop_Core_Helpers::sas_shop_order_status_names($order_meta['field-order-status'][0]) . '</strong></p>';
			echo '<p class="sas-shop-col-4">Shipping: <br /><strong>' . Sas_Shop_Core_Helpers::sas_shop_shipping_names($order_meta['field-order-shipping'][0]) . '</strong></p>';

			echo '<div class="sas-shop-tab-wrap"><table class="sas-shop-tab">';
			echo '<tr>';
			echo '<th class="sas-shop-tab">Product</th>';
			echo '<th class="sas-shop-tab">Total</th>';
			echo '</tr>';

			$order_products = json_decode($order_meta['field-order-cart-products'][0]);
			$order_products = json_decode(json_encode($order_products), true );

			foreach( $order_products as $product ){

				$product_price = $product['product_price'] * $product['product_qty'];
				$product_price = Sas_Shop_Core_Helpers::sas_shop_format_decimal( $product_price , Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) );

				echo '  <tr>';
				echo '<td class="sas-shop-tab">' . $product['product_name'] . ' x ' . $product['product_qty'] . '</td>';
				echo '<td class="sas-shop-tab">'. $product_price . ' ' . $currencySymbol . '</td>';
				echo '</tr>';
  			}


  			echo '<tr>';
  			echo '<td class="sas-shop-tab">Subtotal</td>';
  			echo '<td class="sas-shop-tab">' . $subtotal . ' ' . $currencySymbol . '</td>';
  			echo '</tr>';
  			echo '<tr>';
  			echo '<td class="sas-shop-tab">Shipping</td>';
  			echo '<td class="sas-shop-tab">' . $shipping . ' ' . $currencySymbol . '</td>';
  			echo '</tr>';
  			echo '<tr>';
  			echo '<td class="sas-shop-tab">VAT</td>';
  			echo '<td class="sas-shop-tab">' . $vat . ' ' . $currencySymbol . '</td>';
  			echo '</tr>';
  			echo '<tr>';
  			echo '<td class="sas-shop-tab">Total</td>';
  			echo '<td class="sas-shop-tab">' . $total . ' ' . $currencySymbol . '</td>';
  			echo '</tr>';

  			echo '</table></div>';

		echo '<h2>' .  __( 'Details', 'sas-shop' ) . '</h2>' ;

			echo '<p>'. $order_meta['field-order-customer-name'][0] . ' ' . $order_meta['field-order-customer-lastname'][0] . '</p>';

			echo '<p>'. $order_meta['field-order-customer-email'][0] . ' - ' . $order_meta['field-order-customer-phone'][0] . '</p>';



			echo '<address>'. $order_meta['field-order-customer-address'][0] . '<br />';
			echo  $order_meta['field-order-customer-country'][0] . '<br />';
			echo  $order_meta['field-order-customer-city'][0] . '<br />';
			echo  $order_meta['field-order-customer-zip-code'][0] . '</address>';


			echo '<p>'. $order_meta['field-order-customer-info'][0] . '</p>';






		}else{

			do_action( 'sas_shop_wrapper_myaccount_orders' );
			do_action( 'sas_shop_wrapper_myaccount_form' );
		}
?>

		<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
		?>
		<?php // do_action( 'sas_shop_wrapper_myaccount_orders' ); ?>
		<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
		?>
		<?php // do_action( 'sas_shop_wrapper_myaccount_form' ); ?>


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

	<?php
		/*
		 * @since 1.0.0
		 * Defined in public/class-sas-shop-public.php
	 	 */
	?>
	<?php  do_action( 'sas_shop_wrapper_end' ); ?>
<?php   get_sidebar(); ?>
<?php  get_footer( 'Shop' ); ?>