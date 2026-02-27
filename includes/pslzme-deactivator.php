<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.pslzme.com
 * @since      1.0.0
 *
 * @package    pslzme
 * @subpackage pslzme/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    pslzme
 * @subpackage pslzme/includes
 * @author     Alexander Dort GmbH <robin@alexanderdort.com>
 */
class Pslzme_Deactivator {
	/**
	 *
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// remove the created pslzme pages again
		$pageController = new PslzmeAdminPagesController();
		$pageController->remove_pslzme_acception_page();
		$pageController->remove_pslzme_decline_page();

		// remove various option values
		$pslzmeSettings = get_option('pslzme_settings', []);
		$pslzme_ip_settings = get_option("pslzme_ip_settings", []);
		$pslzme_api_key = get_option("pslzme_api_key", []);
		$pslzme_tables_configured = get_option("pslzme_tables_configured",[]);
		$pslzme_url_licensed = get_option("pslzme_url_licensed",[]);

		if (!empty($pslzmeSettings)) {
			delete_option("pslzme_settings");
		}
		if (!empty($pslzme_ip_settings)) {
			delete_option("pslzme_ip_settings");
		}
		if (!empty($pslzme_api_key)) {
			delete_option("pslzme_api_key");
		}
		if (!empty($pslzme_tables_configured)) {
			delete_option("pslzme_tables_configured");
		}
		if (!empty($pslzme_url_licensed)) {
			delete_option("pslzme_url_licensed");
		}
	}

}
