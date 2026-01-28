<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.pslzme.com
 * @since      1.0.0
 *
 * @package    pslzme
 * @subpackage pslzme/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    pslzme
 * @subpackage pslzme/includes
 * @author     Alexander Dort GmbH <robin@alexanderdort.com>
 */
class Pslzme_Activator {
	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// create a new pslzme pages so the navigation functionality works as intended
		$pageController = new PslzmeAdminPagesController();
		$pageController->create_pslzme_acception_page();
		$pageController->create_pslzme_decline_page();

	}

}
