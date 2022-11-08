<?php
/**
 * REA Skin Card.
 *
 * @since   1.0.0
 * @package Responsive_Elementor_Addons
 */

namespace Responsive_Elementor_Addons\WidgetsManager\Widgets\Skins;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes;

if (! defined('ABSPATH') ) {
    exit; // Exit if accessed directly.
}
/**
 * REA Skin Card Extending REA Skin Base.
 *
 * An abstract class to register new skins for Elementor widgets. Skins allows
 * you to add new templates, set custom controls and more.
 *
 * @since 1.0.0
 */
class REA_Skin_Cards extends REA_Skin_Base
{

    /**
     * Get ID.
     *
     * Retrieve ID.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Card ID.
     */
    public function get_id()
    {
        return 'rea_cards';
    }

    /**
     * Register skin controls actions.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls_actions()
    {
        parent::_register_controls_actions();

        add_action('elementor/element/rea-posts/rea_cards_section_design_image/before_section_end', array( $this, 'register_additional_design_image_controls' ));
    }

    /**
     * Retrieve the title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Card title.
     */
    public function getTitle()
    {
        return __('Cards', 'responsive-elementor-addons');
    }

    /**
     * Retrieve the title.
     *
     * @param  int   $id   ID.
     * @param  array $args Arguments.
     * @since  1.0.0
     * @access public
     */
    public function start_controls_tab( $id, $args )
    {
        $args['condition']['_skin'] = $this->get_id();
        $this->parent->start_controls_tab($this->get_control_id($id), $args);
    }

    /**
     * End Controls tab
     *
     * @since  1.0.0
     * @access public
     */
    public function end_controls_tab()
    {
        $this->parent->end_controls_tab();
    }

    /**
     * Retrieve the title.
     *
     * @param  int $id ID.
     * @since  1.0.0
     * @access public
     */
    public function start_controls_tabs( $id )
    {
        $args['condition']['_skin'] = $this->get_id();
        $this->parent->start_controls_tabs($this->get_control_id($id));
    }

    /**
     * End Controls tab
     *
     * @since  1.0.0
     * @access public
     */
    public function end_controls_tabs()
    {
        $this->parent->end_controls_tabs();
    }

    /**
     * Register skin card controls.
     *
     * @param  Widget_Base $widget Widget.
     * @since  1.0.0
     * @access public
     */
    public function registerControls( Widget_Base $widget )
    {
        $this->parent = $widget;

        $this->register_columns_controls();
        $this->register_post_count_control();
        $this->register_thumbnail_controls();
        $this->register_title_controls();
        $this->register_excerpt_controls();
        $this->register_meta_data_controls();
        $this->register_read_more_controls();
        $this->register_link_controls();
        $this->register_badge_controls();
        $this->register_avatar_controls();
        $this->register_data_position_controls();
    }

    /**
     * Register skin card desgin controls.
     *
     * @since  1.0.0
     * @access public
     */
    public function register_design_controls()
    {
        $this->register_design_layout_controls();
        $this->register_design_card_controls();
        $this->register_design_image_controls();
        $this->register_design_content_controls();
    }

    /**
     * Register skin controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_design_content_controls()
    {
        parent::register_design_content_controls();

        $this->remove_control('meta_spacing');

        $this->update_control(
            'read_more_spacing',
            array(
            'selectors' => array(
            '{{WRAPPER}} .elementor-post__read-more' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ),
            ),
            array(
            'recursive' => true,
            )
        );
    }

    /**
     * Register skin desgin card controls.
     *
     * @since  1.0.0
     * @access public
     */
    public function register_design_card_controls()
    {
        $this->start_controls_section(
            'section_design_card',
            array(
            'label' => __('Card', 'responsive-elementor-addons'),
            'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'card_bg_color',
            array(
            'label'     => __('Background Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .elementor-post__card' => 'background-color: {{VALUE}}',
            ),
            )
        );

        $this->add_control(
            'card_border_color',
            array(
            'label'     => __('Border Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .elementor-post__card' => 'border-color: {{VALUE}}',
            ),
            )
        );

        $this->add_control(
            'card_border_width',
            array(
            'label'      => __('Border Width', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
            'px' => array(
            'min' => 0,
            'max' => 15,
                    ),
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .elementor-post__card' => 'border-width: {{SIZE}}{{UNIT}}',
            ),
            )
        );

        $this->add_control(
            'card_border_radius',
            array(
            'label'      => __('Border Radius', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => array( 'px', '%' ),
            'range'      => array(
            'px' => array(
            'min' => 0,
            'max' => 200,
                    ),
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .elementor-post__card' => 'border-radius: {{SIZE}}{{UNIT}}',
            ),
            )
        );

        $this->add_control(
            'card_padding',
            array(
            'label'      => __('Horizontal Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
            'px' => array(
            'min' => 0,
            'max' => 50,
                    ),
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .elementor-post__text'   => 'padding: 0 {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-post__meta-data' => 'padding: 10px {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-post__avatar' => 'padding-right: {{SIZE}}{{UNIT}}; padding-left: {{SIZE}}{{UNIT}}',
            ),
            )
        );

        $this->add_control(
            'card_vertical_padding',
            array(
            'label'      => __('Vertical Padding', 'responsive-elementor-addons'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => array( 'px' ),
            'range'      => array(
            'px' => array(
            'min' => 0,
            'max' => 50,
                    ),
            ),
            'selectors'  => array(
                    '{{WRAPPER}} .elementor-post__card' => 'padding-top: {{SIZE}}{{UNIT}}; padding-bottom: {{SIZE}}{{UNIT}}',
            ),
            )
        );

        $this->add_control(
            'box_shadow_box_shadow_type', // The name of this control is like that, for future extensibility to group_control box shadow.
            array(
            'label'        => __('Box Shadow', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'elementor-card-shadow-',
            'default'      => 'yes',
            )
        );

        $this->add_control(
            'hover_effect',
            array(
            'label'        => __('Hover Effect', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SELECT,
            'label_block'  => false,
            'options'      => array(
            'none'     => __('None', 'responsive-elementor-addons'),
            'gradient' => __('Gradient', 'responsive-elementor-addons'),
            ),
            'default'      => 'gradient',
            'separator'    => 'before',
            'prefix_class' => 'elementor-posts__hover-',
            )
        );

        $this->add_control(
            'meta_border_color',
            array(
            'label'     => __('Meta Border Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'separator' => 'before',
            'selectors' => array(
            '{{WRAPPER}} .elementor-post__card .elementor-post__meta-data' => 'border-top-color: {{VALUE}}',
            ),
            'condition' => array(
                    $this->get_control_id('meta_data!') => array(),
            ),
            )
        );

        $this->end_controls_section();
    }

    /**
     * Register badge controls.
     *
     * @since  1.0.0
     * @access public
     */
    public function register_badge_controls()
    {
        $this->add_control(
            'show_badge',
            array(
            'label'     => __('Badge', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SWITCHER,
            'label_on'  => __('Show', 'responsive-elementor-addons'),
            'label_off' => __('Hide', 'responsive-elementor-addons'),
            'default'   => 'yes',
            'separator' => 'before',
            )
        );

        $this->add_control(
            'badge_taxonomy',
            array(
            'label'       => __('Badge Taxonomy', 'responsive-elementor-addons'),
            'type'        => Controls_Manager::SELECT2,
            'label_block' => true,
            'default'     => 'category',
            'options'     => $this->get_taxonomies(),
            'condition'   => array(
            $this->get_control_id('show_badge') => 'yes',
            ),
            )
        );
    }

    /**
     * Retrive Taxonomies.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function get_taxonomies()
    {
        $taxonomies = get_taxonomies(array( 'show_in_nav_menus' => true ), 'objects');

        $options = array( '' => '' );

        foreach ( $taxonomies as $taxonomy ) {
            $options[ $taxonomy->name ] = $taxonomy->label;
        }

        return $options;
    }

    /**
     * Register avatar controls.
     *
     * @since  1.0.0
     * @access public
     */
    public function register_avatar_controls()
    {
        $this->add_control(
            'show_avatar',
            array(
            'label'        => __('Avatar', 'responsive-elementor-addons'),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __('Show', 'responsive-elementor-addons'),
            'label_off'    => __('Hide', 'responsive-elementor-addons'),
            'return_value' => 'show-avatar',
            'default'      => 'show-avatar',
            'separator'    => 'before',
            'prefix_class' => 'elementor-posts--',
            'render_type'  => 'template',
            'condition'    => array(
            $this->get_control_id('thumbnail!') => 'none',
            ),
            )
        );
    }

    /**
     * Register meta data controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_meta_data_controls()
    {
        parent::register_meta_data_controls();
        $this->update_control(
            'meta_separator',
            array(
            'default' => '•',
            )
        );
    }

    /**
     * Register thumbnail controls.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_thumbnail_controls()
    {
        parent::register_thumbnail_controls();
        $this->remove_responsive_control('image_width');
        $this->update_control(
            'thumbnail',
            array(
            'label'       => __('Show Image', 'responsive-elementor-addons'),
            'options'     => array(
            'top'  => __('Yes', 'responsive-elementor-addons'),
            'none' => __('No', 'responsive-elementor-addons'),
            ),
            'render_type' => 'template',
            )
        );
    }

    /**
     * Register additional desgin image controls.
     *
     * @since  1.0.0
     * @access public
     */
    public function register_additional_design_image_controls()
    {
        $this->update_control(
            'image_spacing',
            array(
            'selectors' => array(
            '{{WRAPPER}} .elementor-post__text' => 'margin-top: {{SIZE}}{{UNIT}}',
            ),
            'condition' => array(
                    $this->get_control_id('thumbnail!') => 'none',
            ),
            )
        );

        $this->remove_control('img_border_radius');

        $this->add_control(
            'heading_badge_style',
            array(
            'label'     => __('Badge', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            $this->get_control_id('show_badge') => 'yes',
            ),
            )
        );

        $this->add_control(
            'badge_position',
            array(
            'label'     => 'Badge Position',
            'type'      => Controls_Manager::CHOOSE,
            'options'   => array(
            'left'  => array(
            'title' => __('Left', 'responsive-elementor-addons'),
            'icon'  => 'eicon-h-align-left',
                    ),
                    'right' => array(
                        'title' => __('Right', 'responsive-elementor-addons'),
                        'icon'  => 'eicon-h-align-right',
                    ),
            ),
            'default'   => 'right',
            'selectors' => array(
                    '{{WRAPPER}} .elementor-post__badge' => '{{VALUE}}: 0',
            ),
            'condition' => array(
                    $this->get_control_id('show_badge') => 'yes',
            ),
            )
        );

        $this->add_control(
            'badge_bg_color',
            array(
            'label'     => __('Background Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .elementor-post__card .elementor-post__badge' => 'background-color: {{VALUE}};',
            ),
            'scheme'    => array(
                    'type'  => Schemes\Color::get_type(),
                    'value' => Schemes\Color::COLOR_4,
            ),
            'condition' => array(
                    $this->get_control_id('show_badge') => 'yes',
            ),
            )
        );

        $this->add_control(
            'badge_color',
            array(
            'label'     => __('Text Color', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => array(
            '{{WRAPPER}} .elementor-post__card .elementor-post__badge' => 'color: {{VALUE}};',
            ),
            'condition' => array(
                    $this->get_control_id('show_badge') => 'yes',
            ),
            )
        );

        $this->add_control(
            'badge_radius',
            array(
            'label'     => __('Border Radius', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            'px' => array(
            'max' => 50,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-post__card .elementor-post__badge' => 'border-radius: {{SIZE}}{{UNIT}};',
            ),
            'condition' => array(
                    $this->get_control_id('show_badge') => 'yes',
            ),
            )
        );

        $this->add_control(
            'badge_size',
            array(
            'label'     => __('Size', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            'px' => array(
            'min' => 5,
            'max' => 50,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-post__card .elementor-post__badge' => 'font-size: {{SIZE}}{{UNIT}}',
            ),
            'condition' => array(
                    $this->get_control_id('show_badge') => 'yes',
            ),
            )
        );

        $this->add_control(
            'badge_margin',
            array(
            'label'     => __('Margin', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            'px' => array(
            'max' => 50,
                    ),
            ),
            'default'   => array(
                    'size' => 20,
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-post__card .elementor-post__badge' => 'margin: {{SIZE}}{{UNIT}}',
            ),
            'condition' => array(
                    $this->get_control_id('show_badge') => 'yes',
            ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
            'name'      => 'badge_typography',
            'scheme'    => Schemes\Typography::TYPOGRAPHY_4,
            'selector'  => '{{WRAPPER}} .elementor-post__card .elementor-post__badge',
            'exclude'   => array( 'font_size', 'line-height' ),
            'condition' => array(
            $this->get_control_id('show_badge') => 'yes',
            ),
            )
        );

        $this->add_control(
            'heading_avatar_style',
            array(
            'label'     => __('Avatar', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array(
            $this->get_control_id('thumbnail!')  => 'none',
            $this->get_control_id('show_avatar') => 'show-avatar',
            ),
            )
        );

        $this->add_control(
            'avatar_size',
            array(
            'label'     => __('Size', 'responsive-elementor-addons'),
            'type'      => Controls_Manager::SLIDER,
            'range'     => array(
            'px' => array(
            'min' => 20,
            'max' => 90,
                    ),
            ),
            'selectors' => array(
                    '{{WRAPPER}} .elementor-post__avatar' => 'top: calc(-{{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .elementor-post__avatar img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .responsive-post__thumbnail__link' => 'margin-bottom: calc({{SIZE}}{{UNIT}} / 2)',
            ),
            'condition' => array(
                    $this->get_control_id('show_avatar') => 'show-avatar',
            ),
            )
        );
    }

    /**
     * Render Post Header.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_post_header()
    {
        ?>
        <article <?php post_class(array( 'elementor-post elementor-grid-item' )); ?>>
        <div class="elementor-post__card">
        <?php
    }

    /**
     * Render Post Footer.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_post_footer()
    {
        ?>
        </div>
        </article>
        <?php
    }

    /**
     * Render Avatar.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_avatar()
    {
        ?>
        <div class="elementor-post__avatar">
        <?php echo get_avatar(get_the_author_meta('ID'), 128, '', get_the_author_meta('display_name')); ?>
        </div>
        <?php
    }

    /**
     * Render Badge.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_badge()
    {
        $taxonomy = $this->get_instance_value('badge_taxonomy');
        if (empty($taxonomy) ) {
            return;
        }

        $terms = get_the_terms(get_the_ID(), $taxonomy);
        if (empty($terms[0]) ) {
            return;
        }
        ?>
        <div class="elementor-post__badge"><?php echo wp_kses_post($terms[0]->name); ?></div>
        <?php
    }

    /**
     * Render Thumbnail.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_thumbnail()
    {
        if ('none' === $this->get_instance_value('thumbnail') ) {
            return;
        }

        $settings                 = $this->parent->get_settings();
        $setting_key              = $this->get_control_id('thumbnail_size');
        $settings[ $setting_key ] = array(
        'id' => get_post_thumbnail_id(),
        );
        $thumbnail_html           = Group_Control_Image_Size::get_attachment_image_html($settings, $setting_key);

        if (empty($thumbnail_html) ) {
            return;
        }

        $optional_attributes_html = $this->get_optional_link_attributes_html();

        ?>
        <a class="responsive-post__thumbnail__link" href="<?php echo wp_kses_post(get_permalink()); ?>" <?php echo wp_kses_post($optional_attributes_html); ?>>
            <div class="elementor-post__thumbnail"><?php echo wp_kses_post($thumbnail_html); ?></div>
        </a>
        <?php
        if ($this->get_instance_value('show_badge') ) {
            $this->render_badge();
        }

        if ($this->get_instance_value('show_avatar') ) {
            $this->render_avatar();
        }
    }

    /**
     * Render Post.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render_post()
    {
        $content_positions_key = array(
        empty($this->get_instance_value('title_position')) ? 0 : $this->get_instance_value('title_position'),
        empty($this->get_instance_value('excerpt_position')) ? 0 : $this->get_instance_value('excerpt_position'),
        empty($this->get_instance_value('read_more_position')) ? 0 : $this->get_instance_value('read_more_position'),
        );

        $content_positions_value = array(
        'render_title',
        'render_excerpt',
        'render_read_more',
        );

        $positions = array_combine($content_positions_key, $content_positions_value);
        ksort($positions);

        $this->render_post_header();
        $this->render_thumbnail();
        $this->render_text_header();

        foreach ( $positions as $key => $value ) {
            if (0 !== $key ) {
                $this->$value();
            }
        }

        $this->render_text_footer();
        $this->render_meta_data();
        $this->render_post_footer();
    }

}
