/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/metronic/js/pages/crud/forms/widgets/ion-range-slider.js":
/*!****************************************************************************!*\
  !*** ./resources/metronic/js/pages/crud/forms/widgets/ion-range-slider.js ***!
  \****************************************************************************/
/***/ (() => {

eval("// Class definition\nvar KTIONRangeSlider = function () {\n  // Private functions\n  var demos = function demos() {\n    // basic demo\n    $('#kt_slider_1').ionRangeSlider(); // min & max values\n\n    $('#kt_slider_2').ionRangeSlider({\n      min: 100,\n      max: 1000,\n      from: 550\n    }); // custom prefix\n\n    $('#kt_slider_3').ionRangeSlider({\n      type: \"double\",\n      grid: true,\n      min: 0,\n      max: 1000,\n      from: 200,\n      to: 800,\n      prefix: \"$\"\n    }); // range & step\n\n    $('#kt_slider_4').ionRangeSlider({\n      type: \"double\",\n      grid: true,\n      min: -1000,\n      max: 1000,\n      from: -500,\n      to: 500\n    }); // fractional step\n\n    $('#kt_slider_5').ionRangeSlider({\n      type: \"double\",\n      grid: true,\n      min: -12.8,\n      max: 12.8,\n      from: -3.2,\n      to: 3.2,\n      step: 0.1\n    }); // using postfixes\n\n    $('#kt_slider_6').ionRangeSlider({\n      type: \"single\",\n      grid: true,\n      min: -90,\n      max: 90,\n      from: 0,\n      postfix: \"°\"\n    }); // using text\n\n    $('#kt_slider_7').ionRangeSlider({\n      type: \"double\",\n      min: 100,\n      max: 200,\n      from: 145,\n      to: 155,\n      prefix: \"Weight: \",\n      postfix: \" million pounds\",\n      decorate_both: true\n    });\n  };\n\n  return {\n    // public functions\n    init: function init() {\n      demos();\n    }\n  };\n}();\n\njQuery(document).ready(function () {\n  KTIONRangeSlider.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvY3J1ZC9mb3Jtcy93aWRnZXRzL2lvbi1yYW5nZS1zbGlkZXIuanM/ZGY1NSJdLCJuYW1lcyI6WyJLVElPTlJhbmdlU2xpZGVyIiwiZGVtb3MiLCIkIiwiaW9uUmFuZ2VTbGlkZXIiLCJtaW4iLCJtYXgiLCJmcm9tIiwidHlwZSIsImdyaWQiLCJ0byIsInByZWZpeCIsInN0ZXAiLCJwb3N0Zml4IiwiZGVjb3JhdGVfYm90aCIsImluaXQiLCJqUXVlcnkiLCJkb2N1bWVudCIsInJlYWR5Il0sIm1hcHBpbmdzIjoiQUFBQTtBQUVBLElBQUlBLGdCQUFnQixHQUFHLFlBQVk7QUFFL0I7QUFDQSxNQUFJQyxLQUFLLEdBQUcsU0FBUkEsS0FBUSxHQUFZO0FBQ3BCO0FBQ0FDLElBQUFBLENBQUMsQ0FBQyxjQUFELENBQUQsQ0FBa0JDLGNBQWxCLEdBRm9CLENBSXBCOztBQUNBRCxJQUFBQSxDQUFDLENBQUMsY0FBRCxDQUFELENBQWtCQyxjQUFsQixDQUFpQztBQUM3QkMsTUFBQUEsR0FBRyxFQUFFLEdBRHdCO0FBRTdCQyxNQUFBQSxHQUFHLEVBQUUsSUFGd0I7QUFHN0JDLE1BQUFBLElBQUksRUFBRTtBQUh1QixLQUFqQyxFQUxvQixDQVdwQjs7QUFDQUosSUFBQUEsQ0FBQyxDQUFDLGNBQUQsQ0FBRCxDQUFrQkMsY0FBbEIsQ0FBaUM7QUFDN0JJLE1BQUFBLElBQUksRUFBRSxRQUR1QjtBQUU3QkMsTUFBQUEsSUFBSSxFQUFFLElBRnVCO0FBRzdCSixNQUFBQSxHQUFHLEVBQUUsQ0FId0I7QUFJN0JDLE1BQUFBLEdBQUcsRUFBRSxJQUp3QjtBQUs3QkMsTUFBQUEsSUFBSSxFQUFFLEdBTHVCO0FBTTdCRyxNQUFBQSxFQUFFLEVBQUUsR0FOeUI7QUFPN0JDLE1BQUFBLE1BQU0sRUFBRTtBQVBxQixLQUFqQyxFQVpvQixDQXNCcEI7O0FBQ0FSLElBQUFBLENBQUMsQ0FBQyxjQUFELENBQUQsQ0FBa0JDLGNBQWxCLENBQWlDO0FBQzdCSSxNQUFBQSxJQUFJLEVBQUUsUUFEdUI7QUFFN0JDLE1BQUFBLElBQUksRUFBRSxJQUZ1QjtBQUc3QkosTUFBQUEsR0FBRyxFQUFFLENBQUMsSUFIdUI7QUFJN0JDLE1BQUFBLEdBQUcsRUFBRSxJQUp3QjtBQUs3QkMsTUFBQUEsSUFBSSxFQUFFLENBQUMsR0FMc0I7QUFNN0JHLE1BQUFBLEVBQUUsRUFBRTtBQU55QixLQUFqQyxFQXZCb0IsQ0FnQ3BCOztBQUNBUCxJQUFBQSxDQUFDLENBQUMsY0FBRCxDQUFELENBQWtCQyxjQUFsQixDQUFpQztBQUM3QkksTUFBQUEsSUFBSSxFQUFFLFFBRHVCO0FBRTdCQyxNQUFBQSxJQUFJLEVBQUUsSUFGdUI7QUFHN0JKLE1BQUFBLEdBQUcsRUFBRSxDQUFDLElBSHVCO0FBSTdCQyxNQUFBQSxHQUFHLEVBQUUsSUFKd0I7QUFLN0JDLE1BQUFBLElBQUksRUFBRSxDQUFDLEdBTHNCO0FBTTdCRyxNQUFBQSxFQUFFLEVBQUUsR0FOeUI7QUFPN0JFLE1BQUFBLElBQUksRUFBRTtBQVB1QixLQUFqQyxFQWpDb0IsQ0EyQ3BCOztBQUNBVCxJQUFBQSxDQUFDLENBQUMsY0FBRCxDQUFELENBQWtCQyxjQUFsQixDQUFpQztBQUM3QkksTUFBQUEsSUFBSSxFQUFFLFFBRHVCO0FBRTdCQyxNQUFBQSxJQUFJLEVBQUUsSUFGdUI7QUFHN0JKLE1BQUFBLEdBQUcsRUFBRSxDQUFDLEVBSHVCO0FBSTdCQyxNQUFBQSxHQUFHLEVBQUUsRUFKd0I7QUFLN0JDLE1BQUFBLElBQUksRUFBRSxDQUx1QjtBQU03Qk0sTUFBQUEsT0FBTyxFQUFFO0FBTm9CLEtBQWpDLEVBNUNvQixDQXFEcEI7O0FBQ0FWLElBQUFBLENBQUMsQ0FBQyxjQUFELENBQUQsQ0FBa0JDLGNBQWxCLENBQWlDO0FBQzdCSSxNQUFBQSxJQUFJLEVBQUUsUUFEdUI7QUFFN0JILE1BQUFBLEdBQUcsRUFBRSxHQUZ3QjtBQUc3QkMsTUFBQUEsR0FBRyxFQUFFLEdBSHdCO0FBSTdCQyxNQUFBQSxJQUFJLEVBQUUsR0FKdUI7QUFLN0JHLE1BQUFBLEVBQUUsRUFBRSxHQUx5QjtBQU03QkMsTUFBQUEsTUFBTSxFQUFFLFVBTnFCO0FBTzdCRSxNQUFBQSxPQUFPLEVBQUUsaUJBUG9CO0FBUTdCQyxNQUFBQSxhQUFhLEVBQUU7QUFSYyxLQUFqQztBQVdILEdBakVEOztBQW1FQSxTQUFPO0FBQ0g7QUFDQUMsSUFBQUEsSUFBSSxFQUFFLGdCQUFXO0FBQ2JiLE1BQUFBLEtBQUs7QUFDUjtBQUpFLEdBQVA7QUFNSCxDQTVFc0IsRUFBdkI7O0FBOEVBYyxNQUFNLENBQUNDLFFBQUQsQ0FBTixDQUFpQkMsS0FBakIsQ0FBdUIsWUFBVztBQUM5QmpCLEVBQUFBLGdCQUFnQixDQUFDYyxJQUFqQjtBQUNILENBRkQiLCJzb3VyY2VzQ29udGVudCI6WyIvLyBDbGFzcyBkZWZpbml0aW9uXG5cbnZhciBLVElPTlJhbmdlU2xpZGVyID0gZnVuY3Rpb24gKCkge1xuICAgIFxuICAgIC8vIFByaXZhdGUgZnVuY3Rpb25zXG4gICAgdmFyIGRlbW9zID0gZnVuY3Rpb24gKCkge1xuICAgICAgICAvLyBiYXNpYyBkZW1vXG4gICAgICAgICQoJyNrdF9zbGlkZXJfMScpLmlvblJhbmdlU2xpZGVyKCk7XG5cbiAgICAgICAgLy8gbWluICYgbWF4IHZhbHVlc1xuICAgICAgICAkKCcja3Rfc2xpZGVyXzInKS5pb25SYW5nZVNsaWRlcih7XG4gICAgICAgICAgICBtaW46IDEwMCxcbiAgICAgICAgICAgIG1heDogMTAwMCxcbiAgICAgICAgICAgIGZyb206IDU1MFxuICAgICAgICB9KTtcblxuICAgICAgICAvLyBjdXN0b20gcHJlZml4XG4gICAgICAgICQoJyNrdF9zbGlkZXJfMycpLmlvblJhbmdlU2xpZGVyKHtcbiAgICAgICAgICAgIHR5cGU6IFwiZG91YmxlXCIsXG4gICAgICAgICAgICBncmlkOiB0cnVlLFxuICAgICAgICAgICAgbWluOiAwLFxuICAgICAgICAgICAgbWF4OiAxMDAwLFxuICAgICAgICAgICAgZnJvbTogMjAwLFxuICAgICAgICAgICAgdG86IDgwMCxcbiAgICAgICAgICAgIHByZWZpeDogXCIkXCJcbiAgICAgICAgfSk7XG5cbiAgICAgICAgLy8gcmFuZ2UgJiBzdGVwXG4gICAgICAgICQoJyNrdF9zbGlkZXJfNCcpLmlvblJhbmdlU2xpZGVyKHtcbiAgICAgICAgICAgIHR5cGU6IFwiZG91YmxlXCIsXG4gICAgICAgICAgICBncmlkOiB0cnVlLFxuICAgICAgICAgICAgbWluOiAtMTAwMCxcbiAgICAgICAgICAgIG1heDogMTAwMCxcbiAgICAgICAgICAgIGZyb206IC01MDAsXG4gICAgICAgICAgICB0bzogNTAwXG4gICAgICAgIH0pO1xuXG4gICAgICAgIC8vIGZyYWN0aW9uYWwgc3RlcFxuICAgICAgICAkKCcja3Rfc2xpZGVyXzUnKS5pb25SYW5nZVNsaWRlcih7XG4gICAgICAgICAgICB0eXBlOiBcImRvdWJsZVwiLFxuICAgICAgICAgICAgZ3JpZDogdHJ1ZSxcbiAgICAgICAgICAgIG1pbjogLTEyLjgsXG4gICAgICAgICAgICBtYXg6IDEyLjgsXG4gICAgICAgICAgICBmcm9tOiAtMy4yLFxuICAgICAgICAgICAgdG86IDMuMixcbiAgICAgICAgICAgIHN0ZXA6IDAuMVxuICAgICAgICB9KTtcblxuICAgICAgICAvLyB1c2luZyBwb3N0Zml4ZXNcbiAgICAgICAgJCgnI2t0X3NsaWRlcl82JykuaW9uUmFuZ2VTbGlkZXIoe1xuICAgICAgICAgICAgdHlwZTogXCJzaW5nbGVcIixcbiAgICAgICAgICAgIGdyaWQ6IHRydWUsXG4gICAgICAgICAgICBtaW46IC05MCxcbiAgICAgICAgICAgIG1heDogOTAsXG4gICAgICAgICAgICBmcm9tOiAwLFxuICAgICAgICAgICAgcG9zdGZpeDogXCLCsFwiXG4gICAgICAgIH0pO1xuXG4gICAgICAgIC8vIHVzaW5nIHRleHRcbiAgICAgICAgJCgnI2t0X3NsaWRlcl83JykuaW9uUmFuZ2VTbGlkZXIoe1xuICAgICAgICAgICAgdHlwZTogXCJkb3VibGVcIixcbiAgICAgICAgICAgIG1pbjogMTAwLFxuICAgICAgICAgICAgbWF4OiAyMDAsXG4gICAgICAgICAgICBmcm9tOiAxNDUsXG4gICAgICAgICAgICB0bzogMTU1LFxuICAgICAgICAgICAgcHJlZml4OiBcIldlaWdodDogXCIsXG4gICAgICAgICAgICBwb3N0Zml4OiBcIiBtaWxsaW9uIHBvdW5kc1wiLFxuICAgICAgICAgICAgZGVjb3JhdGVfYm90aDogdHJ1ZVxuICAgICAgICB9KTtcblxuICAgIH1cblxuICAgIHJldHVybiB7XG4gICAgICAgIC8vIHB1YmxpYyBmdW5jdGlvbnNcbiAgICAgICAgaW5pdDogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBkZW1vcygpOyBcbiAgICAgICAgfVxuICAgIH07XG59KCk7XG5cbmpRdWVyeShkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG4gICAgS1RJT05SYW5nZVNsaWRlci5pbml0KCk7XG59KTsiXSwiZmlsZSI6Ii4vcmVzb3VyY2VzL21ldHJvbmljL2pzL3BhZ2VzL2NydWQvZm9ybXMvd2lkZ2V0cy9pb24tcmFuZ2Utc2xpZGVyLmpzLmpzIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/metronic/js/pages/crud/forms/widgets/ion-range-slider.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/metronic/js/pages/crud/forms/widgets/ion-range-slider.js"]();
/******/ 	
/******/ })()
;