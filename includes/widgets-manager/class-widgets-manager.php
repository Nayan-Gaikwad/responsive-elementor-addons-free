<?php
/**
 * Widgets Manager for Responsive Elementor Addons
 *
 * @package responsive-elementor-addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager;

use Elementor\Plugin;
use Responsive_Elementor_Addons\WidgetsManager\Widgets\Posts;

if (! defined('WPINC') ) {
    exit;
}
/**
 * Class Widgets_Manager
 *
 * @package Responsive_Elementor_Addons\WidgetsManager
 */
class Widgets_Manager
{

    private static $instance = null;

    /**
     * Get instance of Widgets_Manager
     *
     * @return Widgets_Manager
     */
    public static function instance()
    {
        if (! isset(self::$instance) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function __construct()
    {
        // Register Custom Controls.
        $this->register_modules();

        // Register category for responsive elementor addons.
        add_action('elementor/elements/categories_registered', array( $this, 'register_responsive_widget_category' ));

        // Register all the widgets.
        add_action('elementor/widgets/widgets_registered', array( $this, 'register_responsive_widgets' ));

        // Register Admin Scripts.
        add_action('elementor/editor/before_enqueue_scripts', array( $this, 'editor_scripts' ));

        // Register all Controls.
        add_action('elementor/controls/controls_registered', array( $this, 'register_responsive_controls' ));

        add_action('wp_head', array( $this, 'render_faq_schema' ));

        add_filter('pre_handle_404', array( $this, 'allow_posts_widget_pagination' ), 10, 2);
    }

    public function allow_posts_widget_pagination( $handled, $wp_query )
    {
        // Check it's not already handled and it's a single paged query.
        if ($handled || empty($wp_query->query_vars['page']) || ! is_singular() || empty($wp_query->post) ) {
            return $handled;
        }

        $document = Plugin::instance()->documents->get($wp_query->post->ID);

        return $this->is_valid_pagination($document->get_elements_data(), $wp_query->query_vars['page']);
    }

    public function is_valid_pagination( array $elements, $current_page )
    {
        $is_valid = false;

        // Get all widgets that may add pagination.
        $widgets       = Plugin::instance()->widgets_manager->get_widget_types();
        $posts_widgets = array();
        foreach ( $widgets as $widget ) {
            if ($widget instanceof Posts ) {
                $posts_widgets[] = $widget->getName();
            }
        }

        Plugin::instance()->db->iterate_data(
            $elements,
            function ( $element ) use ( &$is_valid, $posts_widgets, $current_page ) {
                if (isset($element['widgetType']) && in_array($element['widgetType'], $posts_widgets, true) ) {
                    // Has pagination.
                    if (! empty($element['settings']['pagination_type']) ) {
                        // No max pages limits.
                        if (empty($element['settings']['pagination_page_limit']) ) {
                            $is_valid = true;
                        } elseif ((int) $current_page <= (int) $element['settings']['pagination_page_limit'] ) {
                            // Has page limit but current page is less than or equal to max page limit.
                            $is_valid = true;
                        }
                    }
                }
            }
        );

        return $is_valid;
    }

    /**
     * Render the FAQ schema.
     *
     * @since 1.2.0
     *
     * @access public
     */
    public function render_faq_schema()
    {
        $faqs_data = $this->get_faqs_data();
        if ($faqs_data ) {
            $schema_data = array(
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $faqs_data,
            );

            $encoded_data = wp_json_encode($schema_data);
            ?>
            <script type="application/ld+json">
            <?php print_r($encoded_data); ?>
            </script>
            <?php
        }
    }

    /**
     * Get FAQ data.
     *
     * @since 1.2.0
     *
     * @access public
     */
    public function get_faqs_data()
    {
        $elementor = \Elementor\Plugin::$instance;
        $document  = $elementor->documents->get(get_the_ID());

        if (! $document ) {
            return;
        }

        $data        = $document->get_elements_data();
        $widget_ids  = $this->get_widget_ids();
        $object_data = array();

        foreach ( $widget_ids as $widget_id ) {
            $widget_data            = $this->find_element_recursive($data, $widget_id);
            $widget                 = $elementor->elements_manager->create_element_instance($widget_data);
            $settings               = $widget->get_settings();
            $content_schema_warning = 0;
            $enable_schema          = $settings['rea_schema_support'];

            foreach ( $settings['rea_tabs'] as $key ) {
                if ('content' !== $key['rea_faq_content_type'] ) {
                    $content_schema_warning = 1;
                }
            }

            if ('yes' === $enable_schema && ( 0 === $content_schema_warning ) ) {
                foreach ( $settings['rea_tabs'] as $faqs ) {
                    $new_data = array(
                    '@type'          => 'Question',
                    'name'           => $faqs['rea_question'],
                    'acceptedAnswer' =>
                    array(
                    '@type' => 'Answer',
                    'text'  => $faqs['rea_answer'],
                    ),
                    );
                    array_push($object_data, $new_data);
                }
            }
        }

        return $object_data;
    }

    /**
     * Get the widget ID.
     *
     * @since 1.2.0
     *
     * @access public
     */
    public function get_widget_ids()
    {
        $elementor = \Elementor\Plugin::$instance;
        $document  = $elementor->documents->get(get_the_ID());

        if (! $document ) {
            return;
        }

        $data       = $document->get_elements_data();
        $widget_ids = array();

        $elementor->db->iterate_data(
            $data,
            function ( $element ) use ( &$widget_ids ) {
                if (isset($element['widgetType']) && 'rea-faq' === $element['widgetType'] ) {
                    array_push($widget_ids, $element['id']);
                }
            }
        );
        return $widget_ids;
    }

    /**
     * Get Widget Setting data.
     *
     * @since  1.2.0
     * @access public
     * @param  array  $elements Element array.
     * @param  string $form_id  Element ID.
     * @return Boolean True/False.
     */
    public function find_element_recursive( $elements, $form_id )
    {

        foreach ( $elements as $element ) {
            if ($form_id === $element['id'] ) {
                return $element;
            }

            if (! empty($element['elements']) ) {
                $element = $this->find_element_recursive($element['elements'], $form_id);

                if ($element ) {
                    return $element;
                }
            }
        }

        return false;
    }

    public function editor_scripts()
    {
        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        // Elementor Custom Scripts.
        wp_register_script(
            'rea-elementor-editor',
            REA_URL . 'assets/js/editor' . $suffix . '.js',
            array( 'jquery-elementor-select2' ),
            REA_VER
        );

        wp_enqueue_script('rea-elementor-editor');
    }

    /**
     * Place your widgets name list here for responsive elementor addons
     *
     * @return array
     */
    public static function get_responsive_widgets_list()
    {
        $widget_list = array(
        'pricing-table',
        'button',
        'icon-box',
        'media-carousel',
        'rea-video',
        );

        return $widget_list;
    }

    /**
     *  Include files for the responsive elementor controls
     */
    public function register_responsive_controls()
    {

        $controls_manager = Plugin::$instance->controls_manager;

        include_once REA_DIR . '/includes/widgets-manager/controls/rea-media-select.php';
        include_once REA_DIR . '/includes/widgets-manager/controls/rea-visual-select.php';
        include_once REA_DIR . '/includes/widgets-manager/controls/rea-ajax-select2.php';

        $controls_manager->register_control('rea-media', new Controls\REA_Control_Media_Select());
        $controls_manager->register_control('rea-visual-select', new Controls\REA_Control_Visual_Select());
        $controls_manager->register_control('rea-ajax-select2', new Controls\REA_Control_Ajax_Select2());

    }

    /**
     *  Include all the files for responsive elementor widgets
     */
    public function include_responsive_widgets_files()
    {
        $widget_list = $this->get_responsive_widgets_list();

        if (! empty($widget_list) ) {
            foreach ( $widget_list as $handle => $data ) {
                include_once REA_DIR . '/includes/widgets-manager/widgets/class-' . $data . '.php';
            }
        }
    }

    /**
     * Register new category for Responsive Elementor Addons
     *
     * @param  object $elements_manager class.
     * @return mixed
     */
    public function register_responsive_widget_category( $elements_manager )
    {
        $category = __('Responsive Elementor Addons', 'responsive-elementor-addons');

        $elements_manager->add_category(
            'responsive-elementor-addon',
            array(
            'title' => $category,
            'icon'  => 'eicon-font',
            )
        );

        return $elements_manager;
    }

    /**
     * Register the responsive elementor widgets
     *
     * @throws \Exception Throws Exception.
     */
    public function register_responsive_widgets()
    {

        $this->include_responsive_widgets_files();

        // Register Responsive Widgets.

        Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Pricing_Table());
        Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Button());
        Plugin::instance()->widgets_manager->register_widget_type(new Widgets\ReaIconbox());
        Plugin::instance()->widgets_manager->register_widget_type(new Widgets\REA_Media_Carousel());
        Plugin::instance()->widgets_manager->register_widget_type(new Widgets\REA_Video());

    }

    /**
     * Register query control modules for all widgets requiring query module to fetch data.
     */
    public function register_modules()
    {

        $modules = array(
        array(
        'file'  => REA_DIR . 'includes/widgets-manager/modules/query-control/module.php',
        'class' => 'Modules\QueryControl\Module',
        ),
        array(
        'file'  => REA_DIR . 'includes/widgets-manager/modules/single-query-control/module.php',
        'class' => 'Modules\SingleQueryControl\Module',
        ),
        );

        foreach ( $modules as $module ) {
            if (! empty($module['file']) && ! empty($module['class']) ) {
                include_once $module['file'];

                if (isset($module['instance']) ) {
                    continue;
                }

                if (class_exists(__NAMESPACE__ . '\\' . $module['class']) ) {
                    $class_name = __NAMESPACE__ . '\\' . $module['class'];
                } else {
                    continue;
                }
                new $class_name();
            }
        }
    }

}

Widgets_Manager::instance();
