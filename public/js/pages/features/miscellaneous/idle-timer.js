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

/***/ "./resources/metronic/js/pages/features/miscellaneous/idle-timer.js":
/*!**************************************************************************!*\
  !*** ./resources/metronic/js/pages/features/miscellaneous/idle-timer.js ***!
  \**************************************************************************/
/***/ (() => {

eval("\n\nvar KTIdleTimerDemo = function () {\n  var _initDemo1 = function _initDemo1() {\n    //Define default\n    var docTimeout = 5000;\n    /*\n    Handle raised idle/active events\n    */\n\n    $(document).on(\"idle.idleTimer\", function (event, elem, obj) {\n      $(\"#docStatus\").val(function (i, v) {\n        return v + \"Idle @ \" + moment().format() + \" \\n\";\n      }).removeClass(\"alert-success\").addClass(\"alert-warning\").scrollTop($(\"#docStatus\")[0].scrollHeight);\n    });\n    $(document).on(\"active.idleTimer\", function (event, elem, obj, e) {\n      $(\"#docStatus\").val(function (i, v) {\n        return v + \"Active [\" + e.type + \"] [\" + e.target.nodeName + \"] @ \" + moment().format() + \" \\n\";\n      }).addClass(\"alert-success\").removeClass(\"alert-warning\").scrollTop($(\"#docStatus\")[0].scrollHeight);\n    });\n    /*\n    Handle button events\n    */\n\n    $(\"#btPause\").click(function () {\n      $(document).idleTimer(\"pause\");\n      $(\"#docStatus\").val(function (i, v) {\n        return v + \"Paused @ \" + moment().format() + \" \\n\";\n      }).scrollTop($(\"#docStatus\")[0].scrollHeight);\n      $(this).blur();\n      return false;\n    });\n    $(\"#btResume\").click(function () {\n      $(document).idleTimer(\"resume\");\n      $(\"#docStatus\").val(function (i, v) {\n        return v + \"Resumed @ \" + moment().format() + \" \\n\";\n      }).scrollTop($(\"#docStatus\")[0].scrollHeight);\n      $(this).blur();\n      return false;\n    });\n    $(\"#btElapsed\").click(function () {\n      $(\"#docStatus\").val(function (i, v) {\n        return v + \"Elapsed (since becoming active): \" + $(document).idleTimer(\"getElapsedTime\") + \" \\n\";\n      }).scrollTop($(\"#docStatus\")[0].scrollHeight);\n      $(this).blur();\n      return false;\n    });\n    $(\"#btDestroy\").click(function () {\n      $(document).idleTimer(\"destroy\");\n      $(\"#docStatus\").val(function (i, v) {\n        return v + \"Destroyed: @ \" + moment().format() + \" \\n\";\n      }).removeClass(\"alert-success\").removeClass(\"alert-warning\").scrollTop($(\"#docStatus\")[0].scrollHeight);\n      $(this).blur();\n      return false;\n    });\n    $(\"#btInit\").click(function () {\n      // for demo purposes show init with just object\n      $(document).idleTimer({\n        timeout: docTimeout\n      });\n      $(\"#docStatus\").val(function (i, v) {\n        return v + \"Init: @ \" + moment().format() + \" \\n\";\n      }).scrollTop($(\"#docStatus\")[0].scrollHeight); //Apply classes for default state\n\n      if ($(document).idleTimer(\"isIdle\")) {\n        $(\"#docStatus\").removeClass(\"alert-success\").addClass(\"alert-warning\");\n      } else {\n        $(\"#docStatus\").addClass(\"alert-success\").removeClass(\"alert-warning\");\n      }\n\n      $(this).blur();\n      return false;\n    }); //Clear old statuses\n\n    $(\"#docStatus\").val(\"\"); //Start timeout, passing no options\n    //Same as $.idleTimer(docTimeout, docOptions);\n\n    $(document).idleTimer(docTimeout); //For demo purposes, style based on initial state\n\n    if ($(document).idleTimer(\"isIdle\")) {\n      $(\"#docStatus\").val(function (i, v) {\n        return v + \"Initial Idle State @ \" + moment().format() + \" \\n\";\n      }).removeClass(\"alert-success\").addClass(\"alert-warning\").scrollTop($(\"#docStatus\")[0].scrollHeight);\n    } else {\n      $(\"#docStatus\").val(function (i, v) {\n        return v + \"Initial Active State @ \" + moment().format() + \" \\n\";\n      }).addClass(\"alert-success\").removeClass(\"alert-warning\").scrollTop($(\"#docStatus\")[0].scrollHeight);\n    } //For demo purposes, display the actual timeout on the page\n\n\n    $(\"#docTimeout\").text(docTimeout / 1000);\n  };\n\n  var _initDemo2 = function _initDemo2() {\n    //Define textarea settings\n    var taTimeout = 3000;\n    /*\n    Handle raised idle/active events\n    */\n\n    $(\"#elStatus\").on(\"idle.idleTimer\", function (event, elem, obj) {\n      //If you dont stop propagation it will bubble up to document event handler\n      event.stopPropagation();\n      $(\"#elStatus\").val(function (i, v) {\n        return v + \"Idle @ \" + moment().format() + \" \\n\";\n      }).removeClass(\"alert-success\").addClass(\"alert-warning\").scrollTop($(\"#elStatus\")[0].scrollHeight);\n    });\n    $(\"#elStatus\").on(\"active.idleTimer\", function (event) {\n      //If you dont stop propagation it will bubble up to document event handler\n      event.stopPropagation();\n      $(\"#elStatus\").val(function (i, v) {\n        return v + \"Active @ \" + moment().format() + \" \\n\";\n      }).addClass(\"alert-success\").removeClass(\"alert-warning\").scrollTop($(\"#elStatus\")[0].scrollHeight);\n    });\n    /*\n    Handle button events\n    */\n\n    $(\"#btReset\").click(function () {\n      $(\"#elStatus\").idleTimer(\"reset\").val(function (i, v) {\n        return v + \"Reset @ \" + moment().format() + \" \\n\";\n      }).scrollTop($(\"#elStatus\")[0].scrollHeight); //Apply classes for default state\n\n      if ($(\"#elStatus\").idleTimer(\"isIdle\")) {\n        $(\"#elStatus\").removeClass(\"alert-success\").addClass(\"alert-warning\");\n      } else {\n        $(\"#elStatus\").addClass(\"alert-success\").removeClass(\"alert-warning\");\n      }\n\n      $(this).blur();\n      return false;\n    });\n    $(\"#btRemaining\").click(function () {\n      $(\"#elStatus\").val(function (i, v) {\n        return v + \"Remaining: \" + $(\"#elStatus\").idleTimer(\"getRemainingTime\") + \" \\n\";\n      }).scrollTop($(\"#elStatus\")[0].scrollHeight);\n      $(this).blur();\n      return false;\n    });\n    $(\"#btLastActive\").click(function () {\n      $(\"#elStatus\").val(function (i, v) {\n        return v + \"LastActive: \" + $(\"#elStatus\").idleTimer(\"getLastActiveTime\") + \" \\n\";\n      }).scrollTop($(\"#elStatus\")[0].scrollHeight);\n      $(this).blur();\n      return false;\n    });\n    $(\"#btState\").click(function () {\n      $(\"#elStatus\").val(function (i, v) {\n        return v + \"State: \" + ($(\"#elStatus\").idleTimer(\"isIdle\") ? \"idle\" : \"active\") + \" \\n\";\n      }).scrollTop($(\"#elStatus\")[0].scrollHeight);\n      $(this).blur();\n      return false;\n    }); //Clear value if there was one cached & start time\n\n    $(\"#elStatus\").val(\"\").idleTimer(taTimeout); //For demo purposes, show initial state\n\n    if ($(\"#elStatus\").idleTimer(\"isIdle\")) {\n      $(\"#elStatus\").val(function (i, v) {\n        return v + \"Initial Idle @ \" + moment().format() + \" \\n\";\n      }).removeClass(\"alert-success\").addClass(\"alert-warning\").scrollTop($(\"#elStatus\")[0].scrollHeight);\n    } else {\n      $(\"#elStatus\").val(function (i, v) {\n        return v + \"Initial Active @ \" + moment().format() + \" \\n\";\n      }).addClass(\"alert-success\").removeClass(\"alert-warning\").scrollTop($(\"#elStatus\")[0].scrollHeight);\n    } // Display the actual timeout on the page\n\n\n    $(\"#elTimeout\").text(taTimeout / 1000);\n  };\n\n  return {\n    //main function to initiate the module\n    init: function init() {\n      _initDemo1();\n\n      _initDemo2();\n    }\n  };\n}();\n\njQuery(document).ready(function () {\n  KTIdleTimerDemo.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvZmVhdHVyZXMvbWlzY2VsbGFuZW91cy9pZGxlLXRpbWVyLmpzLmpzIiwibWFwcGluZ3MiOiJBQUFhOztBQUViLElBQUlBLGVBQWUsR0FBRyxZQUFXO0FBQzdCLE1BQUlDLFVBQVUsR0FBRyxTQUFiQSxVQUFhLEdBQVc7QUFDeEI7QUFDQSxRQUFJQyxVQUFVLEdBQUcsSUFBakI7QUFFQTtBQUNSO0FBQ0E7O0FBQ1FDLElBQUFBLENBQUMsQ0FBQ0MsUUFBRCxDQUFELENBQVlDLEVBQVosQ0FBZSxnQkFBZixFQUFpQyxVQUFTQyxLQUFULEVBQWdCQyxJQUFoQixFQUFzQkMsR0FBdEIsRUFBMkI7QUFDeERMLE1BQUFBLENBQUMsQ0FBQyxZQUFELENBQUQsQ0FDS00sR0FETCxDQUNTLFVBQVNDLENBQVQsRUFBWUMsQ0FBWixFQUFlO0FBQ2hCLGVBQU9BLENBQUMsR0FBRyxTQUFKLEdBQWdCQyxNQUFNLEdBQUdDLE1BQVQsRUFBaEIsR0FBb0MsS0FBM0M7QUFDSCxPQUhMLEVBSUtDLFdBSkwsQ0FJaUIsZUFKakIsRUFLS0MsUUFMTCxDQUtjLGVBTGQsRUFNS0MsU0FOTCxDQU1lYixDQUFDLENBQUMsWUFBRCxDQUFELENBQWdCLENBQWhCLEVBQW1CYyxZQU5sQztBQU9ILEtBUkQ7QUFTQWQsSUFBQUEsQ0FBQyxDQUFDQyxRQUFELENBQUQsQ0FBWUMsRUFBWixDQUFlLGtCQUFmLEVBQW1DLFVBQVNDLEtBQVQsRUFBZ0JDLElBQWhCLEVBQXNCQyxHQUF0QixFQUEyQlUsQ0FBM0IsRUFBOEI7QUFDN0RmLE1BQUFBLENBQUMsQ0FBQyxZQUFELENBQUQsQ0FDS00sR0FETCxDQUNTLFVBQVNDLENBQVQsRUFBWUMsQ0FBWixFQUFlO0FBQ2hCLGVBQU9BLENBQUMsR0FBRyxVQUFKLEdBQWlCTyxDQUFDLENBQUNDLElBQW5CLEdBQTBCLEtBQTFCLEdBQWtDRCxDQUFDLENBQUNFLE1BQUYsQ0FBU0MsUUFBM0MsR0FBc0QsTUFBdEQs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TUFBTSxHQUFHQyxNQUFULEVBQXhCLEdBQTRDLEtBQW5EO0FBQ0gsT0FITCxFQUlLQyxXQUpMLENBSWlCLGVBSmpCLEVBS0tDLFFBTEwsQ0FLYyxlQUxkLEVBTUtDLFNBTkwsQ0FNZWIsQ0FBQyxDQUFDLFdBQUQsQ0FBRCxDQUFlLENBQWYsRUFBa0JjLFlBTmpDO0FBT0gsS0FSRCxNQVFPO0FBQ0hkLE1BQUFBLENBQUMsQ0FBQyxXQUFELENBQUQsQ0FDS00sR0FETCxDQUNTLFVBQVNDLENBQVQsRUFBWUMsQ0FBWixFQUFlO0FBQ2hCLGVBQU9BLENBQUMsR0FBRyxtQkFBSixHQUEwQkMsTUFBTSxHQUFHQyxNQUFULEVBQTFCLEdBQThDLEtBQXJEO0FBQ0gsT0FITCxFQUlLRSxRQUpMLENBSWMsZUFKZCxFQUtLRCxXQUxMLENBS2lCLGVBTGpCLEVBTUtFLFNBTkwsQ0FNZWIsQ0FBQyxDQUFDLFdBQUQsQ0FBRCxDQUFlLENBQWYsRUFBa0JjLFlBTmpDO0FBT0gsS0ExR3VCLENBNEd4Qjs7O0FBQ0FkLElBQUFBLENBQUMsQ0FBQyxZQUFELENBQUQsQ0FBZ0J1QixJQUFoQixDQUFxQkUsU0FBUyxHQUFHLElBQWpDO0FBRUgsR0EvR0Q7O0FBaUhBLFNBQU87QUFDSDtBQUNBRSxJQUFBQSxJQUFJLEVBQUUsZ0JBQVc7QUFDYjdCLE1BQUFBLFVBQVU7O0FBQ1YwQixNQUFBQSxVQUFVO0FBQ2I7QUFMRSxHQUFQO0FBT0gsQ0F2UHFCLEVBQXRCOztBQXlQQUksTUFBTSxDQUFDM0IsUUFBRCxDQUFOLENBQWlCNEIsS0FBakIsQ0FBdUIsWUFBVztBQUM5QmhDLEVBQUFBLGVBQWUsQ0FBQzhCLElBQWhCO0FBQ0gsQ0FGRCIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9tZXRyb25pYy9qcy9wYWdlcy9mZWF0dXJlcy9taXNjZWxsYW5lb3VzL2lkbGUtdGltZXIuanM/YzkyZiJdLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcblxudmFyIEtUSWRsZVRpbWVyRGVtbyA9IGZ1bmN0aW9uKCkge1xuICAgIHZhciBfaW5pdERlbW8xID0gZnVuY3Rpb24oKSB7XG4gICAgICAgIC8vRGVmaW5lIGRlZmF1bHRcbiAgICAgICAgdmFyIGRvY1RpbWVvdXQgPSA1MDAwO1xuXG4gICAgICAgIC8qXG4gICAgICAgIEhhbmRsZSByYWlzZWQgaWRsZS9hY3RpdmUgZXZlbnRzXG4gICAgICAgICovXG4gICAgICAgICQoZG9jdW1lbnQpLm9uKFwiaWRsZS5pZGxlVGltZXJcIiwgZnVuY3Rpb24oZXZlbnQsIGVsZW0sIG9iaikge1xuICAgICAgICAgICAgJChcIiNkb2NTdGF0dXNcIilcbiAgICAgICAgICAgICAgICAudmFsKGZ1bmN0aW9uKGksIHYpIHtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHYgKyBcIklkbGUgQCBcIiArIG1vbWVudCgpLmZvcm1hdCgpICsgXCIgXFxuXCI7XG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAucmVtb3ZlQ2xhc3MoXCJhbGVydC1zdWNjZXNzXCIpXG4gICAgICAgICAgICAgICAgLmFkZENsYXNzKFwiYWxlcnQtd2FybmluZ1wiKVxuICAgICAgICAgICAgICAgIC5zY3JvbGxUb3AoJChcIiNkb2NTdGF0dXNcIilbMF0uc2Nyb2xsSGVpZ2h0KTtcbiAgICAgICAgfSk7XG4gICAgICAgICQoZG9jdW1lbnQpLm9uKFwiYWN0aXZlLmlkbGVUaW1lclwiLCBmdW5jdGlvbihldmVudCwgZWxlbSwgb2JqLCBlKSB7XG4gICAgICAgICAgICAkKFwiI2RvY1N0YXR1c1wiKVxuICAgICAgICAgICAgICAgIC52YWwoZnVuY3Rpb24oaSwgdikge1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gdiArIFwiQWN0aXZlIFtcIiArIGUudHlwZSArIFwiXSBbXCIgKyBlLnRhcmdldC5ub2RlTmFtZSArIFwiXSBAIFwiICsgbW9tZW50KCkuZm9ybWF0KCkgKyBcIiBcXG5cIjtcbiAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgIC5hZGRDbGFzcyhcImFsZXJ0LXN1Y2Nlc3NcIilcbiAgICAgICAgICAgICAgICAucmVtb3ZlQ2xhc3MoXCJhbGVydC13YXJuaW5nXCIpXG4gICAgICAgICAgICAgICAgLnNjcm9sbFRvcCgkKFwiI2RvY1N0YXR1c1wiKVswXS5zY3JvbGxIZWlnaHQpO1xuICAgICAgICB9KTtcblxuICAgICAgICAvKlxuICAgICAgICBIYW5kbGUgYnV0dG9uIGV2ZW50c1xuICAgICAgICAqL1xuICAgICAgICAkKFwiI2J0UGF1c2VcIikuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAkKGRvY3VtZW50KS5pZGxlVGltZXIoXCJwYXVzZVwiKTtcbiAgICAgICAgICAgICQoXCIjZG9jU3RhdHVzXCIpXG4gICAgICAgICAgICAgICAgLnZhbChmdW5jdGlvbihpLCB2KSB7XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiB2ICsgXCJQYXVzZWQgQCBcIiArIG1vbWVudCgpLmZvcm1hdCgpICsgXCIgXFxuXCI7XG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAuc2Nyb2xsVG9wKCQoXCIjZG9jU3RhdHVzXCIpWzBdLnNjcm9sbEhlaWdodCk7XG4gICAgICAgICAgICAkKHRoaXMpLmJsdXIoKTtcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgfSk7XG4gICAgICAgICQoXCIjYnRSZXN1bWVcIikuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAkKGRvY3VtZW50KS5pZGxlVGltZXIoXCJyZXN1bWVcIik7XG4gICAgICAgICAgICAkKFwiI2RvY1N0YXR1c1wiKVxuICAgICAgICAgICAgICAgIC52YWwoZnVuY3Rpb24oaSwgdikge1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gdiArIFwiUmVzdW1lZCBAIFwiICsgbW9tZW50KCkuZm9ybWF0KCkgKyBcIiBcXG5cIjtcbiAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgIC5zY3JvbGxUb3AoJChcIiNkb2NTdGF0dXNcIilbMF0uc2Nyb2xsSGVpZ2h0KTtcbiAgICAgICAgICAgICQodGhpcykuYmx1cigpO1xuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICB9KTtcbiAgICAgICAgJChcIiNidEVsYXBzZWRcIikuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAkKFwiI2RvY1N0YXR1c1wiKVxuICAgICAgICAgICAgICAgIC52YWwoZnVuY3Rpb24oaSwgdikge1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gdiArIFwiRWxhcHNlZCAoc2luY2UgYmVjb21pbmcgYWN0aXZlKTogXCIgKyAkKGRvY3VtZW50KS5pZGxlVGltZXIoXCJnZXRFbGFwc2VkVGltZVwiKSArIFwiIFxcblwiO1xuICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgLnNjcm9sbFRvcCgkKFwiI2RvY1N0YXR1c1wiKVswXS5zY3JvbGxIZWlnaHQpO1xuICAgICAgICAgICAgJCh0aGlzKS5ibHVyKCk7XG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgIH0pO1xuICAgICAgICAkKFwiI2J0RGVzdHJveVwiKS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICQoZG9jdW1lbnQpLmlkbGVUaW1lcihcImRlc3Ryb3lcIik7XG4gICAgICAgICAgICAkKFwiI2RvY1N0YXR1c1wiKVxuICAgICAgICAgICAgICAgIC52YWwoZnVuY3Rpb24oaSwgdikge1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gdiArIFwiRGVzdHJveWVkOiBAIFwiICsgbW9tZW50KCkuZm9ybWF0KCkgKyBcIiBcXG5cIjtcbiAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgIC5yZW1vdmVDbGFzcyhcImFsZXJ0LXN1Y2Nlc3NcIilcbiAgICAgICAgICAgICAgICAucmVtb3ZlQ2xhc3MoXCJhbGVydC13YXJuaW5nXCIpXG4gICAgICAgICAgICAgICAgLnNjcm9sbFRvcCgkKFwiI2RvY1N0YXR1c1wiKVswXS5zY3JvbGxIZWlnaHQpO1xuICAgICAgICAgICAgJCh0aGlzKS5ibHVyKCk7XG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgIH0pO1xuICAgICAgICAkKFwiI2J0SW5pdFwiKS5jbGljayhmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIC8vIGZvciBkZW1vIHB1cnBvc2VzIHNob3cgaW5pdCB3aXRoIGp1c3Qgb2JqZWN0XG4gICAgICAgICAgICAkKGRvY3VtZW50KS5pZGxlVGltZXIoe1xuICAgICAgICAgICAgICAgIHRpbWVvdXQ6IGRvY1RpbWVvdXRcbiAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgJChcIiNkb2NTdGF0dXNcIilcbiAgICAgICAgICAgICAgICAudmFsKGZ1bmN0aW9uKGksIHYpIHtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIHYgKyBcIkluaXQ6IEAgXCIgKyBtb21lbnQoKS5mb3JtYXQoKSArIFwiIFxcblwiO1xuICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgLnNjcm9sbFRvcCgkKFwiI2RvY1N0YXR1c1wiKVswXS5zY3JvbGxIZWlnaHQpO1xuXG4gICAgICAgICAgICAvL0FwcGx5IGNsYXNzZXMgZm9yIGRlZmF1bHQgc3RhdGVcbiAgICAgICAgICAgIGlmICgkKGRvY3VtZW50KS5pZGxlVGltZXIoXCJpc0lkbGVcIikpIHtcbiAgICAgICAgICAgICAgICAkKFwiI2RvY1N0YXR1c1wiKVxuICAgICAgICAgICAgICAgICAgICAucmVtb3ZlQ2xhc3MoXCJhbGVydC1zdWNjZXNzXCIpXG4gICAgICAgICAgICAgICAgICAgIC5hZGRDbGFzcyhcImFsZXJ0LXdhcm5pbmdcIik7XG4gICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICQoXCIjZG9jU3RhdHVzXCIpXG4gICAgICAgICAgICAgICAgICAgIC5hZGRDbGFzcyhcImFsZXJ0LXN1Y2Nlc3NcIilcbiAgICAgICAgICAgICAgICAgICAgLnJlbW92ZUNsYXNzKFwiYWxlcnQtd2FybmluZ1wiKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgICQodGhpcykuYmx1cigpO1xuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICB9KTtcblxuICAgICAgICAvL0NsZWFyIG9sZCBzdGF0dXNlc1xuICAgICAgICAkKFwiI2RvY1N0YXR1c1wiKS52YWwoXCJcIik7XG5cbiAgICAgICAgLy9TdGFydCB0aW1lb3V0LCBwYXNzaW5nIG5vIG9wdGlvbnNcbiAgICAgICAgLy9TYW1lIGFzICQuaWRsZVRpbWVyKGRvY1RpbWVvdXQsIGRvY09wdGlvbnMpO1xuICAgICAgICAkKGRvY3VtZW50KS5pZGxlVGltZXIoZG9jVGltZW91dCk7XG5cbiAgICAgICAgLy9Gb3IgZGVtbyBwdXJwb3Nlcywgc3R5bGUgYmFzZWQgb24gaW5pdGlhbCBzdGF0ZVxuICAgICAgICBpZiAoJChkb2N1bWVudCkuaWRsZVRpbWVyKFwiaXNJZGxlXCIpKSB7XG4gICAgICAgICAgICAkKFwiI2RvY1N0YXR1c1wiKVxuICAgICAgICAgICAgICAgIC52YWwoZnVuY3Rpb24oaSwgdikge1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gdiArIFwiSW5pdGlhbCBJZGxlIFN0YXRlIEAgXCIgKyBtb21lbnQoKS5mb3JtYXQoKSArIFwiIFxcblwiO1xuICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgLnJlbW92ZUNsYXNzKFwiYWxlcnQtc3VjY2Vzc1wiKVxuICAgICAgICAgICAgICAgIC5hZGRDbGFzcyhcImFsZXJ0LXdhcm5pbmdcIilcbiAgICAgICAgICAgICAgICAuc2Nyb2xsVG9wKCQoXCIjZG9jU3RhdHVzXCIpWzBdLnNjcm9sbEhlaWdodCk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAkKFwiI2RvY1N0YXR1c1wiKVxuICAgICAgICAgICAgICAgIC52YWwoZnVuY3Rpb24oaSwgdikge1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gdiArIFwiSW5pdGlhbCBBY3RpdmUgU3RhdGUgQCBcIiArIG1vbWVudCgpLmZvcm1hdCgpICsgXCIgXFxuXCI7XG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAuYWRkQ2xhc3MoXCJhbGVydC1zdWNjZXNzXCIpXG4gICAgICAgICAgICAgICAgLnJlbW92ZUNsYXNzKFwiYWxlcnQtd2FybmluZ1wiKVxuICAgICAgICAgICAgICAgIC5zY3JvbGxUb3AoJChcIiNkb2NTdGF0dXNcIilbMF0uc2Nyb2xsSGVpZ2h0KTtcbiAgICAgICAgfVxuXG5cbiAgICAgICAgLy9Gb3IgZGVtbyBwdXJwb3NlcywgZGlzcGxheSB0aGUgYWN0dWFsIHRpbWVvdXQgb24gdGhlIHBhZ2VcbiAgICAgICAgJChcIiNkb2NUaW1lb3V0XCIpLnRleHQoZG9jVGltZW91dCAvIDEwMDApO1xuICAgIH1cblxuICAgIHZhciBfaW5pdERlbW8yID0gZnVuY3Rpb24oKSB7XG4gICAgICAgIC8vRGVmaW5lIHRleHRhcmVhIHNldHRpbmdzXG4gICAgICAgIHZhclxuICAgICAgICAgICAgdGFUaW1lb3V0ID0gMzAwMDtcblxuICAgICAgICAvKlxuICAgICAgICBIYW5kbGUgcmFpc2VkIGlkbGUvYWN0aXZlIGV2ZW50c1xuICAgICAgICAqL1xuICAgICAgICAkKFwiI2VsU3RhdHVzXCIpLm9uKFwiaWRsZS5pZGxlVGltZXJcIiwgZnVuY3Rpb24oZXZlbnQsIGVsZW0sIG9iaikge1xuICAgICAgICAgICAgLy9JZiB5b3UgZG9udCBzdG9wIHByb3BhZ2F0aW9uIGl0IHdpbGwgYnViYmxlIHVwIHRvIGRvY3VtZW50IGV2ZW50IGhhbmRsZXJcbiAgICAgICAgICAgIGV2ZW50LnN0b3BQcm9wYWdhdGlvbigpO1xuXG4gICAgICAgICAgICAkKFwiI2VsU3RhdHVzXCIpXG4gICAgICAgICAgICAgICAgLnZhbChmdW5jdGlvbihpLCB2KSB7XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiB2ICsgXCJJZGxlIEAgXCIgKyBtb21lbnQoKS5mb3JtYXQoKSArIFwiIFxcblwiO1xuICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgLnJlbW92ZUNsYXNzKFwiYWxlcnQtc3VjY2Vzc1wiKVxuICAgICAgICAgICAgICAgIC5hZGRDbGFzcyhcImFsZXJ0LXdhcm5pbmdcIilcbiAgICAgICAgICAgICAgICAuc2Nyb2xsVG9wKCQoXCIjZWxTdGF0dXNcIilbMF0uc2Nyb2xsSGVpZ2h0KTtcblxuICAgICAgICB9KTtcbiAgICAgICAgJChcIiNlbFN0YXR1c1wiKS5vbihcImFjdGl2ZS5pZGxlVGltZXJcIiwgZnVuY3Rpb24oZXZlbnQpIHtcbiAgICAgICAgICAgIC8vSWYgeW91IGRvbnQgc3RvcCBwcm9wYWdhdGlvbiBpdCB3aWxsIGJ1YmJsZSB1cCB0byBkb2N1bWVudCBldmVudCBoYW5kbGVyXG4gICAgICAgICAgICBldmVudC5zdG9wUHJvcGFnYXRpb24oKTtcblxuICAgICAgICAgICAgJChcIiNlbFN0YXR1c1wiKVxuICAgICAgICAgICAgICAgIC52YWwoZnVuY3Rpb24oaSwgdikge1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gdiArIFwiQWN0aXZlIEAgXCIgKyBtb21lbnQoKS5mb3JtYXQoKSArIFwiIFxcblwiO1xuICAgICAgICAgICAgICAgIH0pXG4gICAgICAgICAgICAgICAgLmFkZENsYXNzKFwiYWxlcnQtc3VjY2Vzc1wiKVxuICAgICAgICAgICAgICAgIC5yZW1vdmVDbGFzcyhcImFsZXJ0LXdhcm5pbmdcIilcbiAgICAgICAgICAgICAgICAuc2Nyb2xsVG9wKCQoXCIjZWxTdGF0dXNcIilbMF0uc2Nyb2xsSGVpZ2h0KTtcbiAgICAgICAgfSk7XG5cbiAgICAgICAgLypcbiAgICAgICAgSGFuZGxlIGJ1dHRvbiBldmVudHNcbiAgICAgICAgKi9cbiAgICAgICAgJChcIiNidFJlc2V0XCIpLmNsaWNrKGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgJChcIiNlbFN0YXR1c1wiKVxuICAgICAgICAgICAgICAgIC5pZGxlVGltZXIoXCJyZXNldFwiKVxuICAgICAgICAgICAgICAgIC52YWwoZnVuY3Rpb24oaSwgdikge1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gdiArIFwiUmVzZXQgQCBcIiArIG1vbWVudCgpLmZvcm1hdCgpICsgXCIgXFxuXCI7XG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAuc2Nyb2xsVG9wKCQoXCIjZWxTdGF0dXNcIilbMF0uc2Nyb2xsSGVpZ2h0KTtcblxuICAgICAgICAgICAgLy9BcHBseSBjbGFzc2VzIGZvciBkZWZhdWx0IHN0YXRlXG4gICAgICAgICAgICBpZiAoJChcIiNlbFN0YXR1c1wiKS5pZGxlVGltZXIoXCJpc0lkbGVcIikpIHtcbiAgICAgICAgICAgICAgICAkKFwiI2VsU3RhdHVzXCIpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVDbGFzcyhcImFsZXJ0LXN1Y2Nlc3NcIilcbiAgICAgICAgICAgICAgICAgICAgLmFkZENsYXNzKFwiYWxlcnQtd2FybmluZ1wiKTtcbiAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgJChcIiNlbFN0YXR1c1wiKVxuICAgICAgICAgICAgICAgICAgICAuYWRkQ2xhc3MoXCJhbGVydC1zdWNjZXNzXCIpXG4gICAgICAgICAgICAgICAgICAgIC5yZW1vdmVDbGFzcyhcImFsZXJ0LXdhcm5pbmdcIik7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICAkKHRoaXMpLmJsdXIoKTtcbiAgICAgICAgICAgIHJldHVybiBmYWxzZTtcbiAgICAgICAgfSk7XG4gICAgICAgICQoXCIjYnRSZW1haW5pbmdcIikuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAkKFwiI2VsU3RhdHVzXCIpXG4gICAgICAgICAgICAgICAgLnZhbChmdW5jdGlvbihpLCB2KSB7XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiB2ICsgXCJSZW1haW5pbmc6IFwiICsgJChcIiNlbFN0YXR1c1wiKS5pZGxlVGltZXIoXCJnZXRSZW1haW5pbmdUaW1lXCIpICsgXCIgXFxuXCI7XG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAuc2Nyb2xsVG9wKCQoXCIjZWxTdGF0dXNcIilbMF0uc2Nyb2xsSGVpZ2h0KTtcbiAgICAgICAgICAgICQodGhpcykuYmx1cigpO1xuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICB9KTtcbiAgICAgICAgJChcIiNidExhc3RBY3RpdmVcIikuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAkKFwiI2VsU3RhdHVzXCIpXG4gICAgICAgICAgICAgICAgLnZhbChmdW5jdGlvbihpLCB2KSB7XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiB2ICsgXCJMYXN0QWN0aXZlOiBcIiArICQoXCIjZWxTdGF0dXNcIikuaWRsZVRpbWVyKFwiZ2V0TGFzdEFjdGl2ZVRpbWVcIikgKyBcIiBcXG5cIjtcbiAgICAgICAgICAgICAgICB9KVxuICAgICAgICAgICAgICAgIC5zY3JvbGxUb3AoJChcIiNlbFN0YXR1c1wiKVswXS5zY3JvbGxIZWlnaHQpO1xuICAgICAgICAgICAgJCh0aGlzKS5ibHVyKCk7XG4gICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgIH0pO1xuICAgICAgICAkKFwiI2J0U3RhdGVcIikuY2xpY2soZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAkKFwiI2VsU3RhdHVzXCIpXG4gICAgICAgICAgICAgICAgLnZhbChmdW5jdGlvbihpLCB2KSB7XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiB2ICsgXCJTdGF0ZTogXCIgKyAoJChcIiNlbFN0YXR1c1wiKS5pZGxlVGltZXIoXCJpc0lkbGVcIikgPyBcImlkbGVcIiA6IFwiYWN0aXZlXCIpICsgXCIgXFxuXCI7XG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAuc2Nyb2xsVG9wKCQoXCIjZWxTdGF0dXNcIilbMF0uc2Nyb2xsSGVpZ2h0KTtcbiAgICAgICAgICAgICQodGhpcykuYmx1cigpO1xuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICB9KTtcblxuICAgICAgICAvL0NsZWFyIHZhbHVlIGlmIHRoZXJlIHdhcyBvbmUgY2FjaGVkICYgc3RhcnQgdGltZVxuICAgICAgICAkKFwiI2VsU3RhdHVzXCIpLnZhbChcIlwiKS5pZGxlVGltZXIodGFUaW1lb3V0KTtcblxuICAgICAgICAvL0ZvciBkZW1vIHB1cnBvc2VzLCBzaG93IGluaXRpYWwgc3RhdGVcbiAgICAgICAgaWYgKCQoXCIjZWxTdGF0dXNcIikuaWRsZVRpbWVyKFwiaXNJZGxlXCIpKSB7XG4gICAgICAgICAgICAkKFwiI2VsU3RhdHVzXCIpXG4gICAgICAgICAgICAgICAgLnZhbChmdW5jdGlvbihpLCB2KSB7XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiB2ICsgXCJJbml0aWFsIElkbGUgQCBcIiArIG1vbWVudCgpLmZvcm1hdCgpICsgXCIgXFxuXCI7XG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAucmVtb3ZlQ2xhc3MoXCJhbGVydC1zdWNjZXNzXCIpXG4gICAgICAgICAgICAgICAgLmFkZENsYXNzKFwiYWxlcnQtd2FybmluZ1wiKVxuICAgICAgICAgICAgICAgIC5zY3JvbGxUb3AoJChcIiNlbFN0YXR1c1wiKVswXS5zY3JvbGxIZWlnaHQpO1xuICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgJChcIiNlbFN0YXR1c1wiKVxuICAgICAgICAgICAgICAgIC52YWwoZnVuY3Rpb24oaSwgdikge1xuICAgICAgICAgICAgICAgICAgICByZXR1cm4gdiArIFwiSW5pdGlhbCBBY3RpdmUgQCBcIiArIG1vbWVudCgpLmZvcm1hdCgpICsgXCIgXFxuXCI7XG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAuYWRkQ2xhc3MoXCJhbGVydC1zdWNjZXNzXCIpXG4gICAgICAgICAgICAgICAgLnJlbW92ZUNsYXNzKFwiYWxlcnQtd2FybmluZ1wiKVxuICAgICAgICAgICAgICAgIC5zY3JvbGxUb3AoJChcIiNlbFN0YXR1c1wiKVswXS5zY3JvbGxIZWlnaHQpO1xuICAgICAgICB9XG5cbiAgICAgICAgLy8gRGlzcGxheSB0aGUgYWN0dWFsIHRpbWVvdXQgb24gdGhlIHBhZ2VcbiAgICAgICAgJChcIiNlbFRpbWVvdXRcIikudGV4dCh0YVRpbWVvdXQgLyAxMDAwKTtcblxuICAgIH1cblxuICAgIHJldHVybiB7XG4gICAgICAgIC8vbWFpbiBmdW5jdGlvbiB0byBpbml0aWF0ZSB0aGUgbW9kdWxlXG4gICAgICAgIGluaXQ6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgX2luaXREZW1vMSgpO1xuICAgICAgICAgICAgX2luaXREZW1vMigpO1xuICAgICAgICB9XG4gICAgfTtcbn0oKTtcblxualF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcbiAgICBLVElkbGVUaW1lckRlbW8uaW5pdCgpO1xufSk7XG4iXSwibmFtZXMiOlsiS1RJZGxlVGltZXJEZW1vIiwiX2luaXREZW1vMSIsImRvY1RpbWVvdXQiLCIkIiwiZG9jdW1lbnQiLCJvbiIsImV2ZW50IiwiZWxlbSIsIm9iaiIsInZhbCIsImkiLCJ2IiwibW9tZW50IiwiZm9ybWF0IiwicmVtb3ZlQ2xhc3MiLCJhZGRDbGFzcyIsInNjcm9sbFRvcCIsInNjcm9sbEhlaWdodCIsImUiLCJ0eXBlIiwidGFyZ2V0Iiwibm9kZU5hbWUiLCJjbGljayIsImlkbGVUaW1lciIsImJsdXIiLCJ0aW1lb3V0IiwidGV4dCIsIl9pbml0RGVtbzIiLCJ0YVRpbWVvdXQiLCJzdG9wUHJvcGFnYXRpb24iLCJpbml0IiwialF1ZXJ5IiwicmVhZHkiXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/metronic/js/pages/features/miscellaneous/idle-timer.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/metronic/js/pages/features/miscellaneous/idle-timer.js"]();
/******/ 	
/******/ })()
;