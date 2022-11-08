<?php
/**
 * REA Video Widget
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Icons_Manager;

if (! defined('ABSPATH') ) {
    exit;   // Exit if accessed directly.
}

/**
 * REA video widget.
 *
 * REA widget that displays a video player.
 *
 * @since 1.0.0
 */
class REA_Video extends Widget_Base
{


    /**
     * Retrieve the widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function getName()
    {
        return 'rea-video';
    }

    /**
     * Retrieve the widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function getTitle()
    {
        return __('REA Video', 'responsive-elementor-addons');
    }

    /**
     * Get widget icon.
     *
     * Retrieve Video widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function getIcon()
    {
        return 'eicon-youtube rea-badge';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Video widget belongs to.
     *
     * @since  1.0.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function getCategories()
    {
        return array( 'responsive-elementor-addon' );
    }

    /**
     * Retrieve the keywords.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget keywords.
     */
    public function get_keywords()
    {
        return array( 'video', 'play', 'player', 'vimeo', 'youtube' );
    }

    /**
     * Retrieve the scripts.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget script.
     */
    public function get_script_depends()
    {
        return array( 'rea-magnific-popup' );
    }

    /**
     * Retrieve the url.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget url.
     */
    public function get_help_url()
    {
        return 'https://docs.cyberchimps.com/responsive-elementor-addons/';
    }

    /**
     * Register video widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function registerControls()
    {
        $this->start_controls_section(
            'rea_video_popup_content_section',
            array(
            'label' => esc_html__('Video', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_CONTENT,
            )
        );

        $this->add_control(
            'rea_video_popup_button_icons',
            array(
            'label'            => esc_html__('Button Icon', 'responsive-elementor-addons'),
            'type'             => Controls_Manager::ICONS,
            'fa4compatibility' => 'rea_video_popup_button_icon',
            'default'          => array(
            'value'   => 'fas fa-play',
            'library' => 'fa-solid',
            ),
            'label_block'      => true,
            )
        );

        $this->add_control(
            'rea_video_glow',
            array(
            'label'        => esc_html__('Active Glow', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'responsive-elementor-addons'),
            'label_off'    => esc_html__('No', 'responsive-elementor-addons'),
            'return_value' => 'yes',
            'default'      => 'yes',
            )
        );

        $this->add_control(
            'rea_video_popup_type',
            array(
            'label'   => esc_html__('Video Type', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'youtube',
            'options' => array(
            'youtube' => esc_html__('youtube', 'responsive-elementor-addons'),
            'vimeo'   => esc_html__('vimeo', 'responsive-elementor-addons'),
            ),
            )
        );

        $this->add_control(
            'rea_video_popup_url',
            array(
            'label'       => esc_html__('URL to embed', 'responsive-elementor-addons'),
            'label_block' => true,
            'type'        => Controls_Manager::TEXT,
            'input_type'  => 'url',
            'placeholder' => esc_html('https://www.youtube.com/watch?v=OI3gGmJzhVM'),
            'default'     => esc_html('https://www.youtube.com/watch?v=OI3gGmJzhVM'),
            'dynamic'     => array(
            'active' => true,
            ),
            )
        );

        $this->add_control(
            'rea_video_popup_start_time',
            array(
            'label'       => esc_html__('Start Time', 'responsive-elementor-addons'),
            'type'        => Controls_Manager::NUMBER,
            'input_type'  => 'number',
            'placeholder' => '',
            'default'     => '0',
            'condition'   => array( 'rea_video_popup_type' => 'youtube' ),
            )
        );

        $this->add_control(
            'rea_video_popup_end_time',
            array(
            'label'       => esc_html__('End Time', 'responsive-elementor-addons'),
            'type'        => Controls_Manager::NUMBER,
            'input_type'  => 'number',
            'placeholder' => '',
            'default'     => '',
            'condition'   => array( 'rea_video_popup_type' => 'youtube' ),
            )
        );

        $this->add_control(
            'rea_video_popup_auto_play',
            array(
            'label'        => esc_html__('Auto Play', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'responsive-elementor-addons'),
            'label_off'    => esc_html__('No', 'responsive-elementor-addons'),
            'return_value' => '1',
            'default'      => 'yes',
            )
        );

        $this->add_control(
            'rea_video_popup_mute',
            array(
            'label'        => esc_html__('Mute', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'responsive-elementor-addons'),
            'label_off'    => esc_html__('No', 'responsive-elementor-addons'),
            'return_value' => '1',
            'default'      => 'no',
            )
        );

        $this->add_control(
            'rea_video_popup_video_loop',
            array(
            'label'        => esc_html__('Loop', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'responsive-elementor-addons'),
            'label_off'    => esc_html__('No', 'responsive-elementor-addons'),
            'return_value' => '1',
            'default'      => 'no',
            )
        );

        $this->add_control(
            'rea_video_popup_video_player_control',
            array(
            'label'        => esc_html__('Player Control', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'responsive-elementor-addons'),
            'label_off'    => esc_html__('No', 'responsive-elementor-addons'),
            'return_value' => '1',
            'default'      => 'no',
            )
        );

        $this->add_control(
            'rea_video_popup_video_intro_title',
            array(
            'label'        => esc_html__('Intro Title', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'responsive-elementor-addons'),
            'label_off'    => esc_html__('No', 'responsive-elementor-addons'),
            'return_value' => '1',
            'default'      => 'no',
            'condition'    => array( 'rea_video_popup_type' => 'vimeo' ),
            )
        );

        $this->add_control(
            'rea_video_popup_video_intro_portrait',
            array(
            'label'        => esc_html__('Intro Portrait', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'responsive-elementor-addons'),
            'label_off'    => esc_html__('No', 'responsive-elementor-addons'),
            'return_value' => '1',
            'default'      => 'no',
            'condition'    => array( 'rea_video_popup_type' => 'vimeo' ),
            )
        );

        $this->add_control(
            'rea_video_popup_video_intro_byline',
            array(
            'label'        => esc_html__('Intro Byline', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Yes', 'responsive-elementor-addons'),
            'label_off'    => esc_html__('No', 'responsive-elementor-addons'),
            'return_value' => '1',
            'default'      => 'no',
            'condition'    => array( 'rea_video_popup_type' => 'vimeo' ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'rea_video_popup_style_section',
            array(
            'label' => esc_html__('Wrapper Style', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'ekit_video_popup_title_align',
            array(
            'label'     => esc_html__('Alignment', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => array(

            'left'    => array(
            'title' => esc_html__('Left', 'responsive-elementor-addons'),
            'icon'  => 'fa fa-align-left',
                    ),
                    'center'  => array(
                        'title' => esc_html__('Center', 'responsive-elementor-addons'),
                        'icon'  => 'fa fa-align-center',
                    ),
                    'right'   => array(
                        'title' => esc_html__('Right', 'responsive-elementor-addons'),
                        'icon'  => 'fa fa-align-right',
                    ),
                    'justify' => array(
                        'title' => esc_html__('Justified', 'responsive-elementor-addons'),
                        'icon'  => 'fa fa-align-justify',
                    ),
            ),
            'default'   => 'center',
            'selectors' => array(
                    '{{WRAPPER}} .rea-video-content' => 'text-align: {{VALUE}};',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_video_wrap_padding',
            array(
            'label'      => esc_html__('Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'selectors'  => array(
            '{{WRAPPER}} .rea-video-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
            'name'     => 'rea_video_wrap_border',
            'label'    => esc_html__('Border', 'responsive-elementor-addons'),
            'selector' => '{{WRAPPER}} .rea-video-content',
            )
        );

        $this->add_control(
            'rea_video_wrap_border_radius',
            array(
            'label'      => esc_html__('Border Radius', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'selectors'  => array(
            '{{WRAPPER}} .rea-video-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'rea_video_popup_section_style',
            array(
            'label' => esc_html__('Button Style', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'rea_video_popup_text_padding',
            array(
            'label'      => esc_html__('Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
            '{{WRAPPER}} .rea-video-popup-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_video_popup_icon_size',
            array(
            'label'      => esc_html__('Icon Size', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
            'px' => array(
            'min'  => 1,
            'max'  => 100,
            'step' => 5,
                    ),
                    '%'  => array(
                        'min' => 1,
                        'max' => 100,
                    ),
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .rea-video-popup-btn i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .rea-video-popup-btn svg' => 'max-width: {{SIZE}}{{UNIT}};',
            ),
            )
        );

        $this->add_control(
            'rea_video_popup_btn_use_height_and_width',
            array(
            'label'        => esc_html__('Use height width', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => esc_html__('Show', 'responsive-elementor-addons'),
            'label_off'    => esc_html__('Hide', 'responsive-elementor-addons'),
            'return_value' => 'yes',
            'default'      => 'yes',
            )
        );

        $this->add_responsive_control(
            'rea_video_popup_btn_width',
            array(
            'label'      => esc_html__('Width', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
            'px' => array(
            'min'  => 30,
            'max'  => 200,
            'step' => 1,
                    ),
                    '%'  => array(
                        'min' => 10,
                        'max' => 100,
                    ),
            ),
            'default'    => array(
                    'unit' => 'px',
                    'size' => 60,
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .rea-video-popup-btn' => 'width: {{SIZE}}{{UNIT}};',
            ),
            'condition'  => array(
                    'rea_video_popup_btn_use_height_and_width' => 'yes',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_video_popup_btn_height',
            array(
            'label'      => esc_html__('Height', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
            'px' => array(
            'min'  => 30,
            'max'  => 200,
            'step' => 1,
                    ),
                    '%'  => array(
                        'min' => 10,
                        'max' => 100,
                    ),
            ),
            'default'    => array(
                    'unit' => 'px',
                    'size' => 60,
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .rea-video-popup-btn' => 'height: {{SIZE}}{{UNIT}};',
            ),
            'condition'  => array(
                    'rea_video_popup_btn_use_height_and_width' => 'yes',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_video_popup_btn_line_height',
            array(
            'label'      => esc_html__('Line height', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
            'px' => array(
            'min'  => 30,
            'max'  => 200,
            'step' => 1,
                    ),
                    '%'  => array(
                        'min' => 10,
                        'max' => 100,
                    ),
            ),
            'default'    => array(
                    'unit' => 'px',
                    'size' => 45,
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .rea-video-popup-btn' => 'line-height: {{SIZE}}{{UNIT}};',
            ),
            'condition'  => array(
                    'rea_video_popup_btn_use_height_and_width' => 'yes',
            ),
            )
        );

        $this->add_control(
            'rea_video_popup_btn_glow_color',
            array(
            'label'     => esc_html__('Glow Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-video-popup-btn.glow-btn:before' => 'color: {{VALUE}}',
            '{{WRAPPER}} .rea-video-popup-btn.glow-btn:after' => 'color: {{VALUE}}',
            '{{WRAPPER}} .rea-video-popup-btn.glow-btn > i:after' => 'color: {{VALUE}}',
            ),
            'default'   => '#255cff',
            'condition' => array(
                    'rea_video_glow' => 'yes',
            ),
            )
        );

        $this->start_controls_tabs('rea_video_popup_button_style_tabs');

        $this->start_controls_tab(
            'rea_video_popup_button_normal',
            array(
            'label' => esc_html__('Normal', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'rea_video_popup_btn_text_color',
            array(
            'label'     => esc_html__('Icon Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => array(
            '{{WRAPPER}} .rea-video-popup-btn' => 'color: {{VALUE}};',
            '{{WRAPPER}} .rea-video-popup-btn svg path' => 'stroke: {{VALUE}}; fill: {{VALUE}};',
            ),
            )
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
            'name'     => 'rea_video_popup_btn_bg_color',
            'default'  => '',
            'selector' => '{{WRAPPER}} .rea-video-popup-btn',
            )
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'rea_video_popup_btn_tab_button_hover',
            array(
            'label' => esc_html__('Hover', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'rea_video_popup_btn_hover_color',
            array(
            'label'     => esc_html__('Icon Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => array(
            '{{WRAPPER}} .rea-video-popup-btn:hover' => 'color: {{VALUE}};',
            '{{WRAPPER}} .rea-video-popup-btn:hover svg path'   => 'stroke: {{VALUE}}; fill: {{VALUE}};',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
            'name'     => 'rea_video_popup_btn_bg_hover_color',
            'default'  => '',
            'selector' => '{{WRAPPER}} .rea-video-popup-btn:hover',
            )
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'rea_video_popup_border_style',
            array(
            'label' => esc_html__('Border Style', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'rea_video_popup_btn_border_style',
            array(
            'label'     => esc_html_x('Border Type', 'Border Control', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SELECT,
            'options'   => array(
            ''       => esc_html__('None', 'responsive-elementor-addons'),
            'solid'  => esc_html_x('Solid', 'Border Control', 'responsive-elementor-addons'),
            'double' => esc_html_x('Double', 'Border Control', 'responsive-elementor-addons'),
            'dotted' => esc_html_x('Dotted', 'Border Control', 'responsive-elementor-addons'),
            'dashed' => esc_html_x('Dashed', 'Border Control', 'responsive-elementor-addons'),
            'groove' => esc_html_x('Groove', 'Border Control', 'responsive-elementor-addons'),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-video-popup-btn' => 'border-style: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'rea_video_popup_btn_border_dimensions',
            array(
            'label'     => esc_html_x('Width', 'Border Control', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::DIMENSIONS,
            'selectors' => array(
            '{{WRAPPER}} .rea-video-popup-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );
        $this->start_controls_tabs('rea_video_popup__button_border_style');
        $this->start_controls_tab(
            'rea_video_popup__button_border_normal',
            array(
            'label' => esc_html__('Normal', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'rea_video_popup_btn_border_color',
            array(
            'label'     => esc_html_x('Color', 'Border Control', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => array(
            '{{WRAPPER}} .rea-video-popup-btn' => 'border-color: {{VALUE}};',
            ),
            )
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'rea_video_popup_btn_tab_button_border_hover',
            array(
            'label' => esc_html__('Hover', 'responsive-elementor-addons'),
            )
        );
        $this->add_control(
            'rea_video_popup_btn_hover_border_color',
            array(
            'label'     => esc_html_x('Color', 'Border Control', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => array(
            '{{WRAPPER}} .rea-video-popup-btn:hover' => 'border-color: {{VALUE}};',
            ),
            )
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->add_responsive_control(
            'rea_video_popup_btn_border_radius',
            array(
            'label'      => esc_html__('Border Radius', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'default'    => array(
            'top'    => '',
            'right'  => '',
            'bottom' => '',
            'left'   => '',
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .rea-video-popup-btn, {{WRAPPER}} .rea-video-popup-btn:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'rea_video_popup_box_shadow_style',
            array(
            'label' => esc_html__('Shadow Style', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
            'name'     => 'rea_video_popup_btn_box_shadow',
            'label'    => esc_html__('Box Shadow', 'responsive-elementor-addons'),
            'selector' => '{{WRAPPER}} .rea-video-popup-btn',
            )
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            array(
            'name'     => 'rea_video_popup_btn_text_shadow',
            'label'    => esc_html__('Text Shadow', 'responsive-elementor-addons'),
            'selector' => '{{WRAPPER}} .rea-video-popup-btn',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'rea_video_popup_icon_style',
            array(
            'label'     => esc_html__('Icon', 'responsive-elementor-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => array(
            'rea_video_popup_button_icons__switch' => 'yes',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_video_popup_icon_padding_right',
            array(
            'label'      => esc_html__('Padding Right', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
            'px' => array(
            'min'  => 0,
            'max'  => 200,
            'step' => 1,
                    ),
                    '%'  => array(
                        'min' => 0,
                        'max' => 100,
                    ),
            ),
            'default'    => array(
                    'unit' => 'px',
                    'size' => 5,
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .rea-video-popup-btn > i' => 'padding-right: {{SIZE}}{{UNIT}};',
            ),
            'condition'  => array(
                    'rea_video_popup_icon_align' => 'before',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_video_popup_icon_padding_left',
            array(
            'label'      => esc_html__('Padding Left', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
            'px' => array(
            'min'  => 0,
            'max'  => 200,
            'step' => 1,
                    ),
                    '%'  => array(
                        'min' => 0,
                        'max' => 100,
                    ),
            ),
            'default'    => array(
                    'unit' => 'px',
                    'size' => 5,
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .rea-video-popup-btn > i' => 'padding-left: {{SIZE}}{{UNIT}};',
            ),
            'condition'  => array(
                    'rea_video_popup_icon_align' => 'after',
            ),
            )
        );

        $this->end_controls_section();

    }

    /**
     * Render video widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings                   = $this->get_settings_for_display();
        $rea_video_popup_auto_play  = $settings['rea_video_popup_auto_play'];
        $rea_video_popup_video_loop = $settings['rea_video_popup_video_loop'];
        if (1 === $settings['rea_video_popup_video_player_control'] ) {
            $rea_video_popup_video_player_control = 1;
        } else {
            $rea_video_popup_video_player_control = 0;
        }
        $rea_video_popup_video_mute   = $settings['rea_video_popup_mute'];
        $rea_video_popup_start_time   = $settings['rea_video_popup_start_time'];
        $rea_video_popup_end_time     = $settings['rea_video_popup_end_time'];
        $rea_video_popup_url          = $settings['rea_video_popup_url'];
        $rea_video_glow               = $settings['rea_video_glow'];
        $rea_video_popup_button_icons = $settings['rea_video_popup_button_icons'];

        $rea_video_url = $rea_video_popup_url . "?autoplay={$rea_video_popup_auto_play}&loop={$rea_video_popup_video_loop}&controls={$rea_video_popup_video_player_control}&mute={$rea_video_popup_video_mute}&start={$rea_video_popup_start_time}&end={$rea_video_popup_end_time}&version=3";
        ?>
        <div class="rea-video-content">
            <a href="<?php echo esc_url($rea_video_url); ?>" class="rea-video-popup rea-video-popup-btn <?php echo esc_attr('yes' === $rea_video_glow ? 'glow-btn' : ''); ?>">
        <?php if ('' !== $rea_video_popup_button_icons ) : ?>
            <?php
            $settings = $this->get_settings_for_display();

            // new icon.
            $migrated = isset($settings['__fa4_migrated']['rea_video_popup_button_icons']);
            // Check if its a new widget without previously selected icon using the old Icon control.
            $is_new = empty($settings['rea_video_popup_button_icon']);
            if ($is_new || $migrated ) {
                // new icon.
                Icons_Manager::render_icon($settings['rea_video_popup_button_icons'], array( 'aria-hidden' => 'true' ));
            } else {
                ?>
                            <i class="<?php echo esc_attr($settings['rea_video_popup_button_icon']); ?>" aria-hidden="true"></i>
                <?php
            }
            ?>
        <?php endif; ?>
            </a>
        </div>
        <?php
    }

}
