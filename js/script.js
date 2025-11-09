/* ========================================
   CUENTA REGRESIVA HERO
======================================== */
// Estructura esperada: .counter[data-countdown="YYYY-MM-DDTHH:mm:ss-Z"][data-unit="days|hours|minutes|seconds"]
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

  // CARRUSEL DE JUNTA DIRECTIVA
  // CARRUSEL DE JUNTA DIRECTIVA
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

    // Calcular cantidad de "páginas"
    function getTotalDots() {
      return Math.ceil(totalSlides / slidesPerView);
    }

    let totalDots = getTotalDots();

    // Crear dots
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

    // Función para actualizar el carrusel
    function updateCarousel() {
      const slideWidth = slides[0].getBoundingClientRect().width;
      const gap = 24;

      // Mover el track basado en el slide actual
      const moveAmount = -(currentSlide * (slideWidth + gap));
      track.style.transform = `translateX(${moveAmount}px)`;

      // Calcular qué dot debe estar activo
      const activeDotIndex = Math.floor(currentSlide / slidesPerView);

      // Actualizar dots
      getDots().forEach((dot, index) => {
        dot.classList.toggle("active", index === activeDotIndex);
      });
    }

    // Botón siguiente
    nextBtn.addEventListener("click", () => {
      if (currentSlide < totalSlides - slidesPerView) {
        currentSlide++;
      } else {
        currentSlide = 0;
      }
      updateCarousel();
    });

    // Botón anterior
    prevBtn.addEventListener("click", () => {
      if (currentSlide > 0) {
        currentSlide--;
      } else {
        currentSlide = totalSlides - slidesPerView;
      }
      updateCarousel();
    });

    // Click en dots
    dotsContainer.addEventListener("click", (e) => {
      if (e.target.classList.contains("carousel-dot")) {
        const index = getDots().indexOf(e.target);
        if (index !== -1) {
          currentSlide = index * slidesPerView;
          updateCarousel();
        }
      }
    });

    // Resize
    window.addEventListener("resize", () => {
      const oldSlidesPerView = slidesPerView;
      slidesPerView = getSlidesPerView();

      if (oldSlidesPerView !== slidesPerView) {
        currentSlide = 0;
        createDots();
      }

      updateCarousel();
    });

    // Touch swipe
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
  // MODAL DE VOLUNTARIADO - ÚNICO
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
      console.log("✅ btnInscribirse encontrado");
      btnInscribirse.addEventListener("click", () => {
        console.log("🔓 Abriendo modal desde btnInscribirse");
        formModal.classList.remove("oculto");
      });
    } else {
      console.log("⚠️ btnInscribirse NO encontrado");
    }

    if (btnReclutamiento) {
      console.log("✅ btnReclutamiento encontrado");
      btnReclutamiento.addEventListener("click", () => {
        console.log("🔓 Abriendo modal desde btnReclutamiento");
        formModal.classList.remove("oculto");
      });
    } else {
      console.log("⚠️ btnReclutamiento NO encontrado");
    }

    if (btnCerrarForm) {
      console.log("✅ btnCerrarForm encontrado");
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
  } else {
    console.error("❌ Modal 'formModal' NO encontrado");
  }

  // ====================================
  // FORMULARIOS - GOOGLE SHEETS
  // ====================================

  const scriptURL =
    "https://script.google.com/macros/s/AKfycbwiioIR9TPa0xW6QFpQ5E6y9DuFdfx1SOk3Ylntac1Nm4co4yXwvUq-zEjV0v5317a5xA/exec";

  console.log("🔧 Script URL configurada:", scriptURL);

  async function testConnection() {
    console.log("🔍 Probando conexión con Google Apps Script...");
    try {
      const response = await fetch(scriptURL, { method: "GET" });
      const text = await response.text();
      console.log("✅ Respuesta GET:", text);
    } catch (err) {
      console.error("❌ Error en conexión:", err);
    }
  }

  testConnection();

  // =====================================
  // FORMULARIO DE VOLUNTARIADO
  // =====================================
  const formVoluntariado = document.getElementById(
    "voluntarioFormReclutamiento"
  );

  if (formVoluntariado) {
    console.log("✅ Formulario de voluntariado encontrado");

    formVoluntariado.addEventListener("submit", async (e) => {
      e.preventDefault();
      console.log("\n========== ENVIANDO VOLUNTARIADO ==========");

      // Verificar CAPTCHA (índice 0 para el primer captcha)
      const captchaResponse = grecaptcha.getResponse(0);
      if (!captchaResponse) {
        alert("⚠️ Por favor, completa la verificación CAPTCHA.");
        return;
      }

      const formElement = e.target;
      const formData = new FormData(formElement);
      formData.append("formType", "voluntariado");
      formData.append("g-recaptcha-response", captchaResponse);

      console.log("📦 Datos del FormData:");
      for (let [key, value] of formData.entries()) {
        console.log(` ${key}: ${value}`);
      }

      console.log("🚀 Enviando a:", scriptURL);

      try {
        const response = await fetch(scriptURL, {
          method: "POST",
          body: formData,
          mode: "no-cors",
        });

        console.log("📬 Respuesta recibida");
        console.log(" Status:", response.status);
        console.log(" Type:", response.type);

        alert("✅ Formulario enviado exitosamente");

        // Resetear formulario y cerrar modal
        formElement.reset();
        grecaptcha.reset(0); // Resetear el primer captcha
        if (formModal) {
          formModal.classList.add("oculto");
        }
      } catch (err) {
        console.error("❌ Error al enviar:");
        console.error(" Mensaje:", err.message);
        console.error(" Stack:", err.stack);
        alert("❌ Error al enviar. Inténtalo nuevamente.");
      }

      console.log("========== FIN VOLUNTARIADO ==========\n");
    });
  } else {
    console.error("❌ Formulario 'voluntarioFormReclutamiento' NO encontrado");
  }

  // =====================================
  // FORMULARIO DE CONTACTO
  // =====================================
  const formContacto = document.getElementById("contactForm");

  if (formContacto) {
    console.log("✅ Formulario de contacto encontrado");

    formContacto.addEventListener("submit", async (e) => {
      e.preventDefault();
      console.log("\n========== ENVIANDO CONTACTO ==========");

      // Verificar CAPTCHA (índice 1 para el segundo captcha)
      const captchaResponse = grecaptcha.getResponse(1);
      if (!captchaResponse) {
        alert("⚠️ Por favor, completa la verificación CAPTCHA.");
        return;
      }

      const formElement = e.target;
      const formData = new FormData(formElement);
      formData.append("formType", "contacto");
      formData.append("g-recaptcha-response", captchaResponse);

      console.log("📦 Datos del FormData:");
      for (let [key, value] of formData.entries()) {
        console.log(` ${key}: ${value}`);
      }

      console.log("🚀 Enviando a:", scriptURL);

      try {
        const response = await fetch(scriptURL, {
          method: "POST",
          body: formData,
          mode: "no-cors",
        });

        console.log("📬 Respuesta recibida");
        console.log(" Status:", response.status);
        console.log(" Type:", response.type);

        alert("✅ Mensaje enviado exitosamente");

        // Resetear formulario
        formElement.reset();
        grecaptcha.reset(1); // Resetear el segundo captcha
      } catch (err) {
        console.error("❌ Error al enviar:");
        console.error(" Mensaje:", err.message);
        console.error(" Stack:", err.stack);
        alert("❌ Error al enviar. Inténtalo nuevamente.");
      }

      console.log("========== FIN CONTACTO ==========\n");
    });
  } else {
    console.error("❌ Formulario 'contactForm' NO encontrado");
  }
});
