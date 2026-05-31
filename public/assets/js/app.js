// ── Sidebar toggle ───────────────────────────────────────────
const sidebar = document.getElementById('sidebar');
const mainContent = document.querySelector('.main-content');
const toggleBtn = document.getElementById('sidebarToggle');

if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            sidebar?.classList.toggle('open');
        } else {
            sidebar?.classList.toggle('collapsed');
            mainContent?.classList.toggle('expanded');
        }
    });
}

// ── Auto-dismiss toasts ──────────────────────────────────────
document.querySelectorAll('.toast').forEach(el => {
    setTimeout(() => {
        const bsToast = bootstrap.Toast.getOrCreateInstance(el);
        bsToast.hide();
    }, 4000);
});

// ── Confirm delete ───────────────────────────────────────────
document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', e => {
        const msg = el.dataset.confirm || 'Are you sure?';
        if (!confirm(msg)) e.preventDefault();
    });
});
