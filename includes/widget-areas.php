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

/**
 * Register the widget areas enabled by default in Utility.
 *
 * @since  1.0.0
 *
 * @return string Markup for each sidebar ID
 */
function podcast_pro_register_widget_areas() {

	$widget_areas = array(
		array(
			'id'          => 'utility-bar',
			'name'        => __( 'Utility Bar', 'podcast-pro' ),
			'description' => __( 'This is the utility bar across the top of page.', 'podcast-pro' ),
		),
		array(
			'id'          => 'home-welcome',
			'name'        => __( 'Home Welcome', 'podcast-pro' ),
			'description' => __( 'This is the welcome section at the top of the home page.', 'podcast-pro' ),
		),
		array(
			'id'          => 'home-announce',
			'name'        => __( 'Home Announce', 'podcast-pro' ),
			'description' => __( 'This is the announcement section at the top of the home page.', 'podcast-pro' ),
		),
		array(
			'id'          => 'home-optin',
			'name'        => __( 'Home Optin', 'podcast-pro' ),
			'description' => __( 'This widget area appears near the top of the home page.', 'podcast-pro' ),
		),
		array(
			'id'          => 'call-to-action',
			'name'        => __( 'Call to Action', 'podcast-pro' ),
			'description' => __( 'This is the Call to Action section on the home page.', 'podcast-pro' ),
		),
		array(
			'id'          => 'podcast-sidebar',
			'name'        => __( 'Podcast Sidebar', 'podcast-pro-sidebar' ),
			'description' => __( 'This is the Sidebar that appears on Podcast posts.', 'podcast-pro' ),
		),
	);

	$widget_areas = apply_filters( 'podcast_pro_default_widget_areas', $widget_areas );

	foreach ( $widget_areas as $widget_area ) {
		genesis_register_sidebar( $widget_area );
	}
}
