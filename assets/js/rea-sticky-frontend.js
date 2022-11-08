/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 84);
/******/ })
/************************************************************************/
/******/ ({

/***/ 84:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function ($, elementor) {
  'use strict';

  var ReaSticky = {
    init: function init() {
      elementor.hooks.addAction('frontend/element_ready/column', ReaSticky.elementorColumn);
      elementorFrontend.hooks.addAction('frontend/element_ready/section', ReaSticky.setStickySection);
      $(ReaSticky.stickySection);
    },
    getStickySectionsDesktop: [],
    getStickySectionsTablet: [],
    getStickySectionsMobile: [],
    setStickySection: function setStickySection($scope) {
      var setStickySection = {
        target: $scope,
        isEditMode: Boolean(elementorFrontend.isEditMode()),
        init: function init() {
          if ('yes' === this.getSectionSetting('rea_sticky_section_sticky')) {
            if (this.isEditMode) {
              $(this.target[0]).addClass('rea-sticky-section-sticky--stuck');
            }

            var availableDevices = this.getSectionSetting('rea_sticky_section_sticky_visibility') || [];

            if (!availableDevices[0]) {
              return;
            }

            if (-1 !== availableDevices.indexOf('desktop')) {
              ReaSticky.getStickySectionsDesktop.push($scope);
            }

            if (-1 !== availableDevices.indexOf('tablet')) {
              ReaSticky.getStickySectionsTablet.push($scope);
            }

            if (-1 !== availableDevices.indexOf('mobile')) {
              ReaSticky.getStickySectionsMobile.push($scope);
            }
          } else {
            if (this.isEditMode) {
              $(this.target[0]).removeClass('rea-sticky-section-sticky--stuck');
            }
          }
        },
        getSectionSetting: function getSectionSetting(setting) {
          var settings = {},
              editMode = Boolean(elementorFrontend.isEditMode());

          if (editMode) {
            if (!elementorFrontend.config.hasOwnProperty('elements')) {
              return;
            }

            if (!elementorFrontend.config.elements.hasOwnProperty('data')) {
              return;
            }

            var modelCID = this.target.data('model-cid'),
                editorSectionData = elementorFrontend.config.elements.data[modelCID];

            if (!editorSectionData) {
              return;
            }

            if (!editorSectionData.hasOwnProperty('attributes')) {
              return;
            }

            settings = editorSectionData.attributes || {};
          } else {
            settings = this.target.data('settings') || {};
          }

          if (!settings[setting]) {
            return;
          }

          return settings[setting];
        }
      };
      setStickySection.init();
    },
    stickySection: function stickySection() {
      var stickySection = {
        isEditMode: Boolean(elementorFrontend.isEditMode()),
        correctionSelector: $('#wpadminbar'),
        initDesktop: false,
        initTablet: false,
        initMobile: false,
        init: function init() {
          this.run();
          $(window).on('resize.ReaStickySectionSticky orientationchange.ReaStickySectionSticky', this.run.bind(this));
        },
        getOffset: function getOffset() {
          var offset = 0;

          if (this.correctionSelector[0] && 'fixed' === this.correctionSelector.css('position')) {
            offset = this.correctionSelector.outerHeight(true);
          }

          return offset;
        },
        run: function run() {
          var currentDeviceMode = elementorFrontend.getCurrentDeviceMode(),
              transitionIn = 'rea-sticky-transition-in',
              transitionOut = 'rea-sticky-transition-out',
              options = {
            stickyClass: 'rea-sticky-section-sticky--stuck',
            topSpacing: this.getOffset()
          };

          function initSticky(section, options) {
            section.jetStickySection(options).on('jetStickySection:stick', function (event) {
              $(event.target).addClass(transitionIn);
              setTimeout(function () {
                $(event.target).removeClass(transitionIn);
              }, 3000);
            }).on('jetStickySection:unstick', function (event) {
              $(event.target).addClass(transitionOut);
              setTimeout(function () {
                $(event.target).removeClass(transitionOut);
              }, 3000);
            });
            section.trigger('jetStickySection:activated');
          }

          if ('desktop' === currentDeviceMode && !this.initDesktop) {
            if (this.initTablet) {
              ReaSticky.getStickySectionsTablet.forEach(function (section, i) {
                section.trigger('jetStickySection:detach');
              });
              this.initTablet = false;
            }

            if (this.initMobile) {
              ReaSticky.getStickySectionsMobile.forEach(function (section, i) {
                section.trigger('jetStickySection:detach');
              });
              this.initMobile = false;
            }

            if (ReaSticky.getStickySectionsDesktop[0]) {
              ReaSticky.getStickySectionsDesktop.forEach(function (section, i) {
                if (ReaSticky.getStickySectionsDesktop[i + 1]) {
                  options.stopper = ReaSticky.getStickySectionsDesktop[i + 1];
                } else {
                  options.stopper = '';
                }

                initSticky(section, options);
              });
              this.initDesktop = true;
            }
          }

          if ('tablet' === currentDeviceMode && !this.initTablet) {
            if (this.initDesktop) {
              ReaSticky.getStickySectionsDesktop.forEach(function (section, i) {
                section.trigger('jetStickySection:detach');
              });
              this.initDesktop = false;
            }

            if (this.initMobile) {
              ReaSticky.getStickySectionsMobile.forEach(function (section, i) {
                section.trigger('jetStickySection:detach');
              });
              this.initMobile = false;
            }

            if (ReaSticky.getStickySectionsTablet[0]) {
              ReaSticky.getStickySectionsTablet.forEach(function (section, i) {
                if (ReaSticky.getStickySectionsTablet[i + 1]) {
                  options.stopper = ReaSticky.getStickySectionsTablet[i + 1];
                } else {
                  options.stopper = '';
                }

                initSticky(section, options);
              });
              this.initTablet = true;
            }
          }

          if ('mobile' === currentDeviceMode && !this.initMobile) {
            if (this.initDesktop) {
              ReaSticky.getStickySectionsDesktop.forEach(function (section, i) {
                section.trigger('jetStickySection:detach');
              });
              this.initDesktop = false;
            }

            if (this.initTablet) {
              ReaSticky.getStickySectionsTablet.forEach(function (section, i) {
                section.trigger('jetStickySection:detach');
              });
              this.initTablet = false;
            }

            if (ReaSticky.getStickySectionsMobile[0]) {
              ReaSticky.getStickySectionsMobile.forEach(function (section, i) {
                if (ReaSticky.getStickySectionsMobile[i + 1]) {
                  options.stopper = ReaSticky.getStickySectionsMobile[i + 1];
                } else {
                  options.stopper = '';
                }

                initSticky(section, options);
              });
              this.initMobile = true;
            }
          }
        }
      };
      stickySection.init();
    }
  };
  $(window).on('elementor/frontend/init', ReaSticky.init);
})(jQuery, window.elementorFrontend);

/***/ })

/******/ });
//# sourceMappingURL=rea-sticky-frontend.js.map