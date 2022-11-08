<?php
/**
 * REA Skin Base.
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Widgets\Skins;

use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Skin_Base as Elementor_Skin_Base;
use Elementor\Widget_Base;
use Elementor\Plugin;

if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}
/**
 * REA Skin base Extending Elementor Skin Base.
 *
 * An abstract class to register new skins for Elementor widgets. Skins allows
 * you to add new templates, set custom controls and more.
 *
 * @since 1.0.0
 */
abstract class REA_Skin_Base extends Elementor_Skin_Base
{

    /**
     * Current Permalink
     *
     * @var string Save current permalink to avoid conflict with plugins the filters the permalink during the post render.
     */
    protected $current_permalink;

    /**
     * Register skin controls actions.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls_actions()
    {
        add_action('elementor/element/rea-posts/section_layout/before_section_end', array( $this, 'registerControls' ));
        add_action('elementor/element/rea-posts/rea_section_query/after_section_end', array( $this, 'register_style_sections' ));
    }

    /**
     * Register skin style section.
     *
     * @param  Widget_Base $widget Widget.
     * @since  1.0.0
     * @access protected
     */
    public function register_style_sections( Widget_Base $widget )
    {
        $this->parent = $widget;

        $this->register_design_controls();
    }

    /**
     * Regsiter Design Controls
     *
     * @return void
     */
    public function register_design_controls()
    {
        $this->register_design_layout_controls();
        $this->register_design_image_controls();
        $this->register_design_content_controls();
    }

    /**
     * Register skin base controls
     *
     * @param  Widget_Base $widget Widget.
     * @return void
     */
    public function registerControls( Widget_Base $widget )
    {
        $this->parent = $widget;

        $this->register_columns_controls();
        $this->register_post_count_control();
        $this->register_thumbnail_controls();
        $this->register_title_controls();
        $this->register_excerpt_controls();
        $this->register_meta_data_controls();
        $this->register_read_more_controls();
        $this->register_link_controls();

        if ('rea-posts' === $this->parent->getName() ) {
            $this->register_data_position_controls();
        }

    }

    /**
     * Register thumbnail controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_thumbnail_controls()
    {
        $this->add_control(
            'thumbnail',
            array(
            'label'        => __('Image Position', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SELECT,
            'default'      => 'top',
            'options'      => array(
            'top'   => __('Top', 'responsive-elementor-addons'),
            'left'  => __('Left', 'responsive-elementor-addons'),
            'right' => __('Right', 'responsive-elementor-addons'),
            'none'  => __('None', 'responsive-elementor-addons'),
            ),
            'prefix_class' => 'elementor-posts--thumbnail-',
            )
        );

        $this->add_control(
            'masonry',
            array(
            'label'              => __('Masonry', 'responsive-elementor-addons'),
            'type'               => Controls_Manager::SWITCHER,
            'label_off'          => __('Off', 'responsive-elementor-addons'),
            'label_on'           => __('On', 'responsive-elementor-addons'),
            'condition'          => array(
            $this->get_control_id('columns!')  => '1',
            $this->get_control_id('thumbnail') => 'top',
            ),
            'render_type'        => 'ui',
            'frontend_available' => true,
            )
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            array(
            'name'         => 'thumbnail_size',
            'default'      => 'medium',
            'exclude'      => array( 'custom' ),
            'condition'    => array(
            $this->get_control_id('thumbnail!') => 'none',
            ),
            'prefix_class' => 'elementor-posts--thumbnail-size-',
            )
        );

        $this->add_responsive_control(
            'item_ratio',
            array(
            'label'          => __('Image Ratio', 'responsive-elementor-addons'),
            'type'           => Controls_Manager::SLIDER,
            'default'        => array(
            'size' => 0.6,
            ),
            'tablet_default' => array(
                    'size' => '',
            ),
            'mobile_default' => array(
                    'size' => 0.5,
            ),
            'range'          => array(
                    'px' => array(
                        'min'  => 0.1,
                        'max'  => 2,
                        'step' => 0.01,
            ),
            ),
            'selectors'      => array(
                    '{{WRAPPER}} .responsive-posts-container .elementor-post__thumbnail' => 'padding-bottom: calc( {{SIZE}} * 100% );',
                    '{{WRAPPER}}:after' => 'content: "{{SIZE}}"; position: absolute; color: transparent;',
            ),
            'condition'      => array(
                    $this->get_control_id('thumbnail!') => 'none',
                    $this->get_control_id('masonry')    => '',
            ),
            )
        );

        $this->add_responsive_control(
            'image_width',
            array(
            'label'          => __('Image Width', 'responsive-elementor-addons'),
            'type'           => Controls_Manager::SLIDER,
            'range'          => array(
            '%'  => array(
            'min' => 10,
            'max' => 100,
                    ),
                    'px' => array(
                        'min' => 10,
                        'max' => 600,
                    ),
            ),
            'default'        => array(
                    'size' => 100,
                    'unit' => '%',
            ),
            'tablet_default' => array(
                    'size' => '',
                    'unit' => '%',
            ),
            'mobile_default' => array(
                    'size' => 100,
                    'unit' => '%',
            ),
            'size_units'     => array( '%', 'px' ),
            'selectors'      => array(
                    '{{WRAPPER}} .responsive-post__thumbnail__link' => 'width: {{SIZE}}{{UNIT}};',
            ),
            'condition'      => array(
                    $this->get_control_id('thumbnail!') => 'none',
            ),
            )
        );
    }

    /**
     * Register coloumns controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_columns_controls()
    {
        $this->add_responsive_control(
            'columns',
            array(
            'label'              => __('Columns', 'responsive-elementor-addons'),
            'type'               => Controls_Manager::SELECT,
            'default'            => '3',
            'tablet_default'     => '2',
            'mobile_default'     => '1',
            'options'            => array(
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            ),
            'prefix_class'       => 'elementor-grid%s-',
            'frontend_available' => true,
            )
        );
    }

    /**
     * Register post count controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_post_count_control()
    {
        $this->add_control(
            'posts_per_page',
            array(
            'label'   => __('Posts Per Page', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::NUMBER,
            'default' => 6,
            )
        );
    }

    /**
     * Register title controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_title_controls()
    {
        $this->add_control(
            'show_title',
            array(
            'label'     => __('Title', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => __('Show', 'responsive-elementor-addons'),
            'label_off' => __('Hide', 'responsive-elementor-addons'),
            'default'   => 'yes',
            'separator' => 'before',
            )
        );

        $this->add_control(
            'title_tag',
            array(
            'label'     => __('Title HTML Tag', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SELECT,
            'options'   => array(
            'h1'   => 'H1',
            'h2'   => 'H2',
            'h3'   => 'H3',
            'h4'   => 'H4',
            'h5'   => 'H5',
            'h6'   => 'H6',
            'div'  => 'div',
            'span' => 'span',
            'p'    => 'p',
            ),
            'default'   => 'h3',
            'condition' => array(
                    $this->get_control_id('show_title') => 'yes',
            ),
            )
        );

    }

    /**
     * Register Excerpt controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_excerpt_controls()
    {
        $this->add_control(
            'show_excerpt',
            array(
            'label'     => __('Excerpt', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => __('Show', 'responsive-elementor-addons'),
            'label_off' => __('Hide', 'responsive-elementor-addons'),
            'default'   => 'yes',
            )
        );

        $this->add_control(
            'excerpt_length',
            array(
            'label'     => __('Excerpt Length', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::NUMBER,
            /**
            * This filter is documented in wp-includes/formatting.php 
            */
            'default'   => apply_filters('excerpt_length', 25),
            'condition' => array(
            $this->get_control_id('show_excerpt') => 'yes',
            ),
            )
        );
    }

    /**
     * Register READ More controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_read_more_controls()
    {
        $this->add_control(
            'show_read_more',
            array(
            'label'     => __('Read More', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => __('Show', 'responsive-elementor-addons'),
            'label_off' => __('Hide', 'responsive-elementor-addons'),
            'default'   => 'yes',
            'separator' => 'before',
            )
        );

        $this->add_control(
            'read_more_text',
            array(
            'label'     => __('Read More Text', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => __('Read More »', 'responsive-elementor-addons'),
            'condition' => array(
            $this->get_control_id('show_read_more') => 'yes',
            ),
            )
        );
    }

    /**
     * Register link controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_link_controls()
    {
        $this->add_control(
            'open_new_tab',
            array(
            'label'       => __('Open in new window', 'responsive-elementor-addons'),
            'type'        => Controls_Manager::SWITCHER,
            'label_on'    => __('Yes', 'responsive-elementor-addons'),
            'label_off'   => __('No', 'responsive-elementor-addons'),
            'default'     => 'no',
            'render_type' => 'none',
            )
        );
    }

    /**
     * Register Data position controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_data_position_controls()
    {
        $position_order = array(
        '0' => __('Select', 'responsive-elementor-addons'),
        '1' => __('One', 'responsive-elementor-addons'),
        '2' => __('Two', 'responsive-elementor-addons'),
        '3' => __('Three', 'responsive-elementor-addons'),
        );

        if ('rea_cards' !== $this->get_id() ) {
            $position_order['4'] = __('Four', 'responsive-elementor-addons');
        }

        $this->add_control(
            'title_position',
            array(
            'label'     => __('Title Position', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SELECT,
            'options'   => $position_order,
            'default'   => '1',
            'condition' => array(
                    $this->get_control_id('show_title') => 'yes',
            ),
            )
        );

        if ('rea_cards' !== $this->get_id() ) {
            $this->add_control(
                'meta_data_position',
                array(
                'label'     => __('Meta Position', 'responsive-elementor-addons'),
                'type'      => Controls_Manager::SELECT,
                'options'   => $position_order,
                'default'   => '2',
                'condition' => array(
                $this->get_control_id('meta_data!') => array(),
                ),
                )
            );
        }

        $this->add_control(
            'excerpt_position',
            array(
            'label'     => __('Excerpt Position', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SELECT,
            'options'   => $position_order,
            'default'   => '3',
            'condition' => array(
                    $this->get_control_id('show_excerpt') => 'yes',
            ),
            )
        );

        $this->add_control(
            'read_more_position',
            array(
            'label'     => __('Read More Position', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SELECT,
            'options'   => $position_order,
            'default'   => '4',
            'condition' => array(
            $this->get_control_id('show_read_more') => 'yes',
            ),
            )
        );
    }

    /**
     * Function to get optional link attribute html.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function get_optional_link_attributes_html()
    {
        $settings                 = $this->parent->get_settings();
        $new_tab_setting_key      = $this->get_control_id('open_new_tab');
        $optional_attributes_html = 'yes' === $settings[ $new_tab_setting_key ] ? 'target="_blank"' : '';

        return $optional_attributes_html;
    }

    /**
     * Register meta data controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_meta_data_controls()
    {
        $this->add_control(
            'meta_data',
            array(
            'label'       => __('Meta Data', 'responsive-elementor-addons'),
            'label_block' => true,
            'type'        => Controls_Manager::SELECT2,
            'default'     => array( 'date', 'comments' ),
            'multiple'    => true,
            'options'     => array(
            'author'   => __('Author', 'responsive-elementor-addons'),
            'date'     => __('Date', 'responsive-elementor-addons'),
            'time'     => __('Time', 'responsive-elementor-addons'),
            'comments' => __('Comments', 'responsive-elementor-addons'),
            ),
            'separator'   => 'before',
            )
        );

        $this->add_control(
            'meta_separator',
            array(
            'label'     => __('Separator Between', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => '///',
            'selectors' => array(
            '{{WRAPPER}} .elementor-post__meta-data span + span:before' => 'content: "{{VALUE}}"',
            ),
            'condition' => array(
                    $this->get_control_id('meta_data!') => array(),
            ),
            )
        );
    }

    /**
     * Style Tab
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_design_layout_controls()
    {
        $this->start_controls_section(
            'section_design_layout',
            array(
            'label' => __('Layout', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'column_gap',
            array(
            'label'     => __('Columns Gap', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'default'   => array(
            'size' => 30,
            ),
            'range'     => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
            ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .responsive-posts-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}',
                    '.elementor-msie {{WRAPPER}} .elementor-post' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 );',
                    '.elementor-msie {{WRAPPER}} .responsive-posts-container' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
            ),
            )
        );

        $this->add_control(
            'row_gap',
            array(
            'label'              => __('Rows Gap', 'responsive-elementor-addons'),
            'type'               => Controls_Manager::SLIDER,
            'default'            => array(
            'size' => 35,
            ),
            'range'              => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
            ),
            ),
            'frontend_available' => true,
            'selectors'          => array(
                    '{{WRAPPER}} .responsive-posts-container' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
                    '.elementor-msie {{WRAPPER}} .elementor-post' => 'padding-bottom: {{SIZE}}{{UNIT}};',
            ),
            )
        );

        $this->add_control(
            'alignment',
            array(
            'label'        => __('Alignment', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::CHOOSE,
            'options'      => array(
            'left'   => array(
            'title' => __('Left', 'responsive-elementor-addons'),
            'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => __('Center', 'responsive-elementor-addons'),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right'  => array(
                        'title' => __('Right', 'responsive-elementor-addons'),
                        'icon'  => 'eicon-text-align-right',
                    ),
            ),
            'prefix_class' => 'elementor-posts--align-',
            )
        );

        $this->end_controls_section();
    }

    /**
     * Register design image controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_design_image_controls()
    {
        $this->start_controls_section(
            'section_design_image',
            array(
            'label'     => __('Image', 'responsive-elementor-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => array(
            $this->get_control_id('thumbnail!') => 'none',
            ),
            )
        );

        $this->add_control(
            'img_border_radius',
            array(
            'label'      => __('Border Radius', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
            '{{WRAPPER}} .elementor-post__thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            'condition'  => array(
                    $this->get_control_id('thumbnail!') => 'none',
            ),
            )
        );

        $this->add_control(
            'image_spacing',
            array(
            'label'     => __('Spacing', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            'px' => array(
            'max' => 100,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}}.elementor-posts--thumbnail-left .responsive-post__thumbnail__link' => 'margin-right: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}}.elementor-posts--thumbnail-right .responsive-post__thumbnail__link' => 'margin-left: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}}.elementor-posts--thumbnail-top .responsive-post__thumbnail__link' => 'margin-bottom: {{SIZE}}{{UNIT}}',
            ),
            'default'   => array(
                    'size' => 20,
            ),
            'condition' => array(
                    $this->get_control_id('thumbnail!') => 'none',
            ),
            )
        );

        $this->start_controls_tabs('thumbnail_effects_tabs');

        $this->start_controls_tab(
            'normal',
            array(
            'label' => __('Normal', 'responsive-elementor-addons'),
            )
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            array(
            'name'     => 'thumbnail_filters',
            'selector' => '{{WRAPPER}} .elementor-post__thumbnail img',
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'hover',
            array(
            'label' => __('Hover', 'responsive-elementor-addons'),
            )
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            array(
            'name'     => 'thumbnail_hover_filters',
            'selector' => '{{WRAPPER}} .elementor-post:hover .elementor-post__thumbnail img',
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Register desgin content controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_design_content_controls()
    {
        $this->start_controls_section(
            'section_design_content',
            array(
            'label' => __('Content', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'heading_title_style',
            array(
            'label'     => __('Title', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'condition' => array(
            $this->get_control_id('show_title') => 'yes',
            ),
            )
        );

        $this->add_control(
            'title_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => array(
            'type'  => Schemes\Color::get_type(),
            'value' => Schemes\Color::COLOR_2,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-post__title, {{WRAPPER}} .elementor-post__title a' => 'color: {{VALUE}};',
            ),
            'condition' => array(
                    $this->get_control_id('show_title') => 'yes',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'      => 'title_typography',
            'scheme'    => Schemes\Typography::TYPOGRAPHY_1,
            'selector'  => '{{WRAPPER}} .elementor-post__title, {{WRAPPER}} .elementor-post__title a',
            'condition' => array(
            $this->get_control_id('show_title') => 'yes',
            ),
            )
        );

        $this->add_control(
            'title_spacing',
            array(
            'label'     => __('Spacing', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            'px' => array(
            'max' => 100,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-post__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ),
            'condition' => array(
                    $this->get_control_id('show_title') => 'yes',
            ),
            )
        );

        $this->add_control(
            'heading_meta_style',
            array(
            'label'     => __('Meta', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            $this->get_control_id('meta_data!') => array(),
            ),
            )
        );

        $this->add_control(
            'meta_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .elementor-post__meta-data' => 'color: {{VALUE}};',
            ),
            'condition' => array(
                    $this->get_control_id('meta_data!') => array(),
            ),
            )
        );

        $this->add_control(
            'meta_separator_color',
            array(
            'label'     => __('Separator Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .elementor-post__meta-data span:before' => 'color: {{VALUE}};',
            ),
            'condition' => array(
                    $this->get_control_id('meta_data!') => array(),
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'      => 'meta_typography',
            'scheme'    => Schemes\Typography::TYPOGRAPHY_2,
            'selector'  => '{{WRAPPER}} .elementor-post__meta-data',
            'condition' => array(
            $this->get_control_id('meta_data!') => array(),
            ),
            )
        );

        $this->add_control(
            'meta_spacing',
            array(
            'label'     => __('Spacing', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            'px' => array(
            'max' => 100,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-post__meta-data' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ),
            'condition' => array(
                    $this->get_control_id('meta_data!') => array(),
            ),
            )
        );

        $this->add_control(
            'heading_excerpt_style',
            array(
            'label'     => __('Excerpt', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            $this->get_control_id('show_excerpt') => 'yes',
            ),
            )
        );

        $this->add_control(
            'excerpt_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .elementor-post__excerpt p' => 'color: {{VALUE}};',
            ),
            'condition' => array(
                    $this->get_control_id('show_excerpt') => 'yes',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'      => 'excerpt_typography',
            'scheme'    => Schemes\Typography::TYPOGRAPHY_3,
            'selector'  => '{{WRAPPER}} .elementor-post__excerpt p',
            'condition' => array(
            $this->get_control_id('show_excerpt') => 'yes',
            ),
            )
        );

        $this->add_control(
            'excerpt_spacing',
            array(
            'label'     => __('Spacing', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            'px' => array(
            'max' => 100,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-post__excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ),
            'condition' => array(
                    $this->get_control_id('show_excerpt') => 'yes',
            ),
            )
        );

        $this->add_control(
            'heading_readmore_style',
            array(
            'label'     => __('Read More', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            $this->get_control_id('show_read_more') => 'yes',
            ),
            )
        );

        $this->add_control(
            'read_more_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => array(
            'type'  => Schemes\Color::get_type(),
            'value' => Schemes\Color::COLOR_4,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-post__read-more' => 'color: {{VALUE}};',
            ),
            'condition' => array(
                    $this->get_control_id('show_read_more') => 'yes',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'      => 'read_more_typography',
            'selector'  => '{{WRAPPER}} .elementor-post__read-more',
            'scheme'    => Schemes\Typography::TYPOGRAPHY_4,
            'condition' => array(
            $this->get_control_id('show_read_more') => 'yes',
            ),
            )
        );

        $this->add_control(
            'read_more_spacing',
            array(
            'label'     => __('Spacing', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            'px' => array(
            'max' => 100,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-post__text' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ),
            'condition' => array(
                    $this->get_control_id('show_read_more') => 'yes',
            ),
            )
        );

        $this->end_controls_section();
    }

    /**
     * Render skin.
     *
     * Generates the final HTML on the frontend.
     *
     * @since    1.0.0
     * @access   public
     * @abstract
     */
    public function render()
    {
        $this->parent->query_posts();

        /**
         * Query
         *
         *  @var \WP_Query $query 
*/
        $query = $this->parent->get_query();

        if (! $query->found_posts ) {
            return;
        }

        $this->render_loop_header();

        // It's the global `wp_query` it self. and the loop was started from the theme.
        if ($query->in_the_loop ) {
            $this->current_permalink = get_permalink();
            $this->render_post();
        } else {
            while ( $query->have_posts() ) {
                $query->the_post();

                $this->current_permalink = get_permalink();
                $this->render_post();
            }
        }

        wp_reset_postdata();

        $this->render_loop_footer();

    }

    /**
     * Filter excerpt Length.
     *
     * @since    1.0.0
     * @access   public
     * @abstract
     */
    public function filter_excerpt_length()
    {
        return $this->get_instance_value('excerpt_length');
    }

    /**
     * Filter excerpt Length.
     *
     * @param    mixed $more More.
     * @since    1.0.0
     * @access   public
     * @abstract
     */
    public function filter_excerpt_more( $more )
    {
        return '';
    }

    /**
     * Get Container Class.
     *
     * @since    1.0.0
     * @access   public
     * @abstract
     */
    public function get_container_class()
    {
        return 'elementor-posts--skin-' . $this->get_id();
    }

    /**
     * Render Thumbnail.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_thumbnail()
    {
        $thumbnail = $this->get_instance_value('thumbnail');

        if ('none' === $thumbnail && ! Plugin::instance()->editor->is_edit_mode() ) {
            return;
        }

        $settings                 = $this->parent->get_settings();
        $setting_key              = $this->get_control_id('thumbnail_size');
        $settings[ $setting_key ] = array(
        'id' => get_post_thumbnail_id(),
        );
        $thumbnail_html           = Group_Control_Image_Size::get_attachment_image_html($settings, $setting_key);

        if (empty($thumbnail_html) ) {
            return;
        }

        $optional_attributes_html = $this->get_optional_link_attributes_html();

        ?>
        <a class="responsive-post__thumbnail__link" href="<?php echo wp_kses_post($this->current_permalink); ?>" <?php echo wp_kses_post($optional_attributes_html); ?>>
            <div class="elementor-post__thumbnail"><?php echo wp_kses_post($thumbnail_html); ?></div>
        </a>
        <?php
    }

    /**
     * Render title.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_title()
    {
        if (! $this->get_instance_value('show_title') ) {
            return;
        }

        $optional_attributes_html = $this->get_optional_link_attributes_html();

        $tag = $this->get_instance_value('title_tag');
        ?>
        <<?php echo wp_kses_post($tag); ?> class="elementor-post__title">
        <a href="<?php echo wp_kses_post($this->current_permalink); ?>" <?php echo wp_kses_post($optional_attributes_html); ?>>
        <?php the_title(); ?>
        </a>
        </<?php echo wp_kses_post($tag); ?>>
        <?php
    }

    /**
     * Render Excerpt.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_excerpt()
    {
        add_filter('excerpt_more', array( $this, 'filter_excerpt_more' ), 20);
        add_filter('excerpt_length', array( $this, 'filter_excerpt_length' ), 20);

        if (! $this->get_instance_value('show_excerpt') ) {
            return;
        }

        add_filter('excerpt_more', array( $this, 'filter_excerpt_more' ), 20);
        add_filter('excerpt_length', array( $this, 'filter_excerpt_length' ), 20);

        ?>
        <div class="elementor-post__excerpt">
        <?php the_excerpt(); ?>
        </div>
        <?php

        remove_filter('excerpt_length', array( $this, 'filter_excerpt_length' ), 20);
        remove_filter('excerpt_more', array( $this, 'filter_excerpt_more' ), 20);
    }

    /**
     * Render read more.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_read_more()
    {
        if (! $this->get_instance_value('show_read_more') ) {
            return;
        }

        $optional_attributes_html = $this->get_optional_link_attributes_html();

        ?>
        <a class="elementor-post__read-more" href="<?php echo wp_kses_post($this->current_permalink); ?>" <?php echo wp_kses_post($optional_attributes_html); ?>>
        <?php echo wp_kses_post($this->get_instance_value('read_more_text')); ?>
        </a>
        <?php
    }

    /**
     * Render Post header.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_post_header()
    {
        ?>
        <article <?php post_class(array( 'elementor-post elementor-grid-item' )); ?>>
        <?php
    }

    /**
     * Render Post Footer.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_post_footer()
    {
        ?>
        </article>
        <?php
    }

    /**
     * Render Text Header.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_text_header()
    {
        ?>
        <div class="elementor-post__text">
        <?php
    }

    /**
     * Render Text Footer.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_text_footer()
    {
        ?>
        </div>
        <?php
    }

    /**
     * Render loop header.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_loop_header()
    {
        $classes = array(
        'responsive-posts-container',
        'responsive-posts',
        $this->get_container_class(),
        );

        /**
         * WP_Query
         *
         * @var \WP_Query $wp_query 
*/
        $wp_query = $this->parent->get_query();

        // Use grid only if found posts.
        if ($wp_query->found_posts ) {
            $classes[] = 'elementor-grid';
        }

        $this->parent->add_render_attribute(
            'container',
            array(
            'class' => $classes,
            )
        );

        ?>
        <div <?php echo wp_kses_post($this->parent->get_render_attribute_string('container')); ?>>
        <?php
    }

    /**
     * Render Loop footer.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_loop_footer()
    {
        ?>
        </div>
        <?php

        $parent_settings = $this->parent->get_settings();
        if ('' === $parent_settings['pagination_type'] ) {
            return;
        }

        $page_limit = $this->parent->get_query()->max_num_pages;
        if ('' !== $parent_settings['pagination_page_limit'] ) {
            $page_limit = min($parent_settings['pagination_page_limit'], $page_limit);
        }

        if (2 > $page_limit ) {
            return;
        }

        $this->parent->add_render_attribute('pagination', 'class', 'elementor-pagination');

        $has_numbers   = in_array($parent_settings['pagination_type'], array( 'numbers', 'numbers_and_prev_next' ), true);
        $has_prev_next = in_array($parent_settings['pagination_type'], array( 'prev_next', 'numbers_and_prev_next' ), true);

        $links = array();

        if ($has_numbers ) {
            $paginate_args = array(
            'type'               => 'array',
            'current'            => $this->parent->get_current_page(),
            'total'              => $page_limit,
            'prev_next'          => false,
            'show_all'           => 'yes' !== $parent_settings['pagination_numbers_shorten'],
            'before_page_number' => '<span class="elementor-screen-only">' . __('Page', 'responsive-elementor-addons') . '</span>',
            );

            if (is_singular() && ! is_front_page() ) {
                global $wp_rewrite;
                if ($wp_rewrite->using_permalinks() ) {
                    $paginate_args['base']   = trailingslashit(get_permalink()) . '%_%';
                    $paginate_args['format'] = user_trailingslashit('%#%', 'single_paged');
                } else {
                    $paginate_args['format'] = '?page=%#%';
                }
            }

            $links = paginate_links($paginate_args);
        }

        if ($has_prev_next ) {
            $prev_next = $this->parent->get_posts_nav_link($page_limit);
            array_unshift($links, $prev_next['prev']);
            $links[] = $prev_next['next'];
        }

        ?>
        <nav class="elementor-pagination" role="navigation" aria-label="<?php esc_attr_e('Pagination', 'responsive-elementor-addons'); ?>">
        <?php echo wp_kses_post(implode(PHP_EOL, $links)); ?>
        </nav>
        <?php
    }

    /**
     * Render Meta Data.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_meta_data()
    {
        /**
         * Settings array
         *
         * @var array $settings e.g. [ 'author', 'date', ... ] 
*/
        $settings = $this->get_instance_value('meta_data');
        if (empty($settings) ) {
            return;
        }
        ?>
        <div class="elementor-post__meta-data">
        <?php
        if (in_array('author', $settings, true) ) {
            $this->render_author();
        }

        if (in_array('date', $settings, true) ) {
            $this->render_date();
        }

        if (in_array('time', $settings, true) ) {
            $this->render_time();
        }

        if (in_array('comments', $settings, true) ) {
            $this->render_comments();
        }
        ?>
        </div>
        <?php
    }
    /**
     * Render author.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_author()
    {
        ?>
        <span class="elementor-post-author">
        <?php the_author(); ?>
        </span>
        <?php
    }

    /**
     * Render date.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_date()
    {
        ?>
        <span class="elementor-post-date">
        <?php
        /**
         * This filter is documented in wp-includes/general-template.php 
         */
        echo wp_kses_post(apply_filters('the_date', get_the_date(), get_option('date_format'), '', ''));
        ?>
        </span>
        <?php
    }

    /**
     * Render Time.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_time()
    {
        ?>
        <span class="elementor-post-time">
        <?php the_time(); ?>
        </span>
        <?php
    }

    /**
     * Render Comments.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_comments()
    {
        ?>
        <span class="elementor-post-avatar">
        <?php comments_number(); ?>
        </span>
        <?php
    }

    /**
     * Render Post.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_post()
    {
        $content_positions_key = array(
        empty($this->get_instance_value('title_position')) ? 0 : $this->get_instance_value('title_position'),
        empty($this->get_instance_value('meta_data_position')) ? 0 : $this->get_instance_value('meta_data_position'),
        empty($this->get_instance_value('excerpt_position')) ? 0 : $this->get_instance_value('excerpt_position'),
        empty($this->get_instance_value('read_more_position')) ? 0 : $this->get_instance_value('read_more_position'),
        );

        $content_positions_value = array(
        'render_title',
        'render_meta_data',
        'render_excerpt',
        'render_read_more',
        );

        $positions = array_combine($content_positions_key, $content_positions_value);
        ksort($positions);

        $this->render_post_header();
        $this->render_thumbnail();
        $this->render_text_header();

        foreach ( $positions as $key => $value ) {
            if (0 !== $key ) {
                $this->$value();
            }
        }

        $this->render_text_footer();
        $this->render_post_footer();
    }

    /**
     * Render AMp.
     *
     * @since  1.0.0
     * @access public
     */
    public function render_amp()
    {

    }
}
