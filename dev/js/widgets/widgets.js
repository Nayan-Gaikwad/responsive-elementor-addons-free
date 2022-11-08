(function($, window, document, undefined) {

    $(window).on('elementor/frontend/init', function () {

        if (elementorFrontend.isEditMode()) {
            elementorFrontend.hooks.addAction('frontend/element_ready/rea_audio.default', function ($scope) {
                window.wp.mediaelement.initialize()
            });
        }
    });
})(jQuery, window, document);