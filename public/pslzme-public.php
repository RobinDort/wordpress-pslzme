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
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->pslzme . "-public", plugin_dir_url( __FILE__ ) . 'js/pslzme-public.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->pslzme . "-min", plugin_dir_url( __FILE__ ) . 'js/pslzme/pslzme.min.js', array('jquery'), $this->version, true);

		// Import 3D script as module
		wp_enqueue_script( $this->pslzme . "-3d", plugin_dir_url( __FILE__ ) . 'js/bundles/pslzme-3d.bundle.js', array(), $this->version, true );


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

		wp_localize_script(
			$this->pslzme . "-3d", // JS handle
			"fonts",           // Object name in JS
			[
				'droidSans' => plugin_dir_url(__FILE__) . 'js/3D/droid_sans_bold.typeface.json',
			]
		);
	}

	/**
	 * This function registers all available custom gutenberg blocks
	 */
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

		register_block_type(
			plugin_dir_path(dirname(__FILE__)) . 'build/pslzme-image',
		[
			'render_callback' => [$this, 'render_pslzme_image_block']
		]);

		register_block_type(
			plugin_dir_path(dirname(__FILE__)) . 'build/pslzme-3d-text',
		[
			'render_callback' => [$this, 'render_pslzme_3d_text_block']
		]);

		register_block_type(
			plugin_dir_path(dirname(__FILE__)) . 'build/pslzme-marquee',
		[
			'render_callback' => [$this, 'render_pslzme_marquee_block']
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


	/**
	 * This function registers the pslzme REST route to handle different API calls.
	 * @Route pslzme/v1
	 */
	public function register_rest_routes() {
		register_rest_route("pslzme/v1", "/requestHandler", [
			'methods' => 'POST',
			'callback' => [$this, 'handle_rest_request'],
			'permission_callback' => '__return_true' // public access
		]);
	}


	/**
	 * This function handles the REST request from the registered route pslzme/v1.
	 * @handler PslzmePublicRouteController
	 * @location /public/controller/pslzme-public-route-controller.php
	 */
	public function handle_rest_request($request) {
		$publicRouteController = new PslzmePublicRouteController();
		return $publicRouteController->handleRoutes($request);
	}

	/**
	 * This function loads the partial file for the pslzme cookiebanner.
	 * @location /public/partials/pslzme-public-cookiebanner.php
	 */
	public function load_cookiebanner() {
		require_once plugin_dir_path(__FILE__) . 'partials/pslzme-public-cookiebanner.php';
	}

	/**
	 * This function loads the partial file for the pslzme cookie caller.
	 * @location /public/partials/pslzme-public-cookie-caller.php
	 */
	public function load_cookie_caller() {
		require_once plugin_dir_path(__FILE__) . 'partials/pslzme-public-cookie-caller.php';
	}

	/**
	 * This function registers all available custom elementor widgets
	 */
	public function register_elementor_pslzme_widgets( $widgets_manager) {
		if ( ! did_action( 'elementor/loaded' ) ) {
			return;
		}
		
		require_once plugin_dir_path(__FILE__) . 'elementor/pslzme-public-elementor-pslzme-text.php';
		require_once plugin_dir_path(__FILE__) . 'elementor/pslzme-public-elementor-pslzme-content.php';
		require_once plugin_dir_path(__FILE__) . 'elementor/pslzme-public-elementor-pslzme-image.php';
		require_once plugin_dir_path(__FILE__) . 'elementor/pslzme-public-elementor-pslzme-marquee.php';
		require_once plugin_dir_path(__FILE__) . 'elementor/pslzme-public-elementor-pslzme-3d-text.php';

		$widgets_manager->register( new ElementorWidgetPslzmeText() );
		$widgets_manager->register( new ElementorWidgetPslzmeContent() );
		$widgets_manager->register( new ElementorWidgetPslzmeImage() );
		$widgets_manager->register( new ElementorWidgetPslzmeMarquee() );
		$widgets_manager->register( new ElementorWidgetPslzme3DText() );
	}

	/**
	 * This function adds a new custom category "Pslzme" to the elementor editor. 
	 */
	public function add_elementor_widget_categories( $elements_manager) {
        $elements_manager->add_category(
            "Pslzme",
            [
                "title" => esc_html__("Pslzme", "pslzme"),
                "icon"  => "eicon-navigator",
            ]
        );
    }

	/**
	 * This function registers custom shortcodes for pslzme.
	 * @handler PslzmeShortcodeService
	 * @location /public/service/pslzme-public-shortcode-service.php
	 */
	public function register_pslzme_shortcodes() {
    	$shortcodeService = new PslzmeShortcodeService();
		$shortcodeService->register_shortcodes();
	}


	/**
	 * This function renders the dynamic output for the pslzme text gutenberg block
	 * @attributes Object containing predefined values for the pslzme text block.
	 * @location src/pslzme-text
	 */
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

	/**
	 * This function renders the dynamic output for the pslzme content gutenberg block.
	 * @attributes Object containing predefined values for the pslzme content block.
	 * @location src/pslzme-content
	 */
	public function render_pslzme_content_block( $attributes ) {
		$decryptionController = DecryptionController::get_instance();
		$varsSet = $decryptionController->vars_set();

		$contentType = $attributes['content_type'] ?? '';

		$personalizedImage = $attributes['personalized_image'] ?? null;
		$personalizedImageAlt = $attributes['personalized_image_alt'] ?? '';
		$personalizedImageSize = $attributes['personalized_image_size'] ?? 'full';
		$personalizedImageCaption = $attributes['personalized_image_caption'] ?? '';
		$personalizedImageLinkID = $attributes['personalized_image_link'] ?? '';
		$personalizedImageLinkUrl = $personalizedImageLinkID ? get_permalink($personalizedImageLinkID) : '';

		$unpersonalizedImage = $attributes['unpersonalized_image'] ?? null;
		$unpersonalizedImageAlt = $attributes['unpersonalized_image_alt'] ?? '';
		$unpersonalizedImageSize = $attributes['unpersonalized_image_size'] ?? 'full';
		$unpersonalizedImageCaption = $attributes['unpersonalized_image_caption'] ?? '';
		$unpersonalizedImageLinkID = $attributes['unpersonalized_image_link'] ?? '';
		$unpersonalizedImageLinkUrl = $unpersonalizedImageLinkID ? get_permalink($unpersonalizedImageLinkID) : '';

		$personalizedVideo = $attributes['personalized_video'] ?? null;
		$personalizedVideoWidth = $attributes['personalized_video_width'] ?? '';
		$personalizedVideoHeight = $attributes['personalized_video_height'] ?? '';
		$personalizedVideoOptions = $attributes['personalized_video_options'] ?? [];
		$personalizedVideoAttributes = [];

		$availableOptions = ['autoplay', 'loop', 'muted', 'playsinline'];

		foreach ($personalizedVideoOptions as $option) {
			if (in_array($option, $availableOptions, true)) {
				$personalizedVideoAttributes[] = $option;
			}
		}

		// Add controls if not hidden
		if (!in_array('controls_hidden', $personalizedVideoOptions, true)) {
			$personalizedVideoAttributes[] = 'controls';
		}
		$personalizedVideoAttributes = implode(' ', $personalizedVideoAttributes);

		$unpersonalizedVideo = $attributes['unpersonalized_video'] ?? null;
		$unpersonalizedVideoWidth = $attributes['unpersonalized_video_width'] ?? '';
		$unpersonalizedVideoHeight = $attributes['unpersonalized_video_height'] ?? '';
		$unpersonalizedVideoOptions = $attributes['unpersonalized_video_options'] ?? [];
		$unpersonalizedVideoAttributes = [];

		foreach ($unpersonalizedVideoOptions as $option) {
			if (in_array($option, $availableOptions, true)) {
				$unpersonalizedVideoAttributes[] = $option;
			}
		}

		// Add controls if not hidden
		if (!in_array('controls_hidden', $unpersonalizedVideoOptions, true)) {
			$unpersonalizedVideoAttributes[] = 'controls';
		}
		$unpersonalizedVideoAttributes = implode(' ', $unpersonalizedVideoAttributes);

		ob_start();
		?>

		<div <?= get_block_wrapper_attributes(); ?>>
			<?php if ($varsSet) :?>
				<?php if ($contentType === "image") :?>
					<div class="ce_image pslzme-image">
						<a href="<?= esc_url($personalizedImageLinkUrl); ?>">
							<img src="<?= esc_url($personalizedImage['url']); ?>" alt="<?= esc_attr($personalizedImageAlt); ?>" />
							<?php if ( $personalizedImageCaption ) : ?>
								<figcaption><?= esc_html( $personalizedImageCaption ); ?></figcaption>
							<?php endif; ?>
						</a>
					</div>
				<?php elseif ($contentType === "video") :?>
					<div class="ce_video pslzme-video">
						<video width="<?= esc_attr($personalizedVideoWidth); ?>" height="<?= esc_attr($personalizedVideoHeight); ?>" <?= $personalizedVideoAttributes; ?>>
							<source src="<?= esc_url($personalizedVideo['url']); ?>">
							<?= esc_html__('Your browser does not support the video tag.', 'pslzme') ?>
						</video>
					</div>
				<?php endif; ?>

			<?php else: ?>
				<?php if ($contentType === "image") :?>
					<div class="ce_image pslzme-image">
						<a href="<?= esc_url($unpersonalizedImageLinkUrl); ?>">
							<img src="<?= esc_url($unpersonalizedImage['url']); ?>" alt="<?= esc_attr($unpersonalizedImageAlt); ?>" />
							<?php if ( $unpersonalizedImageCaption ) : ?>
								<figcaption><?= esc_html( $unpersonalizedImageCaption ); ?></figcaption>
							<?php endif; ?>
						</a>
					</div>

				<?php elseif ($contentType === "video") :?>
					<div class="ce_video pslzme-video">
						<video width="<?= esc_attr($unpersonalizedVideoWidth); ?>" height="<?= esc_attr($unpersonalizedVideoHeight); ?>" <?= $unpersonalizedVideoAttributes; ?>>
							<source src="<?= esc_url($unpersonalizedVideo['url']); ?>">
							<?= esc_html__('Your browser does not support the video tag.', 'pslzme') ?>
						</video>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<?php
		return ob_get_clean();
	}

	/**
	 * This function renders the dynamic output for the pslzme image gutenberg block.
	 * @attributes Object containing predefined values for the pslzme image block.
	 * @location src/pslzme-image
	 */
	public function render_pslzme_image_block( $attributes ) {
		$decryptionController = DecryptionController::get_instance();
		$varsSet = $decryptionController->vars_set();

		$personalizedText = $attributes['personalized_text'] ?? '';
		$personalizedTextFontSize = $attributes['personalized_text_font_size'] ?? '';
		$personalizedTextAlignment = $attributes['personalized_text_alignment'] ?? 'left';
		$personalizedTextColor = $attributes['personalized_text_color'] ?? '#000000';

		$unpersonalizedText = $attributes['unpersonalized_text'] ?? '';
		$unpersonalizedTextFontSize = $attributes['unpersonalized_text_font_size'] ?? '';
		$unpersonalizedTextAlignment = $attributes['unpersonalized_text_alignment'] ?? 'left';
		$unpersonalizedTextColor = $attributes['unpersonalized_text_color'] ?? '#000000';

		$imageDimensionTop = $attributes['image_dimension_top'] ?? "0";
		$imageDimensionRight = $attributes['image_dimension_right'] ?? "0";
		$imageDimensionBottom = $attributes['image_dimension_bottom'] ?? "0";
		$imageDimensionLeft = $attributes['image_dimension_left'] ?? "0";
		$imageDimensionUnit = $attributes['image_dimension_unit'] ?? "px";

		$textDimensionTop = $attributes['text_dimension_top'] ?? '0';
		$textDimensionRight = $attributes['text_dimension_right'] ?? '0';
		$textDimensionBottom = $attributes['text_dimension_bottom'] ?? '0';
		$textDimensionLeft = $attributes['text_dimension_left'] ?? '0';
		$textDimensionUnit = $attributes['text_dimension_unit'] ?? 'px';

		$backgroundImageID = $attributes['background_image']['id'] ?? '';
		$backgroundImageSize = $attributes['background_image_size'] ?? '';
		$backgroundImageAlt = $attributes['background_image_alt'] ?? '';
		$backgroundImageTitle = $attributes['background_image_title'] ?? '';

		$foregroundImageID = $attributes['foreground_image']['id'] ?? '';
		$foregroundImageSize = $attributes['foreground_image_size'] ?? '';
		$foregroundImageAlt = $attributes['foreground_image_alt'] ?? '';
		$foregroundImageTitle = $attributes['foreground_image_title'] ?? '';

		$imageContainerWidth = $attributes['image_container_width'] ?? '0';
		$imageContainerMaxWidth = $attributes['image_container_max_width'] ?? '0';
		$imageContainerHeight = $attributes['image_container_height'] ?? '0';

		$imageContainerBorderRadiusTopLeft = $attributes['image_container_border_radius_top_left'] ?? '0';
		$imageContainerBorderRadiusTopRight = $attributes['image_container_border_radius_top_right'] ?? '0';
		$imageContainerBorderRadiusBottomRight = $attributes['image_container_border_radius_bottom_right'] ?? '0';
		$imageContainerBorderRadiusBottomLeft = $attributes['image_container_border_radius_bottom_left'] ?? '0';

		ob_start();
		?>

		<?php if ($backgroundImageID && $foregroundImageID) : ?>
			<div class="pslzme-ov-image-container" 
			style="margin: 
				<?= esc_attr($imageDimensionTop). esc_attr($imageDimensionUnit) . " " .
				esc_attr($imageDimensionRight) . esc_attr($imageDimensionUnit) . " " .
				esc_attr($imageDimensionBottom) . esc_attr($imageDimensionUnit) . " " .
				esc_attr($imageDimensionLeft) . esc_attr($imageDimensionUnit) ?>;
				width: <?= esc_attr($imageContainerWidth) ? esc_attr($imageContainerWidth) . "px" : 'auto' ?>;
				max-width: <?= esc_attr($imageContainerMaxWidth) ? esc_attr($imageContainerMaxWidth) . "px" : 'none' ?>;
				height: <?= esc_attr($imageContainerHeight) ? esc_attr($imageContainerHeight) . "px" : 'auto' ?>;
				"
			>
				<div class="pslzme-background-figure">
					<?= wp_get_attachment_image(
						$backgroundImageID,
						$backgroundImageSize,
						false,
						[
							'alt'   => esc_attr($backgroundImageAlt),
							'title' => esc_attr($backgroundImageTitle),
							'loading' => 'lazy',
							'style' => "border-radius: 
								" . esc_attr($imageContainerBorderRadiusTopLeft) . "px " .
								esc_attr($imageContainerBorderRadiusTopRight) . "px " .
								esc_attr($imageContainerBorderRadiusBottomRight) . "px " .
								esc_attr($imageContainerBorderRadiusBottomLeft) . "px"
						]
					); ?>
				</div>

				<?php if ($varsSet) : ?>
					<?php if ($personalizedText) : ?>
						<div class="ce_text block layered-text"
						style="
							text-align: <?= esc_attr($personalizedTextAlignment) ?>;
							font-size: <?= esc_attr($personalizedTextFontSize); ?>;
							color: <?= esc_attr($personalizedTextColor) ?>;
							margin-top: <?= esc_attr($textDimensionTop) ?><?= esc_attr($textDimensionUnit)?>;
							margin-right: <?= esc_attr($textDimensionRight) ?><?= esc_attr($textDimensionUnit)?>;
							margin-bottom: <?= esc_attr($textDimensionBottom) ?><?= esc_attr($textDimensionUnit)?>;
							margin-left: <?= esc_attr($textDimensionLeft) ?><?= esc_attr($textDimensionUnit)?>;
						">
							<?= esc_html($personalizedText) ?>
						</div>
					<?php endif; ?>

				<?php else : ?>
					<?php if ($unpersonalizedText) : ?>
						<div class="ce_text block layered-text"
						style="
							text-align: <?= esc_attr($unpersonalizedTextAlignment) ?>;
							font-size: <?= esc_attr($unpersonalizedTextFontSize) ?>;
							color: <?= esc_attr($unpersonalizedTextColor) ?>;
							margin-top: <?= esc_attr($textDimensionTop) ?><?= esc_attr($textDimensionUnit)?>;
							margin-right: <?= esc_attr($textDimensionRight) ?><?= esc_attr($textDimensionUnit)?>;
							margin-bottom: <?= esc_attr($textDimensionBottom) ?><?= esc_attr($textDimensionUnit)?>;
							margin-left: <?= esc_attr($textDimensionLeft) ?><?= esc_attr($textDimensionUnit)?>;
						">
							<?= esc_html($unpersonalizedText) ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<div class="pslzme-foreground-figure">
					<?= wp_get_attachment_image(
						$foregroundImageID,
						$foregroundImageSize,
						false,
						[
							'alt'   => esc_attr($foregroundImageAlt),
							'title' => esc_attr($foregroundImageTitle),
							'loading' => 'lazy',
						]
					); ?>
				</div>
			</div>
		<?php endif; ?>
		
		<?php
		return ob_get_clean();
	}

	public function render_pslzme_3d_text_block( $attributes ) {

		$decryptionController = DecryptionController::get_instance();
		$varsSet = $decryptionController->vars_set();

		$personalized_text = $attributes['personalized_3d_text'] ?? '';
		$unpersonalized_text = $attributes['unpersonalized_3d_text'] ?? '';
		$usedText = $varsSet && !empty($personalized_text) ? $personalized_text : $unpersonalized_text;
		$draggable = $attributes['text_draggable'] ?? 'yes';
		$scene_background = $attributes['background_color'] ?? "#222222";
		$highlight_color_one = $attributes['highlight_color_one'] ?? '#a4dd46';
		$highlight_color_two = $attributes['highlight_color_two'] ?? '#0000ff';
		$highlight_color_three = $attributes['highlight_color_three'] ?? '#ff0000';
		$fogEnabled = $attributes['fog_enabled'] ?? 'yes';
		$fogColor = $attributes['fog_color'] ?? "#222222";
		$mirrored = $attributes['mirrored_text'] ?? 'yes';
		$movingLight = $attributes['moving_light_enabled'] ?? 'no';
		$rotationEnabled = $attributes['text_rotation'] ?? 'no';
		$rotationDirection = $attributes['rotation_direction'] ?? 'left';
		$debugUIEnabled = $attributes['debug_ui_enabled'] ?? 'no';
		$cameraPositionX = $attributes['camera_position_x'] ?? 0;
		$cameraPositionY = $attributes['camera_position_y'] ?? 150;
		$cameraPositionZ = $attributes['camera_position_z'] ?? 700;
		$cameraTargetX = $attributes['camera_target_x'] ?? 0;
		$cameraTargetY = $attributes['camera_target_y'] ?? 115;
		$cameraTargetZ = $attributes['camera_target_z'] ?? 0;
		$borderRadiusTopLeft = $attributes['container_border_top_left_radius'] ?? 0;
		$borderRadiusTopRight = $attributes['container_border_top_right_radius'] ?? 0;
		$borderRadiusBottomLeft = $attributes['container_border_bottom_left_radius'] ?? 0;
		$borderRadiusBottomRight = $attributes['container_border_bottom_right_radius'] ?? 0;

		ob_start();
		?>
		<div class="pslzme-3d-text <?= $draggable === 'yes' ? 'pslzme-3d-text-draggable' : '' ?>"
			style="
				border-top-left-radius: <?= esc_attr($borderRadiusTopLeft) ?>px;
				border-top-right-radius: <?= esc_attr($borderRadiusTopRight) ?>px;
				border-bottom-left-radius: <?= esc_attr($borderRadiusBottomLeft) ?>px;
				border-bottom-right-radius: <?= esc_attr($borderRadiusBottomRight) ?>px;
				overflow: hidden;
			" 
			data-3d-text="<?= esc_attr( $usedText ) ?>"
			data-background="<?= esc_attr( $scene_background ) ?>"
			data-highlight-color-one="<?= esc_attr( $highlight_color_one ) ?>"
			data-highlight-color-two="<?= esc_attr( $highlight_color_two ) ?>"
			data-highlight-color-three="<?= esc_attr( $highlight_color_three ) ?>"
			data-fog-enabled="<?= esc_attr( $fogEnabled ) ?>"
			data-fog-color="<?= esc_attr( $fogColor ) ?>"
			data-mirrored="<?= esc_attr( $mirrored ) ?>"
			data-moving-light="<?= esc_attr( $movingLight ) ?>"
			data-rotation-enabled="<?= esc_attr( $rotationEnabled) ?>"
			data-rotation-direction="<?= esc_attr( $rotationDirection ) ?>"
			data-draggable="<?= esc_attr( $draggable ) ?>"
			data-debug-ui="<?= esc_attr( $debugUIEnabled) ?>"
			data-camera-pos-x="<?= esc_attr( $cameraPositionX ) ?>"
			data-camera-pos-y="<?= esc_attr( $cameraPositionY ) ?>"
			data-camera-pos-z="<?= esc_attr( $cameraPositionZ ) ?>"
			data-camera-target-x="<?= esc_attr( $cameraTargetX ) ?>"
			data-camera-target-y="<?= esc_attr( $cameraTargetY ) ?>"
			data-camera-target-z="<?= esc_attr( $cameraTargetZ ) ?>">
		</div>
		<?php
		return ob_get_clean();
	}


	public function render_pslzme_marquee_block( $attributes) {
		$decryptionController = DecryptionController::get_instance();
		$varsSet = $decryptionController->vars_set();

		$personalizedText = $attributes['personalized_text'];
		$unpersonalizedText = $attributes['unpersonalized_text'];
		$backgroundColor = $attributes['background_color'] ?? "#ffffff"; 
		$textColor = $attributes['text_color'] ?? "#000000";
		$containerHeight = $attributes['container_height'];

		$content = '';

		if ($varsSet && !empty($personalizedText)) {
			$content = $personalizedText;
		} else {
			$content = $unpersonalizedText;
		}

		ob_start();

		?>
		
			<?php if (!empty($content)) : ?>
				<div class="pslzme-marquee" style="height: <?= esc_attr($containerHeight) ?>px; background-color: <?= esc_attr($backgroundColor) ?>; ">
					<div class="pslzme-marquee-text">
						<div class="pslzme-marquee-text-track">
							<div class="pslzme-marquee-item" style="color: <?= $textColor ?>;">
								<?= esc_html($content) ?>
							</div>
							<div class="pslzme-marquee-item" style="color: <?= $textColor ?>;">
								<?= esc_html($content) ?>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>

		<?php
		return ob_get_clean();
	}

	/**
	 * This function searches for all the available image sizes that have been set in the Wordpress admin panel.
	 * @return An array containing all available sizes for images.
	 */
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
