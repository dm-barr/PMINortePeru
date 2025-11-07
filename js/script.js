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
