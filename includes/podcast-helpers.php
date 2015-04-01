<?php

// Customize the post info for podcasts
add_filter( 'genesis_post_info', 'podcast_pro_post_info_filter', 25 );
function podcast_pro_post_info_filter( $post_info ) {

	// Check to see if there's a custom field for speaker_title
	if ( ! genesis_get_custom_field( 'air_date' ) ) {
		return;
	}

	$post_info = podcast_pro_podcast_date_info();
	return $post_info;
}

/**
 * Displays information about the podcast's air date including the date, time,
 * and whether or not it's already aired.
 *
 * H/T Rob Neu
 *
 * @uses podcast_pro_get_the_air_date()
 * @uses podcast_pro_get_the_air_time()
 * @since 1.0.0
 */
function podcast_pro_podcast_date_info() {

	// Do nothing if the post has no air date or air time.
	if ( ! genesis_get_custom_field( 'air_date' ) ) {
		return;
	}

	// Get the Podcast's air date.
	$air_date = podcast_pro_get_the_air_date();
	// Get the Podcast's air time.
	$air_time = podcast_pro_get_the_air_time();

	// Set some air text.
	$air_text = __( 'Airs on ', 'podcast_pro' );

	// Set different air text for already-aired episodes.
	if ( podcast_pro_is_show_live() ) {
		$air_text = __( 'Aired on ', 'podcast_pro' );
	}

	// Display the air date and time.
	return $air_text . esc_attr( $air_date );
}

// Checks to see whether the podcast is live
function podcast_pro_is_show_live() {
	$air_date = genesis_get_custom_field( 'air_date' );
	if ( current_time( 'timestamp', 0 ) > $air_date ) {
		return true;
	}
	return false;
}

// Checks to see the date the podcast aired
function podcast_pro_get_the_air_date() {
	$date = DateTime::createFromFormat( 'U', genesis_get_custom_field( 'air_date' ) );
	// Format the date for display.
	$air_date = $date->format( 'F dS, Y' );

	return $air_date;
}

// Checks to see the time the podcast aired
function podcast_pro_get_the_air_time() {
	$date = DateTime::createFromFormat( 'U', genesis_get_custom_field( 'air_date' ) );
	// Format the date for display.
	$air_time = $date->format( 'h:i A' );

	return $air_time;
}

function podcast_pro_get_guests() {

	// Do nothing if the post has no guest.
	if ( ! genesis_get_custom_field( 'guest1' ) ) {
		return;
	}

	$podcast_guests = '<p class="episode-guest">';

	$podcast_guests .= 'With ' . genesis_get_custom_field( 'guest1' );

	if ( genesis_get_custom_field( 'guest2' ) ) {
		$podcast_guests .= ' and ' . genesis_get_custom_field( 'guest2' );
	}

	$podcast_guests .= '</p>';

	return $podcast_guests;
}
