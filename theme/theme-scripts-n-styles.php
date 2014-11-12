<?php

/**
 * Load in our scripts, the RIGHT way
 */
if( ! function_exists( 'ltcon_enqueue_scripts' ) ) {
	
	function ltcon_enqueue_scripts() {
		
		// Include the comment reply script where needed
		if( is_singular() && comments_open() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
		
		if( ! is_admin() ) {

			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', null, '1.10.2' );
		}
		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'script', LTCON_BUILD_URI . '/js/script.min.js', array( 'jquery' ), '0.1' );
		wp_localize_script( 'script', 'ltcon', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	}
	add_action( 'wp_enqueue_scripts', 'ltcon_enqueue_scripts' );
}

/**
 * Load in our styles, the RIGHT way
 */
if( ! function_exists( 'ltcon_enqueue_styles' ) ) {
	
	function ltcon_enqueue_styles() {
		
		// Enqueue our theme style.css
		wp_enqueue_style( 'style', get_stylesheet_uri(), null, '0.1' );
	}
	add_action( 'wp_enqueue_scripts', 'ltcon_enqueue_styles', 11 );
}