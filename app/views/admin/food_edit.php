<?php 
$title = "Edit Item Makanan";
ob_start();
?>

<!-- Premium Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL ?>/admin/foods" class="w-10 h-10 rounded-[14px] bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
        </a>
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Edit Konfigurasi Menu</h2>
            <p class="text-[13px] font-medium text-slate-500">Ubah atribut inventaris menu secara aktual</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden w-full relative mb-8">
    <!-- Structural Top Decoration -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>
    <div class="p-8 sm:p-10">
        <form action="<?= BASEURL ?>/admin/editFood/<?= $food['id'] ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
            <?= CSRF::getTokenField() ?>
            <input type="hidden" name="current_image" value="<?= htmlspecialchars($food['image']) ?>">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <?php 
                        $props = [
                            'name' => 'name',
                            'label' => 'Identitas Menu',
                            'value' => htmlspecialchars($food['name']),
                            'required' => true
                        ];
                        include __DIR__ . '/../components/ui/input.php';
                    ?>
                </div>
                <div>
                    <label class="block text-[13px] font-black text-slate-800 mb-2.5 uppercase tracking-wide">Pengelompokan (Kategori)</label>
                    <select name="category_id" required class="w-full px-5 py-3.5 bg-slate-50/50 border border-slate-200/80 rounded-xl text-slate-900 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all font-bold text-[14px] hover:bg-white cursor-pointer appearance-none">
                        <option value="">-- Tentukan Kategori --</option>
                        <?php if(!empty($categories)): foreach($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['id']) ?>" <?= ($cat['id'] == $food['category_id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-[13px] font-black text-slate-800 mb-2.5 uppercase tracking-wide">Nilai Jual (Rp)</label>
                <?php $priceFormatted = number_format($food['price'], 0, ',', '.'); ?>
                <div class="relative w-full md:w-1/2">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <span class="text-slate-400 font-black text-[14px]">Rp</span>
                    </div>
                    <input type="text" id="priceDisplay" value="<?= $priceFormatted ?>" required class="w-full pl-12 pr-5 py-3.5 bg-slate-50/50 border border-slate-200/80 rounded-xl text-slate-900 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder-slate-300 font-black text-[15px] font-mono tracking-tight hover:bg-white">
                    <input type="hidden" name="price" id="priceValue" value="<?= htmlspecialchars($food['price']) ?>" required>
                </div>
            </div>

            <div>
                <label class="block text-[13px] font-black text-slate-800 mb-2.5 uppercase tracking-wide">Naskah Penjualan (Deskripsi)</label>
                <textarea name="description" rows="4" required class="w-full px-5 py-3.5 bg-slate-50/50 border border-slate-200/80 rounded-xl text-slate-900 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder-slate-400 font-medium text-[14px] hover:bg-white leading-relaxed resize-none"><?= htmlspecialchars($food['description']) ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-4">
                <div>
                    <label class="block text-[13px] font-black text-slate-800 mb-2.5 uppercase tracking-wide">Representasi Visual Lama / Baru</label>
                    <div class="flex flex-col gap-4">
                        <div class="w-24 h-24 rounded-[16px] bg-slate-50 border-2 border-dashed border-slate-300 flex items-center justify-center text-slate-400 overflow-hidden shadow-sm relative group cursor-pointer transition-colors hover:border-indigo-400 hover:bg-indigo-50/50" onclick="document.getElementById('imageInput').click()" id="imagePreviewContainer">
                            <?php if(!empty($food['image'])): ?>
                                <img src="<?= BASEURL ?>/uploads/food/<?= htmlspecialchars($food['image']) ?>" class="w-full h-full object-cover rounded-[14px]">
                            <?php else: ?>
                                <span class="flex flex-col items-center gap-1 group-hover:text-indigo-500 transition-colors">
                                    <i class="fas fa-camera text-[22px]"></i>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <input type="file" name="image" id="imageInput" accept="image/*" class="w-full text-[13px] font-bold text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-[13px] file:font-black file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition-colors cursor-pointer outline-none">
                            <p class="text-[12px] font-medium text-slate-400 mt-2.5 flex items-center gap-1.5"><i class="fas fa-circle-info text-slate-300"></i> Max 2MB. Abaikan jika tidak ingin ganti visual.</p>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-[13px] font-black text-slate-800 mb-2.5 uppercase tracking-wide">Ketersediaan Menu</label>
                    <div class="flex gap-4 p-1.5 bg-slate-100 rounded-xl w-fit border border-slate-200/60 p-1">
                        <label class="relative flex items-center justify-center cursor-pointer">
                            <input type="radio" name="is_active" value="1" <?= ($food['is_active']) ? 'checked' : '' ?> class="peer sr-only">
                            <div class="px-5 py-2.5 rounded-lg text-[13px] font-black text-slate-500 peer-checked:bg-white peer-checked:text-indigo-600 peer-checked:shadow-sm transition-all duration-300">TERSEDIA PABRIK</div>
                        </label>
                        <label class="relative flex items-center justify-center cursor-pointer">
                            <input type="radio" name="is_active" value="0" <?= (!$food['is_active']) ? 'checked' : '' ?> class="peer sr-only">
                            <div class="px-5 py-2.5 rounded-lg text-[13px] font-black text-slate-500 peer-checked:bg-white peer-checked:text-rose-600 peer-checked:shadow-sm transition-all duration-300">DIARSIPKAN</div>
                        </label>
                    </div>
                    <p class="text-[12px] font-medium text-slate-400 mt-3 flex items-center gap-1.5"><i class="fas fa-eye-slash text-slate-300"></i> "Diarsipkan" akan menyembunyikan menu dari katalog publik.</p>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-3 mt-4">
                <a href="<?= BASEURL ?>/admin/foods" class="px-6 py-3 rounded-xl text-[14px] font-extrabold text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition-colors">Batal</a>
                <button type="submit" class="px-8 py-3 rounded-xl text-[14px] font-black text-white bg-indigo-600 hover:bg-indigo-700 shadow-[0_4px_12px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_16px_rgba(79,70,229,0.4)] hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-check"></i> Terapkan Mutasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        if(e.target.files && e.target.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreviewContainer').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-[14px]">`;
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    const priceDisplay = document.getElementById('priceDisplay');
    const priceValue = document.getElementById('priceValue');

    priceDisplay.addEventListener('input', function(e) {
        // Remove non-digit chars
        let value = this.value.replace(/\D/g, '');
        priceValue.value = value;
        // Format with thousand separators
        if(value) {
            this.value = parseInt(value, 10).toLocaleString('id-ID');
        } else {
            this.value = '';
        }
    });
</script>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
