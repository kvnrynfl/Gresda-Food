<?php 
$title = "Kirim Ulasan";
include '../app/views/layouts/header.php'; 
?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center gap-3">
                <a href="<?= BASEURL ?>/customer/orders" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="text-2xl font-bold text-gray-800">Nilai Pengalaman Anda</h2>
            </div>
            
            <div class="p-8">
                <?php if(isset($error)): ?>
                    <div class="bg-cyan-50 text-cyan-600 p-4 rounded-lg mb-6 flex items-center gap-3 animate-pulse">
                        <i class="fas fa-exclamation-circle text-xl"></i> <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                <?php if(isset($success)): ?>
                    <div class="bg-green-50 text-green-600 p-4 rounded-lg mb-6 flex items-center gap-3">
                        <i class="fas fa-check-circle text-xl"></i> <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <div class="flex flex-col items-center mb-8">
                    <div class="w-20 h-20 rounded-full bg-cyan-50 flex items-center justify-center mb-4 text-cyan-500 shadow-sm border border-cyan-100">
                        <i class="fas fa-hamburger text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 text-center">Bagaimana makanan Anda?</h3>
                    <p class="text-gray-500 text-sm text-center">Masukan Anda membantu kami menjadi lebih baik.</p>
                </div>

                <form action="<?= BASEURL ?>/customer/submitReview" method="POST" class="space-y-6">
                    <?= CSRF::getTokenField() ?>
                    <!-- Assumes order ID or food ID is passed via URL or session, setting as hidden input for future-proofing -->
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($_GET['order'] ?? 1) ?>">
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Penilaian Keseluruhan</label>
                        <div class="flex gap-2">
                            <!-- Basic Select for now to ensure functional parity, can be upgraded to star-rating JS later -->
                            <select name="rating" required class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition font-bold text-gray-700 text-lg">
                                <option value="5" <?= (isset($existing_review['rating']) && $existing_review['rating'] == '5') ? 'selected' : '' ?>>⭐⭐⭐⭐⭐ 5 - Sangat Bagus!</option>
                                <option value="4" <?= (isset($existing_review['rating']) && $existing_review['rating'] == '4') ? 'selected' : '' ?>>⭐⭐⭐⭐ 4 - Sangat Baik</option>
                                <option value="3" <?= (isset($existing_review['rating']) && $existing_review['rating'] == '3') ? 'selected' : '' ?>>⭐⭐⭐ 3 - Rata-rata</option>
                                <option value="2" <?= (isset($existing_review['rating']) && $existing_review['rating'] == '2') ? 'selected' : '' ?>>⭐⭐ 2 - Buruk</option>
                                <option value="1" <?= (isset($existing_review['rating']) && $existing_review['rating'] == '1') ? 'selected' : '' ?>>⭐ 1 - Sangat Buruk</option>
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Pikiran Anda (Opsional)</label>
                        <textarea name="message" rows="4" placeholder="Beri tahu kami apa yang Anda sukai, atau apa yang bisa kami tingkatkan..." class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition"><?= htmlspecialchars($existing_review['message'] ?? '') ?></textarea>
                    </div>
                    
                    <button type="submit" class="w-full <?= isset($existing_review) ? 'bg-orange-500 hover:bg-orange-600 shadow-orange-500/30' : 'bg-cyan-600 hover:bg-cyan-700 shadow-cyan-500/30' ?> text-white font-bold py-3 px-4 rounded-xl shadow-lg transition transform hover:-translate-y-0.5 active:translate-y-0">
                        <?= isset($existing_review) ? 'Perbarui Ulasan' : 'Kirim Ulasan' ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../app/views/layouts/footer.php'; ?>

