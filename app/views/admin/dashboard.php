<?php 
$title = "Ringkasan Dasbor";
ob_start();
?>

<!-- Premium Stats Grid -->
<div class="grid grid-cols-1 select-none md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <?php
    $stats = [
        ['title' => 'Total Pendapatan', 'value' => 'Rp ' . number_format($totalRevenue ?? 0, 0, ',', '.'), 'icon' => 'fas fa-wallet', 'color' => 'indigo'],
        ['title' => 'Total Pelanggan', 'value' => $totalCustomers ?? 0, 'icon' => 'fas fa-users', 'color' => 'blue'],
        ['title' => 'Total Pesanan', 'value' => $totalOrders ?? 0, 'icon' => 'fas fa-boxes', 'color' => 'green'],
        ['title' => 'Varian Makanan', 'value' => $totalFoods ?? 0, 'icon' => 'fas fa-hamburger', 'color' => 'orange'],
        ['title' => 'Pesan Belum Dibaca', 'value' => $unreadContacts ?? 0, 'icon' => 'fas fa-envelope', 'color' => 'cyan'],
    ];

    foreach($stats as $stat) {
        extract($stat);
        include __DIR__ . '/../components/admin/ui/stat_card.php';
    }
    ?>
</div>

<!-- Advanced High-End Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Revenue Evolution Chart -->
    <div class="lg:col-span-2 bg-white rounded-[20px] border border-slate-200/80 p-8 flex flex-col relative overflow-hidden group hover:shadow-[0_4px_24px_rgba(0,0,0,0.03)] transition-all duration-300">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 class="text-[22px] font-black text-slate-900 tracking-tight leading-none mb-2">Evolusi Pendapatan</h3>
                <p class="text-[13px] text-slate-500 font-bold uppercase tracking-widest">6 Bulan Terakhir</p>
            </div>
            <div class="p-2.5 bg-indigo-50/50 rounded-xl text-indigo-500 ring-1 ring-indigo-100">
                <i class="fas fa-arrow-trend-up"></i>
            </div>
        </div>
        <div id="revenueChart" class="w-full h-72 flex-grow -ml-2"></div>
    </div>
    
    <!-- Order Distribution Donut -->
    <div class="bg-white rounded-[20px] border border-slate-200/80 p-8 flex flex-col items-center justify-center relative group hover:shadow-[0_4px_24px_rgba(0,0,0,0.03)] transition-all duration-300">
        <div class="w-full mb-2">
            <h3 class="text-[18px] font-black text-slate-900 tracking-tight leading-none mb-2">Distribusi Status Pesanan</h3>
            <p class="text-[11px] text-slate-500 font-bold uppercase tracking-widest">Agregasi Aktivitas</p>
        </div>
        <div id="statusChart" class="w-full h-64 flex-grow flex justify-center items-center"></div>
    </div>
</div>

<!-- Seamless Recent Orders List -->
<div class="bg-white rounded-[20px] border border-slate-200/80 p-8 hover:shadow-[0_4px_24px_rgba(0,0,0,0.03)] transition-all duration-300">
    <div class="flex justify-between items-center border-b border-slate-100/80 pb-6 mb-6">
        <div>
            <h3 class="text-[22px] font-black text-slate-900 tracking-tight leading-none mb-2">Aliran Pesanan Terkini</h3>
            <p class="text-[13px] text-slate-500 font-bold uppercase tracking-widest">5 Entri Terakhir</p>
        </div>
        <a href="<?= BASEURL ?>/admin/orders" class="text-[13px] text-indigo-600 hover:text-indigo-800 font-extrabold flex items-center gap-2 transition-colors group bg-indigo-50/50 px-4 py-2 rounded-xl">
            Lihat Semua <i class="fas fa-arrow-right text-[10px] transform group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
    
    <?php
    $headers = [
        ['text' => 'No. Pesanan', 'class' => 'w-36'],
        ['text' => 'Pelanggan', 'class' => ''],
        ['text' => 'Total', 'class' => 'text-right w-40'],
        ['text' => 'Status', 'class' => 'text-center w-32'],
        ['text' => 'Aksi', 'class' => 'text-right w-24']
    ];
    $is_empty = empty($recentOrders);
    
    ob_start();
    if (!$is_empty) {
        foreach($recentOrders as $ro) {
            
            $statusColor = 'gray'; $statusIcon = 'fas fa-clock';
            switch($ro['status']) {
                case 'pending_payment': $statusColor = 'blue';   $statusIcon = 'fas fa-wallet'; break;
                case 'confirmed':      $statusColor = 'indigo'; $statusIcon = 'fas fa-check-double'; break;
                case 'processing':     $statusColor = 'violet'; $statusIcon = 'fas fa-cog'; break;
                case 'delivering':     $statusColor = 'orange'; $statusIcon = 'fas fa-motorcycle'; break;
                case 'finished':       $statusColor = 'green';  $statusIcon = 'fas fa-box-open'; break;
                case 'cancelled':      $statusColor = 'red';    $statusIcon = 'fas fa-ban'; break;
            }

            $statusLabels = [
                'pending_payment' => 'Menunggu Bayar',
                'confirmed' => 'Dikonfirmasi',
                'processing' => 'Diproses',
                'delivering' => 'Dikirim',
                'finished' => 'Selesai',
                'cancelled' => 'Dibatalkan'
            ];

            echo '<tr class="group">';
            echo '<td class="font-mono font-black text-slate-800 text-[13px]">' . htmlspecialchars($ro['order_number'] ?? substr($ro['id'], 0, 8)) . '</td>';
            echo '<td class="text-[14px] text-slate-700 font-bold group-hover:text-indigo-600 transition-colors">' . htmlspecialchars($ro['customer_name'] ?? $ro['username'] ?? 'N/A') . '</td>';
            echo '<td class="text-right text-[14px] font-black text-slate-800">Rp ' . number_format($ro['grand_total'] ?? 0, 0, ',', '.') . '</td>';
            
            echo '<td class="text-center">';
            $text = $statusLabels[$ro['status']] ?? $ro['status'];
            $color = $statusColor;
            $icon = false; 
            include __DIR__ . '/../components/admin/ui/badge.php';
            echo '</td>';

            echo '<td class="text-right">';
            $type = 'a';
            $href = BASEURL . '/admin/orderDetails/' . urlencode($ro['id']);
            $color = 'indigo';
            $icon = 'fas fa-arrow-right';
            $btn_title = 'Detail';
            include __DIR__ . '/../components/admin/ui/action_button.php';
            echo '</td>';
            echo '</tr>';
        }
    }
    $tableSlot = ob_get_clean();

    $slot = $tableSlot;
    $empty_icon = 'fas fa-inbox';
    $empty_title = 'Tidak Ada Aktivitas';
    $empty_message = 'Belum ada pesanan masuk.';
    include __DIR__ . '/../components/admin/ui/data_table.php';
    ?>
</div>

<?php 
// Prepare Chart Data from statusCounts
$status_labels = [];
$status_data = [];
if (!empty($statusCounts)) {
    $statusTranslation = [
        'pending_payment' => 'Menunggu Bayar',
        'confirmed' => 'Dikonfirmasi',
        'processing' => 'Diproses',
        'delivering' => 'Dikirim',
        'finished' => 'Selesai',
        'cancelled' => 'Dibatalkan'
    ];
    foreach ($statusCounts as $row) {
        $status_labels[] = $statusTranslation[$row['status']] ?? $row['status'];
        $status_data[] = (int)$row['count'];
    }
}
?>

<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Revenue Chart - Placeholder since we need actual data from controller
        var revOptions = {
            series: [{
                name: 'Pendapatan',
                data: <?= json_encode(!empty($statusCounts) ? array_column($statusCounts, 'count') : [0]) ?>
            }],
            chart: {
                type: 'area',
                height: 300,
                fontFamily: '"Plus Jakarta Sans", sans-serif',
                toolbar: { show: false },
                zoom: { enabled: false },
                animations: { easing: 'easeinout', speed: 800 }
            },
            colors: ['#4f46e5'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: <?= json_encode($status_labels ?: ['Tidak ada data']) ?>,
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: '#94a3b8', fontWeight: 600, fontSize: '11px' } }
            },
            yaxis: {
                labels: { 
                    style: { colors: '#94a3b8', fontWeight: 600, fontSize: '11px' },
                    formatter: function (value) { return Math.round(value); }
                }
            },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 5, padding: { left: 10, right: 0 } },
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.0, stops: [0, 90, 100] }
            },
            tooltip: {
                theme: 'light',
                y: { formatter: function (val) { return val + ' pesanan' } }
            }
        };

        var revChart = new ApexCharts(document.querySelector("#revenueChart"), revOptions);
        revChart.render();
        
        // Polished Status Donut Chart
        var statusOptions = {
            series: <?= json_encode(empty($status_data) ? [1] : $status_data) ?>,
            labels: <?= json_encode(empty($status_labels) ? ['Tidak Ada Data'] : $status_labels) ?>,
            chart: {
                type: 'donut',
                height: 290,
                fontFamily: '"Plus Jakarta Sans", sans-serif',
                animations: { easing: 'easeinout', speed: 800 }
            },
            colors: ['#3b82f6', '#4f46e5', '#8b5cf6', '#f59e0b', '#10b981', '#ef4444'],
            plotOptions: {
                pie: {
                    donut: { 
                        size: '72%', 
                        labels: { 
                            show: true, 
                            name: { show: true, fontSize: '11px', fontWeight: 700, color: '#94a3b8' }, 
                            value: { show: true, fontSize: '24px', fontWeight: 900, color: '#0f172a' } 
                        } 
                    }
                }
            },
            dataLabels: { enabled: false },
            legend: { show: false },
            stroke: { show: true, colors: '#fff', width: 4 }
        };

        var statusChart = new ApexCharts(document.querySelector("#statusChart"), statusOptions);
        statusChart.render();
    });
</script>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
