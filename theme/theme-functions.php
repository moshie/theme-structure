<?php

/**
 * Custom format for blog/page comments. The default is a bit naff.
 * This is far better
 */
if( ! function_exists( 'ltcon_comments_callback' ) ) {
	
	function ltcon_comments_callback( $comment, $args, $depth ) {
		
		global $post;
		
		$GLOBALS['comment'] = $comment;
		
		switch( $comment->comment_type ) {
			
			case 'pingback' :
			case 'trackback' :
			
				break;
				
			case 'comment' : default :
				
				?>
				
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<article class="comment-article comment">
						<div class="comment-inner clearfix">
							
							<div class="comment-side pull-left">
								
								<div class="comment-avatar">
									<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
								</div>
								
							</div>
							
							<div class="comment-body pull-right">
								
								<header class="comment-header clearfix">
									
									<h3 class="comment-author pull-left"><?php comment_author_link(); ?></h3>
									
									<span class="comment-time pull-right">
										<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
											<time datetime="<?php echo esc_attr( get_comment_time( 'c' ) ); ?>"><?php echo esc_html( sprintf( __( '%1$s @ %2$s', LTCON_THEME_TEXTDOMAIN ), get_comment_date( 'm/d/y' ), get_comment_time( 'H:i' ) ) ); ?></time>
										</a>
									</span>
									
								</header>
								
								<div class="comment-content">
								
									<?php if( '0' == $comment->comment_approved ) : ?>
										<p class="awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', LTCON_THEME_TEXTDOMAIN ); ?></p>
									<?php endif; ?>
								
									<?php comment_text(); ?>
									
									<div class="reply text-right">
										<?php comment_reply_link( array( 'reply_text' => __( 'Reply', LTCON_THEME_TEXTDOMAIN ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ); ?>
									</div>
								
								</div>
								
							</div>
							
						</div>
					</article>
				
				<?php
				break;
		}
	}
}

/**
 * Closing tag for comment list
 */
if( ! function_exists( 'ltcon_comments_callback_end' ) ) {
	
	function ltcon_comments_callback_end() {
		
		echo '</li>';
	}
}

/**
 * Alter the comment form to support bootstraps
 * markup. Unfortunately, you cannot change the
 * class on the button :()
 */
if( ! function_exists( 'ltcon_comment_form_defaults' ) ) {

	function ltcon_comment_form_defaults( $defaults ) {

		$commenter = wp_get_current_commenter();

		$user = wp_get_current_user();
		$user_identity = $user->exists() ? $user->display_name : '';

		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		$html5 = 'html5' === $defaults['format'];

		$defaults['fields']['author'] = '<div class="form-group comment-form-author">
			<label for="author">' . __( 'Name', LTCON_THEME_TEXTDOMAIN ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label>
		    <input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' />
		</div>';

		$defaults['fields']['email'] = '<div class="form-group comment-form-email">
			<label for="email">' . __( 'Email', LTCON_THEME_TEXTDOMAIN ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label>
			<input id="email" class="form-control" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' />
		</div>';

		$defaults['fields']['url'] = '<div class="form-group comment-form-url">
			<label for="url">' . __( 'Website', LTCON_THEME_TEXTDOMAIN ) . '</label>
		    <input id="url" class="form-control" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
		</div>';

		$defaults['comment_field'] = '<div class="form-group comment-form-comment">
			<label for="comment">' . _x( 'Comment', 'noun' ) . '</label>
			<textarea id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea>
		</p>';

		return $defaults;
	}
	add_filter( 'comment_form_defaults', 'ltcon_comment_form_defaults' );
}




if( ! function_exists('add_scripts_wp_head'))
{
	function add_scripts_wp_head()
	{
		$text = lt()->settings->get('scripts_hook_before_close_head', '');
		
		if( strlen($text) == 0 )
			return;
		
		echo $text;
		
	}
	add_action('wp_head', 'add_scripts_wp_head');
}

if( ! function_exists('add_scripts_to_start_of_body_tag'))
{
	function add_scripts_to_start_of_body_tag()
	{
		$text = lt()->settings->get('scripts_hook_after_open_body', '');
		
		if( strlen($text) == 0 )
			return;
		
		echo $text;
		
	}
	add_action('ltcon_open_bodytag', 'add_scripts_to_start_of_body_tag');
}

if( ! function_exists('add_scripts_to_end_of_close_body_tag'))
{
	function add_scripts_to_end_of_close_body_tag()
	{
		$text = lt()->settings->get('scripts_hook_before_close_body', '');
		
		if( strlen($text) == 0 )
			return;
		
		echo $text;
		
	}
	add_action('wp_footer', 'add_scripts_to_end_of_close_body_tag');
}