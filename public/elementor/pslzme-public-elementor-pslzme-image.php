<?php

/**
 * Class that creates a custom elementor widget as pslzme image.
 */
class ElementorWidgetPslzmeImage extends \Elementor\Widget_Base {

    /**
     * This function returns the name of the widget.
     */
    public function get_name(): string {
        return 'pslzme_image';
    }

    /**
     * This function returns the title of the widget.
     */
    public function get_title(): string {
        return esc_html__("Pslzme Image Widget", "pslzme");
    }

    /**
     * This function returns the icon of the widget.
     */
    public function get_icon(): string {
        return 'eicon-e-image';
    }

    /**
     * This function returns the categories of the widget.
     */
    public function get_categories(): array {
		return [ 'Pslzme' ];
	}

    /**
     * This function returns the keywords of the widget.
     */
    public function get_keywords(): array {
		return [ 'Pslzme', 'pslzme', 'Image', 'image', 'Pslzme Image', 'pslzme image' ];
	}

    /**
     * This function registers custom controls for the widget.
     */
    protected function register_controls(): void {
        $this->add_content_controls();
    }

    /**
     * This function renders the widget and outputs its content.
     * @location /public/partials/pslzme-public-elementor-pslzme-image.php
     */
    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pslzme-public-elementor-pslzme-image.php';
    }

    /**
     * This functions adds sections and control options to the widget.
     */
    private function add_content_controls(): void {

        $this->start_controls_section(
            'content_section_pslzme_image',
            [
                'label' => esc_html__('Pslzme Image Section', 'pslzme'),
                'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT, 
            ]
        );

        $this->add_control('pslzme_image_personalized_text',
            [
                'label' => esc_html__( 'Personalized Text', 'pslzme' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
            ]
        );

        $this->add_control(
            'pslzme_image_unpersonalized_text',
            [
                'label' => esc_html__( 'Unpersonalized Text', 'pslzme' ),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
            ]
        );

        $this->add_control(
            'pslzme_image_text_align',
            [
                'label' => esc_html__( 'Pslzme image text align', 'pslzme' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
					'left' => esc_html__( 'Pslzme image text align left', 'pslzme' ),
					'center'  => esc_html__( 'Pslzme image text align center', 'pslzme' ),
					'right' => esc_html__( 'Pslzme image text align right', 'pslzme' ),
				],
                'selectors' => [
					'{{WRAPPER}} .pslzme_image_ce_text' => 'text-align: {{VALUE}};',
				],
            ]
        );

        $this->add_control(
            'pslzme_image_text_color',
            [
                'label' => esc_html__( 'Pslzme image text color', 'pslzme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
					'{{WRAPPER}} .pslzme_image_ce_text' => 'color: {{VALUE}};',
				],
            ]
        );

        $this->add_control(
            'pslzme_image_dimensions',
            [
                'label' => esc_html__( 'Pslzme image dimensions', 'pslzme' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem' ],
                'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => false,
				],
                'selectors' => [
					'{{WRAPPER}} .pslzme-ov-image-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
            ]
        );

        $this->add_control(
            'pslzme_image_background',
            [
                'label' => esc_html__( 'Pslzme image background', 'pslzme' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
            ]
        );

        $this->add_control(
            'pslzme_image_background_size',
            [
                'label' => esc_html__( 'Pslzme image background size', 'pslzme' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'full',
                'options' => $this->get_available_image_sizes(),
            ]
        );

        $this->add_control(
            'pslzme_image_background_alt_text',
            [
                'label' => esc_html__( 'Pslzme image background alt text', 'pslzme' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'pslzme_image_background_title',
            [
                'label' => esc_html__( 'Pslzme image background title', 'pslzme' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'pslzme_image_foreground',
            [
                'label' => esc_html__( 'Pslzme image foreground', 'pslzme' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(), 
                ],
            ]
        );

        $this->add_control(
            'pslzme_image_foreground_size',
            [
                'label' => esc_html__( 'Pslzme image foreground size', 'pslzme' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'full',
                'options' => $this->get_available_image_sizes(),
            ]
        );

        $this->add_control(
            'pslzme_image_foreground_alt_text',
            [
                'label' => esc_html__( 'Pslzme image foreground alt text', 'pslzme' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'pslzme_image_foreground_title',
            [
                'label' => esc_html__( 'Pslzme image foreground title', 'pslzme' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );
        $this->end_controls_section();
    }

    /**
     * This function searches for available predefined image sizes.
     * @return an array containing all available image sizes.
     */
    private function get_available_image_sizes(): array {
        global $_wp_additional_image_sizes;

        $sizes = [
            'thumbnail' => esc_html__('Thumbnail', 'pslzme'),
            'medium'    => esc_html__('Medium', 'pslzme'),
            'large'     => esc_html__('Large', 'pslzme'),
            'full'      => esc_html__('Full', 'pslzme'),
        ];

        if (!empty($_wp_additional_image_sizes)) {
            foreach ($_wp_additional_image_sizes as $key => $value) {
                $sizes[$key] = ucfirst(str_replace('_', ' ', $key));
            }
        }

        return $sizes;
    }

}

?>