<?php 
$title = "Detail Pesanan #" . htmlspecialchars($order['order_number'] ?? substr($order['id'] ?? '', 0, 8));
ob_start();

$statusLabels = [
    'pending_payment' => 'Menunggu Pembayaran',
    'confirmed' => 'Dikonfirmasi',
    'processing' => 'Sedang Diproses',
    'delivering' => 'Dalam Pengiriman',
    'finished' => 'Selesai',
    'cancelled' => 'Dibatalkan'
];
$statusStyles = [
    'pending_payment' => 'bg-amber-50 text-amber-700 border border-amber-200/60 ring-1 ring-amber-100',
    'confirmed' => 'bg-indigo-50 text-indigo-700 border border-indigo-200/60 ring-1 ring-indigo-100',
    'processing' => 'bg-violet-50 text-violet-700 border border-violet-200/60 ring-1 ring-violet-100',
    'delivering' => 'bg-sky-50 text-sky-700 border border-sky-200/60 ring-1 ring-sky-100',
    'finished' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/60 ring-1 ring-emerald-100',
    'cancelled' => 'bg-rose-50 text-rose-700 border border-rose-200/60 ring-1 ring-rose-100',
];
$statusIcons = [
    'pending_payment' => 'fa-clock',
    'confirmed' => 'fa-check-double',
    'processing' => 'fa-cog',
    'delivering' => 'fa-truck-fast',
    'finished' => 'fa-flag-checkered',
    'cancelled' => 'fa-xmark',
];
?>

<div class="bg-slate-50 min-h-screen" x-data="{ showImageModal: false }">
    <div class="w-full mx-auto">
        
        <style>
            @media print {
                body { background-color: white !important; }
                .no-print { display: none !important; }
                .print-only { display: block !important; }
                .shadow-sm, .shadow-md, .shadow-lg, .shadow-\[.*\] { box-shadow: none !important; }
                .rounded-\[24px\], .rounded-\[16px\], .rounded-xl, .rounded-3xl, .rounded-2xl { border-radius: 0 !important; }
                .border, .border-slate-100, .border-slate-200 { border-color: #000 !important; }
                * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            }
        </style>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 no-print">
            <div class="flex items-center gap-4">
                <a href="<?= BASEURL ?>/admin/orders" class="w-10 h-10 bg-white rounded-[14px] flex items-center justify-center text-slate-500 shadow-sm border border-slate-200/60 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
                </a>
                <div>
                    <h1 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Inspeksi Transaksi</h1>
                    <p class="text-[13px] font-medium text-slate-500">Logistik pesanan pelanggan secara terperinci</p>
                </div>
            </div>
            <button onclick="window.print()" class="px-5 py-2.5 bg-slate-800 text-white text-[13px] font-bold rounded-xl shadow-md hover:bg-slate-900 transition-colors flex items-center justify-center gap-2">
                <i class="fas fa-print"></i> Cetak Rekapitulasi
            </button>
        </div>

        <div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden mb-8 relative">
            
            <!-- Structural Top Decoration -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>

            <!-- Header Panel -->
            <div class="bg-slate-50/50 p-8 sm:px-10 border-b border-slate-100/80 flex flex-col md:flex-row justify-between md:items-end gap-8 relative overflow-hidden pt-10">
                <div class="relative z-10 w-full md:w-auto">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-1.5">
                        <i class="fas fa-fingerprint text-slate-300"></i> Nomor Pesanan
                    </p>
                    <div class="flex flex-col lg:flex-row lg:items-center gap-5">
                        <h2 class="text-[36px] font-black text-slate-900 font-mono tracking-tight leading-none">
                            <?= htmlspecialchars($order['order_number'] ?? substr($order['id'], 0, 8)) ?>
                        </h2>
                        <span class="inline-flex items-center gap-1.5 <?= $statusStyles[$order['status']] ?? 'bg-slate-50 text-slate-600 border border-slate-200 ring-1 ring-slate-100' ?> px-3.5 py-1.5 rounded-lg text-[12px] font-bold self-start mt-2 lg:mt-0">
                            <i class="fas <?= $statusIcons[$order['status']] ?? 'fa-circle-question' ?> text-[10px]"></i>
                            <?= htmlspecialchars($statusLabels[$order['status']] ?? $order['status']) ?>
                        </span>
                    </div>
                </div>

                <!-- Form Mutasi Status -->
                <?php if (!in_array($order['status'], ['finished', 'cancelled'])): ?>
                <div class="relative z-10 w-full md:w-auto no-print">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2.5 text-left md:text-right">Ubah Status Pesanan</p>
                    <form action="<?= BASEURL ?>/admin/updateOrderStatus/<?= urlencode($order['id']) ?>" method="POST" class="flex flex-col sm:flex-row gap-2 bg-white p-2 rounded-xl border border-slate-200/60 shadow-sm">
                        <?= CSRF::getTokenField() ?>
                        <div class="relative flex-1">
                            <select name="status" class="w-full sm:w-[240px] text-[13px] font-bold text-slate-700 border-0 bg-slate-50 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition-all appearance-none cursor-pointer">
                                <option value="confirmed" <?= ($order['status'] == 'confirmed') ? 'selected' : '' ?>>Dikonfirmasi</option>
                                <option value="processing" <?= ($order['status'] == 'processing') ? 'selected' : '' ?>>Sedang Diproses</option>
                                <option value="delivering" <?= ($order['status'] == 'delivering') ? 'selected' : '' ?>>Dalam Pengiriman</option>
                                <option value="finished" <?= ($order['status'] == 'finished') ? 'selected' : '' ?>>Selesai</option>
                                <option value="cancelled">Batalkan secara paksa</option>
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] pointer-events-none"></i>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white text-[13px] px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-black shadow-[0_2px_8px_rgba(79,70,229,0.3)] hover:shadow-[0_4px_12px_rgba(79,70,229,0.4)] whitespace-nowrap">
                            Terapkan
                        </button>
                    </form>
                </div>
                <?php endif; ?>
            </div>

            <div class="px-8 sm:px-10 pt-10 pb-6">
                <!-- Metadata Info -->
                <div class="mb-10 grid grid-cols-1 md:grid-cols-2 gap-6 relative">
                    <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-px bg-slate-100/80 -translate-x-1/2"></div>
                    
                    <div>
                        <h3 class="text-[14px] font-black text-slate-900 mb-6 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-indigo-50/50 flex items-center justify-center text-indigo-500 ring-1 ring-inset ring-indigo-100"><i class="fas fa-user text-[13px]"></i></span>
                            Identitas Pemesan
                        </h3>
                        <div class="space-y-5 pl-10 text-[13px]">
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Akun Pelanggan</p>
                                <div class="flex items-center gap-4 bg-white p-3 rounded-xl border border-slate-100 shadow-sm">
                                    <div class="w-10 h-10 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-500 font-bold shrink-0">
                                        <i class="fas fa-user-circle text-[16px]"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-[14px] leading-tight mb-0.5">
                                            <?= htmlspecialchars($order['customer_name'] ?? $order['username'] ?? 'Pelanggan') ?>
                                        </p>
                                        <p class="text-[12px] font-medium text-slate-500 font-mono">
                                            <?= htmlspecialchars($order['email'] ?? 'Tidak ada email') ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Alamat Pengiriman</p>
                                <div class="flex gap-3 text-slate-700 leading-relaxed bg-slate-50/50 p-4 rounded-xl border border-slate-100/80">
                                    <i class="fas fa-map-marker-alt text-slate-400 mt-1"></i>
                                    <p class="font-medium">
                                        <?= htmlspecialchars($order['shipping_address'] ?? 'Belum ditentukan') ?>
                                    </p>
                                </div>
                            </div>

                            <?php if (!empty($order['notes'])): ?>
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Catatan Pelanggan</p>
                                <div class="flex gap-3 text-slate-700 leading-relaxed bg-amber-50/50 p-4 rounded-xl border border-amber-100/80">
                                    <i class="fas fa-sticky-note text-amber-400 mt-1"></i>
                                    <p class="font-medium"><?= htmlspecialchars($order['notes']) ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="md:pl-6">
                        <h3 class="text-[14px] font-black text-slate-900 mb-6 flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-500 ring-1 ring-inset ring-slate-200/60"><i class="fas fa-clock text-[13px]"></i></span>
                            Kronologi Timestamp
                        </h3>
                        <div class="space-y-4 pl-10 text-[13px]">
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Pesanan Dibuat</p>
                                <div class="flex items-center gap-3 text-slate-700 leading-relaxed bg-slate-50/50 p-4 rounded-xl border border-slate-100/80">
                                    <i class="fas fa-calendar-check text-slate-400"></i>
                                    <p class="font-medium"><?= date('d M Y - H:i', strtotime($order['created_at'])) ?></p>
                                </div>
                            </div>
                            <?php if(!empty($order['confirmed_at'])): ?>
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Dikonfirmasi</p>
                                <div class="flex items-center gap-3 text-slate-700 leading-relaxed bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
                                    <i class="fas fa-check-double text-indigo-400"></i>
                                    <p class="font-medium"><?= date('d M Y - H:i', strtotime($order['confirmed_at'])) ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if(!empty($order['delivering_at'])): ?>
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Dikirim</p>
                                <div class="flex items-center gap-3 text-slate-700 leading-relaxed bg-white p-4 rounded-xl border border-slate-100 shadow-sm">
                                    <i class="fas fa-truck-fast text-sky-400"></i>
                                    <p class="font-medium"><?= date('d M Y - H:i', strtotime($order['delivering_at'])) ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php if(!empty($order['finished_at'])): ?>
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Selesai</p>
                                <div class="flex items-center gap-3 text-slate-700 leading-relaxed bg-emerald-50 p-4 rounded-xl border border-emerald-100 shadow-sm">
                                    <i class="fas fa-flag-checkered text-emerald-400"></i>
                                    <p class="font-medium"><?= date('d M Y - H:i', strtotime($order['finished_at'])) ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Invoice Content -->
                <div class="mb-8">
                    <h3 class="text-[14px] font-black text-slate-900 mb-5 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-indigo-50/50 flex items-center justify-center text-indigo-500 ring-1 ring-inset ring-indigo-100"><i class="fas fa-box-open text-[13px]"></i></span>
                        Rincian Pesanan
                    </h3>
                    
                    <?php if(!empty($details)): ?>
                    <div class="border border-slate-200/60 rounded-2xl overflow-hidden shadow-sm bg-white">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-indigo-50/50 border-b border-slate-200/60 text-[11px] font-black tracking-widest text-slate-500 uppercase">
                                    <th class="py-4 px-6 w-1/2">Menu</th>
                                    <th class="py-4 px-6 text-right hidden lg:table-cell w-1/4">Harga Satuan</th>
                                    <th class="py-4 px-6 text-right w-1/4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100/80">
                                <?php foreach($details as $item): ?>
                                <tr class="group hover:bg-slate-50/50 transition-colors">
                                    <td class="py-5 px-6 align-top">
                                        <div class="flex items-center gap-5">
                                            <div class="w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 bg-slate-50 flex items-center justify-center border border-slate-200/60 relative">
                                                <?php if(!empty($item['image'])): ?>
                                                    <img src="<?= BASEURL ?>/uploads/food/<?= htmlspecialchars($item['image']) ?>" class="w-full h-full object-cover" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($item['food_name'] ?? 'Menu') ?>&background=random&color=fff'">
                                                <?php else: ?>
                                                    <i class="fas fa-utensils text-slate-300 text-[20px]"></i>
                                                <?php endif; ?>
                                                
                                                <div class="absolute -top-2 -right-2 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-[10px] font-black border-[3px] border-white shadow-sm z-10">
                                                    <?= htmlspecialchars($item['qty'] ?? 1) ?>
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="font-extrabold text-slate-900 text-[15px] leading-tight mb-1"><?= htmlspecialchars($item['food_name'] ?? 'Item') ?></h4>
                                                <div class="lg:hidden mt-0.5 text-[13px] font-bold text-slate-500">
                                                    Rp <?= number_format($item['unit_price'] ?? 0, 0, ',', '.') ?> &times; <?= htmlspecialchars($item['qty'] ?? 1) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-5 px-6 align-middle text-right text-[14px] font-semibold text-slate-500 hidden lg:table-cell">
                                        Rp <?= number_format($item['unit_price'] ?? 0, 0, ',', '.') ?>
                                        <span class="text-[11px] text-slate-400 font-bold block mt-1">x <?= htmlspecialchars($item['qty'] ?? 1) ?> unit</span>
                                    </td>
                                    <td class="py-5 px-6 align-middle text-right">
                                        <span class="text-[15px] font-black text-slate-900 bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                                            Rp <?= number_format($item['subtotal'] ?? (($item['unit_price'] ?? 0) * ($item['qty'] ?? 1)), 0, ',', '.') ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-10 bg-slate-50/50 rounded-[16px] border border-slate-200/60 border-dashed">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm border border-slate-100 mx-auto mb-3 text-slate-300">
                            <i class="fas fa-ghost text-[20px]"></i>
                        </div>
                        <p class="text-[13px] font-bold text-slate-500">Tidak ada detail pesanan.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Payment Summary -->
            <?php if(!empty($details)): ?>
            <div class="p-8 sm:px-10 border-t border-slate-200/60 bg-slate-50/50 flex justify-end">
                <div class="w-full max-w-sm bg-indigo-900 rounded-2xl p-6 sm:p-8 text-white shadow-xl shadow-indigo-900/20 relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-500 rounded-full blur-3xl opacity-20 pointer-events-none"></div>
                    
                    <div class="relative z-10 text-[13px]">
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-medium text-indigo-200">Subtotal</span>
                            <span class="font-mono font-bold tracking-tight">Rp <?= number_format($order['subtotal'] ?? 0, 0, ',', '.') ?></span>
                        </div>
                        <div class="flex justify-between items-center mb-3">
                            <span class="font-medium text-indigo-200">Pajak (PPN 10%)</span>
                            <span class="font-mono font-bold tracking-tight">Rp <?= number_format($order['tax_amount'] ?? 0, 0, ',', '.') ?></span>
                        </div>
                        <div class="flex justify-between items-center mb-6">
                            <span class="font-medium text-indigo-200">Ongkos Kirim</span>
                            <span class="font-mono font-bold tracking-tight">Rp <?= number_format($order['shipping_cost'] ?? 0, 0, ',', '.') ?></span>
                        </div>
                        <div class="flex flex-col gap-1 pt-5 border-t border-indigo-700/60 mt-2">
                            <span class="text-[11px] font-black text-indigo-300 uppercase tracking-widest text-right">Grand Total</span>
                            <span class="text-[32px] font-black text-white font-mono tracking-tight leading-none text-right drop-shadow-sm">Rp <?= number_format($order['grand_total'] ?? 0, 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Payment Proof -->
            <div class="no-print">
                <?php if(isset($payment) && !empty($payment['proof_image'])): ?>
                <div class="bg-slate-50/50 p-8 sm:px-10 border-t border-slate-200/60">
                    <h3 class="text-[14px] font-black text-slate-900 mb-6 flex items-center gap-2">
                        <span class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-500 ring-1 ring-inset ring-emerald-200/60"><i class="fas fa-file-invoice-dollar text-[13px]"></i></span>
                        Bukti Pembayaran
                    </h3>
                    <div class="flex flex-col md:flex-row gap-8 items-start">
                        <div class="w-full md:w-1/3 xl:w-1/4 shrink-0 bg-white p-2.5 rounded-2xl border border-slate-200/80 shadow-sm relative group overflow-hidden cursor-pointer" @click="showImageModal = true">
                            <div class="aspect-[4/3] w-full relative overflow-hidden rounded-xl bg-slate-100 flex items-center justify-center">
                                <img src="<?= BASEURL ?>/uploads/payment/<?= htmlspecialchars($payment['proof_image']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" onerror="this.src='https://ui-avatars.com/api/?name=Bukti+Hilang&background=f1f5f9&color=475569'">
                                <div class="absolute inset-0 bg-indigo-900/0 group-hover:bg-indigo-900/10 transition-colors pointer-events-none flex items-center justify-center">
                                    <div class="w-12 h-12 bg-white/95 rounded-full flex items-center justify-center text-indigo-600 shadow-xl opacity-0 scale-75 group-hover:opacity-100 group-hover:scale-100 transition-all duration-300">
                                        <i class="fas fa-search-plus text-[16px]"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center text-[11px] font-bold text-slate-400 mt-3 mb-1 uppercase tracking-widest group-hover:text-indigo-500 transition-colors">Perbesar Gambar</p>
                        </div>
                        <div class="flex-1 w-full grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-500 flex items-center justify-center mb-4">
                                    <i class="fas fa-university"></i>
                                </div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Metode Pembayaran</p>
                                <p class="text-[15px] font-black text-slate-800"><?= htmlspecialchars($payment['payment_method_name'] ?? 'Transfer Bank') ?></p>
                            </div>
                            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center mb-4">
                                    <i class="fas fa-id-card"></i>
                                </div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama Pengirim</p>
                                <p class="text-[15px] font-black text-slate-800 truncate" title="<?= htmlspecialchars($payment['sender_name'] ?? '') ?>">
                                    <?= htmlspecialchars($payment['sender_name'] ?? 'Anonim') ?>
                                </p>
                            </div>
                            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm sm:col-span-2 lg:col-span-1">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-500 flex items-center justify-center mb-4">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Transfer</p>
                                <p class="text-[15px] font-black text-slate-800">
                                    <?= !empty($payment['payment_date']) && $payment['payment_date'] !== '0000-00-00' ? date('d F Y', strtotime($payment['payment_date'])) : 'Tidak tersedia' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="bg-amber-50/50 p-6 sm:p-8 border-t border-amber-200/60 flex items-start sm:items-center gap-4 text-amber-800">
                    <div class="w-12 h-12 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center shrink-0">
                        <i class="fas fa-triangle-exclamation text-[18px]"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-[14px] mb-1">Bukti Pembayaran Belum Ada</h4>
                        <p class="text-[13px] font-medium opacity-80 leading-relaxed">Pelanggan belum mengunggah bukti pembayaran. Jangan lakukan konfirmasi sebelum bukti diterima.</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>

        </div>
        
        <!-- Image Popup Modal -->
        <?php if(isset($payment) && !empty($payment['proof_image'])): ?>
        <div x-show="showImageModal" style="display: none;" class="fixed inset-0 z-[110] flex items-center justify-center backdrop-blur-md bg-slate-900/90" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <button @click="showImageModal = false" type="button" class="absolute top-6 right-6 w-12 h-12 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors backdrop-blur-lg z-10 focus:outline-none focus:ring-2 focus:ring-white/50">
                <i class="fas fa-times text-xl"></i>
            </button>
            <div @click.outside="showImageModal = false" class="relative max-w-[95vw] max-h-[90vh] flex items-center justify-center overflow-hidden p-4 sm:p-8" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                <img src="<?= BASEURL ?>/uploads/payment/<?= htmlspecialchars($payment['proof_image']) ?>" class="max-w-full max-h-[90vh] object-contain rounded-2xl shadow-2xl ring-1 ring-white/10" alt="Bukti Pembayaran">
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
