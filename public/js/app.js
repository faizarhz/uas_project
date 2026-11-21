function toast(m) {
    const t = document.getElementById('toast');
    t.textContent = m;
    t.style.opacity = 1;
    setTimeout(() => (t.style.opacity = 0), 1800);
}

if (window.__toast) toast(window.__toast);

// Halaman produk: kirim filter otomatis
const f = document.getElementById('filter');
if (f) {
    let timer;
    const q = document.getElementById('q');
    q?.addEventListener('input', () => {
        clearTimeout(timer);
        timer = setTimeout(() => f.requestSubmit(), 400);
    });
    f.querySelectorAll('select, input[type=range]').forEach(el =>
        el.addEventListener('change', () => f.requestSubmit())
    );
    if (q && q.value) {
        q.focus();
        q.setSelectionRange(q.value.length, q.value.length);
    }
}

// Checkout: perbarui ongkir & total tanpa memuat ulang halaman
const rp = n => 'Rp' + n.toLocaleString('id-ID');
const subEl = document.querySelector('[data-sub]');
document.querySelectorAll('input[name=ship]').forEach(r =>
    r.addEventListener('change', () => {
        const sub = +subEl.dataset.sub, cost = +r.dataset.cost;
        document.getElementById('ong').textContent = rp(cost);
        document.getElementById('total').textContent = rp(sub + cost);
    })
);
