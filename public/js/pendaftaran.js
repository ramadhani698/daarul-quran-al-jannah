document.addEventListener('DOMContentLoaded', function () {

        var canvas = document.getElementById('hero-canvas-pendaftaran');
        var hero   = document.querySelector('.hero-section-pendaftaran');

        if (!canvas || !hero) return;

        var ctx = canvas.getContext('2d');

        function resize() {
            canvas.width  = hero.offsetWidth;
            canvas.height = hero.offsetHeight;
        }

        resize();
        window.addEventListener('resize', resize);

        var types = ['triangle', 'square', 'diamond', 'cross'];

        var shapes = Array.from({ length: 42 }, function () {
            var isGold = Math.random() > 0.55;
            return {
                x        : Math.random() * canvas.width,
                y        : canvas.height + Math.random() * 250,
                size     : 4 + Math.random() * 13,
                speed    : 0.18 + Math.random() * 0.48,
                drift    : (Math.random() - 0.5) * 0.32,
                rot      : Math.random() * Math.PI * 2,
                rotSpeed : (Math.random() - 0.5) * 0.014,
                opacity  : 0.08 + Math.random() * 0.18,
                color    : isGold ? 'rgba(244,196,48,' : 'rgba(255,255,255,',
                type     : types[Math.floor(Math.random() * types.length)],
            };
        });

        function drawShape(s) {
            ctx.save();
            ctx.translate(s.x, s.y);
            ctx.rotate(s.rot);

            ctx.strokeStyle = s.color + (s.opacity + 0.06) + ')';
            ctx.fillStyle   = s.color + s.opacity + ')';
            ctx.lineWidth   = 1;

            ctx.beginPath();

            if (s.type === 'triangle') {
                ctx.moveTo(0, -s.size);
                ctx.lineTo(s.size * 0.87,  s.size * 0.5);
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
                var t = s.size * 0.28;
                ctx.moveTo(-t,      -s.size);
                ctx.lineTo( t,      -s.size);
                ctx.lineTo( t,      -t);
                ctx.lineTo( s.size, -t);
                ctx.lineTo( s.size,  t);
                ctx.lineTo( t,       t);
                ctx.lineTo( t,       s.size);
                ctx.lineTo(-t,       s.size);
                ctx.lineTo(-t,       t);
                ctx.lineTo(-s.size,  t);
                ctx.lineTo(-s.size, -t);
                ctx.lineTo(-t,      -t);
                ctx.closePath();
                ctx.fill();
            }

            ctx.restore();
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            shapes.forEach(function (s) {
                drawShape(s);

                s.y   -= s.speed;
                s.x   += s.drift;
                s.rot += s.rotSpeed;

                if (s.y + s.size < 0) {
                    s.y = canvas.height + s.size;
                    s.x = Math.random() * canvas.width;
                }
            });

            requestAnimationFrame(animate);
        }

        animate();

    });