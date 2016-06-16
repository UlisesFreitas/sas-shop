<?php
global $attributes;

if( isset( $attributes['sas_shop_this_is_not_your_order'] ) ){
	echo $attributes['sas_shop_this_is_not_your_order'];
	$sessionHandler = Sas_Shop_Session_Handler::getInstance();
	$sessionHandler->sas_shop_session_unset();

}else{

$currencySymbol = Sas_Shop_Settings_Definition::get_sas_shop_currency_symbol( Sas_Shop_Option::get_option( 'sas_shop_currency' ) );

$order_products_obj = json_decode($attributes['sas_shop_order_meta']['field-order-cart-products'][0]);
$order_products = json_decode(json_encode($order_products_obj),true);
//print_r($order_products);

//echo '</pre>';
?>
<div class="row">
	<div class="sas-shop-col-12">
	<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;border:none;margin:0px auto;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
@media screen and (max-width: 767px) {.tg {width: auto !important;}.tg col {width: auto !important;}.tg-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;margin: auto 0px;}}</style>
<div class="tg-wrap"><table class="tg">
  <tr>
    <th class="tg-031e">ORDER NUMBER</th>
    <th class="tg-031e">DATE</th>
    <th class="tg-031e">TOTAL</th>
    <th class="tg-031e">PAYMENT METHOD</th>
  </tr>
  <tr>
    <td class="tg-031e"><?php echo '# ' . $attributes['sas_shop_order_id']; ?></td>
    <td class="tg-031e"><?php echo $attributes['sas_shop_order_meta']['field-order-date-creation'][0] . ' - ' . $attributes['sas_shop_order_meta']['field-order-time-creation'][0]; ?></td>
    <td class="tg-031e"><?php echo $attributes['sas_shop_order_meta']['field-order-cart-total'][0] . ' ' . $currencySymbol; ?></td>
	<td class="tg-031e">
    <?php

	    /**
		    "sas_shop_bank_method_name";s:13:"Bank transfer";
		    s:25:"sas_shop_bank_description";s:102:"Make your payment directly into our bank account. Please use the reference order as payment reference.";
		    s:18:"sas_shop_bank_name";s:17:"My Bank name Inc.";
		    s:21:"sas_shop_bank_account";
		    s:24:"ES1020903200500041045040";s:21:


		    "sas_shop_cod_payments";
		    s:1:"1";s:24:"sas_shop_cod_method_name";
		    s:16:"Cash on delivery";
		    s:24:"sas_shop_cod_description";
		    s:37:"Make your payment on product delivery"
		*/
		if($attributes['sas_shop_order_meta']['field-order-payment-method'][0] == 'bank_transfer' ){
			echo Sas_Shop_Option::get_option( 'sas_shop_bank_method_name' );
		}
		if($attributes['sas_shop_order_meta']['field-order-payment-method'][0] == 'cash_on_delivery' ){
			echo Sas_Shop_Option::get_option( 'sas_shop_cod_method_name' );
		}
    ?>
   </td>
  </tr>
  <tr>
	  <td colspan="4">
		  <?php

	    /**
		    "sas_shop_bank_method_name";s:13:"Bank transfer";
		    s:25:"sas_shop_bank_description";s:102:"Make your payment directly into our bank account. Please use the reference order as payment reference.";
		    s:18:"sas_shop_bank_name";s:17:"My Bank name Inc.";
		    s:21:"sas_shop_bank_account";
		    s:24:"ES1020903200500041045040";s:21:
		*/
		if($attributes['sas_shop_order_meta']['field-order-payment-method'][0] == 'bank_transfer' ){
			echo Sas_Shop_Option::get_option( 'sas_shop_bank_description' );
			echo '<br />';
			echo Sas_Shop_Option::get_option( 'sas_shop_bank_name' ) . ' - ' . Sas_Shop_Option::get_option( 'sas_shop_bank_account' );
		}

		if($attributes['sas_shop_order_meta']['field-order-payment-method'][0] == 'cash_on_delivery' ){
			echo Sas_Shop_Option::get_option( 'sas_shop_cod_description' );
		}
    ?>
	  </td>
  </tr>
</table></div>
	</div>

	<div class="sas-shop-col-12">


		<div class="tg-wrap"><table class="tg">
		  <tr>
		    <th class="sas-shop-table-1"><h3><?php echo __('Product', SAS_SHOP_NAME); ?></h3></th>
		    <th class="sas-shop-table-1"><h3><?php echo __('Total', SAS_SHOP_NAME); ?></h3></th>
		  </tr>

		    <?php foreach($order_products as $product){ ?>
		    <tr>
		    <td class="sas-shop-table-1">
			    <?php echo $product['product_name']. ' x ' . $product['product_qty'];  ?></td>

		    <td class="sas-shop-table-1">
			    <?php

				    $qty = $product['product_qty'];
				    $price = $product['product_price'];

				    echo Sas_Shop_Core_Helpers::sas_shop_format_decimal(
			    									$price  * $qty,
			    									Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) ) . ' ' . $currencySymbol ;
			    ?>
			</td>
		    </tr>

		    <?php
			    //$subtotal = $subtotal + $qty * $price;
			    }
			?>


		  <tr>
			  <?php

			  ?>
		    <td class="sas-shop-table-1"><h3><?php echo __('Subtotal', SAS_SHOP_NAME); ?></h3></td>

		    <td class="sas-shop-table-1">
			    <?php
				    $subtotal = $attributes['sas_shop_order_meta']['field-order-cart-subtotal'][0];
				    echo Sas_Shop_Core_Helpers::sas_shop_format_decimal( $subtotal, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) ); ?>
				    <span class="currency"><?php echo $currencySymbol; ?></span></td>
		  </tr>


		  <tr>

		    <td class="sas-shop-table-2"><h3><?php echo __('Shipping', SAS_SHOP_NAME); ?></h3></td>
		    <td class="sas-shop-table-2">
			    <?php

				  if($attributes['sas_shop_order_meta']['field-order-shipping'][0] == 'free_shipping'){
					  echo Sas_Shop_Option::get_option( 'shipping_free_name' );
				  }
				  if($attributes['sas_shop_order_meta']['field-order-shipping'][0] == 'flat_shipping'){
					  echo Sas_Shop_Option::get_option( 'shipping_flat_name' );
				  }
			  	?>
		    </td>
		  </tr>


		  <tr>
		    <td class="sas-shop-table-2"><h3><?php echo __('VAT', SAS_SHOP_NAME); ?></h3></td>
		    <td class="sas-shop-table-2">
			    <?php echo Sas_Shop_Core_Helpers::sas_shop_format_decimal($attributes['sas_shop_order_meta']['field-order-cart-taxes'][0], Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) ); ?> <span class="currency"><?php echo $currencySymbol; ?></span></td>
		  </tr>

		  <tr>
		    <td class="sas-shop-table-2"><h3><?php echo __('Total', SAS_SHOP_NAME); ?></h3></td>
		    <td class="sas-shop-table-2">
			    <?php
				    echo Sas_Shop_Core_Helpers::sas_shop_format_decimal($attributes['sas_shop_order_meta']['field-order-cart-total'][0], Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) ); ?>

				    <span class="currency"><?php echo $currencySymbol; ?></span>
			</td>
		  </tr>
		</table>

	</div>
</div>
<?php
$sessionHandler = Sas_Shop_Session_Handler::getInstance();
$sessionHandler->sas_shop_session_unset();
}
?>