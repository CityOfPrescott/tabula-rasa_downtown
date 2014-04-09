<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to tr_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() )
	return;
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'tabula-rasa' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>
		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="navigation-comment" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'tabula-rasa' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'tabula-rasa' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'tabula-rasa' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>		

		<ol class="commentlist">
			<?php 
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use tr_comment() to format the comments.
				 * If you want to overload this in a child theme then you can
				 * define tr_comment() and that will be used instead.
				 * See tr_comment() in inc/template-tags.php for more.
				 */
				 wp_list_comments( array( 'callback' => 'tr_comment', 'style' => 'ol' ) ); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation-comment" role="navigation">
			<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'tabula-rasa' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'tabula-rasa' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'tabula-rasa' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'tabula-rasa' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php 
	$comments_args = array(
        // change the title of send button 
        'label_submit'=>'Submit Note',
        // change the title of the reply section
        'title_reply'=>'Leave a Note',
        // remove "Text or HTML to be displayed after the set of comment fields"
        'comment_notes_after' => '',
		'logged_in_as' => '',
        // redefine your own textarea (the comment body)
        'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
);
	comment_form($comments_args);
	?>

</div><!-- #comments .comments-area -->