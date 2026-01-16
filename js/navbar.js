document.addEventListener('DOMContentLoaded', function() {
    // Manejo del Menú Hamburguesa en Móvil
    const menuToggle = document.getElementById('menu-toggle');
    const menuIcon = document.querySelector('.menu-icon');
    const menuLinks = document.querySelectorAll('.menu a:not(.dropdown-toggle)');
    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            if(menuToggle) menuToggle.checked = false;
        });
    });

    const dropdowns = document.querySelectorAll('.dropdown-container');

    dropdowns.forEach(dropdown => {
        const toggleBtn = dropdown.querySelector('.dropdown-toggle');
        
        if (toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                if (window.innerWidth <= 968) { 
                    e.preventDefault();
                    dropdowns.forEach(other => {
                        if (other !== dropdown) other.classList.remove('active');
                    });
                    dropdown.classList.toggle('active');
                }
            });
        }
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.nav-container')) {
            dropdowns.forEach(d => d.classList.remove('active'));
            if(menuToggle) menuToggle.checked = false;
        }
    });
});