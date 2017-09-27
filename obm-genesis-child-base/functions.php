<?php
/*
* Theme Name: OBM-Genesis-Child
* Author: Orange Blossom Media
* URI: https://orangeblossommedia.com/
*/

/* --- DEFINE CHILD THEME --- */

// CHILD_DIR defined in Genesis
define( 'CHILD_THEME_NAME', 'obm-genesis-child' );
define( 'CHILD_THEME_URL', 'http://obm-genesis-child.com/' );

/* --- THEME SETUP --- */


// Activate the child theme
// All core child theme actions and filters hooked here
add_action( 'genesis_setup','obm_theme_setup', 15 );
function obm_theme_setup() {

	// Sets up child, including scripts and styles
	include_once( CHILD_DIR . '/lib/child_setup.php');

	// Child theme functions
	include_once( CHILD_DIR . '/lib/child_theme_functions.php');

	// Child theme admin area functions
	include_once( CHILD_DIR . '/lib/admin_functions.php');

	// Setup theme defaults
	include_once( get_stylesheet_directory() . '/lib/theme_defaults.php' );

	// Mobile Detection PHP support
	// https://github.com/serbanghita/Mobile-Detect
	include_once( CHILD_DIR . '/lib/Mobile_Detect.php');
	$detect = new Mobile_Detect;

	// Stop updates from WordPress repo
	add_filter( 'http_request_args', 'obm_dont_update', 5, 2 );


	/* --- THEME SUPPORT --- */

	// Turn On HTML5 Markup @since GENESIS 2.0 final
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'
	) );

	// Add structural support
	add_theme_support( 'genesis-structural-wraps', array(
		'header',
		'nav',
		'subnav',
		'site-inner',
		'footer-widgets',
		'footer'
	) );


	// Menus
	add_theme_support( 'genesis-menus', array(//theme_menus
	) );


	/* --- LAYOUTS, SIDEBARS, AND WIDGETS --- */

	// Remove Page Template Layouts//unregister_layouts

	// Remove Sidebars//unregister_sidebars

	// Add footer widgets//footer_widgets

	// Additional Sidebars//sidebars


	/* --- <HEAD> ELEMENTS --- */

	// Remove default stylesheet
	remove_action( 'genesis_meta', 'genesis_load_stylesheet' );

	// Enqueue base scripts and styles
	// See /lib/child_setup.php
	add_action( 'wp_enqueue_scripts', 'obm_scripts_and_styles', 999 );

	// Add viewport meta tag for mobile browsers @since GENESIS 2.0
	add_theme_support( 'genesis-responsive-viewport' );

	// Remove rsd link
	remove_action( 'wp_head', 'rsd_link' );
	// Remove Windows Live Writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// Remove links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// Remove WP version
	remove_action( 'wp_head', 'wp_generator' );


	/* --- CHILD THEME IMAGES --- */
	/*
		* To add more sizes, simply copy a line from below and change the dimensions & name.
		  As long as you upload a "featured image" as large as the biggest set width or height,
		  all the other sizes will be auto-cropped.

		* To call a different size, simply change the text inside the thumbnail function.

		* You can change the names and dimensions to whatever you like.
	*/

	//image_sizes

	// Change image to default to no link
	update_option( 'image_default_link_type' , 'none' );


	/* --- HEADER AREA --- */

	// Add support for custom logo header
	add_theme_support( 'custom-header', array(
		'default-color'		=> '000000',
		'header-selector'	=> '.site-title a',
		'header-text'		=> false,
		'flex-height'		=> true,
		'flex-width'		=> true,
		'height'			=> 100,
		'width'				=> 200,
	) );


	// Reposition the navigation
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_before_header', 'genesis_do_nav' );
	remove_action( 'genesis_after_header', 'genesis_do_subnav' );

	// Remove Header Title and Tagline
	// remove_action( 'genesis_site_title', 'genesis_seo_site_title' );
	// remove_action( 'genesis_site_description', 'genesis_seo_site_description' );


	/* --- FOOTER AREA --- */

	// Add footer credit & attribution text
	add_filter( 'genesis_footer_creds_text', 'obm_footer_cred' );


	/* --- POSTS --- */

	// Remove Post Meta
	// remove_action( 'genesis_before_entry_content', 'genesis_post_info', 99 );

	// Reposition Post Image
	// remove_action( 'genesis_post_content', 'genesis_do_post_image' );
	// add_action( 'genesis_before_post', 'genesis_do_post_image' );

}
