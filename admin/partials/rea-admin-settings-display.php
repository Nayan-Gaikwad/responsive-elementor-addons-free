<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  https://cyberchimps.com/
 * @since 1.0.0
 *
 * @package responsive-elementor-addons
 */

?>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="rea-wrap">
    <div id="icon-themes" class="icon32"></div>
    <h2>REA Settings Page Settings</h2>
    <!--NEED THE settings_errors below so that the errors/success messages are shown after submission - wasn't working once we started using add_menu_page and stopped using add_options_page so needed this-->
    <?php settings_errors(); ?>
    <form method="POST" action="options.php">
        <?php
        settings_fields('rea_mailchimp_settings');
        do_settings_sections('rea_mailchimp_settings');
        ?>
        <?php submit_button(); ?>
    </form>
</div>
