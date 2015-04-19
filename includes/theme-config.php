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

// Enable shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'theme_page_templates', 'podcast_pro_remove_genesis_page_templates' );
/**
 * Remove Genesis Blog page template.
 *
 * @param array $page_templates
 * @return array
 */
function podcast_pro_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}

// Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'podcast_pro_remove_comment_form_allowed_tags' );
function podcast_pro_remove_comment_form_allowed_tags( $defaults ) {
	$defaults['comment_notes_after'] = '';
	return $defaults;
}

/**
 * Customize the search form to improve accessibility.
 *
 * The instantiation can accept an array of custom strings, should you want
 * the search form have different strings in different contexts.
 *
 * @since 1.0.0
 *
 * @return string Search form markup.
 */
function podcast_pro_get_search_form() {
	$search = new podcast_pro_Search_Form;
	return $search->get_form();
}

/**
 * Use WordPress archive pagination.
 *
 * Return a paginated navigation to next/previous set of posts, when
 * applicable. Includes screen reader text for better accessibility.
 *
 * @since  1.0.0
 *
 * @see  the_posts_pagination()
 * @return string Markup for pagination links.
 */
function podcast_pro_post_pagination() {
	$args = array(
		'mid_size' => 2,
		'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'podcast-pro' ) . ' </span>',
	);

	if ( 'numeric' === genesis_get_option( 'posts_nav' ) ) {
		the_posts_pagination( $args );
	} else {
		the_posts_navigation( $args );
	}
}

/**
 * Create podcast post type.
 */
add_action( 'init', 'create_post_type' );
function create_post_type() {

	// Podcast custom post type
	register_post_type( 'podcast',
		array(
			'labels' => array(
				'name'          => __( 'Podcast' ),
				'singular_name' => __( 'Podcast' ),
			),
			'exclude_from_search' => true,
			'has_archive'         => true,
			'hierarchical'        => true,
			'menu_icon'           => 'dashicons-video-alt3',
			'public'              => true,
			'rewrite'             => array( 'slug' => 'podcast' ),
			'supports'            => array( 'title', 'editor', 'thumbnail', 'comments', 'custom-fields', 'genesis-seo', 'genesis-cpt-archives-settings' ),
		)
	);

}
