<?php
/**
 * Fired during plugin deactivation
 *
 * @link  https://www.cyberchimps.com
 * @since 1.0.0
 *
 * @package    Responsive_Elementor_Addons
 * @subpackage Responsive_Elementor_Addons/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Responsive_Elementor_Addons
 * @subpackage Responsive_Elementor_Addons/includes
 * @author     CyberChimps <support@cyberchimps.com>
 */
class Responsive_Elementor_Addons_Deactivator
{

    /**
     * Short Description.
     *
     * Long Description.
     *
     * @since 1.0.0
     */
    public static function deactivate()
    {
        flush_rewrite_rules();
    }

}
