<?php get_header(); ?>

	<div class="container">

		<div class="row">

			<div class="content col-sm-8">

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_type() ); ?>

				<?php endwhile; ?>

				<?php else : ?>

					<?php _e( 'Sorry, no posts matched your criteria', LTCON_THEME_TEXTDOMAIN ); ?>

				<?php endif; ?>

				<?php ltcon_archive_pagination(); ?>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>

<?php get_footer();