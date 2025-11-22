document.addEventListener("DOMContentLoaded", function () {


    const subEspecializadas = ["#agiles", "#dominio", "#rol", "#industria"];

    const sidebarLinks = document.querySelectorAll(".sidebar-navegacion a");
    const navbarLinks  = document.querySelectorAll(".navbar a");
    const submenuLinks = document.querySelectorAll(".submenu-membresia a, .submenu-certificacion a");

    // Unión total de enlaces
    const allLinks = [...sidebarLinks, ...navbarLinks, ...submenuLinks];

    function limpiarActivos() {
        allLinks.forEach(a => a.classList.remove("activo"));
    }

    function marcarPorHash(hash) {
        if (!hash) return;

        limpiarActivos();

        // Activar enlaces con el mismo hash
        document.querySelectorAll(`a[href="${hash}"]`)
            .forEach(a => a.classList.add("activo"));

        // Si es un sub-hash de Especializadas → marcar padre
        if (subEspecializadas.includes(hash)) {
            const padre = document.querySelector(`.sidebar-navegacion a[href="#especializadas"]`);
            if (padre) padre.classList.add("activo");

            const submenu = document.querySelector(".submenu-sidebar");
            if (submenu) submenu.style.display = "block";
        }
    }

    function marcarPorPagina() {

        const pagina = window.location.pathname.split("/").pop();

        limpiarActivos();

        // Marcar enlaces con nombre exacto de la página
        document.querySelectorAll(`a[href="${pagina}"], a[href="./${pagina}"]`)
            .forEach(a => a.classList.add("activo"));

        // Caso especial → Certificaciones
        if (pagina.includes("certificaciones")) {
            const p = document.querySelector('.sidebar-navegacion a[href="#principales"]');
            if (p) p.classList.add("activo");
        }
    }
    allLinks.forEach(link => {
        link.addEventListener("click", function () {
            const href = this.getAttribute("href");

            // HASHES (#agiles, #rol…)
            if (href.startsWith("#")) {
                marcarPorHash(href);
                return;
            }

            // RUTAS (beneficios.php, manuales.php)
            if (href.endsWith(".php")) {
                limpiarActivos();
                this.classList.add("activo");
            }
        });
    });
    // Si hay hash → prioridad 1
    if (window.location.hash) {
        marcarPorHash(window.location.hash);
    } 
    else {
        marcarPorPagina();
    }
    // Si cambia el hash sin recargar
    window.addEventListener("hashchange", function () {
        marcarPorHash(window.location.hash);
    });

});