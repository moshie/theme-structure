<?php

/**
 * Just print_r() - but with some extra awesomeness!
 */
if( ! function_exists( 'print_rr' ) ) {
	
	function print_rr( $item, $echo = true ) {
		
		$string = '<pre>' . print_r( $item, true ) . '</pre>';

		if( ! $echo )
			return $string;

		echo $string;
	}
}

/**
 * Die & Dump
 */
if( ! function_exists( 'dd' ) ) {
	
	function dd( $data ) {
		
		var_dump( $data );
		exit;
	}
}