<?php
/**
 * Media Carousel Widget
 *
 * @since   1.2.1
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Embed;

if (! defined('ABSPATH') ) {
    exit;
}

/**
 * Elementor 'Media Carousel' widget.
 *
 * Elementor widget that displays Team Member.
 *
 * @since 1.2.1
 */
class REA_Media_Carousel extends Widget_Base
{

    private $slide_prints_count = 0;

    /**
     * @var int
     */
    private $lightbox_slide_index;

    public function getName()
    {
        return 'rea-media-carousel';
    }

    public function getTitle()
    {
        return __('REA Media Carousel', 'responsive-elementor-addons');
    }

    public function getIcon()
    {
        return 'eicon-media-carousel rea-badge';
    }

    public function get_keywords()
    {
        return [ 'media', 'carousel', 'image', 'video', 'lightbox' ];
    }

    public function getCategories()
    {
        return [ 'responsive-elementor-addon' ];
    }

    protected function get_repeater_defaults()
    {
        return array_fill(0, 5, []);
    }

    protected function registerControls()
    {
        $this->start_controls_section(
            'section_slides',
            [
            'label' => __('Slides', 'responsive-elementor-addons'),
            'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'rea_skin',
            [
            'label' => __('Skin', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'carousel',
            'options' => [
            'carousel' => __('Carousel', 'responsive-elementor-addons'),
            'slideshow' => __('Slideshow', 'responsive-elementor-addons'),
            'coverflow' => __('Coverflow', 'responsive-elementor-addons'),
            ],
            'prefix_class' => 'rea-elementor-skin-',
            'render_type' => 'template',
            'frontend_available' => true,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'rea_type',
            [
            'type' => Controls_Manager::CHOOSE,
            'label' => __('Type', 'responsive-elementor-addons'),
            'default' => 'image',
            'options' => [
            'image' => [
            'title' => __('Image', 'responsive-elementor-addons'),
            'icon' => 'eicon-image-bold',
            ],
            'video' => [
            'title' => __('Video', 'responsive-elementor-addons'),
            'icon' => 'eicon-video-camera',
            ],
            ],
            'toggle' => false,
            ]
        );

        $repeater->add_control(
            'rea_image',
            [
            'label' => __('Image', 'responsive-elementor-addons'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
            'url' => Utils::get_placeholder_image_src(),
            ],
            ]
        );

        $repeater->add_control(
            'rea_image_link_to_type',
            [
            'label' => __('Link', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'options' => [
            '' => __('None', 'responsive-elementor-addons'),
            'file' => __('Media File', 'responsive-elementor-addons'),
            'custom' => __('Custom URL', 'responsive-elementor-addons'),
            ],
            'condition' => [
                    'rea_type' => 'image',
            ],
            ]
        );

        $repeater->add_control(
            'rea_image_link_to',
            [
            'type' => Controls_Manager::URL,
            'placeholder' => __('https://your-link.com', 'responsive-elementor-addons'),
            'show_external' => 'true',
            'condition' => [
            'rea_type' => 'image',
            'rea_image_link_to_type' => 'custom',
            ],
            'separator' => 'none',
            'show_label' => false,
            ]
        );

        $repeater->add_control(
            'rea_video',
            [
            'label' => __('Video Link', 'responsive-elementor-addons'),
            'type' => Controls_Manager::URL,
            'placeholder' => __('Enter your video link', 'responsive-elementor-addons'),
            'description' => __('YouTube or Vimeo link', 'responsive-elementor-addons'),
            'options' => false,
            'condition' => [
            'rea_type' => 'video',
            ],
            ]
        );

        $this->add_control(
            'rea_slides',
            [
            'label' => __('Slides', 'responsive-elementor-addons'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => $this->get_repeater_defaults(),
            'separator' => 'after',
            ]
        );

        $this->add_control(
            'rea_effect',
            [
            'type' => Controls_Manager::SELECT,
            'label' => __('Effect', 'responsive-elementor-addons'),
            'default' => 'slide',
            'options' => [
            'slide' => __('Slide', 'responsive-elementor-addons'),
            'fade' => __('Fade', 'responsive-elementor-addons'),
            'cube' => __('Cube', 'responsive-elementor-addons'),
            ],
            'condition' => [
                    'rea_skin!' => 'coverflow',
            ],
            'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
            'rea_slideshow_height',
            [
            'type' => Controls_Manager::SLIDER,
            'label' => __('Height', 'responsive-elementor-addons'),
            'range' => [
            'px' => [
            'min' => 20,
            'max' => 1000,
            ],
            ],
            'selectors' => [
                    '{{WRAPPER}} .elementor-main-swiper' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                    'rea_skin' => 'slideshow',
            ],
            ]
        );

        $this->add_control(
            'rea_thumbs_title',
            [
            'label' => __('Thumbnails', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'condition' => [
            'rea_skin' => 'slideshow',
            ],
            ]
        );

        $slides_per_view = range(1, 10);
        $slides_per_view = array_combine($slides_per_view, $slides_per_view);

        $this->add_responsive_control(
            'rea_slides_per_view',
            [
            'type' => Controls_Manager::SELECT,
            'label' => __('Slides Per View', 'responsive-elementor-addons'),
            'options' => [ '' => __('Default', 'responsive-elementor-addons') ] + $slides_per_view,
            'condition' => [
            'rea_skin!' => 'slideshow',
            'rea_effect' => 'slide',
            ],
            'frontend_available' => true,
            ],
            [ 'recursive' => true ]
        );

        $this->add_responsive_control(
            'rea_slideshow_rea_slides_per_view',
            [
            'type' => Controls_Manager::SELECT,
            'label' => __('Slides Per View', 'responsive-elementor-addons'),
            'options' => [ '' => __('Default', 'responsive-elementor-addons') ] + $slides_per_view,
            'condition' => [
            'rea_skin' => 'slideshow',
            ],
            'frontend_available' => true,
            ]
        );

        $this->add_control(
            'rea_thumbs_ratio',
            [
            'label' => __('Ratio', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => '219',
            'options' => [
            '169' => '16:9',
            '219' => '21:9',
            '43' => '4:3',
            '11' => '1:1',
            ],
            'prefix_class' => 'elementor-aspect-ratio-',
            'condition' => [
                    'rea_skin' => 'slideshow',
            ],
            ]
        );

        $this->add_control(
            'rea_centered_slides',
            [
            'label' => __('Centered Slides', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SWITCHER,
            'condition' => [
            'rea_skin' => 'slideshow',
            ],
            'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
            'rea_slides_to_scroll',
            [
            'type' => Controls_Manager::SELECT,
            'label' => __('Slides to Scroll', 'responsive-elementor-addons'),
            'description' => __('Set how many slides are scrolled per swipe.', 'responsive-elementor-addons'),
            'options' => [ '' => __('Default', 'responsive-elementor-addons') ] + $slides_per_view,
            'condition' => [
            'rea_skin!' => 'slideshow',
            'rea_effect' => 'slide',
            ],
            'frontend_available' => true,
            ],
            [ 'recursive' => true ]
        );

        $this->add_responsive_control(
            'rea_height',
            [
            'type' => Controls_Manager::SLIDER,
            'label' => __('Height', 'responsive-elementor-addons'),
            'size_units' => [ 'px', 'vh' ],
            'range' => [
            'px' => [
            'min' => 100,
            'max' => 1000,
            ],
            'vh' => [
            'min' => 20,
            ],
            ],
            'selectors' => [
                    '{{WRAPPER}} .elementor-main-swiper' => 'height: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                    'rea_skin!' => 'slideshow',
            ],
            ],
            [ 'recursive' => true ]
        );

        $this->add_responsive_control(
            'rea_width',
            [
            'type' => Controls_Manager::SLIDER,
            'label' => __('Width', 'responsive-elementor-addons'),
            'range' => [
            'px' => [
            'min' => 100,
            'max' => 1140,
            ],
            '%' => [
            'min' => 50,
            ],
            ],
            'size_units' => [ '%', 'px' ],
            'default' => [
                    'unit' => '%',
            ],
            'selectors' => [
                    '{{WRAPPER}} .elementor-main-swiper' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                    'rea_skin!' => 'slideshow',
            ],
            ],
            [ 'recursive' => true ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_additional_options',
            [
            'label' => __('Additional Options', 'responsive-elementor-addons'),
            ]
        );

        $this->add_control(
            'rea_show_arrows',
            [
            'type' => Controls_Manager::SWITCHER,
            'label' => __('Arrows', 'responsive-elementor-addons'),
            'default' => 'yes',
            'label_off' => __('Hide', 'responsive-elementor-addons'),
            'label_on' => __('Show', 'responsive-elementor-addons'),
            'prefix_class' => 'elementor-arrows-',
            'render_type' => 'template',
            'frontend_available' => true,
            ]
        );

        $this->add_control(
            'rea_pagination',
            [
            'label' => __('Pagination', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'bullets',
            'options' => [
            '' => __('None', 'responsive-elementor-addons'),
            'bullets' => __('Dots', 'responsive-elementor-addons'),
            'fraction' => __('Fraction', 'responsive-elementor-addons'),
            'progressbar' => __('Progress', 'responsive-elementor-addons'),
            ],
            'condition' => [
                    'rea_skin!' => 'slideshow',
            ],
            'prefix_class' => 'elementor-pagination-type-',
            'render_type' => 'template',
            'frontend_available' => true,
            ],
            [ 'recursive' => true ]
        );

        $this->add_control(
            'rea_speed',
            [
            'label' => __('Transition Duration', 'responsive-elementor-addons'),
            'type' => Controls_Manager::NUMBER,
            'default' => 500,
            'frontend_available' => true,
            ]
        );

        $this->add_control(
            'rea_autoplay',
            [
            'label' => __('Autoplay', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'separator' => 'before',
            'frontend_available' => true,
            ]
        );

        $this->add_control(
            'rea_autoplay_speed',
            [
            'label' => __('Autoplay Speed', 'responsive-elementor-addons'),
            'type' => Controls_Manager::NUMBER,
            'default' => 5000,
            'condition' => [
            'rea_autoplay' => 'yes',
            ],
            'frontend_available' => true,
            ]
        );

        $this->add_control(
            'rea_loop',
            [
            'label' => __('Infinite Loop', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'frontend_available' => true,
            ]
        );

        $this->add_control(
            'rea_pause_on_hover',
            [
            'label' => __('Pause on Hover', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
            'rea_autoplay' => 'yes',
            ],
            'frontend_available' => true,
            ]
        );

        $this->add_control(
            'rea_pause_on_interaction',
            [
            'label' => __('Pause on Interaction', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SWITCHER,
            'default' => 'yes',
            'condition' => [
            'rea_autoplay' => 'yes',
            ],
            'frontend_available' => true,
            ]
        );

        $this->add_control(
            'rea_overlay',
            [
            'label' => __('Overlay', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'options' => [
            '' => __('None', 'responsive-elementor-addons'),
            'text' => __('Text', 'responsive-elementor-addons'),
            'icon' => __('Icon', 'responsive-elementor-addons'),
            ],
            'condition' => [
                    'rea_skin!' => 'slideshow',
            ],
            'separator' => 'before',
            ]
        );

        $this->add_control(
            'rea_caption',
            [
            'label' => __('Caption', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'title',
            'options' => [
            'title' => __('Title', 'responsive-elementor-addons'),
            'caption' => __('Caption', 'responsive-elementor-addons'),
            'description' => __('Description', 'responsive-elementor-addons'),
            ],
            'condition' => [
                    'rea_skin!' => 'slideshow',
                    'rea_overlay' => 'text',
            ],
            ]
        );

        $this->add_control(
            'rea_icon',
            [
            'label' => __('Icon', 'responsive-elementor-addons'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'search-plus',
            'options' => [
            'search-plus' => [
            'icon' => 'eicon-search-plus',
            ],
            'plus-circle' => [
            'icon' => 'eicon-plus-circle',
            ],
            'eye' => [
            'icon' => 'eicon-preview-medium',
            ],
            'link' => [
            'icon' => 'eicon-link',
            ],
            ],
            'condition' => [
                    'rea_skin!' => 'slideshow',
                    'rea_overlay' => 'icon',
            ],
            ]
        );

        $this->add_control(
            'rea_overlay_animation',
            [
            'label' => __('Animation', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'fade',
            'options' => [
            'fade' => 'Fade',
            'slide-up' => 'Slide Up',
            'slide-down' => 'Slide Down',
            'slide-right' => 'Slide Right',
            'slide-left' => 'Slide Left',
            'zoom-in' => 'Zoom In',
            ],
            'condition' => [
                    'rea_skin!' => 'slideshow',
                    'rea_overlay!' => '',
            ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
            'name' => 'image_size',
            'default' => 'full',
            'separator' => 'before',
            ]
        );

        $this->add_control(
            'rea_image_fit',
            [
            'label' => __('Image Fit', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => '',
            'options' => [
            '' => __('Cover', 'responsive-elementor-addons'),
            'contain' => __('Contain', 'responsive-elementor-addons'),
            'auto' => __('Auto', 'responsive-elementor-addons'),
            ],
            'selectors' => [
                    '{{WRAPPER}} .elementor-main-swiper .elementor-carousel-image' => 'background-size: {{VALUE}}',
            ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_slides_style',
            [
            'label' => __('Slides', 'responsive-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'rea_space_between',
            [
            'label' => __('Space Between', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
            'px' => [
            'max' => 50,
            ],
            ],
            'desktop_default' => [
                    'size' => 10,
            ],
            'tablet_default' => [
                    'size' => 10,
            ],
            'mobile_default' => [
                    'size' => 10,
            ],
            'frontend_available' => true,
            'selectors' => [
                    '{{WRAPPER}}.rea-elementor-skin-slideshow .elementor-main-swiper' => 'margin-bottom: {{SIZE}}{{UNIT}}',
            ],
            'render_type' => 'ui',
            ]
        );

        $this->add_control(
            'rea_slide_background_color',
            [
            'label' => __('Background Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .elementor-main-swiper .swiper-slide' => 'background-color: {{VALUE}}',
            ],
            ]
        );

        $this->add_control(
            'rea_slide_border_size',
            [
            'label' => __('Border Size', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
            '{{WRAPPER}} .elementor-main-swiper .swiper-slide' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
            ]
        );

        $this->add_control(
            'rea_slide_border_radius',
            [
            'label' => __('Border Radius', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', '%' ],
            'range' => [
            '%' => [
            'max' => 50,
            ],
            ],
            'selectors' => [
                    '{{WRAPPER}} .elementor-main-swiper .swiper-slide' => 'border-radius: {{SIZE}}{{UNIT}}',
            ],
            ]
        );

        $this->add_control(
            'rea_slide_border_color',
            [
            'label' => __('Border Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .elementor-main-swiper .swiper-slide' => 'border-color: {{VALUE}}',
            ],
            ]
        );

        $this->add_control(
            'rea_slide_padding',
            [
            'label' => __('Padding', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'selectors' => [
            '{{WRAPPER}} .elementor-main-swiper .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ],
            'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_navigation',
            [
            'label' => __('Navigation', 'responsive-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'rea_heading_arrows',
            [
            'label' => __('Arrows', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'none',
            ]
        );

        $this->start_controls_tabs('rea_arrows_tabs');

        $this->start_controls_tab(
            'rea_arrows_normal_state',
            [
            'label' => __('Normal', 'responsive-elementor-addons'),
            ]
        );

        $this->add_control(
            'rea_arrows_normal_size',
            [
            'label' => __('Size', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
            'size' => 20,
            ],
            'range' => [
                    'px' => [
                        'min' => 10,
                    ],
            ],
            'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button' => 'font-size: {{SIZE}}{{UNIT}}',
            ],
            ]
        );

        $this->add_control(
            'rea_arrows_normal_color',
            [
            'label' => __('Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .elementor-swiper-button' => 'color: {{VALUE}}',
            ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'rea_arrows_hover_state',
            [
            'label' => __('Hover', 'responsive-elementor-addons'),
            ]
        );

        $this->add_control(
            'rea_arrows_hover_size',
            [
            'label' => __('Size', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
            'size' => 20,
            ],
            'range' => [
                    'px' => [
                        'min' => 10,
                    ],
            ],
            'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button:hover' => 'font-size: {{SIZE}}{{UNIT}}',
            ],
            ]
        );

        $this->add_control(
            'rea_arrows_hover_color',
            [
            'label' => __('Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .elementor-swiper-button:hover' => 'color: {{VALUE}}',
            ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'rea_heading_pagination',
            [
            'label' => __('Pagination', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
            'rea_skin!' => 'slideshow',
            ],
            ],
            [ 'recursive' => true ]
        );

        $this->add_control(
            'rea_pagination_position',
            [
            'label' => __('Position', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'outside',
            'options' => [
            'outside' => __('Outside', 'responsive-elementor-addons'),
            'inside' => __('Inside', 'responsive-elementor-addons'),
            ],
            'prefix_class' => 'elementor-pagination-position-',
            'condition' => [
                    'rea_skin!' => 'slideshow',
            ],
            ],
            [ 'recursive' => true ]
        );

        $this->add_control(
            'rea_pagination_size',
            [
            'label' => __('Size', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
            'px' => [
            'max' => 20,
            ],
            ],
            'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .swiper-container-horizontal .swiper-pagination-progressbar' => 'height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .swiper-pagination-fraction' => 'font-size: {{SIZE}}{{UNIT}}',
            ],
            'condition' => [
                    'rea_skin!' => 'slideshow',
            ],
            ],
            [ 'recursive' => true ]
        );

        $this->add_control(
            'rea_pagination_color',
            [
            'label' => __('Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .swiper-pagination-bullet-active, {{WRAPPER}} .swiper-pagination-progressbar-fill' => 'background-color: {{VALUE}}',
            '{{WRAPPER}} .swiper-pagination-fraction' => 'color: {{VALUE}}',
            ],
            'condition' => [
                    'rea_skin!' => 'slideshow',
            ],
            ],
            [ 'recursive' => true ]
        );

        $this->add_control(
            'rea_play_icon_title',
            [
            'label' => __('Play Icon', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            ]
        );

        $this->add_control(
            'rea_play_icon_color',
            [
            'label' => __('Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .elementor-custom-embed-play i' => 'color: {{VALUE}}',
            ],
            ]
        );

        $this->add_responsive_control(
            'rea_play_icon_size',
            [
            'label' => __('Size', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
            'px' => [
            'min' => 20,
            'max' => 150,
            ],
            ],
            'selectors' => [
                    '{{WRAPPER}} .elementor-custom-embed-play i' => 'font-size: {{SIZE}}{{UNIT}}',
            ],
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
            'name' => 'play_icon_text_shadow',
            'selector' => '{{WRAPPER}} .elementor-custom-embed-play i',
            'fields_options' => [
            'text_shadow_type' => [
            'label' => _x('Shadow', 'Text Shadow Control', 'responsive-elementor-addons'),
            ],
            ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_overlay',
            [
            'label' => __('Overlay', 'responsive-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => [
            'rea_skin!' => 'slideshow',
            'rea_overlay!' => '',
            ],
            ]
        );

        $this->add_control(
            'rea_overlay_background_color',
            [
            'label' => __('Background Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .rea-elementor-carousel-image-overlay' => 'background-color: {{VALUE}};',
            ],
            ]
        );

        $this->add_control(
            'rea_overlay_color',
            [
            'label' => __('Text Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
            '{{WRAPPER}} .rea-elementor-carousel-image-overlay' => 'color: {{VALUE}};',
            ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
            'name' => 'caption_typography',
            'global' => [
            'default' => Global_Typography::TYPOGRAPHY_ACCENT,
            ],
            'selector' => '{{WRAPPER}} .rea-elementor-carousel-image-overlay',
            'condition' => [
                    'rea_overlay' => 'text',
            ],
            ]
        );

        $this->add_control(
            'rea_icon_size',
            [
            'label' => __('Icon Size', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'selectors' => [
            '{{WRAPPER}} .rea-elementor-carousel-image-overlay i' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                    'rea_overlay' => 'icon',
            ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_lightbox_style',
            [
            'label' => __('Lightbox', 'responsive-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'rea_lightbox_color',
            [
            'label' => __('Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
            '#elementor-lightbox-slideshow-{{ID}}' => 'background-color: {{VALUE}};',
            ],
            ]
        );

        $this->add_control(
            'rea_lightbox_ui_color',
            [
            'label' => __('UI Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
            '#elementor-lightbox-slideshow-{{ID}} .dialog-lightbox-close-button, #elementor-lightbox-slideshow-{{ID}} .elementor-swiper-button' => 'color: {{VALUE}};',
            ],
            ]
        );

        $this->add_control(
            'rea_lightbox_ui_hover_color',
            [
            'label' => __('UI Hover Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
            '#elementor-lightbox-slideshow-{{ID}} .dialog-lightbox-close-button:hover, #elementor-lightbox-slideshow-{{ID}} .elementor-swiper-button:hover' => 'color: {{VALUE}};',
            ],
            ]
        );

        $this->add_control(
            'rea_lightbox_video_width',
            [
            'label' => __('Video Width', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => [
            'unit' => '%',
            ],
            'range' => [
                    '%' => [
                        'min' => 50,
                    ],
            ],
            'selectors' => [
                    '#elementor-lightbox-slideshow-{{ID}} .elementor-video-container' => 'width: {{SIZE}}{{UNIT}};',
            ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_active_settings();

        if ($settings['rea_overlay'] ) {
            $this->add_render_attribute(
                'image-overlay', 'class', [
                'rea-elementor-carousel-image-overlay',
                'e-overlay-animation-' . $settings['rea_overlay_animation'],
                ] 
            );
        }

        $this->print_slider();

        if ('slideshow' != $settings['rea_skin'] || count($settings['rea_slides']) <= 1 ) {
            return;
        }

        $settings['rea_thumbs_slider'] = true;
        $settings['rea_container_class'] = 'rea-elementor-thumbnails-swiper';
        $settings['rea_show_arrows'] = false;

        $this->print_slider($settings);

    }

    protected function print_slider( array $settings = null )
    {
        $this->lightbox_slide_index = 0;

        if (null == $settings ) {
            $settings = $this->get_settings_for_display();
        }

        $default_settings = [
        'rea_container_class' => 'elementor-main-swiper',
        'rea_video_play_icon' => true,
        ];

        $settings = array_merge($default_settings, $settings);

        $slides_count = count($settings['rea_slides']);
        ?>
        <div class="elementor-swiper">
            <div class="<?php echo esc_attr($settings['rea_container_class']); ?> swiper-container">
                <div class="swiper-wrapper">
        <?php
        foreach ( $settings['rea_slides'] as $index => $slide ) :
            $this->slide_prints_count++;
            ?>
                        <div class="swiper-slide">
            <?php $this->print_slide($slide, $settings, 'slide-' . $index . '-' . $this->slide_prints_count); ?>
                        </div>
        <?php endforeach; ?>
                </div>
        <?php if (1 < $slides_count ) : ?>
            <?php if ($settings['rea_pagination'] ) : ?>
                        <div class="swiper-pagination"></div>
            <?php endif; ?>
            <?php if ($settings['rea_show_arrows'] ) : ?>
                        <div class="elementor-swiper-button elementor-swiper-button-prev">
                            <i class="eicon-chevron-left" aria-hidden="true"></i>
                            <span class="elementor-screen-only"><?php _e('Previous', 'responsive-elementor-addons'); ?></span>
                        </div>
                        <div class="elementor-swiper-button elementor-swiper-button-next">
                            <i class="eicon-chevron-right" aria-hidden="true"></i>
                            <span class="elementor-screen-only"><?php _e('Next', 'responsive-elementor-addons'); ?></span>
                        </div>
            <?php endif; ?>
        <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function print_slide( array $slide, array $settings, $element_key )
    {

        if (! empty($settings['rea_thumbs_slider']) ) {
            $settings['rea_video_play_icon'] = false;

            $this->add_render_attribute($element_key . '-image', 'class', 'elementor-fit-aspect-ratio');
        }

        $this->add_render_attribute(
            $element_key . '-image', [
            'class' => 'elementor-carousel-image',
            'style' => 'background-image: url(' . $this->get_slide_image_url($slide, $settings) . ')',
            ] 
        );

        $image_link_to = $this->get_image_link_to($slide);

        if ($image_link_to && empty($settings['rea_thumbs_slider']) ) {
            if ('custom' == $slide['rea_image_link_to_type'] ) {
                $this->add_link_attributes($element_key . '_link', $slide['rea_image_link_to']);
            } else {
                $this->add_render_attribute($element_key . '_link', 'href', $image_link_to);

                $this->add_lightbox_data_attributes($element_key . '_link', $slide['rea_image']['id'], 'yes', $this->get_id());

                if (\Elementor\Plugin::instance()->editor->is_edit_mode() ) {
                    $this->add_render_attribute($element_key . '_link', 'class', 'elementor-clickable');
                }

                $this->lightbox_slide_index++;
            }

            if ('video' == $slide['rea_type'] && $slide['rea_video']['url'] ) {
                $embed_url_params = [
                'autoplay' => 1,
                'rel' => 0,
                'controls' => 0,
                ];

                $this->add_render_attribute($element_key . '_link', 'data-elementor-lightbox-video', Embed::get_embed_url($slide['rea_video']['url'], $embed_url_params));
            }

            echo '<a ' . $this->get_render_attribute_string($element_key . '_link') . '>';
        }

        $this->print_slide_image($slide, $element_key, $settings);

        if ($image_link_to ) {
            echo '</a>';
        }
    }

    protected function get_slide_image_url( $slide, array $settings )
    {
        $image_url = Group_Control_Image_Size::get_attachment_image_src($slide['rea_image']['id'], 'image_size', $settings);

        if (! $image_url ) {
            $image_url = $slide['rea_image']['url'];
        }

        return $image_url;
    }

    protected function get_image_link_to( $slide )
    {
        if (! empty($slide['rea_video']['url']) ) {
            return $slide['rea_image']['url'];
        }

        if (! $slide['rea_image_link_to_type'] ) {
            return '';
        }

        if ('custom' == $slide['rea_image_link_to_type'] ) {
            return $slide['rea_image_link_to']['url'];
        }

        return $slide['rea_image']['url'];
    }

    protected function print_slide_image( array $slide, $element_key, array $settings )
    {
        ?>
        <div <?php echo $this->get_render_attribute_string($element_key . '-image'); ?>>
        <?php if ('video' == $slide['rea_type'] && $settings['rea_video_play_icon'] ) : ?>
                <div class="elementor-custom-embed-play">
                    <i class="eicon-play" aria-hidden="true"></i>
                    <span class="elementor-screen-only"><?php _e('Play', 'responsive-elementor-addons'); ?></span>
                </div>
        <?php endif; ?>
        </div>
        <?php if ($settings['rea_overlay'] ) : ?>
            <div <?php echo $this->get_render_attribute_string('image-overlay'); ?>>
            <?php if ('text' == $settings['rea_overlay'] ) : ?>
                <?php echo $this->get_image_caption($slide); ?>
                <?php else : ?>
                    <i class="fa fa-<?php echo $settings['rea_icon']; ?>"></i>
                <?php endif; ?>
            </div>
            <?php
        endif;
    }

    protected function get_image_caption( $slide )
    {
        $caption_type = $this->get_settings('rea_caption');

        if (empty($caption_type) ) {
            return '';
        }

        $attachment_post = get_post($slide['rea_image']['id']);

        if ('caption' == $caption_type ) {
            return $attachment_post->post_excerpt;
        }

        if ('title' == $caption_type ) {
            return $attachment_post->post_title;
        }

        return $attachment_post->post_content;
    }

    /**
     * Get Custom help URL
     *
     * @return string help URL
     */
    public function getCustomHelpUrl()
    {
        return 'https://docs.cyberchimps.com/responsive-elementor-addons/rea-media-carousel';
    }

}
