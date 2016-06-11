<?php
/**
 * Gravitation Shop countries
 *
 * The Gravitation Shop countries class stores country/state data.
 *
 * @class 		Gravitation_Shop_Countries
 * @version		1.0.0
 * @package		Gravitation Shop/Classes
 * @category	Class
 * @author 		UlisesFreitas
 */
class Sas_Shop_Countries {

	/** @var array Array of countries */
	public $countries;

	/** @var array Array of states */
	public $states;

	/** @var array Array of locales */
	public $locale;

	/** @var array Array of address formats for locales */
	public $address_formats;

	/**
	 * Constructor for the counties class - defines all countries and states.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		global $sas_shop, $states;

		$this->countries = apply_filters( 'sas_shop_countries', array(
			'AF' => __( 'Afghanistan', 'sas-shop' ),
			'AX' => __( '&#197;land Islands', 'sas-shop' ),
			'AL' => __( 'Albania', 'sas-shop' ),
			'DZ' => __( 'Algeria', 'sas-shop' ),
			'AD' => __( 'Andorra', 'sas-shop' ),
			'AO' => __( 'Angola', 'sas-shop' ),
			'AI' => __( 'Anguilla', 'sas-shop' ),
			'AQ' => __( 'Antarctica', 'sas-shop' ),
			'AG' => __( 'Antigua and Barbuda', 'sas-shop' ),
			'AR' => __( 'Argentina', 'sas-shop' ),
			'AM' => __( 'Armenia', 'sas-shop' ),
			'AW' => __( 'Aruba', 'sas-shop' ),
			'AU' => __( 'Australia', 'sas-shop' ),
			'AT' => __( 'Austria', 'sas-shop' ),
			'AZ' => __( 'Azerbaijan', 'sas-shop' ),
			'BS' => __( 'Bahamas', 'sas-shop' ),
			'BH' => __( 'Bahrain', 'sas-shop' ),
			'BD' => __( 'Bangladesh', 'sas-shop' ),
			'BB' => __( 'Barbados', 'sas-shop' ),
			'BY' => __( 'Belarus', 'sas-shop' ),
			'BE' => __( 'Belgium', 'sas-shop' ),
			'PW' => __( 'Belau', 'sas-shop' ),
			'BZ' => __( 'Belize', 'sas-shop' ),
			'BJ' => __( 'Benin', 'sas-shop' ),
			'BM' => __( 'Bermuda', 'sas-shop' ),
			'BT' => __( 'Bhutan', 'sas-shop' ),
			'BO' => __( 'Bolivia', 'sas-shop' ),
			'BQ' => __( 'Bonaire, Saint Eustatius and Saba', 'sas-shop' ),
			'BA' => __( 'Bosnia and Herzegovina', 'sas-shop' ),
			'BW' => __( 'Botswana', 'sas-shop' ),
			'BV' => __( 'Bouvet Island', 'sas-shop' ),
			'BR' => __( 'Brazil', 'sas-shop' ),
			'IO' => __( 'British Indian Ocean Territory', 'sas-shop' ),
			'VG' => __( 'British Virgin Islands', 'sas-shop' ),
			'BN' => __( 'Brunei', 'sas-shop' ),
			'BG' => __( 'Bulgaria', 'sas-shop' ),
			'BF' => __( 'Burkina Faso', 'sas-shop' ),
			'BI' => __( 'Burundi', 'sas-shop' ),
			'KH' => __( 'Cambodia', 'sas-shop' ),
			'CM' => __( 'Cameroon', 'sas-shop' ),
			'CA' => __( 'Canada', 'sas-shop' ),
			'CV' => __( 'Cape Verde', 'sas-shop' ),
			'KY' => __( 'Cayman Islands', 'sas-shop' ),
			'CF' => __( 'Central African Republic', 'sas-shop' ),
			'TD' => __( 'Chad', 'sas-shop' ),
			'CL' => __( 'Chile', 'sas-shop' ),
			'CN' => __( 'China', 'sas-shop' ),
			'CX' => __( 'Christmas Island', 'sas-shop' ),
			'CC' => __( 'Cocos (Keeling) Islands', 'sas-shop' ),
			'CO' => __( 'Colombia', 'sas-shop' ),
			'KM' => __( 'Comoros', 'sas-shop' ),
			'CG' => __( 'Congo (Brazzaville)', 'sas-shop' ),
			'CD' => __( 'Congo (Kinshasa)', 'sas-shop' ),
			'CK' => __( 'Cook Islands', 'sas-shop' ),
			'CR' => __( 'Costa Rica', 'sas-shop' ),
			'HR' => __( 'Croatia', 'sas-shop' ),
			'CU' => __( 'Cuba', 'sas-shop' ),
			'CW' => __( 'Cura&Ccedil;ao', 'sas-shop' ),
			'CY' => __( 'Cyprus', 'sas-shop' ),
			'CZ' => __( 'Czech Republic', 'sas-shop' ),
			'DK' => __( 'Denmark', 'sas-shop' ),
			'DJ' => __( 'Djibouti', 'sas-shop' ),
			'DM' => __( 'Dominica', 'sas-shop' ),
			'DO' => __( 'Dominican Republic', 'sas-shop' ),
			'EC' => __( 'Ecuador', 'sas-shop' ),
			'EG' => __( 'Egypt', 'sas-shop' ),
			'SV' => __( 'El Salvador', 'sas-shop' ),
			'GQ' => __( 'Equatorial Guinea', 'sas-shop' ),
			'ER' => __( 'Eritrea', 'sas-shop' ),
			'EE' => __( 'Estonia', 'sas-shop' ),
			'ET' => __( 'Ethiopia', 'sas-shop' ),
			'FK' => __( 'Falkland Islands', 'sas-shop' ),
			'FO' => __( 'Faroe Islands', 'sas-shop' ),
			'FJ' => __( 'Fiji', 'sas-shop' ),
			'FI' => __( 'Finland', 'sas-shop' ),
			'FR' => __( 'France', 'sas-shop' ),
			'GF' => __( 'French Guiana', 'sas-shop' ),
			'PF' => __( 'French Polynesia', 'sas-shop' ),
			'TF' => __( 'French Southern Territories', 'sas-shop' ),
			'GA' => __( 'Gabon', 'sas-shop' ),
			'GM' => __( 'Gambia', 'sas-shop' ),
			'GE' => __( 'Georgia', 'sas-shop' ),
			'DE' => __( 'Germany', 'sas-shop' ),
			'GH' => __( 'Ghana', 'sas-shop' ),
			'GI' => __( 'Gibraltar', 'sas-shop' ),
			'GR' => __( 'Greece', 'sas-shop' ),
			'GL' => __( 'Greenland', 'sas-shop' ),
			'GD' => __( 'Grenada', 'sas-shop' ),
			'GP' => __( 'Guadeloupe', 'sas-shop' ),
			'GT' => __( 'Guatemala', 'sas-shop' ),
			'GG' => __( 'Guernsey', 'sas-shop' ),
			'GN' => __( 'Guinea', 'sas-shop' ),
			'GW' => __( 'Guinea-Bissau', 'sas-shop' ),
			'GY' => __( 'Guyana', 'sas-shop' ),
			'HT' => __( 'Haiti', 'sas-shop' ),
			'HM' => __( 'Heard Island and McDonald Islands', 'sas-shop' ),
			'HN' => __( 'Honduras', 'sas-shop' ),
			'HK' => __( 'Hong Kong', 'sas-shop' ),
			'HU' => __( 'Hungary', 'sas-shop' ),
			'IS' => __( 'Iceland', 'sas-shop' ),
			'IN' => __( 'India', 'sas-shop' ),
			'ID' => __( 'Indonesia', 'sas-shop' ),
			'IR' => __( 'Iran', 'sas-shop' ),
			'IQ' => __( 'Iraq', 'sas-shop' ),
			'IE' => __( 'Republic of Ireland', 'sas-shop' ),
			'IM' => __( 'Isle of Man', 'sas-shop' ),
			'IL' => __( 'Israel', 'sas-shop' ),
			'IT' => __( 'Italy', 'sas-shop' ),
			'CI' => __( 'Ivory Coast', 'sas-shop' ),
			'JM' => __( 'Jamaica', 'sas-shop' ),
			'JP' => __( 'Japan', 'sas-shop' ),
			'JE' => __( 'Jersey', 'sas-shop' ),
			'JO' => __( 'Jordan', 'sas-shop' ),
			'KZ' => __( 'Kazakhstan', 'sas-shop' ),
			'KE' => __( 'Kenya', 'sas-shop' ),
			'KI' => __( 'Kiribati', 'sas-shop' ),
			'KW' => __( 'Kuwait', 'sas-shop' ),
			'KG' => __( 'Kyrgyzstan', 'sas-shop' ),
			'LA' => __( 'Laos', 'sas-shop' ),
			'LV' => __( 'Latvia', 'sas-shop' ),
			'LB' => __( 'Lebanon', 'sas-shop' ),
			'LS' => __( 'Lesotho', 'sas-shop' ),
			'LR' => __( 'Liberia', 'sas-shop' ),
			'LY' => __( 'Libya', 'sas-shop' ),
			'LI' => __( 'Liechtenstein', 'sas-shop' ),
			'LT' => __( 'Lithuania', 'sas-shop' ),
			'LU' => __( 'Luxembourg', 'sas-shop' ),
			'MO' => __( 'Macao S.A.R., China', 'sas-shop' ),
			'MK' => __( 'Macedonia', 'sas-shop' ),
			'MG' => __( 'Madagascar', 'sas-shop' ),
			'MW' => __( 'Malawi', 'sas-shop' ),
			'MY' => __( 'Malaysia', 'sas-shop' ),
			'MV' => __( 'Maldives', 'sas-shop' ),
			'ML' => __( 'Mali', 'sas-shop' ),
			'MT' => __( 'Malta', 'sas-shop' ),
			'MH' => __( 'Marshall Islands', 'sas-shop' ),
			'MQ' => __( 'Martinique', 'sas-shop' ),
			'MR' => __( 'Mauritania', 'sas-shop' ),
			'MU' => __( 'Mauritius', 'sas-shop' ),
			'YT' => __( 'Mayotte', 'sas-shop' ),
			'MX' => __( 'Mexico', 'sas-shop' ),
			'FM' => __( 'Micronesia', 'sas-shop' ),
			'MD' => __( 'Moldova', 'sas-shop' ),
			'MC' => __( 'Monaco', 'sas-shop' ),
			'MN' => __( 'Mongolia', 'sas-shop' ),
			'ME' => __( 'Montenegro', 'sas-shop' ),
			'MS' => __( 'Montserrat', 'sas-shop' ),
			'MA' => __( 'Morocco', 'sas-shop' ),
			'MZ' => __( 'Mozambique', 'sas-shop' ),
			'MM' => __( 'Myanmar', 'sas-shop' ),
			'NA' => __( 'Namibia', 'sas-shop' ),
			'NR' => __( 'Nauru', 'sas-shop' ),
			'NP' => __( 'Nepal', 'sas-shop' ),
			'NL' => __( 'Netherlands', 'sas-shop' ),
			'AN' => __( 'Netherlands Antilles', 'sas-shop' ),
			'NC' => __( 'New Caledonia', 'sas-shop' ),
			'NZ' => __( 'New Zealand', 'sas-shop' ),
			'NI' => __( 'Nicaragua', 'sas-shop' ),
			'NE' => __( 'Niger', 'sas-shop' ),
			'NG' => __( 'Nigeria', 'sas-shop' ),
			'NU' => __( 'Niue', 'sas-shop' ),
			'NF' => __( 'Norfolk Island', 'sas-shop' ),
			'KP' => __( 'North Korea', 'sas-shop' ),
			'NO' => __( 'Norway', 'sas-shop' ),
			'OM' => __( 'Oman', 'sas-shop' ),
			'PK' => __( 'Pakistan', 'sas-shop' ),
			'PS' => __( 'Palestinian Territory', 'sas-shop' ),
			'PA' => __( 'Panama', 'sas-shop' ),
			'PG' => __( 'Papua New Guinea', 'sas-shop' ),
			'PY' => __( 'Paraguay', 'sas-shop' ),
			'PE' => __( 'Peru', 'sas-shop' ),
			'PH' => __( 'Philippines', 'sas-shop' ),
			'PN' => __( 'Pitcairn', 'sas-shop' ),
			'PL' => __( 'Poland', 'sas-shop' ),
			'PT' => __( 'Portugal', 'sas-shop' ),
			'QA' => __( 'Qatar', 'sas-shop' ),
			'RE' => __( 'Reunion', 'sas-shop' ),
			'RO' => __( 'Romania', 'sas-shop' ),
			'RU' => __( 'Russia', 'sas-shop' ),
			'RW' => __( 'Rwanda', 'sas-shop' ),
			'BL' => __( 'Saint Barth&eacute;lemy', 'sas-shop' ),
			'SH' => __( 'Saint Helena', 'sas-shop' ),
			'KN' => __( 'Saint Kitts and Nevis', 'sas-shop' ),
			'LC' => __( 'Saint Lucia', 'sas-shop' ),
			'MF' => __( 'Saint Martin (French part)', 'sas-shop' ),
			'SX' => __( 'Saint Martin (Dutch part)', 'sas-shop' ),
			'PM' => __( 'Saint Pierre and Miquelon', 'sas-shop' ),
			'VC' => __( 'Saint Vincent and the Grenadines', 'sas-shop' ),
			'SM' => __( 'San Marino', 'sas-shop' ),
			'ST' => __( 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'sas-shop' ),
			'SA' => __( 'Saudi Arabia', 'sas-shop' ),
			'SN' => __( 'Senegal', 'sas-shop' ),
			'RS' => __( 'Serbia', 'sas-shop' ),
			'SC' => __( 'Seychelles', 'sas-shop' ),
			'SL' => __( 'Sierra Leone', 'sas-shop' ),
			'SG' => __( 'Singapore', 'sas-shop' ),
			'SK' => __( 'Slovakia', 'sas-shop' ),
			'SI' => __( 'Slovenia', 'sas-shop' ),
			'SB' => __( 'Solomon Islands', 'sas-shop' ),
			'SO' => __( 'Somalia', 'sas-shop' ),
			'ZA' => __( 'South Africa', 'sas-shop' ),
			'GS' => __( 'South Georgia/Sandwich Islands', 'sas-shop' ),
			'KR' => __( 'South Korea', 'sas-shop' ),
			'SS' => __( 'South Sudan', 'sas-shop' ),
			'ES' => __( 'Spain', 'sas-shop' ),
			'LK' => __( 'Sri Lanka', 'sas-shop' ),
			'SD' => __( 'Sudan', 'sas-shop' ),
			'SR' => __( 'Suriname', 'sas-shop' ),
			'SJ' => __( 'Svalbard and Jan Mayen', 'sas-shop' ),
			'SZ' => __( 'Swaziland', 'sas-shop' ),
			'SE' => __( 'Sweden', 'sas-shop' ),
			'CH' => __( 'Switzerland', 'sas-shop' ),
			'SY' => __( 'Syria', 'sas-shop' ),
			'TW' => __( 'Taiwan', 'sas-shop' ),
			'TJ' => __( 'Tajikistan', 'sas-shop' ),
			'TZ' => __( 'Tanzania', 'sas-shop' ),
			'TH' => __( 'Thailand', 'sas-shop' ),
			'TL' => __( 'Timor-Leste', 'sas-shop' ),
			'TG' => __( 'Togo', 'sas-shop' ),
			'TK' => __( 'Tokelau', 'sas-shop' ),
			'TO' => __( 'Tonga', 'sas-shop' ),
			'TT' => __( 'Trinidad and Tobago', 'sas-shop' ),
			'TN' => __( 'Tunisia', 'sas-shop' ),
			'TR' => __( 'Turkey', 'sas-shop' ),
			'TM' => __( 'Turkmenistan', 'sas-shop' ),
			'TC' => __( 'Turks and Caicos Islands', 'sas-shop' ),
			'TV' => __( 'Tuvalu', 'sas-shop' ),
			'UG' => __( 'Uganda', 'sas-shop' ),
			'UA' => __( 'Ukraine', 'sas-shop' ),
			'AE' => __( 'United Arab Emirates', 'sas-shop' ),
			'GB' => __( 'United Kingdom (UK)', 'sas-shop' ),
			'US' => __( 'United States (US)', 'sas-shop' ),
			'UY' => __( 'Uruguay', 'sas-shop' ),
			'UZ' => __( 'Uzbekistan', 'sas-shop' ),
			'VU' => __( 'Vanuatu', 'sas-shop' ),
			'VA' => __( 'Vatican', 'sas-shop' ),
			'VE' => __( 'Venezuela', 'sas-shop' ),
			'VN' => __( 'Vietnam', 'sas-shop' ),
			'WF' => __( 'Wallis and Futuna', 'sas-shop' ),
			'EH' => __( 'Western Sahara', 'sas-shop' ),
			'WS' => __( 'Western Samoa', 'sas-shop' ),
			'YE' => __( 'Yemen', 'sas-shop' ),
			'ZM' => __( 'Zambia', 'sas-shop' ),
			'ZW' => __( 'Zimbabwe', 'sas-shop' )
		));

		// States set to array() are blank i.e. the country has no use for the state field.
		$states = array(
			'AF' => array(),
			'AT' => array(),
			'BE' => array(),
			'BI' => array(),
			'CZ' => array(),
			'DE' => array(),
			'DK' => array(),
			'EE' => array(),
			'FI' => array(),
			'FR' => array(),
			'IS' => array(),
			'IL' => array(),
			'KR' => array(),
			'NL' => array(),
			'NO' => array(),
			'PL' => array(),
			'PT' => array(),
			'SG' => array(),
			'SK' => array(),
			'SI' => array(),
			'LK' => array(),
			'SE' => array(),
			'VN' => array(),
		);

		// Load only the state files the site owner wants/needs
		$allowed = array_merge( $this->get_allowed_countries() );

		if ( $allowed ) {
			foreach ( $allowed as $CC => $country ) {
				if ( ! isset( $states[ $CC ] ) && file_exists( plugin_dir_path( dirname( __FILE__ ) ) . '/includes/states/' . $CC . '.php' ) ) {
					include( plugin_dir_path( dirname( __FILE__ ) ) . '/includes/states/' . $CC . '.php' );
				}
			}
		}

		$this->states = apply_filters( 'sas_shop_states', $states );
	}

	/**
	 * Get the base country for the store.
	 *
	 * @access public
	 * @return string
	 */
	public function get_base_country() {
		$default = esc_attr( get_option('sas_shop_default_country') );
		$country = ( ( $pos = strrpos( $default, ':' ) ) === false ) ? $default : substr( $default, 0, $pos );

		return apply_filters( 'sas_shop_countries_base_country', $country );
	}

	/**
	 * Get the base state for the store.
	 *
	 * @access public
	 * @return string
	 */
	public function get_base_state() {
		$default 	= get_option( 'sas_shop_default_country' );
		$state 		= ( ( $pos = strrpos( $default, ':' ) ) === false ) ? '' : substr( $default, $pos + 1 );

		return apply_filters( 'sas_shop_countries_base_state', $state );
	}

	/**
	 * Get the base city for the store.
	 *
	 * @access public
	 * @return string
	 */
	public function get_base_city() {
		return apply_filters( 'sas_shop_countries_base_city', '' );
	}

	/**
	 * Get the base postcode for the store.
	 *
	 * @access public
	 * @return string
	 */
	public function get_base_postcode() {
		return apply_filters( 'sas_shop_countries_base_postcode', '' );
	}

	/**
	 * Get the allowed countries for the store.
	 *
	 * @access public
	 * @return array
	 */
	public function get_allowed_countries() {
		if ( apply_filters('sas_shop_sort_countries', true ) ) {
			asort( $this->countries );
		}

		if ( get_option('sas_shop_allowed_countries') !== 'specific' ) {
			return $this->countries;
		}

		$countries = array();

		$raw_countries = get_option( 'sas_shop_specific_allowed_countries' );

		foreach ( $raw_countries as $country ) {
			$countries[ $country ] = $this->countries[ $country ];
		}

		return apply_filters( 'sas_shop_countries_allowed_countries', $countries );
	}

	/**
	 * get_allowed_country_states function.
	 *
	 * @access public
	 * @return array
	 */
	public function get_allowed_country_states() {
		if ( get_option('sas_shop_allowed_countries') !== 'specific' ) {
			return $this->states;
		}

		$states = array();

		$raw_countries = get_option( 'sas_shop_specific_allowed_countries' );

		foreach ( $raw_countries as $country ) {
			if ( isset( $this->states[ $country ] ) ) {
				$states[ $country ] = $this->states[ $country ];
			}
		}

		return apply_filters( 'sas_shop_countries_allowed_country_states', $states );
	}

	/**
	 * Gets an array of countries in the EU.
	 *
	 * @access public
	 * @return array
	 */
	public function get_european_union_countries() {
		return array( 'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GB', 'GR', 'HU', 'HR', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK' );
	}

	/**
	 * Prefix certain countries with 'the'
	 *
	 * @access public
	 * @return string
	 */
	public function estimated_for_prefix() {
		$return = '';
		if ( in_array( $this->get_base_country(), array( 'GB', 'US', 'AE', 'CZ', 'DO', 'NL', 'PH', 'USAF' ) ) ) $return = __( 'the', 'sas-shop' ) . ' ';
		return apply_filters('sas_shop_countries_estimated_for_prefix', $return, $this->get_base_country());
	}

	/**
	 * Get the states for a country.
	 *
	 * @access public
	 * @param string $cc country code
	 * @return array of states
	 */
	public function get_states( $cc ) {
		return ( isset( $this->states[ $cc ] ) ) ? $this->states[ $cc ] : array();
	}

	/**
	 * Outputs the list of countries and states for use in dropdown boxes.
	 *
	 * @access public
	 * @param string $selected_country (default: '')
	 * @param string $selected_state (default: '')
	 * @param bool $escape (default: false)
	 * @return void
	 */
	public function country_dropdown_options( $selected_country = '', $selected_state = '', $escape = false ) {
		if ( apply_filters('sas_shop_sort_countries', true ) ) {
			asort( $this->countries );
		}
		$html = '';
		if ( $this->countries ) foreach ( $this->countries as $key => $value) {
			if ( $states =  $this->get_states($key) ) {
				$html .= '<optgroup label="' . esc_attr( $value ) . '">';
					foreach ($states as $state_key=>$state_value) {
						$html .= '<option value="' . esc_attr( $key ) . ':'.$state_key.'"';

						if ($selected_country==$key && $selected_state==$state_key) echo ' selected="selected"';

						$html .= '>'.$value.' &mdash; '. ($escape ? esc_js($state_value) : $state_value) .'</option>';
					}
				$html .= '</optgroup>';
			}
			else {
				$html .= '<option';
				if ( $selected_country == $key && $selected_state == '*' ) $html .= ' selected="selected"';
				$html .= ' value="' . esc_attr( $key ) . '">'. ($escape ? esc_js( $value ) : $value) .'</option>';
			}
		}
		return $html;
	}

}

?>