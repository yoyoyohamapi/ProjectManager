define("arale-widget/1.2.0/widget", ["arale-base/1.2.0/base", "arale-class/1.2.0/class", "arale-events/1.2.0/events", "jquery"], function (e, t, n) {
    n.exports = e("arale-widget/1.2.0/src/widget")
}), define("arale-widget/1.2.0/src/widget", ["arale-base/1.2.0/base", "arale-class/1.2.0/class", "arale-events/1.2.0/events", "jquery"], function (e, t, n) {
    function r() {
        return "widget-" + b++
    }

    function i(e) {
        return "[object String]" === A.call(e)
    }

    function a(e) {
        return "[object Function]" === A.call(e)
    }

    function s(e) {
        return O(document.documentElement, e)
    }

    function o(e) {
        return e.charAt(0).toUpperCase() + e.substring(1)
    }

    function l(e) {
        return a(e.events) && (e.events = e.events()), e.events
    }

    function u(e, t) {
        var n = e.match(R), r = n[1] + g + t.cid, i = n[2] || void 0;
        return i && i.indexOf("{{") > -1 && (i = d(i, t)), {type: r, selector: i}
    }

    function d(e, t) {
        return e.replace(C, function (e, n) {
            for (var r, a = n.split("."), s = t; r = a.shift();)s = s === t.attrs ? t.get(r) : s[r];
            return i(s) ? s : j
        })
    }

    function f(e) {
        return null == e || void 0 === e
    }

    function c(e) {
        for (var t = e.length - 1; t >= 0 && void 0 === e[t]; t--)e.pop();
        return e
    }

    var h = e("arale-base/1.2.0/base"), m = e("jquery"), p = e("arale-widget/1.2.0/src/daparser"), v = e("arale-widget/1.2.0/src/auto-render"), g = ".delegate-events-", y = "_onRender", w = "data-widget-cid", E = {}, _ = h.extend({
        propsInAttrs: ["initElement", "element", "events"],
        element: null,
        events: null,
        attrs: {
            id: null,
            className: null,
            style: null,
            template: "<div></div>",
            model: null,
            parentNode: document.body
        },
        initialize: function (e) {
            this.cid = r();
            var t = this._parseDataAttrsConfig(e);
            _.superclass.initialize.call(this, e ? m.extend(t, e) : t), this.parseElement(), this.initProps(), this.delegateEvents(), this.setup(), this._stamp(), this._isTemplate = !(e && e.element)
        },
        _parseDataAttrsConfig: function (e) {
            var t, n;
            return e && (t = m(e.initElement ? e.initElement : e.element)), t && t[0] && !v.isDataApiOff(t) && (n = p.parseElement(t)), n
        },
        parseElement: function () {
            var e = this.element;
            if (e ? this.element = m(e) : this.get("template") && this.parseElementFromTemplate(), !this.element || !this.element[0])throw new Error("element is invalid")
        },
        parseElementFromTemplate: function () {
            this.element = m(this.get("template"))
        },
        initProps: function () {
        },
        delegateEvents: function (e, t, n) {
            var r = c(Array.prototype.slice.call(arguments));
            if (0 === r.length ? (t = l(this), e = this.element) : 1 === r.length ? (t = e, e = this.element) : 2 === r.length ? (n = t, t = e, e = this.element) : (e || (e = this.element), this._delegateElements || (this._delegateElements = []), this._delegateElements.push(m(e))), i(t) && a(n)) {
                var s = {};
                s[t] = n, t = s
            }
            for (var o in t)if (t.hasOwnProperty(o)) {
                var d = u(o, this), f = d.type, h = d.selector;
                !function (t, n) {
                    var r = function (e) {
                        a(t) ? t.call(n, e) : n[t](e)
                    };
                    h ? m(e).on(f, h, r) : m(e).on(f, r)
                }(t[o], this)
            }
            return this
        },
        undelegateEvents: function (e, t) {
            var n = c(Array.prototype.slice.call(arguments));
            if (t || (t = e, e = null), 0 === n.length) {
                var r = g + this.cid;
                if (this.element && this.element.off(r), this._delegateElements)for (var i in this._delegateElements)this._delegateElements.hasOwnProperty(i) && this._delegateElements[i].off(r)
            } else {
                var a = u(t, this);
                e ? m(e).off(a.type, a.selector) : this.element && this.element.off(a.type, a.selector)
            }
            return this
        },
        setup: function () {
        },
        render: function () {
            this.rendered || (this._renderAndBindAttrs(), this.rendered = !0);
            var e = this.get("parentNode");
            if (e && !s(this.element[0])) {
                var t = this.constructor.outerBoxClass;
                if (t) {
                    var n = this._outerBox = m("<div></div>").addClass(t);
                    n.append(this.element).appendTo(e)
                } else this.element.appendTo(e)
            }
            return this
        },
        _renderAndBindAttrs: function () {
            var e = this, t = e.attrs;
            for (var n in t)if (t.hasOwnProperty(n)) {
                var r = y + o(n);
                if (this[r]) {
                    var i = this.get(n);
                    f(i) || this[r](i, void 0, n), function (t) {
                        e.on("change:" + n, function (n, r, i) {
                            e[t](n, r, i)
                        })
                    }(r)
                }
            }
        },
        _onRenderId: function (e) {
            this.element.attr("id", e)
        },
        _onRenderClassName: function (e) {
            this.element.addClass(e)
        },
        _onRenderStyle: function (e) {
            this.element.css(e)
        },
        _stamp: function () {
            var e = this.cid;
            (this.initElement || this.element).attr(w, e), E[e] = this
        },
        $: function (e) {
            return this.element.find(e)
        },
        destroy: function () {
            this.undelegateEvents(), delete E[this.cid], this.element && this._isTemplate && (this.element.off(), this._outerBox ? this._outerBox.remove() : this.element.remove()), this.element = null, _.superclass.destroy.call(this)
        }
    });
    m(window).unload(function () {
        for (var e in E)E[e].destroy()
    }), _.query = function (e) {
        var t, n = m(e).eq(0);
        return n && (t = n.attr(w)), E[t]
    }, _.autoRender = v.autoRender, _.autoRenderAll = v.autoRenderAll, _.StaticsWhiteList = ["autoRender"], n.exports = _;
    var A = Object.prototype.toString, b = 0, O = m.contains || function (e, t) {
            return !!(16 & e.compareDocumentPosition(t))
        }, R = /^(\S+)\s*(.*)$/, C = /{{([^}]+)}}/g, j = "INVALID_SELECTOR"
}), define("arale-widget/1.2.0/src/daparser", ["jquery"], function (e, t) {
    function n(e) {
        return e.toLowerCase().replace(s, function (e, t) {
            return (t + "").toUpperCase()
        })
    }

    function r(e) {
        for (var t in e)if (e.hasOwnProperty(t)) {
            var n = e[t];
            if ("string" != typeof n)continue;
            o.test(n) ? (n = n.replace(/'/g, '"'), e[t] = r(l(n))) : e[t] = i(n)
        }
        return e
    }

    function i(e) {
        if ("false" === e.toLowerCase())e = !1; else if ("true" === e.toLowerCase())e = !0; else if (/\d/.test(e) && /[^a-z]/i.test(e)) {
            var t = parseFloat(e);
            t + "" === e && (e = t)
        }
        return e
    }

    var a = e("jquery");
    t.parseElement = function (e, t) {
        e = a(e)[0];
        var i = {};
        if (e.dataset)i = a.extend({}, e.dataset); else for (var s = e.attributes, o = 0, l = s.length; l > o; o++) {
            var u = s[o], d = u.name;
            0 === d.indexOf("data-") && (d = n(d.substring(5)), i[d] = u.value)
        }
        return t === !0 ? i : r(i)
    };
    var s = /-([a-z])/g, o = /^\s*[\[{].*[\]}]\s*$/, l = this.JSON ? JSON.parse : a.parseJSON
}), define("arale-widget/1.2.0/src/auto-render", ["jquery"], function (e, t) {
    var n = e("jquery"), r = "data-widget-auto-rendered";
    t.autoRender = function (e) {
        return new this(e).render()
    }, t.autoRenderAll = function (e, i) {
        "function" == typeof e && (i = e, e = null), e = n(e || document.body);
        var a = [], s = [];
        e.find("[data-widget]").each(function (e, n) {
            t.isDataApiOff(n) || (a.push(n.getAttribute("data-widget").toLowerCase()), s.push(n))
        }), a.length && seajs.use(a, function () {
            for (var e = 0; e < arguments.length; e++) {
                var t = arguments[e], a = n(s[e]);
                if (!a.attr(r)) {
                    var o = {initElement: a, renderType: "auto"}, l = a.attr("data-widget-role");
                    o[l ? l : "element"] = a, t.autoRender && t.autoRender(o), a.attr(r, "true")
                }
            }
            i && i()
        })
    };
    var i = "off" === n(document.body).attr("data-api");
    t.isDataApiOff = function (e) {
        var t = n(e).attr("data-api");
        return "off" === t || "on" !== t && i
    }
});