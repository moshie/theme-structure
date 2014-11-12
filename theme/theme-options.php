<?php

/*

# Sections

You can add sections and sub sections using either:

lt()->settings->add_section( $handle, $label, $icon );
lt()->settings->add_subsection( $parent, $handle, $label );

The $handle, is the unique ID of that section, used to attach fields
to it. The $label is the wording the user will see. The $parent is
the unique ID of the top level section you want to create a sub section
for. The $icon is any glyphicon you can find from the bootstrap website:
http://getbootstrap.com/components/

# Fields

You can add fields using

lt()->settings->add_field( $handle, $args );

The $handle is the unique ID of that field, it will be used as
the name="" attribute. The $args is an array of arguments that could
contain the following keys:
 - section
 - label
 - type
 - placeholder
 - default
 - description
For more possibilies, look in the fields class (/includes/classes/field.class.php).

An example implementation of the theme options could be:

lt()->settings->add_section( 'general', __( 'General', LTCON_ADMIN_TEXTDOMAIN ), 'cog' );
lt()->settings->add_field( 'homepage_banner', array(
	'type' => 'upload',
	'label' => 'Homepage Banner Image',
	'description' => 'Upload an image to be used for banner. Recommended size: 960x220',
	'section' => 'general'
) );

*/

//
//
// Sections
//

lt()->settings->add_section( 'general', __( 'General', LTCON_ADMIN_TEXTDOMAIN ), 'cog' );
lt()->settings->add_section( 'misc', __( 'Misc', LTCON_ADMIN_TEXTDOMAIN ), 'fire' );
lt()->settings->add_subsection( 'misc', 'scripts-styles', __( 'Scripts/Styles', LTCON_ADMIN_TEXTDOMAIN ) );

//
//
// Fields
//

$args = array(
	'type' => 'textarea',
	'label' => __( 'Before Close Head', LTCON_ADMIN_TEXTDOMAIN ),
	'description' => __( 'Scripts/Styles to add before closing head tag.', LTCON_ADMIN_TEXTDOMAIN ),
	'section' => 'scripts-styles'
);
lt()->settings->add_field( 'scripts_hook_before_close_head', $args );

$args = array(
	'type' => 'textarea',
	'label' => __( 'After Opening Body', LTCON_ADMIN_TEXTDOMAIN ),
	'description' => __( 'Scripts/Styles to after the opening body tag.', LTCON_ADMIN_TEXTDOMAIN ),
	'section' => 'scripts-styles'
);
lt()->settings->add_field( 'scripts_hook_after_open_body', $args );

$args = array(
	'type' => 'textarea',
	'label' => __( 'Before Close Body', LTCON_ADMIN_TEXTDOMAIN ),
	'description' => __( 'Scripts/Styles to add before the closing body tag.', LTCON_ADMIN_TEXTDOMAIN ),
	'section' => 'scripts-styles'
);
lt()->settings->add_field( 'scripts_hook_before_close_body', $args );