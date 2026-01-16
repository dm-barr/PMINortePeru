<?php
$pagina_actual = basename($_SERVER['PHP_SELF']);
$active_membresia = in_array($pagina_actual, ['beneficios.php', 'tiposMembresia.php', 'preguntas.php']) ? 'active' : '';
$active_certificacion = in_array($pagina_actual, ['certificaciones.php']) ? 'active' : '';
$active_inicio = ($pagina_actual == 'index.php') ? 'active' : '';
?>
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
                    <li><a href="index.php#hero">Inicio</a></li>
                    <li><a href="index.php#nosotros">Nosotros</a></li>
                    <li><a href="index.php#eventos">Eventos</a></li>
                    <li class="dropdown-beneficios">
                        <a href="#cta" class="dropdown-toggle">
                            Membresía <span class="arrow">▼</span></a>
                            <ul class="submenu-membresia">
                            <li><a href="beneficios.php">Beneficios</a></li>
                            <li><a href="tiposMembresia.php">Tipos de Mebresía</a></li>                        
                            <li><a href="preguntas.php">Preguntas</a></li>
                        </ul> 
                    </li>
                    <li class="dropdown-certificacion">
                        <a href="#" class="dropdown-toggle">
                            Certificación <span class="arrow">▼</span></a>
                            <ul class="submenu-certificacion">
                            <li><a href="certificaciones.php">Principales</a></li>
                            <li><a href="certificaciones.php#especializadas">Especializadas</a></li>
                            <li><a href="certificaciones.php#recursos">Recursos</a></li>
                            <li><a href="preguntas.php#faq-certificaciones">Preguntas Frecuentes</a></li>
                        </ul> 
                    </li>
                    <li><a href="index.php#junta-directiva">Junta Directiva</a></li>
                    <li><a href="index.php#voluntariado">Voluntariado</a></li>

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