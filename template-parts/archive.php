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
	<section>
		<h2><?php echo $year; ?></h2>

		<ul>
		<?php foreach( $posts as $post ) : ?>
			<li><?php echo $post->post_title; ?></li>
		<?php endforeach; ?>
		</ul>
<?php
}
