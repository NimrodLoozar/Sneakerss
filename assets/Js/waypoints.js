/*!
Waypoints - 4.0.0
Copyright © 2011-2015 Caleb Troughton
Licensed under the MIT license.
https://github.com/imakewebthings/waypoints/blog/master/licenses.txt
*/
(function() {
    "use strict";

    var waypointCounter = 0;
    var waypoints = {};

    function Waypoint(options) {
        if (!options) throw new Error("No options passed to Waypoint constructor");
        if (!options.element) throw new Error("No element option passed to Waypoint constructor");
        if (!options.handler) throw new Error("No handler option passed to Waypoint constructor");

        this.key = "waypoint-" + waypointCounter;
        this.options = Object.assign({}, Waypoint.defaults, options);
        this.element = this.options.element;
        this.callback = options.handler;
        this.axis = this.options.horizontal ? "horizontal" : "vertical";
        this.enabled = this.options.enabled;
        this.triggerPoint = null;
        this.group = Waypoint.Group.findOrCreate({ name: this.options.group, axis: this.axis });
        this.context = Waypoint.Context.findOrCreateByElement(this.options.context);

        if (Waypoint.offsetAliases[this.options.offset]) {
            this.options.offset = Waypoint.offsetAliases[this.options.offset];
        }

        this.group.add(this);
        this.context.add(this);
        waypoints[this.key] = this;
        waypointCounter += 1;
    }

    Waypoint.prototype.queueTrigger = function(direction) {
        this.group.queueTrigger(this, direction);
    };

    Waypoint.prototype.trigger = function(args) {
        if (this.enabled && this.callback) {
            this.callback.apply(this, args);
        }
    };

    Waypoint.prototype.destroy = function() {
        this.context.remove(this);
        this.group.remove(this);
        delete waypoints[this.key];
    };

    Waypoint.prototype.disable = function() {
        this.enabled = false;
        return this;
    };

    Waypoint.prototype.enable = function() {
        this.context.refresh();
        this.enabled = true;
        return this;
    };

    Waypoint.prototype.next = function() {
        return this.group.next(this);
    };

    Waypoint.prototype.previous = function() {
        return this.group.previous(this);
    };

    Waypoint.invokeAll = function(method) {
        var instances = [];
        for (var key in waypoints) {
            instances.push(waypoints[key]);
        }
        instances.forEach(function(instance) {
            instance[method]();
        });
    };

    Waypoint.destroyAll = function() {
        Waypoint.invokeAll("destroy");
    };

    Waypoint.disableAll = function() {
        Waypoint.invokeAll("disable");
    };

    Waypoint.enableAll = function() {
        Waypoint.invokeAll("enable");
    };

    Waypoint.refreshAll = function() {
        Waypoint.Context.refreshAll();
    };

    Waypoint.viewportHeight = function() {
        return window.innerHeight || document.documentElement.clientHeight;
    };

    Waypoint.viewportWidth = function() {
        return document.documentElement.clientWidth;
    };

    Waypoint.defaults = {
        context: window,
        continuous: true,
        enabled: true,
        group: "default",
        horizontal: false,
        offset: 150
    };

    Waypoint.offsetAliases = {
        "bottom-in-view": function() {
            return this.context.innerHeight() - this.adapter.outerHeight();
        },
        "right-in-view": function() {
            return this.context.innerWidth() - this.adapter.outerWidth();
        }
    };

    window.Waypoint = Waypoint;
})();
