document.addEventListener("DOMContentLoaded", function () {
  // ===============================================
  // MANEJO DE VISTAS (TABS)
  // ===============================================

  const navLinks = document.querySelectorAll(".sidebar-nav .nav-link");
  const views = document.querySelectorAll(".main-content .view");

  function switchView(targetId) {
    views.forEach((view) => view.classList.remove("active"));
    navLinks.forEach((link) => link.classList.remove("active"));

    const targetView = document.getElementById(targetId);
    if (targetView) targetView.classList.add("active");

    const activeLink = document.querySelector(
      `.nav-link[data-target="${targetId}"]`
    );
    if (activeLink) activeLink.classList.add("active");
  }

  navLinks.forEach((link) => {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      const targetId = this.getAttribute("data-target");
      switchView(targetId);
    });
  });

  // ===============================================
  // MANEJO DE MODALES
  // ===============================================

  const modalOverlays = document.querySelectorAll(".modal-overlay");

  const btnAbrirEvento = document.getElementById("btn-abrir-evento");
  const btnAbrirEducacion = document.getElementById("btn-abrir-educacion");
  const btnAbrirNoticia = document.getElementById("btn-abrir-noticia");

  const modalEvento = document.getElementById("modal-evento");
  const modalEducacion = document.getElementById("modal-educacion");
  const modalNoticia = document.getElementById("modal-noticia");

  const closeButtons = document.querySelectorAll(".close-modal");

  function openModal(modal) {
    if (modal) modal.classList.add("active");
  }

  function closeModal(modal) {
    if (modal) modal.classList.remove("active");
  }

  // Abrir modales en modo AGREGAR
  if (btnAbrirEvento) {
    btnAbrirEvento.addEventListener("click", () => {
      document.getElementById("titulo-modal-evento").textContent =
        "Agregar Evento";
      document.getElementById("accion-evento").value = "agregar_evento";
      document.getElementById("evento-id").value = "";
      document.querySelector(".form-evento").reset();
      document.getElementById("evento-estado").value = "1";
      const preview = document.getElementById("preview-evento");
      if (preview) preview.style.display = "none";
      openModal(modalEvento);
    });
  }

  if (btnAbrirEducacion) {
    btnAbrirEducacion.addEventListener("click", () => {
      document.getElementById("titulo-modal-educacion").textContent =
        "Agregar Curso";
      document.getElementById("accion-educacion").value = "agregar_educacion";
      document.getElementById("educacion-id").value = "";
      document.querySelector(".form-educacion").reset();
      const preview = document.getElementById("preview-educacion");
      if (preview) preview.style.display = "none";
      openModal(modalEducacion);
    });
  }

  if (btnAbrirNoticia) {
    btnAbrirNoticia.addEventListener("click", () => {
      document.getElementById("titulo-modal-noticia").textContent =
        "Agregar Noticia";
      document.getElementById("accion-noticia").value = "agregar_noticia";
      document.getElementById("noticia-id").value = "";
      document.querySelector(".form-noticia").reset();
      const preview = document.getElementById("preview-noticia");
      if (preview) preview.style.display = "none";
      openModal(modalNoticia);
    });
  }

  // Cerrar modales
  closeButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const modal = button.closest(".modal-overlay");
      closeModal(modal);
    });
  });

  modalOverlays.forEach((overlay) => {
    overlay.addEventListener("click", (event) => {
      if (event.target === overlay) {
        closeModal(overlay);
      }
    });
  });

  // ===============================================
  // VISTA PREVIA DE IMÁGENES
  // ===============================================
  // VISTA PREVIA DE IMÁGENES - MEJORADA
  function setupImagePreview(inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);

    if (!input || !preview) return;

    input.addEventListener("change", function (e) {
      const file = e.target.files[0];

      if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();

        reader.onload = function (event) {
          const img = preview.querySelector("img");
          if (img) {
            img.src = event.target.result;
            preview.style.display = "block";
          }
        };

        reader.readAsDataURL(file);
      } else if (!file) {
        // Si no hay archivo, mantener la imagen actual si existe
        // No ocultar el preview
      } else {
        preview.style.display = "none";
      }
    });
  }

  setupImagePreview("evento-imagen", "preview-evento");
  setupImagePreview("curso-imagen", "preview-educacion");
  setupImagePreview("noticia-imagen", "preview-noticia");

  // ===============================================
  // ✅ TOGGLE ESTADO DE EVENTO
  // ===============================================

  document.addEventListener("click", function (e) {
    if (e.target.closest(".btn-toggle-estado")) {
      e.preventDefault();
      const btn = e.target.closest(".btn-toggle-estado");
      const id = btn.dataset.id;
      const estadoActual = btn.dataset.estado;

      // Confirmación antes de cambiar
      const nuevoEstado = estadoActual === "1" ? "inactivo" : "activo";
      const mensaje = `¿Cambiar estado del evento a "${nuevoEstado}"?`;

      if (confirm(mensaje)) {
        // Crear formulario para enviar
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "";

        const inputAccion = document.createElement("input");
        inputAccion.type = "hidden";
        inputAccion.name = "accion";
        inputAccion.value = "toggle_estado_evento";

        const inputId = document.createElement("input");
        inputId.type = "hidden";
        inputId.name = "id";
        inputId.value = id;

        form.appendChild(inputAccion);
        form.appendChild(inputId);
        document.body.appendChild(form);
        form.submit();
      }
    }
  });

  // ===============================================
  // EDITAR - DELEGACIÓN DE EVENTOS
  // ===============================================

  // EDITAR EVENTO - CON VISTA PREVIA DE IMAGEN
  document.addEventListener("click", function (e) {
    if (e.target.closest(".btn-editar-evento")) {
      e.preventDefault();
      const btn = e.target.closest(".btn-editar-evento");

      // Cambiar título del modal
      document.getElementById("titulo-modal-evento").textContent =
        "Editar Evento";
      document.getElementById("accion-evento").value = "editarevento";

      // Llenar campos del formulario
      document.getElementById("evento-id").value = btn.dataset.id;
      document.getElementById("evento-nombre").value = btn.dataset.nombre;
      document.getElementById("evento-descripcion").value =
        btn.dataset.descripcion;
      document.getElementById("evento-descripcion-corta").value =
        btn.dataset.descripcioncorta || "";
      document.getElementById("evento-comunidad").value = btn.dataset.comunidad;
      document.getElementById("evento-modalidad").value = btn.dataset.modalidad;
      document.getElementById("evento-categoria").value = btn.dataset.categoria;
      document.getElementById("evento-fecha-inicio").value =
        btn.dataset.fechainicio;
      document.getElementById("evento-fecha-fin").value = btn.dataset.fechafin;
      document.getElementById("evento-lugar").value = btn.dataset.lugar;
      document.getElementById("evento-link").value = btn.dataset.link || "";
      document.getElementById("evento-estado").value =
        btn.dataset.estado || "1";

      // MOSTRAR VISTA PREVIA DE LA IMAGEN EXISTENTE
      const preview = document.getElementById("preview-evento");
      const imagenActual = btn.dataset.imagen;

      if (preview && imagenActual && imagenActual !== "-") {
        const img = preview.querySelector("img");
        if (img) {
          // Construir la ruta correcta (asumiendo que las imágenes están en /uploads/)
          img.src = "../" + imagenActual;
          preview.style.display = "block";
        }
      } else if (preview) {
        preview.style.display = "none";
      }

      openModal(modalEvento);
    }
  });

  // EDITAR EDUCACIÓN
  document.addEventListener("click", function (e) {
    if (e.target.closest(".btn-editar-educacion")) {
      e.preventDefault();
      const btn = e.target.closest(".btn-editar-educacion");

      document.getElementById("titulo-modal-educacion").textContent =
        "Editar Curso";
      document.getElementById("accion-educacion").value = "editar_educacion";
      document.getElementById("educacion-id").value = btn.dataset.id;
      document.getElementById("curso-nombre").value = btn.dataset.curso;
      document.getElementById("curso-modalidad").value = btn.dataset.modalidad;
      document.getElementById("curso-fecha").value = btn.dataset.fecha;
      document.getElementById("curso-instructor").value =
        btn.dataset.instructor;
      document.getElementById("curso-descripcion").value =
        btn.dataset.descripcion;

      const preview = document.getElementById("preview-educacion");
      if (preview) preview.style.display = "none";

      openModal(modalEducacion);
    }
  });

  // EDITAR NOTICIA
  document.addEventListener("click", function (e) {
    if (e.target.closest(".btn-editar-noticia")) {
      e.preventDefault();
      const btn = e.target.closest(".btn-editar-noticia");

      document.getElementById("titulo-modal-noticia").textContent =
        "Editar Noticia";
      document.getElementById("accion-noticia").value = "editar_noticia";
      document.getElementById("noticia-id").value = btn.dataset.id;
      document.getElementById("noticia-titulo").value = btn.dataset.titulo;
      document.getElementById("noticia-descripcion").value =
        btn.dataset.descripcion;

      const preview = document.getElementById("preview-noticia");
      if (preview) preview.style.display = "none";

      openModal(modalNoticia);
    }
  });

  // ===============================================
  // ELIMINAR
  // ===============================================

  document.addEventListener("click", function (e) {
    if (e.target.closest(".btn-eliminar")) {
      e.preventDefault();
      const btn = e.target.closest(".btn-eliminar");

      const tipo = btn.dataset.tipo;
      const id = btn.dataset.id;
      const tipoTexto =
        tipo === "evento"
          ? "evento"
          : tipo === "educacion"
          ? "curso"
          : "noticia";

      if (confirm(`¿Estás seguro de eliminar este ${tipoTexto}?`)) {
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "";

        const inputAccion = document.createElement("input");
        inputAccion.type = "hidden";
        inputAccion.name = "accion";
        inputAccion.value = `eliminar_${tipo}`;

        const inputId = document.createElement("input");
        inputId.type = "hidden";
        inputId.name = "id";
        inputId.value = id;

        form.appendChild(inputAccion);
        form.appendChild(inputId);
        document.body.appendChild(form);
        form.submit();
      }
    }
  });

  // ===============================================
  // BUSCADORES EN TABLAS
  // ===============================================

  function setupTableSearch(searchInputId, tableBodyId) {
    const searchInput = document.getElementById(searchInputId);
    const tableBody = document.getElementById(tableBodyId);

    if (!searchInput || !tableBody) return;

    searchInput.addEventListener("keyup", function () {
      const filter = this.value.toLowerCase().trim();
      const rows = tableBody.getElementsByTagName("tr");

      for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < cells.length - 1; j++) {
          const cellText = cells[j].textContent || cells[j].innerText;

          if (cellText.toLowerCase().indexOf(filter) > -1) {
            found = true;
            break;
          }
        }

        row.style.display = found ? "" : "none";
      }
    });
  }

  setupTableSearch("search-eventos", "eventos-tbody");
  setupTableSearch("search-educacion", "educacion-tbody");
  setupTableSearch("search-noticias", "noticias-tbody");

  // ===============================================
  // AUTO-OCULTAR MENSAJES
  // ===============================================

  const alertas = document.querySelectorAll(".alert");
  alertas.forEach((alerta) => {
    setTimeout(() => {
      alerta.style.transition = "opacity 0.5s";
      alerta.style.opacity = "0";
      setTimeout(() => alerta.remove(), 500);
    }, 3000);
  });

  // ===============================================
  // SISTEMA DE NOTIFICACIONES MEJORADO
  // ===============================================

  function showToast(message, type = "success") {
    const toast = document.createElement("div");
    toast.className = `toast-notification toast-${type}`;

    const icon = type === "success" ? "✓" : type === "error" ? "✕" : "⚠";

    toast.innerHTML = `
        <span class="toast-icon">${icon}</span>
        <span>${message}</span>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
      toast.style.animation = "slideInRight 0.4s ease reverse";
      setTimeout(() => toast.remove(), 400);
    }, 3000);
  }

  function showConfirmModal(title, message, onConfirm, type = "warning") {
    const overlay = document.createElement("div");
    overlay.className = "confirm-modal-overlay active";

    const iconMap = {
      warning: "⚠️",
      danger: "🗑️",
      success: "✓",
    };

    overlay.innerHTML = `
        <div class="confirm-modal-box">
            <div class="confirm-modal-icon ${type}">${
      iconMap[type] || "⚠️"
    }</div>
            <h3 class="confirm-modal-title">${title}</h3>
            <p class="confirm-modal-message">${message}</p>
            <div class="confirm-modal-actions">
                <button class="btn-confirm btn-confirm-secondary" onclick="this.closest('.confirm-modal-overlay').remove()">
                    Cancelar
                </button>
                <button class="btn-confirm btn-confirm-primary" id="btn-confirm-action">
                    Confirmar
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(overlay);

    document
      .getElementById("btn-confirm-action")
      .addEventListener("click", () => {
        overlay.remove();
        onConfirm();
      });

    overlay.addEventListener("click", (e) => {
      if (e.target === overlay) {
        overlay.remove();
      }
    });
  }

  // ===============================================
  // ACTUALIZAR ELIMINACIÓN CON MODAL
  // ===============================================

  document.addEventListener("click", function (e) {
    if (e.target.closest(".btn-eliminar")) {
      e.preventDefault();
      const btn = e.target.closest(".btn-eliminar");
      const tipo = btn.dataset.tipo;
      const id = btn.dataset.id;

      const tipoTexto =
        tipo === "evento"
          ? "evento"
          : tipo === "educacion"
          ? "curso"
          : "noticia";

      showConfirmModal(
        `Eliminar ${tipoTexto}`,
        `¿Estás seguro de que deseas eliminar este ${tipoTexto}? Esta acción no se puede deshacer.`,
        () => {
          const form = document.createElement("form");
          form.method = "POST";
          form.action = "";

          const inputAccion = document.createElement("input");
          inputAccion.type = "hidden";
          inputAccion.name = "accion";
          inputAccion.value = `eliminar_${tipo}`;

          const inputId = document.createElement("input");
          inputId.type = "hidden";
          inputId.name = "id";
          inputId.value = id;

          form.appendChild(inputAccion);
          form.appendChild(inputId);
          document.body.appendChild(form);
          form.submit();
        },
        "danger"
      );
    }
  });

  // ===============================================
  // ACTUALIZAR TOGGLE ESTADO CON MODAL
  // ===============================================

  document.addEventListener("click", function (e) {
    if (e.target.closest(".btn-toggle-estado")) {
      e.preventDefault();
      const btn = e.target.closest(".btn-toggle-estado");
      const id = btn.dataset.id;
      const estadoActual = btn.dataset.estado;

      const nuevoEstado = estadoActual === "1" ? "inactivo" : "activo";

      showConfirmModal(
        "Cambiar estado",
        `¿Cambiar el estado del evento a "${nuevoEstado}"?`,
        () => {
          const form = document.createElement("form");
          form.method = "POST";
          form.action = "";

          const inputAccion = document.createElement("input");
          inputAccion.type = "hidden";
          inputAccion.name = "accion";
          inputAccion.value = "toggle_estado_evento";

          const inputId = document.createElement("input");
          inputId.type = "hidden";
          inputId.name = "id";
          inputId.value = id;

          form.appendChild(inputAccion);
          form.appendChild(inputId);
          document.body.appendChild(form);
          form.submit();
        },
        "warning"
      );
    }
  });
});
