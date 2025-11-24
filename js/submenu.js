document.addEventListener("DOMContentLoaded", function () {

    const subEspecializadas = ["#agiles", "#dominio", "#rol", "#industria"];
    const sidebarLinks = document.querySelectorAll(".sidebar-navegacion a");
    const navbarLinks = document.querySelectorAll(".navbar a");
    const submenuLinks = document.querySelectorAll(".submenu-membresia a, .submenu-certificacion a");

    const allLinks = [...sidebarLinks, ...navbarLinks, ...submenuLinks];
    function limpiarActivos() {
        allLinks.forEach(a => a.classList.remove("activo"));
    }

    function marcarPorHash(hash) {
        if (!hash) return;

        limpiarActivos();
        document.querySelectorAll(`a[href="${hash}"]`).forEach(a => a.classList.add("activo"));

        if (subEspecializadas.includes(hash)) {
            const padre = document.querySelector(`.sidebar-navegacion a[href="#especializadas"]`);
            if (padre) padre.classList.add("activo");

            const submenu = document.querySelector(".submenu-sidebar");
            if (submenu) submenu.classList.add("abierto");
        }
    }

    // Marca enlaces activos según página
    function marcarPorPagina() {
        const pagina = window.location.pathname.split("/").pop();
        limpiarActivos();

        document.querySelectorAll(`a[href="${pagina}"], a[href="./${pagina}"]`)
            .forEach(a => a.classList.add("activo"));

        // Caso especial para Certificaciones
        if (pagina.includes("certificaciones")) {
            const p = document.querySelector('.sidebar-navegacion a[href="#principales"]');
            if (p) p.classList.add("activo");
        }
    }

    allLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            const href = this.getAttribute("href");

            if (href.startsWith("#")) {
                if (href === "#especializadas") {
                    e.preventDefault();
                    const submenu = document.querySelector(".submenu-sidebar");
                    if (submenu) submenu.classList.toggle("abierto");
                    this.classList.add("activo");
                    return;
                }

                marcarPorHash(href);
                return;
            }

            if (href.endsWith(".php")) {
                limpiarActivos();
                this.classList.add("activo");
            }
        });
    });

    if (window.location.hash) {
        marcarPorHash(window.location.hash);
    } else {
        marcarPorPagina();
    }

    window.addEventListener("hashchange", function () {
        marcarPorHash(window.location.hash);
    });

});
