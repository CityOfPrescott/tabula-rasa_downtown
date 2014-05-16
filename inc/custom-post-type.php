<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/


// Register Custom Post Type
function locations() {

	$labels = array(
		'name'                => _x( 'Locations', 'Post Type General Name', 'tabula-rasa' ),
		'singular_name'       => _x( 'Location', 'Post Type Singular Name', 'tabula-rasa' ),
		'menu_name'           => __( 'Locations', 'tabula-rasa' ),
		'parent_item_colon'   => __( 'Parent Location:', 'tabula-rasa' ),
		'all_items'           => __( 'All Location', 'tabula-rasa' ),
		'view_item'           => __( 'View Location', 'tabula-rasa' ),
		'add_new_item'        => __( 'Add New Location', 'tabula-rasa' ),
		'add_new'             => __( 'Add New', 'tabula-rasa' ),
		'edit_item'           => __( 'Edit Location', 'tabula-rasa' ),
		'update_item'         => __( 'Update Location', 'tabula-rasa' ),
		'search_items'        => __( 'Search Location', 'tabula-rasa' ),
		'not_found'           => __( 'Not found', 'tabula-rasa' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'tabula-rasa' ),
	);
	$capabilities = array(
		'publish_posts'       => 'publish_locations',
		'edit_post'           => 'edit_location',
		'read_post'           => 'read_location',
		'delete_post'         => 'delete_location',
		'edit_posts'          => 'edit_locations',
		'edit_others_posts'   => 'edit_others_locations',
		'read_private_posts'  => 'read_private_locations',
	);	
	$args = array(
		'label'               => __( 'location', 'tabula-rasa' ),
		'description'         => __( 'Locations for the downtown map', 'tabula-rasa' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'author' ),
		'taxonomies'          => array( 'types, blocks' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => '',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'map_meta_cap' => true,
		'capability_type' => 'location',
		'rewrite' => array( 'slug' => 'location', 'with_front' => false ), // Important!
		//'capabilities'        => $capabilities,
	);
	register_post_type( 'location', $args );
}

// Hook into the 'init' action
add_action( 'init', 'locations', 0 );
	
	/*
	for more information on taxonomies, go here:
	http://codex.wordpress.org/Function_Reference/register_taxonomy
	*/
	
// Register Custom Taxonomy
function tax_location_type() {

	$labels = array(
		'name'                       => _x( 'Types', 'Taxonomy General Name', 'tabula-rasa' ),
		'singular_name'              => _x( 'Type', 'Taxonomy Singular Name', 'tabula-rasa' ),
		'menu_name'                  => __( 'Types', 'tabula-rasa' ),
		'all_items'                  => __( 'All Types', 'tabula-rasa' ),
		'parent_item'                => __( 'Parent Type', 'tabula-rasa' ),
		'parent_item_colon'          => __( 'Parent Type:', 'tabula-rasa' ),
		'new_item_name'              => __( 'New Type Name', 'tabula-rasa' ),
		'add_new_item'               => __( 'Add New Type', 'tabula-rasa' ),
		'edit_item'                  => __( 'Edit Type', 'tabula-rasa' ),
		'update_item'                => __( 'Update Type', 'tabula-rasa' ),
		'separate_items_with_commas' => __( 'Separate types with commas', 'tabula-rasa' ),
		'search_items'               => __( 'Search Types', 'tabula-rasa' ),
		'add_or_remove_items'        => __( 'Add or remove types', 'tabula-rasa' ),
		'choose_from_most_used'      => __( 'Choose from the most used items', 'tabula-rasa' ),
		'not_found'                  => __( 'Not Found', 'tabula-rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'types', array( 'location' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'tax_location_type', 10 );

// Register Custom Taxonomy
function tax_location_block() {

	$labels = array(
		'name'                       => _x( 'Blocks', 'Taxonomy General Name', 'tabula-rasa' ),
		'singular_name'              => _x( 'Block', 'Taxonomy Singular Name', 'tabula-rasa' ),
		'menu_name'                  => __( 'Blocks', 'tabula-rasa' ),
		'all_items'                  => __( 'All blocks', 'tabula-rasa' ),
		'parent_item'                => __( 'Parent block', 'tabula-rasa' ),
		'parent_item_colon'          => __( 'Parent block:', 'tabula-rasa' ),
		'new_item_name'              => __( 'New block Name', 'tabula-rasa' ),
		'add_new_item'               => __( 'Add New block', 'tabula-rasa' ),
		'edit_item'                  => __( 'Edit block', 'tabula-rasa' ),
		'update_item'                => __( 'Update block', 'tabula-rasa' ),
		'separate_items_with_commas' => __( 'Separate blocks with commas', 'tabula-rasa' ),
		'search_items'               => __( 'Search blocks', 'tabula-rasa' ),
		'add_or_remove_items'        => __( 'Add or remove blocks', 'tabula-rasa' ),
		'choose_from_most_used'      => __( 'Choose from the most used items', 'tabula-rasa' ),
		'not_found'                  => __( 'Not Found', 'tabula-rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite' => array( 'slug' => 'blocks'),  
		'query_var' => true
	);
	register_taxonomy( 'blocks', array( 'location' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'tax_location_block', 10 );

// Register Custom Taxonomy
function tax_location_district() {

	$labels = array(
		'name'                       => _x( 'Districts', 'Taxonomy General Name', 'tabula-rasa' ),
		'singular_name'              => _x( 'District', 'Taxonomy Singular Name', 'tabula-rasa' ),
		'menu_name'                  => __( 'Districts', 'tabula-rasa' ),
		'all_items'                  => __( 'All districts', 'tabula-rasa' ),
		'parent_item'                => __( 'Parent district', 'tabula-rasa' ),
		'parent_item_colon'          => __( 'Parent district:', 'tabula-rasa' ),
		'new_item_name'              => __( 'New district Name', 'tabula-rasa' ),
		'add_new_item'               => __( 'Add New district', 'tabula-rasa' ),
		'edit_item'                  => __( 'Edit district', 'tabula-rasa' ),
		'update_item'                => __( 'Update district', 'tabula-rasa' ),
		'separate_items_with_commas' => __( 'Separate districts with commas', 'tabula-rasa' ),
		'search_items'               => __( 'Search districts', 'tabula-rasa' ),
		'add_or_remove_items'        => __( 'Add or remove districts', 'tabula-rasa' ),
		'choose_from_most_used'      => __( 'Choose from the most used items', 'tabula-rasa' ),
		'not_found'                  => __( 'Not Found', 'tabula-rasa' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'districts', array( 'location' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'tax_location_district', 10 );
?>