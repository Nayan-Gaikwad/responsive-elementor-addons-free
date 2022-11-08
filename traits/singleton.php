<?php
namespace Responsive_Elementor_Addons\Traits;

/**
 * Trait for making singleton instance
 */
trait Singleton
{
    public static $instance = null;

    public static function instance()
    {
        if (is_null(self::$instance) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
