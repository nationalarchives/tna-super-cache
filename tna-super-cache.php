<?php
/**
 * Plugin Name: TNA Super Cache (bypass button & do not cache internal TNA)
 * Plugin URI: https://github.com/nationalarchives/tna-super-cache
 * Description: The National Archives Super Cache bypass cache button & do not cache internal TNA Wordpress plugin.
 * Version: 0.1
 * Author: Chris Bishop
 * Author URI: https://github.com/nationalarchives
 * License: GPL2
 */

// WP Super Cache DONOTCACHEPAGE if internal TNA
function do_not_cache_page_if_internal() {
	if ( !is_admin() ) {
		if ( substr( $_SERVER['REMOTE_ADDR'], 0, 3 ) === '10.' ) {
			// Internal TNA
			define( 'DONOTCACHEPAGE', true );
		}
	}
}
add_action( 'wp_loaded', 'do_not_cache_page_if_internal' );

// Adds 'Bypass Cache' to admin toolbar
function bypass_cache_button( $wp_admin_bar ) {
	$args = array(
		'id' => 'bypass-cache',
		'title' => 'Bypass Cache',
		// TEST Key
		'href' => get_permalink() . '?donotcachepage=0dad2424cff6e4a18814494ba509cfb8',
		'meta' => array(
			'class' => 'bypass-cache'
		)
	);
	$wp_admin_bar->add_node( $args );
}
add_action('admin_bar_menu', 'bypass_cache_button', 50);