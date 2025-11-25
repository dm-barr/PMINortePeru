document.addEventListener("DOMContentLoaded", () => {

    const btnProf = document.getElementById("btn-profesional");
    const btnEst = document.getElementById("btn-estudiante");

    const boxProf = document.getElementById("box-profesional");
    const boxEst = document.getElementById("box-estudiante");

    // ===== CONTENIDO DEL MANUAL PROFESIONAL =====
    const htmlProfesional = `
         <section class="manual-item">
                <div class="manual-imagen">
                    <a href="../pdfs/manual_profesional.pdf" target="_blank">
                        <img src="../img/certificaciones/capm.png" alt="Portada Manual Profesional">
                    </a>
                </div>

                <div class="manual-texto">
                    <h2>Guía para Miembro Profesional</h2>
                    <p>
                        Este manual detalla todos los beneficios, responsabilidades y oportunidades disponibles para nuestros miembros profesionales. Descubre cómo maximizar tu membresía, conectar con otros expertos y acceder a recursos exclusivos para impulsar tu carrera.
                    </p>

                    <a href="../pdfs/manual_profesional.pdf" target="_blank" class="btn-manual">
                        Ver (PDF)
                    </a>
                </div>
            </section>
    `;

    // ===== CONTENIDO DEL MANUAL ESTUDIANTE =====
    const htmlEstudiante = `
         <section class="manual-item">
                <div class="manual-imagen">
                    <a href="../pdfs/manual_estudiante.pdf" target="_blank">
                        <img src="../img/certificaciones/acp.png" alt="Portada Manual Estudiante">
                    </a>
                </div>

                <div class="manual-texto">
                    <h2>Guía para Miembro Estudiante</h2>
                    <p>
                        Esta guía está diseñada para estudiantes y te muestra cómo aprovechar al máximo tu membresía, obtener descuentos en certificaciones como la CAPM® y participar en eventos de networking.
                    </p>

                    <a href="../pdfs/manual_estudiante.pdf" target="_blank" class="btn-manual">
                        Ver (PDF)
                    </a>
                </div>
            </section>
    `;

     // ===== EVENTOS CLICK BOTONES =====
    btnProf.addEventListener("click", (e) => {
        e.stopPropagation(); 
        boxProf.style.display = "block";
        boxEst.style.display = "none"; 
        boxProf.innerHTML = htmlProfesional;

        boxProf.scrollIntoView({ behavior: "smooth" });
    });

    btnEst.addEventListener("click", (e) => {
        e.stopPropagation();
        boxEst.style.display = "block";
        boxProf.style.display = "none"; 
        boxEst.innerHTML = htmlEstudiante;

        boxEst.scrollIntoView({ behavior: "smooth" });
    });

    // ===== CERRAR AL CLICKEAR FUERA =====
    document.addEventListener("click", (e) => {
        const clickDentroProf = boxProf.contains(e.target);
        const clickDentroEst = boxEst.contains(e.target);
        const clickEnBoton = e.target === btnProf || e.target === btnEst;

        if (!clickDentroProf && !clickDentroEst && !clickEnBoton) {
            boxProf.style.display = "none";
            boxEst.style.display = "none";
        }
    });

});
