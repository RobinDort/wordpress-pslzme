<?php

class ElementorWidgetPslzme3DText extends \Elementor\Widget_Base {
    /**
     * This function returns the name of the widget.
     */
    public function get_name(): string {
        return 'pslzme_3d_text';
    }

	/**
     * This function returns the title of the widget.
     */
    public function get_title(): string {
        return esc_html__("Pslzme 3D Text Widget", "pslzme");
    }

	/**
     * This function returns the icon of the widget.
     */
    public function get_icon(): string {
        return 'eicon-t-letter-bold';
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
		return [ 'Pslzme', 'pslzme', 'Text', 'text', '3D', '3d', 'Pslzme 3D Text', 'pslzme 3d text' ];
	}

    public function get_script_depends(): array {
        return ['pslzme-3d'];
    }

	/**
     * This function registers custom controls for the widget.
     */
    protected function register_controls(): void {
        $this->add_content_controls();
        $this->add_style_controls();
    }

	/**
     * This function renders the widget and outputs its content.
     * @location /public/partials/pslzme-public-elementor-pslzme-text.php'
     */
    protected function render(): void {
        $settings = $this->get_settings_for_display();
        include plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pslzme-public-elementor-pslzme-3d-text.php';
    }

    private function add_content_controls(): void {
        $this->start_controls_section(
            'pslzme_3d_text_content_section',
            [
                'label' => esc_html__('Pslzme 3D Text configuration', 'pslzme'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pslzme_3d_personalized_text',
            [
                'label' => esc_html__('Pslzme 3D personalized text', 'pslzme'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'pslzme_3d_unpersonalized_text',
            [
                'label' => esc_html__('Pslzme 3D unpersonalized text', 'pslzme'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => 'Max Mustermann',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'pslzme_3d_text_color_section',
            [
                'label' => esc_html__('Pslzme 3D Text color configuration', 'pslzme'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pslzme_3d_scene_background',
            [
                'label' => esc_html__('Pslzme 3D scene background color', 'pslzme'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#222222',
            ]
        );

        $this->add_control(
            'pslzme_3d_highlight_color_one',
            [
                'label' => esc_html__('Pslzme 3D highlight color 1', 'pslzme'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#a4dd46',
            ]
        );

        $this->add_control(
            'pslzme_3d_highlight_color_two',
            [
                'label' => esc_html__('Pslzme 3D highlight color 2', 'pslzme'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0000ff',
            ]
        );

        $this->add_control(
            'pslzme_3d_highlight_color_three',
            [
                'label' => esc_html__('Pslzme 3D highlight color 3', 'pslzme'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff0000',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'pslzme_3d_text_camera_section',
            [
                'label' => esc_html__('Pslzme 3D Text camera configuration', 'pslzme'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pslzme_3d_camera_position_x',
            [
                'label' => esc_html__("Pslzme 3D camera position x", "pslzme"),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 500,
                'default' => 0,
            ]
        );

        $this->add_control(
            'pslzme_3d_camera_position_y',
            [
                'label' => esc_html__("Pslzme 3D camera position y", "pslzme"),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 500,
                'default' => 150,
            ]
        );

        $this->add_control(
            'pslzme_3d_camera_position_z',
            [
                'label' => esc_html__("Pslzme 3D camera position z", "pslzme"),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'default' => 700,
            ]
        );


        $this->add_control(
            'pslzme_3d_camera_target_x',
            [
                'label' => esc_html__("Pslzme 3D camera target x", "pslzme"),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 500,
                'default' => 0,
            ]
        );

        $this->add_control(
            'pslzme_3d_camera_target_y',
            [
                'label' => esc_html__("Pslzme 3D camera target y", "pslzme"),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 500,
                'default' => 115,
            ]
        );

        $this->add_control(
            'pslzme_3d_camera_target_z',
            [
                'label' => esc_html__("Pslzme 3D camera target z", "pslzme"),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 500,
                'default' => 0,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'pslzme_3d_text_custom_options_section',
            [
                'label' => esc_html__('Pslzme 3D Text custom options', 'pslzme'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pslzme_3d_fog_enabled',
            [
                'label' => esc_html__('Pslzme 3D fog enabled', 'pslzme'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'pslzme'),
                    'no' => esc_html__('No', 'pslzme'),
                ],
            ]
        );

        $this->add_control(
            'pslzme_3d_fog_color',
            [
                'label' => esc_html__('Pslzme 3D fog color', 'pslzme'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#222222',
                'condition' => [
                    'pslzme_3d_fog_enabled' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pslzme_3d_mirrored',
            [
                'label' => esc_html__('Pslzme 3D mirrored', 'pslzme'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'options' => [
                    'yes' => esc_html__('Yes', 'pslzme'),
                    'no' => esc_html__('No', 'pslzme'),
                ],
            ]
        );

        $this->add_control(
            'pslzme_3d_draggable',
            [
                'label' => esc_html__("Pslzme 3D draggable", "pslzme"),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'pslzme'),
                    'no' => esc_html__('No', 'pslzme'),
                ],
            ]
        );

        $this->add_control(
            'pslzme_3d_moving_light',
            [
                'label' => esc_html__('Pslzme 3D moving light', 'pslzme'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'pslzme'),
                    'no' => esc_html__('No', 'pslzme'),
                ],
            ]
        );


        $this->add_control(
            'pslzme_3d_rotation',
            [
                'label' => esc_html__("Pslzme 3D rotation", "pslzme"),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'pslzme'),
                    'no' => esc_html__('No', 'pslzme'),
                ],
            ]
        );

        $this->add_control(
            'pslzme_3d_rotation_direction',
            [
                'label' => esc_html__("Pslzme 3D rotation direction", "pslzme"),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'right' => esc_html__('Right', 'pslzme'),
                    'left' => esc_html__('Left', 'pslzme'),
                ],
                'condition' => [
                    'pslzme_3d_rotation' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function add_style_controls(): void {
         $this->start_controls_section(
            'content_section_pslzme_3d_text_styles',
            [
                'label' => esc_html__('Pslzme 3D Text Style Section', 'pslzme'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'pslzme_3d_text_border_radius',
            [
                'label' => esc_html__('Pslzme 3D Text border radius', 'pslzme'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .pslzme-3d-text canvas' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }
}

?>