<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manuales y Guías</title>

   
    <link rel="stylesheet" href="../css/styles.css" />

    <link rel="stylesheet" href="../css/manuales.css" />
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
                    <li class="dropdown-beneficios">
                        <a href="#cta" class="dropdown-toggle">
                            Membresía <span class="arrow">▼</span></a>
                             <ul class="submenu-membresia">
                            <li><a href="beneficios.php">Beneficios</a></li>
                            <li><a href="#">Tipos de Mebresía</a></li>
                            <li><a href="manuales.php">Manuales</a></li>
                            <li><a href="#">Videos</a></li>
                        </ul> 
                    </li>
                    <li class="dropdown-certificacion">
                        <a href="#" class="dropdown-toggle">
                            Certificación <span class="arrow">▼</span></a>
                             <ul class="submenu-certificacion">
                            <li><a href="certificaciones.php">Principales</a></li>
                            <li><a href="#">Especializadas</a></li>
                            <li><a href="#">Recursos</a></li>
                        </ul> 
                    </li>
                    <li><a href="#junta-directiva">Junta Directiva</a></li>
                    <li><a href="#voluntariado">Voluntariado</a></li>

                    <!-- Dropdown de Comunidades -->
                    <li class="dropdown-comunidades">
                        <a href="#comunidades" class="dropdown-toggle">
                            Comunidades <span class="arrow">▼</span>
                        </a>
                        <ul class="submenu-comunidades">
                            <li><a href="#cajamarca">Cajamarca</a></li>
                            <li><a href="#trujillo">Trujillo</a></li>
                            <li><a href="#piura">Piura</a></li>
                            <li><a href="#estudiantil">Estudiantil</a></li>
                            <li><a href="https://comunidadunc.pminorteperu.org/">Student Club UNC</a></li>
                        </ul>
                    </li>

                    <a href="https://www.pmi.org/shop/p-/chapter-membership/norte-per%C3%BA-chapter/101293"
                        class="btn-hazte">Hazte miembro</a>
                </ul>
            </nav>
        </div>
    </header>






    <main class="manuales-container">
        
        <div class="header-manuales">
            <h1>Manuales y Guías</h1>
            <p>Recursos esenciales para miembros profesionales y estudiantes que inician su camino en PMI.</p>
        </div>

        <section class="manual-item">
            
            <div class="manual-texto">
                <h2>Guía para Miembro Profesional</h2>
                <p>
                    Este manual detalla todos los beneficios, responsabilidades y oportunidades disponibles para nuestros miembros profesionales. Descubre cómo maximizar tu membresía, conectar con otros expertos y acceder a recursos exclusivos para impulsar tu carrera.
                </p>
                <a href="../pdfs/manual_profesional.pdf" target="_blank" class="btn-manual">
                    Ver Guía Profesional (PDF)
                </a>
            </div>

            <div class="manual-imagen">
                <a href="../pdfs/manual_profesional.pdf" target="_blank" title="Ver PDF">
                    <img src="../img/certificaciones/capm.png" alt="Portada del Manual Profesional">
                </a>
            </div>

        </section>

        <section class="manual-item">
            
            <div class="manual-texto">
                <h2>Guía para Miembro Estudiante</h2>
                <p>
                    Tu carrera en Gestión de Proyectos comienza aquí. Esta guía está diseñada para estudiantes y te muestra cómo aprovechar al máximo tu membresía, obtener descuentos en certificaciones (como la CAPM®) y participar en eventos de networking.
                </p>
                <a href="../pdfs/manual_estudiante.pdf" target="_blank" class="btn-manual">
                    Ver Guía Estudiante (PDF)
                </a>
            </div>

            <div class="manual-imagen">
                <a href="../pdfs/manual_estudiante.pdf" target="_blank" title="Ver PDF">
                    <img src="../img/certificaciones/acp.png" alt="Portada del Manual Estudiante">
                </a>
            </div>

        </section>

    </main>

</body>

</html>