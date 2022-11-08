<?php
/**
 * REA Ajax select2 control.
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Controls;

use Elementor\Base_Data_Control;

if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}

/**
 * REA Ajax select2 control.
 *
 * A base control for creating dynamic/ajax select control. Displays options based on the
 * user input in the select input box.
 *
 * @since 1.0.0
 */
class REA_Control_Ajax_Select2 extends Base_Data_Control
{

    /**
     * Retrive Type
     *
     * @return string
     */
    public function get_type()
    {
        return 'rea-ajax-select2';
    }

    /**
     * Enqueue ajax scripts and styles.
     *
     * @return void
     */
    public function enqueue()
    {

        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

        wp_register_script(
            'rea-ajax-select2',
            REA_ASSETS_URL . 'js/rea-ajax-select2' . $suffix . '.js',
            array( 'jquery-elementor-select2' ),
            REA_VER,
            false
        );

        wp_localize_script(
            'rea-ajax-select2',
            'rea_ajax_select2_localize',
            array(
            'ajaxurl'       => esc_url(admin_url('admin-ajax.php')),
            'search_text'   => esc_html__('Search', 'responsive-elementor-addons'),
            'remove'        => __('Remove', 'responsive-elementor-addons'),
            'thumbnail'     => __('Image', 'responsive-elementor-addons'),
            'name'          => __('Title', 'responsive-elementor-addons'),
            'price'         => __('Price', 'responsive-elementor-addons'),
            'quantity'      => __('Quantity', 'responsive-elementor-addons'),
            'subtotal'      => __('Subtotal', 'responsive-elementor-addons'),
            'user_status'   => __('User Status', 'responsive-elementor-addons'),
            'post_type'     => __('Post Type', 'responsive-elementor-addons'),
            'browser'       => __('Browser', 'responsive-elementor-addons'),
            'date_time'     => __('Date & Time', 'responsive-elementor-addons'),
            'dynamic_field' => __('Dynamic Field', 'responsive-elementor-addons'),
            )
        );

        wp_enqueue_script('rea-ajax-select2');
    }

    /**
     * Get default settings.
     *
     * @return array
     */
    protected function get_default_settings()
    {
        return array(
        'multiple'    => false,
        'source_name' => 'post_type',
        'source_type' => 'post',
        );
    }

    /**
     * Render ajax control output in the editor.
     *
     * @return void
     */
    public function content_template()
    {
        $control_uid = $this->get_control_uid();
        ?>
        <# var controlUID = '<?php echo esc_html($control_uid); ?>'; #>
        <# var currentID = elementor.panel.currentView.currentPageView.model.attributes.settings.attributes[data.name]; #>
        <div class="elementor-control-field">
            <# if ( data.label ) { #>
            <label for="<?php echo esc_attr($control_uid); ?>" class="elementor-control-title">{{{data.label }}}</label>
            <# } #>
            <div class="elementor-control-input-wrapper elementor-control-unit-5">
                <# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
                <select id="<?php echo esc_attr($control_uid); ?>" {{ multiple }} class="rea-ajax-select2" data-setting="{{ data.name }}"></select>
            </div>
        </div>
        <#
        ( function( $ ) {
            $( document.body ).trigger( 'rea_ajax_select2_init',{currentID:data.controlValue,data:data,controlUID:controlUID,multiple:data.multiple} );
        }( jQuery ) );
        #>
        <?php
    }
}
