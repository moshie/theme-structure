<?php

/**
 * Allow shortcodes to be run within
 * widget_text widgets.
 */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * A copy of the_content filter
 */
add_filter( 'ltcon_the_content', 'wptexturize' );
add_filter( 'ltcon_the_content', 'convert_smilies' );
add_filter( 'ltcon_the_content', 'convert_chars' );
add_filter( 'ltcon_the_content', 'wpautop' );
add_filter( 'ltcon_the_content', 'shortcode_unautop' );
add_filter( 'ltcon_the_content', 'prepend_attachment' );