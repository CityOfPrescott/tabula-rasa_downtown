<?php
/*
Template Name: Home Page
*/
get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
<?php
/*
 $args = array(
	'show_option_all'    => 'Choose one...',
	'orderby'            => 'NAME', 
	'order'              => 'ASC',
	'name'               => 'cat',
	'id'                 => '',
	'class'              => 'postform',
	'depth'              => 0,
	'taxonomy'           => 'blocks',
	'tab_index'          => 0,
); 
*/
?>
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
<!--
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'tabula-rasa' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h1>
				</header><!-- .entry-header -->
<!--
				<?php if ( is_single() && has_post_thumbnail() ) { ?>
				<div class="entry-thumbnail">
				<?php the_post_thumbnail(); ?>
				</div>		
				<?php } ?>
				
				<div class="entry-content">
					<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'tabula-rasa' ) ); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'tabula-rasa' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
				</div><!-- .entry-content -->
<!--
			</article><!-- #post -->				
				
				
			<?php endwhile; ?>

			<?php tr_content_nav( 'nav-below' ); ?>

		<?php else : ?>

		<?php get_template_part( 'content', 'none' ); ?>
		
		<?php endif; // end have_posts() check ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>