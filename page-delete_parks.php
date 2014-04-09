<?php
/*
Template Name: Function: Delete Locations
*/
include_once("header.php");
?>
<?php
//$submited_state = $_POST['submited_state'];
if (isset($_POST['submit'])) { 
	global $wpdb;	
	$parks_query = $wpdb->get_results(" SELECT ID FROM hiphop_posts WHERE post_status = 'publish' ");
	foreach ($parks_query as $parks) {
		$postid = $parks->ID;
		wp_delete_post( $postid, true );
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