<?php 
$title = "Detail Admin Internal";
ob_start();
?>
<!-- Premium Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL ?>/admin/admins" class="w-10 h-10 rounded-[14px] bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
        </a>
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Profil Administrator</h2>
            <p class="text-[13px] font-medium text-slate-500">Tinjauan komprehensif atas identitas akun internal</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden w-full relative mb-8">
    <!-- Structural Top Decoration -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>
    <div class="p-8 sm:p-10 space-y-8">
        <div class="flex items-center gap-6 pb-8 border-b border-slate-100/80">
            <div class="w-24 h-24 rounded-[20px] bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-[32px] font-black shadow-[0_8px_24px_-8px_rgba(99,102,241,0.5)] border-2 border-white ring-4 ring-indigo-50/50">
                <?= strtoupper(substr($admin['full_name'], 0, 1)) ?>
            </div>
            <div>
                <h4 class="text-[28px] font-black text-slate-900 tracking-tight leading-none mb-2"><?= htmlspecialchars($admin['full_name']) ?></h4>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-1 bg-slate-100 rounded-md font-mono text-[13px] font-bold text-slate-600 border border-slate-200/60">
                        @<?= htmlspecialchars($admin['username']) ?>
                    </span>
                </div>
            </div>
            
            <a href="<?= BASEURL ?>/admin/editAdmin/<?= urlencode($admin['id']) ?>" class="ml-auto flex-shrink-0 w-10 h-10 rounded-[12px] bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors">
                <i class="fas fa-pen text-[14px]"></i>
            </a>
        </div>
        
        <?php if($admin['id'] == $_SESSION['user_id']): ?>
        <div class="p-5 rounded-[16px] bg-emerald-50/50 border border-emerald-200/60 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-emerald-100 text-emerald-600">
                <i class="fas fa-shield-check text-[18px]"></i>
            </div>
            <div>
                <p class="text-[14px] font-bold text-emerald-800">Sesi Profil Identik</p>
                <p class="text-[13px] font-medium text-emerald-600/80 mt-0.5">Anda sedang memanajemen sistem melalui akses otorisasi ini.</p>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="pt-2">
            <h5 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-4">Log Sistem Rekam Jejak</h5>
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">ID Referensi UID</span>
                    <span class="text-[13px] font-mono font-bold text-slate-800">#<?= htmlspecialchars($admin['id']) ?></span>
                </div>
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">Waktu Inisiasi Akun</span>
                    <span class="text-[13px] font-bold text-slate-800"><?= date('d M Y, H:i', strtotime($admin['created_at'])) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
