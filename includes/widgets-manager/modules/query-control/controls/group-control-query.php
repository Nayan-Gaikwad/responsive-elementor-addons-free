<?php
/**
 * Group Control Query
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Modules\QueryControl\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Base;

if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}
/**
 * Group Control Query Class.
 *
 * @since 1.0.0
 */
class Group_Control_Query extends Group_Control_Base
{
    /**
     * Presets
     *
     * @var mixed
     */
    protected static $presets;

    /**
     * Fields
     *
     * @var mixed
     */
    protected static $fields;

    /**
     * Retrieve the query group.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Query group name.
     */
    public static function get_type()
    {
        return 'rea-query-group';
    }

    /**
     * Initialize Agruments
     *
     * @param  array $args Arguments.
     * @return void
     */
    protected function init_args( $args )
    {
        parent::init_args($args);
        $args           = $this->get_args();
        static::$fields = $this->init_fields_by_name($args['name']);
    }

    /**
     * Initalize Fields
     *
     * @return mixed
     */
    protected function init_fields()
    {
        $args = $this->get_args();

        return $this->init_fields_by_name($args['name']);
    }

    /**
     * Build the group-controls array
     * Note: this method completely overrides any settings done in Group_Control_Posts
     *
     * @param string $name Name.
     *
     * @return array
     */
    protected function init_fields_by_name( $name )
    {
        $fields = array();

        $name .= '_';

        $fields['post_type'] = array(
        'label'   => __('Source', 'responsive-elementor-addons'),
        'type'    => Controls_Manager::SELECT,
        'options' => array(
        'by_id'         => __('Manual Selection', 'responsive-elementor-addons'),
        'current_query' => __('Current Query', 'responsive-elementor-addons'),
        ),
        );

        $fields['query_args'] = array(
        'type' => Controls_Manager::TABS,
        );

        $tabs_wrapper    = $name . 'query_args';
        $include_wrapper = $name . 'query_include';
        $exclude_wrapper = $name . 'query_exclude';

        $fields['query_include'] = array(
        'type'         => Controls_Manager::TAB,
        'label'        => __('Include', 'responsive-elementor-addons'),
        'tabs_wrapper' => $tabs_wrapper,
        'condition'    => array(
        'post_type!' => array(
                    'current_query',
                    'by_id',
        ),
        ),
        );

        $fields['posts_ids'] = array(
        'label'        => __('Search & Select', 'responsive-elementor-addons'),
        'type'         => 'rea-query',
        'post_type'    => '',
        'options'      => array(),
        'label_block'  => true,
        'multiple'     => true,
        'filter_type'  => 'by_id',
        'condition'    => array(
        'post_type' => 'by_id',
        ),
        'tabs_wrapper' => $tabs_wrapper,
        'inner_tab'    => $include_wrapper,
        'export'       => false,
        );

        $fields['include'] = array(
        'label'        => __('Include By', 'responsive-elementor-addons'),
        'type'         => Controls_Manager::SELECT2,
        'multiple'     => true,
        'options'      => array(
        'terms'   => __('Term', 'responsive-elementor-addons'),
        'authors' => __('Author', 'responsive-elementor-addons'),
        ),
        'condition'    => array(
        'post_type!' => array(
                    'by_id',
                    'current_query',
        ),
        ),
        'label_block'  => true,
        'tabs_wrapper' => $tabs_wrapper,
        'inner_tab'    => $include_wrapper,
        );

        $fields['include_term_ids'] = array(
        'label'        => __('Term', 'responsive-elementor-addons'),
        'type'         => 'rea-query',
        'post_type'    => '',
        'options'      => array(),
        'label_block'  => true,
        'multiple'     => true,
        'filter_type'  => 'cpt_taxonomies',
        'group_prefix' => $name,
        'include_type' => true,
        'condition'    => array(
        'include'    => 'terms',
        'post_type!' => array(
                    'by_id',
                    'current_query',
        ),
        ),
        'tabs_wrapper' => $tabs_wrapper,
        'inner_tab'    => $include_wrapper,
        );

        $fields['include_authors'] = array(
        'label'        => __('Author', 'responsive-elementor-addons'),
        'label_block'  => true,
        'type'         => 'rea-query',
        'multiple'     => true,
        'default'      => array(),
        'options'      => array(),
        'filter_type'  => 'author',
        'condition'    => array(
        'include'    => 'authors',
        'post_type!' => array(
                    'by_id',
                    'current_query',
        ),
        ),
        'tabs_wrapper' => $tabs_wrapper,
        'inner_tab'    => $include_wrapper,
        'export'       => false,
        );

        $fields['query_exclude'] = array(
        'type'         => Controls_Manager::TAB,
        'label'        => __('Exclude', 'responsive-elementor-addons'),
        'tabs_wrapper' => $tabs_wrapper,
        'condition'    => array(
        'post_type!' => array(
                    'by_id',
                    'current_query',
        ),
        ),
        );

        $fields['exclude'] = array(
        'label'        => __('Exclude By', 'responsive-elementor-addons'),
        'type'         => Controls_Manager::SELECT2,
        'multiple'     => true,
        'options'      => array(
        'current_post'     => __('Current Post', 'responsive-elementor-addons'),
        'manual_selection' => __('Manual Selection', 'responsive-elementor-addons'),
        'terms'            => __('Term', 'responsive-elementor-addons'),
        'authors'          => __('Author', 'responsive-elementor-addons'),
        ),
        'condition'    => array(
        'post_type!' => array(
                    'by_id',
                    'current_query',
        ),
        ),
        'label_block'  => true,
        'tabs_wrapper' => $tabs_wrapper,
        'inner_tab'    => $exclude_wrapper,
        );

        $fields['exclude_ids'] = array(
        'label'        => __('Search & Select', 'responsive-elementor-addons'),
        'type'         => 'rea-query',
        'post_type'    => '',
        'options'      => array(),
        'label_block'  => true,
        'multiple'     => true,
        'filter_type'  => 'by_id',
        'condition'    => array(
        'exclude'    => 'manual_selection',
        'post_type!' => array(
                    'by_id',
                    'current_query',
        ),
        ),
        'tabs_wrapper' => $tabs_wrapper,
        'inner_tab'    => $exclude_wrapper,
        'export'       => false,
        );

        $fields['exclude_term_ids'] = array(
        'label'        => __('Term', 'responsive-elementor-addons'),
        'type'         => 'rea-query',
        'post_type'    => '',
        'options'      => array(),
        'label_block'  => true,
        'multiple'     => true,
        'filter_type'  => 'cpt_taxonomies',
        'group_prefix' => $name,
        'include_type' => true,
        'condition'    => array(
        'exclude'    => 'terms',
        'post_type!' => array(
                    'by_id',
                    'current_query',
        ),
        ),
        'tabs_wrapper' => $tabs_wrapper,
        'inner_tab'    => $exclude_wrapper,
        'export'       => false,
        );

        $fields['exclude_authors'] = array(
        'label'        => __('Author', 'responsive-elementor-addons'),
        'type'         => 'rea-query',
        'post_type'    => '',
        'options'      => array(),
        'label_block'  => true,
        'multiple'     => true,
        'filter_type'  => 'author',
        'include_type' => true,
        'condition'    => array(
        'exclude'    => 'authors',
        'post_type!' => array(
                    'by_id',
                    'current_query',
        ),
        ),
        'tabs_wrapper' => $tabs_wrapper,
        'inner_tab'    => $exclude_wrapper,
        'export'       => false,
        );

        $fields['avoid_duplicates'] = array(
        'label'        => __('Avoid Duplicates', 'responsive-elementor-addons'),
        'type'         => Controls_Manager::SWITCHER,
        'default'      => '',
        'description'  => __('Set to Yes to avoid duplicate posts from showing up. This only effects the frontend.', 'responsive-elementor-addons'),
        'tabs_wrapper' => $tabs_wrapper,
        'inner_tab'    => $exclude_wrapper,
        'condition'    => array(
        'post_type!' => array(
                    'by_id',
                    'current_query',
        ),
        ),
        );

        $fields['offset'] = array(
        'label'        => __('Offset', 'responsive-elementor-addons'),
        'type'         => Controls_Manager::NUMBER,
        'default'      => 0,
        'condition'    => array(
        'post_type!' => array(
                    'by_id',
                    'current_query',
        ),
        ),
        'description'  => __('Use this setting to skip over posts (e.g. \'2\' to skip over 2 posts).', 'responsive-elementor-addons'),
        'tabs_wrapper' => $tabs_wrapper,
        'inner_tab'    => $exclude_wrapper,
        );

        $fields['select_date'] = array(
        'label'        => __('Date', 'responsive-elementor-addons'),
        'type'         => Controls_Manager::SELECT,
        'post_type'    => '',
        'options'      => array(
        'anytime' => __('All', 'responsive-elementor-addons'),
        'today'   => __('Past Day', 'responsive-elementor-addons'),
        'week'    => __('Past Week', 'responsive-elementor-addons'),
        'month'   => __('Past Month', 'responsive-elementor-addons'),
        'quarter' => __('Past Quarter', 'responsive-elementor-addons'),
        'year'    => __('Past Year', 'responsive-elementor-addons'),
        'exact'   => __('Custom', 'responsive-elementor-addons'),
        ),
        'default'      => 'anytime',
        'label_block'  => false,
        'multiple'     => false,
        'filter_type'  => 'date',
        'include_type' => true,
        'condition'    => array(
        'post_type!' => array(
                    'by_id',
                    'current_query',
        ),
        ),
        'separator'    => 'before',
        );

        $fields['date_before'] = array(
        'label'        => __('Before', 'responsive-elementor-addons'),
        'type'         => Controls_Manager::DATE_TIME,
        'post_type'    => '',
        'label_block'  => false,
        'multiple'     => false,
        'filter_type'  => 'date',
        'include_type' => true,
        'placeholder'  => __('Choose', 'responsive-elementor-addons'),
        'condition'    => array(
        'select_date' => 'exact',
        'post_type!'  => array(
                    'by_id',
                    'current_query',
        ),
        ),
        'description'  => __('Setting a ‘Before’ date will show all the posts published until the chosen date (inclusive).', 'responsive-elementor-addons'),
        );

        $fields['date_after'] = array(
        'label'        => __('After', 'responsive-elementor-addons'),
        'type'         => Controls_Manager::DATE_TIME,
        'post_type'    => '',
        'label_block'  => false,
        'multiple'     => false,
        'filter_type'  => 'date',
        'include_type' => true,
        'placeholder'  => __('Choose', 'responsive-elementor-addons'),
        'condition'    => array(
        'select_date' => 'exact',
        'post_type!'  => array(
                    'by_id',
                    'current_query',
        ),
        ),
        'description'  => __('Setting an ‘After’ date will show all the posts published since the chosen date (inclusive).', 'responsive-elementor-addons'),
        );

        $fields['orderby'] = array(
        'label'     => __('Order By', 'responsive-elementor-addons'),
        'type'      => Controls_Manager::SELECT,
        'default'   => 'post_date',
        'options'   => array(
        'post_date'  => __('Date', 'responsive-elementor-addons'),
        'post_title' => __('Title', 'responsive-elementor-addons'),
        'menu_order' => __('Menu Order', 'responsive-elementor-addons'),
        'rand'       => __('Random', 'responsive-elementor-addons'),
        ),
        'condition' => array(
        'post_type!' => 'current_query',
        ),
        );

        $fields['order'] = array(
        'label'     => __('Order', 'responsive-elementor-addons'),
        'type'      => Controls_Manager::SELECT,
        'default'   => 'desc',
        'options'   => array(
        'asc'  => __('ASC', 'responsive-elementor-addons'),
        'desc' => __('DESC', 'responsive-elementor-addons'),
        ),
        'condition' => array(
        'post_type!' => 'current_query',
        ),
        );

        $fields['posts_per_page'] = array(
        'label'     => __('Posts Per Page', 'responsive-elementor-addons'),
        'type'      => Controls_Manager::NUMBER,
        'default'   => 3,
        'condition' => array(
        'post_type!' => 'current_query',
        ),
        );

        $fields['ignore_sticky_posts'] = array(
        'label'       => __('Ignore Sticky Posts', 'responsive-elementor-addons'),
        'type'        => Controls_Manager::SWITCHER,
        'default'     => 'yes',
        'condition'   => array(
        'post_type' => 'post',
        ),
        'description' => __('Sticky-posts ordering is visible on frontend only', 'responsive-elementor-addons'),
        );

        $fields['query_id'] = array(
        'label'       => __('Query ID', 'responsive-elementor-addons'),
        'type'        => Controls_Manager::TEXT,
        'default'     => '',
        'description' => __('Give your Query a custom unique id to allow server side filtering', 'responsive-elementor-addons'),
        'separator'   => 'before',
        );

        static::init_presets();

        return $fields;
    }

    /**
     * Presets: filter controls subsets to be be used by the specific Group_Control_Query instance.
     *
     * Possible values:
     * 'full' : (default) all presets
     * 'include' : the 'include' tab - by id, by taxonomy, by author
     * 'exclude': the 'exclude' tab - by id, by taxonomy, by author
     * 'advanced_exclude': extend the 'exclude' preset with 'avoid-duplicates' & 'offset'
     * 'date': date query controls
     * 'pagination': posts per-page
     * 'order': sort & ordering controls
     * 'query_id': allow saving a specific query for future usage.
     *
     * Usage:
     * full: build a Group_Controls_Query with all possible controls,
     * when 'full' is passed, the Group_Controls_Query will ignore all other preset values.
     * $this->add_group_control(
     * Group_Control_Query::get_type(),
     * [
     * ...
     * 'presets' => [ 'full' ],
     *  ...
     *  ] );
     *
     * Subset: build a Group_Controls_Query with subset of the controls,
     * in the following example, the Query controls will set only the 'include' & 'date' query args.
     * $this->add_group_control(
     * Group_Control_Query::get_type(),
     * [
     * ...
     * 'presets' => [ 'include', 'date' ],
     *  ...
     *  ] );
     */
    protected static function init_presets()
    {

        $tabs = array(
        'query_args',
        'query_include',
        'query_exclude',
        );

        static::$presets['include'] = array_merge(
            $tabs,
            array(
            'include',
            'include_ids',
            'include_term_ids',
            'include_authors',
            )
        );

        static::$presets['exclude'] = array_merge(
            $tabs,
            array(
            'exclude',
            'exclude_ids',
            'exclude_term_ids',
            'exclude_authors',
            )
        );

        static::$presets['advanced_exclude'] = array_merge(
            static::$presets['exclude'],
            array(
            'avoid_duplicates',
            'offset',
            )
        );

        static::$presets['date'] = array(
        'select_date',
        'date_before',
        'date_after',
        );

        static::$presets['pagination'] = array(
        'posts_per_page',
        'ignore_sticky_posts',
        );

        static::$presets['order'] = array(
        'orderby',
        'order',
        );

        static::$presets['query_id'] = array(
        'query_id',
        );
    }

    /**
     * Filter by presets
     *
     * @param  array $presets Presets.
     * @param  array $fields  Fields.
     * @return array
     */
    private function filter_by_presets( $presets, $fields )
    {

        if (in_array('full', $presets, true) ) {
            return $fields;
        }

        $control_ids = array();
        foreach ( static::$presets as $key => $preset ) {
            $control_ids = array_merge($control_ids, $preset);
        }

        foreach ( $presets as $preset ) {
            if (array_key_exists($preset, static::$presets) ) {
                $control_ids = array_diff($control_ids, static::$presets[ $preset ]);
            }
        }

        foreach ( $control_ids as $remove ) {
            unset($fields[ $remove ]);
        }

        return $fields;

    }

    /**
     * Prepare Fields
     *
     * @param  mixed $fields Fields.
     * @return mixed
     */
    protected function prepare_fields( $fields )
    {

        $args = $this->get_args();

        if (! empty($args['presets']) ) {
            $fields = $this->filter_by_presets($args['presets'], $fields);
        }

        $post_type_args = array();
        if (! empty($args['post_type']) ) {
            $post_type_args['post_type'] = $args['post_type'];
        }

        $post_types = $this->get_public_post_types($post_type_args);

        $fields['post_type']['options']     = array_merge($post_types, $fields['post_type']['options']);
        $fields['post_type']['default']     = key($post_types);
        $fields['posts_ids']['object_type'] = array_keys($post_types);

        // skip parent, go directly to grandparent.
        return Group_Control_Base::prepare_fields($fields);
    }

    /**
     * Get child default arguments
     *
     * @return mixed
     */
    protected function get_child_default_args()
    {
        $args            = parent::get_child_default_args();
        $args['presets'] = array( 'full' );

        return $args;
    }

    /**
     * Get Default options
     *
     * @return array
     */
    protected function get_default_options()
    {
        return array(
        'popover' => false,
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
