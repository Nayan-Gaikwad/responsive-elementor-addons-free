/* ================== js/src/module.carousel-lightbox.js =================== */


(function($, window, document, undefined) {
    "use strict";

    /* ------------------------------------------------------------------------------ */
    // insert photoswipe markup to the page

    if (!window.photoswipe_l10n) {
        window.photoswipe_l10n = {};
    }

    var $pswp = $(
        '<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">' +
        '<div class="pswp__bg"></div>' +
        '<div class="pswp__scroll-wrap">' +
        '<div class="pswp__container">' +
        '<div class="pswp__item"></div>' +
        '<div class="pswp__item"></div>' +
        '<div class="pswp__item"></div>' +
        "</div>" +
        '<div class="pswp__ui pswp__ui--hidden">' +
        '<div class="pswp__top-bar">' +
        '<div class="pswp__counter"></div>' +
        '<button class="pswp__button pswp__button--close" title="' +
        (photoswipe_l10n.close || "Close (Esc)") +
        '"></button>' +
        '<button class="pswp__button pswp__button--share" title="' +
        (photoswipe_l10n.share || "Share") +
        '"></button>' +
        '<button class="pswp__button pswp__button--fs" title="' +
        (photoswipe_l10n.fullscreen || "Toggle fullscreen") +
        '"></button>' +
        '<button class="pswp__button pswp__button--zoom" title="' +
        (photoswipe_l10n.zoom || "Zoom in/out") +
        '"></button>' +
        '<div class="pswp__preloader">' +
        '<div class="pswp__preloader__icn">' +
        '<div class="pswp__preloader__cut">' +
        '<div class="pswp__preloader__donut"></div>' +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>" +
        '<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">' +
        '<div class="pswp__share-tooltip"></div> ' +
        "</div>" +
        '<button class="pswp__button pswp__button--arrow--left" title="' +
        (photoswipe_l10n.previous || "Previous (arrow left)") +
        '">' +
        "</button>" +
        '<button class="pswp__button pswp__button--arrow--right" title="' +
        (photoswipe_l10n.next || "Next (arrow right)") +
        '">' +
        "</button>" +
        '<div class="pswp__caption">' +
        '<div class="pswp__caption__center"></div>' +
        "</div>" +
        "</div>" +
        "</div>" +
        "</div>"
    ).appendTo("body");

    /* ------------------------------------------------------------------------------ */

    var defaults = {
            target: "a",
            ui: PhotoSwipeUI_Default,
            titleMap: false,
            thumbnailMap: false,
            autoplay: 0,
            showHideOpacity: true,
            getThumbBoundsFn: false
        },
        _uid = 1;

    function JQPhotoSwipe(element, options) {
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this.slides = [];
        this.UID = _uid++;
        this.element = element;
        this.$element = $(element);
        this.init();
    }

    $.extend(JQPhotoSwipe.prototype, {
        init: function() {
            this.$element
                .find(this.settings.target)
                .each(this._registerSlide.bind(this));

            // Parse URL and open gallery if it contains #&pid=3&gid=1
            var hashData = this._photoswipeParseHash();
            if (hashData.pid && hashData.gid) {
                // disable animation
                var animDuration = this.settings.showAnimationDuration;
                this.settings.showAnimationDuration = 0;

                this._openPhotoSwipe(hashData.pid, true);

                this.settings.showAnimationDuration = animDuration;
            }
        },

        getSlides: function() {
            return this.slides;
        },

        _registerSlide: function(index, item) {
            var $item = $(item),
                slide = {
                    src: $item.is("a")
                        ? $item.attr("href")
                        : $item.data("original-src") || $item.attr("src"),
                    w: $item.data("original-width"),
                    h: $item.data("original-height"),
                    item: item
                };

            if ($item.data("type") == "video" && $item.is("a")) {
                slide = {
                    html: this._getVideoHtml($item.attr("href"))
                };
            }

            // title
            if (this.settings.titleMap) {
                slide.title = this.settings.titleMap($item, index, this);
            } else {
                slide.title =
                    $item.data("caption") ||
                    $item.attr("title") ||
                    $item.attr("alt");
            }

            // thumbnail
            if (this.settings.thumbnailMap) {
                var thumb = this.settings.thumbnailMap($item, index, this);
                slide.el = thumb.element;
                slide.msrc = thumb.src;
            } else if ($item.is("img")) {
                slide.el = item;
                slide.msrc = $item.attr("src");
            } else {
                var img = $item.find("img");
                if (img.length) {
                    slide.el = img[0];
                    slide.msrc = img.attr("src");
                }
            }

            $item.data("index", index);
            $item.on("click.photoswipe", this._onItemClick.bind(this));
            this.slides.push(slide);
        },

        // get clean html video data
        _getVideoHtml: function(url) {
            var videoEmbedLink = url;

            if (url.match(/(youtube.com)/)) {
                var split_c = "v=";
                var split_n = 1;
            }

            if (url.match(/(youtu.be)/) || url.match(/(vimeo.com\/)+[0-9]/)) {
                var split_c = "/";
                var split_n = 3;
            }

            if (url.match(/(vimeo.com\/)+[a-zA-Z]/)) {
                var split_c = "/";
                var split_n = 5;
            }

            var getYouTubeVideoID = url.split(split_c)[split_n];

            var cleanVideoID = getYouTubeVideoID.replace(/(&)+(.*)/, "");

            if (url.match(/(youtu.be)/) || url.match(/(youtube.com)/)) {
                videoEmbedLink =
                    "//www.youtube.com/embed/" +
                    cleanVideoID +
                    "?autoplay=" +
                    this.settings.autoplay +
                    "";
            }
            if (
                url.match(/(vimeo.com\/)+[0-9]/) ||
                url.match(/(vimeo.com\/)+[a-zA-Z]/)
            ) {
                videoEmbedLink =
                    "//player.vimeo.com/video/" +
                    cleanVideoID +
                    "?autoplay=" +
                    this.settings.autoplay +
                    "";
            }

            return (
                '<div class="video-wrapper"><iframe class="pswp__video" src="' +
                videoEmbedLink +
                '" width="960" height="640" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>'
            );
        },

        _onItemClick: function(e) {
            e.preventDefault();
            this._openPhotoSwipe($(e.currentTarget).data("index"));
        },

        _thumbnailBounds: function(index) {
            var thumbnail = this.slides[index].el,
                pageYScroll =
                    window.pageYOffset || document.documentElement.scrollTop;

            if (thumbnail) {
                var rect = thumbnail.getBoundingClientRect();
                return {
                    x: rect.left,
                    y: rect.top + pageYScroll,
                    w: rect.width
                };
            } else {
                return null;
            }
        },

        // parse picture index and gallery index from URL (#&pid=1&gid=2)
        _photoswipeParseHash: function() {
            var hash = window.location.hash.substring(1),
                params = {};

            if (hash.length < 5) {
                return params;
            }

            var vars = hash.split("&");
            for (var i = 0; i < vars.length; i++) {
                if (!vars[i]) {
                    continue;
                }
                var pair = vars[i].split("=");
                if (pair.length < 2) {
                    continue;
                }
                params[pair[0]] = pair[1];
            }

            if (params.gid) {
                params.gid = parseInt(params.gid, 10);
            }

            return params;
        },

        _openPhotoSwipe: function(index, fromURL) {
            var gallery,
                options = this.settings;

            $.extend(options, {
                galleryUID: this.UID,
                getThumbBoundsFn: this._thumbnailBounds.bind(this)
            });

            // PhotoSwipe opened from URL
            if (fromURL) {
                // in URL indexes start from 1
                options.index = parseInt(index, 10) - 1;
            } else {
                options.index = parseInt(index, 10);
            }

            // exit if index not found
            if (isNaN(options.index)) {
                return;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe(
                $pswp[0],
                options.ui,
                this.slides,
                options
            );
            gallery.init();
            this._photoswipeListen(gallery);
        },

        _photoswipeListen: function(gallery) {
            gallery.listen("beforeChange", function() {
                var $allItems = $(this.container).find(".pswp__video");
                // Remove active class from all items
                $allItems.removeClass("active");
                // Add active class too current open item
                $(this.currItem.container)
                    .find(".pswp__video")
                    .addClass("active");
                // Check all items
                $allItems.each(function() {
                    if (!$(this).hasClass("active")) {
                        $(this).attr("src", $(this).attr("src"));
                    }
                });
            });
            gallery.listen("close", function() {
                $(this.currItem.container)
                    .find(".pswp__video")
                    .each(function() {
                        $(this).attr("src", "about:blank");
                    });
            });
        }
    });

    // $.fn.photoSwipe = function ( options ) {
    //     return this.each(function() {
    //         if ( !$.data( this, 'averta_photoswipe' ) ) {
    //             $.data( this, 'averta_photoswipe', new JQPhotoSwipe( this, options ) );
    //         }
    //     });
    // };

    $.fn.photoSwipe = function(options) {
        var args = arguments,
            plugin = "averta_photoswipe";

        if (options === undefined || typeof options === "object") {
            return this.each(function() {
                if (!$.data(this, plugin)) {
                    $.data(this, plugin, new JQPhotoSwipe(this, options));
                }
            });
        } else if (
            typeof options === "string" &&
            options[0] !== "_" &&
            options !== "init"
        ) {
            var returns;

            this.each(function() {
                var instance = $.data(this, plugin);

                if (
                    instance instanceof JQPhotoSwipe &&
                    typeof instance[options] === "function"
                ) {
                    returns = instance[options].apply(
                        instance,
                        Array.prototype.slice.call(args, 1)
                    );
                }

                // Allow instances to be destroyed via the 'destroy' method
                if (options === "destroy") {
                    $.data(this, plugin, null);
                }
            });

            return returns !== undefined ? returns : this;
        }
    };
})(jQuery, window, document);

/**
 * Init Carousel and Lightbox
 *
 */
(function($, window, document, undefined){
    "use strict";

    $.fn.REAinCarouselInit = function( $scope ){
        $scope = $scope || $(this);

        $scope.find('.rea-lightbox-video').photoSwipe({
                target: '.rea-open-video',
                bgOpacity: 0.97,
                shareEl: true
            }
        );
    };

})(jQuery, window, document);

/**
 * Initialize All Modules
 */
;(function($, window, document, undefined){

    /**
     * Initializes general modules
     */
    window.REAinInitElements = function( $scope ){
        $scope = $scope || $(document);

        // Init Carousel and Lightbox
        $.fn.REAinCarouselInit( $scope );

    }

    /**
     * Initializes all Photoswipe modules
     */
    window.REAInitAllModules = function( $scope ){
        $scope = $scope || $(document);

        REAinInitElements( $scope );
    }

    // Init general modules
    REAinInitElements();

})(jQuery, window, document);

/**
 * Initialize Modules on Vidual Editors
 */
;(function($, window, document, undefined){

    var $vcWindow, $__window = $(window);

    // Add js callback for customizer partials trigger
    if( typeof wp !== 'undefined' && typeof wp.customize !== 'undefined' ) {
        if( typeof wp.customize.selectiveRefresh !== 'undefined' ){
            wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function() {
                // Init photoswipe modules
                REAInitAllModules( $('body') );
            });
        }
    }

    // Init Visual Composer
    $__window.on('vc_reload', function(){
        // Main selector
        $vcWindow = $('#vc_inline-frame', window.parent.document).contents().find('.vc_element');

        // Init photoswipe modules
        REAInitAllModules( $vcWindow );

        $__window.trigger('resize');
    });

})(jQuery, window, document);
