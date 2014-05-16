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

get_header(); ?>
<?php
$args = array(
  'taxonomy' => 'blocks',
  'parent' => 0
  );
$blocks = get_categories( $args );
//print_r($blocks);
?>

	<section id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
<?php
foreach ( $blocks as $block ) {
	$block_title =  $block->name;
	$block_slug = $block->slug;
	
//echo $blocks[0]['name'];
// WP_Query arguments
$args = array (
	'post_type'              => 'location',
	'tax_query'=>array(
		array(
			'taxonomy'=>'blocks',
			'field'=>'slug',
			'terms'=> $block_slug
		)
	),
	'posts_per_page'         => '-1',
	'order'                  => 'ASC',
	'orderby'                => 'title',
);

// The Query
$query = new WP_Query( $args );
		?>
		<?php if ( $query->have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php echo $block_title; ?></h1>
			</header><!-- .archive-header -->

			<?php //tr_content_nav( 'nav-above' ); ?>
			
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
<?php } ?>
		</div><!-- #content -->
	</section><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>