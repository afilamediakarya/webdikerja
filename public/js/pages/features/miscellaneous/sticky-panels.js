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

/***/ "./resources/metronic/js/pages/features/miscellaneous/sticky-panels.js":
/*!*****************************************************************************!*\
  !*** ./resources/metronic/js/pages/features/miscellaneous/sticky-panels.js ***!
  \*****************************************************************************/
/***/ (() => {

eval(" // Class definition\n// Based on:  https://github.com/rgalus/sticky-js\n\nvar KTStickyPanelsDemo = function () {\n  // Private functions\n  // Basic demo\n  var demo1 = function demo1() {\n    if (KTLayoutAsideToggle && KTLayoutAsideToggle.onToggle) {\n      var sticky = new Sticky('.sticky');\n      KTLayoutAsideToggle.onToggle(function () {\n        setTimeout(function () {\n          sticky.update(); // update sticky positions on aside toggle\n        }, 500);\n      });\n    }\n  };\n\n  return {\n    // public functions\n    init: function init() {\n      demo1();\n    }\n  };\n}();\n\njQuery(document).ready(function () {\n  KTStickyPanelsDemo.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvZmVhdHVyZXMvbWlzY2VsbGFuZW91cy9zdGlja3ktcGFuZWxzLmpzLmpzIiwibWFwcGluZ3MiOiJDQUNBO0FBQ0E7O0FBRUEsSUFBSUEsa0JBQWtCLEdBQUcsWUFBWTtBQUVqQztBQUVBO0FBQ0EsTUFBSUMsS0FBSyxHQUFHLFNBQVJBLEtBQVEsR0FBWTtBQUNwQixRQUFJQyxtQkFBbUIsSUFBSUEsbUJBQW1CLENBQUNDLFFBQS9DLEVBQXlEO0FBQ3JELFVBQUlDLE1BQU0sR0FBRyxJQUFJQyxNQUFKLENBQVcsU0FBWCxDQUFiO0FBRUFILE1BQUFBLG1CQUFtQixDQUFDQyxRQUFwQixDQUE2QixZQUFXO0FBQ3BDRyxRQUFBQSxVQUFVLENBQUMsWUFBVztBQUNsQkYsVUFBQUEsTUFBTSxDQUFDRyxNQUFQLEdBRGtCLENBQ0Q7QUFDcEIsU0FGUyxFQUVQLEdBRk8sQ0FBVjtBQUdILE9BSkQ7QUFLSDtBQUNKLEdBVkQ7O0FBWUEsU0FBTztBQUNIO0FBQ0FDLElBQUFBLElBQUksRUFBRSxnQkFBVztBQUNiUCxNQUFBQSxLQUFLO0FBQ1I7QUFKRSxHQUFQO0FBTUgsQ0F2QndCLEVBQXpCOztBQXlCQVEsTUFBTSxDQUFDQyxRQUFELENBQU4sQ0FBaUJDLEtBQWpCLENBQXVCLFlBQVc7QUFDOUJYLEVBQUFBLGtCQUFrQixDQUFDUSxJQUFuQjtBQUNILENBRkQiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvZmVhdHVyZXMvbWlzY2VsbGFuZW91cy9zdGlja3ktcGFuZWxzLmpzPzI2MzkiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XHJcbi8vIENsYXNzIGRlZmluaXRpb25cclxuLy8gQmFzZWQgb246ICBodHRwczovL2dpdGh1Yi5jb20vcmdhbHVzL3N0aWNreS1qc1xyXG5cclxudmFyIEtUU3RpY2t5UGFuZWxzRGVtbyA9IGZ1bmN0aW9uICgpIHtcclxuXHJcbiAgICAvLyBQcml2YXRlIGZ1bmN0aW9uc1xyXG5cclxuICAgIC8vIEJhc2ljIGRlbW9cclxuICAgIHZhciBkZW1vMSA9IGZ1bmN0aW9uICgpIHtcclxuICAgICAgICBpZiAoS1RMYXlvdXRBc2lkZVRvZ2dsZSAmJiBLVExheW91dEFzaWRlVG9nZ2xlLm9uVG9nZ2xlKSB7XHJcbiAgICAgICAgICAgIHZhciBzdGlja3kgPSBuZXcgU3RpY2t5KCcuc3RpY2t5Jyk7XHJcblxyXG4gICAgICAgICAgICBLVExheW91dEFzaWRlVG9nZ2xlLm9uVG9nZ2xlKGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgc2V0VGltZW91dChmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgICAgICBzdGlja3kudXBkYXRlKCk7IC8vIHVwZGF0ZSBzdGlja3kgcG9zaXRpb25zIG9uIGFzaWRlIHRvZ2dsZVxyXG4gICAgICAgICAgICAgICAgfSwgNTAwKTtcclxuICAgICAgICAgICAgfSk7XHJcbiAgICAgICAgfVxyXG4gICAgfVxyXG5cclxuICAgIHJldHVybiB7XHJcbiAgICAgICAgLy8gcHVibGljIGZ1bmN0aW9uc1xyXG4gICAgICAgIGluaXQ6IGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICBkZW1vMSgpO1xyXG4gICAgICAgIH1cclxuICAgIH07XHJcbn0oKTtcclxuXHJcbmpRdWVyeShkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XHJcbiAgICBLVFN0aWNreVBhbmVsc0RlbW8uaW5pdCgpO1xyXG59KTtcclxuIl0sIm5hbWVzIjpbIktUU3RpY2t5UGFuZWxzRGVtbyIsImRlbW8xIiwiS1RMYXlvdXRBc2lkZVRvZ2dsZSIsIm9uVG9nZ2xlIiwic3RpY2t5IiwiU3RpY2t5Iiwic2V0VGltZW91dCIsInVwZGF0ZSIsImluaXQiLCJqUXVlcnkiLCJkb2N1bWVudCIsInJlYWR5Il0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/metronic/js/pages/features/miscellaneous/sticky-panels.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/metronic/js/pages/features/miscellaneous/sticky-panels.js"]();
/******/ 	
/******/ })()
;