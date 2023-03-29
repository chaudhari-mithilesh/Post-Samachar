<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://https://mithilesh.wisdmlabs.net/
 * @since      1.0.0
 *
 * @package    Post_Samachar
 * @subpackage Post_Samachar/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Post_Samachar
 * @subpackage Post_Samachar/includes
 * @author     Mithilesh <mithilesh.chaudhaudhari@wisdmlabs.com>
 */
class Post_Samachar_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'post-samachar',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
