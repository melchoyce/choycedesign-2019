<?php
/**
 * Partial template file for displaying the archive post list (in year sections).
 *
 * @package Choyce Design
 */

// TODO Cache the sorted list
$all_posts = get_posts( array(
	'posts_per_page' => -1,
	'post_type' => 'post',
	'suppress_filters' => true,
	// TODO Only posts in the last 3? 4? years
) );

$all_posts_by_year = [];

foreach( $all_posts as $post ) {
	$year = mysql2date( 'Y', $post->post_date );
	if ( ! isset( $all_posts_by_year ) ) {
		$all_posts_by_year[ $year ] = [ $post ];
	} else {
		$all_posts_by_year[ $year ][] = $post;
	}
}

ksort( $all_posts );

// END CACHED FUNCTION… eventually

foreach( $all_posts_by_year as $year => $posts ) {
?>
	<section class="archive">
		<h2 class="archive-year"><?php echo $year; ?></h2>

		<ul class="archive-list">
		<?php foreach( $posts as $post ) {
			global $post;
			setup_postdata( $post );
			the_title(
				sprintf( '<li class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
				'</a></li>'
			);
		} ?>
		</ul>
	</section>
<?php
wp_reset_postdata();
}
