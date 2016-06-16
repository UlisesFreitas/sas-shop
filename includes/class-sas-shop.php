<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://disenialia.com
 * @since      1.0.0
 *
 * @package    Sas_Shop
 * @subpackage Sas_Shop/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Sas_Shop
 * @subpackage Sas_Shop/includes
 * @author     UlisesFreitas <ulises.freitas@gmail.com>
 */
class Sas_Shop {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Sas_Shop_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct($version , $plugin_name) {

		//$this->plugin_name = 'sas-shop';
		//$this->version = '1.0.0';

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Sas_Shop_Loader. Orchestrates the hooks of the plugin.
	 * - Sas_Shop_i18n. Defines internationalization functionality.
	 * - Sas_Shop_Admin. Defines all hooks for the admin area.
	 * - Sas_Shop_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sas-shop-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sas-shop-i18n.php';

		/**
		 * The class responsible for defining helper functions of the plugin core
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/sas-shop-core-helpers.php';


		/**
		 * The class responsible for defining helper functions of the plugin core
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname(__FILE__) ) . 'includes/class-sas-shop-sessions.php';

		/**
		 * The class responsible for defining Accounts functions of the plugin core
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sas-shop-accounts.php';

		/**
		 * The class responsible for defining Accounts functions of the plugin core
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sas-shop-email.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sas-shop-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sas-shop-orders.php';


		/**
		 * The class responsible for insert custom metaboxes on custom post types
		 *
		 */
		require_once plugin_dir_path( dirname(__FILE__) ) . 'includes/external-plugins/custom-meta-boxes/custom-meta-boxes.php';


		/**
		 * The class responsible for insert custom widgets on sas shop
		 *
		 */
		require_once plugin_dir_path( dirname(__FILE__) ) . 'includes/external-plugins/widget-helper/wph-widget-class.php';
		require_once plugin_dir_path( dirname(__FILE__) ) . 'includes/widgets/sample.php';


		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-sas-shop-public.php';




		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sas-product-metabox.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sas-order-metabox.php';


		//settings stuff
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-sas-shop-option.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-sas-shop-callback-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-sas-shop-meta-box.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-sas-shop-sanitization-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-sas-shop-settings-definition.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-sas-shop-settings.php';


		//countries
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/classes/class-sas-shop-countries.php';



		$this->loader = new Sas_Shop_Loader();



	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Sas_Shop_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Sas_Shop_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	private function define_core_helpers() {

		$coreHelpers = new Sas_Shop_Core_Helpers( $this->get_version(), $this->get_plugin_name() );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Sas_Shop_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_filter('init', $plugin_admin, 'sas_shop_add_thumbnail_size');
		$this->loader->add_filter('image_size_names_choose', $plugin_admin, 'sas_shop_image_sizes');

		//$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );
		//$this->loader->add_action( 'init', $plugin_admin, 'load_settings' );
		//$this->loader->add_action( 'admin_init', $plugin_admin, 'register_general_settings' );
		//$this->loader->add_action( 'admin_init', $plugin_admin, 'register_taxes_settings' );
		//$this->loader->add_action( 'admin_menu', $plugin_admin, 'sas_shop_custom_post_menu' );



		$this->loader->add_action( 'init', $plugin_admin, 'SASProduct' );
		$this->loader->add_action( 'init', $plugin_admin, 'SASOrders' );



		$this->loader->add_action( 'init', $plugin_admin, 'sas_product_taxonomy_type' );

		$this->loader->add_filter('post_row_actions', $plugin_admin, 'remove_quick_edit',10,2);
		$this->loader->add_filter( 'manage_sas_shop_orders_posts_columns', $plugin_admin, 'sas_shop_set_custom_edit_sas_shop_orders_columns' );
		$this->loader->add_action( 'manage_sas_shop_orders_posts_custom_column' , $plugin_admin, 'sas_shop_custom_sas_shop_orders_column', 10, 2 );
		/*
		 *	Load the meta box class and create its hooks:
		 *  - This is defined on Sas_Shop_Admin
				- public static sas_product_metaboxes(){}
				 - this function create a new instance of Sas_Product_Metabox then
				 - Call to CMB_Meta_Box to create all denided meta boxes on the file
				 - admin/class-sas-product-metabox.php
		 */
		$this->loader->add_action( 'init', $plugin_admin, 'sas_product_metaboxes' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'sas_shop_order_metabox_sku' );
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'sas_shop_order_products_metabox' );
		$this->loader->add_action( 'init', $plugin_admin, 'sas_order_metaboxes' );

		/**
		 * This way adds more metaboxes filter 999, 1
		 *
		 */
		//$this->loader->add_filter( 'cmb_meta_boxes', $plugin_admin, 'sas_order_product_metaboxes', 999, 1 );


		$this->loader->add_action( 'init', $plugin_admin, 'sas_shop_orders_remove_post_type_support', 10 );
		$this->loader->add_action( 'init', $plugin_admin, 'sas_shop_create_order_on_new', 10 );

		/**
		* This is an example creating metaboxes from here abobe is an example creating metaboxes from
		* Sas_Shop_Admin
		* First:
		*       - require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sas-product-metabox.php';
		*       - In Sas_Shop_Admin declare a public static function:
							public function sas_product_metaboxes(){
								$sasProductMetabox = new Sas_Product_Metabox($this->plugin_name, $this->version, 'sas_product');
								$meta_boxes = $sasProductMetabox->init_metaboxes();
								new CMB_Meta_Box( $meta_boxes[0] );
							}
				- There is when we call CMB_Meta_Box class for a new instance() of the class itself so we
				avoid to conflict of add_filter('cmb_meta_boxes', array());
		*/
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-sas-taxes-metabox.php';
		$sas_taxes_metaboxes = new Sas_Taxes_Metabox($this->plugin_name, $this->version, 'sas_shop_taxes');
		$arr = $sas_taxes_metaboxes->init_metaboxes();
		new CMB_Meta_Box( $arr[0] );

		//$this->loader->add_action('init', $plugin_admin, 'sas_shop_taxes_remove_post_type_support', 10);



		//Settings
		// Add the options page and menu item.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->plugin_name . '.php' );
		$this->loader->add_action( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		// Built the option page
		$settings_callback = new Sas_Shop_Callback_Helper( $this->plugin_name );
		$settings_sanitization = new Sas_Shop_Sanitization_Helper( $this->plugin_name );
		$plugin_settings = new Sas_Shop_Settings( $this->plugin_name, $settings_callback, $settings_sanitization);
		$this->loader->add_action( 'admin_init' , $plugin_settings, 'register_settings' );

		$plugin_meta_box = new Sas_Shop_Meta_Box( $this->plugin_name );
		$this->loader->add_action( 'load-toplevel_page_' . $this->plugin_name , $plugin_meta_box, 'add_meta_boxes' );

		//THIS DOENT WORK YET
		//$this->loader->add_filter('widget_text', $plugin_admin, 'do_shortcode');



	}


	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {


		$sessionHandler = new Sas_Shop_Session_Handler();

		$plugin_public = new Sas_Shop_Public( $this->get_plugin_name(), $this->get_version() );
		$plugin_accounts = new Sas_Shop_Accounts( $this->get_version(), $this->get_plugin_name() );



		//$this->loader->add_action( 'init', $plugin_public,'sas_shop_register_session');



		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );



		$this->loader->add_action('init', $plugin_accounts, 'sas_shop_prevent_direct_access_to_login', 999 );
		//@TODO UNCOMMENT LATER
		//$this->loader->add_action('init', $plugin_accounts, 'sas_shop_remove_admin_bar');
		//$this->loader->add_action('init' , $plugin_accounts, 'sas_shop_prevent_profile_access');


		//@TODO ver que pasa despues de registrar o en wp-login.php?action=register
		//$this->loader->add_action( 'login_form_register', $plugin_accounts, 'sas_shop_redirect_to_signup' );
		//$this->loader->add_action( 'wp_loaded', $plugin_accounts, 'sas_shop_redirect_to_signup' );

		$this->loader->add_filter('user_contactmethods', $plugin_accounts, 'sas_shop_add_contact_methods', 10, 2 );



		/**
		 * Wrappers of all output HTML generally
		 *
		 * @var mixed
		 * @access public
		 */
		$this->loader->add_filter( 'sas_shop_wrapper_start', $plugin_public, 'sas_shop_include_wrapper_start' );
		$this->loader->add_filter( 'sas_shop_wrapper_pre_loop_args', $plugin_public, 'sas_shop_custom_args_shop_front_page', 999, 1 );
		$this->loader->add_filter( 'sas_shop_wrapper_loop', $plugin_public, 'sas_shop_include_wrapper_loop' );
		$this->loader->add_filter( 'sas_shop_wrapper_no_content', $plugin_public, 'sas_shop_include_wrapper_no_content' );
		$this->loader->add_filter( 'sas_shop_wrapper_end', $plugin_public, 'sas_shop_include_wrapper_end' );

		$this->loader->add_filter( 'sas_shop_wrapper_cart_form', $plugin_public, 'sas_shop_wrapper_cart_form_display' );

		$this->loader->add_filter( 'sas_shop_wrapper_myaccount_form', $plugin_public,'sas_shop_wrapper_myaccount_form_template', 10, 2 );
		$this->loader->add_filter( 'sas_shop_wrapper_myaccount_orders', $plugin_public,'sas_shop_wrapper_myaccount_orders_template', 10, 2 );


		$this->loader->add_filter( 'sas_shop_wrapper_signup_form', $plugin_public, 'sas_shop_wrapper_signup_form_display', 10, 2 );
		$this->loader->add_filter( 'sas_shop_wrapper_mini_signup_form', $plugin_public,'sas_shop_wrapper_mini_signup_form_display', 99, 2);

		$this->loader->add_filter( 'sas_shop_wrapper_login_form', $plugin_public,'sas_shop_wrapper_login_form_template', 101, 2 );
		$this->loader->add_filter( 'sas_shop_wrapper_password_lost_form', $plugin_public, 'sas_shop_wrapper_password_lost_form_display', 10, 2 );

		$this->loader->add_filter( 'sas_shop_wrapper_single_content', $plugin_public, 'sas_shop_wrapper_single_content_display', 10, 2 );
		$this->loader->add_filter( 'sas_shop_wrapper_checkout_form', $plugin_public, 'sas_shop_wrapper_checkout_form_display', 10, 2 );

		$this->loader->add_filter( 'sas_shop_wrapper_order_completed', $plugin_public, 'sas_shop_wrapper_order_completed_display', 10, 1 );

		/**
		 * All our pages overwritten
		 *
		 * @var mixed
		 * @access public
		 */
		$this->loader->add_filter( 'single_template', $plugin_public, 'get_single_template' );

		$this->loader->add_action( 'page_template', $plugin_public, 'get_shop_template');
		$this->loader->add_action( 'page_template', $plugin_public, 'get_cart_template');
		$this->loader->add_action( 'page_template', $plugin_public, 'get_checkout_template');

		$this->loader->add_action( 'page_template', $plugin_public, 'get_myaccount_template');
		$this->loader->add_action( 'page_template', $plugin_public, 'get_signup_template');

		$this->loader->add_action( 'page_template', $plugin_public, 'get_password_lost_template');
		$this->loader->add_action( 'page_template', $plugin_public, 'get_login_template');


		$this->loader->add_action( 'login_form_register', $plugin_accounts, 'sas_shop_redirect_to_signup' );
		//$this->loader->add_action( 'login_form_register', $plugin_accounts, 'sas_shop_do_register_user' );
		/**
		 * Update profile of the user
		 *
		 * @var mixed
		 * @access public
		 */
		$this->loader->add_action( 'sas_shop_update_account_user', $plugin_accounts, 'sas_shop_do_sas_account_user' );




		/**
		 * Filters and actions Login/Logout/Register
		 *
		 * @var mixed
		 * @access public
		 */
		$this->loader->add_filter( 'authenticate', $plugin_accounts, 'sas_shop_maybe_redirect_at_authenticate', 101, 3 );
		$this->loader->add_filter( 'login_redirect', $plugin_accounts, 'sas_shop_redirect_after_login', 10, 3 );

		$this->loader->add_action( 'wp_logout', $plugin_accounts, 'sas_shop_redirect_after_logout' );


		//$this->loader->add_action( 'login_form_login', $plugin_accounts, 'sas_shop_redirect_to_sas_login'  );
		//$this->loader->add_action( 'sas_shop_update_account', $plugin_accounts, 'sas_shop_do_sas_account_user');
		//$this->loader->add_action( 'wp_loaded', $plugin_accounts, 'sas_shop_do_sas_account_user');




		//$this->loader->add_action( 'widgets_init', $plugin_public, 'sas_shop_register_sidebar', 10 );
		//$this->loader->add_filter( 'widget_text', $plugin_public, 'do_shortcode', 11);

		$this->loader->add_shortcode('sas-shop-cart-display', $plugin_public, 'sas_shop_add_to_cart_single_product_process', 10 );

		/**
		 *  The shopping cart stuff
		 *
		 * @var mixed
		 * @access public
		 */
		$this->loader->add_action( 'admin_post_add_to_cart', $plugin_public, 'sas_shop_add_to_cart_single' );
		$this->loader->add_action( 'admin_post_nopriv_add_to_cart', $plugin_public, 'sas_shop_add_to_cart_single' );
		$this->loader->add_action( 'admin_post_update_cart', $plugin_public, 'sas_shop_add_to_cart_single' );
		$this->loader->add_action( 'admin_post_nopriv_update_cart', $plugin_public, 'sas_shop_add_to_cart_single' );

		//$this->loader->add_action( 'sas_shop_add_to_cart_single_product', $plugin_public, 'sas_shop_add_to_cart_single_product_process', 10, 3 );

		$this->loader->add_filter( 'sas_shop_add_to_cart_front_btn_display', $plugin_public, 'sas_shop_add_to_cart_front_btn' );
		$this->loader->add_filter( 'sas_shop_add_to_cart_single_btn_display', $plugin_public, 'sas_shop_add_to_cart_single_btn' );


		// Include the Ajax library on the front end backend
		$this->loader->add_action( 'wp_ajax_sas_shop_update_cart_data', $plugin_public, 'sas_shop_update_cart_data' );
		$this->loader->add_action( 'wp_ajax_nopriv_sas_shop_update_cart_data', $plugin_public, 'sas_shop_update_cart_data' );


		//UNCOMMENT FOR ENABLE SHORTCODES

		//$this->loader->add_shortcode('sas-shop-shop-display', $plugin_public, 'sas_shop_shop_page_shortcode');


	}

	/**
	 * Get the plugin url.
	 *
	 * @access public
	 * @return string
	 */
	public function plugin_url() {
		return untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Get the plugin path.
	 *
	 * @access public
	 * @return string
	 */
	public function plugin_path() {
		return untrailingslashit( plugin_dir_path( dirname( __FILE__ ) ) );
	}

	/**
	 * Get the template path.
	 *
	 * @return string
	 */
	public function template_path() {
		return apply_filters( 'SAS_SHOP_TEMPLATE_PATH', 'sas-shop' );
	}



	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Sas_Shop_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}