<?php 
$title = "Detail Kategori Menu";
ob_start();
?>
<!-- Premium Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL ?>/admin/categories" class="w-10 h-10 rounded-[14px] bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
        </a>
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Arsitektur Kategori</h2>
            <p class="text-[13px] font-medium text-slate-500">Tinjauan komprehensif atas pengelompokan menu bisnis</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden w-full relative mb-8">
    <!-- Structural Top Decoration -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>
    <div class="p-8 sm:p-10 space-y-8">
        <div class="flex items-start justify-between">
            <div>
                <h4 class="text-3xl font-black text-slate-900 tracking-tight md:mr-4"><?= htmlspecialchars($category['name']) ?></h4>
                <div class="flex items-center gap-3 mt-3">
                    <div class="px-3 py-1 bg-slate-100 rounded-md font-mono text-[13px] font-bold text-slate-600 flex items-center gap-2 border border-slate-200/60">
                        <i class="fas fa-link text-slate-400"></i> /kategori/<?= htmlspecialchars($category['slug']) ?>
                    </div>
                </div>
            </div>
            <a href="<?= BASEURL ?>/admin/categories?edit=<?= $category['id'] ?>" class="flex-shrink-0 w-10 h-10 rounded-[12px] bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors">
                <i class="fas fa-pen text-[14px]"></i>
            </a>
        </div>
        
        <div class="p-5 rounded-[16px] <?= (!empty($category['is_active'])) ? 'bg-emerald-50/50 border border-emerald-200/60' : 'bg-slate-50 border border-slate-200/60' ?> flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center <?= (!empty($category['is_active'])) ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-200 text-slate-500' ?>">
                    <i class="fas <?= (!empty($category['is_active'])) ? 'fa-check' : 'fa-power-off' ?> text-[18px]"></i>
                </div>
                <div>
                    <span class="block text-[11px] font-black <?= (!empty($category['is_active'])) ? 'text-emerald-500' : 'text-slate-400' ?> uppercase tracking-widest mb-0.5">Siklus Hidup (Lifecycle)</span>
                    <span class="text-[14px] font-bold <?= (!empty($category['is_active'])) ? 'text-emerald-800' : 'text-slate-700' ?>">
                        <?= (!empty($category['is_active'])) ? 'Produksi Aktif (Tampil di Katalog)' : 'Sandbox (Diarsipkan/Disembunyikan)' ?>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="pt-6 border-t border-slate-100/80">
            <h5 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-4">Log Sistem Rekam Jejak</h5>
            <div class="grid sm:grid-cols-3 gap-6">
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">ID Referensi UID</span>
                    <span class="text-[13px] font-mono font-bold text-slate-800">#<?= htmlspecialchars($category['id']) ?></span>
                </div>
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">Waktu Penciptaan</span>
                    <span class="text-[13px] font-bold text-slate-800"><?= date('d M Y, H:i', strtotime($category['created_at'])) ?></span>
                </div>
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">Mutasi Terakhir</span>
                    <span class="text-[13px] font-bold text-slate-800"><?= date('d M Y, H:i', strtotime($category['updated_at'])) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
