<?php
global $post;
$post_id = get_the_ID();
$user_id = get_current_user_id();
$my_post = array(
	'ID'           => $post_id,
	'post_author' => $user_id
);
wp_update_post( $my_post );
echo 'kenny';
?>