<?php 
$title = "Detail Pelanggan Perusahaan";
ob_start();
?>
<!-- Premium Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL ?>/admin/users" class="w-10 h-10 rounded-[14px] bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
        </a>
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Inspeksi Identitas Pelanggan</h2>
            <p class="text-[13px] font-medium text-slate-500">Profil komprehensif dan metrik interaksi akun</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden w-full relative mb-8">
    <!-- Structural Top Decoration -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>
    <div class="p-8 sm:p-10">
        <div class="flex flex-col md:flex-row gap-8 items-center md:items-start text-center md:text-left pb-8 border-b border-slate-100/80">
            <div class="relative">
                <img src="<?= BASEURL ?>/uploads/users/<?= htmlspecialchars($client['img_user'] ?? 'default.jpg') ?>" class="w-32 h-32 rounded-[24px] border border-slate-200/60 shadow-[0_8px_24px_-8px_rgba(0,0,0,0.15)] object-cover ring-4 ring-slate-50" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($client['username']) ?>&background=random&color=fff'">
            </div>
            
            <div class="flex-1 w-full space-y-6">
                <div>
                    <h4 class="text-[32px] font-black text-slate-900 tracking-tight leading-none mb-2"><?= htmlspecialchars($client['username']) ?></h4>
                    <p class="text-indigo-600 font-bold text-[15px]"><?= htmlspecialchars($client['email']) ?></p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                    <div class="bg-slate-50/50 p-5 rounded-[16px] border border-slate-200/60 flex items-center gap-4 hover:bg-slate-50 transition-colors group">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-[20px] shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="text-left">
                            <span class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Total Pesanan</span>
                            <span class="font-black text-slate-900 text-[24px] tracking-tight leading-none flex items-baseline gap-1.5">
                                <?= (int)($client['total_orders'] ?? 0) ?>
                                <span class="text-[12px] font-bold text-slate-400">transaksi</span>
                            </span>
                        </div>
                    </div>
                    <div class="bg-emerald-50/30 p-5 rounded-[16px] border border-emerald-100/60 flex items-center gap-4 hover:bg-emerald-50/80 transition-colors group">
                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-[20px] shadow-sm group-hover:scale-110 transition-transform">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="text-left">
                            <span class="block text-[11px] font-black text-emerald-500 uppercase tracking-widest mb-0.5">Durasi Keanggotaan</span>
                            <span class="font-bold text-emerald-800 text-[16px] tracking-tight">Sejak <?= date('M Y', strtotime($client['created_at'])) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="pt-8">
            <h5 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-4">Log Sistem Rekam Jejak</h5>
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">ID Referensi UID</span>
                    <span class="text-[13px] font-mono font-bold text-slate-800">#<?= htmlspecialchars($client['id']) ?></span>
                </div>
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">Waktu Inisiasi Akun</span>
                    <span class="text-[13px] font-bold text-slate-800"><?= date('d M Y, H:i', strtotime($client['created_at'])) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
