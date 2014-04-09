<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( has_post_thumbnail() && ! post_password_required() && !is_single() ) : ?>
			<div class="entry-thumbnail">
				<?php the_post_thumbnail('thumbnail'); ?>
			</div>
			<?php endif; ?>
			<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'tabula-rasa' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
			</h1>
			<?php endif; // is_single() ?>
		</header><!-- .entry-header -->

		<?php if ( is_single() && has_post_thumbnail() ) { ?>
		<div class="entry-thumbnail">
		<?php the_post_thumbnail(); ?>
		</div>		
		<?php } ?>
		
		<?php if ( !is_single() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<ul>
				<li><span>Business Name: </span><?php echo $name = get_post_meta( get_the_ID(), '_cmb_name', true ); ?></li>
				<li><span>Business Type: </span><?php echo $name = get_post_meta( get_the_ID(), '_cmb_type', true ); ?></li>
				<li><span>Business District: </span><?php echo $name = get_post_meta( get_the_ID(), '_cmb_district', true ); ?></li>
			</ul>
				
			<?php //echo $name = get_post_meta( get_the_ID(), '_cmb_name', true ); ?>
			<?php //the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<ul>
				<li><span>Business Name: </span><?php echo $name = get_post_meta( get_the_ID(), '_cmb_name', true ); ?></li>
				<li><span>Business Type: </span>
					<?php 
					$types = wp_get_post_terms( get_the_ID(), 'types' ); 
					foreach ( $types as $type ) {
						echo $type->name;
					}
					?>
				</li>
				<li><span>Business District: </span>
					<?php 
					$districts = wp_get_post_terms( get_the_ID(), 'districts' ); 
					foreach ( $districts as $district ) {
						echo $district->name;
					}
					?>
				</li>
			</ul>
			<?php if ( is_single() ) { ?>
			<div class="entry-meta">
			<?php tr_entry_meta(); ?>
			<?php //edit_post_link( __( 'Edit', 'tabula-rasa' ), '<span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-meta -->
			<?php } ?>			
			<div class="listing_check">
				<p>Is this listing correct?</p>
				<div id="yesButton" class="button">Yes				
					<input type="hidden" value="<?php echo get_the_ID(); ?>" class="post_id" />
					<input type="hidden" value="<?php echo get_current_user_id(); ?>" class="user_id" />
				</div>
			

				<button id="noButton" class="button">No</button>
				<script type="text/javascript">
					document.getElementById("noButton").onclick = function () {
						location.href = "<?php echo get_home_url(); ?>/wp-admin/post.php?post=<?php echo the_ID(); ?>&action=edit";
					};
				</script>				
			</div>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'tabula-rasa' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
			<?php //the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tabula-rasa' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
			<?php 
			$blocks = wp_get_post_terms( get_the_ID(), 'blocks' ); 
			foreach ( $blocks as $block ) {
				$block = $block->name;
			}
								
			// get_posts in same custom taxonomy
			$postlist_args = array(
				'posts_per_page'  => -1,
				'orderby'         => 'menu_order title',
				'order'           => 'ASC',
				'post_type'       => 'location',
				'blocks' => $block
			);
			$postlist = get_posts( $postlist_args );
			//echo 'postlist: ';
			//print_r($postlist);

			// get ids of posts retrieved from get_posts
			$ids = array();
			foreach ($postlist as $thepost) {
			   $ids[] = $thepost->ID;
			}
			$array_count = count( $ids ) - 1;
			
			// get and echo previous and next post in the same taxonomy  
			//echo 'post id: ' . $post->ID;      
			$thisindex = array_search($post->ID, $ids);
			if ( $thisindex != 0 ) {
			$previd = $ids[$thisindex - 1];
			}
			if ( $thisindex != $array_count ) {
			$nextid = $ids[$thisindex + 1];
			}
			if ( !empty($previd) ) {
			   echo '<div class="nav-previous"><a rel="prev" href="' . get_permalink($previd). '">' . get_the_title($previd) .'</a></div>';
			}
			if ( !empty($nextid) ) {
			   echo '<div class="nav-next"><a rel="next" href="' . get_permalink($nextid). '">' . get_the_title($nextid) .'</a></div>';
			}
			
			?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
