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
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pslzme-public-elementor-pslzme-3d-text.php';
    }

    private function add_content_controls(): void {}

    private function add_style_controls(): void {}
}

?>