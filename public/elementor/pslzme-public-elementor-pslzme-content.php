<?php

/**
 * Class that creates a custom elementor widget as pslzme content.
 */
class ElementorWidgetPslzmeContent extends \Elementor\Widget_Base {

    /**
     * This function returns the name of the widget.
     */
    public function get_name(): string {
        return 'pslzme_content';
    }

     /**
     * This function returns the title of the widget.
     */
    public function get_title(): string {
        return esc_html__("Pslzme Content Widget", "pslzme");
    }

    /**
     * This function returns the icon of the widget.
     */
    public function get_icon(): string {
        return 'eicon-clone';
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
		return [ 'Pslzme', 'pslzme', 'Content', 'content', 'Pslzme Content', 'pslzme content' ];
	}

    /**
     * This function registers custom controls for the widget.
     */
    protected function register_controls(): void {
        $this->add_content_controls();
    }

    /**
     * This function renders the widget and outputs its content.
     * @location /public/partials/pslzme-public-elementor-pslzme-content.php
     */
    protected function render(): void {
        $settings = $this->get_settings_for_display();
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pslzme-public-elementor-pslzme-content.php';
    }

    /**
     * This functions adds sections and control options to the widget.
     * Depending on a content type 'image' or 'video' different controls are displayed.
     */
    private function add_content_controls(): void {
        $this->start_controls_section(
            'section_content_type',
            [
                'label' => esc_html__('Content Type', 'pslzme'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'pslzme_content_type',
            [
                'label'   => esc_html__('Pslzme content type', 'pslzme'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image' => esc_html__('Image', 'pslzme'),
                    'video' => esc_html__('Video', 'pslzme'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->add_pslzme_content_image_controls();
        $this->add_pslzme_content_video_controls();       
     }

    
    /**
     * This function adds the controls for the image content type.
     */
    private function add_pslzme_content_image_controls() {

        $this->start_controls_section(
            'section_personalized_image_settings',
            [
                'label' => esc_html__('Pslzme content personalized image settings', 'pslzme'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'pslzme_content_type' => 'image',
                ],
            ]
        );

        $this->add_control(
            'pslzme_content_personalized_image',
            [
                'label' => esc_html__('Pslzme content personalized image', 'pslzme'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => [ 'image' ],
            ]
        );

        $this->add_control(
            'pslzme_content_personalized_image_alt',
            [
                'label' => esc_html__('Pslzme content personalized image alt text', 'pslzme'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_responsive_control(
            'pslzme_content_personalized_image_size',
            [
                'label'   => esc_html__('Pslzme content personalized image size', 'pslzme'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'full',
                'options' => $this->get_available_image_sizes(),
            ]
        );

        $this->add_control(
            'pslzme_content_personalized_image_caption',
            [
                'label' => esc_html__('Pslzme content personalized image caption', 'pslzme'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
            ]
        );

        $this->add_control(
            'pslzme_content_personalized_image_link',
            [
                'label' => esc_html__('Pslzme content personalized image link', 'pslzme'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_pages_options(),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_unpersonalized_image_settings',
            [
                'label' => esc_html__('Pslzme content unpersonalized image settings', 'pslzme'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'pslzme_content_type' => 'image',
                ],
            ]
        );

         $this->add_control(
            'pslzme_content_unpersonalized_image',
            [
                'label' => esc_html__('Pslzme content unpersonalized image', 'pslzme'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => [ 'image' ],
            ]
        );

        $this->add_control(
            'pslzme_content_unpersonalized_image_alt',
            [
                'label' => esc_html__('Pslzme content unpersonalized image alt text', 'pslzme'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_responsive_control(
            'pslzme_content_unpersonalized_image_size',
            [
                'label'   => esc_html__('Pslzme content unpersonalized image size', 'pslzme'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 'full',
                'options' => $this->get_available_image_sizes(),
            ]
        );

        $this->add_control(
            'pslzme_content_unpersonalized_image_caption',
            [
                'label' => esc_html__('Pslzme content unpersonalized image caption', 'pslzme'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
            ]
        );

        $this->add_control(
            'pslzme_content_unpersonalized_image_link',
            [
                'label' => esc_html__('Pslzme content unpersonalized image link', 'pslzme'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_pages_options(),
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

    }


    /**
     * This function adds the controls for the video content type.
     */
    private function add_pslzme_content_video_controls() {
        $this->start_controls_section(
            'section_personalized_video_settings',
            [
                'label' => esc_html__('Pslzme content personalized video settings', 'pslzme'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'pslzme_content_type' => 'video',
                ],
            ]
        );

        $this->add_control(
            'pslzme_content_personalized_video',
            [
                'label' => esc_html__('Pslzme content personalized video', 'pslzme'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'label_block' => true,
            ]   
        );

        $this->add_responsive_control(
            'pslzme_content_personalized_video_width',
            [
                'label'   => esc_html__('Pslzme content personalized video width', 'pslzme'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 1920,
                'step' => 1,
                'default' => 640,
            ]
        );

        $this->add_responsive_control(
            'pslzme_content_personalized_video_height',
            [
                'label'   => esc_html__('Pslzme content personalized video height', 'pslzme'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 1080,
                'step' => 1,
                'default' => 360,
            ]
        );

        $this->add_control(
            'pslzme_content_personalized_video_options',
            [
                'label' => esc_html__('Pslzme content personalized video options', 'pslzme'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    'autoplay'     => esc_html__('Autoplay', 'pslzme'),
                    'controls_hidden' => esc_html__('Hide control options', 'pslzme'),
                    'loop'         => esc_html__('Play in loop', 'pslzme'),
                    'playsinline'  => esc_html__('Inline play (no fullscreen mode)', 'pslzme'),
                    'muted'        => esc_html__('Mute audio output', 'pslzme'),
                ],
                'label_block' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_unpersonalized_video_settings',
            [
                'label' => esc_html__('Pslzme content unpersonalized video settings', 'pslzme'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'pslzme_content_type' => 'video',
                ],
            ]
        );

        $this->add_control(
            'pslzme_content_unpersonalized_video',
            [
                'label' => esc_html__('Pslzme content unpersonalized video', 'pslzme'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'label_block' => true,
            ]   
        );

        $this->add_responsive_control(
            'pslzme_content_unpersonalized_video_width',
            [
                'label'   => esc_html__('Pslzme content unpersonalized video width', 'pslzme'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 1920,
                'step' => 1,
                'default' => 640,
            ]
        );

        $this->add_responsive_control(
            'pslzme_content_unpersonalized_video_height',
            [
                'label'   => esc_html__('Pslzme content unpersonalized video height', 'pslzme'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 1080,
                'step' => 1,
                'default' => 360,
            ]
        );

        $this->add_control(
            'pslzme_content_unpersonalized_video_options',
            [
                'label' => esc_html__('Pslzme content unpersonalized video options', 'pslzme'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    'autoplay'     => esc_html__('Autoplay', 'pslzme'),
                    'controls_hidden' => esc_html__('Hide control options', 'pslzme'),
                    'loop'         => esc_html__('Play in loop', 'pslzme'),
                    'playsinline'  => esc_html__('Inline play (no fullscreen mode)', 'pslzme'),
                    'muted'        => esc_html__('Mute audio output', 'pslzme'),
                ],
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


    /**
     * This function searches for all available pages.
     * @return an array containing all defined pages.
     */
    private function get_pages_options() {
        $pages = get_pages();
        $options = [ '' => esc_html__('— No Link —', 'pslzme') ];

        foreach ($pages as $page) {
            $options[$page->ID] = $page->post_title;
        }

        return $options;
    }

}

?>