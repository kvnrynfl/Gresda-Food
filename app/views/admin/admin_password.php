<?php 
$title = "Ubah Kata Sandi Admin";
ob_start();
?>

<!-- Premium Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL ?>/admin/admins" class="w-10 h-10 rounded-[14px] bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
        </a>
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Pembaruan Kode Enkripsi</h2>
            <p class="text-[13px] font-medium text-slate-500">Mutasikan akses kontrol untuk akun @<?= htmlspecialchars($admin['username']) ?></p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden w-full relative mb-8">
    <!-- Structural Top Decoration -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>
    <div class="p-8 sm:p-10">
        <form action="<?= BASEURL ?>/admin/editAdminPassword/<?= $admin['id'] ?>" method="POST" class="space-y-8">
            <?= CSRF::getTokenField() ?>
            
            <div class="p-5 bg-amber-50 rounded-xl border border-amber-200/60 text-amber-800 text-[13px] font-medium flex items-start gap-4">
                <i class="fas fa-shield-halved mt-0.5 text-amber-500 text-[18px]"></i>
                <p class="leading-relaxed">Tindakan ini mengubah kredensial inti untuk ruang lingkup administratif. Pastikan rute komunikasi aman apabila menyerahkan hasil kepada yang bersangkutan.</p>
            </div>

            <?php 
                $props = [
                    'name' => 'new_password',
                    'type' => 'password',
                    'label' => 'Inisiasi Sandi Revisi',
                    'class' => 'font-mono tracking-[0.2em] focus:ring-amber-500/10 focus:border-amber-500',
                    'required' => true
                ];
                include __DIR__ . '/../components/ui/input.php';
            ?>

            <?php 
                $props = [
                    'name' => 'confirm_password',
                    'type' => 'password',
                    'label' => 'Validasi Komparasi Sandi',
                    'class' => 'font-mono tracking-[0.2em] focus:ring-amber-500/10 focus:border-amber-500',
                    'required' => true
                ];
                include __DIR__ . '/../components/ui/input.php';
            ?>

            <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-3 mt-4">
                <a href="<?= BASEURL ?>/admin/admins" class="px-6 py-3 rounded-xl text-[14px] font-extrabold text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition-colors">Abaikan</a>
                <button type="submit" class="px-8 py-3 rounded-xl text-[14px] font-black text-white bg-amber-500 hover:bg-amber-600 shadow-[0_4px_12px_rgba(245,158,11,0.3)] hover:shadow-[0_6px_16px_rgba(245,158,11,0.4)] hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-lock"></i> Sinkronisasi Kredensial
                </button>
            </div>
        </form>
    </div>
</div>



<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
