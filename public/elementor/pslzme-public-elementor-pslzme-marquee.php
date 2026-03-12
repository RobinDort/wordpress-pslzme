<?php
class ElementorWidgetPslzmeMarquee extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'pslzme_marquee';
    }

	/**
     * This function returns the title of the widget.
     */
    public function get_title(): string {
        return esc_html__("Pslzme Marquee Widget", "pslzme");
    }

	/**
     * This function returns the icon of the widget.
     */
    public function get_icon(): string {
        return 'eicon-animation';
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
		return [ 'Pslzme', 'pslzme', 'Marquee', 'marquee', 'Pslzme Marquee', 'pslzme marquee' ];
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
                'pslzme-marquee-widget',
                'elementor-widget-' . $this->get_name(),
            ]
        );
        $this->add_render_attribute( 'wrapper', 'data-widget_type', $this->get_name() );
        include plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pslzme-public-elementor-pslzme-marquee.php';
    }


    private function add_content_controls(): void {
        $this->start_controls_section(
			'content_section_marquee',
			[
				'label' => esc_html__('Personalized Text Section', 'pslzme'),
				'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT, 
			]
		);

        $this->add_control(
			'marquee_personalized_text',
			[
				'label' => esc_html__( 'Personalized Text', 'pslzme' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
			]
		);

         $this->add_control(
			'marquee_unpersonalized_text',
			[
				'label' => esc_html__( 'Unpersonalized Text', 'pslzme' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
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
            'marque_text_color',
            [
                'label' => esc_html__('Marquee Text Color', 'pslzme'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pslzme-marquee' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'marquee_background_color',
            [
                'label' => esc_html__('Marquee background Color', 'pslzme'),
                'type'  => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .pslzme-marquee' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Typography (includes font size)
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .pslzme-marquee',
            ]
        );

        $this->add_responsive_control(
            'marquee_height',
            [
                'label' => esc_html__('Marquee container height', 'pslzme'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem' ],
                'range' => [
                    'px' => [ 'min' => 280, 'max' => 500 ],
                    '%'  => [ 'min' => 1, 'max' => 100 ],
                    'em' => [ 'min' => 1, 'max' => 5 ],
                    'rem'=> [ 'min' => 1, 'max' => 30 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pslzme-marquee ' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

}


?>