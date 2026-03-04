<?php 
$title = "Tambah Admin Baru";
ob_start();
?>

<!-- Premium Header -->
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="<?= BASEURL ?>/admin/admins" class="w-10 h-10 rounded-[14px] bg-white border border-slate-200/60 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition transform duration-300"></i>
        </a>
        <div>
            <h2 class="text-[26px] font-black text-slate-900 tracking-tight leading-none mb-1">Tambah Kredensial Admin</h2>
            <p class="text-[13px] font-medium text-slate-500">Buat otorisasi hak akses penuh untuk kolaborator</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-[24px] shadow-[0_2px_20px_-8px_rgba(0,0,0,0.1)] border border-slate-200/60 overflow-hidden w-full relative mb-8">
    <!-- Structural Top Decoration -->
    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-fuchsia-500 z-10"></div>
    <div class="p-8 sm:p-10">
        <form action="<?= BASEURL ?>/admin/createAdmin" method="POST" class="space-y-8">
            <?= CSRF::getTokenField() ?>
            
            <?php 
                $props = [
                    'name' => 'full_name',
                    'label' => 'Nama Representasi',
                    'placeholder' => 'misal: John Doe',
                    'required' => true
                ];
                include __DIR__ . '/../components/ui/input.php';
            ?>
            <p class="text-[12px] font-medium text-slate-400 -mt-3 mb-6 flex items-center gap-1.5"><i class="fas fa-circle-info text-slate-300"></i> Nama ini akan tampil di log aktivitas dan pesan sambutan.</p>

            <?php 
                $props = [
                    'name' => 'username',
                    'label' => 'Alias Sistem Akses',
                    'placeholder' => 'johndoe',
                    'icon' => 'fas fa-at',
                    'class' => 'font-mono text-[14px] tracking-tight',
                    'required' => true
                ];
                include __DIR__ . '/../components/ui/input.php';
            ?>

            <?php 
                $props = [
                    'name' => 'email',
                    'type' => 'email',
                    'label' => 'Alamat Email',
                    'placeholder' => 'admin@gresda.com',
                    'icon' => 'fas fa-envelope',
                    'required' => true
                ];
                include __DIR__ . '/../components/ui/input.php';
            ?>

            <?php 
                $props = [
                    'name' => 'password',
                    'type' => 'password',
                    'label' => 'Kunci Keamanan Sandi',
                    'class' => 'font-mono tracking-[0.2em]',
                    'required' => true
                ];
                include __DIR__ . '/../components/ui/input.php';
            ?>
            <p class="text-[12px] font-medium text-amber-500 -mt-3 flex items-center gap-1.5"><i class="fas fa-shield-halved text-amber-500/50"></i> Sandi inisiasi. Wajib terdiri dari minimal 8 karakter acak.</p>

            <div class="pt-8 border-t border-slate-100 flex items-center justify-end gap-3 mt-4">
                <a href="<?= BASEURL ?>/admin/admins" class="px-6 py-3 rounded-xl text-[14px] font-extrabold text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition-colors">Batal & Kembali</a>
                <button type="submit" class="px-8 py-3 rounded-xl text-[14px] font-black text-white bg-indigo-600 hover:bg-indigo-700 shadow-[0_4px_12px_rgba(79,70,229,0.3)] hover:shadow-[0_6px_16px_rgba(79,70,229,0.4)] hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-user-plus"></i> Finalisasi Kredensial
                </button>
            </div>
        </form>
    </div>
</div>



<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
