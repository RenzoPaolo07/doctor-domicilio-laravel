// assets/js/main.js

// Función para toggle de dropdowns
function toggleDropdown(event, dropdownId) {
    event.preventDefault();
    
    // Cerrar otros dropdowns abiertos
    document.querySelectorAll('.dropdown-container.active').forEach(container => {
        if (container.querySelector('.dropdown-menu').id !== dropdownId) {
            container.classList.remove('active');
        }
    });
    
    // Toggle el dropdown actual
    const container = event.currentTarget.closest('.dropdown-container');
    container.classList.toggle('active');
}

// Cerrar dropdowns al hacer clic fuera
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown-container')) {
        document.querySelectorAll('.dropdown-container.active').forEach(container => {
            container.classList.remove('active');
        });
    }
});

// Para dispositivos móviles: menú toggle
document.getElementById('menuToggle')?.addEventListener('click', function() {
    document.querySelector('.sidebar').classList.toggle('active');
});