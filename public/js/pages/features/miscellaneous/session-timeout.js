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

/***/ "./resources/metronic/js/pages/features/miscellaneous/session-timeout.js":
/*!*******************************************************************************!*\
  !*** ./resources/metronic/js/pages/features/miscellaneous/session-timeout.js ***!
  \*******************************************************************************/
/***/ (() => {

eval("\n\nvar KTSessionTimeoutDemo = function () {\n  var initDemo = function initDemo() {\n    $.sessionTimeout({\n      title: 'Session Timeout Notification',\n      message: 'Your session is about to expire.',\n      keepAliveUrl: HOST_URL + '/api//session-timeout/keepalive.php',\n      redirUrl: '?p=page_user_lock_1',\n      logoutUrl: '?p=page_user_login_1',\n      warnAfter: 5000,\n      //warn after 5 seconds\n      redirAfter: 15000,\n      //redirect after 15 secons,\n      ignoreUserActivity: true,\n      countdownMessage: 'Redirecting in {timer} seconds.',\n      countdownBar: true\n    });\n  };\n\n  return {\n    //main function to initiate the module\n    init: function init() {\n      initDemo();\n    }\n  };\n}();\n\njQuery(document).ready(function () {\n  KTSessionTimeoutDemo.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvZmVhdHVyZXMvbWlzY2VsbGFuZW91cy9zZXNzaW9uLXRpbWVvdXQuanMuanMiLCJtYXBwaW5ncyI6IkFBQWE7O0FBRWIsSUFBSUEsb0JBQW9CLEdBQUcsWUFBWTtBQUNuQyxNQUFJQyxRQUFRLEdBQUcsU0FBWEEsUUFBVyxHQUFZO0FBQ3ZCQyxJQUFBQSxDQUFDLENBQUNDLGNBQUYsQ0FBaUI7QUFDYkMsTUFBQUEsS0FBSyxFQUFFLDhCQURNO0FBRWJDLE1BQUFBLE9BQU8sRUFBRSxrQ0FGSTtBQUdiQyxNQUFBQSxZQUFZLEVBQUVDLFFBQVEsR0FBRyxxQ0FIWjtBQUliQyxNQUFBQSxRQUFRLEVBQUUscUJBSkc7QUFLYkMsTUFBQUEsU0FBUyxFQUFFLHNCQUxFO0FBTWJDLE1BQUFBLFNBQVMsRUFBRSxJQU5FO0FBTUk7QUFDakJDLE1BQUFBLFVBQVUsRUFBRSxLQVBDO0FBT007QUFDbkJDLE1BQUFBLGtCQUFrQixFQUFFLElBUlA7QUFTYkMsTUFBQUEsZ0JBQWdCLEVBQUUsaUNBVEw7QUFVYkMsTUFBQUEsWUFBWSxFQUFFO0FBVkQsS0FBakI7QUFZSCxHQWJEOztBQWVBLFNBQU87QUFDSDtBQUNBQyxJQUFBQSxJQUFJLEVBQUUsZ0JBQVk7QUFDZGQsTUFBQUEsUUFBUTtBQUNYO0FBSkUsR0FBUDtBQU1ILENBdEIwQixFQUEzQjs7QUF3QkFlLE1BQU0sQ0FBQ0MsUUFBRCxDQUFOLENBQWlCQyxLQUFqQixDQUF1QixZQUFXO0FBQzlCbEIsRUFBQUEsb0JBQW9CLENBQUNlLElBQXJCO0FBQ0gsQ0FGRCIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9tZXRyb25pYy9qcy9wYWdlcy9mZWF0dXJlcy9taXNjZWxsYW5lb3VzL3Nlc3Npb24tdGltZW91dC5qcz9jZGUxIl0sInNvdXJjZXNDb250ZW50IjpbIlwidXNlIHN0cmljdFwiO1xuXG52YXIgS1RTZXNzaW9uVGltZW91dERlbW8gPSBmdW5jdGlvbiAoKSB7XG4gICAgdmFyIGluaXREZW1vID0gZnVuY3Rpb24gKCkge1xuICAgICAgICAkLnNlc3Npb25UaW1lb3V0KHtcbiAgICAgICAgICAgIHRpdGxlOiAnU2Vzc2lvbiBUaW1lb3V0IE5vdGlmaWNhdGlvbicsXG4gICAgICAgICAgICBtZXNzYWdlOiAnWW91ciBzZXNzaW9uIGlzIGFib3V0IHRvIGV4cGlyZS4nLFxuICAgICAgICAgICAga2VlcEFsaXZlVXJsOiBIT1NUX1VSTCArICcvYXBpLy9zZXNzaW9uLXRpbWVvdXQva2VlcGFsaXZlLnBocCcsXG4gICAgICAgICAgICByZWRpclVybDogJz9wPXBhZ2VfdXNlcl9sb2NrXzEnLFxuICAgICAgICAgICAgbG9nb3V0VXJsOiAnP3A9cGFnZV91c2VyX2xvZ2luXzEnLFxuICAgICAgICAgICAgd2FybkFmdGVyOiA1MDAwLCAvL3dhcm4gYWZ0ZXIgNSBzZWNvbmRzXG4gICAgICAgICAgICByZWRpckFmdGVyOiAxNTAwMCwgLy9yZWRpcmVjdCBhZnRlciAxNSBzZWNvbnMsXG4gICAgICAgICAgICBpZ25vcmVVc2VyQWN0aXZpdHk6IHRydWUsXG4gICAgICAgICAgICBjb3VudGRvd25NZXNzYWdlOiAnUmVkaXJlY3RpbmcgaW4ge3RpbWVyfSBzZWNvbmRzLicsXG4gICAgICAgICAgICBjb3VudGRvd25CYXI6IHRydWVcbiAgICAgICAgfSk7XG4gICAgfVxuXG4gICAgcmV0dXJuIHtcbiAgICAgICAgLy9tYWluIGZ1bmN0aW9uIHRvIGluaXRpYXRlIHRoZSBtb2R1bGVcbiAgICAgICAgaW5pdDogZnVuY3Rpb24gKCkge1xuICAgICAgICAgICAgaW5pdERlbW8oKTtcbiAgICAgICAgfVxuICAgIH07XG59KCk7XG5cbmpRdWVyeShkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24oKSB7XG4gICAgS1RTZXNzaW9uVGltZW91dERlbW8uaW5pdCgpO1xufSk7XG4iXSwibmFtZXMiOlsiS1RTZXNzaW9uVGltZW91dERlbW8iLCJpbml0RGVtbyIsIiQiLCJzZXNzaW9uVGltZW91dCIsInRpdGxlIiwibWVzc2FnZSIsImtlZXBBbGl2ZVVybCIsIkhPU1RfVVJMIiwicmVkaXJVcmwiLCJsb2dvdXRVcmwiLCJ3YXJuQWZ0ZXIiLCJyZWRpckFmdGVyIiwiaWdub3JlVXNlckFjdGl2aXR5IiwiY291bnRkb3duTWVzc2FnZSIsImNvdW50ZG93bkJhciIsImluaXQiLCJqUXVlcnkiLCJkb2N1bWVudCIsInJlYWR5Il0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/metronic/js/pages/features/miscellaneous/session-timeout.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/metronic/js/pages/features/miscellaneous/session-timeout.js"]();
/******/ 	
/******/ })()
;