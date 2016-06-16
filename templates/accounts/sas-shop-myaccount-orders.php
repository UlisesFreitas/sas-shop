<div class="sas-shop-col-12 sas-shop-col-m-12">
<h2><?php echo __('My Orders', 'sas-shop'); ?></h2>
<?php
	$current_user = wp_get_current_user();
	$current_user->ID;
	if( $current_user->ID != 0 ):
?>
<div class="sas-shop-tab-wrap"><table class="sas-shop-tab">
  <tr>
    <th class="sas-shop-tab">Order</th>
    <th class="sas-shop-tab">Date</th>
    <th class="sas-shop-tab">Status</th>
    <th class="sas-shop-tab">Total</th>
    <th class="sas-shop-tab"></th>
  </tr>
<?php
			$currencySymbol = Sas_Shop_Settings_Definition::get_sas_shop_currency_symbol( Sas_Shop_Option::get_option( 'sas_shop_currency' ) );
			$myAccountPage = get_the_permalink( get_option( 'sas_shop_sas-shop-myaccount_page_id' ) );


			$args = array(
						'post_type' => 'sas_shop_orders',
						'meta_query' => array(
					array(
						'key' => 'field-order-customer-id',
						'value' => array($current_user->ID)
					)
				)
			);

			$query = new WP_Query( $args );


			// The Loop
			if ( $query->have_posts() ) {

				while ( $query->have_posts() ): $query->the_post();

					$title  = get_the_title();
					$date 	= get_post_meta(get_the_ID(), 'field-order-date-creation' , true );
					$status = Sas_Shop_Core_Helpers::sas_shop_order_status_names( get_post_meta(get_the_ID(), 'field-order-status', true ) );
					$total 	= get_post_meta(get_the_ID(), 'field-order-cart-total', true );
					$total  = Sas_Shop_Core_Helpers::sas_shop_format_decimal($total, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) );

					$returnArgs = array('order' => get_the_ID() );
					$viewUrl = add_query_arg( $returnArgs , $myAccountPage );


					echo '<tr><td class="sas-shop-tab">' . $title . '</td>';
					echo '<td class="sas-shop-tab">' . $date . '</td>';
					echo '<td class="sas-shop-tab">' . $status . '</td>';
					echo '<td class="sas-shop-tab">' . $total . ' ' . $currencySymbol .'</td>';
					echo '<td class="sas-shop-tab"><a href="' . $viewUrl . '" class="sas-shop-btn">' . __('View order','sas-shop') . '</a></td></tr>';
				endwhile;

			} else {
				// no posts found
			}
			/* Restore original Post Data */
			wp_reset_postdata();



?>

</table></div>
<?php else:?>
<?php echo __('No orders yet!', 'sas-shop'); ?>
<?php endif; ?>
</div>