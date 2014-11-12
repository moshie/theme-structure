<?php

if( ! function_exists( 'ltcon_register_widgets' ) ) { 
  
    function ltcon_register_widgets() { 
  		
  		// Include abstract class, does all the cool stuff
    	include_once( LTCON_THEME_PATH . '/includes/abstracts/lt-widget.php' ); 

    	// Loop the firectory, and include any widgets we have in there
    	foreach( scandir( LTCON_THEME_PATH . '/theme/widgets' ) as $file ) {

    		if( '.' == substr( $file, 0, 1 ) || '_' == substr( $file, 0, 1 ) || '.php' != substr( $file, -4 ) )
    			continue;

    		include_once( LTCON_THEME_PATH . '/theme/widgets/' . $file );
    	}
    } 
    add_action( 'widgets_init', 'ltcon_register_widgets' ); 
}