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

/***/ "./resources/metronic/js/pages/crud/forms/editors/tinymce.js":
/*!*******************************************************************!*\
  !*** ./resources/metronic/js/pages/crud/forms/editors/tinymce.js ***!
  \*******************************************************************/
/***/ (() => {

eval(" // Class definition\n\nvar KTTinymce = function () {\n  // Private functions\n  var demos = function demos() {\n    tinymce.init({\n      selector: '#kt-tinymce-1',\n      toolbar: false,\n      statusbar: false\n    });\n    tinymce.init({\n      selector: '#kt-tinymce-2'\n    });\n    tinymce.init({\n      selector: '#kt-tinymce-3',\n      toolbar: 'advlist | autolink | link image | lists charmap | print preview',\n      plugins: 'advlist autolink link image lists charmap print preview'\n    });\n    tinymce.init({\n      selector: '#kt-tinymce-4',\n      menubar: false,\n      toolbar: ['styleselect fontselect fontsizeselect', 'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify', 'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code'],\n      plugins: 'advlist autolink link image lists charmap print preview code'\n    });\n  };\n\n  return {\n    // public functions\n    init: function init() {\n      demos();\n    }\n  };\n}(); // Initialization\n\n\njQuery(document).ready(function () {\n  KTTinymce.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvY3J1ZC9mb3Jtcy9lZGl0b3JzL3RpbnltY2UuanMuanMiLCJtYXBwaW5ncyI6IkNBQ0E7O0FBRUEsSUFBSUEsU0FBUyxHQUFHLFlBQVk7QUFDeEI7QUFDQSxNQUFJQyxLQUFLLEdBQUcsU0FBUkEsS0FBUSxHQUFZO0FBRXBCQyxJQUFBQSxPQUFPLENBQUNDLElBQVIsQ0FBYTtBQUNsQkMsTUFBQUEsUUFBUSxFQUFFLGVBRFE7QUFFVEMsTUFBQUEsT0FBTyxFQUFFLEtBRkE7QUFHVEMsTUFBQUEsU0FBUyxFQUFFO0FBSEYsS0FBYjtBQU1OSixJQUFBQSxPQUFPLENBQUNDLElBQVIsQ0FBYTtBQUNaQyxNQUFBQSxRQUFRLEVBQUU7QUFERSxLQUFiO0FBSU1GLElBQUFBLE9BQU8sQ0FBQ0MsSUFBUixDQUFhO0FBQ1RDLE1BQUFBLFFBQVEsRUFBRSxlQUREO0FBRVRDLE1BQUFBLE9BQU8sRUFBRSxpRUFGQTtBQUdURSxNQUFBQSxPQUFPLEVBQUc7QUFIRCxLQUFiO0FBTUFMLElBQUFBLE9BQU8sQ0FBQ0MsSUFBUixDQUFhO0FBQ1RDLE1BQUFBLFFBQVEsRUFBRSxlQUREO0FBRVRJLE1BQUFBLE9BQU8sRUFBRSxLQUZBO0FBR1RILE1BQUFBLE9BQU8sRUFBRSxDQUFDLHVDQUFELEVBQ0wsdUdBREssRUFFTCxrSUFGSyxDQUhBO0FBTVRFLE1BQUFBLE9BQU8sRUFBRztBQU5ELEtBQWI7QUFRSCxHQTFCRDs7QUE0QkEsU0FBTztBQUNIO0FBQ0FKLElBQUFBLElBQUksRUFBRSxnQkFBVztBQUNiRixNQUFBQSxLQUFLO0FBQ1I7QUFKRSxHQUFQO0FBTUgsQ0FwQ2UsRUFBaEIsQyxDQXNDQTs7O0FBQ0FRLE1BQU0sQ0FBQ0MsUUFBRCxDQUFOLENBQWlCQyxLQUFqQixDQUF1QixZQUFXO0FBQzlCWCxFQUFBQSxTQUFTLENBQUNHLElBQVY7QUFDSCxDQUZEIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL21ldHJvbmljL2pzL3BhZ2VzL2NydWQvZm9ybXMvZWRpdG9ycy90aW55bWNlLmpzPzY0ODYiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XG4vLyBDbGFzcyBkZWZpbml0aW9uXG5cbnZhciBLVFRpbnltY2UgPSBmdW5jdGlvbiAoKSB7ICAgIFxuICAgIC8vIFByaXZhdGUgZnVuY3Rpb25zXG4gICAgdmFyIGRlbW9zID0gZnVuY3Rpb24gKCkge1xuICAgICAgICBcbiAgICAgICAgdGlueW1jZS5pbml0KHtcblx0XHRcdHNlbGVjdG9yOiAnI2t0LXRpbnltY2UtMScsXG4gICAgICAgICAgICB0b29sYmFyOiBmYWxzZSxcbiAgICAgICAgICAgIHN0YXR1c2JhcjogZmFsc2Vcblx0XHR9KTtcblxuXHRcdHRpbnltY2UuaW5pdCh7XG5cdFx0XHRzZWxlY3RvcjogJyNrdC10aW55bWNlLTInXG4gICAgICAgIH0pO1xuICAgICAgICBcbiAgICAgICAgdGlueW1jZS5pbml0KHtcbiAgICAgICAgICAgIHNlbGVjdG9yOiAnI2t0LXRpbnltY2UtMycsXG4gICAgICAgICAgICB0b29sYmFyOiAnYWR2bGlzdCB8IGF1dG9saW5rIHwgbGluayBpbWFnZSB8IGxpc3RzIGNoYXJtYXAgfCBwcmludCBwcmV2aWV3JywgXG4gICAgICAgICAgICBwbHVnaW5zIDogJ2Fkdmxpc3QgYXV0b2xpbmsgbGluayBpbWFnZSBsaXN0cyBjaGFybWFwIHByaW50IHByZXZpZXcnXG4gICAgICAgIH0pO1xuICAgICAgICBcbiAgICAgICAgdGlueW1jZS5pbml0KHtcbiAgICAgICAgICAgIHNlbGVjdG9yOiAnI2t0LXRpbnltY2UtNCcsXG4gICAgICAgICAgICBtZW51YmFyOiBmYWxzZSxcbiAgICAgICAgICAgIHRvb2xiYXI6IFsnc3R5bGVzZWxlY3QgZm9udHNlbGVjdCBmb250c2l6ZXNlbGVjdCcsXG4gICAgICAgICAgICAgICAgJ3VuZG8gcmVkbyB8IGN1dCBjb3B5IHBhc3RlIHwgYm9sZCBpdGFsaWMgfCBsaW5rIGltYWdlIHwgYWxpZ25sZWZ0IGFsaWduY2VudGVyIGFsaWducmlnaHQgYWxpZ25qdXN0aWZ5JyxcbiAgICAgICAgICAgICAgICAnYnVsbGlzdCBudW1saXN0IHwgb3V0ZGVudCBpbmRlbnQgfCBibG9ja3F1b3RlIHN1YnNjcmlwdCBzdXBlcnNjcmlwdCB8IGFkdmxpc3QgfCBhdXRvbGluayB8IGxpc3RzIGNoYXJtYXAgfCBwcmludCBwcmV2aWV3IHwgIGNvZGUnXSwgXG4gICAgICAgICAgICBwbHVnaW5zIDogJ2Fkdmxpc3QgYXV0b2xpbmsgbGluayBpbWFnZSBsaXN0cyBjaGFybWFwIHByaW50IHByZXZpZXcgY29kZSdcbiAgICAgICAgfSk7ICAgICAgIFxuICAgIH1cblxuICAgIHJldHVybiB7XG4gICAgICAgIC8vIHB1YmxpYyBmdW5jdGlvbnNcbiAgICAgICAgaW5pdDogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBkZW1vcygpOyBcbiAgICAgICAgfVxuICAgIH07XG59KCk7XG5cbi8vIEluaXRpYWxpemF0aW9uXG5qUXVlcnkoZG9jdW1lbnQpLnJlYWR5KGZ1bmN0aW9uKCkge1xuICAgIEtUVGlueW1jZS5pbml0KCk7XG59KTsiXSwibmFtZXMiOlsiS1RUaW55bWNlIiwiZGVtb3MiLCJ0aW55bWNlIiwiaW5pdCIsInNlbGVjdG9yIiwidG9vbGJhciIsInN0YXR1c2JhciIsInBsdWdpbnMiLCJtZW51YmFyIiwialF1ZXJ5IiwiZG9jdW1lbnQiLCJyZWFkeSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/metronic/js/pages/crud/forms/editors/tinymce.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/metronic/js/pages/crud/forms/editors/tinymce.js"]();
/******/ 	
/******/ })()
;