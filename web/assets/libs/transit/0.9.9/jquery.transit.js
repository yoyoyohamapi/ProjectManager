define(function (b, a, c) {
    /*!
     * jQuery Transit - CSS3 transitions and transformations
     * (c) 2011-2012 Rico Sta. Cruz
     * MIT Licensed.
     *
     * http://ricostacruz.com/jquery.transit
     * http://github.com/rstacruz/jquery.transit
     */
    var d = b("jquery");
    (function (o) {
        o.transit = {
            version: "0.9.9",
            propertyMap: {
                marginLeft: "margin",
                marginRight: "margin",
                marginBottom: "margin",
                marginTop: "margin",
                paddingLeft: "padding",
                paddingRight: "padding",
                paddingBottom: "padding",
                paddingTop: "padding"
            },
            enabled: true,
            useTransitionEnd: false
        };
        var h = document.createElement("div");
        var u = {};

        function f(z) {
            if (z in h.style) {
                return z
            }
            var y = ["Moz", "Webkit", "O", "ms"];
            var v = z.charAt(0).toUpperCase() + z.substr(1);
            if (z in h.style) {
                return z
            }
            for (var x = 0; x < y.length; ++x) {
                var w = y[x] + v;
                if (w in h.style) {
                    return w
                }
            }
        }

        function i() {
            h.style[u.transform] = "";
            h.style[u.transform] = "rotateY(90deg)";
            return h.style[u.transform] !== ""
        }

        var e = navigator.userAgent.toLowerCase().indexOf("chrome") > -1;
        u.transition = f("transition");
        u.transitionDelay = f("transitionDelay");
        u.transform = f("transform");
        u.transformOrigin = f("transformOrigin");
        u.filter = f("Filter");
        u.transform3d = i();
        var m = {
            "transition": "transitionEnd",
            "MozTransition": "transitionend",
            "OTransition": "oTransitionEnd",
            "WebkitTransition": "webkitTransitionEnd",
            "msTransition": "MSTransitionEnd"
        };
        var j = u.transitionEnd = m[u.transition] || null;
        for (var t in u) {
            if (u.hasOwnProperty(t) && typeof o.support[t] === "undefined") {
                o.support[t] = u[t]
            }
        }
        h = null;
        o.cssEase = {
            "_default": "ease",
            "in": "ease-in",
            "out": "ease-out",
            "in-out": "ease-in-out",
            "snap": "cubic-bezier(0,1,.5,1)",
            "easeOutCubic": "cubic-bezier(.215,.61,.355,1)",
            "easeInOutCubic": "cubic-bezier(.645,.045,.355,1)",
            "easeInCirc": "cubic-bezier(.6,.04,.98,.335)",
            "easeOutCirc": "cubic-bezier(.075,.82,.165,1)",
            "easeInOutCirc": "cubic-bezier(.785,.135,.15,.86)",
            "easeInExpo": "cubic-bezier(.95,.05,.795,.035)",
            "easeOutExpo": "cubic-bezier(.19,1,.22,1)",
            "easeInOutExpo": "cubic-bezier(1,0,0,1)",
            "easeInQuad": "cubic-bezier(.55,.085,.68,.53)",
            "easeOutQuad": "cubic-bezier(.25,.46,.45,.94)",
            "easeInOutQuad": "cubic-bezier(.455,.03,.515,.955)",
            "easeInQuart": "cubic-bezier(.895,.03,.685,.22)",
            "easeOutQuart": "cubic-bezier(.165,.84,.44,1)",
            "easeInOutQuart": "cubic-bezier(.77,0,.175,1)",
            "easeInQuint": "cubic-bezier(.755,.05,.855,.06)",
            "easeOutQuint": "cubic-bezier(.23,1,.32,1)",
            "easeInOutQuint": "cubic-bezier(.86,0,.07,1)",
            "easeInSine": "cubic-bezier(.47,0,.745,.715)",
            "easeOutSine": "cubic-bezier(.39,.575,.565,1)",
            "easeInOutSine": "cubic-bezier(.445,.05,.55,.95)",
            "easeInBack": "cubic-bezier(.6,-.28,.735,.045)",
            "easeOutBack": "cubic-bezier(.175, .885,.32,1.275)",
            "easeInOutBack": "cubic-bezier(.68,-.55,.265,1.55)"
        };
        o.cssHooks["transit:transform"] = {
            get: function (v) {
                return o(v).data("transform") || new n()
            }, set: function (x, w) {
                var y = w;
                if (!(y instanceof n)) {
                    y = new n(y)
                }
                if (u.transform === "WebkitTransform" && !e) {
                    x.style[u.transform] = y.toString(true)
                } else {
                    x.style[u.transform] = y.toString()
                }
                o(x).data("transform", y)
            }
        };
        o.cssHooks.transform = {set: o.cssHooks["transit:transform"].set};
        o.cssHooks.filter = {
            get: function (v) {
                return v.style[u.filter]
            }, set: function (v, w) {
                v.style[u.filter] = w
            }
        };
        if (o.fn.jquery < "1.8") {
            o.cssHooks.transformOrigin = {
                get: function (v) {
                    return v.style[u.transformOrigin]
                }, set: function (v, w) {
                    v.style[u.transformOrigin] = w
                }
            };
            o.cssHooks.transition = {
                get: function (v) {
                    return v.style[u.transition]
                }, set: function (v, w) {
                    v.style[u.transition] = w
                }
            }
        }
        r("scale");
        r("translate");
        r("rotate");
        r("rotateX");
        r("rotateY");
        r("rotate3d");
        r("perspective");
        r("skewX");
        r("skewY");
        r("x", true);
        r("y", true);
        function n(v) {
            if (typeof v === "string") {
                this.parse(v)
            }
            return this
        }

        n.prototype = {
            setFromString: function (x, w) {
                var v = (typeof w === "string") ? w.split(",") : (w.constructor === Array) ? w : [w];
                v.unshift(x);
                n.prototype.set.apply(this, v)
            }, set: function (w) {
                var v = Array.prototype.slice.apply(arguments, [1]);
                if (this.setter[w]) {
                    this.setter[w].apply(this, v)
                } else {
                    this[w] = v.join(",")
                }
            }, get: function (v) {
                if (this.getter[v]) {
                    return this.getter[v].apply(this)
                } else {
                    return this[v] || 0
                }
            }, setter: {
                rotate: function (v) {
                    this.rotate = s(v, "deg")
                }, rotateX: function (v) {
                    this.rotateX = s(v, "deg")
                }, rotateY: function (v) {
                    this.rotateY = s(v, "deg")
                }, scale: function (v, w) {
                    if (w === undefined) {
                        w = v
                    }
                    this.scale = v + "," + w
                }, skewX: function (v) {
                    this.skewX = s(v, "deg")
                }, skewY: function (v) {
                    this.skewY = s(v, "deg")
                }, perspective: function (v) {
                    this.perspective = s(v, "px")
                }, x: function (v) {
                    this.set("translate", v, null)
                }, y: function (v) {
                    this.set("translate", null, v)
                }, translate: function (v, w) {
                    if (this._translateX === undefined) {
                        this._translateX = 0
                    }
                    if (this._translateY === undefined) {
                        this._translateY = 0
                    }
                    if (v !== null && v !== undefined) {
                        this._translateX = s(v, "px")
                    }
                    if (w !== null && w !== undefined) {
                        this._translateY = s(w, "px")
                    }
                    this.translate = this._translateX + "," + this._translateY
                }
            }, getter: {
                x: function () {
                    return this._translateX || 0
                }, y: function () {
                    return this._translateY || 0
                }, scale: function () {
                    var v = (this.scale || "1,1").split(",");
                    if (v[0]) {
                        v[0] = parseFloat(v[0])
                    }
                    if (v[1]) {
                        v[1] = parseFloat(v[1])
                    }
                    return (v[0] === v[1]) ? v[0] : v
                }, rotate3d: function () {
                    var w = (this.rotate3d || "0,0,0,0deg").split(",");
                    for (var v = 0; v <= 3; ++v) {
                        if (w[v]) {
                            w[v] = parseFloat(w[v])
                        }
                    }
                    if (w[3]) {
                        w[3] = s(w[3], "deg")
                    }
                    return w
                }
            }, parse: function (w) {
                var v = this;
                w.replace(/([a-zA-Z0-9]+)\((.*?)\)/g, function (y, A, z) {
                    v.setFromString(A, z)
                })
            }, toString: function (x) {
                var w = [];
                for (var v in this) {
                    if (this.hasOwnProperty(v)) {
                        if ((!u.transform3d) && ((v === "rotateX") || (v === "rotateY") || (v === "perspective") || (v === "transformOrigin"))) {
                            continue
                        }
                        if (v[0] !== "_") {
                            if (x && (v === "scale")) {
                                w.push(v + "3d(" + this[v] + ",1)")
                            } else {
                                if (x && (v === "translate")) {
                                    w.push(v + "3d(" + this[v] + ",0)")
                                } else {
                                    w.push(v + "(" + this[v] + ")")
                                }
                            }
                        }
                    }
                }
                return w.join(" ")
            }
        };
        function q(w, v, x) {
            if (v === true) {
                w.queue(x)
            } else {
                if (v) {
                    w.queue(v, x)
                } else {
                    x()
                }
            }
        }

        function l(w) {
            var v = [];
            o.each(w, function (x) {
                x = o.camelCase(x);
                x = o.transit.propertyMap[x] || o.cssProps[x] || x;
                x = g(x);
                if (u[x]) {
                    x = g(u[x])
                }
                if (o.inArray(x, v) === -1) {
                    v.push(x)
                }
            });
            return v
        }

        function k(w, z, B, v) {
            var x = l(w);
            if (o.cssEase[B]) {
                B = o.cssEase[B]
            }
            var A = "" + p(z) + " " + B;
            if (parseInt(v, 10) > 0) {
                A += " " + p(v)
            }
            var y = [];
            o.each(x, function (D, C) {
                y.push(C + " " + A)
            });
            return y.join(", ")
        }

        o.fn.transition = o.fn.transit = function (E, x, D, H) {
            var I = this;
            var z = 0;
            var B = true;
            var v = d.extend(true, {}, E);
            if (typeof x === "function") {
                H = x;
                x = undefined
            }
            if (typeof x === "object") {
                D = x.easing;
                z = x.delay || 0;
                B = x.queue || true;
                H = x.complete;
                x = x.duration
            }
            if (typeof D === "function") {
                H = D;
                D = undefined
            }
            if (typeof v.easing !== "undefined") {
                D = v.easing;
                delete v.easing
            }
            if (typeof v.duration !== "undefined") {
                x = v.duration;
                delete v.duration
            }
            if (typeof v.complete !== "undefined") {
                H = v.complete;
                delete v.complete
            }
            if (typeof v.queue !== "undefined") {
                B = v.queue;
                delete v.queue
            }
            if (typeof v.delay !== "undefined") {
                z = v.delay;
                delete v.delay
            }
            if (typeof x === "undefined") {
                x = o.fx.speeds._default
            }
            if (typeof D === "undefined") {
                D = o.cssEase._default
            }
            x = p(x);
            var J = k(v, x, D, z);
            var G = o.transit.enabled && u.transition;
            var y = G ? (parseInt(x, 10) + parseInt(z, 10)) : 0;
            if (y === 0) {
                var F = function (K) {
                    I.css(v);
                    if (H) {
                        H.apply(I)
                    }
                    if (K) {
                        K()
                    }
                };
                q(I, B, F);
                return I
            }
            var C = {};
            var w = function (M) {
                var L = false;
                var K = function () {
                    if (L) {
                        I.unbind(j, K)
                    }
                    if (y > 0) {
                        I.each(function () {
                            this.style[u.transition] = (C[this] || null)
                        })
                    }
                    if (typeof H === "function") {
                        H.apply(I)
                    }
                    if (typeof M === "function") {
                        M()
                    }
                };
                if ((y > 0) && (j) && (o.transit.useTransitionEnd)) {
                    L = true;
                    I.bind(j, K)
                } else {
                    window.setTimeout(K, y)
                }
                I.each(function () {
                    if (y > 0) {
                        this.style[u.transition] = J
                    }
                    o(this).css(E)
                })
            };
            var A = function (K) {
                this.offsetWidth;
                w(K)
            };
            q(I, B, A);
            return this
        };
        function r(w, v) {
            if (!v) {
                o.cssNumber[w] = true
            }
            o.transit.propertyMap[w] = u.transform;
            o.cssHooks[w] = {
                get: function (y) {
                    var x = o(y).css("transit:transform");
                    return x.get(w)
                }, set: function (y, z) {
                    var x = o(y).css("transit:transform");
                    x.setFromString(w, z);
                    o(y).css({"transit:transform": x})
                }
            }
        }

        function g(v) {
            return v.replace(/([A-Z])/g, function (w) {
                return "-" + w.toLowerCase()
            })
        }

        function s(w, v) {
            if ((typeof w === "string") && (!w.match(/^[\-0-9\.]+$/))) {
                return w
            } else {
                return "" + w + v
            }
        }

        function p(w) {
            var v = w;
            if (typeof v === "string" && (!v.match(/^[\-0-9\.]+/))) {
                v = o.fx.speeds[v] || o.fx.speeds._default
            }
            return s(v, "ms")
        }

        o.transit.getTransitionValue = k
    })(d)
});