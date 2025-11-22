<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manuales y Guías | PMI Norte Perú</title>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/manuales.css">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="img/logo/icono.png" type="image/x-icon">
</head>

<body>

    <?php include 'header.php'; ?>

    <!-- ===============================
        FRANJA MORADA SUPERIOR (IGUAL A BENEFICIOS)
    =================================-->
    <div class="header-banner">
        <div class="contenedor">
            <h1>Manuales y Guías</h1> 
        </div>
    </div>


    

    <!-- ===============================
        CONTENEDOR DOS COLUMNAS (MENU + CONTENIDO)
    =================================-->
    <div class="contenedor-principal">

        <!-- ========= MENÚ IZQUIERDO (REDUCIDO) ========= -->
        <aside class="sidebar-navegacion">
            <h4>Membresía</h4>
            <ul>
                <li><a href="beneficios.php">Beneficios</a></li> 
                <li><a href="#">Tipos de Mebresía</a></li>
                <li><a href="manuales.php">Manuales</a></li>
                <li><a href="#">Videos</a></li>
                <li><a href="#">Preguntas Frecuentes</a></li>
            </ul>
        </aside>

        <!-- ========= CONTENIDO PRINCIPAL ========= -->
        <main class="contenido-beneficios">

            <!-- ====== MANUAL PROFESIONAL ====== -->
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
                        Ver Guía Profesional (PDF)
                    </a>
                </div>
            </section>

            <!-- ====== MANUAL ESTUDIANTE ====== -->
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
                        Ver Guía Estudiante (PDF)
                    </a>
                </div>
            </section>

        </main>

</div>

</body>
</html>
