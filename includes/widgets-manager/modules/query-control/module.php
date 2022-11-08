<?php
/**
 * Module
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Modules\QueryControl;

use Elementor\Controls_Manager;
use Elementor\Core\Common\Modules\Ajax\Module as Ajax;
use Elementor\Widget_Base;
use Elementor\Core\Base\Module as Module_Base;
use Responsive_Elementor_Addons\WidgetsManager\Modules\QueryControl\Controls\Group_Control_Posts;
use Responsive_Elementor_Addons\WidgetsManager\Modules\QueryControl\Controls\Group_Control_Query;
use Responsive_Elementor_Addons\WidgetsManager\Modules\QueryControl\Controls\Group_Control_Related;
use Responsive_Elementor_Addons\WidgetsManager\Modules\QueryControl\Classes\Elementor_Post_Query;
use Responsive_Elementor_Addons\WidgetsManager\Modules\QueryControl\Classes\Elementor_Related_Query;
use Responsive_Elementor_Addons\WidgetsManager\Modules\QueryControl\Controls\Query;
use Elementor\Plugin;

if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}
/**
 * Module Class extending Module Base.
 *
 * @since 1.0.0
 */
class Module extends Module_Base
{

    const QUERY_CONTROL_ID = 'rea-query';

    const QUERY_OBJECT_POST = 'post';
    /**
     * Displayed Ids
     *
     * @var array
     */
    public static $displayed_ids = array();

    /**
     * Construct
     */
    public function __construct()
    {
        $this->add_actions();
    }

    /**
     * Add to avoid list
     *
     * @param  mixed $ids Ids.
     * @return void
     */
    public static function add_to_avoid_list( $ids )
    {
        self::$displayed_ids = array_merge(self::$displayed_ids, $ids);
    }

    /**
     * Get avoid list ids
     *
     * @return mixed
     */
    public static function get_avoid_list_ids()
    {
        return self::$displayed_ids;
    }

    /**
     * Add exclude controls
     *
     * @param  mixed $widget widget.
     * @return void
     */
    public static function add_exclude_controls( $widget )
    {

        $widget->add_control(
            'exclude',
            array(
            'label'       => __('Exclude', 'responsive-elementor-addons'),
            'type'        => Controls_Manager::SELECT2,
            'multiple'    => true,
            'options'     => array(
            'current_post'     => __('Current Post', 'responsive-elementor-addons'),
            'manual_selection' => __('Manual Selection', 'responsive-elementor-addons'),
            ),
            'label_block' => true,
            )
        );

        $widget->add_control(
            'exclude_ids',
            array(
            'label'       => __('Search & Select', 'responsive-elementor-addons'),
            'type'        => 'rea-query',
            'post_type'   => '',
            'options'     => array(),
            'label_block' => true,
            'multiple'    => true,
            'filter_type' => 'by_id',
            'condition'   => array(
            'exclude' => 'manual_selection',
            ),
            )
        );

        $widget->add_control(
            'avoid_duplicates',
            array(
            'label'       => __('Avoid Duplicates', 'responsive-elementor-addons'),
            'type'        => Controls_Manager::SWITCHER,
            'default'     => '',
            'description' => __('Set to Yes to avoid duplicate posts from showing up on the page. This only affects the frontend.', 'responsive-elementor-addons'),
            )
        );

    }

    /**
     * Retrieve Name
     *
     * @return string
     */
    public function getName()
    {
        return 'query-control';
    }

    /**
     * Search Taxonomies
     *
     * @param  mixed $query_params Query Parameters.
     * @param  mixed $data         Data.
     * @return array
     */
    private function search_taxonomies( $query_params, $data )
    {
        $by_field = $this->extract_term_by_field($data);
        $terms    = get_terms($query_params);

        global $wp_taxonomies;

        $results = array();

        foreach ( $terms as $term ) {
            $term_name = $this->get_term_name_with_parents($term);
            if (! empty($data['include_type']) ) {
                $text = $wp_taxonomies[ $term->taxonomy ]->labels->name . ': ' . $term_name;
            } else {
                $text = $term_name;
            }

            $results[] = array(
            'id'   => $term->{$by_field},
            'text' => $text,
            );
        }

        return $results;

    }

    /**
     * Extract term by field
     *
     * @param array $data data.
     *
     * @return string
     */
    private function extract_term_by_field( $data )
    {
        if (! empty($data['query']) && ! empty($data['query']['by_field']) ) {
            return $data['query']['by_field'];
        }

        return 'term_taxonomy_id';
    }

    /**
     * Ajax Posts filter autocomplete
     *
     * @param array $data data.
     *
     * @return array
     * @throws \Exception Bad Request.
     */
    public function ajax_posts_filter_autocomplete( array $data )
    {
        if (empty($data['filter_type']) || empty($data['q']) ) {
            throw new \Exception('Bad Request');
        }

        $results = array();

        switch ( $data['filter_type'] ) {
        case 'taxonomy':
            $query_params = array(
            'taxonomy'   => $this->extract_post_type($data),
            'search'     => $data['q'],
            'hide_empty' => false,
            );

            $results = $this->search_taxonomies($query_params, $data);

            break;

        case 'cpt_taxonomies':
            $post_type = $this->extract_post_type($data);

            $taxonomies = get_object_taxonomies($post_type);

            $query_params = array(
            'taxonomy'   => $taxonomies,
            'search'     => $data['q'],
            'hide_empty' => false,
            );

            $results = $this->search_taxonomies($query_params, $data);

            break;

        case 'by_id':
        case 'post':
            $query_params = array(
            'post_type'      => $this->extract_post_type($data),
            's'              => $data['q'],
            'posts_per_page' => -1,
            );

            if ('attachment' === $query_params['post_type'] ) {
                $query_params['post_status'] = 'inherit';
            }

            $query = new \WP_Query($query_params);

            foreach ( $query->posts as $post ) {
                $post_type_obj = get_post_type_object($post->post_type);
                if (! empty($data['include_type']) ) {
                    $text = $post_type_obj->labels->name . ': ' . $post->post_title;
                } else {
                    $text = ( $post_type_obj->hierarchical ) ? $this->get_post_name_with_parents($post) : $post->post_title;
                }

                $results[] = array(
                        'id'   => $post->ID,
                        'text' => $text,
                );
            }
            break;

        case 'author':
            $query_params = array(
            'who'                 => 'authors',
            'has_published_posts' => true,
            'fields'              => array(
                        'ID',
                        'display_name',
            ),
            'search'              => '*' . $data['q'] . '*',
            'search_columns'      => array(
                        'user_login',
                        'user_nicename',
            ),
            );

            $user_query = new \WP_User_Query($query_params);

            foreach ( $user_query->get_results() as $author ) {
                $results[] = array(
                'id'   => $author->ID,
                'text' => $author->display_name,
                );
            }
            break;
        default:
            $results = apply_filters('rea/core_elements/query_control/get_autocomplete/' . $data['filter_type'], array(), $data);
        }

        return array(
        'results' => $results,
        );
    }

    /**
     * Ajax posts control value titles
     *
     * @param  mixed $request Request.
     * @return array
     */
    public function ajax_posts_control_value_titles( $request )
    {
        $ids = (array) $request['id'];

        $results = array();

        switch ( $request['filter_type'] ) {
        case 'cpt_taxonomies':
        case 'taxonomy':
            $by_field = $this->extract_term_by_field($request);
            $terms    = get_terms(
                array(
                $by_field    => $ids,
                'hide_empty' => false,
                )
            );

            global $wp_taxonomies;
            foreach ( $terms as $term ) {
                  $term_name = $this->get_term_name_with_parents($term);
                if (! empty($request['include_type']) ) {
                    $text = $wp_taxonomies[ $term->taxonomy ]->labels->name . ': ' . $term_name;
                } else {
                    $text = $term_name;
                }
                    $results[ $term->{$by_field} ] = $text;
            }
            break;

        case 'by_id':
        case 'post':
            $query = new \WP_Query(
                array(
                'post_type'      => 'any',
                'post__in'       => $ids,
                'posts_per_page' => -1,
                )
            );

            foreach ( $query->posts as $post ) {
                $results[ $post->ID ] = $post->post_title;
            }
            break;

        case 'author':
            $query_params = array(
            'who'                 => 'authors',
            'has_published_posts' => true,
            'fields'              => array(
                        'ID',
                        'display_name',
            ),
            'include'             => $ids,
            );

            $user_query = new \WP_User_Query($query_params);

            foreach ( $user_query->get_results() as $author ) {
                $results[ $author->ID ] = $author->display_name;
            }
            break;
        default:
            $results = apply_filters('rea/core_elements/query_control/get_value_titles/' . $request['filter_type'], array(), $request);
        }

        return $results;
    }

    /**
     * Regsiter Controls
     *
     * @return void
     */
    public function registerControls()
    {
        $controls_manager = Plugin::instance()->controls_manager;

        $controls = array(
        'rea-query'         => array(
        'file'  => __DIR__ . '/controls/query.php',
        'class' => 'Controls\Query',
        'type'  => 'single',
        ),
        'rea-posts'         => array(
        'file'  => __DIR__ . '/controls/group-control-posts.php',
        'class' => 'Controls\Group_Control_Posts',
        'type'  => 'group',
        ),
        'rea-query-group'   => array(
        'file'  => __DIR__ . '/controls/group-control-query.php',
        'class' => 'Controls\Group_Control_Query',
        'type'  => 'group',
        ),
        'rea-related-query' => array(
        'file'  => __DIR__ . '/controls/group-control-related.php',
        'class' => 'Controls\Group_Control_Related',
        'type'  => 'group',
        ),
        );

        foreach ( $controls as $control_type => $control_info ) {
            if (! empty($control_info['file']) && ! empty($control_info['class']) ) {
                include_once $control_info['file'];

                if (class_exists($control_info['class']) ) {
                    $class_name = $control_info['class'];
                } elseif (class_exists(__NAMESPACE__ . '\\' . $control_info['class']) ) {
                    $class_name = __NAMESPACE__ . '\\' . $control_info['class'];
                }

                if ('group' === $control_info['type'] ) {
                    $controls_manager->add_group_control($control_type, new $class_name());
                } else {
                    $controls_manager->register_control($control_type, new $class_name());
                }
            }
        }

    }

    /**
     * Extract Post Types
     *
     * @param  array $data data.
     * @return array
     */
    private function extract_post_type( $data )
    {

        if (! empty($data['query']) && ! empty($data['query']['post_type']) ) {
            return $data['query']['post_type'];
        }

        return $data['object_type'];
    }

    /**
     * Function Get Term Name with Parents
     *
     * @param \WP_Term $term Term.
     * @param int      $max  Max.
     *
     * @return string
     */
    private function get_term_name_with_parents( \WP_Term $term, $max = 3 )
    {
        if (0 === $term->parent ) {
            return $term->name;
        }
        $separator = is_rtl() ? ' < ' : ' > ';
        $test_term = $term;
        $names     = array();
        while ( $test_term->parent > 0 ) {
            $test_term = get_term_by('term_taxonomy_id', $test_term->parent);
            if (! $test_term ) {
                break;
            }
            $names[] = $test_term->name;
        }

        $names = array_reverse($names);
        if (count($names) < ( $max ) ) {
            return implode($separator, $names) . $separator . $term->name;
        }

        $name_string = '';
        for ( $i = 0; $i < ( $max - 1 ); $i++ ) {
            $name_string .= $names[ $i ] . $separator;
        }
        return $name_string . '...' . $separator . $term->name;
    }

    /**
     * Get post name with parents
     *
     * @param \WP_Post $post Post.
     * @param int      $max  Max.
     *
     * @return string
     */
    private function get_post_name_with_parents( $post, $max = 3 )
    {
        if (0 === $post->post_parent ) {
            return $post->post_title;
        }
        $separator = is_rtl() ? ' < ' : ' > ';
        $test_post = $post;
        $names     = array();
        while ( $test_post->post_parent > 0 ) {
            $test_post = get_post($test_post->post_parent);
            if (! $test_post ) {
                break;
            }
            $names[] = $test_post->post_title;
        }

        $names = array_reverse($names);
        if (count($names) < ( $max ) ) {
            return implode($separator, $names) . $separator . $post->post_title;
        }

        $name_string = '';
        for ( $i = 0; $i < ( $max - 1 ); $i++ ) {
            $name_string .= $names[ $i ] . $separator;
        }
        return $name_string . '...' . $separator . $post->post_title;
    }

    /**
     * Function Get query Arguments.
     *
     * @param  int   $control_id Control ID.
     * @param  mixed $settings   Settings.
     * @return mixed
     */
    public function get_query_args( $control_id, $settings )
    {

        $controls_manager = Plugin::instance()->controls_manager;

        /**
         * Post Query
         *
         *  @var Group_Control_Posts $posts_query  Post Query.
        */
        $posts_query = $controls_manager->get_control_groups(Group_Control_Posts::get_type());

        return $posts_query->get_query_args($control_id, $settings);
    }

    /**
     * Function Get Query
     *
     * @param \ElementorPro\Base\Base_Widget $widget        Widget.
     * @param string                         $name          Name.
     * @param array                          $query_args    Query Args.
     * @param array                          $fallback_args Fallback Arguments.
     *
     * @return \WP_Query
     */
    public function get_query( $widget, $name, $query_args = array(), $fallback_args = array() )
    {
        $prefix    = $name . '_';
        $post_type = $widget->get_settings($prefix . 'post_type');
        include_once __DIR__ . '/classes/elementor-post-query.php';
        if ('related' === $post_type ) {
            include_once __DIR__ . '/classes/elementor-related-query.php';
            $elementor_query = new Elementor_Related_Query($widget, $name, $query_args, $fallback_args);
        } else {
            $elementor_query = new Elementor_Post_Query($widget, $name, $query_args);
        }
        return $elementor_query->get_query();
    }

    /**
     * Function to Fix Query Offset
     *
     * @param  mixed $query Query.
     * @return void
     */
    public function fix_query_offset( &$query )
    {
        if (! empty($query->query_vars['offset_to_fix']) ) {
            if ($query->is_paged ) {
                $query->query_vars['offset'] = $query->query_vars['offset_to_fix'] + ( ( $query->query_vars['paged'] - 1 ) * $query->query_vars['posts_per_page'] );
            } else {
                $query->query_vars['offset'] = $query->query_vars['offset_to_fix'];
            }
        }
    }

    /**
     * Function to fix query found post
     *
     * @param  array $found_posts Found Post.
     * @param  mixed $query       Query.
     * @return array
     */
    public static function fix_query_found_posts( $found_posts, $query )
    {
        $offset_to_fix = $query->get('offset_to_fix');

        if ($offset_to_fix ) {
            $found_posts -= $offset_to_fix;
        }

        return $found_posts;
    }

    /**
     * Function Register Ajax Actions
     *
     * @param Ajax $ajax_manager Ajax Manager.
     */
    public function register_ajax_actions( $ajax_manager )
    {
        $ajax_manager->register_ajax_action('query_control_value_titles', array( $this, 'ajax_posts_control_value_titles' ));
        $ajax_manager->register_ajax_action('panel_posts_control_filter_autocomplete', array( $this, 'ajax_posts_filter_autocomplete' ));
    }

    /**
     * Localize Settings
     *
     * @param  array $settings Settings.
     * @return array
     */
    public function localize_settings( $settings )
    {
        $settings = array_replace_recursive(
            $settings,
            array(
            'i18n' => array(
            'all' => __('All', 'responsive-elementor-addons'),
            ),
            )
        );

        return $settings;
    }

    /**
     * Function Add actions.
     *
     * @return void
     */
    protected function add_actions()
    {
        add_action('elementor/ajax/register_actions', array( $this, 'register_ajax_actions' ));
        add_action('elementor/controls/controls_registered', array( $this, 'registerControls' ));

        add_filter('rea/core_elements/editor/localize_settings', array( $this, 'localize_settings' ));

        /**
         * URL
         *
         * @see https://codex.wordpress.org/Making_Custom_Queries_using_Offset_and_Pagination
         */
        add_action('pre_get_posts', array( $this, 'fix_query_offset' ), 1);
        add_filter('found_posts', array( $this, 'fix_query_found_posts' ), 1, 2);
    }
}
