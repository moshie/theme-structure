<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-header">

		<?php if ( ! is_front_page() ) : ?>

			<div class="entry-header">

				<?php

				$before = $after = '';

				if ( ! is_singular() ) {

					$title  = __( 'Permalink to:', LTCON_THEME_TEXTDOMAIN ) . ' ' . get_the_title();
					$before = '<a href="' . esc_url( get_permalink() ) . '" title="' . esc_attr( $title ) . '">';
					$after  = '</a>';
				}

				the_title( sprintf( '<h1 class="article-title">%s', $before ), sprintf( '%s</h1>', $after ) ); ?>

			</div>

		<?php endif; ?>

	</div>

	<div class="entry-body">

		<?php the_content(); ?>

	</div>

	<footer class="entry-footer">

		<?php wp_link_pages(); ?>

		<?php // comments_template(); ?>

	</footer>

</article>