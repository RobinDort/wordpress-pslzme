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


	/**
	 * 
	 * This function adds a new menu inside the Wordpress admin panel for the configuration of pslzme. 
	 * 
	 */
	public function add_pslzme_admin_settings_menu() {
		$svg_file = plugin_dir_path(__FILE__) . 'images/pslzme_fingerprint.svg';
		$svg_content = file_get_contents($svg_file);

		// wordpress does allow Base64 encoded svg icons for admin menu items

		// Encode in base64
		$svg_base64 = base64_encode($svg_content);

		// Create the data URI
		$svg_data_uri = 'data:image/svg+xml;base64,' . $svg_base64;
		add_menu_page("Pslzme Settings", "pslzme", "manage_options", "pslzme_settings", [$this, 'display_pslzme_settings_menu'], $svg_data_uri);
	}

	/**
	 * 
	 * This function creates new settings to use inside the configuration forms inside the pslzme-admin-settings-display.php file.
	 * 
	 */
	public function register_pslzme_settings() {
		// Single option for everything
		register_setting("pslzme_settings_group", "pslzme_settings", [
			'sanitize_callback' => [$this, "sanitize_pslzme_settings"]
		]);

		// --- DB Section ---
		add_settings_section(
			"pslzme_db_section",
			__("Datenbank Konfiguration"),
			null,
			"pslzme_settings"
		);

		$db_fields = [
			'db_name' => __("Database name", "pslzme"),
			'db_user' => __("Database user", "pslzme"),
			'db_password' => __("Database password", "pslzme"),
		];

		foreach ($db_fields as $id => $title) {
			add_settings_field(
				$id,
				$title,
				[$this, 'render_pslzme_settings_field'],
				'pslzme_settings',
				'pslzme_db_section',
				['id' => $id]
			);
		}

		// --- Internal Pages Section ---
		add_settings_section(
			"pslzme_ip_section",
			__("Seiten Konfiguration"),
			null,
			"pslzme_settings"
		);

		$ip_fields = [
			'db_imprint' => __("ID der Impressumsseite:"),
			'db_privacy' => __("ID der Datenschutzseite"),
		];

		foreach ($ip_fields as $id => $title) {
			add_settings_field(
				$id,
				$title,
				[$this, 'render_pslzme_settings_field'],
				'pslzme_settings',
				'pslzme_ip_section',
				['id' => $id]
			);
		}
	}


	/**
	 * 
	 * This function loads the partial output file for the pslzme admin panel.
	 * @location /admin/partials/pslzme-admin-settings-display.php
	 * 
	 */
	public function display_pslzme_settings_menu() {
		include_once plugin_dir_path(__FILE__) . 'partials/pslzme-admin-settings-display.php';
	}


	/**
	 * 
	 * This function sanitizes all the form inputs inside the pslzme admin panel before saving them into the database.
	 * @input The value from the forms input field.
	 * @return An array with sanitized form inputs that is saved to the database.
	 * 
	 */
	public function sanitize_pslzme_settings($input) {

		// Start with existing settings so nothing gets lost
		$sanitized = get_option('pslzme_settings', []);

		/* ---------------- DB FIELDS ---------------- */

		if (isset($input['db_name'])) {
			$sanitized['db_name'] = sanitize_text_field($input['db_name']);
		}

		if (isset($input['db_user'])) {
			$sanitized['db_user'] = sanitize_text_field($input['db_user']);
		}

		if (isset($input['db_password'])) {
			$password = sanitize_text_field($input['db_password']);

			if (!empty($password)) {
				$sanitized['db_password'] = PslzmeAdminCryptoService::encrypt($password);
			}
			// If empty → do NOT overwrite existing password
		}

		/* ------------- INTERNAL PAGE IDS ------------- */

		if (!isset($sanitized['internal_pages'])) {
			$sanitized['internal_pages'] = [];
		}

		if (isset($input['db_imprint'])) {
			$sanitized['internal_pages']['imprint'] = intval($input['db_imprint']);
		}

		if (isset($input['db_privacy'])) {
			$sanitized['internal_pages']['privacy'] = intval($input['db_privacy']);
		}

		return $sanitized;
	}


	/**
	 * 
	 * This function renders the pslzme admin panels forms and outputs the values as input fields.
	 * @args Array that is passed by Wordpress when rendering a settings field. Contains info stored for this particular field.
	 * 
	 */
	public function render_pslzme_settings_field($args) {
		$id = $args['id'];
		$type = ($id === 'db_password') ? 'password' : 'text';

		// Load existing settings
		$options = get_option('pslzme_settings', []);

		// Default value
		$value = ($type === 'password') ? '' : ($options[$id] ?? '');

		// Handle internal pages specially
		if (in_array($id, ['db_imprint','db_privacy'])) {
			$key = str_replace('db_', '', $id); // db_imprint -> imprint
			$value = $options['internal_pages'][$key] ?? '';
		}

		printf(
			'<input type="%1$s" name="pslzme_settings[%2$s]" value="%3$s" %4$s>',
			esc_attr($type),
			esc_attr($id),
			esc_attr($value),
			$type === 'password' ? 'autocomplete="new-password"' : ''
		);
	}

	/**
	 * 
	 * This function is used as callback for the wp_ajax_pslzme_create_tables hook.
	 * It is responsible for handling an ajax request when a user fires an action=pslzme_create_tables.
	 * 
	 */
	public function handle_create_tables() {
		// Check nonce for security
		check_ajax_referer('pslzme_create_tables', 'nonce');
		$settingsController = new PslzmeAdminDatabaseOptionsController();
		$settingsController->handle_create_pslzme_tables();
	}

	/**
	 * 
	 * This function is used as callback for the wp_ajax_pslzme_register_customer hook.
	 * It is responsible for handling an ajax when a user fires an action=pslzme_register_customer.
	 * 
	 */
	public function handle_register_customer() {
		check_ajax_referer('pslzme_create_tables', 'nonce');
		$settingsController = new PslzmeAdminDatabaseOptionsController();
		$settingsController->handle_register_customer();
	}

	/**
	 * 
	 * This function is used as callback for the theme_page_templates hook.
	 * It registers a new template type for special pslzme pages.
	 * @page_templates Array containing existing page templates for the current theme
	 * @theme The current theme used.
	 * @post The current post being edited. Used for conditionally adding specific post types.
	 * @return The modified page_templates array containing a new key for pslzme page.
	 * 
	 */
	public function register_pslzme_template($page_templates, $theme, $post) {
		$templates = $this->pslzme_template_array();
		foreach ($templates as $tk=>$tv) {
			$page_templates[$tk] = $tv;
		}
		return $page_templates;
	}

	/**
	 * This function is used as a callback for the template_include hook.
	 * It loads the template file file for the current post type.
	 * @template The path of the currently selected template
	 * @return The rendered php file for the page.
	 */
	public function load_pslzme_page_template($template) {
		global $post;
		$page_temp_slug = get_page_template_slug($post->ID);

		$templates = $this->pslzme_template_array();

		if ( isset($templates[$page_temp_slug]) ) {
			$template = plugin_dir_path( __FILE__ ) . 'templates/' . $page_temp_slug;
		}
		return $template;
	}

	/**
	 * This function is used as a callback for the wp_nav_menu_objects hook.
	 * It hides the special template pslzme page in navbars when the required pslzme URL parameters are not set.
	 * @menu_objects Array containing information about the pages inside the nav menu.
	 * @args arguments passed to wp_nav_menu() function like theme location etc.
	 * @return the modified menu objects that will be displayed inside the menu.
	 */
	public function hide_pslzme_pages_in_menus($menu_objects, $args) {
		$dc = DecryptionController::get_instance();
		$pslzme_slug = 'pslzme-page.php';

		foreach ($menu_objects as $key => $menu_object) {
			$template_slug = get_page_template_slug($menu_object->object_id);

			// Only remove if it's a pslzme page AND vars are not set
			if ($template_slug === $pslzme_slug && !$dc->vars_set()) {
				unset($menu_objects[$key]);
			}
		}

		return $menu_objects;
	}


	public function protect_pslzme_page_direct_access() {
		if (is_page() && get_page_template_slug() === 'pslzme-page.php') {
			$dc = DecryptionController::get_instance();
			if (!$dc->vars_set()) {
				wp_redirect(home_url());
            	exit;
			}
		}
	}


	/**
	 * 
	 * This function adds a custom category to the gutenberg block editor
	 * @categories All the currently available categories inside the editor.
	 * @post The current post being edited.
	 * 
	 */
	public function add_custom_gutenberg_category($categories, $post) {
		return array_merge(
			$categories,
			[
				[
					'slug'  => 'Pslzme',
					'title' => __('Pslzme', 'pslzme'),
					'icon'  => null, // Optional, could be a dashicon slug or SVG
				],
			]
    	);
	}

	/**
	 * 
	 * This function is used to add a new template type for pslzme pages.
	 * @return An array containing the new page type.
	 * 
	 */
	private function pslzme_template_array() {
		$templates = [];
		$templates['pslzme-page.php'] = 'pslzme';
		return $templates;
	}

	/**
	 * 
	 * This function is used to encrypt a customers password before saving it into the database.
	 * @password The password inserted into a form input field. Not encrypted before this funtion.
	 * @timestamp A timestamp used as salt to encrypt the password.
	 * 
	 */
	private function encrypt_password($password, $timestamp) {
		$secretKey = hash('sha256', (string)$timestamp, true); // binary key
		$iv = random_bytes(16); // IV
		
		// Use RAW_DATA to get binary output
		$ciphertext = openssl_encrypt($password, 'aes-256-cbc', $secretKey, OPENSSL_RAW_DATA, $iv);

		// Store IV + ciphertext together, base64 encoded
		$encryptedData = base64_encode($iv . $ciphertext);

		return $encryptedData;
	}

}
