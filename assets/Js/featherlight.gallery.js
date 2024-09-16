/**
 * Featherlight Gallery – an extension for the ultra slim jQuery lightbox
 * Version 1.3.3 - http://noelboss.github.io/featherlight/
 *
 * Copyright 2015, Noël Raoul Bossart (http://www.noelboss.com)
 * MIT Licensed.
**/
(function() {
    "use strict";

    function FeatherlightGallery(source, options) {
        if (!(this instanceof FeatherlightGallery)) {
            var instance = new FeatherlightGallery(source, options);
            instance.open();
            return instance;
        }
        this.init(source, options);
    }

    FeatherlightGallery.prototype = {
        defaults: {
            autoBind: "[data-featherlight-gallery]",
            previousIcon: "&#xf104;",
            nextIcon: "&#xf105;",
            galleryFadeIn: 100,
            galleryFadeOut: 300
        },

        init: function(source, options) {
            this.config = Object.assign({}, this.defaults, options || {});
            this.$source = source;
            this.$currentTarget = source.firstElementChild;
            this.setup();
        },

        setup: function() {
            this.open = this.open.bind(this);
            this.beforeContent = this.beforeContent.bind(this);
            this.afterContent = this.afterContent.bind(this);
            this.onKeyUp = this.onKeyUp.bind(this);
            this.navigateTo = this.navigateTo.bind(this);

            this.createNavigation = this.createNavigation.bind(this);

            this.attachEvents();
            this.chainCallbacks();
        },

        attachEvents: function() {
            document.addEventListener('keyup', this.onKeyUp);
            document.addEventListener('click', this.handleClick.bind(this));
        },

        handleClick: function(event) {
            if (event.target.matches('.next')) {
                this.$instance.dispatchEvent(new Event('next'));
            } else if (event.target.matches('.previous')) {
                this.$instance.dispatchEvent(new Event('previous'));
            }
        },

        chainCallbacks: function(callbacks) {
            this.callbacks = Object.assign({}, callbacks);
        },

        open: function() {
            this.$instance = document.createElement('div');
            this.$instance.className = 'featherlight-gallery';
            document.body.appendChild(this.$instance);

            this.$instance.addEventListener('next', () => this.navigateTo(this.currentNavigation() + 1));
            this.$instance.addEventListener('previous', () => this.navigateTo(this.currentNavigation() - 1));

            this.beforeContent();
            this.setContent();
            this.afterContent();
        },

        beforeContent: function() {
            // Logic before content is added
        },

        afterContent: function() {
            // Logic after content is added
        },

        setContent: function() {
            this.$instance.innerHTML = '<div class="featherlight-inner"></div>';
            this.getContent().then(content => {
                this.$instance.querySelector('.featherlight-inner').innerHTML = content;
                this.$instance.querySelector('.featherlight-inner').style.opacity = 0.2;
                setTimeout(() => {
                    this.$instance.querySelector('.featherlight-inner').style.opacity = 1;
                }, this.config.galleryFadeIn);
            });
        },

        getContent: function() {
            return new Promise((resolve) => {
                // Assuming getContent logic here
                resolve('Content');
            });
        },

        navigateTo: function(index) {
            const slides = this.slides();
            const length = slides.length;
            index = (index % length + length) % length;
            this.$currentTarget = slides[index];
            this.beforeContent();
            this.getContent().then(content => {
                const inner = this.$instance.querySelector('.featherlight-inner');
                inner.style.opacity = 0.2;
                setTimeout(() => {
                    inner.innerHTML = content;
                    inner.style.opacity = 1;
                }, this.config.galleryFadeIn);
            });
        },

        slides: function() {
            return Array.from(this.$source.children);
        },

        currentNavigation: function() {
            return this.slides().indexOf(this.$currentTarget);
        },

        createNavigation: function(direction) {
            const nav = document.createElement('span');
            nav.title = direction;
            nav.className = 'featherlight-' + direction;
            nav.innerHTML = this.config[direction + 'Icon'];
            nav.addEventListener('click', () => {
                this.$instance.dispatchEvent(new Event(direction));
            });
            return nav;
        },

        onKeyUp: function(event) {
            const actions = {
                37: 'previous',
                39: 'next'
            };
            const action = actions[event.keyCode];
            if (action) {
                this.$instance.dispatchEvent(new Event(action));
                event.preventDefault();
            }
        }
    };

    window.FeatherlightGallery = FeatherlightGallery;

    document.addEventListener('DOMContentLoaded', function() {
        const autoBindElements = document.querySelectorAll(FeatherlightGallery.prototype.defaults.autoBind);
        autoBindElements.forEach(element => {
            new FeatherlightGallery(element);
        });
    });
})();
