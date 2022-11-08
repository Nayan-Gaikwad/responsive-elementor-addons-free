<?php
namespace Responsive_Elementor_Addons\WidgetsManager\Widgets\Skins;

if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}

class REA_Skin_Full_Content extends REA_Skin_Classic
{
    use REA_Skin_Content_Base;

    public function get_id()
    {
        return 'rea_full_content';
    }
}
