/* ========================================
   CUENTA REGRESIVA HERO
======================================== */

const countdownBlocks = document.querySelectorAll(".counter[data-countdown]");

countdownBlocks.forEach((block) => {
  const t = new Date(block.dataset.countdown).getTime();
  const el = {
    d: block.querySelector('[data-unit="days"]'),
    h: block.querySelector('[data-unit="hours"]'),
    m: block.querySelector('[data-unit="minutes"]'),
    s: block.querySelector('[data-unit="seconds"]'),
  };

  const tick = () => {
    const now = Date.now();
    let diff = Math.max(0, Math.floor((t - now) / 1000));
    const d = Math.floor(diff / 86400);
    diff -= d * 86400;
    const h = Math.floor(diff / 3600);
    diff -= h * 3600;
    const m = Math.floor(diff / 60);
    diff -= m * 60;
    const s = diff;

    if (el.d) el.d.textContent = String(d).padStart(2, "0");
    if (el.h) el.h.textContent = String(h).padStart(2, "0");
    if (el.m) el.m.textContent = String(m).padStart(2, "0");
    if (el.s) el.s.textContent = String(s).padStart(2, "0");
  };

  tick();
  const id = setInterval(() => {
    tick();
    if (Date.now() >= t) clearInterval(id);
  }, 1000);
});

/* ========================================
   REVEAL AL ENTRAR EN VIEWPORT
======================================== */

const reveals = document.querySelectorAll(".reveal");
const prefersReduced = window.matchMedia(
  "(prefers-reduced-motion: reduce)"
).matches;

if (prefersReduced) {
  reveals.forEach((el) => el.classList.add("is-visible"));
} else {
  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) {
          e.target.classList.add("is-visible");
          io.unobserve(e.target);
        }
      });
    },
    { threshold: 0.35 }
  );
  reveals.forEach((el) => io.observe(el));
}

// ============================================
// CONFIGURACIÓN RECAPTCHA V3
// ============================================
const RECAPTCHA_SITE_KEY_V3 = "6LdvMAgsAAAAADUpao4CRIs4Irv2zsIbT95UN_mg";

// FORMULARIO DE VOLUNTARIADO
const formVoluntariado = document.getElementById("voluntarioFormReclutamiento");
if (formVoluntariado) {
  console.log("Formulario de voluntariado encontrado");
  formVoluntariado.addEventListener("submit", async (e) => {
    e.preventDefault();

    // Validar campos requeridos
    if (!formVoluntariado.checkValidity()) {
      formVoluntariado.reportValidity(); // Muestra mensajes de error nativos
      return;
    }

    console.log("Ejecutando reCAPTCHA v3...");

    try {
      const token = await grecaptcha.execute(RECAPTCHA_SITE_KEY_V3, {
        action: "submit_voluntariado",
      });
      console.log("Token reCAPTCHA recibido:", token);

      const formData = new FormData(formVoluntariado);
      formData.append("formType", "voluntariado");
      formData.append("g-recaptcha-response", token);

      const scriptURL =
        "https://script.google.com/macros/s/AKfycbxC-04gzCeK6aiBtxx1S6s36mJ7jEX6J9qkWddDLtCxBpzRN2YoCIeqe-5AJshgjPFJzQ/exec";

      const response = await fetch(scriptURL, {
        method: "POST",
        body: formData,
        mode: "no-cors",
      });

      console.log("Formulario enviado exitosamente");
      alert("Formulario enviado exitosamente");
      formVoluntariado.reset();

      const formModal = document.getElementById("formModal");
      if (formModal) formModal.classList.add("oculto");
    } catch (err) {
      console.error("Error al enviar:", err);
      alert("Error al enviar. Inténtalo nuevamente.");
    }
  });
}

// FORMULARIO DE CONTACTO
const formContacto = document.getElementById("contactForm");
if (formContacto) {
  console.log("Formulario de contacto encontrado");
  formContacto.addEventListener("submit", async (e) => {
    e.preventDefault();
    // Validar campos requeridos
    if (!formContacto.checkValidity()) {
      formContacto.reportValidity(); // Muestra mensajes de error nativos
      return;
    }
    console.log("Ejecutando reCAPTCHA v3...");

    try {
      const token = await grecaptcha.execute(RECAPTCHA_SITE_KEY_V3, {
        action: "submit_contacto",
      });
      console.log("Token reCAPTCHA recibido:", token);

      const formData = new FormData(formContacto);
      formData.append("formType", "contacto");
      formData.append("g-recaptcha-response", token);

      const scriptURL =
        "https://script.google.com/macros/s/AKfycbxC-04gzCeK6aiBtxx1S6s36mJ7jEX6J9qkWddDLtCxBpzRN2YoCIeqe-5AJshgjPFJzQ/exec";

      const response = await fetch(scriptURL, {
        method: "POST",
        body: formData,
        mode: "no-cors",
      });

      console.log("Mensaje enviado exitosamente");
      formContacto.reset();
    } catch (err) {
      console.error("Error al enviar:", err);
    }
  });
}

/* ========================================
   ESPERAR A QUE EL DOM ESTÉ LISTO
======================================== */

document.addEventListener("DOMContentLoaded", function () {
  console.log("🚀 DOM cargado completamente");

  // =====================================
  // FILTROS DE EVENTOS
  // =====================================
  const filtrosEventos = document.querySelectorAll(".filtros button");
  const cardsEventos = document.querySelectorAll(".card-evento");

  if (filtrosEventos.length > 0) {
    filtrosEventos.forEach((btn) => {
      btn.addEventListener("click", function () {
        filtrosEventos.forEach((b) => b.classList.remove("activo"));
        this.classList.add("activo");
        const filtro = this.textContent.trim();
        cardsEventos.forEach((card) => {
          if (filtro === "Todos") {
            card.style.display = "block";
          } else {
            const ciudades = card
              .getAttribute("data-ciudad")
              .split(",")
              .map((c) => c.trim());
            if (ciudades.includes(filtro)) {
              card.style.display = "block";
            } else {
              card.style.display = "none";
            }
          }
        });
      });
    });
  }

  // =====================================
  // CARRUSEL DE JUNTA DIRECTIVA
  // =====================================
  const track = document.querySelector(".carousel-track");
  const nextBtn = document.querySelector(".next-btn");
  const prevBtn = document.querySelector(".prev-btn");
  const dotsContainer = document.querySelector(".carousel-dots");

  if (track && nextBtn && prevBtn && dotsContainer) {
    const slides = Array.from(track.children);
    let currentSlide = 0;

    function getSlidesPerView() {
      const width = window.innerWidth;
      if (width >= 1024) return 3;
      if (width >= 768) return 2;
      return 1;
    }

    let slidesPerView = getSlidesPerView();
    const totalSlides = slides.length;

    function getTotalDots() {
      return Math.ceil(totalSlides / slidesPerView);
    }

    let totalDots = getTotalDots();

    function createDots() {
      dotsContainer.innerHTML = "";
      totalDots = getTotalDots();
      for (let i = 0; i < totalDots; i++) {
        const dot = document.createElement("div");
        dot.classList.add("carousel-dot");
        if (i === 0) dot.classList.add("active");
        dotsContainer.appendChild(dot);
      }
    }

    createDots();

    const getDots = () => Array.from(dotsContainer.children);

    function updateCarousel() {
      const slideWidth = slides[0].getBoundingClientRect().width;
      const gap = 24;
      const moveAmount = -(currentSlide * (slideWidth + gap));
      track.style.transform = `translateX(${moveAmount}px)`;
      const activeDotIndex = Math.floor(currentSlide / slidesPerView);
      getDots().forEach((dot, index) => {
        dot.classList.toggle("active", index === activeDotIndex);
      });
    }

    nextBtn.addEventListener("click", () => {
      if (currentSlide < totalSlides - slidesPerView) {
        currentSlide++;
      } else {
        currentSlide = 0;
      }
      updateCarousel();
    });

    prevBtn.addEventListener("click", () => {
      if (currentSlide > 0) {
        currentSlide--;
      } else {
        currentSlide = totalSlides - slidesPerView;
      }
      updateCarousel();
    });

    dotsContainer.addEventListener("click", (e) => {
      if (e.target.classList.contains("carousel-dot")) {
        const index = getDots().indexOf(e.target);
        if (index !== -1) {
          currentSlide = index * slidesPerView;
          updateCarousel();
        }
      }
    });

    window.addEventListener("resize", () => {
      const oldSlidesPerView = slidesPerView;
      slidesPerView = getSlidesPerView();
      if (oldSlidesPerView !== slidesPerView) {
        currentSlide = 0;
        createDots();
      }
      updateCarousel();
    });

    let startX = 0;
    let isDragging = false;

    track.addEventListener("touchstart", (e) => {
      startX = e.touches[0].clientX;
      isDragging = true;
    });

    track.addEventListener("touchend", (e) => {
      if (!isDragging) return;
      const endX = e.changedTouches[0].clientX;
      const diff = startX - endX;
      if (Math.abs(diff) > 50) {
        if (diff > 0 && currentSlide < totalSlides - slidesPerView) {
          currentSlide++;
        } else if (diff < 0 && currentSlide > 0) {
          currentSlide--;
        }
        updateCarousel();
      }
      isDragging = false;
    });
  }

  // =====================================
  // MODAL DE VOLUNTARIADO
  // =====================================
  const btnInscribirse = document.getElementById("btnInscribirse");
  const btnReclutamiento = document.getElementById("btnReclutamiento");
  const formModal = document.getElementById("formModal");
  const btnCerrarForm = document.getElementById("btnCerrarForm");
  const form = document.getElementById("voluntarioForm");

  if (formModal) {
    console.log("✅ Modal encontrado");
    formModal.classList.add("oculto");

    if (btnInscribirse) {
      btnInscribirse.addEventListener("click", () => {
        console.log("🔓 Abriendo modal desde btnInscribirse");
        formModal.classList.remove("oculto");
      });
    }

    if (btnReclutamiento) {
      btnReclutamiento.addEventListener("click", () => {
        console.log("🔓 Abriendo modal desde btnReclutamiento");
        formModal.classList.remove("oculto");
      });
    }

    if (btnCerrarForm) {
      btnCerrarForm.addEventListener("click", () => {
        console.log("🔒 Cerrando modal");
        formModal.classList.add("oculto");
      });
    }

    formModal.addEventListener("click", (e) => {
      if (e.target === formModal) {
        console.log("🔒 Cerrando modal (click afuera)");
        formModal.classList.add("oculto");
      }
    });

    if (form) {
      form.addEventListener("submit", (e) => {
        e.preventDefault();
        form.reset();
        formModal.classList.add("oculto");
      });
    }
  }

  // ====================================
  // FORMULARIOS - GOOGLE SHEETS
  // ====================================
  const scriptURL =
    "https://script.google.com/macros/s/AKfycbxC-04gzCeK6aiBtxx1S6s36mJ7jEX6J9qkWddDLtCxBpzRN2YoCIeqe-5AJshgjPFJzQ/exec";

  // FORMULARIO DE VOLUNTARIADO
  const formVoluntariado = document.getElementById(
    "voluntarioFormReclutamiento"
  );
  if (formVoluntariado) {
    console.log("Formulario de voluntariado encontrado");
    formVoluntariado.addEventListener("submit", (e) => {
      e.preventDefault();
      console.log("Ejecutando reCAPTCHA invisible...");
      // Ejecutar el captcha invisible - automáticamente dispara el callback
      if (captchaVoluntariado !== null) {
        grecaptcha.execute(captchaVoluntariado);
      } else {
        console.error("captchaVoluntariado no inicializado");
        // Si el captcha no está inicializado, enviar sin captcha
        onSubmitVoluntariado("");
      }
    });
  }

  // FORMULARIO DE CONTACTO
  const formContacto = document.getElementById("contactForm");
  if (formContacto) {
    console.log("Formulario de contacto encontrado");
    formContacto.addEventListener("submit", (e) => {
      e.preventDefault();
      console.log("Ejecutando reCAPTCHA invisible...");
      // Ejecutar el captcha invisible - automáticamente dispara el callback
      if (captchaContacto !== null) {
        grecaptcha.execute(captchaContacto);
      } else {
        console.error("captchaContacto no inicializado");
        // Si el captcha no está inicializado, enviar sin captcha
        onSubmitContacto("");
      }
    });
  }
});

/* ========================================
   CALLBACKS DE RECAPTCHA INVISIBLE
======================================== */

// Callback para VOLUNTARIADO
function onSubmitVoluntariado(token) {
  console.log("\n========== ENVIANDO VOLUNTARIADO ==========");
  console.log("✅ Token reCAPTCHA recibido");

  const formVoluntariado = document.getElementById(
    "voluntarioFormReclutamiento"
  );
  const formData = new FormData(formVoluntariado);
  formData.append("formType", "voluntariado");
  formData.append("g-recaptcha-response", token);

  const scriptURL =
    "https://script.google.com/macros/s/AKfycbxC-04gzCeK6aiBtxx1S6s36mJ7jEX6J9qkWddDLtCxBpzRN2YoCIeqe-5AJshgjPFJzQ/exec";

  fetch(scriptURL, {
    method: "POST",
    body: formData,
    mode: "no-cors",
  })
    .then((response) => {
      console.log("✅ Formulario enviado exitosamente");
      alert("✅ Formulario enviado exitosamente");
      formVoluntariado.reset();

      // Resetear reCAPTCHA
      if (captchaVoluntariado !== null) {
        grecaptcha.reset(captchaVoluntariado);
      }

      const formModal = document.getElementById("formModal");
      if (formModal) {
        formModal.classList.add("oculto");
      }
    })
    .catch((err) => {
      console.error("❌ Error al enviar:", err);
      alert("❌ Error al enviar. Inténtalo nuevamente.");

      // Resetear reCAPTCHA también en error
      if (captchaVoluntariado !== null) {
        grecaptcha.reset(captchaVoluntariado);
      }
    });
}

// Callback para CONTACTO
function onSubmitContacto(token) {
  console.log("\n========== ENVIANDO CONTACTO ==========");
  console.log("✅ Token reCAPTCHA recibido");

  const formContacto = document.getElementById("contactForm");
  const formData = new FormData(formContacto);
  formData.append("formType", "contacto");
  formData.append("g-recaptcha-response", token);

  const scriptURL =
    "https://script.google.com/macros/s/AKfycbxC-04gzCeK6aiBtxx1S6s36mJ7jEX6J9qkWddDLtCxBpzRN2YoCIeqe-5AJshgjPFJzQ/exec";

  fetch(scriptURL, {
    method: "POST",
    body: formData,
    mode: "no-cors",
  })
    .then((response) => {
      console.log("✅ Mensaje enviado exitosamente");
      formContacto.reset();

      // Resetear reCAPTCHA
      if (captchaContacto !== null) {
        grecaptcha.reset(captchaContacto);
      }
    })
    .catch((err) => {
      console.error("❌ Error al enviar:", err);

      // Resetear reCAPTCHA también en error
      if (captchaContacto !== null) {
        grecaptcha.reset(captchaContacto);
      }
    });
}

// MENU HAMBURGUESA - TOGGLE
document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.getElementById("menu-toggle");
  const menu = document.querySelector(".menu");
  const menuIcon = document.querySelector(".menu-icon");

  if (menuToggle && menuIcon) {
    menuIcon.addEventListener("click", function () {
      menuToggle.checked = !menuToggle.checked;
    });
  }

  // Cerrar menú al hacer clic en un enlace
  const menuLinks = document.querySelectorAll(".menu a");
  menuLinks.forEach((link) => {
    link.addEventListener("click", function () {
      if (menuToggle) {
        menuToggle.checked = false;
      }
    });
  });
});

// DROPDOWN COMUNIDADES EN MÓVILES
document.addEventListener("DOMContentLoaded", function () {
  const dropdownToggle = document.querySelector(".dropdown-toggle");
  const dropdownComunidades = document.querySelector(".dropdown-comunidades");

  if (dropdownToggle && window.innerWidth <= 768) {
    dropdownToggle.addEventListener("click", function (e) {
      e.preventDefault();
      dropdownComunidades.classList.toggle("active");
    });
  }
});
