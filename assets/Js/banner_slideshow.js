var slideIndex = 0;
showSlides();

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");

    // Alle slides verbergen door de 'active' class te verwijderen
    for (i = 0; i < slides.length; i++) {
        slides[i].classList.remove("active");
    }

    slideIndex++;
    if (slideIndex > slides.length) {
        slideIndex = 1;
    }

    // Toon de huidige slide door de 'active' class toe te voegen
    slides[slideIndex - 1].classList.add("active");

    // Verander de afbeelding elke 4 seconden
    setTimeout(showSlides, 3000);
}
