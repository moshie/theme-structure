<?php

/**
 * A serious WIP, would like to move everything
 * to be OOP, includes to be handled by composer
 * and follow PSR guidelines
 */
if( ! class_exists( 'LTCon_Theme' ) ) {

	class LTCon_Theme {

		protected static $instance;

		public $settings;

		public $metabox;

		private function __construct() {

			$this->settings = new LTCon_Settings( LTCON_THEME_OPTIONS_KEY );

			$this->metabox = new LTCon_Metabox( 'custom-information', __( 'Custom Data', LTCON_ADMIN_TEXTDOMAIN ) );
			$this->metabox->set_screens( get_post_types( array( 'public' => true, 'show_ui' => true ) ) );
		}

		public static function singleton() {

			if( null == self::$instance )
				self::$instance = new self;

			return self::$instance;
		}
	}
	
	if( ! function_exists( 'lt' ) ) {

		function lt() {

			return LTCon_Theme::singleton();
		}
	}
}