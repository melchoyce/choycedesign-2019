<?php
/**
 * Partial template file for displaying the archive post list (in year sections).
 *
 * @package Choyce Design
 */

$all_posts_by_year = choycedesign_2018_get_posts_by_year();

foreach( $all_posts_by_year as $year => $links ) {
?>
	<section class="full-archive">
		<h2 class="full-archive-year"><?php echo $year; ?></h2>

		<ul class="full-archive-list">
		<?php foreach( $links as $link ) {
			printf( '<li class="entry-title">%s</li>', $link );
		} ?>
		</ul>
	</section>
<?php
}
