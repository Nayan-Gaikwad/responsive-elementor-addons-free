<?php
/**
 * Single Query
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Modules\SingleQueryControl\Controls;

use Elementor\Control_Select2;

if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}
/**
 * Single Query Class.
 *
 * @since 1.0.0
 */
class SingleQuery extends Control_Select2
{
    /**
     * Function Get Type
     *
     * @return string
     */
    public function get_type()
    {
        return 'rea-single-query';
    }

    /**
     * 'query' can be used for passing query args in the structure and format used by WP_Query.
     *
     * @return array
     */
    protected function get_default_settings()
    {
        return array_merge(
            parent::get_default_settings(),
            array(
            'query' => '',
            )
        );
    }
}
