<?php

/**
 * Class that creates a custom elementor widget as pslzme text.
 */
class ElementorWidgetPslzmeText extends \Elementor\Widget_Base {

	/**
     * This function returns the name of the widget.
     */
    public function get_name(): string {
        return 'pslzme_text';
    }

	/**
     * This function returns the title of the widget.
     */
    public function get_title(): string {
        return esc_html__("Pslzme Text Widget", "pslzme");
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
		return [ 'Pslzme', 'pslzme', 'Text', 'text', 'Pslzme Text', 'pslzme text' ];
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
        $this->add_render_attribute(
            'wrapper',
            'class',
            [
                'pslzme-text',
                'ce_text',
                'block'
            ]
        );
        $this->add_render_attribute( 'wrapper', 'data-widget_type', $this->get_name() );
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pslzme-public-elementor-pslzme-text.php';
    }

	/**
     * This functions adds sections and control options to the widget.
     */
    private function add_content_controls(): void {
        $this->start_controls_section(
			'content_section_personalized_text',
			[
				'label' => esc_html__('Personalized Text Section', 'pslzme'),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT, 
			]
		);

        $this->add_control(
			'personalized_text',
			[
				'label' => esc_html__( 'Personalized Text', 'pslzme' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'content_section_unpersonalized_text',
			[
				'label' => esc_html__('Unpersonalized Text Section', 'pslzme'),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT, 
			]
		);

         $this->add_control(
			'unpersonalized_text',
			[
				'label' => esc_html__( 'Unpersonalized Text', 'pslzme' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
			]
		);

        $this->add_control(
			'show_unpersonalized_text',
			[
				'label' => esc_html__( 'Show unpersonalized text', 'pslzme' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Yes', 'pslzme' ),
				'label_off' => esc_html__( 'No', 'pslzme' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

        $this->end_controls_section();
    }


    private function add_style_controls(): void {

        $this->start_controls_section(
            'style_section_text',
            [
                'label' => esc_html__('Text Styling', 'pslzme'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Text Color
        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text Color', 'pslzme'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pslzme-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Typography (includes font size)
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .pslzme-text',
            ]
        );

        $this->end_controls_section();
    }

}

?>