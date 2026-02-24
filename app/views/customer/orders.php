<?php 
$page_title = "Riwayat Pesanan";
$back_link = BASEURL . "/customer/profile";
$hide_card = true;
ob_start(); 
?>

<!-- Filter Tabs -->
<div class="flex overflow-x-auto gap-2 mb-6 pb-2 hide-scrollbar">
    <button onclick="filterOrders('all', this)" class="order-filter-btn flex-shrink-0 px-5 py-2.5 rounded-full text-sm font-bold transition-all bg-primary text-white shadow-md">Semua Pesanan</button>
    <button onclick="filterOrders('Payment', this)" class="order-filter-btn flex-shrink-0 px-5 py-2.5 rounded-full text-sm font-bold bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 transition-all">Belum Dibayar</button>
    <button onclick="filterOrders('active', this)" class="order-filter-btn flex-shrink-0 px-5 py-2.5 rounded-full text-sm font-bold bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 transition-all">Sedang Diproses</button>
    <button onclick="filterOrders('Finished', this)" class="order-filter-btn flex-shrink-0 px-5 py-2.5 rounded-full text-sm font-bold bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 transition-all">Selesai</button>
    <button onclick="filterOrders('Canceled', this)" class="order-filter-btn flex-shrink-0 px-5 py-2.5 rounded-full text-sm font-bold bg-white text-gray-600 border border-gray-200 hover:bg-gray-50 transition-all">Dibatalkan</button>
</div>

<div class="space-y-6" id="orders-list">
    <?php if(!empty($orders)): foreach($orders as $order): ?>
        <?php 
        $filterType = $order['status'];
        if(in_array($order['status'], ['Confirmed', 'Delivery'])) $filterType = 'active';
        ?>
        <div class="order-item transition-all duration-300 transform origin-top" data-filter="<?= htmlspecialchars($filterType) ?>">
            <?php ob_start(); ?>
                <div class="flex flex-col md:flex-row justify-between md:items-center gap-4 mb-6 pb-6 border-b border-gray-50">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-full bg-cyan-50 flex items-center justify-center text-primary">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 font-medium">ID Pesanan</p>
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-primary transition-colors">#<?= htmlspecialchars($order['order_id']) ?></h3>
                            </div>
                        </div>
                        <p class="text-sm text-gray-500 flex items-center gap-2 mt-4 md:mt-0">
                            <i class="far fa-clock"></i> <?= date('d M Y - H:i', strtotime($order['created_at'])) ?>
                        </p>
                    </div>
                    <div class="flex items-center">
                        <?php 
                            $statusVariant = 'gray';
                            $statusIcon = 'fas fa-clock';
                            $statusMap = [
                                'Cart' => 'Keranjang',
                                'Payment' => 'Menunggu Pembayaran',
                                'Confirmed' => 'Dikonfirmasi',
                                'Delivery' => 'Sedang Dikirim',
                                'Finished' => 'Selesai',
                                'Canceled' => 'Dibatalkan'
                            ];
                            switch($order['status']) {
                                case 'Cart': $statusVariant = 'gray'; $statusIcon = 'fas fa-shopping-cart'; break;
                                case 'Payment': $statusVariant = 'info'; $statusIcon = 'fas fa-wallet'; break;
                                case 'Confirmed': $statusVariant = 'info'; $statusIcon = 'fas fa-check-circle'; break;
                                case 'Delivery': $statusVariant = 'warning'; $statusIcon = 'fas fa-motorcycle'; break;
                                case 'Finished': $statusVariant = 'success'; $statusIcon = 'fas fa-flag-checkered'; break;
                                case 'Canceled': $statusVariant = 'danger'; $statusIcon = 'fas fa-times-circle'; break;
                            }
                            $statusText = $statusMap[$order['status']] ?? $order['status'];
                            
                            $props = ['text' => $statusText, 'variant' => $statusVariant, 'icon' => $statusIcon, 'class' => 'px-4 py-2 text-sm'];
                            include '../app/views/components/ui/badge.php';
                        ?>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="w-full md:w-auto text-left">
                        <p class="text-sm text-gray-500 font-medium mb-1">Total Pembayaran</p>
                        <p class="text-3xl font-black text-gray-800">Rp <?= number_format($order['total'] ?? 0, 0, ',', '.') ?></p>
                    </div>
                    <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                        <?php if($order['status'] === 'Payment'): ?>
                            <?php 
                            $props = [
                                'text' => 'Bayar Sekarang', 
                                'type' => 'a', 
                                'href' => BASEURL . '/customer/payment/' . urlencode($order['order_id']), 
                                'variant' => 'danger', 
                                'icon' => 'fas fa-wallet', 
                                'class' => 'w-full sm:w-auto'
                            ];
                            include '../app/views/components/ui/button.php';
                            ?>
                        <?php elseif($order['status'] === 'Finished'): ?>
                            <?php 
                            $props = [
                                'text' => 'Beri Ulasan', 
                                'type' => 'a', 
                                'href' => BASEURL . '/customer/reviews', 
                                'variant' => 'primary', 
                                'icon' => 'fas fa-star', 
                                'class' => 'w-full sm:w-auto'
                            ];
                            include '../app/views/components/ui/button.php';
                            ?>
                        <?php endif; ?>
                        <?php 
                        $props = [
                            'text' => 'Detail', 
                            'type' => 'a', 
                            'href' => BASEURL . '/customer/orderDetails/' . urlencode($order['order_id']), 
                            'variant' => 'outline', 
                            'class' => 'w-full sm:w-auto'
                        ];
                        include '../app/views/components/ui/button.php';
                        ?>
                    </div>
                </div>
            <?php 
            $slot = ob_get_clean();
            $props = ['class' => 'hover:shadow-lg transition-all duration-300 group', 'body_class' => 'p-6 md:p-8'];
            include '../app/views/components/ui/card.php';
            ?>
        </div>
    <?php endforeach; else: ?>
        <?php ob_start(); ?>
        <div class="text-center py-8">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                <i class="fas fa-box-open text-3xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-lg mb-2">Belum Ada Pesanan</h3>
            <p class="text-gray-500 mb-6 max-w-sm mx-auto">Anda belum membuat pesanan sama sekali. Mulai jelajahi menu kami yuk!</p>
            <a href="<?= BASEURL ?>/menu" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold hover:bg-cyan-700 transition shadow-sm">
                <i class="fas fa-utensils"></i> Jelajahi Menu
            </a>
        </div>
        <?php 
        $slot = ob_get_clean();
        include '../app/views/components/ui/card.php';
        ?>
    <?php endif; ?>
</div>

<script>
function filterOrders(filter, btn) {
    // Handle active state on buttons
    document.querySelectorAll('.order-filter-btn').forEach(b => {
        b.classList.remove('bg-primary', 'text-white', 'shadow-md');
        b.classList.add('bg-white', 'text-gray-600');
    });
    btn.classList.add('bg-primary', 'text-white', 'shadow-md');
    btn.classList.remove('bg-white', 'text-gray-600');

    // Handle filtering
    const items = document.querySelectorAll('.order-item');
    items.forEach(item => {
        if(filter === 'all' || item.dataset.filter === filter) {
            item.style.display = 'block';
            setTimeout(() => { item.style.opacity = '1'; item.style.transform = 'scaleY(1)'; }, 50);
        } else {
            item.style.opacity = '0';
            item.style.transform = 'scaleY(0.95)';
            setTimeout(() => { item.style.display = 'none'; }, 300);
        }
    });
}
</script>

<?php 
$slot = ob_get_clean();
include '../app/views/components/app_layout.php'; 
?>
