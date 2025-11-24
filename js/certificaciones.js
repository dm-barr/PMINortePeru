document.addEventListener('DOMContentLoaded', () => {
    const seccionCert = document.querySelector('.section-certificaciones');
    if (!seccionCert) return;

    const contenedorPrincipal = seccionCert.querySelector('.cert-container');
    const botonesExpandir = seccionCert.querySelectorAll('.btn-expandir');
    const botonesVolver = seccionCert.querySelectorAll('.btn-volver');

    /* EXPANSIÓN */
    if (contenedorPrincipal && botonesExpandir.length > 0) {

        botonesExpandir.forEach(boton => {
            boton.addEventListener('click', (e) => {
                e.preventDefault();

                const tarjeta = boton.closest('.cert-card');
                const containerPadre = tarjeta.closest('.cert-container');
                containerPadre.classList.add('detalle-abierto');
                tarjeta.classList.add('expandido');
                setTimeout(() => {
                    tarjeta.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            });
        });
        botonesVolver.forEach(boton => {
            boton.addEventListener('click', (e) => {
                e.preventDefault();

                const tarjeta = boton.closest('.cert-card');
                const containerPadre = tarjeta.closest('.cert-container');
                tarjeta.classList.remove('expandido');
                containerPadre.classList.remove('detalle-abierto');
                setTimeout(() => {
                    tarjeta.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 100);
            });
        });
    }

    /* FAQ */
    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(question => {
        question.addEventListener('click', () => {
            const faqItem = question.parentElement;
            document.querySelectorAll('.faq-item.active').forEach(item => {
                if (item !== faqItem) item.classList.remove('active');
            });

            faqItem.classList.toggle('active');
        });
    });

});