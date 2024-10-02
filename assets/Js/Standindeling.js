// Mock data voor verkopers
const standData = [
    { id: 1, name: "Verkoper A", x: 50, y: 100 },
    { id: 2, name: "Verkoper B", x: 200, y: 150 },
    { id: 3, name: "Verkoper C", x: 300, y: 250 }
];

const mapContainer = document.getElementById('stand-map');
const errorMessage = document.getElementById('error-message');

// Functie om verkoper-markers toe te voegen
function displayStands(stands) {
    if (stands.length > 0) {
        stands.forEach(stand => {
            const marker = document.createElement('div');
            marker.classList.add('marker');
            marker.style.left = `${stand.x}px`;
            marker.style.top = `${stand.y}px`;
            marker.innerText = stand.id;
            marker.title = stand.name;
            mapContainer.appendChild(marker);
        });
    } else {
        showError();
    }
}

// Functie voor foutmelding
function showError() {
    mapContainer.classList.add('hidden');
    errorMessage.classList.remove('hidden');
}

// Check voor beschikbare standdata
if (standData.length > 0) {
    displayStands(standData);
} else {
    showError();
}
