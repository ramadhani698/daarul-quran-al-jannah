// Carousel auto-slide + dots
(function () {
    const track = document.getElementById('donasiCarouselTrack');
    const dotsWrap = document.getElementById('donasiCarouselDots');
    if (!track || !dotsWrap) return;
    const slides = track.querySelectorAll('.donasi-carousel__slide');
    if (slides.length === 0) return;

    slides.forEach((slide, i) => {
        const dot = document.createElement('span');
        if (i === 0) dot.classList.add('is-active');
        dot.addEventListener('click', () => goTo(i));
        dotsWrap.appendChild(dot);
    });
    const dots = dotsWrap.querySelectorAll('span');

    let current = 0;
    function goTo(index) {
        slides[current].classList.remove('is-active');
        dots[current].classList.remove('is-active');
        current = index;
        slides[current].classList.add('is-active');
        dots[current].classList.add('is-active');
    }
    slides[0].classList.add('is-active');

    setInterval(() => {
        goTo((current + 1) % slides.length);
    }, 4000);
})();

// Partikel geometris ambient di hero — pola sama kayak hero galeri
(function () {
    const canvas = document.getElementById('donasiParticles');
    const hero = canvas ? canvas.closest('.donasi-hero__card') : null;
    if (!canvas || !hero) return;
    const ctx = canvas.getContext('2d');

    function resize() {
        canvas.width = hero.offsetWidth;
        canvas.height = hero.offsetHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    const types = ['triangle', 'square', 'diamond', 'cross'];
    const count = Math.max(14, Math.floor((canvas.width * canvas.height) / 11000));

    const shapes = Array.from({ length: count }, () => {
        const isGold = Math.random() > 0.55;
        return {
            x: Math.random() * canvas.width,
            y: canvas.height + Math.random() * 150,
            size: 4 + Math.random() * 10,
            speed: 0.15 + Math.random() * 0.4,
            drift: (Math.random() - 0.5) * 0.28,
            rot: Math.random() * Math.PI * 2,
            rotSpeed: (Math.random() - 0.5) * 0.014,
            opacity: 0.08 + Math.random() * 0.18,
            color: isGold ? 'rgba(244,196,48,' : 'rgba(255,255,255,',
            type: types[Math.floor(Math.random() * types.length)],
        };
    });

    function drawShape(s) {
        ctx.save();
        ctx.translate(s.x, s.y);
        ctx.rotate(s.rot);
        ctx.strokeStyle = s.color + (s.opacity + 0.06) + ')';
        ctx.fillStyle = s.color + s.opacity + ')';
        ctx.lineWidth = 1;
        ctx.beginPath();

        if (s.type === 'triangle') {
            ctx.moveTo(0, -s.size);
            ctx.lineTo(s.size * 0.87, s.size * 0.5);
            ctx.lineTo(-s.size * 0.87, s.size * 0.5);
            ctx.closePath();
            ctx.stroke();
        } else if (s.type === 'square') {
            ctx.strokeRect(-s.size / 2, -s.size / 2, s.size, s.size);
        } else if (s.type === 'diamond') {
            ctx.moveTo(0, -s.size);
            ctx.lineTo(s.size * 0.6, 0);
            ctx.lineTo(0, s.size);
            ctx.lineTo(-s.size * 0.6, 0);
            ctx.closePath();
            ctx.fill();
        } else if (s.type === 'cross') {
            const t = s.size * 0.28;
            ctx.moveTo(-t, -s.size); ctx.lineTo(t, -s.size); ctx.lineTo(t, -t);
            ctx.lineTo(s.size, -t); ctx.lineTo(s.size, t); ctx.lineTo(t, t);
            ctx.lineTo(t, s.size); ctx.lineTo(-t, s.size); ctx.lineTo(-t, t);
            ctx.lineTo(-s.size, t); ctx.lineTo(-s.size, -t); ctx.lineTo(-t, -t);
            ctx.closePath();
            ctx.fill();
        }
        ctx.restore();
    }

    function animate() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        shapes.forEach((s) => {
            drawShape(s);
            s.y -= s.speed;
            s.x += s.drift;
            s.rot += s.rotSpeed;
            if (s.y + s.size < 0) {
                s.y = canvas.height + s.size;
                s.x = Math.random() * canvas.width;
            }
        });
        requestAnimationFrame(animate);
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!prefersReducedMotion) {
        animate();
    }
})();

// Efek ketik otomatis di kotak header (Zakat / Infaq / Sedekah / Berbagi kebaikan)
(function () {
    const el = document.getElementById('donasiTypeWord');
    if (!el) return;

    const words = ['Zakat', 'Infaq', 'Sedekah', 'Berbagi kebaikan'];
    const typeSpeed = 90;
    const deleteSpeed = 45;
    const pauseAfterType = 1400;
    const pauseAfterDelete = 300;

    let wordIndex = 0;
    let charIndex = 0;

    function typeStep() {
        const currentWord = words[wordIndex];
        if (charIndex <= currentWord.length) {
            el.textContent = currentWord.slice(0, charIndex);
            charIndex++;
            setTimeout(typeStep, typeSpeed);
        } else {
            setTimeout(deleteStep, pauseAfterType);
        }
    }

    function deleteStep() {
        const currentWord = words[wordIndex];
        if (charIndex >= 0) {
            el.textContent = currentWord.slice(0, charIndex);
            charIndex--;
            setTimeout(deleteStep, deleteSpeed);
        } else {
            wordIndex = (wordIndex + 1) % words.length;
            charIndex = 0;
            setTimeout(typeStep, pauseAfterDelete);
        }
    }

    typeStep();
})();

// Carousel program per kategori (Splide) — pola sama kayak versi PHP native
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Splide === 'undefined') return;

    document.querySelectorAll('.donasi-program-slider').forEach(function (el) {
        const splide = new Splide(el, {
            type: 'slide',
            perPage: 2,
            gap: '16px',
            autoplay: true,
            interval: 4000,
            arrows: false,
            pagination: false,
            drag: true,
            rewind: true,
            speed: 800,
            pauseOnHover: false,
            pauseOnFocus: false,
            breakpoints: {
                480: { perPage: 1 },
            },
        });

        splide.on('drag', () => splide.Components.Autoplay.pause());
        splide.on('dragged', () => splide.Components.Autoplay.play());

        splide.mount();
    });
});