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

    // Abrir modales en modo AGREGAR
    if(btnAbrirEvento) {
        btnAbrirEvento.addEventListener('click', () => {
            document.getElementById('titulo-modal-evento').textContent = 'Agregar Evento';
            document.getElementById('accion-evento').value = 'agregar_evento';
            document.getElementById('evento-id').value = '';
            document.querySelector('.form-evento').reset();
            openModal(modalEvento);
        });
    }
    if(btnAbrirEducacion) {
        btnAbrirEducacion.addEventListener('click', () => {
            document.getElementById('titulo-modal-educacion').textContent = 'Agregar Curso';
            document.getElementById('accion-educacion').value = 'agregar_educacion';
            document.getElementById('educacion-id').value = '';
            document.querySelector('.form-educacion').reset();
            openModal(modalEducacion);
        });
    }
    if(btnAbrirNoticia) {
        btnAbrirNoticia.addEventListener('click', () => {
            document.getElementById('titulo-modal-noticia').textContent = 'Agregar Noticia';
            document.getElementById('accion-noticia').value = 'agregar_noticia';
            document.getElementById('noticia-id').value = '';
            document.querySelector('.form-noticia').reset();
            openModal(modalNoticia);
        });
    }

    // Cerrar modales
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
    // EDITAR - Cargar datos en modales
    // ===============================================

    // EDITAR EVENTO
    document.querySelectorAll('.btn-editar-evento').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            document.getElementById('titulo-modal-evento').textContent = 'Editar Evento';
            document.getElementById('accion-evento').value = 'editar_evento';
            document.getElementById('evento-id').value = this.dataset.id;
            document.getElementById('evento-nombre').value = this.dataset.nombre;
            document.getElementById('evento-descripcion').value = this.dataset.descripcion;
            document.getElementById('evento-comunidad').value = this.dataset.comunidad;
            document.getElementById('evento-modalidad').value = this.dataset.modalidad;
            document.getElementById('evento-categoria').value = this.dataset.categoria;
            document.getElementById('evento-lugar').value = this.dataset.lugar;
            document.getElementById('evento-imagen').value = this.dataset.imagen;
            
            openModal(modalEvento);
        });
    });

    // EDITAR EDUCACIÓN
    document.querySelectorAll('.btn-editar-educacion').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            document.getElementById('titulo-modal-educacion').textContent = 'Editar Curso';
            document.getElementById('accion-educacion').value = 'editar_educacion';
            document.getElementById('educacion-id').value = this.dataset.id;
            document.getElementById('curso-nombre').value = this.dataset.curso;
            document.getElementById('curso-modalidad').value = this.dataset.modalidad;
            document.getElementById('curso-fecha').value = this.dataset.fecha;
            document.getElementById('curso-instructor').value = this.dataset.instructor;
            document.getElementById('curso-descripcion').value = this.dataset.descripcion;
            document.getElementById('curso-imagen').value = this.dataset.imagen || '';
            
            openModal(modalEducacion);
        });
    });

    // EDITAR NOTICIA
    document.querySelectorAll('.btn-editar-noticia').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            document.getElementById('titulo-modal-noticia').textContent = 'Editar Noticia';
            document.getElementById('accion-noticia').value = 'editar_noticia';
            document.getElementById('noticia-id').value = this.dataset.id;
            document.getElementById('noticia-titulo').value = this.dataset.titulo;
            document.getElementById('noticia-descripcion').value = this.dataset.descripcion;
            document.getElementById('noticia-imagen').value = this.dataset.imagen;
            
            openModal(modalNoticia);
        });
    });

    // ===============================================
    // ELIMINAR
    // ===============================================

    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const tipo = this.dataset.tipo;
            const id = this.dataset.id;
            const tipoTexto = tipo === 'evento' ? 'evento' : (tipo === 'educacion' ? 'curso' : 'noticia');
            
            if (confirm(`¿Estás seguro de eliminar este ${tipoTexto}?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                
                const inputAccion = document.createElement('input');
                inputAccion.type = 'hidden';
                inputAccion.name = 'accion';
                inputAccion.value = `eliminar_${tipo}`;
                
                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'id';
                inputId.value = id;
                
                form.appendChild(inputAccion);
                form.appendChild(inputId);
                document.body.appendChild(form);
                form.submit();
            }
        });
    });

    // ===============================================
    // BUSCADORES EN TABLAS
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

    setupTableSearch('search-eventos', 'eventos-tbody');
    setupTableSearch('search-educacion', 'educacion-tbody');
    setupTableSearch('search-noticias', 'noticias-tbody');

    // ===============================================
    // AUTO-OCULTAR MENSAJES
    // ===============================================

    const alertas = document.querySelectorAll('.alert');
    alertas.forEach(alerta => {
        setTimeout(() => {
            alerta.style.transition = 'opacity 0.5s';
            alerta.style.opacity = '0';
            setTimeout(() => alerta.remove(), 500);
        }, 3000);
    });
});
