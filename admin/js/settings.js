jQuery(window).load(function(){

	//Repeater

	jQuery('#add-repeater').on( 'click', function( e ) {

		e.preventDefault();

		var clone = jQuery('.repeater.hidden').clone(true);

		clone.removeClass('hidden');
		clone.insertBefore('.repeater.hidden');

		return false;

	});

	jQuery('.link-remove').on('click', function() {

		var parents = jQuery(this).parents('.repeater');

		if ( ! parents.hasClass( 'first' ) ) {

			parents.remove();

		}

		return false;

	});

	jQuery( '.btn-edit' ).on( 'click', function() {

		var repeater = $(this).parents( '.repeater' );

		repeater.children( '.repeater-content' ).slideToggle( '150' );
		jQuery(this).children( '.toggle-arrow' ).toggleClass( 'closed' );
		jQuery(this).parents( '.handle' ).toggleClass( 'closed' );

	});

	jQuery(function(){

		jQuery( '.repeater-title' ).on( 'keyup', function(){

			var repeater = $(this).parents( '.repeater' );
			var fieldval = $(this).val();

			if ( fieldval.length > 0 ) {

				repeater.find( '.title-repeater' ).text( fieldval );

			} else {

				repeater.find( '.title-repeater' ).text( nhdata.repeatertitle );

			}

		});

	});

	jQuery(function() {

		jQuery( '.repeaters' ).sortable({
			cursor: 'move',
			handle: '.handle',
			items: '.repeater',
			opacity: 0.6,
		});
	});




	// Countries
	jQuery('select#gravitation_shop_multi_countries').change(function(){
		if (jQuery(this).val()=="specific") {
			jQuery(this).parent().parent().next('tr').show();
		}
		else {
			jQuery(this).parent().parent().next('tr').hide();
		}
	}).change();

	// Chosen selects
	jQuery("select.chosen_select").chosen({
		width: '350px',
		disable_search_threshold: 5
	});

	jQuery("select.chosen_select_nostd").chosen({
		allow_single_deselect: 'true',
		width: '350px',
		disable_search_threshold: 5
	});

});