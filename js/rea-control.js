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
/******/ 	return __webpack_require__(__webpack_require__.s = 121);
/******/ })
/************************************************************************/
/******/ ({

/***/ 121:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


(function ($, window, document, undefined) {
  $(window).on('elementor/frontend/init', function () {
    if (elementorFrontend.isEditMode()) {
      elementorFrontend.hooks.addAction('frontend/element_ready/rea_audio.default', function ($scope) {
        window.wp.mediaelement.initialize();
      });
    }
  });
  $(window).on('elementor:init', function () {
    var ReaControlBaseDataView = elementor.modules.controls.BaseData;
    /**
     *  REA Visual Select Controller
     */

    var ReaControlVisualSelectItemView = ReaControlBaseDataView.extend({
      onReady: function onReady() {
        this.ui.select.reaVisualSelect();
      },
      onBeforeDestroy: function onBeforeDestroy() {
        this.ui.select.reaVisualSelect('destroy');
      }
    });
    elementor.addControlView('rea-visual-select', ReaControlVisualSelectItemView);
    /**
     *  REA Media Select Controller
     */

    var ReaMediaSelectControl = ReaControlBaseDataView.extend({
      ui: function ui() {
        var ui = ReaControlBaseDataView.prototype.ui.apply(this, arguments);
        ui.controlMedia = '.rea-elementor-control-media';
        ui.mediaImage = '.rea-elementor-control-media-attachment';
        ui.frameOpeners = '.rea-elementor-control-media-upload-button, .rea-elementor-control-media-attachment';
        ui.deleteButton = '.rea-elementor-control-media-delete';
        return ui;
      },
      events: function events() {
        return _.extend(ReaControlBaseDataView.prototype.events.apply(this, arguments), {
          'click @ui.frameOpeners': 'openFrame',
          'click @ui.deleteButton': 'deleteImage'
        });
      },
      applySavedValue: function applySavedValue() {
        var control = this.getControlValue();
        this.ui.mediaImage.css('background-image', control.img ? 'url(' + control.img + ')' : '');
        this.ui.controlMedia.toggleClass('elementor-media-empty', !control.img);
      },
      openFrame: function openFrame() {
        if (!this.frame) {
          this.initFrame();
        }

        this.frame.open();
      },
      deleteImage: function deleteImage() {
        this.setValue({
          url: '',
          img: '',
          id: ''
        });
        this.applySavedValue();
      },

      /**
       * Create a media modal select frame, and store it so the instance can be reused when needed.
       */
      initFrame: function initFrame() {
        this.frame = wp.media({
          button: {
            text: elementor.translate('insert_media')
          },
          states: [new wp.media.controller.Library({
            title: elementor.translate('insert_media'),
            library: wp.media.query({
              type: this.ui.controlMedia.data('media-type')
            }),
            multiple: false,
            date: false
          })]
        }); // When a file is selected, run a callback.

        this.frame.on('insert select', this.select.bind(this));
      },

      /**
       * Callback handler for when an attachment is selected in the media modal.
       * Gets the selected image information, and sets it within the control.
       */
      select: function select() {
        this.trigger('before:select'); // Get the attachment from the modal frame.

        var attachment = this.frame.state().get('selection').first().toJSON();

        if (attachment.url) {
          this.setValue({
            url: attachment.url,
            img: attachment.image.src,
            id: attachment.id
          });
          this.applySavedValue();
        }

        this.trigger('after:select');
      },
      onBeforeDestroy: function onBeforeDestroy() {
        this.$el.remove();
      }
    });
    elementor.addControlView('rea-media', ReaMediaSelectControl);
  });
})(jQuery, window, document);

/***/ })

/******/ });
//# sourceMappingURL=rea-control.js.map