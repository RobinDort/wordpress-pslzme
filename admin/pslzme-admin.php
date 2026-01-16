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

		//enable AJAX requests
		wp_localize_script($this->pslzme, 'pslzme_admin_ajax', [
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('pslzme_create_tables')
		]);
	}


	public function add_pslzme_admin_settings_menu() {
		$svg_file = plugin_dir_path(__FILE__) . 'images/pslzme_fingerprint.svg';
		$svg_content = file_get_contents($svg_file);

		// wordpress does allow Base64 encoded svg icons for admin menu items

		// Encode in base64
		$svg_base64 = base64_encode($svg_content);

		// Create the data URI
		$svg_data_uri = 'data:image/svg+xml;base64,' . $svg_base64;
		add_menu_page("Pslzme Settings", "Pslzme", "manage_options", "pslzme_settings", [$this, 'display_pslzme_settings_menu'], $svg_data_uri);
	}

	public function register_pslzme_settings() {
		// Register the option group, option name, and sanitize callback
		register_setting("pslzme_settings_group", "pslzme_settings", [$this, "sanitize_pslzme_settings"]);
		add_settings_section("pslzme_db_section", __("Datenbank Konfiguration"), null, "pslzme_settings");

		// add fields
		$fields = [
			'db_name' => __("Datenbankname", "pslzme"),
			'db_user' => __("Datenbank-User", "pslzme"),
			'db_password' => __("Datenbank-Passwort", "pslzme"),
		];

		foreach($fields as $id => $title) {
			add_settings_field($id, $title, [$this, 'render_pslzme_settings_field'], 'pslzme_settings', 'pslzme_db_section', ['id' => $id]);
		}
	}


	public function display_pslzme_settings_menu() {
		include_once plugin_dir_path(__FILE__) . 'partials/pslzme-admin-settings-display.php';
	}


	public function sanitize_pslzme_settings($input) {
		$sanitized = [];
		$sanitized['db_name'] = sanitize_text_field($input['db_name'] ?? '');
		$sanitized['db_user'] = sanitize_text_field($input['db_user'] ?? '');
		$sanitized['db_password'] = sanitize_text_field($input['db_password'] ?? '');
		return $sanitized;
	}

	public function render_pslzme_settings_field($args) {
		$options = get_option('pslzme_settings', []);
		$id = $args['id'];
		$type = ($id === 'db_password') ? 'password' : 'text';
		$value = $options[$id] ?? '';

		 printf(
        '<input type="%1$s" name="pslzme_settings[%2$s]" value="%3$s" required>',
        esc_attr($type),
        esc_attr($id),
        esc_attr($value)
    	);
	}

	public function handle_create_tables() {
		// Check nonce for security
		check_ajax_referer('pslzme_create_tables', 'nonce');
		$settingsController = new PslzmeAdminDatabaseOptionsController();
		$settingsController->handle_create_pslzme_tables();
	}

}
