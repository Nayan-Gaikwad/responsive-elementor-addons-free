( function( $, elementor ) {

    'use strict';

    var ReaSticky = {
        init: function() {
            elementor.hooks.addAction( 'frontend/element_ready/column', ReaSticky.elementorColumn );

            elementorFrontend.hooks.addAction( 'frontend/element_ready/section', ReaSticky.setStickySection );

            $( ReaSticky.stickySection );
        },

        getStickySectionsDesktop: [],
        getStickySectionsTablet:  [],
        getStickySectionsMobile:  [],

        setStickySection: function( $scope ) {
            var setStickySection = {

                target: $scope,

                isEditMode: Boolean( elementorFrontend.isEditMode() ),

                init: function() {

                    if (  'yes' === this.getSectionSetting( 'rea_sticky_section_sticky' ) ) {

                        if ( this.isEditMode ) {
                            $(this.target[0]).addClass('rea-sticky-section-sticky--stuck')
                        }
                        var availableDevices = this.getSectionSetting( 'rea_sticky_section_sticky_visibility' ) || [];

                        if ( ! availableDevices[0] ) {
                            return;
                        }

                        if ( -1 !== availableDevices.indexOf( 'desktop' ) ) {
                            ReaSticky.getStickySectionsDesktop.push( $scope );
                        }

                        if ( -1 !== availableDevices.indexOf( 'tablet' ) ) {
                            ReaSticky.getStickySectionsTablet.push( $scope );
                        }

                        if ( -1 !== availableDevices.indexOf( 'mobile' ) ) {
                            ReaSticky.getStickySectionsMobile.push( $scope );
                        }
                    }
                    else
                    {
                        if ( this.isEditMode ) {
                            $(this.target[0]).removeClass('rea-sticky-section-sticky--stuck')
                        }
                    }

                },

                getSectionSetting: function( setting ){
                    var settings = {},
                        editMode = Boolean( elementorFrontend.isEditMode() );

                    if ( editMode ) {

                        if ( ! elementorFrontend.config.hasOwnProperty( 'elements' ) ) {
                            return;
                        }

                        if ( ! elementorFrontend.config.elements.hasOwnProperty( 'data' ) ) {
                            return;
                        }

                        var modelCID = this.target.data( 'model-cid' ),
                            editorSectionData = elementorFrontend.config.elements.data[ modelCID ];

                        if ( ! editorSectionData ) {
                            return;
                        }

                        if ( ! editorSectionData.hasOwnProperty( 'attributes' ) ) {
                            return;
                        }

                        settings = editorSectionData.attributes || {};
                    } else {
                        settings = this.target.data( 'settings' ) || {};
                    }

                    if ( ! settings[ setting ] ) {
                        return;
                    }

                    return settings[ setting ];
                }
            };

            setStickySection.init();
        },

        stickySection: function() {
            var stickySection = {

                isEditMode: Boolean( elementorFrontend.isEditMode() ),

                correctionSelector: $( '#wpadminbar' ),

                initDesktop: false,
                initTablet:  false,
                initMobile:  false,

                init: function() {

                    this.run();
                    $( window ).on( 'resize.ReaStickySectionSticky orientationchange.ReaStickySectionSticky', this.run.bind( this ) );
                },

                getOffset: function(){
                    var offset = 0;

                    if ( this.correctionSelector[0] && 'fixed' === this.correctionSelector.css( 'position' ) ) {
                        offset = this.correctionSelector.outerHeight( true );
                    }

                    return offset;
                },

                run: function() {
                    var currentDeviceMode = elementorFrontend.getCurrentDeviceMode(),
                        transitionIn  = 'rea-sticky-transition-in',
                        transitionOut = 'rea-sticky-transition-out',
                        options = {
                            stickyClass: 'rea-sticky-section-sticky--stuck',
                            topSpacing: this.getOffset()
                        };

                    function initSticky ( section, options ) {
                        section.jetStickySection( options )
                            .on( 'jetStickySection:stick', function( event ) {
                                $( event.target ).addClass( transitionIn );
                                setTimeout( function() {
                                    $( event.target ).removeClass( transitionIn );
                                }, 3000 );
                            } )
                            .on( 'jetStickySection:unstick', function( event ) {
                                $( event.target ).addClass( transitionOut );
                                setTimeout( function() {
                                    $( event.target ).removeClass( transitionOut );
                                }, 3000 );
                            } );
                        section.trigger( 'jetStickySection:activated' );
                    }

                    if ( 'desktop' === currentDeviceMode && ! this.initDesktop ) {
                        if ( this.initTablet ) {
                            ReaSticky.getStickySectionsTablet.forEach( function( section, i ) {
                                section.trigger( 'jetStickySection:detach' );
                            });

                            this.initTablet = false;
                        }

                        if ( this.initMobile ) {
                            ReaSticky.getStickySectionsMobile.forEach( function( section, i ) {
                                section.trigger( 'jetStickySection:detach' );
                            });

                            this.initMobile = false;
                        }

                        if ( ReaSticky.getStickySectionsDesktop[0] ) {
                            ReaSticky.getStickySectionsDesktop.forEach( function( section, i ) {

                                if ( ReaSticky.getStickySectionsDesktop[i+1] ) {
                                    options.stopper = ReaSticky.getStickySectionsDesktop[i+1];
                                } else {
                                    options.stopper = '';
                                }

                                initSticky( section, options );
                            });

                            this.initDesktop = true;
                        }
                    }

                    if ( 'tablet' === currentDeviceMode && ! this.initTablet ) {
                        if ( this.initDesktop ) {
                            ReaSticky.getStickySectionsDesktop.forEach( function( section, i ) {
                                section.trigger( 'jetStickySection:detach' );
                            });

                            this.initDesktop = false;
                        }

                        if ( this.initMobile ) {
                            ReaSticky.getStickySectionsMobile.forEach( function( section, i ) {
                                section.trigger( 'jetStickySection:detach' );
                            });

                            this.initMobile = false;
                        }

                        if ( ReaSticky.getStickySectionsTablet[0] ) {
                            ReaSticky.getStickySectionsTablet.forEach( function( section, i ) {
                                if ( ReaSticky.getStickySectionsTablet[i+1] ) {
                                    options.stopper = ReaSticky.getStickySectionsTablet[i+1];
                                } else {
                                    options.stopper = '';
                                }

                                initSticky( section, options );
                            });

                            this.initTablet = true;
                        }
                    }

                    if ( 'mobile' === currentDeviceMode && ! this.initMobile ) {
                        if ( this.initDesktop ) {
                            ReaSticky.getStickySectionsDesktop.forEach( function( section, i ) {
                                section.trigger( 'jetStickySection:detach' );
                            });

                            this.initDesktop = false;
                        }

                        if ( this.initTablet ) {
                            ReaSticky.getStickySectionsTablet.forEach( function( section, i ) {
                                section.trigger( 'jetStickySection:detach' );
                            });

                            this.initTablet = false;
                        }

                        if ( ReaSticky.getStickySectionsMobile[0] ) {
                            ReaSticky.getStickySectionsMobile.forEach( function( section, i ) {

                                if ( ReaSticky.getStickySectionsMobile[i+1] ) {
                                    options.stopper = ReaSticky.getStickySectionsMobile[i+1];
                                } else {
                                    options.stopper = '';
                                }

                                initSticky( section, options );
                            });

                            this.initMobile = true;
                        }
                    }
                }
            };

            stickySection.init();
        }
    }

    $( window ).on( 'elementor/frontend/init',ReaSticky.init);

}( jQuery, window.elementorFrontend ) );