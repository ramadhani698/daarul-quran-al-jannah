// Tombol salin kode donasi di halaman upload-bukti
(function () {
    const btn = document.getElementById('donasiCopyKode');
    const kode = document.getElementById('donasiKodeDonasi');
    if (!btn || !kode) return;

    btn.addEventListener('click', function () {
        navigator.clipboard.writeText(kode.textContent.trim()).then(function () {
            const original = btn.textContent;
            btn.textContent = 'Tersalin!';
            setTimeout(function () { btn.textContent = original; }, 1500);
        });
    });
})();