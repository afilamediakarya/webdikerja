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

eval(" // Class definition\n\nvar KTProfile = function () {\n  // Elements\n  var avatar;\n  var offcanvas; // Private functions\n\n  var _initAside = function _initAside() {\n    // Mobile offcanvas for mobile mode\n    offcanvas = new KTOffcanvas('kt_profile_aside', {\n      overlay: true,\n      baseClass: 'offcanvas-mobile',\n      //closeBy: 'kt_user_profile_aside_close',\n      toggleBy: 'kt_subheader_mobile_toggle'\n    });\n  };\n\n  var _initForm = function _initForm() {\n    avatar = new KTImageInput('kt_profile_avatar');\n  };\n\n  return {\n    // public functions\n    init: function init() {\n      _initAside();\n\n      _initForm();\n    }\n  };\n}();\n\njQuery(document).ready(function () {\n  KTProfile.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvY3VzdG9tL3Byb2ZpbGUvcHJvZmlsZS5qcy5qcyIsIm1hcHBpbmdzIjoiQ0FFQTs7QUFDQSxJQUFJQSxTQUFTLEdBQUcsWUFBWTtBQUMzQjtBQUNBLE1BQUlDLE1BQUo7QUFDQSxNQUFJQyxTQUFKLENBSDJCLENBSzNCOztBQUNBLE1BQUlDLFVBQVUsR0FBRyxTQUFiQSxVQUFhLEdBQVk7QUFDNUI7QUFDQUQsSUFBQUEsU0FBUyxHQUFHLElBQUlFLFdBQUosQ0FBZ0Isa0JBQWhCLEVBQW9DO0FBQ3RDQyxNQUFBQSxPQUFPLEVBQUUsSUFENkI7QUFFdENDLE1BQUFBLFNBQVMsRUFBRSxrQkFGMkI7QUFHdEM7QUFDQUMsTUFBQUEsUUFBUSxFQUFFO0FBSjRCLEtBQXBDLENBQVo7QUFNQSxHQVJEOztBQVVBLE1BQUlDLFNBQVMsR0FBRyxTQUFaQSxTQUFZLEdBQVc7QUFDMUJQLElBQUFBLE1BQU0sR0FBRyxJQUFJUSxZQUFKLENBQWlCLG1CQUFqQixDQUFUO0FBQ0EsR0FGRDs7QUFJQSxTQUFPO0FBQ047QUFDQUMsSUFBQUEsSUFBSSxFQUFFLGdCQUFXO0FBQ2hCUCxNQUFBQSxVQUFVOztBQUNWSyxNQUFBQSxTQUFTO0FBQ1Q7QUFMSyxHQUFQO0FBT0EsQ0EzQmUsRUFBaEI7O0FBNkJBRyxNQUFNLENBQUNDLFFBQUQsQ0FBTixDQUFpQkMsS0FBakIsQ0FBdUIsWUFBVztBQUNqQ2IsRUFBQUEsU0FBUyxDQUFDVSxJQUFWO0FBQ0EsQ0FGRCIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9tZXRyb25pYy9qcy9wYWdlcy9jdXN0b20vcHJvZmlsZS9wcm9maWxlLmpzPzVjNWEiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XG5cbi8vIENsYXNzIGRlZmluaXRpb25cbnZhciBLVFByb2ZpbGUgPSBmdW5jdGlvbiAoKSB7XG5cdC8vIEVsZW1lbnRzXG5cdHZhciBhdmF0YXI7XG5cdHZhciBvZmZjYW52YXM7XG5cblx0Ly8gUHJpdmF0ZSBmdW5jdGlvbnNcblx0dmFyIF9pbml0QXNpZGUgPSBmdW5jdGlvbiAoKSB7XG5cdFx0Ly8gTW9iaWxlIG9mZmNhbnZhcyBmb3IgbW9iaWxlIG1vZGVcblx0XHRvZmZjYW52YXMgPSBuZXcgS1RPZmZjYW52YXMoJ2t0X3Byb2ZpbGVfYXNpZGUnLCB7XG4gICAgICAgICAgICBvdmVybGF5OiB0cnVlLFxuICAgICAgICAgICAgYmFzZUNsYXNzOiAnb2ZmY2FudmFzLW1vYmlsZScsXG4gICAgICAgICAgICAvL2Nsb3NlQnk6ICdrdF91c2VyX3Byb2ZpbGVfYXNpZGVfY2xvc2UnLFxuICAgICAgICAgICAgdG9nZ2xlQnk6ICdrdF9zdWJoZWFkZXJfbW9iaWxlX3RvZ2dsZSdcbiAgICAgICAgfSk7XG5cdH1cblxuXHR2YXIgX2luaXRGb3JtID0gZnVuY3Rpb24oKSB7XG5cdFx0YXZhdGFyID0gbmV3IEtUSW1hZ2VJbnB1dCgna3RfcHJvZmlsZV9hdmF0YXInKTtcblx0fVxuXG5cdHJldHVybiB7XG5cdFx0Ly8gcHVibGljIGZ1bmN0aW9uc1xuXHRcdGluaXQ6IGZ1bmN0aW9uKCkge1xuXHRcdFx0X2luaXRBc2lkZSgpO1xuXHRcdFx0X2luaXRGb3JtKCk7XG5cdFx0fVxuXHR9O1xufSgpO1xuXG5qUXVlcnkoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xuXHRLVFByb2ZpbGUuaW5pdCgpO1xufSk7XG4iXSwibmFtZXMiOlsiS1RQcm9maWxlIiwiYXZhdGFyIiwib2ZmY2FudmFzIiwiX2luaXRBc2lkZSIsIktUT2ZmY2FudmFzIiwib3ZlcmxheSIsImJhc2VDbGFzcyIsInRvZ2dsZUJ5IiwiX2luaXRGb3JtIiwiS1RJbWFnZUlucHV0IiwiaW5pdCIsImpRdWVyeSIsImRvY3VtZW50IiwicmVhZHkiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/metronic/js/pages/custom/profile/profile.js\n");

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