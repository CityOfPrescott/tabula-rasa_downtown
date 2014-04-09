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
			
			<?php if ( is_single() ) { ?>
			<div class="entry-meta">
			<?php tr_entry_meta(); ?>
			<?php edit_post_link( __( 'Edit', 'tabula-rasa' ), '<span class="edit-link">', '</span>' ); ?>
			</div><!-- .entry-meta -->
			<?php } ?>
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
				
			<?php //echo $name = get_post_meta( get_the_ID(), '_cmb_name', true ); ?>
			<?php //the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php //the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tabula-rasa' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'tabula-rasa' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
