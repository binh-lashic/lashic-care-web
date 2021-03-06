"use strict";
!function (t) {
    t.fn.circliful = function (i, e) {
        var a = t.extend({
            animationstep: 1,
            bgcolor      : "#eee",
            border       : "default",
            bordersize   : 10,
            complete     : null,
            delay        : 0,
            dimension    : 200,
            fgcolor      : "#556b2f",
            fill         : !1,
            fontsize     : 15,
            iconcolor    : "#999",
            iconsize     : "20px",
            percent      : 50,
            startdegree  : 0,
            width        : 15
        }, i);
        return this.each(function () {
            function e(i, e, a) {
                t("<span></span>")
                    .appendTo(i)
                    .addClass(e)
                    .html(c)
                    .prepend(p)
                    .css({
                        "font-size"  : f.fontsize + "px",
                        "line-height": a + "px"
                    })
            }
            function n(i, e) {
                t("<span></span>")
                    .appendTo(i)
                    .addClass("circle-info-half")
                    .css("line-height", f.dimension * e + "px")
                    .text(l)
            }
            function o(i) {
                t
                    .each(h, function (e, n) {
                        void 0 != i.data(n)
                            ? f[n] = i.data(n)
                            : f[n] = t(a).attr(n),
                        "fill" == n && void 0 != i.data("fill") && (v = !0)
                    })
            }
            function d() {
                P.clearRect(0, 0, y.width, y.height),
                P.beginPath(),
                P.arc(M, w, C, F, k, !1),
                P.lineWidth   = f.bordersize + 1,
                P.strokeStyle = f.bgcolor,
                P.stroke(),
                f.fill && (P.fillStyle = f.fill, P.fill())
            }
            function s(e) {
                d(),
                P.beginPath(),
                P.arc(M, w, C, -R + A, W * e - R + A, !1),
                "outline" == f.border
                    ? P.lineWidth = f.width + f.bordersize
                    : "inline" == f.border && (P.lineWidth = f.width - f.bordersize),
                P.strokeStyle     = f.fgcolor,
                P.stroke(),
                m > T && (T += S, requestAnimationFrame(function () {
                    s(Math.min(T, m) / 100)
                }, u)),
                T == m && q && "undefined" != typeof i && t.isFunction(i.complete) && (i.complete(), q = !1)
            }
            var r,
                c,
                l,
                h = [
                    "fgcolor",
                    "bgcolor",
                    "fill",
                    "width",
                    "dimension",
                    "fontsize",
                    "animationstep",
                    "endPercent",
                    "icon",
                    "iconcolor",
                    "iconsize",
                    "border",
                    "startdegree",
                    "bordersize",
                    "delay"
                ],
                f = {},
                p = "",
                u = t(this),
                v = !1;
            u.addClass("circliful"),
            o(u);
            var m = f.endPercent || 0;
            if (void 0 != u.attr("data-text") && (c = u.attr("data-text"), void 0 != u.attr("data-icon") && (p = t("<i></i>").addClass("fa " + t(this).attr("data-icon")).css({"font-size": f.iconsize, color: f.iconcolor})), void 0 != u.attr("data-type")
                ? (j = t(this).attr("data-type"), "half" == j
                    ? e(u, "circle-text-half", f.dimension / 1.45)
                    : e(u, "circle-text", f.dimension))
                : e(u, "circle-text", f.dimension)), void 0 != t(this).attr("data-total") && void 0 != t(this).attr("data-part")) {
                var g = t(this).attr("data-total") / 100;
                r = (t(this).attr("data-part") / g / 100).toFixed(3),
                m = (t(this).attr("data-part") / g).toFixed(3)
            } else 
                void 0 != t(this).attr("data-percent")
                    ? (r = t(this).attr("data-percent") / 100, m = t(this).attr("data-percent"))
                    : r = a.percent / 100;
            void 0 != t(this).attr("data-info") && (l = t(this).attr("data-info"), void 0 != t(this).attr("data-type")
                ? (j = t(this).attr("data-type"), "half" == j
                    ? n(u, .9)
                    : n(u, 1.25))
                : n(u, 1.25)),
            t(this).width(f.dimension + "px");
            var x = f.dimension,
                y = t("<canvas></canvas>")
                    .attr({height: x, width: x})
                    .appendTo(t(this))
                    .get(0),
                P = y.getContext("2d"),
                b = window.devicePixelRatio;
            if (b) {
                var z = t(y);
                z.css("width", x),
                z.css("height", x),
                z.attr("width", x * b),
                z.attr("height", x * b),
                P.scale(b, b)
            }
            var M = (t(y).parent(), x / 2),
                w = x / 2,
                I = 360 * f.percent,
                C = (I * (Math.PI / 180), x / 2.5),
                k = 2.3 * Math.PI,
                F = 0,
                T = 0 === f.animationstep
                    ? m
                    : 0,
                S = Math.max(f.animationstep, 0),
                W = 2 * Math.PI,
                R = Math.PI / 2,
                j = "",
                q = !0,
                A = f.startdegree / 180 * Math.PI,
                Q = f.delay;
            void 0 != t(this).attr("data-type") && (j = t(this).attr("data-type"), "half" == j && (k = 2 * Math.PI, F = 3.13, W = Math.PI, R = Math.PI / .996)),
            void 0 != t(this).attr("data-type") && (j = t(this).attr("data-type"), "angle" == j && (k = 2.25 * Math.PI, F = 2.4, W = 1.53 + Math.PI, R = .73 + Math.PI / .996)),
            setTimeout(function () {
                s(T / 100)
            }, Q)
        })
    }
}(jQuery);