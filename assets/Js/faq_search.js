$(document).ready(function () {
    $(".faq-item h3").on("click", function () {
        $(".faq-item p").slideUp();
        $(".faq-item .arrow").html('&#10095;');

        var content = $(this).next('p');
        var arrow = $(this).find('.arrow');
        if (content.is(":visible")) {
            content.slideUp();
            arrow.html('&#10095;');
            arrow.toggleClass('rotatedDown');
        } else {
            content.slideDown();
            arrow.html('&#10094;');
            arrow.toggleClass('rotatedDown');
        }
    });
});

function searchFAQ() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const faqItems = document.querySelectorAll(".faq-item");

    if (input.trim() === "") {
        // Als het zoekveld leeg is, toon alle FAQ-items
        faqItems.forEach(item => {
            item.style.display = "block";
        });
        document.getElementById("error-message").style.display = "none"; // Verberg foutmelding
    } else {
        // Filter de FAQ-items op basis van de zoekinvoer
        faqItems.forEach(item => {
            const questionText = item.querySelector("h3").textContent.toLowerCase();
            if (questionText.startsWith(input)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });

        // Controleer of er zichtbare FAQ-items zijn en toon de foutmelding indien nodig
        const hasVisibleItems = Array.from(faqItems).some(item => item.style.display === "block");

        if (!hasVisibleItems) {
            document.getElementById("error-message").style.display = "block";
            document.getElementById("error-message").textContent = "Geen resultaten gevonden.";
        } else {
            document.getElementById("error-message").style.display = "none";
        }
    }
}
