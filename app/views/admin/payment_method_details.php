<?php 
$title = "Detail Metode Pembayaran";
ob_start();
?>
<!-- Premium Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL ?>/admin/paymentMethods" class="w-10 h-10 rounded-[14px] bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
        </a>
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Arsitektur Metode Pembayaran</h2>
            <p class="text-[13px] font-medium text-slate-500">Tinjauan komprehensif atas kanal pembayaran terdaftar</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden w-full relative mb-8">
    <!-- Structural Top Decoration -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>
    <div class="p-8 sm:p-10 space-y-8">
        <!-- Header: Icon + Name + Type -->
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-5">
                <?php if(!empty($method['icon'])): ?>
                    <div class="w-16 h-16 rounded-[16px] bg-slate-50 border border-slate-200/60 flex items-center justify-center overflow-hidden shadow-sm">
                        <img src="<?= BASEURL ?>/uploads/payment-methods/<?= htmlspecialchars($method['icon']) ?>" alt="<?= htmlspecialchars($method['name']) ?>" class="w-full h-full object-contain p-2">
                    </div>
                <?php else: ?>
                    <div class="w-16 h-16 rounded-[16px] bg-slate-100 border border-slate-200/60 flex items-center justify-center text-slate-400">
                        <i class="fas fa-<?= $method['type'] === 'e_wallet' ? 'wallet' : 'building-columns' ?> text-[24px]"></i>
                    </div>
                <?php endif; ?>
                <div>
                    <h4 class="text-3xl font-black text-slate-900 tracking-tight"><?= htmlspecialchars($method['name']) ?></h4>
                    <div class="flex items-center gap-3 mt-2">
                        <?php 
                            $typeLabel = $method['type'] === 'e_wallet' ? 'E-Wallet' : 'Bank Transfer';
                            $typeColor = $method['type'] === 'e_wallet' ? 'violet' : 'sky';
                            $typeIcon = $method['type'] === 'e_wallet' ? 'fas fa-wallet' : 'fas fa-building-columns';
                        ?>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-[11px] font-black uppercase tracking-wide bg-<?= $typeColor ?>-50 text-<?= $typeColor ?>-600 border border-<?= $typeColor ?>-200/60">
                            <i class="<?= $typeIcon ?> text-[10px]"></i> <?= $typeLabel ?>
                        </span>
                        <span class="text-[12px] font-bold text-slate-400">Urutan: #<?= htmlspecialchars($method['sort_order']) ?></span>
                    </div>
                </div>
            </div>
            <a href="<?= BASEURL ?>/admin/editPaymentMethod/<?= $method['id'] ?>" class="flex-shrink-0 w-10 h-10 rounded-[12px] bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors">
                <i class="fas fa-pen text-[14px]"></i>
            </a>
        </div>

        <!-- Account Info -->
        <div class="grid sm:grid-cols-2 gap-6 p-5 rounded-[16px] bg-slate-50/80 border border-slate-200/60">
            <div>
                <span class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Nomor Rekening / ID Akun</span>
                <span class="text-[18px] font-mono font-black text-slate-800 tracking-tight"><?= htmlspecialchars($method['account_number']) ?></span>
            </div>
            <div>
                <span class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Nama Pemilik Rekening</span>
                <span class="text-[18px] font-black text-slate-800"><?= htmlspecialchars($method['account_name']) ?></span>
            </div>
        </div>

        <!-- Status -->
        <div class="p-5 rounded-[16px] <?= (!empty($method['is_active'])) ? 'bg-emerald-50/50 border border-emerald-200/60' : 'bg-slate-50 border border-slate-200/60' ?> flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full flex items-center justify-center <?= (!empty($method['is_active'])) ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-200 text-slate-500' ?>">
                    <i class="fas <?= (!empty($method['is_active'])) ? 'fa-check' : 'fa-power-off' ?> text-[18px]"></i>
                </div>
                <div>
                    <span class="block text-[11px] font-black <?= (!empty($method['is_active'])) ? 'text-emerald-500' : 'text-slate-400' ?> uppercase tracking-widest mb-0.5">Status Operasional</span>
                    <span class="text-[14px] font-bold <?= (!empty($method['is_active'])) ? 'text-emerald-800' : 'text-slate-700' ?>">
                        <?= (!empty($method['is_active'])) ? 'Aktif (Ditampilkan di Checkout)' : 'Nonaktif (Disembunyikan dari Checkout)' ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <?php if(!empty($method['instructions'])): ?>
        <div>
            <h5 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3">Instruksi Pembayaran</h5>
            <div class="p-5 rounded-[16px] bg-amber-50/50 border border-amber-200/60">
                <p class="text-[14px] font-medium text-slate-700 leading-relaxed whitespace-pre-line"><?= htmlspecialchars($method['instructions']) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- System Info -->
        <div class="pt-6 border-t border-slate-100/80">
            <h5 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-4">Log Sistem Rekam Jejak</h5>
            <div class="grid sm:grid-cols-3 gap-6">
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">ID Referensi UID</span>
                    <span class="text-[13px] font-mono font-bold text-slate-800">#<?= htmlspecialchars($method['id']) ?></span>
                </div>
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">Waktu Penciptaan</span>
                    <span class="text-[13px] font-bold text-slate-800"><?= date('d M Y, H:i', strtotime($method['created_at'])) ?></span>
                </div>
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">Mutasi Terakhir</span>
                    <span class="text-[13px] font-bold text-slate-800"><?= date('d M Y, H:i', strtotime($method['updated_at'])) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
