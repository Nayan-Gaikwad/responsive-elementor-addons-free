(function($, window, document, undefined){

    $(window).on('elementor/frontend/init', function (){

        if ( elementorFrontend.isEditMode() ) {
            elementorFrontend.hooks.addAction( 'frontend/element_ready/rea_audio.default', function( $scope ){ window.wp.mediaelement.initialize() } );
        }
    });

    $( window ).on( 'elementor:init', function() {

        var ReaControlBaseDataView = elementor.modules.controls.BaseData;

        /**
         *  REA Visual Select Controller
         */
        var ReaControlVisualSelectItemView = ReaControlBaseDataView.extend( {
            onReady: function() {
                this.ui.select.reaVisualSelect();
            },
            onBeforeDestroy: function() {
                this.ui.select.reaVisualSelect( 'destroy' );
            }
        } );
        elementor.addControlView( 'rea-visual-select', ReaControlVisualSelectItemView );

        /**
         *  REA Media Select Controller
         */
        var ReaMediaSelectControl = ReaControlBaseDataView.extend({
            ui: function() {
                var ui = ReaControlBaseDataView.prototype.ui.apply( this, arguments );

                ui.controlMedia = '.rea-elementor-control-media';
                ui.mediaImage = '.rea-elementor-control-media-attachment';
                ui.frameOpeners = '.rea-elementor-control-media-upload-button, .rea-elementor-control-media-attachment';
                ui.deleteButton = '.rea-elementor-control-media-delete';

                return ui;
            },

            events: function() {
                return _.extend( ReaControlBaseDataView.prototype.events.apply( this, arguments ), {
                    'click @ui.frameOpeners': 'openFrame',
                    'click @ui.deleteButton': 'deleteImage'
                } );
            },

            applySavedValue: function() {
                var control = this.getControlValue();

                this.ui.mediaImage.css( 'background-image', control.img ? 'url(' + control.img + ')' : '' );

                this.ui.controlMedia.toggleClass( 'elementor-media-empty', ! control.img );
            },

            openFrame: function() {
                if ( ! this.frame ) {
                    this.initFrame();
                }

                this.frame.open();
            },

            deleteImage: function() {
                this.setValue( {
                    url: '',
                    img: '',
                    id : ''
                } );

                this.applySavedValue();
            },

            /**
             * Create a media modal select frame, and store it so the instance can be reused when needed.
             */
            initFrame: function() {
                this.frame = wp.media( {
                    button: {
                        text: elementor.translate( 'insert_media' )
                    },
                    states: [
                        new wp.media.controller.Library( {
                            title: elementor.translate( 'insert_media' ),
                            library: wp.media.query( { type: this.ui.controlMedia.data('media-type') } ),
                            multiple: false,
                            date: false
                        } )
                    ]
                } );

                // When a file is selected, run a callback.
                this.frame.on( 'insert select', this.select.bind( this ) );
            },

            /**
             * Callback handler for when an attachment is selected in the media modal.
             * Gets the selected image information, and sets it within the control.
             */
            select: function() {
                this.trigger( 'before:select' );

                // Get the attachment from the modal frame.
                var attachment = this.frame.state().get( 'selection' ).first().toJSON();

                if ( attachment.url ) {
                    this.setValue( {
                        url: attachment.url,
                        img: attachment.image.src,
                        id : attachment.id
                    } );

                    this.applySavedValue();
                }

                this.trigger( 'after:select' );
            },

            onBeforeDestroy: function() {
                this.$el.remove();
            }
        });

        elementor.addControlView('rea-media', ReaMediaSelectControl);
    });

})(jQuery, window, document);