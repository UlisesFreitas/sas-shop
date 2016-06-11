<?php
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
class Sas_Taxes_Metabox{

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

		$meta_boxes = array();

		// Examples of Groups and Columns

		$groups_and_cols = array(
			array( 'id' => 'gtax-1',  'name' => 'Tax visible name - Like IVA', 'type' => 'text', 'cols' => 4 ),
			array( 'id' => 'gtax-2',  'name' => 'Tax rate - Like 21.00', 'type' => 'text', 'cols' => 4 ),
			array( 'id' => 'gtax-3',  'name' => 'Tax Country code - Like ES', 'type' => 'text', 'cols' => 4 ),


		);
		/*
		$meta_boxes[] = array(
			'title' => 'Groups and Columns',
			'pages' => 'sas_shop_taxes',
			'repeatable' => true,
			'sortable' => true,
			'fields' => $groups_and_cols,

		);
		*/

		// For this example, copy fields from $fields, update I
		$group_fields = $groups_and_cols;
			foreach ( $group_fields as &$field ) {
			$field['id'] = str_replace( 'gtax', 'gtax', $field['id'] );
		}

		$meta_boxes[] = array(
			'title' => 'CMB Test - group (all fields)',
			'pages' => 'sas_shop_taxes',
			'fields' => array(
				array(
					'id' => 'gp_taxes',
					'name' => 'My Repeatable Group',
					'type' => 'group',
					'repeatable' => true,
					'sortable' => true,
					'fields' => $group_fields,
					'desc' => 'This is the group description.'
				)
			)
		);

		return $meta_boxes;

	}

}
