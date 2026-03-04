<?php 
$page_title = "Masuk";
$back_link = BASEURL . "/";
$hide_card = true;
ob_start(); 
?>

<div class="container mx-auto px-4 max-w-xl">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8">
            <?php if(!empty($error)): ?>
                <div class="bg-cyan-50 text-primary p-4 rounded-lg mb-6 flex items-center gap-3">
                    <i class="fas fa-exclamation-circle text-xl"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <?php if(!empty($success)): ?>
                <div class="bg-green-50 text-green-600 p-4 rounded-lg mb-6 flex items-center gap-3">
                    <i class="fas fa-check-circle text-xl"></i> <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <div class="mb-8 text-center text-gray-500">
                <i class="fas fa-sign-in-alt text-5xl mb-4 text-primary"></i>
                <p>Masuk untuk mengelola keranjang, pesanan, dan profil Anda.</p>
            </div>

            <form action="<?= BASEURL ?>/auth/login" method="POST" class="space-y-6">
                <?= CSRF::getTokenField() ?>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Pengguna atau Email</label>
                    <input type="text" name="login_id" value="<?= htmlspecialchars($login_id ?? '') ?>" required placeholder="username atau email" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary accent-primary">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700 font-medium">Ingat saya</label>
                    </div>
                    <a href="<?= BASEURL ?>/auth/forgotPassword" class="text-sm font-bold text-primary hover:text-cyan-700 transition">Lupa kata sandi?</a>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-cyan-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-cyan-600/30 transition transform hover:-translate-y-0.5 active:translate-y-0">
                    Masuk
                </button>
            </form>

            <div class="mt-8 relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500 font-medium">Belum punya akun?</span>
                </div>
            </div>

            <div class="mt-6">
                <a href="<?= BASEURL ?>/auth/register" class="w-full block text-center py-3 px-4 border-2 border-gray-200 hover:border-primary hover:bg-cyan-50 text-gray-700 hover:text-primary font-bold rounded-xl transition">
                    Buat Akun Baru
                </a>
            </div>
        </div>
    </div>
</div>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>
