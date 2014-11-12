<?php

/**
 * LTCon Metabox
 *
 */

if( ! class_exists( 'LTCon_Metabox' ) ) {
	
	class LTCon_Metabox {
		
		private $fields = array();
		
		private $sections = array();
		
		private $name = '';
		
		private $label = '';
		
		private $types = array();
		
		//
		
		public function __construct( $name = null, $label = '' ) {
			
			if( null == $name )
				return;
			
			$this->name = trim( str_replace( ' ', '', $name ) );
			$this->label = trim( $label );
			
			add_action( 'add_meta_boxes', array( $this, 'register' ) );
			add_action( 'save_post', apply_filters( "ltcon_metabox_save_{$this->name}", array( $this, 'save' ) ) ); 
		}
		
		/*
		
		
		
		
		
		*/
		
		public function set_screens( $screens = 'page' ) {
			
			$this->types = ltcon_explode( $screens );
		}
		
		/*
		
		
		
		
		
		*/
		
		public function register() {
			
			if( ! is_array( $this->types ) && count( $this->types ) == 0 )
				return;
			
			foreach( $this->types as $type ) {
				
				add_meta_box( trim( $this->name ), $this->label, apply_filters( "ltcon_metabox_callback_{$this->name}", array( $this, 'callback' ) ), $type, 'normal' );
			}
		}
		
		/*
		
		
		
		
		
		*/
		
		public function add_field( $id = '', $args = array() ) {
			
			if( empty( $id ) )
				return;
			
			$this->fields[$id] = wp_parse_args( $args, array(
				'id' => $id,
				'label' => str_replace( array( '-', '_' ), ' ', $id ),
				'description' => '',
				'type' => '',
				'section' => '',
				'default' => '',
				'choices' => '',
				'placeholder' => '',
				'data' => array(),
				'args' => array()
			) );;
		}
		
		/*
		
		
		
		
		
		*/
		
		public function callback( $post ) {
			
			foreach( $this->get_fields() as $key => $field ) {
				
				echo '<div class="field-wrap ltcon-metabox ltcon-ui">';
					echo '<div class="ltcon-metabox-inner">';
						echo '<label for="' . esc_attr( $field['id'] ) . '"><strong>' . esc_html( $field['label'] ) . '</strong></label>';
						echo '<div class="ltcon-metabox-field">';
							$f = new LTCon_Field( $key );
			
							$f->set( 'id', $field['id'] );
							$f->set( 'placeholder', $field['placeholder'] );
							$f->set( 'value', get_post_meta( $post->ID, "_{$key}", true ) );
							$f->set( 'default', $field['default'] );
							$f->set( 'data', $field['data'] );
							$f->set( 'args', $field['args'] );
							$f->set( 'choices', $field['choices'] );
			
							$f->render( $field['type'] );
			
							echo trim( $field['description'] ) ? '<p class="description">' . trim( $field['description'] ) . '</p>' : '';
						echo '</div>';
					 echo '</div>';
				echo '</div>';
			}
			
			wp_nonce_field( "{$this->name}_nonce", "{$this->name}_nonce" ); 
		}
		
		/*
		
		
		
		
		
		*/
		
		public function save( $post_id ) {
			
			if( ! isset( $_POST["{$this->name}_nonce"] ) ) 
				return $post_id; 

			if( ! wp_verify_nonce( $_POST["{$this->name}_nonce"], "{$this->name}_nonce" ) ) 
				return $post_id; 

			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  
				return $post_id; 
			
			if( 'page' == $_POST['post_type'] ) {
				
				if( ! current_user_can( 'edit_page', $post_id ) ) 
					return $post_id;
			} else {
				
				if( ! current_user_can( 'edit_post', $post_id ) ) 
					return $post_id;
			}
			
			// Do the updates..
			
			foreach( $this->fields as $key => $field ) {
				
				update_post_meta( $post_id, "_{$key}", $_POST[$key] );
			}
		}
		
		/*
		
		
		
		
		
		*/
		
		public function get_fields() {
			
			return $this->fields;
		}
	}
}