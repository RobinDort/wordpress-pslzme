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

		// remove the pslzme_settings
		$pslzmeSettings = get_option('pslzme_settings', []);

		if (!empty($pslzmeSettings)) {
			delete_option("pslzme_settings");
		}
	}

}
