<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.pslzme.com
 * @since      1.0.0
 *
 * @package    pslzme
 * @subpackage pslzme/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    pslzme
 * @subpackage pslzme/includes
 * @author     Alexander Dort GmbH <robin@alexanderdort.com>
 */
class Pslzme {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Pslzme_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $pslzme    The string used to uniquely identify this plugin.
	 */
	protected $pslzme;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PSLZME_VERSION' ) ) {
			$this->version = PSLZME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->pslzme = 'pslzme';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Pslzme_Loader. Orchestrates the hooks of the plugin.
	 * - Pslzme_i18n. Defines internationalization functionality.
	 * - Pslzme_Admin. Defines all hooks for the admin area.
	 * - Pslzme_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/pslzme-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/pslzme-i18n.php';


		/**
		 * Load the database connection class
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/pslzme-database-connection.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/pslzme-admin.php';

		/**
		 * Load all admin controller files
		 */
		$admin_controller_path = plugin_dir_path(dirname(__FILE__)) . 'admin/controller/';
		foreach (glob($admin_controller_path . '*.php') as $file) {
			require_once $file;
		}


		/**
		 * Load all admin database files
		 */
		$admin_database_path = plugin_dir_path(dirname(__FILE__)) . 'admin/database/';
		foreach (glob($admin_database_path . '*.php') as $file) {
			require_once $file;
		}

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/pslzme-public.php';


		/**
		 * Load all public database files
		 */
		$public_database_path = plugin_dir_path(dirname(__FILE__)) . 'public/database/';
		foreach (glob($public_database_path . '*.php') as $file) {
			require_once $file;
		}


		/**
		 * Load public controller file
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/controller/pslzme-public-route-controller.php';
			

		$this->loader = new Pslzme_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Pslzme_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Pslzme_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Pslzme_Admin( $this->get_pslzme(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_pslzme_admin_settings_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_pslzme_settings' );
		$this->loader->add_action( 'wp_ajax_pslzme_create_tables', $plugin_admin, 'handle_create_tables' );
		$this->loader->add_action( 'wp_ajax_pslzme_register_customer', $plugin_admin, 'handle_register_customer');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Pslzme_Public( $this->get_pslzme(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );	
		$this->loader->add_action( 'rest_api_init', $plugin_public, 'register_rest_routes');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_pslzme() {
		return $this->pslzme;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Pslzme_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
