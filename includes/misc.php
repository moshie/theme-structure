<?php

/**
 * Basically explodes a string, but if you pass it an array
 * it doesn't complain. Usd for function argument if you're
 * unsure if what you getting is a string or an array
 */
if( ! function_exists( 'ltcon_explode' ) ) {
	
	function ltcon_explode( $string = '', $delimiter = ',' ) {
		
		if( is_array( $string ) )
			return $string;
		
		$parts = explode( $delimiter, $string );
		$return = array();
		
		foreach( $parts as $part ) {
			
			$part = trim( $part );
			if( '' == $part )
				continue;
			
			$return[] = $part;
		}
		
		return $return;
	}
}

/**
 * The LT widget/settings expect you to parse an array of choices
 * in a $key => $value structure. This function does the heavy
 * lifting for any post type.
 */
if( ! function_exists( '_ltcon_format_post_to_array' ) ) {
	
	function _ltcon_format_post_to_array( $posts ) {
		
		if( ! $posts || is_a( $posts, 'WP_Error' ) )
			return array();
		
		foreach( $posts as $p ) {
			$temp[$p->ID] = $p->post_title;
		}
		
		return $temp;
	}
}

/**
 * The LT widget/settings expect you to parse an array of choices
 * in a $key => $value structure. This function does the heavy
 * lifting for any taxonomy.
 */
if( ! function_exists( '_ltcon_format_taxonomy_to_array' ) ) {
	
	function _ltcon_format_taxonomy_to_array( $terms ) {
		
		if( ! $terms || is_a( $terms, 'WP_Error' ) )
			return array();
		
		foreach( $terms as $t ) {
			$temp[$t->term_id] = $t->name . ' (' . $t->count . ')';
		}
		
		return $temp;
	}
}

/**
 * Helper function, makes it easy to get
 * posts in a $key => $value structured array
 */
if( ! function_exists( 'ltcon_get_posts' ) ) {
	
	function ltcon_get_posts( $args = array() ) {
		
		return _ltcon_format_post_to_array( get_posts( $args ) );
	}
}

/**
 * Helper function, makes it easy to get
 * pages in a $key => $value structured array
 */
if( ! function_exists( 'ltcon_get_pages' ) ) {
	
	function ltcon_get_pages( $args = array() ) {
		
		return _ltcon_format_post_to_array( get_pages( $args ) );
	}
}

/**
 * Helper function, makes it easy to get
 * any terms in a $key => $value structured array
 */
if( ! function_exists( 'ltcon_get_terms' ) ) {
	
	function ltcon_get_terms( $term = 'category', $args = array() ) {
		
		return _ltcon_format_taxonomy_to_array( get_terms( $term, $args ) );
	}
}

/**
 * Helper function, makes it easy to get
 * categories in a $key => $value structured array
 */
if( ! function_exists( 'ltcon_get_categories' ) ) {
	
	function ltcon_get_categories( $args = array() ) {
		
		return ltcon_get_terms( 'category', $args );
	}
}

/**
 * Helper function, makes it easy to get
 * tags in a $key => $value structured array
 */
if( ! function_exists( 'ltcon_get_tags' ) ) {
	
	function ltcon_get_tags( $args = array() ) {
		
		return ltcon_get_terms( 'post_tag', $args );
	}
}

/**
 * Sort an array based on another array. The values from
 * $order_array are used to order the keys from $array
 */
if( ! function_exists( 'ltcon_sort_array_by_array' ) ) {
	
	function ltcon_sort_array_by_array( Array $array, Array $order_array ) {
		
		$ordered = array();
		
		foreach( $order_array as $key ) {
			
			if( array_key_exists( $key, $array ) ) {
				
				$ordered[$key] = $array[$key];
				unset( $array[$key] );
			}
		}

		return $ordered + $array;
	}
}

/**
 * Set IE headers in PHP as the <meta> version
 * throws w3c validation errors
 */
if( ! function_exists( 'ltcon_custom_http_headers' ) ) {
	
	function ltcon_custom_http_headers() {
		
		header( 'X-UA-Compatible: IE=Edge, chrome=1' );
	}
	add_action( 'send_headers', 'ltcon_custom_http_headers' );
}

/**
 * Add a favicon, all you need to do is add a favicon.ico
 * or favicon.png file into the images folder and it'll do
 * the rest.
 */
if( ! function_exists( 'ltcon_favicon' ) )
{
	function ltcon_favicon() {
		
 		$uri = false;
		$ico = '/images/favicon.ico';
		$png = '/images/favicon.png';
 	   
		// Check if a favicon exists in either of the above paths
		if( file_exists( LTCON_ASSETS_PATH . $ico ) )
			$uri = LTCON_ASSETS_URI . $ico;
 		elseif( file_exists( LTCON_ASSETS_PATH . $png ) )
 			$uri = LTCON_ASSETS_URI . $png;
		
		if( ! $uri )
			return;
		
 		echo '<link rel="shortcut icon" href="' . esc_url( $uri ) . '" />';
	}
	add_action( 'wp_head', 'ltcon_favicon', 1 );
}

/**
 * Remove all the pointless junk WordPress adds to the
 * document <head> tag.
 */
if( ! function_exists( 'ltcon_cleanup_head' ) ) {
	
	function ltcon_cleanup_head() {
	
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'index_rel_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
	}
	add_action( 'init', 'ltcon_cleanup_head', 99 );
}

/**
 * Format the wp_title() via a hook, rather than hardcoding
 * bloginfo() and various others into the header.php
 */
if( ! function_exists( 'ltcon_format_wp_title' ) ) {
	
	function ltcon_format_wp_title( $title, $sep ) {
		
		global $page, $paged;
		
		if( is_feed() )
			return $title;
		
		$title .= get_bloginfo( 'name' );
		
		$site_description = get_bloginfo( 'description', 'display' );
		
		if( $site_description && ( is_home() || is_front_page() ) )
			$title = "$title $sep $site_description";
		
		if( $paged >= 2 || $page >= 2 )
			$title = "$title $sep " . sprintf( __( 'Page %s', LTCON_THEME_TEXTDOMAIN ), max( $paged, $page ) );
		
		return $title;
	}
	add_filter( 'wp_title', 'ltcon_format_wp_title', 10, 2 );
}

/**
 * Add our custom media sizes to the dropdown of available
 * media inserts when adding an image to a page.
 */
if( ! function_exists( 'ltcon_add_image_size_to_media' ) ) {
	
	function ltcon_add_image_size_to_media( $sizes ) {
		
		global $_wp_additional_image_sizes;
		
		if( empty( $_wp_additional_image_sizes ) )
			return $sizes;

		foreach( $_wp_additional_image_sizes as $key => $data ) {

			if( ! isset( $sizes[$key] ) )
				$sizes[$key] = ucfirst( str_replace( '-', ' ', $key ) );
		}

		return $sizes;
	}
	add_filter( 'image_size_names_choose', 'ltcon_add_image_size_to_media' );
}

/**
 * Archive pagination
 */
if( ! function_exists( 'ltcon_archive_pagination' ) ) {
	
	function ltcon_archive_pagination() {
		
		global $wp_query;
		
		if( $wp_query->max_num_pages < 2 )
			return;
		
		$big = 999999999;
		
		$links = paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total' => $wp_query->max_num_pages,
			'type' => 'array'
		) );
			
		?>
		<nav class="navigation archive-pagination" role="navigation">
			<?php

			echo '<ul class="pagination"><li>';
			echo join( '</li><li>', $links );
			echo '</li></ul>';

			?>
		</nav>
		<?php
	}
}

/**
 * Does exactly the same as comments_number, but instead it
 * returns the data, rather than echoing it.
 */
if( ! function_exists( 'ltcon_get_comments_number' ) ) {

	function ltcon_get_comments_number() {

		$num_comments = get_comments_number();

		if( comments_open() ) {

			if( $num_comments == 0 ) {

				$comments = __( '0 Comments', LTCON_THEME_TEXTDOMAIN );

			} elseif( $num_comments > 1 ) {

				$comments = $num_comments . __( ' Comments', LTCON_THEME_TEXTDOMAIN );

			} else {

				$comments = __( '1 Comment', LTCON_THEME_TEXTDOMAIN );

			}

			$write = '<a href="' . get_comments_link() . '">' . $comments . '</a>';

		} else {

			$write =  __( 'Comments are off for this post.', LTCON_THEME_TEXTDOMAIN );
		}

		return $write;
	}
}

/**
 * Fix tags around shortcodes, for some reason
 * WordPress has a habit of soutputting empty
 * <p> and <br/> tags aruond shortcodes
 */
if( ! function_exists( 'ltcon_fix_shortcodes' ) ) {

	function ltcon_fix_shortcodes( $content ) {

		$array = array (
			'<p>[' => '[', 
			']</p>' => ']', 
			']<br />' => ']'
		);

		return strtr( $content, $array );
	}
	add_filter( 'the_content', 'ltcon_fix_shortcodes' );
}

/**
 * Add support for custom classes within the wordpress
 * posts/pages admin panel (like thesis)
 */
if( ! function_exists( 'ltcon_add_class_to_body_tag' ) ) {

	function ltcon_add_class_to_body_tag( $classes ) {

		if( ! is_singular() )
			return $classes;

		$newclasses = get_post_meta( get_queried_object()->ID, '_custom_class', true );

		if( strlen($newclasses) > 0 )
			$classes[] = $newclasses;
		
		return $classes;
	}
	add_filter( 'body_class', 'ltcon_add_class_to_body_tag' );
}

/**
 * Add oembed responsive support, basically just wraps
 * the embed in .responsive-video
 */
if( ! function_exists( 'ltcon_responsive_oembeds' ) ) {

	function ltcon_responsive_oembeds( $html, $url, $attr ) {

		$resize = false;
		$accepted_providers = array(
			'youtube',
			'vimeo',
			'slideshare',
			'dailymotion',
			'viddler.com',
			'hulu.com',
			'blip.tv',
			'revision3.com',
			'funnyordie.com',
			'wordpress.tv',
			'scribd.com',
		);

		foreach ( $accepted_providers as $provider ) {
			if ( strstr( $url, $provider ) ) {
				$resize = true;
				break;
			}
		}

		$embed = preg_replace( '/\s+/', '', $html );
		$embed = trim( $embed );

		$html = '<div class="embed-responsive embed-responsive-16by9">' . $embed . '</div>';

		return $html;
	}
	add_filter( 'embed_oembed_html', 'ltcon_responsive_oembeds', 1, 3 );
}

/**
 * Editing label names for taxonomies are annoyingly slow
 * so this function helps you do this faster.
 *
 * @param $singular string
 * @param $plural string
 */
if( ! function_exists( 'ltcon_format_taxonomy_labels' ) ) {
	
	function ltcon_format_taxonomy_labels( $singular, $plural = '' )
	{
		if( empty( $plural ) )
			$plural = $singular . 's';

		$labels = array(
			'name' => $plural,
			'singular_name' => $singular,
			'search_items' => sprintf( 'Search %s', $plural ),
			'all_items'  => sprintf( 'All %s', $plural ),
			'parent_item' => sprintf( 'Parent %s', $singular ),
			'parent_item_colon' => sprintf( 'Parent %s:', $singular ),
			'edit_item' => sprintf( 'Update %s', $singular ),
			'update_item' => sprintf( 'Update %s', $singular ),
			'add_new_item' => sprintf( 'Add New %s', $singular ),
			'new_item_name' => sprintf( 'New %s Name', $singular ),
			'menu_name' => $singular,
		);

		return $labels;
	}
}

/**
 * Editing label names for post types are annoyingly slow
 * so this function helps you do this faster.
 *
 * @param $singular string
 * @param $plural string
 */
if( ! function_exists( 'ltcon_format_posttype_labels' ) ) {
	
	function ltcon_format_posttype_labels( $singular, $plural = '' )
	{
		if( empty( $plural ) )
			$plural = $singular . 's';

		$labels = array(
			'name' => $plural,
			'singular_name' => $singular,
			'add_new' => __( 'Add New' ),
			'add_new_item' => sprintf( 'Add New %s', $singular ),
			'edit_item' => sprintf( 'Edit %s', $singular ),
			'new_item' => sprintf( 'New %s', $singular ),
			'all_items' => sprintf( 'All %s', $plural ),
			'view_item' => sprintf( 'View %s', $singular ),
			'search_items' => sprintf( 'Search %s', $plural ),
			'not_found' =>  sprintf( 'No %s found', strtolower( $plural ) ),
			'not_found_in_trash' => sprintf( 'No %s found in trash', strtolower( $plural ) ),
			'parent_item_colon' => '',
			'menu_name' => $plural
		);

		return $labels;
	}
}