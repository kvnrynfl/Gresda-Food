<?php 
$page_title = "Lupa Kata Sandi";
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
                <i class="fas fa-key text-5xl mb-4 text-primary"></i>
                <p>Masukkan email Anda untuk menerima link reset kata sandi.</p>
            </div>

            <form action="<?= BASEURL ?>/auth/sendResetLink" method="POST" class="space-y-6">
                <?= CSRF::getTokenField() ?>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required placeholder="email@contoh.com" class="w-full px-4 py-3 bg-white border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary focus:border-cyan-700 transition">
                </div>

                <button type="submit" class="w-full bg-primary hover:bg-cyan-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-cyan-600/30 transition transform hover:-translate-y-0.5 active:translate-y-0">
                    <i class="fas fa-paper-plane mr-2"></i> Kirim Link Reset
                </button>
            </form>

            <div class="mt-8 relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500 font-medium">Ingat kata sandi Anda?</span>
                </div>
            </div>

            <div class="mt-6">
                <a href="<?= BASEURL ?>/auth/login" class="w-full block text-center py-3 px-4 border-2 border-gray-200 hover:border-primary hover:bg-cyan-50 text-gray-700 hover:text-primary font-bold rounded-xl transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</div>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>
