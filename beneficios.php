<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMI Norte Perú</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/beneficios.css">
 
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="img/logo/icono.png" type="image/x-icon">
    <!-- Script de reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LdvMAgsAAAAADUpao4CRIs4Irv2zsIbT95UN_mg"></script>
</head>

<body>
    <?php include 'header.php'; ?>

    <div class="header-banner">
        <div class="contenedor">
            <h1>Beneficios</h1> 
        </div>
    </div>

    <div class="contenedor-principal">
        
        <aside class="sidebar-navegacion">
            <h4>Membresía</h4>
            <ul>
                <li><a href="beneficios.php">Beneficios</a></li> 
                <li><a href="tiposMembresia.php">Tipos de Mebresía</a></li>            
                <li><a href="preguntas.php">Preguntas Frecuentes</a></li>
            </ul>
        </aside>
        <main class="contenido-beneficios">
            
            <section class="seccion-intro">
                <h2>¡Transforma ideas en valor real!</h2>
                <p class="lead">
                    El Capítulo Norte de Perú conecta a Cajamarca, Piura y Trujillo con los recursos mundiales del PMI. 
                    Descubre cómo impulsamos tu carrera según tu etapa profesional.
                </p>
                <div class="video-container">
                    <div class="placeholder-video">
                        <span>[video de bienvenida ]</span>
                    </div>
                </div>
            </section>

            <hr class="divisor">

            <section class="seccion-grupo profesional">
                <div class="titulo-grupo">
                    <i class="fas fa-briefcase icono-titulo"></i>
                    <div>
                        <h2>Para Profesionales con Experiencia</h2>
                        <p>Consolida tu carrera, fomenta el liderazgo regional y genera impacto local.</p>
                    </div>
                    <!-- BOTÓN PARA CARGAR MANUALES -->
                    <button class="manual-btn" id="btn-profesional">Ver Manual Profesional</button>
                </div>

                <div class="beneficios-grid-detalle">
                    <div class="beneficio-detalle-card">
                        <h4><i class="fas fa-crown"></i> Liderazgo y Visibilidad</h4>
                        <ul>
                            <li><strong>Voluntariado Estratégico:</strong> Lidera iniciativas y comités, ganando reconocimiento entre stakeholders del norte.</li>
                            <li><strong>Ponencias Locales:</strong> Participa como expositor en eventos y meetups, posicionándote como experto.</li>
                        </ul>
                    </div>
                    <div class="beneficio-detalle-card">
                        <h4><i class="fas fa-network-wired"></i> Networking Regional</h4>
                        <ul>
                            <li><strong>Conexiones Directas:</strong> Contacta con líderes de agroindustria, minería y construcción en Piura, Trujillo y Cajamarca.</li>
                            <li><strong>Alianzas Locales:</strong> Acceso a convenios con empresas y cámaras de comercio de la zona.</li>
                        </ul>
                    </div>
                    <div class="beneficio-detalle-card">
                        <h4><i class="fas fa-chart-line"></i> Desarrollo Avanzado</h4>
                        <ul>
                            <li><strong>Descuentos:</strong> Ahorros en certificaciones PMP®, PgMP®, PfMP® que aumentan tu potencial salarial.</li>
                            <li><strong>Enfoque Local:</strong> Talleres sobre desafíos específicos de proyectos en el norte del Perú.</li>
                        </ul>
                    </div>
                </div>
            </section>
 

                <!-- CAJA DONDE SE CARGA EL MANUAL PROFESIONAL -->
                <section class="manual-box" id="box-profesional"></section>

            <section class="seccion-grupo estudiante">
                <div class="titulo-grupo">
                    <i class="fas fa-graduation-cap icono-titulo"></i>
                    <div>
                        <h2>Para Estudiantes de Pregrado</h2>
                        <p>Construye una base sólida y facilita tu inserción laboral desde la universidad.</p>
                    </div>
                    <button class="manual-btn" id="btn-estudiante">Ver Manual Estudiante</button>
                </div>

                <div class="beneficios-grid-detalle">
                    <div class="beneficio-detalle-card">
                        <h4><i class="fas fa-percentage"></i> Costos y Certificación</h4>
                        <ul>
                            <li><strong>Membresía Asequible:</strong> Tarifas especiales (Global + Capítulo) mucho menores que las de un profesional.</li>
                            <li><strong>Certificación CAPM®:</strong> Descuentos ideales para validar conocimientos antes de tener experiencia.</li>
                        </ul>
                    </div>
                    <div class="beneficio-detalle-card">
                        <h4><i class="fas fa-hands-helping"></i> Experiencia Práctica</h4>
                        <ul>
                            <li><strong>Voluntariado:</strong> Gana experiencia real en gestión de proyectos para tu CV.</li>
                            <li><strong>Mentoría:</strong> Conecta con profesionales senior para orientación de carrera y pasantías.</li>
                        </ul>
                    </div>
                    <div class="beneficio-detalle-card">
                        <h4><i class="fas fa-users"></i> Comunidad Universitaria</h4>
                        <ul>
                            <li><strong>Clubes Estudiantiles:</strong> Forma parte de comunidades en universidades del norte.</li>
                            <li><strong>Talleres Jóvenes:</strong> Eventos adaptados para acumular PDUs desde temprano.</li>
                        </ul>
                    </div>
                </div>
            </section>

                <!-- CAJA DONDE SE CARGA EL MANUAL ESTUDIANTE -->
                <section class="manual-box" id="box-estudiante"></section>

            <hr class="divisor">

            <section class="seccion-grupo transversal">
                <h2>Beneficios Transversales</h2>
                <p>Recursos globales disponibles para todos los miembros del Capítulo Norte Perú.</p>
                
                <div class="contenedor-tarjetas-iconos">
                    <div class="beneficio-card">
                        <i class="icono-beneficio fas fa-book"></i>
                        <div class="beneficio-contenido">
                            <h3>Estándares Globales</h3>
                            <p>Descarga gratuita de la Guía del PMBOK® y otros estándares.</p>
                        </div>
                    </div>
                    <div class="beneficio-card secundario">
                        <i class="icono-beneficio fas fa-tools"></i>
                        <div class="beneficio-contenido">
                            <h3>Herramientas</h3>
                            <p>Acceso a +1,000 plantillas y al asistente de IA PMI Infinity.</p>
                        </div>
                    </div>
                    <div class="beneficio-card">
                        <i class="icono-beneficio fas fa-globe"></i>
                        <div class="beneficio-contenido">
                            <h3>Networking Global</h3>
                            <p>Conexión con la comunidad global de +750,000 profesionales.</p>
                        </div>
                    </div>
                    <div class="beneficio-card secundario">
                        <i class="icono-beneficio fas fa-briefcase"></i>
                        <div class="beneficio-contenido">
                            <h3>Bolsa de Trabajo</h3>
                            <p>Acceso a ofertas de empleo y pasantías a nivel global y nacional.</p>
                        </div>
                    </div>
                    <div class="beneficio-card">
                        <i class="icono-beneficio fas fa-newspaper"></i>
                        <div class="beneficio-contenido">
                            <h3>Publicaciones</h3>
                            <p>Suscripción a revistas (PM Network) y recursos de investigación.</p>
                        </div>
                    </div>
                    <div class="beneficio-card secundario">
                        <i class="icono-beneficio fas fa-id-card"></i>
                        <div class="beneficio-contenido">
                            <h3>Diploma</h3>
                            <p>Recepción de un carnet y diploma digital de afiliación.</p>
                        </div>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <p>© 2025 PMI Norte Perú</p>
    </footer>

    <script src="js/submenu.js"></script>
    <script src="js/beneficios.js"></script>


</body>
</html>