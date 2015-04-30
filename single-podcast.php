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


add_action ( 'genesis_after_entry', 'show_sponsors', 5 );
/**
 * Add Sponsor Boxes underneath podcast entry
 *
 * Relies on a relationship between podcast CPT and sposnor CPT
 * created by the Post Connector plugin.
 * https://post-connector.com/
 *
 */
function show_sponsors() {

	// Get the connected posts
	$my_connected_posts = Post_Connector::API()->get_children( 'podcast-sponsors', get_the_id() );

	// Check
	if ( count( $my_connected_posts ) > 0 ) {

		// Loop
		foreach ( $my_connected_posts as $my_connected_post ) {

			echo '<div class="episode-sponsor-box">';

				echo '<div class="sponsor-thumbnail">';
					echo '<span class="sponsor-box-label">Sponsor</span>';
					echo get_the_post_thumbnail( $my_connected_post->ID );
				echo '</div>'; //end sponsor-thumbnail

				// Don't filter the content. Keep original markup
				$content = apply_filters( 'the_content', $my_connected_post->post_content );
				$content = str_replace( ']]>', ']]&gt;', $content );

				echo '<div class="sponsor-summary"><div class="sponsor-content">';
					echo $content;
					echo '<a class="button" href="' . get_permalink( $my_connected_post->ID ) . '">' . 'Get ' .$my_connected_post->post_title . '</a><br/>';
				echo'</div></div>'; //end sponsor-summary

			echo '</div>'; //end episode-sponsor
		}

	}
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
	$my_connected_posts = Post_Connector::API()->get_children( 'podcast-transripts', get_the_id() );

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