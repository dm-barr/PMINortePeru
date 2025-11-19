<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PMI Norte Perú</title>
    <!-- Estilos y fuentes -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/beneficios.css">
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

   <div class="header-banner">
        <div class="contenedor">
            <h1>Beneficios</h1> 
        </div>
    </div>

    <div class="contenedor-principal">
        
        <aside class="sidebar-navegacion">
            <h4>Membresía</h4>
            <ul>
                <li><a href="beneficios.php" class="activo">Beneficios</a></li> 
                <li><a href="#">Tipos de Mebresía</a></li>
                <li><a href="#">Manuales</a></li>
                <li><a href="#">Videos</a></li>
                <li><a href="#">Preguntas Frecuentes</a></li>
            </ul>
        </aside>

        <main class="contenido-beneficios">
            
            <h2>Conoce nuestros beneficios!</h2>
            
            <div class="video-container">
                <div class="placeholder-video">
                    [Espacio para Video de YouTube / Iframe]
                </div>
            </div>
            
            <p class="introduccion">Forma parte de la Comunidad de profesionales en Gestión de proyectos más grande a nivel mundial!</p>
            
            <h2 style="margin-top: 40px;">Beneficios Exclusivos</h2>
            <p class="subtitulo-seccion">Accede a una red global y a recursos exclusivos que impulsarán tu carrera.</p>
            
            <div class="contenedor-tarjetas">
                <div class="beneficio-card">
                    <i class="icono-beneficio fas fa-trophy"></i>
                    <div class="beneficio-contenido">
                        <h3>Título del Beneficio</h3>
                        <p>Descripción corta y clara de este beneficio o característica.</p>
                    </div>
                </div>

                <div class="beneficio-card secundario">
                    <i class="icono-beneficio fas fa-book-reader"></i>
                    <div class="beneficio-contenido">
                        <h3>Acceso al PMBOK® Guide y Estándares</h3>
                        <p>Descarga gratuita de la Guía PMBOK (Project Management Body of Knowledge)...</p>
                    </div>
                </div>
                
            </div>
        </main>
    </div>




    
    </body>
</html>