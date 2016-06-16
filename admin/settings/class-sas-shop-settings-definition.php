<?php
/**
 *
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Sas_Shop
 * @subpackage Sas_Shop/includes
 */

/**
 * The Settings definition of the plugin.
 *
 *
 * @package    Sas_Shop
 * @subpackage Sas_Shop/includes
 * @author     Your Name <email@example.com>
 */
class Sas_Shop_Settings_Definition {


	public static $plugin_name = 'sas-shop';

	/**
	 * [apply_tab_slug_filters description]
	 *
	 * @param  array $default_settings [description]
	 *
	 * @return array                   [description]
	 */
	static private function apply_tab_slug_filters( $default_settings ) {

		$extended_settings[] = array();
		$extended_tabs       = self::get_tabs();

		foreach ( $extended_tabs as $tab_slug => $tab_desc ) {

			$options = isset( $default_settings[ $tab_slug ] ) ? $default_settings[ $tab_slug ] : array();

			$extended_settings[ $tab_slug ] = apply_filters( 'sas_shop_settings_' . $tab_slug, $options );
		}

		return $extended_settings;
	}

	/**
	 * [get_general_tab_slug description]
	 * @return [type] [description]
	 */
	static public function get_general_tab_slug() {

		return key( self::get_tabs() );
	}

	/**
	 * Retrieve settings tabs
	 *
	 * @since    1.0.0
	 * @return    array    $tabs    Settings tabs
	 */
	static public function get_tabs() {

		$tabs                = array();
		$tabs['general_tab'] = __( 'General', self::$plugin_name );
		$tabs['pages_tab']  = __( 'Pages', self::$plugin_name );
		$tabs['accounts_tab']  = __( 'Accounts', self::$plugin_name );
		$tabs['taxes_tab']  = __( 'Taxes', self::$plugin_name );
		$tabs['shipping_tab']  = __( 'Shipping', self::$plugin_name );
		$tabs['payments_tab']  = __( 'Payments', self::$plugin_name );

		return apply_filters( 'sas_shop_settings_tabs', $tabs );
	}

	public static function get_currency_dropdown() {

        $county_array_result = array(
            'AED' => __('United Arab Emirates Dirham', self::$plugin_name),
            'ARS' => __('Argentine Peso', self::$plugin_name),
            'AUD' => __('Australian Dollars', self::$plugin_name),
            'BDT' => __('Bangladeshi Taka', self::$plugin_name),
            'BRL' => __('Brazilian Real', self::$plugin_name),
            'BGN' => __('Bulgarian Lev', self::$plugin_name),
            'CAD' => __('Canadian Dollars', self::$plugin_name),
            'CLP' => __('Chilean Peso', self::$plugin_name),
            'CNY' => __('Chinese Yuan', self::$plugin_name),
            'COP' => __('Colombian Peso', self::$plugin_name),
            'CZK' => __('Czech Koruna', self::$plugin_name),
            'DKK' => __('Danish Krone', self::$plugin_name),
            'DOP' => __('Dominican Peso', self::$plugin_name),
            'EUR' => __('Euros', self::$plugin_name),
            'HKD' => __('Hong Kong Dollar', self::$plugin_name),
            'HRK' => __('Croatia kuna', self::$plugin_name),
            'HUF' => __('Hungarian Forint', self::$plugin_name),
            'ISK' => __('Icelandic krona', self::$plugin_name),
            'IDR' => __('Indonesia Rupiah', self::$plugin_name),
            'INR' => __('Indian Rupee', self::$plugin_name),
            'NPR' => __('Nepali Rupee', self::$plugin_name),
            'ILS' => __('Israeli Shekel', self::$plugin_name),
            'JPY' => __('Japanese Yen', self::$plugin_name),
            'KIP' => __('Lao Kip', self::$plugin_name),
            'KRW' => __('South Korean Won', self::$plugin_name),
            'MYR' => __('Malaysian Ringgits', self::$plugin_name),
            'MXN' => __('Mexican Peso', self::$plugin_name),
            'NGN' => __('Nigerian Naira', self::$plugin_name),
            'NOK' => __('Norwegian Krone', self::$plugin_name),
            'NZD' => __('New Zealand Dollar', self::$plugin_name),
            'PYG' => __('Paraguayan Guaraní', self::$plugin_name),
            'PHP' => __('Philippine Pesos', self::$plugin_name),
            'PLN' => __('Polish Zloty', self::$plugin_name),
            'GBP' => __('Pounds Sterling', self::$plugin_name),
            'RON' => __('Romanian Leu', self::$plugin_name),
            'RUB' => __('Russian Ruble', self::$plugin_name),
            'SGD' => __('Singapore Dollar', self::$plugin_name),
            'ZAR' => __('South African rand', self::$plugin_name),
            'SEK' => __('Swedish Krona', self::$plugin_name),
            'CHF' => __('Swiss Franc', self::$plugin_name),
            'TWD' => __('Taiwan New Dollars', self::$plugin_name),
            'THB' => __('Thai Baht', self::$plugin_name),
            'TRY' => __('Turkish Lira', self::$plugin_name),
            'UAH' => __('Ukrainian Hryvnia', self::$plugin_name),
            'USD' => __('US Dollars', self::$plugin_name),
            'VND' => __('Vietnamese Dong', self::$plugin_name),
            'EGP' => __('Egyptian Pound', self::$plugin_name)
        );

        foreach ($county_array_result as $code => $name) {
            $county_array_result[$code] = $name . ' (' . self::get_sas_shop_currency_symbol($code) . ')';
        }
        return $county_array_result;
    }

    public static function get_sas_shop_currency_symbol($currency = '') {

        $currency_symbol = "";
        switch ($currency) {
            case 'AED' :
                $currency_symbol = 'د.إ';
                break;
            case 'AUD' :
            case 'ARS' :
            case 'CAD' :
            case 'CLP' :
            case 'COP' :
            case 'HKD' :
            case 'MXN' :
            case 'NZD' :
            case 'SGD' :
            case 'USD' :
                $currency_symbol = '&#36;';
                break;
            case 'BDT':
                $currency_symbol = '&#2547;&nbsp;';
                break;
            case 'BGN' :
                $currency_symbol = '&#1083;&#1074;.';
                break;
            case 'BRL' :
                $currency_symbol = '&#82;&#36;';
                break;
            case 'CHF' :
                $currency_symbol = '&#67;&#72;&#70;';
                break;
            case 'CNY' :
            case 'JPY' :
            case 'RMB' :
                $currency_symbol = '&yen;';
                break;
            case 'CZK' :
                $currency_symbol = '&#75;&#269;';
                break;
            case 'DKK' :
                $currency_symbol = 'DKK';
                break;
            case 'DOP' :
                $currency_symbol = 'RD&#36;';
                break;
            case 'EGP' :
                $currency_symbol = 'EGP';
                break;
            case 'EUR' :
                $currency_symbol = '&euro;';
                break;
            case 'GBP' :
                $currency_symbol = '&pound;';
                break;
            case 'HRK' :
                $currency_symbol = 'Kn';
                break;
            case 'HUF' :
                $currency_symbol = '&#70;&#116;';
                break;
            case 'IDR' :
                $currency_symbol = 'Rp';
                break;
            case 'ILS' :
                $currency_symbol = '&#8362;';
                break;
            case 'INR' :
                $currency_symbol = 'Rs.';
                break;
            case 'ISK' :
                $currency_symbol = 'Kr.';
                break;
            case 'KIP' :
                $currency_symbol = '&#8365;';
                break;
            case 'KRW' :
                $currency_symbol = '&#8361;';
                break;
            case 'MYR' :
                $currency_symbol = '&#82;&#77;';
                break;
            case 'NGN' :
                $currency_symbol = '&#8358;';
                break;
            case 'NOK' :
                $currency_symbol = '&#107;&#114;';
                break;
            case 'NPR' :
                $currency_symbol = 'Rs.';
                break;
            case 'PHP' :
                $currency_symbol = '&#8369;';
                break;
            case 'PLN' :
                $currency_symbol = '&#122;&#322;';
                break;
            case 'PYG' :
                $currency_symbol = '&#8370;';
                break;
            case 'RON' :
                $currency_symbol = 'lei';
                break;
            case 'RUB' :
                $currency_symbol = '&#1088;&#1091;&#1073;.';
                break;
            case 'SEK' :
                $currency_symbol = '&#107;&#114;';
                break;
            case 'THB' :
                $currency_symbol = '&#3647;';
                break;
            case 'TRY' :
                $currency_symbol = '&#8378;';
                break;
            case 'TWD' :
                $currency_symbol = '&#78;&#84;&#36;';
                break;
            case 'UAH' :
                $currency_symbol = '&#8372;';
                break;
            case 'VND' :
                $currency_symbol = '&#8363;';
                break;
            case 'ZAR' :
                $currency_symbol = '&#82;';
                break;
            default :
                $currency_symbol = '';
                break;
        }
        return $currency_symbol;
    }

    public static function get_page_list_dropdown() {
        try {
            $pages = get_pages();
            $result = array();
            $result['page'] = 'Select a page';
            foreach ($pages as $page) {
                $result[$page->ID] = $page->post_title;
            }
            return $result;
        } catch (Exception $ex) {

        }
    }


	/**
	 * 'Whitelisted' Sas_Shop settings, filters are provided for each settings
	 * section to allow extensions and other plugins to add their own settings
	 *
	 *
	 * @since    1.0.0
	 * @return    mixed    $value    Value saved / $default if key if not exist
	 */
	static public function get_settings() {


		$settings[] = array();
		$countries = new Sas_Shop_Countries();

		$settings = array(
			'general_tab' => array(

				'sas_shop_email_manager_name'                       => array(
					'name' => __( 'Shop name or Brand name for emails', self::$plugin_name ),
					'type' => 'text'
				),
				'sas_shop_email_manager'                       => array(
					'name' => __( 'Shop Email Manager', self::$plugin_name ),
					'type' => 'text'
				),
				'sas_shop_location_address'                       => array(
					'name' => __( 'Shop Address', self::$plugin_name ),
					'type' => 'textarea'
				),
				'single_select_country' => array(
					'name' => __( 'Shop Country', self::$plugin_name ),
					'options' => $countries->country_dropdown_options(),
					'type' => 'countries'
				),

				'sas_shop_location_phone'                       => array(
					'name' => __( 'Shop Phone', self::$plugin_name ),
					'type' => 'text'
				),

				'sas_shop_currency'                     => array(
					'name'    => __( 'Currency', self::$plugin_name ),
					'options' => self::get_currency_dropdown(),
					'type'    => 'select'
				),
				'sas_shop_price_decimal_sep'                       => array(
					'name' => __( 'Price decimal separator', self::$plugin_name ),
					'type' => 'text',
					'std'  => '.'
				),
				'sas_shop_price_num_decimals'                       => array(
					'name' => __( 'Price number of decimals', self::$plugin_name ),
					'type' => 'number',
					'std'  => '2'
				),


			),

			'pages_tab'  => array(
				'sas_shop_product_show_qty_front' => array(
					'name' => __( 'Products qty on front', self::$plugin_name ),
					'desc' => __( 'Set the number of products to display on Shop front page', self::$plugin_name ),
					'type' => 'number',
					'std'     => '8'
				),
				'sas_shop_page_shop' => array(
					'name'    => __( 'Shop page', self::$plugin_name ),
					'desc'    => __( 'Select a page to display the Shop font pages', self::$plugin_name ),
					'options' => self::get_page_list_dropdown(),
					'type'    => 'select'
				),
				'sas_shop_page_cart' => array(
					'name'    => __( 'Shop Cart page', self::$plugin_name ),
					'desc'    => __( 'Select a page to display the Shop Cart', self::$plugin_name ),
					'options' => self::get_page_list_dropdown(),
					'type'    => 'select'
				),
				'sas_shop_page_checkout' => array(
					'name'    => __( 'Shop Checkout page', self::$plugin_name ),
					'desc'    => __( 'Select a page to display the Shop Checkout', self::$plugin_name ),
					'options' => self::get_page_list_dropdown(),
					'type'    => 'select'
				),

			),

			'accounts_tab'  => array(

				'sas_shop_page_my_account' => array(
					'name'    => __( 'My Account page', self::$plugin_name ),
					'desc'    => __( 'Select a page to display the Shop My Account', self::$plugin_name ),
					'options' => self::get_page_list_dropdown(),
					'type'    => 'select'
				),
				'sas_shop_page_login' => array(
					'name'    => __( 'User/Customer Login page', self::$plugin_name ),
					'desc'    => __( 'Select a page to display the Shop Login(User/Customer)', self::$plugin_name ),
					'options' => self::get_page_list_dropdown(),
					'type'    => 'select'
				),


			),
			);

			$taxes_settings = array(
			'taxes_tab'  => array(
				'sas_shop_enable_taxes'                   => array(
					'name' => __( 'Enable Taxes', self::$plugin_name ),
					'desc' => __( 'Enable taxes on all SAS Shop', self::$plugin_name ),
					'type' => 'checkbox'
				),
			),
			);

			if(Sas_Shop_Option::get_option('sas_shop_enable_taxes') == 1){


			$taxes_enabled = array(
				'sas_shop_prices_with_tax'                      => array(
					'name'    => __( 'Prices and Taxes', self::$plugin_name ),
					'desc'    => __( 'How to show prices', self::$plugin_name ),
					'options' => array(
						'sas-shop-prices-with-tax'   => __( "Show prices with tax included", self::$plugin_name ),
						'sas-shop-prices-without-tax' => __( "Show prices without taxes", self::$plugin_name )
					),
					'type'    => 'radio'
				),
				'sas_shop_tax_sufix_included' => array(
					'name' => __( 'Tax sufix included', self::$plugin_name ),
					'type' => 'text',
					'std'  => 'Tax Included.'
				),
				'sas_shop_tax_sufix_excluded' => array(
					'name' => __( 'Tax sufix excluded', self::$plugin_name ),
					'type' => 'text',
					'std'  => 'Without Tax.'
				),
				'sas_get_current_taxes'       => array(
					'name'   => __( 'Current Taxes', self::$plugin_name ),
					'type'   => 'current_taxes',
					'options' => array(
						array('text' => array( 'class' => '', 'description' => '', 'id' => 'tax_name', 'label' => 'Tax Name', 'name' =>  'tax_name', 'placeholder' => 'Tax name like I.V.A', 'type' => 'text', 'value' => '' ) ),
						array('text' => array( 'class' => '', 'description' => '', 'id' => 'tax_rate', 'label' => 'Tax Rate', 'name' => 'tax_rate', 'placeholder' => 'Tax rate like 21.00', 'type' => 'text', 'value' => '' ) ),
						array('text' => array( 'class' => '', 'description' => '', 'id' => 'tax_country', 'label' => 'Tax Region', 'name' => 'tax_country', 'placeholder' => 'Tax region like ES', 'type' => 'text', 'value' => '' ) )

					),
				),



				);
			}
			//),
			$shipping_settings = array(
				'shipping_tab'  => array(
					'sas_shop_enable_shipping' => array(
						'name' => __( 'Enable Shipping', self::$plugin_name ),
						'desc' => __( 'Enable shipping on SAS Shop', self::$plugin_name ),
						'type' => 'checkbox'
					),
				),

			);
			if(Sas_Shop_Option::get_option('sas_shop_enable_shipping') == 1){
				$shipping_enabled = array(
					'shipping_select_country' => array(
						'name' => __( 'Shipping Country', self::$plugin_name ),
						'options' => $countries->country_dropdown_options(),
						'type' => 'countries'
					),

					'shipping_free_header'       => array(
						'name' => '<strong>' . __( 'Free Shipping', self::$plugin_name ) . '</strong>',
						'type' => 'header'
					),
					'shipping_free_enabled'                   => array(
						'name' => __( 'Enable this method', self::$plugin_name ),
						'desc' => __( 'Check this to enable Free Shipping', self::$plugin_name ),
						'type' => 'checkbox'
					),
					'shipping_free_name' => array(
						'name' => __( 'Method name', self::$plugin_name ),
						'desc' => __( 'Free for all kind of shipping products', self::$plugin_name ),
						'type' => 'text',
						'std'  => 'Free Shipping'
					),

					'shipping_flat_header'       => array(
						'name' => '<strong>' . __( 'Flat Shipping', self::$plugin_name ) . '</strong>',
						'type' => 'header'
					),
					'shipping_flat_enabled'                   => array(
						'name' => __( 'Enable this method', self::$plugin_name ),
						'desc' => __( 'Check this to enable Flat Shipping', self::$plugin_name ),
						'type' => 'checkbox'
					),
					'shipping_flat_name' => array(
						'name' => __( 'Method name', self::$plugin_name ),
						'desc' => __( 'Flat shipping one price for all kind of shipping products', self::$plugin_name ),
						'type' => 'text',
						'std'  => 'Flat Shipping'
					),
					'shipping_flat_price' => array(
						'name' => __( 'Price', self::$plugin_name ),
						'desc' => __( 'Flat same price for all shippings', self::$plugin_name ),
						'type' => 'text',
						'std'  => '1.00'
					),
					'shipping_flat_tax' => array(
						'name' => __( 'Tax ', self::$plugin_name ),
						'desc' => __( 'Tax to aplly on this method', self::$plugin_name ),
						'type' => 'text',
						'std'  => '21.00'
					),
				);
			}
			$payments_settings = array(
				'payments_tab'  => array(

					'sas_shop_bank_header'       => array(
						'name' => '<strong>' . __( 'Bank Transfer Method', self::$plugin_name ) . '</strong>',
						'type' => 'header'
					),
					'sas_shop_bank_payments' => array(
						'name' => __( 'Enable Bank transfer', self::$plugin_name ),
						'desc' => __( 'Enable bank transfer on SAS Shop', self::$plugin_name ),
						'type' => 'checkbox'
					),

					'sas_shop_bank_method_name'                       => array(
						'name' => __( 'Method name', self::$plugin_name ),
						'std'  => __('Bank transfer', self::$plugin_name),
						'type' => 'text'
					),
					'sas_shop_bank_description'                       => array(
						'name' => __( 'Description', self::$plugin_name ),
						'std'  => __('Make your payment directly into our bank account. Please use the reference order as payment reference.', self::$plugin_name),
						'type' => 'textarea'
					),
					'sas_shop_bank_name'                       => array(
						'name' => __( 'Bank name', self::$plugin_name ),
						'std'  => __('My Bank name Inc.', self::$plugin_name),
						'type' => 'text'
					),
					'sas_shop_bank_account'                       => array(
						'name' => __( 'Bank account number', self::$plugin_name ),
						'std'  => __('ES1020903200500041045040', self::$plugin_name),
						'type' => 'text'
					),
					'sas_shop_cod_header'       => array(
						'name' => '<strong>' . __( 'Cash on delivery Method', self::$plugin_name ) . '</strong>',
						'type' => 'header'
					),
					'sas_shop_cod_payments' => array(
						'name' => __( 'Enable cash on delivery', self::$plugin_name ),
						'desc' => __( 'Enable cash on delivery on SAS Shop', self::$plugin_name ),
						'type' => 'checkbox'
					),
					'sas_shop_cod_method_name'                       => array(
						'name' => __( 'Method name', self::$plugin_name ),
						'std'  => __('Cash on delivery', self::$plugin_name),
						'type' => 'text'
					),
					'sas_shop_cod_description'                       => array(
						'name' => __( 'Description', self::$plugin_name ),
						'std'  => __('Make your payment on product delivery', self::$plugin_name),
						'type' => 'textarea'
					),
				),
			);

		$settings = array_merge($settings, $taxes_settings);
		$settings = array_merge($settings, $shipping_settings);
		if(Sas_Shop_Option::get_option('sas_shop_enable_taxes') == 1){
			$settings['taxes_tab'] = array_merge($settings['taxes_tab'],$taxes_enabled);
		}
		if(Sas_Shop_Option::get_option('sas_shop_enable_shipping') == 1){
			$settings['shipping_tab'] = array_merge($settings['shipping_tab'],$shipping_enabled);
		}
		$settings = array_merge($settings, $payments_settings);
		//echo '<pre>';
		//print_r($settings);
		//echo '</pre>';
		//exit;


		return self::apply_tab_slug_filters( $settings );
	}
}