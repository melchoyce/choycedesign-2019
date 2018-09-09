<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Choyce Design
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function choycedesign_2018_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'choycedesign_2018_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function choycedesign_2018_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'choycedesign_2018_pingback_header' );

/**
 * Add a link to "all posts" in the next/prev post navigation
 */
function choycedesign_2018_post_navigation( $template, $class ) {
	if ( 'post-navigation' !== $class ) {
		return $template;
	}
	$all_posts = sprintf(
		'<div class="nav-all"><a href="%s" rel="prev">%s</a></div>',
		home_url( '/archive' ),
		__( 'All Posts', 'choycedesign' )
	);

	return str_replace( '</h2>', '</h2>' . $all_posts, $template );
}
add_filter( 'navigation_markup_template', 'choycedesign_2018_post_navigation', 10, 2 );

/**
 * Get a list of all posts, sorted by year, from cached value. Rebuild cache if not found.
 */
function choycedesign_2018_get_posts_by_year() {
	$all_posts_by_year = get_transient( 'cd2018_archives_by_year' );
	if ( false === $all_posts_by_year ) {
		$all_posts_by_year = _choycedesign_2018_generate_posts();
		set_transient( 'cd2018_archives_by_year', $all_posts_by_year, WEEK_IN_SECONDS );
	}

	return $all_posts_by_year;
}

/**
 * Get a list of all posts, sorted by year (this function bypasses cache).
 */
function _choycedesign_2018_generate_posts() {
	$all_posts = get_posts( array(
		'posts_per_page' => -1,
		'post_type' => 'post',
		'suppress_filters' => true,
		// TODO Only posts in the last 3? 4? years (or last 40-50?)
	) );

	$all_posts_by_year = array();

	foreach( $all_posts as $post ) {
		$year = mysql2date( 'Y', $post->post_date );
		$link = sprintf(
			'<a href="%s" rel="bookmark">%s</a>',
			esc_url( get_permalink( $post ) ),
			esc_html( get_the_title( $post ) )
		);

		if ( ! isset( $all_posts_by_year ) ) {
			$all_posts_by_year[ $year ] = [ $link ];
		} else {
			$all_posts_by_year[ $year ][] = $link;
		}
	}

	krsort( $all_posts_by_year );

	return $all_posts_by_year;
}

/**
 * Flush the transient when posts are added/deleted.
 */
function choycedesign_2018_update_post_cache( $new_status, $old_status, $post ) {
	if ( 'post' !== $post->post_type ) {
		return;
	}
	// If newly published or newly deleted…
	if ( ( 'publish' === $new_status && 'publish' !== $old_status )
		|| ( 'trash' === $new_status && 'trash' !== $old_status ) ) {
		$all_posts_by_year = _choycedesign_2018_generate_posts();
		set_transient( 'cd2018_archives_by_year', $all_posts_by_year, WEEK_IN_SECONDS );
	}
}
add_action( 'transition_post_status', 'choycedesign_2018_update_post_cache', 10, 3 );
