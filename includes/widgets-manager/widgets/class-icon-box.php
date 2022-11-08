<?php
/**
 * Icon Box Widget
 *
 * @category Widget
 * @package  Responsive_Elementor_Addons
 * @author   CyberChimps <support@cyberchimps.com>
 * @link     https://www.cyberchimps.com
 * @since    1.2.0
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Icons_Manager;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;

if (! defined('ABSPATH') ) {
    exit;
}

/**
 * Elementor 'Icon Box' widget class.
 *
 * @category Widget
 * @package  Responsive_Elementor_Addons
 * @author   CyberChimps <support@cyberchimps.com>
 * @link     https://www.cyberchimps.com
 * @since    1.2.0
 */
class ReaIconbox extends Widget_Base
{

    /**
     * Retrieve the widget name.
     *
     * @since  1.2.0
     * @access public
     *
     * @return string Widget name.
     */
    public function getName()
    {
        return 'rea-info-box';
    }

    /**
     * Retrieve the widget title.
     *
     * @since  1.2.0
     * @access public
     *
     * @return string Widget title.
     */
    public function getTitle()
    {
        return __('REA Icon Box', 'responsive-elementor-addons');
    }

    /**
     * Get widget icon.
     *
     * Retrieve slider widget icon.
     *
     * @since  1.2.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function getIcon()
    {
        return 'eicon-icon-box rea-badge';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the icon box widget belongs to.
     *
     * @since  1.2.0
     * @access public
     *
     * @return array Widget categories.
     */
    public function getCategories()
    {
        return array( 'responsive-elementor-addon' );
    }

    /**
     * Get Custom help URL
     *
     * @return string help URL
     */
    public function getCustomHelpUrl()
    {
        return 'https://docs.cyberchimps.com/responsive-elementor-addons/rea-icon-box';
    }

    /**
     * Register all the control settings for the icon box
     *
     * @since  1.2.0
     * @access public
     * @return void
     */
    protected function registerControls()     // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
    {
        // Content Section.
        $this->register_general_content_controls();
        $this->register_imgicon_content_controls();
        $this->register_separator_content_controls();
        $this->register_cta_content_controls();

        // Style Section.
        $this->register_infobox_container_style_controls();
        $this->register_icon_style_controls();
        $this->register_typography_style_controls();
        $this->register_button_style_controls();
        $this->register_seperator_style_controls();
        $this->register_margin_style_controls();
    }

    /**
     * Add General controls section under the Content TAB
     *
     * @since  1.2.0
     * @access public
     * @return void
     */
    public function register_general_content_controls()
    {
        $this->start_controls_section(
            'rea_general_section',
            array(
            'label' => __('General', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'rea_title',
            array(
            'label' => __('Title', 'responsive-elementor-addons'),
            'type' => Controls_Manager::TEXT,
            'selector' => '{{WRAPPER}} .rea-infobox__title',
            'dynamic' => array(
            'active' => true,
            ),
            'default' => __('Icon Box', 'responsive-elementor-addons'),
            )
        );
        $this->add_control(
            'rea_description',
            array(
            'label' => __('Description', 'responsive-elementor-addons'),
            'type' => Controls_Manager::TEXTAREA,
            'selector' => '{{WRAPPER}} .rea-infobox__description',
            'dynamic' => array(
            'active' => true,
            ),
            'default' => __('Enter description text here.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.​', 'responsive-elementor-addons'),
            )
        );

        $this->end_controls_section();
    }

    /**
     * Add Image/Icon controls section under the Content TAB
     *
     * @since  1.2.0
     * @access public
     */
    public function register_imgicon_content_controls()
    {
        $this->start_controls_section(
            'rea_imageicon_section',
            array(
            'label' => __('Image/Icon', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'rea_image_type',
            array(
            'label' => __('Image Type', 'responsive-elementor-addons'),
            'type' => Controls_Manager::CHOOSE,
            'options' => array(
            'photo' => array(
            'title' => __('Image', 'responsive-elementor-addons'),
            'icon' => 'fa fa-picture-o',
                    ),
                    'icon' => array(
                        'title' => __('Font Icon', 'responsive-elementor-addons'),
                        'icon' => 'fa fa-info-circle',
                    ),
            ),
            'default' => 'icon',
            'toggle' => true,
            )
        );
        $this->add_control(
            'rea_icon_basics',
            array(
            'label' => __('Icon Basics', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'condition' => array(
            'rea_image_type' => 'icon',
            ),
            )
        );

        if (self::is_elementor_updated() ) {

            $this->add_control(
                'rea_new_select_icon',
                array(
                'label' => __('Select Icon', 'responsive-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'rea_select_icon',
                'default' => array(
                'value' => 'fa fa-star',
                'library' => 'fa-solid',
                ),
                'condition' => array(
                'rea_image_type' => 'icon',
                ),
                'render_type' => 'template',
                )
            );
        } else {
            $this->add_control(
                'rea_select_icon',
                array(
                'label' => __('Select Icon', 'responsive-elementor-addons'),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-star',
                'condition' => array(
                'rea_image_type' => 'icon',
                ),
                )
            );
        }

        $this->add_control(
            'rea_image_basics',
            array(
            'label' => __('Image Basics', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'condition' => array(
                    'rea_image_type' => 'photo',
            ),
            )
        );
        $this->add_control(
            'rea_photo_type',
            array(
            'label' => __('Photo Source', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'media',
            'label_block' => false,
            'options' => array(
            'media' => __('Media Library', 'responsive-elementor-addons'),
            'url' => __('URL', 'responsive-elementor-addons'),
            ),
            'condition' => array(
                    'rea_image_type' => 'photo',
            ),
            )
        );
        $this->add_control(
            'rea_image',
            array(
            'label' => __('Photo', 'responsive-elementor-addons'),
            'type' => Controls_Manager::MEDIA,
            'dynamic' => array(
            'active' => true,
            ),
            'default' => array(
                    'url' => Utils::get_placeholder_image_src(),
            ),
            'condition' => array(
                    'rea_image_type' => 'photo',
                    'rea_photo_type' => 'media',

            ),
            )
        );
        $this->add_control(
            'rea_image_link',
            array(
            'label' => __('Photo URL', 'responsive-elementor-addons'),
            'type' => Controls_Manager::URL,
            'default' => array(
            'url' => '',
            ),
            'show_external' => false, // Show the 'open in new tab' button.
            'condition' => array(
                    'rea_image_type' => 'photo',
                    'rea_photo_type' => 'url',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            array(
            'name' => 'rea_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`phpcs:ignore Squiz.PHP.CommentedOutCode.Found.
            'default' => 'full',
            'separator' => 'none',
            'condition' => array(
            'rea_image_type' => 'photo',
            'rea_photo_type' => 'media',
            ),
            )
        );

        // End of section for Image Background color if custom design enabled.
        $this->end_controls_section();
    }

    /**
     * Check if elementor is updated.
     *
     * @static
     *
     * @since  1.2.0
     * @access public
     *
     * @return boolean
     */
    public static function is_elementor_updated()
    {
        if (class_exists('Elementor\Icons_Manager') ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Return new icon name
     *
     * @static
     *
     * @since  1.2.0
     * @access public
     *
     * @param  string $icon Icon name.
     * @return string New Icon name.
     */
    public static function get_new_icon_name( $icon )
    {
        if (class_exists('Elementor\Icons_Manager') ) {
            return 'rea_new_' . $icon . '[value]';
        } else {
            return 'rea_' . $icon . '[value]';
        }
    }

    /**
     * Add Separator controls section under the Content TAB
     *
     * @since  1.2.0
     * @access public
     */
    public function register_separator_content_controls()
    {
        $this->start_controls_section(
            'rea_separator_section',
            array(
            'label' => __('Separator', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'rea_toggle_separator',
            array(
            'label' => __('Separator', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => __('Yes', 'responsive-elementor-addons'),
            'label_off' => __('No', 'responsive-elementor-addons'),
            'return_value' => 'yes',
            'default' => '',
            )
        );

        $this->end_controls_section();
    }

    /**
     * Add CTA controls section under the Content TAB
     *
     * @since  1.2.0
     * @access public
     */
    public function register_cta_content_controls()
    {
        $this->start_controls_section(
            'rea_cta_section',
            array(
            'label' => __('Call To Action', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'rea_cta_type',
            array(
            'label' => __('Type', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'label_block' => false,
            'options' => array(
            'none' => __('None', 'responsive-elementor-addons'),
            'link' => __('Text', 'responsive-elementor-addons'),
            'button' => __('Button', 'responsive-elementor-addons'),
            'module' => __('Complete Box', 'responsive-elementor-addons'),
            ),
            )
        );

        $this->add_control(
            'rea_link_text',
            array(
            'label' => __('Text', 'responsive-elementor-addons'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Read More', 'responsive-elementor-addons'),
            'dynamic' => array(
            'active' => true,
            ),
            'condition' => array(
                    'rea_cta_type' => 'link',
            ),
            )
        );

        $this->add_control(
            'rea_button_text',
            array(
            'label' => __('Text', 'responsive-elementor-addons'),
            'type' => Controls_Manager::TEXT,
            'default' => __('Click Here', 'responsive-elementor-addons'),
            'dynamic' => array(
            'active' => true,
            ),
            'condition' => array(
                    'rea_cta_type' => 'button',
            ),
            )
        );

        $this->add_control(
            'rea_text_link',
            array(
            'label' => __('Link', 'responsive-elementor-addons'),
            'type' => Controls_Manager::URL,
            'default' => array(
            'url' => '#',
            'is_external' => '',
            ),
            'dynamic' => array(
                    'active' => true,
            ),
            'show_external' => true, // Show the 'open in new tab' button.
            'condition' => array(
                    'rea_cta_type!' => 'none',
            ),
            'selector' => '{{WRAPPER}} a.rea-infobox__cta-link',
            )
        );

        $this->add_control(
            'rea_button_size',
            array(
            'label' => __('Size', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'sm',
            'options' => array(
            'xs' => __('Extra Small', 'responsive-elementor-addons'),
            'sm' => __('Small', 'responsive-elementor-addons'),
            'md' => __('Medium', 'responsive-elementor-addons'),
            'lg' => __('Large', 'responsive-elementor-addons'),
            'xl' => __('Extra Large', 'responsive-elementor-addons'),
            ),
            'condition' => array(
                    'rea_cta_type' => 'button',
            ),
            )
        );

        $this->add_control(
            'rea_icon_structure',
            array(
            'label' => __('Icon', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            'rea_cta_type' => array( 'button', 'link' ),
            ),
            )
        );

        if (self::is_elementor_updated() ) {

            $this->add_control(
                'rea_new_button_icon',
                array(
                'label' => __('Select Icon', 'responsive-elementor-addons'),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'rea_button_icon',
                'condition' => array(
                'rea_cta_type' => array( 'button', 'link' ),
                ),
                'render_type' => 'template',
                )
            );
        } else {
            $this->add_control(
                'rea_button_icon',
                array(
                'label' => __('Select Icon', 'responsive-elementor-addons'),
                'type' => Controls_Manager::ICON,
                'condition' => array(
                'rea_cta_type' => array( 'button', 'link' ),
                ),
                'render_type' => 'template',
                )
            );
        }
        $this->add_control(
            'rea_button_icon_position',
            array(
            'label' => __('Icon Position', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'right',
            'label_block' => false,
            'options' => array(
                    'right' => __('After Text', 'responsive-elementor-addons'),
                    'left' => __('Before Text', 'responsive-elementor-addons'),
            ),
            'condition' => array(
            'rea_cta_type' => array( 'button', 'link' ),
            ),
            )
        );
        $this->add_control(
            'rea_icon_spacing',
            array(
            'label' => __('Icon Spacing', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => array(
            'px' => array(
            'min' => 0,
            'max' => 50,
                    ),
            ),
            'default' => array(
                    'size' => '5',
                    'unit' => 'px',
            ),
            'condition' => array(
                    'rea_cta_type' => array( 'button', 'link' ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-right,{{WRAPPER}} .rea-infobox__link-icon--after' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-button .elementor-align-icon-left, {{WRAPPER}} .rea-infobox__link-icon--before' => 'margin-right: {{SIZE}}{{UNIT}};',
            ),
            )
        );

        $this->end_controls_section();
    }

    public function register_button_style_controls()
    {
        $this->start_controls_section(
            'rea_button_style_section',
            array(
            'label' => __('CTA Button', 'responsive-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            'condition' => array(
            'rea_cta_type' => 'button',
            ),
            )
        );

        $this->add_control(
            'rea_button_colors',
            array(
            'label' => __('Colors', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            )
        );

        $this->start_controls_tabs('rea_tabs_button_style');

        $this->start_controls_tab(
            'rea_button_normal_state',
            array(
            'label' => __('Normal', 'responsive-elementor-addons'),
            )
        );
        $this->add_control(
            'rea_button_text_normal_color',
            array(
            'label' => __('Text Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => array(
            '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button, {{WRAPPER}} .elementor-button-icon' => 'color: {{VALUE}}; fill: {{VALUE}};',
            ),
            )
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
            'name' => 'rea_btn_normal_background_color',
            'label' => __('Background Color', 'responsive-elementor-addons'),
            'types' => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .elementor-button',
            'fields_options' => array(
            'color' => array(
            'scheme' => array(
            'type' => Color::get_type(),
            'value' => Color::COLOR_4,
            ),
                    ),
            ),
            )
        );

        $this->add_control(
            'rea_button_border',
            array(
            'label' => __('Border Style', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'label_block' => false,
            'options' => array(
            'none' => __('None', 'responsive-elementor-addons'),
            'solid' => __('Solid', 'responsive-elementor-addons'),
            'double' => __('Double', 'responsive-elementor-addons'),
            'dotted' => __('Dotted', 'responsive-elementor-addons'),
            'dashed' => __('Dashed', 'responsive-elementor-addons'),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-button' => 'border-style: {{VALUE}};',
            ),
            )
        );
        $this->add_control(
            'rea_button_border_color',
            array(
            'label' => __('Border Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'condition' => array(
            'rea_button_border!' => 'none',
            ),
            'default' => '',
            'selectors' => array(
                    '{{WRAPPER}} .elementor-button' => 'border-color: {{VALUE}};',
            ),
            )
        );
        $this->add_control(
            'rea_button_border_size',
            array(
            'label' => __('Border Width', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'default' => array(
            'top' => '1',
            'bottom' => '1',
            'left' => '1',
            'right' => '1',
            'unit' => 'px',
            ),
            'condition' => array(
                    'rea_cta_type' => 'button',
                    'rea_button_border!' => 'none',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->add_control(
            'rea_button_radius',
            array(
            'label' => __('Rounded Corners', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'default' => array(
            'top' => '0',
            'bottom' => '0',
            'left' => '0',
            'right' => '0',
            'unit' => 'px',
            ),
            'selectors' => array(
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
            'name' => 'rea_button_normal_box_shadow',
            'selector' => '{{WRAPPER}} .elementor-button',
            )
        );

        $this->add_responsive_control(
            'rea_button_custom_padding',
            array(
            'label' => __('Padding', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors' => array(
            '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'rea_button_hover_state',
            array(
            'label' => __('Hover', 'responsive-elementor-addons'),
            )
        );
        $this->add_control(
            'rea_button_hover_color',
            array(
            'label' => __('Text Hover Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
            ),
            )
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
            'name' => 'rea_button_hover_bgcolor',
            'label' => __('Background Hover Color', 'responsive-elementor-addons'),
            'types' => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover',
            'fields_options' => array(
            'color' => array(
            'scheme' => array(
            'type' => Color::get_type(),
            'value' => Color::COLOR_4,
            ),
                    ),
            ),
            )
        );

        $this->add_control(
            'rea_button_border_hover_color',
            array(
            'label' => __('Border Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'condition' => array(
            'rea_button_border!' => 'none',
            ),
            'selectors' => array(
                    '{{WRAPPER}} a.elementor-button:hover, {{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
            'name' => 'rea_cta_hover_box_shadow',
            'label' => __('Box Shadow', 'responsive-elementor-addons'),
            'selector' => '{{WRAPPER}} .rea-infobox-button-wrapper .elementor-button-link:hover',
            )
        );

        $this->add_control(
            'rea_button_animation',
            array(
            'label' => __('Hover Animation', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HOVER_ANIMATION,
            'selector' => '{{WRAPPER}} .elementor-button',
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    public function register_seperator_style_controls()
    {
        $this->start_controls_section(
            'rea_seperator_style_section',
            array(
            'label' => __('Seperator', 'responsive-elementor-addons'),
            'tab'       => Controls_Manager::TAB_STYLE,
            'condition' => array(
            'rea_toggle_separator' => 'yes',
            ),
            )
        );

        $this->add_control(
            'rea_separator_position',
            array(
            'label' => __('Position', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'label_block' => false,
            'default' => 'after_heading',
            'options' => array(
            'after_icon' => __('After Icon', 'responsive-elementor-addons'),
            'after_heading' => __('After Heading', 'responsive-elementor-addons'),
            'after_description' => __('After Description', 'responsive-elementor-addons'),
            ),
            )
        );

        $this->add_control(
            'rea_separator_style',
            array(
            'label' => __('Style', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'solid',
            'label_block' => false,
            'options' => array(
            'solid' => __('Solid', 'responsive-elementor-addons'),
            'dashed' => __('Dashed', 'responsive-elementor-addons'),
            'dotted' => __('Dotted', 'responsive-elementor-addons'),
            'double' => __('Double', 'responsive-elementor-addons'),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__separator' => 'border-top-style: {{VALUE}}; display: inline-block;',
            ),
            )
        );

        $this->add_control(
            'rea_separator_color',
            array(
            'label' => __('Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'scheme' => array(
            'type' => Color::get_type(),
            'value' => Color::COLOR_4,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__separator' => 'border-top-color: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'rea_separator_thickness',
            array(
            'label' => __('Thickness', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em', 'rem' ),
            'range' => array(
            'px' => array(
            'min' => 1,
            'max' => 200,
                    ),
            ),
            'default' => array(
                    'size' => 3,
                    'unit' => 'px',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__separator' => 'border-top-width: {{SIZE}}{{UNIT}};',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_separator_width',
            array(
            'label' => __('Width', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => array( '%', 'px' ),
            'range' => array(
            'px' => array(
            'max' => 1000,
                    ),
            ),
            'default' => array(
                    'size' => 30,
                    'unit' => '%',
            ),
            'tablet_default' => array(
                    'unit' => '%',
            ),
            'mobile_default' => array(
                    'unit' => '%',
            ),
            'label_block' => true,
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__separator' => 'width: {{SIZE}}{{UNIT}};',
            ),
            )
        );

        $this->end_controls_section();
    }

    public function register_icon_style_controls()
    {
        $this->start_controls_section(
            'rea_icon_style_section',
            array(
            'label' => __('Icon', 'responsive-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'rea_icon_size',
            array(
            'label' => __('Size', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em', 'rem' ),
            'range' => array(
            'px' => array(
            'min' => 1,
            'max' => 200,
                    ),
            ),
            'default' => array(
                    'size' => 40,
                    'unit' => 'px',
            ),
            'conditions' => array(
                    'relation' => 'and',
                    'terms' => array(
                        array(
                            'name' => self::get_new_icon_name('select_icon'),
                            'operator' => '!=',
                            'value' => '',
                        ),
                        array(
                            'name' => 'rea_image_type',
                            'operator' => '==',
                            'value' => 'icon',
                        ),
            ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__icon i' => 'font-size: {{SIZE}}{{UNIT}}; text-align: center;',
                    '{{WRAPPER}} .rea-infobox__icon svg' => 'height: {{SIZE}}{{UNIT}}; text-align: center;',
            ),
            )
        );

        $this->add_control(
            'rea_icon_rotate',
            array(
            'label' => __('Rotate', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => array(
            'size' => 0,
            'unit' => 'deg',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__icon i,
					{{WRAPPER}} .rea-infobox__icon svg' => 'transform: rotate({{SIZE}}{{UNIT}});',
            ),
            'conditions' => array(
                    'relation' => 'and',
                    'terms' => array(
                        array(
                            'name' => self::get_new_icon_name('select_icon'),
                            'operator' => '!=',
                            'value' => '',
                        ),
                        array(
                            'name' => 'rea_image_type',
                            'operator' => '==',
                            'value' => 'icon',
                        ),
            ),
            ),
            )
        );

        $this->add_control(
            'rea_image_position',
            array(
            'label' => __('Select Position', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'above-title',
            'label_block' => false,
            'options' => array(
            'above-title' => __('Above Heading', 'responsive-elementor-addons'),
            'below-title' => __('Below Heading', 'responsive-elementor-addons'),
            'left-title' => __('Left of Heading', 'responsive-elementor-addons'),
            'right-title' => __('Right of Heading', 'responsive-elementor-addons'),
            'left' => __('Left of Text and Heading', 'responsive-elementor-addons'),
            'right' => __('Right of Text and Heading', 'responsive-elementor-addons'),
            ),
            )
        );

        $this->add_control(
            'rea_imgicon_style',
            array(
            'label' => __('Image/Icon Style', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'normal',
            'label_block' => false,
            'options' => array(
            'normal' => __('Normal', 'responsive-elementor-addons'),
            'circle' => __('Circle Background', 'responsive-elementor-addons'),
            'square' => __('Square / Rectangle Background', 'responsive-elementor-addons'),
            'custom' => __('Design your own', 'responsive-elementor-addons'),
            ),
            'condition' => array(
                    'rea_image_type!' => '',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_image_width',
            array(
            'label' => __('Width', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => array( 'px', 'em', 'rem' ),
            'range' => array(
            'px' => array(
            'min' => 1,
            'max' => 2000,
                    ),
            ),
            'default' => array(
                    'size' => 150,
                    'unit' => 'px',
            ),
            'condition' => array(
                    'rea_image_type' => 'photo',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__image img' => 'width: {{SIZE}}{{UNIT}};',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_icon_bg_size',
            array(
            'label' => __('Background Size', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range' => array(
            'px' => array(
            'min' => 0,
            'max' => 200,
                    ),
            ),
            'default' => array(
                    'size' => 20,
                    'unit' => 'px',
            ),
            'condition' => array(
                    'rea_image_type' => array( 'icon', 'photo' ),
                    'rea_imgicon_style!' => 'normal',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__icon, {{WRAPPER}} .rea-infobox__image-content img' => 'padding: {{SIZE}}{{UNIT}}; display:inline-block; box-sizing:content-box;',
            ),
            )
        );

        $this->start_controls_tabs('rea_tabs_icon_style');

        $this->start_controls_tab(
            'rea_icon_normal',
            array(
            'label' => __('Normal', 'responsive-elementor-addons'),
            'condition' => array(
            'rea_image_type' => array( 'icon', 'photo' ),
            ),
            )
        );
        $this->add_control(
            'rea_icon_color',
            array(
            'label' => __('Icon Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'scheme' => array(
            'type' => Color::get_type(),
            'value' => Color::COLOR_1,
            ),
            'conditions' => array(
                    'relation' => 'and',
                    'terms' => array(
                        array(
                            'name' => self::get_new_icon_name('select_icon'),
                            'operator' => '!=',
                            'value' => '',
                        ),
                        array(
                            'name' => 'rea_image_type',
                            'operator' => '==',
                            'value' => 'icon',
                        ),
            ),
            ),
            'default' => '',
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__icon i, {{WRAPPER}} .rea-infobox__icon svg' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rea-infobox__icon svg' => 'fill: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'rea_icon_bgcolor',
            array(
            'label' => __('Background Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'scheme' => array(
            'type' => Color::get_type(),
            'value' => Color::COLOR_2,
            ),
            'default' => '',
            'condition' => array(
                    'rea_image_type' => array( 'icon', 'photo' ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox:not(.rea-infobox__imgicon-style--normal) .rea-infobox__icon, {{WRAPPER}} .rea-infobox:not(.rea-infobox__imgicon-style--normal) .rea-infobox__image .rea-infobox__image-content img' => 'background-color: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'rea_icon_border',
            array(
            'label' => __('Border Style', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'label_block' => false,
            'options' => array(
            'none' => __('None', 'responsive-elementor-addons'),
            'solid' => __('Solid', 'responsive-elementor-addons'),
            'double' => __('Double', 'responsive-elementor-addons'),
            'dotted' => __('Dotted', 'responsive-elementor-addons'),
            'dashed' => __('Dashed', 'responsive-elementor-addons'),
            ),
            'condition' => array(
                    'rea_image_type' => array( 'icon', 'photo' ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__icon-wrapper .rea-infobox__icon, {{WRAPPER}} .rea-infobox__icon-wrapper .rea-infobox__image-content img' => 'border-style: {{VALUE}};',
            ),
            )
        );
        $this->add_control(
            'rea_icon_border_color',
            array(
            'label' => __('Border Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'scheme' => array(
            'type' => Color::get_type(),
            'value' => Color::COLOR_1,
            ),
            'condition' => array(
                    'rea_image_type' => array( 'icon', 'photo' ),
                    'rea_icon_border!' => 'none',
            ),
            'default' => '',
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__icon-wrapper .rea-infobox__icon, {{WRAPPER}} .rea-infobox__icon-wrapper .rea-infobox__image-content img' => 'border-color: {{VALUE}};',
            ),
            )
        );
        $this->add_control(
            'rea_icon_border_size',
            array(
            'label' => __('Border Width', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'default' => array(
            'top' => '1',
            'bottom' => '1',
            'left' => '1',
            'right' => '1',
            'unit' => 'px',
            ),
            'condition' => array(
                    'rea_image_type' => array( 'icon', 'photo' ),
                    'rea_icon_border!' => 'none',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__icon-wrapper .rea-infobox__icon, {{WRAPPER}} .rea-infobox__icon-wrapper .rea-infobox__image-content img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing:content-box;',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_icon_border_radius',
            array(
            'label' => __('Rounded Corners', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'default' => array(
            'top' => '5',
            'bottom' => '5',
            'left' => '5',
            'right' => '5',
            'unit' => 'px',
            ),
            'condition' => array(
                    'rea_image_type' => array( 'icon', 'photo' ),
                    'rea_icon_border!' => 'none',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__icon-wrapper .rea-infobox__icon, {{WRAPPER}} .rea-infobox__icon-wrapper .rea-infobox__image-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing:content-box;',
            ),
            )
        );

        $this->add_control(
            'rea_css_filters_heading',
            array(
            'label' => __('Image Style', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            'rea_image_type' => 'photo',
            'rea_imgicon_style!' => 'normal',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            array(
            'name' => 'rea_css_filters',
            'selector' => '{{WRAPPER}} .rea-infobox__image-content img',
            'condition' => array(
            'rea_image_type' => 'photo',
            'rea_imgicon_style!' => 'normal',
            ),
            )
        );

        $this->add_control(
            'rea_image_opacity',
            array(
            'label' => __('Image Opacity', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => array(
            'px' => array(
            'max' => 1,
            'min' => 0.10,
            'step' => 0.01,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__image-content img' => 'opacity: {{SIZE}};',
            ),
            'condition' => array(
                    'rea_image_type' => 'photo',
                    'rea_imgicon_style!' => 'normal',
            ),
            )
        );

        $this->add_control(
            'rea_background_hover_transition',
            array(
            'label' => __('Transition Duration', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => array(
            'size' => 0.3,
            ),
            'range' => array(
                    'px' => array(
                        'max' => 3,
                        'step' => 0.1,
            ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__image-content img' => 'transition-duration: {{SIZE}}s',
            ),
            'condition' => array(
                    'rea_image_type' => 'photo',
                    'rea_imgicon_style!' => 'normal',
            ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'rea_icon_hover_state',
            array(
            'label' => __('Hover', 'responsive-elementor-addons'),
            'condition' => array(
            'rea_image_type' => array( 'icon', 'photo' ),
            ),
            )
        );
        $this->add_control(
            'rea_icon_hover_color_imgicon_not_normal',
            array(
            'label' => __('Icon Hover Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'conditions' => array(
            'relation' => 'and',
            'terms' => array(
            array(
            'name' => self::get_new_icon_name('select_icon'),
            'operator' => '!=',
            'value' => '',
            ),
            array(
            'name' => 'rea_image_type',
            'operator' => '==',
            'value' => 'icon',
            ),
                    ),
            ),
            'default' => '',
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox:hover .rea-infobox__icon > i, {{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__content .rea-infobox__imgicon-wrapper i, {{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__imgicon-wrapper i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rea-infobox:hover .rea-infobox__icon > svg, {{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea__infobox-content .rea-infobox__imgicon-wrapper svg, {{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__imgicon-wrapper svg' => 'fill: {{VALUE}}; color: {{VALUE}}',
            ),
            )
        );

        $this->add_control(
            'rea_icon_hover_bgcolor',
            array(
            'label' => __('Background Hover Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'condition' => array(
            'rea_image_type' => array( 'icon', 'photo' ),
            'rea_imgicon_style!' => 'normal',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox:hover .rea-infobox__icon-wrapper .rea-infobox__icon, {{WRAPPER}} .rea-infobox__image-content img, {{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__content .rea-infobox__imgicon-wrapper .rea-infobox__icon, {{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__imgicon-wrapper .rea-infobox__icon,
					{{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__image .rea-infobox__image-content img, {{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__imgicon-wrapper img,{{WRAPPER}} .rea-infobox:hover .rea-infobox:not(.rea-infobox__imgicon-style--normal) .rea-infobox__icon-wrapper .rea-infobox__icon,
					{{WRAPPER}} .rea-infobox:hover .rea-infobox:not(.rea-infobox__imgicon-style--normal) .rea-infobox__image .rea-infobox__image-content img' => 'background-color: {{VALUE}};',
            ),
            )
        );
        $this->add_control(
            'rea_icon_border_hover',
            array(
            'label' => __('Border Style', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'label_block' => false,
            'options' => array(
            'none' => __('None', 'responsive-elementor-addons'),
            'solid' => __('Solid', 'responsive-elementor-addons'),
            'double' => __('Double', 'responsive-elementor-addons'),
            'dotted' => __('Dotted', 'responsive-elementor-addons'),
            'dashed' => __('Dashed', 'responsive-elementor-addons'),
            ),
            'condition' => array(
                    'rea_image_type' => array( 'icon', 'photo' ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox:hover .rea-infobox__icon-wrapper .rea-infobox__icon,
					{{WRAPPER}} .rea-infobox:hover .rea-infobox__icon-wrapper .rea-infobox__image-content img' => 'border-style: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'rea_icon_hover_border',
            array(
            'label' => __('Border Hover Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'condition' => array(
            'rea_image_type' => array( 'icon', 'photo' ),
            'rea_icon_border_hover!' => 'none',
            ),
            'default' => '',
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox:hover .rea-infobox__icon-wrapper .rea-infobox__icon,
					{{WRAPPER}} .rea-infobox:hover .rea-infobox__image-content img,
					{{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__content .rea-infobox__imgicon-wrapper .rea-infobox__icon,
					{{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__imgicon-wrapper .rea-infobox__icon,
					{{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__image .rea-infobox__image-content img,
					{{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__imgicon-wrapper img ' => 'border-color: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'rea_icon_border_size_hover',
            array(
            'label' => __('Border Width', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'default' => array(
            'top' => '1',
            'bottom' => '1',
            'left' => '1',
            'right' => '1',
            'unit' => 'px',
            ),
            'condition' => array(
                    'rea_image_type' => array( 'icon', 'photo' ),
                    'rea_icon_border_hover!' => 'none',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox:hover .rea-infobox__icon-wrapper .rea-infobox__icon,
					{{WRAPPER}} .rea-infobox:hover .rea-infobox__icon-wrapper .rea-infobox__image-content img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing:content-box;',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_icon_border_radius_hover',
            array(
            'label' => __('Rounded Corners', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'default' => array(
            'top' => '5',
            'bottom' => '5',
            'left' => '5',
            'right' => '5',
            'unit' => 'px',
            ),
            'condition' => array(
                    'rea_image_type' => array( 'icon', 'photo' ),
                    'rea_icon_border_hover!' => 'none',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox:hover .rea-infobox__icon-wrapper .rea-infobox__icon, {{WRAPPER}} .rea-infobox:hover .rea-infobox__icon-wrapper .rea-infobox__image-content img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; box-sizing:content-box;',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            array(
            'name' => 'rea_hover_css_filters',
            'selector' => '{{WRAPPER}} .rea-infobox:hover .rea-infobox__image-content img,
				{{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__imgicon-wrapper .rea-infobox__icon,
				{{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__image .rea-infobox__image-content img,
				{{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__imgicon-wrapper img',
            'condition' => array(
            'rea_image_type' => 'photo',
            ),
            )
        );

        $this->add_control(
            'rea_hover_image_opacity',
            array(
            'label' => __('Opacity', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => array(
            'px' => array(
            'max' => 1,
            'min' => 0.10,
            'step' => 0.01,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox:hover .rea-infobox__image-content img,
					{{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__imgicon-wrapper .rea-infobox__icon,
					{{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__image .rea-infobox__image-content img,
					{{WRAPPER}} .rea-infobox:hover .rea-infobox-link-type-module .rea-infobox-module-link ~ .rea-infobox__imgicon-wrapper img' => 'opacity: {{SIZE}};',
            ),
            'condition' => array(
                    'rea_image_type' => 'photo',
            ),
            )
        );

        $this->add_control(
            'rea_imgicon_animation',
            array(
            'label' => __('Hover Animation', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HOVER_ANIMATION,
            'condition' => array(
            'rea_image_type' => array( 'icon', 'photo' ),
            ),
            )
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'rea_normal_css_filters_heading',
            array(
            'label' => __('Image Style', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            'rea_image_type' => 'photo',
            'rea_imgicon_style' => 'normal',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            array(
            'name' => 'rea_normal_css_filters',
            'selector' => '{{WRAPPER}} .rea-infobox__image .rea-infobox__image-content img',
            'condition' => array(
            'rea_image_type' => 'photo',
            'rea_imgicon_style' => 'normal',
            ),
            )
        );

        $this->add_control(
            'rea_normal_image_opacity',
            array(
            'label' => __('Image Opacity', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'range' => array(
            'px' => array(
            'max' => 1,
            'min' => 0.10,
            'step' => 0.01,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__image .rea-infobox__image-content img' => 'opacity: {{SIZE}};',
            ),
            'condition' => array(
                    'rea_image_type' => 'photo',
                    'rea_imgicon_style' => 'normal',
            ),
            )
        );

        $this->add_control(
            'rea_normal_bg_hover_transition',
            array(
            'label' => __('Transition Duration', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SLIDER,
            'default' => array(
            'size' => 0.3,
            ),
            'range' => array(
                    'px' => array(
                        'max' => 3,
                        'step' => 0.1,
            ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__image .rea-infobox__image-content img' => 'transition-duration: {{SIZE}}s',
            ),
            'condition' => array(
                    'rea_image_type' => 'photo',
                    'rea_imgicon_style' => 'normal',
            ),
            )
        );

        $this->add_control(
            'rea_image_responsive_support',
            array(
            'label' => __('Responsive Support', 'responsive-elementor-addons'),
            'description' => __('Choose on what breakpoint the Iconbox will stack.', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'default' => 'tablet',
            'options' => array(
            'none' => __('No', 'responsive-elementor-addons'),
            'tablet' => __('For Tablet & Mobile ', 'responsive-elementor-addons'),
            'mobile' => __('For Mobile Only', 'responsive-elementor-addons'),
            ),
            'condition' => array(
                    'rea_image_type' => array( 'icon', 'photo' ),
                    'rea_image_position' => array( 'left', 'right' ),
            ),
            )
        );

        $this->add_control(
            'rea_image_valign',
            array(
            'label' => __('Vertical Alignment', 'responsive-elementor-addons'),
            'type' => Controls_Manager::CHOOSE,
            'label_block' => false,
            'options' => array(
            'top' => array(
            'title' => __('Top', 'responsive-elementor-addons'),
            'icon' => 'eicon-v-align-top',
                    ),
                    'middle' => array(
                        'title' => __('Middle', 'responsive-elementor-addons'),
                        'icon' => 'eicon-v-align-middle',
                    ),
            ),
            'default' => 'top',
            'condition' => array(
                    'rea_image_type' => array( 'icon', 'photo' ),
                    'rea_image_position' => array( 'left-title', 'right-title', 'left', 'right' ),
            ),
            )
        );

        $this->add_responsive_control(
            'rea_overall_align',
            array(
            'label' => __('Overall Alignment', 'responsive-elementor-addons'),
            'type' => Controls_Manager::CHOOSE,
            'default' => 'center',
            'options' => array(
            'left' => array(
            'title' => __('Left', 'responsive-elementor-addons'),
            'icon' => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => __('Center', 'responsive-elementor-addons'),
                        'icon' => 'fa fa-align-center',
                    ),
                    'right' => array(
                        'title' => __('Right', 'responsive-elementor-addons'),
                        'icon' => 'fa fa-align-right',
                    ),
            ),
            'condition' => array(
                    'rea_image_type!' => array( 'icon', 'photo' ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox, {{WRAPPER}} .rea-infobox__separator-wrapper' => 'text-align: {{VALUE}};',
            ),
            )
        );

        $this->end_controls_section();
    }

    public function register_infobox_container_style_controls()
    {
        $this->start_controls_section(
            'rea_infobox_container',
            array(
            'label' => __('Icon Box Container', 'responsive-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'rea_align',
            array(
            'label' => __('Overall Alignment', 'responsive-elementor-addons'),
            'type' => Controls_Manager::CHOOSE,
            'options' => array(
            'left' => array(
            'title' => __('Left', 'responsive-elementor-addons'),
            'icon' => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => __('Center', 'responsive-elementor-addons'),
                        'icon' => 'fa fa-align-center',
                    ),
                    'right' => array(
                        'title' => __('Right', 'responsive-elementor-addons'),
                        'icon' => 'fa fa-align-right',
                    ),
            ),
            'default' => 'center',
            'condition' => array(
                    'rea_image_type' => array( 'icon', 'photo' ),
                    'rea_image_position' => array( 'above-title', 'below-title' ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox,  {{WRAPPER}} .rea-infobox__separator-wrapper' => 'text-align: {{VALUE}};',
            ),
            )
        );

        $this->start_controls_tabs('rea_icon_box_style_background_tab');
        $this->start_controls_tab(
            'rea_icon_box_section_background_style_n_tab',
            [
            'label' => esc_html__('Normal', 'responsive-elementor-addons'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
            'name' => 'rea_infobox_bg_group',
            'label' => esc_html__('Background', 'responsive-elementor-addons'),
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .rea-infobox',
            ]
        );
        $this->add_responsive_control(
            'rea_infobox_bg_padding',
            [
            'label' => esc_html__('Padding', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'default' => [
            'top' => '50',
            'right' => '40',
            'bottom' => '50',
            'left' => '40',
            'unit' => 'px',
            ],
            'selectors' => [
                    '{{WRAPPER}} .rea-infobox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
            'name' => 'rea_infobox_box_shadow_group',
            'label' => esc_html__('Box Shadow', 'responsive-elementor-addons'),
            'selector' => '{{WRAPPER}} .rea-infobox',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
            'name' => 'rea_infobox_border_group',
            'label' => esc_html__('Border', 'responsive-elementor-addons'),
            'selector' => '{{WRAPPER}} .rea-infobox',
            ]
        );
        $this->add_responsive_control(
            'rea_infobox_border_radious',
            [
            'label' => esc_html__('Border Radius', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors' => [
            '{{WRAPPER}} .rea-infobox' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'rea_infobox_section_background_style_n_hv_tab',
            [
            'label' => esc_html__('Hover', 'responsive-elementor-addons'),
            ]
        );
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
            'name' => 'rea_infobox_bg_hover_group',
            'label' => esc_html__('Background', 'responsive-elementor-addons'),
            'types' => [ 'classic', 'gradient', 'video' ],
            'selector' => '{{WRAPPER}} .rea-infobox:hover',
            ]
        );

        $this->add_control(
            'rea_title_hover_color',
            array(
            'label' => __('Title Hover Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => array(
            '{{WRAPPER}} .rea-infobox:hover  .rea-infobox__title' => 'color: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'rea_description_hover_color',
            array(
            'label' => __('Description Hover Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => array(
            '{{WRAPPER}} .rea-infobox:hover .rea-infobox__content .rea-infobox__description' => 'color: {{VALUE}};',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_infobox_bg_padding_inner',
            [
            'label' => esc_html__('Padding', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],

            'selectors' => [
            '{{WRAPPER}} .rea-infobox:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
            'name' => 'rea_infobox_box_shadow_hv_group',
            'label' => esc_html__('Box Shadow', 'responsive-elementor-addons'),
            'selector' => '{{WRAPPER}} .rea-infobox:hover',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
            'name' => 'rea_icon_box_border_hv_group',
            'label' => esc_html__('Border', 'responsive-elementor-addons'),
            'selector' => '{{WRAPPER}} .rea-infobox:hover',
            ]
        );

        $this->add_responsive_control(
            'rea_infobox_border_radious_hv',
            [
            'label' => esc_html__('Border Radius', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors' => [
            '{{WRAPPER}} .rea-infobox:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            ]
        );
        $this->add_control(
            'rea_info_box_hover_animation',
            [
            'label' => esc_html__('Hover Animation', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Add Typography controls section under the Style TAB
     *
     * @since  1.2.0
     * @access public
     */
    public function register_typography_style_controls()
    {
        $this->start_controls_section(
            'rea_typography_section',
            array(
            'label' => __('Typography', 'responsive-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'rea_title_typo',
            array(
            'label' => __('Title', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'condition' => array(
            'rea_title!' => '',
            ),
            )
        );
        $this->add_control(
            'rea_title_tag',
            array(
            'label' => __('Title Tag', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
            'h1' => __('H1', 'responsive-elementor-addons'),
            'h2' => __('H2', 'responsive-elementor-addons'),
            'h3' => __('H3', 'responsive-elementor-addons'),
            'h4' => __('H4', 'responsive-elementor-addons'),
            'h5' => __('H5', 'responsive-elementor-addons'),
            'h6' => __('H6', 'responsive-elementor-addons'),
            'div' => __('div', 'responsive-elementor-addons'),
            'p' => __('p', 'responsive-elementor-addons'),
            ),
            'default' => 'h3',
            'condition' => array(
                    'rea_title!' => '',
            ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name' => 'rea_title_typography',
            'scheme' => Typography::TYPOGRAPHY_1,
            'selector' => '{{WRAPPER}} .rea-infobox__title',
            'condition' => array(
            'rea_title!' => '',
            ),
            )
        );
        $this->add_control(
            'rea_title_color',
            array(
            'label' => __('Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'scheme' => array(
            'type' => Color::get_type(),
            'value' => Color::COLOR_1,
            ),
            'default' => '',
            'condition' => array(
                    'rea_title!' => '',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__title' => 'color: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'rea_blend_mode',
            array(
            'label' => __('Blend Mode', 'responsive-elementor-addons'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
            '' => __('Normal', 'responsive-elementor-addons'),
            'multiply' => 'Multiply',
            'screen' => 'Screen',
            'overlay' => 'Overlay',
            'darken' => 'Darken',
            'lighten' => 'Lighten',
            'color-dodge' => 'Color Dodge',
            'saturation' => 'Saturation',
            'color' => 'Color',
            'difference' => 'Difference',
            'exclusion' => 'Exclusion',
            'hue' => 'Hue',
            'luminosity' => 'Luminosity',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__title' => 'mix-blend-mode: {{VALUE}}',
            ),
            'separator' => 'none',
            )
        );

        $this->add_control(
            'rea_description_typo',
            array(
            'label' => __('Description', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            'rea_description!' => '',
            ),
            )
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name' => 'rea_description_typography',
            'scheme' => Typography::TYPOGRAPHY_3,
            'selector' => '{{WRAPPER}} .rea-infobox__description',
            'condition' => array(
            'rea_description!' => '',
            ),
            )
        );
        $this->add_control(
            'rea_description_color',
            array(
            'label' => __('Description Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'scheme' => array(
            'type' => Color::get_type(),
            'value' => Color::COLOR_3,
            ),
            'default' => '',
            'condition' => array(
                    'rea_description!' => '',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__description' => 'color: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'rea_link_typo',
            array(
            'label' => __('CTA Link Text', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            'rea_cta_type' => 'link',
            ),
            )
        );

        $this->add_control(
            'rea_button_typo',
            array(
            'label' => __('CTA Button Text', 'responsive-elementor-addons'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            'rea_cta_type' => 'button',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name' => 'rea_cta_typography',
            'scheme' => Typography::TYPOGRAPHY_2,
            'selector' => '{{WRAPPER}} .rea-infobox__cta-link, {{WRAPPER}} .elementor-button, {{WRAPPER}} a.elementor-button',
            'condition' => array(
            'rea_cta_type' => array( 'link', 'button' ),
            ),
            )
        );
        $this->add_control(
            'rea_cta_color',
            array(
            'label' => __('Link Color', 'responsive-elementor-addons'),
            'type' => Controls_Manager::COLOR,
            'scheme' => array(
            'type' => Color::get_type(),
            'value' => Color::COLOR_4,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__cta-link' => 'color: {{VALUE}};',
            ),
            'condition' => array(
                    'rea_cta_type' => 'link',
            ),
            )
        );

        $this->end_controls_section();
    }

    /**
     * Add Margin controls section under the Style TAB
     *
     * @since  1.2.0
     * @access public
     */
    public function register_margin_style_controls()
    {
        $this->start_controls_section(
            'rea_margin_section',
            array(
            'label' => __('Margins', 'responsive-elementor-addons'),
            'tab' => Controls_Manager::TAB_STYLE,
            )
        );
        $this->add_responsive_control(
            'rea_title_margin',
            array(
            'label' => __('Title Margin', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'default' => array(
            'top' => '0',
            'bottom' => '0',
            'left' => '0',
            'right' => '0',
            'unit' => 'px',
            'isLinked' => false,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            'condition' => array(
                    'rea_title!' => '',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_responsive_imgicon_margin',
            array(
            'label' => __('Image/Icon Margin', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'condition' => array(
            'rea_image_type' => array( 'icon', 'photo' ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__imgicon-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_description_margin',
            array(
            'label' => __('Description Margins', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'default' => array(
            'top' => '0',
            'bottom' => '0',
            'left' => '0',
            'right' => '0',
            'unit' => 'px',
            'isLinked' => false,
            ),
            'condition' => array(
                    'rea_description!' => '',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->add_responsive_control(
            'rea_separator_margin',
            array(
            'label' => __('Separator Margins', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'default' => array(
            'top' => '10',
            'bottom' => '10',
            'left' => '0',
            'right' => '0',
            'unit' => 'px',
            'isLinked' => false,
            ),
            'condition' => array(
                    'rea_toggle_separator' => 'yes',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__separator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),

            )
        );
        $this->add_responsive_control(
            'rea_cta_margin',
            array(
            'label' => __('CTA Margin', 'responsive-elementor-addons'),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'default' => array(
            'top' => '10',
            'bottom' => '0',
            'left' => '0',
            'right' => '0',
            'unit' => 'px',
            'isLinked' => false,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-infobox__cta-link-style, {{WRAPPER}} .rea-infobox-button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            'condition' => array(
                    'rea_cta_type' => array( 'link', 'button' ),
            ),
            )
        );
        $this->end_controls_section();
    }

    /**
     * Render in the frontend
     *
     * @since  1.2.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $html = $this->widget_template($settings);
        echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /**
     * Renders widget template
     *
     * @param  object $settings Settings for the widget.
     * @return string HTML for the widget.
     */
    protected function widget_template( $settings )
    {
        $dynamic_settings = $this->get_settings_for_display();

        $this->add_render_attribute('rea_infobox_classname', 'class', 'rea-infobox-widget-content rea-infobox');

        if ('icon' == $settings['rea_image_type'] || 'photo' == $settings['rea_image_type'] ) {

            $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox__imgicon-style--' . $settings['rea_imgicon_style']);
            $this->add_render_attribute('rea_infobox_classname', 'class', ' elementor-animation-' . $settings['rea_info_box_hover_animation']);

            if ('above-title' == $settings['rea_image_position'] || 'below-title' == $settings['rea_image_position'] ) {
                $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox--' . $settings['rea_align']);
            }
            if ('left-title' == $settings['rea_image_position'] || 'left' == $settings['rea_image_position'] ) {
                $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox--left');
            }
            if ('right-title' == $settings['rea_image_position'] || 'right' == $settings['rea_image_position'] ) {
                $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox--right');
            }
            if ('icon' == $settings['rea_image_type'] ) {
                $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox--has-icon rea-infobox--icon-' . $settings['rea_image_position']);
            }
            if ('photo' == $settings['rea_image_type'] ) {
                $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox--has-photo rea-infobox--photo-' . $settings['rea_image_position']);
            }
            if ('above-title' != $settings['rea_image_position'] && 'below-title' != $settings['rea_image_position'] ) {

                if ('middle' == $settings['rea_image_valign'] ) {
                    $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox__image-valign--middle');
                } else {
                    $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox__image-valign--top');
                }
            }
            if ('left' == $settings['rea_image_position'] || 'right' == $settings['rea_image_position'] ) {
                if ('tablet' == $settings['rea_image_responsive_support'] ) {
                    $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox--view-tablet');
                }
                if ('mobile' == $settings['rea_image_responsive_support'] ) {
                    $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox--view-mobile');
                }
            }
            if ('right' == $settings['rea_image_position'] ) {
                if ('tablet' == $settings['rea_image_responsive_support'] ) {
                    $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox--reverse-order-tablet');
                }
                if ('mobile' == $settings['rea_image_responsive_support'] ) {
                    $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox--reverse-order-mobile');
                }
            }
        } else {
            if ('left' == $settings['rea_overall_align'] || 'center' == $settings['rea_overall_align'] || 'right' == $settings['rea_overall_align'] ) {
                $classname = ' rea-infobox--' . $settings['rea_overall_align'];
                $this->add_render_attribute('rea_infobox_classname', 'class', $classname);
            }
        }

        $this->add_render_attribute('rea_infobox_classname', 'class', ' rea-infobox-link-type-' . $settings['rea_cta_type']);
        ob_start();
        ?>
        <div <?php echo wp_kses_post($this->get_render_attribute_string('rea_infobox_classname')); ?>>
            <div class="rea-infobox-left-right-wrapper">
        <?php
        if ('module' == $settings['rea_cta_type'] && '' != $settings['rea_text_link'] ) {
            $_nofollow = ( 'on' == $dynamic_settings['rea_text_link']['nofollow'] ) ? '1' : '0';
            $_target = ( 'on' == $dynamic_settings['rea_text_link']['is_external'] ) ? '_blank' : '';
            $_link = ( isset($dynamic_settings['rea_text_link']['url']) ) ? $dynamic_settings['rea_text_link']['url'] : '';
            ?>
                <a href="<?php echo $_link; ?>"
                    target="<?php echo esc_attr($_target); ?>" <?php self::get_link_rel($_target, $_nofollow, 1); ?>
                    class="rea-infobox-module-link"></a><?php //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php
        }
        ?>
        <?php $this->render_image('left', $settings); ?>
                <div class="rea-infobox__content">
        <?php $this->render_image('above-title', $settings); ?>
        <?php
        if ('after_icon' === $settings['rea_separator_position'] ) {
            $this->render_separator($settings);
        }
        ?>
        <?php $this->render_title($settings); ?>
        <?php
        if ('after_heading' === $settings['rea_separator_position'] ) {
            $this->render_separator($settings);
        }
        ?>
        <?php
        $this->render_image('below-title', $settings);
        if (! empty($settings['rea_description']) ) {
            ?>
                        <div class="rea-infobox__description-wrapper">
            <?php
            $this->add_render_attribute('rea_description', 'class', 'rea-infobox__description');
            $this->add_inline_editing_attributes('rea_description', 'advanced');
            ?>
                            <div <?php echo wp_kses_post($this->get_render_attribute_string('rea_description')); ?>>
            <?php echo wp_kses_post($settings['rea_description']); ?>
                            </div>
            <?php
            if ('after_description' == $settings['rea_separator_position'] ) {
                $this->render_separator($settings);
                ?>
            <?php } ?>
                        </div>
        <?php } ?>
        <?php $this->render_link($settings); ?>
                </div>
        <?php $this->render_image('right', $settings); ?>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }

    /**
     *  Get link rel attribute
     *
     * @param  string $target      Target attribute to the link.
     * @param  int    $is_nofollow No follow yes/no.
     * @param  int    $echo        Return or echo the output.
     * @since  1.2.0
     * @return string
     */
    public static function get_link_rel( $target, $is_nofollow = 0, $echo = 0 )
    {

        $attr = '';
        if ('_blank' == $target ) {
            $attr .= 'noopener';
        }

        if (1 == $is_nofollow ) {
            $attr .= ' nofollow';
        }

        if ('' == $attr ) {
            return;
        }

        $attr = trim($attr);
        if (! $echo ) {
            return 'rel="' . $attr . '"';
        }
        echo 'rel="' . esc_attr($attr) . '"';
    }

    /**
     * Renders REA Infobox Image or Icon
     *
     * @param  string $position Position of the image.
     * @param  object $settings Control Settings of the widget.
     * @access public
     *
     * @since 1.2.0
     */
    public function render_image( $position, $settings )
    {
        $set_pos = '';
        $anim_class = '';
        $image_html = '';

        if ('icon' == $settings['rea_image_type'] || 'photo' == $settings['rea_image_type'] ) {
            $set_pos = $settings['rea_image_position'];
        }
        if ($position == $set_pos ) {
            if ('icon' == $settings['rea_image_type'] || 'photo' == $settings['rea_image_type'] ) {

                if ('normal' != $settings['rea_imgicon_style'] ) {
                    $anim_class = 'elementor-animation-' . $settings['rea_imgicon_animation'];
                } elseif ('normal' == $settings['rea_imgicon_style'] ) {
                    $anim_class = 'elementor-animation-' . $settings['rea_imgicon_animation'];
                }

                ?>
                <div class="rea-infobox-widget-content rea-infobox__imgicon-wrapper"><?php /* Module Wrap */ ?>
                <?php
                /*Icon Html */
                if (self::is_elementor_updated() ) {
                    if (! isset($settings['rea_select_icon']) && ! Icons_Manager::is_migration_allowed() ) {
                        // add old default.
                        $settings['rea_select_icon'] = 'fa fa-star';
                    }
                     $has_icon = ! empty($settings['rea_select_icon']);

                    if (! $has_icon && ! empty($settings['rea_new_select_icon']['value']) ) {
                        $has_icon = true;
                    }
                        $migrated = isset($settings['__fa4_migrated']['rea_new_select_icon']);
                        $is_new = ! isset($settings['rea_select_icon']) && Icons_Manager::is_migration_allowed();
                    ?>
                    <?php if ('icon' == $settings['rea_image_type'] && $has_icon ) { ?>
                            <div class="rea-infobox__icon-wrapper <?php echo esc_attr($anim_class); ?>">
                                <div class="rea-infobox__icon">
                        <?php
                        if ($is_new || $migrated ) {
                            Icons_Manager::render_icon($settings['rea_new_select_icon'], array( 'aria-hidden' => 'true' ));
                        } elseif (! empty($settings['rea_select_icon']) ) {
                            ?>
                                        <i class="<?php echo esc_attr($settings['rea_select_icon']); ?>"
                                            aria-hidden="true"></i>
                        <?php } ?>
                                </div>
                            </div>
                        <?php
                    }
                } elseif ('icon' == $settings['rea_image_type'] ) {
                    ?>
                        <div class="rea-infobox__icon-wrapper <?php echo esc_attr($anim_class); ?>">
                            <div class="rea-infobox__icon">
                                <i class="<?php echo esc_attr($settings['rea_select_icon']); ?>"></i>
                            </div>
                        </div>
                <?php } // Icon Html End. ?>

                <?php /* Photo Html */ ?>
                <?php
                if ('photo' == $settings['rea_image_type'] ) {
                    if ('media' == $settings['rea_photo_type'] ) {
                        if (! empty($settings['rea_image']['url']) ) {

                            $this->add_render_attribute('rea_image', 'src', $settings['rea_image']['url']);
                            $this->add_render_attribute('rea_image', 'alt', Control_Media::get_image_alt($settings['rea_image']));
                            $this->add_render_attribute('rea_image', 'title', Control_Media::get_image_title($settings['rea_image']));

                            $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'rea_image', 'rea_image');
                        }
                    }
                    if ('url' == $settings['rea_photo_type'] ) {
                        if (! empty($settings['rea_image_link']) ) {

                            $this->add_render_attribute('rea_image_link', 'src', $settings['rea_image_link']['url']);

                            $image_html = '<img ' . $this->get_render_attribute_string('rea_image_link') . '>';
                        }
                    }
                    ?>
                        <div class="rea-infobox__image" itemscope itemtype="http://schema.org/ImageObject">
                            <div class="rea-infobox__image-content <?php echo esc_attr($anim_class); ?> ">
                    <?php echo wp_kses_post($image_html); ?>
                            </div>
                        </div>

                <?php } // Photo Html End. ?>
                </div>
                <?php
            }
        }
    }

    /**
     * Renders REA Infobox Title
     *
     * @param object $settings Control Settings of the widget.
     * 
     * @access public
     *
     * @return void
     * @since  1.2.0
     */
    public function render_title( $settings )
    {
        $flag = false;
        $dynamic_settings = $this->get_settings_for_display();

        if (( 'photo' == $settings['rea_image_type'] && 'left-title' == $settings['rea_image_position'] ) || ( 'icon' == $settings['rea_image_type'] && 'left-title' == $settings['rea_image_position'] ) ) {
            echo '<div class="rea-infobox-image--left-of-heading">';
            $flag = true;
        } elseif (( 'photo' == $settings['rea_image_type'] && 'right-title' == $settings['rea_image_position'] ) || ( 'icon' == $settings['rea_image_type'] && 'right-title' == $settings['rea_image_position'] ) ) {
            echo '<div class="rea-infobox-image--right-of-heading">';
            $flag = true;
        }

        $this->render_image('left-title', $settings);
        echo '<div class="rea-infobox__title-wrapper">';

        if (! empty($dynamic_settings['rea_title']) ) {
            $this->add_render_attribute('rea_title', 'class', 'rea-infobox__title');
            $this->add_inline_editing_attributes('rea_title', 'basic');

            echo '<' . esc_attr($settings['rea_title_tag']) . ' ' . wp_kses_post($this->get_render_attribute_string('rea_title')) . '>';
            echo wp_kses_post($dynamic_settings['rea_title']);
            echo '</' . esc_attr($settings['rea_title_tag']) . '>';
        }
        echo '</div>';
        $this->render_image('right-title', $settings);

        if ($flag ) {
            echo '</div>';
        }
    }

    /**
     * Renders REA Infobox Separator element
     *
     * @param object $settings Control Settings of the widget.
     * 
     * @access public
     *
     * @return void
     * @since  1.2.0
     */
    public function render_separator( $settings )
    {
        if ('yes' == $settings['rea_toggle_separator'] ) {
            ?>
            <div class="rea-infobox__separator-wrapper">
                <div class="rea-infobox__separator"></div>
            </div>
            <?php
        }
    }

    /**
     * Renders REA Infobox link
     *
     * @param object $settings Control Settings of the widget.
     * 
     * @access public
     * @return void
     * @since  1.2.0
     */
    public function render_link( $settings )
    {

        $dynamic_settings = $this->get_settings_for_display();

        if ('link' == $settings['rea_cta_type'] ) {
            $_nofollow = ( 'on' == $dynamic_settings['rea_text_link']['nofollow'] ) ? 'nofollow' : '';
            $_target = ( 'on' == $dynamic_settings['rea_text_link']['is_external'] ) ? '_blank' : '';
            $_link = ( isset($dynamic_settings['rea_text_link']['url']) ) ? $dynamic_settings['rea_text_link']['url'] : '';
            ?>
            <div class="rea-infobox__cta-link-style">
                <a href="<?php echo $_link; ?>" rel="<?php echo esc_attr($_nofollow); ?>"
                    target="<?php echo esc_attr($_target); ?>"
                    class="rea-infobox__cta-link"> <?php //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php
            if ('left' == $settings['rea_button_icon_position'] ) {
                if (self::is_elementor_updated() ) {
                    if (( ! empty($settings['rea_button_icon']) || ! empty($settings['rea_new_button_icon']) ) ) {

                        $migrated = isset($settings['__fa4_migrated']['rea_new_button_icon']);
                        $is_new = ! isset($settings['rea_button_icon']);
                        ?>
                                <span class="rea-infobox__link-icon rea-infobox__link-icon--before">
                        <?php
                        if ($is_new || $migrated ) :
                            Icons_Manager::render_icon($settings['rea_new_button_icon'], array( 'aria-hidden' => 'true' ));
                  elseif (! empty($settings['rea_button_icon']) ) :
                        ?>
                                        <i class="<?php echo esc_attr($settings['rea_button_icon']); ?>"
                                            aria-hidden="true"></i>
                  <?php endif; ?>
                                </span>
                    <?php } ?>
                <?php } elseif (! empty($settings['rea_button_icon']) ) { ?>
                            <span class="rea-infobox__link-icon rea-infobox__link-icon--before">
                                <i class="<?php echo esc_attr($settings['rea_button_icon']); ?>" aria-hidden="true"></i>
                            </span>
                <?php } ?>
            <?php } ?>
            <?php
            $this->add_inline_editing_attributes('rea_link_text', 'basic');
            ?>
                    <span <?php echo wp_kses_post($this->get_render_attribute_string('rea_link_text')); ?> >
            <?php echo wp_kses_post($settings['rea_link_text']); ?>
                        </span>
            <?php
            if ('right' == $settings['rea_button_icon_position'] ) {
                if (self::is_elementor_updated() ) {
                    if (( ! empty($settings['rea_button_icon']) || ! empty($settings['rea_new_button_icon']) ) ) {
                        $migrated = isset($settings['__fa4_migrated']['rea_new_button_icon']);
                        $is_new = ! isset($settings['rea_button_icon']);
                        ?>
                                <span class="rea-infobox__link-icon rea-infobox__link-icon--after">
                        <?php
                        if ($is_new || $migrated ) :
                            Icons_Manager::render_icon($settings['rea_new_button_icon'], array( 'aria-hidden' => 'true' ));
                  elseif (! empty($settings['rea_button_icon']) ) :
                        ?>
                                        <i class="<?php echo esc_attr($settings['rea_button_icon']); ?>"
                                            aria-hidden="true"></i>
                  <?php endif; ?>
                                </span>
                    <?php } ?>
                <?php } elseif (! empty($settings['rea_button_icon']) ) { ?>
                            <span class="rea-infobox__link-icon rea-infobox__link-icon--after">
                                <i class="<?php echo esc_attr($settings['rea_button_icon']); ?>" aria-hidden="true"></i>
                            </span>
                <?php } ?>
            <?php } ?>
                </a>
            </div>
            <?php
        } elseif ('button' == $settings['rea_cta_type'] ) {
            $this->add_render_attribute('rea_btn_wrapper', 'class', 'rea-infobox-button-wrapper elementor-button-wrapper');

            if (! empty($dynamic_settings['rea_text_link']['url']) ) {
                $this->add_render_attribute('rea_button', 'href', $dynamic_settings['rea_text_link']['url']);
                $this->add_render_attribute('rea_button', 'class', 'elementor-button-link');

                if ($dynamic_settings['rea_text_link']['is_external'] ) {
                    $this->add_render_attribute('rea_button', 'target', '_blank');
                }
                if ($dynamic_settings['rea_text_link']['nofollow'] ) {
                    $this->add_render_attribute('rea_button', 'rel', 'nofollow');
                }
            }
            $this->add_render_attribute('rea_button', 'class', ' elementor-button');

            if (! empty($settings['rea_button_size']) ) {
                $this->add_render_attribute('rea_button', 'class', 'elementor-size-' . $settings['rea_button_size']);
            }
            if ($settings['rea_button_animation'] ) {
                $this->add_render_attribute('rea_button', 'class', 'elementor-animation-' . $settings['rea_button_animation']);
            }
            ?>
            <div <?php echo wp_kses_post($this->get_render_attribute_string('rea_btn_wrapper')); ?>>
                <a <?php echo wp_kses_post($this->get_render_attribute_string('rea_button')); ?>>
            <?php $this->render_button_text(); ?>
                </a>
            </div>
            <?php
        }
    }

    /**
     * Render REA Infobox Button text
     *
     * @access public
     * @since  1.2.0
     * @return void
     */
    public function render_button_text()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('rea_infobox_content', 'class', 'elementor-button-content-wrapper');
        $this->add_render_attribute('icon-align', 'class', 'elementor-align-icon-' . $settings['rea_button_icon_position']);
        $this->add_render_attribute('icon-align', 'class', 'elementor-button-icon');

        $this->add_render_attribute('rea_infobox_button_text', 'class', 'elementor-button-text');
        $this->add_inline_editing_attributes('rea_infobox_button_text', 'none');
        ?>
        <span <?php echo wp_kses_post($this->get_render_attribute_string('rea_infobox_content')); ?>>
        <?php if (self::is_elementor_updated() ) { ?>
            <?php
            $migrated = isset($settings['__fa4_migrated']['rea_new_button_icon']);
            $is_new = ! isset($settings['rea_button_icon']);
            ?>
            <?php if (! empty($settings['rea_button_icon']) || ! empty($settings['rea_new_button_icon']) ) : ?>
                    <span <?php echo wp_kses_post($this->get_render_attribute_string('icon-align')); ?>>
                <?php
                if ($is_new || $migrated ) :
                    Icons_Manager::render_icon($settings['rea_new_button_icon'], array( 'aria-hidden' => 'true' ));
                        elseif (! empty($settings['rea_button_icon']) ) :
                            ?>
                            <i class="<?php echo esc_attr($settings['rea_button_icon']); ?>" aria-hidden="true"></i>
                        <?php endif; ?>
                    </span>
            <?php endif; ?>
        <?php } elseif (! empty($settings['rea_button_icon']) ) { ?>
                <span <?php echo wp_kses_post($this->get_render_attribute_string('icon-align')); ?>>
                    <i class="<?php echo esc_attr($settings['rea_button_icon']); ?>" aria-hidden="true"></i>
                </span>
        <?php } ?>

            <span <?php echo wp_kses_post($this->get_render_attribute_string('rea_infobox_button_text')); ?> >
        <?php echo wp_kses_post($settings['rea_button_text']); ?>
            </span>
        </span>
        <?php
    }

    /**
     * Render template for live preview in the backend
     *
     * @since  1.2.0
     * @access protected
     * @return void
     */
    protected function content_template()
    {
        ?>

        <#
        function widget_template() {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', 'rea-infobox-widget-content rea-infobox' );

        if ( 'icon' == settings.rea_image_type || 'photo' == settings.rea_image_type ) {

        view.addRenderAttribute( 'rea_infobox_classname', 'class', 'rea-infobox__imgicon-style--' + settings.rea_imgicon_style );
        view.addRenderAttribute( 'rea_infobox_classname', 'class', 'elementor-animation-' + settings.rea_info_box_hover_animation );

        if ( 'above-title' == settings.rea_image_position || 'below-title' == settings.rea_image_position ) {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', ' rea-infobox--' + settings.rea_align );
        }
        if ( 'left-title' == settings.rea_image_position || 'left' == settings.rea_image_position ) {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', ' rea-infobox--left' );
        }
        if ( 'right-title' == settings.rea_image_position || 'right' == settings.rea_image_position ) {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', ' rea-infobox--right' );
        }
        if ( 'icon' == settings.rea_image_type ) {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', 'rea-infobox--has-icon rea-infobox--icon-' + settings.rea_image_position );
        }
        if ( 'photo' == settings.rea_image_type ) {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', 'rea-infobox--has-photo rea-infobox--photo-' + settings.rea_image_position );
        }
        if ( 'above-title' != settings.rea_image_position && 'below-title' != settings.rea_image_position ) {

        if ( 'middle' == settings.rea_image_valign ) {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', ' rea-infobox__image-valign--middle' );
        } else {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', ' rea-infobox__image-valign--top' );
        }
        }
        if ( 'left' == settings.rea_image_position || 'right' == settings.rea_image_position ) {
        if ( 'tablet' == settings.rea_image_responsive_support ) {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', ' rea-infobox--view-tablet' );
        }
        if ( 'mobile' == settings.rea_image_responsive_support ) {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', ' rea-infobox--view-mobile' );
        }
        }
        if ( 'right' == settings.rea_image_position ) {
        if ( 'tablet' == settings.rea_image_responsive_support ) {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', ' rea-infobox--reverse-order-tablet' );
        }
        if ( 'mobile' == settings.rea_image_responsive_support ) {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', ' rea-infobox--reverse-order-mobile' );
        }
        }
        } else {
        if ( 'left' == settings.rea_overall_align || 'center' == settings.rea_overall_align || 'right' == settings.rea_overall_align ) {
        view.addRenderAttribute( 'rea_infobox_classname', 'class', ' rea-infobox--' + settings.rea_overall_align );
        }
        }

        view.addRenderAttribute( 'rea_infobox_classname', 'class', 'rea-infobox-link-type-' + settings.rea_cta_type );
        #>
        <div {{{ view.getRenderAttributeString( 'rea_infobox_classname' ) }}}>
        <div class="rea-infobox-left-right-wrapper">
            <#
            if ( 'module' == settings.rea_cta_type && '' != settings.rea_text_link ) {
            #>
            <a href="{{ settings.rea_text_link.url }}" class="rea-infobox-module-link"></a>
            <# } #>
            <# render_image( 'left' ); #>
            <div class="rea-infobox__content">
                <# render_image( 'above-title' ); #>
                <# if( 'after_icon' == settings.rea_separator_position ) {
                render_separator();
                } #>
                <# render_title(); #>
                <# if( 'after_heading' == settings.rea_separator_position ) {
                render_separator();
                } #>
                <# render_image( 'below-title' ); #>
                <# if( '' != settings.rea_description ) { #>
                    <div class="rea-infobox__description-wrapper">
                        <# view.addRenderAttribute('rea_description', 'class', 'rea-infobox__description'); #>
                        <# view.addInlineEditingAttributes('rea_description', 'advanced'); #>
                        <div {{{ view.getRenderAttributeString(
                        'rea_description') }}}>
                        {{{ settings.rea_description }}}
                    </div>
                <# } #>
                <# if( 'after_description' == settings.rea_separator_position ) {
                render_separator();
                } #>
                <# render_link(); #>
            </div>
        </div>
        <# render_image( 'right' ); #>
        </div>
        </div>
        <#
        }
        #>

        <#
        function render_image( position ) {
        var set_pos = '';
        var media_img = '';
        var anim_class = '';
        if ( 'icon' == settings.rea_image_type || 'photo' == settings.rea_image_type ) {
        var set_pos = settings.rea_image_position;
        }
        if ( position == set_pos ) {
        if ( 'icon' == settings.rea_image_type || 'photo' == settings.rea_image_type ) {

        if( 'normal' != settings.rea_imgicon_style ) {
        anim_class = 'elementor-animation-' + settings.rea_imgicon_animation;
        } else if ( 'normal' == settings.rea_imgicon_style ) {
        anim_class = 'elementor-animation-' + settings.rea_imgicon_animation;
        } #>
        <div class="rea-infobox-widget-content rea-infobox__imgicon-wrapper">
            <# if ( 'icon' == settings.rea_image_type ) { #>
        <?php if (self::is_elementor_updated() ) { ?>
                <# if ( settings.rea_select_icon || settings.rea_new_select_icon ) {
                var iconHTML = elementor.helpers.renderIcon( view, settings.rea_new_select_icon, { 'aria-hidden': true }, 'i' , 'object' );

                var migrated = elementor.helpers.isIconMigrated( settings, 'rea_new_select_icon' );

                #>
                <div class="rea-infobox__icon-wrapper {{ anim_class }} ">
                                    <span class="rea-infobox__icon">
                                        <# if ( iconHTML && iconHTML.rendered && ( ! settings.rea_select_icon || migrated ) ) {
                                        #>
                                            {{{ iconHTML.value }}}
                                        <# } else { #>
                                            <i class="{{ settings.rea_select_icon }}" aria-hidden="true"></i>
                                        <# } #>
                                    </span>
                </div>
                <# } #>
        <?php } else { ?>
                <div class="rea-infobox__icon-wrapper {{ anim_class }} ">
                                <span class="rea-infobox__icon">
                                    <i class="{{ settings.rea_select_icon }}" aria-hidden="true"></i>
                                </span>
                </div>
        <?php } ?>
            <# }
            if ( 'photo' == settings.rea_image_type ) {
            #>
            <div class="rea-infobox__image" itemscope itemtype="http://schema.org/ImageObject">
                <div class="rea-infobox__image-content {{ anim_class }} ">
                    <#
                    if ( 'media' == settings.rea_photo_type ) {
                    if ( '' != settings.rea_image.url ) {

                    var media_image = {
                    id: settings.rea_image.id,
                    url: settings.rea_image.url,
                    size: settings.rea_image_size,
                    dimension: settings.rea_image_custom_dimension,
                    model: view.getEditModel()
                    };
                    media_img = elementor.imagesManager.getImageUrl( media_image );
                    #>
                    <img src="{{{ media_img }}}">
                    <#
                    }
                    }
                    if ( 'url' == settings.rea_photo_type ) {
                    if ( '' != settings.rea_image_link ) {
                    view.addRenderAttribute( 'rea_image_link', 'src', settings.rea_image_link.url );
                    #>
                    <img {{{ view.getRenderAttributeString( 'rea_image_link' ) }}}>
                    <#
                    }
                    } #>
                </div>
            </div>
            <# } #>
        </div>
        <#
        }
        }
        }
        #>

        <#
        function render_title() {
        var flag = false;
        if ( ( 'photo' == settings.rea_image_type && 'left-title' == settings.rea_image_position ) || ( 'icon' == settings.rea_image_type && 'left-title' == settings.rea_image_position ) ) {
        #>
        <div class="rea-infobox-image--left-of-heading">
            <#
            flag = true;
            }
            if ( ( 'photo' == settings.rea_image_type && 'right-title' == settings.rea_image_position ) || ( 'icon' ==
            settings.rea_image_type && 'right-title' == settings.rea_image_position ) ) {
            #>
            <div class="rea-infobox-image--right-of-heading">
                <#
                flag = true;
                } #>
                <# render_image( 'left-title' ); #>
                <div class='rea-infobox__title-wrapper'>
                <# view.addRenderAttribute('rea_title', 'class', 'rea-infobox__title'); #>
                <# view.addInlineEditingAttributes('rea_title', 'basic'); #>

                <{{{ settings.rea_title_tag }}} {{{ view.getRenderAttributeString('rea_title') }}}>
                {{{ settings.rea_title }}}
            </
            {{{ settings.rea_title_tag }}}>
        </div>
        <# render_image( 'right-title' ); #>
        <# if ( flag ) { #>
        </div>
        <# }
        }
        #>

        <#
        function render_link() {

        if ( 'link' == settings.rea_cta_type ) {
        #>
        <div class="rea-infobox__cta-link-style">
            <a href="{{ settings.rea_text_link.url }}" class="rea-infobox__cta-link">
                <#
                if ( 'left' == settings.rea_button_icon_position ) {
                #>
                <span class="rea-infobox__link-icon rea-infobox__link-icon--before">
                                <?php if (self::is_elementor_updated() ) { ?>
                                    <#
                                    var buttoniconHTML = elementor.helpers.renderIcon( view, settings.rea_new_button_icon, { 'aria-hidden': true }, 'i' , 'object' );

                                    var buttonMigrated = elementor.helpers.isIconMigrated( settings, 'rea_new_button_icon' );
                                    #>
                                    <# if ( buttoniconHTML && buttoniconHTML.rendered && ( ! settings.rea_button_icon || buttonMigrated ) ) { #>
                                    {{{ buttoniconHTML.value }}}
                                    <# } else { #>
                                    <i class="{{ settings.rea_button_icon }}"></i>
                                    <# } #>
                                <?php } else { ?>
                                    <i class="{{ settings.rea_button_icon }}"></i>
                                <?php } ?>
                            </span>
                <# } #>
                <# view.addInlineEditingAttributes('rea_link_text', 'basic'); #>
                <span {{ view.getRenderAttributeString('rea_link_text') }}>
                {{{ settings.rea_link_text }}}
                </span>

                <# if ( 'right' == settings.rea_button_icon_position ) {
                #>
                <span class="rea-infobox__link-icon rea-infobox__link-icon--after">
                                <?php if (self::is_elementor_updated() ) { ?>
                                    <#
                                    var buttoniconHTML = elementor.helpers.renderIcon( view, settings.rea_new_button_icon, { 'aria-hidden': true }, 'i' , 'object' );

                                    var buttonMigrated = elementor.helpers.isIconMigrated( settings, 'rea_new_button_icon' );
                                    #>
                                    <# if ( buttoniconHTML && buttoniconHTML.rendered && ( ! settings.rea_button_icon || buttonMigrated ) ) { #>
                                    {{{ buttoniconHTML.value }}}
                                    <# } else { #>
                                    <i class="{{ settings.rea_button_icon }}"></i>
                                    <# } #>
                                <?php } else { ?>
                                    <i class="{{ settings.rea_button_icon }}"></i>
                                <?php } ?>
                            </span>
                <# } #>
            </a>
        </div>
        <# }
        else if ( 'button' == settings.rea_cta_type ) {

        view.addRenderAttribute( 'rea_btn_wrapper', 'class', 'rea-infobox-button-wrapper elementor-button-wrapper' );
        if ( '' != settings.rea_text_link.url ) {
        view.addRenderAttribute( 'rea_button', 'href', settings.rea_text_link.url );
        view.addRenderAttribute( 'rea_button', 'class', 'elementor-button-link' );
        }
        view.addRenderAttribute( 'rea_button', 'class', 'elementor-button' );

        if ( '' != settings.rea_button_size ) {
        view.addRenderAttribute( 'rea_button', 'class', 'elementor-size-' + settings.rea_button_size );
        }

        if ( settings.rea_button_animation ) {
        view.addRenderAttribute( 'rea_button', 'class', 'elementor-animation-' + settings.rea_button_animation );
        } #>
        <div {{{ view.getRenderAttributeString( 'rea_btn_wrapper' ) }}}>
        <a {{{ view.getRenderAttributeString( 'rea_button' ) }}}>
        <#
        view.addRenderAttribute( 'rea_infobox_content', 'class', 'elementor-button-content-wrapper' );

        view.addRenderAttribute( 'icon-align', 'class', 'elementor-align-icon-' + settings.rea_button_icon_position );

        view.addRenderAttribute( 'icon-align', 'class', 'elementor-button-icon' );

        view.addRenderAttribute( 'rea_infobox_button_text', 'class', 'elementor-button-text' );

        view.addInlineEditingAttributes( 'rea_infobox_button_text', 'none' );

        #>
        <span {{{ view.getRenderAttributeString( 'rea_infobox_content' ) }}}>
        <?php if (self::is_elementor_updated() ) { ?>
        <# if ( settings.rea_button_icon || settings.rea_new_button_icon ) { #>
        <span {{{ view.getRenderAttributeString( 'icon-align' ) }}}>
        <#
        var buttoniconHTML = elementor.helpers.renderIcon( view, settings.rea_new_button_icon, { 'aria-hidden': true }, 'i' , 'object' );

        var buttonMigrated = elementor.helpers.isIconMigrated( settings, 'rea_new_button_icon' );
        #>
        <# if ( buttoniconHTML && buttoniconHTML.rendered && ( ! settings.rea_button_icon || buttonMigrated ) ) { #>
        {{{ buttoniconHTML.value }}}
        <# } else { #>
        <i class="{{ settings.rea_button_icon }}"></i>
        <# } #>
        </span>
        <# } #>
        <?php } else { ?>
        <span {{{ view.getRenderAttributeString( 'icon-align' ) }}}>
        <i class="{{ settings.rea_button_icon }}"></i>
        </span>
        <?php } ?>
        <span {{{ view.getRenderAttributeString( 'rea_infobox_button_text' ) }}}>
        {{ settings.rea_button_text }}
        </span>
        </span>
        </a>
        </div>
        <#
        }
        }
        #>

        <#
        function render_separator() {
        if ( 'yes' == settings.rea_toggle_separator ) { #>
        <div class="rea-infobox__separator-wrapper">
            <div class="rea-infobox__separator"></div>
        </div>
        <# }
        }

        widget_template();
        #>

        <?php
    }
}
