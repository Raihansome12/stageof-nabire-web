{{-- Bulk-select JavaScript — push this into @stack('scripts') on pages that use checkboxes --}}
<script>
// ── Bulk select system ────────────────────────────────────────────────────────
function updateBulkBar() {
    const checked = document.querySelectorAll('.row-cb:checked');
    const bar     = document.getElementById('bulkBar');
    const counter = document.getElementById('bulkCount');
    if (!bar) return;

    if (checked.length > 0) {
        bar.classList.remove('hidden');
        bar.classList.add('flex');
        if (counter) counter.textContent = checked.length;
    } else {
        bar.classList.add('hidden');
        bar.classList.remove('flex');
    }
}

function toggleSelectAll(masterCb) {
    document.querySelectorAll('.row-cb').forEach(cb => {
        cb.checked = masterCb.checked;
    });
    updateBulkBar();
}

function clearSelection() {
    document.querySelectorAll('.row-cb, #selectAll').forEach(cb => { cb.checked = false; });
    updateBulkBar();
}

function submitBulkDelete() {
    const checked = document.querySelectorAll('.row-cb:checked');
    if (checked.length === 0) return;

    if (!confirm(`Hapus ${checked.length} data yang dipilih? Tindakan ini tidak dapat dibatalkan.`)) return;

    const container = document.getElementById('bulkInputs');
    container.innerHTML = '';
    checked.forEach(cb => {
        const inp = document.createElement('input');
        inp.type  = 'hidden';
        inp.name  = 'ids[]';
        inp.value = cb.value;
        container.appendChild(inp);
    });

    document.getElementById('bulkForm').submit();
}

// Sync master checkbox state when individual rows change
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('row-cb')) {
        updateBulkBar();
        const all    = document.querySelectorAll('.row-cb');
        const master = document.getElementById('selectAll');
        if (master) {
            master.checked       = [...all].every(cb => cb.checked);
            master.indeterminate = !master.checked && [...all].some(cb => cb.checked);
        }
    }
});
</script>
