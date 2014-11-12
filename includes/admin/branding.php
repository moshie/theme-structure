<?php

/**
 * Plugin Name: LT Branding
 * Author: LT Consulting Solutions Ltd.
 * Author URI: http://www.ltconsulting.co.uk/
 * Description: Modifies the WordPress admin panel branding
 */

if( ! defined( 'LTCON_BRANDING_URI' ) )
	define( 'LTCON_BRANDING_URI', untrailingslashit( get_template_directory_uri() ) );

if( ! defined( 'LTCON_BRANDING_PATH' ) )
	define( 'LTCON_BRANDING_PATH', untrailingslashit( get_template_directory() ) );

$ltcon_branding = array();

/*








	Modify the default WordPress dashboard metaboxes

*/

if( ! function_exists( 'ltcon_branding_setup_settngs' ) ) {
	
	function ltcon_branding_setup_settngs() {

		global $ltcon_branding;

		$settings = array(

			// The company/branding name
			'branding_name' => 'LT Consulting Solutions',

			// The company/branding email address
			'branding_email' => 'support@ltconsulting.co.uk',

			// The company/branding website
			'branding_website' => 'http://www.ltconsulting.co.uk',

			// The company/branding logo
			'branding_logo' => LTCON_BRANDING_URI . '/includes/admin/assets/images/logo.png',
			'branding_logo_path' => LTCON_BRANDING_PATH . '/includes/admin/assets/images/logo.png',

			// The company/banding office or mobile number
			'branding_phone' => '01442 877 473',
			
			// Logo to use on the wordpress login screen
			'branding_login_logo' => LTCON_BRANDING_URI . ( file_exists( LTCON_BRANDING_PATH . '/assets/images/logo.png' ) ? '/assets/images/logo.png' : '/includes/admin/assets/images/logo.png' ),
			'branding_login_logo_path' => LTCON_BRANDING_PATH . ( file_exists( LTCON_BRANDING_PATH . '/assets/images/logo.png' ) ? '/assets/images/logo.png' : '/includes/admin/assets/images/logo.png' ),
			
			// The link on the wordpress login logo
			'branding_login_link' => ( file_exists( LTCON_BRANDING_PATH . '/assets/images/logo.png' ) ? get_bloginfo( 'url' ) : 'http://www.ltconsulting.co.uk' ),
			
			// The tooltop when hovering the login logo
			'branding_login_tooltip' => ( file_exists( LTCON_BRANDING_PATH . '/assets/images/logo.png' ) ? get_bloginfo( 'name' ) : 'LT Consulting Solutions' ),

			// Text to be displayed within the wp-admin footer
			// Replaces the default "Powered by WordPress" text
			'admin_footer_text' => 'Powered by <a href="http://wordpress.org/">WordPress</a>, Built by <a href="%4$s">%1$s</a>',

			// The company name, brand name, or other name you with to
			// display within the metabox "header" area
			'dashboard_metabox_label' => 'LT Consulting Support',

			// The text used for the metabox, you can always scroll down and
			// modify the text if you want something really custom
			'dashboard_metabox_text' => 'You can email our support team at <a href="mailto:%2$s">%2$s</a>, or call us on <strong>%3$s</strong> if you need some assistance.',

			// Whether or not to remove the CORE wordpress metaboxes. This will
			// not effect any custom metaboxes added by third party plugins
			'remove_dashboard_metaboxes' => true,

			// An array of "allowed" dashboard metaboxes. For a full list, dump
			// out the $wp_meta_boxes array while on the dashboard page.
			'allowed_dashboard_metaboxes' => array( 'dashboard_right_now', 'dashboard_activity' )

		);

		$ltcon_branding = apply_filters( 'ltcon_branding_settings', $settings );
	}
	add_action( 'after_setup_theme', 'ltcon_branding_setup_settngs', 0 );
}

/*








	Remove some of the default WordPress dashboard metaboxes

*/

if( ! function_exists( 'ltcon_branding_remove_dashboard_widgets' ) ) {
	
	function ltcon_branding_remove_dashboard_widgets() {

		global $ltcon_branding, $wp_meta_boxes;

		if( ! is_array( $wp_meta_boxes ) || false == $ltcon_branding['remove_dashboard_metaboxes'] )
			return;

		foreach( $wp_meta_boxes['dashboard'] as $context => $types ) {
			foreach( $types['core'] as $metabox ) {
				
				if( is_array( $ltcon_branding['allowed_dashboard_metaboxes'] ) && in_array( $metabox['id'], $ltcon_branding['allowed_dashboard_metaboxes'] ) )
					continue;

				remove_meta_box( $metabox['id'], 'dashboard', $context );
			}
		}
	}
	add_action( 'wp_dashboard_setup', 'ltcon_branding_remove_dashboard_widgets' );
}

/*








	Add some custom dashboard metaboxe(s)

*/

if( ! function_exists( 'ltcon_branding_add_dashboard_widgets' ) ) {
	
	function ltcon_branding_add_dashboard_widgets() {

		global $ltcon_branding, $wp_meta_boxes;

		wp_add_dashboard_widget( 'dashboard_agency_branding', $ltcon_branding['dashboard_metabox_label'], 'ltcon_branding_dashboard_agency_widget_callback', null );
	}
	add_action( 'wp_dashboard_setup', 'ltcon_branding_add_dashboard_widgets' );
}

/*








	Our "branded" agency widget callback.

*/

if( ! function_exists( 'ltcon_branding_dashboard_agency_widget_callback' ) ) {
	
	function ltcon_branding_dashboard_agency_widget_callback() {

		global $ltcon_branding, $wp_meta_boxes;

		$image = getimagesize( $ltcon_branding['branding_logo_path'] ) ? getimagesize( $ltcon_branding['branding_logo_path'] ) : false;
		$text = '';

		if( isset( $ltcon_branding['dashboard_metabox_text'] ) && ! empty( $ltcon_branding['dashboard_metabox_text'] ) ) {

			$text = sprintf( $ltcon_branding['dashboard_metabox_text'], $ltcon_branding['branding_name'], $ltcon_branding['branding_email'], $ltcon_branding['branding_phone'], $ltcon_branding['branding_website'] );
		}

		?>

		<style>

		.ltcon-metabox-footer {
			border-top: 1px solid #DDDDDD;
		}
		.ltcon-text-right {
			text-align: right;
		}
		.ltcon-text-right p {
			margin-bottom: 0;
			margin-top: 8px;
		}
		.ltcon-metabox .ltcon-metabox-inner {
			margin-left: <?php echo $image[0] ? ( $image[0] + 15 ) : 115; ?>px;
		}
		.ltcon-metabox .ltcon-metabox-side {
			margin-left: <?php echo $image[0] ? ( $image[0] + 15 ) * -1 : -115; ?>px;
		}
		.ltcon-metabox .ltcon-metabox-side {
			width: <?php echo $image[0] ? $image[0] : 100; ?>px;
			float: left;
		}
		.ltcon-metabox .ltcon-metabox-main {
			width: 100%;
			float: left;
			border-left: 1px solid #DDDDDD;
			padding-left: 15px;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}
		.ltcon-metabox .ltcon-metabox-main, .ltcon-metabox .ltcon-metabox-side {
			margin-bottom: 10px;
		}
		.ltcon-metabox .ltcon-metabox-side img {
			max-width: 100%;
			height: auto;
		}
		.ltcon-clearfix:before, .ltcon-clearfix:after {
			content: '';
			display: table;
		}
		.ltcon-clearfix:after {
			clear: both;
		}

		</style>

		<?php

		echo '<div class="ltcon-metabox">';

			if( $image ) :

			echo '<div class="ltcon-metabox-inner ltcon-clearfix">';

				echo '<div class="ltcon-metabox-side">';
					echo '<img src="' . esc_url( $ltcon_branding['branding_logo'] ) . '" alt="' . esc_attr( $ltcon_branding['branding_name'] ) . '" />';
				echo '</div>';

				echo '<div class="ltcon-metabox-main">';
					echo $text;
				echo '</div>';

			echo '</div>';

			else :

				echo $text;

			endif;

		echo '</div>';


		?>
		<div class="ltcon-text-right ltcon-metabox-footer">
			<p>Website by, <a href="<?php echo esc_url( $ltcon_branding['branding_website'] ); ?>"><?php echo $ltcon_branding['branding_name']; ?></a></p>
		</div>
		<?php
	}
}

/*








	Change the "copyright" text in the footer

*/

if( ! function_exists( 'ltcon_branding_wpadmin_footer_text' ) ) {
	
	function ltcon_branding_wpadmin_footer_text( $string ) {

		global $ltcon_branding;

		if( strlen( trim( $ltcon_branding['admin_footer_text'] ) ) > 0 )
			$string = trim( sprintf( $ltcon_branding['admin_footer_text'], $ltcon_branding['branding_name'], $ltcon_branding['branding_email'], $ltcon_branding['branding_phone'], $ltcon_branding['branding_website'] ) );

		return wp_kses( $string, array(
			'a' => array( 'href' => array() ),
			'strong' => array(),
			'em' => array(),
			'i' => array(),
			'img' => array( 'src' => array(), 'alt' => array() )
		) );
	}
	add_filter( 'admin_footer_text', 'ltcon_branding_wpadmin_footer_text' );
}

if( ! function_exists('ltcon_branding_login_css'))
{
	function ltcon_branding_login_css()
	{
		global $ltcon_branding;
		
		$image = getimagesize( $ltcon_branding['branding_login_logo_path'] ) ? getimagesize( $ltcon_branding['branding_login_logo_path'] ) : false;
		
		$width = $image[0];
		$height = $image[1];
		$maxheight = 150;
		$maxwidth = 320;
		
		if($height > $maxheight)
		{
		    $num = $height / $maxheight;
		    $height = $height / $num;
		    $width = $width / $num;
		}
		
		if($width > $maxwidth)
		{
			$num = $width / $maxwidth;
			$height = $height / $num;
			$width = $width / $num;
		}
		
		?><style>
		
		.login h1 a {
			background-image: url(<?php echo esc_url( $ltcon_branding['branding_login_logo'] ); ?>);
			background-size: 100% auto;
			display: block;
			max-width: 320px;
			width: <?php echo $width . 'px'; ?>;
			height: <?php echo $height . 'px'; ?>;
		}
		
		</style><?php
	}
	add_action('login_head', 'ltcon_branding_login_css');
}

if( ! function_exists('ltcon_branding_login_logo_url'))
{
	function ltcon_branding_login_logo_url($url)
	{
		global $ltcon_branding;
		
		return $ltcon_branding['branding_login_link'];
	}
	add_filter('login_headerurl', 'ltcon_branding_login_logo_url');
}

if( ! function_exists('ltcon_branding_login_logo_title'))
{
	function ltcon_branding_login_logo_title($text)
	{
		global $ltcon_branding;
		
		return $ltcon_branding['branding_login_tooltip'];
	}
	add_filter('login_headertitle', 'ltcon_branding_login_logo_title');
}