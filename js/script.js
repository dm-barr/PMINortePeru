/* ========================================
   CUENTA REGRESIVA HERO
======================================== */

// Estructura esperada: .counter[data-countdown="YYYY-MM-DDTHH:mm:ss-Z"][data-unit="days|hours|minutes|seconds"]
const countdownBlocks = document.querySelectorAll('.counter[data-countdown]');

countdownBlocks.forEach(block => {
    const t = new Date(block.dataset.countdown).getTime();
    
    const el = {
        d: block.querySelector('[data-unit="days"]'),
        h: block.querySelector('[data-unit="hours"]'),
        m: block.querySelector('[data-unit="minutes"]'),
        s: block.querySelector('[data-unit="seconds"]')
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
        
        if (el.d) el.d.textContent = String(d).padStart(2, '0');
        if (el.h) el.h.textContent = String(h).padStart(2, '0');
        if (el.m) el.m.textContent = String(m).padStart(2, '0');
        if (el.s) el.s.textContent = String(s).padStart(2, '0');
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

const reveals = document.querySelectorAll('.reveal');
const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (prefersReduced) {
    reveals.forEach(el => el.classList.add('is-visible'));
} else {
    const io = new IntersectionObserver((entries) => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                e.target.classList.add('is-visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.35 });
    
    reveals.forEach(el => io.observe(el));
}

// Filtros de eventos
document.addEventListener('DOMContentLoaded', function() {
    const filtrosEventos = document.querySelectorAll('.filtros button');
    const cardsEventos = document.querySelectorAll('.card-evento');
    
    filtrosEventos.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remover clase activo de todos los botones
            filtrosEventos.forEach(b => b.classList.remove('activo'));
            // Agregar clase activo al botón clickeado
            this.classList.add('activo');
            
            const filtro = this.textContent.trim();
            
            cardsEventos.forEach(card => {
                if (filtro === 'Todos') {
                    card.style.display = 'block';
                } else {
                    const ciudades = card.getAttribute('data-ciudad')
                        .split(',')
                        .map(c => c.trim());
                    
                    if (ciudades.includes(filtro)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        });
    });
});


// Carrusel de Junta Directiva
document.addEventListener('DOMContentLoaded', function() {
    const track = document.querySelector('.carousel-track');
    const slides = Array.from(track.children);
    const nextBtn = document.querySelector('.next-btn');
    const prevBtn = document.querySelector('.prev-btn');
    const dotsContainer = document.querySelector('.carousel-dots');
    
    // Calcular número de slides visibles según ancho de pantalla
    function getSlidesPerView() {
        const width = window.innerWidth;
        if (width >= 1024) return 3;
        if (width >= 768) return 2;
        return 1;
    }
    
    let currentIndex = 0;
    let slidesPerView = getSlidesPerView();
    
    // Crear dots
    const totalDots = Math.ceil(slides.length / slidesPerView);
    for (let i = 0; i < totalDots; i++) {
        const dot = document.createElement('div');
        dot.classList.add('carousel-dot');
        if (i === 0) dot.classList.add('active');
        dotsContainer.appendChild(dot);
    }
    
    const dots = Array.from(dotsContainer.children);
    
    // Actualizar posición del carrusel
    function updateCarousel() {
        const slideWidth = slides[0].getBoundingClientRect().width;
        const gap = 24; // var(--spacing-md)
        const moveAmount = -(currentIndex * (slideWidth + gap) * slidesPerView);
        track.style.transform = `translateX(${moveAmount}px)`;
        
        // Actualizar dots
        dots.forEach(dot => dot.classList.remove('active'));
        if (dots[currentIndex]) dots[currentIndex].classList.add('active');
    }
    
    // Botón siguiente
    nextBtn.addEventListener('click', () => {
        if (currentIndex < totalDots - 1) {
            currentIndex++;
        } else {
            currentIndex = 0; // Loop infinito
        }
        updateCarousel();
    });
    
    // Botón anterior
    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = totalDots - 1; // Loop infinito
        }
        updateCarousel();
    });
    
    // Click en dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentIndex = index;
            updateCarousel();
        });
    });
    
    // Responsive: recalcular al cambiar tamaño de ventana
    window.addEventListener('resize', () => {
        slidesPerView = getSlidesPerView();
        updateCarousel();
    });
    
    // Deslizamiento táctil (opcional)
    let startX = 0;
    track.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
    });
    
    track.addEventListener('touchend', (e) => {
        const endX = e.changedTouches[0].clientX;
        const diff = startX - endX;
        
        if (Math.abs(diff) > 50) {
            if (diff > 0 && currentIndex < totalDots - 1) {
                currentIndex++;
            } else if (diff < 0 && currentIndex > 0) {
                currentIndex--;
            }
            updateCarousel();
        }
    });
});

