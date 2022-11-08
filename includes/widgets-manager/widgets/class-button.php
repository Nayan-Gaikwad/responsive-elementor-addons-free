<?php
/**
 * Button Widget
 *
 * @category Widget
 * @package  Responsive_Elementor_Addons
 * @author   CyberChimps <support@cyberchimps.com>
 * @link     https://www.cyberchimps.com
 * @since    1.0.0
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Widgets;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor 'Button' widget.
 *
 * Elementor widget that displays an 'Button' with lightbox.
 *
 * @category Widget
 * @package  Responsive_Elementor_Addons
 * @author   CyberChimps <support@cyberchimps.com>
 * @link     https://www.cyberchimps.com
 * @since    1.0.0
 */
class Button extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve 'Button' widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function getName()
    {
        return 'rea-button';
    }

    /**
     * Get widget title.
     *
     * Retrieve 'Button' widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function getTitle()
    {
        return __('REA Button', 'responsive-elementor-addons');
    }

    /**
     * Get widget icon.
     *
     * Retrieve 'Button' widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function getIcon()
    {
        return 'eicon-button rea-badge';
    }

    /**
     * Get widget categories.
     *
     * Retrieve 'Button' widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function getCategories()
    {
        return array( 'responsive-elementor-addon' );
    }

    /**
     * Register 'Button' widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     * @return void
     */
    protected function registerControls()
    {
        // Section button_section.

        $this->start_controls_section(
            'button_section',
            array(
            'label' => __('Button', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'label',
            array(
            'label'   => __('Button label', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => 'Read More',
            )
        );

        $this->add_control(
            'link',
            array(
            'label'         => __('Link', 'responsive-elementor-addons'),
            'description'   => __('If you want to link your button.', 'responsive-elementor-addons'),
            'type'          => Controls_Manager::URL,
            'placeholder'   => 'https://your-link.com',
            'show_external' => true,
            'dynamic'       => array(
            'active' => true,
            ),
            )
        );

        $this->add_control(
            'open_video_in_lightbox',
            array(
            'label'        => __('Open Video in Lightbox', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('On', 'responsive-elementor-addons'),
            'label_off'    => __('Off', 'responsive-elementor-addons'),
            'return_value' => 'yes',
            'default'      => '',
            )
        );

        $this->end_controls_section();

        // Section general_section.

        $this->start_controls_section(
            'general_section',
            array(
            'label' => __('Wrapper', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'size',
            array(
            'label'   => __('Button size', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'medium',
            'options' => array(
            'exlarge' => __('Exlarge', 'responsive-elementor-addons'),
            'large'   => __('Large', 'responsive-elementor-addons'),
            'medium'  => __('Medium', 'responsive-elementor-addons'),
            'small'   => __('Small', 'responsive-elementor-addons'),
            'tiny'    => __('Tiny', 'responsive-elementor-addons'),
            ),
            )
        );

        $this->add_control(
            'uppercase',
            array(
            'label'        => __('Uppercase label', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('On', 'responsive-elementor-addons'),
            'label_off'    => __('Off', 'responsive-elementor-addons'),
            'return_value' => 'yes',
            'default'      => 'yes',
            )
        );

        $this->add_control(
            'border',
            array(
            'label'   => __('Button shape', 'responsive-elementor-addons'),
            'type'    => 'rea-visual-select',
            'options' => array(
            'none'  => array(
            'label' => __('Box', 'responsive-elementor-addons'),
            'image' => REA_ASSETS_URL . 'images/visual-select/button-normal.svg',
                    ),
                    'round' => array(
                        'label' => __('Round', 'responsive-elementor-addons'),
                        'image' => REA_ASSETS_URL . 'images/visual-select/button-curved.svg',
                    ),
                    'curve' => array(
                        'label' => __('Curve', 'responsive-elementor-addons'),
                        'image' => REA_ASSETS_URL . 'images/visual-select/button-rounded.svg',
                    ),
            ),
            'default' => 'none',
            )
        );

        $this->add_control(
            'style',
            array(
            'label'   => __('Button style', 'responsive-elementor-addons'),
            'type'    => 'rea-visual-select',
            'options' => array(
            'none'    => array(
            'label' => __('Normal', 'responsive-elementor-addons'),
            'image' => REA_ASSETS_URL . 'images/visual-select/button-normal.svg',
                    ),
                    '3d'      => array(
                        'label' => __('3D', 'responsive-elementor-addons'),
                        'image' => REA_ASSETS_URL . 'images/visual-select/button-3d.svg',
                    ),
                    'outline' => array(
                        'label' => __('Outline', 'responsive-elementor-addons'),
                        'image' => REA_ASSETS_URL . 'images/visual-select/button-outline.svg',
                    ),
            ),
            'default' => 'none',
            )
        );

        $this->add_responsive_control(
            'align',
            array(
            'label'     => __('Align', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => array(
            'left'   => array(
            'title' => __('Left', 'responsive-elementor-addons'),
            'icon'  => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => __('Center', 'responsive-elementor-addons'),
                        'icon'  => 'fa fa-align-center',
                    ),
                    'right'  => array(
                        'title' => __('Right', 'responsive-elementor-addons'),
                        'icon'  => 'fa fa-align-right',
                    ),
            ),
            'default'   => 'center',
            'toggle'    => true,
            'selectors' => array(
                    '{{WRAPPER}}' => 'text-align: {{VALUE}}',
            ),
            )
        );

        $this->add_responsive_control(
            'button_padding',
            array(
            'label'      => __('Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
            '{{WRAPPER}} .rea-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->end_controls_section();

        // Section sking_section.

        $this->start_controls_section(
            'sking_section',
            array(
            'label' => __('Skin', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'color_name',
            array(
            'label'   => __('Skin', 'responsive-elementor-addons'),
            'type'    => 'rea-visual-select',
            'default' => 'carmine-pink',
            'options' => $this->reaGetFamousColorsList(),
            )
        );

        $this->start_controls_tabs('button_background');

        $this->start_controls_tab(
            'button_bg_normal',
            array(
            'label' => __('Normal', 'responsive-elementor-addons'),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
            'name'     => 'background',
            'label'    => __('Background', 'responsive-elementor-addons'),
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .rea-button',
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
            'name'     => 'box_shadow',
            'selector' => '{{WRAPPER}} .rea-button',
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_bg_hover',
            array(
            'label' => __('Hover', 'responsive-elementor-addons'),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
            'name'     => 'hover_background',
            'label'    => __('Background', 'responsive-elementor-addons'),
            'types'    => array( 'classic', 'gradient' ),
            'selector' => '{{WRAPPER}} .rea-button:hover',
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
            'name'     => 'hover_box_shadow',
            'selector' => '{{WRAPPER}} .rea-button:hover',
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // Section icon_section.

        $this->start_controls_section(
            'icon_section',
            array(
            'label' => __('Icon', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'rea_button_icon',
            array(
            'label' => __('Icon for button', 'responsive-elementor-addons'),
            'type'  => Controls_Manager::ICONS,
            )
        );

        $this->add_control(
            'icon_align',
            array(
            'label'   => __('Icon alignment', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::SELECT,
            'default' => 'default',
            'options' => array(
            'default'       => __('Default', 'responsive-elementor-addons'),
            'left'          => __('Left', 'responsive-elementor-addons'),
            'right'         => __('Right', 'responsive-elementor-addons'),
            'over'          => __('Over', 'responsive-elementor-addons'),
            'left-animate'  => __('Animate from Left', 'responsive-elementor-addons'),
            'right-animate' => __('Animate from Right', 'responsive-elementor-addons'),
            ),
            )
        );

        $this->add_responsive_control(
            'btn_icon_size',
            array(
            'label'      => __('Icon Size', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
            'px' => array(
            'min'  => 10,
            'max'  => 512,
            'step' => 2,
                    ),
                    '%'  => array(
                        'min' => 0,
                        'max' => 100,
                    ),
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .rea-icon'       => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .rea-button svg' => 'height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
            ),
            )
        );

        $this->add_responsive_control(
            'icon_margin',
            array(
            'label'      => __('Icon Margin', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
            '{{WRAPPER}} .rea-icon, {{WRAPPER}} .rea-button svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->start_controls_tabs('button_icon_color');

        $this->start_controls_tab(
            'icon_color_normal',
            array(
            'label' => __('Normal', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'icon_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-icon'       => 'color: {{VALUE}};',
            '{{WRAPPER}} .rea-button svg' => 'fill: {{VALUE}};',
            ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'icon_color_hover',
            array(
            'label' => __('Hover', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'hover_icon_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-button:hover .rea-icon' => 'color: {{VALUE}};',
            '{{WRAPPER}} .rea-button:hover svg' => 'fill: {{VALUE}};',
            ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_padding',
            array(
            'label'      => __('Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
            '{{WRAPPER}} .rea-icon, {{WRAPPER}} .rea-button svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->end_controls_section();

        // Section text_section.

        $this->start_controls_section(
            'text_section',
            array(
            'label' => __('Text', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->start_controls_tabs('button_text');

        $this->start_controls_tab(
            'button_text_normal',
            array(
            'label' => __('Normal', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'text_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-text' => 'color: {{VALUE}};',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            array(
            'name'     => 'text_shadow',
            'label'    => __('Text Shadow', 'responsive-elementor-addons'),
            'selector' => '{{WRAPPER}} .rea-button',
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'     => 'text_typography',
            'scheme'   => Typography::TYPOGRAPHY_1,
            'selector' => '{{WRAPPER}} .rea-text',
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_text_hover',
            array(
            'label' => __('Hover', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'hover_text_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-button:hover .rea-text' => 'color: {{VALUE}};',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            array(
            'name'     => 'hover_text_shadow',
            'label'    => __('Text Shadow', 'responsive-elementor-addons'),
            'selector' => '{{WRAPPER}} .rea-button:hover',
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'     => 'hover_text_typography',
            'scheme'   => Typography::TYPOGRAPHY_1,
            'selector' => '{{WRAPPER}} .rea-text',
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Render image box widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     * @return array
     */
    protected function render()
    {

        $settings = $this->get_settings_for_display();

        $icon_value = ! empty($settings['rea_button_icon']['value']) ? $settings['rea_button_icon']['value'] : ( ! empty($settings['icon']) ? $settings['icon'] : '' );

        $btn_target = $settings['link']['is_external'] ? '_blank' : '_self';

        $args = array(
        'label'                  => $settings['label'],
        'size'                   => $settings['size'],
        'border'                 => $settings['border'],
        'style'                  => $settings['style'],
        'uppercase'              => $settings['uppercase'],
        'icon'                   => $icon_value,
        'icon_align'             => $settings['icon_align'],
        'color_name'             => $settings['color_name'],
        'link'                   => $settings['link']['url'],
        'nofollow'               => $settings['link']['nofollow'],
        'target'                 => $btn_target,
        'open_video_in_lightbox' => $settings['open_video_in_lightbox'],
        );

        echo $this->reaWidgetButtonCallback($args);
    }

    /**
     * Render button widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @param array  $atts              Attributes
     * @param string $shortcode_content .
     *
     * @since  1.0.0
     * @return String
     */
    public function reaWidgetButtonCallback( $atts = array(), $shortcode_content = null )
    {

        // Defining default attributes.
        $default_atts = array(
        'label'                  => '',
        'size'                   => 'medium',
        'border'                 => '',
        'style'                  => '',
        'uppercase'              => '1',
        'dark'                   => '0',
        'icon'                   => '',
        'icon_align'             => 'default',
        'color_name'             => 'carmine-pink',
        'link'                   => '',
        'target'                 => '_self',
        'nofollow'               => false,
        'btn_attrs'              => '', // data-attr1{val1};data-attr2{val2}.
        'custom_styles'          => array(),
        'extra_classes'          => '', // custom css class names for this element.
        'custom_el_id'           => '',
        'base_class'             => 'rea-widget-button',
        'open_video_in_lightbox' => false,
        );

        // Parse shortcode attributes.
        $parsed_atts = shortcode_atts($default_atts, $atts, __FUNCTION__);
        extract($parsed_atts); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract

        // --------------------------------------------
        $btn_css_classes   = array( 'rea-button' );
        $btn_css_classes[] = 'rea-' . $size;    // size.
        $btn_css_classes[] = 'rea-' . $color_name;   // appearance.

        if ($border ) {
            $btn_css_classes[] = 'rea-' . $border;  // border form.
        }
        if ($style ) {
            $btn_css_classes[] = 'rea-' . $style;   // appearance.
        }
        if ($this->reaIsTrue($uppercase) ) {
            $btn_css_classes[] = 'rea-uppercase';   // text form.
        }
        if ($this->reaIsTrue($dark) ) {
            $btn_css_classes[] = 'rea-dark-text';   // text color.
        }
        if ('default' != $icon_align ) {
            $btn_css_classes[] = 'rea-icon-' . $icon_align;   // icon align.
        }

        // add extra attributes to button element if defined.
        $btn_other_attrs = '';

        if ($btn_attrs = trim($btn_attrs, ';') ) { // phpcs:ignore WordPress.CodeAnalysis.AssignmentInCondition.Found, Squiz.PHP.DisallowMultipleAssignments.FoundInControlStructure
            preg_match_all('/([\-|\w]+)(?!{})([\w]+)/s', $btn_attrs, $btn_attr_matches);

            if (! empty($btn_attr_matches[0]) && is_array($btn_attr_matches[0]) ) {
                foreach ( $btn_attr_matches[0] as $i => $attr_name_value ) {
                    if (0 == $i % 2 ) {
                        $btn_other_attrs .= sprintf(' %s', $attr_name_value);
                    } else {
                        $btn_other_attrs .= sprintf('="%s"', esc_attr(trim($attr_name_value)));
                    }
                }
                $btn_other_attrs = trim($btn_other_attrs);
            }
        }

        $extra_styles = '';

        if (isset($custom_styles) && ! empty($custom_styles) ) {

            foreach ( $custom_styles as $property => $value ) {
                if ('custom' == $property ) {
                    $extra_styles .= $value;
                } else {
                    $extra_styles .= $property . ':' . $value . ';';
                }
            }

            $extra_styles = 'style="' . $extra_styles . '"';

        }

        if (! empty($extra_classes) ) {
            $btn_css_classes[] = $extra_classes;
        }

        if ($this->reaIsTrue($open_video_in_lightbox) ) {
            $btn_css_classes[] = 'rea-open-video';
            $btn_other_attrs  .= ' data-type="video"';
        }

        // get escaped class attributes.
        $button_class_attr = $this->reaMakeHtmlClassAttribute($btn_css_classes);

        $label = empty($label) ? $shortcode_content : $label;
        $label = empty($label) ? __('Button', 'responsive-elementor-addons') : $label;

        $btn_content = '<span class="rea-overlay"></span>';
        $btn_label   = '<span class="rea-text">' . $this->reaDoCleanupShortcode($label) . '</span>';
        if ('array' === gettype($icon) ) {
            $btn_icon = Icons_Manager::render_uploaded_svg_icon($icon);
        } else {
            $btn_icon = '<span class="rea-icon ' . esc_attr($icon) . '"></span>';
        }

        // if icon is aligned on left.
        if (false != strpos($icon_align, 'left') ) {
            $btn_content .= $btn_icon . $btn_label;
        } else {
            $btn_content .= $btn_label . $btn_icon;
        }

        $btn_tag  = empty($link) ? 'button' : 'a';
        $btn_rel  = $this->reaIsTrue($nofollow) ? ' rel="nofollow"' : '';
        $btn_href = empty($link) ? '' : ' href="' . $link . '" target="' . esc_attr($target) . '" ' . $btn_rel;

        $output = '';

        // widget custom output.
        $output .= "<$btn_tag $btn_href $btn_other_attrs $button_class_attr $extra_styles>";
        $output .= $btn_content;
        $output .= "</$btn_tag>";

        if ($this->reaIsTrue($open_video_in_lightbox) ) {
            $output = '<span class="rea-lightbox-video ">' . $output . '</span>';
        }
        return $output;
    }

    /**
     * Sets flag
     *
     * @param boolean $var .
     *
     * @return boolean
     */
    public function reaIsTrue( $var )
    {
        if (is_bool($var) ) {
            return $var;
        }

        if (is_string($var) ) {
            $var = strtolower($var);
            if (in_array($var, array( 'yes', 'on', 'true', 'checked' )) ) {
                return true;
            }
        }

        if (is_numeric($var) ) {
            return (bool) $var;
        }

        return false;
    }

    /**
     * Cleanup Shortcode
     *
     * @param string $content Content.
     *
     * @return mixed|string
     */
    public function reaDoCleanupShortcode( $content )
    {

        /* Parse nested shortcodes and add formatting. */
        $content = trim(wpautop(do_shortcode($content)));

        /* Remove any instances of '<p>' '</p>'. */
        $content = $this->reaCleanupContent($content);

        return $content;
    }

    /**
     * Cleanup Content
     *
     * @param string $content Content.
     *
     * @return string
     */
    public function reaCleanupContent( $content )
    {
        /* Remove any instances of '<p>' '</p>'. */
        return str_replace(array( '<p>', '</p>' ), array( '', '' ), $content);
    }

    /**
     * Creates and returns an HTML class attribute
     *
     * @param array        $classes List of current classes.
     * @param string|array $class   One or more classes to add to the class list.
     *
     * @return string                  HTML class attribute
     */
    public function reaMakeHtmlClassAttribute( $classes = '', $class = '' )
    {

        if (! $merged_classes = $this->reaMergeCssClasses($classes, $class) ) { // phpcs:ignore WordPress.CodeAnalysis.AssignmentInCondition.Found, Squiz.PHP.DisallowMultipleAssignments.FoundInControlStructure
            return '';
        }

        return 'class="' . esc_attr(trim(join(' ', array_unique($merged_classes)))) . '"';
    }

    /**
     * Merge CSS classes
     *
     * @param array  $classes .
     * @param string $class   .
     *
     * @return array CSS classes
     */
    public function reaMergeCssClasses( $classes = array(), $class = '' )
    {

        if (empty($classes) && empty($class) ) {
            return array();
        }

        if (! empty($class) ) {
            if (! is_array($class) ) {
                $class = preg_split('#\s+#', $class);
            }

            $classes = array_merge($class, $classes);
        }

        return $classes;
    }

    /**
     * Get Famous colors list
     *
     * @return array Colors
     */
    public function reaGetFamousColorsList()
    {
        return array(
        'black'           => array(
        'label'     => __('black', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-black',
        ),
        'white'           => array(
        'label'     => __('White', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-white',
        ),
        'masala'          => array(
        'label'     => __('Masala', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-masala',
        ),
        'dark-gray'       => array(
        'label'     => __('Dark Gray', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-dark-gray',
        ),
        'ball-blue'       => array(
        'label'     => __('Ball Blue', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-ball-blue',
        ),
        'fountain-blue'   => array(
        'label'     => __('Fountain Blue', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-fountain-blue',
        ),
        'shamrock'        => array(
        'label'     => __('Shamrock', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-shamrock',
        ),
        'curios-blue'     => array(
        'label'     => __('Curios Blue', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-curios-blue',
        ),
        'light-sea-green' => array(
        'label'     => __('Light Sea Green', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-light-sea-green',
        ),
        'emerald'         => array(
        'label'     => __('Emerald', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-emerald',
        ),
        'energy-yellow'   => array(
        'label'     => __('Energy Yellow', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-energy-yellow',
        ),
        'mikado-yellow'   => array(
        'label'     => __('Mikado Yellow', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-mikado-yellow',
        ),
        'pink-salmon'     => array(
        'label'     => __('Pink Salmon', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-pink-salmon',
        ),
        'wisteria'        => array(
        'label'     => __('Wisteria', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-wisteria',
        ),
        'lilac'           => array(
        'label'     => __('Lilac', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-lilac',
        ),
        'pale-sky'        => array(
        'label'     => __('Pale Sky', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-pale-sky',
        ),
        'tower-gray'      => array(
        'label'     => __('Tower Gray', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-tower-gray',
        ),

        'william'         => array(
        'label'     => __('William', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-william',
        ),
        'carmine-pink'    => array(
        'label'     => __('Carmine Pink', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-carmine-pink',
        ),
        'persimmon'       => array(
        'label'     => __('Persimmon', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-persimmon',
        ),
        'tan-hide'        => array(
        'label'     => __('Tan Hide', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-tan-hide',
        ),
        'wild-watermelon' => array(
        'label'     => __('Wild Watermelon', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-wild-watermelon',
        ),
        'iceberg'         => array(
        'label'     => __('Iceberg', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-iceberg',
        ),

        'dark-lavender'   => array(
        'label'     => __('Dark Lavender', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-dark-lavender',
        ),
        'viking'          => array(
        'label'     => __('Viking', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-viking',
        ),
        'tiffany-blue'    => array(
        'label'     => __('Tiffany Blue', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-tiffany-blue',
        ),
        'pastel-orange'   => array(
        'label'     => __('Pastel Orange', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-pastel-orange',
        ),
        'east-bay'        => array(
        'label'     => __('East Bay', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-east-bay',
        ),
        'steel-blue'      => array(
        'label'     => __('Steel Blue', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-steel-blue',
        ),
        'half-backed'     => array(
        'label'     => __('Half Backed', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-half-backed',
        ),
        'tapestry'        => array(
        'label'     => __('Tapestry', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-tapestry',
        ),
        'fire-engine-red' => array(
        'label'     => __('Fire Engine Red', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-fire-engine-red',
        ),
        'dark-orange'     => array(
        'label'     => __('Dark Orange', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-dark-orange',
        ),
        'brick-red'       => array(
        'label'     => __('Brick Red', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-brick-red',
        ),
        'khaki'           => array(
        'label'     => __('Khaki', 'responsive-elementor-addons'),
        'css_class' => 'rea-color-selector rea-button rea-visual-selector-khaki',
        ),
        );
    }

    /**
     * Get Custom help URL
     *
     * @return string help URL
     */
    public function getCustomHelpUrl()
    {
        return 'https://docs.cyberchimps.com/responsive-elementor-addons/rea-button';
    }
}
