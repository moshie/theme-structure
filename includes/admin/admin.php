<?php

if( ! function_exists( 'ltcon_admin_enqueue_scripts'  ) ) {
	
	function ltcon_admin_enqueue_scripts() {
		
		wp_enqueue_media();
		add_thickbox();
		
		// Color Picker (http://www.eyecon.ro/colorpicker/)
		wp_enqueue_script( 'ltcon-colorpicker', LTCON_THEME_URI . '/includes/admin/assets/js/colorpicker.js', false, '23.05.2009' );
		wp_enqueue_style( 'ltcon-colorpicker', LTCON_THEME_URI . '/includes/admin/assets/css/colorpicker.css', false, '23.05.2009' );
				
		wp_enqueue_script( 'ltcon-functions', LTCON_THEME_URI . '/includes/admin/assets/js/functions.js', false, '1.0' );
		wp_enqueue_script( 'ltcon-admin', LTCON_THEME_URI . '/includes/admin/assets/js/admin.js', false, '1.0' );
		
		wp_enqueue_style( 'ltcon-admin', LTCON_THEME_URI . '/includes/admin/assets/css/admin.css', false, '1.0' );
	}
	add_action( 'admin_enqueue_scripts', 'ltcon_admin_enqueue_scripts' );
}