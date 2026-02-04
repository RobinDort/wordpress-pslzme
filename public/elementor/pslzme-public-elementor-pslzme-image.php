<?php

class ElementorWidgetPslzmeImage extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'pslzme_image';
    }

    public function get_title(): string {
        return esc_html__("Pslzme Image Widget", "pslzme");
    }

    public function get_icon(): string {
        return 'eicon-e-image';
    }

    public function get_categories(): array {
		return [ 'Pslzme' ];
	}

    public function get_keywords(): array {
		return [ 'Pslzme', 'pslzme', 'Image', 'image', 'Pslzme Image', 'pslzme image' ];
	}

    protected function register_controls(): void {
        $this->add_content_controls();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pslzme-public-elementor-pslzme-image.php';
    }

    private function add_content_controls(): void {

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
					'{{WRAPPER}} .pslzme-image-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'type' => \Elementor\Controls_Manager::SLIDER,
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
                'type' => \Elementor\Controls_Manager::SLIDER,
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
    }
}

?>