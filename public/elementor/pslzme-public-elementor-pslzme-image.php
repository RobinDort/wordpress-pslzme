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
        $this->add_style_controls();
    }

    /**
     * This function renders the widget and outputs its content.
     * @location /public/partials/pslzme-public-elementor-pslzme-image.php
     */
    protected function render(): void {
        $settings = $this->get_settings_for_display();
        include plugin_dir_path( dirname( __FILE__ ) ) . 'partials/pslzme-public-elementor-pslzme-image.php';
    }

    /**
     * This functions adds sections and control options to the widget.
     */
    private function add_content_controls(): void {

        $this->start_controls_section(
            'content_section_pslzme_image_unpersonalized',
            [
                'label' => esc_html__('Pslzme Image Unpersonalized Section', 'pslzme'),
                'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT, 
            ]
        );

        $this->add_control(
            'pslzme_image_unpersonalized_texts',
            [
                'label' => esc_html__('Unpersonalized Texts', 'pslzme'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'text',
                        'label' => esc_html__('Unpersonalized Text', 'pslzme'),
                        'type' => \Elementor\Controls_Manager::WYSIWYG,
                        'default' => esc_html__('Personalized text', 'pslzme'),
                        'show_label' => false,
                    ],
                    [
                        'name' => 'horizontal_position',
                        'label' => esc_html__('Horizontal Position', 'pslzme'),
                        'type' => \Elementor\Controls_Manager::CHOOSE,
                        'options' => [
                            'left' => [
                                'title' => esc_html__('Left', 'pslzme'),
                                'icon' => 'eicon-h-align-left',
                            ],
                            'center' => [
                                'title' => esc_html__('Center', 'pslzme'),
                                'icon' => 'eicon-h-align-center',
                            ],
                            'end' => [
                                'title' => esc_html__('Right', 'pslzme'),
                                'icon' => 'eicon-h-align-right',
                            ],
                        ],
                        'default' => 'left',
                        'toggle' => true,
                    ],
                    [
                        'name' => 'vertical_position',
                        'label' => esc_html__('Vertical Position', 'pslzme'),
                        'type' => \Elementor\Controls_Manager::CHOOSE,
                        'options' => [
                            'start' => [
                                'title' => esc_html__('Top', 'pslzme'),
                                'icon' => 'eicon-v-align-top',
                            ],
                            'center' => [
                                'title' => esc_html__('Middle', 'pslzme'),
                                'icon' => 'eicon-v-align-middle',
                            ],
                            'end' => [
                                'title' => esc_html__('Bottom', 'pslzme'),
                                'icon' => 'eicon-v-align-bottom',
                            ],
                        ],
                        'default' => 'start',
                        'toggle' => true,
                    ],
                    [
                        'name' => 'text_spacing',
                        'label' => esc_html__('Pslzme image text spacing', 'pslzme'),
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
                    ],
                    [
                        'name' => 'text_padding',
                        'label' => esc_html__('Pslzme image text padding', 'pslzme'),
                        'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
                        'size_units' => [ 'px', '%', 'em', 'rem' ],
                        'default' => [
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 0,
                            'left' => 0,
                            'unit' => 'px',
                            'isLinked' => false,
                        ],
                    ],
                    [
                        'name' => 'text_color',
                        'label' => esc_html('Pslzme image text color', 'pslzme'),
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#000000'
                    ]
                ],
                'default' => [
                    [
                        'text' => esc_html__('Unpersonalized text example #1', 'pslzme'),
                        'horizontal_position' => 'left',
                        'vertical_position' => 'start',
                        'text_spacing' => [
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 0,
                            'left' => 0,
                            'unit' => 'px',
                            'isLinked' => false,
                        ],
                        'text_padding' => [
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 0,
                            'left' => 0,
                            'unit' => 'px',
                            'isLinked' => false,
                        ],
                        'text_color' => '#000000'
                    ],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_section_pslzme_image_personalized',
            [
                'label' => esc_html__('Pslzme Image Personalized Section', 'pslzme'),
                'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT, 
            ]
        );

        $this->add_control(
            'pslzme_image_personalized_texts',
            [
                'label' => esc_html__('Personalized Texts', 'pslzme'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'text',
                        'label' => esc_html__('Personalized Text', 'pslzme'),
                        'type' => \Elementor\Controls_Manager::WYSIWYG,
                        'default' => esc_html__('Personalized text', 'pslzme'),
                        'show_label' => false,
                    ],
                     [
                        'name' => 'horizontal_position',
                        'label' => esc_html__('Horizontal Position', 'pslzme'),
                        'type' => \Elementor\Controls_Manager::CHOOSE,
                        'options' => [
                            'left' => [
                                'title' => esc_html__('Left', 'pslzme'),
                                'icon' => 'eicon-h-align-left',
                            ],
                            'center' => [
                                'title' => esc_html__('Center', 'pslzme'),
                                'icon' => 'eicon-h-align-center',
                            ],
                            'end' => [
                                'title' => esc_html__('Right', 'pslzme'),
                                'icon' => 'eicon-h-align-right',
                            ],
                        ],
                        'default' => 'left',
                        'toggle' => true,
                    ],
                    [
                        'name' => 'vertical_position',
                        'label' => esc_html__('Vertical Position', 'pslzme'),
                        'type' => \Elementor\Controls_Manager::CHOOSE,
                        'options' => [
                            'start' => [
                                'title' => esc_html__('Top', 'pslzme'),
                                'icon' => 'eicon-v-align-top',
                            ],
                            'center' => [
                                'title' => esc_html__('Middle', 'pslzme'),
                                'icon' => 'eicon-v-align-middle',
                            ],
                            'end' => [
                                'title' => esc_html__('Bottom', 'pslzme'),
                                'icon' => 'eicon-v-align-bottom',
                            ],
                        ],
                        'default' => 'start',
                        'toggle' => true,
                    ],
                    [
                        'name' => 'text_spacing',
                        'label' => esc_html__('Pslzme image text spacing', 'pslzme'),
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
                    ],
                    [
                        'name' => 'text_padding',
                        'label' => esc_html__('Pslzme image text padding', 'pslzme'),
                        'type' =>  \Elementor\Controls_Manager::DIMENSIONS,
                        'size_units' => [ 'px', '%', 'em', 'rem' ],
                        'default' => [
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 0,
                            'left' => 0,
                            'unit' => 'px',
                            'isLinked' => false,
                        ],
                    ],
                    [
                        'name' => 'text_color',
                        'label' => esc_html('Pslzme image text color', 'pslzme'),
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'default' => '#000000'
                    ]
                ],
                'default' => [
                    [
                        'text' => esc_html__('Unpersonalized text example #1', 'pslzme'),
                        'horizontal_position' => 'left',
                        'vertical_position' => 'start',
                        'text_spacing' => [
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 0,
                            'left' => 0,
                            'unit' => 'px',
                            'isLinked' => false,
                        ],
                        'text_padding' => [
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 0,
                            'left' => 0,
                            'unit' => 'px',
                            'isLinked' => false,
                        ],
                        'text_color' => '#000000'
                    ],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'pslzme_image_settings_section',
            [
                'label' => esc_html__('Pslzme Image Settings', 'pslzme'),
                'tab' 	=> \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
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

        $this->add_responsive_control(
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

        $this->add_responsive_control(
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


    private function add_style_controls(): void {
        $this->start_controls_section(
            'content_section_pslzme_image_styles',
            [
                'label' => esc_html__('Pslzme Image Style Section', 'pslzme'),
                'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .layered-text p',
            ]
        );

        $this->add_responsive_control(
            'pslzme_image_width',
            [
                'label' => esc_html__('Pslzme image width', 'pslzme'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 2000],
                    '%'  => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pslzme-ov-image-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pslzme_image_max_width',
            [
                'label' => esc_html__('Pslzme image max width', 'pslzme'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 2000],
                    '%'  => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pslzme-ov-image-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pslzme_image_height',
            [
                'label' => esc_html__('Pslzme image height', 'pslzme'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em', 'rem', 'vh'],
                'range' => [
                    'px' => ['min' => 0, 'max' => 2000],
                    '%'  => ['min' => 0, 'max' => 100],
                    'vh' => ['min' => 0, 'max' => 100],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pslzme-ov-image-container' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'pslzme_image_border_radius',
            [
                'label' => esc_html__( 'Pslzme image border radius', 'pslzme' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em', 'rem' ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                ],
                'selectors' => [
					'{{WRAPPER}} .pslzme-background-figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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