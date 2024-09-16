/*
 * stickyNavbar.js v1.3.1
 * https://github.com/jbutko/stickyNavbar.js
 * Fancy sticky navigation jQuery plugin with smart anchor links highlighting
 *
 * Developed and maintenained under MIT licence by Jozef Butko - www.jozefbutko.com
 * http://www.opensource.org/licenses/MIT

 * Original jquery-browser code Copyright 2005, 2014 jQuery Foundation, Inc. and other contributors
 * http://jquery.org/license
 *
 * CREDITS:
 * Daniel Eden for Animate.CSS:
 * http://daneden.github.io/animate.css/
 * jQuery easing plugin:
 * http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * COPYRIGHT (C) 2014 Jozef Butko
 * https://github.com/jbutko
 * LAST UPDATE: 06/06/2015
 *
 */
(function (s, i, t) {
    "use strict";
    s.fn.stickyNavbar = function (e) {
        var a = Object.assign({
            activeClass: "active",
            sectionSelector: "scrollto",
            animDuration: 750,
            startAt: 0,
            easing: "swing",
            animateCSS: true,
            animateCSSRepeat: false,
            cssAnimation: "fadeIn",
            jqueryEffects: false,
            jqueryAnim: "slideDown",
            selector: "a",
            mobile: false,
            mobileWidth: 480,
            zindex: 9999,
            stickyModeClass: "sticky",
            unstickyModeClass: "unsticky"
        }, e);

        var n = s("." + a.sectionSelector);
        n.attr("tabindex", -1);

        return this.each(function () {
            var e = s(this),
                o = e.css("position"),
                r = e.css("zIndex"),
                d = e.outerHeight(true),
                l = e.offset().top - d,
                c = e.css("top") === "auto" ? 0 : e.css("top"),
                m = e.find(a.selector === "a" ? "li a" : "li");

            m.on("click", function (i) {
                var o, r, l, c, m;
                o = a.selector === "li" ? s(this).children("a").attr("href") : s(this).attr("href");
                
                if (o.startsWith("http") || o.startsWith("https") || o.startsWith("mailto:") || o.startsWith("/")) {
                    return true;
                }

                i.preventDefault();
                r = o.substr(1);

                var scrollPositions = {};
                n.each(function () {
                    scrollPositions[this.id] = this.offsetTop;
                });

                var targetScrollPos = e.hasClass(a.unstickyModeClass) ? scrollPositions[r] - 2 * d + 2 + "px" : scrollPositions[r] - d + 2 + "px";

                s("html, body").stop().animate({ scrollTop: targetScrollPos }, {
                    duration: a.animDuration,
                    easing: a.easing,
                    complete: function () {
                        t.getElementById(r).focus();
                    }
                });
            });

            var updateStickyNavbar = function () {
                var scrollTop = s(i).scrollTop();
                var windowWidth = s(i).width();
                var windowHeight = s(i).height();

                if (!a.mobile && windowWidth < a.mobileWidth) {
                    e.css("position", o);
                    return;
                }

                m.removeClass(a.activeClass);
                n.each(function () {
                    var sectionTop = s(this).offset().top - d;
                    var sectionBottom = sectionTop + s(this).outerHeight(true);
                    
                    if (scrollTop >= sectionTop && scrollTop < sectionBottom) {
                        var target = a.selector === "a" ? 'li a[href~="#' + this.id + '"]' : 'li a[href~="#' + this.id + '"]';
                        e.find(target).addClass(a.activeClass);
                    }
                });

                if (scrollTop >= l + a.startAt) {
                    e.removeClass(a.unstickyModeClass).addClass(" " + a.stickyModeClass).css({
                        position: "fixed",
                        zIndex: a.zindex
                    });

                    if (a.jqueryEffects) {
                        if (a.animateCSSRepeat) {
                            e.hide().stop()[a.jqueryAnim](a.animDuration, a.easing);
                        }
                        e.hide().stop()[a.jqueryAnim](a.animDuration, a.easing);
                    } else if (a.animateCSS) {
                        if (a.animateCSSRepeat) {
                            e.addClass(a.cssAnimation + " animated").one("animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd", function () {
                                e.removeClass(a.cssAnimation + " animated");
                            });
                        } else {
                            e.addClass(a.cssAnimation + " animated").one("animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd");
                        }
                    }
                } else {
                    e.css({
                        position: o,
                        zIndex: r
                    }).removeClass(a.stickyModeClass).addClass(" " + a.unstickyModeClass);
                }

                if (typeof h !== "undefined") {
                    var lastSection = n.last();
                    var lastSectionBottom = lastSection.offset().top + lastSection.outerHeight(true);

                    if (scrollTop + windowHeight >= s(t).height() && lastSectionBottom >= scrollTop) {
                        m.removeClass(a.activeClass).last().addClass(a.activeClass);
                    }

                    if (l - 2 >= scrollTop) {
                        e.removeClass(a.cssAnimation + " animated");

                        if (a.jqueryEffects) {
                            if (scrollTop === 0) m.removeClass(a.activeClass);
                            if (scrollTop >= l) {
                                e.css({ position: "fixed", zIndex: a.zindex }).hide().stop()[a.jqueryAnim](a.animDuration, a.easing);
                            } else {
                                e.css({ position: o, zIndex: a.zindex });
                            }
                        } else {
                            if (scrollTop === 0) m.removeClass(a.activeClass);
                            e.css({ position: o, top: c }).stop().animate({ top: c }, a.animDuration, a.easing);
                        }
                    }
                }
            };

            s(i).on("scroll", updateStickyNavbar);
            s(i).on("ready", updateStickyNavbar);
            s(i).on("resize", updateStickyNavbar);
            s(i).on("load", updateStickyNavbar);
        });
    };
}(jQuery, window, document));
