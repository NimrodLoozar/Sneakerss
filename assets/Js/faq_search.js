$(document).ready(function () {
    $(".faq-item h3").on("click", function () {
        $(".faq-item p").slideUp();
        $(".faq-item .arrow").html('&rarr;');

        var content = $(this).next('p');
        var arrow = $(this).find('.arrow');
        if (content.is(":visible")) {
            content.slideUp();
            arrow.html('&rarr;');
        } else {
            content.slideDown();
            arrow.html('&#9733;');
        }
    });
});

function searchFAQ() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const faqItems = document.querySelectorAll(".faq-item");

    if (input.trim() === "") {
        // Als het zoekveld leeg is, toon alle FAQ-items
        faqItems.forEach(item => {
            item.style.display = "block"; // Of gebruik item.classList.remove("hidden");
        });
    } else {
        // Filter de FAQ-items op basis van de zoekinvoer
        faqItems.forEach(item => {
            const questionText = item.querySelector("h3").textContent.toLowerCase();
            // Check of de vraag begint met de invoer
            if (questionText.startsWith(input)) {
                item.style.display = "block"; // Of gebruik item.classList.remove("hidden");
            } else {
                item.style.display = "none"; // Of gebruik item.classList.add("hidden");
            }
        });
    }
}
