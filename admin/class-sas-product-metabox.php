<?php
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
class Sas_Product_Metabox{

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

		add_filter( 'cmb_meta_boxes', array( &$this, 'init_metaboxes' ) );

	}


	public function init_metaboxes( ) {



		$settings = Sas_Shop_Option::get_options();
		$taxes_enabled = Sas_Shop_Option::get_option( 'sas_shop_enable_taxes' );
		$shipping_enabled = Sas_Shop_Option::get_option( 'sas_shop_enable_shipping' );


		if($shipping_enabled == 1){

			$shipping_methods = array();

			$shipping_free_enabled = Sas_Shop_Option::get_option( 'shipping_free_enabled' );
			if($shipping_free_enabled == 1){
				$shipping_free_name = Sas_Shop_Option::get_option( 'shipping_free_name' );
				$free_shipping = $shipping_free_name;
				$shipping_methods['shipping_free_name'] = $free_shipping;
			}

			$shipping_flat_enabled = Sas_Shop_Option::get_option( 'shipping_flat_enabled' );
			if($shipping_flat_enabled == 1){
				$shipping_flat_name = Sas_Shop_Option::get_option( 'shipping_flat_name' );
				$flat_shipping = $shipping_flat_name;
				$shipping_methods['shipping_flat_name'] = $flat_shipping;
			}
		}


		if( $taxes_enabled == 1 ){

			if(isset($settings['taxes'])){
				$all_tax_names		= array_filter($settings['taxes']['tax_name']); //Array ( [0] => IVA [1] => IVA REDUCIDO [2] => )
				$all_tax_rates 		= array_filter($settings['taxes']['tax_rate']); //Array ( [0] => 21.00 [1] => 14.00 [2] => )
				$all_tax_country 	= array_filter($settings['taxes']['tax_country']); //Array ( [0] => 21.00 [1] => 14.00 [2] => )

				foreach($all_tax_names as $key => $val){
					if( array_key_exists( $key, $all_tax_rates ) && array_key_exists( $key, $all_tax_country ) ){
						$all_taxes_enabled[$all_tax_rates[$key]] = $val .' - '.$all_tax_country[$key] . ' - ' . $all_tax_rates[$key];
					}
				}
			}
	    }

		$meta_boxes = array();

		$fields = array();

		$fields[] = array( 'id' => 'field-product-sku',  'name' => 'SKU #', 'type' => 'text', );
		$fields[] = array( 'id' => 'field-product-display-sku',  'name' => 'Display product SKU on single product page', 'type' => 'checkbox',  );

		$fields[] = array( 'id' => 'field-product-price',  'name' => 'Price', 'type' => 'text', 'cols' => 6 );

		if( isset($all_taxes_enabled) && $taxes_enabled == 1 ){
			$fields[] = array( 'id' => 'field-sas-product-taxes', 'name' => 'Product tax', 'type' => 'select', 'options' => $all_taxes_enabled , 'allow_none' => false,'cols' => 6  );
		}

		if( isset($shipping_methods) && $shipping_enabled == 1 ){
			$fields[] = array( 'id' => 'field-sas-product-shipping-select', 'name' => 'Select Product Shipping methods', 'type' => 'select', 'options' => $shipping_methods , 'multiple' => true );
		}

		$meta_boxes[] = array(
			'title' => __('Product Price - Shipping - Taxes', $this->plugin_name ),
			'pages' => $this->post_type,
			'fields' => $fields
		);

		$stockFields = array();
		$stockFields[] = array( 'id' => 'field-product-display-current-stock',  'name' => 'Display current stock on single product page', 'type' => 'checkbox' );
		$stockFields[] = array( 'id' => 'field-product-current-stock',  'name' => 'Current Stock', 'type' => 'number' );
		$stockFields[] = array( 'id' => 'field-product-max-stock',  'name' => 'Max Stock allowed', 'type' => 'number' );

		$meta_boxes[] = array(
			'title' => __('Product Stock management', $this->plugin_name ),
			'pages' => $this->post_type,
			'fields' => $stockFields
		);
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

}
