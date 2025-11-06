// JsAdmin.js - Versión mejorada con buscadores

document.addEventListener('DOMContentLoaded', function() {

    // ===============================================
    // MANEJO DE VISTAS (TABS)
    // ===============================================

    const navLinks = document.querySelectorAll('.sidebar-nav .nav-link');
    const views = document.querySelectorAll('.main-content .view');

    function switchView(targetId) {
        views.forEach(view => view.classList.remove('active'));
        navLinks.forEach(link => link.classList.remove('active'));

        const targetView = document.getElementById(targetId);
        if (targetView) targetView.classList.add('active');

        const activeLink = document.querySelector(`.nav-link[data-target="${targetId}"]`);
        if (activeLink) activeLink.classList.add('active');
    }

    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const targetId = this.getAttribute('data-target');
            switchView(targetId);
        });
    });

    // ===============================================
    // MANEJO DE MODALES
    // ===============================================

    const modalOverlays = document.querySelectorAll('.modal-overlay');
    
    const btnAbrirEvento = document.getElementById('btn-abrir-evento');
    const btnAbrirEducacion = document.getElementById('btn-abrir-educacion');
    const btnAbrirNoticia = document.getElementById('btn-abrir-noticia');

    const modalEvento = document.getElementById('modal-evento');
    const modalEducacion = document.getElementById('modal-educacion');
    const modalNoticia = document.getElementById('modal-noticia');
    
    const closeButtons = document.querySelectorAll('.close-modal');

    function openModal(modal) {
        if (modal) modal.classList.add('active');
    }

    function closeModal(modal) {
        if (modal) modal.classList.remove('active');
    }

    if(btnAbrirEvento) {
        btnAbrirEvento.addEventListener('click', () => openModal(modalEvento));
    }
    if(btnAbrirEducacion) {
        btnAbrirEducacion.addEventListener('click', () => openModal(modalEducacion));
    }
    if(btnAbrirNoticia) {
        btnAbrirNoticia.addEventListener('click', () => openModal(modalNoticia));
    }

    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const modal = button.closest('.modal-overlay');
            closeModal(modal);
        });
    });

    modalOverlays.forEach(overlay => {
        overlay.addEventListener('click', (event) => {
            if (event.target === overlay) {
                closeModal(overlay);
            }
        });
    });

    // ===============================================
    // FUNCIONALIDAD DE BÚSQUEDA EN TABLAS
    // ===============================================

    function setupTableSearch(searchInputId, tableBodyId) {
        const searchInput = document.getElementById(searchInputId);
        const tableBody = document.getElementById(tableBodyId);
        
        if (!searchInput || !tableBody) return;

        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase().trim();
            const rows = tableBody.getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length - 1; j++) {
                    const cellText = cells[j].textContent || cells[j].innerText;
                    
                    if (cellText.toLowerCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }

                row.style.display = found ? '' : 'none';
            }
        });
    }

    // Configurar buscadores para cada tabla
    setupTableSearch('search-eventos', 'eventos-tbody');
    setupTableSearch('search-educacion', 'educacion-tbody');
    setupTableSearch('search-noticias', 'noticias-tbody');

    // ===============================================
    // MANEJO DE FORMULARIOS
    // ===============================================

    const formEvento = document.querySelector('.form-evento');
    const formEducacion = document.querySelector('.form-educacion');
    const formNoticia = document.querySelector('.form-noticia');

    if (formEvento) {
        formEvento.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Formulario de evento enviado');
            closeModal(modalEvento);
            this.reset();
        });
    }

    if (formEducacion) {
        formEducacion.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Formulario de educación enviado');
            closeModal(modalEducacion);
            this.reset();
        });
    }

    if (formNoticia) {
        formNoticia.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Formulario de noticia enviado');
            closeModal(modalNoticia);
            this.reset();
        });
    }
});
