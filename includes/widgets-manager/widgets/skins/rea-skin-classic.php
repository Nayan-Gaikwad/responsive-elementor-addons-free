<?php
/**
 * REA Skin Classic.
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Widgets\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;

if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}

/**
 * REA Skin Classic Extending REA Skin Base.
 *
 * An abstract class to register new skins for Elementor widgets. Skins allows
 * you to add new templates, set custom controls and more.
 *
 * @since 1.0.0
 */
class REA_Skin_Classic extends REA_Skin_Base
{

    /**
     * Get ID.
     *
     * Retrieve ID.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Card ID.
     */
    public function get_id()
    {
        return 'rea_classic';
    }

    /**
     * Retrieve the title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Title.
     */
    public function getTitle()
    {
        return __('Classic', 'responsive-elementor-addons');
    }

    /**
     * Register skin classic controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls_actions()
    {
        parent::_register_controls_actions();
        add_action('elementor/element/rea-posts/rea_classic_section_design_layout/after_section_end', array( $this, 'register_additional_design_controls' ));

    }

    /**
     * Register Additional skin classic desgin controls.
     *
     * @since  1.0.0
     * @access public
     */
    public function register_additional_design_controls()
    {
        $this->start_controls_section(
            'section_design_box',
            array(
            'label' => __('Box', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'box_border_width',
            array(
            'label'      => __('Border Width', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'range'      => array(
            'px' => array(
            'min' => 0,
            'max' => 50,
                    ),
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .elementor-post' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ),
            )
        );

        $this->add_control(
            'box_border_radius',
            array(
            'label'      => __('Border Radius', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
            'px' => array(
            'min' => 0,
            'max' => 200,
                    ),
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .elementor-post' => 'border-radius: {{SIZE}}{{UNIT}}',
            ),
            )
        );

        $this->add_control(
            'box_padding',
            array(
            'label'      => __('Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'range'      => array(
            'px' => array(
            'min' => 0,
            'max' => 50,
                    ),
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .elementor-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ),
            )
        );

        $this->add_control(
            'content_padding',
            array(
            'label'      => __('Content Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => array( 'px' ),
            'range'      => array(
            'px' => array(
            'min' => 0,
            'max' => 50,
                    ),
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .elementor-post__text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
            ),
            'separator'  => 'after',
            )
        );

        $this->start_controls_tabs('bg_effects_tabs');

        $this->start_controls_tab(
            'classic_style_normal',
            array(
            'label' => __('Normal', 'responsive-elementor-addons'),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
            'name'     => 'box_shadow',
            'selector' => '{{WRAPPER}} .elementor-post',
            )
        );

        $this->add_control(
            'box_bg_color',
            array(
            'label'     => __('Background Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .elementor-post' => 'background-color: {{VALUE}}',
            ),
            )
        );

        $this->add_control(
            'box_border_color',
            array(
            'label'     => __('Border Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .elementor-post' => 'border-color: {{VALUE}}',
            ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'classic_style_hover',
            array(
            'label' => __('Hover', 'responsive-elementor-addons'),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
            'name'     => 'box_shadow_hover',
            'selector' => '{{WRAPPER}} .elementor-post:hover',
            )
        );

        $this->add_control(
            'box_bg_color_hover',
            array(
            'label'     => __('Background Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .elementor-post:hover' => 'background-color: {{VALUE}}',
            ),
            )
        );

        $this->add_control(
            'box_border_color_hover',
            array(
            'label'     => __('Border Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .elementor-post:hover' => 'border-color: {{VALUE}}',
            ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

}
