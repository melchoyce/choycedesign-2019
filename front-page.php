<?php
/**
 * The template for displaying the front page.
 *
 * @package Choyce Design
 */

get_header(); ?>

	<main id="primary" class="site-main">

		<?php while ( have_posts() ) : the_post(); ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php the_content(); ?>
			</article><!-- #post-<?php the_ID(); ?> -->

		<?php endwhile; ?>

	</main><!-- #primary -->

<?php
get_footer();
