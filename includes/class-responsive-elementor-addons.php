<?php

use Elementor\Utils;
use Elementor\Plugin;
use Elementor\Icons_Manager;
use Responsive_Elementor_Addons\Helper\Helper;

if (! defined('ABSPATH') ) {
    exit;
}

class Responsive_Elementor_Addons
{

    const MINIMUM_ELEMENTOR_VERSION = '2.9.6';

    private static $instance = null;

    public static function instance()
    {

        if (is_null(self::$instance) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {

        add_action('init', array( $this, 'i18n' ));
        add_action('plugins_loaded', array( $this, 'init' ));

        add_action('elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_frontend_scripts' ));
        add_action('elementor/frontend/after_enqueue_styles', array( $this, 'enqueue_styles' ));
        add_action('elementor/editor/before_enqueue_scripts', array( $this, 'enqueue_admin_styles' ));
        add_action('elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ));

        add_action('admin_enqueue_scripts', array( &$this, 'responsive_elementor_addons_admin_enqueue_styles' ));

        // Responsive Elementor Addons Menu.
        add_action('admin_menu', array( $this, 'responsive_elementor_addons_admin_menu' ));

        // Remove all admin notices from specific pages.
        add_action('admin_init', array( $this, 'responsive_elementor_addons_admin_init' ));

        // Redirect to Getting Started Page on Plugin Activation.
        add_action('admin_init', array( $this, 'responsive_elementor_addons_maybe_redirect_to_getting_started' ));
        add_action('wp_enqueue_scripts', array( $this, 'load_assets' ), 15);

        add_action('admin_enqueue_scripts', array( $this, 'enqueue_scripts' ));

        add_action('wp_ajax_rea_mailchimp_subscribe', array( $this, 'mailchimp_subscribe_with_ajax' ));
        add_action('wp_ajax_nopriv_rea_mailchimp_subscribe', array( $this, 'mailchimp_subscribe_with_ajax' ));

        // REA Ajax Select2.
        add_action('wp_ajax_rea_ajax_select2_search_post', [ Helper::class, 'rea_ajax_select2_posts_filter_autocomplete' ]);
        add_action('wp_ajax_nopriv_rea_ajax_select2_search_post', [ Helper::class, 'rea_ajax_select2_posts_filter_autocomplete' ]);

        add_action('wp_ajax_rea_ajax_select2_get_title', [ Helper::class, 'rea_ajax_select2_get_posts_value_titles' ]);
        add_action('wp_ajax_nopriv_rea_ajax_select2_get_title', [ Helper::class, 'rea_ajax_select2_get_posts_value_titles' ]);

        $this->load_dependencies();
        $this->define_admin_hooks();

    }

    public function mailchimp_subscribe_with_ajax()
    {
        if (! isset($_POST['fields']) ) {
            return;
        }

        $api_key = $_POST['apiKey']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
        $list_id = $_POST['listId']; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

        parse_str($_POST['fields'], $settings); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

        $merge_fields = array(
        'FNAME' => ! empty($settings['rea_mailchimp_firstname']) ? $settings['rea_mailchimp_firstname'] : '',
        'LNAME' => ! empty($settings['rea_mailchimp_lastname']) ? $settings['rea_mailchimp_lastname'] : '',
        );

        $response = wp_remote_post(
            'https://' . substr(
                $api_key,
                strpos(
                    $api_key,
                    '-'
                ) + 1
            ) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5(strtolower($settings['rea_mailchimp_email'])),
            array(
            'method'  => 'PUT',
            'headers' => array(
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode('user:' . $api_key), // phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode
            ),
            'body'    => json_encode(
                array( // phpcs:ignore WordPress.WP.AlternativeFunctions.json_encode_json_encode
                'email_address' => $settings['rea_mailchimp_email'],
                'status'        => 'subscribed',
                'merge_fields'  => $merge_fields,
                )
            ),
            )
        );

        if (! is_wp_error($response) ) {
            $response = json_decode(wp_remote_retrieve_body($response));

            if (! empty($response) ) {
                if ('subscribed' === $response->status ) {
                    wp_send_json(
                        array(
                        'status' => 'subscribed',
                        )
                    );
                } else {
                    wp_send_json(
                        array(
                        'status' => $response->title,
                        )
                    );
                }
            }
        }
        die();
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script('rea-select2', REA_URL . 'admin/assets/lib/select2/select2.js', array( 'jquery' ), REA_VER, true);

        // Select2 i18n.
        $wp_local_lang = get_locale();

        if ('' !== $wp_local_lang ) {
            $select2_available_lang = array(
            ''               => 'en',
            'hi_IN'          => 'hi',
            'mr'             => 'mr',
            'af'             => 'af',
            'ar'             => 'ar',
            'ary'            => 'ar',
            'as'             => 'as',
            'azb'            => 'az',
            'az'             => 'az',
            'bel'            => 'be',
            'bg_BG'          => 'bg',
            'bn_BD'          => 'bn',
            'bo'             => 'bo',
            'bs_BA'          => 'bs',
            'ca'             => 'ca',
            'ceb'            => 'ceb',
            'cs_CZ'          => 'cs',
            'cy'             => 'cy',
            'da_DK'          => 'da',
            'de_CH'          => 'de',
            'de_DE'          => 'de',
            'de_DE_formal'   => 'de',
            'de_CH_informal' => 'de',
            'dzo'            => 'dz',
            'el'             => 'el',
            'en_CA'          => 'en',
            'en_GB'          => 'en',
            'en_AU'          => 'en',
            'en_NZ'          => 'en',
            'en_ZA'          => 'en',
            'eo'             => 'eo',
            'es_MX'          => 'es',
            'es_VE'          => 'es',
            'es_CR'          => 'es',
            'es_CO'          => 'es',
            'es_GT'          => 'es',
            'es_ES'          => 'es',
            'es_CL'          => 'es',
            'es_PE'          => 'es',
            'es_AR'          => 'es',
            'et'             => 'et',
            'eu'             => 'eu',
            'fa_IR'          => 'fa',
            'fi'             => 'fi',
            'fr_BE'          => 'fr',
            'fr_FR'          => 'fr',
            'fr_CA'          => 'fr',
            'gd'             => 'gd',
            'gl_ES'          => 'gl',
            'gu'             => 'gu',
            'haz'            => 'haz',
            'he_IL'          => 'he',
            'hr'             => 'hr',
            'hu_HU'          => 'hu',
            'hy'             => 'hy',
            'id_ID'          => 'id',
            'is_IS'          => 'is',
            'it_IT'          => 'it',
            'ja'             => 'ja',
            'jv_ID'          => 'jv',
            'ka_GE'          => 'ka',
            'kab'            => 'kab',
            'km'             => 'km',
            'ko_KR'          => 'ko',
            'ckb'            => 'ku',
            'lo'             => 'lo',
            'lt_LT'          => 'lt',
            'lv'             => 'lv',
            'mk_MK'          => 'mk',
            'ml_IN'          => 'ml',
            'mn'             => 'mn',
            'ms_MY'          => 'ms',
            'my_MM'          => 'my',
            'nb_NO'          => 'nb',
            'ne_NP'          => 'ne',
            'nl_NL'          => 'nl',
            'nl_NL_formal'   => 'nl',
            'nl_BE'          => 'nl',
            'nn_NO'          => 'nn',
            'oci'            => 'oc',
            'pa_IN'          => 'pa',
            'pl_PL'          => 'pl',
            'ps'             => 'ps',
            'pt_BR'          => 'pt',
            'pt_PT_ao90'     => 'pt',
            'pt_PT'          => 'pt',
            'rhg'            => 'rhg',
            'ro_RO'          => 'ro',
            'ru_RU'          => 'ru',
            'sah'            => 'sah',
            'si_LK'          => 'si',
            'sk_SK'          => 'sk',
            'sl_SI'          => 'sl',
            'sq'             => 'sq',
            'sr_RS'          => 'sr',
            'sv_SE'          => 'sv',
            'szl'            => 'szl',
            'ta_IN'          => 'ta',
            'te'             => 'te',
            'th'             => 'th',
            'tl'             => 'tl',
            'tr_TR'          => 'tr',
            'tt_RU'          => 'tt',
            'tah'            => 'ty',
            'ug_CN'          => 'ug',
            'uk'             => 'uk',
            'ur'             => 'ur',
            'uz_UZ'          => 'uz',
            'vi'             => 'vi',
            'zh_CN'          => 'zh',
            'zh_TW'          => 'zh',
            'zh_HK'          => 'zh',
            );

            if (isset($select2_available_lang[ $wp_local_lang ]) && file_exists(REA_URL . 'admin/assets/lib/select2/i18n/' . $select2_available_lang[ $wp_local_lang ] . '.js') ) {
                wp_enqueue_script(
                    'rea-select2-lang',
                    REA_URL . 'admin/assets/lib/select2/i18n/' . $select2_available_lang[ $wp_local_lang ] . '.js',
                    array( 'jquery', 'rea-select2' ),
                    REA_VER,
                    true
                );
            }
        }

        wp_register_style('rea-select2-style', REA_URL . 'admin/assets/lib/select2/select2.css', array(), REA_VER);
        wp_enqueue_style('rea-select2-style');

        wp_enqueue_script(
            'rea-admin',
            REA_URL . 'admin/assets/js/admin.js',
            array( 'jquery' ),
            REA_VER,
            true
        );

        $locale_settings = array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('responsive-elementor-addons'),
        );

        wp_localize_script(
            'rea-admin',
            'localize',
            $locale_settings
        );
    }

    public function get_i18n_words()
    {
        $words = [
        'loading' => esc_html__('Loading', 'responsive-elementor-addons'),
        'added' => esc_html__('Added', 'responsive-elementor-addons'),
        ];

        return $words;
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since  1.0.0
     * @access private
     */
    private function define_admin_hooks()
    {
        new REA_Admin_Settings();
    }

    private function load_dependencies()
    {
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        include_once REA_DIR . 'admin/class-rea-admin-settings.php';
        include_once REA_DIR . 'admin/classes/class-rea-attachment.php';
        include_once REA_DIR . 'traits/singleton.php';
        include_once REA_DIR . 'traits/missing-dependency.php';
        include_once REA_DIR . 'helper/helper.php';
    }

    public function widget_scripts()
    {
        wp_enqueue_script('rea-elementor-widgets', REA_ASSETS_URL . 'js/widgets.js', 'jquery', REA_VER, true);
        wp_enqueue_script('wp-mediaelement');
    }

    public function i18n()
    {

        load_plugin_textdomain('responsive-elementor-addons');
    }

    public function init()
    {

        // Check if Elementor installed and activated.
        if (! did_action('elementor/loaded') ) {
            add_action('admin_notices', array( $this, 'admin_notice_missing_main_plugin' ));
            return;
        }

        // Check for required minimum Elementor version.
        if (! version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=') ) {
            add_action('admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ));
            return;
        }

        $this->include_widget_manager();
    }

    /**
     * Admin Notices
     */
    public function admin_notice_missing_main_plugin()
    {

        $file_path         = 'elementor/elementor.php';
        $installed_plugins = get_plugins();

        if (isset($installed_plugins[ $file_path ]) ) {

            if (! current_user_can('activate_plugins') ) {
                return;
            }

            $plugin                   = 'elementor/elementor.php';
            $elementor_activation_url = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1&amp;s', 'activate-plugin_' . $plugin);

            $message = sprintf(
            /* translators: Name of plugin and Elementor */
                esc_html__('"%1$s" requires "%2$s" to be activated.', 'responsive-elementor-addons'),
                '<strong>' . esc_html__('Responsive Elementor Addons', 'responsive-elementor-addons') . '</strong>',
                '<strong>' . esc_html__('Elementor', 'responsive-elementor-addons') . '</strong>'
            );

            $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $elementor_activation_url, __('Activate Elementor Now', 'responsive-elementor-addons')) . '</p>';

            printf('<div class="notice notice-error"><p>%1$s</p></div>', $message);
        } else {
            if (! current_user_can('install_plugins') ) {
                return;
            }

            $elementor_install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=elementor'), 'install-plugin_elementor');
            $message               = sprintf(
            /* translators: Name of plugin and Elementor */
                esc_html__('"%1$s" requires "%2$s" to be installed.', 'responsive-elementor-addons'),
                '<strong>' . esc_html__('Responsive Elementor Addons', 'responsive-elementor-addons') . '</strong>',
                '<strong>' . esc_html__('Elementor', 'responsive-elementor-addons') . '</strong>'
            );

            $message .= '<p>' . sprintf('<a href="%s" class="button-primary">%s</a>', $elementor_install_url, __('Install Elementor Now', 'responsive-elementor-addons')) . '</p>';

            printf('<div class="notice notice-error"><p>%1$s</p></div>', $message);
        }
    }

    /**
     * Admin notice to check for the minimum Elementor version
     */
    public function admin_notice_minimum_elementor_version()
    {

        $message = sprintf(
        /* translators: Name of plugin, Elementor and minimum elementor version */
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'responsive-elementor-addons'),
            '<strong>' . esc_html__('Responsive Elementor Addons', 'responsive-elementor-addons') . '</strong>',
            '<strong>' . esc_html__('Elementor', 'responsive-elementor-addons') . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);

    }

    /**
     * Include widget manager
     */
    public function include_widget_manager()
    {
        // Load the widgets.
        include REA_DIR . 'includes/widgets-manager/class-widgets-manager.php';
    }

    /**
     * Enqueue frontend scripts
     */
    public function enqueue_frontend_scripts()
    {
        $suffix = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min';

        wp_enqueue_script(
            'rea-frontend',
            REA_URL . 'assets/js/frontend' . $suffix . '.js',
            array(
            'elementor-frontend',
            ),
            REA_VER,
            true
        );

        $locale_settings['ajaxurl'] = admin_url('admin-ajax.php');
        $locale_settings['i18n'] = $this->get_i18n_words();

        wp_localize_script(
            'rea-frontend',
            'localize',
            $locale_settings
        );

        Utils::print_js_config(
            'rea-frontend',
            'REAFrontendConfig',
            $locale_settings
        );
    }

    /**
     * Enqueue Styles
     */
    public function enqueue_styles()
    {
        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        // @todo Use rtl to load the file
        $direction_suffix = is_rtl() ? '-rtl' : '';

        $frontend_file_name = 'frontend' . $suffix . '.css';

        $frontend_file_url = REA_ASSETS_URL . 'css/' . $frontend_file_name;

        if (! Icons_Manager::is_migration_allowed() ) {
            wp_enqueue_style('font-awesome');
        } else {
            Icons_Manager::enqueue_shim();
        }

        wp_enqueue_style(
            'rea-frontend',
            $frontend_file_url,
            array(),
            REA_VER
        );

        wp_enqueue_style('wp-mediaelement');
    }

    /**
     * Enqueue admin styles
     */
    public function enqueue_admin_styles()
    {
        wp_register_style(
            'rea-style',
            REA_ASSETS_URL . 'css/admin.css',
            array(),
            REA_VER
        );

        wp_enqueue_style('rea-style');

        wp_register_style(
            'rea-icons',
            REA_URL . 'admin/css/reaicon.css',
            array(),
            REA_VER
        );

        wp_enqueue_style('rea-icons');

        wp_register_script(
            'rea-elementor-control-js',
            REA_ASSETS_URL . 'js/rea-control.js',
            array( 'jquery-elementor-select2' ),
            REA_VER,
            false
        );

        wp_register_script(
            'rea-elementor-visualselect',
            REA_ASSETS_URL . 'js/visual-select.js',
            array( 'jquery' ),
            REA_VER,
            false
        );

    }

    /**
     * Load assets from Library.
     */
    public function load_assets()
    {
        wp_enqueue_script('rea-photoswipe', REA_ASSETS_URL . 'lib/photoswipe/photoswipe.js', array( 'jquery', 'masonry', 'imagesloaded' ), REA_VER, true);
        wp_enqueue_script('rea-fancybox', REA_ASSETS_URL . 'lib/fancybox/jquery_fancybox.js', array( 'jquery' ), REA_VER, true);
        wp_enqueue_script('rea-justified', REA_ASSETS_URL . 'lib/justifiedgallery/justifiedgallery.min.js', array( 'jquery' ), REA_VER, true);
        wp_enqueue_script('rea-element-resize', REA_ASSETS_URL . 'lib/jquery-element-resize/jquery_resize.min.js', array( 'jquery' ), REA_VER, true);
        wp_enqueue_script('rea-isotope', REA_ASSETS_URL . 'lib/isotope/isotope.min.js', array( 'jquery' ), REA_VER, true);
        wp_enqueue_script('rea-photoswipe-ui', REA_ASSETS_URL . 'lib/photoswipe/photoswipe-ui-default.js', array(), REA_VER, true);
        wp_enqueue_script('rea-smartmenus', REA_ASSETS_URL . 'lib/smartmenus/jquery.smartmenus.js', array(), REA_VER, true);
        wp_enqueue_script('rea-scripts', REA_ASSETS_URL . 'js/rea-photoswipe.js', array( 'rea-photoswipe', 'rea-photoswipe-ui' ), REA_VER, true);
        wp_enqueue_script('rea-magnific-popup', REA_ASSETS_URL . 'lib/magnific-popup/jquery.magnific-popup.min.js', array(), REA_VER, true);
        wp_enqueue_script('rea-lottie-lib', REA_ASSETS_URL . 'lib/lottie/lottie.js', array(), REA_VER, true);
        wp_enqueue_script('rea-plyr', REA_ASSETS_URL . 'lib/plyr/plyr.js', array(), REA_VER, true);
        wp_enqueue_script('rea-swiper', REA_ASSETS_URL . 'lib/swiper/swiper.js', array(), REA_VER, true);

        wp_enqueue_script('rea-table-sorter', REA_ASSETS_URL . 'lib/table-sorter/jquery.tablesorter.min.js', array(), REA_VER, true);
        wp_enqueue_script('rea-tilt', REA_ASSETS_URL . 'lib/universal-tilt/universal-tilt.js', array(), REA_VER, true);
        wp_enqueue_script('rea-inview', REA_ASSETS_URL . 'lib/inview/inview.min.js', array(), REA_VER, true);

        // Register and enqueue the font icons in front-end.

        wp_register_style('rea-animate-style', REA_ASSETS_URL . 'lib/animate/animate.min.css', null, REA_VER);
        wp_enqueue_style('rea-animate-style');

        wp_register_style('rea-fancybox-style', REA_ASSETS_URL . 'lib/fancybox/jquery-fancybox.min.css', null, REA_VER);
        wp_enqueue_style('rea-fancybox-style');

        wp_register_style('rea-photoswipe-style', REA_ASSETS_URL . 'lib/photoswipe/photoswipe.css', null, REA_VER);
        wp_enqueue_style('rea-photoswipe-style');

        wp_register_style('rea-magnific-popup-style', REA_ASSETS_URL . 'lib/magnific-popup/magnific-popup.min.css', null, REA_VER);
        wp_enqueue_style('rea-magnific-popup-style');

        wp_register_style('rea-photoswipe-default-skin', REA_ASSETS_URL . 'lib/photoswipe/default-skin.css', null, REA_VER);
        wp_enqueue_style('rea-photoswipe-default-skin');

        wp_register_style('rea-plyr-style', REA_ASSETS_URL . 'lib/plyr/plyr.min.css', null, REA_VER);
        wp_enqueue_style('rea-plyr-style');

        wp_enqueue_script('rea-typed', REA_ASSETS_URL . 'lib/typed/typed.min.js', array(), REA_VER, true);
        wp_enqueue_script('rea-morphext', REA_ASSETS_URL . 'lib/morphext/morphext.min.js', array(), REA_VER, true);

    }

    /**
     * Include Admin css
     *
     * @param string $hook Hook.
     *
     * @return void [description]
     */
    public function responsive_elementor_addons_admin_enqueue_styles( $hook = '' )
    {

        if ('rea_page_responsive_elementor_addons_getting_started' !== $hook ) {
            return;
        }
        // Registering Bootstrap scripts.
        wp_enqueue_script('rea-frontend', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array( 'jquery' ), REA_VER, true);

        // Responsive Ready Sites admin styles.
        wp_register_style('responsive-elementor-addons-admin', REA_URL . 'admin/css/responsive-elementor-addons-admin.css', false, REA_VER);
        wp_enqueue_style('responsive-elementor-addons-admin');
        wp_enqueue_script(
            'responsive-elementor-addons-admin-jsfile',
            REA_URL . 'admin/js/responsive-elementor-addons-admin.js',
            array( 'jquery' ),
            REA_VER,
            true
        );
    }

    /**
     * Register the menu for the plugin.
     *
     * @return void [description]
     */
    public function responsive_elementor_addons_admin_menu()
    {

        // Create Sub Menu with empty parent slug.
        add_submenu_page(
            'rea-settings',
            __('Getting Started', 'responsive-elementor-addons'),
            __('Getting Started', 'responsive-elementor-addons'),
            'manage_options',
            'responsive_elementor_addons_getting_started',
            array( $this, 'responsive_elementor_addons_getting_started' ),
            10
        );

    }

    /**
     * Return widget settings.
     *
     * @param integer $page_id   Page ID.
     * @param string  $widget_id Widget ID.
     *
     * @access public
     */
    public function rea_get_widget_settings( $page_id, $widget_id )
    {
        $document = Plugin::$instance->documents->get($page_id);
        $settings = array();
        if ($document ) {
            $elements    = $document->get_elements_data();
            $widget_data = self::find_element_recursive($elements, $widget_id);

            if (! empty($widget_data) ) {
                $widget = Plugin::instance()->elements_manager->create_element_instance($widget_data);
                if ($widget ) {
                    $settings = $widget->get_settings_for_display();
                }
            }
        }
        return $settings;
    }

    /**
     * Get Widget data.
     *
     * @param array  $elements Element array.
     * @param string $form_id  Element ID.
     *
     * @return bool|array
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

    /**
     * Display Getting Started Page.
     *
     * Output the content for the getting started page.
     *
     * @access public
     */
    public function responsive_elementor_addons_getting_started()
    {

        ?>
        <div class="responsive-elementor-addons-admin-page responsive-elementor-addons-welcome">
        <div class="responsive-elementor-addons-welcome-container">
            <div class="responsive-elementor-addons-welcome-block responsive-elementor-addons-welcome-block-first">
                <div class="responsive-elementor-addons-welcome-logo-container">
                    <div class="responsive-elementor-addons-welcome-logo responsive-elementor-addons-bg-img">
                    </div>
                </div>
                <div class="responsive-elementor-addons-welcome-block-inner">
                    <h3><?php echo esc_html__('Welcome to Responsive Elementor Addons', 'responsive-elementor-addons'); ?></h3>
                    <p class="responsive-elementor-addons-subtitle">
        <?php
         /* translators: %s: search term */
         $name_and_current_version = sprintf(__('Responsive Elementor Addons %s', 'responsive-elementor-addons'), REA_VER);
         echo esc_html($name_and_current_version);
        ?>
                        <a href="https://cyberchimps.com/elementor-widgets-addons/" target="_blank"><?php echo esc_html__('View Demo', 'responsive-elementor-addons'); ?></a>
                    </p>
                    <p class="responsive-elementor-addons-subtitle">
         <?php echo esc_html__('Thank you for choosing Responsive Elementor Addons - The most powerful page builder addons plugin.', 'responsive-elementor-addons'); ?>
                    </p>
                </div>
                <div class="responsive-elementor-addons-welcome-video">
                    <div class="rea-getting-started-video modal rea-modal-fade-slide-in" id="rea-getting-started-video">
                        <div class="modal-dialog rea-gsv-dialog">
                            <div class="modal-content rea-gsv-content">
                                <!-- Modal "Close" button -->
                                <button type="button" class="close rea-gsv-modal-close" data-dismiss="modal">&times;</button>

                                <!-- Modal body -->
                                <div class="modal-body rea-gsv-body" id="rea-gsv-player">
                                    <iframe
                                        id="rea-gsv-yt-player"
                                        class="rea-gsv-video-frame"
                                        src="https://www.youtube.com/embed/CQUg70syNkA?disablekb=0&modestbranding=1&autoplay=0"
                                        allowfullscreen
                                        frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="responsive-elementor-addons-getting-started-link" id="rea-gsv-image-link" data-toggle="modal" data-target="#rea-getting-started-video">
                        <div class="responsive-elementor-addons-welcome-video-image responsive-elementor-addons-bg-img"></div>
                    </a>
                    <div class="responsive-elementor-addons-welcome-block-inner full">
                        <p class="responsive-elementor-addons-subtitle full ">
          <?php echo esc_html__('Build creative, fully customizable and innovative websites in less than a day, using the responsive addons and widgets library for Elementor.', 'responsive-elementor-addons'); ?>
                        </p>
                        <div class="responsive-elementor-addons-button-wrap">
                            <div class="responsive-elementor-addons-welcome-left">
                                <a href="https://cyberchimps.com/elementor-widgets-addons/" target="_blank" class="responsive-elementor-addons-button responsive-elementor-addons-button-large"><?php echo esc_html__('View Demos', 'responsive-elementor-addons'); ?>
                                </a>
                            </div>
                            <div class="responsive-elementor-addons-welcome-right">
                                <a href="https://docs.cyberchimps.com/responsive-elementor-addons/" target="_blank" rel="noopener noreferrer" class="responsive-elementor-addons-button responsive-elementor-addons-button-alt responsive-elementor-addons-button-large">
                                    <?php echo esc_html__('Documentation', 'responsive-elementor-addons'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="responsive-elementor-addons-welcome-block">
                    <div class="responsive-elementor-addons-welcome-block-inner">
                        <h3><?php echo esc_html__('Responsive Features &amp; Addons', 'responsive-elementor-addons'); ?></h3>
                        <p class="responsive-elementor-addons-subtitle features-block"><?php echo esc_html__('Get more customization options and page builder elements to make your website faster than ever.', 'responsive-elementor-addons'); ?></p>
                        <p class="responsive-elementor-addons-subtitle full"><?php echo esc_html__('Design beautiful websites with pre-made templates and sections using widgets like Slider, Testimonial, Audio Player and many more.', 'responsive-elementor-addons'); ?></p>
                    </div>
                    <div class="responsive-elementor-addons-welcome-block-inner responsive-elementor-addons-welcome-features">
         <?php
            $feature_list_array = array(
            array( 'Pricing Table Widget', 'Create dynamic and beautiful pricing tables to showcase your product plans and prices with the Pricing Table widget.', 'rea-pricing-table.png' ),
            array( 'Button', 'Easily add a modern button in your post or page.', 'rea-button.png' ),
            array( 'Video', 'Display your videos effortlessly without making your website slow', 'rea-video.png' ),
            array( 'Icon Box', 'The REA Icon Box is a multi-purpose widget with powerful customizing options', 'rea-icon-box.png' ),
            array( 'Media Carousel', 'Impress your website visitors by adding carousels and sliders', 'rea-media-carousel.png' ),
            );

            foreach ( $feature_list_array as $single_feature ) {

                ?>
                            <div class="responsive-elementor-addons-welcome-feature">
                                <div class="responsive-elementor-addons-welcome-feature-img">
                                    <img src="<?php echo esc_url(REA_URL . 'admin/images/' . $single_feature[2]); ?>">
                                </div>
                                <div class="responsive-elementor-addons-welcome-feature-text">
                                    <h4>
                <?php
                /* translators: %s: search term */
                $title = sprintf(__('%s', 'responsive-elementor-addons'), $single_feature[0]); // phpcs:ignore WordPress.WP.I18n.NoEmptyStrings
                echo esc_html($title);
                ?>
                                    </h4>
                                    <p>
                <?php
                /* translators: %s: search term */
                $short_desc = sprintf(__('%s.', 'responsive-elementor-addons'), $single_feature[1]);
                echo esc_html($short_desc);
                ?>
                                    </p>
                                </div>
                            </div>
            <?php } ?>
                    </div>
                    <div class="responsive-elementor-addons-welcome-block-inner responsive-elementor-addons-welcome-block-footer">
                        <a href="<?php echo esc_url('https://cyberchimps.com/elementor-widgets-addons/'); ?>" target="_blank" class="responsive-elementor-addons-button"><?php echo esc_html__('See All Widgets', 'responsive-elementor-addons'); ?></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="responsive-elementor-addons-quick-links responsive-elementor-addons-quick-links-close">
            <button class="responsive-elementor-addons-quick-links-label">
                <span class="responsive-elementor-addons-bg-img responsive-elementor-addons-quick-links-mascot">
                </span>
                <span class="responsive-elementor-addons-quick-link-title"><?php echo esc_html__('See Quick Links ', 'responsive-elementor-addons'); ?></span>
            </button>
            <div class="responsive-elementor-addons-quick-links-menu">
                <a href="<?php echo esc_url('https://cyberchimps.com/contact/'); ?>" data-index="0" target="_blank" class="responsive-elementor-addons-quick-links-menu-item responsive-elementor-addons-quick-links-item-suggest responsive-elementor-addons-show responsive-elementor-addons-staggered-fade-enter-to">
                    <span class="lightbulb">
                        <img src="<?php echo esc_url(REA_URL . 'admin/images/mascot-1.png'); ?> ">
                    </span>
                    <span class="responsive-elementor-addons-quick-link-title"><?php echo esc_html__('Suggest a Feature', 'responsive-elementor-addons'); ?>
                    </span>
                </a>
                <a href="<?php echo esc_url('https://www.facebook.com/groups/responsive.theme'); ?>" data-index="1" target="_blank" class="responsive-elementor-addons-quick-links-menu-item responsive-elementor-addons-quick-links-item-community responsive-elementor-addons-show">
                    <span class="wpbeginner">
                        <img src="<?php echo esc_url(REA_URL . 'admin/images/mascot-2.png'); ?> ">
                    </span>
                    <span class="responsive-elementor-addons-quick-link-title"><?php echo esc_html__('Join Our Community', 'responsive-elementor-addons'); ?>
                    </span>
                </a>
                <a href="<?php echo esc_url('https://cyberchimps.com/my-account/'); ?>" data-index="2" target="_blank" class="responsive-elementor-addons-quick-links-menu-item responsive-elementor-addons-quick-links-item-support responsive-elementor-addons-show">
                    <span class="life-ring">
                        <img src="<?php echo esc_url(REA_URL . 'admin/images/mascot-3.png'); ?> ">
                    </span>
                    <span class="responsive-elementor-addons-quick-link-title"><?php echo esc_html__('Support &amp; Docs', 'responsive-elementor-addons'); ?>
                    </span>
                </a>
            </div>
        </div>

        <?php
    }

    /**
     * On admin init.
     *
     * Preform actions on WordPress admin initialization.
     *
     * Fired by `admin_init` action.
     *
     * @access public
     */
    public function responsive_elementor_addons_admin_init()
    {

        $this->responsive_elementor_addons_remove_all_admin_notices();
    }

    /**
     * [responsive_elementor_addons_remove_all_admin_notices description]
     */
    private function responsive_elementor_addons_remove_all_admin_notices()
    {
        $responsive_elementor_addons_pages = array(
        'responsive_elementor_addons',
        'responsive_elementor_addons_getting_started',
        );

        if (empty($_GET['page']) || ! in_array($_GET['page'], $responsive_elementor_addons_pages, true) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            return;
        }

        remove_all_actions('admin_notices');
    }

    /**
     * Responsive_elementor_addons_maybe_redirect_to_getting_started description
     *
     * @return [type] [description]
     */
    public function responsive_elementor_addons_maybe_redirect_to_getting_started()
    {
        if (! get_transient('responsive_elementor_addons_activation_redirect') ) {
            return;
        }

        if (wp_doing_ajax() ) {
            return;
        }

        delete_transient('responsive_elementor_addons_activation_redirect');

        if (is_network_admin() || isset($_GET['activate-multi']) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            return;
        }

        wp_safe_redirect(admin_url('admin.php?page=responsive_elementor_addons_getting_started'));

        exit;
    }

}
