<?php

/**
 * Set the content width for oEmbeds
 */
if( ! isset( $content_width ) )
	$content_width = 870;

/**
 * Setup the theme
 */
if( ! function_exists( 'ltcon_setup_theme' ) ) {
	
	function ltcon_setup_theme() {

		add_theme_support( 'post-thumbnails' ); 
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form' ) );
	}
	add_action( 'after_setup_theme', 'ltcon_setup_theme' );
}

/**
 * Register navigation menus
 */
if( ! function_exists( 'ltcon_register_nav_menus' ) ) {
	
	function ltcon_register_nav_menus() {
		
		register_nav_menus( array(
			'primary' => __( 'Primary', LTCON_THEME_TEXTDOMAIN )
		) );
	}
	add_action( 'init', 'ltcon_register_nav_menus' );
}

/**
 * Register 1 or more sidebars
 */
if( ! function_exists( 'ltcon_register_sidebar' ) ) {
	
	function ltcon_register_sidebar() {
		
		register_sidebar( array(
			'id' => 'primary',
			'name'=> __( 'Primary', LTCON_THEME_TEXTDOMAIN ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
		) );

		register_sidebar( array(
			'id' => 'footer',
			'name'=> __( 'Footer', LTCON_THEME_TEXTDOMAIN ),
			'before_widget' => '<div class="col-sm-4"><div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div></div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>'
		) );
	}
	add_action( 'widgets_init', 'ltcon_register_sidebar' );
}