document.addEventListener('DOMContentLoaded', function() {
const menuToggle = document.getElementById('menu-toggle'); 
    const menuIcon = document.querySelector('.menu-icon');    
    const navMenu = document.querySelector('.menu');           
    const menuLinks = document.querySelectorAll('.menu a:not(.dropdown-toggle)');
    const dropdowns = document.querySelectorAll('.dropdown-beneficios, .dropdown-certificacion, .dropdown-comunidades');

    if (menuIcon && menuToggle) {
        menuIcon.addEventListener('click', function(e) {
            e.preventDefault(); 
            menuToggle.checked = !menuToggle.checked;
        });
    }

    menuLinks.forEach(link => {
        link.addEventListener('click', () => {
            if(menuToggle) menuToggle.checked = false;
        });
    });

    dropdowns.forEach(dropdown => {
        const toggleBtn = dropdown.querySelector('.dropdown-toggle');
        
        if (toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                if (window.innerWidth <= 968) { 
                    e.preventDefault(); 
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