<?php

/**
 * LTCon Settings
 *
 * @author Christopher Geary
 * @link http://crgeary.com/
 *
 */

if( ! class_exists( 'LTCon_Settings' ) ) {
	
	class LTCon_Settings {
		
		private $option;
		
		private $fields = array();
		
		private $sections = array();
		
		//
		
		public function __construct( $option = null ) {
			
			if( null == $option )
				return;
			
			$this->option = trim( $option );
			
			add_action( 'admin_init', array( $this, 'register' ) );
		}
		
		/*
		
		
		
		
		
		*/
		
		public function register() {
			
			register_setting( $this->option, $this->option, array( $this, 'sanitize' ) );
			
			$this->register_sections();
			$this->register_fields();
		}
		
		/*
		
		
		
		
		
		*/
		
		private function register_sections() {
			
			do_action( 'ltcon_sections-' . $this->option );
			
			foreach( $this->sections as $parent_key => $parent ) {
				
				if( isset( $parent['children'] ) && is_array( $parent['children'] ) ) {
					
					foreach( $parent['children'] as $child_key => $child )
						add_settings_section( $child_key, '<span>' . $parent['label'] . ' &rarr; </span>' . $child, array( &$this, 'section_callback' ), $this->option );
					
				} else {
					
					add_settings_section( $parent_key, $parent['label'], array( &$this, 'section_callback' ), $this->option );
				}
			}
		}
		
		/*
		
		
		
		
		
		*/
		
		public function add_section( $id = '', $label = '', $icon = '' ) {
			
			if( isset( $this->sections[$id] ) )
				return;
			
			$this->sections[$id]['label'] = $label;
			$this->sections[$id]['icon'] = ( $icon ? $icon : 'cog' );
		}
		
		/*
		
		
		
		
		
		*/
		
		public function add_subsection( $parent = '', $id = '', $label = '' ) {
			
			if( empty( $parent ) )
				return;
			
			$this->sections[$parent]['children'][$id] = $label;
		}
		
		/*
		
		
		
		
		
		*/
		
		public function get_sections() {
			
			return $this->sections;
		}
		
		/*
		
		
		
		
		
		*/
		
		public function section_callback( $section = array() ) {
			
			// Stupid hack, but can't see any other way..
			$id = esc_attr( $section['id'] );
			echo '<div class="ltcon-section-id" data-id="tab-' . $id . '"></div>';
		}
		
		/*
		
		
		
		
		
		*/
		
		private function register_fields() {
			
			do_action( 'ltcon_fields-' . $this->option );
			
			foreach( $this->fields as $key => $field ) {
				
				$field = wp_parse_args( $field, array(
					'id' => $key,
					'label' => $key,
					'description' => '',
					'type' => '',
					'section' => '',
					'default' => '',
					'choices' => '',
					'placeholder' => '',
					'data' => array(),
					'args' => array()
				) );
				
				$field['label_for'] = $field['id'];
				
				extract( $field );
				
				add_settings_field( $id, $label, array( &$this, 'field_callback' ), $this->option, $section, $field );
			}
		}
		
		/*
		
		
		
		
		
		*/
		
		public function add_field( $id = '', $args = array() ) {
			
			if( empty( $id ) )
				return;
			
			$this->fields[$id] = $args;
		}
		
		/*
		
		
		
		
		
		*/
		
		public function get_fields() {
			
			return $this->fields;
		}
		
		/*
		
		
		
		
		
		*/
		
		public function field_callback( $field = array() ) {
			
			extract( $field );
			$option = get_option( $this->option );
			
			$f = new LTCon_Field( "$this->option[$id]" );
			
			$f->set( 'id', $id );
			$f->set( 'placeholder', $placeholder );
			$f->set( 'value', ( isset( $option[$id] ) ? $option[$id] : '' ) );
			$f->set( 'default', $default );
			$f->set( 'data', $data );
			$f->set( 'args', $args );
			$f->set( 'choices', $choices );
			
			$f->render( $type );
			
			echo trim( $description ) ? '<p class="description">' . trim( $description ) . '</p>' : '';
		}
		
		/*
		
		
		
		
		
		*/
		
		public function get( $key = '', $default = '' ) {
			
			$option = get_option( $this->option );
			
			if( '' == $key )
				return is_array( $option ) ? $option : array();
			
			if( is_array( $option ) && array_key_exists( $key, $option ) ) {
				
				if( ! is_null( $option[$key] ) && '' != $option[$key] )
					return $option[$key];
			}
			
			return '' == $default ? ( isset( $this->fields[$key]['default'] ) ? $this->fields[$key]['default'] : $default ) : $default;
		}
		
		/*
		
		
		
		
		
		*/
		
		public function errors() {
			
			settings_errors();
		}
		
		/*
		
		
		
		
		
		*/
		
		public function sanitize( $input = array() ) {
			
			$input = $input ? $input : array();
			
			if( count( $this->fields ) > 0 ) {
				
				foreach( $this->fields as $name => $field ) {
				
					if( ! array_key_exists( $name, $input ) && 'boolean' == $field['type'] )
						$input[$name] = 0;
				}
			}			
			
			return apply_filters( 'ltcon_sanitize-' . $this->option, $input );
		}
		
		/*
		
		
		
		
		
		*/
		
		public function navigation() {
			
			if( ! is_array( $this->sections ) || ! count( $this->sections ) > 0 )
				return;
			
			echo '<ul class="navigation ltcon-navigation">';
			
			foreach( $this->sections as $parent_key => $parent ) {
				
				$children = false;
				$key = $parent_key;
				
				if( isset( $parent['children'] ) && count( $parent['children'] ) > 0 ) {
					
					$children = true;
					reset( $parent['children'] );
					$key = key( $parent['children'] );
				}
				
				echo '<li' . ( $children ? ' class="has-children"' : '' ) . '><a href="' . esc_attr( "#tab-$key" ) .'">';
				echo isset( $parent['icon'] ) && $parent['icon'] ? '<i class="glyphicon glyphicon-' . esc_attr( $parent['icon'] ) . '"></i>' : '';
				echo '<span>' . esc_html( $parent['label'] ) . '</span></a>';
				
				if( $children ) {
					
					echo '<ul class="children">';
					foreach( $parent['children'] as $childkey => $child ) {
						
						echo '<li><a href="' . esc_attr( "#tab-$childkey" ) .'">' . $child . '</a></li>';
					}
					echo '</ul>';
				}
				
				echo '</li>';
			}
			
			echo '</ul>';
		}
		
		/*
		
		
		
		
		
		*/
		
		public function fields() {
			
			settings_fields( $this->option );
			do_settings_sections( $this->option );
		}
		
		/*
		
		
		
		
		
		*/
		
		public function button( $label = '', $classes = 'button primary' ) {
			
			if( ! $label )
				$label = __( 'Save Settings', LTCON_ADMIN_TEXTDOMAIN );
			
			submit_button( $label, $classes, 'submit', false );
		}
	}
}