<?php
/**
 * Template part for displaying single posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Choyce Design
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			if ( has_post_thumbnail() ) :
				the_post_thumbnail( 'post-thumbnail', array(
					'alt' => the_title_attribute( array(
						'echo' => false,
					) ),
				) );
			endif;
		endif;
		?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content( sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'choycedesign' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			) );

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'choycedesign' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php choycedesign_2019_entry_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php
		the_post_navigation( array(
			'prev_text' => __( 'Previous Post', 'choycedesign' ),
			'next_text' => __( 'Next Post', 'choycedesign' ),
		) );
	?>

</article><!-- #post-<?php the_ID(); ?> -->
