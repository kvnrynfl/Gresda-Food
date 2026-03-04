<?php 
$title = "Tambah Metode Pembayaran";
ob_start();
?>

<!-- Premium Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL ?>/admin/paymentMethods" class="w-10 h-10 rounded-[14px] bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
        </a>
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Tambah Metode Pembayaran</h2>
            <p class="text-[13px] font-medium text-slate-500">Registrasi kanal pembayaran baru untuk pelanggan</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden w-full relative mb-8">
    <!-- Structural Top Decoration -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>
    <div class="p-8 sm:p-10">
        <form action="<?= BASEURL ?>/admin/createPaymentMethod" method="POST" enctype="multipart/form-data" class="space-y-8">
            <?= CSRF::getTokenField() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <?php 
                        $props = [
                            'name' => 'name',
                            'label' => 'Nama Metode Pembayaran',
                            'placeholder' => 'misal: Bank BCA, Dana, GoPay',
                            'required' => true
                        ];
                        include __DIR__ . '/../components/ui/input.php';
                    ?>
                    <p class="text-[12px] font-medium text-slate-400 -mt-3 mb-6 flex items-center gap-1.5"><i class="fas fa-circle-info text-slate-300"></i> Nama ini akan ditampilkan kepada pelanggan saat checkout.</p>
                </div>
                <div>
                    <label class="block text-[13px] font-black text-slate-800 mb-2.5 uppercase tracking-wide">Tipe Pembayaran</label>
                    <div class="flex gap-4 p-1.5 bg-slate-100 rounded-xl border border-slate-200/60 p-1">
                        <label class="relative flex-1 flex items-center justify-center cursor-pointer">
                            <input type="radio" name="type" value="bank_transfer" checked class="peer sr-only">
                            <div class="w-full text-center px-5 py-3 rounded-lg text-[13px] font-black text-slate-500 peer-checked:bg-white peer-checked:text-indigo-600 peer-checked:shadow-sm transition-all duration-300 flex items-center justify-center gap-2">
                                <i class="fas fa-building-columns text-[12px]"></i> BANK TRANSFER
                            </div>
                        </label>
                        <label class="relative flex-1 flex items-center justify-center cursor-pointer">
                            <input type="radio" name="type" value="e_wallet" class="peer sr-only">
                            <div class="w-full text-center px-5 py-3 rounded-lg text-[13px] font-black text-slate-500 peer-checked:bg-white peer-checked:text-violet-600 peer-checked:shadow-sm transition-all duration-300 flex items-center justify-center gap-2">
                                <i class="fas fa-wallet text-[12px]"></i> E-WALLET
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <?php 
                        $props = [
                            'name' => 'account_number',
                            'label' => 'Nomor Rekening / ID Akun',
                            'placeholder' => 'misal: 1234567890',
                            'icon' => 'fas fa-hashtag',
                            'class' => 'font-mono text-[14px] tracking-tight',
                            'required' => true
                        ];
                        include __DIR__ . '/../components/ui/input.php';
                    ?>
                </div>
                <div>
                    <?php 
                        $props = [
                            'name' => 'account_name',
                            'label' => 'Nama Pemilik Rekening',
                            'placeholder' => 'misal: Gresda Food',
                            'icon' => 'fas fa-user',
                            'required' => true
                        ];
                        include __DIR__ . '/../components/ui/input.php';
                    ?>
                </div>
            </div>

            <div>
                <label class="block text-[13px] font-black text-slate-800 mb-2.5 uppercase tracking-wide">Instruksi Pembayaran (Opsional)</label>
                <textarea name="instructions" rows="4" class="w-full px-5 py-3.5 bg-slate-50/50 border border-slate-200/80 rounded-xl text-slate-900 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder-slate-400 font-medium text-[14px] hover:bg-white leading-relaxed resize-none" placeholder="Tulis panduan langkah-langkah pembayaran untuk pelanggan..."></textarea>
                <p class="text-[12px] font-medium text-slate-400 mt-2 flex items-center gap-1.5"><i class="fas fa-circle-info text-slate-300"></i> Instruksi ini akan ditampilkan saat pelanggan memilih metode pembayaran ini.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                <div>
                    <label class="block text-[13px] font-black text-slate-800 mb-2.5 uppercase tracking-wide">Ikon Metode (Opsional)</label>
                    <div class="flex flex-col gap-4">
                        <div class="w-24 h-24 rounded-[16px] bg-slate-50 border-2 border-dashed border-slate-300 flex items-center justify-center text-slate-400 overflow-hidden shadow-sm relative group cursor-pointer transition-colors hover:border-indigo-400 hover:bg-indigo-50/50" onclick="document.getElementById('iconInput').click()">
                            <span id="previewPlaceholder" class="flex flex-col items-center gap-1 group-hover:text-indigo-500 transition-colors">
                                <i class="fas fa-credit-card text-[22px]"></i>
                            </span>
                            <div id="iconPreviewContainer" class="absolute inset-0 z-10 hidden"></div>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="icon" id="iconInput" accept="image/*" class="w-full text-[13px] font-bold text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-[13px] file:font-black file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition-colors cursor-pointer outline-none">
                            <p class="text-[12px] font-medium text-slate-400 mt-2.5 flex items-center gap-1.5"><i class="fas fa-circle-info text-slate-300"></i> Max 5MB. Format: JPG/PNG/WEBP.</p>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="mb-8">
                        <?php 
                            $props = [
                                'name' => 'sort_order',
                                'label' => 'Urutan Tampilan',
                                'type' => 'number',
                                'placeholder' => '0',
                                'value' => '0',
                                'icon' => 'fas fa-sort'
                            ];
                            include __DIR__ . '/../components/ui/input.php';
                        ?>
                        <p class="text-[12px] font-medium text-slate-400 -mt-3 flex items-center gap-1.5"><i class="fas fa-circle-info text-slate-300"></i> Semakin kecil angka, semakin atas posisinya.</p>
                    </div>
                    <label class="block text-[13px] font-black text-slate-800 mb-2.5 uppercase tracking-wide">Status Ketersediaan</label>
                    <div class="flex gap-4 p-1.5 bg-slate-100 rounded-xl w-fit border border-slate-200/60 p-1">
                        <label class="relative flex items-center justify-center cursor-pointer">
                            <input type="radio" name="is_active" value="1" checked class="peer sr-only">
                            <div class="px-5 py-2.5 rounded-lg text-[13px] font-black text-slate-500 peer-checked:bg-white peer-checked:text-indigo-600 peer-checked:shadow-sm transition-all duration-300">AKTIF</div>
                        </label>
                        <label class="relative flex items-center justify-center cursor-pointer">
                            <input type="radio" name="is_active" value="0" class="peer sr-only">
                            <div class="px-5 py-2.5 rounded-lg text-[13px] font-black text-slate-500 peer-checked:bg-white peer-checked:text-rose-600 peer-checked:shadow-sm transition-all duration-300">NONAKTIF</div>
                        </label>
                    </div>
                    <p class="text-[12px] font-medium text-slate-400 mt-3 flex items-center gap-1.5"><i class="fas fa-eye-slash text-slate-300"></i> "Nonaktif" akan menyembunyikan metode dari halaman checkout.</p>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-3 mt-4">
                <a href="<?= BASEURL ?>/admin/paymentMethods" class="px-6 py-3 rounded-xl text-[14px] font-extrabold text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition-colors">Batal & Kembali</a>
                <button type="submit" class="px-8 py-3 rounded-xl text-[14px] font-black text-white bg-indigo-600 hover:bg-indigo-700 shadow-[0_4px_12px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_16px_rgba(79,70,229,0.4)] hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-check"></i> Simpan Metode Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('iconInput').addEventListener('change', function(e) {
        if(e.target.files && e.target.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                const container = document.getElementById('iconPreviewContainer');
                container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-contain rounded-[16px] p-1">`;
                container.classList.remove('hidden');
                document.getElementById('previewPlaceholder').classList.add('hidden');
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
