define("arale-class/1.2.0/class", [], function (t, n, r) {
    function o(t) {
        return this instanceof o || !f(t) ? void 0 : i(t)
    }

    function e(t) {
        var n, r;
        for (n in t)r = t[n], o.Mutators.hasOwnProperty(n) ? o.Mutators[n].call(this, r) : this.prototype[n] = r
    }

    function i(t) {
        return t.extend = o.extend, t.implement = e, t
    }

    function s() {
    }

    function c(t, n, r) {
        for (var o in n)if (n.hasOwnProperty(o)) {
            if (r && -1 === l(r, o))continue;
            "prototype" !== o && (t[o] = n[o])
        }
    }

    r.exports = o, o.create = function (t, n) {
        function r() {
            t.apply(this, arguments), this.constructor === r && this.initialize && this.initialize.apply(this, arguments)
        }

        return f(t) || (n = t, t = null), n || (n = {}), t || (t = n.Extends || o), n.Extends = t, t !== o && c(r, t, t.StaticsWhiteList), e.call(r, n), i(r)
    }, o.extend = function (t) {
        return t || (t = {}), t.Extends = this, o.create(t)
    }, o.Mutators = {
        Extends: function (t) {
            var n = this.prototype, r = u(t.prototype);
            c(r, n), r.constructor = this, this.prototype = r, this.superclass = t.prototype
        }, Implements: function (t) {
            p(t) || (t = [t]);
            for (var n, r = this.prototype; n = t.shift();)c(r, n.prototype || n)
        }, Statics: function (t) {
            c(this, t)
        }
    };
    var u = Object.__proto__ ? function (t) {
        return {__proto__: t}
    } : function (t) {
        return s.prototype = t, new s
    }, a = Object.prototype.toString, p = Array.isArray || function (t) {
            return "[object Array]" === a.call(t)
        }, f = function (t) {
        return "[object Function]" === a.call(t)
    }, l = Array.prototype.indexOf ? function (t, n) {
        return t.indexOf(n)
    } : function (t, n) {
        for (var r = 0, o = t.length; o > r; r++)if (t[r] === n)return r;
        return -1
    }
});