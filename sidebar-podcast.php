<?
/**
 * Custom sidebar use on single podcasts
 *
 * Add Sponsor Boxes
 *
 * Relies on a relationship between podcast CPT and sponsor CPT
 * created by the Post Connector plugin.
 * https://post-connector.com/
 *
 */

// Get the connected posts
$connected_sponsors = Post_Connector::API()->get_children( 'podcast-sponsors', get_the_id() );

// Make sure there are some records
if ( count( $connected_sponsors ) > 0 ) {

	// Loop through each record
	foreach ( $connected_sponsors as $connected_sponsor ) {

		echo '<div class="episode-sponsor-box">';

			echo '<div class="sponsor-thumbnail">';
				echo '<span class="sponsor-box-label">Sponsor</span>';
				echo get_the_post_thumbnail( $connected_sponsor->ID );
			echo '</div>'; //end sponsor-thumbnail

			// Don't filter the content. Keep original markup
			$content = $connected_sponsor->post_content;
			$content = apply_filters( 'the_content', $connected_sponsor->post_content );

			echo '<div class="sponsor-summary"><div class="sponsor-content">';
				echo $content;
			echo'</div></div>'; //end sponsor-summary

		echo '</div>'; //end episode-sponsor
	}

}