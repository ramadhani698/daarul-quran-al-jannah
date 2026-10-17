// Modal form donasi di halaman show — buka via tombol CTA, tutup via backdrop/tombol X
(function () {
    const modal = document.getElementById('donasiFormModal');
    const openBtn = document.getElementById('donasiOpenFormBtn');
    const closeBtn = document.getElementById('donasiFormCloseBtn');
    const backdrop = document.getElementById('donasiFormBackdrop');
    if (!modal || !openBtn) return;

    function open() { modal.classList.add('is-open'); }
    function close() { modal.classList.remove('is-open'); }

    openBtn.addEventListener('click', open);
    if (closeBtn) closeBtn.addEventListener('click', close);
    if (backdrop) backdrop.addEventListener('click', close);
})();

// Tombol salin nomor rekening di form donasi
(function () {
    const btn = document.getElementById('donasiCopyRekening');
    const nomor = document.getElementById('donasiRekeningNomor');
    if (!btn || !nomor) return;

    btn.addEventListener('click', function () {
        navigator.clipboard.writeText(nomor.textContent.trim()).then(function () {
            const original = btn.textContent;
            btn.textContent = 'Tersalin!';
            setTimeout(function () { btn.textContent = original; }, 1500);
        });
    });
})();

// Toggle tab metode pembayaran (Transfer Bank / QRIS) di modal form show
(function () {
    const tabs = document.querySelectorAll('.donasi-form__rekening-tab');
    const metodeInput = document.getElementById('metodePembayaran');
    if (tabs.length === 0) return;

    tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
            tabs.forEach((t) => t.classList.remove('is-active'));
            tab.classList.add('is-active');

            document.querySelectorAll('.donasi-form__rekening-panel').forEach((panel) => {
                panel.hidden = panel.id !== tab.dataset.target;
            });

            // simpan pilihan ke hidden input biar ikut ke-submit
            if (metodeInput) metodeInput.value = tab.dataset.metode;
        });
    });
})();

// Format nominal donasi (Rp)
document.addEventListener('DOMContentLoaded', function () {
    const nominalInput = document.getElementById('nominal');
    if (!nominalInput) return;

    const formatRupiah = (value) => {
        const digits = value.replace(/\D/g, '');
        return digits ? new Intl.NumberFormat('id-ID').format(Number(digits)) : '';
    };

    nominalInput.addEventListener('input', function () {
        // simpan posisi kursor dihitung dari belakang, biar nggak loncat ke ujung pas ngedit di tengah
        const caretFromEnd = this.value.length - this.selectionStart;
        this.value = formatRupiah(this.value);
        const pos = Math.max(this.value.length - caretFromEnd, 0);
        this.setSelectionRange(pos, pos);
    });

    // kalau balik dari error validasi, old('nominal') isinya angka polos, format ulang
    nominalInput.value = formatRupiah(nominalInput.value);
});