<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Función para formatear fecha en español
function formatearFechaEspanol($fecha)
{
    $meses = array(
        "01" => "Enero",
        "02" => "Febrero",
        "03" => "Marzo",
        "04" => "Abril",
        "05" => "Mayo",
        "06" => "Junio",
        "07" => "Julio",
        "08" => "Agosto",
        "09" => "Septiembre",
        "10" => "Octubre",
        "11" => "Noviembre",
        "12" => "Diciembre"
    );

    // Si la fecha viene en formato YYYY-MM-DD (desde MySQL)
    if (preg_match('/^(\d{4})-(\d{2})-(\d{2})/', $fecha, $matches)) {
        $anio = $matches[1];
        $mes = $matches[2];
        $dia = intval($matches[3]); // Convertir a entero para quitar el 0 inicial

        return $dia . " " . $meses[$mes];
    }

    // Si la fecha viene como "30/12" o "30/12/2025"
    if (strpos($fecha, '/') !== false) {
        $partes = explode('/', $fecha);
        $dia = intval($partes[0]);
        $mes = str_pad($partes[1], 2, "0", STR_PAD_LEFT);

        return $dia . " " . $meses[$mes];
    }

    return $fecha; // Si no coincide el formato, devuelve la fecha original
}

// ✅ NUEVA FUNCIÓN: Formatear rango de fechas
function formatearRangoFechas($fecha_inicio, $fecha_fin)
{
    // Si las fechas son iguales o fecha_fin está vacía, mostrar solo fecha_inicio
    if (empty($fecha_fin) || $fecha_inicio === $fecha_fin) {
        return formatearFechaEspanol($fecha_inicio);
    }

    // Si son diferentes, mostrar rango
    return formatearFechaEspanol($fecha_inicio) . " - " . formatearFechaEspanol($fecha_fin);
}

// Incluir el modelo de eventos
require_once __DIR__ . '/php/evento.php';

// Instanciar el modelo
$eventoModel = new EventoModel_mysqli();

// ✅ Obtener SOLO eventos activos desde la base de datos
$eventos = $eventoModel->getAllActivos();

// Ordenar por fecha_inicio (más antiguos primero)
usort($eventos, function ($a, $b) {
    return strtotime($a['fecha_inicio']) - strtotime($b['fecha_inicio']);
});

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
    <!-- Script de reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js?render=6LdvMAgsAAAAADUpao4CRIs4Irv2zsIbT95UN_mg"></script>
</head>

<body>
    <!-- BARRA SUPERIOR -->
    <div class="topbar">
        <div class="topbar-left">
            <a href="https://www.instagram.com/pminorteperu?igsh=MWw1OGU1dWgxcHV2bw==" class="social"><i
                    class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/share/1CfCowCGzB/" class="social"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.linkedin.com/company/pmi-norte-peru-chapter/" class="social"><i
                    class="fab fa-linkedin-in"></i></a>
        </div>
        <div class="topbar-right">
            <span class="email">informes@pminorteperu.org</span>
            <span class="separator">|</span>
            <a href="#contacto" class="contact-link">Contáctanos</a>
            <span class="separator">|</span>
            <a href="admin/login.php" class="contact-link">Login Administración</a>
        </div>
    </div>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="nav-container">
            <img src="img/logo/logo_PMI.png" alt="Logo PMI Norte Perú" class="logo">
            <input type="checkbox" id="menu-toggle" class="menu-toggle">
            <label for="menu-toggle" class="menu-icon"></label>
            <nav id="navmenu">
                <ul class="menu">
                    <li><a href="#hero">Inicio</a></li>
                    <li><a href="#nosotros">Nosotros</a></li>
                    <li><a href="#eventos">Eventos</a></li>
                    <li><a href="#cta">Membresía</a></li>
                    <li><a href="#junta-directiva">Junta Directiva</a></li>
                    <li><a href="#voluntariado">Voluntariado</a></li>
                    <a href="https://www.pmi.org/shop/p-/chapter-membership/norte-per%C3%BA-chapter/101293"
                        class="btn-hazte">Hazte miembro</a>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Principal -->
    <section id="hero" class="hero" aria-label="Sección principal">
        <div class="hero-bg" aria-hidden="true">
            <video class="hero-video" autoplay muted loop playsinline preload="metadata">
                <source src="video/hero2.mp4" type="video/mp4">
            </video>
        </div>
        <div class="hero-overlay"></div>
        <div class="container hero-grid">
            <div class="hero-copy">
                <p class="eyebrow">PMI Norte Perú Chapter</p>
                <h1>¡Maximizando el éxito de los<span class="txt-gradient"> proyectos para elevar nuestro mundo!</span>
                </h1>
                <p class="lead">Transformamos ideas en <strong>valor real</strong> para Cajamarca, Piura y Trujillo
                    mediante dirección de proyectos.</p>
                <div class="hero-actions">
                    <a href="#eventos" class="btn btn--primary">Ver eventos</a>
                    <a href="#nosotros" class="btn btn--secondary">Conocer el capítulo</a>
                </div>
            </div>
            <aside class="hero-card glass reveal">
                <figure>
                    <img src="img/portada/cajamarca_portada.png" alt="Norte del Perú - Trujillo, Piura y Cajamarca"
                        loading="lazy">
                </figure>
                <div class="hero-card-body">
                    <h3>Student Club PMI UNC</h3>
                    <p class="muted">10 - 15 de Noviembre · Semana Formativa</p>
                </div>
                <div class="hero-card-actions">
                    <a href="https://comunidadunc.pminorteperu.org/" class="btn btn--secondary">Descubre más</a>
                    <a href="https://wa.me/51955769734" class="btn btn--primary">Inscribirme</a>
                </div>
            </aside>
        </div>
    </section>

    <!-- QUIÉNES SOMOS -->
    <section id="nosotros" class="quienes-somos">
        <div class="container">
            <h2>Quiénes somos</h2>
            <p class="descripcion">
                PMI Norte Perú Chapter es una comunidad profesional afiliada al Project Management Institute (PMI) que
                impulsa la excelencia en la dirección de proyectos en las regiones de Cajamarca, Trujillo y Piura.
                Promovemos el desarrollo del talento local mediante formación, certificaciones, eventos y espacios de
                colaboración que fortalecen la gestión profesional de proyectos y contribuyen al crecimiento sostenible
                del norte del país.
            </p>
            <div class="cards">
                <div class="card">
                    <img src="img/valores/logo_misión.png" alt="Misión" class="icono-img">
                    <h3>Misión</h3>
                    <p>Fortalecer las competencias en dirección de proyectos de los profesionales del norte del Perú,
                        promoviendo el liderazgo, la ética y la creación de valor a través de la aplicación de
                        estándares y buenas prácticas del PMI.</p>
                </div>
                <div class="card">
                    <img src="img/valores/logo_visión.png" alt="Visión" class="icono-img">
                    <h3>Visión</h3>
                    <p>Ser el capítulo referente del norte del Perú en gestión de proyectos, reconocido por su impacto
                        positivo en la comunidad y por fomentar una cultura de excelencia, innovación y colaboración.
                    </p>
                </div>
                <div class="card">
                    <img src="img/valores/logo_valores.png" alt="Valores" class="icono-img">
                    <h3>Valores</h3>
                    <p><strong>Excelencia:</strong> compromiso con la calidad y la mejora continua.</p>
                    <p><strong>Integridad:</strong> actuar con ética y transparencia.</p>
                    <p><strong>Colaboración:</strong> trabajo conjunto y aprendizaje compartido.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- PRÓXIMOS EVENTOS -->
    <section id="eventos" class="eventos">
        <div class="container-eventos">
            <div class="titulo-eventos">
                <h2>Próximos<br><span>eventos</span></h2>
                <p>En el PMI Norte Perú Chapter promovemos el aprendizaje continuo y la conexión entre profesionales de
                    todo el norte del país. Participa en nuestros eventos, talleres y congresos, donde compartimos
                    experiencias, conocimientos y buenas prácticas en dirección de proyectos que transforman ideas en
                    resultados reales.</p>
            </div>

            <div class="filtros">
                <button class="activo">Todos</button>
                <button>Cajamarca</button>
                <button>Trujillo</button>
                <button>Piura</button>
                <button>Comunidad Estudiantil</button>
                <button>Student Club UNC</button>
            </div>

            <div class="cards-eventos">
                <?php if (!empty($eventos)): ?>
                        <?php foreach ($eventos as $evento): ?>
                        <div class="card-evento" data-ciudad="<?php echo htmlspecialchars($evento['comunidad']); ?>">
                            <!-- ✅ FECHA CON RANGO CONDICIONAL -->
                            <span     class="fecha"><?php echo formatearRangoFechas($evento['fecha_inicio'], $evento['fecha_fin']); ?></span>

                            <?php if (!empty($evento['imagen'])): ?>
                                            <img src="<?php echo htmlspecialchars($evento['imagen']); ?>"
                                alt="
                    <?php echo htmlspecialchars($evento['nombre']); ?>">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/400x250?text=Sin+Imagen" alt="Sin imagen">
                            <?php endif; ?>

                                    <h3><?php echo htmlspecialchars($evento['nombre']); ?></h3>

                            <!-- ✅ DESCRIPCIÓN CORTA DEBAJO DEL TÍTULO -->
                            <?php if (!empty($evento['descripcion_corta'])): ?>
                                <p>
                                    <?php echo htmlspecialchars($evento['descripcion_corta']); ?>
                                </p>
                            <?php endif; ?>

                            <div class="botones-evento">
                                <button class="btn-evento btn-info"
                                    onclick="mostrarInfoEvento(<?php echo $evento['id_Evento']; ?>)">
                                    Ver información
                                    </button>

                                    <?php if (!empty($evento['link'])): ?>
                                            <a href="<?php echo htmlspecialchars($evento['link']); ?>"
                                        class="btn-evento btn-registro">Regístrate</a>
                                    <?php else: ?>
                                        <a href="#" class="btn-evento btn-registro">Regístrate</a>
                                    <?php endif; ?>
                                            </div>
                                            </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No hay eventos disponibles en este momento.</p>
                            <?php endif; ?>
                    </div>
                </div>
    </section>

    <!-- MODAL PARA INFORMACIÓN DEL EVENTO -->
    <div id="modalInfoEvento" class="modal oculto">
        <div class="modal-content">
            <span class="close-modal" onclick="cerrarModalEvento()">&times;</span>
            <div id="contenidoEvento">
                <!-- El contenido se cargará dinámicamente aquí -->
            </div>
        </div>
    </div>

    <!-- LLAMADO A LA ACCIÓN -->
    <section id="cta" class="cta">
        <div class="cta-fondo"></div>
        <div class="cta-content">
            <h2>¿Listo para el siguiente proyecto?</h2>
            <p>Únete al PMI Norte Perú Chapter y forma parte de una comunidad que impulsa el crecimiento profesional, la
                innovación y el liderazgo en la gestión de proyectos. Juntos, hacemos que las ideas se conviertan en
                resultados que transforman nuestra región.</p>
            <div class="cta-buttons">
                <a href="https://www.pmi.org/shop/p-/chapter-membership/norte-per%C3%BA-chapter/101293"
                    class="btn-cta btn-primary">Hazte miembro</a>
                <a href="#contacto" class="btn-cta btn-secondary">Habla con nosotros</a>
            </div>
        </div>
    </section>

    <!-- JUNTA DIRECTIVA -->
    <section id="junta-directiva" class="seccion-junta">
        <div class="container container-noticias">
            <div class="titulo-noticias">
                <h2>Junta<br><span>Directiva</span></h2>
                <p>La Junta Directiva del PMI Norte Perú Chapter está conformada por profesionales comprometidos con
                    promover la excelencia en la gestión de proyectos y fortalecer la presencia del PMI en la región
                    norte del país. Cada miembro aporta su experiencia, liderazgo y visión estratégica para impulsar
                    iniciativas clave para el desarrollo dentro de nuestra comunidad.</p>
            </div>
        </div>
        <div class="carousel-wrapper">
            <button class="carousel-btn prev-btn" aria-label="Anterior"><i class="fas fa-chevron-left"></i></button>
            <div class="carousel-container">
                <div class="carousel-track">
                    <!-- Miembro 1 -->
                    <div class="card-miembro">
                        <div class="foto-miembro">
                            <img src="img/junta/OscarZocon.png" alt="Presidente">
                        </div>
                        <span class="cargo-badge">Presidente</span>
                        <h3>Oscar Zocón</h3>
                        <div class="redes-miembro">
                            <a href="https://www.linkedin.com/in/oscarzocon/" aria-label="LinkedIn"><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <!-- Miembro 2 -->
                    <div class="card-miembro">
                        <div class="foto-miembro">
                            <img src="img/junta/CarlosBriceno.png" alt="Presidente Electo">
                        </div>
                        <span class="cargo-badge">Presidente Electo</span>
                        <h3>Carlos Briceño</h3>
                        <div class="redes-miembro">
                            <a href="https://www.linkedin.com/in/carlos-daniel-briceno-burgos/" aria-label="LinkedIn"><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <!-- Miembro 3 -->
                    <div class="card-miembro">
                        <div class="foto-miembro">
                            <img src="img/junta/HeynerNinaquispe.jpg" alt="Past President">
                        </div>
                        <span class="cargo-badge">Past President</span>
                        <h3>Heyner Ninaquispe</h3>
                        <div class="redes-miembro">
                            <a href="https://www.linkedin.com/in/heynerninaquispe/" aria-label="LinkedIn"><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <!-- Miembro 4 -->
                    <div class="card-miembro">
                        <div class="foto-miembro">
                            <img src="img/junta/TaniaAngeles.jpg" alt="Vicepresidente de Membresía">
                        </div>
                        <span class="cargo-badge">Vicepresidente de Membresía y Voluntariado</span>
                        <h3>Tania Ángeles</h3>
                        <div class="redes-miembro">
                            <a href="https://www.linkedin.com/in/taniaangelesmoncada/" aria-label="LinkedIn"><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <!-- Miembro 5 -->
                    <div class="card-miembro">
                        <div class="foto-miembro">
                            <img src="img/junta/DeniseLeon.png" alt="Vicepresidente de Eventos">
                        </div>
                        <span class="cargo-badge">Vicepresidente de Eventos</span>
                        <h3>Denise León</h3>
                        <div class="redes-miembro">
                            <a href="https://www.linkedin.com/in/denise-le%C3%B3n/" aria-label="LinkedIn"><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <!-- Miembro 6 -->
                    <div class="card-miembro">
                        <div class="foto-miembro">
                            <img src="img/junta/GabrielaGonzales.png" alt="Vicepresidente de Comunicaciones">
                        </div>
                        <span class="cargo-badge">Vicepresidente de Comunicaciones</span>
                        <h3>Gabriela Gonzales</h3>
                        <div class="redes-miembro">
                            <a href="https://www.linkedin.com/in/ggonzales-mkt/" aria-label="LinkedIn"><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <!-- Miembro 7 -->
                    <div class="card-miembro">
                        <div class="foto-miembro">
                            <img src="img/junta/CeciliaRojas.png" alt="Vicepresidente de Educación">
                        </div>
                        <span class="cargo-badge">Vicepresidente de Educación</span>
                        <h3>Cecilia Rojas</h3>
                        <div class="redes-miembro">
                            <a href="https://www.linkedin.com/in/zoila-cecilia-rojas-ramirez-43921a13a/"
                                aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <!-- Miembro 8 -->
                    <div class="card-miembro">
                        <div class="foto-miembro">
                            <img src="img/junta/GiselaCieza.jpg" alt="Vicepresidente de Finanzas">
                        </div>
                        <span class="cargo-badge">Vicepresidente de Finanzas</span>
                        <h3>Gisela Cieza</h3>
                        <div class="redes-miembro">
                            <a href="https://www.linkedin.com/in/giselacieza/" aria-label="LinkedIn"><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <!-- Miembro 9 -->
                    <div class="card-miembro">
                        <div class="foto-miembro">
                            <img src="img/junta/JeremyBecerra.png" alt="Líder Comunidad Trujillo">
                        </div>
                        <span class="cargo-badge">Líder Comunidad Trujillo</span>
                        <h3>Jeremy Becerra</h3>
                        <div class="redes-miembro">
                            <a href="https://www.linkedin.com/in/jeremybecerraleon/" aria-label="LinkedIn"><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <!-- Miembro 10 -->
                    <div class="card-miembro">
                        <div class="foto-miembro">
                            <img src="img/junta/JoseLuisSoriano.png" alt="Líder Comunidad Cajamarca">
                        </div>
                        <span class="cargo-badge">Líder Comunidad Cajamarca</span>
                        <h3>José Luis Soriano</h3>
                        <div class="redes-miembro">
                            <a href="https://www.linkedin.com/in/soriano-cacho-jos%C3%A9-luis/" aria-label="LinkedIn"><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <!-- Miembro 11 -->
                    <div class="card-miembro">
                        <div class="foto-miembro">
                            <img src="img/junta/LizethRodriguez.png" alt="Líder Comunidad Piura">
                        </div>
                        <span class="cargo-badge">Líder Comunidad Piura</span>
                        <h3>Lizeth Rodríguez</h3>
                        <div class="redes-miembro">
                            <a href="https://www.linkedin.com/in/lizeth-roxana-rodr%C3%ADguez-neyra-0730ba161/"
                                aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-btn next-btn" aria-label="Siguiente"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="carousel-dots"></div>
    </section>

    <!-- VOLUNTARIADO -->
    <section id="voluntariado" class="voluntariado">
        <div class="cta-fondo"></div>
        <div class="voluntariado-content">
            <h2>Sé voluntario y deja huella!</h2>
            <p>Forma parte activa del PMI Norte Perú Chapter como voluntario y contribuye al desarrollo de la comunidad
                profesional de gestión de proyectos. Participar como voluntario te permite aprender, liderar y conectar
                con otros profesionales, fortaleciendo tus habilidades mientras generas un impacto positivo en tu
                región.</p>
            <div class="voluntariado-buttons">
                <a href="#registro" class="btn-vol btn-azul" id="btnInscribirse">Sé voluntario</a>
                <a href="#contacto" class="btn-vol btn-blanco">Habla con nosotros</a>
            </div>
        </div>
    </section>

    <!-- FORMULARIO DE VOLUNTARIADO PARA EVENTOS -->
    <div id="formModal" class="modal oculto">
        <div class="modal-content">
            <h3>Formulario de Voluntariado</h3>
            <form id="voluntarioFormReclutamiento">
                <label for="nombre">Nombre completo</label>
                <input type="text" id="nombre" name="name" required>

                <label for="correo">Correo electrónico</label>
                <input type="email" id="correo" name="email" required>

                <label for="interes">Área de interés</label>
                <select id="interes" name="topic" required>
                    <option value="">Selecciona una opción</option>
                    <option value="membresia">Membresía</option>
                    <option value="eventos">Eventos</option>
                    <option value="comunicaciones">Comunicaciones</option>
                    <option value="educacion">Educación</option>
                    <option value="finanzas">Finanzas</option>
                    <option value="ti">Tecnologías de la Información</option>
                </select>

                <label for="mensaje">¿Por qué te gustaría participar?</label>
                <textarea id="mensaje" name="message" rows="4" required></textarea>

                <div class="check-group">
                    <label class="lbl-tc">
                        <input type="checkbox" required aria-required="true" name="privacidad">
                        Acepto la política de privacidad
                    </label>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-vol btn-azul">Enviar</button>
                    <button type="button" class="btn-vol btn-blanco" id="btnCerrarForm">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- CONTÁCTANOS -->
    <section id="contacto" class="contacto">
        <h2 class="titulo-contacto">Contáctanos</h2>
        <div class="container-contacto">
            <div class="columna-formulario">
                <form class="form-contacto" id="contactForm" novalidate>
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="name" required aria-required="true" autocomplete="name">

                    <label for="correo">Correo</label>
                    <input type="email" id="correo" name="email" required aria-required="true" autocomplete="email">

                    <label for="interes">Interés</label>
                    <select id="interes" name="topic" required aria-required="true">
                        <option value="" disabled selected>Selecciona</option>
                        <option value="membresia">Membresía</option>
                        <option value="certificacion">Certificación</option>
                        <option value="alianzas">Alianzas</option>
                        <option value="voluntariado">Voluntariado</option>
                    </select>

                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="message" rows="4" required></textarea>

                    <div class="check-group">
                        <label class="lbl-tc">
                            <input type="checkbox" required aria-required="true" name="privacidad">
                            Acepto la política de privacidad
                        </label>
                    </div>

                    <button type="submit" class="btn-enviar">Enviar</button>
                    <p class="hint" role="status" aria-live="polite" hidden>Gracias. Te contactaremos pronto.</p>
                </form>
            </div>
            <div class="columna-imagen">
                <img src="img/recursos/form.jpg" alt="Equipo PMI Norte Perú">
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <p>© 2025 PMI Norte Perú</p>
    </footer>

    <script>
        // Datos de eventos en formato JSON para JavaScript
        const eventosData = <?php echo json_encode($eventos); ?>;

        // ✅ FUNCIÓN ACTUALIZADA: Formatear rango de fechas en JavaScript
        function formatearRangoFechasJS(fecha_inicio, fecha_fin) {
            // Si las fechas son iguales o fecha_fin está vacía, mostrar solo fecha_inicio
            if (!fecha_fin || fecha_inicio === fecha_fin) {
                return formatearFechaJS(fecha_inicio);
            }

            // Si son diferentes, mostrar rango
            return formatearFechaJS(fecha_inicio) + " - " + formatearFechaJS(fecha_fin);
        }

        // Función para mostrar información del evento
        function mostrarInfoEvento(idEvento) {
            // Buscar el evento por ID
            const evento = eventosData.find(e => e.id_Evento == idEvento);

            if (!evento) {
                alert('Evento no encontrado');
                return;
            }

            // ✅ CONTENIDO DEL MODAL ACTUALIZADO: descripcion_corta eliminada, descripcion completa incluida
            const contenido = `
        <h2>${evento.nombre}</h2>
        <div class="info-evento-detalle">
            ${evento.imagen ? `<img src="${evento.imagen}" alt="${evento.nombre}" style="width: 100%; max-width: 500px; border-radius: 8px; margin-bottom: 20px;">` : ''}
            
            <div class="detalle-item">
                <strong>📅 Fecha:</strong> ${formatearRangoFechasJS(evento.fecha_inicio, evento.fecha_fin)}
            </div>
            
            <div class="detalle-item">
                <strong>📍 Lugar:</strong> ${evento.lugar || 'Por confirmar'}
            </div>
            
            <div class="detalle-item">
                <strong>🌐 Modalidad:</strong> ${evento.modalidad || 'Por confirmar'}
            </div>
            
            <div class="detalle-item">
                <strong>📂 Categoría:</strong> ${evento.categoria || 'General'}
            </div>
            
            <div class="detalle-item">
                <strong>🏢 Comunidad:</strong> ${evento.comunidad || 'PMI Norte Perú'}
            </div>
            
            <div class="detalle-item descripcion-completa">
                <strong>📋 Descripción:</strong>
                <p>${evento.descripcion}</p>
            </div>
            
            ${evento.link ? `
                <div style="margin-top: 20px; text-align: center;">
                    <a href="${evento.link}" class="btn-evento btn-registro" style="display: inline-block; padding: 12px 30px;">
                        Regístrate ahora
                    </a>
                </div>
            ` : ''}
        </div>
    `;

            // Insertar contenido en el modal
            document.getElementById('contenidoEvento').innerHTML = contenido;

            // Mostrar el modal
            document.getElementById('modalInfoEvento').classList.remove('oculto');
        }

        // Función para cerrar el modal
        function cerrarModalEvento() {
            document.getElementById('modalInfoEvento').classList.add('oculto');
        }

        // Función auxiliar para formatear fecha en JavaScript
        function formatearFechaJS(fecha) {
            const meses = {
                '01': 'Enero', '02': 'Febrero', '03': 'Marzo', '04': 'Abril',
                '05': 'Mayo', '06': 'Junio', '07': 'Julio', '08': 'Agosto',
                '09': 'Septiembre', '10': 'Octubre', '11': 'Noviembre', '12': 'Diciembre'
            };

            const partes = fecha.split('-');
            if (partes.length === 3) {
                return `${parseInt(partes[2])} ${meses[partes[1]]}`;
            }
            return fecha;
        }

        // Cerrar modal al hacer clic fuera de él
        document.addEventListener('click', function (event) {
            const modal = document.getElementById('modalInfoEvento');
            if (event.target === modal) {
                cerrarModalEvento();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuToggle = document.querySelector('.menu-toggle');
            const menuLinks = document.querySelectorAll('.menu a');

            menuLinks.forEach(link => {
                link.addEventListener('click', () => {
                    menuToggle.checked = false;
                });
            });
        });
    </script>
    <script src="js/script.js?v=<?php echo time(); ?>"></script>
</body>

</html>