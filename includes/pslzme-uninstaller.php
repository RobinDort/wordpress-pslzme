<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    pslzme
 * @subpackage pslzme/includes
 */

 class Pslzme_Uninstaller {

    	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $pslzme  The ID of this plugin.
	 */
	private $pslzme;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $pslzme     The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($pslzme, $version ) {

		$this->pslzme = $pslzme;
		$this->version = $version;

	}

    
    public function uninstall() {
        // If uninstall not called from WordPress, then exit.
        if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
            exit;
        }
    }
 }


