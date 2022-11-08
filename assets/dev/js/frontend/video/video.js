(function($) {
    "use strict";

    $(document).ready((function() {
        if ($(".rea-video-popup").length > 0 )
        {
            $(".rea-video-popup").magnificPopup({
                type: "iframe",
                mainClass: "mfp-fade",
                removalDelay: 160,
                preloader: !0,
                fixedContentPos: !1});
        }
    }))

})(jQuery);