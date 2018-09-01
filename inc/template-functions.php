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
