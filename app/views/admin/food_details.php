<?php 
$title = "Detail Daftar Menu";
ob_start();
?>
<!-- Premium Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL ?>/admin/foods" class="w-10 h-10 rounded-[14px] bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
        </a>
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Inspeksi Inventaris</h2>
            <p class="text-[13px] font-medium text-slate-500">Tinjauan komprehensif atas detail item menu</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden w-full relative mb-8">
    <!-- Structural Top Decoration -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>
    <div class="p-8 sm:p-10">
        <div class="flex flex-col md:flex-row gap-10">
            <!-- Visual Section -->
            <div class="w-full md:w-1/3">
                <div class="aspect-square rounded-[20px] overflow-hidden bg-slate-50 border border-slate-200/60 shadow-inner group relative">
                    <img src="<?= BASEURL ?>/uploads/food/<?= htmlspecialchars($product['image']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($product['name']) ?>&background=random&color=fff'">
                    <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-[20px]"></div>
                </div>
                
                <div class="mt-6 flex flex-col gap-3">
                    <a href="<?= BASEURL ?>/admin/editFood/<?= urlencode($product['id']) ?>" class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl font-bold text-[13px] transition-colors">
                        <i class="fas fa-pen text-[14px]"></i> Edit Konfigurasi
                    </a>
                </div>
            </div>

            <!-- Content Section -->
            <div class="flex-1 space-y-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <?php if($product['is_active']): ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-emerald-50 text-emerald-600 ring-1 ring-inset ring-emerald-600/20 text-[11px] font-black tracking-wide">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                TERSEDIA PABRIK
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-rose-50 text-rose-600 ring-1 ring-inset ring-rose-600/20 text-[11px] font-black tracking-wide">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                DIARSIPKAN
                            </span>
                        <?php endif; ?>
                    </div>
                    <h4 class="text-3xl font-black text-slate-900 tracking-tight"><?= htmlspecialchars($product['name']) ?></h4>
                    <p class="text-indigo-600 font-mono font-bold text-[22px] tracking-tight mt-1">Rp <?= number_format($product['price'] ?? 0, 0, ',', '.') ?></p>
                </div>
                
                <div>
                    <h5 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3">Naskah Penjualan</h5>
                    <div class="p-6 bg-slate-50/50 rounded-[16px] border border-slate-100 flex items-start gap-4">
                        <i class="fas fa-quote-left text-[24px] text-slate-200"></i>
                        <p class="text-[14px] leading-relaxed text-slate-600 font-medium">
                            <?= nl2br(htmlspecialchars($product['description'])) ?>
                        </p>
                    </div>
                </div>

                <div>
                    <h5 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3">Metadata Klasifikasi</h5>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-indigo-50/30 p-4 rounded-xl border border-indigo-100/50 flex items-center gap-4 group hover:bg-indigo-50/80 transition-colors">
                            <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center shadow-sm text-indigo-500 group-hover:scale-110 transition-transform">
                                <i class="fas fa-folder-tree"></i>
                            </div>
                            <div>
                                <span class="block text-[11px] font-black text-indigo-400 uppercase tracking-widest mb-0.5">Kategori</span>
                                <span class="text-[14px] font-bold text-slate-800"><?= htmlspecialchars($product['category_name'] ?? 'Tidak ada') ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="pt-6 border-t border-slate-100/80">
                    <h5 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-4">Log Sistem Rekam Jejak</h5>
                    <div class="grid sm:grid-cols-3 gap-6">
                        <div>
                            <span class="block text-[12px] font-medium text-slate-500 mb-1">ID Referensi UID</span>
                            <span class="text-[13px] font-mono font-bold text-slate-800">#<?= htmlspecialchars($product['id']) ?></span>
                        </div>
                        <div>
                            <span class="block text-[12px] font-medium text-slate-500 mb-1">Waktu Penciptaan</span>
                            <span class="text-[13px] font-bold text-slate-800"><?= date('d M Y, H:i', strtotime($product['created_at'])) ?></span>
                        </div>
                        <div>
                            <span class="block text-[12px] font-medium text-slate-500 mb-1">Mutasi Terakhir</span>
                            <span class="text-[13px] font-bold text-slate-800"><?= date('d M Y, H:i', strtotime($product['updated_at'])) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
