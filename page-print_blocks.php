<?php
/*
Template Name: Function: Import location data
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
	$parks_query = $wpdb->get_results("SELECT bus_name, st_name, district, type FROM base_data ORDER BY bus_name ASC");
	foreach ($parks_query as $parks) {
		$bus_name = $parks->bus_name;
		$st_name = $parks->st_name;
		$district = $parks->district;
		$type = $parks->type;
		$block = explode (' ', $st_name );
		$block_num = $block[0];
		if ( $block_num % 2 == 0 ) { $block_side = 'Even'; } else { $block_side = 'Odd'; }
		$block_section = substr( $block_num, 0, 1 );
		if ( $block_section == 1 ) { $block_section = 100;}
		if ( $block_section == 2 ) { $block_section = 200;}
		if ( $block_section == 3 ) { $block_section = 300;}
		if ( $block_section == 4 ) { $block_section = 400;}
		$block_direction = $block[1];
		if ( $block_direction == 'N' || $block_direction == 'S'  ) { 
			if ( $block_side == 'Even' ) { $block_side = 'Westside'; }
			if ( $block_side == 'Odd' ) { $block_side = 'Eastside'; }
		}
		if ( $block_direction == 'W' || $block_direction == 'E'  ) { 
			if ( $block_side == 'Even' ) { $block_side = 'Northside'; }
			if ( $block_side == 'Odd' ) { $block_side = 'Southside'; }
		}		
		if ( $block_direction == 'N' ) { $block_direction = 'North';}
		if ( $block_direction == 'S' ) { $block_direction = 'South';}
		if ( $block_direction == 'W' ) { $block_direction = 'West';}
		if ( $block_direction == 'E' ) { $block_direction = 'East';}
		$block_street = $block[2];
		$block_unit = $block[4];
		$block = $block_street . ' - ' . $block_section . ' Block ' . $block_direction . ' (' . $block_side . ')';
		if ( $district ) {
		$term_id = term_exists( $district, 'districts' );
			echo $district . '<br />';
			echo $new_term_id = $term_id['term_id']. '<br />';
			echo $term_id['term_taxonomy_id']. '<br />';
			$glat = get_term ( $new_term_id, 'districts' );
			print_r ( $glat);
		}
		//echo '<strong>' . $bus_name . ', ' . $st_name . ', ' . $district . ', ' . $type . '</strong><br />' . $block . '<br />';
		$post = array(
		  'post_title'     => $st_name,
		  'post_status'    => 'publish',
		  'post_type'      => 'location'
		);
		
		$post_id = wp_insert_post( $post, $wp_error );
		if ($bus_name) { add_post_meta( $post_id, '_cmb_name', $bus_name ); }
		if ($block_num) { add_post_meta( $post_id, '_cmb_st_number', $block_num ); }
		if ($block_unit) { add_post_meta( $post_id, '_cmb_st_unit', $block_unit ); }
		if ($district) { 
			$term_id = term_exists( $district, 'districts' );
			$new_term_id = $term_id['term_id'];
			wp_set_object_terms( $post_id, $district, 'districts' );
		}
		if ($type) { 
			$term_id = term_exists( $type, 'types' );
			$new_term_id = $term_id['term_id'];
			wp_set_object_terms( $post_id, $type, 'types' );
		}	
		if ($block) { 
			$term_id = term_exists( $block, 'blocks' );
			$new_term_id = $term_id['term_id'];
			wp_set_object_terms( $post_id, $block, 'blocks' );
		}	
		
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