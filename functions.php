<?php
/**
 * Podcast Pro.
 *
 * @package      podcast_pro
 * @link         http://www.carriedils.com/podcast-pro
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

// This file loads the Google fonts used in this theme
require get_stylesheet_directory() . '/includes/google-fonts.php';

// This file contains search form improvements
require get_stylesheet_directory() . '/includes/class-search-form.php';

add_action( 'genesis_setup', 'podcast_pro_setup', 15 );
/**
 * Theme setup.
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function podcast_pro_setup() {

	define( 'CHILD_THEME_NAME', 'podcast-pro' );
	define( 'CHILD_THEME_URL', 'https://store.carriedils.com/podcast-pro' );
	define( 'CHILD_THEME_VERSION', '1.0.0' );

	// Add HTML5 markup structure
	add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

	// Add viewport meta tag for mobile browsers
	add_theme_support( 'genesis-responsive-viewport' );

	// Add support for custom background
	add_theme_support( 'custom-background', array( 'wp-head-callback' => '__return_false' ) );

	// Add support for three footer widget areas
	add_theme_support( 'genesis-footer-widgets', 1 );

	// Add support for structural wraps (all default Genesis wraps unless noted)
	add_theme_support(
		'genesis-structural-wraps',
		array(
			'footer',
			'footer-widgets',
			'header',
			'home-optin', // Custom
			'nav',
			'site-inner',
			'site-tagline',
		)
	);

	// Add custom image sizes
	add_image_size( 'thumbnail', 150, 150, true );
	add_image_size( 'feature', 480, 360, true );

	// Unregister secondary sidebar
	unregister_sidebar( 'sidebar-alt' );

	// Unregister layouts that use secondary sidebar
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );

	// Register the default widget areas
	podcast_pro_register_widget_areas();

	// Add Utility Bar above header
	add_action( 'genesis_before_header', 'podcast_pro_add_bar' );

	// Add featured image above posts
	add_filter( 'the_content', 'podcast_pro_featured_image' );

	// Add a navigation area above the site footer
	add_action( 'genesis_before_footer', 'podcast_pro_do_footer_nav' );

	// Remove Genesis archive pagination (Genesis pagination settings still apply)
	remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

	// Add WordPress archive pagination (accessibility)
	add_action( 'genesis_after_endwhile', 'podcast_pro_post_pagination' );

	// Load skip links (accessibility)
	include get_stylesheet_directory() . '/includes/skip-links.php';

	// Apply search form enhancements (accessibility)
	add_filter( 'get_search_form', 'podcast_pro_get_search_form', 25 );

}

/**
 * Add Utility Bar above header.
 *
 * @since 1.0.0
 */
function podcast_pro_add_bar() {

	genesis_widget_area( 'utility-bar', array(
		'before' => '<div class="utility-bar"><div class="wrap">',
		'after'  => '</div></div>',
	) );
}

/**
* Add featured image above single posts.
*
* Outputs image as part of the post content, so it's included in the RSS feed.
* H/t to Robin Cornett for the suggestion of making image available to RSS.
*
* @since 1.0.0
*
* @return null Return early if not a single post or there is no thumbnail.
*/
function podcast_pro_featured_image( $content ) {

	if ( ! is_singular( 'post' ) || ! has_post_thumbnail() ) {
		return $content;
	}

	$image = '<div class="featured-image">';
	$image .= get_the_post_thumbnail( get_the_ID(), 'feature-large' );
	$image .= '</div>';

	return $image . $content;
}

add_filter( 'genesis_footer_creds_text', 'podcast_pro_footer_creds' );
/**
 * Change the footer text.
 *
 * @since  1.0.0
 *
 * @return null Return early if not a single post or post does not have thumbnail.
 */
function podcast_pro_footer_creds( $creds ) {

	return '[footer_copyright first="2015 CWD Holdings LLC"]<br /><a href="http://www.carriedils.com/rainmaker/">Powered by Rainmaker</a>';
}

add_filter( 'genesis_author_box_gravatar_size', 'podcast_pro_author_box_gravatar_size' );
/**
 * Customize the Gravatar size in the author box.
 *
 * @since 1.0.0
 *
 * @return integer Pixel size of gravatar.
 */
function podcast_pro_author_box_gravatar_size( $size ) {
	return 96;
}

// Add theme widget areas
include get_stylesheet_directory() . '/includes/widget-areas.php';

// Add scripts to enqueue
include get_stylesheet_directory() . '/includes/enqueue-assets.php';

// Miscellaenous functions used in theme configuration
include get_stylesheet_directory() . '/includes/theme-config.php';

// Miscellaenous functions used for podcasts
include get_stylesheet_directory() . '/includes/podcast-helpers.php';
