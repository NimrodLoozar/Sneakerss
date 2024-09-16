(function() {
    "use strict";
    
    function enllax(elements, options) {
        var windowHeight = window.innerHeight;
        var documentHeight = document.body.offsetHeight;
        var defaults = {
            ratio: 0,
            type: "background",
            direction: "vertical"
        };
        var settings = Object.assign({}, defaults, options);

        elements.forEach(function(el) {
            var elTop = el.getBoundingClientRect().top + window.scrollY;
            var elHeight = el.offsetHeight;
            var elRatio = el.getAttribute("data-enllax-ratio") || settings.ratio;
            var elType = el.getAttribute("data-enllax-type") || settings.type;
            var elDirection = el.getAttribute("data-enllax-direction") || settings.direction;

            var f = Math.round(elTop * elRatio);
            var u = Math.round((elTop - windowHeight / 2 + elHeight) * elRatio);

            if (elType === "background") {
                if (elDirection === "vertical") {
                    el.style.backgroundPosition = "center " + -f + "px";
                } else if (elDirection === "horizontal") {
                    el.style.backgroundPosition = -f + "px center";
                }
            } else if (elType === "foreground") {
                if (elDirection === "vertical") {
                    el.style.transform = "translateY(" + u + "px)";
                } else if (elDirection === "horizontal") {
                    el.style.transform = "translateX(" + u + "px)";
                }
            }

            window.addEventListener("scroll", function() {
                var scrollTop = window.scrollY;
                f = Math.round((elTop - scrollTop) * elRatio);
                u = Math.round((elTop - windowHeight / 2 + elHeight - scrollTop) * elRatio);

                if (elType === "background") {
                    if (elDirection === "vertical") {
                        el.style.backgroundPosition = "center " + -f + "px";
                    } else if (elDirection === "horizontal") {
                        el.style.backgroundPosition = -f + "px center";
                    }
                } else if (elType === "foreground") {
                    if (documentHeight > scrollTop) {
                        if (elDirection === "vertical") {
                            el.style.transform = "translateY(" + u + "px)";
                        } else if (elDirection === "horizontal") {
                            el.style.transform = "translateX(" + u + "px)";
                        }
                    }
                }
            });
        });
    }

    // To use the function
    var elements = document.querySelectorAll("[data-enllax-ratio]");
    enllax(elements, { ratio: 0.5, type: "background", direction: "vertical" });
})();
