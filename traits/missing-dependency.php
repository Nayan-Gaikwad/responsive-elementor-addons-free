<?php

namespace Responsive_Elementor_Addons\Traits;

use Elementor\Controls_Manager;

/**
 * Utility trait for missing dependencies.
 *
 * @since 1.5.0
 */
trait Missing_Dependency
{
    /**
     * Register warning controls under Content Tab.
     *
     * Use it inside a condition when the dependency plugin is not activated.
     *
     * @since 1.5.0
     *
     * @param string $plugin             Name of the missing plugin to be displayed in the warning message.
     * @param string $plugin_search_term Search term for the missing plugin to be used in the link.
     *
     * @access protected
     */
    protected function register_content_tab_missing_dep_warning_controls( $plugin, $plugin_search_term )
    {
        $this->start_controls_section(
            'rea_missing_dependency_warning_section',
            [
            'label' => __('Warning!', 'responsive-elementor-addons'),
            'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'rea_missing_plugin_warning',
            [
            'type' => Controls_Manager::RAW_HTML,
            'raw' => sprintf(__('<strong><a href="plugin-install.php?s=%1$s&tab=search&type=term" target="_blank">%2$s</a></strong> is not installed/activated on your site. Please install and activate it first.', 'responsive-elementor-addons'), $plugin_search_term, $plugin),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
            ]
        );

        $this->end_controls_section();
    }
}
