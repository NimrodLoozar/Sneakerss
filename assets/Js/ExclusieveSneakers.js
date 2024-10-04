// Mock data (kan vervangen worden door een echte API-aanroep)
const sneakersData = [
    {
        name: "Sneaker 1",
        brand: "Brand A",
        image: "sneaker1.jpg",
        price: "$150"
    },
    {
        name: "Sneaker 2",
        brand: "Brand B",
        image: "sneaker2.jpg",
        price: "$200"
    }
];

// HTML-elementen selecteren
const sneakerContainer = document.getElementById('sneakers');
const errorMessage = document.getElementById('error-message');

// Functie om sneakers te tonen
function displaySneakers(sneakers) {
    if (sneakers.length > 0) {
        sneakers.forEach(sneaker => {
            const sneakerItem = document.createElement('div');
            sneakerItem.classList.add('sneaker');
            sneakerItem.innerHTML = `
                <img src="${sneaker.image}" alt="${sneaker.name}">
                <h2>${sneaker.name}</h2>
                <p>${sneaker.brand}</p>
                <p>${sneaker.price}</p>
            `;
            sneakerContainer.appendChild(sneakerItem);
        });
    } else {
        showError();
    }
}

// Functie om foutmelding te tonen
function showError() {
    sneakerContainer.classList.add('error_hidden');
    errorMessage.classList.remove('error_hidden');
}

// Sneakers weergeven of foutmelding tonen
if (sneakersData.length > 0) {
    displaySneakers(sneakersData);
} else {
    showError();
}
