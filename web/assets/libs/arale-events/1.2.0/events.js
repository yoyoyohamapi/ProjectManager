define("arale-events/1.2.0/events", [], function (t, e, r) {
    function n() {
    }

    function o(t, e, r) {
        var n = !0;
        if (t) {
            var o = 0, i = t.length, s = e[0], a = e[1], f = e[2];
            switch (e.length) {
                case 0:
                    for (; i > o; o += 2)n = t[o].call(t[o + 1] || r) !== !1 && n;
                    break;
                case 1:
                    for (; i > o; o += 2)n = t[o].call(t[o + 1] || r, s) !== !1 && n;
                    break;
                case 2:
                    for (; i > o; o += 2)n = t[o].call(t[o + 1] || r, s, a) !== !1 && n;
                    break;
                case 3:
                    for (; i > o; o += 2)n = t[o].call(t[o + 1] || r, s, a, f) !== !1 && n;
                    break;
                default:
                    for (; i > o; o += 2)n = t[o].apply(t[o + 1] || r, e) !== !1 && n
            }
        }
        return n
    }

    function i(t) {
        return "[object Function]" === Object.prototype.toString.call(t)
    }

    var s = /\s+/;
    n.prototype.on = function (t, e, r) {
        var n, o, i;
        if (!e)return this;
        for (n = this.__events || (this.__events = {}), t = t.split(s); o = t.shift();)i = n[o] || (n[o] = []), i.push(e, r);
        return this
    }, n.prototype.once = function (t, e, r) {
        var n = this, o = function () {
            n.off(t, o), e.apply(r || n, arguments)
        };
        return this.on(t, o, r)
    }, n.prototype.off = function (t, e, r) {
        var n, o, i, f;
        if (!(n = this.__events))return this;
        if (!(t || e || r))return delete this.__events, this;
        for (t = t ? t.split(s) : a(n); o = t.shift();)if (i = n[o])if (e || r)for (f = i.length - 2; f >= 0; f -= 2)e && i[f] !== e || r && i[f + 1] !== r || i.splice(f, 2); else delete n[o];
        return this
    }, n.prototype.trigger = function (t) {
        var e, r, n, i, a, f, c = [], l = !0;
        if (!(e = this.__events))return this;
        for (t = t.split(s), a = 1, f = arguments.length; f > a; a++)c[a - 1] = arguments[a];
        for (; r = t.shift();)(n = e.all) && (n = n.slice()), (i = e[r]) && (i = i.slice()), "all" !== r && (l = o(i, c, this) && l), l = o(n, [r].concat(c), this) && l;
        return l
    }, n.prototype.emit = n.prototype.trigger;
    var a = Object.keys;
    a || (a = function (t) {
        var e = [];
        for (var r in t)t.hasOwnProperty(r) && e.push(r);
        return e
    }), n.mixTo = function (t) {
        function e(e) {
            t[e] = function () {
                return r[e].apply(o, Array.prototype.slice.call(arguments)), this
            }
        }

        t = i(t) ? t.prototype : t;
        var r = n.prototype, o = new n;
        for (var s in r)r.hasOwnProperty(s) && e(s)
    }, r.exports = n
});