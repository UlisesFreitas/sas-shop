<?php

/**
 * Sas_Shop Callback Helper Class
 *
 * The callback functions of the settings page
 *
 * @package    Sas_Shop
 * @subpackage Sas_Shop/admin/settings
 * @author     UlisesFreitas <ulises.freitas@gmail.com>
 */
class Sas_Shop_Callback_Helper {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of this plugin.
	 */
	public function __construct( $plugin_name ) {

		$this->plugin_name = $plugin_name;

	}

	private function get_id_attribute( $id ) {
		return ' id="sas_shop_settings[' . $id . ']" ';
	}

	private function get_name_attribute( $name ) {
		return ' name="sas_shop_settings[' . $name . ']" ';
	}

	private function get_id_and_name_attrubutes( $field_key ) {
		return  $this->get_id_attribute( $field_key ) . $this->get_name_attribute( $field_key );
	}

	private function get_label_for( $id, $desc ) {
		return '<label for="sas_shop_settings[' . $id . ']"> '  . $desc . '</label>';
	}

	/**
	 * Missing Callback
	 *
	 * If a function is missing for settings callbacks alert the user.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function missing_callback( $args ) {
		printf( __( 'The callback function used for <strong>%s</strong> setting is missing.', $this->plugin_name ), $args['id'] );
	}

	/**
	 * Header Callback
	 *
	 * Renders the header.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function header_callback( $args ) {
		echo '<hr/>';
	}

	/**
	 * Checkbox Callback
	 *
	 * Renders checkboxes.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function checkbox_callback( $args ) {

		$value = Sas_Shop_Option::get_option( $args['id'] );
		$checked = isset( $value ) ? checked( 1, $value, false ) : '';

		$html = '<input type="checkbox" ';
		$html .= $this->get_id_and_name_attrubutes( $args['id'] );
		$html .= 'value="1" ' . $checked . '/>';

		$html .= '<br />';
		$html .= $this->get_label_for( $args['id'], $args['desc'] );

		echo $html;
	}

	/**
	 * Multicheck Callback
	 *
	 * Renders multiple checkboxes.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function multicheck_callback( $args ) {



		if ( empty( $args['options'] ) ) {
			printf( __( 'Options for <strong>%s</strong> multicheck is missing.', $this->plugin_name ), $args['id'] );
			return;
		}

		$old_values = Sas_Shop_Option::get_option( $args['id'], array() );

		$html ='';

		foreach( $args['options'] as $field_key => $option ) {

			if( isset( $old_values[$field_key] ) ) {
				$enabled = $option;
			} else {
				$enabled = NULL;
			}

			$checked = checked( $option, $enabled, false );

			$html .= '<input type="checkbox" ';
			$html .= $this->get_id_and_name_attrubutes( $args['id'] . '][' . $field_key );
			$html .= ' value="' . $option . '" ' . $checked . '/> ';

			$html .= $this->get_label_for( $args['id'] . '][' . $field_key, $option );
			$html .= '<br/>';
		}

		$html .= '<p class="description">' . $args['desc'] . '</p>';

		echo $html;
	}



	/**
	 * Radio Callback
	 *
	 * Renders radio boxes.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function radio_callback( $args ) {

		if ( empty( $args['options'] ) ) {
			printf( __( 'Options for <strong>%s</strong> radio is missing.', $this->plugin_name ), $args['id'] );
			return;
		}

		$old_value = Sas_Shop_Option::get_option( $args['id'] );

		$html = '';

		foreach ( $args['options'] as $field_key => $option ) {

			if ( !empty( $old_value ) ) {
				$checked = checked( $field_key, $old_value,false );
			} else {
				$checked = checked( $args['std'], $field_key, false );
			}

			$html .= '<input type="radio"';
			$html .= $this->get_name_attribute( $args['id'] );
			$html .= $this->get_id_attribute( $args['id'] . '][' . $field_key );
			$html .= ' value="' . $field_key . '" ' . $checked . '/> ';

			$html .= $this->get_label_for( $args['id'] . '][' . $field_key, $option );
			$html .= '<br/>';

		}

		$html .= '<p class="description">' . $args['desc'] . '</p>';
		echo $html;
	}

	/**
	 * Text Callback
	 *
	 * Renders text fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function text_callback( $args ) {

		$this->input_type_callback( 'text', $args );

	}

	/**
	 * Email Callback
	 *
	 * Renders email fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function email_callback( $args ) {

		$this->input_type_callback( 'email', $args );

	}

	/**
	 * Url Callback
	 *
	 * Renders url fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function url_callback( $args ) {

		$this->input_type_callback( 'url', $args );

	}

	/**
	 * Password Callback
	 *
	 * Renders password fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function password_callback( $args ) {

		$this->input_type_callback( 'password', $args );

	}

	/**
	 * Input Type Callback
	 *
	 * Renders input type fields.
	 *
	 * @since 	1.0.0
	 * @param 	string $type Input Type
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	private function input_type_callback( $type, $args ) {



		$value = Sas_Shop_Option::get_option( $args['id'], $args['std']  );

		$html = '<input type="' . $type . '" ';
		$html .= $this->get_id_and_name_attrubutes( $args['id'] );
		$html .= 'class="' . $args['size'] . '-text" ';
		$html .= 'value="' . esc_attr( stripslashes( $value ) ) . '"/>';

		$html .= '<br />';
		$html .= $this->get_label_for( $args['id'], $args['desc'] );

		echo $html;
	}

	/**
	 * Number Callback
	 *
	 * Renders number fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function number_callback( $args ) {

		$value = Sas_Shop_Option::get_option( $args['id'] );


		$html = '<input type="number" ';
		$html .= $this->get_id_and_name_attrubutes( $args['id'] );
		$html .= 'class="' . $args['size'] . '-text" ';
		$html .= 'step="' . $args['step'] . '" ';
		$html .= 'max="' . $args['max'] . '" ';
		$html .= 'min="' . $args['min'] . '" ';
		$html .= 'value="' . $value . '"/>';

		$html .= '<br />';
		$html .= $this->get_label_for( $args['id'], $args['desc'] );

		echo $html;
	}

	/**
	 * Textarea Callback
	 *
	 * Renders textarea fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function textarea_callback( $args ) {

		$value = Sas_Shop_Option::get_option( $args['id'], $args['std']  );


		$html = '<textarea ';
		$html .= 'class="' . $args['size'] . '-text" ';
		$html .= 'cols="50" rows="5" ';
		$html .= $this->get_id_and_name_attrubutes( $args['id'] ) . '>';
		$html .= esc_textarea( stripslashes( $value ) );
		$html .= '</textarea>';

		$html .= '<br />';
		$html .= $this->get_label_for( $args['id'], $args['desc'] );

		echo $html;
	}

	/**
	 * Select Callback
	 *
	 * Renders select fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function select_callback( $args ) {

		$value = Sas_Shop_Option::get_option( $args['id'] );

		$html = '<select ' . $this->get_id_and_name_attrubutes( $args['id'] ) . ' title="'.$args['name'].'" class="chosen_select" />';

			foreach ( $args['options'] as $option => $option_name ) {
				$selected = selected( $option, $value, false );
				$html .= '<option value="' . $option . '" ' . $selected . '>' . $option_name . '</option>';
			}

		$html .= '</select>';
		$html .= '<br />';
		$html .= $this->get_label_for( $args['id'], $args['desc'] );

		echo $html;
	}

	public function countries_callback( $args ) {

		$country_setting = (string) Sas_Shop_Option::get_option( $args['id'] );
		$countries = new Sas_Shop_Countries(); // Countries class
		//$countries 		 = Sas_Shop()->countries->countries;

					if ( strstr( $country_setting, ':' ) ) {
						$country_setting 	= explode( ':', $country_setting );
						$country 			= current( $country_setting );
						$state 				= end( $country_setting );
					}
					else {
						$country 	= $country_setting;
						$state 		= '*';
					}

					$html = '';
					/*
					$html .= '<tr valign="top">
						<th scope="row" class="titledesc">
							<label for="' . esc_attr( $args['id'] ).'">'.esc_html( $args['name'] ).'</label>
						</th>
						<td class="forminp"><select name="'. $this->get_id_and_name_attrubutes( $args['id'] ).'" data-placeholder="' . _e( 'Choose a country&hellip;', $this->plugin_name ) . '" title="Country" class="chosen_select_nostd">'.
							$countries->country_dropdown_options( $country, $state ) . '
						</select>'. $this->get_label_for( $args['id'], $args['desc'] ).'
						</td>
					</tr>';
					*/



					$html .= '<select ' . $this->get_id_and_name_attrubutes( $args['id'] ) . ' title="Country" class="chosen_select" />';
					$html .= $countries->country_dropdown_options( $country, $state );
					$html .= '</select>';
					$html .= '<br />';
					$html .= $this->get_label_for( $args['id'], $args['desc'] );

					echo $html;
	}


	public function current_taxes_callback( $args ){


		$old_values = Sas_Shop_Option::get_options() ;

		$defaults['class'] 			= 'repeater';
		$defaults['fields']         = $args['options'];
		$defaults['id'] 			= '';
		$defaults['label-add'] 		= 'Add Item';
		$defaults['label-edit'] 	= 'Edit Item';
		$defaults['label-header'] 	= 'Item Name';
		$defaults['label-remove'] 	= 'Remove Item';
		$defaults['title-field'] 	= '';

		apply_filters( $this->plugin_name . '-field-repeater-taxes-defaults', $defaults );

		$setatts 	= wp_parse_args( $args, $defaults );
		$count 		= 1;
		$repeater 	= array();


		if(!empty($old_values['taxes'])){
			foreach($old_values['taxes'] as $arr){

				for($i=0;$i<count($arr);$i++){
					$count = count(array_filter($arr));
				}
			}
		}


		if ( ! empty( $this->options[$setatts['id']] ) ) {
			$repeater = maybe_unserialize( $this->options[$setatts['id']][0] );
		}
		if ( ! empty( $repeater ) ) {
			//$count = count( $repeater );
		}


		$html = '';
		$html .= '<ul class="repeaters">';
		$html .= '<li class="">';
		$html .= '<div class=""><div class="wrap-fields"><p class="wrap-field">Tax Name</p>';
		$html .= '<p class="wrap-field">Tax Rate </p>';
		$html .= '<p class="wrap-field">Tax Region</p></div><div></div></div></li>';

		for ( $i = 0; $i <= $count; $i++ ) {

			if ( $i === $count ) {
				$setatts['class'] .= ' hidden';
			}
			if ( ! empty( $repeater[$i][$setatts['title-field']] ) ) {
				$setatts['label-header'] = $repeater[$i][$setatts['title-field']];
			}

		$html .= '<li class="' . esc_attr( $setatts['class'] ) . '">';
		$html .= '<div class="repeater-content">';
		$html .= '<div class="wrap-fields">';

		foreach ( $setatts['fields'] as $fieldcount => $field ) {

			foreach ( $field as $type => $atts ) {


				$repeater_value = isset($old_values['taxes'][$atts['name']][$i]) ? $old_values['taxes'][$atts['name']][$i] : '';


				$atts['id'] 	= 'sas_shop_settings[taxes]['.$atts['id'].'][]';
				$atts['name'] 	= 'sas_shop_settings[taxes]['.$atts['name'].'][]';



				$html .= '<p class="wrap-field">';

				if ( ! empty( $atts['label'] ) ) {

					//$html .= '<label for="' . esc_attr( $atts['id'] ) .'">' . __( $atts['label'], $this->plugin_name ) . ' </label>';

				}


				$html .= '<input id="' . esc_attr( $atts['id'] ) .'" name="' . esc_attr( $atts['name'] ) .'" type="text" value="' . esc_attr( $repeater_value ) . '" />';

				//if ( ! empty( $atts['description'] ) ) {

				//	$html .= '<span class="description">' . esc_html_e( $atts['description'], $this->plugin_name ) . '</span>';

				//}

				$html .= '</p>';

			}

		} // $fieldset foreach

		$html .= '</div>';
		$html .= '<div class="repeater-remove">';
		$html .= '<a class="link-remove" href="#">';
		$html .= '<span>';
		$html .= esc_html( apply_filters( $this->plugin_name . '-repeater-remove-link-label', $setatts['label-remove'] ), $this->plugin_name );
		$html .= '</span>';
		$html .= '</a>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</li>';

	} // for

	$html .= '<div class="repeater-more">';
	$html .= '<span id="status"></span>';
	$html .= '<a class="button" href="#" id="add-repeater">';
	$html .=  esc_html( apply_filters( $this->plugin_name . '-repeater-more-link-label', $setatts['label-add'] ), $this->plugin_name );
	$html .= '</a>';
	$html .= '</div>';
	$html .= '</ul>';

	echo $html;

	}
	/**
	 * Rich Editor Callback
	 *
	 * Renders rich editor fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @global 	$wp_version WordPress Version
	 */
	public function rich_editor_callback( $args ) {
		global $wp_version;

		$value = Sas_Shop_Option::get_option( $args['id'] );

		if ( $wp_version >= 3.3 && function_exists( 'wp_editor' ) ) {
			ob_start();
			wp_editor( stripslashes( $value ), 'sas_shop_settings_' . $args['id'], array( 'textarea_name' => 'sas_shop_settings[' . $args['id'] . ']' ) );
			$html = ob_get_clean();
		} else {
			$html = '<textarea' . $this->get_id_and_name_attrubutes( $args['id'] ) . 'class="' . $args['size'] . '-text" rows="10" >' . esc_textarea( stripslashes( $value ) ) . '</textarea>';
		}

		$html .= '<br/>';
		$html .= $this->get_label_for( $args['id'], $args['desc'] );
		$html .= '<br/>';

		echo $html;
	}

	/**
	 * Upload Callback
	 *
	 * Renders upload fields.
	 *
	 * @since 	1.0.0
	 * @param 	array $args Arguments passed by the setting
	 * @return 	void
	 */
	public function upload_callback( $args ) {


		$html = '<input type="text" ';
		$html .= $this->get_id_and_name_attrubutes( $args['id'] );
		$html .= 'class="' . $args['size'] . '-text ' . 'sas_shop_upload_field" ';
		$html .= ' value="' . esc_attr( stripslashes( $value ) ) . '"/>';

		$html .= '<span>&nbsp;<input type="button" class="' .  'sas_shop_settings_upload_button button-secondary" value="' . __( 'Upload File', $this->plugin_name ) . '"/></span>';

		$html .= $this->get_label_for( $args['id'], $args['desc'] );

		echo $html;
	}
}
