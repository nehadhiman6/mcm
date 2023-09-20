var APP={};function theme_color(e){return e in APP.COLORS&&APP.COLORS[e]}function closeShined(){$("body").removeClass("has-backdrop"),$(".shined").removeClass("shined")}APP.jQueryLoaded=!!window.jQuery,APP.guid=function(){function e(){return Math.floor(65536*(1+Math.random())).toString(16).substring(1)}return function(){return e()+e()+"-"+e()+"-"+e()+"-"+e()+"-"+e()+e()+e()}}(),APP.ASSETS_PATH="./assets/",APP.COLORS={primary:"#2949EF",secondary:"#6c757d",success:"#06b5b6",info:"#00bcd4",warning:"#fd7e14",danger:"#FE4D2E",light:"#dee2e6",purple:"#6f42c1",indigo:"#6610f2",pink:"#e83e8c",yellow:"#FDA424",teal:"#20c997"},$(window).on("load",function(){setTimeout(function(){$(".preloader-backdrop").fadeOut(200)},0)}),$(function(){for(var e=document.querySelectorAll(".custom-scroll"),t=0;t<e.length;t++)new PerfectScrollbar(e[t]);function i(e){27==e.which&&($("body").removeClass("fullscreen-mode"),$(".card-fullscreen").removeClass("card-fullscreen"),$(window).off("keydown",i))}$('[data-toggle="tooltip"]').tooltip(),$('[data-toggle="popover"]').popover(),$.fn.backdrop=function(){return $(this).toggleClass("shined"),$("body").toggleClass("has-backdrop"),$(this)},$(".backdrop, .js-close-backdrop").on("click",closeShined),$(".card-collapse").on("click",function(){$(this).closest(".card").toggleClass("collapsed-mode").children(".card-body").slideToggle(200)}),$(".card-remove").on("click",function(){$(this).closest(".card").remove()}),$(".fullscreen-link").click(function(){$("body").hasClass("fullscreen-mode")?($("body").removeClass("fullscreen-mode"),$(this).closest(".card").removeClass("card-fullscreen"),$(window).off("keydown",i)):($("body").addClass("fullscreen-mode"),$(this).closest(".card").addClass("card-fullscreen"),$(window).on("keydown",i))})}),APP.layout={sidebarAlwaysDrawerMode:!1},APP.layout.sidebarAlwaysDrawerMode||$("body").hasClass("sidebar-drawer-mode")||$(window).on("load resize scroll",function(){$("body").hasClass("sidebar-collapsed-mode")?$(this).width()<992?$("body").addClass("sidebar-hidden"):$("body").removeClass("sidebar-hidden"):$("body").hasClass("mini-sidebar")||($(this).width()<992?$("body").addClass("drawer-sidebar"):($("body").removeClass("drawer-sidebar"),$("#sidebar").hasClass("shined")&&closeShined()))}),$(function(){$(".metismenu").length&&$(".metismenu").metisMenu(),$("#sidebar-toggler").on("click",function(e){e.preventDefault(),$("body").hasClass("drawer-sidebar")?$("#sidebar").backdrop():$("body").hasClass("sidebar-collapsed-mode")?$("body").toggleClass("sidebar-hidden"):$("body").toggleClass("mini-sidebar")}),$(".quick-sidebar-toggler").on("click",function(e){e.preventDefault(),$("#quick-sidebar").backdrop()})}),function(w){APP.updateTextFields=function(){w("input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=nuAPPer], input[type=search], textarea").each(function(e,t){var i=w(this);0<w(t).val().length||w(t).is(":focus")||t.autofocus||void 0!==i.attr("placeholder")?i.siblings("label").addClass("active"):w(t)[0].validity?i.siblings("label").toggleClass("active",!0===w(t)[0].validity.badInput):i.siblings("label").removeClass("active")})},APP.validate_field=function(e){var t=void 0!==e.attr("data-length"),i=parseInt(e.attr("data-length")),o=e.val().length;0!==o||!1!==e[0].validity.badInput||e.is(":required")?e.hasClass("validate")&&(e.is(":valid")&&t&&o<=i||e.is(":valid")&&!t?(e.removeClass("invalid"),e.addClass("valid")):(e.removeClass("valid"),e.addClass("invalid"))):e.hasClass("validate")&&(e.removeClass("valid"),e.removeClass("invalid"))},APP.textareaAutoResize=function(e){var t=w(".hiddendiv").first();t.length||(t=w('<div class="hiddendiv common"></div>'),w("body").append(t));var i=e.css("font-family"),o=e.css("font-size"),a=e.css("line-height"),s=e.css("padding");o&&t.css("font-size",o),i&&t.css("font-family",i),a&&t.css("line-height",a),s&&t.css("padding",s),e.data("original-height")||e.data("original-height",e.outerHeight()),"off"===e.attr("wrap")&&t.css("overflow-wrap","normal").css("white-space","pre"),t.text(e.val()+"\n");var n=t.html().replace(/\n/g,"<br>");t.html(n),e.is(":visible")?t.css("width",e.width()):t.css("width",w(window).width()/2),e.data("original-height")<=t.outerHeight()?e.css("height",t.outerHeight()):e.val().length<e.data("previous-length")&&e.css("height",e.data("original-height")),e.data("previous-length",e.val().length)},w(document).ready(function(){var e="input[type=text], input[type=password], input[type=email], input[type=url], input[type=tel], input[type=nuAPPer], input[type=search], textarea";w(document).on("change",e,function(){0===w(this).val().length&&void 0===w(this).attr("placeholder")||w(this).siblings("label").addClass("active"),APP.validate_field(w(this))}),APP.updateTextFields(),w(document).on("focus",e,function(){w(this).siblings("label, .prefix").addClass("active")}),w(document).on("blur",e,function(){var e=w(this),t=".prefix";0===e.val().length&&!0!==e[0].validity.badInput&&void 0===e.attr("placeholder")&&(t+=", label"),e.siblings(t).removeClass("active"),APP.validate_field(e)});var t="textarea.md-form-control.auto-resize";w(t).each(function(){var e=w(this);e.data("original-height",e.outerHeight()),e.data("previous-length",e.val().length),APP.textareaAutoResize(e)}),w(document).on("keyup keydown",t,function(){APP.textareaAutoResize(w(this))})}),w.fn.autocomplete=function(b){var e={data:{},limit:1/0,onAutocomplete:null,minLength:1};return b=w.extend(e,b),this.each(function(){var u,h=w(this),f=b.data,v=0,s=-1,e=h.closest(".md-form");if(w.isEmptyObject(f))h.off("keyup.autocomplete focus.autocomplete");else{var t,g=w('<ul class="autocomplete-content dropdown-content"></ul>');e.length?(t=e.children(".autocomplete-content.dropdown-content").first()).length||e.append(g):(t=h.next(".autocomplete-content.dropdown-content")).length||h.after(g),t.length&&(g=t);var m=function(){g.empty(),s=-1,g.find(".active").removeClass("active"),u=void 0};h.off("blur.autocomplete").on("blur.autocomplete",function(){m()}),h.off("keyup.autocomplete focus.autocomplete").on("keyup.autocomplete focus.autocomplete",function(e){v=0;var t=h.val().toLowerCase();if(13!==e.which&&38!==e.which&&40!==e.which){if(u!==t&&(m(),t.length>=b.minLength))for(var i in f)if(f.hasOwnProperty(i)&&-1!==i.toLowerCase().indexOf(t)){if(v>=b.limit)break;var o=w("<li></li>");f[i]?o.append('<img src="'+f[i]+'" class="right circle"><span>'+i+"</span>"):o.append("<span>"+i+"</span>"),g.append(o),a=t,void 0,n=(s=o).find("img"),l=s.text().toLowerCase().indexOf(""+a.toLowerCase()),d=l+a.length-1,r=s.text().slice(0,l),c=s.text().slice(l,d+1),p=s.text().slice(d+1),s.html("<span>"+r+"<span class='highlight'>"+c+"</span>"+p+"</span>"),n.length&&s.prepend(n),v++}var a,s,n,l,d,r,c,p;u=t}}),h.off("keydown.autocomplete").on("keydown.autocomplete",function(e){var t,i=e.which,o=g.children("li").length,a=g.children(".active").first();13===i&&0<=s?(t=g.children("li").eq(s)).length&&(t.trigger("mousedown.autocomplete"),e.preventDefault()):38!==i&&40!==i||(e.preventDefault(),38===i&&0<s&&s--,40===i&&s<o-1&&s++,a.removeClass("active"),0<=s&&g.children("li").eq(s).addClass("active"))}),g.off("mousedown.autocomplete touchstart.autocomplete").on("mousedown.autocomplete touchstart.autocomplete","li",function(){var e=w(this).text().trim();h.val(e),h.trigger("change"),m(),"function"==typeof b.onAutocomplete&&b.onAutocomplete.call(this,e)})}})},w.fn.formSelect=function(g){function m(e,t,i){var o=e.indexOf(t),a=-1===o;return a?e.push(t):e.splice(o,1),i.siblings("ul.dropdown-content").find("li:not(.optgroup)").eq(t).toggleClass("active"),i.find("option").eq(t).prop("selected",a),function(e,t){for(var i="",o=0,a=e.length;o<a;o++){var s=t.find("option").eq(e[o]).text();i+=0===o?s:", "+s}""===i&&(i=t.find("option:disabled").eq(0).text());t.siblings("input.select-dropdown").val(i)}(e,i),a}w(this).each(function(){var o=w(this);if(!o.hasClass("browser-default")){var r=!!o.attr("multiple"),e=o.attr("data-select-id");if(e&&(o.parent().find("span.caret").remove(),o.parent().find("input").remove(),o.unwrap(),w("ul#select-options-"+e).remove()),"destroy"===g)return o.removeAttr("data-select-id").removeClass("initialized"),void w(window).off("click.select");var t=APP.guid();o.attr("data-select-id",t);var i=w('<div class="select-wrapper"></div>');i.addClass(o.attr("class")),o.is(":disabled")&&i.addClass("disabled");var c=w('<ul id="select-options-'+t+'" class="dropdown-content select-dropdown '+(r?"multiple-select-dropdown":"")+'"></ul>'),a=o.children("option, optgroup"),s=[],n=!1,l=o.find("option:selected").html()||o.find("option:first").html()||"",d=function(e,t,i){var o=t.is(":disabled")?"disabled ":"",a="optgroup-option"===i?"optgroup-option ":"",s=r?'<label class="checkbox checkbox-primary"><input type="checkbox"'+o+"/><span>"+t.html()+"</span></label>":t.html(),n=t.data("icon"),l=t.attr("class");if(n){var d="";return l&&(d=' class="'+l+'"'),c.append(w('<li class="'+o+a+'"><img alt="" src="'+n+'"'+d+"><span>"+s+"</span></li>")),!0}c.append(w('<li class="'+o+a+'"><span>'+s+"</span></li>"))};a.length&&a.each(function(){if(w(this).is("option"))r?d(0,w(this),"multiple"):d(0,w(this));else if(w(this).is("optgroup")){var e=w(this).children("option");c.append(w('<li class="optgroup"><span>'+w(this).attr("label")+"</span></li>")),e.each(function(){d(0,w(this),"optgroup-option")})}}),c.find("li:not(.optgroup)").each(function(i){w(this).click(function(e){if(!w(this).hasClass("disabled")&&!w(this).hasClass("optgroup")){var t=!0;r?(w('input[type="checkbox"]',this).prop("checked",function(e,t){return!t}),t=m(s,i,o),h.trigger("focus")):(c.find("li").removeClass("active"),w(this).toggleClass("active"),h.val(w(this).text())),f(c,w(this)),o.find("option").eq(i).prop("selected",t),o.trigger("change"),void 0!==g&&g()}e.stopPropagation()})}),o.wrap(i);var p=w('<span class="caret">&#9660;</span>'),u=l.replace(/"/g,"&quot;"),h=w('<input type="text" class="select-dropdown" readonly="true" '+(o.is(":disabled")?"disabled":"")+' data-activates="select-options-'+t+'" value="'+u+'"/>');o.before(h),h.before(p),h.after(c),o.is(":disabled")||h.dropdown({hover:!1}),o.attr("tabindex")&&w(h[0]).attr("tabindex",o.attr("tabindex")),o.addClass("initialized"),h.on({focus:function(){if(w("ul.select-dropdown").not(c[0]).is(":visible")&&(w("input.select-dropdown").trigger("close"),w(window).off("click.select")),!c.is(":visible")){w(this).trigger("open",["focus"]);var e=w(this).val();r&&0<=e.indexOf(",")&&(e=e.split(",")[0]);var t=c.find("li").filter(function(){return w(this).text().toLowerCase()===e.toLowerCase()})[0];f(c,t,!0),w(window).off("click.select").on("click.select",function(){r&&(n||h.trigger("close")),w(window).off("click.select")})}},click:function(e){e.stopPropagation()}}),h.on("blur",function(){r||(w(this).trigger("close"),w(window).off("click.select")),c.find("li.selected").removeClass("selected")}),c.hover(function(){n=!0},function(){n=!1}),r&&o.find("option:selected:not(:disabled)").each(function(){var e=this.index;m(s,e,o),c.find("li:not(.optgroup)").eq(e).find(":checkbox").prop("checked",!0)});var f=function(e,t,i){if(t){e.find("li.selected").removeClass("selected");var o=w(t);o.addClass("selected"),r&&!i||c.scrollTo(o)}},v=[];h.on("keydown",function(e){if(9!=e.which)if(40!=e.which||c.is(":visible")){if(13!=e.which||c.is(":visible")){e.preventDefault();var t=String.fromCharCode(e.which).toLowerCase();if(t&&-1===[9,13,27,38,40].indexOf(e.which)){v.push(t);var i=v.join(""),o=c.find("li").filter(function(){return 0===w(this).text().toLowerCase().indexOf(i)})[0];o&&f(c,o)}if(13==e.which){var a=c.find("li.selected:not(.disabled)")[0];a&&(w(a).trigger("click"),r||h.trigger("close"))}40==e.which&&(o=c.find("li.selected").length?c.find("li.selected").next("li:not(.disabled)")[0]:c.find("li:not(.disabled)")[0],f(c,o)),27==e.which&&h.trigger("close"),38==e.which&&(o=c.find("li.selected").prev("li:not(.disabled)")[0])&&f(c,o),setTimeout(function(){v=[]},1e3)}}else h.trigger("open");else h.trigger("close")})}})}}(jQuery);
/*!
 * metismenu https://github.com/onokumus/metismenu#readme
 * A jQuery menu plugin
 * @version 3.0.3
 * @author Osman Nuri Okumus <onokumus@gmail.com> (https://github.com/onokumus)
 * @license: MIT 
 */
! function (e, n) {
	"object" == typeof exports && "undefined" != typeof module ? module.exports = n(require("jquery")) : "function" == typeof define && define.amd ? define(["jquery"], n) : e.metisMenu = n(e.jQuery)
}(this, function (o) {
	"use strict";

	function a(r) {
		for (var e = 1; e < arguments.length; e++) {
			var a = null != arguments[e] ? arguments[e] : {},
				n = Object.keys(a);
			"function" == typeof Object.getOwnPropertySymbols && (n = n.concat(Object.getOwnPropertySymbols(a).filter(function (e) {
				return Object.getOwnPropertyDescriptor(a, e).enumerable
			}))), n.forEach(function (e) {
				var n, t, i;
				n = r, i = a[t = e], t in n ? Object.defineProperty(n, t, {
					value: i,
					enumerable: !0,
					configurable: !0,
					writable: !0
				}) : n[t] = i
			})
		}
		return r
	}
	var s = function (i) {
			var n = "transitionend",
				r = {
					TRANSITION_END: "mmTransitionEnd",
					triggerTransitionEnd: function (e) {
						i(e).trigger(n)
					},
					supportsTransitionEnd: function () {
						return Boolean(n)
					}
				};

			function e(e) {
				var n = this,
					t = !1;
				return i(this).one(r.TRANSITION_END, function () {
					t = !0
				}), setTimeout(function () {
					t || r.triggerTransitionEnd(n)
				}, e), this
			}
			return i.fn.mmEmulateTransitionEnd = e, i.event.special[r.TRANSITION_END] = {
				bindType: n,
				delegateType: n,
				handle: function (e) {
					if (i(e.target).is(this)) return e.handleObj.handler.apply(this, arguments)
				}
			}, r
		}(o = o && o.hasOwnProperty("default") ? o.default : o),
		e = "metisMenu",
		g = "metisMenu",
		n = "." + g,
		t = o.fn[e],
		l = {
			toggle: !0,
			preventDefault: !0,
			triggerElement: "a",
			parentTrigger: "li",
			subMenu: "ul"
		},
		u = {
			SHOW: "show" + n,
			SHOWN: "shown" + n,
			HIDE: "hide" + n,
			HIDDEN: "hidden" + n,
			CLICK_DATA_API: "click" + n + ".data-api"
		},
		i = "metismenu",
		f = "mm-active",
		h = "mm-show",
		d = "mm-collapse",
		c = "mm-collapsing",
		r = function () {
			function r(e, n) {
				this.element = e, this.config = a({}, l, n), this.transitioning = null, this.init()
			}
			var e = r.prototype;
			return e.init = function () {
				var a = this,
					s = this.config;
				o(this.element).addClass(i), o(this.element).find(s.parentTrigger + "." + f).children(s.triggerElement).attr("aria-expanded", "true"), o(this.element).find(s.parentTrigger + "." + f).parents(s.parentTrigger).addClass(f), o(this.element).find(s.parentTrigger + "." + f).parents(s.parentTrigger).children(s.triggerElement).attr("aria-expanded", "true"), o(this.element).find(s.parentTrigger + "." + f).has(s.subMenu).children(s.subMenu).addClass(d + " " + h), o(this.element).find(s.parentTrigger).not("." + f).has(s.subMenu).children(s.subMenu).addClass(d), o(this.element).find(s.parentTrigger).has(s.subMenu).children(s.triggerElement).on(u.CLICK_DATA_API, function (e) {
					var n = o(this),
						t = n.parent(s.parentTrigger),
						i = t.siblings(s.parentTrigger).children(s.triggerElement),
						r = t.children(s.subMenu);
					s.preventDefault && e.preventDefault(), "true" !== n.attr("aria-disabled") && (t.hasClass(f) ? (n.attr("aria-expanded", "false"), a.hide(r)) : (a.show(r), n.attr("aria-expanded", "true"), s.toggle && i.attr("aria-expanded", "false")), s.onTransitionStart && s.onTransitionStart(e))
				})
			}, e.show = function (e) {
				var n = this;
				if (!this.transitioning && !o(e).hasClass(c)) {
					var t = o(e),
						i = o.Event(u.SHOW);
					if (t.trigger(i), !i.isDefaultPrevented()) {
						if (t.parent(this.config.parentTrigger).addClass(f), this.config.toggle) {
							var r = t.parent(this.config.parentTrigger).siblings().children(this.config.subMenu + "." + h);
							this.hide(r)
						}
						t.removeClass(d).addClass(c).height(0), this.setTransitioning(!0);
						t.height(e[0].scrollHeight).one(s.TRANSITION_END, function () {
							n.config && n.element && (t.removeClass(c).addClass(d + " " + h).height(""), n.setTransitioning(!1), t.trigger(u.SHOWN))
						}).mmEmulateTransitionEnd(350)
					}
				}
			}, e.hide = function (e) {
				var n = this;
				if (!this.transitioning && o(e).hasClass(h)) {
					var t = o(e),
						i = o.Event(u.HIDE);
					if (t.trigger(i), !i.isDefaultPrevented()) {
						t.parent(this.config.parentTrigger).removeClass(f), t.height(t.height())[0].offsetHeight, t.addClass(c).removeClass(d).removeClass(h), this.setTransitioning(!0);
						var r = function () {
							n.config && n.element && (n.transitioning && n.config.onTransitionEnd && n.config.onTransitionEnd(), n.setTransitioning(!1), t.trigger(u.HIDDEN), t.removeClass(c).addClass(d))
						};
						0 === t.height() || "none" === t.css("display") ? r() : t.height(0).one(s.TRANSITION_END, r).mmEmulateTransitionEnd(350)
					}
				}
			}, e.setTransitioning = function (e) {
				this.transitioning = e
			}, e.dispose = function () {
				o.removeData(this.element, g), o(this.element).find(this.config.parentTrigger).has(this.config.subMenu).children(this.config.triggerElement).off("click"), this.transitioning = null, this.config = null, this.element = null
			}, r.jQueryInterface = function (i) {
				return this.each(function () {
					var e = o(this),
						n = e.data(g),
						t = a({}, l, e.data(), "object" == typeof i && i ? i : {});
					if (n || (n = new r(this, t), e.data(g, n)), "string" == typeof i) {
						if (void 0 === n[i]) throw new Error('No method named "' + i + '"');
						n[i]()
					}
				})
			}, r
		}();
	return o.fn[e] = r.jQueryInterface, o.fn[e].Constructor = r, o.fn[e].noConflict = function () {
		return o.fn[e] = t, r.jQueryInterface
	}, r
});
//# sourceMappingURL=metisMenu.min.js.map
/*!
 * perfect-scrollbar v1.4.0
 * (c) 2018 Hyunje Jun
 * @license MIT
 */
! function (t, e) {
	"object" == typeof exports && "undefined" != typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define(e) : t.PerfectScrollbar = e()
}(this, function () {
	"use strict";

	function t(t) {
		return getComputedStyle(t)
	}

	function e(t, e) {
		for (var i in e) {
			var r = e[i];
			"number" == typeof r && (r += "px"), t.style[i] = r
		}
		return t
	}

	function i(t) {
		var e = document.createElement("div");
		return e.className = t, e
	}

	function r(t, e) {
		if (!v) throw new Error("No element matching method supported");
		return v.call(t, e)
	}

	function l(t) {
		t.remove ? t.remove() : t.parentNode && t.parentNode.removeChild(t)
	}

	function n(t, e) {
		return Array.prototype.filter.call(t.children, function (t) {
			return r(t, e)
		})
	}

	function o(t, e) {
		var i = t.element.classList,
			r = m.state.scrolling(e);
		i.contains(r) ? clearTimeout(Y[e]) : i.add(r)
	}

	function s(t, e) {
		Y[e] = setTimeout(function () {
			return t.isAlive && t.element.classList.remove(m.state.scrolling(e))
		}, t.settings.scrollingThreshold)
	}

	function a(t, e) {
		o(t, e), s(t, e)
	}

	function c(t) {
		if ("function" == typeof window.CustomEvent) return new CustomEvent(t);
		var e = document.createEvent("CustomEvent");
		return e.initCustomEvent(t, !1, !1, void 0), e
	}

	function h(t, e, i, r, l) {
		var n = i[0],
			o = i[1],
			s = i[2],
			h = i[3],
			u = i[4],
			d = i[5];
		void 0 === r && (r = !0), void 0 === l && (l = !1);
		var f = t.element;
		t.reach[h] = null, f[s] < 1 && (t.reach[h] = "start"), f[s] > t[n] - t[o] - 1 && (t.reach[h] = "end"), e && (f.dispatchEvent(c("ps-scroll-" + h)), e < 0 ? f.dispatchEvent(c("ps-scroll-" + u)) : e > 0 && f.dispatchEvent(c("ps-scroll-" + d)), r && a(t, h)), t.reach[h] && (e || l) && f.dispatchEvent(c("ps-" + h + "-reach-" + t.reach[h]))
	}

	function u(t) {
		return parseInt(t, 10) || 0
	}

	function d(t) {
		return r(t, "input,[contenteditable]") || r(t, "select,[contenteditable]") || r(t, "textarea,[contenteditable]") || r(t, "button,[contenteditable]")
	}

	function f(e) {
		var i = t(e);
		return u(i.width) + u(i.paddingLeft) + u(i.paddingRight) + u(i.borderLeftWidth) + u(i.borderRightWidth)
	}

	function p(t, e) {
		return t.settings.minScrollbarLength && (e = Math.max(e, t.settings.minScrollbarLength)), t.settings.maxScrollbarLength && (e = Math.min(e, t.settings.maxScrollbarLength)), e
	}

	function b(t, i) {
		var r = {
				width: i.railXWidth
			},
			l = Math.floor(t.scrollTop);
		i.isRtl ? r.left = i.negativeScrollAdjustment + t.scrollLeft + i.containerWidth - i.contentWidth : r.left = t.scrollLeft, i.isScrollbarXUsingBottom ? r.bottom = i.scrollbarXBottom - l : r.top = i.scrollbarXTop + l, e(i.scrollbarXRail, r);
		var n = {
			top: l,
			height: i.railYHeight
		};
		i.isScrollbarYUsingRight ? i.isRtl ? n.right = i.contentWidth - (i.negativeScrollAdjustment + t.scrollLeft) - i.scrollbarYRight - i.scrollbarYOuterWidth : n.right = i.scrollbarYRight - t.scrollLeft : i.isRtl ? n.left = i.negativeScrollAdjustment + t.scrollLeft + 2 * i.containerWidth - i.contentWidth - i.scrollbarYLeft - i.scrollbarYOuterWidth : n.left = i.scrollbarYLeft + t.scrollLeft, e(i.scrollbarYRail, n), e(i.scrollbarX, {
			left: i.scrollbarXLeft,
			width: i.scrollbarXWidth - i.railBorderXWidth
		}), e(i.scrollbarY, {
			top: i.scrollbarYTop,
			height: i.scrollbarYHeight - i.railBorderYWidth
		})
	}

	function g(t, e) {
		function i(e) {
			b[d] = g + Y * (e[a] - v), o(t, f), R(t), e.stopPropagation(), e.preventDefault()
		}

		function r() {
			s(t, f), t[p].classList.remove(m.state.clicking), t.event.unbind(t.ownerDocument, "mousemove", i)
		}
		var l = e[0],
			n = e[1],
			a = e[2],
			c = e[3],
			h = e[4],
			u = e[5],
			d = e[6],
			f = e[7],
			p = e[8],
			b = t.element,
			g = null,
			v = null,
			Y = null;
		t.event.bind(t[h], "mousedown", function (e) {
			g = b[d], v = e[a], Y = (t[n] - t[l]) / (t[c] - t[u]), t.event.bind(t.ownerDocument, "mousemove", i), t.event.once(t.ownerDocument, "mouseup", r), t[p].classList.add(m.state.clicking), e.stopPropagation(), e.preventDefault()
		})
	}
	var v = "undefined" != typeof Element && (Element.prototype.matches || Element.prototype.webkitMatchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector),
		m = {
			main: "ps",
			element: {
				thumb: function (t) {
					return "ps__thumb-" + t
				},
				rail: function (t) {
					return "ps__rail-" + t
				},
				consuming: "ps__child--consume"
			},
			state: {
				focus: "ps--focus",
				clicking: "ps--clicking",
				active: function (t) {
					return "ps--active-" + t
				},
				scrolling: function (t) {
					return "ps--scrolling-" + t
				}
			}
		},
		Y = {
			x: null,
			y: null
		},
		X = function (t) {
			this.element = t, this.handlers = {}
		},
		w = {
			isEmpty: {
				configurable: !0
			}
		};
	X.prototype.bind = function (t, e) {
		void 0 === this.handlers[t] && (this.handlers[t] = []), this.handlers[t].push(e), this.element.addEventListener(t, e, !1)
	}, X.prototype.unbind = function (t, e) {
		var i = this;
		this.handlers[t] = this.handlers[t].filter(function (r) {
			return !(!e || r === e) || (i.element.removeEventListener(t, r, !1), !1)
		})
	}, X.prototype.unbindAll = function () {
		var t = this;
		for (var e in t.handlers) t.unbind(e)
	}, w.isEmpty.get = function () {
		var t = this;
		return Object.keys(this.handlers).every(function (e) {
			return 0 === t.handlers[e].length
		})
	}, Object.defineProperties(X.prototype, w);
	var y = function () {
		this.eventElements = []
	};
	y.prototype.eventElement = function (t) {
		var e = this.eventElements.filter(function (e) {
			return e.element === t
		})[0];
		return e || (e = new X(t), this.eventElements.push(e)), e
	}, y.prototype.bind = function (t, e, i) {
		this.eventElement(t).bind(e, i)
	}, y.prototype.unbind = function (t, e, i) {
		var r = this.eventElement(t);
		r.unbind(e, i), r.isEmpty && this.eventElements.splice(this.eventElements.indexOf(r), 1)
	}, y.prototype.unbindAll = function () {
		this.eventElements.forEach(function (t) {
			return t.unbindAll()
		}), this.eventElements = []
	}, y.prototype.once = function (t, e, i) {
		var r = this.eventElement(t),
			l = function (t) {
				r.unbind(e, l), i(t)
			};
		r.bind(e, l)
	};
	var W = function (t, e, i, r, l) {
			void 0 === r && (r = !0), void 0 === l && (l = !1);
			var n;
			if ("top" === e) n = ["contentHeight", "containerHeight", "scrollTop", "y", "up", "down"];
			else {
				if ("left" !== e) throw new Error("A proper axis should be provided");
				n = ["contentWidth", "containerWidth", "scrollLeft", "x", "left", "right"]
			}
			h(t, i, n, r, l)
		},
		L = {
			isWebKit: "undefined" != typeof document && "WebkitAppearance" in document.documentElement.style,
			supportsTouch: "undefined" != typeof window && ("ontouchstart" in window || window.DocumentTouch && document instanceof window.DocumentTouch),
			supportsIePointer: "undefined" != typeof navigator && navigator.msMaxTouchPoints,
			isChrome: "undefined" != typeof navigator && /Chrome/i.test(navigator && navigator.userAgent)
		},
		R = function (t) {
			var e = t.element,
				i = Math.floor(e.scrollTop);
			t.containerWidth = e.clientWidth, t.containerHeight = e.clientHeight, t.contentWidth = e.scrollWidth, t.contentHeight = e.scrollHeight, e.contains(t.scrollbarXRail) || (n(e, m.element.rail("x")).forEach(function (t) {
				return l(t)
			}), e.appendChild(t.scrollbarXRail)), e.contains(t.scrollbarYRail) || (n(e, m.element.rail("y")).forEach(function (t) {
				return l(t)
			}), e.appendChild(t.scrollbarYRail)), !t.settings.suppressScrollX && t.containerWidth + t.settings.scrollXMarginOffset < t.contentWidth ? (t.scrollbarXActive = !0, t.railXWidth = t.containerWidth - t.railXMarginWidth, t.railXRatio = t.containerWidth / t.railXWidth, t.scrollbarXWidth = p(t, u(t.railXWidth * t.containerWidth / t.contentWidth)), t.scrollbarXLeft = u((t.negativeScrollAdjustment + e.scrollLeft) * (t.railXWidth - t.scrollbarXWidth) / (t.contentWidth - t.containerWidth))) : t.scrollbarXActive = !1, !t.settings.suppressScrollY && t.containerHeight + t.settings.scrollYMarginOffset < t.contentHeight ? (t.scrollbarYActive = !0, t.railYHeight = t.containerHeight - t.railYMarginHeight, t.railYRatio = t.containerHeight / t.railYHeight, t.scrollbarYHeight = p(t, u(t.railYHeight * t.containerHeight / t.contentHeight)), t.scrollbarYTop = u(i * (t.railYHeight - t.scrollbarYHeight) / (t.contentHeight - t.containerHeight))) : t.scrollbarYActive = !1, t.scrollbarXLeft >= t.railXWidth - t.scrollbarXWidth && (t.scrollbarXLeft = t.railXWidth - t.scrollbarXWidth), t.scrollbarYTop >= t.railYHeight - t.scrollbarYHeight && (t.scrollbarYTop = t.railYHeight - t.scrollbarYHeight), b(e, t), t.scrollbarXActive ? e.classList.add(m.state.active("x")) : (e.classList.remove(m.state.active("x")), t.scrollbarXWidth = 0, t.scrollbarXLeft = 0, e.scrollLeft = 0), t.scrollbarYActive ? e.classList.add(m.state.active("y")) : (e.classList.remove(m.state.active("y")), t.scrollbarYHeight = 0, t.scrollbarYTop = 0, e.scrollTop = 0)
		},
		T = {
			"click-rail": function (t) {
				t.event.bind(t.scrollbarY, "mousedown", function (t) {
					return t.stopPropagation()
				}), t.event.bind(t.scrollbarYRail, "mousedown", function (e) {
					var i = e.pageY - window.pageYOffset - t.scrollbarYRail.getBoundingClientRect().top > t.scrollbarYTop ? 1 : -1;
					t.element.scrollTop += i * t.containerHeight, R(t), e.stopPropagation()
				}), t.event.bind(t.scrollbarX, "mousedown", function (t) {
					return t.stopPropagation()
				}), t.event.bind(t.scrollbarXRail, "mousedown", function (e) {
					var i = e.pageX - window.pageXOffset - t.scrollbarXRail.getBoundingClientRect().left > t.scrollbarXLeft ? 1 : -1;
					t.element.scrollLeft += i * t.containerWidth, R(t), e.stopPropagation()
				})
			},
			"drag-thumb": function (t) {
				g(t, ["containerWidth", "contentWidth", "pageX", "railXWidth", "scrollbarX", "scrollbarXWidth", "scrollLeft", "x", "scrollbarXRail"]), g(t, ["containerHeight", "contentHeight", "pageY", "railYHeight", "scrollbarY", "scrollbarYHeight", "scrollTop", "y", "scrollbarYRail"])
			},
			keyboard: function (t) {
				function e(e, r) {
					var l = Math.floor(i.scrollTop);
					if (0 === e) {
						if (!t.scrollbarYActive) return !1;
						if (0 === l && r > 0 || l >= t.contentHeight - t.containerHeight && r < 0) return !t.settings.wheelPropagation
					}
					var n = i.scrollLeft;
					if (0 === r) {
						if (!t.scrollbarXActive) return !1;
						if (0 === n && e < 0 || n >= t.contentWidth - t.containerWidth && e > 0) return !t.settings.wheelPropagation
					}
					return !0
				}
				var i = t.element,
					l = function () {
						return r(i, ":hover")
					},
					n = function () {
						return r(t.scrollbarX, ":focus") || r(t.scrollbarY, ":focus")
					};
				t.event.bind(t.ownerDocument, "keydown", function (r) {
					if (!(r.isDefaultPrevented && r.isDefaultPrevented() || r.defaultPrevented) && (l() || n())) {
						var o = document.activeElement ? document.activeElement : t.ownerDocument.activeElement;
						if (o) {
							if ("IFRAME" === o.tagName) o = o.contentDocument.activeElement;
							else
								for (; o.shadowRoot;) o = o.shadowRoot.activeElement;
							if (d(o)) return
						}
						var s = 0,
							a = 0;
						switch (r.which) {
							case 37:
								s = r.metaKey ? -t.contentWidth : r.altKey ? -t.containerWidth : -30;
								break;
							case 38:
								a = r.metaKey ? t.contentHeight : r.altKey ? t.containerHeight : 30;
								break;
							case 39:
								s = r.metaKey ? t.contentWidth : r.altKey ? t.containerWidth : 30;
								break;
							case 40:
								a = r.metaKey ? -t.contentHeight : r.altKey ? -t.containerHeight : -30;
								break;
							case 32:
								a = r.shiftKey ? t.containerHeight : -t.containerHeight;
								break;
							case 33:
								a = t.containerHeight;
								break;
							case 34:
								a = -t.containerHeight;
								break;
							case 36:
								a = t.contentHeight;
								break;
							case 35:
								a = -t.contentHeight;
								break;
							default:
								return
						}
						t.settings.suppressScrollX && 0 !== s || t.settings.suppressScrollY && 0 !== a || (i.scrollTop -= a, i.scrollLeft += s, R(t), e(s, a) && r.preventDefault())
					}
				})
			},
			wheel: function (e) {
				function i(t, i) {
					var r = Math.floor(o.scrollTop),
						l = 0 === o.scrollTop,
						n = r + o.offsetHeight === o.scrollHeight,
						s = 0 === o.scrollLeft,
						a = o.scrollLeft + o.offsetWidth === o.scrollWidth;
					return !(Math.abs(i) > Math.abs(t) ? l || n : s || a) || !e.settings.wheelPropagation
				}

				function r(t) {
					var e = t.deltaX,
						i = -1 * t.deltaY;
					return void 0 !== e && void 0 !== i || (e = -1 * t.wheelDeltaX / 6, i = t.wheelDeltaY / 6), t.deltaMode && 1 === t.deltaMode && (e *= 10, i *= 10), e !== e && i !== i && (e = 0, i = t.wheelDelta), t.shiftKey ? [-i, -e] : [e, i]
				}

				function l(e, i, r) {
					if (!L.isWebKit && o.querySelector("select:focus")) return !0;
					if (!o.contains(e)) return !1;
					for (var l = e; l && l !== o;) {
						if (l.classList.contains(m.element.consuming)) return !0;
						var n = t(l);
						if ([n.overflow, n.overflowX, n.overflowY].join("").match(/(scroll|auto)/)) {
							var s = l.scrollHeight - l.clientHeight;
							if (s > 0 && !(0 === l.scrollTop && r > 0 || l.scrollTop === s && r < 0)) return !0;
							var a = l.scrollWidth - l.clientWidth;
							if (a > 0 && !(0 === l.scrollLeft && i < 0 || l.scrollLeft === a && i > 0)) return !0
						}
						l = l.parentNode
					}
					return !1
				}

				function n(t) {
					var n = r(t),
						s = n[0],
						a = n[1];
					if (!l(t.target, s, a)) {
						var c = !1;
						e.settings.useBothWheelAxes ? e.scrollbarYActive && !e.scrollbarXActive ? (a ? o.scrollTop -= a * e.settings.wheelSpeed : o.scrollTop += s * e.settings.wheelSpeed, c = !0) : e.scrollbarXActive && !e.scrollbarYActive && (s ? o.scrollLeft += s * e.settings.wheelSpeed : o.scrollLeft -= a * e.settings.wheelSpeed, c = !0) : (o.scrollTop -= a * e.settings.wheelSpeed, o.scrollLeft += s * e.settings.wheelSpeed), R(e), (c = c || i(s, a)) && !t.ctrlKey && (t.stopPropagation(), t.preventDefault())
					}
				}
				var o = e.element;
				void 0 !== window.onwheel ? e.event.bind(o, "wheel", n) : void 0 !== window.onmousewheel && e.event.bind(o, "mousewheel", n)
			},
			touch: function (e) {
				function i(t, i) {
					var r = Math.floor(h.scrollTop),
						l = h.scrollLeft,
						n = Math.abs(t),
						o = Math.abs(i);
					if (o > n) {
						if (i < 0 && r === e.contentHeight - e.containerHeight || i > 0 && 0 === r) return 0 === window.scrollY && i > 0 && L.isChrome
					} else if (n > o && (t < 0 && l === e.contentWidth - e.containerWidth || t > 0 && 0 === l)) return !0;
					return !0
				}

				function r(t, i) {
					h.scrollTop -= i, h.scrollLeft -= t, R(e)
				}

				function l(t) {
					return t.targetTouches ? t.targetTouches[0] : t
				}

				function n(t) {
					return !(t.pointerType && "pen" === t.pointerType && 0 === t.buttons || (!t.targetTouches || 1 !== t.targetTouches.length) && (!t.pointerType || "mouse" === t.pointerType || t.pointerType === t.MSPOINTER_TYPE_MOUSE))
				}

				function o(t) {
					if (n(t)) {
						var e = l(t);
						u.pageX = e.pageX, u.pageY = e.pageY, d = (new Date).getTime(), null !== p && clearInterval(p)
					}
				}

				function s(e, i, r) {
					if (!h.contains(e)) return !1;
					for (var l = e; l && l !== h;) {
						if (l.classList.contains(m.element.consuming)) return !0;
						var n = t(l);
						if ([n.overflow, n.overflowX, n.overflowY].join("").match(/(scroll|auto)/)) {
							var o = l.scrollHeight - l.clientHeight;
							if (o > 0 && !(0 === l.scrollTop && r > 0 || l.scrollTop === o && r < 0)) return !0;
							var s = l.scrollLeft - l.clientWidth;
							if (s > 0 && !(0 === l.scrollLeft && i < 0 || l.scrollLeft === s && i > 0)) return !0
						}
						l = l.parentNode
					}
					return !1
				}

				function a(t) {
					if (n(t)) {
						var e = l(t),
							o = {
								pageX: e.pageX,
								pageY: e.pageY
							},
							a = o.pageX - u.pageX,
							c = o.pageY - u.pageY;
						if (s(t.target, a, c)) return;
						r(a, c), u = o;
						var h = (new Date).getTime(),
							p = h - d;
						p > 0 && (f.x = a / p, f.y = c / p, d = h), i(a, c) && t.preventDefault()
					}
				}

				function c() {
					e.settings.swipeEasing && (clearInterval(p), p = setInterval(function () {
						e.isInitialized ? clearInterval(p) : f.x || f.y ? Math.abs(f.x) < .01 && Math.abs(f.y) < .01 ? clearInterval(p) : (r(30 * f.x, 30 * f.y), f.x *= .8, f.y *= .8) : clearInterval(p)
					}, 10))
				}
				if (L.supportsTouch || L.supportsIePointer) {
					var h = e.element,
						u = {},
						d = 0,
						f = {},
						p = null;
					L.supportsTouch ? (e.event.bind(h, "touchstart", o), e.event.bind(h, "touchmove", a), e.event.bind(h, "touchend", c)) : L.supportsIePointer && (window.PointerEvent ? (e.event.bind(h, "pointerdown", o), e.event.bind(h, "pointermove", a), e.event.bind(h, "pointerup", c)) : window.MSPointerEvent && (e.event.bind(h, "MSPointerDown", o), e.event.bind(h, "MSPointerMove", a), e.event.bind(h, "MSPointerUp", c)))
				}
			}
		},
		H = function (r, l) {
			var n = this;
			if (void 0 === l && (l = {}), "string" == typeof r && (r = document.querySelector(r)), !r || !r.nodeName) throw new Error("no element is specified to initialize PerfectScrollbar");
			this.element = r, r.classList.add(m.main), this.settings = {
				handlers: ["click-rail", "drag-thumb", "keyboard", "wheel", "touch"],
				maxScrollbarLength: null,
				minScrollbarLength: null,
				scrollingThreshold: 1e3,
				scrollXMarginOffset: 0,
				scrollYMarginOffset: 0,
				suppressScrollX: !1,
				suppressScrollY: !1,
				swipeEasing: !0,
				useBothWheelAxes: !1,
				wheelPropagation: !0,
				wheelSpeed: 1
			};
			for (var o in l) n.settings[o] = l[o];
			this.containerWidth = null, this.containerHeight = null, this.contentWidth = null, this.contentHeight = null;
			var s = function () {
					return r.classList.add(m.state.focus)
				},
				a = function () {
					return r.classList.remove(m.state.focus)
				};
			this.isRtl = "rtl" === t(r).direction, this.isNegativeScroll = function () {
				var t = r.scrollLeft,
					e = null;
				return r.scrollLeft = -1, e = r.scrollLeft < 0, r.scrollLeft = t, e
			}(), this.negativeScrollAdjustment = this.isNegativeScroll ? r.scrollWidth - r.clientWidth : 0, this.event = new y, this.ownerDocument = r.ownerDocument || document, this.scrollbarXRail = i(m.element.rail("x")), r.appendChild(this.scrollbarXRail), this.scrollbarX = i(m.element.thumb("x")), this.scrollbarXRail.appendChild(this.scrollbarX), this.scrollbarX.setAttribute("tabindex", 0), this.event.bind(this.scrollbarX, "focus", s), this.event.bind(this.scrollbarX, "blur", a), this.scrollbarXActive = null, this.scrollbarXWidth = null, this.scrollbarXLeft = null;
			var c = t(this.scrollbarXRail);
			this.scrollbarXBottom = parseInt(c.bottom, 10), isNaN(this.scrollbarXBottom) ? (this.isScrollbarXUsingBottom = !1, this.scrollbarXTop = u(c.top)) : this.isScrollbarXUsingBottom = !0, this.railBorderXWidth = u(c.borderLeftWidth) + u(c.borderRightWidth), e(this.scrollbarXRail, {
				display: "block"
			}), this.railXMarginWidth = u(c.marginLeft) + u(c.marginRight), e(this.scrollbarXRail, {
				display: ""
			}), this.railXWidth = null, this.railXRatio = null, this.scrollbarYRail = i(m.element.rail("y")), r.appendChild(this.scrollbarYRail), this.scrollbarY = i(m.element.thumb("y")), this.scrollbarYRail.appendChild(this.scrollbarY), this.scrollbarY.setAttribute("tabindex", 0), this.event.bind(this.scrollbarY, "focus", s), this.event.bind(this.scrollbarY, "blur", a), this.scrollbarYActive = null, this.scrollbarYHeight = null, this.scrollbarYTop = null;
			var h = t(this.scrollbarYRail);
			this.scrollbarYRight = parseInt(h.right, 10), isNaN(this.scrollbarYRight) ? (this.isScrollbarYUsingRight = !1, this.scrollbarYLeft = u(h.left)) : this.isScrollbarYUsingRight = !0, this.scrollbarYOuterWidth = this.isRtl ? f(this.scrollbarY) : null, this.railBorderYWidth = u(h.borderTopWidth) + u(h.borderBottomWidth), e(this.scrollbarYRail, {
				display: "block"
			}), this.railYMarginHeight = u(h.marginTop) + u(h.marginBottom), e(this.scrollbarYRail, {
				display: ""
			}), this.railYHeight = null, this.railYRatio = null, this.reach = {
				x: r.scrollLeft <= 0 ? "start" : r.scrollLeft >= this.contentWidth - this.containerWidth ? "end" : null,
				y: r.scrollTop <= 0 ? "start" : r.scrollTop >= this.contentHeight - this.containerHeight ? "end" : null
			}, this.isAlive = !0, this.settings.handlers.forEach(function (t) {
				return T[t](n)
			}), this.lastScrollTop = Math.floor(r.scrollTop), this.lastScrollLeft = r.scrollLeft, this.event.bind(this.element, "scroll", function (t) {
				return n.onScroll(t)
			}), R(this)
		};
	return H.prototype.update = function () {
		this.isAlive && (this.negativeScrollAdjustment = this.isNegativeScroll ? this.element.scrollWidth - this.element.clientWidth : 0, e(this.scrollbarXRail, {
			display: "block"
		}), e(this.scrollbarYRail, {
			display: "block"
		}), this.railXMarginWidth = u(t(this.scrollbarXRail).marginLeft) + u(t(this.scrollbarXRail).marginRight), this.railYMarginHeight = u(t(this.scrollbarYRail).marginTop) + u(t(this.scrollbarYRail).marginBottom), e(this.scrollbarXRail, {
			display: "none"
		}), e(this.scrollbarYRail, {
			display: "none"
		}), R(this), W(this, "top", 0, !1, !0), W(this, "left", 0, !1, !0), e(this.scrollbarXRail, {
			display: ""
		}), e(this.scrollbarYRail, {
			display: ""
		}))
	}, H.prototype.onScroll = function (t) {
		this.isAlive && (R(this), W(this, "top", this.element.scrollTop - this.lastScrollTop), W(this, "left", this.element.scrollLeft - this.lastScrollLeft), this.lastScrollTop = Math.floor(this.element.scrollTop), this.lastScrollLeft = this.element.scrollLeft)
	}, H.prototype.destroy = function () {
		this.isAlive && (this.event.unbindAll(), l(this.scrollbarX), l(this.scrollbarY), l(this.scrollbarXRail), l(this.scrollbarYRail), this.removePsClasses(), this.element = null, this.scrollbarX = null, this.scrollbarY = null, this.scrollbarXRail = null, this.scrollbarYRail = null, this.isAlive = !1)
	}, H.prototype.removePsClasses = function () {
		this.element.className = this.element.className.split(" ").filter(function (t) {
			return !t.match(/^ps([-_].+|)$/)
		}).join(" ")
	}, H
});




/*sub tab*/
$(document).ready(function(){
	console.log("aaaa");
const container = document.querySelector('.tabs')
const primary = container.querySelector('.-primary')
const primaryItems = container.querySelectorAll('.-primary > li:not(.-more)')
container.classList.add('--jsfied')

// insert "more" button and duplicate the list

primary.insertAdjacentHTML('beforeend', `
  <li class="-more">
    <button type="button" aria-haspopup="true" aria-expanded="false">
      More <span>&darr;</span>
    </button>
    <ul class="-secondary">
      ${primary.innerHTML}
    </ul>
  </li>
`)
const secondary = container.querySelector('.-secondary')
const secondaryItems = secondary.querySelectorAll('li')
const allItems = container.querySelectorAll('li')
const moreLi = primary.querySelector('.-more')
const moreBtn = moreLi.querySelector('button')
moreBtn.addEventListener('click', (e) => {
  e.preventDefault()
  container.classList.toggle('--show-secondary')
  moreBtn.setAttribute('aria-expanded', container.classList.contains('--show-secondary'))
})

// adapt tabs

const doAdapt = () => {
  // reveal all items for the calculation
  allItems.forEach((item) => {
    item.classList.remove('--hidden')
  })

  // hide items that won't fit in the Primary
  let stopWidth = moreBtn.offsetWidth
  let hiddenItems = []
  const primaryWidth = primary.offsetWidth
  primaryItems.forEach((item, i) => {
    if(primaryWidth >= stopWidth + item.offsetWidth) {
      stopWidth += item.offsetWidth
    } else {
      item.classList.add('--hidden')
      hiddenItems.push(i)
    }
  })
  
  // toggle the visibility of More button and items in Secondary
  if(!hiddenItems.length) {
    moreLi.classList.add('--hidden')
    container.classList.remove('--show-secondary')
    moreBtn.setAttribute('aria-expanded', false)
  }
  else {  
    secondaryItems.forEach((item, i) => {
      if(!hiddenItems.includes(i)) {
        item.classList.add('--hidden')
      }
    })
  }
}

doAdapt() // adapt immediately on load
window.addEventListener('resize', doAdapt) // adapt on window resize

// hide Secondary on the outside click

document.addEventListener('click', (e) => {
  let el = e.target
  while(el) {
    if(el === secondary || el === moreBtn) {
      return;
    }
    el = el.parentNode
  }
  container.classList.remove('--show-secondary')
  moreBtn.setAttribute('aria-expanded', false)
})
});
