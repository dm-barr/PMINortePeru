/* === Certificaciones: acordeón y vista expandida === */

document.addEventListener('DOMContentLoaded', () => {

    const seccionCert = document.querySelector('.section-certificaciones');
    if (!seccionCert) return;

    /* Acordeón de requisitos */
    const botonesToggle = seccionCert.querySelectorAll('.btn-requisitos');
    botonesToggle.forEach(boton => {
        boton.addEventListener('click', () => {
            const tarjeta = boton.closest('.cert-card');
            const detalles = tarjeta.querySelector('.cert-details');

            detalles.classList.toggle('visible');
            boton.textContent = detalles.classList.contains('visible')
                ? 'Ocultar Requisitos'
                : 'Ver Requisitos';
        });
    });

    /* Expansión dinámica "Saber más" */
    const contenedorPrincipal = seccionCert.querySelector('.cert-container');
    const botonesSaberMas = seccionCert.querySelectorAll('.btn-saber-mas');
    const botonesVolver = seccionCert.querySelectorAll('.btn-volver');

    if (!contenedorPrincipal || botonesSaberMas.length === 0) return;

    botonesSaberMas.forEach(boton => {
        boton.addEventListener('click', (e) => {
            e.preventDefault();
            const tarjeta = boton.closest('.cert-card');

            contenedorPrincipal.classList.add('detalle-abierto');
            tarjeta.classList.add('expandido');
        });
    });

    botonesVolver.forEach(boton => {
        boton.addEventListener('click', () => {
            const tarjeta = boton.closest('.cert-card');

            seccionCert.scrollIntoView({ behavior: 'smooth', block: 'start' });

            contenedorPrincipal.classList.remove('detalle-abierto');
            tarjeta.classList.remove('expandido');
        });
    });

});
