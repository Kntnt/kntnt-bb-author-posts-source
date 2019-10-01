<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Author's Posts Source for Beaver Builder
 * Plugin URI:        https://github.com/Kntnt/kntnt-bb-author-posts-source
 * GitHub Plugin URI: https://github.com/Kntnt/kntnt-bb-author-posts-source
 * Description:       Extends Beaver Builder's loop settings with a source that returns posts of the current post's author.
 * Version:           1.0.0
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       kntnt-bb-author-posts-source
 * Domain Path:       /languages
 */

namespace Kntnt\BB_Authors_Post_Source;

defined( 'WPINC' ) && new Plugin;

final class Plugin {

	public function __construct() {
		load_plugin_textdomain( 'kntnt-bb-author-posts-source', false, 'languages' );
		add_action( 'plugins_loaded', [ $this, 'run' ] );
	}

	public function run() {
		add_filter( 'fl_builder_render_settings_field', [ $this, 'data_source_field' ], 10, 3 );
		add_filter( 'fl_builder_loop_query_args', [ $this, 'builder_loop_query_args' ] );
	}

	public function data_source_field( $field, $name, $settings ) {
		if ( 'data_source' == $name ) {
			$field['options']['kntnt-bb-author-posts-source'] = __( "Posts of the current post's author", 'kntnt-bb-author-posts-source' );
		}
		return $field;
	}

	public function builder_loop_query_args( $args ) {
		if ( 'kntnt-bb-author-posts-source' == $args['settings']->data_source ) {
			$args['author__in'] = [ get_the_author_meta( 'ID' ) ];
		}
		return $args;
	}

}
