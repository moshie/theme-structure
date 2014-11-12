<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<?php

		/**
		 * Display H1 tag if it's the single page, otherwise
		 * it'll display an H2 tag, also add a link if it's not
		 * the single page.
		 */
		$before = $after = '';
		$tag = 'h1';

		if( ! is_singular() ) {

			$title = __( 'Permalink to:', LTCON_THEME_TEXTDOMAIN ) . ' ' . get_the_title();
			$before = '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( $title ) . '">';
			$after = '</a>';
			$tag = 'h2';
		}

		the_title( sprintf( '<%s class="article-title">%s', $tag, $before ), sprintf( '%s</%s>', $after, $tag ) ); ?>

		<div class="entry-meta">

			<?php

			/**
			 * Display the entry meta, date/category & number of comments
			 */
			printf(
				__( 'Posted on <time datetime="%s">%s</time> in %s with %s', LTCON_THEME_TEXTDOMAIN ),
				get_the_date( 'Y-m-d\TH:i:s' ),
				get_the_date(),
				get_the_term_list( get_the_ID(), 'category', '', ', ', '' ),
				ltcon_get_comments_number()
			);

			?>

		</div>

	</header>

	<div class="entry-body">

		<?php if( is_singular() ) :

			the_content();

		else :

			the_excerpt(); ?>

			<div class="entry-more">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( __( 'Permalink to:', LTCON_THEME_TEXTDOMAIN ) ) . ' ' . get_the_title(); ?>" class="btn btn-primary"><?php _e( 'Read More', LTCON_THEME_TEXTDOMAIN ); ?></a>
			</div>

		<?php endif; ?>

	</div>

	<footer class="entry-footer">

		<?php wp_link_pages(); ?>

		<?php comments_template(); ?>

	</footer>

</article>