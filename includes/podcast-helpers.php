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

/**
 * Custom featured image for the podcast entries.
 *
 * @param  array $classes
 * @since  1.0.0
 */
function podcast_pro_podcast_image() {

	// Display the promo image if we're not live.
	if ( ! podcast_pro_is_show_live() ) {
		podcast_pro_the_promo_image();
		return;
	}

	// Get the video thumbnail.
	$video_id = esc_attr( genesis_get_custom_field( 'youtube_id' ) );
	$video_thumbnail = '<img src="http://img.youtube.com/vi/' . $video_id . '/0.jpg" />';

	// Output the featured image.
	printf( '<a href="%s" class="featured-image" title="%s">%s</a>', get_permalink(), the_title_attribute( 'echo=0' ), $video_thumbnail );
}

/**
 * Displays a promo image if one exists.
 *
 * @uses Advanced Custom Fields
 * @since 2.0.0
 */
function podcast_pro_the_promo_image() {
	// Do nothing if we have no promo image.
	if ( ! has_post_thumbnail() ) {
		return;
	}

	// Get the promo image.
	$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'feature' );
	// Set the image title to the post title.
	$title = the_title_attribute( 'echo=0' );

	// Output the promo image.
	printf( '<a href="%s" class="featured-image"><img title="%s" alt="%s" src="%s" /></a>', get_permalink(), $title, $title, $image[0] );
}

/**
 * Loop through podcasts (for archive-style display).
 *
 */
function podcast_pro_archive_loop() {

	global $post;
	$args = array(
		'posts_per_page'   => 10,
		'orderby'          => 'post_date',
		'order'            => 'DESC',
		'post_type'        => 'podcast',
	);
	$podcasts = get_posts( $args );

	$counter = 0;

	echo '<div class="list-podcasts">';
		echo '<div class="wrap">';
			foreach ( $podcasts as $post ) {
				setup_postdata( $post );
				$counter++;

				echo sprintf( '<article class="%s">', implode( ' ', get_post_class() ) );

					// Print Episode Number
					echo '<div class="one-sixth first">';
					printf( '<a href="%s" class="episode-count"><span class="episode">Episode</span>%s</a>', get_permalink(), basename( get_permalink() ) );
					echo '</div>';

					// Print Episode Title & Meta
					echo '<div class="five-sixths episode-detail">';
					echo '<header class="entry-header">';
						printf( '<h4 class="episode-title"><a href="%s" title="%s">%s</a></h4>', get_permalink(), the_title_attribute( 'echo=0' ), get_the_title() );
					echo '</header>';

					echo '<p class="entry-meta">';
						echo podcast_pro_podcast_date_info();
						echo podcast_pro_get_guests();
					echo '</p>';
					echo '</div>';

			 	echo '</article>';
			}
		echo '</div>';
	echo '</div>';
	wp_reset_postdata();
}

