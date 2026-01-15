<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.pslzme.com
 * @since      1.0.0
 *
 * @package    pslzme
 * @subpackage pslzme/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    pslzme
 * @subpackage pslzme/admin
 * @author     Alexander Dort GmbH <robin@alexanderdort.com>
 */
class Pslzme_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $pslzme    The ID of this plugin.
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
	 * @param      string    $pslzme       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $pslzme, $version ) {

		$this->pslzme = $pslzme;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pslzme_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pslzme_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->pslzme, plugin_dir_url( __FILE__ ) . 'css/pslzme-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Pslzme_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Pslzme_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->pslzme, plugin_dir_url( __FILE__ ) . 'js/pslzme-admin.js', array( 'jquery' ), $this->version, false );

	}


	public function add_pslzme_admin_settings_menu() {
		add_menu_page("Pslzme", "Konfiguration", "manage_options", plugin_dir_path( __FILE__ ) . "partials/pslzme-admin-settings-display.php", null, "none");
	}

}
