<?php
/**
 * Query
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Modules\QueryControl\Controls;

use Elementor\Control_Select2;

if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}
/**
 * Query Class.
 *
 * @since 1.0.0
 */
class Query extends Control_Select2
{
    /**
     * Retrieve the query.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Query.
     */
    public function get_type()
    {
        return 'rea-query';
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
