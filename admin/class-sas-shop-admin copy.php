<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://disenialia.com
 * @since      1.0.0
 *
 * @package    Sas_Shop
 * @subpackage Sas_Shop/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Sas_Shop
 * @subpackage Sas_Shop/admin
 * @author     UlisesFreitas <ulises.freitas@gmail.com>
 */
class Sas_Shop_Admin {

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
	 * General Settings of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sas_shop_general_settings_key    The current version of this plugin.
	 */
	private $sas_shop_general_settings_key = 'sas_shop_general_settings';

	/**
	 * Taxes Settings of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sas_shop_taxes_settings_key    The current version of this plugin.
	 */
	private $sas_shop_taxes_settings_key = 'sas_shop_taxes_settings';

	/**
	 * Options Keys of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $sas_shop_options_key    The current version of this plugin.
	 */
	private $sas_shop_options_key = 'sas_shop_options';

	/**
	 * Settings tabs of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $sas_shop_settings_tabs    The current version of this plugin.
	 */
	private $sas_shop_settings_tabs = array();



	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}



	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sas_Shop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sas_Shop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/sas-shop-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Sas_Shop_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Sas_Shop_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/sas-shop-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'postbox' );
	}



	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 * @return   array 			Action links
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>'
				),
			$links
			);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {

		$tabs = Sas_Shop_Settings_Definition::get_tabs();

		$default_tab = Sas_Shop_Settings_Definition::get_default_tab_slug();

		$active_tab = isset( $_GET[ 'tab' ] ) && array_key_exists( $_GET['tab'], $tabs ) ? $_GET[ 'tab' ] : $default_tab;

		include_once( 'partials/' . $this->plugin_name . '-admin-display.php' );

	}




	/*
	 * Loads both the general and taxes settings from
	 * the database into their respective arrays.
	 * Uses array_merge to merge with default values if they're missing.
	 * @since    1.0.0
	 */
	 /*
	function load_settings() {

		$this->general_settings = (array) get_option( $this->sas_shop_general_settings_key );
		$this->sas_shop_taxes_settings = (array) get_option( $this->sas_shop_taxes_settings_key );

		// Merge with defaults
		$this->general_settings = array_merge( array(
			'general_option' => 'General value'
		), $this->general_settings );

		$this->sas_shop_taxes_settings = array_merge( array(
			'taxes_option' => 'Taxes value'
		), $this->sas_shop_taxes_settings );

		$this->sas_shop_taxes_settings = array_merge( array(
			'taxes_active' => '0'
		), $this->sas_shop_taxes_settings );

	}
	*/

	/*
	 * Registers the general settings via the Settings API,
	 * appends the setting to the tabs array of the object.
	 * @since    1.0.0
	 */
	/*
	function register_general_settings() {

		$this->sas_shop_settings_tabs[$this->sas_shop_general_settings_key] = 'General';

		register_setting( $this->sas_shop_general_settings_key, $this->sas_shop_general_settings_key );
		add_settings_section( 'section_general', 'General Plugin Settings', array( &$this, 'section_general_desc' ), $this->sas_shop_general_settings_key );
		add_settings_field( 'general_option', 'A General Option', array( &$this, 'field_general_option' ), $this->sas_shop_general_settings_key, 'section_general' );
	}
	*/
	/*
	 * The following methods provide descriptions
	 * for their respective sections, used as callbacks
	 * with add_settings_section General
	 * @since    1.0.0
	 */
	//function section_general_desc() { echo 'General section description goes here.'; }

	/*
	 * General Option field callback, renders a
	 * text input, note the name and value.
	 */
	 /*
	function field_general_option() {
		?>
		<input type="text" name="<?php echo $this->sas_shop_general_settings_key; ?>[general_option]" value="<?php echo esc_attr( $this->general_settings['general_option'] ); ?>" />
		<?php
	}
	*/
	/*
	 * Registers the taxes settings and appends the
	 * key to the plugin settings tabs array.
	 * @since    1.0.0
	 */
	 /*
	function register_taxes_settings() {

		$this->sas_shop_settings_tabs[$this->sas_shop_taxes_settings_key] = 'Taxes';

		register_setting( $this->sas_shop_taxes_settings_key, $this->sas_shop_taxes_settings_key );

		add_settings_section( 'section_taxes', 'Taxes SAS Shop Settings', array( &$this, 'section_taxes_desc' ), $this->sas_shop_taxes_settings_key );

		add_settings_field( 'taxes_active', 'Taxes on SAS Shop', array( &$this, 'field_taxes_active' ), $this->sas_shop_taxes_settings_key, 'section_taxes' );

		add_settings_field( 'taxes_option', 'An Option', array( &$this, 'field_taxes_option' ), $this->sas_shop_taxes_settings_key, 'section_taxes' );
	}
	*/

	/*
	 * The following methods provide descriptions
	 * for their respective sections, used as callbacks
	 * with add_settings_section Taxes
	 * @since    1.0.0
	 */
	//function section_taxes_desc() { echo 'Taxes section description goes here.'; }



	/*
	 * Taxes Option field callback, same as above.
	 */
	 /*
	function field_taxes_option() {
		?>

        <fieldset>
		<input type="text" name="<?php echo $this->sas_shop_taxes_settings_key; ?>[taxes_option]" value="<?php echo esc_attr( $this->sas_shop_taxes_settings['taxes_option'] ); ?>" />
        </fieldset>
		<?php
	}

	function field_taxes_active(){

		$isChecked = esc_attr( get_option( $this->sas_shop_taxes_settings['taxes_active'] ) );
		?>

		<fieldset>
            <label for="<?php echo $this->sas_shop_taxes_settings_key; ?>_taxes_active">
                <input type="checkbox" name="<?php echo $this->sas_shop_taxes_settings_key; ?>[taxes_active]" value="0" <?php checked($isChecked, 1); ?> />
                <span><?php esc_attr_e('Activate taxes on this shop', $this->plugin_name); ?></span>
            </label>
        </fieldset>
		<?php
	}
	*/

	/*
	 * Renders our tabs in the plugin options page,
	 * walks through the object's tabs array and prints
	 * them one by one. Provides the heading for the
	 * plugin_options_page method.
	 */
	 /*
	function sas_shop_options_tabs() {

		$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->sas_shop_general_settings_key;
		screen_icon();
		echo '<h2 class="nav-tab-wrapper">';
		foreach ( $this->sas_shop_settings_tabs as $tab_key => $tab_caption ) {
			$active = $current_tab == $tab_key ? 'nav-tab-active' : '';
			echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->sas_shop_options_key . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
		}
		echo '</h2>';
	}

	*/

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */

	public function add_plugin_admin_menu() {

	    /*
	     * Add a settings page for this plugin to the Settings menu.
	     *
	     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
	     *
	     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
	     *
	     */

		 /*
	    add_menu_page(
        	__( 'SAS Shop', $this->plugin_name ),
			__( 'SAS Shop', $this->plugin_name ),
			'manage_options',
			$this->sas_shop_options_key,
			array(&$this, 'show_sas_shop_admin_page'),
			'dashicons-cart',
			26
		);

		add_submenu_page($this->sas_shop_options_key , __( 'Products', $this->plugin_name ), __( 'Products', $this->plugin_name ), 'manage_options', 'edit.php?post_type=sas_product', NULL );
		add_submenu_page($this->sas_shop_options_key , __( 'Orders', $this->plugin_name ), __( 'Orders', $this->plugin_name ), 'manage_options', 'edit.php?post_type=sas_shop_orders', NULL );
		add_submenu_page($this->sas_shop_options_key , __( 'Taxes', $this->plugin_name ), __( 'Taxes', $this->plugin_name ), 'manage_options', 'edit.php?post_type=sas_shop_taxes', NULL );
		add_submenu_page($this->sas_shop_options_key , __( 'Shipping', $this->plugin_name ), __( 'Shipping', $this->plugin_name ), 'manage_options', 'edit.php?post_type=sas_shop_shipping', NULL );
*/


		add_menu_page(
			__( 'SAS Shop', $this->plugin_name ),
			__( 'SAS Shop', $this->plugin_name ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_plugin_admin_page' )
			);

		$tabs = Sas_Shop_Settings_Definition::get_tabs();

		foreach ( $tabs as $tab_slug => $tab_title ) {

			add_submenu_page(
				$this->plugin_name,
				$tab_title,
				$tab_title,
				'manage_options',
				$this->plugin_name . '&tab=' . $tab_slug,
				array( $this, 'display_plugin_admin_page' )
				);
		}

		remove_submenu_page( $this->plugin_name, $this->plugin_name );


	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	 /*
	public function show_sas_shop_admin_page(){

		include plugin_dir_path( __FILE__ ) . '/partials/'.$this->plugin_name.'-admin-display.php';

	}
	*/

	/**
	 * SASProduct function.
	 *
	 * @access public
	 * @static
	 * @return void
	 * @since    1.0.0
	 */
	public static function SASProduct() {

		if ( post_type_exists('sas_product') ) {
			return;
		}

		$labels = array(
			'name'                  => _x( 'Products', 'Post Type General Name', 'sas-shop' ),
			'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'sas-shop' ),
			'menu_name'             => __( 'Products', 'sas-shop' ),
			'name_admin_bar'        => __( 'Product', 'sas-shop' ),
			'archives'              => __( 'Item Archives', 'sas-shop' ),
			'parent_item_colon'     => __( 'Parent Product:', 'sas-shop' ),
			'all_items'             => __( 'All Products', 'sas-shop' ),
			'add_new_item'          => __( 'Add New Product', 'sas-shop' ),
			'add_new'               => __( 'New Product', 'sas-shop' ),
			'new_item'              => __( 'New Item', 'sas-shop' ),
			'edit_item'             => __( 'Edit Product', 'sas-shop' ),
			'update_item'           => __( 'Update Product', 'sas-shop' ),
			'view_item'             => __( 'View Product', 'sas-shop' ),
			'search_items'          => __( 'Search products', 'sas-shop' ),
			'not_found'             => __( 'No products found', 'sas-shop' ),
			'not_found_in_trash'    => __( 'No products found in Trash', 'sas-shop' ),
			'featured_image'        => __( 'Featured Image', 'sas-shop' ),
			'set_featured_image'    => __( 'Set featured image', 'sas-shop' ),
			'remove_featured_image' => __( 'Remove featured image', 'sas-shop' ),
			'use_featured_image'    => __( 'Use as featured image', 'sas-shop' ),
			'insert_into_item'      => __( 'Insert into item', 'sas-shop' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'sas-shop' ),
			'items_list'            => __( 'Items list', 'sas-shop' ),
			'items_list_navigation' => __( 'Items list navigation', 'sas-shop' ),
			'filter_items_list'     => __( 'Filter items list', 'sas-shop' ),
		);
		$rewrite = array(
			'slug'                  => 'sas_product',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		/*
		$capabilities = array(

									// meta caps (don't assign these to roles)
									'edit_post'              => 'edit_sas_product',
									'read_post'              => 'read_sas_product',
									'delete_post'            => 'delete_sas_product',

									// primitive/meta caps
									'create_posts'           => 'create_sas_products',

									// primitive caps used outside of map_meta_cap()
									'edit_posts'             => 'edit_sas_products',
									'edit_others_posts'      => 'manage_sas_products',
									'publish_posts'          => 'manage_sas_products',
									'read_private_posts'     => 'read',

									// primitive caps used inside of map_meta_cap()
									'read'                   => 'read',
									'delete_posts'           => 'manage_sas_products',
									'delete_private_posts'   => 'manage_sas_products',
									'delete_published_posts' => 'manage_sas_products',
									'delete_others_posts'    => 'manage_sas_products',
									'edit_private_posts'     => 'edit_sas_products',
									'edit_published_posts'   => 'edit_sas_products'
			);
			*/

		$args = array(
			'label'                 => __( 'Product', 'sas-shop' ),
			'description'           => __( 'Product information pages.', 'sas-shop' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', ),
			'taxonomies'            => array( 'sas_product_category', 'sas_product_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => false,
			'menu_position'         => 25,
			'menu_icon'             => 'dashicons-sticky',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => 'sas_products',
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'query_var'             => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
			'map_meta_cap'          => true,
			//'capabilities'          => $capabilities,

		);
		register_post_type( 'sas_product', $args );
		flush_rewrite_rules();
	}

	/**
	 * SASOrders function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function SASOrders() {

		if ( post_type_exists('sas_shop_orders') ) {
			return;
		}

		$labels = array(
			'name'                  => _x( 'Orders', 'Post Type General Name', 'sas-shop' ),
			'singular_name'         => _x( 'Order', 'Post Type Singular Name', 'sas-shop' ),
			'menu_name'             => __( 'Orders', 'sas-shop' ),
			'name_admin_bar'        => __( 'Orders', 'sas-shop' ),
			'archives'              => __( 'Order Archives', 'sas-shop' ),
			'parent_item_colon'     => __( 'Parent Order:', 'sas-shop' ),
			'all_items'             => __( 'All Orders', 'sas-shop' ),
			'add_new_item'          => __( 'Add New Order', 'sas-shop' ),
			'add_new'               => __( 'Add Order', 'sas-shop' ),
			'new_item'              => __( 'New Order', 'sas-shop' ),
			'edit_item'             => __( 'Edit Order', 'sas-shop' ),
			'update_item'           => __( 'Update Order', 'sas-shop' ),
			'view_item'             => __( 'View Order', 'sas-shop' ),
			'search_items'          => __( 'Search Order', 'sas-shop' ),
			'not_found'             => __( 'Not found', 'sas-shop' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'sas-shop' ),
			'featured_image'        => __( 'Featured Image', 'sas-shop' ),
			'set_featured_image'    => __( 'Set featured image', 'sas-shop' ),
			'remove_featured_image' => __( 'Remove featured image', 'sas-shop' ),
			'use_featured_image'    => __( 'Use as featured image', 'sas-shop' ),
			'insert_into_item'      => __( 'Insert into Order', 'sas-shop' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Order', 'sas-shop' ),
			'items_list'            => __( 'Orders list', 'sas-shop' ),
			'items_list_navigation' => __( 'Orders list navigation', 'sas-shop' ),
			'filter_items_list'     => __( 'Filter orders list', 'sas-shop' ),
		);

		$rewrite = array(
			'slug'                  => 'sas_orders',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);


		$args = array(
			'label'                 => __( 'Order', 'sas-shop' ),
			'description'           => __( 'All SAS Shop Orders', 'sas-shop' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'comments', 'revisions', ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => false,
			'menu_position'         => 30,
			'menu_icon'             => 'dashicons-tickets-alt',
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capabillity_type'      => 'post',

		);
		register_post_type( 'sas_shop_orders', $args );
		flush_rewrite_rules();
	}


	public static function sas_shop_taxes_remove_post_type_support() {
    	remove_post_type_support( 'sas_shop_taxes', 'title' );
		remove_post_type_support( 'sas_shop_taxes', 'editor' );
	}

	/**
	 * SASTaxes function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function SASTaxes() {

		$labels = array(
			'name'                  => _x( 'Taxes', 'Post Type General Name', 'sas-shop' ),
			'singular_name'         => _x( 'Tax', 'Post Type Singular Name', 'sas-shop' ),
			'menu_name'             => __( 'Taxes', 'sas-shop' ),
			'name_admin_bar'        => __( 'Tax', 'sas-shop' ),
			'archives'              => __( 'Item Archives', 'sas-shop' ),
			'parent_item_colon'     => __( 'Parent Tax:', 'sas-shop' ),
			'all_items'             => __( 'All Taxes', 'sas-shop' ),
			'add_new_item'          => __( 'Add New Tax', 'sas-shop' ),
			'add_new'               => __( 'New Tax', 'sas-shop' ),
			'new_item'              => __( 'New Item', 'sas-shop' ),
			'edit_item'             => __( 'Edit Tax', 'sas-shop' ),
			'update_item'           => __( 'Update Tax', 'sas-shop' ),
			'view_item'             => __( 'View Product', 'sas-shop' ),
			'search_items'          => __( 'Search taxes', 'sas-shop' ),
			'not_found'             => __( 'No products found', 'sas-shop' ),
			'not_found_in_trash'    => __( 'No products found in Trash', 'sas-shop' ),
			'featured_image'        => __( 'Featured Image', 'sas-shop' ),
			'set_featured_image'    => __( 'Set featured image', 'sas-shop' ),
			'remove_featured_image' => __( 'Remove featured image', 'sas-shop' ),
			'use_featured_image'    => __( 'Use as featured image', 'sas-shop' ),
			'insert_into_item'      => __( 'Insert into item', 'sas-shop' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'sas-shop' ),
			'items_list'            => __( 'Items list', 'sas-shop' ),
			'items_list_navigation' => __( 'Items list navigation', 'sas-shop' ),
			'filter_items_list'     => __( 'Filter items list', 'sas-shop' ),
		);
		$args = array(
			'label'                 => __( 'Tax', 'sas-shop' ),
			'description'           => __( 'Taxes information pages.', 'sas-shop' ),
			'labels'                => $labels,
			'supports'              => array( 'title' ),
			'hierarchical'          => false,
			'public'                => false,
			'show_ui'               => true,
			'show_in_menu'          => false,
			'menu_position'         => 25,
			'menu_icon'             => 'dashicons-sticky',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'query_var'             => 'sas_tax',
			'capability_type'       => 'post',
		);
		register_post_type( 'sas_shop_taxes', $args );

	}

	/**
	 * SASShipping function.
	 *
	 * @access public
	 * @static
	 * @return void
	 */
	public static function SASShipping() {

		$labels = array(
			'name'                  => _x( 'Shipping Companies', 'Post Type General Name', 'sas-shop' ),
			'singular_name'         => _x( 'Shipping Company', 'Post Type Singular Name', 'sas-shop' ),
			'menu_name'             => __( 'Shipping Company', 'sas-shop' ),
			'name_admin_bar'        => __( 'Shipping Company', 'sas-shop' ),
			'archives'              => __( 'Item Archives', 'sas-shop' ),
			'parent_item_colon'     => __( 'Parent Shipping Company:', 'sas-shop' ),
			'all_items'             => __( 'All Shipping companies', 'sas-shop' ),
			'add_new_item'          => __( 'Add New Shipping Company', 'sas-shop' ),
			'add_new'               => __( 'New Shipping company', 'sas-shop' ),
			'new_item'              => __( 'New Item', 'sas-shop' ),
			'edit_item'             => __( 'Edit Shipping company', 'sas-shop' ),
			'update_item'           => __( 'Update Shipping company', 'sas-shop' ),
			'view_item'             => __( 'View Shipping company', 'sas-shop' ),
			'search_items'          => __( 'Search shipping company', 'sas-shop' ),
			'not_found'             => __( 'No shipping company found', 'sas-shop' ),
			'not_found_in_trash'    => __( 'No shipping company found in Trash', 'sas-shop' ),
			'featured_image'        => __( 'Featured Image', 'sas-shop' ),
			'set_featured_image'    => __( 'Set featured image', 'sas-shop' ),
			'remove_featured_image' => __( 'Remove featured image', 'sas-shop' ),
			'use_featured_image'    => __( 'Use as featured image', 'sas-shop' ),
			'insert_into_item'      => __( 'Insert into item', 'sas-shop' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'sas-shop' ),
			'items_list'            => __( 'Items list', 'sas-shop' ),
			'items_list_navigation' => __( 'Items list navigation', 'sas-shop' ),
			'filter_items_list'     => __( 'Filter items list', 'sas-shop' ),
		);
		$rewrite = array(
			'slug'                  => 'sas_shop_shipping',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Shipping Company', 'sas-shop' ),
			'description'           => __( 'Shipping information pages.', 'sas-shop' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'thumbnail', ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => false,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-sticky',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
		);
		register_post_type( 'sas_shop_shipping', $args );

	}


	/*
	 * Register Custom Taxonomy
	 * @since    1.0.0
	 */
	public function sas_product_taxonomy_type() {

		$labels = array(
			'name'                       => _x( 'Type of products', 'Taxonomy General Name', 'sas-shop' ),
			'singular_name'              => _x( 'Type of product', 'Taxonomy Singular Name', 'sas-shop' ),
			'menu_name'                  => __( 'Types of product', 'sas-shop' ),
			'all_items'                  => __( 'All types of product', 'sas-shop' ),
			'parent_item'                => __( 'Parent Item', 'sas-shop' ),
			'parent_item_colon'          => __( 'Parent Item:', 'sas-shop' ),
			'new_item_name'              => __( 'New tipo de producto', 'sas-shop' ),
			'add_new_item'               => __( 'Add New Item', 'sas-shop' ),
			'edit_item'                  => __( 'Edit Item', 'sas-shop' ),
			'update_item'                => __( 'Update Item', 'sas-shop' ),
			'view_item'                  => __( 'View Item', 'sas-shop' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'sas-shop' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'sas-shop' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'sas-shop' ),
			'popular_items'              => __( 'Popular Items', 'sas-shop' ),
			'search_items'               => __( 'Search Items', 'sas-shop' ),
			'not_found'                  => __( 'Not Found', 'sas-shop' ),
			'no_terms'                   => __( 'No items', 'sas-shop' ),
			'items_list'                 => __( 'Items list', 'sas-shop' ),
			'items_list_navigation'      => __( 'Items list navigation', 'sas-shop' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => false,
			'show_admin_column'          => false,
			'show_in_nav_menus'          => false,
			'show_tagcloud'              => false,
			'query_var'                  => 'sas_product_type',
		);
		register_taxonomy( 'sas_product_type', array( 'sas_product' ), $args );

	}


	// Register Custom Taxonomy
	public static function sas_product_taxonomies() {

		$labels = array(
			'name'                       => _x( 'Categories', 'Taxonomy General Name', 'sas-shop' ),
			'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'sas-shop' ),
			'menu_name'                  => __( 'Category', 'sas-shop' ),
			'all_items'                  => __( 'All Items', 'sas-shop' ),
			'parent_item'                => __( 'Parent Item', 'sas-shop' ),
			'parent_item_colon'          => __( 'Parent Item:', 'sas-shop' ),
			'new_item_name'              => __( 'New Item Name', 'sas-shop' ),
			'add_new_item'               => __( 'Add New Item', 'sas-shop' ),
			'edit_item'                  => __( 'Edit Item', 'sas-shop' ),
			'update_item'                => __( 'Update Item', 'sas-shop' ),
			'view_item'                  => __( 'View Item', 'sas-shop' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'sas-shop' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'sas-shop' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'sas-shop' ),
			'popular_items'              => __( 'Popular Items', 'sas-shop' ),
			'search_items'               => __( 'Search Items', 'sas-shop' ),
			'not_found'                  => __( 'Not Found', 'sas-shop' ),
			'no_terms'                   => __( 'No items', 'sas-shop' ),
			'items_list'                 => __( 'Items list', 'sas-shop' ),
			'items_list_navigation'      => __( 'Items list navigation', 'sas-shop' ),
		);
		$rewrite = array(
			'slug'                       => 'sas_product_cat',
			'with_front'                 => true,
			'hierarchical'               => false,
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'query_var'                  => 'sas_product_cat',
			'rewrite'                    => $rewrite,
		);
		register_taxonomy( 'sas_product_cat', array( 'sas_product' ), $args );

	}

	public function sas_shop_custom_post_menu() {

        //remove_submenu_page('edit.php?post_type=sas_shop_orders', 'post-new.php?post_type=sas_shop_orders');
        //remove_submenu_page('edit.php?post_type=sas_product', 'post-new.php?post_type=sas_product');
		//remove_menu_page('edit.php?post_type=sas_shop_orders', 'post-new.php?post_type=sas_shop_orders' );
    }


	public function sas_product_metaboxes(){

		$sasProductMetabox = new Sas_Product_Metabox($this->plugin_name, $this->version, 'sas_product');
		$meta_boxes = $sasProductMetabox->init_metaboxes();
		new CMB_Meta_Box( $meta_boxes[0] );
	}

	public function sas_taxes_metaboxes(){
		$sasTaxesMetabox = new Sas_Taxes_Metabox($this->plugin_name, $this->version, 'sas_shop_taxes');
		$sasTaxesMetabox->init_metaboxes();

		//new CMB_Meta_Box( $meta_box );
	}

}