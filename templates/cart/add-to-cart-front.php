<?php
$html = '';
$current_stock = get_post_meta(get_the_ID(), 'field-product-current-stock', true);

if($current_stock > 0){

	$html .= '<form method="post" action="' . esc_url( admin_url('admin-post.php') ) .'">';
	$html .= '<input type="hidden" name="action" value="add_to_cart" />';
	$html .= '<input type="hidden" size="2" min="1" max="1" name="product_qty" value="1" />';
	$html .= '<input type="hidden" name="product_id" value="' . get_the_ID() . '" />';
	$html .= '<input type="hidden" name="type" value="add" />';
	$html .= '<input type="hidden" name="return_url" value="' . esc_url( get_permalink( get_the_ID() ) ) . '" />';
	$html .= '<button type="submit" class="sas-shop-add-to-cart">Add to Cart</button>';
	$html .= '</form>';

}else{
	$html .= '<p class="sas-shop-out-of-stock">' . __('Out of stock', SAS_SHOP_NAME ) . '</p>';
}
echo $html;
?>