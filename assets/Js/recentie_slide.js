let currentIndex = 0;
const slides = document.querySelector('.slides');
const totalSlides = document.querySelectorAll('.testimonial').length;
const slidesToShow = 3;
const slideWidth = 100 / slidesToShow; // 33.33%

function updateSlidePosition() {
    slides.style.transform = `translateX(-${currentIndex * slideWidth}%)`;
}

function nextSlide() {
    currentIndex = (currentIndex + slidesToShow) % totalSlides;
    updateSlidePosition();
}

function prevSlide() {
    currentIndex = (currentIndex - slidesToShow + totalSlides) % totalSlides;
    updateSlidePosition();
}

// Set initial position
updateSlidePosition();
