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


	$(function () {

			/*
			 * Checkout
			 *
			 */

			var sas_shop_bank_transfer_selected = $('#sas_shop_bank_transfer_selected').prop('checked');
			var sas_shop_cod_selected = $('#sas_shop_cod_selected').prop('checked');
			if(!sas_shop_bank_transfer_selected && !sas_shop_cod_selected ){

				$('#sas_shop_bank_transfer_selected').prop('checked', true);
			}

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

	$(function () {
		/*
		$.validator.setDefaults({
			submitHandler: function() {
				alert("submitted!");


			}
		});
		*/

		$("#place-order-form").validate({
			rules: {
				firstname: "required",
				lastname: "required",

				password: {
					required: true,
					minlength: 5
				},

				email: {
					required: true,
					email: true
				},
				sas_shop_phone:{
					required: true,
				},
				sas_shop_address: {
					required: true,
				},
				sas_shop_country: {
					required: true,
				},
				sas_shop_city: {
					required: true,
				},
				sas_shop_zipcode: {
					required: true,
				},
				sas_shop_bank_transfer_selected:{
					required: true,
				}

			},
			messages: {
				firstname: "Please enter your firstname",
				lastname: "Please enter your lastname",

				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 5 characters long"
				},

				email: "Please enter a valid email address"

			}
			})
	});

})( jQuery );
