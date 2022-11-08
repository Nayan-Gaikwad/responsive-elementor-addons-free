<?php
/**
 * Add Attachment Data Extra fields
 *
 * @package responsive-elementor-addons
 */

if (! class_exists('REA_Attachment') ) {
    /**
     * Class REA_Attachment.
     */
    class REA_Attachment
    {

        /**
         * Constructor function that initializes required actions and hooks
         *
         * @since 1.0
         */
        public function __construct()
        {
            add_filter('attachment_fields_to_edit', array( $this, 'rea_custom_field_attachment_link' ), 11, 2);
            add_filter('attachment_fields_to_save', array( $this, 'rea_custom_field_attachment_link_save' ), 11, 2);
        }

        /**
         * Add Custom Link field to media uploader and categories for the Image Gallery Widget
         *
         * @param  array  $form_fields fields to include in attachment form.
         * @param  object $post        attachment record in database.
         * @return array $form_fields modified form fields
         */
        public function rea_custom_field_attachment_link( $form_fields, $post )
        {

            $form_fields['rea-custom-link'] = array(
            'label' => sprintf(__('REA - Custom Link', 'responsive-elementor-addons')),
            'input' => 'text',
            'value' => get_post_meta($post->ID, 'rea-custom-link', true),
            );

            $form_fields['rea-categories'] = array(
            'label' => sprintf(__('REA - Categories (Ex: Cat1, Cat2)', 'responsive-elementor-addons')),
            'input' => 'text',
            'value' => get_post_meta($post->ID, 'rea-categories', true),
            );

            return $form_fields;
        }


        /**
         * Save values of Custom Link field in media uploader for the Image Gallery Widget
         *
         * @param  array $post       the post data for database.
         * @param  array $attachment attachment fields from $_POST form.
         * @return array $post modified post data.
         */
        public function rea_custom_field_attachment_link_save( $post, $attachment )
        {

            if (isset($attachment['rea-custom-link']) ) {
                update_post_meta($post['ID'], 'rea-custom-link', $attachment['rea-custom-link']);
            }

            if (isset($attachment['rea-categories']) ) {
                update_post_meta($post['ID'], 'rea-categories', $attachment['rea-categories']);
            }

            return $post;
        }
    }

    new REA_Attachment();
}
