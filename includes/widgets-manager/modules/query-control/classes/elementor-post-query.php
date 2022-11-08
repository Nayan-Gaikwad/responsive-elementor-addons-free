<?php
/**
 * Elementor Post Query
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Modules\QueryControl\Classes;

use Elementor\Widget_Base;
use Responsive_Elementor_Addons\WidgetsManager\Modules\QueryControl\Module;
/**
 * Elementor Post Query Class
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */
class Elementor_Post_Query
{
    /**
     * Widget
     *
     * @var mixed
     */
    protected $widget;

    /**
     * Query Arguments
     *
     * @var array
     */
    protected $query_args;

    /**
     * Prefix
     *
     * @var mixed
     */
    protected $prefix;

    /**
     * Widget Settings
     *
     * @var array
     */
    protected $widget_settings;

    /**
     * Elementor_Post_Query constructor.
     *
     * @param Widget_Base $widget           Widget.
     * @param string      $group_query_name Group Query Name.
     * @param array       $query_args       Query Arguments.
     */
    public function __construct( $widget, $group_query_name, $query_args = array() )
    {
        $this->widget     = $widget;
        $this->prefix     = $group_query_name . '_';
        $this->query_args = $query_args;

        $settings = $this->widget->get_settings();
        $defaults = $this->get_query_defaults();

        $this->widget_settings = wp_parse_args($settings, $defaults);
    }

    /**
     * 1) build query args
     * 2) invoke callback to fine-tune query-args
     * 3) generate WP_Query object
     * 4) if no results & fallback is set, generate a new WP_Query with fallback args
     * 5) return WP_Query
     *
     * @return \WP_Query
     */
    public function get_query()
    {
        $this->get_query_args();

        $offset_control = $this->get_widget_settings('offset');

        $query_id = $this->get_widget_settings('query_id');
        if (! empty($query_id) ) {
            add_action('pre_get_posts', array( $this, 'pre_get_posts_query_filter' ));
        }

        if (0 < $offset_control ) {
            add_action('pre_get_posts', array( $this, 'fix_query_offset' ), 1);
            add_filter('found_posts', array( $this, 'fix_query_found_posts' ), 1, 2);
        }

        $query = new \WP_Query($this->query_args);

        remove_action('pre_get_posts', array( $this, 'pre_get_posts_query_filter' ));
        remove_action('pre_get_posts', array( $this, 'fix_query_offset' ), 1);
        remove_filter('found_posts', array( $this, 'fix_query_found_posts' ), 1);

        Module::add_to_avoid_list(wp_list_pluck($query->posts, 'ID'));

        return $query;
    }

    /**
     * Function Get Query Defaults.
     *
     * @return array
     */
    protected function get_query_defaults()
    {
        $defaults = array(
        $this->prefix . 'post_type'      => 'post',
        $this->prefix . 'posts_ids'      => array(),
        $this->prefix . 'orderby'        => 'date',
        $this->prefix . 'order'          => 'desc',
        $this->prefix . 'offset'         => 0,
        $this->prefix . 'posts_per_page' => 3,
        );

        return $defaults;
    }

    /**
     * Get Query Arguments
     *
     * @return mixed
     */
    public function get_query_args()
    {
        $post_type = $this->get_widget_settings('post_type');

        if ('current_query' === $post_type ) {
            $current_query_vars = $GLOBALS['wp_query']->query_vars;

            $current_query_vars = apply_filters('elementor/query/get_query_args/current_query', $current_query_vars);
            $this->query_args   = $current_query_vars;
            return $current_query_vars;
        }

        $this->set_common_args();
        $this->set_order_args();
        $this->set_pagination_args();
        $this->set_post_include_args();

        if ('by_id' !== $post_type ) {

            $this->set_post_exclude_args();
            $this->set_avoid_duplicates();
            $this->set_terms_args();
            $this->set_author_args();
            $this->set_date_args();
        }

        $this->query_args = apply_filters('elementor/query/query_args', $this->query_args, $this->widget);

        return $this->query_args;
    }

    /**
     * Function Set Pagination Agruments
     *
     * @return void
     */
    protected function set_pagination_args()
    {
        $this->set_query_arg('posts_per_page', $this->get_widget_settings('posts_per_page'));
        $sticky_post = $this->get_widget_settings('ignore_sticky_posts') ? true : false;
        $this->set_query_arg('ignore_sticky_posts', $sticky_post);
    }

    /**
     * Function Set Common Arguments
     *
     * @return void
     */
    protected function set_common_args()
    {
        $this->query_args['post_status'] = 'publish'; // Hide drafts/private posts for admins.

        $post_type = $this->get_widget_settings('post_type');
        if ('by_id' === $post_type ) {
            $post_types                    = $this->get_public_post_types();
            $this->query_args['post_type'] = array_keys($post_types);
        } else {
            $this->query_args['post_type'] = $post_type;
        }
    }

    /**
     * Function Set Pot Include Agruments
     *
     * @return void
     */
    protected function set_post_include_args()
    {

        if ('by_id' === $this->get_widget_settings('post_type') ) {

            $this->set_query_arg('post__in', $this->get_widget_settings('posts_ids'));

            if (empty($this->query_args['post__in']) ) {
                // If no selection - return an empty query.
                $this->query_args['post__in'] = array( 0 );
            }
        }
    }

    /**
     * Set Post Exclude Agruments
     *
     * @return void
     */
    protected function set_post_exclude_args()
    {

        $exclude = $this->get_widget_settings('exclude');

        if (empty($exclude) ) {
            return;
        }

        $post__not_in = array();

        if ($this->maybe_in_array('current_post', $exclude) ) {
            if (is_singular() ) {
                $post__not_in[] = get_queried_object_id();
            }
        }

        $exclude_ids = $this->get_widget_settings('exclude_ids');
        if ($this->maybe_in_array('manual_selection', $exclude) && ! empty($exclude_ids) ) {
            $post__not_in = array_merge($post__not_in, $exclude_ids);
        }

        $this->set_query_arg('post__not_in', $post__not_in);
    }

    /**
     * Function Set Avoid Duplicates
     *
     * @return void
     */
    protected function set_avoid_duplicates()
    {
        if ('yes' === $this->get_widget_settings('avoid_duplicates') ) {
            $post__not_in = isset($this->query_args['post__not_in']) ? $this->query_args['post__not_in'] : array();
            $post__not_in = array_merge($post__not_in, Module::$displayed_ids);
            $this->set_query_arg('post__not_in', $post__not_in);
        }
    }

    /**
     * Function Set Terms Arguments
     *
     * @return void
     */
    protected function set_terms_args()
    {

        $post_type = $this->get_widget_settings('post_type');

        if ('by_id' === $post_type ) {
            return;
        }
        $this->build_terms_query_include('include_term_ids');
        $this->build_terms_query_exclude('exclude_term_ids');
    }

    /**
     * Function Build Terma Query Include
     *
     * @param  [type] $control_id Control ID.
     * @return void
     */
    protected function build_terms_query_include( $control_id )
    {
        $this->build_terms_query('include', $control_id);
    }

    /**
     * Function Build Terms Query Exclude
     *
     * @param  [type] $control_id Control ID.
     * @return void
     */
    protected function build_terms_query_exclude( $control_id )
    {
        $this->build_terms_query('exclude', $control_id, true);
    }

    /**
     * Function Build Terms Query
     *
     * @param  [type] $tab_id     Tab ID.
     * @param  [type] $control_id Control ID.
     * @param  bool   $exclude    Exclude.
     * @return void
     */
    protected function build_terms_query( $tab_id, $control_id, $exclude = false )
    {
        $tab_id         = $this->get_widget_settings($tab_id);
        $settings_terms = $this->get_widget_settings($control_id);
        if (empty($tab_id) || empty($settings_terms) || ! $this->maybe_in_array('terms', $tab_id) ) {
            return;
        }

        $terms = array();

        // Switch to term_id in order to get all term children (sub-categories).
        foreach ( $settings_terms as $id ) {
            $term_data = get_term_by('term_taxonomy_id', $id);
            if (false !== $term_data ) {
                $taxonomy             = $term_data->taxonomy;
                $terms[ $taxonomy ][] = $id;
            }
        }
        $this->insert_tax_query($terms, $exclude);
    }

    /**
     * Insert Taxonomy Query
     *
     * @param  [type] $terms   Terms.
     * @param  bool   $exclude Exclude.
     * @return void
     */
    protected function insert_tax_query( $terms, $exclude )
    {
        $tax_query = array();
        foreach ( $terms as $taxonomy => $ids ) {
            $query = array(
            'taxonomy' => $taxonomy,
            'field'    => 'term_taxonomy_id',
            'terms'    => $ids,
            );

            if ($exclude ) {
                $query['operator'] = 'NOT IN';
            }

            $tax_query[] = $query;
        }

        if (empty($tax_query) ) {
            return;
        }

        if (empty($this->query_args['tax_query']) ) {
            $this->query_args['tax_query'] = $tax_query;
        } else {
            $this->query_args['tax_query']['relation'] = 'AND';
            $this->query_args['tax_query'][]           = $tax_query;
        }
    }

    /**
     * Set Author Arguments
     *
     * @return void
     */
    protected function set_author_args()
    {

        $include_authors = $this->get_widget_settings('include_authors');
        if (! empty($include_authors) && $this->maybe_in_array('authors', $this->get_widget_settings('include')) ) {
            $this->set_query_arg('author__in', $include_authors);
        }

        $exclude_authors = $this->get_widget_settings('exclude_authors');
        if (! empty($exclude_authors) && $this->maybe_in_array('authors', $this->get_widget_settings('exclude')) ) {
            // exclude only if not explicitly included.
            if (empty($this->query_args['author__in']) ) {
                $this->set_query_arg('author__not_in', $exclude_authors);
            }
        }
    }

    /**
     * Set Order Arguments
     *
     * @return void
     */
    protected function set_order_args()
    {
        $order = $this->get_widget_settings('order');
        if (! empty($order) ) {
            $this->set_query_arg('orderby', $this->get_widget_settings('orderby'));
            $this->set_query_arg('order', $this->get_widget_settings('order'));
        }
    }

    /**
     * Function Set date agruments
     *
     * @return void
     */
    protected function set_date_args()
    {

        $select_date = $this->get_widget_settings('select_date');
        if (! empty($select_date) ) {
            $date_query = array();
            switch ( $select_date ) {
            case 'today':
                $date_query['after'] = '-1 day';
                break;
            case 'week':
                $date_query['after'] = '-1 week';
                break;
            case 'month':
                   $date_query['after'] = '-1 month';
                break;
            case 'quarter':
                $date_query['after'] = '-3 month';
                break;
            case 'year':
                $date_query['after'] = '-1 year';
                break;
            case 'exact':
                $after_date = $this->get_widget_settings('date_after');
                if (! empty($after_date) ) {
                     $date_query['after'] = $after_date;
                }
                $before_date = $this->get_widget_settings('date_before');
                if (! empty($before_date) ) {
                    $date_query['before'] = $before_date;
                }
                $date_query['inclusive'] = true;
                break;
            }

            $this->set_query_arg('date_query', $date_query);
        }
    }

    /**
     * Function Get widget settings
     *
     * @param string $control_name Control Name.
     *
     * @return mixed|null
     */
    protected function get_widget_settings( $control_name )
    {
        $control_name = $this->prefix . $control_name;
        return isset($this->widget_settings[ $control_name ]) ? $this->widget_settings[ $control_name ] : null;
    }

    /**
     * Function Set Query Arguments
     *
     * @param string $key   Key.
     * @param mixed  $value Value.
     */
    protected function set_query_arg( $key, $value )
    {
        if (! isset($this->query_args[ $key ]) ) {
            $this->query_args[ $key ] = $value;
        }
    }

    /**
     * Maybe in Array
     *
     * @param string $value       Value.
     * @param mixed  $maybe_array MaybeArray.
     *
     * @return bool
     */
    protected function maybe_in_array( $value, $maybe_array )
    {
        return is_array($maybe_array) ? in_array($value, $maybe_array, true) : $value === $maybe_array;
    }

    /**
     * Function Pre Get Posts Query Filter.
     *
     * @param \WP_Query $wp_query WP_Query.
     */
    public function pre_get_posts_query_filter( $wp_query )
    {
        if ($this->widget ) {
            $query_id    = $this->get_widget_settings('query_id');
            $widget_name = $this->widget->getName();
            do_action("elementor/query/{$query_id}", $wp_query, $this->widget);
        }
    }

    /**
     * Function Fix Query Offset
     *
     * @param \WP_Query $query Query.
     */
    public function fix_query_offset( &$query )
    {
        $offset = $this->get_widget_settings('offset');

        if ($offset && $query->is_paged ) {
            $query->query_vars['offset'] = $offset + ( ( $query->query_vars['paged'] - 1 ) * $query->query_vars['posts_per_page'] );
        } else {
            $query->query_vars['offset'] = $offset;
        }
    }

    /**
     * Function Fix Query Found Post.
     *
     * @param int       $found_posts Found Posts.
     * @param \WP_Query $query       Query.
     *
     * @return int
     */
    public function fix_query_found_posts( $found_posts, $query )
    {
        $offset = $this->get_widget_settings('offset');

        if ($offset ) {
            $found_posts -= $offset;
        }

        return $found_posts;
    }

    /**
     * Get public post type list
     *
     * @param  array $args Arguments.
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
