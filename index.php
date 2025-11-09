<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/php/noticia.php';
require_once __DIR__ . '/php/evento.php';
require_once __DIR__ . '/php/educacion.php';

$noticiaModel = new NoticiaModel_mysqli();
$eventoModel = new EventoModel_mysqli();
$educacionModel = new EducacionModel_mysqli();

$noticias = $noticiaModel->getAll();
$eventos = $eventoModel->getAll();
$educaciones = $educacionModel->getAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMI Norte Perú</title>

    <!-- Estilos y fuentes -->
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="img/logo/icono.png" type="image/x-icon">
</head>

<body>

    <!-- 🔹 BARRA SUPERIOR -->
    <div class="topbar">
        <div class="topbar-left">
            <a href="https://www.instagram.com/pminorteperu?igsh=MWw1OGU1dWgxcHV2bw==" class="social"><i
                    class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/share/1CfCowCGzB/" class="social"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.linkedin.com/company/pmi-norte-peru-chapter" class="social"><i
                    class="fab fa-linkedin-in"></i></a>
        </div>
        <div class="topbar-right">
            <span class="email">informes@pminorteperu.org</span>
            <span class="separator">•</span>
            <a href="#contacto" class="contact-link">Contáctanos</a>
        </div>
    </div>

    <!-- 🔹 NAVBAR -->
    <header class="navbar">
        <div class="nav-container">
            <img src="img/logo/logo.png" alt="PMI Norte Perú Logo" class="logo">
            <nav class="nav-menu">
                <a href="#home">Inicio</a>
                <a href="#nosotros">Nosotros</a>
                <a href="#eventos">Eventos</a>
                <a href="#junta">Junta Directiva</a>
                <a href="#voluntariado">Voluntariado</a>
                <a href="#contacto">Contacto</a>
            </nav>
            <button class="btn-afiliate">Afíliate</button>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </header>

    <!-- Hero Principal -->
    <section id="home" class="hero">
        <!-- Video de fondo -->
        <video autoplay muted loop playsinline class="hero-video">
            <source src="img/fondo/fondo.mp4" type="video/mp4">
        </video>

        <div class="hero-content">
            <h1 class="hero-title">
                Transformamos ideas en <br>
                <span class="highlight">valor real</span> para Cajamarca, Piura y Trujillo <br>
                mediante dirección de proyectos.
            </h1>
        </div>

        <!-- Contador estilo congreso -->
        <div class="congress-counter">
            <div class="counter-item">
                <span class="counter-number" data-target="300">0</span>
                <span class="counter-label">Miembros</span>
            </div>
            <div class="counter-item">
                <span class="counter-number" data-target="50">0</span>
                <span class="counter-label">Eventos realizados</span>
            </div>
            <div class="counter-item">
                <span class="counter-number" data-target="15">0</span>
                <span class="counter-label">Talleres de formación</span>
            </div>
            <div class="counter-item">
                <span class="counter-number" data-target="3">0</span>
                <span class="counter-label">Ciudades</span>
            </div>
        </div>
    </section>

    <!-- 🔹 QUIÉNES SOMOS -->
    <section id="nosotros" class="nosotros">
        <div class="nosotros-container">
            <div class="nosotros-text">
                <h2 class="section-title">Quiénes somos</h2>
                <p class="nosotros-description">
                    PMI Norte Perú Chapter es una comunidad profesional afiliada al Project Management Institute (PMI)
                    que impulsa la excelencia en la dirección de proyectos en las regiones de Cajamarca, Trujillo y
                    Piura. Promovemos el desarrollo del talento local mediante formación, certificaciones, eventos y
                    espacios de colaboración que fortalecen la gestión profesional de proyectos y contribuyen al
                    crecimiento sostenible del norte del país.
                </p>
            </div>

            <div class="nosotros-cards">
                <div class="nosotros-card">
                    <div class="card-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Misión</h3>
                    <p>Fortalecer las competencias en dirección de proyectos de los profesionales del norte del Perú,
                        promoviendo el liderazgo, la ética y la creación de valor a través de la aplicación de
                        estándares y buenas prácticas del PMI.</p>
                </div>

                <div class="nosotros-card">
                    <div class="card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Visión</h3>
                    <p>Ser el capítulo referente del norte del Perú en gestión de proyectos, reconocido por su impacto
                        positivo en la comunidad y por fomentar una cultura de excelencia, innovación y colaboración.
                    </p>
                </div>

                <div class="nosotros-card">
                    <div class="card-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Valores</h3>
                    <ul class="valores-list">
                        <li><strong>Excelencia:</strong> compromiso con la calidad y la mejora continua.</li>
                        <li><strong>Integridad:</strong> actuar con ética y transparencia.</li>
                        <li><strong>Colaboración:</strong> trabajo conjunto y aprendizaje compartido.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- 🔹 PRÓXIMOS EVENTOS -->
    <section id="eventos" class="eventos">
        <div class="eventos-container">
            <h2 class="section-title">Próximos eventos</h2>
            <p class="eventos-intro">
                En el PMI Norte Perú Chapter promovemos el aprendizaje continuo y la conexión entre profesionales de
                todo el norte del país. Participa en nuestros eventos, talleres y congresos, donde compartimos
                experiencias, conocimientos y buenas prácticas en dirección de proyectos que transforman ideas en
                resultados reales.
            </p>

            <div class="eventos-grid">
                <?php if (!empty($eventos)): ?>
                    <?php foreach ($eventos as $evento): ?>
                        <div class="evento-card">
                            <div class="evento-image">
                                <img src="<?php echo htmlspecialchars($evento['imagen']); ?>"
                                    alt="<?php echo htmlspecialchars($evento['titulo']); ?>">
                                <div class="evento-badge"><?php echo htmlspecialchars($evento['tipo']); ?></div>
                            </div>
                            <div class="evento-content">
                                <h3><?php echo htmlspecialchars($evento['titulo']); ?></h3>
                                <p class="evento-fecha">
                                    <i class="far fa-calendar-alt"></i>
                                    <?php echo htmlspecialchars($evento['fecha']); ?>
                                </p>
                                <p><?php echo htmlspecialchars($evento['descripcion']); ?></p>
                                <a href="<?php echo htmlspecialchars($evento['enlace']); ?>" class="btn-ver-mas">Ver más</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-content">No hay eventos disponibles actualmente.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 🔹 LLAMADO A LA ACCIÓN -->
    <section class="cta-membresia">
        <div class="cta-content">
            <h2>Únete al PMI Norte Perú Chapter</h2>
            <p>Y forma parte de una comunidad que impulsa el crecimiento profesional, la innovación y el liderazgo en
                la gestión de proyectos. Juntos, hacemos que las ideas se conviertan en resultados que transforman
                nuestra región.</p>
            <button class="btn-afiliate-cta">Afíliate ahora</button>
        </div>
    </section>

    <!-- ========================================
         🔹 SECCIÓN EDUCACIÓN - COMENTADA
         (Descomentar cuando se necesite)
    ========================================= -->
    <!--
    <section id="educacion" class="educacion">
        <div class="educacion-container">
            <h2 class="section-title">Impulsa tu formación</h2>
            <p class="educacion-intro">
                En el PMI Norte Perú Chapter promovemos el aprendizaje continuo y la conexión entre profesionales de
                todo el norte del país. Participa en nuestros eventos, talleres y congresos, donde compartimos
                experiencias, conocimientos y buenas prácticas en dirección de proyectos que transforman ideas en
                resultados reales.
            </p>

            <div class="educacion-grid">
                <?php if (!empty($educaciones)): ?>
                    <?php foreach ($educaciones as $educacion): ?>
                        <div class="educacion-card">
                            <div class="educacion-image">
                                <img src="<?php echo htmlspecialchars($educacion['imagen']); ?>"
                                    alt="<?php echo htmlspecialchars($educacion['titulo']); ?>">
                                <div class="educacion-badge"><?php echo htmlspecialchars($educacion['tipo']); ?></div>
                            </div>
                            <div class="educacion-content">
                                <h3><?php echo htmlspecialchars($educacion['titulo']); ?></h3>
                                <p class="educacion-fecha">
                                    <i class="far fa-calendar-alt"></i>
                                    <?php echo htmlspecialchars($educacion['fecha']); ?>
                                </p>
                                <p><?php echo htmlspecialchars($educacion['descripcion']); ?></p>
                                <a href="<?php echo htmlspecialchars($educacion['enlace']); ?>" class="btn-ver-mas">Ver más</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-content">No hay cursos disponibles actualmente.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    -->

    <!-- JUNTA DIRECTIVA -->
    <section id="junta" class="junta-directiva">
        <div class="junta-container">
            <h2 class="section-title">Junta Directiva</h2>
            <p class="junta-intro">
                La Junta Directiva del PMI Norte Perú Chapter está conformada por profesionales comprometidos con
                promover la excelencia en la gestión de proyectos y fortalecer la presencia del PMI en la región norte
                del país. Cada miembro aporta su experiencia, liderazgo y visión estratégica para impulsar iniciativas
                clave para el desarrollo dentro de nuestra comunidad.
            </p>

            <div class="junta-grid">
                <!-- Miembro 1 -->
                <div class="junta-card">
                    <div class="junta-image">
                        <img src="img/equipo/persona.png" alt="Alex Valdivia">
                    </div>
                    <div class="junta-info">
                        <h3>Alex Valdivia</h3>
                        <p class="junta-cargo">Presidente</p>
                        <a href="https://www.linkedin.com/in/alexvaldiviacruzado" target="_blank" class="linkedin-btn">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>

                <!-- Miembro 2 -->
                <div class="junta-card">
                    <div class="junta-image">
                        <img src="img/equipo/persona.png" alt="María Rodríguez">
                    </div>
                    <div class="junta-info">
                        <h3>María Rodríguez</h3>
                        <p class="junta-cargo">Vicepresidenta</p>
                        <a href="#" target="_blank" class="linkedin-btn">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>

                <!-- Más miembros aquí -->
            </div>
        </div>
    </section>

    <!-- 🔹 VOLUNTARIADO -->
    <section id="voluntariado" class="voluntariado">
        <div class="voluntariado-container">
            <h2 class="section-title">Sé parte del cambio</h2>
            <p class="voluntariado-intro">
                Forma parte activa del PMI Norte Perú Chapter como voluntario y contribuye al desarrollo de la
                comunidad profesional de gestión de proyectos. Participar como voluntario te permite aprender, liderar y
                conectar con otros profesionales, fortaleciendo tus habilidades mientras generas un impacto positivo en
                tu región.
            </p>
            <button class="btn-voluntario" id="openModalVoluntario">Quiero ser voluntario</button>
        </div>
    </section>

    <!-- FORMULARIO DE VOLUNTARIADO PARA EVENTOS -->
    <div id="modalVoluntario" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModalVoluntario">&times;</span>
            <h2>Formulario de Voluntariado</h2>
            <form id="formVoluntario">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="tel" name="telefono" placeholder="Teléfono" required>
                <select name="ciudad" required>
                    <option value="">Selecciona tu ciudad</option>
                    <option value="Cajamarca">Cajamarca</option>
                    <option value="Trujillo">Trujillo</option>
                    <option value="Piura">Piura</option>
                </select>
                <textarea name="mensaje" placeholder="¿Por qué quieres ser voluntario?" rows="4"></textarea>
                <button type="submit" class="btn-enviar">Enviar solicitud</button>
            </form>
        </div>
    </div>

    <!-- ========================================
         🔹 SECCIÓN NOTICIAS - COMENTADA
         (Descomentar cuando se necesite)
    ========================================= -->
    <!--
    <section id="noticias" class="noticias">
        <div class="noticias-container">
            <h2 class="section-title">Noticias recientes</h2>
            <p class="noticias-intro">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
            </p>

            <div class="noticias-grid">
                <?php if (!empty($noticias)): ?>
                    <?php foreach ($noticias as $noticia): ?>
                        <div class="noticia-card">
                            <div class="noticia-image">
                                <img src="<?php echo htmlspecialchars($noticia['imagen']); ?>"
                                    alt="<?php echo htmlspecialchars($noticia['titulo']); ?>">
                            </div>
                            <div class="noticia-content">
                                <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                                <p class="noticia-fecha">
                                    <i class="far fa-calendar-alt"></i>
                                    <?php echo htmlspecialchars($noticia['fecha']); ?>
                                </p>
                                <p><?php echo htmlspecialchars($noticia['descripcion']); ?></p>
                                <a href="<?php echo htmlspecialchars($noticia['enlace']); ?>" class="btn-leer-mas">Leer más</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-content">No hay noticias recientes.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    -->

    <!-- 🔹 CONTÁCTANOS -->
    <section id="contacto" class="contacto">
        <div class="contacto-container">
            <h2 class="section-title">Contáctanos</h2>
            <p class="contacto-intro">¿Tienes alguna pregunta? Escríbenos y te responderemos a la brevedad.</p>

            <form id="formContacto" class="contacto-form">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <input type="text" name="asunto" placeholder="Asunto" required>
                <textarea name="mensaje" placeholder="Escribe tu mensaje aquí..." rows="5" required></textarea>
                <button type="submit" class="btn-enviar-contacto">Enviar mensaje</button>
            </form>
        </div>
    </section>

    <!-- 🔹 FOOTER -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <img src="img/logo/logo.png" alt="PMI Norte Perú Logo" class="footer-logo">
                <p>PMI Norte Perú Chapter</p>
                <p>Impulsando la excelencia en gestión de proyectos</p>
            </div>

            <div class="footer-section">
                <h3>Enlaces rápidos</h3>
                <ul>
                    <li><a href="#home">Inicio</a></li>
                    <li><a href="#nosotros">Nosotros</a></li>
                    <li><a href="#eventos">Eventos</a></li>
                    <li><a href="#junta">Junta Directiva</a></li>
                    <li><a href="#voluntariado">Voluntariado</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contacto</h3>
                <p><i class="fas fa-envelope"></i> informes@pminorteperu.org</p>
                <div class="footer-social">
                    <a href="https://www.instagram.com/pminorteperu?igsh=MWw1OGU1dWgxcHV2bw=="><i
                            class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/share/1CfCowCGzB/"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.linkedin.com/company/pmi-norte-peru-chapter"><i
                            class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 PMI Norte Perú Chapter. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="js/script.js"></script>
</body>

</html>
