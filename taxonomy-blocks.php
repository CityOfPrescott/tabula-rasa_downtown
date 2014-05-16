<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Twelve already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); 
$blocks = get_query_var( 'blocks' );
// WP_Query arguments
$args = array (
	'post_type'              => 'location',
	'tax_query'=>array(
		array(
			'taxonomy'=>'blocks',
			'field'=>'slug',
			'terms'=>$blocks
		)
	),
	'posts_per_page'         => '-1',
	'order'                  => 'ASC',
	'orderby'                => 'title',
);

// The Query
$query = new WP_Query( $args );
?>
	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
		<?php if ( $query->have_posts() ) : ?>
<?php $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
echo $term->name; ?>
			<?php tr_content_nav( 'nav-above' ); ?>

			<?php //not sure about this - custom to keep all archives in one file
			// If a user has filled out their description, show a bio on their entries.
			if ( is_author() ) :
				if ( get_the_author_meta( 'description' ) ) : ?>
				<?php get_template_part( 'author-bio' ); ?>
				<?php endif;
			endif;	?>
			
			<?php
			/* Start the Loop */
			while ( $query->have_posts() ) : $query->the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content', 'blocks' );

			endwhile;

			//tr_content_nav( 'nav-below' );
			?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>