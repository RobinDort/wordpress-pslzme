<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.pslzme.com
 * @since      1.0.0
 *
 * @package    pslzme
 * @subpackage pslzme/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    pslzme
 * @subpackage Pslzme/public
 * @author     Alexander Dort GmbH <robin@alexanderdort.com>
 */
class Pslzme_Public {

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
	 * @param      string    $pslzme       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $pslzme, $version ) {

		$this->pslzme = $pslzme;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->pslzme, plugin_dir_url( __FILE__ ) . 'css/pslzme-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->pslzme . "-cookiebanner", plugin_dir_url( __FILE__ ) . 'css/pslzme-cookiebanner.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->pslzme . "-cookie-caller", plugin_dir_url( __FILE__ ) . 'css/pslzme-cookie-caller.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->pslzme . "-animations", plugin_dir_url( __FILE__ ) . 'css/pslzme-animations.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->pslzme . "-public", plugin_dir_url( __FILE__ ) . 'js/pslzme-public.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->pslzme . "-min", plugin_dir_url( __FILE__ ) . 'js/pslzme.min.js', array('jquery'), $this->version, true);

		wp_localize_script(
			$this->pslzme . "-min", // JS handle
			"pslzmeData",           // Object name in JS
			[
				'rest_url' => esc_url(rest_url("pslzme/v1/requestHandler")),
				'nonce'    => wp_create_nonce('wp_rest'),
				'accept_url' => home_url('/pslzme-accept'),
				'decline_url' => home_url('/pslzme-decline')
			]
		);
	}

	public function register_gutenberg_blocks() {
		$availableImageSizes = $this->get_available_image_sizes();


		register_block_type(
			plugin_dir_path(dirname(__FILE__)) . 'build/pslzme-text',
        [
            'render_callback' => [$this, 'render_pslzme_text_block']
        ]);


		register_block_type(
			plugin_dir_path(dirname(__FILE__)) . 'build/pslzme-content',
        [
            'render_callback' => [$this, 'render_pslzme_content_block']
        ]);

		wp_localize_script(
			'pslzme-content-block-editor-script',
			'pslzmeGutenbergData',
			[
				'imageSizes' => $availableImageSizes,
			]
		);


		wp_set_script_translations(
			'pslzme-block-editor-script',
			'pslzme',
			plugin_dir_path(dirname(__FILE__)) . 'languages'
		);
	}


	public function register_rest_routes() {
		register_rest_route("pslzme/v1", "/requestHandler", [
			'methods' => 'POST',
			'callback' => [$this, 'handle_rest_request'],
			'permission_callback' => '__return_true' // public access
		]);
	}


	public function handle_rest_request($request) {
		$publicRouteController = new PslzmePublicRouteController();
		return $publicRouteController->handleRoutes($request);
	}

	public function load_cookiebanner() {
		require_once plugin_dir_path(__FILE__) . 'partials/pslzme-public-cookiebanner.php';
	}

	public function load_cookie_caller() {
		require_once plugin_dir_path(__FILE__) . 'partials/pslzme-public-cookie-caller.php';
	}

	public function register_elementor_pslzme_widgets( $widgets_manager) {
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}
		
		require_once plugin_dir_path(__FILE__) . 'elementor/pslzme-public-elementor-pslzme-text.php';
		require_once plugin_dir_path(__FILE__) . 'elementor/pslzme-public-elementor-pslzme-content.php';
		require_once plugin_dir_path(__FILE__) . 'elementor/pslzme-public-elementor-pslzme-image.php';

		$widgets_manager->register( new ElementorWidgetPslzmeText() );
		$widgets_manager->register( new ElementorWidgetPslzmeContent() );
		$widgets_manager->register( new ElementorWidgetPslzmeImage() );
	}

	public function add_elementor_widget_categories( $elements_manager) {
        $elements_manager->add_category(
            "Pslzme",
            [
                "title" => esc_html__("Pslzme", "pslzme"),
                "icon"  => "eicon-navigator",
            ]
        );
    }

	public function register_pslzme_shortcodes() {
        $shortcodeService = new PslzmeShortcodeService();
		$shortcodeService->register_shortcodes();
	}

	public function render_pslzme_text_block( $attributes ) {
		$decryptionController = DecryptionController::get_instance();
		$varsSet = $decryptionController->vars_set();

		$personalized_text   = $attributes['personalized_text'] ?? '';
		$unpersonalized_text = $attributes['unpersonalized_text'] ?? '';
		$show_unpersonalized = $attributes['show_unpersonalized_text'] ?? true;

		ob_start();
		?>
		<div <?= get_block_wrapper_attributes(); ?>>
			<?php if ($varsSet): ?>
				<div class="personalized-text-content">
					<?= wp_kses_post($personalized_text); ?>
				</div>
			<?php elseif ($show_unpersonalized): ?>
				<div class="unpersonalized-text-content">
					<?= wp_kses_post($unpersonalized_text); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php
		return ob_get_clean();
	}

	public function render_pslzme_content_block() {
		ob_start();
		?>

		<div <?= get_block_wrapper_attributes(); ?>>
		</div>

		<?php
		return ob_get_clean();
	}

	private function get_available_image_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = [];

		foreach ( get_intermediate_image_sizes() as $size ) {

			if ( in_array( $size, ['thumbnail','medium','large'] ) ) {
				$width  = get_option( "{$size}_size_w" );
				$height = get_option( "{$size}_size_h" );
			} elseif ( isset( $_wp_additional_image_sizes[ $size ] ) ) {
				$width  = $_wp_additional_image_sizes[ $size ]['width'];
				$height = $_wp_additional_image_sizes[ $size ]['height'];
			} else {
				$width = $height = '';
			}

			$label = ucfirst($size);

			if ($width && $height) {
				$label .= " ({$width}x{$height})";
			}

			$sizes[] = [
				'label' => $label,
				'value' => $size,
			];
		}
		return $sizes;
	}

}
