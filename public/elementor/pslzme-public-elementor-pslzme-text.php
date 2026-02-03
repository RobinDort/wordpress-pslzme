<?php

class ElementorWidgetPslzmeText extends \Elementor\Widget_Base {

    public function get_name(): string {
        return 'pslzme_text';
    }

    public function get_title(): string {
        return esc_html__("Pslzme Text Widget", "pslzme");
    }

    public function get_icon(): string {
        return 'eicon-t-letter-bold';
    }

    public function get_categories(): array {
		return [ 'Pslzme' ];
	}

    public function get_keywords(): array {
		return [ 'Pslzme', 'pslzme', 'Text', 'text', 'Pslzme Text', 'pslzme text' ];
	}

    protected function register_controls(): void {
        $this->add_content_controls();
    }

    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pslzme-public-elementor-pslzme-text.php';
    }

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
				'label' => esc_html__( 'Personalized Text', 'pslzme' ),
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

}

?>