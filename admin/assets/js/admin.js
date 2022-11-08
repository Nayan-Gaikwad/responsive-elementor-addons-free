/**
 *  Admin js file for all the js needed for the admin part of REA
 */

(function ($) {
    "use strict";

    $('#rea_mailchimp_api_key_button').on('click',function (event) {
        event.preventDefault();

        var _this = $(this);
        var apiKey = $('#rea_mailchimp_settings_api_key').val();
        var action = $('#rea_mailchimp_api_key_button').data('action');
        var nonce = $('#rea_mailchimp_api_key_button').data('nonce');


        jQuery.post(ajaxurl, {
            action: action,
            api_key: apiKey,
            _nonce: nonce
        }).done(function (data) {
            if (data.success) {
                $('#rea_mailchimp_api_key_button').removeClass('error');
                $('#rea_mailchimp_api_key_button').addClass('success');
            } else {
                $('#rea_mailchimp_api_key_button').removeClass('success');
                $('#rea_mailchimp_api_key_button').addClass('error');
            }
        }).fail(function () {
            console.log($('#rea_mailchimp_settings_api_key').val());
        });

    })
})(jQuery);