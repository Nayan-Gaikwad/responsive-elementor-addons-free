<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @version 1.0.0
 * @package responsive-elementor-addons
 * @author  Cyberchimps.com
 */
class REA_Admin_Settings
{
    /**
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        add_action('admin_menu', array( $this, 'add_rea_admin_menu' ), 9);
        add_action('admin_init', array( $this, 'register_and_build_fields' ));
    }

    /**
     * Adds menus to the admin dashboard.
     *
     * @since 1.0.0
     */
    public function add_rea_admin_menu()
    {
        add_menu_page(__('REA', 'responsive-elementor-addons'), 'REA', 'manage_options', 'rea-settings', array( $this, 'display_rea_admin_dashboard' ), 'dashicons-chart-area', 26);
        add_submenu_page(__('settings', 'responsive-elementor-addons'), 'REA Settings Page Settings', 'Settings', 'manage_options', 'rea-settings', array( $this, 'display_rea_admin_settings' ));
    }

    /**
     * Displays admin dashboard.
     *
     * @since 1.0.0
     */
    public function display_rea_admin_dashboard()
    {
        include_once 'partials/rea-admin-display.php';
    }

    /**
     * Display Rea admin settings.
     *
     * @since 1.0.0
     */
    public function display_rea_admin_settings()
    {
        // set this var to be used in the settings-display view.
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'general'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
        if (isset($_GET['error_message']) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            add_action('admin_notices', array( $this, 'settings_page_settings_messages' ));
            do_action('admin_notices', $_GET['error_message']); // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
        }
        include_once 'partials/rea-admin-settings-display.php';
    }

    /**
     * Display Rea admin settings.
     *
     * @param mixed $error_message Error Message.
     * @since 1.0.0
     */
    public function settings_page_settings_messages( $error_message )
    {
        switch ( $error_message ) {
        case '1':
            $message       = __('There was an error adding this setting. Please try again.', 'responsive-elementor-addons');
            $err_code      = esc_attr('rea_mailchimp_settings_api_key');
            $setting_field = 'rea_mailchimp_settings_api_key';
            break;
        }
        $type = 'error';
        add_settings_error(
            $setting_field,
            $err_code,
            $message,
            $type
        );
    }

    /**
     * Register and build fields for rea menu.
     *
     * @since 1.0.0
     */
    public function register_and_build_fields()
    {
        /**
         * First, we add_settings_section. This is necessary since all future settings must belong to one.
         * Second, add_settings_field
         * Third, register_setting
         */

        // Settings for Google Maps Embed for REA Google Map widget.
        add_settings_section(
            'rea_settings_section_google_map',
            __('REA Google Map settings', 'responsive-elementor-addons'),
            array( $this, 'rea_settings_page_display_google_map_section' ),
            'rea_mailchimp_settings'
        );

        unset($args);
        $args = array(
        'type'     => 'input',
        'subtype'  => 'text',
        'id'       => 'rea_google_map_settings_api_key',
        'name'     => 'rea_google_map_settings_api_key',
        'required' => false,
        );
        add_settings_field(
            'rea_google_map_settings_api_key',
            __('REA Google Map API Key', 'responsive-elementor-addons'),
            array( $this, 'rea_google_map_settings_render' ),
            'rea_mailchimp_settings',
            'rea_settings_section_google_map',
            $args
        );

        unset($args);
        $args = array(
        'type'    => 'select',
        'name'    => 'rea_google_map_settings_localization_language',
        'id'      => 'rea_google_map_settings_localization_language',
        'default' => __('Default', 'responsive-elementor-addons'),
        'options' => $this->get_google_map_supported_languages(),
        );
        add_settings_field(
            'rea_google_map_settings_localization_language',
            __('REA Google Map Localization Language', 'responsive-elementor-addons'),
            array( $this, 'rea_google_map_settings_render' ),
            'rea_mailchimp_settings',
            'rea_settings_section_google_map',
            $args
        );

        register_setting(
            'rea_mailchimp_settings',
            'rea_google_map_settings_api_key'
        );

        register_setting(
            'rea_mailchimp_settings',
            'rea_google_map_settings_localization_language'
        );

    }

    /**
     * Display rea settings page.
     *
     * @since 1.0.0
     */
    public function rea_settings_page_display_general_account()
    {
        echo '<p>These setting apply to REA Mailchimp Styler widget.</p>';
    }

    /**
     * Display google map section.
     *
     * @since 1.0.0
     */
    public function rea_settings_page_display_google_map_section()
    {
        echo '<p>These settings apply to REA Google Map widget.</p>';
    }

    /**
     * Display login register section.
     *
     * @since 1.0.0
     */
    public function rea_settings_page_display_login_register_section()
    {
        echo '<p>These settings apply to REA Login / Register Form widget.</p>';
    }

    /**
     * Google map render settings.
     *
     * @param mixed $args
     * @since 1.0.0
     */
    public function rea_google_map_settings_render( $args )
    {
        if (! get_option($args['name']) ) {
            $value = '';
        } else {
            $value = get_option($args['name']);
        }

        $generate_options = function ( $value, $key, $selected ) {
            echo '<option value="' . esc_attr($key) . '" ' . ( $selected === $key ? 'selected ' : ' ' ) . '>' . $value . '</option>';
        };

        switch ( $args['type'] ) {
        case 'input':
            echo '<input type="' . $args['subtype'] . '" id="' . $args['id'] . '" name="' . $args['name'] . '" ' . ( $args['required'] ? 'required' : '' ) . ' size="40" value="' . $value . '" />';
            break;

        case 'select':
            echo '<select name="' . $args['name'] . '" id="' . $args['id'] . '" class="placeholder placeholder-active" >';
            if (isset($args['default']) ) {
                echo '<option value="" selected>' . $args['default'] . '</option>';
            }
            array_walk($args['options'], $generate_options, $value);
            echo '</select>';
            break;
        }
    }

    /**
     * Google map supported languages.
     *
     * @since 1.0.0
     */
    public function get_google_map_supported_languages()
    {
        $langs = array(
        'ar'    => __('ARABIC', 'responsive-elementor-addons'),
        'eu'    => __('BASQUE', 'responsive-elementor-addons'),
        'bg'    => __('BULGARIAN', 'responsive-elementor-addons'),
        'bn'    => __('BENGALI', 'responsive-elementor-addons'),
        'ca'    => __('CATALAN', 'responsive-elementor-addons'),
        'cs'    => __('CZECH', 'responsive-elementor-addons'),
        'da'    => __('DANISH', 'responsive-elementor-addons'),
        'de'    => __('GERMAN', 'responsive-elementor-addons'),
        'el'    => __('GREEK', 'responsive-elementor-addons'),
        'en'    => __('ENGLISH', 'responsive-elementor-addons'),
        'en-AU' => __('ENGLISH (AUSTRALIAN)', 'responsive-elementor-addons'),
        'en-GB' => __('ENGLISH (GREAT BRITAIN)', 'responsive-elementor-addons'),
        'es'    => __('SPANISH', 'responsive-elementor-addons'),
        'fa'    => __('FARSI', 'responsive-elementor-addons'),
        'fi'    => __('FINNISH', 'responsive-elementor-addons'),
        'fil'   => __('FILIPINO', 'responsive-elementor-addons'),
        'fr'    => __('FRENCH', 'responsive-elementor-addons'),
        'gl'    => __('GALACIAN', 'responsive-elementor-addons'),
        'gu'    => __('GUJARATI', 'responsive-elementor-addons'),
        'hi'    => __('HINDI', 'responsive-elementor-addons'),
        'hr'    => __('CROATIAN', 'responsive-elementor-addons'),
        'hu'    => __('HUNGARIAN', 'responsive-elementor-addons'),
        'id'    => __('INDONESIAN', 'responsive-elementor-addons'),
        'it'    => __('ITALIAN', 'responsive-elementor-addons'),
        'iw'    => __('HEBREW', 'responsive-elementor-addons'),
        'ja'    => __('JAPANESE', 'responsive-elementor-addons'),
        'kn'    => __('KANNADA', 'responsive-elementor-addons'),
        'ko'    => __('KOREAN', 'responsive-elementor-addons'),
        'lt'    => __('LITHUANIAN', 'responsive-elementor-addons'),
        'lv'    => __('LATVIAN', 'responsive-elementor-addons'),
        'ml'    => __('MALAYALAM', 'responsive-elementor-addons'),
        'mr'    => __('MARATHI', 'responsive-elementor-addons'),
        'nl'    => __('DUTCH', 'responsive-elementor-addons'),
        'no'    => __('NORWEGIAN', 'responsive-elementor-addons'),
        'pl'    => __('POLISH', 'responsive-elementor-addons'),
        'pt'    => __('PORTUGUESE', 'responsive-elementor-addons'),
        'pt-BR' => __('PORTUGUESE (BRAZIL)', 'responsive-elementor-addons'),
        'pt-PR' => __('PORTUGUESE (PORTUGAL)', 'responsive-elementor-addons'),
        'ro'    => __('ROMANIAN', 'responsive-elementor-addons'),
        'ru'    => __('RUSSIAN', 'responsive-elementor-addons'),
        'sk'    => __('SLOVAK', 'responsive-elementor-addons'),
        'sl'    => __('SLOVENIAN', 'responsive-elementor-addons'),
        'sr'    => __('SERBIAN', 'responsive-elementor-addons'),
        'sv'    => __('SWEDISH', 'responsive-elementor-addons'),
        'tl'    => __('TAGALOG', 'responsive-elementor-addons'),
        'ta'    => __('TAMIL', 'responsive-elementor-addons'),
        'te'    => __('TELUGU', 'responsive-elementor-addons'),
        'th'    => __('THAI', 'responsive-elementor-addons'),
        'tr'    => __('TURKISH', 'responsive-elementor-addons'),
        'uk'    => __('UKRANIAN', 'responsive-elementor-addons'),
        'vi'    => __('VIETNAMESE', 'responsive-elementor-addons'),
        'zh-CN' => __('CHINESE (SIMPLIFIED)', 'responsive-elementor-addons'),
        'zh-TW' => __('CHINESE (TRADITIONAL)', 'responsive-elementor-addons'),
        );

        return $langs;
    }
}
