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

/***/ "./resources/metronic/js/pages/features/custom/spinners.js":
/*!*****************************************************************!*\
  !*** ./resources/metronic/js/pages/features/custom/spinners.js ***!
  \*****************************************************************/
/***/ (() => {

eval(" // Class definition\n\nvar KTSpinnersDemo = function () {\n  // Private functions\n  // Demos\n  var demo1 = function demo1() {\n    // Demo 1\n    var btn = KTUtil.getById(\"kt_btn_1\");\n    KTUtil.addEvent(btn, \"click\", function () {\n      KTUtil.btnWait(btn, \"spinner spinner-right spinner-white pr-15\", \"Please wait\");\n      setTimeout(function () {\n        KTUtil.btnRelease(btn);\n      }, 1000);\n    });\n  };\n\n  var demo2 = function demo2() {\n    // Demo 2\n    var btn = KTUtil.getById(\"kt_btn_2\");\n    KTUtil.addEvent(btn, \"click\", function () {\n      KTUtil.btnWait(btn, \"spinner spinner-dark spinner-right pr-15\", \"Loading\");\n      setTimeout(function () {\n        KTUtil.btnRelease(btn);\n      }, 1000);\n    });\n  };\n\n  var demo3 = function demo3() {\n    // Demo 3\n    var btn = KTUtil.getById(\"kt_btn_3\");\n    KTUtil.addEvent(btn, \"click\", function () {\n      KTUtil.btnWait(btn, \"spinner spinner-left spinner-darker-success pl-15\", \"Disabled...\");\n      setTimeout(function () {\n        KTUtil.btnRelease(btn);\n      }, 1000);\n    });\n  };\n\n  var demo4 = function demo4() {\n    // Demo 4\n    var btn = KTUtil.getById(\"kt_btn_4\");\n    KTUtil.addEvent(btn, \"click\", function () {\n      KTUtil.btnWait(btn, \"spinner spinner-left spinner-darker-danger pl-15\", \"Please wait\");\n      setTimeout(function () {\n        KTUtil.btnRelease(btn);\n      }, 1000);\n    });\n  };\n\n  return {\n    // public functions\n    init: function init() {\n      demo1();\n      demo2();\n      demo3();\n      demo4();\n    }\n  };\n}();\n\njQuery(document).ready(function () {\n  KTSpinnersDemo.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvZmVhdHVyZXMvY3VzdG9tL3NwaW5uZXJzLmpzLmpzIiwibWFwcGluZ3MiOiJDQUVBOztBQUVBLElBQUlBLGNBQWMsR0FBRyxZQUFZO0FBQzdCO0FBRUE7QUFDQSxNQUFJQyxLQUFLLEdBQUcsU0FBUkEsS0FBUSxHQUFZO0FBQ3BCO0FBQ0EsUUFBSUMsR0FBRyxHQUFHQyxNQUFNLENBQUNDLE9BQVAsQ0FBZSxVQUFmLENBQVY7QUFFQUQsSUFBQUEsTUFBTSxDQUFDRSxRQUFQLENBQWdCSCxHQUFoQixFQUFxQixPQUFyQixFQUE4QixZQUFXO0FBQ3JDQyxNQUFBQSxNQUFNLENBQUNHLE9BQVAsQ0FBZUosR0FBZixFQUFvQiwyQ0FBcEIsRUFBaUUsYUFBakU7QUFFQUssTUFBQUEsVUFBVSxDQUFDLFlBQVc7QUFDbEJKLFFBQUFBLE1BQU0sQ0FBQ0ssVUFBUCxDQUFrQk4sR0FBbEI7QUFDSCxPQUZTLEVBRVAsSUFGTyxDQUFWO0FBR0gsS0FORDtBQU9ILEdBWEQ7O0FBYUEsTUFBSU8sS0FBSyxHQUFHLFNBQVJBLEtBQVEsR0FBWTtBQUNwQjtBQUNBLFFBQUlQLEdBQUcsR0FBR0MsTUFBTSxDQUFDQyxPQUFQLENBQWUsVUFBZixDQUFWO0FBRUFELElBQUFBLE1BQU0sQ0FBQ0UsUUFBUCxDQUFnQkgsR0FBaEIsRUFBcUIsT0FBckIsRUFBOEIsWUFBVztBQUNyQ0MsTUFBQUEsTUFBTSxDQUFDRyxPQUFQLENBQWVKLEdBQWYsRUFBb0IsMENBQXBCLEVBQWdFLFNBQWhFO0FBRUFLLE1BQUFBLFVBQVUsQ0FBQyxZQUFXO0FBQ2xCSixRQUFBQSxNQUFNLENBQUNLLFVBQVAsQ0FBa0JOLEdBQWxCO0FBQ0gsT0FGUyxFQUVQLElBRk8sQ0FBVjtBQUdILEtBTkQ7QUFPSCxHQVhEOztBQWFBLE1BQUlRLEtBQUssR0FBRyxTQUFSQSxLQUFRLEdBQVk7QUFDcEI7QUFDQSxRQUFJUixHQUFHLEdBQUdDLE1BQU0sQ0FBQ0MsT0FBUCxDQUFlLFVBQWYsQ0FBVjtBQUVBRCxJQUFBQSxNQUFNLENBQUNFLFFBQVAsQ0FBZ0JILEdBQWhCLEVBQXFCLE9BQXJCLEVBQThCLFlBQVc7QUFDckNDLE1BQUFBLE1BQU0sQ0FBQ0csT0FBUCxDQUFlSixHQUFmLEVBQW9CLG1EQUFwQixFQUF5RSxhQUF6RTtBQUVBSyxNQUFBQSxVQUFVLENBQUMsWUFBVztBQUNsQkosUUFBQUEsTUFBTSxDQUFDSyxVQUFQLENBQWtCTixHQUFsQjtBQUNILE9BRlMsRUFFUCxJQUZPLENBQVY7QUFHSCxLQU5EO0FBT0gsR0FYRDs7QUFhQSxNQUFJUyxLQUFLLEdBQUcsU0FBUkEsS0FBUSxHQUFZO0FBQ3BCO0FBQ0EsUUFBSVQsR0FBRyxHQUFHQyxNQUFNLENBQUNDLE9BQVAsQ0FBZSxVQUFmLENBQVY7QUFFQUQsSUFBQUEsTUFBTSxDQUFDRSxRQUFQLENBQWdCSCxHQUFoQixFQUFxQixPQUFyQixFQUE4QixZQUFXO0FBQ3JDQyxNQUFBQSxNQUFNLENBQUNHLE9BQVAsQ0FBZUosR0FBZixFQUFvQixrREFBcEIsRUFBd0UsYUFBeEU7QUFFQUssTUFBQUEsVUFBVSxDQUFDLFlBQVc7QUFDbEJKLFFBQUFBLE1BQU0sQ0FBQ0ssVUFBUCxDQUFrQk4sR0FBbEI7QUFDSCxPQUZTLEVBRVAsSUFGTyxDQUFWO0FBR0gsS0FORDtBQU9ILEdBWEQ7O0FBYUEsU0FBTztBQUNIO0FBQ0FVLElBQUFBLElBQUksRUFBRSxnQkFBVztBQUNiWCxNQUFBQSxLQUFLO0FBQ0xRLE1BQUFBLEtBQUs7QUFDTEMsTUFBQUEsS0FBSztBQUNMQyxNQUFBQSxLQUFLO0FBQ1I7QUFQRSxHQUFQO0FBU0gsQ0FqRW9CLEVBQXJCOztBQW1FQUUsTUFBTSxDQUFDQyxRQUFELENBQU4sQ0FBaUJDLEtBQWpCLENBQXVCLFlBQVc7QUFDOUJmLEVBQUFBLGNBQWMsQ0FBQ1ksSUFBZjtBQUNILENBRkQiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvZmVhdHVyZXMvY3VzdG9tL3NwaW5uZXJzLmpzPzcxYzUiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XG5cbi8vIENsYXNzIGRlZmluaXRpb25cblxudmFyIEtUU3Bpbm5lcnNEZW1vID0gZnVuY3Rpb24gKCkge1xuICAgIC8vIFByaXZhdGUgZnVuY3Rpb25zXG5cbiAgICAvLyBEZW1vc1xuICAgIHZhciBkZW1vMSA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgLy8gRGVtbyAxXG4gICAgICAgIHZhciBidG4gPSBLVFV0aWwuZ2V0QnlJZChcImt0X2J0bl8xXCIpO1xuXG4gICAgICAgIEtUVXRpbC5hZGRFdmVudChidG4sIFwiY2xpY2tcIiwgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBLVFV0aWwuYnRuV2FpdChidG4sIFwic3Bpbm5lciBzcGlubmVyLXJpZ2h0IHNwaW5uZXItd2hpdGUgcHItMTVcIiwgXCJQbGVhc2Ugd2FpdFwiKTtcblxuICAgICAgICAgICAgc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICBLVFV0aWwuYnRuUmVsZWFzZShidG4pO1xuICAgICAgICAgICAgfSwgMTAwMCk7XG4gICAgICAgIH0pO1xuICAgIH1cblxuICAgIHZhciBkZW1vMiA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgLy8gRGVtbyAyXG4gICAgICAgIHZhciBidG4gPSBLVFV0aWwuZ2V0QnlJZChcImt0X2J0bl8yXCIpO1xuXG4gICAgICAgIEtUVXRpbC5hZGRFdmVudChidG4sIFwiY2xpY2tcIiwgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBLVFV0aWwuYnRuV2FpdChidG4sIFwic3Bpbm5lciBzcGlubmVyLWRhcmsgc3Bpbm5lci1yaWdodCBwci0xNVwiLCBcIkxvYWRpbmdcIik7XG5cbiAgICAgICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgS1RVdGlsLmJ0blJlbGVhc2UoYnRuKTtcbiAgICAgICAgICAgIH0sIDEwMDApO1xuICAgICAgICB9KTtcbiAgICB9XG5cbiAgICB2YXIgZGVtbzMgPSBmdW5jdGlvbiAoKSB7XG4gICAgICAgIC8vIERlbW8gM1xuICAgICAgICB2YXIgYnRuID0gS1RVdGlsLmdldEJ5SWQoXCJrdF9idG5fM1wiKTtcblxuICAgICAgICBLVFV0aWwuYWRkRXZlbnQoYnRuLCBcImNsaWNrXCIsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgS1RVdGlsLmJ0bldhaXQoYnRuLCBcInNwaW5uZXIgc3Bpbm5lci1sZWZ0IHNwaW5uZXItZGFya2VyLXN1Y2Nlc3MgcGwtMTVcIiwgXCJEaXNhYmxlZC4uLlwiKTtcblxuICAgICAgICAgICAgc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICBLVFV0aWwuYnRuUmVsZWFzZShidG4pO1xuICAgICAgICAgICAgfSwgMTAwMCk7XG4gICAgICAgIH0pO1xuICAgIH1cblxuICAgIHZhciBkZW1vNCA9IGZ1bmN0aW9uICgpIHtcbiAgICAgICAgLy8gRGVtbyA0XG4gICAgICAgIHZhciBidG4gPSBLVFV0aWwuZ2V0QnlJZChcImt0X2J0bl80XCIpO1xuXG4gICAgICAgIEtUVXRpbC5hZGRFdmVudChidG4sIFwiY2xpY2tcIiwgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBLVFV0aWwuYnRuV2FpdChidG4sIFwic3Bpbm5lciBzcGlubmVyLWxlZnQgc3Bpbm5lci1kYXJrZXItZGFuZ2VyIHBsLTE1XCIsIFwiUGxlYXNlIHdhaXRcIik7XG5cbiAgICAgICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgS1RVdGlsLmJ0blJlbGVhc2UoYnRuKTtcbiAgICAgICAgICAgIH0sIDEwMDApO1xuICAgICAgICB9KTtcbiAgICB9XG5cbiAgICByZXR1cm4ge1xuICAgICAgICAvLyBwdWJsaWMgZnVuY3Rpb25zXG4gICAgICAgIGluaXQ6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgZGVtbzEoKTtcbiAgICAgICAgICAgIGRlbW8yKCk7XG4gICAgICAgICAgICBkZW1vMygpO1xuICAgICAgICAgICAgZGVtbzQoKTtcbiAgICAgICAgfVxuICAgIH07XG59KCk7XG5cbmpRdWVyeShkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG4gICAgS1RTcGlubmVyc0RlbW8uaW5pdCgpO1xufSk7XG4iXSwibmFtZXMiOlsiS1RTcGlubmVyc0RlbW8iLCJkZW1vMSIsImJ0biIsIktUVXRpbCIsImdldEJ5SWQiLCJhZGRFdmVudCIsImJ0bldhaXQiLCJzZXRUaW1lb3V0IiwiYnRuUmVsZWFzZSIsImRlbW8yIiwiZGVtbzMiLCJkZW1vNCIsImluaXQiLCJqUXVlcnkiLCJkb2N1bWVudCIsInJlYWR5Il0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/metronic/js/pages/features/custom/spinners.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/metronic/js/pages/features/custom/spinners.js"]();
/******/ 	
/******/ })()
;