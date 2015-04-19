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

add_action( 'wp_enqueue_scripts', 'podcast_pro_enqueue_assets' );
/**
 * Enqueue theme assets.
 *
 * @since 1.0.0
 */
function podcast_pro_enqueue_assets() {

	// Load mobile responsive menu
	wp_enqueue_script( 'podcast-pro-responsive-menu', get_stylesheet_directory_uri() . '/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true );

	$localize = array(
		'buttonText'     => __( 'Menu', 'podcast-pro' ),
		'buttonLabel'    => __( 'Primary Navigation Menu', 'podcast-pro' ),
		'subButtonText'  => __( 'Menu', 'podcast-pro' ),
		'subButtonLabel' => __( 'Sub Navigation Menu', 'podcast-pro' ),
	);

	// Localize the responsive menu script (for translation)
	wp_localize_script( 'podcast-pro-responsive-menu', 'utilityResponsiveL10n', $localize );

	// Keyboard navigation (dropdown menus) script
	wp_enqueue_script( 'genwpacc-dropdown',  get_stylesheet_directory_uri() . '/js/genwpacc-dropdown.js', array( 'jquery' ), false, true );

	// Load skiplink scripts
	wp_enqueue_script( 'genwpacc-skiplinks-js',  get_stylesheet_directory_uri() . '/js/genwpacc-skiplinks.js', array(), '1.0.0', true );

}
