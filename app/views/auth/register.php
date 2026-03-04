<?php 
$page_title = "Buat Akun Baru";
$back_link = BASEURL . "/auth/login";
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
                <i class="fas fa-user-plus text-5xl mb-4 text-primary"></i>
                <p>Daftar untuk melakukan pesanan pertama Anda yang lezat!</p>
            </div>

            <form action="<?= BASEURL ?>/auth/register" method="POST" class="space-y-6">
                <?= CSRF::getTokenField() ?>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="full_name" value="<?= htmlspecialchars($old['full_name'] ?? '') ?>" required placeholder="Budi Santoso" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Pengguna</label>
                    <input type="text" name="username" value="<?= htmlspecialchars($old['username'] ?? '') ?>" required placeholder="budi_santoso" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required placeholder="email@contoh.com" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="tel" name="phone" value="<?= htmlspecialchars($old['phone'] ?? '') ?>" placeholder="08123456789" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                    <p class="text-xs text-gray-500 mt-2">Minimal 8 karakter, harus mengandung huruf besar dan angka.</p>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                    <input type="password" name="confirm_password" required placeholder="Ulangi kata sandi" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                </div>

                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary accent-primary">
                    </div>
                    <label for="terms" class="ml-2 text-sm font-medium text-gray-700">Saya setuju dengan <a href="<?= BASEURL ?>/legal/terms" target="_blank" class="text-primary hover:text-cyan-700 hover:underline">Syarat & Ketentuan</a> serta <a href="<?= BASEURL ?>/legal/privacy" target="_blank" class="text-primary hover:text-cyan-700 hover:underline">Kebijakan Privasi</a>.</label>
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-cyan-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-cyan-600/30 transition transform hover:-translate-y-0.5 active:translate-y-0">
                    Buat Akun
                </button>
            </form>

            <div class="mt-8 relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500 font-medium">Sudah punya akun?</span>
                </div>
            </div>

            <div class="mt-6">
                <a href="<?= BASEURL ?>/auth/login" class="w-full block text-center py-3 px-4 border-2 border-gray-200 hover:border-primary hover:bg-cyan-50 text-gray-700 hover:text-primary font-bold rounded-xl transition">
                    Masuk di sini
                </a>
            </div>
        </div>
    </div>
</div>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>
