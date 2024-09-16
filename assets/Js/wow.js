(function() {
    var Util, WeakMap, MutationObserver, getComputedStyle, vendorPrefixes, WOW;

    Util = (function() {
        function Util() {}

        Util.prototype.extend = function(target, source) {
            for (var key in source) {
                if (source.hasOwnProperty(key) && target[key] == null) {
                    target[key] = source[key];
                }
            }
            return target;
        };

        Util.prototype.isMobile = function(agent) {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(agent);
        };

        Util.prototype.createEvent = function(name, bubbles, cancelable, detail) {
            var event;
            if (bubbles == null) bubbles = false;
            if (cancelable == null) cancelable = false;
            if (detail == null) detail = null;
            if (typeof document.createEvent === 'function') {
                event = document.createEvent('CustomEvent');
                event.initCustomEvent(name, bubbles, cancelable, detail);
            } else if (typeof document.createEventObject === 'function') {
                event = document.createEventObject();
                event.eventType = name;
            } else {
                event = { eventName: name };
            }
            return event;
        };

        Util.prototype.emitEvent = function(element, event) {
            if (element.dispatchEvent) {
                return element.dispatchEvent(event);
            } else if (event in element) {
                return element[event]();
            } else if ('on' + event in element) {
                return element['on' + event]();
            }
        };

        Util.prototype.addEvent = function(element, event, handler) {
            if (element.addEventListener) {
                return element.addEventListener(event, handler, false);
            } else if (element.attachEvent) {
                return element.attachEvent('on' + event, handler);
            } else {
                return element[event] = handler;
            }
        };

        Util.prototype.removeEvent = function(element, event, handler) {
            if (element.removeEventListener) {
                return element.removeEventListener(event, handler, false);
            } else if (element.detachEvent) {
                return element.detachEvent('on' + event, handler);
            } else {
                return delete element[event];
            }
        };

        Util.prototype.innerHeight = function() {
            return 'innerHeight' in window ? window.innerHeight : document.documentElement.clientHeight;
        };

        return Util;
    })();

    WeakMap = (function() {
        function WeakMap() {
            this.keys = [];
            this.values = [];
        }

        WeakMap.prototype.get = function(key) {
            var index = this.keys.indexOf(key);
            return index > -1 ? this.values[index] : undefined;
        };

        WeakMap.prototype.set = function(key, value) {
            var index = this.keys.indexOf(key);
            if (index > -1) {
                this.values[index] = value;
            } else {
                this.keys.push(key);
                this.values.push(value);
            }
        };

        return WeakMap;
    })();

    MutationObserver = (function() {
        function MutationObserver() {
            if (typeof console !== 'undefined' && console !== null) {
                console.warn('MutationObserver is not supported by your browser.');
                console.warn('WOW.js cannot detect dom mutations, please call .sync() after loading new content.');
            }
        }

        MutationObserver.prototype.observe = function() {};

        MutationObserver.notSupported = true;

        return MutationObserver;
    })();

    getComputedStyle = (function() {
        return window.getComputedStyle || function(element) {
            return {
                getPropertyValue: function(property) {
                    var value;
                    if (property === 'float') {
                        property = 'styleFloat';
                    }
                    if (vendorPrefixes.test(property)) {
                        property = property.replace(vendorPrefixes, function(match, p1) {
                            return p1.toUpperCase();
                        });
                    }
                    value = element.currentStyle ? element.currentStyle[property] : null;
                    return value || null;
                }
            };
        };
    })();

    vendorPrefixes = /(\-([a-z]){1})/g;

    WOW = (function() {
        function WOW(options) {
            if (options == null) options = {};
            this.scrollCallback = this.scrollCallback.bind(this);
            this.scrollHandler = this.scrollHandler.bind(this);
            this.resetAnimation = this.resetAnimation.bind(this);
            this.start = this.start.bind(this);
            this.scrolled = true;
            this.config = this.util().extend(options, this.defaults);
            if (options.scrollContainer != null) {
                this.config.scrollContainer = document.querySelector(options.scrollContainer);
            }
            this.animationNameCache = new WeakMap();
            this.wowEvent = this.util().createEvent(this.config.boxClass);
        }

        WOW.prototype.defaults = {
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 0,
            mobile: true,
            live: true,
            callback: null,
            scrollContainer: null
        };

        WOW.prototype.init = function() {
            this.element = window.document.documentElement;
            if (document.readyState === 'interactive' || document.readyState === 'complete') {
                this.start();
            } else {
                this.util().addEvent(document, 'DOMContentLoaded', this.start);
            }
            this.finished = [];
        };

        WOW.prototype.start = function() {
            var box, i, len, ref, results;
            if (this.stopped) {
                return;
            }
            this.boxes = (function() {
                var i, len, ref, results;
                ref = this.element.querySelectorAll('.' + this.config.boxClass);
                results = [];
                for (i = 0, len = ref.length; i < len; i++) {
                    box = ref[i];
                    results.push(box);
                }
                return results;
            }).call(this);
            this.all = (function() {
                var i, len, ref, results;
                ref = this.boxes;
                results = [];
                for (i = 0, len = ref.length; i < len; i++) {
                    box = ref[i];
                    results.push(box);
                }
                return results;
            }).call(this);
            if (this.boxes.length) {
                if (this.disabled()) {
                    this.resetStyle();
                } else {
                    results = [];
                    for (i = 0, len = this.boxes.length; i < len; i++) {
                        box = this.boxes[i];
                        results.push(this.applyStyle(box, true));
                    }
                    return results;
                }
            }
            if (!this.disabled()) {
                this.util().addEvent(this.config.scrollContainer || window, 'scroll', this.scrollHandler);
                this.util().addEvent(window, 'resize', this.scrollHandler);
                this.interval = setInterval(this.scrollCallback, 50);
                if (this.config.live) {
                    new MutationObserver(function(self) {
                        return function(mutations) {
                            var addedNode, j, len, results;
                            results = [];
                            for (j = 0, len = mutations.length; j < len; j++) {
                                addedNode = mutations[j].addedNodes;
                                results.push((function() {
                                    var k, len1, results1;
                                    results1 = [];
                                    for (k = 0, len1 = addedNode.length; k < len1; k++) {
                                        results1.push(self.doSync(addedNode[k]));
                                    }
                                    return results1;
                                })());
                            }
                            return results;
                        };
                    })(this).observe(document.body, { childList: true, subtree: true });
                }
            }
        };

        WOW.prototype.stop = function() {
            this.stopped = true;
            this.util().removeEvent(this.config.scrollContainer || window, 'scroll', this.scrollHandler);
            this.util().removeEvent(window, 'resize', this.scrollHandler);
            if (this.interval != null) {
                clearInterval(this.interval);
            }
        };

        WOW.prototype.sync = function() {
            if (MutationObserver.notSupported) {
                return this.doSync(this.element);
            }
        };

        WOW.prototype.doSync = function(element) {
            var box, i, len, ref, results;
            if (element == null) {
                element = this.element;
            }
            if (element.nodeType === 1) {
                element = element.parentNode || element;
                ref = element.querySelectorAll('.' + this.config.boxClass);
                results = [];
                for (i = 0, len = ref.length; i < len; i++) {
                    box = ref[i];
                    if (this.all.indexOf(box) < 0) {
                        this.boxes.push(box);
                        this.all.push(box);
                        if (this.stopped || this.disabled()) {
                            this.resetStyle();
                        } else {
                            this.applyStyle(box, true);
                        }
                        results.push(this.scrolled = true);
                    }
                }
                return results;
            }
        };

        WOW.prototype.show = function(box) {
            this.applyStyle(box);
            box.className = box.className + ' ' + this.config.animateClass;
            if (this.config.callback != null) {
                this.config.callback(box);
            }
            this.util().emitEvent(box, this.wowEvent);
            this.util().addEvent(box, 'animationend', this.resetAnimation);
            this.util().addEvent(box, 'oanimationend', this.resetAnimation);
            this.util().addEvent(box, 'webkitAnimationEnd', this.resetAnimation);
            this.util().addEvent(box, 'MSAnimationEnd', this.resetAnimation);
            return box;
        };

        WOW.prototype.applyStyle = function(box, hidden) {
            var duration, delay, iteration;
            duration = box.getAttribute('data-wow-duration');
            delay = box.getAttribute('data-wow-delay');
            iteration = box.getAttribute('data-wow-iteration');
            return this.animate(function(self) {
                return function() {
                    return self.customStyle(box, hidden, duration, delay, iteration);
                };
            })(this);
        };

        WOW.prototype.animate = function(callback) {
            if (window.requestAnimationFrame) {
                return window.requestAnimationFrame(callback);
            } else {
                return callback();
            }
        };

        WOW.prototype.resetStyle = function() {
            var box, i, len, results;
            results = [];
            for (i = 0, len = this.boxes.length; i < len; i++) {
                box = this.boxes[i];
                results.push(box.style.visibility = 'visible');
            }
            return results;
        };

        WOW.prototype.resetAnimation = function(event) {
            if (event.type.toLowerCase().indexOf('animationend') >= 0) {
                var target = event.target || event.srcElement;
                target.className = target.className.replace(this.config.animateClass, '').trim();
            }
        };

        WOW.prototype.customStyle = function(box, hidden, duration, delay, iteration) {
            if (hidden) {
                this.cacheAnimationName(box);
            }
            box.style.visibility = hidden ? 'hidden' : 'visible';
            if (duration) {
                this.vendorSet(box.style, { animationDuration: duration });
            }
            if (delay) {
                this.vendorSet(box.style, { animationDelay: delay });
            }
            if (iteration) {
                this.vendorSet(box.style, { animationIterationCount: iteration });
            }
            this.vendorSet(box.style, { animationName: hidden ? 'none' : this.cachedAnimationName(box) });
            return box;
        };

        WOW.prototype.vendors = ['moz', 'webkit'];

        WOW.prototype.vendorSet = function(style, properties) {
            var key, value, results;
            results = [];
            for (key in properties) {
                value = properties[key];
                style[key] = value;
                results.push((function() {
                    var j, len, results1;
                    results1 = [];
                    for (j = 0, len = this.vendors.length; j < len; j++) {
                        var vendor = this.vendors[j];
                        results1.push(style[vendor + key.charAt(0).toUpperCase() + key.slice(1)] = value);
                    }
                    return results1;
                }).call(this));
            }
            return results;
        };

        WOW.prototype.vendorCSS = function(element, property) {
            var cssValue, i, vendor;
            var computedStyle = getComputedStyle(element);
            cssValue = computedStyle.getPropertyCSSValue(property);
            for (i = 0; i < this.vendors.length; i++) {
                vendor = this.vendors[i];
                cssValue = cssValue || computedStyle.getPropertyCSSValue('-' + vendor + '-' + property);
            }
            return cssValue;
        };

        WOW.prototype.animationName = function(element) {
            var name;
            try {
                name = this.vendorCSS(element, 'animation-name').cssText;
            } catch (e) {
                name = getComputedStyle(element).getPropertyValue('animation-name');
            }
            return name === 'none' ? '' : name;
        };

        WOW.prototype.cacheAnimationName = function(element) {
            return this.animationNameCache.set(element, this.animationName(element));
        };

        WOW.prototype.cachedAnimationName = function(element) {
            return this.animationNameCache.get(element);
        };

        WOW.prototype.scrollHandler = function() {
            return this.scrolled = true;
        };

        WOW.prototype.scrollCallback = function() {
            if (!this.scrolled) {
                return;
            }
            this.scrolled = false;
            this.boxes = (function() {
                var box, i, len, results;
                results = [];
                for (i = 0, len = this.boxes.length; i < len; i++) {
                    box = this.boxes[i];
                    if (box) {
                        if (this.isVisible(box)) {
                            this.show(box);
                        } else {
                            results.push(box);
                        }
                    }
                }
                return results;
            }).call(this);
            if (this.boxes.length === 0 && !this.config.live) {
                return this.stop();
            }
        };

        WOW.prototype.offsetTop = function(element) {
            var offset = 0;
            while (element) {
                offset += element.offsetTop;
                element = element.offsetParent;
            }
            return offset;
        };

        WOW.prototype.isVisible = function(element) {
            var offset = element.getAttribute('data-wow-offset') || this.config.offset;
            var scrollTop = this.config.scrollContainer ? this.config.scrollContainer.scrollTop : window.pageYOffset;
            var viewBottom = scrollTop + Math.min(this.element.clientHeight, this.util().innerHeight()) - offset;
            var elementTop = this.offsetTop(element);
            return viewBottom >= elementTop && viewBottom <= elementTop + element.clientHeight;
        };

        WOW.prototype.util = function() {
            if (this._util == null) {
                this._util = new Util();
            }
            return this._util;
        };

        WOW.prototype.disabled = function() {
            return !this.config.mobile && this.util().isMobile(navigator.userAgent);
        };

        return WOW;
    })();

    window.WOW = WOW;
}).call(this);
