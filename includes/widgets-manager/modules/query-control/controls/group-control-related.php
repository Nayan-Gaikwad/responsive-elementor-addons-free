<?php
/**
 * Group Control Related
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Modules\QueryControl\Controls;

use Elementor\Controls_Manager;

if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}
/**
 * Group Control Related Class.
 *
 * @since 1.0.0
 */
class Group_Control_Related extends Group_Control_Query
{
    /**
     * Retrieve the related query.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Related Query name.
     */
    public static function get_type()
    {
        return 'rea-related-query';
    }

    /**
     * Build the group-controls array
     * Note: this method completely overrides any settings done in Group_Control_Posts
     *
     * @param string $name name.
     *
     * @return array
     */
    protected function init_fields_by_name( $name )
    {
        $fields = parent::init_fields_by_name($name);

        $tabs_wrapper    = $name . '_query_args';
        $include_wrapper = $name . '_query_include';

        $fields['post_type']['options']['related']                = __('Related', 'responsive-elementor-addons');
        $fields['include_term_ids']['condition']['post_type!'][]  = 'related';
        $fields['related_taxonomies']['condition']['post_type'][] = 'related';
        $fields['include_authors']['condition']['post_type!'][]   = 'related';
        $fields['exclude_authors']['condition']['post_type!'][]   = 'related';
        $fields['avoid_duplicates']['condition']['post_type!'][]  = 'related';
        $fields['offset']['condition']['post_type!'][]            = 'related';

        $related_taxonomies = array(
        'label'        => __('Term', 'responsive-elementor-addons'),
        'type'         => Controls_Manager::SELECT2,
        'options'      => $this->get_supported_taxonomies(),
        'label_block'  => true,
        'multiple'     => true,
        'condition'    => array(
        'include'   => 'terms',
        'post_type' => array(
        'related',
        ),
        ),
        'tabs_wrapper' => $tabs_wrapper,
        'inner_tab'    => $include_wrapper,
        );

        $related_fallback = array(
        'label'       => __('Fallback', 'responsive-elementor-addons'),
        'type'        => Controls_Manager::SELECT,
        'options'     => array(
        'fallback_none'   => __('None', 'responsive-elementor-addons'),
        'fallback_by_id'  => __('Manual Selection', 'responsive-elementor-addons'),
        'fallback_recent' => __('Recent Posts', 'responsive-elementor-addons'),
        ),
        'default'     => 'fallback_none',
        'description' => __('Displayed if no relevant results are found. Manual selection display order is random', 'responsive-elementor-addons'),
        'condition'   => array(
        'post_type' => 'related',
        ),
        'separator'   => 'before',
        );

        $fallback_ids = array(
        'label'       => __('Search & Select', 'responsive-elementor-addons'),
        'type'        => 'rea-query',
        'post_type'   => '',
        'options'     => array(),
        'label_block' => true,
        'multiple'    => true,
        'filter_type' => 'by_id',
        'condition'   => array(
        'post_type'        => 'related',
        'related_fallback' => 'fallback_by_id',
        ),
        'export'      => false,
        );

        $fields = \Elementor\Utils::array_inject($fields, 'include_term_ids', array( 'related_taxonomies' => $related_taxonomies ));
        $fields = \Elementor\Utils::array_inject($fields, 'offset', array( 'related_fallback' => $related_fallback ));
        $fields = \Elementor\Utils::array_inject($fields, 'related_fallback', array( 'fallback_ids' => $fallback_ids ));

        return $fields;
    }

    /**
     * Get supported taxonomies
     *
     * @return array
     */
    protected function get_supported_taxonomies()
    {
        $supported_taxonomies = array();

        $public_types = $this->get_public_post_types();

        foreach ( $public_types as $type => $title ) {
            $taxonomies = get_object_taxonomies($type, 'objects');
            foreach ( $taxonomies as $key => $tax ) {
                if (! array_key_exists($key, $supported_taxonomies) ) {
                    $label = $tax->label;
                    if (in_array($tax->label, $supported_taxonomies) ) {
                        $label = $tax->label . ' (' . $tax->name . ')';
                    }
                    $supported_taxonomies[ $key ] = $label;
                }
            }
        }

        return $supported_taxonomies;
    }

    /**
     * Initialize Presets
     *
     * @return void
     */
    protected static function init_presets()
    {
        parent::init_presets();
        static::$presets['related'] = array(
        'related_fallback',
        'fallback_ids',
        );
    }

    /**
     * Get public post type list
     *
     * @param  array $args args.
     * @return array
     */
    public function get_public_post_types( $args = array() )
    {
        $post_type_args = array(
        // Default is the value $public.
        'show_in_nav_menus' => true,
        );

        // Keep for backwards compatibility.
        if (! empty($args['post_type']) ) {
            $post_type_args['name'] = $args['post_type'];
            unset($args['post_type']);
        }

        $post_type_args = wp_parse_args($post_type_args, $args);

        $_post_types = get_post_types($post_type_args, 'objects');

        $post_types = array();

        foreach ( $_post_types as $post_type => $object ) {
            $post_types[ $post_type ] = $object->label;
        }

        return apply_filters('rea/core_elements/get_public_post_types', $post_types);
    }
}
