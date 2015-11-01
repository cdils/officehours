<?php

/**
 * Template Name: Guest List
 */


add_action('genesis_entry_content', 'podcast_pro_list_guests');
/**
 * Display list of guests who've appeared on podcast.
 *
 * Custom taxonomy used for guests is `keywords`.
 *
 * @return array
 */
function podcast_pro_list_guests() {

 $args = array(
	'show_option_all'    => '',
	'orderby'            => 'name',
	'order'              => 'ASC',
	'style'              => 'list',
	'show_count'         => 1,
	'hide_empty'         => 1,
	'use_desc_for_title' => 1,
	'child_of'           => 0,
	'feed'               => '',
	'feed_type'          => '',
	'feed_image'         => '',
	'exclude'            => '',
	'exclude_tree'       => '',
	'include'            => '',
	'hierarchical'       => 1,
	'title_li'           => __( '' ),
	'show_option_none'   => __( '' ),
	'number'             => null,
	'echo'               => 1,
	'depth'              => 0,
	'current_category'   => 0,
	'pad_counts'         => 0,
	'taxonomy'           => 'keywords',
	'walker'             => null
    );
	wp_list_categories( $args );

}

genesis();
