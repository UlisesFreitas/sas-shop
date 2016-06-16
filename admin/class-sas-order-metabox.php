<?php
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
class Sas_Order_Metabox{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * post_type
	 *
	 * @var mixed
	 * @access private
	 */
	private $post_type;



	/**
	 * __construct function.
	 *
	 * @access public
	 * @param mixed $plugin_name
	 * @param mixed $version
	 * @param mixed $post_type
	 * @return void
	 */
	public function __construct( $plugin_name, $version, $post_type ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->post_type = $post_type;

		//add_filter( 'cmb_meta_boxes', array( &$this, 'init_metaboxes' ) );

	}


	public function init_metaboxes() {

		$meta_boxes = array();

		$fields = array();

		//$fields[] = array( 'id' => 'field-order-sku', 'name' => 'Order #' , 'type' => 'title' );

		$fields[] = array( 'id' => 'field-order-date-creation', 'name' => 'Order Date', 'type' => 'date', 'cols' => '3' );
		$fields[] = array( 'id' => 'field-order-time-creation', 'name' => 'Order Time', 'type' => 'text', 'cols' => '3' );

		//$fields[] = array( 'id' => 'field-order-date-and-time', 'name' => 'Date & Time (unix) input field', 'type' => 'datetime_unix' , 'cols' => '6');
		$fields[] = array( 'id' => 'field-order-status', 'name' => 'Order Status', 'type' => 'select', 'options' => array( 'cancelled' => 'Cancelled', 'completed' => 'Completed', 'failed' => 'Failed', 'pending_payment' => 'Pending Payment', 'processing' => 'Processing', 'refunded' => 'Refunded',  ), 'allow_none' => false , 'cols' => '6');

		$meta_boxes[] = array(
			'title' => __('Order Details', $this->plugin_name ),
			'pages' => $this->post_type,
			'fields' => $fields
		);

		$customer[] = array( 'id' => 'field-order-customer-name',  'name' => 'Name', 'type' => 'text', 'cols' => '3' );
		$customer[] = array( 'id' => 'field-order-customer-lastname', 'name' => 'Last name', 'type' => 'text', 'cols' => '3' );
		$customer[] = array( 'id' => 'field-order-customer-email', 'name' => 'Email', 'type' => 'text', 'cols' => '3' );
		$customer[] = array( 'id' => 'field-order-customer-country', 'name' => 'Country', 'type' => 'text', 'cols' => '3' );
		$customer[] = array( 'id' => 'field-order-customer-address', 'name' => 'Address', 'type' => 'text', 'cols' => '3' );
		$customer[] = array( 'id' => 'field-order-customer-city', 'name' => 'City', 'type' => 'text', 'cols' => '3' );
		$customer[] = array( 'id' => 'field-order-customer-zip-code', 'name' => 'Zip Code', 'type' => 'text', 'cols' => '3' );
		$customer[] = array( 'id' => 'field-order-customer-phone', 'name' => 'Phone', 'type' => 'text', 'cols' => '3' );
		$customer[] = array( 'id' => 'field-order-customer-info',  'name' => 'Additional information', 'type' => 'textarea' );
		$meta_boxes[] = array(
			'title' => __('Customer Details', $this->plugin_name ),
			'pages' => $this->post_type,
			'fields' => $customer
		);

		/*
		$products = array();
		$products[] = array( 'id' => 'field-order-product-id', 'name' => 'Post select field (AJAX)', 'type' => 'post_select', 'use_ajax' => true, 'query' => array( 'post_type' => 'sas_product' ), 'repeatable' => true, 'sortable' => true , 'cols' => '3');


		$meta_boxes[] = array(
			'title' => __('Products Details', $this->plugin_name ),
			'pages' => $this->post_type,
			'fields' => $products
		);
		*/





			/*
			array( 'id' => 'field-2', 'name' => 'Read-only text input field', 'type' => 'text', 'readonly' => true, 'default' => 'READ ONLY' ),
	 		array( 'id' => 'field-3', 'name' => 'Repeatable text input field', 'type' => 'text', 'desc' => 'Add up to 5 fields.', 'repeatable' => true, 'repeatable_max' => 5, 'sortable' => true ),

			array( 'id' => 'field-4',  'name' => 'Small text input field', 'type' => 'text_small' ),
			array( 'id' => 'field-5',  'name' => 'URL field', 'type' => 'url' ),

			array( 'id' => 'field-6',  'name' => 'Radio input field', 'type' => 'radio', 'options' => array( 'Option 1', 'Option 2' ) ),
			array( 'id' => 'field-7',  'name' => 'Checkbox field', 'type' => 'checkbox' ),

			array( 'id' => 'field-8',  'name' => 'WYSIWYG field', 'type' => 'wysiwyg', 'options' => array( 'editor_height' => '100' ), 'repeatable' => true, 'sortable' => true ),

			array( 'id' => 'field-9',  'name' => 'Textarea field', 'type' => 'textarea' ),
			array( 'id' => 'field-10',  'name' => 'Code textarea field', 'type' => 'textarea_code' ),

			array( 'id' => 'field-11', 'name' => 'File field', 'type' => 'file', 'file_type' => 'image', 'repeatable' => 1, 'sortable' => 1 ),
			array( 'id' => 'field-12', 'name' => 'Image upload field', 'type' => 'image', 'repeatable' => true, 'show_size' => true ),

			array( 'id' => 'field-13', 'name' => 'Select field', 'type' => 'select', 'options' => array( 'option-1' => 'Option 1', 'option-2' => 'Option 2', 'option-3' => 'Option 3' ), 'allow_none' => true, 'sortable' => true, 'repeatable' => true ),
			array( 'id' => 'field-14', 'name' => 'Select field', 'type' => 'select', 'options' => array( 'option-1' => 'Option 1', 'option-2' => 'Option 2', 'option-3' => 'Option 3' ), 'multiple' => true ),
			array( 'id' => 'field-15', 'name' => 'Select taxonomy field', 'type' => 'taxonomy_select',  'taxonomy' => 'category' ),
			array( 'id' => 'field-15b', 'name' => 'Select taxonomy field', 'type' => 'taxonomy_select',  'taxonomy' => 'category',  'multiple' => true ),
			array( 'id' => 'field-16', 'name' => 'Post select field', 'type' => 'post_select', 'use_ajax' => false, 'query' => array( 'cat' => 1 ) ),
			array( 'id' => 'field-17', 'name' => 'Post select field (AJAX)', 'type' => 'post_select', 'use_ajax' => true ),
			array( 'id' => 'field-17b', 'name' => 'Post select field (AJAX)', 'type' => 'post_select', 'use_ajax' => true, 'query' => array( 'posts_per_page' => 8 ), 'multiple' => true  ),

			array( 'id' => 'field-18', 'name' => 'Date input field', 'type' => 'date' ),
			array( 'id' => 'field-19', 'name' => 'Time input field', 'type' => 'time' ),
			array( 'id' => 'field-20', 'name' => 'Date (unix) input field', 'type' => 'date_unix' ),
			array( 'id' => 'field-21', 'name' => 'Date & Time (unix) input field', 'type' => 'datetime_unix' ),

			array( 'id' => 'field-22', 'name' => 'Color', 'type' => 'colorpicker' ),

			array( 'id' => 'field-23', 'name' => 'Location', 'type' => 'gmap' ),

			array( 'id' => 'field-24', 'name' => 'Title Field', 'type' => 'title' ),
			*/


		return $meta_boxes;

	}

	public function init_order_products_metaboxes() {

		$meta_boxes = array();

		$products = array();

		$products[] = array( 'id' => 'field-order-product-id', 'name' => 'Post select field (AJAX)', 'type' => 'post_select', 'use_ajax' => true, 'query' => array( 'post_type' => 'sas_product' ), 'repeatable' => true, 'cols' => '3');
		$products[] = array( 'id' => 'field-order-product-price', 'name' => 'Product cost', 'type' => 'text', 'repeatable' => true, 'cols' => '3' );



		$meta_boxes[] = array(
			'title' => __('Products Details', $this->plugin_name ),
			'pages' => $this->post_type,
			'fields' => $products
		);
		return $meta_boxes;

	}

}
