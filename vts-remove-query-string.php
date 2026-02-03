<?php
/**
 * Plugin Name: WP Rocket | Simple Remove Query Strings
 * Description: Removes ?ver= from all CSS/JS files
 */

namespace WP_Rocket\Helpers\remove_query_strings;

defined( 'ABSPATH' ) or die();

function remove_ver_parameter( $src ) {
	// Skip WP Rocket cache
	if ( strpos( $src, '/cache/' ) !== false ) {
		return $src;
	}
	
	return remove_query_arg( 'ver', $src );
}

add_filter( 'style_loader_src', __NAMESPACE__ . '\remove_ver_parameter', 15 );
add_filter( 'script_loader_src', __NAMESPACE__ . '\remove_ver_parameter', 15 );

// Clear cache on activation/deactivation
function regenerate_rocket_config() {
	if ( function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
	}
	if ( function_exists( 'rocket_generate_config_file' ) ) {
		rocket_generate_config_file();
	}
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\regenerate_rocket_config' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\regenerate_rocket_config' );