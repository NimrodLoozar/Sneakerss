let currentIndex = 0;
const slides = document.querySelector('.testimonial-slides');
const totalSlides = document.querySelectorAll('.testimonial').length;
const slidesToShow = 3;
const slideWidth = 100 / slidesToShow; // 33.33%

// Bereken het totale aantal groepen van slides
const totalGroups = Math.ceil(totalSlides / slidesToShow);

function updateSlidePosition() {
    slides.style.transform = `translateX(-${currentIndex * slideWidth}%)`;
}

function nextSlide() {
    // Ga naar de volgende groep
    currentIndex = (currentIndex + 1) % totalGroups;
    updateSlidePosition();
}

function prevSlide() {
    // Ga naar de vorige groep, of terug naar het einde
    currentIndex = (currentIndex - 1 + totalGroups) % totalGroups;
    updateSlidePosition();
}

// Set initial position
updateSlidePosition();
