<?php
/**
 * Fired during plugin activation
 *
 * @link  https://www.cyberchimps.com
 * @since 1.0.0
 *
 * @package    Responsive_Elementor_Addons
 * @subpackage Responsive_Elementor_Addons/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Responsive_Elementor_Addons
 * @subpackage Responsive_Elementor_Addons/includes
 * @author     CyberChimps <support@cyberchimps.com>
 */
class Responsive_Elementor_Addons_Activator
{

    /**
     * Short Description.
     *
     * Long Description.
     *
     * @since 1.0.0
     */
    public static function activate()
    {
        set_transient('responsive_elementor_addons_activation_redirect', true, MINUTE_IN_SECONDS);

        flush_rewrite_rules();
    }
}
