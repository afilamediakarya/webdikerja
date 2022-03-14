/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/metronic/js/pages/custom/profile/profile.js":
/*!***************************************************************!*\
  !*** ./resources/metronic/js/pages/custom/profile/profile.js ***!
  \***************************************************************/
/***/ (() => {

eval(" // Class definition\n\nvar KTProfile = function () {\n  // Elements\n  var avatar;\n  var offcanvas; // Private functions\n\n  var _initAside = function _initAside() {\n    // Mobile offcanvas for mobile mode\n    offcanvas = new KTOffcanvas('kt_profile_aside', {\n      overlay: true,\n      baseClass: 'offcanvas-mobile',\n      //closeBy: 'kt_user_profile_aside_close',\n      toggleBy: 'kt_subheader_mobile_toggle'\n    });\n  };\n\n  var _initForm = function _initForm() {\n    avatar = new KTImageInput('kt_profile_avatar');\n  };\n\n  return {\n    // public functions\n    init: function init() {\n      _initAside();\n\n      _initForm();\n    }\n  };\n}();\n\njQuery(document).ready(function () {\n  KTProfile.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvY3VzdG9tL3Byb2ZpbGUvcHJvZmlsZS5qcy5qcyIsIm1hcHBpbmdzIjoiQ0FFQTs7QUFDQSxJQUFJQSxTQUFTLEdBQUcsWUFBWTtBQUMzQjtBQUNBLE1BQUlDLE1BQUo7QUFDQSxNQUFJQyxTQUFKLENBSDJCLENBSzNCOztBQUNBLE1BQUlDLFVBQVUsR0FBRyxTQUFiQSxVQUFhLEdBQVk7QUFDNUI7QUFDQUQsSUFBQUEsU0FBUyxHQUFHLElBQUlFLFdBQUosQ0FBZ0Isa0JBQWhCLEVBQW9DO0FBQ3RDQyxNQUFBQSxPQUFPLEVBQUUsSUFENkI7QUFFdENDLE1BQUFBLFNBQVMsRUFBRSxrQkFGMkI7QUFHdEM7QUFDQUMsTUFBQUEsUUFBUSxFQUFFO0FBSjRCLEtBQXBDLENBQVo7QUFNQSxHQVJEOztBQVVBLE1BQUlDLFNBQVMsR0FBRyxTQUFaQSxTQUFZLEdBQVc7QUFDMUJQLElBQUFBLE1BQU0sR0FBRyxJQUFJUSxZQUFKLENBQWlCLG1CQUFqQixDQUFUO0FBQ0EsR0FGRDs7QUFJQSxTQUFPO0FBQ047QUFDQUMsSUFBQUEsSUFBSSxFQUFFLGdCQUFXO0FBQ2hCUCxNQUFBQSxVQUFVOztBQUNWSyxNQUFBQSxTQUFTO0FBQ1Q7QUFMSyxHQUFQO0FBT0EsQ0EzQmUsRUFBaEI7O0FBNkJBRyxNQUFNLENBQUNDLFFBQUQsQ0FBTixDQUFpQkMsS0FBakIsQ0FBdUIsWUFBVztBQUNqQ2IsRUFBQUEsU0FBUyxDQUFDVSxJQUFWO0FBQ0EsQ0FGRCIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9tZXRyb25pYy9qcy9wYWdlcy9jdXN0b20vcHJvZmlsZS9wcm9maWxlLmpzPzVjNWEiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XHJcblxyXG4vLyBDbGFzcyBkZWZpbml0aW9uXHJcbnZhciBLVFByb2ZpbGUgPSBmdW5jdGlvbiAoKSB7XHJcblx0Ly8gRWxlbWVudHNcclxuXHR2YXIgYXZhdGFyO1xyXG5cdHZhciBvZmZjYW52YXM7XHJcblxyXG5cdC8vIFByaXZhdGUgZnVuY3Rpb25zXHJcblx0dmFyIF9pbml0QXNpZGUgPSBmdW5jdGlvbiAoKSB7XHJcblx0XHQvLyBNb2JpbGUgb2ZmY2FudmFzIGZvciBtb2JpbGUgbW9kZVxyXG5cdFx0b2ZmY2FudmFzID0gbmV3IEtUT2ZmY2FudmFzKCdrdF9wcm9maWxlX2FzaWRlJywge1xyXG4gICAgICAgICAgICBvdmVybGF5OiB0cnVlLFxyXG4gICAgICAgICAgICBiYXNlQ2xhc3M6ICdvZmZjYW52YXMtbW9iaWxlJyxcclxuICAgICAgICAgICAgLy9jbG9zZUJ5OiAna3RfdXNlcl9wcm9maWxlX2FzaWRlX2Nsb3NlJyxcclxuICAgICAgICAgICAgdG9nZ2xlQnk6ICdrdF9zdWJoZWFkZXJfbW9iaWxlX3RvZ2dsZSdcclxuICAgICAgICB9KTtcclxuXHR9XHJcblxyXG5cdHZhciBfaW5pdEZvcm0gPSBmdW5jdGlvbigpIHtcclxuXHRcdGF2YXRhciA9IG5ldyBLVEltYWdlSW5wdXQoJ2t0X3Byb2ZpbGVfYXZhdGFyJyk7XHJcblx0fVxyXG5cclxuXHRyZXR1cm4ge1xyXG5cdFx0Ly8gcHVibGljIGZ1bmN0aW9uc1xyXG5cdFx0aW5pdDogZnVuY3Rpb24oKSB7XHJcblx0XHRcdF9pbml0QXNpZGUoKTtcclxuXHRcdFx0X2luaXRGb3JtKCk7XHJcblx0XHR9XHJcblx0fTtcclxufSgpO1xyXG5cclxualF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcclxuXHRLVFByb2ZpbGUuaW5pdCgpO1xyXG59KTtcclxuIl0sIm5hbWVzIjpbIktUUHJvZmlsZSIsImF2YXRhciIsIm9mZmNhbnZhcyIsIl9pbml0QXNpZGUiLCJLVE9mZmNhbnZhcyIsIm92ZXJsYXkiLCJiYXNlQ2xhc3MiLCJ0b2dnbGVCeSIsIl9pbml0Rm9ybSIsIktUSW1hZ2VJbnB1dCIsImluaXQiLCJqUXVlcnkiLCJkb2N1bWVudCIsInJlYWR5Il0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/metronic/js/pages/custom/profile/profile.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/metronic/js/pages/custom/profile/profile.js"]();
/******/ 	
/******/ })()
;