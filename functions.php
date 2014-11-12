<?php

/*
	 _   _____    ____                      _ _   _             
	| | |_   _|  / ___|___  _ __  ___ _   _| | |_(_)_ __   __ _ 
	| |   | |   | |   / _ \| '_ \/ __| | | | | __| | '_ \ / _` |
	| |___| |   | |__| (_) | | | \__ \ |_| | | |_| | | | | (_| |
	|_____|_|    \____\___/|_| |_|___/\__,_|_|\__|_|_| |_|\__, |
                                                          |___/ 
*/

/**
 * Define various constants
 */
define( 'LTCON_THEME_SLUG', 'ltconsulting' );
define( 'LTCON_THEME_OPTIONS_KEY', 'ltcon-settings' );
define( 'LTCON_THEME_TEXTDOMAIN', LTCON_THEME_SLUG );
define( 'LTCON_ADMIN_TEXTDOMAIN', LTCON_THEME_SLUG . '-admin' );

define( 'LTCON_THEME_PATH', untrailingslashit( get_template_directory() ) );
define( 'LTCON_THEME_URI', untrailingslashit( get_template_directory_uri() ) );

/**
 * If you're using grunt chances are all your assets will
 * be in /build. Otherwise they'll probably be in /assets
 */
define( 'LTCON_ASSETS_PATH', LTCON_THEME_PATH . '/resources' );
define( 'LTCON_ASSETS_URI', LTCON_THEME_URI . '/resources' );


/**
 * Overwrite the default path for bootstrap shortcodes
 * plugin so that we can use it in our theme
 */
define( 'BS_SHORTCODES_DIR', LTCON_THEME_PATH . '/includes/vendor/bootstrap-3-shortcodes/includes/' );
define( 'BS_SHORTCODES_URL', LTCON_THEME_URI . '/includes/vendor/bootstrap-3-shortcodes/includes/' );

/**
 * Include misc files
 */
require_once( LTCON_THEME_PATH . '/includes/classes/field.class.php' );
require_once( LTCON_THEME_PATH . '/includes/classes/settings.class.php' );
require_once( LTCON_THEME_PATH . '/includes/classes/metabox.class.php' );

require_once( LTCON_THEME_PATH . '/includes/vendor/bootstrap-nav-walker.php' );
require_once( LTCON_THEME_PATH . '/includes/vendor/bootstrap-3-shortcodes/bootstrap-shortcodes.php' );

require_once( LTCON_THEME_PATH . '/includes/framework.php' );
require_once( LTCON_THEME_PATH . '/includes/options.php' );
require_once( LTCON_THEME_PATH . '/includes/misc.php' );
require_once( LTCON_THEME_PATH . '/includes/metabox.php' );
require_once( LTCON_THEME_PATH . '/includes/debug.php' );

/**
 * Admin specific files
 */
require_once( LTCON_THEME_PATH . '/includes/admin/admin.php' );
require_once( LTCON_THEME_PATH . '/includes/admin/branding.php' );

/**
 * Theme specific files
 */
require_once( LTCON_THEME_PATH . '/theme/theme-functions.php' );
require_once( LTCON_THEME_PATH . '/theme/theme-setup.php' );
require_once( LTCON_THEME_PATH . '/theme/theme-hooks.php' );
require_once( LTCON_THEME_PATH . '/theme/theme-scripts-n-styles.php' );
require_once( LTCON_THEME_PATH . '/theme/theme-posttypes.php' );
require_once( LTCON_THEME_PATH . '/theme/theme-metaboxes.php' );
require_once( LTCON_THEME_PATH . '/theme/theme-widgets.php' );
require_once( LTCON_THEME_PATH . '/theme/theme-shortcodes.php' );
require_once( LTCON_THEME_PATH . '/theme/theme-options.php' );