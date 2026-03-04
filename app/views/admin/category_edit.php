<?php 
$title = "Edit Kategori";
ob_start();
?>

<!-- Premium Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL ?>/admin/categories" class="w-10 h-10 rounded-[14px] bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
        </a>
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Modifikasi Kategori</h2>
            <p class="text-[13px] font-medium text-slate-500">Sesuaikan properti registri kategori terpilih</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden w-full relative mb-8">
    <!-- Structural Top Decoration -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>
    <div class="p-8 sm:p-10">
        <form action="<?= BASEURL ?>/admin/editCategory/<?= $category['id'] ?>" method="POST" class="space-y-8">
            <?= CSRF::getTokenField() ?>
            
            <?php 
                $props = [
                    'name' => 'name',
                    'label' => 'Nama Tampilan Kategori',
                    'value' => htmlspecialchars($category['name']),
                    'required' => true
                ];
                include __DIR__ . '/../components/ui/input.php';
            ?>
            <p class="text-[12px] font-medium text-slate-400 -mt-3 mb-6 flex items-center gap-1.5"><i class="fas fa-circle-info text-slate-300"></i> Nama ini terlihat langsung oleh konsumen.</p>

            <?php 
                $props = [
                    'name' => 'slug',
                    'label' => 'Kunci Registri Akses (Slug URL)',
                    'value' => htmlspecialchars($category['slug']),
                    'icon' => 'fas fa-link',
                    'class' => 'font-mono text-[14px] tracking-tight text-indigo-600 focus:text-indigo-600 focus:border-indigo-500',
                    'required' => true
                ];
                include __DIR__ . '/../components/ui/input.php';
            ?>
            <p class="text-[12px] font-medium text-amber-500 -mt-3 mb-6 flex items-center gap-1.5"><i class="fas fa-triangle-exclamation text-amber-500/50"></i> Peringatan Sistem: Huruf kecil, tanda hubung untuk spasi. Simbol ditolak.</p>

            <div>
                <label class="block text-[13px] font-black text-slate-800 mb-2.5 uppercase tracking-wide">Siklus Kehidupan Status</label>
                <div class="flex gap-4 p-1.5 bg-slate-100 rounded-xl border border-slate-200/60 p-1">
                    <label class="relative flex-1 flex items-center justify-center cursor-pointer">
                        <input type="radio" name="active" value="Yes" <?= (!empty($category['is_active'])) ? 'checked' : '' ?> class="peer sr-only">
                        <div class="w-full text-center px-5 py-3 rounded-lg text-[13px] font-black text-slate-500 peer-checked:bg-white peer-checked:text-indigo-600 peer-checked:shadow-sm transition-all duration-300">PRODUKSI AKTIF (TAMPIL)</div>
                    </label>
                    <label class="relative flex-1 flex items-center justify-center cursor-pointer">
                        <input type="radio" name="active" value="No" <?= (empty($category['is_active'])) ? 'checked' : '' ?> class="peer sr-only">
                        <div class="w-full text-center px-5 py-3 rounded-lg text-[13px] font-black text-slate-500 peer-checked:bg-white peer-checked:text-rose-600 peer-checked:shadow-sm transition-all duration-300">SANDBOX (SEMBUNYIKAN)</div>
                    </label>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-3 mt-4">
                <a href="<?= BASEURL ?>/admin/categories" class="px-6 py-3 rounded-xl text-[14px] font-extrabold text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition-colors">Dibatalkan</a>
                <button type="submit" class="px-8 py-3 rounded-xl text-[14px] font-black text-white bg-indigo-600 hover:bg-indigo-700 shadow-[0_4px_12px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_16px_rgba(79,70,229,0.4)] hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-check"></i> Simpan Mutasi Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Auto-generate slug from category name
    const nameInput = document.querySelector('input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');
    
    // Auto-sync slug from title
    nameInput.addEventListener('input', function() {
        let slug = this.value.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        slugInput.value = slug;
    });

    slugInput.addEventListener('input', function() {
        this.value = this.value.toLowerCase()
            .replace(/[^a-z0-9-]/g, '')
            .replace(/-+/g, '-');
    });
</script>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
