<?php
/*************************************************************
SITE SPECIFIC FUNCTIONS
**************************************************************/
function tr_site_specific_support() {
	// This removes the annoying […] to a Read More link
	function tr_excerpt_more($more) {
		global $post;
		// edit here if you like
		return '...  <a class="excerpt-read-more" href="'. get_permalink($post->ID) . '" title="'. __('Read', 'tabula_rasa') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'tabula_rasa') .'</a>';
	}	
	add_filter('excerpt_more', 'tr_excerpt_more');	
}	
add_action('after_setup_theme','tr_site_specific_support', 16);

function tr_register_site_specific_sidebars() {
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
add_action( 'widgets_init', 'tr_register_site_specific_sidebars' );

/** tr_entry_meta()
**************************************************************/
if ( ! function_exists( 'tr_entry_meta' ) ) :
/** Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
Create your own tr_entry_meta() to override in a child theme. **/
function tr_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'tabula-rasa' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'tabula-rasa' ) );

	$date = sprintf( '<time class="entry-date" datetime="%3$s">%4$s</time>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$author = sprintf( '%3$s',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'tabula-rasa' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'Updated in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'tabula-rasa' );
	} elseif ( $categories_list ) {
		//$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'tabula-rasa' );
		$utility_text = __( 'Updated on %3$s.', 'tabula-rasa' );
	} else {
		$utility_text = __( '<span>Updated on: </span>%3$s<br /><span>Updated by: </span>%4$s', 'tabula-rasa' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/*************************************************************
COMMENT LAYOUT 
**************************************************************/

/*------------------------------------------------------------------
Template for comments and pingbacks.

To override this walker in a child theme without modifying the comments template
simply create your own tr_comment(), and that function will be used instead.

Used as a callback by wp_list_comments() for displaying the comments.
------------------------------------------------------------------*/

if ( ! function_exists( 'tr_comment' ) ) :

/** tr_comment()
**************************************************************/
function tr_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'tabula_rasa' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'tabula_rasa' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					/*
						this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
						echo get_avatar($comment,$size='32',$default='<path_to_url>' );
					*/
					?>
					<!-- custom gravatar call -->
					<?php
						// create variable
						$bgauthemail = get_comment_author_email();
					?>
					<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>?s=32" class="load-gravatar avatar avatar-48 photo" height="32" width="32" src="<?php echo get_template_directory_uri(); ?>/images/nothing.gif" />
					<!-- end custom gravatar call -->
					<?php printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'tabula_rasa' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'tabula_rasa' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'tabula_rasa' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'tabula_rasa' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'tabula_rasa' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

/*************************************************************
MISC
**************************************************************/

/** remove_default_post_formats()
**************************************************************/
function remove_default_post_formats() {
    remove_theme_support( 'post-formats' );
}
add_action( 'init', 'remove_default_post_formats'); 

/** Google Analytics
**************************************************************/
function google_analytics_tracking_code(){ ?>
<!--
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-2432710-6', 'prescott-az.gov');
		ga('send', 'pageview');

	</script>
-->	
<?php }	
add_action('wp_head', 'google_analytics_tracking_code');

function mod_taxonomy_dropdown($taxonomy) { ?>
	<form action="/" method="get">
	<select name="cat" id="cat" class="postform">
	<option value="-1">What block are you working on...</option>
	<?php
	$terms = get_terms($taxonomy);
	foreach ($terms as $term) {
		printf( '<option class="level-0" value="%s">%s</option>', $term->slug, $term->name );
	}
	echo '</select></form>';
	?>
<?php }

/** Save post title based on address
************************************************/
function modify_post_title( $data , $postarr ) {
	if ( $data['post_name'] != '' ) {
	  if($data['post_type'] == 'location') {
		$id = get_the_ID();
		if ( $id != '' ) {
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
			$data['post_title'] = $num . ' ' . $direction . ' ' . $street . ' Street ' . $unit;
		}
	}
  }
  return $data;
}
//add_filter( 'wp_insert_post_data' , 'modify_post_title' , '99', 2 );

/* Attempt to save title based on address
****************************************************/
function save_book_meta( $post_id ) {

    /*
     * In production code, $slug should be set only once in the plugin,
     * preferably as a class property, rather than in each function that needs it.
     */
    $slug = 'location';

    // If this isn't a 'book' post, don't update it.
    if ( $slug != $_POST['post_type'] ) {
        return;
    }

    // - Update the post's metadata.

    if ( isset( $_REQUEST['_cmb_st_number'] ) || isset( $_REQUEST['_cmb_block'] ) || isset( $_REQUEST['_cmb_st_unit'] ) ) {
        //update_post_meta( $post_id, '_cmb_st_number', sanitize_text_field( $_REQUEST['_cmb_st_number'] ) );
		//$id = get_the_ID();
		//$num = get_post_meta($post_id, '_cmb_st_number', true);
		$num = $_REQUEST['_cmb_st_number'];
		//$unit = get_post_meta($post_id, '_cmb_st_unit', true);
		$unit = $_REQUEST['_cmb_st_unit'];
		//$block = wp_get_object_terms($post_id, 'blocks');
		$block = $_REQUEST['_cmb_block'];
		//$block = $block[0]->name;
		$block = explode ('-', $block );
		$direction = $block[3];
		if ( $direction == 'north' ) { $direction = 'N'; } 
		if ( $direction == 'south' ) { $direction = 'S'; } 
		if ( $direction == 'west' ) { $direction = 'W'; } 
		if ( $direction == 'east' ) { $direction = 'E'; } 
		$street = ucfirst ( $block[0] );
		$post_title = $num . ' ' . $direction . ' ' . $street . ' St ' . $unit;		
		
		$my_post = array(
			'ID'           => $post_id,
			'post_title' => $post_title,
			'post_author' => get_current_user_id()
		);

		remove_action( 'save_post', 'save_book_meta' );
		
		// Update the post into the database
		wp_update_post( $my_post );
		
		add_action( 'save_post', 'save_book_meta' );
    }
}
add_action( 'save_post', 'save_book_meta' );

/* Attempt to save post when clicking on yes
*****************************************************/
function enqueue_scripts_styles_init() {
	wp_enqueue_script( 'ajax-script', get_stylesheet_directory_uri().'/js/yesButton.js', array('jquery'), 1.0 ); // jQuery will be included automatically
	// get_template_directory_uri() . '/js/script.js'; // Inside a parent theme
	// get_stylesheet_directory_uri() . '/js/script.js'; // Inside a child theme
	// plugins_url( '/js/script.js', __FILE__ ); // Inside a plugin
	wp_localize_script( 'ajax-script', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); // setting ajaxurl
}
add_action('init', 'enqueue_scripts_styles_init');
 
function ajax_action_stuff() {
	echo 'post id: ' .$post_id = $_POST['post_id']; // getting variables from ajax post
	echo 'user id: ' .$user_id = $_POST['user_id']; // getting variables from ajax post
	// doing ajax stuff
	//update_post_meta($post_id, 'post_key', 'meta_value');
	//global $post;
	//echo $id = get_the_ID();
	//echo $user_ID = get_current_user_id();
  
 $my_post = array(
      'ID'           => $post_id,
      'post_author' => $user_id
  );

  // Update the post into the database
  wp_update_post( $my_post );	
  
	echo 'ajax submitted';
	die(); // stop executing script
	
}
add_action( 'wp_ajax_ajax_action', 'ajax_action_stuff' ); // ajax for logged in users
add_action( 'wp_ajax_nopriv_ajax_action', 'ajax_action_stuff' ); // ajax for not logged in users
?>