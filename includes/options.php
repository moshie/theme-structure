<?php

/*
 * If you are looking for somewhere to add theme options
 * you are in the wrong place. I moved theme, have a look
 * in /theme/theme-options.php
 *
 *
 *
 * Adds "Theme Options" to the Admin Menus.
 */
if( ! function_exists( 'ltcon_theme_options_admin_menu' ) ) {
	
	function ltcon_theme_options_admin_menu() {
		
		if( ! is_a( lt()->settings, 'LTCon_Settings' ) )
			return;
		
		add_theme_page(
			__( 'Theme Options', LTCON_ADMIN_TEXTDOMAIN ),
			__( 'Theme Options', LTCON_ADMIN_TEXTDOMAIN ),
			'edit_theme_options',
			'theme-options',
			'ltcon_theme_options_page_callback'
		);
	}
	add_action( 'admin_menu', 'ltcon_theme_options_admin_menu' );
}

/**
 * Adds "Theme Options" to the Admin Bar
 */
if( ! function_exists( 'ltcon_theme_options_admin_bar_menu' ) ) {
	
	function ltcon_theme_options_admin_bar_menu( $wp_admin_bar ) {
		
		if( ! is_a( lt()->settings, 'LTCon_Settings' ) || is_admin() )
			return;
		
		$wp_admin_bar->add_node( array(
			'id' => 'theme-options',
			'title' => __( 'Theme Options', LTCON_ADMIN_TEXTDOMAIN ),
			'href' => admin_url( 'themes.php?page=theme-options' ),
			'parent' => 'site-name'
		) );
	}
	add_action( 'admin_bar_menu', 'ltcon_theme_options_admin_bar_menu', 99 );
}

/**
 * Callback function to output the markup for our
 * theme options/settings page
 */
if( ! function_exists( 'ltcon_theme_options_page_callback' ) ) {
	
	function ltcon_theme_options_page_callback() {
		
		global $ltcon_branding;
	
		echo '<div class="wrap">';
			
			screen_icon( 'options-general' );
			echo '<h2>' . get_admin_page_title() . '</h2>';
			
			lt()->settings->errors();
			
			echo '<form class="ltcon-settings ltcon-border ltcon-ui" method="post" action="options.php">';
				echo '<div class="inner-wrap ltcon-group">';
				
					echo '<div class="sidebar">';
						echo '<div class="panel logo">';
						
							if( isset( $ltcon_branding['branding_logo'] ) ) {
							
								echo '<div class="logo-inner">';
									echo '<img src="' . esc_url( $ltcon_branding['branding_logo'] ) . '" alt="' . ( isset( $ltcon_branding['branding_name'] ) ? $ltcon_branding['branding_name'] : '' ) . '" />';
								echo '</div>';
							}
						
						echo '</div>';
						lt()->settings->navigation();
					echo '</div>';
				
					echo '<div class="main">';
						echo '<div class="tabbed ltcon-tabs">';
							lt()->settings->fields();
						echo '</div>';
						echo '<div class="footer">';
							lt()->settings->button( __( 'Save Settings', LTCON_ADMIN_TEXTDOMAIN ) );
						echo '</div>';
					echo '</div>';
				
				echo '</div>';
			echo '</form>';
		
		echo '</div>';
	}
}