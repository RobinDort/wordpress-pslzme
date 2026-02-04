<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.pslzme.com
 * @since      1.0.0
 *
 * @package    pslzme
 * @subpackage pslzme/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    pslzme
 * @subpackage pslzme/includes
 * @author     Alexander Dort GmbH <robin@alexanderdort.com>
 */
class Pslzme_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'pslzme',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

	public function filter_plugin_mo_file($mofile, $domain) {
		if ( 'wordpress-pslzme' === $domain && false !== strpos( $mofile, WP_LANG_DIR . '/plugins/' ) ) {
			$locale = apply_filters( 'plugin_locale', determine_locale(), $domain );
			$mofile = WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/' . $domain . '-' . $locale . '.mo';
		}
		return $mofile;
	}



}
