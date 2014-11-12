<?php

if( ! class_exists( 'LTCon_Field' ) ) {
	
	class LTCon_Field {
		
		public
			$name = '',
			$id = '',
			$class = '',
			$placeholder = '',
			$value = '',
			$default = '',
			$choices = array(),
			$args = array();
		
		private $allowed = array( 'id', 'class', 'placeholder', 'value', 'default', 'choices', 'args' );
		
		/*
		
		
		
		
		
		*/
		
		public function __construct( $name = null ) {
			
			if( null == $name )
				return;
			
			$this->name = trim( $name );
		}
		
		/*
		
		
		
		
		
		*/
		
		public function set( $variable = null, $value = '' ) {
			
			if( in_array( $variable, $this->allowed ) )
				$this->$variable = $value;
			
			return $this;
		}
		
		/*
		
		
		
		
		
		*/
		
		public function attr( $attr = '', $value = '' ) {
			
			if( '' == $value )
				return;
			
			return ' ' . esc_html( $attr ) . '="' . esc_attr( $value ) . '"';
		}
		
		/*
		
		
		
		
		
		*/
		
		public function value( $d = '' ) {
			
			if( '' == $this->value && '' == $this->default )
				return $d;
			elseif( '' == $this->value )
				return $this->default;
			
			return $this->value;
		}
		
		/*
		
		
		
		
		
		*/
		
		public function render( $type = 'text', $echo = true ) {
			
			switch( $type ) {
				
				case 'boolean' :
					$field = $this->field_boolean();
					break;
				
				case 'checkbox' :
					$field = $this->field_checkbox();
					break;
				
				case 'colorpicker' :
					$field = $this->field_colorpicker();
					break;
					
				case 'custom' :
					$field = $this->field_custom();
					break;
					
				case 'editor' :
					$field = $this->field_editor();
					break;
					
				case 'radio' :
				case 'radioimage' :
					$field = $this->field_radio();
					break;
					
				case 'select' :
					$field = $this->field_select();
					break;
					
				case 'text' : default :
					$field = $this->field_text();
					break;
					
				case 'textarea' :
					$field = $this->field_textarea();
					break;
				
				case 'upload' :
					$field = $this->field_upload();
					break;
			}
			
			if( true == $echo )
				echo $field;
			else
				return $field;
		}
		
		/*
		
		
		
		
		
		*/
		
		private function field_boolean() {
			
			$id = $this->attr( 'id', $this->id );
			$name = $this->attr( 'name', $this->name );
			$checked = checked( $this->value(), true, false );
			$data = '';
			
			if( isset( $this->args['toggle'] ) ) {
				
				$data = $this->attr( 'data-toggle', $this->args['toggle'] );
			}
			
			$if = isset( $this->args['if'] ) ? $this->attr( 'data-if', $this->args['if'] ) : '';
			
			$output = '<div class="ltcon-field field-toggle ltcon-group field-wrap field-boolean"' . $if . '>';
				$output .= '<input type="hidden" value="0"' . $name . ' />';
				$output .= '<input type="checkbox" value="1" class="field boolean"' . $data . $name . $checked . ' />';
			$output .= '</div>';
			
			return $output;
		}
		
		/*
		
		
		
		
		
		*/
		
		private function field_checkbox() {
			
			if( ! count( $this->choices ) > 0 )
				return __( 'Please provide some options', LTCON_ADMIN_TEXTDOMAIN );
			
			$this->default = ltcon_explode( $this->default );
			$name = $this->attr( 'name', $this->name . '[]' );
			$class = $this->attr( 'class', 'checkbox field' );
			
			$if = isset( $this->args['if'] ) ? $this->attr( 'data-if', $this->args['if'] ) : '';
			
			$output = '<div class="ltcon-field field-toggle ltcon-group field-wrap field-checkbox"' . $if . '>';
				
				foreach( $this->choices as $val => $label ) {
					
					$checked = checked( in_array( $val, $this->value() ), true, false );
					$value = $this->attr( 'value', $val );
					
					$output .= '<label title="' . esc_attr( $label ) . '">';
						$output .= '<input type="checkbox"' . $class . $checked . $name . $value . ' /> ' . $label;
					$output .= '</label><br/>';
				}
				
			$output .= '</div>';
			
			return $output;
		}
		
		/*
		
		
		
		
		
		*/
		
		private function field_colorpicker() {
			
			$id = $this->attr( 'id', $this->id );
			$name = $this->attr( 'name', $this->name );
			$class = $this->attr( 'class', 'color text field' );
			$value = $this->attr( 'value', $this->value() );
			$placeholder = $this->attr( 'placeholder', $this->placeholder );
			
			$if = isset( $this->args['if'] ) ? $this->attr( 'data-if', $this->args['if'] ) : '';
			
			$output = '<div class="ltcon-field field-toggle ltcon-group field-wrap field-colorpicker"' . $if . '>';
				$output .= '<div class="field-inner">';
					
					$output .= '<div class="color swatch"><div></div></div>';
					$output .= '<input type="text"' . $id . $name . $class . $value . $placeholder . ' />';
					
				$output .= '</div>';
			$output .= '</div>';
			
			return $output;
		}
		
		/*
		
		
		
		
		
		*/
		
		private function field_custom() {
			
			return call_user_func_array( $this->args['callback'], array( $this ) );
		}
		
		/*
		
		
		
		
		
		*/
		
		private function field_editor() {
			
			$if = isset( $this->args['if'] ) ? $this->attr( 'data-if', $this->args['if'] ) : '';
			
			$output = '<div class="ltcon-field field-toggle ltcon-group field-wrap field-editor"' . $if . '>';
			
			ob_start();

			wp_editor( $this->value(), $this->id, array(
				'textarea_name' => $this->name,
				'textarea_rows' => 5
			) );
			
			$output .= ob_get_contents();
			ob_end_clean();
			
			$output .= '</div>';
			
			return $output;
		}
		
		/*
		
		
		
		
		
		*/
		
		private function field_radio() {
			
			if( ! count( $this->choices ) > 0 )
				return __( 'Please provide some options', LTCON_ADMIN_TEXTDOMAIN );
			
			$name = $this->attr( 'name', $this->name );
			$class = $this->attr( 'class', 'radio field' );
			$count = 0;
			
			reset( $this->choices );
			$k = key( $this->choices );
			
			$image = is_array( $this->choices[$k] ) && isset( $this->choices[$k]['image'] ) ? true : false;
			
			$if = isset( $this->args['if'] ) ? $this->attr( 'data-if', $this->args['if'] ) : '';
			
			$output = '<div class="ltcon-field field-toggle ltcon-group field-wrap field-radio' . ( $image ? '-image' : '' ) . '"' . $if . '>';
				
				foreach( $this->choices as $val => $data ) {
					
					$count++;
					
					if( $count == 1 )
						$value = $this->value() ? $this->value() : $val;
					
					$checked = checked( $value, $val, false );
					
					$output .= '<label class="single-label">';
						$output .= '<input type="radio"' . $class . $checked . $name . $this->attr( 'value', $val ) . '>' . ( ! $image ? ' ' : '' );
						
						if( $image ) {
							
							$label = isset( $data['label'] ) ? $data['label'] : $v;
							$src = $this->attr( 'src', $data['image'] );
							$alt = $this->attr( 'alt', $label );
							$title = $this->attr( 'title', $label );
					
							$output .= '<img' . $src . $alt . $title . ' />';
						} else {
							
							$output .= $data;
						}
						
					$output .= '</label>' . ( ! $image ? '<br/>' : '' );
				}
				
			$output .= '</div>';
			
			return $output;
		}
		
		/*
		
		
		
		
		
		*/
		
		private function field_select() {
			
			if( ! count( $this->choices ) > 0 )
				return __( 'Please provide some options', LTCON_ADMIN_TEXTDOMAIN );
			
			$id = $this->attr( 'id', $this->id );
			$name = $this->attr( 'name', $this->name );
			$class = $this->attr( 'class', 'select field' );
			
			$if = isset( $this->args['if'] ) ? $this->attr( 'data-if', $this->args['if'] ) : '';
			
			$output = '<div class="ltcon-field field-toggle ltcon-group field-wrap field-select"' . $if . '>';
				$output .= '<div class="field-inner styled-select">';
					$output .= '<select' . $id . $name . $class . '>';
					
						foreach( $this->choices as $val => $label ) {
						
							$value = $this->attr( 'value', $val );
							$selected = selected( $val, $this->value(), false );
							$output .= '<option' . $value . $selected . '>' . esc_html( $label ) . '</option>';
						}
					
					$output .= '</select>';
				$output .= '</div>';
			$output .= '</div>';
			
			return $output;
		}
		
		/*
		
		
		
		
		
		*/
		
		private function field_text() {
			
			$id = $this->attr( 'id', $this->id );
			$name = $this->attr( 'name', $this->name );
			$class = $this->attr( 'class', 'text field' );
			$value = $this->attr( 'value', $this->value() );
			$placeholder = $this->attr( 'placeholder', $this->placeholder );
			
			$if = isset( $this->args['if'] ) ? $this->attr( 'data-if', $this->args['if'] ) : '';
			
			$output = '<div class="ltcon-field field-toggle ltcon-group field-wrap field-text"' . $if . '>';
				$output .= '<input type="text"' . $id . $name . $class . $value . $placeholder . ' />';
			$output .= '</div>';
			
			return $output;
		}
		
		/*
		
		
		
		
		
		*/
		
		private function field_textarea() {
			
			$id = $this->attr( 'id', $this->id );
			$name = $this->attr( 'name', $this->name );
			$class = $this->attr( 'class', 'textarea field' );
			$placeholder = $this->attr( 'placeholder', $this->placeholder );
			
			$if = isset( $this->args['if'] ) ? $this->attr( 'data-if', $this->args['if'] ) : '';
			
			$output = '<div class="ltcon-field field-toggle ltcon-group field-wrap field-textarea"' . $if . '>';
				$output .= '<textarea' . $id . $name . $class . $placeholder . '>' . esc_textarea( $this->value() ) . '</textarea>';
			$output .= '</div>';
			
			return $output;
		}
		
		/*
		
		
		
		
		
		*/
		
		private function field_upload() {
			
			$id = $this->attr( 'id', $this->id );
			$name = $this->attr( 'name', $this->name );
			$class = $this->attr( 'class', 'upload field' );
			$value = $this->attr( 'value', $this->value() );
			$placeholder = $this->attr( 'placeholder', $this->placeholder );
			
			$if = isset( $this->args['if'] ) ? $this->attr( 'data-if', $this->args['if'] ) : '';
			
			$output = '<div class="ltcon-field field-toggle ltcon-group field-wrap field-upload has-upload"' . $if . '>';
				$output .= '<div class="field-inner ltcon-group">';
				
					$output .= '<input type="text"' . $id . $name . $class . $placeholder . $value . ' />';
					
					$output .= '<div class="button-wrap">';
						$output .= '<a title="' . __( 'Upload', LTCON_ADMIN_TEXTDOMAIN ) . '" target="_blank" data-title="' . __( 'Add Image', LTCON_ADMIN_TEXTDOMAIN ) . '" data-button="' . __( 'Attach', LTCON_ADMIN_TEXTDOMAIN ) . '" class="btn-upload button" href="' . admin_url( 'media-new.php' ) . '">' . __( 'Upload', LTCON_ADMIN_TEXTDOMAIN ) . '</a>';
						$output .= '<a title="' . __( 'Preview', LTCON_ADMIN_TEXTDOMAIN ) . '"  target="_blank" class="btn-preview button" href="#">' . __( 'Preview', LTCON_ADMIN_TEXTDOMAIN ) . '</a>';
						$output .= '<a title="' . __( 'Remove', LTCON_ADMIN_TEXTDOMAIN ) . '"  target="_blank" class="btn-remove button" href="#">' . __( 'Remove', LTCON_ADMIN_TEXTDOMAIN ) . '</a>';
					$output .= '</div>';
					
				$output .= '</div>';
				
				$output .= '<div class="upload-preview ltcon-group">';
					$output .= '<a href="#" class="btn-preview-remove">' . __( 'Remove Preview', LTCON_ADMIN_TEXTDOMAIN ) . '</a>';
				$output .= '</div>';
				
			$output .= '</div>';
			
			return $output;
		}
	}
}