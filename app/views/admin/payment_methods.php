<?php 
$title = "Kelola Metode Pembayaran";
ob_start();
?>

<!-- Premium Page Header -->
<div class="mb-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 group">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
            <i class="fas fa-credit-card text-indigo-500 bg-indigo-50/50 w-12 h-12 rounded-[14px] flex items-center justify-center"></i>
            Metode Pembayaran
        </h3>
        <p class="text-slate-500 text-[13px] font-medium mt-2 max-w-lg">Konfigurasi kanal penerimaan pembayaran pelanggan</p>
    </div>
    <a href="<?= BASEURL ?>/admin/createPaymentMethod" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-[14px] shadow-[0_4px_14px_0_rgba(79,70,229,0.39)] hover:shadow-[0_6px_20px_rgba(79,70,229,0.23)] hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2.5 text-[14px] font-extrabold whitespace-nowrap focus:outline-none focus:ring-4 focus:ring-indigo-500/20">
        <i class="fas fa-plus"></i> <span class="hidden sm:inline">Tambah Metode</span>
    </a>
</div>

<?php
$headers = [
    ['text' => 'No.', 'class' => 'w-16 whitespace-nowrap text-center'],
    ['text' => 'Metode', 'class' => ''],
    ['text' => 'Tipe', 'class' => ''],
    ['text' => 'Nomor Rekening', 'class' => ''],
    ['text' => 'Atas Nama', 'class' => ''],
    ['text' => 'Status', 'class' => ''],
    ['text' => 'Aksi', 'class' => 'text-right min-w-[140px]']
];
$is_empty = empty($methods);

ob_start();
if(!$is_empty): $sn=1; foreach($methods as $index => $pm): ?>
    <tr class="group">
        <td class="text-sm text-slate-400 font-bold text-center"><?= $sn++ ?>.</td>
        <td>
            <div class="flex items-center gap-3">
                <?php if(!empty($pm['icon'])): ?>
                    <img src="<?= BASEURL ?>/uploads/payment-methods/<?= htmlspecialchars($pm['icon']) ?>" alt="<?= htmlspecialchars($pm['name']) ?>" class="w-9 h-9 rounded-lg object-contain bg-slate-50 border border-slate-200/60 p-1">
                <?php else: ?>
                    <div class="w-9 h-9 rounded-lg bg-slate-100 border border-slate-200/60 flex items-center justify-center text-slate-400">
                        <i class="fas fa-<?= $pm['type'] === 'e_wallet' ? 'wallet' : 'building-columns' ?> text-[13px]"></i>
                    </div>
                <?php endif; ?>
                <span class="text-[15px] font-black text-slate-800 group-hover:text-indigo-600 transition-colors"><?= htmlspecialchars($pm['name']) ?></span>
            </div>
        </td>
        <td>
            <?php 
                $typeLabel = $pm['type'] === 'e_wallet' ? 'E-Wallet' : 'Bank Transfer';
                $typeColor = $pm['type'] === 'e_wallet' ? 'violet' : 'sky';
                $typeIcon = $pm['type'] === 'e_wallet' ? 'fas fa-wallet' : 'fas fa-building-columns';
            ?>
            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-black uppercase tracking-wide bg-<?= $typeColor ?>-50 text-<?= $typeColor ?>-600 border border-<?= $typeColor ?>-200/60">
                <i class="<?= $typeIcon ?> text-[10px]"></i> <?= $typeLabel ?>
            </span>
        </td>
        <td class="text-[13px] font-mono font-bold text-slate-600"><?= htmlspecialchars($pm['account_number']) ?></td>
        <td class="text-[13px] font-bold text-slate-600"><?= htmlspecialchars($pm['account_name']) ?></td>
        <td>
            <?php 
                $isActive = !empty($pm['is_active']);
                $text = $isActive ? 'Aktif' : 'Nonaktif';
                $color = $isActive ? 'green' : 'gray';
                $icon = $isActive ? 'fas fa-check-circle' : 'fas fa-box-archive';
                include __DIR__ . '/../components/admin/ui/badge.php';
            ?>
        </td>
        <td class="text-right">
            <div class="flex flex-col gap-2 w-full max-w-[140px] ml-auto">
                <?php
                    $type = 'a';
                    $href = BASEURL . '/admin/paymentMethodDetails/' . urlencode($pm['id']);
                    $color = 'indigo';
                    $icon = 'fas fa-search';
                    $btn_title = 'Detail';
                    $btn_label = 'Detail';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';

                    $href = BASEURL . '/admin/editPaymentMethod/' . urlencode($pm['id']);
                    $color = 'blue';
                    $icon = 'fas fa-edit';
                    $btn_title = 'Edit';
                    $btn_label = 'Edit';
                    $btn_width = 'w-full';
                    include __DIR__ . '/../components/admin/ui/action_button.php';
                ?>
                <form action="<?= BASEURL ?>/admin/togglePaymentMethod/<?= urlencode($pm['id']) ?>" method="POST" class="m-0 w-full">
                    <?= CSRF::getTokenField() ?>
                    <?php
                        $type = 'submit';
                        $color = !empty($pm['is_active']) ? 'amber' : 'emerald';
                        $icon = !empty($pm['is_active']) ? 'fas fa-toggle-off' : 'fas fa-toggle-on';
                        $btn_title = !empty($pm['is_active']) ? 'Nonaktifkan' : 'Aktifkan';
                        $btn_label = !empty($pm['is_active']) ? 'Nonaktifkan' : 'Aktifkan';
                        $btn_width = 'w-full';
                        include __DIR__ . '/../components/admin/ui/action_button.php';
                    ?>
                </form>
                <form action="<?= BASEURL ?>/admin/deletePaymentMethod/<?= urlencode($pm['id']) ?>" method="POST" class="delete-form m-0 w-full" data-name="Metode <?= htmlspecialchars($pm['name']) ?>">
                    <?= CSRF::getTokenField() ?>
                    <?php
                        $type = 'submit';
                        $color = 'red';
                        $icon = 'fas fa-trash-alt';
                        $btn_title = 'Hapus';
                        $btn_label = 'Hapus';
                        $btn_width = 'w-full';
                        include __DIR__ . '/../components/admin/ui/action_button.php';
                    ?>
                </form>
            </div>
        </td>
    </tr>
<?php endforeach; endif;

$tableSlot = ob_get_clean();

$slot = $tableSlot;
$empty_icon = 'fas fa-credit-card';
$empty_title = 'Belum Ada Metode Pembayaran';
$empty_message = 'Tidak ada metode pembayaran yang ditemukan dalam basis data.';
include __DIR__ . '/../components/admin/ui/data_table.php';
?>

<?php 
$slot = ob_get_clean();
include __DIR__ . '/../components/admin/layout.php';
?>
