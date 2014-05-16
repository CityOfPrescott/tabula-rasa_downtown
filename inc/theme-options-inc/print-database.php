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

		<footer class="entry-meta">
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
	<?php endwhile; ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
<?php } ?>
		</div><!-- #content -->
	</section><!-- #primary -->	