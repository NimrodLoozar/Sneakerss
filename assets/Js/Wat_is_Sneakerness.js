// Mock data voor informatie over Sneakerness (kan worden vervangen door een API-aanroep)
const sneakernessInfo = {
    description: "Sneakerness is het grootste Europese evenement voor sneakercultuur. Het brengt verzamelaars, verkopers en liefhebbers samen.",
    date: "12-13 Oktober 2024",
    location: "RAI Amsterdam, Nederland",
    tickets: {
        available: true,
        price: "€25 per dag",
        link: "https://www.sneakerness.com/tickets"
    },
    activities: [
        "Verkoop van exclusieve sneakers",
        "Live sneaker customizing",
        "Paneldiscussies met experts",
        "Meet-and-greets met bekende verzamelaars"
    ]
};

// Selecteer HTML-elementen
const infoContent = document.getElementById('info-content');
const errorMessage = document.getElementById('error-message');

// Functie om de informatie te tonen
function displayInfo(info) {
    if (info && info.description && info.activities.length > 0) {
        // Beschrijving
        const description = document.createElement('p');
        description.innerText = info.description;
        infoContent.appendChild(description);

        // Datum en locatie
        const eventDetails = document.createElement('p');
        eventDetails.innerText = `Datum: ${info.date} | Locatie: ${info.location}`;
        infoContent.appendChild(eventDetails);

        // Ticketinformatie
        const ticketInfo = document.createElement('p');
        if (info.tickets.available) {
            ticketInfo.innerHTML = `Tickets beschikbaar voor ${info.tickets.price}. <a href="${info.tickets.link}" target="_blank">Koop hier je tickets</a>.`;
        } else {
            ticketInfo.innerText = "Tickets zijn momenteel niet beschikbaar.";
        }
        infoContent.appendChild(ticketInfo);

        // Activiteitenlijst
        const activityList = document.createElement('ul');
        info.activities.forEach(activity => {
            const listItem = document.createElement('li');
            listItem.innerText = activity;
            activityList.appendChild(listItem);
        });
        infoContent.appendChild(activityList);
    } else {
        showError();
    }
}

// Functie om de foutmelding te tonen
function showError() {
    infoContent.classList.add('hidden');
    errorMessage.classList.remove('hidden');
}

// Controleer of de informatie beschikbaar is
if (sneakernessInfo) {
    displayInfo(sneakernessInfo);
} else {
    showError();
}
