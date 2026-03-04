<?php 
$title = "Detail Testimoni Pelanggan";
ob_start();
?>
<!-- Premium Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL ?>/admin/reviews" class="w-10 h-10 rounded-[14px] bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
        </a>
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Evaluasi Pelanggan</h2>
            <p class="text-[13px] font-medium text-slate-500">Analisis presisi terhadap pengalaman bertransaksi</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden w-full relative mb-8">
    <!-- Structural Top Decoration -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>
    <div class="p-8 sm:p-10 space-y-8">
        <div class="flex flex-col sm:flex-row justify-between sm:items-start gap-6 pb-8 border-b border-slate-100/80">
            <div class="flex items-start gap-5 flex-1">
                <div class="w-16 h-16 rounded-[16px] bg-indigo-50 text-indigo-600 flex items-center justify-center text-[24px] shadow-inner border border-indigo-100/60 shrink-0 font-black">
                    <i class="fas fa-user text-[20px]"></i>
                </div>
                <div>
                    <h4 class="text-[22px] font-black text-slate-900 tracking-tight leading-none mb-2">UID Pelanggan #<?= htmlspecialchars($review['user_id']) ?></h4>
                    <div class="flex items-center gap-2">
                        <span class="text-[12px] font-medium text-slate-500">Relevansi Pesanan:</span>
                        <a href="<?= BASEURL ?>/admin/orderDetails/<?= urlencode($review['order_id']) ?>" class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-50 hover:bg-indigo-50 border border-slate-200/60 hover:border-indigo-200 rounded-lg text-slate-600 hover:text-indigo-600 text-[12px] font-mono font-bold transition-colors">
                            <i class="fas fa-external-link-alt text-[10px]"></i> #<?= htmlspecialchars($review['order_id']) ?>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="bg-amber-50 px-5 py-3 rounded-[16px] border border-amber-200/60 shadow-sm flex items-center self-start sm:self-auto shrink-0">
                <span class="font-black text-amber-600 text-[24px] leading-none mr-3 tracking-tight"><?= number_format($review['rating'] ?? 0, 1) ?></span>
                <div class="flex text-amber-400 gap-0.5 mt-0.5">
                    <?php 
                        $rating = floor($review['rating'] ?? 0);
                        for($i = 0; $i < 5; $i++) {
                            if($i < $rating) echo '<i class="fas fa-star text-[14px]"></i>';
                            else echo '<i class="far fa-star text-[14px] text-amber-200"></i>';
                        }
                    ?>
                </div>
            </div>
        </div>
        
        <div>
            <h5 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-4">Naskah Asli Transkrip Evaluasi</h5>
            <div class="bg-slate-50/50 p-6 sm:p-8 rounded-[20px] border border-slate-200/60 relative">
                <i class="fas fa-quote-left absolute top-6 left-6 text-[32px] text-slate-200/70 pointer-events-none"></i>
                <div class="relative z-10 text-[15px] leading-relaxed text-slate-700 font-medium italic pl-10">
                    "<?= nl2br(htmlspecialchars($review['message'] ?? 'Tidak ada argumen tertulis. Hanya evaluasi metrik.')) ?>"
                </div>
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-2">
            <div class="flex items-center gap-4">
                <span class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em]">Visibilitas Sistem:</span>
                <?php 
                    $reviewStatus = $review['status'] ?? 'pending';
                    if ($reviewStatus === 'approved') {
                        echo '<span class="px-3 py-1.5 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200/60 font-bold text-[12px] flex items-center gap-1.5"><i class="fas fa-globe-americas"></i> Publik (Tampil)</span>';
                    } elseif ($reviewStatus === 'rejected') {
                        echo '<span class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 border border-red-200/60 font-bold text-[12px] flex items-center gap-1.5"><i class="fas fa-times-circle text-red-400"></i> Ditolak</span>';
                    } else {
                        echo '<span class="px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 border border-amber-200/60 font-bold text-[12px] flex items-center gap-1.5"><i class="fas fa-clock text-amber-500"></i> Menunggu Review</span>';
                    }
                ?>
            </div>
        </div>
        
        <div class="pt-6 border-t border-slate-100/80 mt-8">
            <h5 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.15em] mb-4">Log Sistem Rekam Jejak</h5>
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">ID Referensi UID</span>
                    <span class="text-[13px] font-mono font-bold text-slate-800">#<?= htmlspecialchars($review['id']) ?></span>
                </div>
                <div>
                    <span class="block text-[12px] font-medium text-slate-500 mb-1">Waktu Transmisi Sinkronisasi</span>
                    <span class="text-[13px] font-bold text-slate-800"><?= date('d M Y, H:i', strtotime($review['created_at'])) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
