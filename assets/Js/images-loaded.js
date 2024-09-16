/*!
 * imagesLoaded PACKAGED v3.1.4
 * JavaScript is all like "You images are done yet or what?"
 * MIT License
 */

(function() {
    "use strict";

    function EventEmitter() {}

    EventEmitter.prototype.getListeners = function(event) {
        var events = this._getEvents() || {};
        if (typeof event === 'object') {
            var result = {};
            for (var key in events) {
                if (events.hasOwnProperty(key) && event.test(key)) {
                    result[key] = events[key];
                }
            }
            return result;
        } else {
            return events[event] || (events[event] = []);
        }
    };

    EventEmitter.prototype.flattenListeners = function(listeners) {
        return listeners.map(function(item) { return item.listener; });
    };

    EventEmitter.prototype.getListenersAsObject = function(event) {
        var listeners = this.getListeners(event);
        if (Array.isArray(listeners)) {
            var result = {};
            result[event] = listeners;
            return result;
        }
        return listeners;
    };

    EventEmitter.prototype.addListener = function(event, listener) {
        var listeners = this.getListenersAsObject(event);
        for (var key in listeners) {
            if (listeners.hasOwnProperty(key) && !listeners[key].some(function(item) { return item.listener === listener; })) {
                listeners[key].push({ listener: listener, once: false });
            }
        }
        return this;
    };

    EventEmitter.prototype.on = function(event, listener) {
        return this.addListener(event, listener);
    };

    EventEmitter.prototype.addOnceListener = function(event, listener) {
        return this.addListener(event, { listener: listener, once: true });
    };

    EventEmitter.prototype.once = function(event, listener) {
        return this.addOnceListener(event, listener);
    };

    EventEmitter.prototype.defineEvent = function(event) {
        this.getListeners(event);
        return this;
    };

    EventEmitter.prototype.defineEvents = function(events) {
        events.forEach(function(event) { this.defineEvent(event); }, this);
        return this;
    };

    EventEmitter.prototype.removeListener = function(event, listener) {
        var listeners = this.getListenersAsObject(event);
        for (var key in listeners) {
            if (listeners.hasOwnProperty(key)) {
                var index = listeners[key].findIndex(function(item) { return item.listener === listener; });
                if (index !== -1) {
                    listeners[key].splice(index, 1);
                }
            }
        }
        return this;
    };

    EventEmitter.prototype.off = function(event, listener) {
        return this.removeListener(event, listener);
    };

    EventEmitter.prototype.addListeners = function(events, listeners) {
        return this.manipulateListeners(false, events, listeners);
    };

    EventEmitter.prototype.removeListeners = function(events, listeners) {
        return this.manipulateListeners(true, events, listeners);
    };

    EventEmitter.prototype.manipulateListeners = function(remove, events, listeners) {
        var method = remove ? this.removeListener : this.addListener;
        if (typeof events === 'object' && !(events instanceof RegExp)) {
            for (var event in events) {
                if (events.hasOwnProperty(event)) {
                    var handler = events[event];
                    if (typeof handler === 'function') {
                        method.call(this, event, handler);
                    } else {
                        this[remove ? 'removeListeners' : 'addListeners'](event, handler);
                    }
                }
            }
        } else {
            listeners.forEach(function(listener) {
                method.call(this, events, listener);
            }, this);
        }
        return this;
    };

    EventEmitter.prototype.removeEvent = function(event) {
        var events = this._getEvents();
        if (typeof event === 'string') {
            delete events[event];
        } else if (typeof event === 'object') {
            for (var key in events) {
                if (events.hasOwnProperty(key) && event.test(key)) {
                    delete events[key];
                }
            }
        } else {
            this._events = {};
        }
        return this;
    };

    EventEmitter.prototype.removeAllListeners = function(event) {
        return this.removeEvent(event);
    };

    EventEmitter.prototype.emitEvent = function(event, args) {
        var listeners = this.getListenersAsObject(event);
        for (var key in listeners) {
            if (listeners.hasOwnProperty(key)) {
                listeners[key].forEach(function(item) {
                    if (item.once) {
                        this.removeListener(event, item.listener);
                    }
                    var result = item.listener.apply(this, args || []);
                    if (result === this._getOnceReturnValue()) {
                        this.removeListener(event, item.listener);
                    }
                }, this);
            }
        }
        return this;
    };

    EventEmitter.prototype.trigger = function(event) {
        var args = Array.prototype.slice.call(arguments, 1);
        return this.emitEvent(event, args);
    };

    EventEmitter.prototype.emit = function(event) {
        var args = Array.prototype.slice.call(arguments, 1);
        return this.emitEvent(event, args);
    };

    EventEmitter.prototype.setOnceReturnValue = function(value) {
        this._onceReturnValue = value;
        return this;
    };

    EventEmitter.prototype._getOnceReturnValue = function() {
        return this.hasOwnProperty('_onceReturnValue') ? this._onceReturnValue : true;
    };

    EventEmitter.prototype._getEvents = function() {
        return this._events || (this._events = {});
    };

    EventEmitter.noConflict = function() {
        window.EventEmitter = this._originalEventEmitter;
        return this;
    };

    if (typeof define === 'function' && define.amd) {
        define('eventEmitter/EventEmitter', [], function() {
            return EventEmitter;
        });
    } else if (typeof module === 'object' && module.exports) {
        module.exports = EventEmitter;
    } else {
        window.EventEmitter = EventEmitter;
    }
})();

(function(global) {
    function Event(t) {
        var e = global.event;
        e.target = e.target || e.srcElement || t;
        return e;
    }

    var docEl = document.documentElement;
    var bind = function() {};
    var unbind = function() {};

    if (docEl.addEventListener) {
        bind = function(elem, type, listener) {
            elem.addEventListener(type, listener, false);
        };
    } else if (docEl.attachEvent) {
        bind = function(elem, type, listener) {
            elem[type + listener] = function() {
                var event = Event(elem);
                listener.handleEvent ? listener.handleEvent.call(listener, event) : listener.call(elem, event);
            };
            elem.attachEvent('on' + type, elem[type + listener]);
        };
    }

    if (docEl.removeEventListener) {
        unbind = function(elem, type, listener) {
            elem.removeEventListener(type, listener, false);
        };
    } else if (docEl.detachEvent) {
        unbind = function(elem, type, listener) {
            elem.detachEvent('on' + type, elem[type + listener]);
            try {
                delete elem[type + listener];
            } catch (e) {
                elem[type + listener] = undefined;
            }
        };
    }

    var eventie = {
        bind: bind,
        unbind: unbind
    };

    if (typeof define === 'function' && define.amd) {
        define('eventie/eventie', eventie);
    } else {
        global.eventie = eventie;
    }
})(this);

(function(global, EventEmitter, eventie) {
    'use strict';

    function extend(out) {
        out = out || {};
        for (var i = 1; i < arguments.length; i++) {
            var obj = arguments[i];
            if (!obj) continue;
            for (var key in obj) {
                if (obj.hasOwnProperty(key)) {
                    out[key] = obj[key];
                }
            }
        }
        return out;
    }

    function isArray(arr) {
        return Object.prototype.toString.call(arr) === '[object Array]';
    }

    function toArray(elements) {
        var arr = [];
        if (isArray(elements)) {
            arr = elements;
        } else if (typeof elements.length === 'number') {
            for (var i = 0; i < elements.length; i++) {
                arr.push(elements[i]);
            }
        } else {
            arr.push(elements);
        }
        return arr;
    }

    function ImagesLoaded(elements, options, callback) {
        if (!(this instanceof ImagesLoaded)) {
            return new ImagesLoaded(elements, options, callback);
        }

        if (typeof elements === 'string') {
            elements = document.querySelectorAll(elements);
        }

        this.elements = toArray(elements);
        this.options = extend({}, this.options);

        if (typeof options === 'function') {
            callback = options;
        } else {
            extend(this.options, options);
        }

        if (callback) {
            this.on('always', callback);
        }

        this.getImages();
        setTimeout(this.check.bind(this));
    }

    ImagesLoaded.prototype = new EventEmitter();

    ImagesLoaded.prototype.options = {};

    ImagesLoaded.prototype.getImages = function() {
        this.images = [];
        this.elements.forEach(function(element) {
            if (element.nodeName === 'IMG') {
                this.addImage(element);
            }

            var imgs = element.querySelectorAll('img');
            imgs.forEach(function(img) {
                this.addImage(img);
            }, this);
        }, this);
    };

    ImagesLoaded.prototype.addImage = function(img) {
        var image = new Image(img);
        this.images.push(image);
    };

    ImagesLoaded.prototype.check = function() {
        var self = this;
        var count = this.images.length;

        if (!count) {
            this.complete();
            return;
        }

        var onConfirm = function(image, isLoaded) {
            self.progress(image);
            if (++count === self.images.length) {
                self.complete();
            }
        };

        this.images.forEach(function(image) {
            image.on('confirm', onConfirm);
            image.check();
        });
    };

    ImagesLoaded.prototype.progress = function(image) {
        this.hasAnyBroken = this.hasAnyBroken || !image.isLoaded;
        this.emit('progress', this, image);
    };

    ImagesLoaded.prototype.complete = function() {
        var event = this.hasAnyBroken ? 'fail' : 'done';
        this.isComplete = true;
        this.emit(event, this);
        this.emit('always', this);
    };

    function Image(img) {
        this.img = img;
    }

    Image.prototype = new EventEmitter();

    Image.prototype.check = function() {
        var src = this.img.src;
        var cachedImage = Image.cache[src] || new ImageCache(src);

        if (cachedImage.isConfirmed) {
            this.confirm(cachedImage.isLoaded, 'cached was confirmed');
            return;
        }

        if (this.img.complete && this.img.naturalWidth !== undefined) {
            this.confirm(this.img.naturalWidth !== 0, 'naturalWidth');
            return;
        }

        this.img.addEventListener('load', this);
        this.img.addEventListener('error', this);
        cachedImage.on('confirm', function() {
            this.confirm(cachedImage.isLoaded, 'event');
        }.bind(this));
        cachedImage.check();
    };

    Image.prototype.handleEvent = function(event) {
        var method = 'on' + event.type;
        if (this[method]) {
            this[method](event);
        }
    };

    Image.prototype.onload = function() {
        this.confirm(true, 'onload');
        this.unbindEvents();
    };

    Image.prototype.onerror = function() {
        this.confirm(false, 'onerror');
        this.unbindEvents();
    };

    Image.prototype.confirm = function(isLoaded, reason) {
        this.isConfirmed = true;
        this.isLoaded = isLoaded;
        this.emit('confirm', this, reason);
    };

    Image.prototype.unbindEvents = function() {
        this.img.removeEventListener('load', this);
        this.img.removeEventListener('error', this);
    };

    var ImageCache = function(src) {
        this.src = src;
        this.isChecked = false;
        this.isConfirmed = false;
        this.isLoaded = false;
    };

    ImageCache.prototype = new EventEmitter();

    ImageCache.prototype.check = function() {
        if (!this.isChecked) {
            var img = new Image();
            img.src = this.src;
            this.isChecked = true;
            img.onload = this.onload.bind(this);
            img.onerror = this.onerror.bind(this);
        }
    };

    ImageCache.prototype.onload = function() {
        this.confirm(true, 'onload');
        this.unbindEvents();
    };

    ImageCache.prototype.onerror = function() {
        this.confirm(false, 'onerror');
        this.unbindEvents();
    };

    ImageCache.prototype.confirm = function(isLoaded, reason) {
        this.isConfirmed = true;
        this.isLoaded = isLoaded;
        this.emit('confirm', this, reason);
    };

    ImageCache.prototype.unbindEvents = function() {
        // No-op
    };

    ImageCache.cache = {};

    global.ImagesLoaded = ImagesLoaded;
})(this);
