<?php
/**
 * Pricing Table Widget
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;

if (! defined('ABSPATH') ) {
    exit;   // Exit if accessed directly.
}

/**
 * Elementor 'Pricing Table' widget.
 *
 * Elementor widget that displays an Pricing Table.
 *
 * @since 1.0.0
 */
class Pricing_Table extends Widget_Base
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
        return 'rea-pricing-table';
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
        return __('REA Pricing Table', 'responsive-elementor-addons');
    }

    /**
     * Get widget icon.
     *
     * Retrieve Pricing Table widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function getIcon()
    {
        return 'eicon-price-table rea-badge';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the pricing table widget belongs to.
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
     * Register all the control settings for the pricing table
     *
     * @since  1.0.0
     * @access public
     */
    protected function registerControls()
    {
        $this->start_controls_section(
            'section_header',
            array(
            'label' => __('Header', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'heading',
            array(
            'label'   => __('Title', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('Enter title', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'sub_heading',
            array(
            'label'   => __('Description', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('Enter description', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'heading_tag',
            array(
            'label'   => __('Title HTML Tag', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::SELECT,
            'options' => array(
            'h2' => 'H2',
            'h3' => 'H3',
            'h4' => 'H4',
            'h5' => 'H5',
            'h6' => 'H6',
            ),
            'default' => 'h3',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pricing',
            array(
            'label' => __('Pricing', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'currency_symbol',
            array(
            'label'   => __('Currency Symbol', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::SELECT,
            'options' => array(
            ''             => __('None', 'responsive-elementor-addons'),
            'dollar'       => '&#36; ' . _x('Dollar', 'Currency Symbol', 'responsive-elementor-addons'),
            'euro'         => '&#128; ' . _x('Euro', 'Currency Symbol', 'responsive-elementor-addons'),
            'baht'         => '&#3647; ' . _x('Baht', 'Currency Symbol', 'responsive-elementor-addons'),
            'franc'        => '&#8355; ' . _x('Franc', 'Currency Symbol', 'responsive-elementor-addons'),
            'guilder'      => '&fnof; ' . _x('Guilder', 'Currency Symbol', 'responsive-elementor-addons'),
            'krona'        => 'kr ' . _x('Krona', 'Currency Symbol', 'responsive-elementor-addons'),
            'lira'         => '&#8356; ' . _x('Lira', 'Currency Symbol', 'responsive-elementor-addons'),
            'peseta'       => '&#8359 ' . _x('Peseta', 'Currency Symbol', 'responsive-elementor-addons'),
            'peso'         => '&#8369; ' . _x('Peso', 'Currency Symbol', 'responsive-elementor-addons'),
            'pound'        => '&#163; ' . _x('Pound Sterling', 'Currency Symbol', 'responsive-elementor-addons'),
            'real'         => 'R$ ' . _x('Real', 'Currency Symbol', 'responsive-elementor-addons'),
            'ruble'        => '&#8381; ' . _x('Ruble', 'Currency Symbol', 'responsive-elementor-addons'),
            'rupee'        => '&#8360; ' . _x('Rupee', 'Currency Symbol', 'responsive-elementor-addons'),
            'indian_rupee' => '&#8377; ' . _x('Rupee (Indian)', 'Currency Symbol', 'responsive-elementor-addons'),
            'shekel'       => '&#8362; ' . _x('Shekel', 'Currency Symbol', 'responsive-elementor-addons'),
            'yen'          => '&#165; ' . _x('Yen/Yuan', 'Currency Symbol', 'responsive-elementor-addons'),
            'won'          => '&#8361; ' . _x('Won', 'Currency Symbol', 'responsive-elementor-addons'),
            'custom'       => __('Custom', 'responsive-elementor-addons'),
            ),
            'default' => 'dollar',
            )
        );

        $this->add_control(
            'currency_symbol_custom',
            array(
            'label'     => __('Custom Symbol', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::TEXT,
            'condition' => array(
            'currency_symbol' => 'custom',
            ),
            )
        );

        $this->add_control(
            'price',
            array(
            'label'   => __('Price', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => '39.99',
            'dynamic' => array(
            'active' => true,
            ),
            )
        );

        $this->add_control(
            'currency_format',
            array(
            'label'   => __('Currency Format', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::SELECT,
            'options' => array(
            ''  => '1,234.56 (Default)',
            ',' => '1.234,56',
            ),
            )
        );

        $this->add_control(
            'sale',
            array(
            'label'     => __('Sale', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => __('On', 'responsive-elementor-addons'),
            'label_off' => __('Off', 'responsive-elementor-addons'),
            'default'   => '',
            )
        );

        $this->add_control(
            'original_price',
            array(
            'label'     => __('Original Price', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::NUMBER,
            'default'   => '59',
            'condition' => array(
            'sale' => 'yes',
            ),
            'dynamic'   => array(
                    'active' => true,
            ),
            )
        );

        $this->add_control(
            'period',
            array(
            'label'   => __('Period', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('Monthly', 'responsive-elementor-addons'),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_features',
            array(
            'label' => __('Features', 'responsive-elementor-addons'),
            )
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_text',
            array(
            'label'   => __('Text', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('List Item', 'responsive-elementor-addons'),
            )
        );

        $default_icon = array(
        'value'   => 'far fa-check-circle',
        'library' => 'fa-regular',
        );

        $repeater->add_control(
            'selected_item_icon',
            array(
            'label'            => __('Icon', 'responsive-elementor-addons'),
            'type'             => Controls_Manager::ICONS,
            'fa4compatibility' => 'item_icon',
            'default'          => $default_icon,
            )
        );

        $repeater->add_control(
            'item_icon_color',
            array(
            'label'     => __('Icon Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} {{CURRENT_ITEM}} i'   => 'color: {{VALUE}}',
            '{{WRAPPER}} {{CURRENT_ITEM}} svg' => 'fill: {{VALUE}}',
            ),
            )
        );

        $this->add_control(
            'features_list',
            array(
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => array(
            array(
            'item_text'          => __('List Item #1', 'responsive-elementor-addons'),
            'selected_item_icon' => $default_icon,
                    ),
                    array(
                        'item_text'          => __('List Item #2', 'responsive-elementor-addons'),
                        'selected_item_icon' => $default_icon,
                    ),
                    array(
                        'item_text'          => __('List Item #3', 'responsive-elementor-addons'),
                        'selected_item_icon' => $default_icon,
                    ),
            ),
            'title_field' => '{{{ item_text }}}',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_footer',
            array(
            'label' => __('Footer', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'button_text',
            array(
            'label'   => __('Button Text', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::TEXT,
            'default' => __('Click Here', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'link',
            array(
            'label'       => __('Link', 'responsive-elementor-addons'),
            'type'        => Controls_Manager::URL,
            'placeholder' => __('https://your-link.com', 'responsive-elementor-addons'),
            'default'     => array(
            'url' => '#',
            ),
            'dynamic'     => array(
                    'active' => true,
            ),
            )
        );

        $this->add_control(
            'footer_additional_info',
            array(
            'label'   => __('Additional Info', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __('This is text element', 'responsive-elementor-addons'),
            'rows'    => 3,
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_ribbon',
            array(
            'label' => __('Ribbon', 'responsive-elementor-addons'),
            )
        );

        $this->add_control(
            'show_ribbon',
            array(
            'label'     => __('Show', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
            )
        );

        $this->add_control(
            'ribbon_title',
            array(
            'label'     => __('Title', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::TEXT,
            'default'   => __('Popular', 'responsive-elementor-addons'),
            'condition' => array(
            'show_ribbon' => 'yes',
            ),
            )
        );

        $this->add_control(
            'ribbon_horizontal_position',
            array(
            'label'     => __('Position', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => array(
            'left'  => array(
            'title' => __('Left', 'responsive-elementor-addons'),
            'icon'  => 'eicon-h-align-left',
                    ),
                    'right' => array(
                        'title' => __('Right', 'responsive-elementor-addons'),
                        'icon'  => 'eicon-h-align-right',
                    ),
            ),
            'condition' => array(
                    'show_ribbon' => 'yes',
            ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_header_style',
            array(
            'label'      => __('Header', 'responsive-elementor-addons'),
            'tab'        => Controls_Manager::TAB_STYLE,
            'show_label' => false,
            )
        );

        $this->add_control(
            'header_bg_color',
            array(
            'label'     => __('Background Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => array(
            'type'  => Schemes\Color::get_type(),
            'value' => Schemes\Color::COLOR_2,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__header' => 'background-color: {{VALUE}}',
            ),
            )
        );

        $this->add_responsive_control(
            'header_padding',
            array(
            'label'      => __('Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'selectors'  => array(
            '{{WRAPPER}} .rea-price-table__header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->add_control(
            'heading_heading_style',
            array(
            'label'     => __('Title', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            )
        );

        $this->add_control(
            'heading_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-price-table__heading' => 'color: {{VALUE}}',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'     => 'heading_typography',
            'selector' => '{{WRAPPER}} .rea-price-table__heading',
            'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
            )
        );

        $this->add_control(
            'heading_sub_heading_style',
            array(
            'label'     => __('Sub Title', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            )
        );

        $this->add_control(
            'sub_heading_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-price-table__subheading' => 'color: {{VALUE}}',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'     => 'sub_heading_typography',
            'selector' => '{{WRAPPER}} .rea-price-table__subheading',
            'scheme'   => Schemes\Typography::TYPOGRAPHY_2,
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pricing_element_style',
            array(
            'label'      => __('Pricing', 'responsive-elementor-addons'),
            'tab'        => Controls_Manager::TAB_STYLE,
            'show_label' => false,
            )
        );

        $this->add_control(
            'pricing_element_bg_color',
            array(
            'label'     => __('Background Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-price-table__price' => 'background-color: {{VALUE}}',
            ),
            )
        );

        $this->add_responsive_control(
            'pricing_element_padding',
            array(
            'label'      => __('Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'selectors'  => array(
            '{{WRAPPER}} .rea-price-table__price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->add_control(
            'price_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-price-table__currency, {{WRAPPER}} .rea-price-table__integer-part, {{WRAPPER}} .rea-price-table__fractional-part' => 'color: {{VALUE}}',
            ),
            'separator' => 'before',
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'     => 'price_typography',
            'selector' => '{{WRAPPER}} .rea-price-table__price span:not(.rea-price-table__period), {{WRAPPER}} .rea-price-table__price > .rea-price-table__after-price > .rea-price-table__fractional-part',
            'scheme'   => Schemes\Typography::TYPOGRAPHY_1,
            )
        );

        $this->add_control(
            'heading_currency_style',
            array(
            'label'     => __('Currency Symbol', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            'currency_symbol!' => '',
            ),
            )
        );

        $this->add_control(
            'currency_size',
            array(
            'label'     => __('Size', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            'px' => array(
            'min' => 0,
            'max' => 100,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__currency' => 'font-size: calc({{SIZE}}em/100)',
            ),
            'condition' => array(
                    'currency_symbol!' => '',
            ),
            )
        );

        $this->add_control(
            'currency_position',
            array(
            'label'   => __('Position', 'responsive-elementor-addons'),
            'type'    => Controls_Manager::CHOOSE,
            'default' => 'before',
            'options' => array(
            'before' => array(
            'title' => __('Before', 'responsive-elementor-addons'),
            'icon'  => 'eicon-h-align-left',
                    ),
                    'after'  => array(
                        'title' => __('After', 'responsive-elementor-addons'),
                        'icon'  => 'eicon-h-align-right',
                    ),
            ),
            )
        );

        $this->add_control(
            'currency_vertical_position',
            array(
            'label'                => __('Vertical Position', 'responsive-elementor-addons'),
            'type'                 => Controls_Manager::CHOOSE,
            'options'              => array(
            'top'    => array(
            'title' => __('Top', 'responsive-elementor-addons'),
            'icon'  => 'eicon-v-align-top',
                    ),
                    'middle' => array(
                        'title' => __('Middle', 'responsive-elementor-addons'),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'bottom' => array(
                        'title' => __('Bottom', 'responsive-elementor-addons'),
                        'icon'  => 'eicon-v-align-bottom',
                    ),
            ),
            'default'              => 'top',
            'selectors_dictionary' => array(
                    'top'    => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
            ),
            'selectors'            => array(
                    '{{WRAPPER}} .rea-price-table__currency' => 'align-self: {{VALUE}}',
            ),
            'condition'            => array(
                    'currency_symbol!' => '',
            ),
            )
        );

        $this->add_control(
            'fractional_part_style',
            array(
            'label'     => __('Fractional Part', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            )
        );

        $this->add_control(
            'fractional-part_size',
            array(
            'label'     => __('Size', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            'px' => array(
            'min' => 0,
            'max' => 100,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__fractional-part' => 'font-size: calc({{SIZE}}em/100)',
            ),
            )
        );

        $this->add_control(
            'fractional_part_vertical_position',
            array(
            'label'                => __('Vertical Position', 'responsive-elementor-addons'),
            'type'                 => Controls_Manager::CHOOSE,
            'options'              => array(
            'top'    => array(
            'title' => __('Top', 'responsive-elementor-addons'),
            'icon'  => 'eicon-v-align-top',
                    ),
                    'middle' => array(
                        'title' => __('Middle', 'responsive-elementor-addons'),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'bottom' => array(
                        'title' => __('Bottom', 'responsive-elementor-addons'),
                        'icon'  => 'eicon-v-align-bottom',
                    ),
            ),
            'default'              => 'top',
            'selectors_dictionary' => array(
                    'top'    => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
            ),
            'selectors'            => array(
                    '{{WRAPPER}} .rea-price-table__after-price' => 'justify-content: {{VALUE}}',
            ),
            )
        );

        $this->add_control(
            'heading_original_price_style',
            array(
            'label'     => __('Original Price', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            'sale'            => 'yes',
            'original_price!' => '',
            ),
            )
        );

        $this->add_control(
            'original_price_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => array(
            'type'  => Schemes\Color::get_type(),
            'value' => Schemes\Color::COLOR_2,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__original-price' => 'color: {{VALUE}}',
            ),
            'condition' => array(
                    'sale'            => 'yes',
                    'original_price!' => '',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'      => 'original_price_typography',
            'selector'  => '{{WRAPPER}} .rea-price-table__original-price',
            'scheme'    => Schemes\Typography::TYPOGRAPHY_1,
            'condition' => array(
            'sale'            => 'yes',
            'original_price!' => '',
            ),
            )
        );

        $this->add_control(
            'original_price_vertical_position',
            array(
            'label'                => __('Vertical Position', 'responsive-elementor-addons'),
            'type'                 => Controls_Manager::CHOOSE,
            'options'              => array(
            'top'    => array(
            'title' => __('Top', 'responsive-elementor-addons'),
            'icon'  => 'eicon-v-align-top',
                    ),
                    'middle' => array(
                        'title' => __('Middle', 'responsive-elementor-addons'),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'bottom' => array(
                        'title' => __('Bottom', 'responsive-elementor-addons'),
                        'icon'  => 'eicon-v-align-bottom',
                    ),
            ),
            'selectors_dictionary' => array(
                    'top'    => 'flex-start',
                    'middle' => 'center',
                    'bottom' => 'flex-end',
            ),
            'default'              => 'bottom',
            'selectors'            => array(
                    '{{WRAPPER}} .rea-price-table__original-price' => 'align-self: {{VALUE}}',
            ),
            'condition'            => array(
                    'sale'            => 'yes',
                    'original_price!' => '',
            ),
            )
        );

        $this->add_control(
            'heading_period_style',
            array(
            'label'     => __('Period', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            'period!' => '',
            ),
            )
        );

        $this->add_control(
            'period_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => array(
            'type'  => Schemes\Color::get_type(),
            'value' => Schemes\Color::COLOR_2,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__period' => 'color: {{VALUE}}',
            ),
            'condition' => array(
                    'period!' => '',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'      => 'period_typography',
            'selector'  => '{{WRAPPER}} .rea-price-table__period',
            'scheme'    => Schemes\Typography::TYPOGRAPHY_2,
            'condition' => array(
            'period!' => '',
            ),
            )
        );

        $this->add_control(
            'period_position',
            array(
            'label'       => __('Position', 'responsive-elementor-addons'),
            'type'        => Controls_Manager::SELECT,
            'label_block' => false,
            'options'     => array(
            'below'  => __('Below', 'responsive-elementor-addons'),
            'beside' => __('Beside', 'responsive-elementor-addons'),
            ),
            'default'     => 'below',
            'condition'   => array(
                    'period!' => '',
            ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_features_list_style',
            array(
            'label'      => __('Features', 'responsive-elementor-addons'),
            'tab'        => Controls_Manager::TAB_STYLE,
            'show_label' => false,
            )
        );

        $this->add_control(
            'features_list_bg_color',
            array(
            'label'     => __('Background Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'separator' => 'before',
            'selectors' => array(
            '{{WRAPPER}} .rea-price-table__features-list' => 'background-color: {{VALUE}}',
            ),
            )
        );

        $this->add_responsive_control(
            'features_list_padding',
            array(
            'label'      => __('Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'selectors'  => array(
            '{{WRAPPER}} .rea-price-table__features-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->add_control(
            'features_list_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => array(
            'type'  => Schemes\Color::get_type(),
            'value' => Schemes\Color::COLOR_3,
            ),
            'separator' => 'before',
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__features-list' => 'color: {{VALUE}}',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'     => 'features_list_typography',
            'selector' => '{{WRAPPER}} .rea-price-table__features-list li',
            'scheme'   => Schemes\Typography::TYPOGRAPHY_3,
            )
        );

        $this->add_control(
            'features_list_alignment',
            array(
            'label'     => __('Alignment', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::CHOOSE,
            'options'   => array(
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
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__features-list' => 'text-align: {{VALUE}}',
            ),
            )
        );

        $this->add_responsive_control(
            'item_width',
            array(
            'label'     => __('Width', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            '%' => array(
            'min' => 25,
            'max' => 100,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__feature-inner' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
            ),
            )
        );

        $this->add_control(
            'list_divider',
            array(
            'label'     => __('Divider', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'default'   => 'yes',
            'separator' => 'before',
            )
        );

        $this->add_control(
            'divider_style',
            array(
            'label'     => __('Style', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SELECT,
            'options'   => array(
            'solid'  => __('Solid', 'responsive-elementor-addons'),
            'double' => __('Double', 'responsive-elementor-addons'),
            'dotted' => __('Dotted', 'responsive-elementor-addons'),
            'dashed' => __('Dashed', 'responsive-elementor-addons'),
            ),
            'default'   => 'solid',
            'condition' => array(
                    'list_divider' => 'yes',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__features-list li:before' => 'border-top-style: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'divider_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ddd',
            'scheme'    => array(
            'type'  => Schemes\Color::get_type(),
            'value' => Schemes\Color::COLOR_3,
            ),
            'condition' => array(
                    'list_divider' => 'yes',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__features-list li:before' => 'border-top-color: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'divider_weight',
            array(
            'label'     => __('Weight', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'default'   => array(
            'size' => 2,
            'unit' => 'px',
            ),
            'range'     => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 10,
            ),
            ),
            'condition' => array(
                    'list_divider' => 'yes',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__features-list li:before' => 'border-top-width: {{SIZE}}{{UNIT}};',
            ),
            )
        );

        $this->add_control(
            'divider_width',
            array(
            'label'     => __('Width', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'condition' => array(
            'list_divider' => 'yes',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__features-list li:before' => 'margin-left: calc((100% - {{SIZE}}%)/2); margin-right: calc((100% - {{SIZE}}%)/2)',
            ),
            )
        );

        $this->add_control(
            'divider_gap',
            array(
            'label'     => __('Gap', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'default'   => array(
            'size' => 15,
            'unit' => 'px',
            ),
            'range'     => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 50,
            ),
            ),
            'condition' => array(
                    'list_divider' => 'yes',
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__features-list li:before' => 'margin-top: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}}',
            ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_footer_style',
            array(
            'label'      => __('Footer', 'responsive-elementor-addons'),
            'tab'        => Controls_Manager::TAB_STYLE,
            'show_label' => false,
            )
        );

        $this->add_control(
            'footer_bg_color',
            array(
            'label'     => __('Background Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-price-table__footer' => 'background-color: {{VALUE}}',
            ),
            )
        );

        $this->add_responsive_control(
            'footer_padding',
            array(
            'label'      => __('Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'selectors'  => array(
            '{{WRAPPER}} .rea-price-table__footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->add_control(
            'heading_footer_button',
            array(
            'label'     => __('Button', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            'button_text!' => '',
            ),
            )
        );

        $this->add_control(
            'button_size',
            array(
            'label'     => __('Size', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SELECT,
            'default'   => 'md',
            'options'   => array(
            'xs' => __('Extra Small', 'responsive-elementor-addons'),
            'sm' => __('Small', 'responsive-elementor-addons'),
            'md' => __('Medium', 'responsive-elementor-addons'),
            'lg' => __('Large', 'responsive-elementor-addons'),
            'xl' => __('Extra Large', 'responsive-elementor-addons'),
            ),
            'condition' => array(
                    'button_text!' => '',
            ),
            )
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            array(
            'label'     => __('Normal', 'responsive-elementor-addons'),
            'condition' => array(
            'button_text!' => '',
            ),
            )
        );

        $this->add_control(
            'button_text_color',
            array(
            'label'     => __('Text Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => array(
            '{{WRAPPER}} .rea-price-table__button' => 'color: {{VALUE}};',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'     => 'button_typography',
            'scheme'   => Schemes\Typography::TYPOGRAPHY_4,
            'selector' => '{{WRAPPER}} .rea-price-table__button',
            )
        );

        $this->add_control(
            'button_background_color',
            array(
            'label'     => __('Background Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => array(
            'type'  => Schemes\Color::get_type(),
            'value' => Schemes\Color::COLOR_4,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__button' => 'background-color: {{VALUE}};',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
            'name'      => 'button_border',
            'selector'  => '{{WRAPPER}} .rea-price-table__button',
            'separator' => 'before',
            )
        );

        $this->add_control(
            'button_border_radius',
            array(
            'label'      => __('Border Radius', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%' ),
            'selectors'  => array(
            '{{WRAPPER}} .rea-price-table__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->add_control(
            'button_text_padding',
            array(
            'label'      => __('Text Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', 'em', '%' ),
            'selectors'  => array(
            '{{WRAPPER}} .rea-price-table__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            array(
            'label'     => __('Hover', 'responsive-elementor-addons'),
            'condition' => array(
            'button_text!' => '',
            ),
            )
        );

        $this->add_control(
            'button_hover_color',
            array(
            'label'     => __('Text Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-price-table__button:hover' => 'color: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'button_background_hover_color',
            array(
            'label'     => __('Background Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-price-table__button:hover' => 'background-color: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'button_hover_border_color',
            array(
            'label'     => __('Border Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .rea-price-table__button:hover' => 'border-color: {{VALUE}};',
            ),
            )
        );

        $this->add_control(
            'button_hover_animation',
            array(
            'label' => __('Animation', 'responsive-elementor-addons'),
            'type'  => Controls_Manager::HOVER_ANIMATION,
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'heading_additional_info',
            array(
            'label'     => __('Additional Info', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            'footer_additional_info!' => '',
            ),
            )
        );

        $this->add_control(
            'additional_info_color',
            array(
            'label'     => __('Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => array(
            'type'  => Schemes\Color::get_type(),
            'value' => Schemes\Color::COLOR_3,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__additional_info' => 'color: {{VALUE}}',
            ),
            'condition' => array(
                    'footer_additional_info!' => '',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'      => 'additional_info_typography',
            'selector'  => '{{WRAPPER}} .rea-price-table__additional_info',
            'scheme'    => Schemes\Typography::TYPOGRAPHY_3,
            'condition' => array(
            'footer_additional_info!' => '',
            ),
            )
        );

        $this->add_control(
            'additional_info_margin',
            array(
            'label'      => __('Margin', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px', '%', 'em' ),
            'default'    => array(
            'top'    => 15,
            'right'  => 30,
            'bottom' => 0,
            'left'   => 30,
            'unit'   => 'px',
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .rea-price-table__additional_info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ),
            'condition'  => array(
                    'footer_additional_info!' => '',
            ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_ribbon_style',
            array(
            'label'      => __('Ribbon', 'responsive-elementor-addons'),
            'tab'        => Controls_Manager::TAB_STYLE,
            'show_label' => false,
            'condition'  => array(
            'show_ribbon' => 'yes',
            ),
            )
        );

        $this->add_control(
            'ribbon_bg_color',
            array(
            'label'     => __('Background Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'scheme'    => array(
            'type'  => Schemes\Color::get_type(),
            'value' => Schemes\Color::COLOR_4,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__ribbon-inner' => 'background-color: {{VALUE}}',
            ),
            )
        );

        $ribbon_distance_transform = is_rtl() ? 'translateY(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)' : 'translateY(-50%) translateX(-50%) translateX({{SIZE}}{{UNIT}}) rotate(-45deg)';

        $this->add_responsive_control(
            'ribbon_distance',
            array(
            'label'     => __('Distance', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            'px' => array(
            'min' => 0,
            'max' => 50,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .rea-price-table__ribbon-inner' => 'margin-top: {{SIZE}}{{UNIT}}; transform: ' . $ribbon_distance_transform,
            ),
            )
        );

        $this->add_control(
            'ribbon_text_color',
            array(
            'label'     => __('Text Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'separator' => 'before',
            'selectors' => array(
            '{{WRAPPER}} .rea-price-table__ribbon-inner' => 'color: {{VALUE}}',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'     => 'ribbon_typography',
            'selector' => '{{WRAPPER}} .rea-price-table__ribbon-inner',
            'scheme'   => Schemes\Typography::TYPOGRAPHY_4,
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
            'name'     => 'box_shadow',
            'selector' => '{{WRAPPER}} .rea-price-table__ribbon-inner',
            )
        );

        $this->end_controls_section();
    }

    /**
     * Render Currency Symbol
     *
     * @since  1.0.0
     * @access public
     * @param  mixed $symbol   Symbol.
     * @param  mixed $location Location.
     */
    private function render_currency_symbol( $symbol, $location )
    {

        $currency_position = $this->get_settings('currency_position');
        $location_setting  = ! empty($currency_position) ? $currency_position : 'before';
        if (! empty($symbol) && $location === $location_setting ) {
            echo '<span class="rea-price-table__currency elementor-currency--' . wp_kses_post($location) . '">' . wp_kses_post($symbol) . '</span>';
        }
    }

    /**
     * Get Currency Symbol
     *
     * @since  1.0.0
     * @access public
     * @param  mixed $symbol_name Symbol Name.
     */
    private function get_currency_symbol( $symbol_name )
    {
        $symbols = array(
        'dollar'       => '&#36;',
        'euro'         => '&#128;',
        'franc'        => '&#8355;',
        'pound'        => '&#163;',
        'ruble'        => '&#8381;',
        'shekel'       => '&#8362;',
        'baht'         => '&#3647;',
        'yen'          => '&#165;',
        'won'          => '&#8361;',
        'guilder'      => '&fnof;',
        'peso'         => '&#8369;',
        'peseta'       => '&#8359',
        'lira'         => '&#8356;',
        'rupee'        => '&#8360;',
        'indian_rupee' => '&#8377;',
        'real'         => 'R$',
        'krona'        => 'kr',
        );

        return isset($symbols[ $symbol_name ]) ? $symbols[ $symbol_name ] : '';
    }

    /**
     * Render Images on the frontend for the pricing table
     */
    public function render()
    {
        $settings = $this->get_settings_for_display();
        $symbol   = '';

        if (! empty($settings['currency_symbol']) ) {
            if ('custom' !== $settings['currency_symbol'] ) {
                $symbol = $this->get_currency_symbol($settings['currency_symbol']);
            } else {
                $symbol = $settings['currency_symbol_custom'];
            }
        }
        $currency_format = empty($settings['currency_format']) ? '.' : $settings['currency_format'];
        $price           = explode($currency_format, $settings['price']);
        $intpart         = $price[0];
        $fraction        = '';
        if (2 === count($price) ) {
            $fraction = $price[1];
        }

        $this->add_render_attribute(
            'button_text',
            'class',
            array(
            'rea-price-table__button',
            'elementor-button',
            'elementor-size-' . $settings['button_size'],
            )
        );

        if (! empty($settings['link']['url']) ) {
            $this->add_link_attributes('button_text', $settings['link']);
        }

        if (! empty($settings['button_hover_animation']) ) {
            $this->add_render_attribute('button_text', 'class', 'elementor-animation-' . $settings['button_hover_animation']);
        }

        $this->add_render_attribute('heading', 'class', 'rea-price-table__heading');
        $this->add_render_attribute('sub_heading', 'class', 'rea-price-table__subheading');
        $this->add_render_attribute('period', 'class', array( 'rea-price-table__period', 'elementor-typo-excluded' ));
        $this->add_render_attribute('footer_additional_info', 'class', 'rea-price-table__additional_info');
        $this->add_render_attribute('ribbon_title', 'class', 'rea-price-table__ribbon-inner');

        $this->add_inline_editing_attributes('heading', 'none');
        $this->add_inline_editing_attributes('sub_heading', 'none');
        $this->add_inline_editing_attributes('period', 'none');
        $this->add_inline_editing_attributes('footer_additional_info');
        $this->add_inline_editing_attributes('button_text');
        $this->add_inline_editing_attributes('ribbon_title');

        $period_position = $settings['period_position'];
        $period_element  = '<span ' . $this->get_render_attribute_string('period') . '>' . $settings['period'] . '</span>';
        $heading_tag     = $settings['heading_tag'];

        $migration_allowed = Icons_Manager::is_migration_allowed();
        ?>

        <div class="rea-price-table">
        <?php if ($settings['heading'] || $settings['sub_heading'] ) : ?>
                <div class="rea-price-table__header">
            <?php if (! empty($settings['heading']) ) : ?>
                        <<?php echo wp_kses_post($heading_tag) . ' ' . wp_kses_post($this->get_render_attribute_string('heading')); ?>><?php echo wp_kses_post($settings['heading']) . '</' . wp_kses_post($heading_tag); ?>>
            <?php endif; ?>

            <?php if (! empty($settings['sub_heading']) ) : ?>
                        <span <?php echo wp_kses_post($this->get_render_attribute_string('sub_heading')); ?>><?php echo wp_kses_post($settings['sub_heading']); ?></span>
            <?php endif; ?>
                </div>
        <?php endif; ?>

            <div class="rea-price-table__price">
        <?php if ('yes' === $settings['sale'] && ! empty($settings['original_price']) ) : ?>
                    <div class="rea-price-table__original-price elementor-typo-excluded"><?php echo wp_kses_post($symbol) . wp_kses_post($settings['original_price']); ?></div>
        <?php endif; ?>
        <?php $this->render_currency_symbol($symbol, 'before'); ?>
        <?php if (! empty($intpart) || 0 <= $intpart ) : ?>
                    <span class="rea-price-table__integer-part"><?php echo wp_kses_post($intpart); ?></span>
        <?php endif; ?>

        <?php if ('' !== $fraction || ( ! empty($settings['period']) && 'beside' === $period_position ) ) : ?>
                    <div class="rea-price-table__after-price">
                        <span class="rea-price-table__fractional-part"><?php echo wp_kses_post($fraction); ?></span>

            <?php if (! empty($settings['period']) && 'beside' === $period_position ) : ?>
                <?php echo wp_kses_post($period_element); ?>
            <?php endif; ?>
                    </div>
        <?php endif; ?>

        <?php $this->render_currency_symbol($symbol, 'after'); ?>

        <?php if (! empty($settings['period']) && 'below' === $period_position ) : ?>
            <?php echo wp_kses_post($period_element); ?>
        <?php endif; ?>
            </div>

        <?php if (! empty($settings['features_list']) ) : ?>
                <ul class="rea-price-table__features-list">
            <?php
            foreach ( $settings['features_list'] as $index => $item ) :
                $repeater_setting_key = $this->get_repeater_setting_key('item_text', 'features_list', $index);
                $this->add_inline_editing_attributes($repeater_setting_key);

                $migrated = isset($item['__fa4_migrated']['selected_item_icon']);
                // add old default.
                if (! isset($item['item_icon']) && ! $migration_allowed ) {
                    $item['item_icon'] = 'fa fa-check-circle';
                }
                $is_new = ! isset($item['item_icon']) && $migration_allowed;
                ?>
                        <li class="elementor-repeater-item-<?php echo wp_kses_post($item['_id']); ?>">
                            <div class="rea-price-table__feature-inner">
                <?php
                if (! empty($item['item_icon']) || ! empty($item['selected_item_icon']) ) :
                    if ($is_new || $migrated ) :
                             Icons_Manager::render_icon($item['selected_item_icon'], array( 'aria-hidden' => 'true' ));
           else :
                ?>
                                        <i class="<?php echo wp_kses_post($item['item_icon']); ?>" aria-hidden="true"></i>
               <?php
           endif;
                endif;
                ?>
                <?php if (! empty($item['item_text']) ) : ?>
                                    <span <?php echo wp_kses_post($this->get_render_attribute_string($repeater_setting_key)); ?>>
                    <?php echo wp_kses_post($item['item_text']); ?>
                                    </span>
                    <?php
               else :
                   echo '&nbsp;';
               endif;
                ?>
                            </div>
                        </li>
            <?php endforeach; ?>
                </ul>
        <?php endif; ?>

        <?php if (! empty($settings['button_text']) || ! empty($settings['footer_additional_info']) ) : ?>
                <div class="rea-price-table__footer">
            <?php if (! empty($settings['button_text']) ) : ?>
                        <a <?php echo wp_kses_post($this->get_render_attribute_string('button_text')); ?>><?php echo wp_kses_post($settings['button_text']); ?></a>
            <?php endif; ?>

            <?php if (! empty($settings['footer_additional_info']) ) : ?>
                        <div <?php echo wp_kses_post($this->get_render_attribute_string('footer_additional_info')); ?>><?php echo wp_kses_post($settings['footer_additional_info']); ?></div>
            <?php endif; ?>
                </div>
        <?php endif; ?>
        </div>

        <?php
        if ('yes' === $settings['show_ribbon'] && ! empty($settings['ribbon_title']) ) :
            $this->add_render_attribute('ribbon-wrapper', 'class', 'rea-price-table__ribbon');

            if (! empty($settings['ribbon_horizontal_position']) ) :
                $this->add_render_attribute('ribbon-wrapper', 'class', 'elementor-ribbon-' . $settings['ribbon_horizontal_position']);
            endif;

            ?>
            <div <?php echo wp_kses_post($this->get_render_attribute_string('ribbon-wrapper')); ?>>
                <div <?php echo wp_kses_post($this->get_render_attribute_string('ribbon_title')); ?>><?php echo wp_kses_post($settings['ribbon_title']); ?></div>
            </div>
            <?php
        endif;
    }

    /**
     * Content template for the pricing table
     */
    protected function content_template()
    {
        ?>
        <#
        var symbols = {
        dollar: '&#36;',
        euro: '&#128;',
        franc: '&#8355;',
        pound: '&#163;',
        ruble: '&#8381;',
        shekel: '&#8362;',
        baht: '&#3647;',
        yen: '&#165;',
        won: '&#8361;',
        guilder: '&fnof;',
        peso: '&#8369;',
        peseta: '&#8359;',
        lira: '&#8356;',
        rupee: '&#8360;',
        indian_rupee: '&#8377;',
        real: 'R$',
        krona: 'kr'
        };

        var symbol = '',
        iconsHTML = {};

        if ( settings.currency_symbol ) {
        if ( 'custom' != settings.currency_symbol ) {
        symbol = symbols[ settings.currency_symbol ] || '';
        } else {
        symbol = settings.currency_symbol_custom;
        }
        }

        var buttonClasses = 'rea-price-table__button elementor-button elementor-size-' + settings.button_size;

        if ( settings.button_hover_animation ) {
        buttonClasses += ' elementor-animation-' + settings.button_hover_animation;
        }

        view.addRenderAttribute( 'heading', 'class', 'rea-price-table__heading' );
        view.addRenderAttribute( 'sub_heading', 'class', 'rea-price-table__subheading' );
        view.addRenderAttribute( 'period', 'class', ['rea-price-table__period', 'elementor-typo-excluded'] );
        view.addRenderAttribute( 'footer_additional_info', 'class', 'rea-price-table__additional_info'  );
        view.addRenderAttribute( 'button_text', 'class', buttonClasses  );
        view.addRenderAttribute( 'ribbon_title', 'class', 'rea-price-table__ribbon-inner'  );

        view.addInlineEditingAttributes( 'heading', 'none' );
        view.addInlineEditingAttributes( 'sub_heading', 'none' );
        view.addInlineEditingAttributes( 'period', 'none' );
        view.addInlineEditingAttributes( 'footer_additional_info' );
        view.addInlineEditingAttributes( 'button_text' );
        view.addInlineEditingAttributes( 'ribbon_title' );

        var currencyFormat = settings.currency_format || '.',
        price = settings.price.split( currencyFormat ),
        intpart = price[0],
        fraction = price[1],

        periodElement = '<span ' + view.getRenderAttributeString( "period" ) + '>' + settings.period + '</span>';

        #>
        <div class="rea-price-table">
            <# if ( settings.heading || settings.sub_heading ) { #>
            <div class="rea-price-table__header">
                <# if ( settings.heading ) { #>
                <{{ settings.heading_tag }} {{{ view.getRenderAttributeString( 'heading' ) }}}>{{{ settings.heading }}}</{{ settings.heading_tag }}>
            <# } #>
            <# if ( settings.sub_heading ) { #>
            <span {{{ view.getRenderAttributeString( 'sub_heading' ) }}}>{{{ settings.sub_heading }}}</span>
            <# } #>
        </div>
        <# } #>

        <div class="rea-price-table__price">
            <# if ( settings.sale && settings.original_price ) { #>
            <div class="rea-price-table__original-price elementor-typo-excluded">{{{ symbol + settings.original_price }}}</div>
            <# } #>

            <# if ( ! _.isEmpty( symbol ) && ( 'before' == settings.currency_position || _.isEmpty( settings.currency_position ) ) ) { #>
            <span class="rea-price-table__currency elementor-currency--before">{{{ symbol }}}</span>
            <# } #>
            <# if ( intpart ) { #>
            <span class="rea-price-table__integer-part">{{{ intpart }}}</span>
            <# } #>
            <div class="rea-price-table__after-price">
                <# if ( fraction ) { #>
                <span class="rea-price-table__fractional-part">{{{ fraction }}}</span>
                <# } #>
                <# if ( settings.period && 'beside' == settings.period_position ) { #>
                {{{ periodElement }}}
                <# } #>
            </div>

            <# if ( ! _.isEmpty( symbol ) && 'after' == settings.currency_position ) { #>
            <span class="rea-price-table__currency elementor-currency--after">{{{ symbol }}}</span>
            <# } #>

            <# if ( settings.period && 'below' == settings.period_position ) { #>
            {{{ periodElement }}}
            <# } #>
        </div>

        <# if ( settings.features_list ) { #>
        <ul class="rea-price-table__features-list">
            <# _.each( settings.features_list, function( item, index ) {

            var featureKey = view.getRepeaterSettingKey( 'item_text', 'features_list', index ),
            migrated = elementor.helpers.isIconMigrated( item, 'selected_item_icon' );

            view.addInlineEditingAttributes( featureKey ); #>

            <li class="elementor-repeater-item-{{ item._id }}">
                <div class="rea-price-table__feature-inner">
                    <# if ( item.item_icon  || item.selected_item_icon ) {
                    iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.selected_item_icon, { 'aria-hidden': 'true' }, 'i', 'object' );
                    if ( ( ! item.item_icon || migrated ) && iconsHTML[ index ] && iconsHTML[ index ].rendered ) { #>
                    {{{ iconsHTML[ index ].value }}}
                    <# } else { #>
                    <i class="{{ item.item_icon }}" aria-hidden="true"></i>
                    <# }
                    } #>
                    <# if ( ! _.isEmpty( item.item_text.trim() ) ) { #>
                    <span {{{ view.getRenderAttributeString( featureKey ) }}}>{{{ item.item_text }}}</span>
                    <# } else { #>
                    &nbsp;
                    <# } #>
                </div>
            </li>
            <# } ); #>
        </ul>
        <# } #>

        <# if ( settings.button_text || settings.footer_additional_info ) { #>
        <div class="rea-price-table__footer">
            <# if ( settings.button_text ) { #>
            <a href="#" {{{ view.getRenderAttributeString( 'button_text' ) }}}>{{{ settings.button_text }}}</a>
            <# } #>
            <# if ( settings.footer_additional_info ) { #>
            <p {{{ view.getRenderAttributeString( 'footer_additional_info' ) }}}>{{{ settings.footer_additional_info }}}</p>
            <# } #>
        </div>
        <# } #>
        </div>

        <# if ( 'yes' == settings.show_ribbon && settings.ribbon_title ) {
        var ribbonClasses = 'rea-price-table__ribbon';
        if ( settings.ribbon_horizontal_position ) {
        ribbonClasses += ' elementor-ribbon-' + settings.ribbon_horizontal_position;
        } #>
        <div class="{{ ribbonClasses }}">
            <div {{{ view.getRenderAttributeString( 'ribbon_title' ) }}}>{{{ settings.ribbon_title }}}</div>
        </div>
        <# } #>
        <?php
    }

    /**
     * Get Custom help URL
     *
     * @return string help URL
     */
    public function getCustomHelpUrl()
    {
        return 'https://docs.cyberchimps.com/responsive-elementor-addons/rea-pricing-table';
    }
}
