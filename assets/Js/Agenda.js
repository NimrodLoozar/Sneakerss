document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal');
    const closeModal = document.querySelector('.close');
    const saveEventButton = document.getElementById('save-event');
    let selectedDay;

    document.querySelectorAll('.add-event').forEach(button => {
        button.addEventListener('click', (e) => {
            selectedDay = e.target.closest('.day').getAttribute('data-day');
            modal.style.display = 'block';
        });
    });

    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    saveEventButton.addEventListener('click', () => {
        const eventDescription = document.getElementById('event').value;
        if (eventDescription) {
            const dayContainer = document.querySelector(`.day[data-day="${selectedDay}"] ul`);
            const newEvent = document.createElement('li');
            newEvent.textContent = eventDescription;
            dayContainer.appendChild(newEvent);
            document.getElementById('event').value = '';  // Maak het invoerveld leeg
            modal.style.display = 'none';  // Sluit de modal
        } else {
            alert('Voer een beschrijving in voor het evenement!');
        }
    });

    // Sluit modal als je buiten de modal klikt
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});
