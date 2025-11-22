document.addEventListener("DOMContentLoaded", function () {

    const enlaces = document.querySelectorAll(".sidebar-navegacion ul li a");

    enlaces.forEach(enlace => {
        enlace.addEventListener("click", function () {

            // Quitar activo de todos
            enlaces.forEach(e => e.classList.remove("activo"));

            // Activar el clicado
            this.classList.add("activo");
        });
    });

});