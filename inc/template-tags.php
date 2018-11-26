<?php
/**
 * Custom template tags for this theme
 *
 * @package Choyce Design
 */

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function choycedesign_2018_entry_footer() {
	$time_string = sprintf(
		'<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$modified_time_string = sprintf(
			'<time class="updated" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);
	}

	if ( isset( $modified_time_string ) ) {
		$posted_on = sprintf(
			/* translators: %1$s: post date, %2$s modified date. */
			esc_html_x( 'Posted on %1$s, last updated %2$s', 'post date', 'choycedesign' ),
			$time_string,
			$modified_time_string
		);
	} else {
		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'choycedesign' ),
			$time_string
		);
	}

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
}

/**
 * Format the comments.
 */
function choycedesign_2018_comments( $comment, $args, $depth ) {
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment->has_children ? 'parent' : '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
				<div class="comment-posted">
					<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
						<time datetime="<?php comment_time( 'c' ); ?>">
							<?php
								/* translators: 1: comment date, 2: comment time */
								printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment ), get_comment_time() );
							?>
						</time>
					</a>
				</div><!-- .comment-posted -->
				<div class="comment-author vcard">
					<?php
						/* translators: %s: comment author link */
						printf(
							__( '%s <span class="says">says:</span>' ),
							sprintf( '<b class="fn">%s</b>', get_comment_author_link( $comment ) )
						);
					?>
				</div><!-- .comment-author -->
			</footer><!-- .comment-meta -->

			<div class="comment-content">
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
				<?php endif; ?>

				<?php comment_text(); ?>
			</div><!-- .comment-content -->
			<?php
				comment_reply_link( array_merge( $args, array(
					'add_below' => 'div-comment',
					'depth'     => $depth,
					'max_depth' => $args['max_depth'],
					'before'    => '<div class="comment-reply">',
					'after'     => '</div>'
				) ) );
			?>
		</article><!-- .comment-body -->
	<?php
}

/**
 * Format the pings.
 */
function choycedesign_2018_pings( $comment, $args, $depth ) {
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( '', $comment ); ?>>
		<?php comment_author_link( $comment ); ?>
	<?php
}
