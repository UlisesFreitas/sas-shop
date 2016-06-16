<?php

	global $attributes;

	$sessionHandler = Sas_Shop_Session_Handler::getInstance();
	$cart_data = $sessionHandler->sas_shop_get_data();
	$cart_id = $sessionHandler->get_cart_id();

	$currencySymbol = Sas_Shop_Settings_Definition::get_sas_shop_currency_symbol( Sas_Shop_Option::get_option( 'sas_shop_currency' ) );
	$taxes_enabled = Sas_Shop_Option::get_option( 'sas_shop_enable_taxes' );
	$shipping_enabled = Sas_Shop_Option::get_option( 'sas_shop_enable_shipping' );


	$cart_products 		= isset($cart_data[$cart_id]['cart_products']) ? $cart_data[$cart_id]['cart_products'] : array();
	$subtotal 			= isset($cart_data[$cart_id]['cart_subtotal']) ? $cart_data[$cart_id]['cart_subtotal'] : 0;
	$cart_taxes 		= isset($cart_data[$cart_id]['cart_taxes']) ? $cart_data[$cart_id]['cart_taxes'] : 0;
	$shipping_checked 	= isset($cart_data[$cart_id]['shipping_checked']) ? $cart_data[$cart_id]['shipping_checked'] : 0;
	$total_cart_qty 	= isset($cart_data[$cart_id]['total_cart_qty']) ? $cart_data[$cart_id]['total_cart_qty'] : 0;
	$cart_total 		= isset($cart_data[$cart_id]['cart_total']) ? $cart_data[$cart_id]['cart_total'] : 0;

	$id               	= isset($attributes['userdata']->ID) ? $attributes['userdata']->ID : '';
	$email            	= isset($attributes['userdata']->user_email) ? $attributes['userdata']->user_email : '';
	$first_name       	= isset($attributes['usermeta']['first_name']) ? $attributes['usermeta']['first_name'] : '';
	$last_name        	= isset($attributes['usermeta']['last_name']) ? $attributes['usermeta']['last_name'] : '';
	$sas_shop_phone   	= isset($attributes['usermeta']['sas_shop_phone'] ) ? $attributes['usermeta']['sas_shop_phone'] : '';
	$sas_shop_address 	= isset($attributes['usermeta']['sas_shop_address']) ? $attributes['usermeta']['sas_shop_address'] : '';
	$sas_shop_country 	= isset($attributes['usermeta']['sas_shop_country']) ? $attributes['usermeta']['sas_shop_country'] : '';
	$sas_shop_city    	= isset($attributes['usermeta']['sas_shop_city']) ? $attributes['usermeta']['sas_shop_city'] : '';
	$sas_shop_zipcode 	= isset($attributes['usermeta']['sas_shop_zipcode']) ? $attributes['usermeta']['sas_shop_zipcode'] : '';

	$errors           	= isset($attributes['errors']) ? $attributes['errors'] : array();

	if( count( $cart_products ) > 0 ):
?>
<div id="checkout-form" class="row">
<h3><?php echo __( 'Billing information', 'sas-shop'); ?></h3>

	<?php if ( count( $attributes['errors'] ) > 0 ) : ?>
		<?php foreach ( $attributes['errors'] as $error ) : ?>
			<p>
				<?php echo $error; ?>
			</p>
		<?php endforeach; ?>
	<?php endif; ?>

	<form id="place-order-form" action="<?php echo get_the_permalink( get_option( 'sas_shop_sas-shop-checkout_page_id' ) ); ?>" method="post">
		<input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>" />


		<?php if( ! is_user_logged_in() && get_option( 'users_can_register' ) == 1 ): ?>
		<div class="row">
			<div class="sas-shop-col-12">
				<h4><?php _e( 'Create an account', 'sas-shop' ); ?></h4>
				<p class="form-row">
				<input type="checkbox" name="create_account_check" id="create_account_check" placeholder="<?php echo __( 'Create account', 'sas-shop'); ?>">
				</p>
			</div>
		</div>
		<?php endif; ?>
		<div class="sas-shop-col-6">
		<p class="form-row">
			<input type="text" name="email" id="email" placeholder="<?php _e( '* Email', 'sas-shop' ); ?>" value="<?php echo $email; ?>" required>
		</p>

		<p class="form-row">
			<input type="text" name="first_name" id="firstname" placeholder="<?php _e( 'First name', 'sas-shop' ); ?>" value="<?php echo $first_name;  ?>" required>
		</p>

		<p class="form-row">
			<input type="text" name="last_name" id="lastname" placeholder="<?php _e( 'Last name', 'sas-shop' ); ?>" value="<?php echo $last_name; ?>" required>
		</p>

		<p class="form-row">
			<input type="text" name="sas_shop_phone" id="sas_shop_phone" placeholder="<?php _e( 'Phone', 'sas-shop' ); ?>"  value="<?php echo $sas_shop_phone; ?>" required>
		</p>
		</div>
		<div class="sas-shop-col-6">
		<p class="form-row">
			<input type="text" name="sas_shop_address" id="sas_shop_address" placeholder="<?php _e( 'Address', 'sas-shop' ); ?>" value="<?php echo $sas_shop_address; ?>" required>
		</p>
		<p class="form-row">
			<input type="text" name="sas_shop_country" id="sas_shop_country" placeholder="<?php _e( 'Country', 'sas-shop' ); ?>" value="<?php echo $sas_shop_country; ?>" required>
		</p>
		<p class="form-row">
			<input type="text" name="sas_shop_city" id="sas_shop_city" placeholder="<?php _e( 'City', 'sas-shop' ); ?>" value="<?php echo $sas_shop_city; ?>" required>
		</p>

		<p class="form-row">
			<input type="text" name="sas_shop_zipcode" id="sas_shop_zipcode" placeholder="<?php _e( 'Zip code', 'sas-shop' ); ?>" value="<?php echo $sas_shop_zipcode; ?>" required>
		</p>


		</div>

		<?php if( ! is_user_logged_in() ): ?>

			<div class="sas-shop-col-6" id="create_account_password" style="display:none;">
			<p class="form-row">

				<label for="user_password"><?php _e( 'Password', 'sas-shop' ); ?></label>
				<input type="password" name="user_password" id="user_password" placeholder="<?php echo __( '* Password', 'sas-shop'); ?>" required>
			</p>
			</div>
		<?php endif; ?>

		<div class="sas-shop-col-12">
			<p class="form-row">
				<label for="sas_shop_additional_info"><?php _e( 'Additional information', 'sas-shop' ); ?></label>
				<textarea rows="4" cols="50" name="sas_shop_additional_info" id="sas_shop_additional_info" placeholder="<?php _e( 'Write additional information here.', 'sas-shop' ); ?>"></textarea>
			</p>
		</div>


		<div class="tg-wrap"><table class="tg">
		  <tr>
		    <th class="sas-shop-table-1"><h3><?php echo __('Product', 'sas-shop'); ?></h3></th>
		    <th class="sas-shop-table-1"><h3><?php echo __('Total', 'sas-shop'); ?></h3></th>
		  </tr>

		    <?php foreach($cart_products as $cart_itm){ ?>
		    <tr>
		    <td class="sas-shop-table-1"><?php echo $product_name = $cart_itm["product_name"]. ' x '. $product_qty = $cart_itm["product_qty"];  ?></td>
		    <td class="sas-shop-table-1"><?php echo Sas_Shop_Core_Helpers::sas_shop_format_decimal( $product_price = $cart_itm["product_price"]*$product_qty = $cart_itm["product_qty"], Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) ) . ' ' . $currencySymbol ;?></td>
		    </tr>
		    <?php } ?>


		  <tr>
		    <td class="sas-shop-table-1"><h3><?php echo __('Subtotal', 'sas-shop'); ?></h3></td>
		    <td class="sas-shop-table-1"><?php echo Sas_Shop_Core_Helpers::sas_shop_format_decimal( $subtotal, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) ); ?> <span class="currency"><?php echo $currencySymbol; ?></span></td>
		  </tr>
		  <?php if($shipping_enabled == 1){ ?>
		  <tr>
		    <td class="sas-shop-table-2"><h3><?php echo __('Shipping', 'sas-shop'); ?></h3></td>
		    <td class="sas-shop-table-2">
			    <?php
				if($shipping_checked == 'free_shipping'){
					$shipping_name = Sas_Shop_Option::get_option( 'shipping_free_name' );
					echo $shipping = $shipping_name . ' x ' . $total_cart_qty;
				}
				if($shipping_checked == 'flat_shipping'){
					$shipping_flat_name = Sas_Shop_Option::get_option( 'shipping_flat_name' );
					$shipping_flat_price = Sas_Shop_Option::get_option( 'shipping_flat_price' );
					echo $shipping = $shipping_flat_name . ' - '. $shipping_flat_price . ' ' . $currencySymbol . ' x ' . $total_cart_qty;
				}

			    ?>
		    </td>
		  </tr>
		  <?php } ?>
		  <?php if($taxes_enabled == 1){ ?>
		  <tr>
		    <td class="sas-shop-table-2"><h3><?php echo __('VAT', 'sas-shop'); ?></h3></td>
		    <td class="sas-shop-table-2">
			    <?php echo Sas_Shop_Core_Helpers::sas_shop_format_decimal($cart_taxes, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) ); ?> <span class="currency"><?php echo $currencySymbol; ?></span></td>
		  </tr>
		  <?php } ?>
		  <tr>
		    <td class="sas-shop-table-2"><h3><?php echo __('Total', 'sas-shop'); ?></h3></td>
		    <td class="sas-shop-table-2">
			    <?php
				    echo Sas_Shop_Core_Helpers::sas_shop_format_decimal($cart_total, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) ); ?>

				    <span class="currency"><?php echo $currencySymbol; ?></span>
			</td>
		  </tr>
		</table>

		</div>

		<?php
				$bank_payments_enabled = Sas_Shop_Option::get_option('sas_shop_bank_payments');
				if($bank_payments_enabled == 1){

					$sas_shop_bank_method_name = Sas_Shop_Option::get_option('sas_shop_bank_method_name');
					$sas_shop_bank_description = Sas_Shop_Option::get_option('sas_shop_bank_description');
					$sas_shop_bank_name = Sas_Shop_Option::get_option('sas_shop_bank_name');
					$sas_shop_bank_account = Sas_Shop_Option::get_option('sas_shop_bank_account');

		?>

		<div class="sas-shop-payments" id="sas_shop_bank_transfer">
			<input type="radio" name="sas_shop_payment_method[]" value="bank_transfer" id="sas_shop_bank_transfer_selected" required>
			<label for="sas_shop_payment_method"><?php echo $sas_shop_bank_method_name; ?></label>
			<div class="sas-shop-payment-colored-block" id="sas_shop_bank_transfer_selected_info">

			<h4><?php echo $sas_shop_bank_name . ' - '. $sas_shop_bank_account; ?></h4>
			<span><?php echo  $sas_shop_bank_description ; ?></span>
			</div>
		</div>
		<?php
			}
		?>
		<?php
				$cod_payments_enabled = Sas_Shop_Option::get_option('sas_shop_cod_payments');
				if($bank_payments_enabled == 1){

					$sas_shop_cod_method_name = Sas_Shop_Option::get_option('sas_shop_cod_method_name');
					$sas_shop_cod_description = Sas_Shop_Option::get_option('sas_shop_cod_description');

		?>
		<div class="sas-shop-payments">
			<input type="radio" name="sas_shop_payment_method[]" value="cash_on_delivery" id="sas_shop_cod_selected" required>
			<label for="sas_shop_payment_method"><?php echo $sas_shop_cod_method_name; ?></label>

				<div class="sas-shop-payment-colored-block"  id="sas_shop_cod_selected_info">
					<h4><?php $sas_shop_cod_method_name; ?></h4>
					<span><?php echo  $sas_shop_cod_description ; ?></span>
				</div>

		</div>
		<?php
			}
		?>

<div class="sas-shop-col-12">
		<p class="checkout-submit sas-shop-to-right">
			<input type="submit" name="submit" class="sas-shop-btn" value="<?php echo __( 'Place order', 'sas-shop'); ?>"/>
		</p>
</div>
	</form>
</div>


<?php else: ?>
<?php
	$html = '';
	$html .= '<div class="cart-view-table-front" id="view-cart">';
	$html .= '<h3>' . __( 'Shopping Cart', 'sas-shop' ) . '</h3>';
	$html .= '<p>' . __( 'Your cart is empty', 'sas-shop' ) . ' <a href="' . get_permalink( get_option( 'sas_shop_sas-shop-front_page_id' ) ) . '">Continue shopping</a></p>';
	$html .= '</div>';

	echo $html;
?>
<?php endif; ?>