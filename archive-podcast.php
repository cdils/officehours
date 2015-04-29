<?php
/**
 * The custom podcast post type single template
 */

// Add Search form
//add_action( 'genesis_before_loop', 'cd_add_search' );
function cd_add_search() {
	echo '<div class="search">' . get_search_form( false ) . '</div>';
}

// Remove the regular loop & replace it with custom loop to display podcasts
remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action ( 'genesis_loop', 'podcast_pro_archive_loop' );

genesis();