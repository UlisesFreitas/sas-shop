<?php // print_r($_SESSION); ?>
<?php
if( isset( $_SESSION["cart_products"] ) && count($_SESSION["cart_products"]) > 0 ){
	print_r($_SESSION);
?>
<div class="cart-view-table-back">

	<form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
	<input type="hidden" name="action" value="update_cart" />
	<input type="hidden" name="type" value="add" />

		<table width="100%"  cellpadding="6" cellspacing="0">
			<thead>
				<tr>
					<th>Remove</th>
					<th>Link</th>
					<th>Product</th>
					<th>Quantity</th>
					<th>Unit Price</th>
					<!--th>Unit Tax</th-->
					<th>Total</th>

				</tr>
			</thead>
	  		<tbody>
<?php
			$total = 0; //set initial total value
			$b = 0; //var for zebra stripe table
			$html = '';
			$taxes = array();
			$totalCartQty = 0;

			$shipping_cost = array();
			$priceLabel = '';

			$taxes_enabled = Sas_Shop_Option::get_option( 'sas_shop_enable_taxes' );
			$shipping_enabled = Sas_Shop_Option::get_option( 'sas_shop_enable_shipping' );
			$sas_shop_price_num_decimals = Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' );
			$currencySymbol = Sas_Shop_Settings_Definition::get_sas_shop_currency_symbol( Sas_Shop_Option::get_option( 'sas_shop_currency' ) );

			foreach ($_SESSION["cart_products"] as $cart_itm)
	        {


				//set variables to use in content below
				$product_id = $cart_itm["product_id"];

				$product = get_post(  $product_id );

				$product_name = $cart_itm["product_name"];
				$product_qty = $cart_itm["product_qty"];
				$product_price = $cart_itm["product_price"];

				$totalCartQty += $product_qty;

				$maxStockAllowed = get_post_meta( $product_id , 'field-product-max-stock', true );
				$maxStockAllowed = isset($maxStockAllowed) ? $maxStockAllowed : 100;



				$price = Sas_Shop_Core_Helpers::sas_shop_format_decimal(
																		get_post_meta($product_id, 'field-product-price', true),
																		Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' )
																		);

				$priceLabel = $price;



				if($taxes_enabled == 1){

					$taxesIncluded = Sas_Shop_Option::get_option( 'sas_shop_prices_with_tax' );

					if($taxesIncluded == 'sas-shop-prices-with-tax'){

						$taxIncludedSufix =  Sas_Shop_Option::get_option( 'sas_shop_tax_sufix_included' );

						$productTax = get_post_meta( $product_id, 'field-sas-product-taxes', true );

						$tax_amount     = round( ( $price * ( $productTax / 100 ) ) , 2 );

						$taxes[] = $tax_amount * $product_qty;

						$price = $price + $tax_amount;
						$priceLabel = Sas_Shop_Core_Helpers::sas_shop_format_decimal($price, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) );

					}else{

						$productTax = get_post_meta( $product_id, 'field-sas-product-taxes', true );

						$tax_amount     = round( ( $price * ( $productTax / 100 ) ) , 2 );

						$taxes[] = $tax_amount * $product_qty;

						$taxExcludedSufix =  Sas_Shop_Option::get_option( 'sas_shop_tax_sufix_excluded' );
						$priceLabel = Sas_Shop_Core_Helpers::sas_shop_format_decimal($price, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) );;
					}
				}

				$subtotal = ($price * $product_qty); //calculate Price x Qty

				$subtotal = Sas_Shop_Core_Helpers::sas_shop_format_decimal( $subtotal, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) );

			   	$bg_color = ($b++%2==1) ? 'odd' : 'even'; //class for zebra stripe

			    $html .= '<tr class="'.$bg_color.'">';
			    $html .=  '<td class="sas-shop-to-center"><input type="checkbox" name="remove_code[]" value="' . $product_id . '" class="sas-shop-checkbox" /></td>';

			    $html .=  '<td class="sas-shop-to-center">';
			    $html .=  '<a href="' . get_the_permalink($product_id) . '">' . get_the_post_thumbnail( $product_id, 'thumbnail' ,'style=max-width:32px;height:auto;') . '</a>';
			    $html .=  '</td>';

				$html .=  '<td><a href="' . get_the_permalink($product_id) . '">' . $product->post_title . '</a></td>';

				$html .=  '<td>';
				$html .=  '<input type="number" size="1" min="1" max="' . $maxStockAllowed . '" name="product_qty['.$product_id.']" value="'.$product_qty.'" />';
				$html .=  '<input type="hidden" name="product_id[]" value="' . $product_id . '" />';
				$html .=  '</td>';

				$html .=  '<td>' . $priceLabel  . $currencySymbol . '</td>';
				$html .=  '<td>' . $subtotal . ' '. $currencySymbol . '</td>';

	            $html .=  '</tr>';
				$total = ($total + $subtotal); //add subtotal to total var



	        }

	        $_SESSION['total_cart_qty'] = $totalCartQty;

			$grand_total = $total; //grand total

			/*
			 * Here we need to know how proces are set on Sas Shop if with/without taxes to add the correct amount to $grand_total
			 *
			 *
			 */
			if($taxes_enabled == 1){

				if($taxesIncluded != 'sas-shop-prices-with-tax'){
					foreach($taxes as $key => $value){ //list and calculate all taxes in array
						$tax_item[$key] = $value;
						$grand_total    = $grand_total + $value;  //add tax val to grand total
					}
				}
			}

			echo $html;


	    ?>

		<input type="hidden" name="return_url" value="<?php $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); echo $current_url; ?>" />

		<tr>
		    <td colspan="6">

				<button class="sas-shop-to-right" type="submit"><?php echo __('Update Cart',SAS_SHOP_NAME); ?></button>

	    	</td>
	    </tr>

	  </tbody>
	  	</table>
	  	</form>

	  	<?php
	  		/*
			 * Here calculate shipping
			 *
			 */
			$shipping_enabled = Sas_Shop_Option::get_option( 'sas_shop_enable_shipping' );
			if($shipping_enabled == 1){

				$shipping = '';
				$shipping_methods = array();

				$shipping .= '<form id="sas-shop-cart" method="post">';
				$shipping .= '<table id="cart-totals-container">';
				$shipping .= '<thead>';
			  	$shipping .= '<th>' . __('Shipping Method',SAS_SHOP_NAME) . '</th>';
			  	$shipping .= '<th>' . __('Price',SAS_SHOP_NAME) . '</th>';
			  	$shipping .= '<th>' . __('Select One',SAS_SHOP_NAME) . '</th>';
			  	$shipping .= '</thead>';
			  	$shipping .= '<tbody>';


				$shipping_checked = isset( $_SESSION[ 'shipping_checked']) ? $_SESSION['shipping_checked'] : '';
				$shipping_taxes = floatval('0.00');

				$shipping_free_enabled = Sas_Shop_Option::get_option( 'shipping_free_enabled' );
				if($shipping_free_enabled == 1){

					$shipping_free_name = Sas_Shop_Option::get_option( 'shipping_free_name' );
					$free_shipping = $shipping_free_name;
					$shipping_methods['shipping_free_name'] = $free_shipping;
					$shipping_cost[] = '0.00';
					if( $shipping_checked == 'free_shipping'  ){
						$shipping_taxes = floatval('0.00');
					}
					$shipping .= '<tr>';
				  	$shipping .= '<td>' . $shipping_free_name . '</td>';
				  	$shipping .= '<td> - </td>';
				  	$shipping .= '<td class="sas-shop-to-center"><input ';
				  		if( $shipping_checked == 'free_shipping'  ){ $shipping .= ' checked="checked" ';}
				  	$shipping .= 'type="radio" name="sas_shop_shipping_method[]" class="sas_shop_shipping_method" value="shipping_free_name"  id="free_shipping"></td>';
				  	$shipping .= '</tr>';

				}

				$shipping_flat_enabled = Sas_Shop_Option::get_option( 'shipping_flat_enabled' );
				if($shipping_flat_enabled == 1){
					$shipping_flat_name = Sas_Shop_Option::get_option( 'shipping_flat_name' );
					$flat_shipping_price = Sas_Shop_Option::get_option( 'shipping_flat_price' );
					$flat_shipping = $shipping_flat_name . ' - '. $flat_shipping_price . $currencySymbol;

					$shipping_cost[] = $flat_shipping_price;

					if( $shipping_checked == 'flat_shipping'  ){
						$shipping_tax   = Sas_Shop_Option::get_option( 'shipping_flat_tax' );
						$shipping_taxes = round( ( $flat_shipping_price * ( floatval($shipping_tax) / 100 ) ) , 2 );
					}
					$shipping_methods['shipping_flat_name'] = $flat_shipping;

					$shipping .= '<tr>';
				  	$shipping .= '<td>' . $shipping_flat_name . '</td>';
				  	$shipping .= '<td>' . $flat_shipping_price . ' ' . $currencySymbol . ' x ' . $totalCartQty . '</td>';
				  	$shipping .= '<td class="sas-shop-to-center"><input ';
				  		if( $shipping_checked == 'flat_shipping'  ){ $shipping .= ' checked="checked" ';}
				  	$shipping .= 'type="radio" name="sas_shop_shipping_method[]" class="sas_shop_shipping_method" value="shipping_flat_name" id="flat_shipping"></td>';
				  	$shipping .= '</tr>';
				}

				$shipping .='</tbody>';
				$shipping .='</table>';
				echo $shipping;


			}
			?>

			<div id="loading-cart-totals" class="sas-shop-to-center" style="display:none;"><img src="<?php echo plugin_dir_url('sas-shop/public/') . 'public/images/ajax-loader.gif'; ?>" alt="Loading" /></div>
			<table <?php if($shipping_enabled == 1){ echo 'id="cart-totals-display" style="display:none;"';}; ?>>
				<thead></thead>
				<tbody>
					<tr>

						<td colspan="2"><span class="sas-shop-to-right"><?php echo __('Sub Total',SAS_SHOP_NAME); ?></span></td>
						<td>
							<?php
								$realsubtotal = '';
								foreach($_SESSION["cart_products"] as $cart_itm){
									$realsubtotal = $realsubtotal + $cart_itm['product_price'] * $cart_itm['product_qty'];
								}
							?>
							<span class="sas-shop-to-right">
							<?php echo Sas_Shop_Core_Helpers::sas_shop_format_decimal( $realsubtotal, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) ) . ' ' . $currencySymbol; ?>
							</span>
						</td>
					</tr>
					<?php if($taxes_enabled == 1){ ?>
					<tr id="tax_rates_calulated">

						<td colspan="2"><span class="sas-shop-to-right"><?php echo __('VAT',SAS_SHOP_NAME); ?></span></td>
						<td>
							<span class="sas-shop-to-right">
							<?php
								$taxSum = '';
								foreach($taxes as $taxK => $tax){
									$taxSum = $taxSum + $tax;
								}
								//$taxSum = $taxSum + $shipping_taxes;
							?>
							<span class="taxes"><?php echo Sas_Shop_Core_Helpers::sas_shop_format_decimal( $taxSum, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) ); ?></span>
							<span class="currency"><?php echo $currencySymbol; ?></span>
							</span>
						</td>
					</tr>
					<?php }else{ ?>
						<?php if($shipping_enabled == 1){ ?>
						<tr id="tax_rates_calulated">
							<td colspan="2"><span class="sas-shop-to-right"><?php echo __('VAT',SAS_SHOP_NAME); ?></span></td>
							<td>
								<span class="sas-shop-to-right">
								<span class="taxes"></span>
								<span class="currency"><?php echo $currencySymbol; ?></span>
								</span>
							</td>
						</tr>
						<?php }?>
					<?php }?>
					<tr>

						<td colspan="2"><span class="sas-shop-to-right"><?php echo __('Total',SAS_SHOP_NAME); ?></span></td>
						<td>
							<span class="sas-shop-to-right">
							<span id="total"><?php echo Sas_Shop_Core_Helpers::sas_shop_format_decimal( $grand_total, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) ); ?></span>
							<span class="currency"><?php echo  $currencySymbol; ?></span>
							</span>
						</td>
					</tr>

					<tr>
						<td colspan="3">
							<a class="sas-shop-btn sas-shop-to-left" href="<?php echo get_permalink( get_option( 'sas_shop_sas-shop-front_page_id' ) ); ?>"><?php echo __('Continue Shopping',SAS_SHOP_NAME); ?></a>
							<a class="sas-shop-btn sas-shop-to-right" href="<?php echo get_permalink( get_option( 'sas_shop_sas-shop-checkout_page_id' ) ); ?>"><?php echo __('Checkout',SAS_SHOP_NAME); ?></a>
						</td>
					</tr>

				</tbody>
			</table>

			<input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>" />
			<?php if(isset($taxSum)){ ?>
			<input class="taxes" type="hidden" name="taxes_total" value="<?php echo $taxSum; ?>" />
			<?php } ?>
	</form>
</div>
<?php

	if(isset($taxSum)){
	$_SESSION['cart_taxes'] = $taxSum;
	}
	$_SESSION['cart_subtotal'] = $realsubtotal;
	$_SESSION['cart_total'] = $grand_total;



}else{

	unset($_SESSION['cart_products']);
	unset($_SESSION['cart_subtotal']);
	unset($_SESSION['cart_total']);
	unset($_SESSION['total_cart_qty']);
	unset($_SESSION['cart_taxes']);
	unset($_SESSION['shipping_checked']);

	$html = '';
	$html .= '<div class="cart-view-table-front" id="view-cart">';
	$html .= '<h3>' . __( 'Shopping Cart', 'sas-shop' ) . '</h3>';
	$html .= '<p>' . __( 'Your cart is empty', 'sas-shop' ) . ' <a href="' . get_permalink( get_option( 'sas_shop_sas-shop-front_page_id' ) ) . '">Continue shopping</a></p>';
	$html .= '</div>';

	echo $html;
}