<?php
/*************************************************************
ALL CAPS CASE
**************************************************************/

/** Proper Case
**************************************************************/

/** Proper Case **/

/*
Comments Single Line
or Multiple Line
*/

/*************************************************************
FUNCTION TABLE OF CONTENTS
**************************************************************/
require_once('inc/functions-base.php');
/*------------------------------------------------------------------
LAUNCH TABULA RASA
	- tr_launch()
WP_HEAD GOODNESS	
	- head cleanup (remove rss, uri links, junk css, ect)
	- remove WP version from RSS
	- remove WP version from scripts
	- remove injected CSS for recent comments widget
	- remove injected CSS from recent comments widget
	- remove injected CSS from gallery
SCRIPTS & ENQUEUEING		
	- modernizer
	- main stylesheet
	- IE only stylesheet
	- comment reply script for threaded comments
	- scripts.js
	- mobile menu script
THEME SUPPORT	
	- add_theme_support('post-thumbnails')
	- add_editor_style( get_template_directory_uri() . '/css/editor-style.css' )
	- add_theme_support( 'custom-background')
	- add_theme_support('automatic-feed-links')
	- add_theme_support( 'post-formats') 
	- add_theme_support( 'menus' )
	- register_nav_menus( 'The Main Menu', 'The Secondary Menu', 'Footer Links' )
MENUS & NAVIGATION	
	- tr_main_nav()
	- tr_sec_nav()
	- tr_footer_links()
	- tr_main_nav_fallback()
	- tr_sec_nav_fallback()
	- tr_footer_links_fallback()
	- tr_register_sidebars( 'Main Sidebar', 'Secondary Widget Area' )
	- removing <p> from around images
	- tr_content_nav( $html_id )
		// Displays navigation to next/previous pages when applicable.		
	
MISC
	- Custom Header
	- remove the p from around imgs 
	- tr_get_the_author_posts_link()
		// This is a modified the_author_posts_link() which just returns the link.
	- of_get_option
		// This function is needed by inc/theme-options-inc
	- Meta Boxes
		// This function is needed by inc/metabox
------------------------------------------------------------------*/

require_once('inc/functions-site.php');
/*------------------------------------------------------------------
SITE SPECIFIC FUNCTIONS
	- tr_site_specific_support()
	- tr_excerpt_more()
		// This removes the annoying […] to a Read More link
	- tr_register_site_specific_sidebars()
	- tr_entry_meta()
COMMENT LAYOUT 
	- tr_comment()
MISC
	 - remove_default_post_formats()
	 - Google Analytics
------------------------------------------------------------------*/

require_once('inc/functions-admin.php'); 
/*------------------------------------------------------------------
ADMIN MENU
	- remove_admin_menus ()
	- edit_admin_menu_titles()
	- custom_menu_order($menu_ord)
WORDPRESS ADMIN BAR
	- remove admin bar
	- remove admin bar except admin
	- remove admin bar from admin area
	- remove admin bar from from end
	- remove_admin_bar_links()
	- custom_adminbar_menu()
		// Add custom link to admin bar
	- remove margin from the admin bar
DASHBOARD WIDGETS
	- disable_default_dashboard_widgets()
	- custom_dashboard_widgets()
CUSTOM LOGIN PAGE
	- tr_login_css()
	- tr_login_url()
	- tr_login_title()
CUSTOMIZE ADMIN 
	- load_custom_wp_admin_style()
		// Load admin css
	- tr_custom_admin_footer()
HELP PAGE
	-  my_help_menu
------------------------------------------------------------------*/

require_once('inc/custom-post-type.php'); 
/*------------------------------------------------------------------
CUSTOM POST TYPES
	- Construction Post Type
	- Status Taxonomy for Construction Type
	- Documents Taxonomy
	- Status Metabox
	- Documents Shortcode
Posts 2 Posts
	- my_connection_types() 
		// Associates construction posts to construction post types
------------------------------------------------------------------*/

require_once('inc/metabox/metabox-functions.php'); 


//require_once('inc/theme-options.php');
/** Creates "Theme Options" page under Appearance Tab

/*********************************************************
EVEYTHING BELOW THIS LINE IS THEME SPECIFIC!!
********************************************************/

/*------------------------------------------------------------------
If this is a function that you do not want to lose when you change themes, DO NOT put it in this file!

It goes in the Code Snippets plugin or the base-functions.php file in the mu-plugins folder
------------------------------------------------------------------*/

/*------------------------------------------------------------------
	- Google Fonts
THEME SUPPORT		
	- tr_theme_specific_support()
	- set_post_thumbnail_size()
	- tr_register_theme_specific_sidebars()
	
------------------------------------------------------------------*/

/** Google Fonts
**************************************************************/
function tr_theme_specific_scripts_and_styles() {
wp_register_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:400,700,800,600,300|Open+Sans+Condensed:700');
wp_enqueue_style( 'google-fonts' );
}
add_action('wp_enqueue_scripts', 'tr_theme_specific_scripts_and_styles', 999);


/*************************************************************
THEME SUPPORT
**************************************************************/

function tr_theme_specific_support() {
	// default thumb size
	set_post_thumbnail_size(150, 150, true);

	if ( function_exists( 'add_image_size' ) ) { 
		add_image_size( 'featured-home', 500, 250, true ); //500 pixels wide 
		add_image_size( 'featured-destination', 300, 280, true ); //300 pixels wide 
		add_image_size( 'page-banner', 640, 150, true ); //640 pixels wide 
	}	
}	
add_action('after_setup_theme','tr_theme_specific_support', 16);

function tr_register_theme_specific_sidebars() {
	/*register_sidebar( array(
		'name' => __( 'Main Sidebar', 'tabula_rasa' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'tabula_rasa' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. 

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php
	*/	
}
add_action( 'widgets_init', 'tr_register_theme_specific_sidebars' );
?>