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


add_action( 'pre_get_posts', 'cd_sort_podcasts' );
/**
 * Sort Podcast CPT by date in admin
 *
 */
function cd_sort_podcasts( $wp_query ) {

  if ( is_admin() ) {

  	// Get the post type from the query
  	$post_type = $wp_query->query[ 'post_type' ];

  	// If  it's the podcast post type, order by date desc
    if ( 'podcast' == $post_type ) {
      $wp_query->set( 'orderby', 'date' );
      $wp_query->set( 'order', 'DESC' );
    }
  }
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
 * This function modifies the main WordPress query to include an array of
 * post types instead of the default 'post' post type.
 *
 * h/t Thomas Griffin (https://gist.github.com/thomasgriffin/4159035/)
 *
 * @param object $query  The original query.
 * @return object $query The amended query.
 */
function cd_cpt_search( $query ) {

    if ( $query->is_search ) {
		$query->set( 'post_type', array( 'podcast' ) );
    }

    return $query;

}

/**
 * Change post meta based on custom post type
 *
 */
function cd_post_meta_filter( $post_meta ) {

	if ( 'podcast' == get_post_type() ) {
		$post_meta = '[post_terms before="Keywords: " taxonomy="keywords"]';
	}

	return $post_meta;
}
