<?php
  ini_set('memory_limit', '256M');
  ini_set('max_execution_time', 300); //300 seconds = 5 minutes
  $extensions = array('xls' => '.xls', 'xlsx' => '.xlsx');
  $args = array (
      'public'   => true
  );
  $output = 'objects';
  $post_types = get_post_types($args, $output);

  if ( isset($_POST['Submit']) ) {
      $post_type = 'location';
      $ext = 'xls';
      $str = '';
			
      if ( is_multisite() && $network_admin ) {
        $blog_info = get_blog_list(0, 'all');
        foreach ($blog_info as $blog) {
          switch_to_blog($blog['blog_id']);
          include('loop.php');
          restore_current_blog();
        }
      } else {

    query_posts(array('posts_per_page' => -1, 'order'=>'DESC', 'post_type' => 'location'));//-1 is for all posts
    $str = '<table>';
    if (have_posts()) {
      $str .= '<tr>
                <th>ID</th>
                <th>Address</th>
                <th>Name</th>
                <th>Type</th>
                <th>Sponsor</th>
                <th>Last Edited on</th>
                <th>Last Edited by</th>
              </tr>';
      while (have_posts()) {
        the_post();

        global $post;
		$post_id = $post->ID;
		$name = get_post_meta( $post_id, '_cmb_name', true );
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
		$sponsor = get_post_meta( $post_id, '_cmb_sponsor', true );
		if ( $sponsor == NULL ) {
			$sponsor = '';
		}	else {
			$sponsor = 'Yes';
		}
		$edited_on = $post->post_modified;
		$edited_by = $post->post_author;
		switch ( $edited_by ) {
			case 1:
			$edited_by = 'spearhead';
			break;
			case 2:
			$edited_by = 'kennytheeadmin';
			break;
			case 3:
			$edited_by = 'kennytheevolunteer';
			break;
			case 4:
			$edited_by = 'kennytheemanager';
			break;
			case 5:
			$edited_by = 'Cat Moody';
			break;
			case 6:
			$edited_by = 'volunteer';
			break;			
			default:
			$edited_by = 'Unknown';
		}
        $str.= '
          <tr>
            <td>' . mb_convert_encoding($post_id, 'HTML-ENTITIES', 'UTF-8') . '</td>
            <td>' . mb_convert_encoding(get_the_title(), 'HTML-ENTITIES', 'UTF-8') . '</td>
            <td>' . mb_convert_encoding($name, 'HTML-ENTITIES', 'UTF-8') . '</td>
            <td>' . mb_convert_encoding($type_name, 'HTML-ENTITIES', 'UTF-8') . '</td>
            <td>' . mb_convert_encoding($sponsor, 'HTML-ENTITIES', 'UTF-8') . '</td>
            <td>' . mb_convert_encoding($edited_on, 'HTML-ENTITIES', 'UTF-8') . '</td>
            <td>' . mb_convert_encoding($edited_by, 'HTML-ENTITIES', 'UTF-8') . '</td>						
          </tr>';
      }
      wp_reset_query();
    } else {
      $str .= '<tr colspan="8"><td>No post found.</td></tr>';
    }
    $str.= '</table><br/></br>';			
			
      }
			
			$filename = sanitize_file_name(get_bloginfo('name') ) . '.' . $ext;
			header("Content-type: application/vnd.ms-excel;");
			header("Content-Disposition: attachment; filename=" . $filename);
			print $str;//$str variable is used in loop.php
			exit();
  } else { ?>
	<?php
    global $network_admin, $form_action;
    $network_admin = 0;
    $form_action = admin_url('edit.php?post_type=location&page=export2excel_forcat&noheader=true');	
	?>	
    <form name="export" action="<?php echo $form_action; ?>" method="post" onsubmit="return validate_form();">
      <div class="selection_criteria" >
        <div class="popupmain" style="float:left;">
          <div class="formfield">
            <p class="row1">
              <label>&nbsp;</label>
              <em>
                <input type="submit" class="button-primary" name="Submit" value="Download Location Data" />
              </em>
            </p>
          </div>
        </div>
      </div>
    </form> <?php
  } 
?>