<?php 
$auth_heading = "Bergabung dengan Gresda Food";
$auth_subheading = "Daftar untuk melakukan pesanan pertama Anda yang lezat!";
ob_start(); 
?>

<form class="space-y-6" action="<?= BASEURL ?>/auth/register" method="POST" data-aos="fade-up" data-aos-duration="800">
    <?= CSRF::getTokenField() ?>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php 
        $props = ['name' => 'first_name', 'label' => 'Nama Depan', 'icon' => 'fas fa-user', 'placeholder' => 'Budi', 'required' => true];
        include '../app/views/components/ui/input.php';
        
        $props = ['name' => 'last_name', 'label' => 'Nama Belakang', 'icon' => 'far fa-user', 'placeholder' => 'Santoso', 'required' => true];
        include '../app/views/components/ui/input.php';
        ?>
    </div>

    <?php
    $props = ['name' => 'username', 'label' => 'Nama Pengguna', 'icon' => 'fas fa-at', 'placeholder' => 'budi_santoso', 'required' => true];
    include '../app/views/components/ui/input.php';

    $props = ['name' => 'email', 'type' => 'email', 'label' => 'Alamat Email', 'icon' => 'fas fa-envelope', 'required' => true];
    include '../app/views/components/ui/input.php';

    $props = ['name' => 'password', 'type' => 'password', 'label' => 'Kata Sandi', 'icon' => 'fas fa-lock', 'placeholder' => 'Minimal 8 karakter', 'required' => true];
    include '../app/views/components/ui/input.php';
    ?>
    <p class="text-xs text-gray-500 -mt-2.5 ml-1 flex items-center gap-1">
        <i class="fas fa-info-circle text-primary"></i> 
        Gunakan kombinasi huruf, angka, & simbol agar lebih kuat.
    </p>

    <div class="flex items-start mt-4">
        <div class="flex items-center h-5">
            <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary accent-primary">
        </div>
        <label for="terms" class="ml-2 text-sm font-medium text-gray-900">Saya setuju dengan <a href="<?= BASEURL ?>/legal/terms" target="_blank" class="text-primary hover:text-cyan-700 hover:underline">Syarat & Ketentuan</a> serta <a href="<?= BASEURL ?>/legal/privacy" target="_blank" class="text-primary hover:text-cyan-700 hover:underline">Kebijakan Privasi</a>.</label>
    </div>

    <div>
        <?php 
        $props = ['text' => 'Buat Akun', 'type' => 'submit', 'variant' => 'primary', 'w_full' => true, 'class' => 'border-b-4 border-cyan-700 text-lg'];
        include '../app/views/components/ui/button.php';
        ?>
    </div>
</form>

<div class="mt-8 relative">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-200"></div>
    </div>
    <div class="relative flex justify-center text-sm">
        <span class="px-2 bg-white text-gray-500 font-medium tracking-wide">
            Sudah punya akun?
        </span>
    </div>
</div>

<div class="mt-6">
    <?php 
    $props = ['text' => 'Masuk di sini', 'type' => 'a', 'href' => BASEURL . '/auth/login', 'variant' => 'outline', 'w_full' => true];
    include '../app/views/components/ui/button.php';
    ?>
</div>

<?php 
$slot = ob_get_clean();
include '../app/views/components/auth_layout.php'; 
?>

