<?php

if( ! class_exists( 'LT_Shortcodes' ) ) {

	class LT_Shortcodes {
		
		public function __construct() {

			foreach( get_class_methods( $this ) as $method ) {

				// If it starts with an underscore, assume it's a private function
				if( '_' == substr( $method, 0, 1 ) )
    				continue;
    			
    			add_shortcode( $method, array( $this, $method ) );
			}
		}

		/**
		 * Option - Get one of the settings from the theme options
		 */
		public function setting( $atts = array(), $content = '' ) {

			extract( shortcode_atts( array(
				'key' => '',
				'default' => ''
			), $atts ) );

			return lt()->settings->get( $key, $default );
		}

		/**
		 * Shortcode - Displays the current year
		 */
		public function year() {

			return date( 'Y' );
		}

		/**
		 * Shortcode - Mail To Links
		 */
		public function mailto( $atts = array(), $content = '' ) {
			
			return '<a href="mailto:' . esc_attr( antispambot( $content ) ) . '">' . antispambot( $content ) . '</a>';
		}

		/**
		 * Shortcode - Responsive embeds
		 * URL - http://getbootstrap.com/components/#responsive-embed
		 */
		public function responsive_video( $atts = array(), $content = '' ) {
			
			extract( shortcode_atts( array(
				'aspect' => '16by9'
			), $atts ) );

			return '<div class="embed-responsive embed-responsive-' . esc_attr( $aspect ) . '">' . do_shortcode( $content ) . '</div>';
		}
	}
	new LT_Shortcodes();
}