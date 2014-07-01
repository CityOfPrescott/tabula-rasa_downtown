<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
 
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_cmb_';

	$meta_boxes[] = array(
		'id'         => 'location_address',
		'title'      => 'Location Address',
		'pages'      => array( 'location', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Number',
				'desc' => '',
				'id'   => $prefix . 'st_number',
				'type' => 'text',
			),	
			array(
				'name'		=> 'Block',
				'desc'		=> 'Select a block',
				'id'		=> $prefix . 'block',
				'type'		=> 'taxonomy_select',
				'taxonomy'	=> 'blocks', // Taxonomy Slug
			),
			array(
				'name'		=> 'Unit (if any)',
				'desc'		=> '',
				'id'		=> $prefix . 'st_unit',
				'type' => 'text',
			),		
		),
	);

	$meta_boxes[] = array(
		'id'         => 'location_details',
		'title'      => 'Location Details',
		'pages'      => array( 'location', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Business Name',
				'desc' => '',
				'id'   => $prefix . 'name',
				'type' => 'text',
			),	
			array(
				'name'		=> 'Type',
				'desc'		=> '',
				'id'		=> $prefix . 'type',
				'type'		=> 'taxonomy_select',
				'taxonomy'	=> 'types', // Taxonomy Slug
			),
			array(
				'name'		=> 'District',
				'desc'		=> '',
				'id'		=> $prefix . 'district',
				'type'		=> 'taxonomy_select',
				'taxonomy'	=> 'districts', // Taxonomy Slug
			),			
		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'location_vacancy',
		'title'      => 'Location Vacancy',
		'pages'      => array( 'location', ), // Post type
		'context'    => 'side',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Is this location vacant?',
				'desc' => 'Yes',
				'id'   => $prefix . 'vacancy',
				'type' => 'checkbox',
			),			
		),
	);	
	
	$meta_boxes[] = array(
		'id'         => 'location_sponsor_details',
		'title'      => 'Sponsorship Details',
		'pages'      => array( 'location', ), // Post type
		'context'    => 'side',
		'priority'   => 'default',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
				'name' => 'Is this location a sponsor?',
				'desc' => 'Yes',
				'id'   => $prefix . 'sponsor',
				'type' => 'checkbox',
			),			
		),
	);		

	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}