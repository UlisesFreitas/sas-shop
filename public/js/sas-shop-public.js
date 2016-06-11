(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */


	$.fn.extend({

			sas_shop_update_cart_checkout: function () {

			var result;
			$('#loading-cart-totals').show(100);
			$('#cart-totals-display').fadeTo('fast', 0.5);

			result = $.post(sas_shop_ajax.ajaxurl, {

					action:	'sas_shop_update_cart_data',
					data:	$("#sas-shop-cart").serialize()

				}, function (response) {

					console.log(response);
					if( response) {
						if($('.taxes').length > 0){
							$('.taxes').html(response.taxes_total.toFixed(2));
						}

						$('#total').html(response.grand_total.toFixed(2));
						$('#loading-cart-totals').hide();
						$('#cart-totals-display').show();
						$('#cart-totals-display').fadeTo('slow', 1);

					} else {

						alert("There was an error. Please try again.");

					}

				});
			return result;
		    }


	});

	$(function () {

			/*
			 *	This is onload page callfunc
			 *  if any shipping method was previously selected we get that value and do ajax to
			 *  replace VAT / TOTAL on cart
			 */
			if( $('#cart-totals-display').length ){

				var free_shipping_checked = $('#free_shipping').prop('checked');
				var flat_shipping_checked = $('#flat_shipping').prop('checked');
				if(!free_shipping_checked && !flat_shipping_checked ){

					$('#free_shipping').prop('checked', true);
					//.sas_shop_update_cart_checkout();
					//$('input[name="sas_shop_shipping_method[]"]').sas_shop_update_cart_checkout();
				}

				// This is on change shipping methods callfunc
				$('input[name="sas_shop_shipping_method[]"]').change(function (evt) {
		 		$.fn.sas_shop_update_cart_checkout();
				}).change();
			}


			$('#create_account_check').change(function (evt){
				evt.preventDefault();
				if( $('#create_account_check').is(':checked') ){
						$('#create_account_password').show('slow');
				}else{
					$('#create_account_password').hide('slow');
				}
			}).change();


			/*
			 * Checkout
			 *
			 */

			 $('input[name="sas_shop_payment_method[]"]').change(function (evt){

			 	if($('#sas_shop_bank_transfer_selected').is(':checked')){
				 	$('#sas_shop_bank_transfer_selected_info').show('slow');
			 	}else{
				 	$('#sas_shop_bank_transfer_selected_info').hide('slow');
			 	}

			 	if($('#sas_shop_cod_selected').is(':checked')){
				 	$('#sas_shop_cod_selected_info').show('slow');
			 	}else{
				 	$('#sas_shop_cod_selected_info').hide('slow');
			 	}

			 }).change();

	});


})( jQuery );
