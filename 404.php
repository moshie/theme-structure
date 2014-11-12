<?php get_header(); ?>

	<div class="container">

		<h1><?php _e( 'Page Not Found', LTCON_THEME_TEXTDOMAIN ); ?></h1>

		<p><?php _e( 'Sorry, it appears the page you were looking for doesn\'t exist anymore or it may have been moved. To help find your way back, please use your browsers back button, or follow one of the links below:', LTCON_THEME_TEXTDOMAIN ); ?></p>

		<ul>

			<li><a href="<?php echo esc_url( site_url() ); ?>"><?php _e( 'Return to our homepage', LTCON_THEME_TEXTDOMAIN ); ?></a></li>

			<?php if( get_option( 'page_for_posts' ) && wp_count_posts()->publish > 0 ) : ?>
				<li><a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php _e( 'Read our blog', LTCON_THEME_TEXTDOMAIN ); ?></a></li>
			<?php endif; ?>

			<?php if( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) : ?>

				<li><a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_shop_page_id' ) ) ); ?>"><?php _e( 'Visit our store', LTCON_THEME_TEXTDOMAIN ); ?></a></li>
				<li><a href="<?php echo esc_url( get_permalink( get_option( ' woocommerce_myaccount_page_id' ) ) ); ?>"><?php _e( 'View your account', LTCON_THEME_TEXTDOMAIN ); ?></a></li>

			<?php endif; ?>

		</ul>

	</div>

<?php get_footer(); ?>