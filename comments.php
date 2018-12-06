<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Choyce Design
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	global $wp_query;
	$comments_by_type = separate_comments( $wp_query->comments );

	if ( have_comments() ) : ?>

		<?php if ( count( $comments_by_type['comment'] ) ) : ?>
			<h2 class="comments-title">
				<?php
				$comment_count = count( $comments_by_type['comment'] );
				if ( 1 === $comment_count ) {
					printf(
						/* translators: 1: title. */
						esc_html_e( 'One thought on &ldquo;%1$s&rdquo;', 'choycedesign' ),
						'<span>' . get_the_title() . '</span>'
					);
				} else {
					printf( // WPCS: XSS OK.
						/* translators: 1: comment count number, 2: title. */
						esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'choycedesign' ) ),
						number_format_i18n( $comment_count ),
						'<span>' . get_the_title() . '</span>'
					);
				}
				?>
			</h2><!-- .comments-title -->

			<?php the_comments_navigation(); ?>

			<ol class="comment-list">
				<?php
					wp_list_comments( array(
						'callback'    => 'choycedesign_2019_comments',
						'avatar_size' => 128,
						'style'       => 'ol',
						'type'        => 'comment',
					) );
				?>
			</ol><!-- .comment-list -->

			<?php the_comments_navigation(); ?>
		<?php endif; ?>

		<?php if ( count( $comments_by_type['pings'] ) ) : ?>
			<h2 class="pings-title"><?php _e( 'Mentions', 'choycedesign' ); ?></h2>

			<ul class="pings-list">
				<?php
					wp_list_comments( array(
						'callback'    => 'choycedesign_2019_pings',
						'style'       => 'ul',
						'type'        => 'pings',
					) );
				?>
			</ul><!-- .pings-list -->
		<?php endif; ?>

		<?php
		if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'choycedesign' ); ?></p>
		<?php
		endif;

	endif; // Check for have_comments().

	comment_form();
	?>

</div><!-- #comments -->
