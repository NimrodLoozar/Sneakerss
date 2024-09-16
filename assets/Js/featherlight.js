/**
 * Featherlight - ultra slim jQuery lightbox
 * Version 1.3.3 - http://noelboss.github.io/featherlight/
 *
 * Copyright 2015, Noël Raoul Bossart (http://www.noelboss.com)
 * MIT Licensed.
**/
(function() {
    'use strict';

    function Featherlight(target, options) {
        if (!(this instanceof Featherlight)) {
            return new Featherlight(target, options).open();
        }
        this.id = Featherlight.id++;
        this.setup(target, options);
        this.chainCallbacks(Featherlight._callbackChain);
    }

    if (typeof window.jQuery === 'undefined') {
        if (window.console && window.console.info) {
            console.info('Featherlight needs jQuery.');
        }
        return;
    }

    var $ = window.jQuery;
    var instances = [];

    var removeInstances = function(instance) {
        instances = instances.filter(function(i) {
            return i !== instance && i.$instance.closest('body').length > 0;
        });
    };

    var extractAttributes = function(attrs, prefix) {
        var result = {};
        var regex = new RegExp('^' + prefix + '([A-Z])(.*)');
        for (var key in attrs) {
            var match = key.match(regex);
            if (match) {
                var formattedKey = (match[1] + match[2].replace(/([A-Z])/g, '-$1')).toLowerCase();
                result[formattedKey] = attrs[key];
            }
        }
        return result;
    };

    var eventMap = {
        keyup: 'onKeyUp',
        resize: 'onResize'
    };

    var handleEvents = function(event) {
        instances.slice().reverse().forEach(function(instance) {
            if (event.isDefaultPrevented() || instance[eventMap[event.type]](event) === false) {
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
        });
    };

    var globalEventHandler = function(install) {
        if (install !== Featherlight._globalHandlerInstalled) {
            Featherlight._globalHandlerInstalled = install;
            var events = Object.values(eventMap).map(function(event) {
                return event + '.' + Featherlight.prototype.namespace;
            }).join(' ');
            $(window)[install ? 'on' : 'off'](events, handleEvents);
        }
    };

    Featherlight.prototype = {
        constructor: Featherlight,
        namespace: 'featherlight',
        targetAttr: 'data-featherlight',
        variant: null,
        resetCss: false,
        background: null,
        openTrigger: 'click',
        closeTrigger: 'click',
        filter: null,
        root: 'body',
        openSpeed: 250,
        closeSpeed: 250,
        closeOnClick: 'background',
        closeOnEsc: true,
        closeIcon: '&#10005;',
        loading: '',
        persist: false,
        otherClose: null,
        beforeOpen: function() {},
        beforeContent: function() {},
        beforeClose: function() {},
        afterOpen: function() {},
        afterContent: function() {},
        afterClose: function() {},
        onKeyUp: function() {},
        onResize: function() {},
        type: null,
        contentFilters: [
            'jquery', 'image', 'html', 'ajax', 'iframe', 'text'
        ],

        setup: function(target, options) {
            if (typeof target !== 'object' || target instanceof $) {
                if (!options) {
                    options = target;
                    target = undefined;
                }
            }
            var config = $.extend(this, options, { target: target });
            var namespace = config.resetCss ? config.namespace + '-reset' : config.namespace;
            var backgroundHTML = [
                '<div class="' + namespace + '-loading ' + namespace + '">',
                '<div class="' + namespace + '-content">',
                '<span class="' + namespace + '-close-icon ' + config.namespace + '-close">',
                config.closeIcon,
                '</span>',
                '<div class="' + config.namespace + '-inner">' + config.loading + '</div>',
                '</div>',
                '</div>'
            ].join('');
            var closeSelector = '.' + config.namespace + '-close' + (config.otherClose ? ',' + config.otherClose : '');

            config.$instance = $(backgroundHTML).clone().addClass(config.variant);
            config.$instance.on(config.closeTrigger + '.' + config.namespace, function(event) {
                var target = $(event.target);
                if ((config.closeOnClick === 'background' && target.is('.' + config.namespace)) ||
                    config.closeOnClick === 'anywhere' ||
                    target.closest(closeSelector).length) {
                    event.preventDefault();
                    config.close();
                }
            });

            return this;
        },

        getContent: function() {
            if (this.persist !== false && this.$content) {
                return this.$content;
            }
            var filters = this.constructor.contentFilters;
            var attr = function(attrName) {
                return this.$currentTarget && this.$currentTarget.attr(attrName);
            }.bind(this);
            var targetAttr = attr(this.targetAttr);
            var type = this.type;
            var filtersMap = filters.reduce(function(map, key) {
                map[key] = this.constructor.contentFilters[key];
                return map;
            }.bind(this), {});
            var filter = filtersMap[type] || filtersMap[targetAttr] || filtersMap[targetAttr || ''] || filtersMap.html;

            if (typeof filter === 'function') {
                var result = filter.call(this, this.target || targetAttr || '');
                if (result) {
                    return result;
                }
            }

            return false;
        },

        setContent: function(content) {
            if (content.is('iframe') || $('iframe', content).length > 0) {
                this.$instance.addClass(this.namespace + '-iframe');
            }
            this.$instance.removeClass(this.namespace + '-loading');
            this.$instance.find('.' + this.namespace + '-inner').not(content).slice(1).remove().end().replaceWith(
                $.contains(this.$instance[0], content[0]) ? '' : content
            );
            this.$content = content.addClass(this.namespace + '-inner');
            return this;
        },

        open: function(event) {
            if (this.$instance.hide().appendTo(this.root), !event || !event.isDefaultPrevented() && this.beforeOpen(event) !== false) {
                event && event.preventDefault();
                var content = this.getContent();
                if (content) {
                    instances.push(this);
                    globalEventHandler(true);
                    this.$instance.fadeIn(this.openSpeed);
                    this.beforeContent(event);
                    $.when(content).always(function(content) {
                        this.setContent(content);
                        this.afterContent(event);
                    }.bind(this)).then(this.$instance.promise()).done(function() {
                        this.afterOpen(event);
                    }.bind(this));
                }
                return this;
            }
            this.$instance.detach();
            return $.Deferred().reject().promise();
        },

        close: function(event) {
            var deferred = $.Deferred();
            if (this.beforeClose(event) !== false) {
                if (instances.length === 0) {
                    globalEventHandler(false);
                }
                this.$instance.fadeOut(this.closeSpeed, function() {
                    this.$instance.detach();
                    this.afterClose(event);
                    deferred.resolve();
                }.bind(this));
            } else {
                deferred.reject();
            }
            return deferred.promise();
        },

        chainCallbacks: function(callbacks) {
            for (var key in callbacks) {
                this[key] = $.proxy(callbacks[key], this, $.proxy(this[key], this));
            }
        }
    };

    Featherlight.id = 0;
    Featherlight._callbackChain = {
        onKeyUp: function(event) {
            return event.keyCode === 27 && this.closeOnEsc ?
                this.$instance.find('.' + this.namespace + '-close:first').click() :
                event;
        },
        onResize: function(event) {
            if (this.$content[0] && this.$content[0].naturalWidth) {
                var width = this.$content[0].naturalWidth;
                var height = this.$content[0].naturalHeight;
                this.$content.css({ width: '', height: '' });
                var scale = Math.max(
                    width / parseInt(this.$content.parent().css('width'), 10),
                    height / parseInt(this.$content.parent().css('height'), 10)
                );
                if (scale > 1) {
                    this.$content.css({
                        width: width / scale + 'px',
                        height: height / scale + 'px'
                    });
                }
            }
            return event;
        },
        afterContent: function(event) {
            this.onResize(event);
        }
    };

    Featherlight.contentFilters = {
        jquery: {
            regex: /^[#.]\w/,
            test: function(content) {
                return content instanceof $;
            },
            process: function(content) {
                return this.persist !== false ? content : content.clone(true);
            }
        },
        image: {
            regex: /\.(png|jpg|jpeg|gif|tiff|bmp|svg)(\?\S*)?$/i,
            process: function(src) {
                var deferred = $.Deferred();
                var image = new Image();
                var imgElement = $('<img src="' + src + '" alt="" class="' + this.namespace + '-image" />');
                image.onload = function() {
                    imgElement[0].naturalWidth = image.width;
                    imgElement[0].naturalHeight = image.height;
                    deferred.resolve(imgElement);
                };
                image.onerror = function() {
                    deferred.reject(imgElement);
                };
                image.src = src;
                return deferred.promise();
            }
        },
        html: {
            regex: /^\s*<[\w!][^<]*>/,
            process: function(html) {
                return $(html);
            }
        },
        ajax: {
            regex: /./,
            process: function(url) {
                var deferred = $.Deferred();
                $('<div></div>').load(url, function(response, status) {
                    if (status !== 'error') {
                        deferred.resolve($(this).contents());
                    } else {
                        deferred.reject();
                    }
                });
                return deferred.promise();
            }
        },
        iframe: {
            process: function(src) {
                var deferred = $.Deferred();
                var iframe = $('<iframe/>').hide().attr('src', src).css(extractAttributes(this, 'iframe')).on('load', function() {
                    deferred.resolve($(this).show());
                }).appendTo(this.$instance.find('.' + this.namespace + '-content'));
                return deferred.promise();
            }
        },
        text: {
            process: function(text) {
                return $('<div>', { text: text });
            }
        }
    };

    Featherlight.readElementConfig = function(element, namespace) {
        var attributes = element.attributes;
        var regex = new RegExp('^data-' + namespace + '-(.*)');
        var config = {};
        if (attributes) {
            $.each(attributes, function() {
                var match = this.name.match(regex);
                if (match) {
                    var value = this.value;
                    var key = $.camelCase(match[1]);
                    if ($.inArray(key, Featherlight.prototype.functionAttributes) >= 0) {
                        value = new Function(value);
                    } else {
                        try {
                            value = $.parseJSON(value);
                        } catch (e) {}
                    }
                    config[key] = value;
                }
            });
        }
        return config;
    };

    Featherlight.extend = function(parent, properties) {
        function Constructor() {
            this.constructor = parent;
        }
        Constructor.prototype = this.prototype;
        parent.prototype = new Constructor();
        parent.__super__ = this.prototype;
        $.extend(parent, this, properties);
        parent.defaults = parent.prototype;
        return parent;
    };

    Featherlight.attach = function(element, options, defaults) {
        if (typeof options !== 'object' || options instanceof $) {
            if (!defaults) {
                defaults = options;
                options = undefined;
            }
        }
        defaults = $.extend({}, defaults);
        var instance;
        var namespace = defaults.namespace || this.defaults.namespace;
        var config = $.extend({}, this.defaults, Featherlight.readElementConfig(element[0], namespace), defaults);

        element.on(config.openTrigger + '.' + config.namespace, config.filter, function(event) {
            var $source = $(this);
            var targetOptions = $.extend(
                { $source: element, $currentTarget: $source },
                Featherlight.readElementConfig(element[0], config.namespace),
                Featherlight.readElementConfig(this, config.namespace),
                defaults
            );
            var instance = instance || $source.data('featherlight-persisted') || new Featherlight(options, targetOptions);
            if (instance.persist === 'shared') {
                instance = instance;
            } else if (instance.persist !== false) {
                $source.data('featherlight-persisted', instance);
            }
            $source.blur();
            instance.open(event);
        });

        return element;
    };

    Featherlight.current = function() {
        var openedInstances = this.opened();
        return openedInstances[openedInstances.length - 1] || null;
    };

    Featherlight.opened = function() {
        removeInstances();
        return instances.filter(function(instance) {
            return instance instanceof Featherlight;
        });
    };

    Featherlight.close = function() {
        var current = this.current();
        return current ? current.close() : undefined;
    };

    Featherlight.prototype._onReady = function() {
        if (this.autoBind) {
            Featherlight.attach($(document), { filter: this.autoBind });
            $(this.autoBind).filter('[data-featherlight-filter]').each(function() {
                Featherlight.attach($(this));
            });
        }
    };

    Featherlight.prototype.functionAttributes = [
        'beforeOpen', 'afterOpen', 'beforeContent', 'afterContent', 'beforeClose', 'afterClose'
    ];

    Featherlight.prototype._callbackChain = {
        onKeyUp: function(event, keyEvent) {
            if (keyEvent.keyCode === 27) {
                if (this.closeOnEsc) {
                    this.$instance.find('.' + this.namespace + '-close:first').click();
                }
                return false;
            }
            return event;
        },
        onResize: function(event, keyEvent) {
            if (this.$content[0] && this.$content[0].naturalWidth) {
                var width = this.$content[0].naturalWidth;
                var height = this.$content[0].naturalHeight;
                this.$content.css({ width: '', height: '' });
                var scale = Math.max(
                    width / parseInt(this.$content.parent().css('width'), 10),
                    height / parseInt(this.$content.parent().css('height'), 10)
                );
                if (scale > 1) {
                    this.$content.css({
                        width: width / scale + 'px',
                        height: height / scale + 'px'
                    });
                }
            }
            return keyEvent;
        },
        afterContent: function(event) {
            this.onResize(event);
        }
    };

    Featherlight.defaults = Featherlight.prototype;

    $(document).ready(function() {
        Featherlight.prototype._onReady.call(Featherlight.prototype);
    });

    window.Featherlight = Featherlight;
})();
