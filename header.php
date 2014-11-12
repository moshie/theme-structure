<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<title><?php wp_title( '|', true, 'right' ); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11"/>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>

	<?php global $is_IE; if( $is_IE ) : ?><!--[if lt IE 9]>
	<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]--><?php endif; ?>

	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

<?php do_action( 'ltcon_open_bodytag' ); ?>

<a href="#main" class="sr-only"><?php _e( 'Skip to content', LTCON_THEME_TEXTDOMAIN ); ?></a>

<div class="wrapper">

	<header role="banner" class="header">
		<div class="header-main">
			<div class="container">

				<div class="logo">
					<a href="<?php echo esc_url( home_url() ); ?>"
					   title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">

						<?php if ( file_exists( LTCON_ASSETS_PATH . '/images/logo.png' ) ) : ?>
							<img src="<?php echo esc_url( LTCON_ASSETS_URI . '/images/logo.png' ); ?>"
							     alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
						<?php endif; ?>

						<strong<?php echo file_exists( LTCON_ASSETS_PATH . '/images/logo.png' ) ? ' class="sr-only"' : ''; ?>><?php bloginfo( 'name' ); ?></strong>
					</a>
				</div>

			</div>
		</div>

		<nav role="navigation" class="navigation navigation-primary">
			<div class="navbar navbar-default">
				<div class="container">

					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse"
						        data-target=".navbar-primary-collapse">
							<span class="sr-only"><?php _e( 'Toggle navigation', LTCON_THEME_TEXTDOMAIN ); ?></span>
							<span><?php _e( 'Menu', LTCON_THEME_TEXTDOMAIN ); ?></span>
						</button>
					</div>

					<?php wp_nav_menu( array(
						'theme_location'  => 'primary',
						'container'       => 'div',
						'container_class' => 'collapse navbar-collapse navbar-primary-collapse',
						'menu_class'      => 'nav navbar-nav',
						'depth'           => 2,
						'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
						'walker'          => new wp_bootstrap_navwalker()
					) ); ?>

				</div>
			</div>
		</nav>
	</header>

	<main id="main" class="site-main" role="main">