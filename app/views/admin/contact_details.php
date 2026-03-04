<?php 
$title = "Detail Pesan Pelanggan";
ob_start();
?>
<!-- Premium Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL ?>/admin/contacts" class="w-10 h-10 rounded-[14px] bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
        </a>
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Tiket Surat Menyurat</h2>
            <p class="text-[13px] font-medium text-slate-500">Transkrip lengkap pesan dari saluran dukungan internal</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden w-full relative mb-8">
    <!-- Structural Top Decoration -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>
    <div class="p-8 sm:p-10 space-y-8">
        <div class="flex items-start gap-4 pb-8 border-b border-slate-100/80">
            <div class="w-14 h-14 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-[22px] shadow-inner border border-indigo-100/60 font-black">
                <?= strtoupper(substr($contact['name'], 0, 1)) ?>
            </div>
            <div>
                <h4 class="text-[20px] font-black text-slate-900 tracking-tight leading-none mb-1.5"><?= htmlspecialchars($contact['name']) ?></h4>
                <a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="text-[13px] font-medium text-slate-500 hover:text-indigo-600 transition-colors flex items-center gap-1.5">
                    <i class="fas fa-envelope text-slate-400"></i> <?= htmlspecialchars($contact['email']) ?>
                </a>
            </div>
            
            <a href="mailto:<?= htmlspecialchars($contact['email']) ?>" class="ml-auto flex items-center gap-2 px-4 py-2 bg-slate-50 text-slate-600 hover:bg-slate-100 hover:text-slate-800 rounded-xl text-[13px] font-bold transition-colors border border-slate-200/60">
                <i class="fas fa-reply"></i> Balas Surel
            </a>
        </div>
        
        <!-- Naskah Transkrip -->
        <div>
            <h5 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-4">Naskah Asli Transkrip</h5>
            <div class="bg-slate-50/50 p-6 sm:p-8 rounded-[20px] border border-slate-200/60 relative">
                <i class="fas fa-quote-left absolute top-6 left-6 text-[32px] text-slate-100 pointer-events-none"></i>
                <div class="relative z-10 text-[14px] leading-relaxed text-slate-700 font-medium">
                    <?= nl2br(htmlspecialchars($contact['message'])) ?>
                </div>
            </div>
        </div>
        
        <div class="pt-6 border-t border-slate-100/80 mt-8">
            <h5 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-4">Log Sistem Rekam Jejak</h5>
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">ID Referensi UID</span>
                    <span class="text-[13px] font-mono font-bold text-slate-800">#<?= htmlspecialchars($contact['id']) ?></span>
                </div>
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">Tanggal Transmisi Diterima</span>
                    <span class="text-[13px] font-bold text-slate-800"><?= date('d M Y, H:i', strtotime($contact['created_at'])) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
