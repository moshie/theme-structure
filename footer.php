</main>

<footer role="contentinfo" class="footer">

	<?php

	/**
	 * If you remove the widgets from the footer, don't
	 * forget to remove the corresponding register_sidebar() function
	 * which can be found in /theme/theme-widgets.php
	 */
	if( is_active_sidebar( 'footer' ) ) : ?>

		<div class="footer-main">
			<div class="container">
				<div class="row">

					<?php

					/**
					 * This by default outputs in 3 columns, to change this
					 * have a look at the 'before_widget' argument for the sidebar
					 * located in /theme/theme-widgets.php
					 */
					dynamic_sidebar( 'footer' ); ?>

				</div>
			</div>
		</div>

	<?php endif; ?>

	<div class="footer-bottom">

		<div class="container clearfix">
			<p class="copyright pull-left">&copy; Copyright <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
			<p class="lt pull-right">Website by, <a href="http://www.ltconsulting.co.uk/" title="LT Consulting Solutions">LT Consulting Solutions</a></p>
		</div>

	</div>

</footer>

</div>

<?php wp_footer(); ?>

</body>
</html>