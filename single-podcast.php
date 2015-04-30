<?php
/**
 * The custom podcast post type single template
 */


// Use a custom sidebar
//remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
add_action( 'genesis_sidebar', 'podcast_pro_get_podcast_sidebar' );
function podcast_pro_get_podcast_sidebar(){
	get_sidebar( 'podcast' );
}

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

add_action ( 'genesis_after_entry', 'show_transcript' );
/**
 * Add Transcript underneath podcast entry
 *
 * Relies on a relationship between podcast CPT and transcipt CPT
 * created by the Post Connector plugin.
 * https://post-connector.com/
 *
 */
function show_transcript() {

	// Get the connected posts
	$my_connected_posts = Post_Connector::API()->get_children( 'podcast-transcripts', get_the_id() );

	// Check
	if ( count( $my_connected_posts ) > 0 ) {

		// Loop
		foreach ( $my_connected_posts as $my_connected_post ) {

			// Don't filter the content. Keep original markup
			$content = apply_filters( 'the_content', $my_connected_post->post_content );
			$content = str_replace( ']]>', ']]&gt;', $content );

			echo '<div class="transcript-box">';
				echo '<h2>Episode Transcript</h2>';
				echo $content;
			echo '</div>'; //end transcript-box
		}

	}
}

genesis();