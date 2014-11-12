<?php

if ( post_password_required() ) {
	return;
}

?>
<section id="comments" class="comments-area">

	<?php if ( comments_open() && have_comments() ) : ?>

		<h2 class="comments-title"><?php _e( 'Leave A Comment', LTCON_THEME_TEXTDOMAIN ); ?></h2>

	<?php endif;

	if ( have_comments() ) : ?>

		<ol class="comments-list media-list">
			<?php

			/**
			 * Output our list of comments, this uses a custom
			 * callback for our comments, which can be found in
			 * /theme/custom-functions.php
			 */
			wp_list_comments( array(
				'type'         => 'comment',
				'style'        => 'ol',
				'format'       => 'html5',
				'avatar_size'  => 70,
				'callback'     => 'ltcon_comments_callback',
				'end-callback' => 'ltcon_comments_callback_end'
			) );
			?>
		</ol>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>

			<p class="no-comments"><?php _( 'Comments are closed.', LTCON_THEME_TEXTDOMAIN ); ?></p>

		<?php endif;

	endif;

	comment_form( array(
		'comment_notes_after' => ''
	) );

	?>

</section>