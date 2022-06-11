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

/***/ "./resources/metronic/js/pages/custom/todo/todo.js":
/*!*********************************************************!*\
  !*** ./resources/metronic/js/pages/custom/todo/todo.js ***!
  \*********************************************************/
/***/ (() => {

eval(" // Class definition\n\nvar KTAppTodo = function () {\n  // Private properties\n  var _asideEl;\n\n  var _listEl;\n\n  var _viewEl;\n\n  var _replyEl;\n\n  var _asideOffcanvas; // Private methods\n\n\n  var _initEditor = function _initEditor(form, editor) {\n    // init editor\n    var options = {\n      modules: {\n        toolbar: {}\n      },\n      placeholder: 'Type message...',\n      theme: 'snow'\n    };\n\n    if (!KTUtil.getById(editor)) {\n      return;\n    } // Init editor\n\n\n    var editor = new Quill('#' + editor, options); // Customize editor\n\n    var toolbar = KTUtil.find(form, '.ql-toolbar');\n    var editor = KTUtil.find(form, '.ql-editor');\n\n    if (toolbar) {\n      KTUtil.addClass(toolbar, 'px-5 border-top-0 border-left-0 border-right-0');\n    }\n\n    if (editor) {\n      KTUtil.addClass(editor, 'px-8');\n    }\n  };\n\n  var _initAttachments = function _initAttachments(elemId) {\n    if (!KTUtil.getById(elemId)) {\n      return;\n    }\n\n    var id = \"#\" + elemId;\n    var previewNode = $(id + \" .dropzone-item\");\n    previewNode.id = \"\";\n    var previewTemplate = previewNode.parent('.dropzone-items').html();\n    previewNode.remove();\n    var myDropzone = new Dropzone(id, {\n      // Make the whole body a dropzone\n      url: \"https://keenthemes.com/scripts/void.php\",\n      // Set the url for your upload script location\n      parallelUploads: 20,\n      maxFilesize: 1,\n      // Max filesize in MB\n      previewTemplate: previewTemplate,\n      previewsContainer: id + \" .dropzone-items\",\n      // Define the container to display the previews\n      clickable: id + \"_select\" // Define the element that should be used as click trigger to select files.\n\n    });\n    myDropzone.on(\"addedfile\", function (file) {\n      // Hookup the start button\n      $(document).find(id + ' .dropzone-item').css('display', '');\n    }); // Update the total progress bar\n\n    myDropzone.on(\"totaluploadprogress\", function (progress) {\n      document.querySelector(id + \" .progress-bar\").style.width = progress + \"%\";\n    });\n    myDropzone.on(\"sending\", function (file) {\n      // Show the total progress bar when upload starts\n      document.querySelector(id + \" .progress-bar\").style.opacity = \"1\";\n    }); // Hide the total progress bar when nothing's uploading anymore\n\n    myDropzone.on(\"complete\", function (progress) {\n      var thisProgressBar = id + \" .dz-complete\";\n      setTimeout(function () {\n        $(thisProgressBar + \" .progress-bar, \" + thisProgressBar + \" .progress\").css('opacity', '0');\n      }, 300);\n    });\n  }; // Public methods\n\n\n  return {\n    // Public functions\n    init: function init() {\n      // Init variables\n      _asideEl = KTUtil.getById('kt_todo_aside');\n      _listEl = KTUtil.getById('kt_todo_list');\n      _viewEl = KTUtil.getById('kt_todo_view');\n      _replyEl = KTUtil.getById('kt_todo_reply'); // Init handlers\n\n      KTAppTodo.initAside();\n      KTAppTodo.initList();\n      KTAppTodo.initView();\n      KTAppTodo.initReply();\n    },\n    initAside: function initAside() {\n      // Mobile offcanvas for mobile mode\n      _asideOffcanvas = new KTOffcanvas(_asideEl, {\n        overlay: true,\n        baseClass: 'offcanvas-mobile',\n        //closeBy: 'kt_todo_aside_close',\n        toggleBy: 'kt_subheader_mobile_toggle'\n      }); // View list\n\n      KTUtil.on(_asideEl, '.list-item[data-action=\"list\"]', 'click', function (e) {\n        var type = KTUtil.attr(this, 'data-type');\n        var listItemsEl = KTUtil.find(_listEl, '.kt-inbox__items');\n        var navItemEl = this.closest('.kt-nav__item');\n        var navItemActiveEl = KTUtil.find(_asideEl, '.kt-nav__item.kt-nav__item--active'); // demo loading\n\n        var loading = new KTDialog({\n          'type': 'loader',\n          'placement': 'top center',\n          'message': 'Loading ...'\n        });\n        loading.show();\n        setTimeout(function () {\n          loading.hide();\n          KTUtil.css(_listEl, 'display', 'flex'); // show list\n\n          KTUtil.css(_viewEl, 'display', 'none'); // hide view\n\n          KTUtil.addClass(navItemEl, 'kt-nav__item--active');\n          KTUtil.removeClass(navItemActiveEl, 'kt-nav__item--active');\n          KTUtil.attr(listItemsEl, 'data-type', type);\n        }, 600);\n      });\n    },\n    initList: function initList() {\n      // Group selection\n      KTUtil.on(_listEl, '[data-inbox=\"group-select\"] input', 'click', function () {\n        var messages = KTUtil.findAll(_listEl, '[data-inbox=\"message\"]');\n\n        for (var i = 0, j = messages.length; i < j; i++) {\n          var message = messages[i];\n          var checkbox = KTUtil.find(message, '.checkbox input');\n          checkbox.checked = this.checked;\n\n          if (this.checked) {\n            KTUtil.addClass(message, 'active');\n          } else {\n            KTUtil.removeClass(message, 'active');\n          }\n        }\n      }); // Individual selection\n\n      KTUtil.on(_listEl, '[data-inbox=\"message\"] [data-inbox=\"actions\"] .checkbox input', 'click', function () {\n        var item = this.closest('[data-inbox=\"message\"]');\n\n        if (item && this.checked) {\n          KTUtil.addClass(item, 'active');\n        } else {\n          KTUtil.removeClass(item, 'active');\n        }\n      });\n    },\n    initView: function initView() {\n      // Back to listing\n      KTUtil.on(_viewEl, '[data-inbox=\"back\"]', 'click', function () {\n        // demo loading\n        var loading = new KTDialog({\n          'type': 'loader',\n          'placement': 'top center',\n          'message': 'Loading ...'\n        });\n        loading.show();\n        setTimeout(function () {\n          loading.hide();\n          KTUtil.addClass(_listEl, 'd-block');\n          KTUtil.removeClass(_listEl, 'd-none');\n          KTUtil.addClass(_viewEl, 'd-none');\n          KTUtil.removeClass(_viewEl, 'd-block');\n        }, 700);\n      }); // Expand/Collapse reply\n\n      KTUtil.on(_viewEl, '[data-inbox=\"message\"]', 'click', function (e) {\n        var message = this.closest('[data-inbox=\"message\"]');\n        var dropdownToggleEl = KTUtil.find(this, '[data-toggle=\"dropdown\"]');\n        var toolbarEl = KTUtil.find(this, '[data-inbox=\"toolbar\"]'); // skip dropdown toggle click\n\n        if (e.target === dropdownToggleEl || dropdownToggleEl && dropdownToggleEl.contains(e.target) === true) {\n          return false;\n        } // skip group actions click\n\n\n        if (e.target === toolbarEl || toolbarEl && toolbarEl.contains(e.target) === true) {\n          return false;\n        }\n\n        if (KTUtil.hasClass(message, 'toggle-on')) {\n          KTUtil.addClass(message, 'toggle-off');\n          KTUtil.removeClass(message, 'toggle-on');\n        } else {\n          KTUtil.removeClass(message, 'toggle-off');\n          KTUtil.addClass(message, 'toggle-on');\n        }\n      });\n    },\n    initReply: function initReply() {\n      _initEditor(_replyEl, 'kt_todo_reply_editor');\n\n      _initAttachments('kt_todo_reply_attachments');\n    }\n  };\n}(); // Class Initialization\n\n\njQuery(document).ready(function () {\n  KTAppTodo.init();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9yZXNvdXJjZXMvbWV0cm9uaWMvanMvcGFnZXMvY3VzdG9tL3RvZG8vdG9kby5qcy5qcyIsIm1hcHBpbmdzIjoiQ0FFQTs7QUFDQSxJQUFJQSxTQUFTLEdBQUcsWUFBVztBQUN2QjtBQUNBLE1BQUlDLFFBQUo7O0FBQ0EsTUFBSUMsT0FBSjs7QUFDQSxNQUFJQyxPQUFKOztBQUNBLE1BQUlDLFFBQUo7O0FBQ0EsTUFBSUMsZUFBSixDQU51QixDQVF2Qjs7O0FBQ0EsTUFBSUMsV0FBVyxHQUFHLFNBQWRBLFdBQWMsQ0FBU0MsSUFBVCxFQUFlQyxNQUFmLEVBQXVCO0FBQ3JDO0FBQ0EsUUFBSUMsT0FBTyxHQUFHO0FBQ1ZDLE1BQUFBLE9BQU8sRUFBRTtBQUNMQyxRQUFBQSxPQUFPLEVBQUU7QUFESixPQURDO0FBSVZDLE1BQUFBLFdBQVcsRUFBRSxpQkFKSDtBQUtWQyxNQUFBQSxLQUFLLEVBQUU7QUFMRyxLQUFkOztBQVFBLFFBQUksQ0FBQ0MsTUFBTSxDQUFDQyxPQUFQLENBQWVQLE1BQWYsQ0FBTCxFQUE2QjtBQUN6QjtBQUNILEtBWm9DLENBY3JDOzs7QUFDQSxRQUFJQSxNQUFNLEdBQUcsSUFBSVEsS0FBSixDQUFVLE1BQU1SLE1BQWhCLEVBQXdCQyxPQUF4QixDQUFiLENBZnFDLENBaUJyQzs7QUFDQSxRQUFJRSxPQUFPLEdBQUdHLE1BQU0sQ0FBQ0csSUFBUCxDQUFZVixJQUFaLEVBQWtCLGFBQWxCLENBQWQ7QUFDQSxRQUFJQyxNQUFNLEdBQUdNLE1BQU0sQ0FBQ0csSUFBUCxDQUFZVixJQUFaLEVBQWtCLFlBQWxCLENBQWI7O0FBRUEsUUFBSUksT0FBSixFQUFhO0FBQ1RHLE1BQUFBLE1BQU0sQ0FBQ0ksUUFBUCxDQUFnQlAsT0FBaEIsRUFBeUIsZ0RBQXpCO0FBQ0g7O0FBRUQsUUFBSUgsTUFBSixFQUFZO0FBQ1JNLE1BQUFBLE1BQU0sQ0FBQ0ksUUFBUCxDQUFnQlYsTUFBaEIsRUFBd0IsTUFBeEI7QUFDSDtBQUNKLEdBNUJEOztBQThCQSxNQUFJ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WUFBNUI7QUFDQTFELFVBQUFBLE1BQU0sQ0FBQ0ksUUFBUCxDQUFnQnNELE9BQWhCLEVBQXlCLFdBQXpCO0FBQ0g7QUFDSixPQXZCRDtBQXdCSCxLQXBJRTtBQXNJSHRCLElBQUFBLFNBQVMsRUFBRSxxQkFBVztBQUNsQjVDLE1BQUFBLFdBQVcsQ0FBQ0YsUUFBRCxFQUFXLHNCQUFYLENBQVg7O0FBQ0FlLE1BQUFBLGdCQUFnQixDQUFDLDJCQUFELENBQWhCO0FBQ0g7QUF6SUUsR0FBUDtBQTJJSCxDQS9OZSxFQUFoQixDLENBaU9BOzs7QUFDQThELE1BQU0sQ0FBQzVDLFFBQUQsQ0FBTixDQUFpQjZDLEtBQWpCLENBQXVCLFlBQVc7QUFDOUJsRixFQUFBQSxTQUFTLENBQUM4QyxJQUFWO0FBQ0gsQ0FGRCIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3Jlc291cmNlcy9tZXRyb25pYy9qcy9wYWdlcy9jdXN0b20vdG9kby90b2RvLmpzPzVhMGQiXSwic291cmNlc0NvbnRlbnQiOlsiXCJ1c2Ugc3RyaWN0XCI7XG5cbi8vIENsYXNzIGRlZmluaXRpb25cbnZhciBLVEFwcFRvZG8gPSBmdW5jdGlvbigpIHtcbiAgICAvLyBQcml2YXRlIHByb3BlcnRpZXNcbiAgICB2YXIgX2FzaWRlRWw7XG4gICAgdmFyIF9saXN0RWw7XG4gICAgdmFyIF92aWV3RWw7XG4gICAgdmFyIF9yZXBseUVsO1xuICAgIHZhciBfYXNpZGVPZmZjYW52YXM7XG5cbiAgICAvLyBQcml2YXRlIG1ldGhvZHNcbiAgICB2YXIgX2luaXRFZGl0b3IgPSBmdW5jdGlvbihmb3JtLCBlZGl0b3IpIHtcbiAgICAgICAgLy8gaW5pdCBlZGl0b3JcbiAgICAgICAgdmFyIG9wdGlvbnMgPSB7XG4gICAgICAgICAgICBtb2R1bGVzOiB7XG4gICAgICAgICAgICAgICAgdG9vbGJhcjoge31cbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBwbGFjZWhvbGRlcjogJ1R5cGUgbWVzc2FnZS4uLicsXG4gICAgICAgICAgICB0aGVtZTogJ3Nub3cnXG4gICAgICAgIH07XG5cbiAgICAgICAgaWYgKCFLVFV0aWwuZ2V0QnlJZChlZGl0b3IpKSB7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cblxuICAgICAgICAvLyBJbml0IGVkaXRvclxuICAgICAgICB2YXIgZWRpdG9yID0gbmV3IFF1aWxsKCcjJyArIGVkaXRvciwgb3B0aW9ucyk7XG5cbiAgICAgICAgLy8gQ3VzdG9taXplIGVkaXRvclxuICAgICAgICB2YXIgdG9vbGJhciA9IEtUVXRpbC5maW5kKGZvcm0sICcucWwtdG9vbGJhcicpO1xuICAgICAgICB2YXIgZWRpdG9yID0gS1RVdGlsLmZpbmQoZm9ybSwgJy5xbC1lZGl0b3InKTtcblxuICAgICAgICBpZiAodG9vbGJhcikge1xuICAgICAgICAgICAgS1RVdGlsLmFkZENsYXNzKHRvb2xiYXIsICdweC01IGJvcmRlci10b3AtMCBib3JkZXItbGVmdC0wIGJvcmRlci1yaWdodC0wJyk7XG4gICAgICAgIH1cblxuICAgICAgICBpZiAoZWRpdG9yKSB7XG4gICAgICAgICAgICBLVFV0aWwuYWRkQ2xhc3MoZWRpdG9yLCAncHgtOCcpO1xuICAgICAgICB9XG4gICAgfVxuXG4gICAgdmFyIF9pbml0QXR0YWNobWVudHMgPSBmdW5jdGlvbihlbGVtSWQpIHtcbiAgICAgICAgaWYgKCFLVFV0aWwuZ2V0QnlJZChlbGVtSWQpKSB7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cblxuICAgICAgICB2YXIgaWQgPSBcIiNcIiArIGVsZW1JZDtcbiAgICAgICAgdmFyIHByZXZpZXdOb2RlID0gJChpZCArIFwiIC5kcm9wem9uZS1pdGVtXCIpO1xuICAgICAgICBwcmV2aWV3Tm9kZS5pZCA9IFwiXCI7XG4gICAgICAgIHZhciBwcmV2aWV3VGVtcGxhdGUgPSBwcmV2aWV3Tm9kZS5wYXJlbnQoJy5kcm9wem9uZS1pdGVtcycpLmh0bWwoKTtcbiAgICAgICAgcHJldmlld05vZGUucmVtb3ZlKCk7XG5cbiAgICAgICAgdmFyIG15RHJvcHpvbmUgPSBuZXcgRHJvcHpvbmUoaWQsIHsgLy8gTWFrZSB0aGUgd2hvbGUgYm9keSBhIGRyb3B6b25lXG4gICAgICAgICAgICB1cmw6IFwiaHR0cHM6Ly9rZWVudGhlbWVzLmNvbS9zY3JpcHRzL3ZvaWQucGhwXCIsIC8vIFNldCB0aGUgdXJsIGZvciB5b3VyIHVwbG9hZCBzY3JpcHQgbG9jYXRpb25cbiAgICAgICAgICAgIHBhcmFsbGVsVXBsb2FkczogMjAsXG4gICAgICAgICAgICBtYXhGaWxlc2l6ZTogMSwgLy8gTWF4IGZpbGVzaXplIGluIE1CXG4gICAgICAgICAgICBwcmV2aWV3VGVtcGxhdGU6IHByZXZpZXdUZW1wbGF0ZSxcbiAgICAgICAgICAgIHByZXZpZXdzQ29udGFpbmVyOiBpZCArIFwiIC5kcm9wem9uZS1pdGVtc1wiLCAvLyBEZWZpbmUgdGhlIGNvbnRhaW5lciB0byBkaXNwbGF5IHRoZSBwcmV2aWV3c1xuICAgICAgICAgICAgY2xpY2thYmxlOiBpZCArIFwiX3NlbGVjdFwiIC8vIERlZmluZSB0aGUgZWxlbWVudCB0aGF0IHNob3VsZCBiZSB1c2VkIGFzIGNsaWNrIHRyaWdnZXIgdG8gc2VsZWN0IGZpbGVzLlxuICAgICAgICB9KTtcblxuICAgICAgICBteURyb3B6b25lLm9uKFwiYWRkZWRmaWxlXCIsIGZ1bmN0aW9uKGZpbGUpIHtcbiAgICAgICAgICAgIC8vIEhvb2t1cCB0aGUgc3RhcnQgYnV0dG9uXG4gICAgICAgICAgICAkKGRvY3VtZW50KS5maW5kKGlkICsgJyAuZHJvcHpvbmUtaXRlbScpLmNzcygnZGlzcGxheScsICcnKTtcbiAgICAgICAgfSk7XG5cbiAgICAgICAgLy8gVXBkYXRlIHRoZSB0b3RhbCBwcm9ncmVzcyBiYXJcbiAgICAgICAgbXlEcm9wem9uZS5vbihcInRvdGFsdXBsb2FkcHJvZ3Jlc3NcIiwgZnVuY3Rpb24ocHJvZ3Jlc3MpIHtcbiAgICAgICAgICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoaWQgKyBcIiAucHJvZ3Jlc3MtYmFyXCIpLnN0eWxlLndpZHRoID0gcHJvZ3Jlc3MgKyBcIiVcIjtcbiAgICAgICAgfSk7XG5cbiAgICAgICAgbXlEcm9wem9uZS5vbihcInNlbmRpbmdcIiwgZnVuY3Rpb24oZmlsZSkge1xuICAgICAgICAgICAgLy8gU2hvdyB0aGUgdG90YWwgcHJvZ3Jlc3MgYmFyIHdoZW4gdXBsb2FkIHN0YXJ0c1xuICAgICAgICAgICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcihpZCArIFwiIC5wcm9ncmVzcy1iYXJcIikuc3R5bGUub3BhY2l0eSA9IFwiMVwiO1xuICAgICAgICB9KTtcblxuICAgICAgICAvLyBIaWRlIHRoZSB0b3RhbCBwcm9ncmVzcyBiYXIgd2hlbiBub3RoaW5nJ3MgdXBsb2FkaW5nIGFueW1vcmVcbiAgICAgICAgbXlEcm9wem9uZS5vbihcImNvbXBsZXRlXCIsIGZ1bmN0aW9uKHByb2dyZXNzKSB7XG4gICAgICAgICAgICB2YXIgdGhpc1Byb2dyZXNzQmFyID0gaWQgKyBcIiAuZHotY29tcGxldGVcIjtcbiAgICAgICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgJCh0aGlzUHJvZ3Jlc3NCYXIgKyBcIiAucHJvZ3Jlc3MtYmFyLCBcIiArIHRoaXNQcm9ncmVzc0JhciArIFwiIC5wcm9ncmVzc1wiKS5jc3MoJ29wYWNpdHknLCAnMCcpO1xuICAgICAgICAgICAgfSwgMzAwKVxuICAgICAgICB9KTtcbiAgICB9XG5cbiAgICAvLyBQdWJsaWMgbWV0aG9kc1xuICAgIHJldHVybiB7XG4gICAgICAgIC8vIFB1YmxpYyBmdW5jdGlvbnNcbiAgICAgICAgaW5pdDogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAvLyBJbml0IHZhcmlhYmxlc1xuICAgICAgICAgICAgX2FzaWRlRWwgPSBLVFV0aWwuZ2V0QnlJZCgna3RfdG9kb19hc2lkZScpO1xuICAgICAgICAgICAgX2xpc3RFbCA9IEtUVXRpbC5nZXRCeUlkKCdrdF90b2RvX2xpc3QnKTtcbiAgICAgICAgICAgIF92aWV3RWwgPSBLVFV0aWwuZ2V0QnlJZCgna3RfdG9kb192aWV3Jyk7XG4gICAgICAgICAgICBfcmVwbHlFbCA9IEtUVXRpbC5nZXRCeUlkKCdrdF90b2RvX3JlcGx5Jyk7XG5cbiAgICAgICAgICAgIC8vIEluaXQgaGFuZGxlcnNcbiAgICAgICAgICAgIEtUQXBwVG9kby5pbml0QXNpZGUoKTtcbiAgICAgICAgICAgIEtUQXBwVG9kby5pbml0TGlzdCgpO1xuICAgICAgICAgICAgS1RBcHBUb2RvLmluaXRWaWV3KCk7XG4gICAgICAgICAgICBLVEFwcFRvZG8uaW5pdFJlcGx5KCk7XG4gICAgICAgIH0sXG5cbiAgICAgICAgaW5pdEFzaWRlOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIC8vIE1vYmlsZSBvZmZjYW52YXMgZm9yIG1vYmlsZSBtb2RlXG4gICAgICAgICAgICBfYXNpZGVPZmZjYW52YXMgPSBuZXcgS1RPZmZjYW52YXMoX2FzaWRlRWwsIHtcbiAgICAgICAgICAgICAgICBvdmVybGF5OiB0cnVlLFxuICAgICAgICAgICAgICAgIGJhc2VDbGFzczogJ29mZmNhbnZhcy1tb2JpbGUnLFxuICAgICAgICAgICAgICAgIC8vY2xvc2VCeTogJ2t0X3RvZG9fYXNpZGVfY2xvc2UnLFxuICAgICAgICAgICAgICAgIHRvZ2dsZUJ5OiAna3Rfc3ViaGVhZGVyX21vYmlsZV90b2dnbGUnXG4gICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgLy8gVmlldyBsaXN0XG4gICAgICAgICAgICBLVFV0aWwub24oX2FzaWRlRWwsICcubGlzdC1pdGVtW2RhdGEtYWN0aW9uPVwibGlzdFwiXScsICdjbGljaycsIGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgdHlwZSA9IEtUVXRpbC5hdHRyKHRoaXMsICdkYXRhLXR5cGUnKTtcbiAgICAgICAgICAgICAgICB2YXIgbGlzdEl0ZW1zRWwgPSBLVFV0aWwuZmluZChfbGlzdEVsLCAnLmt0LWluYm94X19pdGVtcycpO1xuICAgICAgICAgICAgICAgIHZhciBuYXZJdGVtRWwgPSB0aGlzLmNsb3Nlc3QoJy5rdC1uYXZfX2l0ZW0nKTtcbiAgICAgICAgICAgICAgICB2YXIgbmF2SXRlbUFjdGl2ZUVsID0gS1RVdGlsLmZpbmQoX2FzaWRlRWwsICcua3QtbmF2X19pdGVtLmt0LW5hdl9faXRlbS0tYWN0aXZlJyk7XG5cbiAgICAgICAgICAgICAgICAvLyBkZW1vIGxvYWRpbmdcbiAgICAgICAgICAgICAgICB2YXIgbG9hZGluZyA9IG5ldyBLVERpYWxvZyh7XG4gICAgICAgICAgICAgICAgICAgICd0eXBlJzogJ2xvYWRlcicsXG4gICAgICAgICAgICAgICAgICAgICdwbGFjZW1lbnQnOiAndG9wIGNlbnRlcicsXG4gICAgICAgICAgICAgICAgICAgICdtZXNzYWdlJzogJ0xvYWRpbmcgLi4uJ1xuICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgICAgIGxvYWRpbmcuc2hvdygpO1xuXG4gICAgICAgICAgICAgICAgc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgbG9hZGluZy5oaWRlKCk7XG5cbiAgICAgICAgICAgICAgICAgICAgS1RVdGlsLmNzcyhfbGlzdEVsLCAnZGlzcGxheScsICdmbGV4Jyk7IC8vIHNob3cgbGlzdFxuICAgICAgICAgICAgICAgICAgICBLVFV0aWwuY3NzKF92aWV3RWwsICdkaXNwbGF5JywgJ25vbmUnKTsgLy8gaGlkZSB2aWV3XG5cbiAgICAgICAgICAgICAgICAgICAgS1RVdGlsLmFkZENsYXNzKG5hdkl0ZW1FbCwgJ2t0LW5hdl9faXRlbS0tYWN0aXZlJyk7XG4gICAgICAgICAgICAgICAgICAgIEtUVXRpbC5yZW1vdmVDbGFzcyhuYXZJdGVtQWN0aXZlRWwsICdrdC1uYXZfX2l0ZW0tLWFjdGl2ZScpO1xuXG4gICAgICAgICAgICAgICAgICAgIEtUVXRpbC5hdHRyKGxpc3RJdGVtc0VsLCAnZGF0YS10eXBlJywgdHlwZSk7XG4gICAgICAgICAgICAgICAgfSwgNjAwKTtcbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9LFxuXG4gICAgICAgIGluaXRMaXN0OiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIC8vIEdyb3VwIHNlbGVjdGlvblxuICAgICAgICAgICAgS1RVdGlsLm9uKF9saXN0RWwsICdbZGF0YS1pbmJveD1cImdyb3VwLXNlbGVjdFwiXSBpbnB1dCcsICdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgIHZhciBtZXNzYWdlcyA9IEtUVXRpbC5maW5kQWxsKF9saXN0RWwsICdbZGF0YS1pbmJveD1cIm1lc3NhZ2VcIl0nKTtcblxuICAgICAgICAgICAgICAgIGZvciAodmFyIGkgPSAwLCBqID0gbWVzc2FnZXMubGVuZ3RoOyBpIDwgajsgaSsrKSB7XG4gICAgICAgICAgICAgICAgICAgIHZhciBtZXNzYWdlID0gbWVzc2FnZXNbaV07XG4gICAgICAgICAgICAgICAgICAgIHZhciBjaGVja2JveCA9IEtUVXRpbC5maW5kKG1lc3NhZ2UsICcuY2hlY2tib3ggaW5wdXQnKTtcbiAgICAgICAgICAgICAgICAgICAgY2hlY2tib3guY2hlY2tlZCA9IHRoaXMuY2hlY2tlZDtcblxuICAgICAgICAgICAgICAgICAgICBpZiAodGhpcy5jaGVja2VkKSB7XG4gICAgICAgICAgICAgICAgICAgICAgICBLVFV0aWwuYWRkQ2xhc3MobWVzc2FnZSwgJ2FjdGl2ZScpO1xuICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgS1RVdGlsLnJlbW92ZUNsYXNzKG1lc3NhZ2UsICdhY3RpdmUnKTtcbiAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAvLyBJbmRpdmlkdWFsIHNlbGVjdGlvblxuICAgICAgICAgICAgS1RVdGlsLm9uKF9saXN0RWwsICdbZGF0YS1pbmJveD1cIm1lc3NhZ2VcIl0gW2RhdGEtaW5ib3g9XCJhY3Rpb25zXCJdIC5jaGVja2JveCBpbnB1dCcsICdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgIHZhciBpdGVtID0gdGhpcy5jbG9zZXN0KCdbZGF0YS1pbmJveD1cIm1lc3NhZ2VcIl0nKTtcblxuICAgICAgICAgICAgICAgIGlmIChpdGVtICYmIHRoaXMuY2hlY2tlZCkge1xuICAgICAgICAgICAgICAgICAgICBLVFV0aWwuYWRkQ2xhc3MoaXRlbSwgJ2FjdGl2ZScpO1xuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgIEtUVXRpbC5yZW1vdmVDbGFzcyhpdGVtLCAnYWN0aXZlJyk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0sXG5cbiAgICAgICAgaW5pdFZpZXc6IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgLy8gQmFjayB0byBsaXN0aW5nXG4gICAgICAgICAgICBLVFV0aWwub24oX3ZpZXdFbCwgJ1tkYXRhLWluYm94PVwiYmFja1wiXScsICdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgIC8vIGRlbW8gbG9hZGluZ1xuICAgICAgICAgICAgICAgIHZhciBsb2FkaW5nID0gbmV3IEtURGlhbG9nKHtcbiAgICAgICAgICAgICAgICAgICAgJ3R5cGUnOiAnbG9hZGVyJyxcbiAgICAgICAgICAgICAgICAgICAgJ3BsYWNlbWVudCc6ICd0b3AgY2VudGVyJyxcbiAgICAgICAgICAgICAgICAgICAgJ21lc3NhZ2UnOiAnTG9hZGluZyAuLi4nXG4gICAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgICBsb2FkaW5nLnNob3coKTtcblxuICAgICAgICAgICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgICAgIGxvYWRpbmcuaGlkZSgpO1xuXG4gICAgICAgICAgICAgICAgICAgIEtUVXRpbC5hZGRDbGFzcyhfbGlzdEVsLCAnZC1ibG9jaycpO1xuICAgICAgICAgICAgICAgICAgICBLVFV0aWwucmVtb3ZlQ2xhc3MoX2xpc3RFbCwgJ2Qtbm9uZScpO1xuXG4gICAgICAgICAgICAgICAgICAgIEtUVXRpbC5hZGRDbGFzcyhfdmlld0VsLCAnZC1ub25lJyk7XG4gICAgICAgICAgICAgICAgICAgIEtUVXRpbC5yZW1vdmVDbGFzcyhfdmlld0VsLCAnZC1ibG9jaycpO1xuICAgICAgICAgICAgICAgIH0sIDcwMCk7XG4gICAgICAgICAgICB9KTtcblxuICAgICAgICAgICAgLy8gRXhwYW5kL0NvbGxhcHNlIHJlcGx5XG4gICAgICAgICAgICBLVFV0aWwub24oX3ZpZXdFbCwgJ1tkYXRhLWluYm94PVwibWVzc2FnZVwiXScsICdjbGljaycsIGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgICAgICAgICB2YXIgbWVzc2FnZSA9IHRoaXMuY2xvc2VzdCgnW2RhdGEtaW5ib3g9XCJtZXNzYWdlXCJdJyk7XG5cbiAgICAgICAgICAgICAgICB2YXIgZHJvcGRvd25Ub2dnbGVFbCA9IEtUVXRpbC5maW5kKHRoaXMsICdbZGF0YS10b2dnbGU9XCJkcm9wZG93blwiXScpO1xuICAgICAgICAgICAgICAgIHZhciB0b29sYmFyRWwgPSBLVFV0aWwuZmluZCh0aGlzLCAnW2RhdGEtaW5ib3g9XCJ0b29sYmFyXCJdJyk7XG5cbiAgICAgICAgICAgICAgICAvLyBza2lwIGRyb3Bkb3duIHRvZ2dsZSBjbGlja1xuICAgICAgICAgICAgICAgIGlmIChlLnRhcmdldCA9PT0gZHJvcGRvd25Ub2dnbGVFbCB8fCAoZHJvcGRvd25Ub2dnbGVFbCAmJiBkcm9wZG93blRvZ2dsZUVsLmNvbnRhaW5zKGUudGFyZ2V0KSA9PT0gdHJ1ZSkpIHtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIC8vIHNraXAgZ3JvdXAgYWN0aW9ucyBjbGlja1xuICAgICAgICAgICAgICAgIGlmIChlLnRhcmdldCA9PT0gdG9vbGJhckVsIHx8ICh0b29sYmFyRWwgJiYgdG9vbGJhckVsLmNvbnRhaW5zKGUudGFyZ2V0KSA9PT0gdHJ1ZSkpIHtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICAgICAgICAgIH1cblxuICAgICAgICAgICAgICAgIGlmIChLVFV0aWwuaGFzQ2xhc3MobWVzc2FnZSwgJ3RvZ2dsZS1vbicpKSB7XG4gICAgICAgICAgICAgICAgICAgIEtUVXRpbC5hZGRDbGFzcyhtZXNzYWdlLCAndG9nZ2xlLW9mZicpO1xuICAgICAgICAgICAgICAgICAgICBLVFV0aWwucmVtb3ZlQ2xhc3MobWVzc2FnZSwgJ3RvZ2dsZS1vbicpO1xuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgIEtUVXRpbC5yZW1vdmVDbGFzcyhtZXNzYWdlLCAndG9nZ2xlLW9mZicpO1xuICAgICAgICAgICAgICAgICAgICBLVFV0aWwuYWRkQ2xhc3MobWVzc2FnZSwgJ3RvZ2dsZS1vbicpO1xuICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgIH0pO1xuICAgICAgICB9LFxuXG4gICAgICAgIGluaXRSZXBseTogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBfaW5pdEVkaXRvcihfcmVwbHlFbCwgJ2t0X3RvZG9fcmVwbHlfZWRpdG9yJyk7XG4gICAgICAgICAgICBfaW5pdEF0dGFjaG1lbnRzKCdrdF90b2RvX3JlcGx5X2F0dGFjaG1lbnRzJyk7XG4gICAgICAgIH1cbiAgICB9O1xufSgpO1xuXG4vLyBDbGFzcyBJbml0aWFsaXphdGlvblxualF1ZXJ5KGRvY3VtZW50KS5yZWFkeShmdW5jdGlvbigpIHtcbiAgICBLVEFwcFRvZG8uaW5pdCgpO1xufSk7XG4iXSwibmFtZXMiOlsiS1RBcHBUb2RvIiwiX2FzaWRlRWwiLCJfbGlzdEVsIiwiX3ZpZXdFbCIsIl9yZXBseUVsIiwiX2FzaWRlT2ZmY2FudmFzIiwiX2luaXRFZGl0b3IiLCJmb3JtIiwiZWRpdG9yIiwib3B0aW9ucyIsIm1vZHVsZXMiLCJ0b29sYmFyIiwicGxhY2Vob2xkZXIiLCJ0aGVtZSIsIktUVXRpbCIsImdldEJ5SWQiLCJRdWlsbCIsImZpbmQiLCJhZGRDbGFzcyIsIl9pbml0QXR0YWNobWVudHMiLCJlbGVtSWQiLCJpZCIsInByZXZpZXdOb2RlIiwiJCIsInByZXZpZXdUZW1wbGF0ZSIsInBhcmVudCIsImh0bWwiLCJyZW1vdmUiLCJteURyb3B6b25lIiwiRHJvcHpvbmUiLCJ1cmwiLCJwYXJhbGxlbFVwbG9hZHMiLCJtYXhGaWxlc2l6ZSIsInByZXZpZXdzQ29udGFpbmVyIiwiY2xpY2thYmxlIiwib24iLCJmaWxlIiwiZG9jdW1lbnQiLCJjc3MiLCJwcm9ncmVzcyIsInF1ZXJ5U2VsZWN0b3IiLCJzdHlsZSIsIndpZHRoIiwib3BhY2l0eSIsInRoaXNQcm9ncmVzc0JhciIsInNldFRpbWVvdXQiLCJpbml0IiwiaW5pdEFzaWRlIiwiaW5pdExpc3QiLCJpbml0VmlldyIsImluaXRSZXBseSIsIktUT2ZmY2FudmFzIiwib3ZlcmxheSIsImJhc2VDbGFzcyIsInRvZ2dsZUJ5IiwiZSIsInR5cGUiLCJhdHRyIiwibGlzdEl0ZW1zRWwiLCJuYXZJdGVtRWwiLCJjbG9zZXN0IiwibmF2SXRlbUFjdGl2ZUVsIiwibG9hZGluZyIsIktURGlhbG9nIiwic2hvdyIsImhpZGUiLCJyZW1vdmVDbGFzcyIsIm1lc3NhZ2VzIiwiZmluZEFsbCIsImkiLCJqIiwibGVuZ3RoIiwibWVzc2FnZSIsImNoZWNrYm94IiwiY2hlY2tlZCIsIml0ZW0iLCJkcm9wZG93blRvZ2dsZUVsIiwidG9vbGJhckVsIiwidGFyZ2V0IiwiY29udGFpbnMiLCJoYXNDbGFzcyIsImpRdWVyeSIsInJlYWR5Il0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/metronic/js/pages/custom/todo/todo.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/metronic/js/pages/custom/todo/todo.js"]();
/******/ 	
/******/ })()
;