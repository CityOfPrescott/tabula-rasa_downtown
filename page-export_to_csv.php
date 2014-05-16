<?php
/*
Template Name: Export Locations to CSV
*/
include_once("header.php");
?>
<?php
//$submited_state = $_POST['submited_state'];
if (isset($_POST['submit'])) {
  // filename for download
  $filename = "website_data_" . date('Ymd') . ".csv";


	//$handle = fopen($filename, 'w+');
	//fputcsv($handle, array('ID','Address', 'Name', 'Type'));
	global $wpdb;	
	$parks_query = $wpdb->get_results(" SELECT ID, post_title FROM wp_posts WHERE post_status = 'publish' AND post_type = 'location'");
	
	/*
	foreach ($parks_query as $parks) {
		$post_id = $parks->ID;
		$name = get_post_meta( $post_id, '_cmb_name', $single );
		if ( $name == NULL ) {
			$name = '';
		}
		$types = get_the_terms( $post_id, 'types' );
		if ( $types != NULL ) {
			foreach ( $types as $type ) {
				$type_name = $type->name;
			}
		} else {
			$type_name = '';
		}
		
		
		//fputcsv($handle, array($parks->ID, $parks->post_title, $name, $type_name));
	}
	*/
	
   $line = '';
    foreach( $parks_query as $value ) {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) ) {
            $value = "\t";
        } else {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
	
$data = str_replace( "\r" , "" , $data );

if ( $data == "" ) {
    $data = "\n(0) Records Found!\n";                        
}
	
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=your_desired_name.xls");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";

}  else {
	echo 'Holy new balls!';
}

?>
<form method="post" action=""> <?php //echo esc_attr($_SERVER['REQUEST_URI']); ?>
<br /><br />
<!-- <input type="text" name="submited_state" size="4" />&nbsp; -->
<input type="submit" name="submit" value="Export YO!" />
</form>
<br /><br />
<?php get_footer(); ?>