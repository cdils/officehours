<?php
/**
 * Theme Updater.
 *
 * Originally from Easy Digital Downloads, but customized for Podcast Pro.
 *
 * @package podcast_pro
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/vendors/edd-software-licensing/theme-license-admin.php' );
}

// Loads the updater classes
$GLOBALS['updater'] = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://store.carriedils.com', // Site where EDD is hosted
		'item_name'      => 'Podcast Pro', // Name of theme
		'theme_slug'     => 'podcast-pro', // Theme slug
		'version'        => '1.0.0', // The current version of this theme
		'author'         => 'Carrie Dils', // The author of this theme
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Podcast Pro License', 'podcast-pro' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'podcast-pro' ),
		'license-key'               => __( 'License Key', 'podcast-pro' ),
		'license-action'            => __( 'License Action', 'podcast-pro' ),
		'deactivate-license'        => __( 'Deactivate License', 'podcast-pro' ),
		'activate-license'          => __( 'Activate License', 'podcast-pro' ),
		'status-unknown'            => __( 'License status is unknown.', 'podcast-pro' ),
		'renew'                     => __( 'Renew?', 'podcast-pro' ),
		'unlimited'                 => __( 'unlimited', 'podcast-pro' ),
		'license-key-is-active'     => __( 'License key is active.', 'podcast-pro' ),
		'expires%s'                 => __( 'Expires %s.', 'podcast-pro' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'podcast-pro' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'podcast-pro' ),
		'license-key-expired'       => __( 'License key has expired.', 'podcast-pro' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'podcast-pro' ),
		'license-is-inactive'       => __( 'License is inactive.', 'podcast-pro' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'podcast-pro' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'podcast-pro' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'podcast-pro' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'podcast-pro' ),
		'update-available'          => __( '<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'podcast-pro' )
	)

);

add_action( 'admin_menu', 'podcast_pro_move_license_page_menu_item', 12 );
/**
 * Move the license page menu item from under the Appearance menu to
 * under the Genesis menu.
 *
 * @since 1.0.0
 *
 * @author Gary Jones
 */
function podcast_pro_move_license_page_menu_item() {
	global $updater;
	$page = remove_submenu_page( 'themes.php', 'podcast-pro-license' );
	add_submenu_page( 'genesis', $page[3], $page[0], $page[1], $page[2], array( $updater, 'license_page' ) );
}
