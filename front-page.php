<?php
/**
 * Front page for the Podcast Pro theme
 *
 * @package podcast_pro
 * @author  Carrie Dils
 * @license GPL-2.0+
 *
 */

add_action( 'genesis_meta', 'podcast_pro_homepage_setup' );
/**
 * Set up the homepage layout by conditionally loading sections when widgets
 * are active.
 *
 * @since 1.0.0
 */
function podcast_pro_homepage_setup() {

	$home_sidebars = array(
		'home_welcome' 	   => is_active_sidebar( 'home-welcome' ),
		'home_announce'   => is_active_sidebar( 'home-announce' ),
		'home_optin'   => is_active_sidebar( 'home-optin' ),
		'call_to_action'   => is_active_sidebar( 'call-to-action' ),
	);

	// Return early if no sidebars are active
	if ( ! in_array( true, $home_sidebars ) ) {
		return;
	}

	// Get static home page number.
	$page = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;

	// Only show home page widgets on page 1.
	if ( 1 == $page ) {

		// Add home welcome area if "Home Welcome" widget area is active
		if ( $home_sidebars['home_welcome'] ) {
			add_action( 'genesis_after_header', 'podcast_pro_add_home_welcome' );
		}

		// Add optin area if "Home Optin" widget area is active
		if ( $home_sidebars['home_announce'] ) {
			add_action( 'genesis_after_header', 'podcast_pro_add_home_announce' );
		}

		// Add optin area if "Home Optin" widget area is active
		if ( $home_sidebars['home_optin'] ) {
			add_action( 'genesis_after_header', 'podcast_pro_add_home_optin' );
		}

		// Add call to action area if "Call to Action" widget area is active
		if ( $home_sidebars['call_to_action'] ) {
			add_action( 'genesis_after_header', 'podcast_pro_add_call_to_action' );
		}
	}

	// Remove standard loop and replace with loop showing podcasts, not Page content.
	remove_action( 'genesis_loop', 'genesis_do_loop' );
	add_action ( 'genesis_loop', 'podcast_pro_archive_loop' );
}

// Display content for the "Home Welcome" section
function podcast_pro_add_home_welcome() {

	genesis_widget_area( 'home-welcome',
		array(
			'before' => '<div class="home-welcome"><div class="wrap">',
			'after' => '</div></div>',
		)
	);

}

// Display content for the "Home Announce" section
function podcast_pro_add_home_announce() {



	echo '<div class="home-announce"><div class="wrap">';

		echo '<h4 class="widgettitle">Next Episode</h4>';
		echo '<div class="hr"></div>';

		global $post;
		$args = array(
			'posts_per_page'   => 1,
			'orderby'          => 'post_date',
			'order'            => 'DESC',
			'post_type'        => 'podcast',
		);
		$podcasts = get_posts( $args );

		foreach ( $podcasts as $post ) {
			setup_postdata( $post );

			// Bring in featured image
			echo '<div class="one-third first"><div class="podcast-image">';
				podcast_pro_podcast_image();
			echo '</div></div>';

			// Bring in episode info
			echo '<div class="two-thirds">';

			echo '<div class="announce-podcast-date">' . podcast_pro_get_the_air_date() . ' at ' . podcast_pro_get_the_air_time() . '</div>';
			echo '<p class="announce-podcast-title">' . get_the_title() . '</p>';
			echo '<p>' . get_the_excerpt() . '</p>';
		}

		wp_reset_postdata();

		echo '</div>';

	echo '</div></div>';

}

// Display content for the "Call to action" section
function podcast_pro_add_call_to_action() {

	genesis_widget_area(
		'call-to-action',
		array(
			'before' => '<div class="call-to-action-bar"><div class="wrap">',
			'after' => '</div></div>',
		)
	);
}

// Display content for the "Home Optin" section
function podcast_pro_add_home_optin() {

	genesis_widget_area( 'home-optin',
		array(
			'before' => '<div class="home-optin"><div class="wrap">',
			'after' => '</div></div>',
		)
	);
}

/** Display the "podcasts" section. */
function podcast_pro_archive_loop() {
	global $post;
	$args = array(
		'posts_per_page'   => 6,
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

genesis();
