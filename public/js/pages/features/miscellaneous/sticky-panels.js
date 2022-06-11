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

eval(" // Class definition\n// Based on:  https://github.com/rgalus/sticky-js\n\nvar KTStickyPanelsDemo = function () {\n  // Private functions\n  // Basic demo\n  var demo1 = function demo1() {\n    if (KTLayoutAsideToggle && KTLayoutAsideToggle.onToggle) {\n      var sticky = new Sticky('.sticky');\n      KTLayoutAsideToggle.onToggle(function () {\n        setTimeout(function () {\n          sticky.update(); // update sticky positions on aside toggle\n        }, 500);\n      });\n    }\n  };\n\n  return {\n    // public functions\n    init: function init() {\n      demo1();\n    }\n  };\n}();\n\njQuery(document).ready(function () {\n  KTStickyPanelsDemo.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvZmVhdHVyZXMvbWlzY2VsbGFuZW91cy9zdGlja3ktcGFuZWxzLmpzLmpzIiwibWFwcGluZ3MiOiJDQUNBO0FBQ0E7O0FBRUEsSUFBSUEsa0JBQWtCLEdBQUcsWUFBWTtBQUVqQztBQUVBO0FBQ0EsTUFBSUMsS0FBSyxHQUFHLFNBQVJBLEtBQVEsR0FBWTtBQUNwQixRQUFJQyxtQkFBbUIsSUFBSUEsbUJBQW1CLENBQUNDLFFBQS9DLEVBQXlEO0FBQ3JELFVBQUlDLE1BQU0sR0FBRyxJQUFJQyxNQUFKLENBQVcsU0FBWCxDQUFiO0FBRUFILE1BQUFBLG1CQUFtQixDQUFDQyxRQUFwQixDQUE2QixZQUFXO0FBQ3BDRyxRQUFBQSxVQUFVLENBQUMsWUFBVztBQUNsQkYsVUFBQUEsTUFBTSxDQUFDRyxNQUFQLEdBRGtCLENBQ0Q7QUFDcEIsU0FGUyxFQUVQLEdBRk8sQ0FBVjtBQUdILE9BSkQ7QUFLSDtBQUNKLEdBVkQ7O0FBWUEsU0FBTztBQUNIO0FBQ0FDLElBQUFBLElBQUksRUFBRSxnQkFBVztBQUNiUCxNQUFBQSxLQUFLO0FBQ1I7QUFKRSxHQUFQO0FBTUgsQ0F2QndCLEVBQXpCOztBQXlCQVEsTUFBTSxDQUFDQyxRQUFELENBQU4sQ0FBaUJDLEtBQWpCLENBQXVCLFlBQVc7QUFDOUJYLEVBQUFBLGtCQUFrQixDQUFDUSxJQUFuQjtBQUNILENBRkQiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvZmVhdHVyZXMvbWlzY2VsbGFuZW91cy9zdGlja3ktcGFuZWxzLmpzPzI2MzkiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XG4vLyBDbGFzcyBkZWZpbml0aW9uXG4vLyBCYXNlZCBvbjogIGh0dHBzOi8vZ2l0aHViLmNvbS9yZ2FsdXMvc3RpY2t5LWpzXG5cbnZhciBLVFN0aWNreVBhbmVsc0RlbW8gPSBmdW5jdGlvbiAoKSB7XG5cbiAgICAvLyBQcml2YXRlIGZ1bmN0aW9uc1xuXG4gICAgLy8gQmFzaWMgZGVtb1xuICAgIHZhciBkZW1vMSA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgaWYgKEtUTGF5b3V0QXNpZGVUb2dnbGUgJiYgS1RMYXlvdXRBc2lkZVRvZ2dsZS5vblRvZ2dsZSkge1xuICAgICAgICAgICAgdmFyIHN0aWNreSA9IG5ldyBTdGlja3koJy5zdGlja3knKTtcblxuICAgICAgICAgICAgS1RMYXlvdXRBc2lkZVRvZ2dsZS5vblRvZ2dsZShmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgICAgICBzdGlja3kudXBkYXRlKCk7IC8vIHVwZGF0ZSBzdGlja3kgcG9zaXRpb25zIG9uIGFzaWRlIHRvZ2dsZVxuICAgICAgICAgICAgICAgIH0sIDUwMCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuICAgIH1cblxuICAgIHJldHVybiB7XG4gICAgICAgIC8vIHB1YmxpYyBmdW5jdGlvbnNcbiAgICAgICAgaW5pdDogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBkZW1vMSgpO1xuICAgICAgICB9XG4gICAgfTtcbn0oKTtcblxualF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcbiAgICBLVFN0aWNreVBhbmVsc0RlbW8uaW5pdCgpO1xufSk7XG4iXSwibmFtZXMiOlsiS1RTdGlja3lQYW5lbHNEZW1vIiwiZGVtbzEiLCJLVExheW91dEFzaWRlVG9nZ2xlIiwib25Ub2dnbGUiLCJzdGlja3kiLCJTdGlja3kiLCJzZXRUaW1lb3V0IiwidXBkYXRlIiwiaW5pdCIsImpRdWVyeSIsImRvY3VtZW50IiwicmVhZHkiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/metronic/js/pages/features/miscellaneous/sticky-panels.js\n");

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