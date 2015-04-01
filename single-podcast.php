<?php
/**
 * The custom podcast post type single template
 */

// Display the podcast video/promo area.
add_action( 'genesis_entry_header', 'podcast_pro_show_the_video', 15 );

/**
 * Displays an embeded podcast video if one exists.
 *
 */
function podcast_pro_show_the_video() {
	// Do nothing if we have no video to embed.
	if ( ! genesis_get_custom_field( 'youtube_id' ) ) {
		return;
	}

	$attr = array(
		'src'      => esc_url( "http://youtube.com/watch?v=" . genesis_get_custom_field( 'youtube_id' ) ),
		'width'    => 740,
	);
	echo '<div class="podcast-top">';
		echo wp_video_shortcode( $attr );
	echo '</div>';
}

genesis();