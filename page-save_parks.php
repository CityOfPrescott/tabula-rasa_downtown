<?php
/*
Template Name: Function: Save RV Parks
!!! change schema to uft8
Make a copy of the original database!
Change name to rvty_parks. change  col cgname to name. add wpid columns. add lat and lon columns. add cost columns. add clubs columns.  add dates columns.  
Upload  a fresh database of comments. change blob to text
Upload a fresh database of campground_copy. change blob to text
Then comes alot of phot uploading. The have to be done by hand.
Then fix all the bad coords.
*/
include_once("header.php");
?>
<?php
//$submited_state = $_POST['submited_state'];
if (isset($_POST['submit'])) { 
	global $wpdb;	
	$parks_query = $wpdb->get_results(" SELECT ID FROM hiphop_posts WHERE post_status = 'publish' ");
	foreach ($parks_query as $parks) {
		echo $id = $parks->ID;
		echo '<br />';
		$num = get_post_meta($id, '_cmb_st_number', true);
		$unit = get_post_meta($id, '_cmb_st_unit', true);
		$block = wp_get_object_terms($id, 'blocks');
		$block = $block[0]->name;
		$block = explode (' ', $block );
		$direction = $block[4];
		if ( $direction == 'North' ) { $direction = 'N'; } 
		if ( $direction == 'South' ) { $direction = 'S'; } 
		if ( $direction == 'West' ) { $direction = 'W'; } 
		if ( $direction == 'East' ) { $direction = 'E'; } 
		$street = $block[0];
		echo $post_title = $num . ' ' . $direction . ' ' . $street . ' Street ' . $unit;	
		echo '<br />';
		$my_post = array (
			'ID' => $id,
			'post_title' => $post_title,
			'post_type' => 'location',
		);
		wp_update_post( $my_post );	
			print_r ( $my_post ) ;
	}
}  else {
	echo 'Holy new balls!';
}

?>
<form method="post" action=""> <?php //echo esc_attr($_SERVER['REQUEST_URI']); ?>
<br /><br />
<!-- <input type="text" name="submited_state" size="4" />&nbsp; -->
<input type="submit" name="submit" value="Cleanup Database" />
</form>
<br /><br />
<?php get_footer(); ?>