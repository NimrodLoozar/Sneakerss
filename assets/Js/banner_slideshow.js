function showSlides(slideClass, containerClass) {
    var slideIndex = 0;

    function displaySlides() {
        var i;
        var slides = document.getElementsByClassName(slideClass);

        // Alle slides verbergen
        for (i = 0; i < slides.length; i++) {
            slides[i].classList.remove("active");
        }

        slideIndex++;
        if (slideIndex > slides.length) {
            slideIndex = 1;
        }

        // Toon de huidige slide
        slides[slideIndex - 1].classList.add("active");

        // Verander de afbeelding elke 4 seconden
        setTimeout(displaySlides, 3000);
    }

    displaySlides();
}

// Roep de functie aan voor elke slideshow
showSlides("mySlides-1", "slideshow-container-1");
showSlides("mySlides-2", "slideshow-container-2");
