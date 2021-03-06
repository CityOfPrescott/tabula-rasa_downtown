<?php
/*************************************************************
ADMIN MENU
**************************************************************/

function remove_admin_menus () {
	if (!current_user_can('manage_options')){ // Only proceed if user does not have admin role.
		remove_menu_page('index.php'); 				// Dashboard
		//remove_menu_page('edit.php'); 				// Posts
		//remove_menu_page('upload.php'); 			// Media
		//remove_menu_page('link-manager.php'); 			// Links
		//remove_menu_page('edit.php?post_type=page'); 		// Pages
		//remove_menu_page('edit-comments.php'); 			// Comments
		//remove_menu_page('themes.php'); 			// Appearance
		//remove_menu_page('plugins.php'); 			// Plugins
		//remove_menu_page('users.php'); 				// Users
		//remove_menu_page('tools.php'); 				// Tools
		//remove_menu_page('options-general.php'); 		// Settings
 
		//remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );	// Remove posts->tags submenu
		//remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );	// Remove posts->categories submenu
		remove_submenu_page( 'index.php', 'index.php?page=simple_history_page' );
		remove_submenu_page( 'themes.php', 'themes.php' );
		remove_submenu_page( 'themes.php', 'widgets.php' );
	}
}
add_action('admin_menu', 'remove_admin_menus');

function edit_admin_menu_titles() {  
    global $menu;  
    global $submenu;  
      
    //$menu[5][0] = 'Recipes'; // Change Posts to Recipes  
    //$submenu['edit.php'][5][0] = 'All Recipes';  
    //$submenu['edit.php'][10][0] = 'Add a Recipe';  
    //$submenu['edit.php'][15][0] = 'Meal Types'; // Rename categories to meal types  
    //$submenu['edit.php'][16][0] = 'Ingredients'; // Rename tags to ingredients  
}  
add_action( 'admin_menu', 'edit_admin_menu_titles' ); 

function custom_menu_order($menu_ord) {  
    if (!$menu_ord) return true;  
      
    return array(  
        'index.php', // Dashboard  
        'separator1', // First separator  
        'edit.php', // Posts  
        'upload.php', // Media  
        'link-manager.php', // Links  
        'edit.php?post_type=page', // Pages  
        'edit-comments.php', // Comments  
        'separator2', // Second separator  
        'themes.php', // Appearance  
        'plugins.php', // Plugins  
        'users.php', // Users  
        'tools.php', // Tools  
        'options-general.php', // Settings  
        'separator-last', // Last separator  
    );  
}  
//add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order  
//add_filter('menu_order', 'custom_menu_order');  

/*************************************************************
WORDPRESS ADMIN BAR
***********************************************************/
function remove_admin_bar() {
	if ( !current_user_can ( 'delete_users' ) ) {
		show_admin_bar(false);
	}
}
add_action ('after_setup_theme', 'remove_admin_bar');

/* Remove admin bar from admin area
**************************************************************/
/*
if ( is_admin() ) {  
    remove_action( 'init', '_wp_admin_bar_init' );  
    add_action( 'admin_head', 'remove_adminbar_margin' );  
}*/ 

/* Remove admin bar from from end
**************************************************************/
/*if ( !is_admin() ) {  
    remove_action( 'init', '_wp_admin_bar_init' );  
    add_action( 'wp_head', 'remove_adminbar_margin' );  
}  */

function remove_admin_bar_links() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
	//$wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
	//$wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
	//$wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
	//$wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
	//$wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
	//$wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
	//$wp_admin_bar->remove_menu('my-sites');  				// Remove My Sites menu
	$wp_admin_bar->remove_menu('view');        // Remove the view site link
	$wp_admin_bar->remove_menu('view-site');        // Remove the view site link
	//$wp_admin_bar->remove_menu('updates');          // Remove the updates link
	//$wp_admin_bar->remove_menu('comments');         // Remove the comments link
	//$wp_admin_bar->remove_menu('search');  					// Remove Search Icon
	$wp_admin_bar->remove_menu('new-content');      // Remove the content link
	//$wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
	//$wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
}
add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );

/** Add custom link to admin bar
**************************************************************/
function custom_adminbar_menu( $meta = TRUE ) {  
    global $wp_admin_bar;  
        if ( !is_user_logged_in() ) { return; }  
        if ( !is_super_admin() || !is_admin_bar_showing() ) { return; }  
    $wp_admin_bar->add_menu( array(  
        'id' => 'custom_menu',  
        'title' => __( 'Menu Name', 'tabula-rasa' ),  
        'href' => 'http://google.com/',  
        'meta'  => array( target => '_blank' ) )  
    );  
}
/*------------------------------------------------------------------ 
The add_action # is the menu position: 
10 = Before the WP Logo 
15 = Between the logo and My Sites 
25 = After the My Sites menu 
100 = End of menu 
------------------------------------------------------------------*/
//add_action( 'admin_bar_menu', 'custom_adminbar_menu', 15 );  


/** Removes the 28px margin for the Admin Bar 
**************************************************************/
/*   
function remove_adminbar_margin() {  
    $remove_adminbar_margin = '<style type="text/css">  
        html { margin-top: -28px !important; }  
        * html body { margin-top: -28px !important; }  
    </style>';  
    echo $remove_adminbar_margin;  
}  
*/

/*************************************************************
DASHBOARD WIDGETS 
**************************************************************/

/** Disable default dashboard widgets
**************************************************************/
function disable_default_dashboard_widgets() {
	// remove_meta_box('dashboard_right_now', 'dashboard', 'core');    // Right Now Widget
	//remove_meta_box('dashboard_recent_comments', 'dashboard', 'core'); // Comments Widget
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');  // Incoming Links Widget
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');         // Plugins Widget

	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');  // Quick Press Widget
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');   // Recent Drafts Widget
	remove_meta_box('dashboard_primary', 'dashboard', 'core');         //
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');       //

	// removing plugin dashboard boxes
	//remove_meta_box('yoast_db_widget', 'dashboard', 'normal');         // Yoast's SEO Plugin Widget
	//Remove sections that should only be displayed to admin

	add_action('add_meta_boxes', 'yoast_is_toast', 99);
	function yoast_is_toast(){
		if (!current_user_can('manage_options')){	
			remove_meta_box('simple_history_dashboard_widget', 'dashboard', 'normal'); // Simple History Module
			remove_meta_box('yoast_db_widget', 'dashboard', 'normal'); 
			remove_meta_box('wpseo_meta', 'post', 'normal'); 
			remove_meta_box('wpseo_meta', 'page', 'normal'); 
			remove_meta_box('wpseo_meta', 'construction', 'normal'); 
		}
	}
	if (!current_user_can('manage_options')){	
		remove_meta_box('authordiv', 'location', 'normal'); // Simple History Module
		remove_meta_box('location_sponsor_details', 'location', 'side'); // Simple History Module
	}
	remove_meta_box('tagsdiv-types', 'location', 'normal'); // Simple History Module
	remove_meta_box('tagsdiv-blocks', 'location', 'normal'); // Simple History Module
	remove_meta_box('blocksdiv', 'location', 'normal'); // Simple History Module
	remove_meta_box('tagsdiv-districts', 'location', 'normal'); // Simple History Module
}
add_action('admin_menu', 'disable_default_dashboard_widgets');

// RSS Dashboard Widget
function rss_dashboard_widget() {
	if(function_exists('fetch_feed')) {
		include_once(ABSPATH . WPINC . '/feed.php');               // include the required file
		$feed = fetch_feed('http://themble.com/feed/rss/');        // specify the source feed
		$limit = $feed->get_item_quantity(7);                      // specify number of items
		$items = $feed->get_items(0, $limit);                      // create an array of items
	}
	if ($limit == 0) echo '<div>The RSS Feed is either empty or unavailable.</div>';   // fallback message
	else foreach ($items as $item) { ?>

	<h4 style="margin-bottom: 0;">
		<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo mysql2date(__('j F Y @ g:i a', 'tabula_rasa'), $item->get_date('Y-m-d H:i:s')); ?>" target="_blank">
			<?php echo $item->get_title(); ?>
		</a>
	</h4>
	<p style="margin-top: 0.5em;">
		<?php echo substr($item->get_description(), 0, 200); ?>
	</p>
	<?php }
}

// calling all custom dashboard widgets
function custom_dashboard_widgets() {
	wp_add_dashboard_widget('rss_dashboard_widget', __('Recently on Themble (Customize on admin.php)', 'tabula_rasa'), 'rss_dashboard_widget');
	// Be sure to drop any other created Dashboard Widgets in this function and they will all load.
}
//add_action('wp_dashboard_setup', 'custom_dashboard_widgets');

/*************************************************************
CUSTOM LOGIN PAGE
**************************************************************/

// calling your own login css so you can style it
function tr_login_css() {
	wp_enqueue_style( 'login_css', get_template_directory_uri() . '/css/login.css', false );
}

// changing the logo link from wordpress.org to your site
function tr_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function tr_login_title() { return get_option('blogname'); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'tr_login_css', 10 );
add_filter('login_headerurl', 'tr_login_url');
add_filter('login_headertitle', 'tr_login_title');


/*************************************************************
CUSTOMIZE ADMIN 
**************************************************************/

/** Load admin css
**************************************************************/
function load_custom_wp_admin_style() {
	wp_register_style( 'custom_wp_admin_css', get_template_directory_uri() . '/css/admin.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_css' );
	
	if ( !current_user_can('delete_locations') ){
		wp_register_style( 'custom_wp_admin_volunteer_css', get_template_directory_uri() . '/css/admin-volunteer.css', false, '1.0.0' );
		wp_enqueue_style( 'custom_wp_admin_volunteer_css' );	
	}
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

/** Remove publishing options for volunteers on the edit page
******************************************************************/


/**  Custom Backend Footer
**************************************************************/
function tr_custom_admin_footer() {
	_e('<span id="footer-thankyou">Developed by <a href="http://third-law.com" target="_blank">Kenny Scott (Third Law Web Design)</a></span>. Built using Tabula Rasa.', 'tabula_rasa');
}
add_filter('admin_footer_text', 'tr_custom_admin_footer');

/*************************************************************
OPERATIONS PAGE 
**************************************************************/
/** Creates Operations page for users **/
function my_help_menu() {
	//add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	//add_menu_page( 'Export Database to Excel', 'Operations', 'manage_options', 'operations', 'export2excel_page' );
	//add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
	add_submenu_page( 'edit.php?post_type=location', '', 'Print Database', 'delete_users', 'print_database', 'print_database_page' );
	add_submenu_page( 'edit.php?post_type=location', '', 'Export Database to Excel', 'delete_users', 'export2excel', 'export2excel_page' );
	add_submenu_page( 'edit.php?post_type=location', '', 'Export Database to Excel (For Cat)', 'delete_users', 'export2excel_forcat', 'export2excel_forcat_page' );
}

function operations_options() {
	include('theme-options-inc/export2excel.php');
}

function export2excel_page() {
	include('theme-options-inc/export2excel.php');
}

function export2excel_forcat_page() {
	include('theme-options-inc/export2excel_forcat.php');
}

function print_database_page() {
	include('theme-options-inc/print-database.php');
}

add_action( 'admin_menu', 'my_help_menu' );

/** Removed title section from volunteers edit page
*******************************************************/
function remove_box() {
	if (!current_user_can('manage_options')){
		remove_post_type_support('location', 'title');
	}
}
add_action ( 'admin_init', 'remove_box' );

/** Custum Column Mods
***************************************************************/
function columns_head_only_location( $columns ) { 
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Address' ),
		'_cmb_name' => __( 'Name' ),
		'_cmb_sponsor' => __( 'Sponsored' ),
		'author' => __( 'Updated by' ),
		'taxonomy-types' => __( 'Types' ),
		'taxonomy-blocks' => __( 'Blocks' ),
		'taxonomy-districts' => __( 'Districts' ),
		//'date' => __( 'Date' ),
		'_edit_last' => __( 'Modified' )
	);
	return $columns;
}
add_filter('manage_location_posts_columns', 'columns_head_only_location', 10);

function columns_content_only_location( $column_name, $post_id ) {
	global $post;
	$post_id = $post->ID;	
	$values = get_post_meta( $post_id );
	if ($column_name == '_cmb_sponsor') {
		if ( isset( $values['_cmb_sponsor'][0] ) ) {
			echo 'Yes';
		} else {
			echo '';
		}
	}
	if ($column_name == '_cmb_name') {
		if ( isset( $values['_cmb_name'][0] ) ) {
			echo $values['_cmb_name'][0];
		} else {
			echo '';
		}	
	}	
	if ($column_name == '_edit_last') {
		$m_orig		= get_post_field( 'post_modified', $post_id, 'raw' );
		$m_stamp	= strtotime( $m_orig );
		$modified	= date('n/j/y', $m_stamp );

		echo '<p class="mod-date">' .$modified.'</p>';		
	}		
}
add_action('manage_location_posts_custom_column', 'columns_content_only_location', 10, 2);

function my_sortable_location_column( $columns ) {  
    $columns['_cmb_name'] = '_cmb_name';  
    $columns['_cmb_sponsor'] = '_cmb_sponsor';  
    $columns['author'] = 'author';  
    $columns['taxonomy-types'] = 'taxonomy-types';  
    $columns['taxonomy-blocks'] = 'taxonomy-blocks';  
    $columns['taxonomy-districts'] = 'taxonomy-districts';  
    $columns['_edit_last'] = '_edit_last';  
    return $columns;  
}
add_filter( 'manage_edit-location_sortable_columns', 'my_sortable_location_column' );  

function name_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && '_cmb_name' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => '_cmb_name',
            'orderby' => 'meta_value'
        ) );
    }
    return $vars;
}
add_filter( 'request', 'name_column_orderby' );

function sponsor_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && '_cmb_sponsor' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => '_cmb_sponsor',
            'orderby' => 'meta_value'
        ) );
    }
    return $vars;
}
add_filter( 'request', 'sponsor_column_orderby' );

function type_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && 'taxonomy-types' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'taxonomy' => 'types',
        ) );
    }
    return $vars;
}
add_filter( 'request', 'type_column_orderby' );

function modified_column_orderby( $vars ) {
    if ( isset( $vars['orderby'] ) && '_edit_last' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'orderby' => 'modified'
        ) );
    }
    return $vars;
}
add_filter( 'request', 'modified_column_orderby' );

function custom_search_query( $query ) {
    $custom_fields = array(
        // put all the meta fields you want to search for here
        "_cmb_name"
    );
    $searchterm = $query->query_vars['s'];

    // we have to remove the "s" parameter from the query, because it will prevent the posts from being found
    $query->query_vars['s'] = "";

    if ($searchterm != "") {
        $meta_query = array('relation' => 'OR');
        foreach($custom_fields as $cf) {
            array_push($meta_query, array(
                'key' => $cf,
                'value' => $searchterm,
                'compare' => 'LIKE'
            ));
        }
        $query->set("meta_query", $meta_query);
    };
}
add_filter( "pre_get_posts", "custom_search_query");

// add modified date meta box
function myplugin_add_meta_box() {
	add_meta_box( 'mod_date', 'Last modified on: ', 'modified_callback', 'location', 'side','high');
}	
add_action( 'add_meta_boxes', 'myplugin_add_meta_box' );

function modified_callback( $post_id ) { 
		$m_orig		= get_post_field( 'post_modified', $post_id, 'raw' );
		$m_stamp	= strtotime( $m_orig );
		$modified	= date('n/j/y', $m_stamp );

		echo '<p class="mod-date">' .$modified.'</p>';		
}
?>