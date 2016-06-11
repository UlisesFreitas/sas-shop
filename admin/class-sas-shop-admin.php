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

		wp_enqueue_style( $this->plugin_name.'-chosen-css', plugin_dir_url( __FILE__ ) . 'css/chosen.css', array(), $this->version, 'all' );


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

		wp_enqueue_script( $this->plugin_name.'-chosen-ajax', plugin_dir_url( __FILE__ ) . 'js/chosen/ajax-chosen.jquery.min.js', array( 'jquery', $this->plugin_name.'-chosen-js' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name.'-chosen-js', plugin_dir_url( __FILE__ ) . 'js/chosen/chosen.jquery.min.js', array( 'jquery' ), $this->version, false );
		// Chosen RTL
		if ( is_rtl() ) {
			wp_enqueue_script( $this->plugin_name.'-chosen-rtl', plugin_dir_url( __FILE__ ) . 'js/chosen/chosen-rtl.min.js', array( 'jquery' ), $this->version, false );
		}

		wp_enqueue_script( $this->plugin_name.'-settings', plugin_dir_url( __FILE__ ) . 'js/settings.js', array( 'jquery', $this->plugin_name.'-chosen-js' ), $this->version, false );

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

		$general_tab = Sas_Shop_Settings_Definition::get_general_tab_slug();

		$active_tab = isset( $_GET[ 'tab' ] ) && array_key_exists( $_GET['tab'], $tabs ) ? $_GET[ 'tab' ] : $general_tab;

		include_once( 'partials/' . $this->plugin_name . '-admin-display.php' );

	}

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

		add_menu_page(
			__( 'SAS Shop', $this->plugin_name ),
			__( 'SAS Shop', $this->plugin_name ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_plugin_admin_page' ),
			'dashicons-cart',
			25
			);

		//add_submenu_page($this->plugin_name , __( 'Products', $this->plugin_name ), __( 'Products', $this->plugin_name ), 'manage_options', 'edit.php?post_type=sas_product', NULL );
		add_submenu_page($this->plugin_name , __( 'Orders', $this->plugin_name ), __( 'Orders', $this->plugin_name ), 'manage_options', 'edit.php?post_type=sas_shop_orders', NULL );
		add_submenu_page($this->plugin_name , __( 'Settings', $this->plugin_name ), __( 'Settings', $this->plugin_name ), 'manage_options', 'admin.php?page=sas-shop', NULL );


		remove_submenu_page( $this->plugin_name, $this->plugin_name );


	}

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
			'show_in_menu'          => true,
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


		$args = array(
			'label'                 => __( 'Order', 'sas-shop' ),
			'description'           => __( 'All SAS Shop Orders', 'sas-shop' ),
			'labels'                => $labels,
			'supports'              => array( 'title' ),
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
			'publicly_queryable'    => false,
			'rewrite'               => true,
			'capabillity_type'      => 'post',
			'capabilities' => array(
				'create_posts' => false,),
			'map_meta_cap' => true,

		);
		register_post_type( 'sas_shop_orders', $args );
		flush_rewrite_rules();
	}


	public function sas_shop_order_metabox_sku(){
    	add_meta_box( 'field-order-sku', 'Order Details', array(&$this,'sas_shop_order_sku_display_meta'), 'sas_shop_orders', 'normal', 'high' );
	}
	public function sas_shop_order_sku_display_meta(){
		global $post;
		echo $post->post_title;
	}

	public function sas_shop_order_products_metabox(){

		global $post;
		$productsIDs    = get_post_meta( $post->ID, 'field-order-product-id', false );
		if(count($productsIDs) > 0){

			add_meta_box( 'field-order-products-list', 'Order Products', array(&$this,'sas_shop_order_products_list_display'), 'sas_shop_orders', 'normal', 'low' );
		}

	}
	public function sas_shop_order_products_list_display(){

		global $post;

		$currencySymbol = Sas_Shop_Settings_Definition::get_sas_shop_currency_symbol( Sas_Shop_Option::get_option( 'sas_shop_currency' ) );
		$grand_total    = 0;
		$totalTaxes     = 0;
		$shipping       = get_post_meta( $post->ID, 'field-order-shipping', true );
		$productsIDs    = get_post_meta( $post->ID, 'field-order-product-id', false );

		$totalOrderQty  = 0;

		if($shipping == 'free_shipping'){
			$shippingName = Sas_Shop_Option::get_option( 'shipping_free_name' );
		}
		if($shipping == 'flat_shipping'){
			$shippingName = Sas_Shop_Option::get_option( 'shipping_flat_name' );
			$shippingPrice = Sas_Shop_Option::get_option( 'shipping_flat_price' );
			$shippingTax   = Sas_shop_Option::get_option( 'shipping_flat_tax' );
		}


		if( count( $productsIDs ) > 0 ){
			echo '<style type="text/css">
.sas-shop-order-table-meta  {border-collapse:collapse;border-spacing:0;border-color:#ccc;border:none;margin:0px auto;width:100%;}
.sas-shop-order-table-meta td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
.sas-shop-order-table-meta th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0; text-align: justify;}
@media screen and (max-width: 767px) {.sas-shop-order-table-meta {width: auto !important;}.sas-shop-order-table-meta col {width: auto !important;}.sas-shop-order-table-meta-wrap {overflow-x: auto;-webkit-overflow-scrolling: touch;margin: auto 0px;}}</style>
';
			echo '<div class="sas-shop-order-wrap"><table class="sas-shop-order-table-meta">
					  <tr>
					  	<th>Image</th>
					    <th colspan="3">Product</th>
					    <th>COST</th>
					    <th>QTY</th>
					    <th>TOTAL</th>
					    <th>VAT</th>
					  </tr>';
			foreach( $productsIDs as $key => $productID ){

			$product       =  get_post($productID);
			//$productSKU    =  get_post_meta( $productID ,'field-product-sku' , true);
			$productPrice  =  get_post_meta( $productID ,'field-product-price' , true);

			$productTax    =  get_post_meta( $productID ,'field-sas-product-taxes' , true);
			$productQty    =  get_post_meta( $post->ID ,'field-order-product-' . $productID . '-qty' , true);
			//$total         = $productQty * $productPrice;

			$totalOrderQty += $productQty;

			$total = $productPrice * $productQty;
			$total = Sas_Shop_Core_Helpers::sas_shop_format_decimal( $total, Sas_Shop_Option::get_option( 'sas_shop_price_num_decimals' ) );

			$totalTax      = round( ( ( $productPrice * $productQty ) * ( $productTax / 100 ) ) , 2 );

			echo '<tr>
					<td>' . get_the_post_thumbnail( $productID, array( 24, 24) ) . '</td>
					<td colspan="3"><a href="'. admin_url('post.php?post=' . $productID . '&action=edit') . '">' . $product->post_title . '</a></td>
				    <td>' . $productPrice . ' ' . $currencySymbol . '</td>
				    <td>' . $productQty . '</td>
				    <td>' . $total . ' ' . $currencySymbol . '</td>
				    <td>' . $totalTax . '</td>
				  </tr>';


			$totalTaxes = $totalTaxes + $totalTax;
			$grand_total = $grand_total + $total;
			}

			$totalShippingPrice = $shippingPrice * $totalOrderQty;
			$totalShippingTax   = round( ( $totalShippingPrice * ( $shippingTax / 100 ) ) , 2 );

			$grand_total = $grand_total + $totalShippingPrice + $totalTaxes + $totalShippingTax;

			//$totalTaxes = $totalTaxes - $totalShippingTax;




			echo '<tr>

					<td>Shipping</td>
					<td colspan="5">' . $shippingName . '</td>
					<td>' . $totalShippingPrice . ' ' .$currencySymbol . '</td>
					<td>' . $totalShippingTax . ' ' . $currencySymbol . '</td>
					</tr>';

			echo '<tr>
					<td colspan="6"></td>
					<td>VAT</td>
					<td>' . $totalTaxes . ' ' . $currencySymbol . '</td>
					</tr>';
			echo '<tr>

					<td colspan="6"></td>
					<td>Total</td>
					<td>' . $grand_total . ' ' . $currencySymbol . '</td>
				  </tr>';
			echo '</table></div>';
		}

	}

	public function sas_shop_create_order_on_new(){

		if( 'GET' == $_SERVER['REQUEST_METHOD'] && $_SERVER['REQUEST_URI']  == '/wp-admin/post-new.php?post_type=sas_shop_orders'){


			if( current_user_can( 'administrator' ) ){

				$my_post = array(
					'post_title'   => 'Order',
					'post_content' => 'New order',
					'post_status'  => 'draft',
					'post_author'  => get_current_user_id(),
					'post_type'    => 'sas_shop_orders'
				);

				$post_id = wp_insert_post($my_post);

				if (is_wp_error($post_id)) {
					$errors = $post_id->get_error_messages();
					foreach ($errors as $error) {
						echo $error;
					}
				}else{
					$my_post = array(
						'ID'           => $post_id,
						'post_title'   => 'Order #'.$post_id,
						//'post_content' => '',
					);
					$post_id = wp_update_post( $my_post );
					if (is_wp_error($post_id)) {
						$errors = $post_id->get_error_messages();
						foreach ($errors as $error) {
							echo $error;
						}
					}else{


						$ssl = is_ssl();
						if($ssl == 1){
							wp_redirect( admin_url('post.php?post=' . $post_id . '&action=edit', 'https' ) );
						}else{
							wp_redirect( admin_url('post.php?post=' . $post_id . '&action=edit', 'http' ) );
						}

					}
				}





			}


/*
			Array
(
    [SERVER_SOFTWARE] =&gt; Apache/2.4.10 (Unix) PHP/5.3.29 mod_wsgi/3.4 Python/2.7.6 OpenSSL/1.0.1h
    [REQUEST_URI] =&gt;
    [TMP] =&gt; /Applications/AMPPS/tmp
    [HTTP_HOST] =&gt; unitedshop
    [HTTP_CONNECTION] =&gt; keep-alive
    [HTTP_CACHE_CONTROL] =&gt; max-age=0

    [HTTP_UPGRADE_INSECURE_REQUESTS] =&gt; 1
    [HTTP_USER_AGENT] =&gt; Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36
    [HTTP_REFERER] =&gt; http://unitedshop/wp-admin/edit.php?post_type=sas_shop_orders
    [HTTP_ACCEPT_ENCODING] =&gt; gzip, deflate, sdch
    [HTTP_ACCEPT_LANGUAGE] =&gt; es,en;q=0.8,gl;q=0.6
    [HTTP_COOKIE] =&gt; wordpress_7cbd6f88a1366af35c61c1c4a1e11868=Ulises%7C1465610446%7COMtdwoA8t421RkBxGYKUyvDjVVV4TXERUV9uOxGeclk%7C72216ea2b91fc7f43b928660c728f917873ab3f93a2e1d7fd2a8661303daab76; PHPSESSID=tu369l5r8ppc273jmtbnhltc73; wordpress_test_cookie=WP+Cookie+check; wordpress_logged_in_7cbd6f88a1366af35c61c1c4a1e11868=Ulises%7C1465610446%7COMtdwoA8t421RkBxGYKUyvDjVVV4TXERUV9uOxGeclk%7C576302735677b5bdf81c432c1394d8247a50a89b6196e23fe5ea0ea286d1d8e1; wp-settings-1=libraryContent%3Dbrowse%26imgsize%3Dthumbnail; wp-settings-time-1=1465437654
    [PATH] =&gt; /usr/bin:/bin:/usr/sbin:/sbin
    [SERVER_SIGNATURE] =&gt;
    [SERVER_NAME] =&gt; unitedshop
    [SERVER_ADDR] =&gt; 127.0.0.1
    [SERVER_PORT] =&gt; 80
    [REMOTE_ADDR] =&gt; 127.0.0.1
    [DOCUMENT_ROOT] =&gt; /Applications/AMPPS/www/unitedshop
    [REQUEST_SCHEME] =&gt; http
    [CONTEXT_PREFIX] =&gt;
    [CONTEXT_DOCUMENT_ROOT] =&gt; /Applications/AMPPS/www/unitedshop
    [SERVER_ADMIN] =&gt; admin@localhost
    [SCRIPT_FILENAME] =&gt; /Applications/AMPPS/www/unitedshop/wp-admin/post-new.php
    [REMOTE_PORT] =&gt; 50291
    [GATEWAY_INTERFACE] =&gt; CGI/1.1
    [SERVER_PROTOCOL] =&gt; HTTP/1.1
    [REQUEST_METHOD] =&gt; GET
    [QUERY_STRING] =&gt; post_type=sas_shop_orders
    [SCRIPT_NAME] =&gt; /wp-admin/post-new.php
    [PHP_SELF] =&gt; /wp-admin/post-new.php
    [REQUEST_TIME] =&gt; 1465440732
)
*/

		}
	}
	public function sas_shop_orders_remove_post_type_support() {
    	remove_post_type_support( 'sas_shop_orders', 'title' );
	}

	public static function sas_shop_taxes_remove_post_type_support() {
    	remove_post_type_support( 'sas_shop_taxes', 'title' );
		remove_post_type_support( 'sas_shop_taxes', 'editor' );
	}


	/*
	 * Register Custom Taxonomy
	 * @since    1.0.0
	 */
	public function sas_product_taxonomy_type() {

		$labels = array(
			'name'                       => _x( 'Category', 'Taxonomy General Name', 'sas-shop' ),
			'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'sas-shop' ),
			'menu_name'                  => __( 'Categories', 'sas-shop' ),
			'all_items'                  => __( 'All categories of product', 'sas-shop' ),
			'parent_item'                => __( 'Parent Item', 'sas-shop' ),
			'parent_item_colon'          => __( 'Parent Item:', 'sas-shop' ),
			'new_item_name'              => __( 'New Category', 'sas-shop' ),
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
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'query_var'                  => 'sas_product_category',
		);
		register_taxonomy( 'sas_product_category', array( 'sas_product' ), $args );

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

	public function sas_order_product_metaboxes(){
		global $post;
		global $wp_meta_boxes;

		$sasOrderMetabox = new Sas_Order_Metabox($this->plugin_name, $this->version, 'sas_shop_orders');
		$meta_boxes = $sasOrderMetabox->init_order_products_metaboxes();

		new CMB_Meta_Box( $meta_boxes[0] );


	}
	public function sas_order_metaboxes(){



		$sasOrderMetabox = new Sas_Order_Metabox($this->plugin_name, $this->version, 'sas_shop_orders');
		$meta_boxes = $sasOrderMetabox->init_metaboxes();

		foreach($meta_boxes as $metabox){
			new CMB_Meta_Box( $metabox );
		}





	}

	/**
	 * Create a page and store the ID in an option.
	 *
	 * @access public
	 * @since 1.0.0
	 * @param mixed $slug Slug for the new page
	 * @param mixed $option Option name to store the page's ID
	 * @param string $page_title (default: '') Title for the new page
	 * @param string $page_content (default: '') Content for the new page
	 * @param int $post_parent (default: 0) Parent for the new page
	 * @return int page ID
	 */
	public function sas_shop_create_page( $slug, $option = '', $page_title = '', $page_content = '', $post_parent = 0 ) {

		global $wpdb;

		$option_value = get_option( $option );

		if ( $option_value > 0 && get_post( $option_value ) )
			return -1;

		$page_found = null;

		if ( strlen( $page_content ) > 0 ) {
			// Search for an existing page with the specified page content (typically a shortcode)
			$page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_type='page' AND post_content LIKE %s LIMIT 1;", "%{$page_content}%" ) );
		}
		else {
			// Search for an existing page with the specified page slug
			$page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM " . $wpdb->posts . " WHERE post_type='page' AND post_name = %s LIMIT 1;", $slug ) );
		}

		if ( $page_found ) {
			if ( ! $option_value ) {
				update_option( $option, $page_found );
			}

			return $page_found;
		}

		$page_data = array(
			'post_status'       => 'publish',
			'post_type'         => 'page',
			'post_author'       => 1,
			'post_name'         => $slug,
			'post_title'        => $page_title,
			'post_content'      => $page_content,
			'post_parent'       => $post_parent,
			'comment_status'    => 'closed',
			'ping_status'    => 'closed'
		);

		$page_id = wp_insert_post( $page_data );

		if ( $option ) {
			update_option( $option, $page_id );
		}

		return $page_id;
	}



	/**
	 * sas_shop_add_thumbnail_size function.
	 *
	 * @access public
	 * @return void
	 */
	public function sas_shop_add_thumbnail_size(){

		if ( function_exists( 'add_image_size' ) ) {

			add_image_size( 'sas-shop-product-thumbnail', 300, 300, array( 'center', 'center' ) ); // Hard crop center center
		}
	}
	public function sas_shop_image_sizes( $sizes ) {
	    return array_merge( $sizes, array(
	        'sas-shop-product-thumbnail' => __('Sas Shop Thumbnail'),
	    ) );
	}



}