<?php

// Create custom widget class extending WPH_Widget
class Sas_Shop_Widget extends WPH_Widget {

	function __construct() {

		$plugin = new Sas_Shop(SAS_SHOP_VERSION, SAS_SHOP_NAME);
		$this->plugin_name = $plugin->get_plugin_name();

		// Configure widget array
		$args = array(
		    'label' => __( 'Sas Shop Cart', $this->plugin_name ),
		    'description' => __( 'Show Sas Shop shopping cart', $this->plugin_name ),
		);

		// Configure the widget fields
		// Example for: Title ( text ) and Amount of posts to show ( select box )
		$args[ 'fields' ] = array(
		    // Title field
		    array(
			// Field name/label
			'name' => __( 'Title', $this->plugin_name ),
			// Field description
			'desc' => __( 'Enter the widget title.', $this->plugin_name ),
			// Field id
			'id' => 'title',
			// Field type ( text, checkbox, textarea, select, select-group, taxonomy, taxonomyterm, pages, hidden )
			'type' => 'text',
			// Class, rows, cols
			'class' => 'widefat',
			// Default value
			'std' => __( 'Recent Posts', $this->plugin_name ),
			/*
			  Set the field validation type/s

			  'alpha_dash'
			  Returns FALSE if the value contains anything other than alpha-numeric characters, underscores or dashes.

			  'alpha'
			  Returns FALSE if the value contains anything other than alphabetical characters.

			  'alpha_numeric'
			  Returns FALSE if the value contains anything other than alpha-numeric characters.

			  'numeric'
			  Returns FALSE if the value contains anything other than numeric characters.

			  'boolean'
			  Returns FALSE if the value contains anything other than a boolean value ( true or false ).

			  ----------

			  You can define custom validation methods. Make sure to return a boolean ( TRUE/FALSE ).
			  Example:

			  'validate' => 'my_custom_validation',

			  Will call for: $this->my_custom_validation( $value_to_validate );

			 */
			'validate' => 'alpha_dash',
			/*

			  Filter data before entering the DB

			  strip_tags ( default )
			  wp_strip_all_tags
			  esc_attr
			  esc_url
			  esc_textarea

			 */
			'filter' => 'strip_tags|esc_attr'
		    ),
		    // Taxonomy Field

		    array(
			// Field name/label
			'name' => __( 'Shortcode', $this->plugin_name ),
			// Field description
			'desc' => __( 'Cart shortcode.', $this->plugin_name ),
			// Field id
			'id' => 'cart_shortcode',
			'type' => 'text',
			// Class, rows, cols
			'class' => 'widefat',
			'std'   => '[sas-shop-cart-display]'
		    ),
		    array(
			// Field name/label
			'name' => __( 'Hide on Cart', $this->plugin_name ),
			// Field description
			'desc' => __( 'Cart shortcode.', $this->plugin_name ),
			// Field id
			'id' => 'hide_mini_cart',
			'type' => 'hidden',
			'std'   => 'hide_mini_cart'
		    ),
		    /*
		    // Taxonomy Field
		    array(
			// Field name/label
			'name' => __( 'Taxonomy terms', $this->plugin_name ),
			// Field description
			'desc' => __( 'Set the taxonomy terms.', $this->plugin_name ),
			// Field id
			'id' => 'taxonomyterm',
			'type' => 'taxonomyterm',
			'taxonomy' => 'category',
			// Class, rows, cols
			'class' => 'widefat',
		    ),
		    // Pages Field
		    array(
			// Field name/label
			'name' => __( 'Pages', $this->plugin_name ),
			// Field description
			'desc' => __( 'Set the page.', $this->plugin_name ),
			// Field id
			'id' => 'pages',
			'type' => 'pages',
			// Class, rows, cols
			'class' => 'widefat',
		    ),
		    // Post type Field
		    array(
			// Field name/label
			'name' => __( 'Post type', $this->plugin_name ),
			// Field description
			'desc' => __( 'Set the post type.', $this->plugin_name ),
			// Field id
			'id' => 'posttype',
			'type' => 'posttype',
			'posttype' => 'post',
			// Class, rows, cols
			'class' => 'widefat',
		    ),
		    // Amount Field
		    array(
			'name' => __( 'Amount' ),
			'desc' => __( 'Select how many posts to show.', $this->plugin_name ),
			'id' => 'amount',
			'type' => 'select',
			// Selectbox fields
			'fields' => array(
			    array(
				// Option name
				'name' => __( '1 Post', $this->plugin_name ),
				// Option value
				'value' => '1'
			    ),
			    array(
				'name' => __( '2 Posts', $this->plugin_name ),
				'value' => '2'
			    ),
			    array(
				'name' => __( '3 Posts', $this->plugin_name ),
				'value' => '3'
			    )

			// Add more options
			),
			'validate' => 'my_custom_validation',
			'filter' => 'strip_tags|esc_attr',
		    ),
		    // Output type checkbox
		    array(
			'name' => __( 'Output as list', $this->plugin_name ),
			'desc' => __( 'Wraps posts with the <li> tag.', $this->plugin_name ),
			'id' => 'list',
			'type' => 'checkbox',
			// Checked by default:
			'std' => 1, // 0 or 1
			'filter' => 'strip_tags|esc_attr',
		    ),
		    */
			// Add more fields
		); // Fields array
		// Create widget
		$this->create_widget( $args );
	}

	/**
       * Custom validation for this widget
       *
       * @param string $value
       * @return boolean
       */
	function my_custom_validation( $value ) {
		if ( strlen( $value ) > 1 ) {
			return false;
		} else {
			return true;
		}
	}

      /**
       * Output function
       *
       * @param array $args
       * @param array $instance
       */
	function widget( $args, $instance ) {
		$out = $args[ 'before_widget' ];
		// And here do whatever you want
		$out .= $args[ 'before_title' ];
		$out .= $instance[ 'title' ];
		$out .= $args[ 'after_title' ];

		// Here you would get the most recent posts based on the selected amount: $instance['amount']
		// Then return those posts on the $out variable ready for the output

		$out .= do_shortcode('[sas-shop-cart-display]');

		$out .= $args[ 'after_widget' ];
		echo $out;
	}

}

// Register widget
if ( !function_exists( 'sas_shop_mini_cart_register_widget' ) ) {

	function sas_shop_mini_cart_register_widget() {
		register_widget( 'Sas_Shop_Widget' );
	}

	add_action( 'widgets_init', 'sas_shop_mini_cart_register_widget', 1 );
}
