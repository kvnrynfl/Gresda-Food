<?php 
$page_title = "Syarat & Ketentuan Layanan";
$back_link = BASEURL . "/";
ob_start(); 
?>

<!-- Header -->
<div class="bg-gradient-to-r from-cyan-600 to-cyan-500 px-10 py-12 text-center border-b border-gray-100">
    <h1 class="text-4xl font-extrabold text-white mb-4">Syarat & Ketentuan Layanan</h1>
    <p class="text-cyan-50 text-lg">Diperbarui: 24 Februari 2026</p>
</div>

<!-- Content -->
<div class="p-10 md:p-14 prose prose-cyan max-w-none text-gray-700 leading-relaxed">
    <p class="text-lg font-medium mb-8 text-gray-800">Selamat datang di Gresda Food! Dengan mendaftar, mengakses, atau menggunakan layanan platform kami, Anda menyetujui untuk terikat oleh Syarat dan Ketentuan berikut.</p>
    
    <h3 class="text-2xl font-bold text-gray-900 mt-10 mb-4 flex items-center gap-3">
        <span class="bg-cyan-100 text-cyan-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">1</span> 
        Pendaftaran dan Akun Pengguna
    </h3>
    <ol class="space-y-3 list-decimal list-outside ml-6 font-medium text-gray-600">
        <li class="pl-2">Anda wajib memberikan informasi yang akurat, lengkap, dan terbaru selama proses pendaftaran.</li>
        <li class="pl-2">Anda bertanggung jawab penuh untuk menjaga kerahasiaan kata sandi Anda dan setiap aktivitas yang terjadi di bawah akun Anda.</li>
        <li class="pl-2">Gresda Food berhak untuk menangguhkan atau mengakhiri akun jika ditemukan pelanggaran terhadap ketentuan ini atau tindakan penipuan.</li>
    </ol>

    <h3 class="text-2xl font-bold text-gray-900 mt-10 mb-4 flex items-center gap-3">
        <span class="bg-cyan-100 text-cyan-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">2</span> 
        Pemesanan dan Pembayaran
    </h3>
    <ul class="space-y-3 list-disc list-outside ml-6 text-gray-600">
        <li class="pl-2">Semua harga makanan yang tertera di menu Gresda Food final dan dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya.</li>
        <li class="pl-2">Pesanan baru akan diproses <strong class="text-gray-800">setelah kami menerima dan memverifikasi bukti transfer</strong> (Status: Dikonfirmasi).</li>
        <li class="pl-2">Pelanggan wajib menyelesaikan pembayaran dalam waktu 1x24 jam. Jika melewati batas tersebut, pesanan dapat dibatalkan secara otomatis oleh sistem.</li>
        <li class="pl-2">Dana yang telah ditransfer tidak dapat dikembalikan (Non-refundable) kecuali pesanan dibatalkan oleh pihak restoran akibat kehabisan stok atau kendala internal.</li>
    </ul>

    <h3 class="text-2xl font-bold text-gray-900 mt-10 mb-4 flex items-center gap-3">
        <span class="bg-cyan-100 text-cyan-600 w-8 h-8 rounded-full flex items-center justify-center text-sm">3</span> 
        Pengiriman
    </h3>
    <ul class="space-y-3 list-disc list-outside ml-6 text-gray-600 mb-8">
        <li class="pl-2">Waktu tiba pesanan yang tertera hanyalah estimasi. Kurir kami akan berusaha mengirimkan makanan secepat mungkin berdasarkan lalu lintas dan kondisi cuaca di lapangan.</li>
        <li class="pl-2">Pelanggan harus memastikan alamat pengiriman yang dicantumkan saat proses <em>Checkout</em> jelas, lengkap, serta dapat diakses.</li>
        <li class="pl-2">Gresda Food dibebaskan dari tanggung jawab kualitas makanan jika terjadi penundaan besar akibat Anda (pelanggan) tidak dapat dihubungi saat kurir tiba di tujuan.</li>
    </ul>

    <div class="bg-cyan-50 border-l-4 border-cyan-500 p-6 rounded-r-lg mt-12">
        <h4 class="text-lg font-bold text-cyan-900 mb-2">Punya Pertanyaan?</h4>
        <p class="text-cyan-800 text-sm">Jika Anda memiliki pertanyaan lebih lanjut mengenai syarat dan ketentuan di atas, jangan ragu untuk menghubungi tim dukungan pelanggan kami via <span class="font-bold underline cursor-pointer hover:text-cyan-600">Fitur Kontak di Halaman Utama</span>.</p>
    </div>
</div>

<div class="bg-gray-50 px-10 py-6 border-t border-gray-100 text-center text-sm text-gray-500">
    <p>&copy; <?= date('Y') ?> Gresda Food & Beverage. Semua Hak Dilindungi.</p>
</div>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>
