(function() {
    'use strict';

    var scrollUp = function(options) {
        if (!document.body.dataset.scrollUp) {
            document.body.dataset.scrollUp = true;
            scrollUp.init(options);
        }
    };

    scrollUp.init = function(settings) {
        var s, t, c, i, n, a, d, p = Object.assign({}, scrollUp.defaults, settings),
            f = false;

        d = p.scrollTrigger ? document.querySelector(p.scrollTrigger) : document.createElement('a');
        if (!p.scrollTrigger) {
            d.id = p.scrollName;
            d.href = '#top';
        }

        if (p.scrollTitle) d.setAttribute('title', p.scrollTitle);
        if (!p.scrollTrigger) d.innerHTML = p.scrollText;

        d.style.display = 'none';
        d.style.position = 'fixed';
        d.style.zIndex = p.zIndex;

        document.body.appendChild(d);

        if (p.activeOverlay) {
            var overlay = document.createElement('div');
            overlay.id = p.scrollName + '-active';
            overlay.style.position = 'absolute';
            overlay.style.top = p.scrollDistance + 'px';
            overlay.style.width = '100%';
            overlay.style.borderTop = '1px dotted ' + p.activeOverlay;
            overlay.style.zIndex = p.zIndex;
            document.body.appendChild(overlay);
        }

        switch (p.animation) {
            case 'fade':
                s = 'fadeIn';
                t = 'fadeOut';
                c = p.animationSpeed;
                break;
            case 'slide':
                s = 'slideDown';
                t = 'slideUp';
                c = p.animationSpeed;
                break;
            default:
                s = 'show';
                t = 'hide';
                c = 0;
        }

        i = p.scrollFrom === 'top' ? p.scrollDistance : document.documentElement.scrollHeight - window.innerHeight - p.scrollDistance;

        window.addEventListener('scroll', function() {
            if (window.scrollY > i && !f) {
                d.style.display = 'block';
                f = true;
            } else if (window.scrollY <= i && f) {
                d.style.display = 'none';
                f = false;
            }
        });

        var scrollTarget = 0;
        if (typeof p.scrollTarget === 'number') {
            scrollTarget = p.scrollTarget;
        } else if (typeof p.scrollTarget === 'string') {
            var target = document.querySelector(p.scrollTarget);
            if (target) scrollTarget = Math.floor(target.offsetTop);
        }

        d.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: scrollTarget, behavior: 'smooth' });
        });
    };

    scrollUp.destroy = function() {
        delete document.body.dataset.scrollUp;
        var scrollButton = document.getElementById(scrollUp.defaults.scrollName);
        if (scrollButton) scrollButton.remove();
        var activeOverlay = document.getElementById(scrollUp.defaults.scrollName + '-active');
        if (activeOverlay) activeOverlay.remove();
        window.removeEventListener('scroll', scrollUp.init);
    };

    scrollUp.defaults = {
        scrollName: 'scrollUp',
        scrollDistance: 300,
        scrollFrom: 'top',
        scrollSpeed: 300,
        easingType: 'linear',
        animation: 'slide',
        animationSpeed: 200,
        scrollTrigger: false,
        scrollTarget: false,
        scrollText: '',
        scrollTitle: false,
        scrollImg: false,
        activeOverlay: false,
        zIndex: 2147483647
    };

    window.scrollUp = scrollUp;

})();
