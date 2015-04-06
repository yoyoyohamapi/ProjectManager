define("arale-base/1.2.0/base", ["arale-class/1.2.0/class", "arale-events/1.2.0/events"], function (t, r, e) {
    e.exports = t("arale-base/1.2.0/src/base")
}), define("arale-base/1.2.0/src/base", ["arale-class/1.2.0/class", "arale-events/1.2.0/events"], function (t, r, e) {
    function n(t, r) {
        for (var e in r)if (r.hasOwnProperty(e)) {
            var n = "_onChange" + a(e);
            t[n] && t.on("change:" + e, t[n])
        }
    }

    function a(t) {
        return t.charAt(0).toUpperCase() + t.substring(1)
    }

    var i = t("arale-class/1.2.0/class"), s = t("arale-events/1.2.0/events"), o = t("arale-base/1.2.0/src/aspect"), c = t("arale-base/1.2.0/src/attribute");
    e.exports = i.create({
        Implements: [s, o, c], initialize: function (t) {
            this.initAttrs(t), n(this, this.attrs)
        }, destroy: function () {
            this.off();
            for (var t in this)this.hasOwnProperty(t) && delete this[t];
            this.destroy = function () {
            }
        }
    })
}), define("arale-base/1.2.0/src/aspect", [], function (t, r) {
    function e(t, r, e, s) {
        for (var o, c, u = r.split(i); o = u.shift();)c = n(this, o), c.__isAspected || a.call(this, o), this.on(t + ":" + o, e, s);
        return this
    }

    function n(t, r) {
        var e = t[r];
        if (!e)throw new Error("Invalid method name: " + r);
        return e
    }

    function a(t) {
        var r = this[t];
        this[t] = function () {
            var e = Array.prototype.slice.call(arguments), n = ["before:" + t].concat(e);
            if (this.trigger.apply(this, n) !== !1) {
                var a = r.apply(this, arguments), i = ["after:" + t, a].concat(e);
                return this.trigger.apply(this, i), a
            }
        }, this[t].__isAspected = !0
    }

    r.before = function (t, r, n) {
        return e.call(this, "before", t, r, n)
    }, r.after = function (t, r, n) {
        return e.call(this, "after", t, r, n)
    };
    var i = /\s+/
}), define("arale-base/1.2.0/src/attribute", [], function (t, r) {
    function e(t) {
        return "[object String]" === j.call(t)
    }

    function n(t) {
        return "[object Function]" === j.call(t)
    }

    function a(t) {
        return null != t && t == t.window
    }

    function i(t) {
        if (!t || "[object Object]" !== j.call(t) || t.nodeType || a(t))return !1;
        try {
            if (t.constructor && !A.call(t, "constructor") && !A.call(t.constructor.prototype, "isPrototypeOf"))return !1
        } catch (r) {
            return !1
        }
        var e;
        if (w)for (e in t)return A.call(t, e);
        for (e in t);
        return void 0 === e || A.call(t, e)
    }

    function s(t) {
        if (!t || "[object Object]" !== j.call(t) || t.nodeType || a(t) || !t.hasOwnProperty)return !1;
        for (var r in t)if (t.hasOwnProperty(r))return !1;
        return !0
    }

    function o(t, r) {
        var e;
        for (e in r)r.hasOwnProperty(e) && (t[e] = c(r[e], t[e]));
        return t
    }

    function c(t, r) {
        return _(t) ? t = t.slice() : i(t) && (i(r) || (r = {}), t = o(r, t)), t
    }

    function u(t, r, e) {
        for (var n = [], a = r.constructor.prototype; a;)a.hasOwnProperty("attrs") || (a.attrs = {}), l(e, a.attrs, a), s(a.attrs) || n.unshift(a.attrs), a = a.constructor.superclass;
        for (var i = 0, o = n.length; o > i; i++)y(t, g(n[i]))
    }

    function f(t, r) {
        y(t, g(r, !0), !0)
    }

    function l(t, r, e, n) {
        for (var a = 0, i = t.length; i > a; a++) {
            var s = t[a];
            e.hasOwnProperty(s) && (r[s] = n ? r.get(s) : e[s])
        }
    }

    function h(t, r) {
        for (var e in r)if (r.hasOwnProperty(e)) {
            var a, i = r[e].value;
            n(i) && (a = e.match(m)) && (t[a[1]](v(a[2]), i), delete r[e])
        }
    }

    function v(t) {
        var r = t.match(x), e = r[1] ? "change:" : "";
        return e += r[2].toLowerCase() + r[3]
    }

    function p(t, r, e) {
        var n = {silent: !0};
        t.__initializingAttrs = !0;
        for (var a in e)e.hasOwnProperty(a) && r[a].setter && t.set(a, e[a], n);
        delete t.__initializingAttrs
    }

    function g(t, r) {
        var e = {};
        for (var n in t) {
            var a = t[n];
            e[n] = !r && i(a) && b(a, C) ? a : {value: a}
        }
        return e
    }

    function y(t, r, e) {
        var n, a, i;
        for (n in r)if (r.hasOwnProperty(n)) {
            if (a = r[n], i = t[n], i || (i = t[n] = {}), void 0 !== a.value && (i.value = c(a.value, i.value)), e)continue;
            for (var s in S) {
                var o = S[s];
                void 0 !== a[o] && (i[o] = a[o])
            }
        }
        return t
    }

    function b(t, r) {
        for (var e = 0, n = r.length; n > e; e++)if (t.hasOwnProperty(r[e]))return !0;
        return !1
    }

    function d(t) {
        return null == t || (e(t) || _(t)) && 0 === t.length || s(t)
    }

    function O(t, r) {
        if (t === r)return !0;
        if (d(t) && d(r))return !0;
        var e = j.call(t);
        if (e != j.call(r))return !1;
        switch (e) {
            case"[object String]":
                return t == String(r);
            case"[object Number]":
                return t != +t ? r != +r : 0 == t ? 1 / t == 1 / r : t == +r;
            case"[object Date]":
            case"[object Boolean]":
                return +t == +r;
            case"[object RegExp]":
                return t.source == r.source && t.global == r.global && t.multiline == r.multiline && t.ignoreCase == r.ignoreCase;
            case"[object Array]":
                var n = t.toString(), a = r.toString();
                return -1 === n.indexOf("[object") && -1 === a.indexOf("[object") && n === a
        }
        if ("object" != typeof t || "object" != typeof r)return !1;
        if (i(t) && i(r)) {
            if (!O(P(t), P(r)))return !1;
            for (var s in t)if (t[s] !== r[s])return !1;
            return !0
        }
        return !1
    }

    r.initAttrs = function (t) {
        var r = this.attrs = {}, e = this.propsInAttrs || [];
        u(r, this, e), t && f(r, t), p(this, r, t), h(this, r), l(e, this, r, !0)
    }, r.get = function (t) {
        var r = this.attrs[t] || {}, e = r.value;
        return r.getter ? r.getter.call(this, e, t) : e
    }, r.set = function (t, r, n) {
        var a = {};
        e(t) ? a[t] = r : (a = t, n = r), n || (n = {});
        var s = n.silent, c = n.override, u = this.attrs, f = this.__changedAttrs || (this.__changedAttrs = {});
        for (t in a)if (a.hasOwnProperty(t)) {
            var l = u[t] || (u[t] = {});
            if (r = a[t], l.readOnly)throw new Error("This attribute is readOnly: " + t);
            l.setter && (r = l.setter.call(this, r, t));
            var h = this.get(t);
            !c && i(h) && i(r) && (r = o(o({}, h), r)), u[t].value = r, this.__initializingAttrs || O(h, r) || (s ? f[t] = [r, h] : this.trigger("change:" + t, r, h, t))
        }
        return this
    }, r.change = function () {
        var t = this.__changedAttrs;
        if (t) {
            for (var r in t)if (t.hasOwnProperty(r)) {
                var e = t[r];
                this.trigger("change:" + r, e[0], e[1], r)
            }
            delete this.__changedAttrs
        }
        return this
    }, r._isPlainObject = i;
    var w, j = Object.prototype.toString, A = Object.prototype.hasOwnProperty;
    !function () {
        function t() {
            this.x = 1
        }

        var r = [];
        t.prototype = {valueOf: 1, y: 1};
        for (var e in new t)r.push(e);
        w = "x" !== r[0]
    }();
    var _ = Array.isArray || function (t) {
            return "[object Array]" === j.call(t)
        }, P = Object.keys;
    P || (P = function (t) {
        var r = [];
        for (var e in t)t.hasOwnProperty(e) && r.push(e);
        return r
    });
    var m = /^(on|before|after)([A-Z].*)$/, x = /^(Change)?([A-Z])(.*)/, C = ["value", "getter", "setter", "readOnly"], S = ["setter", "getter", "readOnly"]
});